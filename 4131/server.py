import socket
import io,os
METHOD = 0
PATH = 1

server_socket = socket.socket(socket.AF_INET,socket.SOCK_STREAM)
server_socket.bind(("127.0.0.1",9002))
server_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
server_socket.listen(5)

def dispatcher(header,socket):
	header = header.decode("utf-8")
	headers = header.split("\n")
	request = headers[0].split(" ")
	if request[METHOD] == "GET":
		try:
			router[request[PATH]](socket,request[PATH])
		except:
			socket.send(bytes('HTTP/1.0 404 Error\r\n','utf-8'))
			socket.send(bytes("Content-Type: text/plain\r\n\r\n",'utf-8'))
			socket.send(bytes("Page not found",'utf-8'))
	if request[METHOD] == "HEAD":
		return

def getFileType(fn):
	if ".css" in fn:
		return "text/css"
	if ".html" in fn:
		return "text/html"
		
	return "text/plain"
	
	
def serveIndex(req,fn):
	req.send(bytes('HTTP/1.0 200 OK\r\n','utf-8'))
	req.send(bytes("Content-Type: text/html\r\n\r\n",'utf-8'))
	file = open('Index.html','rb')
	read=file.read(1024)
	while(read):	
		req.send(read)
		read = file.read(1024)
		

def serveFile(req,fn):
	fileType = getFileType(fn)
	req.send(bytes('HTTP/1.0 200 OK\r\n','utf-8'))
	req.send(bytes("Content-Type:"+fileType+"\r\n\r\n",'utf-8'))
	file = open(fn[1:],'rb')
	read = file.read(1024)
	while(read):
		req.send(read)
		read = file.read(1024)


router = {"/":serveIndex,
"/Index.html":serveFile,
"/Style.css":serveFile,
"/Form.html":serveFile}



while 1:
	(client_socket,address) = server_socket.accept()
	header = client_socket.recv(4096)
	dispatcher(header,client_socket)
	client_socket.close()
	
