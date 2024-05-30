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

require plugin_dir_path( __FILE__ ) . 'src/astronomy-picture-of-the-day/index.php';
require plugin_dir_path( __FILE__ ) . 'settings/apod_settings.php';

/**
 * Register the block with WordPress.
 *
 * @author Cheffism
 * @since 0.0.1
 */
function register_block() {

	// Define our assets.
	$editor_script   = 'build/index.js';
	$editor_style    = 'build/editor.css';
	$frontend_style  = 'build/style.css';
	$frontend_script = 'build/frontend.js';

	// Verify we have an editor script.
	if ( ! file_exists( plugin_dir_path( __FILE__ ) . $editor_script ) ) {
		wp_die( esc_html__( 'Whoops! You need to run `npm run build` for the Cheffism Astronomy Picture Of The Day first.', 'cheffism-apod' ) );
	}

	// Autoload dependencies and version.
	$asset_file = require plugin_dir_path( __FILE__ ) . 'build/index.asset.php';

	// Register editor script.
	wp_register_script(
		'cheffism-apod-editor-script',
		plugins_url( $editor_script, __FILE__ ),
		$asset_file['dependencies'],
		$asset_file['version'],
		true
	);

	wp_localize_script(
		'cheffism-apod-editor-script',
		'apod',
		array(
			'api_key'       => get_option( 'apod_api_key' ),
			'api_key_error' => esc_html__( 'This block requires an API key to be set up. Please ensure that you have one set up on the settings page.', 'cheffism-apod' )
		)
	);

	// Register editor style.
	if ( file_exists( plugin_dir_path( __FILE__ ) . $editor_style ) ) {
		wp_register_style(
			'cheffism-apod-editor-style',
			plugins_url( $editor_style, __FILE__ ),
			[ 'wp-edit-blocks' ],
			filemtime( plugin_dir_path( __FILE__ ) . $editor_style )
		);
	}

	// Register frontend style.
	if ( file_exists( plugin_dir_path( __FILE__ ) . $frontend_style ) ) {
		wp_register_style(
			'cheffism-apod-style',
			plugins_url( $frontend_style, __FILE__ ),
			[],
			filemtime( plugin_dir_path( __FILE__ ) . $frontend_style )
		);
	}

	// Register block with WordPress.
	register_block_type( 'cheffism/astronomy-picture-of-the-day', array(
		'editor_script'   => 'cheffism-apod-editor-script',
		'editor_style'    => 'cheffism-apod-editor-style',
		'style'           => 'cheffism-apod-style',
		'render_callback' => '\\Cheffism\\AstronomyPictureOfTheDayBlock\\render_astronomy_picture_of_the_day',
	) );

	// Register frontend script.
	if ( file_exists( plugin_dir_path( __FILE__ ) . $frontend_script ) ) {
		wp_enqueue_script(
			'cheffism-apod-frontend-script',
			plugins_url( $frontend_script, __FILE__ ),
			$asset_file['dependencies'],
			$asset_file['version'],
			true
		);
	}
}
add_action( 'init', __NAMESPACE__ . '\register_block' );
