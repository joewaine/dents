<?php

function collars_head_cleanup() {
	// category feeds
	// remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
	// remove WP version from css
	add_filter( 'style_loader_src', 'collars_remove_wp_ver_css_js', 9999 );
	// remove Wp version from scripts
	add_filter( 'script_loader_src', 'collars_remove_wp_ver_css_js', 9999 );

} /* end collars head cleanup */

// A better title
// http://www.deluxeblogtips.com/2012/03/better-title-meta-tag.html
function rw_title( $title, $sep, $seplocation ) {
  global $page, $paged;

  // Don't affect in feeds.
  if ( is_feed() ) return $title;

  // Add the blog's name
  if ( 'right' == $seplocation ) {
    $title .= get_bloginfo( 'name' );
  } else {
    $title = get_bloginfo( 'name' ) . $title;
  }

  // Add the blog description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );

  if ( $site_description && ( is_home() || is_front_page() ) ) {
    $title .= " {$sep} {$site_description}";
  }

  // Add a page number if necessary:
  if ( $paged >= 2 || $page >= 2 ) {
    $title .= " {$sep} " . sprintf( __( 'Page %s', 'tilt' ), max( $paged, $page ) );
  }

  return $title;

} // end better title

// remove WP version from RSS
function collars_rss_version() { return ''; }

// remove WP version from scripts
function collars_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}

// remove injected CSS for recent comments widget
function collars_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}

// remove injected CSS from recent comments widget
function collars_remove_recent_comments_style() {
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
	}
}

// remove injected CSS from gallery
function collars_gallery_style($css) {
	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}

// add excerpt field for pages
add_action( 'init', 'add_excerpts_to_pages' );
function add_excerpts_to_pages() {
	add_post_type_support( 'page', 'excerpt' );
}


/*********************
SCRIPTS & ENQUEUEING
*********************/

// loading modernizr and jquery, and reply script
function collars_scripts_and_styles() {

  global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way

  if (!is_admin()) {

		// Preloader
		wp_register_script( 'preloader-js', COLLARS_URI . '/library/js/preloader.js', array('jquery'), '', true);
		wp_register_style( 'preloader-style', COLLARS_URI . '/library/css/preloader.css', array(), '', 'all' );

		// modernizr (without media query polyfill)
		wp_register_script( 'collars-modernizr', COLLARS_URI . '/library/js/libs/modernizr.custom.min.js', array(), '2.5.3', false );

		// register main stylesheet
		wp_register_style( 'main', get_stylesheet_directory_uri() . '/style.css', array(), '', 'all' );

		// ie-only style sheet
		wp_register_style( 'collars-ie-only', COLLARS_URI . '/library/css/ie.css', array(), '' );

		// mmenu stylesheet
		wp_register_style( 'jquery.mmenu', COLLARS_URI . '/library/css/jquery.mmenu.css', array(), '', 'all' );


		// Comment reply script for threaded comments
		if ( is_single() AND comments_open() AND (get_option('thread_comments') == 1) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		if ( is_singular() AND comments_open() AND ot_get_option('page_comments') == 'on' ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Smooth scroll
		if ( ot_get_option('smooth_scroll') != 'off' ) :
			wp_register_script( 'jquery.smoothscroll', COLLARS_URI . '/library/js/libs/SmoothScroll.js', array('jquery'), '', true);
			wp_enqueue_script( 'jquery.smoothscroll' );
		endif;

		//adding scripts file in the footer
		wp_register_script( 'collars-js', COLLARS_URI . '/library/js/scripts.js', array( 'jquery' ), '', true );

		// Woocommerce style
		if (class_exists( 'WooCommerce' )){
			wp_register_style( 'my-woocommerce', COLLARS_URI . '/inc/woocommerce/woocommerce.css', null, 1.0, 'all' );
			wp_enqueue_style( 'my-woocommerce' );
		}

		// enqueue styles and scripts
		wp_enqueue_style( 'jquery.mmenu' );
		wp_enqueue_style( 'main' );
		wp_enqueue_style( 'collars-ie-only' );

		$wp_styles->add_data( 'collars-ie-only', 'conditional', 'lt IE 9' ); // add conditional wrapper around ie stylesheet

		wp_enqueue_script( 'collars-modernizr' );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'collars-js' );


		// Menu for small screens
		wp_register_script( 'jquery.mmenu-js', COLLARS_URI . '/library/js/libs/jquery.mmenu.js', array('jquery'), '', true);
		wp_enqueue_script( 'jquery.mmenu-js' );
		wp_localize_script( 'jquery.mmenu-js', 'objectL10n', array('title' => __( 'Menu', 'tilt' )) );
  }
}

/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function collars_theme_support() {

	// wp thumbnails (sizes handled in functions.php)
	add_theme_support( 'post-thumbnails' );

	// default thumb size
//	set_post_thumbnail_size(125, 125, true);

	// wp custom background (thx to @bransonwerner for update)
	add_theme_support( 'custom-background',
	    array(
	    'default-image' => '',    // background image default
	    'default-color' => '',    // background color default (dont add the #)
	    'wp-head-callback' => '_custom_background_cb',
	    'admin-head-callback' => '',
	    'admin-preview-callback' => ''
	    )
	);

	// rss thingy
	add_theme_support('automatic-feed-links');

	// to add header image support go here: http://themble.com/support/adding-header-background-image-support/

	// adding post format support
	add_theme_support( 'post-formats',
		array(
			'aside',             // title less blurb
			'gallery',           // gallery of images
			'link',              // quick link to other site
			'image',             // an image
			'quote',             // a quick quote
			'status',            // a Facebook like status update
			'video',             // video
			'audio',             // audio
			'chat'               // chat transcript
		)
	);

	function theme_slug_setup() {
		add_theme_support( 'title-tag' );
	}
	add_action( 'after_setup_theme', 'theme_slug_setup' );

	add_theme_support( 'custom-header' );

//	// wp menus
//	add_theme_support( 'menus' );
//
//	// registering wp3+ menus
//	register_nav_menus(
//		array(
//			'main-nav' => __( 'The Main Menu', 'tilt' ),   // main nav in header
//			'footer-links' => __( 'Footer Links', 'tilt' ) // secondary nav in footer
//		)
//	);
	// Register menu
	register_nav_menus( array(
		'primary' => __( 'Main Navigation', 'tilt' )
	) );
} /* end collars theme support */


/*********************
RELATED POSTS FUNCTION
*********************/

// Related Posts Function (call using collars_related_posts(); )
function collars_related_posts() {
	echo '<ul id="collars-related-posts">';
	global $post;
	$tags = wp_get_post_tags( $post->ID );
	if($tags) {
		foreach( $tags as $tag ) {
			$tag_arr .= $tag->slug . ',';
		}
		$args = array(
			'tag' => $tag_arr,
			'numberposts' => 5, /* you can change this to show more */
			'post__not_in' => array($post->ID)
		);
		$related_posts = get_posts( $args );
		if($related_posts) {
			foreach ( $related_posts as $post ) : setup_postdata( $post ); ?>
				<li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
			<?php endforeach; }
		else { ?>
			<?php echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'tilt' ) . '</li>'; ?>
		<?php }
	}
	wp_reset_postdata();
	echo '</ul>';
} /* end collars related posts function */

/*********************
PAGE NAVI
*********************/

// Numeric Page Navi (built into the theme by default)
function collars_page_navi() {
  global $wp_query;
  $bignum = 999999999;
  if ( $wp_query->max_num_pages <= 1 )
    return;
  echo '<nav class="pagination">';
  echo paginate_links( array(
    'base'         => str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
    'format'       => '',
    'current'      => max( 1, get_query_var('paged') ),
    'total'        => $wp_query->max_num_pages,
    'prev_text'    => '&larr;',
    'next_text'    => '&rarr;',
    'type'         => 'list',
    'end_size'     => 3,
    'mid_size'     => 3
  ) );
  echo '</nav>';
} /* end page navi */

/*********************
RANDOM CLEANUP ITEMS
*********************/

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function collars_filter_ptags_on_images($content){
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// This removes the annoying […] to a Read More link
function collars_excerpt_more($more) {
	global $post;
	// edit here if you like
	return '...  <div class="read-more"><a class="excerpt-read-more" href="'. get_permalink( $post->ID ) . '" title="'. __( 'Continue reading ', 'tilt' ) . esc_attr( get_the_title( $post->ID ) ).'">'. __( 'Read more', 'tilt' ) .'<i class="fa fa-angle-right"></i></a></div>';
}

// returns array of theme options with EG aliases
function twc_blog_grid_layout($id, $label) {
	$output = NULL;
	if ( class_exists('Essential_Grid') ) {
		$e_grids = new Essential_Grid();
		$grids = $e_grids->get_essential_grids();

		if(!empty($grids)) {
			$options = array(
				array(
					'value'       => '',
					'label'       => __( 'Don\'t use Essential Grid', 'tilt'),
					'src'         => ''
				)
			);
			foreach ( $grids as $grid ) {
				array_push($options, array(
					'value'       => $grid->handle,
					'label'       => $grid->name,
					'src'         => ''
				));
			}

			$output = array(
				'id'          => $id,
				'label'       => sprintf( __( '%s grid layout', 'tilt' ), $label ),
				'desc'        => __( 'Use Essential Grid to display entries. If selected, overrides "Blog template" option.', 'tilt' ),
				'std'         => '',
				'type'        => 'select',
				'section'     => 'layouts_design',
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'min_max_step'=> '',
				'class'       => '',
				'condition'   => '',
				'operator'    => 'and',
				'choices'     => $options
			);
		}
	}

	return $output;
}

?>
