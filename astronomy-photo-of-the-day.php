<?php
/**
 * Plugin Name:     NASA Astronomy Picture Of The Day
 * Description:     A block for WordPress that will let you display NASA's Astronomy Picture of the Day on your website.
 * Version:         0.2.0
 * Author:          Jeffrey de Wit
 * License:         GPL-2.0-or-later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     cheffism-apod
 *
 * @package         Cheffism\AstronomyPictureOfTheDay
 */

namespace Cheffism\AstronomyPictureOfTheDay;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

require plugin_dir_path( __FILE__ ) . 'functions.php';
require plugin_dir_path( __FILE__ ) . 'settings/apod-settings.php';

/**
 * Registers the block with the block.json in the /build folder.
 * Also runs wp_localize_script on the editor script to make the API key available to the editor.
 *
 * @return void
 */
function register_apod_block() {
	register_block_type( __DIR__ . '/build' );

	wp_localize_script(
		'cheffism-astronomy-picture-of-the-day-editor-script',
		'apod',
		array(
			'api_key'       => get_option( 'apod_api_key' ),
			'api_key_error' => esc_html__( 'This block requires an API key to be set up. Please ensure that you have one set up on the settings page.', 'cheffism-apod' ),
		)
	);
}
add_action( 'init', __NAMESPACE__ . '\register_apod_block' );
