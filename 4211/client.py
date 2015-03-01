import socket
import io,os,sys
import threading

HOST = "127.0.0.1"
PORT = 1337
EVENT  = 0
CONTENTS = 1


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
        return
    def run(self):
        self.login()
        self.process()
        return
    def process(self):
        while True:
            #   Recieve a request
            request = input("Command: " )
            self.sign(request)
            self.connect()
            self.send(request)
            self.
            #Process response
            
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
