from random import randint
import socket
import io,os,sys
import threading

PORT = 1337
USER = 1
PASSWORD = 2
COMMAND = 0

class Tokens:
    def __init__(self):
        #Private but dunno how to.
        self.tokens = {}
    def createToken(self):
        token = randint(1000,9999)
        self.tokens[token] = token
        return str(token)
    def checkToken(self,token):
        if token in self.tokens:
            return True
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
                
        self.token = Tokens()
        self.socket = socket.socket(socket.AF_INET,socket.SOCK_STREAM)
        self.socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
        self.socket.bind(("127.0.0.1",PORT))
        self.socket.listen(10)
        self.tokens = Tokens()
        self.handles = {}
        self.handles["LOGIN"] = self.login
        
    def run(self):
        while True:
        	client_socket,address = self.socket.accept()
        	t = threading.Thread(target=self.route, args=(client_socket,))
        	t.run();
        	
    def route(self,client):
        header = client.recv(1024)
        header = header.decode('utf-8').split(" ")
        self.handles[header[COMMAND]](client,header)
        return
    
    def login(self,client,header):
        token = None
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
        

server = FtpServer()
server.run()