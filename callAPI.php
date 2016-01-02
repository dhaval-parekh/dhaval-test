<?php

$request = array(
						'event' => 'onGetMessage',
						'args' => array(
								'mynumber'=>'9876543210',
								'from'=>'3216549871',
								'id'=>'12321423',
								'type'=>'1',
								'time'=>time(),
								'name'=>'Dhaval Test',
								'body'=>'HI ',
							),
					);

$header = array("Content-Type: application/json","access-control-allow-origin: *");
$url = 'http://localhost/work/project/index.php/api/index';
$url = 'http://leclient.ciphersoul.com/index.php/api/index/';
//$url = 'http://new.finestardiamonds.com/Default.aspx';
if($request){
	$request = json_encode($request);
}
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$request);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response  = curl_exec($ch);
curl_close($ch);
echo 'response => ';
echo '<pre>'; print_r($response); echo '</pre>';

/*
$file_name = 'event_log.txt';
$file = fopen($file_name, "a");
$cur_Date = date('Y-m-d H:i:s');
if(is_array($text)){ $text = 'Array => '.json_encode($text); }
$text = $cur_Date.' "'.$text.'"; '.PHP_EOL;
fwrite($file, $text);
*/