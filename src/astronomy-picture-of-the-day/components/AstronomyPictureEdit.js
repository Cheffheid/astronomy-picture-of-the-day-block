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
}
