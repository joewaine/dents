<?php
/*---------------------------------------------------------------*/
/* Register shortcode within Visual Composer interface
/*---------------------------------------------------------------*/

add_action( 'init', 'collars_vc_map' );
function collars_vc_map() {

	$add_css_animation = array(
		'type' => 'dropdown',
		'heading' => __( 'CSS Animation', 'core-extension' ),
		'param_name' => 'css_animation',
		'admin_label' => true,
		'value' => array(
			__( 'No', 'core-extension' ) => '',
			__( 'Top to bottom', 'core-extension' ) => 'top-to-bottom',
			__( 'Bottom to top', 'core-extension' ) => 'bottom-to-top',
			__( 'Left to right', 'core-extension' ) => 'left-to-right',
			__( 'Right to left', 'core-extension' ) => 'right-to-left',
			__( 'Appear from center', 'core-extension' ) => "appear"
		),
		'description' => __( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'core-extension' ),
		"group" => __('Misc', 'core-extension')
	);

	$add_css_animation_delay = array(
		"type" => "dropdown",
		"heading" => __('CSS Animation Delay', 'core-extension'),
		"param_name" => "css_animation_delay",
		"value" => array(
			'0ms' => '', 
			'100ms' => 'delay-100', 
			'200ms' => 'delay-200', 
			'300ms' => 'delay-300', 
			'400ms' => 'delay-400', 
			'500ms' => 'delay-500', 
			'600ms' => 'delay-600', 
			'700ms' => 'delay-700', 
			'800ms' => 'delay-800', 
			'900ms' => 'delay-900', 
			'1000ms' => 'delay-1000', 
			'1100ms' => 'delay-1100', 
			'1200ms' => 'delay-1200', 
			'1300ms' => 'delay-1300', 
			'1400ms' => 'delay-1400', 
			'1500ms' => 'delay-1500', 
			'1600ms' => 'delay-1600',
			'1700ms' => 'delay-1700',
			'1800ms' => 'delay-1800', 
			'1900ms' => 'delay-1900', 
			'2000ms' => 'delay-2000'
		),
		"dependency" => Array('element' => "css_animation", 'not_empty' => true),
		"group" => __('Misc', 'core-extension')
	);

	$add_icon_animation = array(
		'type' => 'dropdown',
		'heading' => __( 'Icon Animation', 'core-extension' ),
		'param_name' => 'icon_animation',
		'admin_label' => true,
		'value' => array(
			__( 'No animation', 'core-extension' ) => '',
			__( 'To full opacity', 'core-extension' ) => 'ha_full-opacity',
			__( 'Scale up', 'core-extension' ) => 'ha_scale',
			__( 'Bounce', 'core-extension' ) => 'ha_bounce',
			__( 'Shake', 'core-extension' ) => 'ha_shake',
			__( 'Swing', 'core-extension' ) => 'ha_swing',
			__( 'Tada', 'core-extension' ) => 'ha_tada',
			__( 'Wobble', 'core-extension' ) => 'ha_wobble',
			__( 'Pulse', 'core-extension' ) => 'ha_pulse'
		),
		'description' => __( 'Select type of animation for the icon when element is hovered. Note: Works only in modern browsers.', 'core-extension' ),
		"group" => __('Misc', 'core-extension')
	);


	// Section
	vc_map( array(
		'name' => __( 'Section', 'core-extension' ),
		'is_container' => true,
		'icon' => 'vc_icon-vc-section',
		'show_settings_on_create' => false,
		'base' => 'vc_section',
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		'as_parent' => array(
			'only' => 'vc_row',
		),
		'as_child' => array(
			'only' => '', // Only root
		),
		'class' => 'vc_main-sortable-element',
		'description' => __( 'Group multiple rows in section', 'core-extension' ),
		'params' => array(
			array(
				"type" => 'checkbox',
				"heading" => __('Full width content', 'core-extension'),
				"param_name" => "full_content_width",
				"value" => Array(__('Yes, please', 'core-extension') => 'row-inner-full'),
			),
			array(
				"type" => "dropdown",
				"heading" => __('Section height', 'core-extension'),
				"param_name" => "full_height",
				"value" => array('Auto' => '',
				                 'Full screen' => 'full_height'
				),
			),
			array(
				"type" => "dropdown",
				"heading" => __('Vertical align', 'core-extension'),
				"param_name" => "section_align",
				"value" => array('Middle' => 'align-middle',
				                 'Top' => 'align-top',
				                 'Bottom' => 'align-bottom'),
				'std' => 'align-middle',
				"description" => __('Choose how the section content should be vertically aligned.', 'core-extension'),
				"dependency" => Array('element' => "full_height", 'value' => 'full_height')
			),
			array(
				"type" => "textfield",
				"heading" => __('Extra class name', 'core-extension'),
				"param_name" => "el_class",
				"description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Add ID to section', 'core-extension'),
				"param_name" => "section_id",
				"description" => __('This ID is used to make one page menu or scroll to anchor. Please give unique ID to each row, if using menu for one page style.', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Background color', 'core-extension'),
				"param_name" => "bg_color",
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Background type', 'core-extension'),
				"param_name" => "bg_type",
				"value" => array('Without attachment'   => '',
				                 'Image background'     => 'image',
				                 'Video background'     => 'video'),
				"description" => __('Choose the type of background attachment for this section.', 'core-extension'),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => __('Background image', 'core-extension'),
				"param_name" => "bg_image",
				"dependency" => Array('element' => "bg_type", 'value' => 'image'),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Parallax background', 'core-extension'),
				"param_name" => "parallax_bg",
				"description" => __('Enable parallax effect during the scroll', 'core-extension'),
				"value" => Array(__('Enable', 'core-extension') => 'parallax-bg'),
				"dependency" => Array('element' => "bg_image", 'not_empty' => true),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Background image parallax speed', 'core-extension'),
				"param_name" => "speed",
				"value" => "0.20",
				"description" => __('You can change the speed of parallax effect by altering the decimal number.  A lower number means slower, higher means faster, and 0.20 is the default.', 'core-extension'),
				"dependency" => Array('element' => "bg_image", 'not_empty' => true),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Scale background', 'core-extension'),
				"param_name" => "scale_bg",
				"description" => __('Enable image scaling effect during the scroll.', 'core-extension'),
				"value" => Array(__('Enable', 'core-extension') => 'scale-bg'),
				"dependency" => Array('element' => "bg_image", 'not_empty' => true),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Background image scaling speed', 'core-extension'),
				"param_name" => "scale_speed",
				"value" => "0.20",
				"description" => __('You can change the speed of scaling effect by altering the decimal number.  A lower number means slower, higher means faster, and 0.20 is the default.', 'core-extension'),
				"dependency" => Array('element' => "bg_image", 'not_empty' => true),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Full background cover', 'core-extension'),
				"param_name" => "bg_cover",
				"description" => __('Scale the background image to be as large as possible so that the background area is completely covered by the background image. Some parts of the background image may not be in view within the background positioning area.', 'core-extension'),
				"value" => Array(__('Enable', 'core-extension') => 'cover'),
				"dependency" => Array('element' => "bg_image", 'not_empty' => true),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Background repeat', 'core-extension'),
				"param_name" => "bg_repeat",
				"value" => array('Repeat all' => '',
				                 'Repeat horizontally' => 'repeat-x',
				                 'Repeat vertically' => 'repeat-y',
				                 'No repeat' => 'no-repeat'),
				"description" => __('The background-repeat property sets if/how a background image will be repeated.', 'core-extension'),
				"dependency" => Array('element' => "bg_image", 'not_empty' => true),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Background position', 'core-extension'),
				"param_name" => "bg_position",
				"value" => array('Left top' => '', 'Left center', 'Left bottom', 'Right top', 'Right center', 'Right bottom', 'Center top', 'Center center', 'Center bottom'),
				"description" => __('The background-position property sets the starting position of a background image.', 'core-extension'),
				"dependency" => Array('element' => "bg_image", 'not_empty' => true),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Background attachment', 'core-extension'),
				"param_name" => "bg_attachment",
				"value" => array('Scroll' => '',
				                 'Fixed' => 'fixed'),
				"description" => __('The background-attachment property sets whether a background image is fixed or scrolls with the rest of the page.', 'core-extension'),
				"dependency" => Array('element' => "bg_image", 'not_empty' => true),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => __('Video poster image', 'core-extension'),
				"param_name" => "video_poster",
				"dependency" => Array('element' => "bg_type", 'value' => 'video'),
				"description" => __('If added, this image will be displayed on desktop before the video is loaded. On mobile devices the video will be replaced with this image to save mobile traffic.', 'core-extension'),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Video source', 'core-extension'),
				"param_name" => "bg_v_source",
				"value" => array('Self-hosted video'    => 'self_hosted',
				                 'Vimeo video'          => 'vimeo',
				                 'Youtube video'        => 'youtube'),
				"description" => __('Choose the source for the background video.', 'core-extension'),
				"dependency" => Array('element' => "bg_type", 'value' => 'video'),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Link to video (mp4)', 'core-extension'),
				"param_name" => "bg_video_mp4",
				"dependency" => Array('element' => "bg_v_source", 'value' => 'self_hosted'),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Link to video (webm)', 'core-extension'),
				"param_name" => "bg_video_webm",
				"dependency" => Array('element' => "bg_v_source", 'value' => 'self_hosted'),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Link to video (ogv)', 'core-extension'),
				"param_name" => "bg_video_ogg",
				"dependency" => Array('element' => "bg_v_source", 'value' => 'self_hosted'),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Link to Vimeo video', 'core-extension'),
				"param_name" => "vimeo_link",
				"dependency" => Array('element' => "bg_v_source", 'value' => 'vimeo'),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Link to Youtube video', 'core-extension'),
				"param_name" => "youtube_link",
				"dependency" => Array('element' => "bg_v_source", 'value' => 'youtube'),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Parallax video background', 'core-extension'),
				"param_name" => "parallax_video",
				"description" => __('Enable parallax effect during the scroll', 'core-extension'),
				"value" => Array(__('Enable', 'core-extension') => 'parallax-bg'),
				"dependency" => Array('element' => "bg_type", 'value' => 'video'),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Background video parallax speed', 'core-extension'),
				"param_name" => "video_speed",
				"value" => "0.20",
				"description" => __('You can change the speed of parallax and scaling effect by altering the decimal number.  A lower number means slower, higher means faster, and 0.20 is the default.', 'core-extension'),
				"dependency" => Array('element' => "bg_type", 'value' => 'video'),
				"group" => __('Background', 'core-extension')
			),
			array(
				'type' => 'checkbox',
				'heading' => __( 'Disable section', 'core-extension' ),
				'param_name' => 'disable_element',
				// Inner param name.
				'description' => __( 'If checked the section won\'t be visible on the public side of your website. You can switch it back any time.', 'core-extension' ),
				'value' => array( __( 'Yes', 'core-extension' ) => 'yes' ),
			),
//			array(
//				'type' => 'css_editor',
//				'heading' => __( 'CSS box', 'core-extension' ),
//				'param_name' => 'css',
//				'group' => __( 'Design Options', 'core-extension' ),
//			),
		),
		'js_view' => 'VcSectionView',
	) );
	  
	// Row
	vc_map( array(
		"name" => __('Row', 'core-extension'),
		"base" => "vc_row",
		"is_container" => true,
		"icon" => "icon-wpb-row",
		"weight" => 2,
		"show_settings_on_create" => false,
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"admin_enqueue_css" => array( COLLARS_PLUGIN_URL . 'assets/css/font-devices.css'),
		"description" => __('Place content elements inside the row', 'core-extension'),
		"params" => array(
			array(
				"type" => 'checkbox',
				"heading" => __('Full width content', 'core-extension'),
				"param_name" => "full_content_width",
				"value" => Array(__('Yes, please', 'core-extension') => 'row-inner-full'),
				"description" => __('Checking this option, make sure that the parent section is also set to full width content.', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Row auto height', 'core-extension'),
				"param_name" => "row_height_type",
				"value" => array('Auto' => '',
				                 'Fixed height' => 'fixed_height'),
				"description" => __('Choose automatic row height based on height of its content (default behaviour) and fixed height (great for landing pages with image or video background).', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Height', 'core-extension'),
				"param_name" => "height",
				"value" => '',
				"description" => __('Set the height that the row should take on the screen.
									You can enter values in <code>px</code> to set absolute height or in <code>%</code> to set the height relative to the screen size.', 'core-extension'),
				"dependency" => Array('element' => "row_height_type", 'value' => 'fixed_height')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Vertical align', 'core-extension'),
				"param_name" => "row_align",
				"value" => array('Middle' => 'align-middle',
				                 'Top' => 'align-top',
				                 'Bottom' => 'align-bottom'),
				"description" => __('Choose how the row content should be vertically aligned. Doesn\'t work with equal-height columns (use "Columns position" option instead).', 'core-extension'),
				"dependency" => Array('element' => "row_height_type", 'value' => 'fixed_height')
			),
			array(
				"type" => "textfield",
				"heading" => __('Padding top', 'core-extension'),
				"param_name" => "top",
				"value" => '60px',
				"description" => __('The padding-top property sets the top padding (space) of an element.', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Padding bottom', 'core-extension'),
				"param_name" => "bottom",
				"value" => '60px',
				"description" => __('The padding-bottom property sets the bottom padding (space) of an element.', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Row divider', 'core-extension'),
				"param_name" => "row_separator",
				"value" => array(__('None', 'core-extension') => 'no-separator',
				                 __('Solid line top', 'core-extension') => 'row-line-separator',
				                 __('Inner shadow top', 'core-extension') => 'row-shadow-top',
				                 __('Inner shadow bottom', 'core-extension') => 'row-shadow-bottom'),
				"description" => __('Divider separates current row from content element above', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Content fade-out animation', 'core-extension'),
				"param_name" => "content_fadeout",
				"description" => __('Enable content parallax fade-out effect during the scroll', 'core-extension'),
				"value" => Array(__('Enable', 'core-extension') => 'content-fadeout')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Equal height columns', 'core-extension'),
				"param_name" => "equal_height",
				"description" => __('Enable equal height columns in this row', 'core-extension'),
				"value" => Array(__('Enable', 'core-extension') => 'content-fadeout'),
				"group" => __('Columns', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Columns gap', 'core-extension' ),
				'param_name' => 'gap',
				'value' => array(
					'default' => '',
					'0px' => '0',
					'1px' => '1',
					'2px' => '2',
					'3px' => '3',
					'4px' => '4',
					'5px' => '5',
					'10px' => '10',
					'15px' => '15',
					'20px' => '20',
					'25px' => '25',
					'30px' => '30',
					'35px' => '35',
				),
				'std' => '',
				'description' => __( 'Select gap between columns in row.', 'core-extension' ),
				"group" => __('Columns', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Columns position', 'core-extension' ),
				'param_name' => 'columns_placement',
				'value' => array(
					__( 'Default', 'core-extension' ) => '',
					__( 'Middle', 'core-extension' ) => 'middle',
					__( 'Top', 'core-extension' ) => 'top',
					__( 'Bottom', 'core-extension' ) => 'bottom',
					__( 'Stretch', 'core-extension' ) => 'stretch',
				),
				'std' => 'stretch',
				'description' => __( 'Select columns position within row.', 'core-extension' ),
				"group" => __('Columns', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Content position', 'core-extension' ),
				'param_name' => 'content_placement',
				'value' => array(
					__( 'Default', 'core-extension' ) => '',
					__( 'Top', 'core-extension' ) => 'top',
					__( 'Middle', 'core-extension' ) => 'middle',
					__( 'Bottom', 'core-extension' ) => 'bottom',
				),
				'std' => '',
				'description' => __( 'Select content position within columns.', 'core-extension' ),
				"group" => __('Columns', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Font Color', 'core-extension'),
				"param_name" => "font_color",
				"group" => __('Typography', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Font weight', 'core-extension'),
				"param_name" => "font_weight",
				"value" => array(__('Inherit', 'core-extension') => "",
				                 __('Normal', 'core-extension') => "normal",
				                 __('Lighter', 'core-extension') => "lighter",
				                 __('Bold', 'core-extension') => "bold",
				                 __('Bolder', 'core-extension') => "bolder"),
				"group" => __('Typography', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Row text align', 'core-extension'),
				"param_name" => "textalign",
				"value" => array(__('Inherit', 'core-extension') => "",
				                 __('Left', 'core-extension') => "left",
				                 __('Center', 'core-extension') => "center",
				                 __('Right', 'core-extension') => "right"),
				"group" => __('Typography', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Extra class name', 'core-extension'),
				"param_name" => "el_class",
				"description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Add ID to section', 'core-extension'),
				"param_name" => "section_id",
				"description" => __('This ID is used to make one page menu or scroll to anchor. Please give unique ID to each row, if using menu for one page style.', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Background color', 'core-extension'),
				"param_name" => "bg_color",
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Background type', 'core-extension'),
				"param_name" => "bg_type",
				"value" => array('Without attachment'   => '',
				                 'Image background'     => 'image',
				                 'Video background'     => 'video'),
				"description" => __('Choose the type of background attachment for this row.', 'core-extension'),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => __('Background image', 'core-extension'),
				"param_name" => "bg_image",
				"dependency" => Array('element' => "bg_type", 'value' => 'image'),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Parallax background', 'core-extension'),
				"param_name" => "parallax_bg",
				"description" => __('Enable parallax effect during the scroll', 'core-extension'),
				"value" => Array(__('Enable', 'core-extension') => 'parallax-bg'),
				"dependency" => Array('element' => "bg_image", 'not_empty' => true),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Background image parallax speed', 'core-extension'),
				"param_name" => "speed",
				"value" => "0.20",
				"description" => __('You can change the speed of parallax effect by altering the decimal number.  A lower number means slower, higher means faster, and 0.20 is the default.', 'core-extension'),
				"dependency" => Array('element' => "bg_image", 'not_empty' => true),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Scale background', 'core-extension'),
				"param_name" => "scale_bg",
				"description" => __('Enable image scaling effect during the scroll.', 'core-extension'),
				"value" => Array(__('Enable', 'core-extension') => 'scale-bg'),
				"dependency" => Array('element' => "bg_image", 'not_empty' => true),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Background image scaling speed', 'core-extension'),
				"param_name" => "scale_speed",
				"value" => "0.20",
				"description" => __('You can change the speed of scaling effect by altering the decimal number.  A lower number means slower, higher means faster, and 0.20 is the default.', 'core-extension'),
				"dependency" => Array('element' => "bg_image", 'not_empty' => true),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Full background cover', 'core-extension'),
				"param_name" => "bg_cover",
				"description" => __('Scale the background image to be as large as possible so that the background area is completely covered by the background image. Some parts of the background image may not be in view within the background positioning area.', 'core-extension'),
				"value" => Array(__('Enable', 'core-extension') => 'cover'),
				"dependency" => Array('element' => "bg_image", 'not_empty' => true),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Background repeat', 'core-extension'),
				"param_name" => "bg_repeat",
				"value" => array('Repeat all' => '',
				                 'Repeat horizontally' => 'repeat-x',
				                 'Repeat vertically' => 'repeat-y',
				                 'No repeat' => 'no-repeat'),
				"description" => __('The background-repeat property sets if/how a background image will be repeated.', 'core-extension'),
				"dependency" => Array('element' => "bg_image", 'not_empty' => true),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Background position', 'core-extension'),
				"param_name" => "bg_position",
				"value" => array('Left top' => '', 'Left center', 'Left bottom', 'Right top', 'Right center', 'Right bottom', 'Center top', 'Center center', 'Center bottom'),
				"description" => __('The background-position property sets the starting position of a background image.', 'core-extension'),
				"dependency" => Array('element' => "bg_image", 'not_empty' => true),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Background attachment', 'core-extension'),
				"param_name" => "bg_attachment",
				"value" => array('Scroll' => '',
				                 'Fixed' => 'fixed'),
				"description" => __('The background-attachment property sets whether a background image is fixed or scrolls with the rest of the page.', 'core-extension'),
				"dependency" => Array('element' => "bg_image", 'not_empty' => true),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => __('Video poster image', 'core-extension'),
				"param_name" => "video_poster",
				"dependency" => Array('element' => "bg_type", 'value' => 'video'),
				"description" => __('If added, this image will be displayed on desktop before the video is loaded. On mobile devices the video will be replaced with this image to save mobile traffic.', 'core-extension'),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Video source', 'core-extension'),
				"param_name" => "bg_v_source",
				"value" => array('Self-hosted video'    => 'self_hosted',
				                 'Vimeo video'          => 'vimeo',
				                 'Youtube video'        => 'youtube'),
				"description" => __('Choose the source for the background video.', 'core-extension'),
				"dependency" => Array('element' => "bg_type", 'value' => 'video'),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Link to video (mp4)', 'core-extension'),
				"param_name" => "bg_video_mp4",
				"dependency" => Array('element' => "bg_v_source", 'value' => 'self_hosted'),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Link to video (webm)', 'core-extension'),
				"param_name" => "bg_video_webm",
				"dependency" => Array('element' => "bg_v_source", 'value' => 'self_hosted'),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Link to video (ogv)', 'core-extension'),
				"param_name" => "bg_video_ogg",
				"dependency" => Array('element' => "bg_v_source", 'value' => 'self_hosted'),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Link to Vimeo video', 'core-extension'),
				"param_name" => "vimeo_link",
				"dependency" => Array('element' => "bg_v_source", 'value' => 'vimeo'),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Link to Youtube video', 'core-extension'),
				"param_name" => "youtube_link",
				"dependency" => Array('element' => "bg_v_source", 'value' => 'youtube'),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Parallax video background', 'core-extension'),
				"param_name" => "parallax_video",
				"description" => __('Enable parallax effect during the scroll', 'core-extension'),
				"value" => Array(__('Enable', 'core-extension') => 'parallax-bg'),
				"dependency" => Array('element' => "bg_type", 'value' => 'video'),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Background video parallax speed', 'core-extension'),
				"param_name" => "video_speed",
				"value" => "0.20",
				"description" => __('You can change the speed of parallax and scaling effect by altering the decimal number.  A lower number means slower, higher means faster, and 0.20 is the default.', 'core-extension'),
				"dependency" => Array('element' => "bg_type", 'value' => 'video'),
				"group" => __('Background', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Overlay color', 'core-extension'),
				"param_name" => "overlay_color",
				"description" => __('Select color of overlay over the background image. Use \'Alpha\' option to set the opacity of the overlay.', 'core-extension'),
				"dependency" => Array('element' => "bg_type", 'value' => array('image', 'video')),
				"group" => __('Overlay', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Pattern overlay', 'core-extension'),
				"param_name" => "overlay_pattern",
				"value" => array('No pattern'               => '',
								 'Large black square'       => 'md_dot_b',
								 'Large white square'       => 'md_dote_w',
								 'Small black square'       => 'sm_dot_b',
								 'Small white square'       => 'sm_dot_w',
								 'Large black cell'         => 'md_cell_b',
								 'Large white cell'         => 'md_cell_w',
								 'Small black cell'         => 'sm_cell_b',
								 'Small white cell'         => 'sm_cell_w',
								 'Left diagonal black'      => 'diagonal_left_b',
								 'Left diagonal white'      => 'diagonal_left_w',
								 'Right diagonal black'     => 'diagonal_right_b',
								 'Right diagonal white'     => 'diagonal_right_w',
								 'Upload custom pattern'    => 'custom'),
				"description" => __('Select pattern for background overlay or choose "Upload custom pattern" to upload your own.', 'core-extension'),
				"group" => __('Overlay', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => __('Upload your custom pattern', 'core-extension'),
				"param_name" => "custom_pattern",
				"dependency" => Array('element' => "overlay_pattern", 'value' => 'custom'),
				"group" => __('Overlay', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Pattern overlay opacity', 'core-extension'),
				"param_name" => "overlay_pattern_op",
				"value" => '0.20',
				"description" => __('Set opacity of background overlay pattern in the range from 0 to 1.', 'core-extension'),
				"dependency" => Array('element' => "overlay_pattern", 'not_empty' => true),
				"group" => __('Overlay', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Row columns', 'core-extension'),
				"param_name" => "row_mobile_style",
				"description" => __('When enabled, all columns are made 100% wide and stacked above each other', 'core-extension'),
				"value" => Array(__('Make this row content 100% width in Tablet Portrait (on screen sizes smaller than 979px)', 'core-extension') => 'ipad_full_width'),
				"group" => __('Responsiveness', 'core-extension')
			),		
			array(
				"type" => 'checkbox',
				"heading" => __('Hide this row on screen sizes:', 'core-extension'),
				"param_name" => "row_show_on",
				"value" => Array(
					"<strong>Desktop</strong> (on screen sizes larger than 1025px)<br/><br/>" => 'hide_on_normal_screen', 
					"<strong>Tablet Landscape</strong> (on screen sizes from 980px - 1024px)<br/><br/>" => 'hide_tablet_landscape', 
					"<strong>Tablet Portrait</strong> (on screen sizes from 768px - 979px)<br/><br/>" => 'hide_tablet_portrait', 
					"<strong>Mobile Landscape</strong> (on screen sizes from 480px - 767px)<br/><br/>" => 'hide_mobile_landscape', 
					"<strong>Mobile Portrait</strong> (on screen sizes smaller than 479px)" => 'hide_mobile_portrait'
				),
				"group" => __('Responsiveness', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Top slope decoration', 'core-extension'),
				"param_name" => "slope_top",
				"description" => __('Enable slope decoration at the top of the row.', 'core-extension'),
				"value" => Array(__('Enable', 'core-extension') => 'slope-top'),
				"group" => __('Decoration', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Top slope position', 'core-extension'),
				"param_name" => "slope_top_pos",
				"value" => array( 'Inside' => 'slope-top-inside',
				                  'Outside' => 'slope-top-outside'),
				"description" => __('Set the position of top slope decoration. Inside positioning will create a slope within the current row, while outside positioning will make it cover the previous row.', 'core-extension'),
				"dependency" => Array('element' => 'slope_top', 'value' => 'slope-top'),
				"group" => __('Decoration', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Top slope direction', 'core-extension'),
				"param_name" => "slope_top_dir",
				"value" => array('Left' => 'slope-top-left',
				                 'Right' => 'slope-top-right'),
				"description" => __('Set the direction of top slope decoration.', 'core-extension'),
				"dependency" => Array('element' => 'slope_top', 'value' => 'slope-top'),
				"group" => __('Decoration', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Top slope height', 'core-extension'),
				"param_name" => "slope_top_height",
				"value" => '100px',
				"description" => __('Set the height of top slope height.', 'core-extension'),
				"dependency" => Array('element' => 'slope_top', 'value' => 'slope-top'),
				"group" => __('Decoration', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Top slope background color', 'core-extension'),
				"param_name" => "slope_top_color",
				"description" => __('Consider using the color of your current/previous row.', 'core-extension'),
				"dependency" => Array('element' => 'slope_top', 'value' => 'slope-top'),
				"group" => __('Decoration', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Top slope stack order', 'core-extension'),
				"param_name" => "slope_top_order",
				"value" => array('On top of the content' => '',
				                 'Under the content' => 'slope-under'),
				"description" => __('Set the direction of top slope decoration.', 'core-extension'),
				"dependency" => Array('element' => 'slope_top', 'value' => 'slope-top'),
				"group" => __('Decoration', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Bottom slope decoration', 'core-extension'),
				"param_name" => "slope_bottom",
				"description" => __('Enable slope decoration at the bottom of the row.', 'core-extension'),
				"value" => Array(__('Enable', 'core-extension') => 'slope-bottom'),
				"group" => __('Decoration', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Bottom slope position', 'core-extension'),
				"param_name" => "slope_bottom_pos",
				"value" => array( 'Inside' => 'slope-bottom-inside',
				                  'Outside' => 'slope-bottom-outside'),
				"description" => __('Set the position of bottom slope decoration. Inside positioning will create a slope within the current row, while outside positioning will make it cover the next row.', 'core-extension'),
				"dependency" => Array('element' => 'slope_bottom', 'value' => 'slope-bottom'),
				"group" => __('Decoration', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Bottom slope direction', 'core-extension'),
				"param_name" => "slope_bottom_dir",
				"value" => array('Left' => 'slope-bottom-left',
				                 'Right' => 'slope-bottom-right'),
				"description" => __('Set the direction of bottom slope decoration.', 'core-extension'),
				"dependency" => Array('element' => 'slope_bottom', 'value' => 'slope-bottom'),
				"group" => __('Decoration', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Bottom slope height', 'core-extension'),
				"param_name" => "slope_bottom_height",
				"value" => '100px',
				"description" => __('Set the height of bottom slope height.', 'core-extension'),
				"dependency" => Array('element' => 'slope_bottom', 'value' => 'slope-bottom'),
				"group" => __('Decoration', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Bottom slope background color', 'core-extension'),
				"param_name" => "slope_bottom_color",
				"description" => __('Consider using the color of your current/next row.', 'core-extension'),
				"dependency" => Array('element' => 'slope_bottom', 'value' => 'slope-bottom'),
				"group" => __('Decoration', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Bottom slope stack order', 'core-extension'),
				"param_name" => "slope_bot_order",
				"value" => array('On top of the content' => '',
				                 'Under the content' => 'slope-under'),
				"description" => __('Set the direction of top slope decoration.', 'core-extension'),
				"dependency" => Array('element' => 'slope_bottom', 'value' => 'slope-bottom'),
				"group" => __('Decoration', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Top and bottom slope decoration height on tablet screen', 'core-extension'),
				"param_name" => "slope_height_tablet",
				"value" => '',
				"description" => __('You can set a shorter height for tablet screen and below (e.g., <code>50px</code>) or leave blank to use default height.', 'core-extension'),
				"group" => __('Decoration', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Top and bottom slope decoration height on mobile screen', 'core-extension'),
				"param_name" => "slope_height_mobile",
				"value" => '',
				"description" => __('You can set a shorter height for mobile screen (e.g., <code>50px</code>) or leave blank to use default height.', 'core-extension'),
				"group" => __('Decoration', 'core-extension')
			)
		),
		"js_view" => 'VcRowView'
	) );

	// Row inner
	vc_map( array(
		'name' => __( 'Row', 'core-extension' ),
		'base' => 'vc_row_inner',
		'content_element' => false,
		'is_container' => true,
		'icon' => 'icon-wpb-row',
		'weight' => 1000,
		'show_settings_on_create' => false,
		'description' => __( 'Place content elements inside the row', 'core-extension' ),
		'params' => array(
			array(
				"type" => "textfield",
				"heading" => __('Height', 'core-extension'),
				"param_name" => "height",
				"value" => '',
				"description" => __('Set the height that the row should take on the screen.
									You can enter values in <code>px</code> to set absolute height or in <code>%</code> to set the height relative to the screen size.', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Padding top', 'core-extension'),
				"param_name" => "top",
				"value" => '60px',
				"description" => __('The padding-top property sets the top padding (space) of an element.', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Padding bottom', 'core-extension'),
				"param_name" => "bottom",
				"value" => '60px',
				"description" => __('The padding-bottom property sets the bottom padding (space) of an element.', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'core-extension' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension' )
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Font Color', 'core-extension' ),
				'param_name' => 'font_color',
				'description' => __( 'Select font color', 'core-extension' ),
				'edit_field_class' => 'vc_col-md-6 vc_column',
				"group" => __('Typography', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Row text align', 'core-extension'),
				"param_name" => "textalign",
				"value" => array(__('Inherit', 'core-extension') => "",
				                 __('Left', 'core-extension') => "left",
				                 __('Center', 'core-extension') => "center",
				                 __('Right', 'core-extension') => "right"),
				"group" => __('Typography', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Background color', 'core-extension'),
				"param_name" => "bg_color",
				"group" => __('Background &amp; Animation', 'core-extension')
			),
			array(
				"type" => "attach_image",
				"heading" => __('Background image', 'core-extension'),
				"param_name" => "bg_image",
				"group" => __('Background &amp; Animation', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Overlay color', 'core-extension'),
				"param_name" => "overlay_color",
				"description" => __('Select color of overlay over the background image. Use \'Alpha\' option to set the opacity of the overlay.', 'core-extension'),
				"dependency" => Array('element' => "bg_image", 'not_empty' => true),
				"group" => __('Background &amp; Animation', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Parallax background', 'core-extension'),
				"param_name" => "parallax_bg",
				"description" => __('Enable parallax effect during the scroll', 'core-extension'),
				"value" => Array(__('Enable', 'core-extension') => 'parallax-bg'),
				"dependency" => Array('element' => "bg_image", 'not_empty' => true),
				"group" => __('Background &amp; Animation', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Scale background', 'core-extension'),
				"param_name" => "scale_bg",
				"description" => __('Enable image scaling effect during the scroll.', 'core-extension'),
				"value" => Array(__('Enable', 'core-extension') => 'scale-bg'),
				"dependency" => Array('element' => "bg_image", 'not_empty' => true),
				"group" => __('Background &amp; Animation', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Parallax speed', 'core-extension'),
				"param_name" => "speed",
				"value" => "0.20",
				"description" => __('You can change the speed by altering the decimal number.  A lower number means slower, higher means faster, and 0.20 is the default.', 'core-extension'),
				"dependency" => Array('element' => "parallax_bg", 'not_empty' => true),
				"group" => __('Background &amp; Animation', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Full background cover', 'core-extension'),
				"param_name" => "bg_cover",
				"description" => __('Scale the background image to be as large as possible so that the background area is completely covered by the background image. Some parts of the background image may not be in view within the background positioning area.', 'core-extension'),
				"value" => Array(__('Enable', 'core-extension') => 'cover'),
				"dependency" => Array('element' => "bg_image", 'not_empty' => true),
				"group" => __('Background &amp; Animation', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Background repeat', 'core-extension'),
				"param_name" => "bg_repeat",
				"value" => array('Repeat all' => '',
				                 'Repeat horizontally' => 'repeat-x',
				                 'Repeat vertically' => 'repeat-y',
				                 'No repeat' => 'no-repeat'),
				"description" => __('The background-repeat property sets if/how a background image will be repeated.', 'core-extension'),
				"dependency" => Array('element' => "bg_image", 'not_empty' => true),
				"group" => __('Background &amp; Animation', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Background position', 'core-extension'),
				"param_name" => "bg_position",
				"value" => array('Left top' => '', 'Left center', 'Left bottom', 'Right top', 'Right center', 'Right bottom', 'Center top', 'Center center', 'Center bottom'),
				"description" => __('The background-position property sets the starting position of a background image.', 'core-extension'),
				"dependency" => Array('element' => "bg_image", 'not_empty' => true),
				"group" => __('Background &amp; Animation', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Background attachment', 'core-extension'),
				"param_name" => "bg_attachment",
				"value" => array('Scroll' => '', 'Fixed' => 'fixed'),
				"description" => __('The background-attachment property sets whether a background image is fixed or scrolls with the rest of the page.', 'core-extension'),
				"dependency" => Array('element' => "bg_image", 'not_empty' => true),
				"group" => __('Background &amp; Animation', 'core-extension')
			)
		),
		'js_view' => 'VcRowView'
	) );

	// Column
	$column_width_list = array(
		__('1 column - 1/12', 'js_composer') => '1/12',
		__('2 columns - 1/6', 'js_composer') => '1/6',
		__('3 columns - 1/4', 'js_composer') => '1/4',
		__('4 columns - 1/3', 'js_composer') => '1/3',
		__('5 columns - 5/12', 'js_composer') => '5/12',
		__('6 columns - 1/2', 'js_composer') => '1/2',
		__('7 columns - 7/12', 'js_composer') => '7/12',
		__('8 columns - 2/3', 'js_composer') => '2/3',
		__('9 columns - 3/4', 'js_composer') => '3/4',
		__('10 columns - 5/6', 'js_composer') => '5/6',
		__('11 columns - 11/12', 'js_composer') => '11/12',
		__('12 columns - 1/1', 'js_composer') => '1/1'
	);
	vc_map( array(
		'name' => __( 'Column', 'core-extension' ),
		'base' => 'vc_column',
		'is_container' => true,
		'content_element' => false,
		'params' => array(
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Font Color', 'core-extension' ),
				'param_name' => 'font_color',
				'description' => __( 'Select font color', 'core-extension' ),
				'edit_field_class' => 'vc_col-md-6 vc_column'
			),
			array(
				"type" => "dropdown",
				"heading" => __('Column height', 'core-extension'),
				"param_name" => "col_height_type",
				"value" => array('Auto' => '',
				                 'Fixed height' => 'fixed_height'),
				"description" => __('Choose automatic column height based on height of its content (default behaviour) or fixed height.', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Height', 'core-extension'),
				"param_name" => "height",
				"value" => '',
				"description" => __('Set the height in pixels that the column should take on the screen.', 'core-extension'),
				"dependency" => Array('element' => "col_height_type", 'value' => 'fixed_height')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Column text align', 'core-extension'),
				"param_name" => "textalign",
				"value" => array(__('Inherit', 'core-extension') => "",
				                 __('Left', 'core-extension') => "left",
				                 __('Center', 'core-extension') => "center",
				                 __('Right', 'core-extension') => "right")
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'core-extension' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension' )
			),
			array(
				'type' => 'css_editor',
				'heading' => __( 'Css', 'core-extension' ),
				'param_name' => 'css',
				// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension' ),
				'group' => __( 'Design options', 'core-extension' )
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Left slope decoration', 'core-extension'),
				"param_name" => "slope_left",
				"description" => __('Enable slope decoration on the left of the column.', 'core-extension'),
				"value" => Array(__('Enable', 'core-extension') => 'slope-left'),
				"group" => __('Decoration', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Top slope direction', 'core-extension'),
				"param_name" => "slope_left_dir",
				"value" => array('Top' => 'slope-left-top',
				                 'Bottom' => 'slope-left-bottom'),
				"description" => __('Set the direction of left slope decoration.', 'core-extension'),
				"dependency" => Array('element' => 'slope_left', 'value' => 'slope-left'),
				"group" => __('Decoration', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Left slope width', 'core-extension'),
				"param_name" => "slope_left_width",
				"value" => '100px',
				"description" => __('Set the width of left slope decoration.', 'core-extension'),
				"dependency" => Array('element' => 'slope_left', 'value' => 'slope-left'),
				"group" => __('Decoration', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Left slope background color', 'core-extension'),
				"param_name" => "slope_left_color",
				"description" => __('Consider using the background color of current column.', 'core-extension'),
				"dependency" => Array('element' => 'slope_left', 'value' => 'slope-left'),
				"group" => __('Decoration', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Right slope decoration', 'core-extension'),
				"param_name" => "slope_right",
				"description" => __('Enable slope decoration on the right of the column.', 'core-extension'),
				"value" => Array(__('Enable', 'core-extension') => 'slope-right'),
				"group" => __('Decoration', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Right slope direction', 'core-extension'),
				"param_name" => "slope_right_dir",
				"value" => array('Top' => 'slope-right-top',
				                 'Bottom' => 'slope-right-bottom'),
				"description" => __('Set the direction of right slope decoration.', 'core-extension'),
				"dependency" => Array('element' => 'slope_right', 'value' => 'slope-right'),
				"group" => __('Decoration', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Right slope width', 'core-extension'),
				"param_name" => "slope_right_width",
				"value" => '100px',
				"description" => __('Set the width of right slope decoration.', 'core-extension'),
				"dependency" => Array('element' => 'slope_right', 'value' => 'slope-right'),
				"group" => __('Decoration', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Right slope background color', 'core-extension'),
				"param_name" => "slope_right_color",
				"description" => __('Consider using the color the current column.', 'core-extension'),
				"dependency" => Array('element' => 'slope_right', 'value' => 'slope-right'),
				"group" => __('Decoration', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Width', 'core-extension' ),
				'param_name' => 'width',
				'value' => $column_width_list,
				'group' => __( 'Width & Responsiveness', 'core-extension' ),
				'description' => __( 'Select column width.', 'core-extension' ),
				'std' => '1/1'
			),
			array(
				'type' => 'column_offset',
				'heading' => __('Responsiveness', 'core-extension'),
				'param_name' => 'offset',
				'group' => __( 'Width & Responsiveness', 'core-extension' ),
				'description' => __('Adjust column for different screen sizes. Control width, offset and visibility settings.', 'core-extension')
			),
			$add_css_animation,
			$add_css_animation_delay
		),
		'js_view' => 'VcColumnView'
	) );

	// Tabs
	$tab_id_1 = time() . '-1-' . rand( 0, 100 );
	$tab_id_2 = time() . '-2-' . rand( 0, 100 );
	$vc_is_wp_version_3_6_more = version_compare( preg_replace( '/^([\d\.]+)(\-.*$)/', '$1', get_bloginfo( 'version' ) ), '3.6' ) >= 0;

	vc_map( array(
		"name" => __( 'Custom Tabs', 'core-extension' ),
		'base' => 'vc_tabs',
		'show_settings_on_create' => false,
		'is_container' => true,
		'icon' => 'icon-wpb-vc_tabs',
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"weight" => 1,
		'description' => __( 'Tabbed content', 'core-extension' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Widget title', 'core-extension' ),
				'param_name' => 'title',
				'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'core-extension' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Tabs style', 'core-extension' ),
				'param_name' => 'style',
				'value' => array( __( 'Classic', 'core-extension' ) => 'tabs_classic',
				                  __( 'Minimalistic', 'core-extension' ) => 'tabs_minimal',
				                  __( 'Underscored', 'core-extension' ) => 'tabs_underscore' ),
				'description' => __( 'Set the style of tabs section.', 'core-extension' )
			),
			array(
				"type" => "dropdown",
				"heading" => __('Tab headings alignment', 'core-extension'),
				"param_name" => "tabs_align",
				"value" => array(__('Left', 'core-extension')   => "",
				                 __('Right', 'core-extension')  => "tabs_right",
				                 __('Center', 'core-extension') => "tabs_center")
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Auto rotate tabs', 'core-extension' ),
				'param_name' => 'interval',
				'value' => array( __( 'Disable', 'core-extension' ) => 0, 3, 5, 10, 15 ),
				'std' => 0,
				'description' => __( 'Auto rotate tabs each X seconds.', 'core-extension' )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'core-extension' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension' )
			)
		),
		'custom_markup' => '
							<div class="wpb_tabs_holder wpb_holder vc_container_for_children">
							<ul class="tabs_controls">
							</ul>
							%content%
							</div>'
	,
		'default_content' => '
								[vc_tab title="' . __( 'Tab 1', 'core-extension' ) . '" tab_id="' . $tab_id_1 . '"][/vc_tab]
								[vc_tab title="' . __( 'Tab 2', 'core-extension' ) . '" tab_id="' . $tab_id_2 . '"][/vc_tab]
								',
		'js_view' => $vc_is_wp_version_3_6_more ? 'VcTabsView' : 'VcTabsView35'
	) );

	// Custom tour
	$tab_id_1 = time() . '-1-' . rand( 0, 100 );
	$tab_id_2 = time() . '-2-' . rand( 0, 100 );
	WPBMap::map( 'vc_tour', array(
		'name' => __( 'Custom Tour', 'core-extension' ),
		'base' => 'vc_tour',
		'show_settings_on_create' => false,
		'is_container' => true,
		'container_not_allowed' => true,
		'icon' => 'icon-wpb-vc_tour',
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"weight" => 1,
		'wrapper_class' => 'vc_clearfix',
		'description' => __( 'Vertical tabbed content', 'core-extension' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Widget title', 'core-extension' ),
				'param_name' => 'title',
				'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'core-extension' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Tabs style', 'core-extension' ),
				'param_name' => 'style',
				'value' => array( __( 'Classic', 'core-extension' ) => 'tabs_classic',
				                  __( 'Minimalistic', 'core-extension' ) => 'tabs_minimal' ),
				'description' => __( 'Set the style of tabs section.', 'core-extension' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Auto rotate slides', 'core-extension' ),
				'param_name' => 'interval',
				'value' => array( __( 'Disable', 'core-extension' ) => 0, 3, 5, 10, 15 ),
				'std' => 0,
				'description' => __( 'Auto rotate slides each X seconds.', 'core-extension' )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'core-extension' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension' )
			)
		),
		'custom_markup' => '
	<div class="wpb_tabs_holder wpb_holder vc_clearfix vc_container_for_children">
	<ul class="tabs_controls">
	</ul>
	%content%
	</div>'
	,
		'default_content' => '
	[vc_tab title="' . __( 'Tab 1', 'core-extension' ) . '" tab_id="' . $tab_id_1 . '"][/vc_tab]
	[vc_tab title="' . __( 'Tab 2', 'core-extension' ) . '" tab_id="' . $tab_id_2 . '"][/vc_tab]
	',
		'js_view' => $vc_is_wp_version_3_6_more ? 'VcTabsView' : 'VcTabsView35'
	) );

	// Tab
	vc_map( array(
		'name' => __( 'Tab', 'core-extension' ),
		'base' => 'vc_tab',
		'allowed_container_element' => 'vc_row',
		'is_container' => true,
		'content_element' => false,
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Title', 'core-extension' ),
				'param_name' => 'title',
				'description' => __( 'Tab title.', 'core-extension' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Icon library', 'core-extension' ),
				'value' => array(
					__( 'No Icon', 'core-extension' ) => '',
					__( 'Font Awesome', 'core-extension' ) => 'fontawesome',
					__( 'Open Iconic', 'core-extension' ) => 'openiconic',
					__( 'Typicons', 'core-extension' ) => 'typicons',
					__( 'Entypo', 'core-extension' ) => 'entypo',
					__( 'Linecons', 'core-extension' ) => 'linecons',
					__( 'Simple Line Icons', 'core-extension' ) => 'simplelineicons',
					__( 'Mono Social', 'core-extension' ) => 'monosocial',
					__( 'Material', 'core-extension' ) => 'material',
				),
				'admin_label' => true,
				'param_name' => 'type',
				'description' => __( 'Select icon library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_fontawesome',
				'value' => 'fa fa-adjust', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'fontawesome',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_openiconic',
				'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'openiconic',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'openiconic',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_typicons',
				'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'typicons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'typicons',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_entypo',
				'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'entypo',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'entypo',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_linecons',
				'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'linecons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'linecons',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_simplelineicons',
				'value' => 'icon-user-unfollow', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'simplelineicons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'simplelineicons',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_monosocial',
				'value' => 'vc-mono vc-mono-fivehundredpx', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'monosocial',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'monosocial',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_material',
				'value' => 'vc-material vc-material-cake',
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false,
					// default true, display an "EMPTY" icon?
					'type' => 'material',
					'iconsPerPage' => 4000,
					// default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'material',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'tab_id',
				'heading' => __( 'Tab ID', 'core-extension' ),
				'param_name' => "tab_id"
			)
		),
		'js_view' => $vc_is_wp_version_3_6_more ? 'VcTabView' : 'VcTabView35'
	) );


	// Accordion
	vc_map( array(
		'name' => __( 'Custom Accordion', 'core-extension' ),
		'base' => 'vc_accordion',
		'show_settings_on_create' => false,
		'is_container' => true,
		'icon' => 'icon-wpb-vc_accordion',
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"weight" => 1,
		'description' => __( 'Collapsible content panels', 'core-extension' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Widget title', 'core-extension' ),
				'param_name' => 'title',
				'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'core-extension' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Accordion style', 'core-extension' ),
				'param_name' => 'style',
				'value' => array( __( 'Classic', 'core-extension' ) => 'accordion_classic',
				                  __( 'Minimalistic', 'core-extension' ) => 'accordion_minimal' ),
				'description' => __( 'Set the style of tabs section.', 'core-extension' )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Active section', 'core-extension' ),
				'param_name' => 'active_tab',
				'description' => __( 'Enter section number to be active on load or enter false to collapse all sections.', 'core-extension' )
			),
			array(
				'type' => 'checkbox',
				'heading' => __( 'Allow collapsible all', 'core-extension' ),
				'param_name' => 'collapsible',
				'description' => __( 'Select checkbox to allow all sections to be collapsible.', 'core-extension' ),
				'value' => array( __( 'Allow', 'core-extension' ) => 'yes' )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'core-extension' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension' )
			)
		),
		'custom_markup' => '
<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
%content%
</div>
<div class="tab_controls">
    <a class="add_tab" title="' . __( 'Add section', 'core-extension' ) . '"><span class="vc_icon"></span> <span class="tab-label">' . __( 'Add section', 'core-extension' ) . '</span></a>
</div>
',
		'default_content' => '
    [vc_accordion_tab title="' . __( 'Section 1', 'core-extension' ) . '"][/vc_accordion_tab]
    [vc_accordion_tab title="' . __( 'Section 2', 'core-extension' ) . '"][/vc_accordion_tab]
',
		'js_view' => 'VcAccordionView'
	) );


	// Buttons
	vc_map( array(
		"name" => __('Custom Button', 'core-extension'),
		"base" => "vc_button",
		"icon" => "icon-wpb-vc_button",
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"weight" => 1,
		"description" => __('Eye catching button', 'core-extension'),
		"params" => array(
			array(
				"type" => "vc_link",
				"heading" => __('URL (Link)', 'core-extension'),
				"param_name" => "link",
			),
			array(
				"type" => "textfield",
				"heading" => __('Text on the button', 'core-extension'),
				"holder" => "button",
				"class" => "wpb_button",
				"param_name" => "title",
				"value" => __('Text on the button', 'core-extension'),
			),
			array(
				"type" => "checkbox",
				"heading" => __('Full width button?', 'core-extension'),
				"param_name" => "button_width",
				"value" => array(__('Yes, please', 'core-extension') => " btn_fw"),
				"description" => __('Button takes full width of its container.', 'core-extension'),
				"group" => __('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Button alignment', 'core-extension'),
				"param_name" => "button_align",
				"value" => array(__('Inherit', 'core-extension') => "",
				                 __('Left', 'core-extension') => "btn_fl",
				                 __('Right', 'core-extension') => "btn_fr")
			),
			array(
				"type" => "dropdown",
				"heading" => __('Button size', 'core-extension'),
				"param_name" => "size",
				"value" => array(__('Regular size', 'core-extension') => "wpb_regularsize",
				                 __('Medium', 'core-extension') => "btn-medium",
				                 __('Large', 'core-extension') => "btn-large"),
				"group" => __('Layout', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Icon library', 'core-extension' ),
				'value' => array(
					__( 'No Icon', 'core-extension' ) => '',
					__( 'Font Awesome', 'core-extension' ) => 'fontawesome',
					__( 'Open Iconic', 'core-extension' ) => 'openiconic',
					__( 'Typicons', 'core-extension' ) => 'typicons',
					__( 'Entypo', 'core-extension' ) => 'entypo',
					__( 'Linecons', 'core-extension' ) => 'linecons',
					__( 'Simple Line Icons', 'core-extension' ) => 'simplelineicons',
					__( 'Mono Social', 'core-extension' ) => 'monosocial',
					__( 'Material', 'core-extension' ) => 'material',
				),
				'admin_label' => true,
				'param_name' => 'type',
				'description' => __( 'Select icon library.', 'core-extension' ),
				"group" => __('Layout', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_fontawesome',
				'value' => 'fa fa-adjust', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'fontawesome',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
				"group" => __('Layout', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_openiconic',
				'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'openiconic',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'openiconic',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
				"group" => __('Layout', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_typicons',
				'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'typicons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'typicons',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
				"group" => __('Layout', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_entypo',
				'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'entypo',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'entypo',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
				"group" => __('Layout', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_linecons',
				'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'linecons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'linecons',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
				"group" => __('Layout', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_simplelineicons',
				'value' => 'icon-user-unfollow', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'simplelineicons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'simplelineicons',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
				"group" => __('Layout', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'js_composer' ),
				'param_name' => 'icon_monosocial',
				'value' => 'vc-mono vc-mono-fivehundredpx', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'monosocial',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'monosocial',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_material',
				'value' => 'vc-material vc-material-cake',
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false,
					// default true, display an "EMPTY" icon?
					'type' => 'material',
					'iconsPerPage' => 4000,
					// default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'material',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				"type" => "dropdown",
				"heading" => __('Icon position', 'core-extension'),
				"param_name" => "icon_pos",
				"value" => array(__('Left', 'core-extension') => "icon-left",
				                 __('Right', 'core-extension') => "icon-right"),
				"description" => __('Choose position of the icon relative to button text. Ignore if no icon chosen.', 'core-extension'),
				"dependency" => Array('element' => "type", 'not_empty' => true),
				"group" => __('Layout', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Margin left', 'core-extension'),
				"param_name" => "margin_left",
				"value" => "0px",
				"description" => '',
				"group" => __('Layout', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Margin right', 'core-extension'),
				"param_name" => "margin_right",
				"value" => "0px",
				"description" => '',
				"group" => __('Layout', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Ghost button style?', 'core-extension'),
				"param_name" => "button_style",
				"description" => __('Border and text in selected color with transparent background', 'core-extension'),
				"value" => Array(__('Enable', 'core-extension') => 'minimal_style'),
				"group" => __('Style', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Color', 'core-extension'),
				"param_name" => "color",
				"value" => array(__('Theme accent color', 'core-extension') => "btn_themecolor",
				                 __('White', 'core-extension') => "btn_white",
				                 __('Grey', 'core-extension') => "btn_grey",
				                 __('Blue', 'core-extension') => "btn_blue",
				                 __('Green', 'core-extension') => "btn_green",
				                 __('Orange', 'core-extension') => "btn_orange",
				                 __('Red', 'core-extension') => "btn_red",
				                 __('Pink', 'core-extension') => "btn_pink",
				                 __('Black', 'core-extension') => "btn_black",
				                 __('Yellow', 'core-extension') => "btn_yellow"),
				"description" => __('Button color', 'core-extension'),
				"group" => __('Style', 'core-extension'),
			),
						array(
				"type" => "dropdown",
				"heading" => __('Corner rounding', 'core-extension'),
				"param_name" => "border_radius",
				"value" => array(__('Sharp', 'core-extension') => "sharp",
				                 __('Slightly rounded', 'core-extension') => "sl_rounded",
				                 __('Heavily rounded', 'core-extension') => "hv_rounded",
				                 __('Round', 'core-extension') => "round"),
				"description" => __('Button border radius', 'core-extension'),
				"group" => __('Style', 'core-extension')
			),
			$add_css_animation,
			$add_css_animation_delay,
			array(
				"type" => "textfield",
				"heading" => __('Extra class name', 'core-extension'),
				"param_name" => "el_class",
				"description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension')
			)
		),
		"js_view" => 'VcButtonView'
	) );


	// Progress Bar
	vc_map( array(
		"name" => __('Progress Bar', 'core-extension'),
		"base" => "vc_progress_bar",
		"icon" => "icon-wpb-graph",
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"description" => __('Animated progress bar', 'core-extension'),
		"params" => array(
		array(
			"type" => "textfield",
			"heading" => __('Widget title', 'core-extension'),
			"param_name" => "title",
			"description" => __('What text use as a widget title. Leave blank if no title is needed.', 'core-extension')
		),
		array(
			"type" => "exploded_textarea",
			"heading" => __('Chart values', 'core-extension'),
			"param_name" => "values",
			"description" => __('Input graph values, labels and bar colors (if you want some bars be of different color than the rest) here. Divide them with "|" and separate the bars with linebreaks (Enter).</br>
							Example: 90|Design|#f47177', 'core-extension'),
			"value" => "90|Development,80|Design,70|Marketing"
		),
		array(
			"type" => "textfield",
			"heading" => __('Units', 'core-extension'),
			"param_name" => "units",
			"description" => __('Enter measurement units (if needed) Eg. %, px, points, etc. Graph value and unit will be appended to the graph title.', 'core-extension')
		),
		array(
			"type" => "dropdown",
			"heading" => __('Bar color', 'core-extension'),
			"param_name" => "bgcolor",
			"value" => array(__('Theme accent color', 'core-extension') => "bar_themecolor",
			                 __('Grey', 'core-extension') => "bar_grey",
			                 __('Blue', 'core-extension') => "bar_blue",
			                 __('Green', 'core-extension') => "bar_green",
			                 __('Orange', 'core-extension') => "bar_orange",
			                 __('Red', 'core-extension') => "bar_red",
			                 __('Black', 'core-extension') => "bar_black",
			                 __('Yellow', 'core-extension') => "bar_yellow",
			                 __('Custom Color', 'core-extension') => "custom"),
			"description" => __('Select bar color.', 'core-extension'),
			"admin_label" => true
		),
		array(
			"type" => "colorpicker",
			"heading" => __('Bar custom color', 'core-extension'),
			"param_name" => "custombgcolor",
			"description" => __('Select custom color for bars.', 'core-extension'),
			"dependency" => Array('element' => "bgcolor", 'value' => array('custom'))
		),
			array(
				"type" => "colorpicker",
				"heading" => __('Track color', 'core-extension'),
				"param_name" => "track_color",
				"description" => __('Select track background color for bars or leave empty for transparent track background.', 'core-extension'),
			),
		array(
			"type" => "textfield",
			"heading" => __('Bar height', 'core-extension'),
			"param_name" => "height",
			"value" => '10px',
			"description" => __('Set the bar height. Dont\'t forget to add <code>px</code>.', 'core-extension')
		),
		array(
			"type" => "dropdown",
			"heading" => __('Label position', 'core-extension'),
			"param_name" => "label_pos",
			"value" => array(__('Below the bar', 'core-extension') => "text_below",
			                 __('Inside the bar', 'core-extension') => "text_inside"),
			"description" => __('Choose where you want the label and units to be displayed.', 'core-extension')
		),
		array(
			"type" => "checkbox",
			"heading" => __('Options', 'core-extension'),
			"param_name" => "options",
			"value" => array(__('Add Stripes?', 'core-extension') => "striped", __('Add animation? Will be visible with striped bars.', 'core-extension') => "animated")
		),
		array(
			"type" => "textfield",
			"heading" => __('Extra class name', 'core-extension'),
			"param_name" => "el_class",
			"description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension')
		)
	  )
	) );


	// Pie chart
	vc_map( array(
		'name' => __( 'Pie chart', 'vc_extend' ),
		'base' => 'vc_pie',
		'class' => '',
		'icon' => 'icon-wpb-vc_pie',
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		'description' => __( 'Animated pie chart', 'core-extension' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Widget title', 'core-extension' ),
				'param_name' => 'title',
				'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'core-extension' ),
				'admin_label' => true
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Pie value', 'core-extension' ),
				'param_name' => 'value',
				'description' => __( 'Input graph value here. Choose range between 0 and 100.', 'core-extension' ),
				'value' => '50',
				'admin_label' => true
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Pie label', 'core-extension' ),
				'param_name' => 'label_value',
				'description' => __( 'Input integer value for label. If empty "Pie value" will be used.', 'core-extension' ),
				'value' => ''
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Units', 'core-extension' ),
				'param_name' => 'units',
				'description' => __( 'Enter measurement units (if needed) Eg. %, px, points, etc. Graph value and unit will be appended to the graph title.', 'core-extension' )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Chart size', 'core-extension' ),
				'param_name' => 'size',
				'value' => '',
				'description' => __( 'Set the size of pie chart. Don\'t forget to add <code>px</code> If left empty, chart will take full width of its container.', 'core-extension' ),
				'group' => __('Design', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Bar color', 'core-extension' ),
				'param_name' => 'bar_color',
				"value" => array(__('Theme accent color', 'core-extension') => "bar_themecolor",
				                 __('Grey', 'core-extension')           => "#9ca8ae",
				                 __('Blue', 'core-extension')           => "#51cbf3",
				                 __('Green', 'core-extension')          => "#67d696",
				                 __('Orange', 'core-extension')         => "#f57b57",
				                 __('Red', 'core-extension')            => "#f47177",
				                 __('Black', 'core-extension')          => "#262628",
				                 __('Yellow', 'core-extension')         => "#ffb400",
				                 __('Custom Color', 'core-extension')   => "custom"),
				'description' => __( 'Select pie chart color.', 'core-extension' ),
				'admin_label' => true,
				'group' => __('Design', 'core-extension'),
				'param_holder_class' => 'vc_colored-dropdown'
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Custom color', 'core-extension'),
				"param_name" => "custom_color",
				"value" => '',
				"dependency" => Array('element' => 'bar_color', 'value' => 'custom'),
				'group' => __('Design', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Track color', 'core-extension'),
				"param_name" => "track_color",
				"value" => '',
				'description' => __( 'Set the color of the track underneath the pie.', 'core-extension' ),
				'group' => __('Design', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Stroke width', 'core-extension' ),
				'param_name' => 'width',
				'value' => '2',
				'description' => __( 'Set the width of the line. The number represents percentage of the total pie chart size.', 'core-extension' ),
				'group' => __('Design', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Background color', 'core-extension'),
				"param_name" => "bg_color",
				"value" => '',
				'description' => __( 'Set the background fill color. Leave empty for transparent background.', 'core-extension' ),
				'group' => __('Design', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Label color', 'core-extension'),
				"param_name" => "text_color",
				"value" => '',
				'description' => __( 'Set the text color for the label. If left empty, bar color will be used.', 'core-extension' ),
				'group' => __('Design', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Bar animation duration', 'core-extension' ),
				'param_name' => 'duration',
				'value' => '2000',
				'group' => __('Misc', 'core-extension'),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Bar animation easing', 'core-extension' ),
				'param_name' => 'easing',
				"value" => array(__('Linear', 'core-extension')         => 'linear',
				                 __('Ease Out', 'core-extension')       => 'easeOut',
				                 __('Ease In Out', 'core-extension')    => 'easeInOut',
				                 __('Bounce', 'core-extension')         => 'bounce',
				                 __('Ease Out Back', 'core-extension')  => "easeOutBack"),
				'admin_label' => true,
				'param_holder_class' => 'vc_colored-dropdown',
				'group' => __('Misc', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'core-extension' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension' )
			),
			$add_css_animation,
			$add_css_animation_delay,
		)
	) );


	// Heading
	vc_map( array(
		"name" => __('Styled Heading', 'core-extension'),
		"base" => "vc_heading",
		"icon" => "icon-wpb-vc_heading",
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"weight" => 1,
		"description" => __('Eye catching headings', 'core-extension'),
		"params" => array(
			array(
				"type" => "dropdown",
				"heading" => __('Heading text size', 'core-extension'),
				"param_name" => "h_size",
				"value" => array(__('Regular', 'core-extension')        => '',
				                 __('Large', 'core-extension')          => 'h-large',
				                 __('Extra large', 'core-extension')    => 'h-extralarge',
				                 __('Super large', 'core-extension')    => 'h-superlarge',
				                 __('Small', 'core-extension')          => 'h-small'),
				"group" => __('Text', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Title', 'core-extension'),
				"param_name" => "title",
				"value" => "",
				"admin_label" => true,
				"group" => __('Text', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Title element tag', 'core-extension'),
				"param_name" => "title_tag",
				"value" => array(__('div', 'core-extension')   => 'div',
				                 __('h1', 'core-extension')    => 'h1',
				                 __('h2', 'core-extension')    => 'h2',
				                 __('h3', 'core-extension')    => 'h3',
				                 __('h4', 'core-extension')    => 'h4',
				                 __('h5', 'core-extension')    => 'h5',
				                 __('h6', 'core-extension')    => 'h6',
				                 __('p', 'core-extension')     => 'p'),
                "group" => __('Text', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Title color', 'core-extension'),
				"param_name" => "title_color",
				"value" => '',
				"description" => '',
				"group" => __('Text', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Sub-title', 'core-extension'),
				"param_name" => "subtitle",
				"admin_label" => true,
				"value" => "",
				"description" => __('Subtitle will be positioned under main title', 'core-extension'),
				"group" => __('Text', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Subtitle element tag', 'core-extension'),
				"param_name" => "subtitle_tag",
				"value" => array(__('div', 'core-extension')   => 'div',
				                 __('h1', 'core-extension')    => 'h1',
				                 __('h2', 'core-extension')    => 'h2',
				                 __('h3', 'core-extension')    => 'h3',
				                 __('h4', 'core-extension')    => 'h4',
				                 __('h5', 'core-extension')    => 'h5',
				                 __('h6', 'core-extension')    => 'h6',
				                 __('p', 'core-extension')     => 'p'),
				"group" => __('Text', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Subtitle color', 'core-extension'),
				"param_name" => "subtitle_color",
				"value" => '',
				"description" => '',
				"group" => __('Text', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Line divider in heading', 'core-extension'),
				"param_name" => "divider",
				"value" => array(__('No divider', 'core-extension')                 => '',
				                 __('Between title and subtitle', 'core-extension') => 'div-between',
				                 __('Below subtitle', 'core-extension')             => 'div-below'),
				"group" => __('Divider', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Type of divider', 'core-extension'),
				"param_name" => "divider_type",
				"value" => array(__('Narrow', 'core-extension')        => 'div-narrow',
				                 __('Narrow thick', 'core-extension')  => 'div-narrow-thick',
				                 __('Wide', 'core-extension')          => 'div-wide',
				                 __('Wide thick', 'core-extension')    => 'div-wide-thick',
				                 __('TiLT branded', 'core-extension')  => 'tilt'),
				"dependency" => Array('element' => "divider", 'value' => array('div-between', 'div-below')),
				"group" => __('Divider', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Size of divider', 'core-extension'),
				"param_name" => "size",
				"value" => array(__('Small', 'core-extension') => "small",
				                 __('Medium', 'core-extension') => "medium",
				                 __('Large', 'core-extension') => "large",
				                 __('Extra-large', 'core-extension') => "extralarge"),
				"dependency" => Array('element' => 'divider_type', 'value' => array('div-between', 'div-below')),
				"group" => __('Divider', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Divider color', 'core-extension'),
				"param_name" => "divider_color",
				"value" => '',
				"description" => '',
				"dependency" => Array('element' => "divider", 'value' => array('div-between', 'div-below')),
				"group" => __('Divider', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Alignment', 'core-extension'),
				"param_name" => "alignment",
				"value" => array(__('Center', 'core-extension') => "align-center",
				                 __('Left', 'core-extension') => "align-left",
				                 __('Right', 'core-extension') => "align-right"),
				"group" => __('Misc', 'core-extension')
			),
			$add_css_animation,
			$add_css_animation_delay,
			array(
				"type" => "textfield",
				"heading" => __('Extra class name', 'core-extension'),
				"param_name" => "el_class",
				"description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension'),
				"group" => __('Misc', 'core-extension')
			)
		)
	) );


	// Icons
	vc_map( array(
		'name' => __( 'Icon', 'core-extension' ),
		'base' => 'vc_icon',
		'icon' => 'icon-wpb-vc_icon',
		'category' => __( 'Content', 'core-extension' ),
		"weight" => 1,
		'description' => __( 'Icon from icon library', 'core-extension' ),
		"admin_enqueue_js" =>  array( COLLARS_PLUGIN_URL . 'assets/js/extend-composer-custom-views.js' ),
		"admin_enqueue_css" => array( COLLARS_PLUGIN_URL . 'assets/css/core-extension-backend.css' ),
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Icon library', 'core-extension' ),
				'value' => array(
					__( 'Font Awesome', 'core-extension' ) => 'fontawesome',
					__( 'Open Iconic', 'core-extension' ) => 'openiconic',
					__( 'Typicons', 'core-extension' ) => 'typicons',
					__( 'Entypo', 'core-extension' ) => 'entypo',
					__( 'Linecons', 'core-extension' ) => 'linecons',
					__( 'Simple Line Icons', 'core-extension' ) => 'simplelineicons',
					__( 'Mono Social', 'core-extension' ) => 'monosocial',
					__( 'Material', 'core-extension' ) => 'material',
				),
				'admin_label' => true,
				'param_name' => 'type',
				'description' => __( 'Select icon library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_fontawesome',
				'value' => 'fa fa-adjust', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'fontawesome',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_openiconic',
				'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'openiconic',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'openiconic',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_typicons',
				'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'typicons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'typicons',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_entypo',
				'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'entypo',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'entypo',
				),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_linecons',
				'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'linecons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'linecons',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_simplelineicons',
				'value' => 'icon-user-unfollow', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'simplelineicons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'simplelineicons',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'js_composer' ),
				'param_name' => 'icon_monosocial',
				'value' => 'vc-mono vc-mono-fivehundredpx', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'monosocial',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'monosocial',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_material',
				'value' => 'vc-material vc-material-cake',
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false,
					// default true, display an "EMPTY" icon?
					'type' => 'material',
					'iconsPerPage' => 4000,
					// default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'material',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'vc_link',
				'heading' => __( 'URL (Link)', 'core-extension' ),
				'param_name' => 'link',
				'description' => __( 'Add link to icon.', 'core-extension' )
			),
			array(
				"type" => "dropdown",
				"heading" => __('Color', 'core-extension'),
				"param_name" => "color",
				"value" => array(__('Theme accent color', 'core-extension') => "icon_themecolor",
				                 __('Black', 'core-extension') => "icon_black",
				                 __('Grey', 'core-extension') => "icon_grey",
				                 __('White', 'core-extension') => "icon_white",
				                 __('Blue', 'core-extension') => "icon_blue",
				                 __('Green', 'core-extension') => "icon_green",
				                 __('Orange', 'core-extension') => "icon_orange",
				                 __('Red', 'core-extension') => "icon_red",
				                 __('Yellow', 'core-extension') => "icon_yellow",
				                 __('Custom Color', 'core-extension') => "custom"),
				"description" => __('Icon color.', 'core-extension'),
				'param_holder_class' => 'vc_colored-dropdown',
				"group" => __('Design', 'core-extension'),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Custom Icon Color', 'core-extension' ),
				'param_name' => 'custom_color',
				'description' => __( 'Select custom icon color.', 'core-extension' ),
				'dependency' => array(
					'element' => 'color',
					'value' => 'custom',
				),
				"group" => __('Design', 'core-extension'),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Background Style', 'core-extension' ),
				'param_name' => 'background_style',
				'value' => array(
					__( 'None', 'core-extension' ) => '',
					__( 'Circle', 'core-extension' ) => 'rounded',
					__( 'Square', 'core-extension' ) => 'boxed',
					__( 'Rounded', 'core-extension' ) => 'rounded-less',
					__( 'Outline Circle', 'core-extension' ) => 'rounded-outline',
					__( 'Outline Square', 'core-extension' ) => 'boxed-outline',
					__( 'Outline Rounded', 'core-extension' ) => 'rounded-less-outline',
				),
				'description' => __( 'Background style for icon.', 'core-extension' ),
				"group" => __('Design', 'core-extension'),
			),
			array(
				"type" => "dropdown",
				'heading' => __( 'Background Color', 'core-extension' ),
				'param_name' => 'background_color',
				"value" => array(__('Theme accent color', 'core-extension') => "icon_bg_themecolor",
				                 __('Black', 'core-extension') => "icon_bg_black",
				                 __('Grey', 'core-extension') => "icon_bg_grey",
				                 __('White', 'core-extension') => "icon_bg_white",
				                 __('Blue', 'core-extension') => "icon_bg_blue",
				                 __('Green', 'core-extension') => "icon_bg_green",
				                 __('Orange', 'core-extension') => "icon_bg_orange",
				                 __('Red', 'core-extension') => "icon_bg_red",
				                 __('Yellow', 'core-extension') => "icon_bg_yellow",
				                 __('Custom Color', 'core-extension') => "bg_custom"),
				'std' => 'icon_bg_themecolor',
				"description" => __('Background color.', 'core-extension'),
				'param_holder_class' => 'vc_colored-dropdown',
				'dependency' => array(
					'element' => 'background_style',
					'not_empty' => true,
				),
				"group" => __('Design', 'core-extension'),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Custom Icon Color', 'core-extension' ),
				'param_name' => 'custom_bg_color',
				'description' => __( 'Select custom icon background color.', 'core-extension' ),
				'dependency' => array(
					'element' => 'background_color',
					'value' => 'bg_custom',
				),
				"group" => __('Design', 'core-extension'),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Size', 'core-extension' ),
				'param_name' => 'size',
				'value' => array_merge( getVcShared( 'sizes' ), array( 'Extra Large' => 'xl' ) ),
				'std' => 'md',
				'description' => __( 'Icon size.', 'core-extension' ),
				"group" => __('Design', 'core-extension'),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Display', 'core-extension' ),
				'param_name' => 'display',
				'value' => array(
					__( 'Block', 'core-extension' ) => 'block',
					__( 'Inline-block', 'core-extension' ) => 'inline-block',
				),
				'description' => __( 'Select icon alignment.', 'core-extension' ),
				"group" => __('Design', 'core-extension'),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Icon alignment', 'core-extension' ),
				'param_name' => 'align',
				'value' => array(
					__( 'Align left', 'core-extension' ) => 'left',
					__( 'Align right', 'core-extension' ) => 'right',
					__( 'Align center', 'core-extension' ) => 'center',
				),
				'description' => __( 'Select icon alignment.', 'core-extension' ),
				"group" => __('Design', 'core-extension'),
				'dependency' => array(
					'element' => 'display',
					'value' => 'block',
				),
			),
			array(
				"type" => "textfield",
				"heading" => __('Margin left', 'core-extension'),
				"param_name" => "margin_left",
				"value" => "0px",
				"description" => '',
				"group" => __('Design', 'core-extension'),
				'dependency' => array(
					'element' => 'display',
					'value' => 'inline-block',
				),
			),
			array(
				"type" => "textfield",
				"heading" => __('Margin right', 'core-extension'),
				"param_name" => "margin_right",
				"value" => "0px",
				"description" => '',
				"group" => __('Design', 'core-extension'),
				'dependency' => array(
					'element' => 'display',
					'value' => 'inline-block',
				),
			),
			$add_icon_animation,
			$add_css_animation,
			$add_css_animation_delay,
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'core-extension' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension' )
			),

		),
		'js_view' => 'VcIconElementView_Backend',
	) );


	// Team
	vc_map( array(
		"name" => __('Team', 'core-extension'),
		"base" => "vc_team",
		"icon" => "icon-wpb-vc_team",
		"wrapper_class" => "clearfix",
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"weight" => 1,
		"description" => __('Staff members', 'core-extension'),
		"params" => array(
			array(
				"type" => "dropdown",
				"heading" => __('Style', 'core-extension'),
				"param_name" => "design",
				"value" => array(__('Modern', 'core-extension')     => "team-style-1",
				                 __('Classic', 'core-extension')    => "team-style-2",
				                 __('Modest', 'core-extension')     => "team-style-3")
			),
			array(
				"type" => "attach_image",
				"heading" => __('Team member photo', 'core-extension'),
				"param_name" => "img_url",
				"value" => "",
				"holder" => "img", 
				"description" => __('Recommended minimum width: 450px', 'core-extension'),
				"group" => __('Image', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Image height', 'core-extension'),
				"param_name" => "height",
				"description" => __('Enter image height in pixels (e.g. <code>300</code>). If left empty, the image will be square.', 'core-extension'),
				"dependency" => Array('element' => "img_url", 'not_empty' => true),
				"group" => __('Image', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Name', 'core-extension'),
				"param_name" => "name",
				"value" => "Michael Smith",
				"holder" => "div",
				"description" => '',
				"group" => __('Content', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Position', 'core-extension'),
				"param_name" => "position",
				"value" => "Sales Manager",
				"holder" => "i",
				"description" => __('e.g. "Senior Developer"', 'core-extension'),
				"group" => __('Content', 'core-extension')
			),
			array(
				"type" => "exploded_textarea",
				"heading" => __('Quote / motto text (optional)', 'core-extension'),
				"param_name" => "hover_txt",
				"value" => "",
				"description" => __('Will be displayed when the element is hovered', 'core-extension'),
				"dependency" => Array('element' => "design", 'value' => array('team-style-1', 'team-style-2')),
				"group" => __('Content', 'core-extension')
			),
			array(
				"type" => "textarea",
				"heading" => __('Additional text information (optional)', 'core-extension'),
				"param_name" => "content",
				"value" => "",
				"description" => __('Write a short description about this person.', 'core-extension'),
				"group" => __('Content', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Overlay color', 'core-extension'),
				"param_name" => "color_scheme",
				"description" => __('Image overlay background color. Leave empty to use "Theme accent color".', 'core-extension'),
				"group" => __('Color palette', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Overlay text color', 'core-extension'),
				"param_name" => "overlay_text_color",
				"description" => __('If left empty white color will be applied.', 'core-extension'),
				"group" => __('Color palette', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Color of team member name', 'core-extension'),
				"param_name" => "name_color",
				"description" => __('If left empty color from default palette will be applied.', 'core-extension'),
				"group" => __('Color palette', 'core-extension'),
				"dependency" => Array('element' => "design", 'value' => array('team-style-1', 'team-style-2'))
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Color of team member position', 'core-extension'),
				"param_name" => "position_color",
				"description" => __('If left empty color from default palette will be applied.', 'core-extension'),
				"group" => __('Color palette', 'core-extension'),
				"dependency" => Array('element' => "design", 'value' => array('team-style-1', 'team-style-2'))
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Color of team member information text', 'core-extension'),
				"param_name" => "info_color",
				"description" => __('If left empty color from default palette will be applied.', 'core-extension'),
				"group" => __('Color palette', 'core-extension'),
				"dependency" => Array('element' => "design", 'value' => array('team-style-1', 'team-style-2'))
			),
			array(
				"type" => "dropdown",
				"heading" => __('Alignment', 'core-extension'),
				"param_name" => "align",
				"value" => array(__('Center', 'core-extension') => "align-center",
				                 __('Left', 'core-extension')   => "align-left",
				                 __('Right', 'core-extension')  => "align-right"),
				"group" => __('Misc', 'core-extension'),
				"dependency" => Array('element' => "design", 'value' => array('team-style-1', 'team-style-2'))
			),
			$add_css_animation,
			$add_css_animation_delay,
			array(
				"type" => "textfield",
				"heading" => __('Extra class name', 'core-extension'),
				"param_name" => "el_class",
				"description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension')
			)
		),
		"js_view" => 'VcTeamView'
	) );


	// Testimonial slider
	vc_map( array(
		"name" => __('Testimonials', 'core-extension'),
		"base" => "vc_testimonial_slider",
		"icon" => "icon-wpb-vc_testimonials", 
		"as_parent" => array('only' => 'vc_testimonial'),
		"is_container" => true,
		"show_settings_on_create" => true,
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"weight" => 1,
		"description" => __('Quote slider', 'core-extension'),
		"params" => array(	
			array(
				"type" => "dropdown",
				"heading" => __('Style', 'core-extension'),
				"param_name" => "style",
				"value" => array(__('Centered simple', 'core-extension') => "testimonials-style-1",
				                 __('Centered with quotation marks', 'core-extension') => "testimonials-style-2",
				                 __('Left-aligned with left border', 'core-extension') => "testimonials-style-3",
				                 __('Styled bubble', 'core-extension') => "testimonials-style-4")
			),
			array(
				"type" => "dropdown",
				"heading" => __('Animation', 'core-extension'),
				"param_name" => "animation",
				"value" => array(__('Fade', 'core-extension') => "fade",
				                 __('Slide', 'core-extension') => "slide",)
			),
			array(
				"type" => "textfield",
				"heading" => __('Slide show speed', 'core-extension'),
				"param_name" => "slide_speed",
				"value" => "5",
				"description" => __('Set the speed of the slideshow cycling, in seconds', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __( 'Hide paging control?', 'core-extension' ),
				"param_name" => "bullets",
				"value" => Array(__( 'Yes, please', 'core-extension' ) => 'paging-false')
			),				
			array(
				"type" => "textfield",
				"heading" => __('Extra class name', 'core-extension'),
				"param_name" => "el_class",
				"description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension')
			)
		),
		"custom_markup" => '
			<h4>Testimonials/Quotes</h4>
			<div class="wpb_testimonial_holder wpb_holder clearfix vc_container_for_children">
			%content%
			</div>
			<div class="tab_controls">
			    <a class="add_tab" title="' . __( 'Add navigation link', 'core-extension' ) . '"><span class="vc_icon"></span> <span class="tab-label">' . __( 'Add testimonial', 'core-extension' ) . '</span></a>
			</div>
		',
	  'default_content' => '
	  [vc_testimonial name="John Martin" position="Developer"]I am testimonial text. Click edit button to change this text.[/vc_testimonial]
	  [vc_testimonial name="Richard Smith" position="Designer"]I am testimonial text 2. Click edit button to change this text.[/vc_testimonial]
	  ',
	  "js_view" => 'VcTestimonialSliderView'
	  
	) );


	// Testimonial
	vc_map( array(
		"name" => __('Testimonial', 'core-extension'),
		"base" => "vc_testimonial",
		"is_container" => true,
		"content_element" => false,
		"as_child" => array('only' => 'vc_testimonial_slider'),
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"params" => array(
			array(
				"type" => "attach_image",
				"heading" => __('Author image', 'core-extension'),
				"param_name" => "img_url"
			),		
			array(
				"type" => "textfield",
				"heading" => __('Author name', 'core-extension'),
				"param_name" => "name",
				"value" => "John Doe",
				"holder" => "h3",
				"description" => ''
			),
			array(
				"type" => "textfield",
				"heading" => __('Author info', 'core-extension'),
				"param_name" => "author_dec",
				"value" => "Designer",
				"description" => __('e.g. "Senior Designer" or  "Happy Customer"', 'core-extension')
			),
			array(
				"type" => "textarea",
				"class" => "quote_text",
				"heading" => __('Testimonial/Quote text', 'core-extension'),
				"holder" => "div",
				"param_name" => "content",
				"value" => __('<p>I am testimonial text. Click edit button to change this text.</p>', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Primary text color', 'core-extension'),
				"param_name" => "color_primary",
				"value" => '#9ca8ae',
				"description" => __('Set the main text color for the quote.', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Secondary text color', 'core-extension'),
				"param_name" => "color_secondary",
				"value" => '#262628',
				"description" => __('Set the secondary text color for decoration and author name.', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Extra class name', 'core-extension'),
				"param_name" => "el_class",
				"description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension')
			)
		),
		"js_view" => 'VcTestimonialView'
	) );


	// List item
	vc_map( array(
		"name" => __('List Item', 'core-extension'),
		"base" => "vc_list_item",
		"icon" => "icon-wpb-vc_list", 
		"is_container" => false,
		"description" => __('List with custom icon', 'core-extension'),
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"weight" => 1,
		"params" => array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Icon library', 'core-extension' ),
				'value' => array(
					__( 'No Icon', 'core-extension' ) => '',
					__( 'Font Awesome', 'core-extension' ) => 'fontawesome',
					__( 'Open Iconic', 'core-extension' ) => 'openiconic',
					__( 'Typicons', 'core-extension' ) => 'typicons',
					__( 'Entypo', 'core-extension' ) => 'entypo',
					__( 'Linecons', 'core-extension' ) => 'linecons',
					__( 'Simple Line Icons', 'core-extension' ) => 'simplelineicons',
					__( 'Mono Social', 'core-extension' ) => 'monosocial',
					__( 'Material', 'core-extension' ) => 'material',
				),
				'admin_label' => true,
				'param_name' => 'type',
				'description' => __( 'Select icon library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_fontawesome',
				'value' => 'fa fa-adjust', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'fontawesome',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_openiconic',
				'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'openiconic',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'openiconic',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_typicons',
				'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'typicons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'typicons',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_entypo',
				'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'entypo',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'entypo',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_linecons',
				'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'linecons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'linecons',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_simplelineicons',
				'value' => 'icon-user-unfollow', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'simplelineicons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'simplelineicons',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'js_composer' ),
				'param_name' => 'icon_monosocial',
				'value' => 'vc-mono vc-mono-fivehundredpx', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'monosocial',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'monosocial',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_material',
				'value' => 'vc-material vc-material-cake',
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false,
					// default true, display an "EMPTY" icon?
					'type' => 'material',
					'iconsPerPage' => 4000,
					// default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'material',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				"type" => "colorpicker",
				"heading" => __('List icon color', 'core-extension'),
				"param_name" => "icon_color",
				"description" => __('Leave empty to use "Theme accent color"', 'core-extension')
			),
			array(
				"type" => "vc_link",
				"heading" => __('URL (Link)', 'core-extension'),
				"param_name" => "link",
			),
			array(
				"type" => "textarea",
				"heading" => __('List item text', 'core-extension'),
				"holder" => "div",
				"param_name" => "content",
				"value" => __('I am a list item', 'core-extension')
			),
			$add_css_animation,
			$add_css_animation_delay,
			array(
				"type" => "textfield",
				"heading" => __('Extra class name', 'core-extension'),
				"param_name" => "el_class",
				"description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension')
			)		
		),
		"js_view" => 'VcListItemView'
	) );


	// Service
	vc_map( array(
		"name" => __('Service', 'core-extension'),
		"base" => "vc_service",
		"icon" => "icon-wpb-vc_service",
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"weight" => 1,
		"description" => __('Service info with custom icon', 'core-extension'),
		"params" => array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Icon library', 'core-extension' ),
				'value' => array(
					__( 'Font Awesome', 'core-extension' ) => 'fontawesome',
					__( 'Open Iconic', 'core-extension' ) => 'openiconic',
					__( 'Typicons', 'core-extension' ) => 'typicons',
					__( 'Entypo', 'core-extension' ) => 'entypo',
					__( 'Linecons', 'core-extension' ) => 'linecons',
					__( 'Simple Line Icons', 'core-extension' ) => 'simplelineicons',
					__( 'Mono Social', 'core-extension' ) => 'monosocial',
					__( 'Material', 'core-extension' ) => 'material',
				),
				'admin_label' => true,
				'param_name' => 'type',
				'description' => __( 'Select icon library.', 'core-extension' ),
				"group" => __('Icon', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_fontawesome',
				'value' => 'fa fa-adjust', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'fontawesome',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
				"group" => __('Icon', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_openiconic',
				'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'openiconic',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'openiconic',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
				"group" => __('Icon', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_typicons',
				'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'typicons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'typicons',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
				"group" => __('Icon', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_entypo',
				'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'entypo',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'entypo',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
				"group" => __('Icon', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_linecons',
				'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'linecons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'linecons',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
				"group" => __('Icon', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_simplelineicons',
				'value' => 'icon-user-unfollow', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'simplelineicons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'simplelineicons',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
				"group" => __('Icon', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'js_composer' ),
				'param_name' => 'icon_monosocial',
				'value' => 'vc-mono vc-mono-fivehundredpx', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'monosocial',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'monosocial',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_material',
				'value' => 'vc-material vc-material-cake',
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false,
					// default true, display an "EMPTY" icon?
					'type' => 'material',
					'iconsPerPage' => 4000,
					// default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'material',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Icon color', 'core-extension'),
				"param_name" => "icon_color",
				"description" => __('Leave empty to use "Theme accent color"', 'core-extension'),
				"group" => __('Icon', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Title', 'core-extension'),
				"param_name" => "title",
				"holder" => "h4",
				"value" => __('Your service title', 'core-extension'),
				"group" => __('Content', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Heading color', 'core-extension'),
				"param_name" => "heading_color",
				"description" => __('Leave empty to use default heading color', 'core-extension'),
				"group" => __('Content', 'core-extension')
			),
			array(
				"type" => "textarea",
				"heading" => __('Service description', 'core-extension'),
				"holder" => "div",
				"param_name" => "content",
				"value" => __('I am service box text. Click edit button to change this text.', 'core-extension'),
				"group" => __('Content', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Description color', 'core-extension'),
				"param_name" => "descr_color",
				"description" => __('Leave empty to use default description color', 'core-extension'),
				"group" => __('Content', 'core-extension')
			),
			array(
				"type" => "vc_link",
				"heading" => __('URL (Link)', 'core-extension'),
				"param_name" => "link",
				"group" => __('Content', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Icon position', 'core-extension'),
				"param_name" => "icon_position",
				"value" => array( __('Left', 'core-extension') => "",
				                  __('Right', 'core-extension') => "sb_right",
				                  __('Top', 'core-extension') => "sb_center"),
				"group" => __('Icon', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Icon container shape', 'core-extension'),
				"param_name" => "icon_shape",
				"value" => array( __('Icon without container', 'core-extension') => "service-empty",
				                  __('Circle', 'core-extension') => "service-circle",
				                  __('Rounded square', 'core-extension') => "service-rounded",
				                  __('Square', 'core-extension') => "service-square",
				                  __('Rhomb', 'core-extension') => "service-rhomb",
				                  __('Hexagon', 'core-extension') => "service-hexagon"),
				"description" => __('Choose the shape of icon container.', 'core-extension'),
				"group" => __('Icon', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Background color', 'core-extension'),
				"param_name" => "bg_color",
				"description" => __('Leave empty for transparent background.', 'core-extension'),
				"group" => __('Icon', 'core-extension'),
				"dependency" => Array('element' => "icon_shape", 'value' => array('service-square', 'service-rounded', 'service-circle', 'service-rhomb', 'service-hexagon'))
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Border color', 'core-extension'),
				"param_name" => "border_color",
				"description" => __('Leave empty if you do not need a border.', 'core-extension'),
				"group" => __('Icon', 'core-extension'),
				"dependency" => Array('element' => "icon_shape", 'value' => array('service-square', 'service-rounded', 'service-circle', 'service-rhomb'))
			),
			array(
				"type" => "dropdown",
				'admin_label' => true,
				"heading" => __('Animation on hover', 'core-extension'),
				"param_name" => "icon_hover_1",
				"value" => array(
					__( 'No animation', 'core-extension' ) => '',
					__( 'Scale up', 'core-extension' ) => 'h-scale',
					__( 'Breathing', 'core-extension' ) => 'h-breathe',
					__( 'Sonar', 'core-extension' ) => 'h-sonar',
					__( 'To full opacity', 'core-extension' ) => 'ha_full-opacity',
					__( 'Bounce', 'core-extension' ) => 'ha_bounce',
					__( 'Shake', 'core-extension' ) => 'ha_shake',
					__( 'Swing', 'core-extension' ) => 'ha_swing',
					__( 'Tada', 'core-extension' ) => 'ha_tada',
					__( 'Wobble', 'core-extension' ) => 'ha_wobble',
					__( 'Pulse', 'core-extension' ) => 'ha_pulse'
				),
				"description" => __('Choose icon animation on mouse hover event. <br/>
									Sonar effect will only be visible if you set border or background color.', 'core-extension'),
				"group" => __('Misc', 'core-extension'),
				"dependency" => Array('element' => "icon_shape", 'value' => array('service-square', 'service-rounded', 'service-circle'))
			),
			array(
				"type" => "dropdown",
				"heading" => __('Animation on hover', 'core-extension'),
				"param_name" => "icon_hover_2",
				"value" => array( __('No animation', 'core-extension') => '',
				                  __('Scale up', 'core-extension') => 'h-scale',
				                  __('Breathing', 'core-extension') => 'h-breathe'),
				"description" => __('Choose icon animation on mouse hover event. <br/>
									Sonar effect will only be visible if you set border or background color.', 'core-extension'),
				"group" => __('Misc', 'core-extension'),
				"dependency" => Array('element' => "icon_shape", 'value' => array('service-empty', 'service-rhomb'))
			),
			$add_css_animation,
			$add_css_animation_delay,
			array(
				"type" => "textfield",
				"heading" => __('Extra class name', 'core-extension'),
				"param_name" => "el_class",
				"description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension'),
				"group" => __('Misc', 'core-extension')
			)
		),
		 "js_view" => 'VcCustomServiceView'

	) );


	// Horizontal divider
	vc_map( array(
		"name"		=> __('Divider', 'core-extension'),
		"base"		=> "vc_separator",
		"icon"		=> "icon-wpb-vc_divider",
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"weight"    => 1,
		"description" => __('Horizontal divider', 'core-extension'),
		"params" => array(
			array(
				"type" => "dropdown",
				"heading" => __('Type', 'core-extension'),
				"param_name" => "style",
				"value" => array(__('Simple line', 'core-extension') => "simple",
				                 __('Line with "To top" button', 'core-extension') => "line-to-top",
				                 __('TiLT branded', 'core-extension') => "tilt")
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Divider color', 'core-extension'),
				"param_name" => "color",
				"value" => '#ededed'
			),
			array(
				"type" => "textfield",
				"heading" => __('Divider width', 'core-extension'),
				"param_name" => "width",
				"value" => '100%',
				"description" => __('Width of divider line. Enter <code>px</code> or <code>%</code> in the end for the value to be in pixels or percentages, respectively. <br />
										<strong>Example:</strong> <code>200px</code> or <code>50%</code>', 'core-extension'),
				"dependency" => Array('element' => "style", 'value' => array('simple'))
			),
			array(
				"type" => "textfield",
				"heading" => __('Divider line thickness', 'core-extension'),
				"param_name" => "thickness",
				"value" => '1px',
				"description" => __('Thickness of divider line. Enter <code>px</code> in the end for a fixed thickness in pixels. <br />
										<strong>Example:</strong> <code>3px</code>', 'core-extension'),
				"dependency" => Array('element' => "style", 'value' => array('simple', 'line-to-top'))
			),
			array(
				"type" => "dropdown",
				"heading" => __('Size of divider', 'core-extension'),
				"param_name" => "size",
				"value" => array(__('Small', 'core-extension') => "small",
				                 __('Medium', 'core-extension') => "medium",
				                 __('Large', 'core-extension') => "large",
				                 __('Extra-large', 'core-extension') => "extralarge"),
				"dependency" => Array('element' => 'style', 'value' => 'tilt')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Alignment', 'core-extension'),
				"param_name" => "align",
				"value" => array(__('Left', 'core-extension') => "left",
				                 __('Right', 'core-extension') => "right",
				                 __('Center', 'core-extension') => "none"),
				"dependency" => Array('element' => 'style', 'value' => 'simple')
			),
			$add_css_animation,
			$add_css_animation_delay,
		)

	) );
	
	
	// Counter
	vc_map( array(
		"name"		=> __('Count To', 'core-extension'),
		"base"		=> "vc_counter",
		"icon"		=> "icon-wpb-vc_counter",
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"weight" => 1,
		"description" => __('Animated numerical data', 'core-extension'),
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __('Value you want to begin at', 'core-extension'),
				"param_name" => "from",
				"value" => "0",
				"description" => ''
			),			
			array(
				"type" => "textarea",
				"heading" => __('Value you want to arrive at', 'core-extension'),
				"param_name" => "to",
				"value" => "2000",
				"admin_label" => true,
				"description" => ''
			),			
			array(
				"type" => "textfield",
				"heading" => __('Duration in milliseconds', 'core-extension'),
				"param_name" => "speed",
				"value" => "1000",
				"description" => ''
			),			
			array(
				"type" => "textfield",
				"heading" => __('Interval', 'core-extension'),
				"param_name" => "interval",
				"value" => "10",
				"description" => __('How often the element should be updated', 'core-extension')
			),	
			array(
				"type" => "textfield",
				"heading" => __('Decimals', 'core-extension'),
				"param_name" => "decimals",
				"value" => "0",
				"description" => __('The number of decimal places to show', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Extra class name', 'core-extension'),
				"param_name" => "el_class",
				"description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Font size', 'core-extension'),
				"param_name" => "size",
				"value" => "50px",
				"description" => __('Choose the size of the number.', 'core-extension'),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Font weight', 'core-extension'),
				"param_name" => "weight",
				"value" => "400",
				"description" => __('Choose the weight of the number.', 'core-extension'),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __( 'Color', 'core-extension' ),
				"param_name" => "color",
				"value" => "#f4f4f3",
				"description" => __( 'Set the text color of the counter.', 'core-extension' ),
				"group" => __('Design', 'core-extension')
			),
			$add_css_animation,
			$add_css_animation_delay
		)

	) );
	
	
	// Pricing box
	vc_map( array(
		"name"		=> __('Pricing', 'core-extension'),
		"base"		=> "vc_pricing_box",
		"icon"		=> "icon-wpb-vc_pricing_box",
		"allowed_container_element" => false,
		"is_container" => true,
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"weight" => 1,
		"description" => __('Customizable pricing boxes', 'core-extension'),
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __( 'Title', 'core-extension' ),
				"param_name" => "title",
				"holder" => "h4",
				"description" => __( 'State the name of this pricing plan.', 'core-extension' ),
				"value" => __( 'Standard Pack', 'core-extension' ),
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Currency', 'core-extension' ),
				"param_name" => "currency",
				"holder" => "span",
				"description" => __( 'Enter currency symbol or text, e.g., $ or USD.', 'core-extension' ),
				"value" => __( '$', 'core-extension' )
			),	
			array(
				"type" => "textfield",
				"heading" => __( 'Price (nominal)', 'core-extension' ),
				"param_name" => "price_big",
				"holder" => "span",
				"description" => __( 'State the nominal (e.g. in dollars) price of this plan.', 'core-extension' ),
				"value" => __( '10', 'core-extension' )
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Price (composite)', 'core-extension' ),
				"param_name" => "price_small",
				"holder" => "span",
				"description" => __( 'State the composite (e.g. in cents) price of this plan.', 'core-extension' ),
				"value" => __( '99', 'core-extension' )
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Time', 'core-extension' ),
				"param_name" => "time",
				"holder" => "span",
				"description" => __( 'Choose time span for you plan, e.g., \'monthly\', \'per week\' or \'/yr\'.', 'core-extension' ),
				"value" => ''
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Meta', 'core-extension' ),
				"param_name" => "meta",
				"holder" => "span",
				"description" => __( 'A short precising desciption or slogan for the plan.', 'core-extension' ),
				"value" => __( 'Most popular choice', 'core-extension' )
			),
			array(
				"type" => "vc_link",
				"heading" => __( 'Add URL to the whole pricing box (optional). <br/>
								Users will be redirected via this link when they click on the box.', 'core-extension' ),
				"param_name" => "link",
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Extra class name', 'core-extension' ),
				"param_name" => "el_class",
				"description" => __( 'If you wish to style particular content element differently, use this field to add a class name and then refer to it in your css file.', 'core-extension' )
			),
			array(
				"type" => "dropdown",
				"heading" => __( 'Select style', 'core-extension' ),
				"param_name" => "box_style",
				"value" => array('Classic'      => 'box-classic',
								 'Minimalistic' => 'box-minimal',
				                 'Flat'         => 'box-flat',
				                 'Fancy'        => 'box-fancy'),
				"description" => __( 'Choose one of four available pricing box styles.', 'core-extension' ),
				"group" => __('Appearance', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __( 'Background color', 'core-extension' ),
				"param_name" => "bg_color",
				"value" => "#ffffff",
				"description" => __( 'Set background color for the body of this pricing box.', 'core-extension' ),
				"group" => __('Appearance', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __( 'Header background color', 'core-extension' ),
				"param_name" => "header_bg",
				"value" => "#262628",
				"description" =>  __( 'Set background color for the header of this pricing box.', 'core-extension' ),
				"dependency" => Array('element' => "box_style", 'value' => array('box-minimal', 'box-flat', 'box-fancy')),
				"group" => __('Appearance', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __( 'Header text color', 'core-extension' ),
				"param_name" => "header_color",
				"value" => "#ffffff",
				"description" => __( 'Set color for text inside box header area.', 'core-extension' ),
				"group" => __('Appearance', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __( 'Text color', 'core-extension' ),
				"param_name" => "color",
				"value" => "#262628",
				"description" => __( 'Set text color for pricing box content.', 'core-extension' ),
				"group" => __('Appearance', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __( 'Border color (optional)', 'core-extension' ),
				"param_name" => "border_color",
				"description" => __( 'Add an outer border to this pricing box. Leave empty for no border.', 'core-extension' ),
				"group" => __('Appearance', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Pricing box padding left and right', 'core-extension' ),
				"param_name" => "padding",
				"value" => __( '0px', 'core-extension' ),
				"description" => __( 'Set left and right padding of the pricing box.', 'core-extension' ),
				"group" => __('Appearance', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"param_name" => "add_badge",
				"description" => "Adds a customizable badge to this pricing box.",
				"value" => Array(__( 'Add badge to this box', 'core-extension' ) => 'on'),
				"group" => __('Badge', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __( 'Badge background color', 'core-extension' ),
				"param_name" => "badge_bg",
				"description" => __( 'Set background color for the badge.', 'core-extension' ),
				"dependency" => Array('element' => "add_badge", 'not_empty' => true),
				"group" => __('Badge', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __( 'Badge text color', 'core-extension' ),
				"param_name" => "badge_color",
				"value" => "#ffffff",
				"description" => __( 'Set text color for the badge.', 'core-extension' ),
				"dependency" => Array('element' => "add_badge", 'not_empty' => true),
				"group" => __('Badge', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Badge text', 'core-extension' ),
				"param_name" => "badge_text",
				"value" => __( 'Best Offer', 'core-extension' ),
				"description" => __( 'What do you want your badge to shout? , E.g., \'Hot Offer\', or \'Save 20%\'.', 'core-extension' ),
				"dependency" => Array('element' => "add_badge", 'not_empty' => true),
				"group" => __('Badge', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __( 'Hover effect', 'core-extension' ),
				"param_name" => "hover_effect",
				"value" => array('None' => '',
				                 'Emphasize' => 'box-effect-1',
				                 'Add Shadow' => 'box-effect-2',
				                 'Emphasize + Add Shadow' => 'box-effect-3',
				                 'Scale up' => 'box-effect-4',
				                 'Scale up + Add Shadow' => 'box-effect-5'),
				"description" => __( 'Enable and choose a hover effect.', 'core-extension' ),
				"group" => __('Misc', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __( 'Always active? (by default only on hover state)', 'core-extension' ),
				"param_name" => "effect_active",
				"value" => Array(__( 'Yes, please', 'core-extension' ) => 'box-effect-active'),
				"description" => __( 'Use this option, if you want to accentuate one of the boxes.', 'core-extension' ),
				"group" => __('Misc', 'core-extension')
			),
			$add_css_animation,
			$add_css_animation_delay
		),
		"js_view" => 'VcPricingView'
	) );	

	// Popover
	vc_map( array(
		"name"		=> __('Popover', 'core-extension'),
		"base"		=> "vc_tooltip",
		"icon"		=> "icon-wpb-vc_popover",
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"weight" => 1,
		"description" => __('Tooltip with custom content', 'core-extension'),
		"allowed_container_element" => false,
		"is_container" => true,
		"show_settings_on_create" => true,
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __( 'Title', 'core-extension' ),
				"param_name" => "title",
				"description" => __( 'Set the title of tooltip. If left empty, title bar will not be shown.', 'core-extension' )
			),
			array(
				"type" => "textarea",
				"heading" => __( 'Popover text', 'core-extension' ),
				"param_name" => "popover_content",
				"description" => __( 'Add custom tooltip content.', 'core-extension' )
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Width', 'core-extension' ),
				"param_name" => "width",
				"value" => "auto",
				"description" => __( 'Enter width you want this popover to be or leave <code>auto</code> value for auto width.<br/>
									Example: <code>300</code>', 'core-extension' )
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Height', 'core-extension' ),
				"param_name" => "height",
				"value" => "auto",
				"description" => __( 'Enter width you want this popover to be or leave <code>auto</code> value for auto height.<br/>
									Example: <code>300</code>', 'core-extension' )
			),
			array(
				"type" => "dropdown",
				"heading" => __( 'Placement', 'core-extension' ),
				"param_name" => "placement",
				"value" => array('Auto' => 'auto',
				                 'Top' => 'top',
				                 'Bottom' => 'bottom',
				                 'Left' => 'left',
				                 'Right' => 'right'),
				"description" => __( 'Choose where you want this tooltip to be shown', 'core-extension' )
			),
			array(
				"type" => "dropdown",
				"heading" => __( 'Trigger', 'core-extension' ),
				"param_name" => "trigger",
				"value" => array('On hover' => 'hover',
				                 'On click' => 'click'),
				"description" => __( 'Choose action on which this tooltip should be triggered', 'core-extension' )
			),
			array(
				"type" => "dropdown",
				"heading" => __( 'Style', 'core-extension' ),
				"param_name" => "style",
				"value" => array('Light' => '',
				                 'Dark' => 'inverse'),
				"description" => __( 'What style do you prefer?', 'core-extension' )
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Extra class name', 'core-extension' ),
				"param_name" => "el_class",
				"description" => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension' )
			)	
		),
		"js_view" => 'VcTooltipView'
	) );

	/* Toggle 2
	---------------------------------------------------------- */
	vc_map( array(
		'name' => __( 'FAQ', 'core-extension' ),
		'base' => 'vc_toggle',
		'icon' => 'icon-wpb-toggle-small-expand',
		'category' => __( 'Content', 'core-extension' ),
		'description' => __( 'Toggle element for Q&A block', 'core-extension' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'h4',
				'class' => 'vc_toggle_title',
				'heading' => __( 'Toggle title', 'core-extension' ),
				'param_name' => 'title',
				'value' => __( 'Toggle title', 'core-extension' ),
				'description' => __( 'Toggle block title.', 'core-extension' )
			),
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'class' => 'vc_toggle_content',
				'heading' => __( 'Toggle content', 'core-extension' ),
				'param_name' => 'content',
				'value' => __( '<p>Toggle content goes here, click edit button to change this text.</p>', 'core-extension' ),
				'description' => __( 'Toggle block content.', 'core-extension' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Default state', 'core-extension' ),
				'param_name' => 'open',
				'value' => array(
					__( 'Closed', 'core-extension' ) => 'false',
					__( 'Open', 'core-extension' ) => 'true'
				),
				'description' => __( 'Select "Open" if you want toggle to be open by default.', 'core-extension' )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'core-extension' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension' )
			),
			$add_css_animation,
			$add_css_animation_delay
		),
		'js_view' => 'VcToggleView'
	) );

	/* Magic Image */
	vc_map( array(
		'name' => __( 'Magic Image', 'core-extension' ),
		'base' => 'vc_magic_image',
		'icon' => 'icon-wpb-vc_magic_image',
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"weight" => 1,
		'description' => __( 'Magic multifunctional image', 'core-extension' ),
		'params' => array(
			array(
				'type' => 'attach_image',
				'heading' => __( 'Image', 'core-extension' ),
				'param_name' => 'image',
				'value' => '',
				'description' => __( 'Select image from media library.', 'core-extension' )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image size', 'core-extension' ),
				'param_name' => 'img_size',
				'description' => __( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)). Leave parameter empty to use "thumbnail" by default.', 'core-extension' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Image alignment', 'core-extension' ),
				'param_name' => 'alignment',
				'value' => array(
					__( 'Left', 'core-extension' ) => '',
					__( 'Right', 'core-extension' ) => 'right',
					__( 'Center', 'core-extension' ) => 'center'
				),
				'description' => __( 'Select image alignment.', 'core-extension' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Shadow decoration', 'core-extension' ),
				'param_name' => 'shadow',
				'value' => array(   __( 'No shadow', 'core-extension' )        => '',
									__( 'Light shadow', 'core-extension' )     => 'img_shadow_l',
									__( 'Medium shadow', 'core-extension' )    => 'img_shadow_m',
									__( 'Dark shadow', 'core-extension' )      => 'img_shadow_h'
								),
				'description' => __( 'Add shadow to image border.', 'core-extension' )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Corner radius', 'core-extension' ),
				'param_name' => 'radius',
				'value' => '0px',
				'description' => __( 'Enter preferred border radius. Don\'t forget to add <code>px</code> or <code>%</code>.', 'core-extension' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Add link to image', 'core-extension' ),
				'param_name' => 'img_link',
				'description' => __( 'Choose where the link will lead', 'core-extension' ),
				'value' => array('Don\'t add link' => '',
				                 'Link to another page'            => 'page_link',
				                 'Open image in popup window'      => 'image_popup',
				                 'Open gallery in popup window'    => 'gallery_popup',
				                 'Open video in popup window'      => 'video_popup'
				),
				"group" => __('Link', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Insert link to the content', 'core-extension' ),
				'param_name' => 'iframe_link',
				'dependency' => array('element' => 'img_link', 'value' => array('video_popup')),
				'description' => __( 'You can add link to <strong>Youtube</strong> video or <strong>Vimeo</strong> video.', 'core-extension' ),
				'group' => __('Link', 'core-extension')
			),
			array(
				'type' => 'attach_images',
				'heading' => __( 'Gallery images', 'core-extension' ),
				'param_name' => 'images',
				'value' => '',
				'dependency' => array('element' => 'img_link', 'value' => 'gallery_popup'),
				'description' => __( 'Select images from media library.', 'core-extension' ),
				"group" => __('Link', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Enable zoom effect on popup opening/closing?', 'core-extension'),
				"param_name" => "zoom",
				"value" => Array(__('Yes, please', 'core-extension') => 'true'),
				'dependency' => array('element' => 'img_link', 'value' => array('image_popup', 'gallery_popup', 'video_popup')),
				"group" => __('Link', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => __('Add icon based on link destination?', 'core-extension'),
				"param_name" => "icon",
				'value' => array('Don\'t add icon'                      => '',
				                 'Add icon'                             => 'img_icon',
				                 'Add icon shown only on image hover'   => 'img_icon_h'),
				'dependency' => array('element' => 'img_link', 'value' => array('page_link', 'image_popup', 'gallery_popup', 'video_popup')),
				'description' => __( 'Icon will be added on top of the picture.', 'core-extension' ),
				"group" => __('Link', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Position of the icon', 'core-extension' ),
				'param_name' => 'icon_position',
				'description' => __( 'Choose the position where the icon should appear.', 'core-extension' ),
				'dependency' => array('element' => 'icon', 'not_empty' => true),
				'value' => array('Center'               => 'icon-center',
				                 'Top right corner'     => 'icon-top-right',
				                 'Bottom right corner'  => 'icon-bot-right',
				                 'Bottom left corner'   => 'icon-bot-left',
				                 'Top left corner'      => 'icon-top-left'
				),
				"group" => __('Link', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Size of the icon', 'core-extension' ),
				'param_name' => 'icon_size',
				'description' => __( 'Choose how big the icon should be', 'core-extension' ),
				'dependency' => array('element' => 'icon', 'not_empty' => true),
				'value' => array('Small'        => 'icon-small',
				                 'Medium'       => 'icon-medium',
				                 'Large'        => 'icon-large',
				                 'Extra-large'  => 'icon-extralarge'
				),
				"group" => __('Link', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Icon color', 'core-extension'),
				"param_name" => "icon_color",
				'value' => '#ffffff',
				'dependency' => array('element' => 'icon', 'not_empty' => true),
				"group" => __('Link', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'How the link should be added?', 'core-extension' ),
				'param_name' => 'link_trigger',
				'description' => __( 'You can add link to the whole picture or to the icon only.', 'core-extension' ),
				'dependency' => array('element' => 'icon', 'not_empty' => true),
				'value' => array('To the whole picture' => 'link_image',
				                 'To the icon only'     => 'link_icon'),
				"group" => __('Link', 'core-extension')
			),
			array(
				'type' => 'vc_link',
				'heading' => __( 'Image link', 'core-extension' ),
				'param_name' => 'link',
				'dependency' => array('element' => 'img_link', 'value' => 'page_link'),
				"group" => __('Link', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Add effect on image hover', 'core-extension' ),
				'param_name' => 'image_hover',
				'value' => array('No effect'                    => '',
				                 'Opaque on hover'              => 'h_transparent',
				                 'Scale up on hover'            => 'h_scale_up',
				                 'Scale down on hover'          => 'h_scale_down'),
				"group" => __('Hover', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => __('Add color overlay?', 'core-extension'),
				"param_name" => "h_overlay",
				'value' => array('No overlay'                   => '',
				                 'Overlay appears on hover'     => 'overlay',
				                 'Overlay disappears on hover'  => 'overlay_h'),
				"group" => __('Hover', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Overlay color', 'core-extension'),
				"param_name" => "overlay_color",
				'value' => 'rgba(0,0,0,.2)',
				'dependency' => array('element' => 'h_overlay', 'not_empty' => true),
				"group" => __('Hover', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'core-extension' ),
				'param_name' => 'el_class',
				'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'core-extension' )
			),
			array(
				'type' => 'css_editor',
				'heading' => __( 'CSS box', 'core-extension' ),
				'param_name' => 'css',
				// 'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'core-extension' ),
				'group' => __( 'Design Options', 'core-extension' )
			),
			$add_css_animation,
			$add_css_animation_delay
		)
	) );

	// Carousel / Slider
	vc_map( array(
		"name"		=> __('Slider / Carousel', 'core-extension'),
		"base"		=> "vc_carousel",
		"icon"		=> "icon-wpb-vc_slider",
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"weight" => 1,
		"description" => __('Animated slider or carousel with images', 'core-extension'),
		"is_container" => false,
		"as_child" => array('only' => 'vc_tab,vc_column,vc_accordion_tab,vc_tta_section'),
		"show_settings_on_create" => true,
		"params" => array(
			array(
				'type' => 'attach_images',
				'heading' => __( 'Images', 'core-extension' ),
				'param_name' => 'images',
				'value' => '',
				'description' => __( 'Select images from media library.', 'core-extension' )
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Items shown per view', 'core-extension' ),
				"param_name" => "items_row",
				"value" => '1',
				"description" => __( 'Set the default number of items displayed at a time in a row.<br/>
										Entering <code>1</code> will make this element a slider', 'core-extension' )
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Enable responsiveness?', 'core-extension'),
				"param_name" => "responsive",
				"value" => Array(__('Yes, please', 'core-extension') => 'true'),
				"description" => __( 'Enables you to set the number of items per view displayed on each screen size.<br/>
										Number of items shown on large screen will be the default number of items.', 'core-extension' )
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Items per view on Tablet', 'core-extension' ),
				"param_name" => "items_tablet",
				"value" => '1',
				"description" => __( '768px - 1024px', 'core-extension' ),
				"dependency" => Array('element' => 'responsive', 'not_empty' => true)
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Items per view on Mobile', 'core-extension' ),
				"param_name" => "items_mobile",
				"value" => '1',
				"description" => __( 'smaller than 768px', 'core-extension' ),
				"dependency" => Array('element' => 'responsive', 'not_empty' => true)
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Image width', 'core-extension' ),
				"param_name" => "custom_width",
				"value" => '',
				"description" => __( 'Set custom image width in pixels to be used for image resizing.<br/>
										If left empty, real image width will be used (may result in carousel images having different height).', 'core-extension' )
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Image height', 'core-extension' ),
				"param_name" => "custom_height",
				"value" => '',
				"description" => __( 'Set custom image height in pixels to be used for image resizing.<br/>
										If left empty, real image height will be used (may result in carousel images having different height).', 'core-extension' )
			),
			array(
				"type" => "dropdown",
				"heading" => __( 'Slide transition', 'core-extension' ),
				"param_name" => "anim_style",
				"value" => array('Default slide' => 'slide',
				                 'Fade'          => 'fade'),
				"description" => __( 'Choose preferred transition between slides.', 'core-extension' ),
				"dependency" => Array('element' => 'items_row', 'value' => '1'),
				"group" => __('Animation', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Slide speed', 'core-extension' ),
				"param_name" => "slide_speed",
				"value" => "500",
				"description" => __( 'Slide speed in milliseconds.', 'core-extension' ),
				"group" => __('Animation', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Slide step', 'core-extension' ),
				"param_name" => "scroll_basis",
				"value" => '1',
				"description" => __( 'Define how many item columns should be swiped on each carousel swipe. Useful for items per column >1.', 'core-extension' ),
				"group" => __('Animation', 'core-extension')
			),
			array(
				"type" => 'textfield',
				"heading" => __('Carousel autoplay speed', 'core-extension'),
				"param_name" => "autoplay",
				"value" => '',
				"description" => __( 'Set time of carousel autoplay in milliseconds. Higher number means longer interval. Leave empty to disable autoplay.<br/>
									Example: <code>3000</code> for 3 second interval.
									', 'core-extension' ),
				"group" => __('Animation', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Stop on hover?', 'core-extension'),
				"param_name" => "stop_hover",
				"value" => Array(__('Yes, please', 'core-extension') => 'true'),
				"group" => __('Animation', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Disable mouse drag?', 'core-extension'),
				"param_name" => "mouse_drag",
				"value" => Array(__('Yes, please', 'core-extension') => 'true'),
				"group" => __('Animation', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Hide navigation buttons?', 'core-extension'),
				"param_name" => "navigation",
				"value" => Array(__('Yes, please', 'core-extension') => 'true'),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Hide pagination?', 'core-extension'),
				"param_name" => "pagination",
				"value" => Array(__('Yes, please', 'core-extension') => 'true'),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Hide pagination and navigation when not hovered?', 'core-extension'),
				"param_name" => "navigation_hide",
				"value" => Array(__('Yes, please', 'core-extension') => 'nav-hide'),
				"description" => __( 'If not checked, navigation and pagination will be hidden when mouse leaves the element.', 'core-extension' ),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __( 'Style', 'core-extension' ),
				"param_name" => "style",
				"value" => array('Classic'      => 'carousel-classic',
				                 'Minimalistic' => 'carousel-minimal'),
				"description" => __( 'Choose the preferred style.', 'core-extension' ),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __( 'Color style', 'core-extension' ),
				"param_name" => "color",
				"value" => array('Light' => 'carousel-light',
				                 'Dark'  => 'carousel-dark'),
				"description" => __( 'Choose the preferred color style.', 'core-extension' ),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __( 'Navigation position', 'core-extension' ),
				"param_name" => "position",
				"value" => array('Sideways'         => '',
				                 'Top right corner' => 'carousel-nav-top'),
				"description" => __( 'Choose the preferred positioning for navigation arrows.', 'core-extension' ),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Space between carousel items', 'core-extension' ),
				"param_name" => "space",
				"value" => "0",
				"description" => __( 'Carousel items will have empty space around them equal to this amount of pixels.<br/>
										Example: <code>5</code>.', 'core-extension' ),
				"group" => __('Design', 'core-extension')
			),
            array(
                'type' => 'textfield',
                'heading' => __( 'Corner radius', 'core-extension' ),
                'param_name' => 'radius',
                'value' => '0px',
                'description' => __( 'Enter preferred border radius. Don\'t forget to add <code>px</code> or <code>%</code>.', 'core-extension' ),
                "group" => __('Design', 'core-extension')
            ),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Add links to images', 'core-extension' ),
				'param_name' => 'img_link',
				'description' => __( 'Choose where the link will lead', 'core-extension' ),
				'value' => array(   'Don\'t add link' => '',
									'Link to another page'            => 'page_link',
									'Open gallery in popup window'    => 'gallery_popup'
				),
				"group" => __('Link', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Enable zoom effect on popup opening/closing?', 'core-extension'),
				"param_name" => "zoom",
				"value" => Array(__('Yes, please', 'core-extension') => 'true'),
				'dependency' => array('element' => 'img_link', 'value' => 'gallery_popup'),
				"group" => __('Link', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => __('Add an icon based on link destination?', 'core-extension'),
				"param_name" => "icon",
				'value' => array(	'Don\'t add icon'                      => '',
									'Add icon'                             => 'img_icon',
									'Add icon shown only on image hover'   => 'img_icon_h'),
				'dependency' => array('element' => 'img_link', 'value' => array('page_link', 'gallery_popup')),
				'description' => __( 'Icon will be added on top of the picture.', 'core-extension' ),
				"group" => __('Link', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Position of the icon', 'core-extension' ),
				'param_name' => 'icon_position',
				'description' => __( 'Choose the position where the icon should appear.', 'core-extension' ),
				'dependency' => array('element' => 'icon', 'not_empty' => true),
				'value' => array(   'Center'               => 'icon-center',
									'Top right corner'     => 'icon-top-right',
									'Bottom right corner'  => 'icon-bot-right',
									'Bottom left corner'   => 'icon-bot-left',
									'Top left corner'      => 'icon-top-left'
				),
				"group" => __('Link', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Icon color', 'core-extension'),
				"param_name" => "icon_color",
				'value' => '#ffffff',
				'dependency' => array('element' => 'icon', 'not_empty' => true),
				"group" => __('Link', 'core-extension')
			),
			array(
				'type' => 'exploded_textarea',
				'heading' => __( 'Image link', 'core-extension' ),
				'param_name' => 'link',
				'dependency' => array('element' => 'img_link', 'value' => 'page_link'),
				'description' => __( 'Enter page addresses to which the image links should lead. Each link should be entered on a new line and line number should correspond to index of an image in the slider.</br>
										<code><strong>Example:</strong></br>
										</br>
										http://www.google.com</br>
										http://www.facebook.com</br>
										http://www.linkedin.com</br>
										etc...</code>', 'core-extension' ),
				"group" => __('Link', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'How the link should open?', 'core-extension' ),
				'param_name' => 'target',
				'dependency' => array('element' => 'img_link', 'value' => 'page_link'),
				'value' => array(	'In the same tab' 	=> '_self',
									'In new tab'		=> '_blank'
				),
				"group" => __('Link', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Add effect on image hover', 'core-extension' ),
				'param_name' => 'image_hover',
				'value' => array(	'No effect'             => '',
									'Opaque on hover'    	=> 'h_transparent',
									'Scale up on hover'     => 'h_scale_up',
									'Scale down on hover'   => 'h_scale_down'),
				"group" => __('Hover', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => __('Add color overlay?', 'core-extension'),
				"param_name" => "h_overlay",
				'value' => array(	'No overlay'                   => '',
									'Overlay appears on hover'     => 'overlay',
									'Overlay disappears on hover'  => 'overlay_h'),
				"group" => __('Hover', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Overlay color', 'core-extension'),
				"param_name" => "overlay_color",
				'value' => 'rgba(0,0,0,.2)',
				'dependency' => array('element' => 'h_overlay', 'not_empty' => true),
				"group" => __('Hover', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Extra class name', 'core-extension' ),
				"param_name" => "el_class",
				"description" => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension' )
			)
		)
	) );

	// Info Box
	vc_map( array(
		"name" => __('Info Box', 'core-extension'),
		"base" => "vc_info_box",
		"icon" => "icon-wpb-vc_info_box",
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"weight" => 1,
		"description" => __('Animated information box', 'core-extension'),
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __('Heading', 'core-extension'),
				"param_name" => "heading",
				"group" => __('Content', 'core-extension')
			),
			array(
				"type" => "textarea",
				"heading" => __('Text content', 'core-extension'),
				"param_name" => "description",
				"holder" => "div",
				"group" => __('Content', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Icon library', 'core-extension' ),
				'value' => array(
					__( 'Font Awesome', 'core-extension' ) => 'fontawesome',
					__( 'Open Iconic', 'core-extension' ) => 'openiconic',
					__( 'Typicons', 'core-extension' ) => 'typicons',
					__( 'Entypo', 'core-extension' ) => 'entypo',
					__( 'Linecons', 'core-extension' ) => 'linecons',
					__( 'Simple Line Icons', 'core-extension' ) => 'simplelineicons',
					__( 'Mono Social', 'core-extension' ) => 'monosocial',
					__( 'Material', 'core-extension' ) => 'material',
				),
				'admin_label' => true,
				'param_name' => 'type',
				'description' => __( 'Select icon library.', 'core-extension' ),
				"group" => __('Content', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_fontawesome',
				'value' => 'fa fa-adjust', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'fontawesome',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
				"group" => __('Content', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_openiconic',
				'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'openiconic',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'openiconic',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
				"group" => __('Content', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_typicons',
				'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'typicons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'typicons',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
				"group" => __('Content', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_entypo',
				'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'entypo',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'entypo',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
				"group" => __('Content', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_linecons',
				'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'linecons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'linecons',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
				"group" => __('Content', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_simplelineicons',
				'value' => 'icon-user-unfollow', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'simplelineicons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'simplelineicons',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
				"group" => __('Content', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'js_composer' ),
				'param_name' => 'icon_monosocial',
				'value' => 'vc-mono vc-mono-fivehundredpx', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'monosocial',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'monosocial',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_material',
				'value' => 'vc-material vc-material-cake',
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false,
					// default true, display an "EMPTY" icon?
					'type' => 'material',
					'iconsPerPage' => 4000,
					// default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'material',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				"type" => "dropdown",
				"heading" => __('Add link to this info box?', 'core-extension'),
				"param_name" => "add_link",
				"value" => array(    __('Don\'t add link', 'core-extension') => "",
				                     __('Add button with link', 'core-extension') => "link_button",
				                     __('Add link to the whole info box', 'core-extension') => "link_box"),
				"group" => __('Link', 'core-extension')
			),
			array(
				"type" => "vc_link",
				"heading" => __('URL (Link)', 'core-extension'),
				"param_name" => "link",
				'description' => __( 'Add link to the whole info box.', 'core-extension' ),
				"dependency" => Array('element' => "add_link", 'value' => array('link_button', 'link_box')),
				"group" => __('Link', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Text on the button', 'core-extension'),
				"param_name" => "button",
				'description' => __( 'Enter the text to be displayed on the button, e.g. "Read more" or "Buy now".', 'core-extension' ),
				"dependency" => Array('element' => "add_link", 'value' => 'link_button'),
				"group" => __('Link', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Info box style', 'core-extension'),
				"param_name" => "ib_style",
				"value" => array( 	__('Basic', 'core-extension') => "",
									__('Minimalistic', 'core-extension') => "twc_ib_minimal",
									__('Flipbox', 'core-extension') => "twc_ib_flipbox"),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Background color', 'core-extension'),
				"param_name" => "bg_color",
				"description" => __('Leave empty for transparent background.', 'core-extension'),
				"dependency" => Array('element' => "ib_style", 'value' => array('twc_ib_flipbox', '')),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Different back side background color', 'core-extension'),
				"param_name" => "bg_color_back",
				"description" => __('Leave empty to use the main background color.', 'core-extension'),
				"dependency" => Array('element' => "ib_style", 'value' => 'twc_ib_flipbox'),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Border color', 'core-extension'),
				"param_name" => "border_color",
				"description" => __('Leave empty if you do not need a border.', 'core-extension'),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Icon color', 'core-extension'),
				"param_name" => "icon_color",
				"description" => __('Leave empty to use default icon color', 'core-extension'),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Icon container color', 'core-extension'),
				"param_name" => "icon_cont_color",
				"description" => __('Leave empty for transparent container background', 'core-extension'),
				"dependency" => Array('element' => "ib_style", 'value' => array('twc_ib_flipbox', '')),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Heading color', 'core-extension'),
				"param_name" => "heading_color",
				"description" => __('Leave empty to use default heading color', 'core-extension'),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Content color', 'core-extension'),
				"param_name" => "content_color",
				"description" => __('Leave empty to use default content color', 'core-extension'),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Button color', 'core-extension'),
				"param_name" => "button_color",
				"description" => __('Leave empty to use default button color', 'core-extension'),
				"dependency" => Array('element' => "ib_style", 'value' => array('twc_ib_flipbox', '')),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Accent color', 'core-extension'),
				"param_name" => "accent_color",
				"description" => __('Accent color is applied to certain info box elements on box hover', 'core-extension'),
				"dependency" => Array('element' => "ib_style", 'value' => 'twc_ib_minimal'),
				"group" => __('Design', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Corner radius', 'core-extension' ),
				'param_name' => 'radius',
				'value' => '0px',
				'description' => __( 'Enter preferred border radius. Don\'t forget to add <code>px</code> or <code>%</code>.', 'core-extension' ),
				"dependency" => Array('element' => "ib_style", 'value' => array('twc_ib_flipbox', '')),
				'group' => __('Design', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Shadow decoration', 'core-extension' ),
				'param_name' => 'shadow',
				'value' => array(   __( 'No shadow', 'core-extension' )        => '',
				                    __( 'Light shadow', 'core-extension' )     => 'ib_shadow_l',
				                    __( 'Medium shadow', 'core-extension' )    => 'ib_shadow_m',
				                    __( 'Dark shadow', 'core-extension' )      => 'ib_shadow_h'
				),
				'description' => __( 'Add shadow to info box border.', 'core-extension' ),
				"dependency" => Array('element' => "ib_style", 'value' => array('twc_ib_flipbox', '')),
				'group' => __('Design', 'core-extension')

			),
			$add_css_animation,
			$add_css_animation_delay,
			array(
				"type" => "textfield",
				"heading" => __('Extra class name', 'core-extension'),
				"param_name" => "el_class",
				"description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension'),
				"group" => __('Misc', 'core-extension')
			)
		)
	) );

	// Image Box
	vc_map( array(
		"name" => __('Image Box', 'core-extension'),
		"base" => "vc_image_box",
		"icon" => "icon-wpb-vc_image_box",
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"weight" => 1,
		"description" => __('Image box with text', 'core-extension'),
		"params" => array(
			array(
				'type' => 'attach_image',
				'heading' => __( 'Image', 'core-extension' ),
				'param_name' => 'image',
				'value' => '',
				'description' => __( 'Select image from media library.', 'core-extension' ),
				"group" => __('Image', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image size', 'core-extension' ),
				'param_name' => 'img_size',
				'description' => __( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)). Leave parameter empty to use "thumbnail" by default.', 'core-extension' ),
				"group" => __('Image', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Add effect on image box hover', 'core-extension' ),
				'param_name' => 'image_effect',
				'value' => array('No effect'                    => '',
				                 'Scale up on hover'            => 'h_scale_up',
				                 'Scale down on hover'          => 'h_scale_down'),
				"group" => __('Image', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => __('Add color overlay?', 'core-extension'),
				"param_name" => "h_overlay",
				'value' => array('No overlay'                       => '',
				                 'Overlay appears on box hover'     => 'overlay',
				                 'Overlay disappears on box hover'  => 'overlay_h'),
				"group" => __('Image', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Overlay color', 'core-extension'),
				"param_name" => "overlay_color",
				'value' => 'rgba(0,0,0,.2)',
				'dependency' => array('element' => 'h_overlay', 'not_empty' => true),
				"group" => __('Image', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Heading', 'core-extension'),
				"param_name" => "heading",
				"group" => __('Content', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Heading color', 'core-extension'),
				"param_name" => "heading_color",
				"description" => __('Leave empty to use default heading color', 'core-extension'),
				"group" => __('Content', 'core-extension')
			),
			array(
				"type" => "textarea",
				"heading" => __('Text content', 'core-extension'),
				"param_name" => "text",
				"group" => __('Content', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Text content color', 'core-extension'),
				"param_name" => "text_color",
				"description" => __('Leave empty to use default content color', 'core-extension'),
				"group" => __('Content', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Image box style', 'core-extension'),
				"param_name" => "style",
				"value" => array( 	 __('Standard', 'core-extension')       => "twc_imb_standard",
				                      __('Minimalistic', 'core-extension')   => "twc_imb_minimal",
				                      __('Modern', 'core-extension')         => "twc_imb_modern"),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => __('Text-align', 'core-extension'),
				"param_name" => "align",
				'value' => array('Center' => '',
				                 'Left'   => 'align-left',
				                 'Right'  => 'align-right'),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Background color', 'core-extension'),
				"param_name" => "bg_color",
				"description" => __('Leave empty for transparent background.', 'core-extension'),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Border color', 'core-extension'),
				"param_name" => "border_color",
				"description" => __('Leave empty if you do not need a border.', 'core-extension'),
				"group" => __('Design', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Corner radius', 'core-extension' ),
				'param_name' => 'radius',
				'value' => '0px',
				'description' => __( 'Enter preferred border radius. Don\'t forget to add <code>px</code> or <code>%</code>.', 'core-extension' ),
				'group' => __('Design', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Shadow decoration', 'core-extension' ),
				'param_name' => 'shadow',
				'value' => array(   __( 'No shadow', 'core-extension' )        => '',
				                    __( 'Light shadow', 'core-extension' )     => 'imb_shadow_l',
				                    __( 'Medium shadow', 'core-extension' )    => 'imb_shadow_m',
				                    __( 'Dark shadow', 'core-extension' )      => 'imb_shadow_h'
				),
				'description' => __( 'Add shadow to info box border.', 'core-extension' ),
				'group' => __('Design', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Add link to image box', 'core-extension' ),
				'param_name' => 'add_link',
				'description' => __( 'Choose where the link will lead', 'core-extension' ),
				'value' => array('Don\'t add link' => '',
				                 'Add link'                        => 'link',
				                 'Open image in popup window'      => 'image_popup',
				                 'Open gallery in popup window'    => 'gallery_popup',
				                 'Open video in popup window'      => 'video_popup'
				),
				"group" => __('Link', 'core-extension')
			),
			array(
				"type" => "vc_link",
				"heading" => __('URL (Link)', 'core-extension'),
				"param_name" => "link",
				'description' => __( 'Add link to the whole info box.', 'core-extension' ),
				"dependency" => Array('element' => 'add_link', 'value' => 'link'),
				"group" => __('Link', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Insert link to the content', 'core-extension' ),
				'param_name' => 'iframe_link',
				'dependency' => array('element' => 'add_link', 'value' => array('video_popup')),
				'description' => __( 'You can add link to <strong>Youtube</strong> video, <strong>Vimeo</strong> video or <strong>Google Maps</strong>.', 'core-extension' ),
				'group' => __('Link', 'core-extension')
			),
			array(
				'type' => 'attach_images',
				'heading' => __( 'Gallery images', 'core-extension' ),
				'param_name' => 'images',
				'value' => '',
				'dependency' => array('element' => 'add_link', 'value' => 'gallery_popup'),
				'description' => __( 'Select images from media library.', 'core-extension' ),
				"group" => __('Link', 'core-extension')
			),
			array(
				"type" => "checkbox",
				"heading" => __('Add trigger to image?', 'core-extension'),
				"param_name" => "link_image",
				"value" => Array(__('Yes, please', 'core-extension') => 'true'),
				"dependency" => Array('element' => 'add_link', 'value' => array('link', 'image_popup', 'gallery_popup', 'video_popup')),
				"group" => __('Link', 'core-extension')
			),
			array(
				"type" => "checkbox",
				"heading" => __('Add trigger to heading?', 'core-extension'),
				"param_name" => "link_heading",
				"value" => Array(__('Yes, please', 'core-extension') => 'true'),
				"dependency" => Array('element' => 'add_link', 'value' => array('link', 'image_popup', 'gallery_popup', 'video_popup')),
				"group" => __('Link', 'core-extension')
			),
			array(
				"type" => "checkbox",
				"heading" => __('Add trigger button?', 'core-extension'),
				"param_name" => "link_button",
				"value" => Array(__('Yes, please', 'core-extension') => 'true'),
				"dependency" => Array('element' => 'add_link', 'value' => array('link', 'image_popup', 'gallery_popup', 'video_popup')),
				"group" => __('Link', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __('Text on the button', 'core-extension'),
				"param_name" => "button",
				'description' => __( 'Enter the text to be displayed on the button, e.g. "Read more" or "Buy now".', 'core-extension' ),
				"dependency" => Array('element' => "link_button", 'value' => 'true'),
				"group" => __('Button', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Button text color', 'core-extension'),
				"param_name" => "b_text_color",
				"description" => __('Leave empty for default text color.', 'core-extension'),
				"dependency" => Array('element' => "link_button", 'value' => 'true'),
				"group" => __('Button', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Button background color', 'core-extension'),
				"param_name" => "b_bg_color",
				"description" => __('Leave empty for transparent background.', 'core-extension'),
				"dependency" => Array('element' => "link_button", 'value' => 'true'),
				"group" => __('Button', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Button border color', 'core-extension'),
				"param_name" => "b_border_color",
				"description" => __('Leave empty if you do not need a border.', 'core-extension'),
				"dependency" => Array('element' => "link_button", 'value' => 'true'),
				"group" => __('Button', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Corner radius', 'core-extension' ),
				'param_name' => 'b_radius',
				'value' => '0px',
				'description' => __( 'Enter preferred border radius. Don\'t forget to add <code>px</code> or <code>%</code>.', 'core-extension' ),
				"dependency" => Array('element' => "link_button", 'value' => 'true'),
				'group' => __('Button', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Button text color', 'core-extension'),
				"param_name" => "bh_text_color",
				"description" => __('Leave empty for default state text color.', 'core-extension'),
				"dependency" => Array('element' => "link_button", 'value' => 'true'),
				"group" => __('Button Hover', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Button background color', 'core-extension'),
				"param_name" => "bh_bg_color",
				"description" => __('Leave empty for default state background color.', 'core-extension'),
				"dependency" => Array('element' => "link_button", 'value' => 'true'),
				"group" => __('Button Hover', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Button border color', 'core-extension'),
				"param_name" => "bh_border_color",
				"description" => __('Leave empty for default state border color.', 'core-extension'),
				"dependency" => Array('element' => "link_button", 'value' => 'true'),
				"group" => __('Button Hover', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Corner radius', 'core-extension' ),
				'param_name' => 'bh_radius',
				'value' => '',
				'description' => __(    'Enter preferred border radius. Don\'t forget to add <code>px</code> or <code>%</code></br>
										Leave empty for default state corner radius.', 'core-extension' ),
				"dependency" => Array('element' => "link_button", 'value' => 'true'),
				'group' => __('Button Hover', 'core-extension')
			),
			$add_css_animation,
			$add_css_animation_delay,
			array(
				"type" => "textfield",
				"heading" => __('Extra class name', 'core-extension'),
				"param_name" => "el_class",
				"description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension'),
				"group" => __('Misc', 'core-extension')
			)
		)
	) );

	// Dropcaps
	vc_map( array(
		"name" => __('Dropcaps', 'core-extension'),
		"base" => "vc_dropcaps",
		"icon" => "icon-wpb-vc_dropcaps",
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"weight" => 1,
		"description" => __('Text block with a drop cap', 'core-extension'),
		"params" => array(
			array(
				"type" => "textarea",
				"heading" => __('Text content', 'core-extension'),
				"param_name" => "text",
				"group" => __('Content', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Text color', 'core-extension'),
				"param_name" => "text_color",
				"description" => __('Leave empty to use default text color', 'core-extension'),
				"group" => __('Content', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Size of drop cap', 'core-extension' ),
				'param_name' => 'size',
				'value' => '2',
				'description' => __( 'Enter the number of rows that the drop cap should take', 'core-extension' ),
				'group' => __('Dropcaps', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __('Drop cap style', 'core-extension'),
				"param_name" => "style",
				"value" => array( 	 __('Without container', 'core-extension') => "",
				                     __('With container', 'core-extension') => "twc_dc_container"),
				"group" => __('Dropcaps', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Drop cap color', 'core-extension'),
				"param_name" => "dc_color",
				"description" => __('Leave empty to make drop cap the same color as text', 'core-extension'),
				"group" => __('Dropcaps', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Container background color', 'core-extension'),
				"param_name" => "bg_color",
				"description" => __('Leave empty for transparent background.', 'core-extension'),
				"dependency" => Array('element' => "style", 'value' => 'twc_dc_container'),
				"group" => __('Dropcaps', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Border color', 'core-extension'),
				"param_name" => "border_color",
				"description" => __('Leave empty if you do not need a border.', 'core-extension'),
				"dependency" => Array('element' => "style", 'value' => 'twc_dc_container'),
				"group" => __('Dropcaps', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Corner radius', 'core-extension' ),
				'param_name' => 'radius',
				'value' => '0px',
				'description' => __( 'Enter preferred border radius. Don\'t forget to add <code>px</code> or <code>%</code>.', 'core-extension' ),
				"dependency" => Array('element' => "style", 'value' => 'twc_dc_container'),
				'group' => __('Dropcaps', 'core-extension')
			),
			$add_css_animation,
			$add_css_animation_delay,
			array(
				"type" => "textfield",
				"heading" => __('Extra class name', 'core-extension'),
				"param_name" => "el_class",
				"description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension'),
				"group" => __('Misc', 'core-extension')
			)
		)
	) );

	// Promo Box
	vc_map( array(
		"name" => __('Promo Box', 'core-extension'),
		"base" => "vc_promo_box",
		"icon" => "icon-wpb-vc_promo_box",
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"weight" => 1,
		"description" => __('Callout banner with text and button', 'core-extension'),
		"params" => array(
			array(
				"type" => "dropdown",
				"heading" => __('Promo box style', 'core-extension'),
				"param_name" => "style",
				"value" => array( 	 __('Simple', 'core-extension') => "twc_pb_simple",
				                      __('Boxed', 'core-extension') => "twc_pb_boxed",
				                      __('Centered', 'core-extension') => "twc_pb_centered"),
			),
			array(
				"type" => "textfield",
				"heading" => __('Heading', 'core-extension'),
				"param_name" => "heading"
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Heading color', 'core-extension'),
				"param_name" => "heading_color",
				"description" => __('Leave empty to use default heading color', 'core-extension')
			),
			array(
				"type" => "textarea",
				"heading" => __('Description', 'core-extension'),
				"param_name" => "text"
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Text color', 'core-extension'),
				"param_name" => "text_color",
				"description" => __('Leave empty to use default text color.', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Background color', 'core-extension'),
				"param_name" => "bg_color",
				"description" => __('Leave empty for transparent background.', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Border color', 'core-extension'),
				"param_name" => "border_color",
				"description" => __('Leave empty if you do not need a border.', 'core-extension'),
				"dependency" => Array('element' => "style", 'value' => 'twc_pb_boxed')
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Corner radius', 'core-extension' ),
				'param_name' => 'radius',
				'value' => '0px',
				'description' => __( 'Enter preferred border radius. Don\'t forget to add <code>px</code> or <code>%</code>.', 'core-extension' ),
				"dependency" => Array('element' => "style", 'value' => 'twc_pb_boxed'),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Shadow decoration', 'core-extension' ),
				'param_name' => 'shadow',
				'value' => array(   __( 'No shadow', 'core-extension' )        => '',
				                    __( 'Light shadow', 'core-extension' )     => 'img_shadow_l',
				                    __( 'Medium shadow', 'core-extension' )    => 'img_shadow_m',
				                    __( 'Dark shadow', 'core-extension' )      => 'img_shadow_h'
				),
				'description' => __( 'Adds shadow to promo box border.', 'core-extension' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Icon library', 'core-extension' ),
				'value' => array(
					__( 'Font Awesome', 'core-extension' ) => 'fontawesome',
					__( 'Open Iconic', 'core-extension' ) => 'openiconic',
					__( 'Typicons', 'core-extension' ) => 'typicons',
					__( 'Entypo', 'core-extension' ) => 'entypo',
					__( 'Linecons', 'core-extension' ) => 'linecons',
					__( 'Simple Line Icons', 'core-extension' ) => 'simplelineicons',
					__( 'Mono Social', 'core-extension' ) => 'monosocial',
					__( 'Material', 'core-extension' ) => 'material',
				),
				'admin_label' => true,
				'param_name' => 'type',
				'description' => __( 'Select icon library.', 'core-extension' ),
				"dependency" => Array('element' => "style", 'value' => array('twc_pb_boxed')),
				"group" => __('Icon', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_fontawesome',
				'value' => 'fa fa-adjust', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'fontawesome',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
				"group" => __('Icon', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_openiconic',
				'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'openiconic',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'openiconic',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
				"group" => __('Icon', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_typicons',
				'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'typicons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'typicons',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
				"group" => __('Icon', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_entypo',
				'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'entypo',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'entypo',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
				"group" => __('Icon', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_linecons',
				'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'linecons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'linecons',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
				"group" => __('Icon', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_simplelineicons',
				'value' => 'icon-user-unfollow', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'simplelineicons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'simplelineicons',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
				"group" => __('Icon', 'core-extension')
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'js_composer' ),
				'param_name' => 'icon_monosocial',
				'value' => 'vc-mono vc-mono-fivehundredpx', // default value to backend editor admin_label
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'monosocial',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'monosocial',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'core-extension' ),
				'param_name' => 'icon_material',
				'value' => 'vc-material vc-material-cake',
				'save_always' => true,
				'settings' => array(
					'emptyIcon' => false,
					// default true, display an "EMPTY" icon?
					'type' => 'material',
					'iconsPerPage' => 4000,
					// default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'type',
					'value' => 'material',
				),
				'description' => __( 'Select icon from library.', 'core-extension' ),
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Icon color', 'core-extension'),
				"param_name" => "icon_color",
				"description" => __('Leave empty to use default color.', 'core-extension'),
				"dependency" => Array('element' => "style", 'value' => array('twc_pb_boxed')),
				"group" => __('Icon', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Background color', 'core-extension'),
				"param_name" => "icon_bg_color",
				"description" => __('Leave empty for transparent background.', 'core-extension'),
				"dependency" => Array('element' => "style", 'value' => array('twc_pb_boxed')),
				"group" => __('Icon', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Border color', 'core-extension'),
				"param_name" => "icon_border_color",
				"description" => __('Leave empty if you do not need a border.', 'core-extension'),
				"dependency" => Array('element' => "style", 'value' => array('twc_pb_boxed')),
				"group" => __('Icon', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Corner radius', 'core-extension' ),
				'param_name' => 'icon_radius',
				'value' => '0px',
				'description' => __( 'Enter preferred border radius. Don\'t forget to add <code>px</code> or <code>%</code>.', 'core-extension' ),
				"dependency" => Array('element' => "style", 'value' => array('twc_pb_boxed')),
				"group" => __('Icon', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Text on the button', 'core-extension' ),
				'param_name' => 'b_text',
				'value' => 'Buy now',
				'description' => __( 'This text will be displayed on the button.', 'core-extension' ),
				'group' => __('Button', 'core-extension')
			),
			array(
				"type" => "vc_link",
				"heading" => __('URL (Link)', 'core-extension'),
				"param_name" => "link",
				"group" => __('Button', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Button text color', 'core-extension'),
				"param_name" => "b_text_color",
				"description" => __('Leave empty for default text color.', 'core-extension'),
				"group" => __('Button', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Button background color', 'core-extension'),
				"param_name" => "b_bg_color",
				"description" => __('Leave empty for transparent background.', 'core-extension'),
				"group" => __('Button', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Button border color', 'core-extension'),
				"param_name" => "b_border_color",
				"description" => __('Leave empty if you do not need a border.', 'core-extension'),
				"group" => __('Button', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Corner radius', 'core-extension' ),
				'param_name' => 'b_radius',
				'value' => '0px',
				'description' => __( 'Enter preferred border radius. Don\'t forget to add <code>px</code> or <code>%</code>.', 'core-extension' ),
				'group' => __('Button', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Button text color', 'core-extension'),
				"param_name" => "bh_text_color",
				"description" => __('Leave empty for default state text color.', 'core-extension'),
				"group" => __('Button Hover', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Button background color', 'core-extension'),
				"param_name" => "bh_bg_color",
				"description" => __('Leave empty for default state background color.', 'core-extension'),
				"group" => __('Button Hover', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Button border color', 'core-extension'),
				"param_name" => "bh_border_color",
				"description" => __('Leave empty for default state border color.', 'core-extension'),
				"group" => __('Button Hover', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Corner radius', 'core-extension' ),
				'param_name' => 'bh_radius',
				'value' => '',
				'description' => __(    'Enter preferred border radius. Don\'t forget to add <code>px</code> or <code>%</code></br>
										Leave empty for default state corner radius.', 'core-extension' ),
				'group' => __('Button Hover', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Add second button', 'core-extension'),
				"param_name" => "second_button",
				"value" => Array(__('Yes, please', 'core-extension') => 'true'),
				'group' => __('Button 2', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Text on the button', 'core-extension' ),
				'param_name' => 'b2_text',
				'value' => 'More info',
				'description' => __( 'This text will be displayed on the button.', 'core-extension' ),
				"dependency" => Array('element' => "second_button", 'value' => 'true'),
				'group' => __('Button 2', 'core-extension')
			),
			array(
				"type" => "vc_link",
				"heading" => __('URL (Link)', 'core-extension'),
				"param_name" => "link2",
				"dependency" => Array('element' => "second_button", 'value' => 'true'),
				"group" => __('Button 2', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Button text color', 'core-extension'),
				"param_name" => "b2_text_color",
				"description" => __('Leave empty for default text color.', 'core-extension'),
				"dependency" => Array('element' => "second_button", 'value' => 'true'),
				"group" => __('Button 2', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Button background color', 'core-extension'),
				"param_name" => "b2_bg_color",
				"description" => __('Leave empty for transparent background.', 'core-extension'),
				"dependency" => Array('element' => "second_button", 'value' => 'true'),
				"group" => __('Button 2', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Button border color', 'core-extension'),
				"param_name" => "b2_border_color",
				"description" => __('Leave empty if you do not need a border.', 'core-extension'),
				"dependency" => Array('element' => "second_button", 'value' => 'true'),
				"group" => __('Button 2', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Corner radius', 'core-extension' ),
				'param_name' => 'b2_radius',
				'value' => '0px',
				'description' => __( 'Enter preferred border radius. Don\'t forget to add <code>px</code> or <code>%</code>.', 'core-extension' ),
				"dependency" => Array('element' => "second_button", 'value' => 'true'),
				'group' => __('Button 2', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Button text color', 'core-extension'),
				"param_name" => "b2h_text_color",
				"description" => __('Leave empty for default state text color.', 'core-extension'),
				"dependency" => Array('element' => "second_button", 'value' => 'true'),
				"group" => __('Button 2 Hover', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Button background color', 'core-extension'),
				"param_name" => "b2h_bg_color",
				"description" => __('Leave empty for default state background color.', 'core-extension'),
				"dependency" => Array('element' => "second_button", 'value' => 'true'),
				"group" => __('Button 2 Hover', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Button border color', 'core-extension'),
				"param_name" => "b2h_border_color",
				"description" => __('Leave empty for default state border color.', 'core-extension'),
				"dependency" => Array('element' => "second_button", 'value' => 'true'),
				"group" => __('Button 2 Hover', 'core-extension')
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Corner radius', 'core-extension' ),
				'param_name' => 'b2h_radius',
				'value' => '',
				'description' => __(    'Enter preferred border radius. Don\'t forget to add <code>px</code> or <code>%</code></br>
										Leave empty for default state corner radius.', 'core-extension' ),
				"dependency" => Array('element' => "second_button", 'value' => 'true'),
				'group' => __('Button 2 Hover', 'core-extension')
			),
			$add_css_animation,
			$add_css_animation_delay,
			array(
				"type" => "textfield",
				"heading" => __('Extra class name', 'core-extension'),
				"param_name" => "el_class",
				"description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension'),
				"group" => __('Misc', 'core-extension')
			)
		)
	) );

	// Modal Window
	vc_map( array(
		"name"		=> __('Modal Window', 'core-extension'),
		"base"		=> "vc_modal",
		"icon"		=> "icon-wpb-vc_modal_window",
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"weight" => 1,
		"description" => __('Modal window with overlay', 'core-extension'),
		'allowed_container_element' => 'vc_row',
		"is_container" => true,
		"show_settings_on_create" => true,
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __( 'Modal window ID', 'core-extension' ),
				"param_name" => "id",
				"value" => "",
				"description" => __('Add <strong>ID</strong> to this modal window. The element triggering this modal shoud have <code>#modal-</code> in front of this ID in the URL.</br>
									 E.g. if your modal window ID is <code>description</code>, your trigger element URL should be <code>#modal-description</code>.', 'core-extension' )
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Modal window heading', 'core-extension' ),
				"param_name" => "heading",
				"value" => "",
				"description" => __('This text will be displayed in modal window header.', 'core-extension' )
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Maximum width', 'core-extension' ),
				"param_name" => "width",
				"value" => "600px",
				"description" => __(   'Enter maximum width you want this modal window to take. Don\'t forget to add <code>px</code> or <code>%</code>.', 'core-extension' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Background overlay effect', 'core-extension' ),
				'param_name' => 'overlay',
				'value' => array(   'Color overlay'         => '',
				                    'Background blur'       => 'blur',
				                    'Color overlay + blur'  => 'color_blur'),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Overlay color', 'core-extension'),
				"param_name" => "overlay_color",
				'value' => 'rgba(0,0,0,.6)',
				'dependency' => array('element' => 'overlay', 'value' => array('', 'color_blur')),
				"group" => __('Design', 'core-extension')
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Animation effect', 'core-extension' ),
				'param_name' => 'effect',
				'value' => array(   'Fade in'       => 'fade',
									'Slide down'    => 'slide-down',
				                    'Slide up'      => 'slide-up',
				                    'Scale down'    => 'scale-down',
									'Scale up'      => 'scale-up'),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Extra class name', 'core-extension' ),
				"param_name" => "el_class",
				"description" => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension' )
			)
		),
		"js_view" => 'VcModalView'
	) );

	// Image Gallery
	vc_map( array(
		"name"		=> __('Image Gallery', 'core-extension'),
		"base"		=> "vc_image_gallery",
		"icon"		=> "icon-wpb-vc_image_gallery",
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"weight" => 1,
		"description" => __('Responsive image gallery grid', 'core-extension'),
		"is_container" => false,
		"show_settings_on_create" => true,
		"params" => array(
			array(
				'type' => 'attach_images',
				'heading' => __( 'Images', 'core-extension' ),
				'param_name' => 'images',
				'value' => '',
				'description' => __( 'Select images from media library.', 'core-extension' )
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Space between images', 'core-extension' ),
				"param_name" => "space",
				"value" => "0",
				"description" => __( 'Images will have empty space around them equal to this amount of pixels.<br/>
										Example: <code>5</code>.', 'core-extension' )
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Image border color', 'core-extension'),
				"param_name" => "border",
				'value' => '',
				"description" => __( 'Choose the color of the border around each of the gallery items. Leave empty for no border.', 'core-extension' )
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Custom image width', 'core-extension' ),
				"param_name" => "custom_width",
				"value" => '',
				"description" => __(   'Set custom width in pixels to be used for image resizing. Example: <code>400</code></br>
										Leave empty to use the default value of <strong>300px</strong>.</br>
										<strong>Notice:</strong> your image size must not be smaller than the value used for resizing.', 'core-extension' ),
				"group" => __('Layout', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Custom image height', 'core-extension' ),
				"param_name" => "custom_height",
				"value" => '',
				"description" => __(   'Set custom height in pixels to be used for image resizing. Example: <code>400</code></br>
										Leave empty to use the default value of <strong>300px</strong>.</br>
										<strong>Notice:</strong> your image size must not be smaller than the value used for resizing.', 'core-extension' ),
				"group" => __('Layout', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Open image gallery in popup when user clicks on an image?', 'core-extension'),
				"param_name" => "popup",
				"value" => Array(__('Yes, please', 'core-extension') => 'true'),
			),
			array(
				"type" => "dropdown",
				"heading" => __( 'Items shown per view', 'core-extension' ),
				"param_name" => "items_row",
				'value' => array(   '3'     => '3',
									'4'     => '4',
				                    '6'     => '6',
				                    '8'     => '8',
									'9'     => '9',
									'12'    => '12'),
				"group" => __('Layout', 'core-extension'),
				"description" => __( 'Set the default number of items in a row.', 'core-extension' )
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Enable responsiveness?', 'core-extension'),
				"param_name" => "responsive",
				"value" => Array(__('Yes, please', 'core-extension') => 'true'),
				"description" => __( 'Enables you to set the number of items per view displayed on each screen size.<br/>
										Number of items shown on large screen will be the default number of items.', 'core-extension' ),
				"group" => __('Layout', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __( 'Items per view on Tablet', 'core-extension' ),
				"param_name" => "items_tablet",
				'value' => array(   '3'     => '3',
				                    '4'     => '4',
				                    '6'     => '6',
				                    '8'     => '8',
				                    '9'     => '9',
				                    '12'    => '12'),
				"description" => __( '768px - 1024px', 'core-extension' ),
				"group" => __('Layout', 'core-extension'),
				"dependency" => Array('element' => 'responsive', 'not_empty' => true)
			),
			array(
				"type" => "dropdown",
				"heading" => __( 'Items per view on Mobile', 'core-extension' ),
				"param_name" => "items_mobile",
				'value' => array(   '3'     => '3',
				                    '4'     => '4',
				                    '6'     => '6',
				                    '8'     => '8',
				                    '9'     => '9',
				                    '12'    => '12'),
				"description" => __( 'smaller than 768px', 'core-extension' ),
				"group" => __('Layout', 'core-extension'),
				"dependency" => Array('element' => 'responsive', 'not_empty' => true)
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Add effect on image hover', 'core-extension' ),
				'param_name' => 'image_hover',
				'value' => array(   'No effect'             => '',
				                    'Opaque on hover'    	=> 'h_transparent',
				                    'Scale up on hover'     => 'h_scale_up',
				                    'Scale down on hover'   => 'h_scale_down'),
				"group" => __('Hover', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => __('Add color overlay?', 'core-extension'),
				"param_name" => "h_overlay",
				'value' => array(	'No overlay'                   => '',
				                    'Overlay appears on hover'     => 'overlay',
				                    'Overlay disappears on hover'  => 'overlay_h'),
				"group" => __('Hover', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Overlay color', 'core-extension'),
				"param_name" => "overlay_color",
				'value' => 'rgba(0,0,0,.2)',
				'dependency' => array('element' => 'h_overlay', 'not_empty' => true),
				"group" => __('Hover', 'core-extension')
			),
			array(
				"type" => 'dropdown',
				"heading" => __('Add an icon based on link destination?', 'core-extension'),
				"param_name" => "icon",
				'value' => array(	 'Don\'t add icon'                      => '',
				                     'Add icon'                             => 'img_icon',
				                     'Add icon shown only on image hover'   => 'img_icon_h'),
				'description' => __( 'Icon will be added on top of the image.', 'core-extension' ),
				"group" => __('Icon', 'core-extension')
			),
			array(
				"type" => "colorpicker",
				"heading" => __('Icon color', 'core-extension'),
				"param_name" => "icon_color",
				'value' => '#ffffff',
				'dependency' => array('element' => 'icon', 'not_empty' => true),
				"group" => __('Icon', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Extra class name', 'core-extension' ),
				"param_name" => "el_class",
				"description" => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension' )
			)
		)
	) );

	// Content Slider
	$slide_id_1 = time() . '-1-' . rand( 0, 100 );
	$slide_id_2 = time() . '-2-' . rand( 0, 100 );
	vc_map( array(
		"name"		=> __('Content Slider', 'core-extension'),
		"base"		=> "vc_content_slider",
		"icon"		=> "icon-wpb-vc_content_slider",
		"category"  => array(__('Premium', 'core-extension'), __('Content', 'core-extension') ),
		"weight" => 1,
		"description" => __('Slider with shortcode elements inside', 'core-extension'),
		"allowed_container_element" => true,
		"is_container" => true,
		"as_parent" => array('only' => 'vc_content_slide'),
		"show_settings_on_create" => true,
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __( 'Slide speed', 'core-extension' ),
				"param_name" => "slide_speed",
				"value" => "500",
				"description" => __( 'Slider speed in milliseconds.', 'core-extension' ),
				"group" => __('Animation', 'core-extension')
			),
			array(
				"type" => 'textfield',
				"heading" => __('Slider autoplay speed', 'core-extension'),
				"param_name" => "autoplay",
				"value" => '',
				"description" => __( 'Set time of slider autoplay in milliseconds. Higher number means longer interval. Leave empty to disable autoplay.<br/>
									Example: <code>3000</code> for 3 second interval.
									', 'core-extension' ),
				"group" => __('Animation', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Stop on hover?', 'core-extension'),
				"param_name" => "stop_hover",
				"value" => Array(__('Yes, please', 'core-extension') => 'true'),
				"group" => __('Animation', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Disable mouse drag?', 'core-extension'),
				"param_name" => "mouse_drag",
				"value" => Array(__('Yes, please', 'core-extension') => 'true'),
				"group" => __('Animation', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Hide navigation buttons?', 'core-extension'),
				"param_name" => "navigation",
				"value" => Array(__('Yes, please', 'core-extension') => 'true'),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Hide pagination?', 'core-extension'),
				"param_name" => "pagination",
				"value" => Array(__('Yes, please', 'core-extension') => 'true'),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => 'checkbox',
				"heading" => __('Hide pagination and navigation when not hovered?', 'core-extension'),
				"param_name" => "navigation_hide",
				"value" => Array(__('Yes, please', 'core-extension') => 'nav-hide'),
				"description" => __( 'If not checked, navigation and pagination will be hidden when mouse leaves the element.', 'core-extension' ),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __( 'Style', 'core-extension' ),
				"param_name" => "style",
				"value" => array('Minimalistic' => 'slider-minimal',
				                 'Classic'      => 'slider-classic'),
				"description" => __( 'Choose the preferred style.', 'core-extension' ),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __( 'Color style', 'core-extension' ),
				"param_name" => "color",
				"value" => array('Dark'  => 'slider-dark',
				                 'Light' => 'slider-light'),
				"description" => __( 'Choose the preferred color style.', 'core-extension' ),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => "dropdown",
				"heading" => __( 'Navigation position', 'core-extension' ),
				"param_name" => "position",
				"value" => array('Sideways'         => '',
				                 'Top right corner' => 'slider-nav-top'),
				"description" => __( 'Choose the preferred positioning for navigation arrows.', 'core-extension' ),
				"group" => __('Design', 'core-extension')
			),
			array(
				"type" => "textfield",
				"heading" => __( 'Extra class name', 'core-extension' ),
				"param_name" => "el_class",
				"description" => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'core-extension' )
			)
		),
		'custom_markup' => '
							<div class="wpb_tabs_holder wpb_holder vc_container_for_children">
							<ul class="tabs_controls">
							</ul>
							%content%
							</div>'
		,
		'default_content' => '
								[vc_content_slide title="' . __( 'Slide-1', 'core-extension' ) . '" slide_id="' . $slide_id_1 . '"][/vc_content_slide]
								[vc_content_slide title="' . __( 'Slide-2', 'core-extension' ) . '" slide_id="' . $slide_id_2 . '"][/vc_content_slide]
								',
		"js_view" => 'VcContentSliderView'
	) );

	// Content Slide
	vc_map( array(
		'name' => __( 'Content Slide', 'core-extension' ),
		'base' => 'vc_content_slide',
		'allowed_container_element' => 'vc_row',
		"as_child" => array('only' => 'vc_content_slider'),
		'is_container' => true,
		'content_element' => false,
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Title', 'core-extension' ),
				'param_name' => 'title',
				'description' => __( 'Slide title.', 'core-extension' )
			),
			array(
				'type' => 'tab_id',
				'heading' => __( 'Slide ID', 'core-extension' ),
				'param_name' => "slide_id"
			),
		),
		'js_view' => 'VcContentSlideView'
	) );
}