<?php
/**
 * Image template part used in render_astronomy_picture_of_the_day().
 *
 * @package Cheffism\AstronomyPictureOfTheDay
 */

?>

<p class="cheffism-apod">
	<img
		class="cheffism-apod__image"
		src="<?php echo esc_url( $picture_url ); ?>"
		alt=""
	/>
</p>
