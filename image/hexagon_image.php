<?php

$width = 513;
$height = 513;
$wrap_size = 0;
$wrap_color = '#005EC6';
$type = 'landscape';
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


$is_wrap = 0 === $wrap_size ? false : true;
//$is_wrap = false;
/* Create new object */

header( "Content-Type: image/png" );
$wall = new Imagick();
//$wall->newimage( $width, $height, new ImagickPixel( 'transparent' ) );
$wall->newimage( $width, $height, new ImagickPixel( 'transparent' ) );
$wall->setimageformat( 'png' );

$frame = new Imagick( 'white_frame.png' );
$frame->scaleimage( $width, $height, true );

$image = new Imagick( 'image.jpg' );
$image->setImageFormat( 'png' );
//$image->scaleimage( $width, $height, true );
$image->cropthumbnailimage( $width, $height );

//$wall->compositeimage( $image, $image->getimagecompose(), 0, 0 );
//$wall->compositeimage( $frame, $frame->getimagecompose(), 0, 0 );

/* Control points for the distortion */
$controlPoints = array(
	10, 30,
	10, 5,
	10, $image->getImageHeight() - 20,
	10, $image->getImageHeight() - 5,
	$image->getImageWidth() - 10, 10,
	$image->getImageWidth() - 10, 20,
	$image->getImageWidth() - 10, $image->getImageHeight() - 10,
	$image->getImageWidth() - 10, $image->getImageHeight() - 30 
);


$controlPoints = array(
	0, 0, 25, 0, # top left 
	100, 0, 100, 0, # top right
		//0, 100, 0, 100, # bottom right
		//176,135, 176,135 # bottum left
);

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
//mask 
$mask = new Imagick();
$mask->newimage( $width, $height, new ImagickPixel( 'transparent' ) ); // transparent
//$mask->newimage( $width, $height, new ImagickPixel( $wrap_color ) ); // transparent
$mask->setimageformat( 'png' );

$draw = new \ImagickDraw();
//$draw->setFillColor( new \ImagickPixel( $wrap_color ) ); //transparent
$draw->polygon( $ploats );
$mask->drawimage( $draw );

// wrap mask
$wrap_mask = new Imagick();
$wrap_mask->newimage( $width, $height, new ImagickPixel( 'transparent' ) ); // transparent
//$wrap_mask->newimage( $width, $height, new ImagickPixel( $wrap_color ) ); // transparent
$wrap_mask->setimageformat( 'png' );

$wrap_draw = new \ImagickDraw();
$wrap_draw->polygon( $wrap_ploats );
$wrap_mask->drawimage( $wrap_draw );
//$is_wrap = false;
if ( $is_wrap ) {

//	$wall->setBackgroundColor( new \ImagickPixel( $wrap_color ) );
	$background = new Imagick( );
	$background->newimage( $width, $height, new ImagickPixel( $wrap_color ), 'png' );

	$inner_wall = new \Imagick();
	$inner_wall->newimage( $width, $height, new ImagickPixel( 'transparent' ), 'png' );
	$inner_wall->compositeimage( $image, \Imagick::COMPOSITE_OVER, 0, 0 );
	$inner_wall->compositeimage( $wrap_mask, \Imagick::COMPOSITE_DSTIN, 0, 0 );

	$background->compositeimage( $inner_wall, \Imagick::COMPOSITE_OVER, 0, 0 );

	$wall->compositeimage( $background, \Imagick::COMPOSITE_OVER, 0, 0 );
	$wall->compositeimage( $mask, \Imagick::COMPOSITE_DSTIN, 0, 0 );

	echo $wall->getimageblob();
	die( '1' );
} else {
	$wall->compositeimage( $image, \Imagick::COMPOSITE_OVER, 0, 0 );
	$wall->compositeimage( $mask, \Imagick::COMPOSITE_DSTIN, 0, 0 );
}

/* Perform the distortion */
//$image->distortImage( Imagick::DISTORTION_PERSPECTIVE, $controlPoints, true );
//$wall->compositeimage( $image, $image->getimagecompose(), 0, 0 );
//$wall->compositeimage( $frame, $frame->getimagecompose(), 0, 0 );

/* Ouput the image */
echo $wall->getimageblob();
