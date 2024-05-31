import apiFetch from "@wordpress/api-fetch";

/**
 * Retrieve the Astronomy Picture of the Day data.
 */
const getPictureOfTheDay = async () => {
	const imageData = await apiFetch({
		path: "cheffism/v1/apod",
	});

	return imageData;
};

export default getPictureOfTheDay;
