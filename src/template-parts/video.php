<?php
/**
 * Sometimes the APOD is a Video. Used in render_astronomy_picture_of_the_day().
 *
 * @package Cheffism\AstronomyPictureOfTheDay
 */

$embed_wrap_class = 'cheffism-apod__video-wrap';

if ( strpos( $picture_url, '/embed' ) ) {
	$youtube_embed     = sprintf( '<iframe src="%s" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>', $picture_url );
	$embed_wrap_class .= ' manual-embed';
} else {
	$youtube_embed = wp_oembed_get( $picture_url );
}
?>
<div class="cheffism-apod">
	<div class="<?php echo esc_attr( $embed_wrap_class ); ?>">
		<?php
			echo wp_kses(
				$youtube_embed,
				array(
					'iframe' => array(
						'src'             => array(),
						'frameborder'     => array(),
						'allowfullscreen' => array(),
						'allow'           => array(),
					),
				)
			);
			?>
	</div>
</div>
