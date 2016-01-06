<?php
define('HOST','127.0.0.1');

$port = 5353;
class serverSocket extends Thread{
	private $login;
	private static $poll;
	
	private $host;
	private $port;
	private $socket; 
	
	public function __construct(){
		$this->login = 0;		
		self::$poll = 0;
		
		$this->host = HOST;
		$this->port = 5353;
		$this->socket = false;
	}	
	
	public function login(){
		$this->login = 1;	
		$this->start();
	}
	public function logout(){
		$this->login = 0;	
		$this->kill();
		
	}
	
	public function handle_error($error = false){
		if($error){
			die($error);
		}
		die('Die Anyway');
	}
	
	public function poll(){
		while($this->login == 1){
			self::$poll++;
			//echo '========== '.__FUNCTION__.' ========== '.self::$poll.' '.time().' <br>'.PHP_EOL;
			$message = array(	
					'command'=>'login',
					'command'=>'logout',
					'command'=>'ping',
					'to'=>'919909208175',
				);
			
				$message = json_encode($message);
				
				//echo 'Request : '.$message.' <br>'.PHP_EOL;
			
				$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
				
				// connect to server
				$result = socket_connect($socket, $this->host, $this->port) or die("Could not connect to server\n");  
				
				// send string to server
				socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
				
				// get server response
				$result = socket_read($socket, 2048) or die("Could not read server response\n");
				//echo "Response : ".$result.' <br>'.PHP_EOL;
				socket_close($socket);
				
			sleep(2);
		}
	}
	
	public function run(){
		$this->poll();
	}
	public function socket(){
		echo __FUNCTION__.'========== START =========='.time().PHP_EOL;
		$this->socket = socket_create(AF_INET, SOCK_STREAM, 0) or  $this->handle_error("Could not create socket\n");	
		$result = socket_bind($this->socket, $this->host, $this->port) or $this->handle_error("Could not bind to socket\n");
		$count = 0;
		while($count < 20){
			$count++;
			$result = socket_listen($this->socket, 3) or $this->handle_error("Could not set up socket listener\n");
			$spawn = socket_accept($this->socket) or $this->handle_error("Could not accept incoming connection\n");
			//socket_set_timeout($spawn, 0 , 100); // 
			$input = socket_read($spawn, 100000) or $this->handle_error("Could not read input\n");
			
			$input = json_decode($input,true);
			if(! (isset($input['command']) && (! empty($input['command']))) ){
				$input['command'] = false;
			}
			$command = trim(strtolower($input['command']));
			switch($command){
				case 'logout':
						echo $command.PHP_EOL;
						$this->logout();
						
					break ;
				default:
					echo $command.PHP_EOL;
					break;
			}
			$response = array();
			$response['status'] = 200;
			$response['message'] = 'ok';
			$response['payload'] = $input;
			$output = json_encode($response);
			socket_write($spawn, $output, strlen ($output)) or $this->handle_error("Could not write output\n"); 
			socket_close($spawn);	
			
			if($command == 'logout'){ break; }
		}
		echo __FUNCTION__.'========== END   =========='.time().PHP_EOL;
		socket_close($this->socket);
		$this->logout();
		
		return true;
	}
	
	
}

$server = new serverSocket();
	$server->login();
	//$flag = $server->start();
	$server->socket();
	//$server->kill();
	
$server->logout();
