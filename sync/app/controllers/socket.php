<?php
class Socket extends Controller{
	private $socket;
	private $host;
	private $port;
	private $client;
	public function __construct(){
		parent::__construct();
		$this->socket = false;
		$this->client = false;
		$this->host = HOST;
		$this->port = PORT;
		
		$this->flag_file = BASE_PATH.DS.'tmp'.DS.'socketflag';
	}
	
	// server Socket ( for web socket )
	public function socketServer($input){
		//system_log($_SERVER);
		if($input['key'] !== API_KEY){ return array('error'=>401); }
		$command = strtolower(trim($input['command']));
		$available_commands = array('start','stop');
		if(! in_array($command,$available_commands)){ return array('error'=>400); }
		$null = NULL; //null var
		switch($command){
			case 'start':
					//Create TCP/IP sream socket
					$this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
					//reuseable port
					socket_set_option($this->socket, SOL_SOCKET, SO_REUSEADDR, 1);
					
					//bind socket to specified host
					socket_bind($this->socket, 0, $this->port);
					
					//listen to port
					socket_listen($this->socket);
					$this->client = array($this->socket);
					$count = 0;
					$file = fopen($this->flag_file,'w');
					fwrite($file,'');
					fclose($file);
					while(true){
						$count++;
						sleep(1);
						if(file_exists($this->flag_file) && file_get_contents($this->flag_file)){ system_log('socket close'); die('Server Closed');  }
						$changed = $this->client;
						socket_select($changed, $null, $null, 0, 10);
						if (in_array($this->socket, $changed)) {
							
						}
						
					}// Infinite While Over
					socket_close($this->socket);
					return array('socketStatus'=>'running');
				break;
			case 'stop':
					$file = fopen($this->flag_file,'w');
					fwrite($file,'1');
					sleep(2);
					fwrite($file,'');
					fclose($file);
					return array('socketStatus'=>'stoped');
				break;	
		}
	}
	
}