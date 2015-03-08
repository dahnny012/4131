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
    def handle(self):
        try:
            header = self.request.split(" ")
            return self.handlers[header[COMMAND]](header)
        except:
            print("Command does not exist")
            return False
    def process(self):
        validCommand = False
        while not self.quit:
            #   Attempt to get a valid request
            while not validCommand:
                self.request = input("Command: " )
                validCommand = self.handle()
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
        self.request = self.request +  "\n" + str(self.token) + "\n"
        # Default just sends command and prints output
    def default(self,header):
        self.sign()
        self.connect()
        self.send(self.request)
        content = self.recieveAll()
        print(content)
        self.close()
        return True
    def upload(self,header):
        self.sign()
        self.connect()
        try:
            self.send(self.request)
            with open(header[CONTENTS],"rb") as file:
                read = file.read(1024)
                while(read):
                    self.sendB(read)
                    read = file.read(1024)
            content = self.recieveAll()
            print(content)
            self.close()
            return True
        except:
            return False
    def download(self,header):
        self.sign()
        try:
            self.send(self.request)
            self.recFile(header[CONTENTS])
            self.close()
            return True
        except:
            return False
    def disconnect(self,header):
        self.quit = True
        self.sign()
        return True
    
    def recFile(self,fn):
        if(self.fileError):
            print("Server had error")
            return False
        with open(fn,"wb") as file:
            while(True):
                buf = self.recieve(1024)
                if not buf:
                    break
                file.write(buf)
    def recResponse(self):
        content = self.recieveAll()
        print(content)
        self.close()
    def fileError(self):
        buf = self.recieve(1024).decode("UTF-8")
        buf = buf.split(" ")
        return buf[EVENT] == "ERROR"
        
    def close(self):
        self.socket.close()
        self.request = ""
    def send(self,msg):
        self.socket.send(bytes(msg, 'UTF-8'))
    def sendB(self,msg):
        self.socket.send(msg)
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
