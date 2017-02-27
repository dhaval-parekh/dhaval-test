<?php

//$url = 'http://localhost:8888/dhaval-web/dhaval-test/svg-template/frontend/img/4-Nature-Wallpapers.jpg';
//$data = file_get_contents( $url );
//$data = base64_encode($data);
//$data = 'data:image/jpg;base64,' . $data;
//die($data);
////$data = imagecreatefromstring( $data );
//$svg = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" id="Layer_1" x="0px" y="0px" width="1424" height="600" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve"><defs><pattern id="img1" x="360" y="-260" width="1600" height="900" patternUnits="userSpaceOnUse" style=""><image x="0" y="0" width="1600" height="900" href="'.$data.'" xmlns:a0="http://www.w3.org/1999/xlink"/></pattern></defs>
//<polygon id="star" fill="url(&quot;#img1&quot;)" stroke="#000000" stroke-miterlimit="10" points="500,90.2 633.2,360 930.9,403.3 715.4,613.3 766.3,909.8   500,769.8 233.7,909.8 284.6,613.3 69.1,403.3 366.8,360 "/>
//</svg>';
//$file = fopen('custom.svg', 'w');
//fwrite($file, $svg);
//echo $svg;
// always load alternative config file for examples
require_once('TCPDF/config/tcpdf_config.php');
$tcpdf_include_dirs = array(
	realpath( 'TCPDF/tcpdf.php' ),
	'/usr/share/php/tcpdf/tcpdf.php',
	'/usr/share/tcpdf/tcpdf.php',
	'/usr/share/php-tcpdf/tcpdf.php',
	'/var/www/tcpdf/tcpdf.php',
	'/var/www/html/tcpdf/tcpdf.php',
	'/usr/local/apache2/htdocs/tcpdf/tcpdf.php'
);
foreach ( $tcpdf_include_dirs as $tcpdf_include_path ) {
	if ( @file_exists( $tcpdf_include_path ) ) {
		require_once($tcpdf_include_path);
		break;
	}
}
// create new PDF document
$pdf = new TCPDF( PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false );

// remove default header/footer
$pdf->setPrintHeader( false );
$pdf->setPrintFooter( false );

// add a page
$pdf->AddPage();
//$html = file_get_contents( 'star.svg' );
// output the HTML content
//$pdf->ImageSVG( $file = 'star.svg', $x = 0, $y = 0, $w = '300px', $h = '300px', $link = '', $align = '', $palign = '', $border = 1, $fitonpage = false );
//$pdf->setRasterizeVectorImages(true);
$pdf->setImageScale( PDF_IMAGE_SCALE_RATIO );

$pdf->ImageSVG( 'output-example-2.svg', 0, 0, 210, 210, '', '', '', 0, false );

//$pdf->writeHTML( $html, true, false, true, false, '' );
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// reset pointer to the last page
//$pdf->lastPage();
// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output( 'test.pdf', 'I' );
