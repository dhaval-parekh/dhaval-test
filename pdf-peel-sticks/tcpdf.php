<?php
include 'functions.php';
require_once 'libs/tcpdf/tcpdf.php';
require_once 'libs/tcpdf/tcpdf_import.php';

// Files
$input_file = 'files/input.pdf';
$output_file = 'files/output.pdf';

echo '<pre>';
$pdf = new TCPDF_IMPORT();
$pdf->importPDF( $input_file );

//display( $pdf );
