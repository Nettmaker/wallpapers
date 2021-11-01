<?php

$months = [];

foreach( glob( './*.jpg' ) as $file ) {

	// Name of the file
	$base_file = basename( $file );

	// Name of the file without extension
	$filename = pathinfo( $file, PATHINFO_FILENAME);

	// The month in the filename
	$month = str_replace( '-portrait', '', $filename );

	// Convert it to a date
	$date = date_create_from_format( 'Y-m', $month );

	// Ignore if we can't parse the date
	if( !$date ) {
		continue;
	}

	// Create the array
	if( !isset( $months[ $month ] ) ) {
		$months[ $month ] = [
			'portrait' => false,
			'landscape' => false
		];
	}

	// Get image dimensions
	list($width, $height) = getimagesize( $file );
	
	// Check if it is portrait image
	if( $width < $height ) {
		$months[ $month ]['portrait'] = $base_file;
	} else {
		$months[ $month ]['landscape'] = $base_file;
	}
}

// Save the json file
file_put_contents( 'wallpapers.json', json_encode( $months, JSON_PRETTY_PRINT ) );

echo "All done :)" . PHP_EOL;