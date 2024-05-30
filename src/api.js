/**
 * Retrieve the Astronomy Picture of the Day in HD.
 *
 * @param {string} apiKey NASA API Key. Register at https://api.nasa.gov/.
 */
const getPictureOfTheDay = async (apiKey) => {
	const response = await fetch(
		`https://api.nasa.gov/planetary/apod?api_key=${apiKey}`,
	);
	const imageData = await response.json();

	return imageData;
};

export default getPictureOfTheDay;
