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
import { useState, useEffect } from "@wordpress/element";

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
	const [pictureData, setPictureData] = useState({
		copyright: "",
		date: "",
		explanation: "",
		hdurl: "",
		media_type: "",
		service_version: "",
		title: "",
		url: "",
		isLoading: true,
	});

	useEffect(() => {
		getPictureOfTheDay().then((imageData) => {
			setPictureData({
				isLoading: false,
				...imageData,
			});
		});
	}, []);

	let blockContent = <Spinner />;

	if (!pictureData.isLoading) {
		if ("video" === pictureData.media_type) {
			blockContent = (
				<div class="cheffism-apod">
					<div class="cheffism-apod__video-wrap">
						<iframe
							src={pictureData.url}
							width="610"
							height="343"
							frameborder="0"
							allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
							allowfullscreen
						></iframe>
					</div>
				</div>
			);
		} else {
			blockContent = (
				<p class="cheffism-apod">
					<img src={pictureData.url} alt="" />
				</p>
			);
		}
	}

	return <section {...useBlockProps()}>{blockContent}</section>;
}
