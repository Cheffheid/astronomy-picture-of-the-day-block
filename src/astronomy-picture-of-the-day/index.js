const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

registerBlockType(
	'cheffism/astronomyblockoftheday',
	{
		title: __( 'NASA Astronomy Picture of the Day', 'astronomy-picture-of-the-day' ),
		description: __( 'A block that will let you display NASA\'s Astronomy Picture of the Day on your website.', 'astronomy-picture-of-the-day' ),
		category: 'widgets',
		edit: props => {
			return (
				<div>
					<p>Astronomy Picture of the Day</p>
				</div>
			)
		},
		save: props => {
			return (
				<div>
					<p>Astronomy Picture of the Day</p>
				</div>
			)
		}
	}
);
