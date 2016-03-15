<?php
//	http://localhost/work/movir/socket.php
function send_message_to_server($message){
	$host = "localhost";
	$port    = 9000;
	$message = json_encode($message);
	$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
	$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
	socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
	$result = socket_read ($socket, 2048) or die("Could not read server response\n");
	socket_close($socket);
	return json_decode($result,true);
}



$message = array('Name'=>'Dhaval Parekh','Roll No'=>150);
print_r(send_message_to_server($message));

