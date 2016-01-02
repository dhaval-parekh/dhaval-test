<?php
function system_log($text){
	$file_name = 'system_log.txt';
	$file = fopen($file_name, "a");
	$cur_Date = date('Y-m-d H:i:s');
	$backtrack = debug_backtrace();
	$function = $backtrack[count($backtrack)-1];
	$location = 'File = "'.__FILE__.'"; Function = "'.$function['function'].'"; Line = '.$function['line'].';';
	$text = $cur_Date.' =>  Log = "'.$text.'"; '.$location.' '.PHP_EOL;
	fwrite($file, $text);
}

function test_log($log){
	
	system_log($log);
}


$array = array('key1'=>'value1','key2'=>array('value-2-1','value-2-3','value-2-3'));
test_log('Hello ');