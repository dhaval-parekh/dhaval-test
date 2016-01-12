<?php
$password = '123123';
$array = array('key1'=>'Value 112 312','key2'=>'Value 2','key3'=>'value 2');

function encrypt($decrypted, $password, $salt='!kQm*fF3pXe1Kbm%9') {
	// Build a 256-bit $key which is a SHA256 hash of $salt and $password.
	$key = hash('SHA256', $salt . $password, true);
	// Build $iv and $iv_base64.  We use a block size of 128 bits (AES compliant) and CBC mode.  (Note: ECB mode is inadequate as IV is not used.)
	srand(); $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_RAND);
	if (strlen($iv_base64 = rtrim(base64_encode($iv), '=')) != 22) return false;
	// Encrypt $decrypted and an MD5 of $decrypted using $key.  MD5 is fine to use here because it's just to verify successful decryption.
	$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $decrypted . md5($decrypted), MCRYPT_MODE_CBC, $iv));
	// We're done!
	return $iv_base64 . $encrypted;
}

function decrypt($encrypted, $password, $salt='!kQm*fF3pXe1Kbm%9') {
	// Build a 256-bit $key which is a SHA256 hash of $salt and $password.
	$key = hash('SHA256', $salt . $password, true);
	// Retrieve $iv which is the first 22 characters plus ==, base64_decoded.
	$iv = base64_decode(substr($encrypted, 0, 22) . '==');
	// Remove $iv from $encrypted.
	$encrypted = substr($encrypted, 22);
	// Decrypt the data.  rtrim won't corrupt the data because the last 32 characters are the md5 hash; thus any \0 character has to be padding.
	$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($encrypted), MCRYPT_MODE_CBC, $iv), "\0\4");
	// Retrieve $hash which is the last 32 characters of $decrypted.
	$hash = substr($decrypted, -32);
	// Remove the last 32 characters from $decrypted.
	$decrypted = substr($decrypted, 0, -32);
	// Integrity check.  If this fails, either the data is corrupted, or the password/salt was incorrect.
	if (md5($decrypted) != $hash) return false;
	// Yay!
	return $decrypted;
}

//function display($obj){ echo '<pre>'; print_r($obj); echo '</pre>'; }
//$string_function = "\$array = array('key1'=>'Value 1','key2'=>'Value 2','key3'=>'value 2'); function display(\$obj){ echo '<pre>'; print_r(\$obj); echo '</pre>'; } display(\$array);";
//$string_function = "function display(\$obj){ echo '<pre>'; print_r(\$obj); echo '</pre>'; } ";
//echo encrypt($string_function,$password);

$encrypted = '5x+gZe+Db9fQNxwu8kLOMAENqxLhqVKQCG8Dc9P8d4CV/xCc7Xbbt66YFvMui7JBRinGXGuV8aXBThS6PQshW5/etDXiRuTVVujONuONVzPGy59UXQoz3bG9iWH8JM4FoIdkmvduoFc/7mVlmg4Cb2N3Fc/M3VKppp80IJBIayKGD2ssriLSEPUE/z62l7IlL4VEDxkT2CstplKw+xqBdbjLjRRXJdMcJHCASYiPVedRDCPN3wuSNJivSYoKxPEOtfUSrxZ/Eo1NGi1vAeOMCu';
$lib_url = 'http://localhost/work/test/product_lib/lib.txt';
$lib = file_get_contents($lib_url);
$lib = decrypt($lib,$password);
//$data = decrypt($encrypted,$password);
//echo $data."<br>";
//echo $lib;
$lib = create_function(false,$lib);
call_user_func($lib);





display($array);
