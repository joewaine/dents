<?php

require_once( 'library/collars.php' );

/*********************
LAUNCH TiLT
Let's get everything up and running.
*********************/

// Define constants
define('COLLARS_PATH', get_template_directory());
define('COLLARS_URI', get_template_directory_uri());
define('COLLARS_INCLUDE', get_template_directory() . '/inc');
define('COLLARS_ADMIN', get_template_directory() . '/inc/theme-options');
define('COLLARS_ADMIN_EXT', get_template_directory() . '/inc/theme-options-ext');
define('COLLARS_PLUGINS', get_template_directory() . '/inc/plugins');


// Theme setup
require_once(COLLARS_INCLUDE . '/theme-setup.php');
require_once(COLLARS_INCLUDE . '/custom-functions.php');
require_once(COLLARS_INCLUDE . '/sidebars.php');
require_once(COLLARS_INCLUDE . '/plugin-activation/tgm-register-plugins.php');

//Plugins
require_once(COLLARS_PLUGINS . '/importer/importer.php');
require_once(COLLARS_PLUGINS . '/per-page-sidebars.php');
require_once(COLLARS_PLUGINS . '/breadcrumbs.php');

// WooCommerce
require_once(COLLARS_INCLUDE . '/woocommerce/woofunctions.php');

// Theme options
add_filter( 'ot_theme_mode', '__return_true' );
add_filter( 'ot_show_pages', '__return_false' );
require(COLLARS_ADMIN . '/ot-loader.php');
require(COLLARS_ADMIN_EXT . '/config.php');
require(COLLARS_ADMIN_EXT . '/theme-options.php' );
require(COLLARS_ADMIN_EXT . '/typography.php' );
require(COLLARS_ADMIN_EXT . '/meta-boxes.php' );


function collars_setup() {

	//Allow editor style.
	add_editor_style();

	// launching operation cleanup
	add_action( 'init', 'collars_head_cleanup' );
	// A better title
	add_filter( 'wp_title', 'rw_title', 10, 3 );
	// remove WP version from RSS
	add_filter( 'the_generator', 'collars_rss_version' );
	// remove pesky injected css for recent comments widget
	add_filter( 'wp_head', 'collars_remove_wp_widget_recent_comments_style', 1 );
	// clean up comment styles in the head
	add_action( 'wp_head', 'collars_remove_recent_comments_style', 1 );
	// clean up gallery output in wp
	add_filter( 'gallery_style', 'collars_gallery_style' );

	// enqueue base scripts and styles
	add_action( 'wp_enqueue_scripts', 'collars_scripts_and_styles' );
	// ie conditional wrapper

	// launching this stuff after theme setup
	collars_theme_support();

	// cleaning up random code around images
//	add_filter( 'the_content', 'collars_filter_ptags_on_images' );
	// cleaning up excerpt
	add_filter( 'excerpt_more', 'collars_excerpt_more' );

	// Enqueue custom styles from back-end
	require_once(COLLARS_PATH . '/dynamic-styles.php');

	// let's get language support going, if you need it
	load_theme_textdomain( 'tilt', get_template_directory() . '/languages' );


	// define the embed_head callback
	function twc_embed_head() {
		echo ot_get_option('twc_oembed_head');
	};
	if ( ot_get_option('twc_oembed_enable') === 'on' && ot_get_option('twc_oembed_head') !== '' ) {
	add_action( 'embed_head', 'twc_embed_head', 10, 0 );
	}

	// define the embed_footer callback
	function twc_embed_footer() {
		echo ot_get_option('twc_oembed_footer');
	};
	if ( ot_get_option('twc_oembed_enable') === 'on' && ot_get_option('twc_oembed_footer') !== '' ) {
		add_action( 'embed_footer', 'twc_embed_footer', 10, 0 );
	}

	// Remove the embed query var.
	if ( ot_get_option('twc_oembed_enable') !== 'on') {
		global $wp;
		$wp->public_query_vars = array_diff( $wp->public_query_vars, array(
			'embed',
		) );
	}

} /* end collars ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'collars_setup' );


/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
	$content_width = 1200;
}


/************* COMMENT LAYOUT *********************/

// Comment Layout
function collars_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php // end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'tilt' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'tilt' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'tilt' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'tilt' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!


// override WP's default toolbar top margin
add_action( 'wp_head', 'admin_bar', 11 );
function admin_bar() {
    if ( is_admin_bar_showing() ) : ?>
	    <style type="text/css" media="screen">
		    html {
			    margin-top: 0px !important;
		    }

		    * html body {
			    margin-top: 0px !important;
		    }

		    @media screen and (max-width: 600px) {
				.admin-bar #header-wrapper {
					position: absolute;
				}

			    .admin-bar #header-wrapper.header-sticked {
				    top: 0 !important;
			    }
		    }

	    </style>
    <?php endif;
}

if ( ! function_exists( 'custom_excerpt_length' ) ) {
	function custom_excerpt_length($length) {
		return 75;
	}
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function themeslug_remove_hentry( $classes ) {
	if ( is_page() ) {
		$classes = array_diff( $classes, array( 'hentry' ) );
	}
	return $classes;
}
add_filter( 'post_class','themeslug_remove_hentry' );

/* DON'T DELETE THIS CLOSING TAG */ ?>
