<?php

$width = 500;
$height = 500;
$wrap_size = 5;
$wrap_color = '#005EC6';
$type = 'landscap';
if ( isset( $_GET['width'] ) && is_numeric( $_GET['width'] ) ) {
	$width = $_GET['width'];
}
if ( isset( $_GET['height'] ) && is_numeric( $_GET['height'] ) ) {
	$height = $_GET['height'];
}
if ( isset( $_GET['wrap_size'] ) && is_numeric( $_GET['wrap_size'] ) ) {
	$wrap_size = $_GET['wrap_size'];
}
if ( isset( $_GET['wrap_color'] ) ) {
	$wrap_color = '#' . $_GET['wrap_color'];
}
if ( isset( $_GET['type'] ) ) {
	$type = $_GET['type'];
}

// Ploats
$corner_width = sqrt( ( $wrap_size * $wrap_size ) + ( $wrap_size * $wrap_size ) );
//	landscape
if ( 'portrait' == strtolower( $type ) ) {
	// portrait
	$ploats = array(
		0	 => array( 'x' => 0.50 * $width, 'y' => 0.00 * $height ),
		1	 => array( 'x' => 1.00 * $width, 'y' => 0.25 * $height ),
		2	 => array( 'x' => 1.00 * $width, 'y' => 0.75 * $height ),
		3	 => array( 'x' => 0.50 * $width, 'y' => 1.00 * $height ),
		4	 => array( 'x' => 0.00 * $width, 'y' => 0.75 * $height ),
		5	 => array( 'x' => 0.00 * $width, 'y' => 0.25 * $height ),
	);

	$wrap_ploats = array(
		0	 => array( 'x' => $ploats[0]['x'], 'y' => $ploats[0]['y'] + $corner_width ),
		1	 => array( 'x' => $ploats[1]['x'] - $wrap_size, 'y' => $ploats[1]['y'] + $wrap_size ),
		2	 => array( 'x' => $ploats[2]['x'] - $wrap_size, 'y' => $ploats[2]['y'] - $wrap_size ),
		3	 => array( 'x' => $ploats[3]['x'], 'y' => $ploats[3]['y'] - $corner_width ),
		4	 => array( 'x' => $ploats[4]['x'] + $wrap_size, 'y' => $ploats[4]['y'] - $wrap_size ),
		5	 => array( 'x' => $ploats[5]['x'] + $wrap_size, 'y' => $ploats[5]['y'] + $wrap_size ),
	);
} else {
	$ploats = array(
		0	 => array( 'x' => 0.00 * $width, 'y' => 0.50 * $height ),
		1	 => array( 'x' => 0.25 * $width, 'y' => 0.00 * $height ),
		2	 => array( 'x' => 0.75 * $width, 'y' => 0.00 * $height ),
		3	 => array( 'x' => 1.00 * $width, 'y' => 0.50 * $height ),
		4	 => array( 'x' => 0.75 * $width, 'y' => 1.00 * $height ),
		5	 => array( 'x' => 0.25 * $width, 'y' => 1.00 * $height ),
	);
	$wrap_ploats = array(
		0	 => array( 'x' => $ploats[0]['x'] + $corner_width, 'y' => $ploats[0]['y'] ),
		1	 => array( 'x' => $ploats[1]['x'] + $wrap_size, 'y' => $ploats[1]['y'] + $wrap_size ),
		2	 => array( 'x' => $ploats[2]['x'] - $wrap_size, 'y' => $ploats[2]['y'] + $wrap_size ),
		3	 => array( 'x' => $ploats[3]['x'] - $corner_width, 'y' => $ploats[3]['y'] ),
		4	 => array( 'x' => $ploats[4]['x'] - $wrap_size, 'y' => $ploats[4]['y'] - $wrap_size ),
		5	 => array( 'x' => $ploats[5]['x'] + $wrap_size, 'y' => $ploats[5]['y'] - $wrap_size ),
	);
}

header( 'Content-Type: image/png' );
$wall = new Imagick( );
$wall->newimage( $width, $height, new ImagickPixel( 'transparent' ) );
$wall->setimageformat( 'png' );

$draw = new \ImagickDraw();
$draw->polygon( $ploats );
//$wall->drawimage( $draw );
//echo $wall->getimageblob();
$image = imagecreatefromstring( $wall->getimageblob() );
$color = imagecolorallocate( $image, 256, 0, 0 );
echo imageline( $image, $ploats[0]['x'], $ploats[0]['y'], $ploats[1]['x'], $ploats[1]['y'], $color );
