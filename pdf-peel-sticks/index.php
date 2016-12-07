<?php
error_reporting( -1 );
// Include 'Composer' autoloader.
include 'vendor/autoload.php';
include 'functions.php';

// Files
$input_file = 'files/input-2.pdf';
$input_file = 'files/triangle.pdf';
$output_file = 'files/output.pdf';

$image_output = 'files/image-out.png';

$file = file( $input_file );
//header('Content-type: application/pdf');
//$conent = readfile( $input_file );
$img_string = '/9j/4AAQSkZJRgABAgEASABIAAD/7QAsUGhvdG9zaG9wIDMuMAA4QklNA+0AAAAAABAASAAAAAEA
AQBIAAAAAQAB/+4ADkFkb2JlAGTAAAAAAf/bAIQABgQEBAUEBgUFBgkGBQYJCwgGBggLDAoKCwoK
DBAMDAwMDAwQDA4PEA8ODBMTFBQTExwbGxscHx8fHx8fHx8fHwEHBwcNDA0YEBAYGhURFRofHx8f
Hx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8f/8AAEQgBAAEAAwER
AAIRAQMRAf/EAaIAAAAHAQEBAQEAAAAAAAAAAAQFAwIGAQAHCAkKCwEAAgIDAQEBAQEAAAAAAAAA
AQACAwQFBgcICQoLEAACAQMDAgQCBgcDBAIGAnMBAgMRBAAFIRIxQVEGE2EicYEUMpGhBxWxQiPB
UtHhMxZi8CRygvElQzRTkqKyY3PCNUQnk6OzNhdUZHTD0uIIJoMJChgZhJRFRqS0VtNVKBry4/PE
1OT0ZXWFlaW1xdXl9WZ2hpamtsbW5vY3R1dnd4eXp7fH1+f3OEhYaHiImKi4yNjo+Ck5SVlpeYmZ
qbnJ2en5KjpKWmp6ipqqusra6voRAAICAQIDBQUEBQYECAMDbQEAAhEDBCESMUEFURNhIgZxgZEy
obHwFMHR4SNCFVJicvEzJDRDghaSUyWiY7LCB3PSNeJEgxdUkwgJChgZJjZFGidkdFU38qOzwygp
0+PzhJSktMTU5PRldYWVpbXF1eX1RlZmdoaWprbG1ub2R1dnd4eXp7fH1+f3OEhYaHiImKi4yNjo
+DlJWWl5iZmpucnZ6fkqOkpaanqKmqq6ytrq+v/aAAwDAQACEQMRAD8A9KaVpWlnS7MmzgJMEdT6
afyD2xVF/onSv+WKD/kUn9MVd+idK/5YoP8AkUn9MVd+idK/5YoP+RSf0xV36J0r/lig/wCRSf0x
V36J0r/lig/5FJ/TFXfonSv+WKD/AJFJ/TFXfonSv+WKD/kUn9MVd+idK/5YoP8AkUn9MVd+idK/
5YoP+RSf0xV36J0r/lig/wCRSf0xV36J0r/lig/5FJ/TFXfonSv+WKD/AJFJ/TFXfonSv+WKD/kU
n9MVd+idK/5YoP8AkUn9MVQl/pWlyKtotnByuaq5EabRD+8PTwPH5kYq6x0rS4w9m1nBW3oIz6ab
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
/wCBIDfRTvir/9k=';
//getImage( $img_string );
//die();

//header('Content-type: application/pdf');
//readfile( $input_file );
display( file_get_contents( $input_file ) );
die();
//$command = "convert {$input_file} {$image_output} 2>&1";
$command = "convert {$input_file} {$image_output} ";
shell_exec( $command );


//	remove white background
$image_png = imagecreatefrompng( $image_output );
//$image_png = imagecreatefrompng( 'files/1000.png' );
$width = imagesx( $image_png );
$height = imagesy( $image_png );

//create image mask layer
$new_image = ImageCreateTruecolor( $height, $height );

//remove white background 
setTransparency( $new_image, $image_png );

//merge mask with original image source
ImageCopyMerge( $new_image, $image_png, 0, 0, 0, 0, imagesx( $image_png ), imagesy( $image_png ), 100 );

header( 'Content-Type: image/png' );
$get_color_file = 'files/output.png';
//imagepng( $new_image, null, 9 );
//die();
imagepng( $new_image, $get_color_file, 9 );
//$get_color_file = $image_output;
$bg_color = array(
	'r'	 => 0,
	'g'	 => 0,
	'b'	 => 0,
);
$bg_color = array(
	'r'	 => 255,
	'g'	 => 255,
	'b'	 => 255,
);

$im = imagecreatefrompng( $get_color_file );
$newImg = imagecreate( $width, $height );
//$bgColor = imagecolorallocate( $newImg, 255, 255, 255 );
$bgColor = imagecolorallocate( $newImg, 0, 0, 0 );

$replaceColor = array(
	'red'	 => 255,
	'green'	 => 0,
	'blue'	 => 0,
	'alpha'	 => 0,
);
//foreach ( $transparent_plots as $plots ) {
//	$i = $plots['row'];
//	$j = $plots['column'];
////	$index = imagecolorat( $im, $i, $j );
////	$color = imagecolorsforindex( $im, $index );
////	if ( ( $bg_color['r'] != $color['red'] && $bg_color['g'] != $color['green'] && $bg_color['b'] != $color['blue'] ) ) {
////		error_log( json_encode( array( 'x' => $i, 'y' => $j ) ) );
////		error_log( json_encode( $color ) );
////		
////	}
//	$ima = imagecolorallocatealpha( $newImg, $replaceColor['red'], $replaceColor['green'], $replaceColor['blue'], $replaceColor['alpha'] );
//	imagesetpixel( $newImg, $j, $i, $ima );
//}
//header( 'Content-Type: image/png' );
//imagepng( $newImg );
//die();
for ( $i = 0; $i < $width; $i++ ) {
	for ( $j = 0; $j < $height; $j++ ) {
		$index = imagecolorat( $im, $i, $j );
		$color = imagecolorsforindex( $im, $index );
		if ( ( $bg_color['r'] != $color['red'] && $bg_color['g'] != $color['green'] && $bg_color['b'] != $color['blue'] ) ) {
			error_log( json_encode( array( 'x' => $i, 'y' => $j ) ) );
			error_log( json_encode( $color ) );
			$ima = imagecolorallocatealpha( $newImg, $replaceColor['red'], $replaceColor['green'], $replaceColor['blue'], $replaceColor['alpha'] );
			imagesetpixel( $newImg, $i, $j, $ima );
		}
	}
}
header( 'Content-Type: image/png' );

imagepng( $newImg );


die();








