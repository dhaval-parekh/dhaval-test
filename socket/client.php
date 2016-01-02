<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Soclet Client</title>
</head>
<body>
	<?php
		//$host    = "127.0.0.1";
		$host = "localhost";
		$port    = 5352;
		$message = array('Name'=>'Dhaval Parekh','Roll No'=>150);
		$message = json_encode($message);
		//$message = '1';
		echo "Message To server :".$message."<br>";
		// create socket
		$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
		// connect to server
		$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
		// send string to server
		
		socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
		// get server response
		$result = socket_read ($socket, 1024) or die("Could not read server response\n");
		echo "<br>Reply From Server  :".$result;
		// close socket
		var_dump(AF_INET,SOCK_STREAM);
		socket_close($socket);
	?>
</body>
</html>