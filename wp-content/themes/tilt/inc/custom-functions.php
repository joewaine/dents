<?php
/*
*	---------------------------------------------------------------------
*	TWC Custom functions
*	---------------------------------------------------------------------
*/


//Title slope decoration
if ( ! function_exists( 'collars_title_slope' ) ) {
	function collars_title_slope() {

		$page_id = get_the_ID();

		if ( is_front_page() && is_home() ) {
			// Default homepage
		} elseif ( is_front_page() ) {
			// static homepage
		} elseif ( class_exists( 'WooCommerce' ) && is_woocommerce() ) {
			$page_id = get_option( 'woocommerce_shop_page_id' );
		} elseif ( is_home() || is_single() || is_category() || is_tax() ||  is_tag() || is_archive() ) {
			$page_id = get_option('page_for_posts');
		}

		if ( wp_kses_post(get_post_meta( $page_id, 'title_slope_enable', true )) == 'on' ) :
			echo    '<div id="title-slope">
				<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">';
				if(wp_kses_post(get_post_meta( $page_id, 'title_slope_direction', true )) == 'left') :
					echo '<path d="M0 100 L100 0 L100 100 Z"></path>';
				elseif (wp_kses_post(get_post_meta( $page_id, 'title_slope_direction', true )) == 'right') :
					echo '<path d="M0 0 L100 100 L0 100 Z"></path>';
				endif;
			echo    '</svg></div><!--#header-slope-decoration-->';
		endif;
	}
}



// Additional buttons in Theme Options
if ( ! function_exists( 'ot_theme_options_support' ) ) {
	function ot_theme_options_support() {
		echo '	<div class="custom_links">
					<a class="custom_link" href="http://docs.whiteboxstud.io/tilt/" target="_blank">User manual</a>
					<a class="custom_link" href="https://whitebox.ticksy.com/" target="_blank">Support forum</a>
				</div>';
	}
}



// Post meta (blog view)
if ( ! function_exists( 'collars_post_meta' ) ) {
	function collars_post_meta() {

		echo '<div class="entry-meta">';

		echo '<div class="vline-wrapper"><div class="vline"></div></div>';
		echo '<div class="hline-wrapper"><div class="hline"></div></div>';


		if ( ot_get_option('post_date') != 'off' ) {
				echo    '<span class="meta-date">
							<div class="d">'. get_the_date('d') .'</div>
							<div class="my">'. get_the_date('M Y') .'</div>
						</span>';
			}

			if ( ot_get_option('post_author') != 'off' ) {
				echo '<span class="meta-author"><i class="icon-user"></i>' . '&nbsp;' . __( 'By', 'tilt' ) .' <a class="author-url" href="'. esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )) .'" title="'. esc_attr(sprintf( __( 'View all posts by %s', 'tilt' ), get_the_author() )) .'">'. get_the_author() .'</a></span>';
			}

			if ( ot_get_option('post_category') != 'off' ) {
				echo '<span class="meta-category"><i class="icon-folder-alt"></i>' , the_category( ', ' ) .'</span>';
			}


			if ( ot_get_option('post_comments') != 'off' ) {
				echo '<span class="meta-comments"><i class="icon-bubble"></i>', comments_popup_link( __( 'Leave a comment', 'tilt' ), __( '1 Comment', 'tilt' ), __( '% Comments', 'tilt' ) ) .'</span>';
			}

			echo '</div>';

	}
}


// Post meta (single post view)
if ( ! function_exists( 'collars_post_meta_footer' ) ) {
	function collars_post_meta_footer() {

		if( ot_get_option('post_date') == 'off' && ot_get_option('post_category') == 'off' && ot_get_option('post_author') == 'off' && ot_get_option('post_comments') == 'off' && ( !has_tag() || ot_get_option('post_tags') == 'off') ) return;

//		if( is_single() ){
			echo '<div class="entry-meta-footer">';

			echo '<div class="vline-wrapper"><div class="vline"></div></div>';
			echo '<div class="hline-wrapper"><div class="hline"></div></div>';

			if ( ot_get_option('post_date') != 'off' ) {
				echo    '<span class="meta-date">
							<div class="d">'. get_the_date('d') .'</div>
							<div class="my">'. get_the_date('M Y') .'</div>
						</span>';
			}

			if ( ot_get_option('post_author') != 'off' ) {
				echo '<span class="meta-author"><i class="icon-user"></i>' . __( 'By', 'tilt' ) . ' <a class="url fn n" href="'. esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )) .'" title="'. esc_attr(sprintf( __( 'View all posts by %s', 'tilt' ), get_the_author() )) .'">'. get_the_author() .'</a></span>';
			}

			if ( ot_get_option('post_category') != 'off' ) {
				echo '<span class="meta-category"><i class="icon-folder-alt"></i>', the_category( ', ' ) .'</span>';
			}

			if ( ot_get_option('post_comments') != 'off' ) {
				echo '<span class="meta-comments"><i class="icon-bubble"></i>', comments_popup_link( __( 'Leave a comment', 'tilt' ), __( '1 Comment', 'tilt' ), __( '% Comments', 'tilt' ) ) .'</span>';
			}

			echo '</div>';
//		}
	}
}

// TiLT post slope decoration
if ( ! function_exists( 'collars_post_slope_top' ) ) {
	function collars_post_slope_top() {

		$blog_template = ot_get_option('blog_template');

		if ( $blog_template == 'blog-tilt' ) {
			echo    '<div class="post-slope-top">
						<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
							<path d="M0 100 L100 100 L100 0 L0 95 Z"></path>
						</svg>
					</div>';
		}
	}
}

if ( ! function_exists( 'collars_post_slope_bot' ) ) {
	function collars_post_slope_bot() {

		$blog_template = ot_get_option('blog_template');

		if ( $blog_template == 'blog-tilt' ) {
			echo    '<div class="post-slope-bot">
						<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
							<path d="M0 0 L100 0 L100 5 L0 100 "></path>
						</svg>
					</div>';
		}
	}
}


// Post next/previous links
if ( ! function_exists( 'collars_post_links' ) ) {
	function collars_post_links() {
		if( is_single() && ot_get_option('post_links') != 'off' ){
			echo '<div class="post-arrows">';

				$prev_post = get_previous_post();
				$next_post = get_next_post();

				if(!empty( $prev_post )) {
					echo '<div class="button-wrapper-left">
							<i class="fa fa-angle-left"></i>'; previous_post_link('<span class="previous_post_link">%link</span>');
					echo   '</div>';
				}
				if(!empty( $next_post )) {
					echo '<div class="button-wrapper-right">
								<i class="fa fa-angle-right"></i>'; next_post_link('<span class="next_post_link">%link</span>');
					echo '</div>';
				}
			echo '</div>';
		}
	}
}

// Hex Color to RGB
function collars_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return implode(",", $rgb); // returns the rgb values separated by commas
}


/* Reading config */
function collars_blog_config($query) {

// Exclude category from blog and search view
$exclude_cat_ids = ot_get_option('exclude_from_blog');
if( $exclude_cat_ids ){
	if ( $query->is_home || $query->is_search ) {
		foreach( $exclude_cat_ids as $exclude_cat_id ) {
			$exclude_from_blog[] = '-'. $exclude_cat_id;
		}
		$query->set( 'cat', implode(',', $exclude_from_blog) );
	}
}

// Change post count in search page
if ( $query->is_search() ) {
	$query->set( 'posts_per_page', '20' );
}

return $query;
}
add_filter('pre_get_posts', 'collars_blog_config');


// Slider Revolution Theme Mode
if(function_exists( 'set_revslider_as_theme' )){
	add_action( 'init', 'collars_revslider_theme_mode' );
	function collars_revslider_theme_mode() {
		set_revslider_as_theme();
	}
}

// Slider Essential Grid Theme Mode
if(function_exists( 'set_ess_grid_as_theme' )){
	add_action( 'init', 'collars_essgrid_theme_mode' );
	function collars_essgrid_theme_mode() {
		set_ess_grid_as_theme();
	}
}

// Allow shortcodes in widgets
add_filter( 'widget_text', 'shortcode_unautop' );
add_filter( 'widget_text', 'do_shortcode' );

/**
 * Filters the required title field's label.
 */
if( ! function_exists( 'twc_filter_list_item_title_label' )) {
	function twc_filter_list_item_title_label($label, $id)
	{
		if ($id == 'custom_fonts') {
			$label = __('Font name (required)', 'tilt');
		}
		return $label;
	}
}
add_filter( 'ot_list_item_title_label', 'twc_filter_list_item_title_label', 10, 2 );

/**
 * Filters the required title field's description.
 */
if( ! function_exists( 'twc_filter_list_item_title_desc' )) {
	function twc_filter_list_item_title_desc($label, $id)
	{
		if ($id == 'custom_fonts') {
			$label = __('Font name will be used when setting a font and will be displayed in the list of available fonts.', 'tilt');
		}
		return $label;
	}
}
add_filter( 'ot_list_item_title_desc', 'twc_filter_list_item_title_desc', 10, 2 );


// check if custom font
if( ! function_exists( 'twc_check_if_custom_font' )) {
	function twc_check_if_custom_font($custom_font) {
		$custom_fonts = ot_get_option('custom_fonts');
		$custom_font = str_replace("+", " ", $custom_font);
		$is_custom = false;

		if ( $custom_fonts !== '' ) {
			foreach ( (array) $custom_fonts as $font ) {
				if ( isset($font['title']) && $font['title'] === $custom_font ) {
					$is_custom = true;
				}
			}
		}

		return $is_custom;
	}
}