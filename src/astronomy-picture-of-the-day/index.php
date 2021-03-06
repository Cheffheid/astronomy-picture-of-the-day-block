<?php
/**
 * Astronomy Picture of the Day frontend PHP.
 *
 * @package Cheffism\AstronomyPictureOfTheDay
 */

namespace Cheffism\AstronomyPictureOfTheDayBlock;

use WP_Error;

/**
 * Frontend callback for rendering this block.
 *
 * @param array $attributes Array of the block's saved attributes.
 * @return string HTML markup for the block's frontend.
 */
function render_astronomy_picture_of_the_day() {
	$picture_data = retrieve_astronomy_picture_of_the_day();

	if ( is_wp_error( $picture_data ) ) {
		return '';
	}

	// Use the SD version by default.
	$picture_url = $picture_data->url;

	ob_start();

	// If there is no hdurl and the url is YouTube, then the APOD is most likely a video instead.
	if ( ! property_exists( $picture_data, 'hdurl' ) && is_youtube_url( $picture_url ) ) {
		require dirname( __FILE__ ) . '/template-parts/youtube-video.php';

		return ob_get_clean();
	}

	// If there is a hdurl, and it's not a video, then reset the picture_url to the hd variant.
	if ( property_exists( $picture_data->hdurl ) ) {
		$picture_url = $picture_data->hdurl;
	}

	require dirname( __FILE__ ) . '/template-parts/image.php';
	return ob_get_clean();
}


/**
 * Retrieve the picture of the day data. This will either retrieve the data from the transient if it's set,
 * or retrieve fresh data from the API.
 *
 * @return WPError|Object Returns a WP_Error with API error details, or an object with all the API data.
 */
function retrieve_astronomy_picture_of_the_day() {
	$today          = date( 'Y-m-d' );
	$apod_transient = get_transient( 'apod-' . $today );

	if ( ! $apod_transient ) {
		return retrieve_astronomy_picture_of_the_day_api_data();
	}

	return $apod_transient;
}


/**
 * Retrieve the picture of the day data from the API.
 *
 * @return WPError|Object Returns a WP_Error with API error details, or an object with all the API data.
 */
function retrieve_astronomy_picture_of_the_day_api_data() {
	$api_key    = 'DEMO_KEY';
	$remote_url = 'https://api.nasa.gov/planetary/apod?api_key=' . $api_key;

	$response      = wp_remote_get( $remote_url );
	$response_body = json_decode( $response['body'] );

	if ( 200 !== $response['response']['code'] ) {
		return new WP_Error( $response_body->error->code, $response_body->error->message );
	}

	save_astronomy_picture_of_the_day_api_data( $response_body );

	return $response_body;
}


/**
 * Save API response data to a transient for 24 hours.
 *
 * @param Object $api_data Object of API data that should be stored.
 * @return void
 */
function save_astronomy_picture_of_the_day_api_data( $api_data ) {
	set_transient( 'apod-' . $api_data->date, $api_data, 24 * HOUR_IN_SECONDS );
}

/**
 * Check if a URL is a YouTube URL.
 *
 * @param string $url URL string.
 * @return Boolean Returns true if the string contains youtube.com.
 */
function is_youtube_url( $url = '' ) {

	if ( ! $url || empty( $url ) ) {
		return false;
	}

	return preg_match( '#^https?://(?:www\.)?youtube.com#', $url );
}
