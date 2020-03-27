import getPictureOfTheDay from './api';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { Spinner } = wp.components;
const { Component, Fragment } = wp.element;

registerBlockType(
	'cheffism/astronomyblockoftheday',
	{
		title: __( 'NASA Astronomy Picture of the Day', 'astronomy-picture-of-the-day' ),
		description: __( 'A block that will let you display NASA\'s Astronomy Picture of the Day on your website.', 'astronomy-picture-of-the-day' ),
		category: 'widgets',
		edit: class extends Component {
			constructor() {
				super( ...arguments );

				this.state = {
					pictureURL: null,
				};
			}

			componentDidMount() {
				getPictureOfTheDay( 'DEMO_KEY' )
					.then( ( pictureURL ) => {
						this.setState( {
							pictureURL: pictureURL
						} )
					} );
			}

			render() {
				const { pictureURL } = this.state;

				if ( ! pictureURL ) {
					return <Spinner />;
				}

				return (
					<Fragment>
						<img src={ pictureURL } alt="" />
					</Fragment>
				)
			}
		},
		save: props => {
			return null;
		}
	}
);
