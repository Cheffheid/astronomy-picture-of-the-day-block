<?php
/**
 * Astronomy Picture of the Day settings page.
 *
 * @package Cheffism\AstronomyPictureOfTheDay
 */

/**
 * Add menu item for the APOD settings.
 *
 * @return void
 */
function create_apod_settings_menu() {
	$page_title = esc_html__( 'Astronomy Picture of the Day', 'astronomy-picture-of-the-day' );
	$menu_title = esc_html__( 'APOD Settings', 'astronomy-picture-of-the-day' );
	$capability = 'manage_options';
	$slug       = 'apod_fields';
	$callback   = 'render_apod_settings_page';

	add_submenu_page( 'options-general.php', $page_title, $menu_title, $capability, $slug, $callback );
}
add_action( 'admin_menu', 'create_apod_settings_menu' );

/**
 * Register settings sections.
 *
 * @return void
 */
function register_apod_settings() {

	add_settings_section(
		'apod_api_settings',
		esc_html__( 'API Settings', 'astronomy-picture-of-the-day' ),
		'render_apod_api_settings_section',
		'apod_fields'
	);

	add_settings_field(
		'apod_api_key',
		esc_html__( 'API Key', 'astronomy-picture-of-the-day' ),
		'render_apod_api_key_field',
		'apod_fields',
		'apod_api_settings'
	);

	register_setting( 'apod_fields', 'apod_api_key' );
}
add_action( 'admin_init', 'register_apod_settings' );


/**
 * Render the settings page markup.
 *
 * @return void
 */
function render_apod_settings_page() {
	?>

	<div class="wrap">
		<h1>
			<?php esc_html_e( 'Astronomy Picture of the Day Settings', 'astronomy-picture-of-the-day' ); ?>
		</h1>
		<form method="post" action="options.php">
			<?php
				settings_fields( 'apod_fields' );
				do_settings_sections( 'apod_fields' );
				submit_button();
			?>
		</form>
	</div>

	<?php
}

/**
 * Render the API Key settings section.
 *
 * @return void
 */
function render_apod_api_settings_section() {
	$link_html = '<a href="https://api.nasa.gov/">https://api.nasa.gov/</a>'
	?>
	<p>
		<?php
			/* translators: The wildcard will render to an anchor tag that will link to the NASA website. */
			printf(
				esc_html__( 'You can read more about the restrictions for the API, as well as register for an API key, at %1$s.', 'astronomy-picture-of-the-day' ),
				$link_html
			);
		?>
	</p>
	<?php
}

function render_apod_api_key_field( $arguments ) {
	?>
	<input
		name="apod_api_key"
		id="apod_api_key"
		type="text"
		value="<?php echo esc_attr( get_option( 'apod_api_key' ) ); ?>"
	/>
	<?php
}
