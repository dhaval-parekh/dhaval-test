<?php

class Example1 extends Thread{
	private static $poll_counter;
	public function __construct(){
		//parent::__construct();
		//echo '<pre>'; print_r($this); echo '</pre>';
		//echo $this->getThreadId();
	}
	
	public function poll(){
		/*echo __FUNCTION__.'===== Start ======>'.PHP_EOL;
		echo __FUNCTION__.'===== Ends  ======>'.PHP_EOL;
		*/
		
		echo __FUNCTION__.'===== POLL ('.$this->poll_counter.') ===== '.time().' <br>'.PHP_EOL;
		$this->poll_counter++;
	}
	
	public function ex_start(){
		echo __FUNCTION__.'===== Start ======> '.time().' <br>'.PHP_EOL;
		echo __FUNCTION__.'===== Ends  ======> '.time().' <br>'.PHP_EOL;
		
	}
	
	public function run(){
		//$this->ex_start();
		while($this->poll_counter < 5){
			$this->poll();
			sleep(1);	
		}
	}
}
echo PHP_SAPI.' <br>'.PHP_EOL;
$object1 = new Example1();
echo 'Executation Start '.time().' <br>'.PHP_EOL;
$object1->start();
die(json_encode(array('status'=>200,'message'=>'ok','time'=>time() )));
echo 'Executation End '.time().' <br>'.PHP_EOL;
//$object1->poll();