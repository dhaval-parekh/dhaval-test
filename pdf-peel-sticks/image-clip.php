<?php
include 'functions.php';
require_once 'libs/tcpdf/tcpdf.php';
//display( ( 9 % 8) );
//die( );
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// add a page
$pdf->AddPage();

$pdf->Write(0,'header', 'Image cliping', false, 0, 'J', 1, 0, false, false, 0);

//Start Graphic Transformation
$pdf->StartTransform();

// set clipping mask
$pdf->StarPolygon(105, 100, 75, 7, 11, 180, false, 'CNZ' );

// draw jpeg image to be clipped
$pdf->Image('files/img-2.jpg', 30, 25, 150, 150, '', 'http://www.tcpdf.org', '', true, 72);
//Stop Graphic Transformation
$pdf->StopTransform();



//Close and output PDF document
$pdf->Output('image-clip.pdf');