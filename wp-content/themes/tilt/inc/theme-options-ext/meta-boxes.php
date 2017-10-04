<?php
/*	
*	---------------------------------------------------------------------
*	TWC Custom meta boxes
*	--------------------------------------------------------------------- 
*/


add_action( 'admin_init', 'collars_custom_meta_boxes' );

function collars_custom_meta_boxes() {

	if (is_plugin_active('revslider/revslider.php')) {
		global $wpdb;
		$rs = $wpdb->get_results(
			"
			SELECT id, title, alias
			FROM ".$wpdb->prefix."revslider_sliders
			ORDER BY id ASC LIMIT 999
			"
		);
		$revsliders = array();
		if ($rs) {
			foreach ( $rs as $slider ) {
				$revsliders[] = array('label' => $slider->title, 'value' => $slider->alias);
			}
		} else {
			$revsliders[] = array('label' => 'No sliders found', 'value' => '');
		}
	} else {
		$revsliders[] = array('label' => 'To use this option please install "Slider Revolution"', 'value' => '');
	}

	$rev_on_of = array(
		'label'       => __( 'Revolution slider', 'tilt' ),
		'id'          => 'rev_on_off',
		'type'        => 'on-off',
		'desc'        => 'Add Revolution slider before content.',
		'std'         => 'off',
		'condition'   => 'pre_content_activation:is(on)'
	);
	$rev_dropdown = array(
		'id'          => 'rev_slider_header',
		'label'       => __( 'Select slider', 'tilt' ),
		'desc'        => '',
		'std'         => '',
		'type'        => 'select',
		'choices'     => $revsliders,
		'operator'    => 'and',
		'condition'   => 'rev_on_off:is(on),pre_content_activation:is(on)'
	);

	$collars_meta_header = array(
		'id'          => 'collars_page_header_options',
		'title'       => __( 'Header Options', 'tilt' ),
		'desc'        => '',
		'pages'       => array( 'page', 'essential_grid', 'portfolio' ),
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(
			array(
				'id'          => 'meta_header',
				'label'       => __( 'Enable custom header', 'tilt' ),
				'desc'        => __( 'Enable different header stile for this particular page?', 'tilt' ),
				'std'         => 'off',
				'type'        => 'on-off',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'meta_menu_style',
				'label'       => __( 'Header style', 'tilt' ),
				'desc'        => __( 'Choose one of header styles.', 'tilt' ),
				'std'         => 'menu-light',
				'type'        => 'radio',
				'condition'   => 'meta_header:is(on)',
				'operator'    => 'and',
				'choices'     => array(
					array(
						'value'       => 'menu-light',
						'label'       => __( 'Light style', 'tilt' ),
						'src'         => ''
					),
					array(
						'value'       => 'menu-dark',
						'label'       => __( 'Dark style', 'tilt' ),
						'src'         => ''
					)
				)
			),
			array(
				'id'          => 'meta_menu_opacity',
				'label'       => __( 'Header opacity', 'tilt' ),
				'desc'        => __( 'Set background opacity for header. <br />0 = fully transparent and 100 = fully opaque.', 'tilt' ),
				'std'         => '100',
				'type'        => 'numeric-slider',
				'condition'   => 'meta_header:is(on)',
				'operator'    => 'and'
			),
			array(
				'id'          => 'meta_logo',
				'label'       => __( 'Logo', 'tilt' ),
				'desc'        => __( 'Please choose an image file for your logo.', 'tilt' ),
				'std'         => '',
				'type'        => 'upload',
				'condition'   => 'meta_header:is(on)',
				'operator'    => 'and'
			),
			array(
				'id'          => 'meta_logo_retina',
				'label'       => __( 'Logo (Retina version @2x)', 'tilt' ),
				'desc'        => __( 'Retina logo should be <code>2x</code> the size of default logo keeping the aspect ratio!', 'tilt' ),
				'std'         => '',
				'type'        => 'upload',
				'condition'   => 'meta_header:is(on)',
				'operator'    => 'and'
			),
			array(
				'id'          => 'meta_sticky_header',
				'label'       => __( 'Enable custom sticky header', 'tilt' ),
				'desc'        => __( 'Enable different sticky header stile for this particular page?', 'tilt' ),
				'std'         => 'off',
				'type'        => 'on-off',
				'condition'   => '',
				'operator'    => 'and'
			),
			array(
				'id'          => 'meta_sticky_menu_style',
				'label'       => __( 'Sticky header menu style', 'tilt' ),
				'desc'        => __( 'Choose header style when sticked to top.', 'tilt' ),
				'std'         => 'sticked-light',
				'type'        => 'radio',
				'condition'   => 'meta_sticky_header:is(on)',
				'operator'    => 'and',
				'choices'     => array(
					array(
						'value'       => 'sticked-light',
						'label'       => __( 'Light style', 'tilt' ),
						'src'         => ''
					),
					array(
						'value'       => 'sticked-dark',
						'label'       => __( 'Dark style', 'tilt' ),
						'src'         => ''
					)
				)
			),
			array(
				'id'          => 'meta_sticky_menu_opacity',
				'label'       => __( 'Sticky header opacity', 'tilt' ),
				'desc'        => __( 'Set background opacity for header sticked to top. <br />0 = fully transparent and 100 = fully opaque.', 'tilt' ),
				'std'         => '100',
				'type'        => 'numeric-slider',
				'condition'   => 'meta_sticky_header:is(on)',
				'operator'    => 'and'
			),
			array(
				'id'          => 'meta_sticky_logo',
				'label'       => __( 'Logo', 'tilt' ),
				'desc'        => __( 'Please choose an image file for your logo.', 'tilt' ),
				'std'         => '',
				'type'        => 'upload',
				'condition'   => 'meta_sticky_header:is(on)',
				'operator'    => 'and'
			),
			array(
				'id'          => 'meta_sticky_logo_retina',
				'label'       => __( 'Logo (Retina version @2x)', 'tilt' ),
				'desc'        => __( 'Retina logo should be <code>2x</code> the size of default logo keeping the aspect ratio!', 'tilt' ),
				'std'         => '',
				'type'        => 'upload',
				'condition'   => 'meta_sticky_header:is(on)',
				'operator'    => 'and'
			),
		)
	);

	$collars_meta_precontent = array(
		'id'          => 'collars_page_options',
		'title'       => __( 'Page Title / Pre-content Options', 'tilt' ),
		'desc'        => '',
		'pages'       => array( 'page', 'essential_grid' ),
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(
			array(
				'label'       => '',
				'id'          => 'dsc_textblock',
				'type'        => 'textblock',
				'desc'        => __( '<div class="section_warning"><strong>IMPORTANT!</strong><br/> Settings for "Blog" page will affect "Single Post" and "Archive" as well.<br/>
										Settings for main "WooCommerce shop" page will affect other standard WooCommerce pages as well.</div>', 'tilt' ),
				'condition'   => ''
			),
			array(
				'label'       => __( 'Enable Page title', 'tilt' ),
				'id'          => 'page_title',
				'type'        => 'on-off',
				'desc'        => 'Display or hide page title.',
				'std'         => 'off',
				'condition'   => ''
			),
			array(
				'label'       => __( 'Enable Pre-content area', 'tilt' ),
				'id'          => 'pre_content_activation',
				'type'        => 'on-off',
				'desc'        => __( 'Activates additional area before page title and main content.', 'tilt' ),
				'std'         => 'off'
			),
			array(
				'label'       => '',
				'id'          => 'pre_content_heading',
				'type'        => 'textblock',
				'desc'        => '<div class="section-title">'. __( 'Pre-content area options', 'tilt' ) .'</div>',
				'condition'   => 'pre_content_activation:is(on)'
			),
			array(
				'label'       => __( 'Height (optional)', 'tilt' ),
				'id'          => 'pre_content_height',
				'type'        => 'text',
				'desc'        => __( 'Pre-content area height. Don\'t forget to add <code>px</code>. Example: <code>250px</code>', 'tilt' ),
				'condition'   => 'pre_content_activation:is(on)'
			),
			$rev_on_of,
			$rev_dropdown,
			array(
				'id'          => 'pre_content_bg',
				'label'       => 'Background',
				'desc'        => 'Set custom background color or image.',
				'type'        => 'background',
				'rows'        => '',
				'condition'   => 'pre_content_activation:is(on)'
			),
			array(
				'label'       => __( 'Custom HTML', 'tilt' ),
				'id'          => 'pre_content_html',
				'type'        => 'textarea',
				'rows'        => '4',
				'desc'        => __( 'Insert any custom code you wish. Also <code>shortcodes</code> allowed!', 'tilt' ),
				'condition'   => 'pre_content_activation:is(on)'
			),
			array(
				'label'       => '',
				'id'          => 'slope_heading',
				'type'        => 'textblock',
				'desc'        => '<div class="section-title">'. __( 'Bottom slope decoration options', 'tilt' ) .'</div>',
				'condition'   => 'page_title:is(on),pre_content_activation:is(on)',
				'operator'    => 'or'
			),
			array(
				'id'          => 'title_slope_enable',
				'label'       => __( 'Enable title slope decoration?', 'tilt' ),
				'desc'        => __( 'Enables customizable slope decoration at the bottom of title section.', 'tilt' ),
				'std'         => 'off',
				'type'        => 'on-off',
				'condition'   => 'page_title:is(on),pre_content_activation:is(on)',
				'operator'    => 'or'
			),
			array(
				'id'          => 'title_slope_direction',
				'label'       => __( 'Direction of slope decoration', 'tilt' ),
				'desc'        => __( 'Choose the preferable direction of slope decoration of title section.', 'tilt' ),
				'std'         => 'left',
				'type'        => 'radio',
				'condition'   => 'page_title:is(on),pre_content_activation:is(on)',
				'operator'    => 'or',
				'choices'     => array(
					array(
						'value'       => 'left',
						'label'       => __( 'Left', 'tilt' ),
						'src'         => ''
					),
					array(
						'value'       => 'right',
						'label'       => __( 'Right', 'tilt' ),
						'src'         => ''
					)
				)
			),
			array(
				'id'          => 'title_slope_height',
				'label'       => __( 'Slope decoration height', 'tilt' ),
				'desc'        => __( 'Enter the height of title slope decoration. <br />
									Remember to add <code>px</code> value after the number. For example: <code>90px</code>px', 'tilt' ),
				'std'         => '100px',
				'type'        => 'text',
				'condition'   => 'page_title:is(on),pre_content_activation:is(on)',
				'operator'    => 'or'
			),
			array(
				'id'          => 'title_slope_color',
				'label'       => __( 'Title / Pre-content area slope decoration color', 'tilt' ),
				'desc'        => 'Set the color of slope decoration in \'Page title / Pre-content area\' (if enabled in theme options). <br/>
									If left blank, will match the default page color.',
				'type'        => 'colorpicker',
				'rows'        => '',
				'condition'   => 'page_title:is(on),pre_content_activation:is(on)',
				'operator'    => 'or'
			)
		)
	);

	$collars_meta_content = array(
		'id'          => 'collars_content_options',
		'title'       => __( 'Page content options', 'tilt' ),
		'desc'        => '',
		'pages'       => array( 'page', 'essential_grid' ),
		'context'     => 'normal',
		'priority'    => 'default',
		'fields'      => array(
			array(
				'label'       => __( 'Padding top', 'tilt' ),
				'id'          => 'content_padding_top',
				'type'        => 'text',
				'std'         => '0px',
				'desc'        => __( 'Enter distance from the top of the page to the content.
									<br/>Remember to add <code>px</code> in the end. Example: <code>30px</code>', 'tilt' ),
				'condition'   => ''
			),
			array(
				'label'       => __( 'Padding bottom', 'tilt' ),
				'id'          => 'content_padding_bottom',
				'type'        => 'text',
				'std'         => '0px',
				'desc'        => __( 'Enter distance from content to the bottom of the page.
									<br/>Remember to add <code>px</code> in the end. Example: <code>30px</code>', 'tilt' ),
				'condition'   => ''
			),
		)
	);

	$collars_meta_post = array(
		'id'          => 'collars_post_options',
		'title'       => __( 'Post Format Options', 'tilt' ),
		'desc'        => '',
		'pages'       => array( 'post' ),
		'context'     => 'normal',
		'priority'    => 'default',
		'fields'      => array(
			array(
				'label'       => __( 'Image link', 'tilt' ),
				'id'          => 'image_embed',
				'type'        => 'text',
				'desc'        => sprintf(__('Link to the image (if image post format selected).  Or use "Featured image" option instead. More about supported formats at %s.', 'tilt'), '<a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">WordPress codex</a>')
			),
			array(
				'label'       => __( 'Audio link', 'tilt' ),
				'id'          => 'audio_embed',
				'type'        => 'text',
				'desc'        => sprintf(__('Link to the audio (if audio post format selected). Or attach audio file to post instead. More about supported formats at %s.', 'tilt'), '<a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">WordPress codex</a>')
			),
			array(
				'label'       => __( 'Video link', 'tilt' ),
				'id'          => 'video_embed',
				'type'        => 'text',
				'desc'        => sprintf(__('Link to the video (if video post format selected). More about supported formats at %s.', 'tilt'), '<a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">WordPress codex</a>')
			),
			array(
				'label'       => '',
				'id'          => 'gallery_options_textblock',
				'type'        => 'textblock',
				'desc'        => '<div class="section-title">'. __( 'Gallery post format', 'tilt' ) .'</div>'
			),
			array(
				'id'          => 'gallery_animation',
				'label'       => __('Animation style', 'tilt' ),
				'desc'        => '',
				'std'         => 'fade',
				'type'        => 'radio',
				'desc'        => __( 'This option will determine the animation type of the slider', 'tilt' ),
				'choices'     => array(
					array(
						'value'       => 'fade',
						'label'       => __( 'Fade', 'tilt' ),
						'src'         => ''
					),
					array(
						'value'       => 'slide',
						'label'       => __( 'Slide', 'tilt' ),
						'src'         => ''
					)
				)
			),
			array(
				'label'       => __( 'Slide delay (milliseconds)', 'tilt' ),
				'id'          => 'gallery_delay',
				'type'        => 'text',
				'std'         => '4000',
				'desc'        => __( 'Set the speed of the slideshow cycling, in milliseconds', 'tilt' ),
			),
			array(
				'label'       => __( 'Slider height (px)', 'tilt' ),
				'id'          => 'gallery_height',
				'type'        => 'text',
				'std'         => '500',
			),
		)
	);

	$collars_meta_portfolio = array(
		'id'          => 'collars_portfolio_options',
		'title'       => __( 'Portfolio Item Options', 'tilt' ),
		'desc'        => '',
		'pages'       => array( 'portfolio' ),
		'context'     => 'side',
		'priority'    => 'core',
		'fields'      => array(
			array(
				'id'          => 'portfolio_layout',
				'label'       => __('Portfolio Item Layout', 'tilt' ),
				'std'         => 'fixed-width',
				'type'        => 'radio',
				'desc'        => '',
				'choices'     => array(
					array(
						'value'       => 'fixed-width',
						'label'       => __( 'Fixed width', 'tilt' ),
						'src'         => ''
					),
					array(
						'value'       => 'full-width',
						'label'       => __( 'Full width', 'tilt' ),
						'src'         => ''
					)
				)
			),
			array(
				'label'       => __( 'Featured Image In Post', 'tilt' ),
				'id'          => 'portfolio_featured_image',
				'type'        => 'on-off',
				'desc'        => '',
				'std'         => 'on'
			),
			array(
				'label'       => __( 'Image Width', 'tilt' ),
				'id'          => 'portfolio_image_width',
				'type'        => 'text',
				'desc'        => '',
				'std'         => '1200',
				'condition'   => 'portfolio_featured_image:is(on)'
			),
			array(
				'label'       => __( 'Image Height', 'tilt' ),
				'id'          => 'portfolio_image_height',
				'type'        => 'text',
				'desc'        => '',
				'std'         => '400',
				'condition'   => 'portfolio_featured_image:is(on)'
			),
		)
	);



	if ( function_exists( 'ot_register_meta_box' ) ) {
		ot_register_meta_box( $collars_meta_header );
		ot_register_meta_box( $collars_meta_precontent );
		ot_register_meta_box( $collars_meta_content );
		ot_register_meta_box( $collars_meta_post );
		ot_register_meta_box( $collars_meta_portfolio );
	}
}