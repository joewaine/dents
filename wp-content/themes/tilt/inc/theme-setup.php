<?php
/*	
*	---------------------------------------------------------------------
*	Collars Theme Setup
*	--------------------------------------------------------------------- 
*/

if ( ! isset( $content_width ) ) {
	$content_width = 1200;
}

/* Register menu */
register_nav_menus( array(
	'primary' => __( 'Main Navigation', 'tilt' ),
	'mobile' => __( 'Mobile Navigation', 'tilt' )
) );

/* Menu fallback */
function collars_no_menu(){
	$url = admin_url( 'nav-menus.php');
	echo '<div class="menu-container"><ul class="menu"><li><a href="'. esc_url($url) .'">Click here to assign menu!</a></li></ul></div>';
}   

/* Thumbnails */
add_theme_support( 'post-thumbnails' );

/* Post formats */
add_theme_support( 'post-formats', array( 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio' ) );

/* Feeds */
add_theme_support( 'automatic-feed-links' );

/* HTML5 */
add_theme_support( 'html5', array( 'gallery', 'caption' ) );

/* Use shortcodes in text widgets */
add_filter( 'widget_text', 'shortcode_unautop' );
add_filter('widget_text', 'do_shortcode');

/* Redirect to "Theme Options/Import Data" after activation */
global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) {
	wp_redirect( admin_url( 'themes.php?page=ot-theme-options#section_import_data' ) );
}

/* Extend editor */
function collars_more_buttons($buttons) {
  $buttons[] = 'fontsizeselect';
 
  return $buttons;
}

/* Editor style */
add_editor_style('/css/editor-style.css');

add_action('admin_head', 'twc_admin_css');
function twc_admin_css() {
	echo '<style>#js_composer-update, #revslider-update {display: none !important;}</style>';
}

function twc_customizer_settings( $wp_customize ){
	$wp_customize->remove_section('colors');
	$wp_customize->remove_section('header_image');
	$wp_customize->remove_section('background_image');
}
add_action( 'customize_register', 'twc_customizer_settings', 20 );

?>