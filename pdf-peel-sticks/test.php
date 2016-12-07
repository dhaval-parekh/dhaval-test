<?php

$image = new Imagick( "frame.png" );

//Get all pixels of image.
$imageIterator = $image->getPixelIterator();

$prevrow = -1;
$is_found_last_plot = false;
$transparent_plots = array();
foreach ( $imageIterator as $row => $pixels ) {
	foreach ( $pixels as $column => $pixel ) {
		$colorInfo = $pixel->getColor();
		if ( !empty( $pixel ) || is_array( $colorInfo ) ) {
			//Check whether current pixel is transparent or not.
			if ( empty( $colorInfo['a'] ) && $row != $prevrow ) {
				$transparent_plots[] = array( "row"	 => $row,
					"column" => $column );
				$prevrow = $row;
			} elseif ( !empty( $colorInfo['a'] ) && $row == $prevrow && !$is_found_last_plot ) {
				$transparent_plots[] = array( "row"	 => $row,
					"column" => $column - 1 );
				$is_found_last_plot = true;
			}
		}
	}
	$prevrow = -1;
	$is_found_last_plot = false;
	$imageIterator->syncIterator();
}

//Get plots to set corners.
if ( is_array( $transparent_plots ) && count( $transparent_plots ) >= 4 ) {
	$plots[] = $transparent_plots[0];
	$plots[] = $transparent_plots[1];
	$plots[] = $transparent_plots[count( $transparent_plots ) - 1];
	$plots[] = $transparent_plots[count( $transparent_plots ) - 2];
}

echo '<pre>';
print_r( $plots );
echo '</pre>';
