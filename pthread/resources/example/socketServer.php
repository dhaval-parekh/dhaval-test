<?php
define('HOST','127.0.0.1');

$port = 5353;
class serverSocket extends Thread{
	private $login;
	private $poll;
	
	private $host;
	private $port;
	private $socket; 
	
	public function __construct(){
		$this->login = 0;		
		$this->poll = 0;
		
		$this->host = HOST;
		$this->port = 5353;
		$this->socket = false;
	}	
	
	public function login(){
		$this->login = 1;	
	}
	public function logout(){
		$this->login = 0;	
	}
	
	public function poll(){
		
		if($this->login == 1){
			echo '===== '.__FUNCTION__.'('.$this->poll.') ===== '.time().PHP_EOL;
			$this->poll++;
			return true;
		}else{
			echo 'OUT'.PHP_EOL;
			return false;	
		}
		
	}
	
	public function handle_error($error = false){
		if($error){
			die($error);
		}
		die('Die Anyway');
	}
	
	public function socket(){
		echo '========== START =========='.time().PHP_EOL;
		$this->socket = socket_create(AF_INET, SOCK_STREAM, 0) or  $this->handle_error("Could not create socket\n");	
		$result = socket_bind($this->socket, $this->host, $this->port) or $this->handle_error("Could not bind to socket\n");
		$count = 0;
		while($count < 10){
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
						return true;
					break;
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
		}
		echo '========== END   =========='.time().PHP_EOL;
		socket_close($this->socket);
		$this->logout();
		
		return true;
	}
	
	public function run(){
		while($this->poll()){
			sleep(1);	
		}
	}
}

$server = new serverSocket();
$server->login();
	$flag = $server->start();
	echo 'socket';
	$server->socket();
	//$server->run();
		/*while($server->poll()){
			sleep(1);	
		}*/
	
$server->logout();
