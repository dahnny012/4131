from random import randint
import socket
import io,os,sys
import threading

PORT = 1337
USER = 1
PASSWORD = 2
COMMAND = 0
TOKEN = 1
HEADER =  0
CONTENTS = 1

class Tokens:
    def __init__(self):
        #Private but dunno how to.
        self.tokens = {}
    def createToken(self):
        token = randint(1000,9999)
        self.tokens[token] = token
        return str(token)
    def checkToken(self,token):
        try:
            if int(token) in self.tokens:
                return True
        except:
            print("not a number")
        return False
    def killToken(self,token):
        self.tokens[token] = None


class FtpServer:
    def __init__(self):
        self.users = {}
        with open("records.txt","r") as file:
            for line in file:
                line = line.split(" ")
                self.users[line[0]]=line[1].split("\n")[0]
        self.socket = socket.socket(socket.AF_INET,socket.SOCK_STREAM)
        self.socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
        self.socket.bind(("127.0.0.1",PORT))
        self.socket.listen(10)
        self.tokens = Tokens()
        self.handles = {}
        self.handles["login"] = self.login
        self.handles["ls"] = self.ls
        self.handles["upload"] = self.upload
        self.handles["download"] = self.download
        
    def run(self):
        while True:
        	client_socket,address = self.socket.accept()
        	t = threading.Thread(target=self.route, args=(client_socket,))
        	t.run();
        	
    def route(self,client):
        header = client.recv(1024).decode('utf-8')
        args = header.split("\n")[0].split(" ")
        self.handles[args[COMMAND]](client,header)
        return
    
    def login(self,client,header):
        token = None
        header = header.split(" ")
        token = self.checkUserPass(header[USER],header[PASSWORD])
        #print("No login credentials")
        if token == None:
                print("Rejected a user")
                client.send(bytes("INVALID",'utf-8'))
                client.close()
                return
        print("Accepted a user")
        client.send(bytes("ACCEPTED " + str(token),'utf-8'))
        client.close()
        return
    def ls(self,client,header):
        if self.authToken(header):
            print("command accepted")
            files="file1.txt\nfile2.txt"
            client.send(bytes(files,'utf-8'))
        else:
            print("token rejected")
            client.send(bytes("ERROR No AuthToken",'utf-8'))
        client.close()
        
    def upload(self,client,header):
        if self.authToken(header):
            print("command accepted")
            args = header.split(" ")
            with open(args[CONTENTS] , "wb") as file:
                while True:
                    buf = client.read(1024)
                    if not buf:
                        break
                    file.write(buf)
        else:
            print("token rejected")
            client.send(bytes("ERROR No AuthToken",'utf-8'))
        client.close()
    def download(self,client,header):
        if self.authToken(header):
            print("command accepted")
            args = header.split(" ")
            try:
                with open(args[CONTENTS] , "rb") as file:
                    client.send(bytes("OK","utf-8"))
                    while True:
                        buf = file.read(1024)
                        if not buf:
                            break
                        client.send(buf)
            except:
                client.send(bytes("ERROR","utf-8"))
        else:
            print("token rejected")
            client.send(bytes("ERROR No AuthToken",'utf-8'))
        client.close()

    def checkUserPass(self,user,password):
        print(user)
        print(password)
        if user in self.users:
            if self.users[user] in password:
                return self.tokens.createToken()
            else:
                print("Password did not match")
        else:
            print("user not in records")
        return None
        
    def authToken(self,request):
        args = request.split("\n")
        token = args[TOKEN]
        return self.tokens.checkToken(token)

server = FtpServer()
server.run()