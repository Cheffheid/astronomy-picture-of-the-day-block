<?php
/**
 * Image template part used in render_astronomy_picture_of_the_day().
 *
 * @package Cheffism\AstronomyPictureOfTheDay
 */

$image_align_class = 'align' . $attributes['imageAlignment'];
$image_wrap_class  = 'cheffism-apod ' . $image_align_class;


?>

<p class="<?php echo esc_attr( $image_wrap_class ); ?>">
	<img
		class="cheffism-apod__image"
		src="<?php echo esc_url( $picture_url ); ?>"
		alt=""
	/>
</p>
