<?php

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

	ob_start();
	?>

	<p class="astronomy-picture-of-the-day">
		<img src="<?php echo esc_url( $picture_data->hdurl ); ?>" alt="" />
	</p>

	<?php
	return ob_get_clean();
}


/**
 * Retrieve the picture of the day URL.
 *
 * @return WPError|Object Returns a WP_Error with API error details, or an object with all the API data.
 */
function retrieve_astronomy_picture_of_the_day() {
	$today          = date( 'Y-m-d' );
	$apod_transient = get_transient( 'apod-' . $today );

	if ( ! $apod_transient ) {
		$picture_data = retrieve_astronomy_picture_of_the_day_api_data();

		if ( ! is_wp_error( $picture_data ) ) {
			set_transient( 'apod-' . $today, $picture_data, 24 * HOUR_IN_SECONDS );
		}

		return $picture_data;
	}

	return $apod_transient;
}

function retrieve_astronomy_picture_of_the_day_api_data() {
	$api_key    = 'DEMO_KEY';
	$remote_url = 'https://api.nasa.gov/planetary/apod?api_key=' . $api_key;

	$response      = wp_remote_get( $remote_url );
	$response_body = json_decode( $response['body'] );

	if ( 200 !== $response['response']['code'] ) {
		return new WP_Error( $response_body->error->code, $response_body->error->message );
	}

	return $response_body;
}
