<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$base	 = new Imagick( 'image/b7seR.png' );
$mask	 = new Imagick( 'image/zCGJv.png' );
$over	 = new Imagick( 'image/GYuIp.png' );

// Setting same size for all images
$base->resizeImage( 274, 275, Imagick::FILTER_LANCZOS, 1 );
if ( $base->getImageMatte() ) {
	$base->compositeImage( $mask, Imagick::COMPOSITE_DSTIN, 0, 0, Imagick::CHANNEL_ALPHA );
} else {
	$base->compositeImage( $mask, Imagick::COMPOSITE_COPYOPACITY, 0, 0 );
}
// Copy opacity mask
//$base->compositeImage( $mask, Imagick::COMPOSITE_DSTIN, 0, 0, Imagick::CHANNEL_ALPHA );

// Add overlay
$base->compositeImage( $over, Imagick::COMPOSITE_DEFAULT, 0, 0 );

$base->writeImage( 'output.png' );
header( "Content-Type: image/png" );

echo $base;
