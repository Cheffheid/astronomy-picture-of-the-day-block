<?php
/**
 * API Related functions.
 *
 * @package Cheffism\AstronomyPictureOfTheDay
 */

namespace Cheffism\AstronomyPictureOfTheDay;

/**
 * Handles requests for our custom API endpoint.
 *
 * @return array Photo data retrieved from NASA's Astronomy Photo of the Day API.
 */
function astronomy_photo_of_the_day_rest_api_handler() {
	$photo_data = retrieve_astronomy_picture_of_the_day();

	return $photo_data;
}

/**
 * Initialize our custom API endpoint.
 *
 * @return void
 */
function astronomy_photo_of_the_day_rest_api_init() {
	register_rest_route(
		'cheffism/v1',
		'/apod',
		array(
			'methods'             => \WP_REST_Server::READABLE,
			'callback'            => __NAMESPACE__ . '\astronomy_photo_of_the_day_rest_api_handler',
			'permission_callback' => '__return_true',
		),
		false
	);
}
add_action( 'rest_api_init', __NAMESPACE__ . '\astronomy_photo_of_the_day_rest_api_init' );
