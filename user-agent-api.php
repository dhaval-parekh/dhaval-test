<?php

echo '<pre>';
//print_r($GLOBALS);
/**/
$user_agent = 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_2 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13C75 Safari/601.1';
$user_agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:44.0) Gecko/20100101 Firefox/44.0';
$user_agent = '';
if(preg_match('/iPhone/',$user_agent)){
	echo 'Iphone ';
}else{
	echo 'Default';
}