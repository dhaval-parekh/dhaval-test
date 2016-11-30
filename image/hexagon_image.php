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


$wall = new Imagick();
//$wall->newimage( $width, $height, new ImagickPixel( 'transparent' ) );
$wall->newimage( $width, $height, new ImagickPixel( 'transparent' ) );
$wall->setbackgroundcolor( new ImagickPixel( '#FFF' ) );
$wall->setimageformat( 'png' );

$frame = new Imagick( 'white_frame.png' );
$frame->scaleimage( $width, $height, true );

$image = new Imagick( 'image.jpg' );
//$image = new Imagick(  );
//$image->newimage($width, $height, new ImagickPixel( '#FFF' ) );
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

$wrap_width = $width - ( $wrap_size * 2 );
$wrap_height = $height - ( $wrap_size * 2 );

$corner_width = sqrt( ( $wrap_size * $wrap_size ) + ( $wrap_size * $wrap_size ) );
$a = $wrap_size * 3;
$a = $a - ( $corner_width + $wrap_size );

$wrap_deduction = $corner_width - $wrap_size;
$wrap_deduction = $wrap_size - $wrap_deduction;

//$wrap_deduction = $corner_width / 2;

$primary_corner = sqrt( ( $wrap_size * $wrap_size ) + ( $wrap_deduction * $wrap_deduction ) );
$primary_corner = round( $primary_corner );
////	Function
function genarate_hexagon_deatil( $width, $height, $frame_type ) {
	$primary_corner = array( 0, 3 );
	$corner_position = array(
		1	 => array( 'x' => 0, 'y' => 0 ),
		2	 => array( 'x' => $width, 'y' => 0 ),
		3	 => array( 'x' => $width, 'y' => $height ),
		4	 => array( 'x' => 0, 'y' => $height ),
	);
	$frame_type = strtolower( trim( $frame_type ) );
	switch ( $frame_type ) {
		case 'portrait':
			$ploats = array(
				0	 => array( 'x' => 0.50 * $width, 'y' => 0.00 * $height ),
				1	 => array( 'x' => 1.00 * $width, 'y' => 0.25 * $height ),
				2	 => array( 'x' => 1.00 * $width, 'y' => 0.75 * $height ),
				3	 => array( 'x' => 0.50 * $width, 'y' => 1.00 * $height ),
				4	 => array( 'x' => 0.00 * $width, 'y' => 0.75 * $height ),
				5	 => array( 'x' => 0.00 * $width, 'y' => 0.25 * $height ),
			);
			$datas = $ploats;
			break;
		case 'landscape':
			$ploats = array(
				0	 => array( 'x' => 0.00 * $width, 'y' => 0.50 * $height ),
				1	 => array( 'x' => 0.25 * $width, 'y' => 0.00 * $height ),
				2	 => array( 'x' => 0.75 * $width, 'y' => 0.00 * $height ),
				3	 => array( 'x' => 1.00 * $width, 'y' => 0.50 * $height ),
				4	 => array( 'x' => 0.75 * $width, 'y' => 1.00 * $height ),
				5	 => array( 'x' => 0.25 * $width, 'y' => 1.00 * $height ),
			);
			$datas = $ploats;
			break;
	}
	foreach ( $datas as $corner => &$data ) {
		//	set next corner
		$next_corner = false;
		$previous_corner = false;
		if ( count( $datas ) === ( $corner + 1 ) ) {
			$next_corner = 0;
		} else {
			$next_corner = $corner + 1;
		}
		if ( 0 === $corner ) {
			$previous_corner = count( $datas ) - 1;
		} else {
			$previous_corner = $corner - 1;
		}
		$data['next_corner'] = $next_corner;
		$data['previous_corner'] = $previous_corner;
		//	get 90* corner
		$base_corner = false;
		if ( $data['x'] < $datas[$next_corner]['x'] && $data['y'] > $datas[$next_corner]['y'] ) {
			$base_corner = 1;
		} else if ( $data['x'] < $datas[$next_corner]['x'] && $data['y'] < $datas[$next_corner]['y'] ) {
			$base_corner = 2;
		} else if ( $data['x'] > $datas[$next_corner]['x'] && $data['y'] < $datas[$next_corner]['y'] ) {
			$base_corner = 3;
		} else if ( $data['x'] > $datas[$next_corner]['x'] && $data['y'] > $datas[$next_corner]['y'] ) {
			$base_corner = 4;
		}
		$data['base_corner'] = $base_corner;

		//	get side length
		$side_length = 0;
		$adjacent_length = false;
		$opposite_length = false;
		switch ( $base_corner ) {
			case 1:
			case 3:
				$adjacent_length = abs( $data['y'] - $corner_position[$base_corner]['y'] );
				$opposite_length = abs( $datas[$next_corner]['x'] - $corner_position[$base_corner]['x'] );
				break;
			case 2:
			case 4:
				$adjacent_length = abs( $data['x'] - $corner_position[$base_corner]['x'] );
				$opposite_length = abs( $datas[$next_corner]['y'] - $corner_position[$base_corner]['y'] );
				break;
			case false:
			default:
				if ( $data['x'] === $datas[$next_corner]['x'] ) {
					$side_length = abs( $data['y'] - $datas[$next_corner]['y'] );
				} elseif ( $data['y'] === $datas[$next_corner]['y'] ) {
					$side_length = abs( $data['x'] - $datas[$next_corner]['x'] );
				}
				break;
		}
		$data['adjacent_length'] = $adjacent_length;
		$data['opposite_length'] = $opposite_length;
		if ( $adjacent_length && $opposite_length ) {
			$side_length = sqrt( ( $adjacent_length * $adjacent_length ) + ( $opposite_length * $opposite_length ) );
		}
		$side_length = round( $side_length );
		$data['side_length'] = $side_length;
		$degree = false;
		// Find degree
		if ( $adjacent_length && $opposite_length ) {
			$opposite_length_sq = ( $opposite_length * $opposite_length );
			$adjacent_length_sq = ( $adjacent_length * $adjacent_length );
			$side_length_sq = ( $side_length * $side_length );
			$cos = $adjacent_length / $side_length;
			$acos = acos( $cos );
			$radian = rad2deg( $acos );
			$degree = round( $radian );
			if ( in_array( $corner, $primary_corner ) ) {
				$degree = 180 - ( $degree * 2 );
			} else {
				$degree = 180 - ( $degree * 1 );
			}
			
		}
		$data['degree'] = $degree;		
	}
	unset( $data );
	$datas[1]['degree'] = $datas[2]['degree'];
	$datas[4]['degree'] = $datas[5]['degree'];
	return $datas;
}

//echo '<pre>' . $type;
//$hexagon_data = genarate_hexagon_deatil( $width, $height, $type );
//print_r( $hexagon_data );
//die( '1' );
$outer_line = array();

//$corner_width = $wrap_size ; //sqrt( ( $wrap_size * $wrap_size ) + ( $wrap_size * $wrap_size ) );
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
		0	 => array( 'x' => $ploats[0]['x'], 'y' => $ploats[0]['y'] + $wrap_size ),
		1	 => array( 'x' => $ploats[1]['x'] - $wrap_size, 'y' => $ploats[1]['y'] + $wrap_deduction ),
		2	 => array( 'x' => $ploats[2]['x'] - $wrap_size, 'y' => $ploats[2]['y'] - $wrap_deduction ),
		3	 => array( 'x' => $ploats[3]['x'], 'y' => $ploats[3]['y'] - $wrap_size ),
		4	 => array( 'x' => $ploats[4]['x'] + $wrap_size, 'y' => $ploats[4]['y'] - $wrap_deduction ),
		5	 => array( 'x' => $ploats[5]['x'] + $wrap_size, 'y' => $ploats[5]['y'] + $wrap_deduction ),
	);
} else {
	$outer_line = array();
	$ploats = array(
		0	 => array( 'x' => 0.00 * $width, 'y' => 0.50 * $height ),
		1	 => array( 'x' => 0.25 * $width, 'y' => 0.00 * $height ),
		2	 => array( 'x' => 0.75 * $width, 'y' => 0.00 * $height ),
		3	 => array( 'x' => 1.00 * $width, 'y' => 0.50 * $height ),
		4	 => array( 'x' => 0.75 * $width, 'y' => 1.00 * $height ),
		5	 => array( 'x' => 0.25 * $width, 'y' => 1.00 * $height ),
	);
	$wrap_ploats = array(
		0	 => array( 'x' => $ploats[0]['x'] + $primary_corner, 'y' => $ploats[0]['y'] ),
		1	 => array( 'x' => $ploats[1]['x'] + $wrap_deduction, 'y' => $ploats[1]['y'] + $wrap_size ),
		2	 => array( 'x' => $ploats[2]['x'] - $wrap_deduction, 'y' => $ploats[2]['y'] + $wrap_size ),
		3	 => array( 'x' => $ploats[3]['x'] - $primary_corner, 'y' => $ploats[3]['y'] ),
		4	 => array( 'x' => $ploats[4]['x'] - $wrap_deduction, 'y' => $ploats[4]['y'] - $wrap_size ),
		5	 => array( 'x' => $ploats[5]['x'] + $wrap_deduction, 'y' => $ploats[5]['y'] - $wrap_size ),
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
	$wrap_deductionackground = new Imagick( );
	$wrap_deductionackground->newimage( $width, $height, new ImagickPixel( $wrap_color ), 'png' );

	$inner_wall = new \Imagick();
	$inner_wall->newimage( $width, $height, new ImagickPixel( 'transparent' ), 'png' );
	$inner_wall->compositeimage( $image, \Imagick::COMPOSITE_OVER, 0, 0 );
	$inner_wall->compositeimage( $wrap_mask, \Imagick::COMPOSITE_DSTIN, 0, 0 );

	$wrap_deductionackground->compositeimage( $inner_wall, \Imagick::COMPOSITE_OVER, 0, 0 );

	$wall->compositeimage( $wrap_deductionackground, \Imagick::COMPOSITE_OVER, 0, 0 );
	$wall->compositeimage( $mask, \Imagick::COMPOSITE_DSTIN, 0, 0 );

//	echo $wall->getimageblob();
//	die( '1' );
} else {
	$wall->compositeimage( $image, \Imagick::COMPOSITE_OVER, 0, 0 );
	$wall->compositeimage( $mask, \Imagick::COMPOSITE_DSTIN, 0, 0 );
}
header( "Content-Type: image/png" );
/* Perform the distortion */
//$image->distortImage( Imagick::DISTORTION_PERSPECTIVE, $controlPoints, true );
//$wall->compositeimage( $image, $image->getimagecompose(), 0, 0 );
//$wall->compositeimage( $frame, $frame->getimagecompose(), 0, 0 );
//$slice =  $wall->getimageblob(); //new \Imagick();
//$slice = $wall->getimage();
//$slice_mask =  new \Imagick( );
//$slice_mask->setformat('png');
//$slice_mask->newimage( $width, $height, new ImagickPixel( '#FFF' ) ); // transparent
//
//
//
//$slice_draw = new \ImagickDraw();
//$slice_polygon = array(
//	0 => $ploats[0],
//	1 => $wrap_ploats[0],
//	2 => $wrap_ploats[1],
//	3 => $ploats[1],
//);
//$slice_draw->polygon($slice_polygon);
//$slice_mask->drawimage( $slice_draw );
//$slice->compositeimage($slice_mask, \Imagick::COMPOSITE_DSTIN, 0, 0);
$another_wall = new Imagick();
$another_mask = new Imagick();
$another_mask->setformat( 'png' );
$another_mask->newimage( $width, $height, new ImagickPixel( '#FF0' ) );
$another_draw = new ImagickDraw();
$another_draw->polygon( $ploats );
$another_mask->drawimage( $another_draw );
//$another_wall->compositeimage( $wall , $wall->getcompression(), 0, 0);
//$another_wall->compositeimage( $wall , $another_wall->getcompression(), 0, 0);
/* Ouput the image */
//$wall->paintTransparentImage( new ImagickPixel( 'transparent' ), 1, 0 );
//$wall->transparentPaintImage( new ImagickPixel( 'transparent' ), 1, new ImagickPixel( '#FFF' ) );
//$wall->compositeimage($another_mask, \Imagick::COMPOSITE_DSTIN, 0, 0);

$wall->compositeimage( $another_mask, \Imagick::COMPOSITE_DSTATOP, 0, 0 );
echo $wall->getimageblob();
//echo $another_mask->getimageblob();
