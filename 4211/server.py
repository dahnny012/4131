import socket
import io,os,sys
import threading

PORT = 9000

class Tokens:
    def __init__(self):
        #Private but dunno how to.
        self.tokens = {}
    def createToken(self):
        token = 1
        self.tokens[token] = token
        return token
    def checkToken(self,token):
        if token in self.tokens:
            return True
        return False
    def killToken(self,token):
        self.tokens[token] = None
        
class FtpServer:
    def __init__(self):
        with open("records.txt","r") as file:
            self.records = file.readlines()
        self.socket = socket.socket(socket.AF_INET,socket.SOCK_STREAM)
        self.socket.bind(("127.0.0.1",PORT))
        self.socket.listen(10)
        self.tokens = Tokens()
    def run(self):
        while True:
        	(client_socket,address) = self.socket.accept()
        	t = threading.Thread(target=self.process(), args=(client_socket,))
        	t.run();
        	
    def process(self,client):
        header = client.recv(1024)
        print(header)
        return
