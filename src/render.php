<?php

namespace Cheffism\AstronomyPictureOfTheDay;

$picture_data = retrieve_astronomy_picture_of_the_day();

if ( is_wp_error( $picture_data ) ) {
	return '';
}

// Use the SD version by default.
$picture_url = $picture_data->url;

if ( 'video' === $picture_data->media_type ) {
	require __DIR__ . '/template-parts/youtube-video.php';
}

if ( 'image' === $picture_data->media_type ) {
	require __DIR__ . '/template-parts/image.php';
}
