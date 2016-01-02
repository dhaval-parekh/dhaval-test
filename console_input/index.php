<?php


function system_log($text){
	$file_name = 'system_log.txt';
	$file = fopen($file_name, "a");
	$cur_Date = date('Y-m-d H:i:s');
	//$backtrack = debug_backtrace();
	//$function = $backtrack[count($backtrack)-2];
	//$location = 'File = "'.__FILE__.'"; Function = "'.$function['function'].'"; Line = '.$function['line'].';';
	if(is_array($text)){ $text = 'Array : '.json_encode($text); }
	$text = $cur_Date.' => Log = "'.$text.'"; '.PHP_EOL;
	fwrite($file, $text);
}

function fgets_u($pStdn)
{
    $pArr = array($pStdn);
    if (false === ($num_changed_streams = stream_select($pArr, $write = NULL, $except = NULL, 0))) {
        print("\$ 001 Socket Error : UNABLE TO WATCH STDIN.\n");

        return FALSE;
    } elseif ($num_changed_streams > 0) {
        return trim(fgets($pStdn, 1024));
    }
    return null;
}


$count = 0;
/*
while($count <= 10){
	$count++;

	$line = fgets_u(STDIN);
	system_log($line);f
	sleep(1);	
}*/

 
stream_set_blocking(STDIN, 0);
stream_set_timeout(STDIN, 1);
 
while ($count <= 100) {
	$count++;
    $info = stream_get_meta_data(STDIN);
    var_dump($info['timed_out']);
}