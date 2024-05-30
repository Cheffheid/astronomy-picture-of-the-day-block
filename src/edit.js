/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from "@wordpress/block-editor";
import { Spinner } from "@wordpress/components";
import { useState } from "@wordpress/element";

import getPictureOfTheDay from "./api";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit() {
	const [pictureURL, setpictureURL] = useState("");
	const [mediaType, setMediaType] = useState("image");

	if (!pictureURL) {
		getPictureOfTheDay(apod.api_key).then((pictureData) => {
			setpictureURL(pictureData.url);
			setMediaType(pictureData.media_type);
		});
	}

	let blockContent = <Spinner />;

	if (pictureURL) {
		if ("vide0" === mediaType) {
			blockContent = (
				<iframe
					src={pictureURL}
					width="610"
					height="343"
					frameborder="0"
					allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
					allowfullscreen
				></iframe>
			);
		} else {
			blockContent = <img src={pictureURL} alt="" />;
		}
	}

	return <p {...useBlockProps()}>{blockContent}</p>;
}
