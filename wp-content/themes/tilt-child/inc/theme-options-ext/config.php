<?php
/*	
*	---------------------------------------------------------------------
*	TWC Edit option panel
*	--------------------------------------------------------------------- 
*/

function collars_ot_header_logo() {
	return '<div class="dashicons dashicons-wordpress" style="font-size:22px; padding:4px 8px 0px 8px"></div>';
}
add_filter( 'ot_header_logo_link', 'collars_ot_header_logo', 10, 2 );

function collars_ot_header_version() {
	return 'Tilt Theme Options Panel - '. wp_get_theme()->get( 'Version' );
}
add_filter( 'ot_header_version_text', 'collars_ot_header_version', 10, 2 );

function collars_ot_upload_text() {
	return 'Add to Panel';
}
add_filter( 'ot_upload_text', 'collars_ot_upload_text', 10, 2 );


/*	
*	---------------------------------------------------------------------
*	TWC Edit option
*	--------------------------------------------------------------------- 
*/

function collars_radio_images( $array, $field_id ) {
	if ( $field_id == 'layout_style' ) {
		$array = array(
			array(
				'value'   => 'full-width',
				'label'   => __( 'Full width', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/full-width-layout.png'
			),
			array(
				'value'   => 'boxed',
				'label'   => __( 'Boxed layout', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/boxed-layout.png'
			)
		);
	} 
	
	if ( $field_id == 'header_style' ) {
		$array = array(
			array(
				'value'   => 'full-width',
				'label'   => __( 'Full width', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/header-layout-full.png'
			),
			array(
				'value'   => 'fixed-width',
				'label'   => __( 'Fixed width', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/header-layout-fixed.png'
			)
		);
	}	
	
	if ( $field_id == 'catalog_layout'  || $field_id == 'product_layout' || $field_id == 'post_layout' || $field_id == 'blog_layout' || $field_id == 'search_layout' || $field_id == 'portfolio_archive_layout' ) {
		$array = array(
			array(
				'value'   => 'full-width',
				'label'   => __( 'Full width', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/full-width-content.png'
			),			
			array(
				'value'   => 'right-sidebar',
				'label'   => __( 'Right sidebar', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/sidebar-right.png'
			),
			array(
				'value'   => 'left-sidebar',
				'label'   => __( 'Left sidebar', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/sidebar-left.png'
			)
		);
	}

	if ( $field_id == 'blog_template' ) {
		$array = array(
			array(
				'value'   => 'blog-tiled',
				'label'   => __( 'Tiled style', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/blog-tiled.png'
			),
			array(
				'value'   => 'blog-clear',
				'label'   => __( 'Clear style', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/blog-clear.png'
			),
			array(
				'value'   => 'blog-tilt',
				'label'   => __( 'Tilt branded style', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/blog-tilt.png'
			)
		);
	}
	
	if ( $field_id == 'background_pattern' ) {
		$array = array(
			array(
				'value'   => 'pattern_1',
				'label'   => __( 'Pattern 1', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_1.png'
			),
			array(
				'value'   => 'pattern_2',
				'label'   => __( 'Pattern 2', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_2.png'
			),
			array(
				'value'   => 'pattern_3',
				'label'   => __( 'Pattern 3', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_3.png'
			  ),
			array(
				'value'   => 'pattern_4',
				'label'   => __( 'Pattern 4', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_4.png'
			  ),
			array(
				'value'   => 'pattern_5',
				'label'   => __( 'Pattern 5', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_5.png'
			  ),
			array(
				'value'   => 'pattern_6',
				'label'   => __( 'Pattern 6', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_6.png'
			  ),
			array(
				'value'   => 'pattern_7',
				'label'   => __( 'Pattern 7', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_7.png'
			  ),
			array(
				'value'   => 'pattern_8',
				'label'   => __( 'Pattern 8', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_8.png'
			  ),
			array(
				'value'   => 'pattern_9',
				'label'   => __( 'Pattern 9', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_9.png'
			  ),
			array(
				'value'   => 'pattern_10',
				'label'   => __( 'Pattern 10', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_10.png'
			  ),
			array(
				'value'   => 'pattern_11',
				'label'   => __( 'Pattern 11', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_11.png'
			  ),
			array(
				'value'   => 'pattern_12',
				'label'   => __( 'Pattern 12', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_12.png'
			  ),
			array(
				'value'   => 'pattern_13',
				'label'   => __( 'Pattern 13', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_13.png'
			  ),
			array(
				'value'   => 'pattern_14',
				'label'   => __( 'Pattern 14', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_14.png'
			  ),
			array(
				'value'   => 'pattern_15',
				'label'   => __( 'Pattern 15', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_15.png'
			  ),
			array(
				'value'   => 'pattern_16',
				'label'   => __( 'Pattern 16', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_16.png'
			  ),
			array(
				'value'   => 'pattern_17',
				'label'   => __( 'Pattern 17', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_17.png'
			  ),
			array(
				'value'   => 'pattern_18',
				'label'   => __( 'Pattern 18', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_18.png'
			  ),	  
			array(
				'value'   => 'pattern_19',
				'label'   => __( 'Pattern 19', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_19.png'
			  ),
			array(
				'value'   => 'pattern_20',
				'label'   => __( 'Pattern 20', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_20.png'
			  ),
			array(
				'value'   => 'pattern_21',
				'label'   => __( 'Pattern 21', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_21.png'
			  ),	  
			array(
				'value'   => 'pattern_22',
				'label'   => __( 'Pattern 22', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_22.png'
			  ),
			array(
				'value'   => 'pattern_23',
				'label'   => __( 'Pattern 23', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_23.png'
			  ),
			array(
				'value'   => 'pattern_24',
				'label'   => __( 'Pattern 24', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_24.png'
			  ),
			array(
				'value'   => 'pattern_25',
				'label'   => __( 'Pattern 25', 'tilt' ),
				'src'	 => COLLARS_URI . '/inc/theme-options-ext/assets/patterns/pattern_25.png'
			  )
		);
	}
	
	return $array;
}
add_filter( 'ot_radio_images', 'collars_radio_images', 10, 2 );