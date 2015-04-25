import socket
import io,os,sys
import threading
import traceback

HOST = "127.0.0.1"
PORT = 8080
EVENT  = 0
CONTENTS = 1
COMMAND = 0


host = input('Enter a host, blank for localhost: ')
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
		self.handlers["ls"] = self.ls
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
			status = True
			if(len(header) <= 2):
				return self.handlers[header[COMMAND]](header)
			for arg in range(CONTENTS,len(header)):
				self.request = header[COMMAND] + " " + header[arg]
				data = [header[COMMAND],header[arg]]
				status = self.handlers[header[COMMAND]](data) & status
			return status
		except:
			print("Command does not exist")
			return False
	def process(self):
		while not self.quit:
			validCommand = False
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
			data = self.recieve(1024).decode("ASCII")
			
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
			sys.exit()
			 
		  
	def sign(self):
		self.request = self.request +  "\n" + str(self.token) + "\n" + "\r"
		# Default just sends command and prints output
	def ls(self,header):
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
		self.send(self.request)
		try:
			with open(header[CONTENTS],"rb") as file:
				while True:
					buf = file.read(1024)
					if not buf:
						break
					self.sendB(buf)
			self.close()
			self.request = "ls"
			self.ls(None)
			print("Upload complete")
			return True
		except:
			print("Could not upload your file")
			return False
	def download(self,header):
		self.sign()
		try:
			self.connect()
			self.send(self.request)
			self.recFile(header[CONTENTS])
			self.close()
			print("Download complete")
			return True
		except Exception:
			print("Could not download the file")
			traceback.print_exc()
			return False
	def disconnect(self,header):
		self.quit = True
		self.sign()
		return True
	
	def recFile(self,fn):
		if not self.fileError():
			print("Server could not process your request, file may not exist")
			return False
		with open(fn,"wb") as file:
			while(True):
				buf = self.recieve(1024)
				if not buf:
					break
				file.write(buf)
	def fileError(self):
		buf = self.recieve(2).decode("ASCII")
		return buf == "OK"
		
	def close(self):
		self.socket.close()
		self.request = ""
	def send(self,msg):
		self.socket.send(bytes(msg, 'ASCII'))
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
			data += buf.decode('ASCII')
		return data
	
client = FtpClient()
client.run()
