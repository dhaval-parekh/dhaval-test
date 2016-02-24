<?php
$buffer = 'creditcardType|Name|Number|CVCCODE|EXPDATE|ADDRESS1|ADDRESS2|CITY|STATE|ZIP|COUNTRY';
// very simple ASCII key and IV
$key = "passwordDR0wSS@P6660juhi";
$iv = "passwor2";
$blocksize = strlen($iv);
$extra = $blocksize - (strlen($buffer) % $blocksize);
// add the zero padding
if($extra > 0) {
   for($i = 0; $i < $extra; $i++) {
	  $buffer .= "\0";
   }
}
echo '<pre>'; print_r($extra); echo '</pre>';

// hex encode the return value
echo "Result: ".bin2hex(mcrypt_cbc(MCRYPT_3DES, $key, $buffer, MCRYPT_ENCRYPT, $iv));	