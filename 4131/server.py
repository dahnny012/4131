import socket
import io,os,sys
import threading
import stat
METHOD = 0
PATH = 1
PORT = 9001

for i in range(0,len(sys.argv)):
	if i==1:
		PORT = int(sys.argv[i])

server_socket = socket.socket(socket.AF_INET,socket.SOCK_STREAM)
server_socket.bind(("127.0.0.1",PORT))
server_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
server_socket.listen(5)

#Server to route Dispatcher
def dispatcher(header,socket):
	header = header.decode("utf-8")
	headers = header.split("\n")
	request = headers[0].split(" ")
	if request[METHOD] == "GET":
		try:
			print(request)
			router[request[PATH]](socket,request[PATH])
		except:
			router["/404.html"](socket,"/404.html",False,"404 Error")
	if request[METHOD] == "HEAD":
		try:
			router[request[PATH]](socket,request[PATH],True)
		except:
			router["/404.html"](socket,"/404.html",True,"404 Error")

def getFileType(fn):
	if ".css" in fn:
		return "text/css"
	if ".html" in fn:
		return "text/html"
	return "text/plain"
	
#Route Handlers
def serveIndex(req,fn,head=False):
	file = open('restaurants.html','rb')
	if not head:
		read=file.read(1024)
		while(read):	
			req.send(read)
			read = file.read(1024)
	else:
		head = "HTTP/1.1 "+code+" \r\n\r\n"
		req.send(bytes(head,'utf-8'))
		
def serveFile(req,fn,head=False,code="200 OK"):
	fn = fn[1:]
	fileType = getFileType(fn)
	if not head:
		file = open(fn,'rb')
		read = file.read(1024)
		while(read):
			req.send(read)
			read = file.read(1024)
	else:
		head = "HTTP/1.1 "+code+" \r\n\r\n"
		req.send(bytes(head,'utf-8'))
			
def checkPermission(filepath):
  st = os.stat(filepath)
  return bool(st.st_mode & stat.S_IRGRP)

router = {"/":serveIndex,
"/restaurants.html":serveFile,
"/private.html":serveFile,
"/404.html":serveFile,
}


def accept(server_socket):
	(client_socket,address) = server_socket.accept()
	header = client_socket.recv(4096)
	dispatcher(header,client_socket)
	client_socket.close()
	
#Accept clients
#for id in range(0,1):
#			t = threading.Thread(target=accept, args=(server_socket,))
#			t.start()
while True:
	accept(server_socket)
