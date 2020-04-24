import getPictureOfTheDay from '../api';

const { Spinner } = wp.components;
const { Component, Fragment } = wp.element;

export default class AstronomyPictureEdit extends Component {
	constructor() {
		super( ...arguments );

		this.state = {
			pictureURL: null,
		};
	}

	componentDidMount() {
		if ( ! apod.api_key ) {
			return;
		}

		getPictureOfTheDay( apod.api_key )
			.then( ( pictureURL ) => {
				this.setState( {
					pictureURL: pictureURL
				} )
			} );
	}

	render() {
		const { pictureURL } = this.state;

		if ( ! apod.api_key ) {
			return (
				<Fragment>
					<p>{ apod.api_key_error }</p>
				</Fragment>
			)
		}

		if ( ! pictureURL ) {
			return <Spinner />;
		}

		if ( this.is_youtube_url( pictureURL ) ) {
			return (
				<Fragment>
					<iframe src={ pictureURL } width="610" height="343" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</Fragment>
			);
		}

		return (
			<Fragment>
				<img src={ pictureURL } alt="" />
			</Fragment>
		)

	}

	is_youtube_url( url = '' ) {
		if ( ! url || '' === url ) {
			return false;
		}

		const regex = new RegExp( '^https?:\/\/(?:www\.)?youtube.com', 'gi' );

		return Array.isArray( url.match( regex ) );
	}
}
