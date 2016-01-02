<?php
function display($obj){ 	echo '<pre>'; print_r($obj); echo '</pre>';	}
/*
$input = file_get_contents('php://input');
$output = file_get_contents('php://output');
$memory = file_get_contents('php://memory');
$temp = file_get_contents('php://temp');

display('Input : '.$input);
display('output  : '.$output);
display('Memory : '.$memory);
display('Temp : '.$temp);
die();
*/
$connection = 'mongodb://adminlog:adminlog@ds037097.mongolab.com:37097/userstory';
//$connection = 'mongodb://root:root@ds037097.mongolab.com:37097/userstory';
//$connection = 'mongodb://roadyo:roadyo@ds047732.mongolab.com:47732/roadyo';
//$connection = '';
$mongo_client = new MongoClient($connection);
$database = $mongo_client->userstory;

$table = $database->selectCollection('table');
$insert = array('id'=>(int) 2, 'name' => 'Mr. Smith','address'=>'Londan , UK','location'=>['latitude'=>21.706124,'longitude'=>71.642651]);
$result = $table->insert($insert);
display($result);
$update = array('id'=>(int) 2);
$update2= array('name'=>'Vikas Patel 1');
$update2= array('location'=>['latitude'=>21.706124,'longitude'=>71.64]);
//$result =$table->update($update,$update2);

var_dump($result);
display($mongo_client);