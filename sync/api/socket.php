<?php
require_once('../config/config.php');

//	define
$socket = false;
$client = false;
$host = HOST;
$port = PORT;
$flag_file = BASE_PATH.DS.'tmp'.DS.'socketflag';
$null = NULL; //null var

$input = array();
if(php_sapi_name() == 'cli'){
	$input['key'] = 'app_secreat_key';
	$input['command'] = isset($argv[1])?$argv[1]:false;
}else{
	$input = $_GET;
	/*$input['key'] = 'app_secreat_key';
	$input['command'] = $argv[1];*/
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
				sleep(3);
				if(file_exists($flag_file) && file_get_contents($flag_file)){  die('Server Closed');  }
				$changed = $clients;
				//display($socket);
				display($changed);
				
				socket_select($changed, $null, $null, 0, 10);
				if (in_array($socket, $changed)) {
					$socket_new = socket_accept($socket); // accpet new socket
					$clients[] = $socket_new; // add socket to client array
					
					$header = socket_read($socket_new, 2048); //read data sent by the socket
					perform_handshaking($header, $socket_new, $host, $port); //perform websocket handshake
					
					socket_getpeername($socket_new, $ip); //get ip address of connected socket
					$response = array('type'=>'system', 'message'=>$ip.' connected');
					$response = mask(json_encode($response)); //prepare json data
					send_message($response); //notify all users about new connection
				}
				
				/*foreach ($changed as $changed_socket){
						while(socket_recv($changed_socket, $buf, 2048, 0) >= 1){
							
						}
				}*/

				

				
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

//	Helper Function
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
// this is use to notify client (brower) that you are connected to server (By sending the Header )
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

	$secKey = $headers['Sec-WebSocket-Key'];
	$secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
	//hand shaking header
	$upgrade  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
	"Upgrade: websocket\r\n" .
	"Connection: Upgrade\r\n" .
	"WebSocket-Origin: $host\r\n" .
	"WebSocket-Location: ws://$host:$port/demo/shout.php\r\n".
	"Sec-WebSocket-Accept:$secAccept\r\n\r\n";
	socket_write($client_conn,$upgrade,strlen($upgrade));
}