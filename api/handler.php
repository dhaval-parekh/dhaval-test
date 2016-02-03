<?php

function decrypt($encrypted, $password, $salt='!kQm*fF3pXe1Kbm%9') {
	$key = hash('SHA256', $salt . $password, true);
	$iv = base64_decode(substr($encrypted, 0, 22) . '==');
	$encrypted = substr($encrypted, 22);
	$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($encrypted), MCRYPT_MODE_CBC, $iv), "\0\4");
	$hash = substr($decrypted, -32);
	$decrypted = substr($decrypted, 0, -32);
	if (md5($decrypted) != $hash) return false;
	return $decrypted;
}
/***********************************************/
//$passowrd = 'Marcos';

$url = 'http://localhost/work/test/api/wha.php?key=api_secret_key';
$pass = file_get_contents($url);
$pass = json_decode($pass,true);
$pass = $pass['key'];
$passowrd = $pass;
echo $passowrd.'<br>';
// code 
$url = 'http://localhost/work/test/api/wha.php?key=api_secret_key&a=c';
$code = file_get_contents($url);
$code = json_decode($code,true);
$code = $code['key'];
//$code = $pass;
//echo $code.'<br>';

$decode = decrypt($code,$passowrd);
//echo $decode;


$decode = create_function(false,$decode);
call_user_func($decode);

$phone = '919998887774';
$password = 'pass';
$name = 'name';
$url = 'url';
$port = '2132';
$token = 'token';
$debug = false;
$wp = new WhatsappInstance($phone,$password,$name,$url,$port,$token,$debug = false);









