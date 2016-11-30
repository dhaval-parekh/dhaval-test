<?php

$width = 500;
$height = 500;
$image = new Imagick( 'image.jpg' );
//$image->setformat( 'png' );

$image->scaleimage( $width, $height, true );
//$image->flipimage();
//$image->flopimage();

header( "Content-Type: image/png" );
echo $image->getimageblob();