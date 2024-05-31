const { __ } = wp.i18n;
const { BlockControls } = wp.blockEditor;
const { DropdownMenu, MenuGroup, MenuItem, ToolbarGroup } = wp.components;

import "./ImageAlignmentOptions.css";

const ImageAlignmentOptions = (props) => {
	const { attributes, setAttributes } = props;
	const { imageAlignment } = attributes;

	const alignments = [
		{
			key: "left",
			label: __("Left", "cheffism-apod"),
			icon: "align-left",
		},
		{
			key: "center",
			label: __("Center", "cheffism-apod"),
			icon: "align-center",
		},
		{
			key: "right",
			label: __("Right", "cheffism-apod"),
			icon: "align-right",
		},
	];

	return (
		<BlockControls group="other">
			<ToolbarGroup>
				<DropdownMenu
					icon={<span>{__("Image Alignment", "cheffism-apod")}</span>}
					label={__("Change Image Alignment", "cheffism-apod")}
				>
					{({ onClose }) => (
						<MenuGroup className="custom-image-alignment-menu">
							{alignments.map((alignmentOption) => {
								return (
									<MenuItem
										icon={alignmentOption.icon}
										isSelected={
											imageAlignment === alignmentOption.key ? true : false
										}
										iconPosition="left"
										className={
											imageAlignment === alignmentOption.key ? "is-active" : ""
										}
										role="menuitemradio"
										onClick={() => {
											setAttributes({ imageAlignment: alignmentOption.key });
											onClose();
										}}
									>
										{alignmentOption.label}
									</MenuItem>
								);
							})}
						</MenuGroup>
					)}
				</DropdownMenu>
			</ToolbarGroup>
		</BlockControls>
	);
};

export default ImageAlignmentOptions;
