<?php
function system_log( $text ) {

	$file_name = __DIR__ . DIRECTORY_SEPARATOR . 'log.txt';

	$file = fopen( $file_name, "a" );

	$cur_Date = date( 'Y-m-d H:i:s' );

	$location = '';
	if ( is_array( $text ) ) {
		$text = 'Array => ' . json_encode( $text );
	}
	$text = $cur_Date . ' => ' . $location . '  Log = "' . $text . '"; ' . PHP_EOL;

	fwrite( $file, $text );

}

if ( ! empty( $_POST ) ) {

	system_log( $_POST );
}

if ( ! empty( $_GET ) ) {
	system_log( $_GET );
}