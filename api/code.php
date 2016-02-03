<?php
set_time_limit(0);
ini_set('max_execution_time', 0); 

class WhatsappInstance extends Thread{

	private $phone;
	private $password;
	private $name;
	private $notifyUrl;
	private static $token;
	private $login;

	private $host;
	private $port;
	private $socket;
	private $debug;

	private static $whatsapp;
	private static $event;
	
	private $callback_url;
	public function __construct($phone,$password,$name,$url,$port,$token,$debug = false){
		$this->phone = $phone;
		$this->name = $name;
		$this->notifyUrl = $url;
		$this->password = $password;
		self::$token = $token;
		
		$this->debug = $debug;
		$this->host = HOST;
		$this->port = $port;
		$this->socket = false;
		$this->callback_url = BASE_URL."api/ping.php?token=".self::$token;
		$this->login = 0;

		self::$whatsapp = new WhatsProt($this->phone,$this->name,$this->debug);
		self::$event = new MyEvents(self::$whatsapp);
	}
	
	public function index(){
	}
	
	private function ping_start(){
		if(! isset($this->callback_url)){ return false; }
		
	}
	private function ping_stop(){
	}
	
	public function login(){
		
		try{
			self::$event->setEventsToListenFor(self::$event->activeEvents);
			
			self::$event->setNotifyUrl($this->notifyUrl);
			self::$whatsapp->connect();
			self::$whatsapp->loginWithPassword($this->password);
			$this->login = 1;
			
			self::$whatsapp->sendGetPrivacyBlockedList(); // Get our privacy list
			self::$whatsapp->sendGetClientConfig();
			self::$whatsapp->sendGetServerProperties();
			self::$whatsapp->sendGetGroups();
			self::$whatsapp->sendGetBroadcastLists();

		}catch(Exception $e){
			display($e);
			return false;
			
		}
		return true;
	}
	
	public function logout(){
		if($this->login == 1){
			$this->login = 0;
			$this->kill();
			self::$whatsapp->disconnect();
		}
		return true;
	}
	
	public function poll(){

		//echo 'Enter '.__FUNCTION__.'=========================== | '.$this->login.' | '.time().' <br>'.PHP_EOL;
		$ping = array( 'command'=>'ping' );
		$poll = array( 'command'=>'poll' );
		$request = array('token'=>self::$token);
		$request = http_build_query($input);
		$ping_url = API_URL.'ping/?token='.self::$token;
		$poll_url = API_URL.'poll/?token='.self::$token;
		if($this->login == 1){
			$before_time = 3;
			$minute_to_second = 60;
			$count = 0; 

			while($this->login == 1){ 
				$payload = $this->sendRequest($ping_url);
				$count++;
		
				$start_time = time();
				$end_time = $start_time + ($minute_to_second - $before_time);
			
				while(time() < $end_time){
					$payload = $this->sendRequest($poll_url);
					sleep(2);
				}
			}
			
		}
		//echo 'Out '.__FUNCTION__.'=========================== | '.$this->login.' | '.time().' <br>'.PHP_EOL;	
		return true;
	}
	
	protected function sendRequest($url){
		$response = file_get_contents($url);

		$response_array = json_decode($response,true);
		if($response_array['status'] != 200){
			die($response)	;
		}
		return $response;
	}

	
	public function run(){
		$this->poll();
	}
	
	public function startServices(){
		//echo 'Enter '.__FUNCTION__.'=========================== '.time().' <br>'.PHP_EOL;		

		$this->socket = socket_create(AF_INET, SOCK_STREAM, 0) or  $this->handle_error("Could not create socket");	
		$result = socket_bind($this->socket, $this->host, $this->port) or $this->handle_error("Could not bind to socket");

		$count = 0;	
		system_log('=================================================================');
		system_log('Start => '.$this->phone.' => '.date('Y-m-d H:i:s'));
		while(true){
			$input = false;
			$result = socket_listen($this->socket, 3) or $this->handle_error("Could not set up socket listener");
			$spawn = socket_accept($this->socket) or $this->handle_error("Could not accept incoming connection");
			$input = socket_read($spawn, 100000) or $this->handle_error("Could not read input");
			
			
			$response = array('status'=>201);
			if(! ($input && (!empty($input)) &&  is_array(json_decode($input,true))) ){
			}
			
			$input = json_decode($input,true);
			system_log($input);
			$count++;

			if(! (isset($input['command']) && (! empty($input['command']))) ){
				$input['command'] = false;
			}
			
			
			$valid_flag = false;
			$command = trim(strtolower($input['command']));
			$log = $this->name.' => '.$this->port.' => '.$count.' => '.$input['command'];
			
			system_log($log);
			//echo $command.PHP_EOL;
				switch($command){
					case 'login':	
							$payload = $this->login();
							$valid_flag = true;
						break;
					case 'logout':
							$payload = $this->logout();
							if($payload){
								$valid_flag = true;
							}
						break;
					case 'die':
							$payload = $this->logout();
							die('Die');
						break;
					case 'type':
							$payload = self::$whatsapp->sendMessageComposing($input['to']);
							$valid_flag = true;
						break;
					case 'pause':
							$payload = self::$whatsapp->sendMessagePaused($input['to']);
							$valid_flag = true;
						break;
					case 'send':
							$payload = $this->sendMessage($input['to'], $input['message'], $input['messagetype']);
							$valid_flag = true;
						break;
					case 'sync':
							
							$contacts = $input['contacts'];
							$contacts = array_unique($contacts);
							$payload = $this->sendSync($contacts);
							$valid_flag = true;
						break;
					case 'poll':
							while(self::$whatsapp->pollMessage());
							$payload = true;
							$valid_flag = true;	
						break;
					case 'ping':
					default:
							$payload = self::$whatsapp->sendPing();
							$valid_flag = true;	
						break;	
				}	

			if( $valid_flag){
				$response['status'] = 200;
				$response['message'] = 'ok';
				$response['payload'] = isset($payload)? $payload:true;
				system_log($response);
				//$response = isset($payload)?$payload:true;
				if(isset($payload)){
					if(! (is_array($payload) || is_object($payload) )){
						$payload = mysql_real_escape_string($payload);
					}
					$response = $payload;
				}else{
					$response = true;
				}

				$output = json_encode($response);
				
				socket_write($spawn, $output, strlen ($output)) or $this->handle_error("Could not write output"); 
				if($command == 'logout'){
					sleep(1);
					break;
				}
			}
			socket_close($spawn);
			$valid_flag = false;
		}// while close
		system_log('Stop => '.$this->phone.' => '.date('Y-m-d H:i:s'));
		system_log('=================================================================');
		
		socket_close($this->socket);
		//echo 'OUT '.__FUNCTION__.'=========================== '.time().' <br>'.PHP_EOL;
		return true;
		
	}
	
	public function sendSync($contacts = array()){
		self::$whatsapp->sendSync($contacts);
	}

	protected function sendMessage($to,$message,$message_type = 1){
		switch($message_type){
			case 2: 
					$response = self::$whatsapp->sendMessageImage($to,$message);
				break;
			case 3:	
					$response = self::$whatsapp->sendMessageAudio($to,$message);
				break;
			case 4: 
					$response = self::$whatsapp->sendMessageVideo($to,$message);
				break;
			case 1: 
			default:	
					$payload = self::$whatsapp->sendMessageComposing($to);
					$time = ceil(strlen($message)/25); 
					$time = 2;
					sleep($time);
					$payload = self::$whatsapp->sendMessagePaused($to);
					$response = self::$whatsapp->sendMessage($to,$message );

				break;
		}

		return $response;
	}

	protected function handle_error($error = false){
		if(! $error){
			$error = 'Undefined Error';
		}
		$this->logout();
		socket_close($this->socket);
			
		header('Content-type: application/json');
		$response = array('status'=>610,'message'=>$error);
		
		return $response;

	}	

	protected function getInstance(){
		return self::$whatsapp;
	}

}

