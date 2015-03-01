import socket
import io,os,sys
import threading

HOST = "127.0.0.1"
PORT = 1337
EVENT  = 0
CONTENTS = 1
COMMAND = 0

class Token:
    def createToken(self,data):
            msg = data.split(" ")
            if msg[EVENT] == "ACCEPTED":
                return int(msg[CONTENTS])
            else:
                print("Did not get a token")
                return -1
            
factory = Token()

class FtpClient:
    def __init__(self):
        self.socket = None
        self.token = ""
        self.quit = False
        self.handlers = {}
        self.handlers["ls"] = self.default
        self.handlers["download"] = self.download
        self.handlers["upload"] = self.upload
        self.handlers["quit"] = self.disconnect
        self.request = ""
        return
    def run(self):
        self.login()
        self.process()
        return
    def package(self):
        try:
            header = self.request.split(" ")
            return self.handlers[header[COMMAND]]()
        except:
            print("Command does not exist")
            return False
    def process(self):
        validCommand = False
        while not self.quit:
            #   Attempt to get a valid request
            while not validCommand:
                self.request = input("Command: " )
                validCommand = self.package()
            self.connect()
            self.send(self.request)
            content = self.recieveAll()
            print(content)
            validCommand = False
            self.close()
    def login(self):
        connected = False
        while not connected:
            self.connect()
            print("Please login")
            user = input('Enter your user: ')
            password = input('Enter your pass: ')
            
            #Should encrypt but... w/e
            self.send("login "+user + " " + password)
            
            #Recieve from server
            data = self.recieve(1024).decode("UTF-8")
            
            # See if you got a token
            token = factory.createToken(data)
            if token != -1:
                self.token = token
                connected = True
            self.socket.close()
            
    def connect(self):
        self.socket = socket.socket(socket.AF_INET,socket.SOCK_STREAM)
        try:
            self.socket.connect((HOST, PORT))
        except:
            print("Error connecting")
             
          
    def sign(self):
        self.request = self.request +  "\n" + str(self.token)
    def default(self):
        self.sign()
        return True
    def upload(self):
        self.sign()
        return True
    def download(self):
        self.sign()
        return True
    def disconnect(self):
        self.quit = True
        self.sign()
        return True
    def close(self):
        self.socket.close()
        self.request = ""
    def send(self,msg):
        self.socket.send(bytes(msg, 'UTF-8'))
    def recieve(self,size):
        return self.socket.recv(size)
    def recieveAll(self):
        data = ""
        while(True):
            buf = self.socket.recv(1024)
            if not buf:
                break
            data += buf.decode('utf-8')
        return data
    
client = FtpClient()
client.run()
