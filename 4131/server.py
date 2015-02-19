import socket
import io,os,sys
import threading
METHOD = 0
PATH = 1
PORT = 9001

for i in range(0,len(sys.argv)):
    if i==1:
		port = sys.argv[i]

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
			socket["/404.html"](socket,request,False,"404 Error")
	if request[METHOD] == "HEAD":
		try:
			router[request[PATH]](socket,request[PATH],True)
		except:
			socket["/404.html"](socket,request,True,"404 Error")

def getFileType(fn):
	if ".css" in fn:
		return "text/css"
	if ".html" in fn:
		return "text/html"
	return "text/plain"
	
#Route Handlers
def serveIndex(req,fn,head=False):
	req.send(bytes('HTTP/1.0 200 OK\r\n','utf-8'))
	req.send(bytes("Content-Type: text/html\r\n\r\n",'utf-8'))
	file = open('restaurants.html','rb')
	if not head:
		read=file.read(1024)
		while(read):	
			req.send(read)
			read = file.read(1024)
		
def serveFile(req,fn,head=False,code="200 OK"):
	fn = fn[1:]
	fileType = getFileType(fn)
	if not checkPermission(fn):
			fn = "403.html"
			code = "403 FORBIDDEN"
	req.send(bytes('HTTP/1.0 '+code+'\r\n','utf-8'))
	req.send(bytes("Content-Type:"+fileType+"\r\n\r\n",'utf-8'))
	if not head:
		file = open(fn,'rb')
		read = file.read(1024)
		while(read):
			req.send(read)
			read = file.read(1024)
			
def checkPermission(filepath):
  st = os.stat(filepath)
  return bool(st.st_mode & st.S_IRGRP)

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
for id in range(0,5):
			t = threading.Thread(target=accept, args=(server_socket,))
			t.start()
	
	

