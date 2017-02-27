<?php

function cache( $data ) {
	// Start output buffering
	ini_set( 'implicit_flush', false );
	ob_start();
	header( 'Content-type: application/json' );
	die( json_encode( $data ) );

	// Save the output
	$buffer = ob_get_clean();
	print_r($buffer);
	return $buffer;
}

$data = array(
	'status'	 => 200,
	'message'	 => 'Coming home',
	'payload'	 => array(
		'data'	 => 1,
		'data2'	 => 2,
		'data3'	 => 3,
	),
);

$buffer = cache( $data );
print_r( $buffer );
