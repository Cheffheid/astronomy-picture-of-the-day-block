<?php
/**
 * Server side render template for the block.
 *
 * @package Cheffism\AstronomyPictureOfTheDay
 */

namespace Cheffism\AstronomyPictureOfTheDay;

$picture_data = retrieve_astronomy_picture_of_the_day();

if ( is_wp_error( $picture_data ) ) {
	return '';
}

// Use the SD version by default.
$picture_url        = $picture_data->url;
$media_include_file = __DIR__ . '/template-parts/' . $picture_data->media_type . '.php';

if ( file_exists( $media_include_file ) ) {
	require $media_include_file;
}
