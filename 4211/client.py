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
        return
    def run(self):
        self.login()
        self.process()
        return
    def package(self,request):
        request = request.split(" ")
        try:
            return self.handlers[request[COMMAND]](request)
        except:
            print("Command does not exist")
            return False
    def process(self):
        validCommand = False
        while not self.quit:
            #   Attempt to get a valid request
            while not validCommand:
                request = input("Command: " )
                validCommand = self.package(request)
            self.connect()
            self.send(request)
            content = self.recieveAll()
            self.close()
            return
    def login(self):
        connected = False
        while not connected:
            self.connect()
            print("Please login")
            user = input('Enter your user: ')
            password = input('Enter your pass: ')
            
            #Should encrypt but... w/e
            self.send("LOGIN "+user + " " + password)
            
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
             
          
    def sign(self,request):
        request += " " + self.token
    def default(self,request):
        self.sign(request)
        return True
    def upload(self,request):
        self.sign(request)
        return True
    def download(self,request):
        self.sign(request)
        return True
    def disconnect(self,request):
        self.quit = True
        self.sign(request)
        return True
    def close(self):
        self.socket.close()
        self.token = ""
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
            data += buf
        return data
    
client = FtpClient()
client.run()
