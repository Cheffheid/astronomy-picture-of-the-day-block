<?php
/**
 * Utility functions for this block.
 *
 * @package Cheffism\AstronomyPictureOfTheDay
 */

namespace Cheffism\AstronomyPictureOfTheDay;

/**
 * Retrieve the picture of the day data. This will either retrieve the data from the transient if it's set,
 * or retrieve fresh data from the API.
 *
 * @return Object|WP_Error Returns the API data from a transient or the NASA API, or a WP_Error if something went wrong.
 */
function retrieve_astronomy_picture_of_the_day() {
	$today          = gmdate( 'Y-m-d' );
	$apod_transient = get_transient( 'apod-' . $today );

	if ( ! $apod_transient ) {
		return retrieve_astronomy_picture_of_the_day_api_data();
	}

	return $apod_transient;
}

/**
 * Retrieve the picture of the day data from the API and save the data to a transient.
 *
 * @return Object|WPError Returns the API data from the NASA API, or a WP_Error if something went wrong.
 */
function retrieve_astronomy_picture_of_the_day_api_data() {
	$api_key = get_option( 'apod_api_key' );

	if ( ! $api_key ) {
		return new \WP_Error( 403, esc_html__( 'This block requires an API key to be set up. Please ensure that you have one set up on the settings page.', 'cheffism-apod' ) );
	}

	$remote_url = 'https://api.nasa.gov/planetary/apod?api_key=' . $api_key;

	$response      = wp_remote_get( $remote_url );
	$response_body = json_decode( $response['body'] );

	if ( 200 !== $response['response']['code'] ) {
		return new \WP_Error( $response_body->error->code, $response_body->error->message );
	}

	save_astronomy_picture_of_the_day_api_data( $response_body );

	return $response_body;
}

/**
 * Save API response data to a transient for 24 hours.
 *
 * @param Object $api_data Object of API data that should be stored.
 * @return boolean|WP_Error Returns true if set_transient was successful, WP_Error if it was not.
 */
function save_astronomy_picture_of_the_day_api_data( $api_data ) {
	$data_saved = set_transient( 'apod-' . $api_data->date, $api_data, 24 * HOUR_IN_SECONDS );

	if ( ! $data_saved ) {
		return new \WP_Error( 500, esc_html__( 'Failed to set transient with API data.', 'cheffism-apod' ) );
	}

	return $data_saved;
}
