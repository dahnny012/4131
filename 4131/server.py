import socket

METHOD = 0
PATH = 1

server_socket = socket.socket(socket.AF_INET,socket.SOCK_STREAM)
server_socket.bind(("127.0.0.1",9001))
server_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
server_socket.listen(5)




while 1:
	(client_socket,address) = server_socket.accept()
	header = client_socket.recv(4096)
	while header:
		client_socket.sendall(header)
		client_socket.send(bytes(header, 'UTF-8'))
	client_socket.close()


def dispatcher(header,socket):
	headers = header.split("\n")
	request = headers.split(" ")
	if request[REQUEST] == "GET":
		try:
			router[request[PATH]](socket)
		except:
			error = "404 Niggie"
			
	if request[REQUEST] == "HEAD":
		return

def serveIndex(req):
	return

router = {"/":serveIndex}
