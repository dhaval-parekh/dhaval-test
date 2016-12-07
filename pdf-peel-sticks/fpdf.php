<?php

include 'functions.php';
require_once 'libs/tcpdf/tcpdf.php';
require_once 'libs/fpdf/fpdf.php';
require_once 'libs/fpdi/fpdi.php';


// Files
$input_file = 'files/input.pdf';
$output_file = 'files/output.pdf';

$fpdf = new FPDF();


$fpdi = new FPDI();
$pageCount = $fpdi->setSourceFile( $input_file );
display( $fpdi );
//display( $pageCount );
//$tplIdx = $pdf->importPage( 1, '/MediaBox' );
