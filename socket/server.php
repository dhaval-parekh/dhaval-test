<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Socket : server</title>
</head>
<body>

	<?php
	function system_log($text){
		$file_name = 'system_log.txt';
		$file = fopen($file_name, "a");
		$cur_Date = date('Y-m-d H:i:s');
		$text = $cur_Date.' => Log = "'.$text.'"; '.PHP_EOL;
		fwrite($file, $text);
	}	
		
		//$host = "localhost";
		$host = "127.0.0.1";
		$port = 5352;
		// create Socket
		$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
		
		// Bind Socket
		$result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");
		$result = socket_listen($socket, 3) or die("Could not set up socket listener\n");
		$spawn = socket_accept($socket) or die("Could not accept incoming connection\n");
		
		
		//while(true){
			
			
			// Read Input form Client message
			$input = socket_read($spawn, 2048) or die("Could not read input\n");
			
			if($input == "1"){
				$input = "Socket Closed";	
				system_log($input);	
				socket_close($spawn);
				socket_close($socket);
				return true;
			}
			$output = strrev($input) . "\n";
			// Send Message to client
			socket_write($spawn, $output, strlen ($output)) or die("Could not write output\n"); 
			
			
			system_log($input);
		//}
		var_dump($socket);
		var_dump($result);
		var_dump($spawn);
		
		socket_close($spawn);
		socket_close($socket);
	?>
</body>
</html>
