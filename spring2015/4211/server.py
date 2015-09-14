from random import randint
import socket
import io,os,sys
from os import walk
import threading
import traceback

HOST = socket.gethostname()
PORT = 8080
USER = 1
PASSWORD = 2
COMMAND = 0
TOKEN = 1
HEADER =  0
CONTENTS = 1
EXCESS = 3
QUIT = False
ALIVE = True

host = input('Enter a host, blank for current host: ')
port = input('Enter a port, blank for 8080: ')

if host:
	HOST = host
if port:
	error = True
	while error:
		try:
			port = int(port)
			error = False
		except:
			port = input('Enter a port, blank for 8080: ')
	PORT = port
	
class Console:
	def __init__(self):
		self.handles = {}
		self.handles["ls"] = self.list
		self.handles["quit"] = self.quit
		self.status = ALIVE
	def run(self):
		while self.status:
			try:
				command = input('Enter a command ')
				self.handles[command]()
			except:
				print("Please enter a valid command")
		os._exit(1)
	def list(self):
		f = []
		for (dirpath, dirnames, filenames) in walk(os.getcwd()):
				f.extend(filenames)
				break
		print("\n".join(f))
		return 1
	def quit(self):
		self.status = QUIT
		
	
	

class Tokens:
	def __init__(self):
		#Private but dunno how to.
		self.tokens = {}
	def createToken(self):
		token = randint(1000,9999)
		while token in self.tokens:
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
		self.socket.bind((socket.gethostname(),PORT))
		self.socket.listen(10)
		print("Starting server " + HOST + " at Port: " + str(PORT))
		self.tokens = Tokens()
		self.handles = {}
		self.handles["login"] = self.login
		self.handles["ls"] = self.ls
		self.handles["upload"] = self.upload
		self.handles["download"] = self.download
		
	def run(self):
		console = Console()
		console_thread = threading.Thread(target=console.run, args=())
		console_thread.start();
		while True:
			client_socket,address = self.socket.accept()
			t = threading.Thread(target=self.route, args=(client_socket,))
			t.daemon = True
			t.start();
			
	def route(self,client):
		try:
			header = client.recv(64)
			header = header.decode("utf-8")
			args = header.split("\n")[0].split(" ")
			print("Routing to " + args[COMMAND])
			self.handles[args[COMMAND]](client,header)
		except:
			traceback.print_exc()
		return
	
	def login(self,client,header):
		token = None
		header = header.split(" ")
		token = self.checkUserPass(header[USER],header[PASSWORD])
		#print("No login credentials")
		if token == None:
				print("Rejected a user")
				client.send(bytes("INVALID",'ASCII'))
				client.close()
				return
		print("Accepted a user")
		client.send(bytes("ACCEPTED " + str(token),'ASCII'))
		client.close()
		return
	def ls(self,client,header):
		if self.authToken(header):
			print("command accepted")
			f = []
			for (dirpath, dirnames, filenames) in walk(os.getcwd()):
				f.extend(filenames)
				break
			client.send(bytes("\n".join(f),'ASCII'))
		else:
			print("token rejected")
			client.send(bytes("ERROR No AuthToken",'ASCII'))
		client.close()
		
	def upload(self,client,msg):
		if self.authToken(msg):
			print("command accepted")
			print(msg)
			headerEnd = msg.find("\r")
			header = msg[0:headerEnd]
			fn = header.split("\n")[0].split(" ")[CONTENTS]
			excess = bytes(msg[headerEnd+1:],'ASCII')
			print(excess)
			#should be not but well ignore for now.
			if not os.path.isfile(fn):
				with open(fn , "wb") as file:
					file.write(excess)
					while True:
						buf = client.recv(1024)
						if not buf:
							break
						file.write(buf)
			else:
				print("File already exists")
				client.send(bytes("ERROR File Exists",'ASCII'))
		else:
			print("token rejected")
			client.send(bytes("ERROR No AuthToken",'ASCII'))
		client.close()
	def download(self,client,header):
		if self.authToken(header):
			print("command accepted")
			args = header.split("\n")[0].split(" ")
			try:
				with open(args[CONTENTS] , "rb") as file:
					client.send(bytes("OK","ASCII"))
					while True:
						buf = file.read(1024)
						if not buf:
							break
						client.send(buf)
			except:
				client.send(bytes("ERROR","ASCII"))
		else:
			print("token rejected")
			client.send(bytes("ERROR No AuthToken",'ASCII'))
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
