<?php

$api_route = array();
$api_route['index'] = new ApiRequest(
		'index/api_index', 'POST', false, //'application/json',
		array(
		//'uid'=>array('type'=>'number','required'=>true)
		)
);

$api_route['addupdateuser'] = new ApiRequest(
		'index/addUpdateUser', 'POST', false, //'application/json',
		array(
	'id'	 => array( 'type' => 'number', 'required' => false ),
	'name'	 => array( 'type' => 'text', 'required' => true ),
	'email'	 => array( 'type' => 'email', 'required' => true ),
	'phone'	 => array( 'type' => 'tel', 'required' => true ),
		)
);

$api_route['getuser'] = new ApiRequest(
		'index/getUser', 'POST', false, //'application/json',
		array(
	'id' => array( 'type' => 'number', 'required' => false ),
		)
);


$api_route['socketserver'] = new ApiRequest(
		'socket/socketServer', 'GET', false, //'application/json',
		array(
	'key'		 => array( 'type' => 'text', 'required' => true ),
	'command'	 => array( 'type' => 'text', 'required' => true )
		)
);
