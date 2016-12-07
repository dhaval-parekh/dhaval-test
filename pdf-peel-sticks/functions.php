<?php

//	references : http://php.net/manual/en/function.imagecolortransparent.php#89927
function setTransparency( $new_image, $image_source ) {
	$transparencyIndex = imagecolortransparent( $image_source );
	$transparencyColor = array( 'red' => 255, 'green' => 255, 'blue' => 255 );

	if ( $transparencyIndex >= 0 ) {
		$transparencyColor = imagecolorsforindex( $image_source, $transparencyIndex );
	}

	$transparencyIndex = imagecolorallocate( $new_image, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue'] );
	imagefill( $new_image, 0, 0, $transparencyIndex );
	imagecolortransparent( $new_image, $transparencyIndex );
}

// create image from source
function resize( $source_image, $destination = false ) {
	$info = getimagesize( $source_image );
	$imgtype = image_type_to_mime_type( $info[2] );
	#assuming the mime type is correct
	switch ( $imgtype ) {
		case 'image/jpeg':
			$source = imagecreatefromjpeg( $source_image );
			break;
		case 'image/gif':
			$source = imagecreatefromgif( $source_image );
			break;
		case 'image/png':
			$source = imagecreatefrompng( $source_image );
			break;
		default:
			die( 'Invalid image type.' );
	}

	#Figure out the dimensions of the image and the dimensions of the desired thumbnail
	$src_w = imagesx( $source );
	$src_h = imagesy( $source );

	return $source;
}

function display( $obj ) {
	echo '<pre>';
	print_r( $obj );
	echo '</pre>';
}

function getImage( $data ) {
	$data = base64_decode( $data );

	$im = imagecreatefromstring( $data );

	if ( $im !== false ) {

		header( 'Content-Type: image/png' );
		imagepng( $im );
	} else {
		echo 'An error occurred.';
	}
}
