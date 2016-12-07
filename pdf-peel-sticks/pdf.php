<?php

error_reporting( -1 );
// Include 'Composer' autoloader.
include 'vendor/autoload.php';
include 'functions.php';
// Files
$input_file = 'files/input.pdf';
$output_file = 'files/output.pdf';



// Parse pdf file and build necessary objects.
$parser = new \Smalot\PdfParser\Parser();
$pdf = $parser->parseFile( $input_file );
$text = $pdf->getText();

$pages = $pdf->getPages() ;
foreach( $pages as $page ){
//	display( $page->getDetails( true) );
//	display( $page->getContent() );
}
display( PDF_closepath_stroke( $input_file ) );
//display($pdf->getPages());
