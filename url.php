<?php

$url = "p.ciphersoulas";
$url = "http://whatsapp.ciphersoul.com/uploads/image.jpg";
//$url = "http://whatsapp.ciphersoul.com/uploads/audio.mp3";
//$url = "http://whatsapp.ciphersoul.com/uploads/video.mp4";
//echo url_exists($url);
//echo url_exists($url) ? "Exists" : 'Not Exists';
 
/* function url_exists($url) {
    $hdrs = get_headers($url);
    return is_array($hdrs) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$hdrs[0]) : false;
}*/
function url_exists($url) {
    $headers = @get_headers($url);
	$herd = $headers;
	foreach($headers as &$head){
		$head = explode(':',$head);
	}
	//echo '<pre>'; print_r($headers); echo '</pre>';	
   // echo @$hdrs[1]."<br>\n";

    return is_array($herd) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$herd[0]) : false;
}
echo getMessageType($url);
function getMessageType($message){
	$message_type = 1;
	if (filter_var($message, FILTER_VALIDATE_URL) === false) {
		$message_type = 1;
		// Message
		return $message_type;
	} else {
		$headers = @get_headers($message);
		$url_flag = is_array($headers) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$headers[0]) : false;
		if(!$url_flag){
			$message_type = 1;
			// url but Broken
			return $message_type;
		}else{
			$temp_headers = array();
			foreach($headers as &$head){
				$head = explode(':',$head);
				$temp_headers[$head[0]] = isset($head[1])?$head[1]:false;
			}
			if(! (isset($temp_headers['Content-Type']) && (! empty($temp_headers['Content-Type'])  ) )){
				$message_type = 1;
				// NO Content Type thats why it is 
				return $message_type;
			}
			
			
			$type  = explode('/',$temp_headers['Content-Type']);
			$type = strtolower(trim($type[0]));
			switch($type){
				case 'image':	
						// 	Image
						$message_type = 2;
					break;
				case 'audio':	
						// Audio
						$message_type = 3;
					break;
				case 'video':	
						// video
						$message_type = 4;
					break;
				default:	
						// BY Default Message
						$message_type = 1;
					break;
			}
			return $message_type;
		}
		
	}
	return $message_type;
}