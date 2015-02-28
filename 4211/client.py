import socket
import io,os,sys
import threading

HOST = "127.0.0.1"
PORT = "9000"
EVENT  = 0
CONTENTS = 1


class Token:
    def createToken(self,data):
        try:
            msg = data.split(" ")
            if msg[EVENT] == "ACCEPTED":
                return int(msg[CONTENTS])
            else:
                return -1
        except:
            return -1
            
factory = Token()

class FtpClient:
    def __init__(self):
        self.socket = socket.socket(socket.AF_INET,socket.SOCK_STREAM)
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
            self.connect()
            self.send(request)
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
            self.send(user + " " + password)
            
            #Recieve from server
            data = self.recieve(1024)
            
            # See if you got a token
            token = factory.createToken(data)
            if token != -1:
                self.token = token
                connected = True
            self.socket.close()
            
    def connect(self):
        self.socket.connect((HOST, PORT))
    def send(self,msg):
        self.socket.sendall(msg)
    def recieve(self,size):
        return self.socket.recv(size)
    
client = FtpClient()
client.run()
