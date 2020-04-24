<?php
/**
 * Sometimes the APOD is a Video. Used in render_astronomy_picture_of_the_day().
 *
 * @package Cheffism\AstronomyPictureOfTheDay
 */

$manual_embed = false;

if ( strpos( $picture_url, '/embed' ) ) {
	$youtube_embed = sprintf( '<iframe src="%s" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>', $picture_url );
	$manual_embed  = true;
} else {
	$youtube_embed = wp_oembed_get( $picture_url );
}
?>
<div class="astronomy-picture-of-the-day">
	<?php if ( $manual_embed ) : ?>
	<style>
		.astronomy-picture-of-the-day__video-wrap {
			overflow: hidden;
			position: relative;
			padding-bottom: 56.25%; /* proportion value to aspect ratio 16:9 (9 / 16 = 0.5625 or 56.25%) */
		}

		.astronomy-picture-of-the-day__video-wrap iframe {
			height: 100%;
			left: 0;
			position: absolute;
			top: 0;
			width: 100%;
		}
	</style>
	<? endif; ?>

	<div class="astronomy-picture-of-the-day__video-wrap">
		<?php
			echo wp_kses(
				$youtube_embed,
				array(
					'iframe' => array(
						'src'             => array(),
						'frameborder'     => array(),
						'allowfullscreen' => array(),
						'allow'           => array(),
					)
				)
			);
		?>
	</div>
</div>
