<?php
$GET = $_GET;
$key = 'api_secret_key';
$response = array('key'=>time());
if(isset($GET['key']) && $GET['key']===$key){
	$action = isset($GET['a'])?strtolower($GET['a']):strtolower('k');
	switch($action){
		case 'c':
				$code = file_get_contents('en_code');
				$response['key'] = $code;
			break;
		case 'k':
		default:
				$password = 'Marcos';
				$response['key'] = $password;
			break;
	}
}

header('Content-type: application/json');
die(json_encode($response));

