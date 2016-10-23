<?php

//$frame_path = 'posters-4x6-portrait-400x400.png';
$frame_path = 'HexagonTemplate_white-mask-test.png';

//set the plots array.
//Currently, it came from 0 index, If we implement multiple frame feature in future then here selected frame index came.
//$plots_array = '[[133,53],[268,53],[268,255],[133,255]]';
$plots_array = '[[0,0],[500,0],[500,500],[0,500]]';

$fname = '4371-4.jpg';

//File meta required for renaming the images
$file_data = pathinfo( $fname );
$file_name = $file_data['filename'];
$file_ext  = $file_data['extension'];

$dimensions = getimagesize( $frame_path );

$width      = $dimensions[0];
$height     = $dimensions[1];

//set facex and facey
$facex = $width;
$facey = $height;

$new_w = min( $facex, $facey );
$new_h = max( $facex, $facey );

$ratio       = (float) $facex / (float) $facey;
$image_ratio = (float) $width / (float) $height;

if ( round( $ratio, 2 ) != round( $image_ratio, 2 ) ) {
	if ( floor( $image_ratio ) != floor( $ratio ) ) {
		$temp   = $width;
		$width  = $height;
		$height = $temp;
	}
	if ( $width < $height ) {
		$new_w = $width;
		$new_h = $width / $ratio;
	} else {
		$new_h = $height;
		$new_w = $height * $ratio;
	}
}


	preg_match_all( '/(?:\[)([^\[\]]+)(?:\])/i', $plots_array, $result );

	$plots = array();
	foreach ( $result[1] as $plot ) {
		$temp    = explode( ',', $plot );
		$plots[] = array( intval( $temp[0] ), intval( $temp[1] ) );
	}
	$points = count( $plots );

	$x1 = $plots[0][0];
	$y1 = $plots[0][1];
	$x2 = $plots[1][0];
	$y2 = $plots[1][1];
	$x3 = $plots[2][0];
	$y3 = $plots[2][1];
	$x4 = $plots[3][0];
	$y4 = $plots[3][1];

	$h       = max( abs( $y4 - $y1 ), abs( $y3 - $y2 ) );
	$w       = abs( $x2 - $x1 );
	$h_left  = abs( $y4 - $y1 );
	$h_right = abs( $y3 - $y2 );
	$x       = $x1;
	$y       = $y1;

	$resized = $fname;
	//preview file name
	$preview  = 'hexagon' . $file_name . '.' . $file_ext;
	$preview1 = 'hexagon' . $file_name . '_1.' . $file_ext;
	$preview2 = 'hexagon' . $file_name . '_2.' . $file_ext;
	$preview3 = 'hexagon' . $file_name . '_3.' . $file_ext;
	$preview4 = 'hexagon' . $file_name . '_4.' . $file_ext;
	$preview5 = 'hexagon' . $file_name . '_5.' . $file_ext;
	$preview6 = 'hexagon' . $file_name . '_6.' . $file_ext;

	$image = new \Imagick( $resized );

	//$image->newimage( $height, $width, new \ImagickPixel ( "black" ) );

	//$image->readimage( $resized );

	// if the uploaded image is a CMYK image, we need to change the colorspace to RGB - // pop
	/*if ( $image->getImageColorspace() == \Imagick::COLORSPACE_CMYK ) {

		$profiles = $image->getImageProfiles( '*', false );
		// we're only interested if ICC profile(s) exist
		$has_icc_profile = ( array_search( 'icc', $profiles ) !== false );
		// if it doesnt have a CMYK ICC profile, we add one
		if ( false === $has_icc_profile ) {
			$icc_cmyk = file_get_contents( STYLESHEETPATH . '/ext-lib/USWebUncoated.icc' );
			$image->profileImage( 'icc', $icc_cmyk );
			unset( $icc_cmyk );
		}
		// then we add an RGB profile
		$icc_rgb = file_get_contents( STYLESHEETPATH . '/ext-lib/sRGB_v4_ICC_preference.icc' );
		$image->profileImage( 'icc', $icc_rgb );
		unset( $icc_rgb );

		$image->stripImage(); // this will drop down the size of the image dramatically (removes all profiles)
		// end convert to RGB=========================|
	}*/

	// $status = $image->cropThumbnailImage( $new_w, $new_h );
	$status = $image->cropThumbnailImage( 500, 500 );

	//The addition and substraction of the pixel is to overcome the image shift during distortion
	$control_points_front = array(
		0,
		0, //top left
		max( $plots[0][0] - 1, 0 ),
		max( $plots[0][1] - 1, 0 ),
		$dimensions[0],
		0, //top right
		$plots[1][0] + 1,
		max( $plots[1][1] - 1, 0 ),
		$dimensions[0],
		$dimensions[1], //bottom-right
		$plots[2][0] + 1,
		$plots[2][1] + 1,
		0,
		$dimensions[1], //bottom-left
		max( $plots[3][0] - 1, 0 ),
		$plots[3][1] + 1,
	);

	$image->scaleimage( $dimensions[0], $dimensions[1] );

	//$image->writeimage( $preview1 );

	//Height required for distortion
	$new_h = ( $h - $h_right ) / 2;

	/* Perform the distortion */
	$image->distortImage( \Imagick::DISTORTION_PERSPECTIVE, $control_points_front, false );

	//Mask is required for removing the artifacts being created by imagemagick with some typical
	//control point configurations
	$mask = new \Imagick();
	$mask->newimage( $dimensions[0], $dimensions[1], new \ImagickPixel( 'transparent' ) );
	$mask->setimageformat( 'png' );
	$draw = new \ImagickDraw();

	$draw->setFillColor( new \ImagickPixel( 'black' ) );
	$mask_coordinates_front = array();
	foreach ( $plots as $plot ) {
		$mask_coordinates_front[] = array( 'x' => $plot[0], 'y' => $plot[1] );
	}
	$draw->polygon( $mask_coordinates_front );
	if ( isset( $mask_coordinates_slice ) && count( $mask_coordinates_slice ) == 5 ) {
		$draw->polygon( $mask_coordinates_slice );
	}
	$mask->drawimage( $draw );

	//$mask->writeimage( $preview2 );

	$canvas = new \Imagick(); // Create a new instance an $image class
	$canvas->newImage( $dimensions[0], $dimensions[1], new \ImagickPixel( '#000000' ) );

	//Creating two Imagick objects
	$frame = new \Imagick( $frame_path );

	//$third = new \Imagick(plugin_dir_path(__FILE__).'/images/shell.png');
	// Set the colorspace to the same value
	$frame->setImageColorspace( $image->getImageColorspace() );
	//$frame->writeimage( $preview3 );

	$canvas->compositeimage( $image, \Imagick::COMPOSITE_OVER, 0, 0 );
	// First remove everything from the distorted image except the mask
	$canvas->compositeimage( $mask, \Imagick::COMPOSITE_DSTIN, 0, 0, \Imagick::CHANNEL_ALPHA );

	//$canvas->writeimage( $preview4 );
	// Put the distorted image on the canvas
	// $canvas->compositeImage($wrap_cover, $image->getimagecompose(), 0, 0);
	//Put the frame on the canvas
	$canvas->compositeImage( $frame, $frame->getimagecompose(), 0, 0 );
	//set interlace plane for pregressive loading of the image
	$canvas->setInterlaceScheme( \Imagick::INTERLACE_PLANE );

	//$canvas->writeimage( $preview5 );

	//increase the preview size // for iphone6 // pop
	$canvas->scaleimage( ( $dimensions[0] * 2 ), ( $dimensions[1] * 2 ) );
	//Write the canvas with the frame and the distorted
	$canvas->writeImage( $preview );

	//Destroying the Imagick Objects created
	$frame->clear();
	$canvas->clear();
	$image->clear();
	$mask->clear();
	$draw->clear();
	//$wrap_cover->destroy();
	$canvas->destroy();
?>

<div style="float:left; margin-left:10px;border:1px solid;">
<img src="<?php echo $fname; ?>" width="500" height="500" />
</div>
<div style="float:right;border:1px solid;">
<img src="<?php echo $preview;?>" width="500" height="500" />
</div>
