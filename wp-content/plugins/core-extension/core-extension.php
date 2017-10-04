<?php
/*
Plugin Name: TWC Theme Extension Plugin
Plugin URI: http://themeforest.net/user/TheWhiteCollars
Description: Extension for Theme and Visual Composer features.
Version: 1.7.1.5
Author: TheWhiteCollars
Author URI: http://whitecollars.co/
License: Envato Marketplaces Split Licence
License URI: Envato Marketplace Item License Certificate 
*/


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) die;


class COLLARS_Core_Extend {
	
	function __construct() {
		require_once ( 'include/aq_resizer.php' );
		require_once ( 'include/Mobile_Detect.php' );
		require_once ( 'include/portfolio_post_type.php' );
		$this->_constants();
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}
	
	protected function _constants() {
		define( 'COLLARS_PLUGIN_MAIN', __FILE__);
		define( 'COLLARS_PLUGIN_PATH', plugin_dir_path(__FILE__) );
		define( 'COLLARS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	}
	
	public function init() { 
		load_plugin_textdomain( 'core-extension', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		if ( ! function_exists( 'vc_map' ) ) {
			add_action('admin_notices', array( $this, 'vc_error' ) ); 
		} else {
			$this->vc_edit();
			add_action('wp_enqueue_scripts', array( $this, 'vc_scripts' ) );
//			add_action( 'init', array( $this, 'remove_vc_options' ) );
			add_action( 'vc_before_init', array( $this, 'remove_vc_options' ) );
		}
	}

	// Display notice if Visual Composer is not installed or activated
	public function vc_error() {
		echo '
		<div class="updated">
			<p>'. __( '<strong>TWC Theme Core Extend</strong> requires Visual Composer plugin to be installed and activated on your site.', 'core-extension' ) .'</p>
		</div>';
	}
	
	// Enqueue scripts
	public function vc_scripts() {
		wp_register_style( 'core-extension', COLLARS_PLUGIN_URL . 'assets/css/core-extension.css', array('js_composer_front') );
		wp_register_style( 'font-awesome', COLLARS_PLUGIN_URL . 'assets/css/font-awesome.css', false, '', 'all' );
		wp_register_style( 'linecons', COLLARS_PLUGIN_URL . 'assets/css/linecons.css', false, '', 'all' );
		wp_register_style( 'simple-line-icons', COLLARS_PLUGIN_URL . 'assets/css/simple-line-icons.css', false, '', 'all' );

		wp_enqueue_style( 'core-extension' );
		wp_enqueue_style( 'font-awesome' );
//		wp_enqueue_style( 'linecons' );
		wp_enqueue_style( 'simple-line-icons' );
	}
	
	// Disable VC design options
	public function remove_vc_options() {
		vc_set_as_theme(true);
	}
	
	// Extend & configure VC	
	public function vc_edit() { 
		
		// Set shortcode template dir
		$dir = COLLARS_PLUGIN_PATH . '/include/templates/shortcodes/';
		vc_set_shortcodes_templates_dir($dir);
		
		// Disable VC front-end editor
		vc_disable_frontend();
		
		// Remove VC elements
		vc_remove_element('vc_text_separator');
		vc_remove_element('vc_gallery');
		vc_remove_element('vc_posts_slider');
		vc_remove_element('vc_images_carousel');
		vc_remove_element('vc_posts_grid');
		vc_remove_element('vc_cta_button');
		vc_remove_element('vc_cta_button2');

		// Add shortcodes
		require_once ('include/classes/heading.php');
		require_once ('include/classes/team.php');
		require_once ('include/classes/testimonials.php');
		require_once ('include/classes/list.php');
		require_once ('include/classes/service.php');
		require_once ('include/classes/counter.php');
		require_once ('include/classes/pricing-box.php');
		require_once ('include/classes/tooltip.php');
		require_once ('include/classes/slider_carousel.php');
		require_once ('include/classes/magic_image.php');
		require_once ('include/classes/info_box.php');
		require_once ('include/classes/dropcaps.php');
		require_once ('include/classes/promo_box.php');
		require_once ('include/classes/image_box.php');
		require_once ('include/classes/modal.php');
		require_once ('include/classes/image_gallery.php');
		require_once ('include/classes/content_slider.php');
		require_once ('include/classes/content_slide.php');

		// Edit VC map
		require_once ('config/map.php');
	}
}
$collars_core_extend = new COLLARS_Core_Extend();