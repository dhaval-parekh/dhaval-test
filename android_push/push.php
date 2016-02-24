<?php
echo 'Android Push Notification <br>';
// GOOGLE API KEY
define('API_KEY_GOOGLE',   'AIzaSyA5_zcTynGydtK0oV1f7R4xGp2nX_S8w0k');
define('API_PUSH_URL', 'https://android.googleapis.com/gcm/send');


/**
 *	@param registatoin_ids = Array Of regirstation ids
 *	@param message == message that is pass to the device (MUST be in array )
 *
 *
 */


function send_push_notification($registatoin_ids, $message) {
	$url = API_PUSH_URL;
	
	$fields = array(
	  'registration_ids' => $registatoin_ids,
	  'data' => $message,
	);
	
	$headers = array(
	  'Authorization: key=' . API_KEY_GOOGLE,
	  'Content-Type: application/json'
	);
	// Open connection
	$ch = curl_init();
	// Set the url, number of POST vars, POST data
	curl_setopt($ch, CURLOPT_URL, $url);
	
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	// Disabling SSL Certificate support temporarly
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	
	// Execute post
	$result = curl_exec($ch);
	if ($result === FALSE) {
	  die('Curl failed: ' . curl_error($ch));
	}
	
	// Close connection
	curl_close($ch);
	echo $result;
}

// replace Udid wil this 
$registatoin_ids = array('APA91bHGW73lmIxWtqPuaGx4I8IWpJYyvkmAXzNY6uhPhLOoC29U2vjyzX2Zj7aV9jl5O9U1uL8fRZ4E5mysRmVVmAd7o40v6gfDbqx9V1YpsH5Qmu7JQFuD_-X8VWxxKGBPC73w6Vnb');
//$message = array("message" => "Messsage fo".date('m/d/Y H:i:s'));

$message = ['status'=>200,'message'=>'OK',
					'payload'=>['message' => 'Your message will be here',]
			];
			$message = ['status'=>'200','message'=>'New Appointment','ordertype'=>'1','appointmenttype'=>'2','appointmentid'=>135];
//$message = ['message'=>$message];


$result = send_push_notification($registatoin_ids, $message);

echo '<pre>';
echo $result;
