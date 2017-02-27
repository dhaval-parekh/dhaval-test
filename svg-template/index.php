<?php

function setVectorGraphics() {
    
	$xml = simplexml_load_file('image/input-1.svg');
	
	$points=array();
	
	$image_height = intval(preg_replace('/[^0-9]+/', '', $xml['height'][0]), 10);
	$image_width = intval(preg_replace('/[^0-9]+/', '', $xml['width'][0]), 10);
	
		foreach ($xml->polygon as $poly){
			
			$points_string=trim( $poly['points'] );
			
			$points_space_array= explode(' ', $points_string);
			if( !empty($points_space_array) ){
				
				foreach ($points_space_array as $key=>$point_space){
					
					$point_xy= explode(',', $point_space);
					if( !empty($point_xy[0]) && $point_xy[1] ){
						$points[$key]['x']=(float) $point_xy[0];
						$points[$key]['y']=(float) $point_xy[1];
					}
					
				}
			}
			
			
		}

    drwapolygon($points, $image_height,$image_width);
}
setVectorGraphics();

function drwapolygon($points,$image_height,$image_width ){
	
	$strokeColor = '#000000';
	$fillColor ='#FF0000';
	$backgroundColor ="#0101DF";
	$trasnpernt= new ImagickPixel( 'transparent' );
	$draw = new \ImagickDraw();

    $draw->setStrokeOpacity(1);
    $draw->setStrokeColor($strokeColor);
    $draw->setStrokeWidth(4);

    $draw->setFillColor($trasnpernt);
	/*echo '<pre>';
	var_dump($points);
	echo '</pre>';*/
	//die;
	/*$points = [
        ['x' => 40 * 5, 'y' => 10 * 5],
        ['x' => 20 * 5, 'y' => 20 * 5], 
        ['x' => 70 * 5, 'y' => 50 * 5], 
        ['x' => 60 * 5, 'y' => 15 * 5],
    ];
	echo '<pre>';
	var_dump($points);
	echo '</pre>';
	die;*/
    $draw->polygon($points);

    $image = new \Imagick();
    $image->newImage($image_width,$image_height, $trasnpernt);
    $image->setImageFormat("png");
    $image->drawImage($draw);

    $image->writeImage ("output/starimage.png");
	
}
//============================================================+
// File name   : example_034.php
// Begin       : 2008-07-18
// Last Update : 2013-05-14
//
// Description : Example 034 for TCPDF class
//               Clipping
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+
/**
 * Search and include the TCPDF library.
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Include the main class.
 * @author Nicola Asuni
 * @since 2013-05-14
 */

// always load alternative config file for examples
require_once('TCPDF/config/tcpdf_config.php');
//var_dump( realpath('TCPDF/tcpdf.php') );die;
// Include the main TCPDF library (search the library on the following directories).
$tcpdf_include_dirs = array(
	realpath('TCPDF/tcpdf.php'),
	'/usr/share/php/tcpdf/tcpdf.php',
	'/usr/share/tcpdf/tcpdf.php',
	'/usr/share/php-tcpdf/tcpdf.php',
	'/var/www/tcpdf/tcpdf.php',
	'/var/www/html/tcpdf/tcpdf.php',
	'/usr/local/apache2/htdocs/tcpdf/tcpdf.php'
);
foreach ($tcpdf_include_dirs as $tcpdf_include_path) {
	if (@file_exists($tcpdf_include_path)) {
		require_once($tcpdf_include_path);
		break;
	}
}

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Clipping
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
//require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
//$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetAuthor('Justin');
//$pdf->SetTitle('Star Vector Path');
//$pdf->SetSubject('Star Vector Path captrured');
//$pdf->SetKeywords('star, vector, path');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 034', PDF_HEADER_STRING);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
//$pdf->SetFont('helvetica', 'B', 20);

// add a page
$pdf->AddPage();

//$pdf->Write(0, 'Image Clipping using geometric functions', '', 0, 'C', 1, 0, false, false, 0);
$content = file_get_contents('star.svg');

$pdf->writeHTML($content, true, false, true, false, '');
//Start Graphic Transformation
//$pdf->StartTransform();

// set clipping mask
//$pdf->StarPolygon(105, 100, 30, 10, 3, 0, 1, 'CNZ');

// draw jpeg image to be clipped
//$pdf->Image('output/starimage.png', 0, 0, 210, 200, '', 'http://www.tcpdf.org', '', true, 72);

//Stop Graphic Transformation
//$pdf->StopTransform();

// ---------------------------------------------------------
/*$x=$pdf->getImageRBX();
//var_dump($x);
$y=$pdf->getImageRBY();
//var_dump($y);
$pdf->getImageScale();


$data=pdf_get_value($pdf,'image',0);
*/

//Close and output PDF document
$pdf->Output(__DIR__.'/output/example_034.pdf', 'F');

//============================================================+
// END OF FILE
//============================================================+