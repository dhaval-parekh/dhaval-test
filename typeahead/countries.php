<?php
header("Content-Type: application/json");
$response = array('key1'=>array('<a href="#"> dhaval </a>','test','testestte'),'key2'=>'parekh','key3'=>'devang','key4'=>'savaliya');
die(json_encode($response));