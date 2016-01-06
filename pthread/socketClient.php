<?php

define('HOST','127.0.0.1');
$host = HOST;

$port = 5353;

$message = array(	//'command'=>'login',
				//'command'=>'logout',
				
				//'command'=>'pause',
				'command'=>'send',
				'command'=>'logout',
				//'command'=>'type',
				//'command'=>'ping',
				//'phone'=>'919909208175',
				'to'=>'919909208175',
				//'to'=>'919228220275',				
				//'message' => 'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcQsccqmhOc3Bh8vWw-yAWtGuHkjr7NqVjueIaxrnbuTX_dgaQ5C',
				//'messagetype' => '2',
			);
			
$message = json_encode($message);

echo 'Request : '.$message.' <br>'.PHP_EOL;
// create socket
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");

// connect to server
$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  

// send string to server
socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");

// get server response
$result = socket_read($socket, 2048) or die("Could not read server response\n");
echo "Response : ".$result.' <br>'.PHP_EOL;
// close socket
socket_close($socket);
echo 'closed <br>\n'.PHP_EOL;