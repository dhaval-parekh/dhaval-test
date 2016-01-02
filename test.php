<?php
error_reporting(-1);
date_default_timezone_set('Asia/Kolkata');
header("access-control-allow-origin: *");
header("Content-Type: application/json");


$cert_name = 'testestse';
sprintf('pics/%s', $cert_name);
die();

$url = 'https://api.togglewave.com/rcci.svc/rate';
//$url = 'http://whiteglovesme.com/newLogic.php/test';
$url = 'http://174.142.46.155/rcci.svc/rate';
$request = array();
$request['mynumber'] = '';
$request['apikey'] = 'hjgjgasdsadsadysauydisadysiadys';
$request['countrycode'] = 'AR';


$request = json_encode($request);
//$request = '{"mynumber":"3106309306","apikey":"hjgjgasdsadsadysauydisadysiadys","countrycode":"AR"}';
//echo $request;
// cUrl



$header = array("Content-Type: application/json","access-control-allow-origin: *");
//$header = array();
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
//curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//curl_setopt($ch,CURLOPT_HEADER, false); 
curl_setopt ($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_POST, count($request));
curl_setopt($ch, CURLOPT_POSTFIELDS, $request);    

$output=curl_exec($ch);
curl_error($ch);
//echo '<pre>';
print_r($output);