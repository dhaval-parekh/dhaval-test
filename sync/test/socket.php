<?php
require_once('config.php');
//	define
$socket = false;
$host = HOST;
$port = PORT;
$flag_file = 'socketflag';
$null = NULL; //null var

$input = array();
if(php_sapi_name() == 'cli'){
	$input['key'] = 'app_secreat_key';
	$input['command'] = isset($argv[1])?$argv[1]:false;
}else{
	$input = $_GET;	
}

// Validation
if(! isset($input['key'],$input['command'])){ return array('error'=>400); }
if($input['key'] !== API_KEY){ return array('error'=>401); }
$command = strtolower(trim($input['command']));
$available_commands = array('start','stop');
if(! in_array($command,$available_commands)){ return array('error'=>400); }

//	code
switch($command){
	case 'start':
			//Create TCP/IP sream socket
			$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			//reuseable port
			socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
			
			//bind socket to specified host
			socket_bind($socket, 0, $port);
			
			//listen to port
			socket_listen($socket);
			$clients = array($socket);
			$count = 0;
			$file = fopen($flag_file,'w');
			fwrite($file,'');
			fclose($file);
			while(true){
				$count++;
				
				if(file_exists($flag_file) && file_get_contents($flag_file)){  die('Server Closed');  }
				$changed = $clients;
				
			
				socket_select($changed, $null, $null, 0, 10);
				
				if (in_array($socket, $changed)) {
					$socket_new = socket_accept($socket); // accpet new socket
					$clients[] = $socket_new; // add socket to client array
					$header = socket_read($socket_new, 2048); //read data sent by the socket
					
					if(is_array(json_decode($header,true))){
						print_r('server connection '.PHP_EOL);
						server_handle_recevied_message($header,$socket_new);
					}else{
						print_r('client connection '.PHP_EOL);
						// this is neccessery for web-socket  interface 
						perform_handshaking($header, $socket_new, $host, $port); //perform websocket handshake
						// handle the message that is Recived from client 
						//client_handle_recevied_message($header,$socket_new); // Do not handle the header portion of web socket request
					}
					//make room for new socket
					$found_socket = array_search($socket, $changed);

					unset($changed[$found_socket]);
				}
			
				
				foreach ($changed as $changed_socket){
					
					//check for any incomming data
					while(socket_recv($changed_socket, $buf, 2048, 0) >= 1){
						$received_text = unmask($buf); //unmask data
						//$message = json_decode($received_text,true); //json decode 
						$message = $received_text;
						client_handle_recevied_message($message,$changed_socket);
						break 2;
					}
					$buf = @socket_read($changed_socket, 2048, PHP_NORMAL_READ);
					if ($buf === false) { // check disconnected client
						$disconnected_socket = array_search($changed_socket, $clients);
						unset($clients[$disconnected_socket]);
					}
				}
				
			
				//	$clients 		// This containe all list of clientd that is conected to server
				// 	$changed		// This containe all CLOSED client that were connected to server // Disconnected list
				//sleep(5);
			}// Infinite While Over
			socket_close($socket);
			return array('socketStatus'=>'running');
		break;
	case 'stop':
			$file = fopen($flag_file,'w');
			fwrite($file,'1');
			sleep(2);
			fclose($file);
			return array('socketStatus'=>'stoped');
		break;	
}


//	Helper Function of Web socket
//	that sent message to all
function send_message($msg){
	global $clients;
	foreach($clients as $changed_socket){
		@socket_write($changed_socket,$msg,strlen($msg));
	}
	return true;
}


//Unmask incoming framed message
function unmask($text){
	$length = ord($text[1]) & 127;
	if($length == 126) {
		$masks = substr($text, 4, 4);
		$data = substr($text, 8);
	}elseif($length == 127){
		$masks = substr($text, 10, 4);
		$data = substr($text, 14);
	}else{
		$masks = substr($text, 2, 4);
		$data = substr($text, 6);
	}
	$text = "";
	for ($i = 0; $i < strlen($data); ++$i) {
		$text .= $data[$i] ^ $masks[$i%4];
	}
	return $text;
}

//Encode message for transfer to client.
// if you don't mask the message then Message wont sent to client
function mask($text)
{
	$b1 = 0x80 | (0x1 & 0x0f);
	$length = strlen($text);
	
	if($length <= 125)
		$header = pack('CC', $b1, $length);
	elseif($length > 125 && $length < 65536)
		$header = pack('CCn', $b1, 126, $length);
	elseif($length >= 65536)
		$header = pack('CCNN', $b1, 127, $length);
		
	return $header.$text;
}

//handshake new client.
// this is use to notify client (browser) that you are connected to server (By sending the Header )
function perform_handshaking($receved_header,$client_conn, $host, $port)
{
	$headers = array();
	$lines = preg_split("/\r\n/", $receved_header);
	foreach($lines as $line)
	{
		$line = chop($line);
		if(preg_match('/\A(\S+): (.*)\z/', $line, $matches))
		{
			$headers[$matches[1]] = $matches[2];
		}
	}

	if(isset($headers['Sec-WebSocket-Key'])){
		$secKey = $headers['Sec-WebSocket-Key'];
		$secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
		//hand shaking header
		$upgrade  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
		"Upgrade: websocket\r\n" .
		"Connection: Upgrade\r\n" .
		"WebSocket-Origin: $host\r\n" .
		"WebSocket-Location: ".SOCKET_URL."\r\n".
		"Sec-WebSocket-Accept:$secAccept\r\n\r\n";
		socket_write($client_conn,$upgrade,strlen($upgrade));
	}
}

/************************************************************************************/
// Action function 


function handle_recevied_message($message,$socket = false){
	
}


//	For handle client Message 
//		@message = client's message in text format
//		@socket = client's Connection instance 
function client_handle_recevied_message($message,$socket = false){
}

//	For handle server Message 
//		@message = server's message in text format
//		@socket = server's Connection instance 
function server_handle_recevied_message($message,$socket = false){

	$message = json_decode($message,true);
	$response = array();
	$response['status'] = 200;
	$response['message'] = 'ok';
	$response['payload'] = $message;
	
	
	$response = json_encode($response);
	socket_write($socket,$response,strlen($response));
}
