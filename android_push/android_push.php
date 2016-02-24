<?php

// GOOGLE API KEY

define('API_KEY_GOOGLE',   'AIzaSyA5_zcTynGydtK0oV1f7R4xGp2nX_S8w0k');

define('API_DISTANCE_URL', 'https://maps.googleapis.com/maps/api/distancematrix/json');

define('API_PUSH_URL', 'https://android.googleapis.com/gcm/send');

function send_push_notification($api_key,$registatoin_ids, $message) {
	// Set POST variables
	$url = API_PUSH_URL;
	$fields = array(
	  'registration_ids' => $registatoin_ids,
	  'data' => $message,
	);

	$headers = array(
	  'Authorization: key=' . $api_key,
	  'Content-Type: application/json'
	);
	//print_r($headers);
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

echo '<form method="post">';
	echo '<table>';
		$val = isset($_POST['api_key'])?$_POST['api_key']:'';
		$val = API_KEY_GOOGLE;
		echo '<tr><td><input type="text" name="api_key" placeholder="API Key"  value="'.$val.'"  required></td></tr>';
		for($i=0;$i<10;$i++){
			$val = isset($_POST['registatoid'][$i])?$_POST['registatoid'][$i]:'';
			echo '<tr><td><input type="text" name="registatoid[]" placeholder="Registration Id '.($i+1).'" value="'.$val.'" ></td></tr>';	
		}
		echo '<tr><td><input type="submit" name="submit" ></td></tr>';
	echo '</table>';
echo '</form>';
if(isset($_POST) && count($_POST)>0 ){
	
	$registatoin_ids = $_POST['registatoid'];
	foreach($registatoin_ids as $key=>$id){
		if(empty($id)){
			unset($registatoin_ids[$key]); 
		}
	}
	var_dump($registatoin_ids);
	$apikey = $_POST['api_key'];
	/*$registatoin_ids = array('APA91bGLUIwJd7sZtTHDXQu8vSoXsXcerNpMG0LIv4PjVzcDpxOzSqADAFHejPRR5la3ZndKozKcDuvEOHb9b-cqHTcg3Ifvy9dKZ7nAwxo0Jmqj4opCr5o',
					'APA91bHSOAiacaw2kMsxUpcp-ijQUktoYIPkTmwFlZOgQFqRIQRo6i4Sx8QiCLYqvvwAk9bwdKWxKIjVvto5khljELZ38rrRjQbFlB0FgPCL3PZEPQLchto',
					);
	$registatoin_ids = array('APA91bHF-mJXyfxFLHtwnC8fzzJm7nXXr-com_OEAyA-PAo3PvP5DX3gpqV-qtX31Z78h3dD3JB4INWnuVXwcCRfLmPUN4kHSxK0eZdk2mEdFN5xmnC8__OMGomS8AwRNlr3d-Z0CITf');
	*/
	$message = ['status'=>'200','message'=>'New Appointment','ordertype'=>'1','appointmenttype'=>'2','appointmentid'=>135];
	$result = send_push_notification($apikey,$registatoin_ids, $message);
	echo '<pre>';
		print_r($result);
	echo '</pre>';
}else{
}

