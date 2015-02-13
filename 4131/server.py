import socket
import io,os
METHOD = 0
PATH = 1

server_socket = socket.socket(socket.AF_INET,socket.SOCK_STREAM)
server_socket.bind(("127.0.0.1",9000))
server_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
server_socket.listen(5)

def dispatcher(header,socket):
	header = header.decode("utf-8")
	headers = header.split("\n")
	request = headers[0].split(" ")
	if request[METHOD] == "GET":
		try:
			router[request[PATH]](socket)
		except:
			print("ERROR")
			error = "404 Niggie"
			
	if request[METHOD] == "HEAD":
		return

def serveIndex(req):
	file = open('HW1.html','rb')
	read=file.read(1024)
	while(read):	
		req.send(read)
		read = file.read(1024)

router = {"/":serveIndex}


while 1:
	(client_socket,address) = server_socket.accept()
	header = client_socket.recv(4096)
	dispatcher(header,client_socket)
	client_socket.close()
	
