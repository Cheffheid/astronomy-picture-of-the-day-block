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

		return (
			<Fragment>
				<img src={ pictureURL } alt="" />
			</Fragment>
		)
	}
}
