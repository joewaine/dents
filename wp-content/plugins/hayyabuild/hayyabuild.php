<?php
/**
 * Plugin Name: 	HayyaBuild
 * Plugin URI: 		https://hayyabuild.zintathemes.com
 * Author: 			ZintaThemes
 * Author URI: 		www.zintathemes.com
 * Version: 		3.1
 * Description: 	HayyaBuild is a powerful and straightforward backend drag-and-drop WordPress plugin that offers responsive headers, pages content and footers builder.
 * License: 		This plugin is licensed according to the license purchased from Envato.
 * License URI:		here: http://themeforest.net/licenses
 *
 * Text Domain: 	hayyabuild
 * Domain Path: 	/languages/
 *
 *
 * @link
 * @since			1.0.0
 * @package			HayyaBuild
 * @category 		*
 * @author 			ZintaThemes
 */

// If this file is called directly, abort.
if ( ! defined ( 'ABSPATH' ) ) {
	die( 'This file cannot be accessed directly!' );
}

// Define HayyaBuild constants
if (!defined('HAYYAB_VERSION' 	)) define('HAYYAB_VERSION'	, '3.1');
if (!defined('HAYYAB_BASENAME' 	)) define('HAYYAB_BASENAME'	, 'hayyabuild');
if (!defined('HAYYAB_NAME' 		)) define('HAYYAB_NAME'		, 'HayyaBuild');
if (!defined('HAYYAB_PATH' 		)) define('HAYYAB_PATH'		, plugin_dir_path(__FILE__));
if (!defined('HAYYAB_URL' 		)) define('HAYYAB_URL'		, plugin_dir_url (__FILE__));

final class HayyaBuildStart {

	/**
	 * The version number.
	 * @var     	string
	 * @access  	public
	 * @since   	3.0.0
	 */
	public $version;

	/**
	 * The plugin directory URL.
	 * @var     	string
	 * @access  	public
	 * @since   	3.0.0
	 */
	public $plugin_url;

	/**
	 * The plugin directory path.
	 * @var     	string
	 * @access  	public
	 * @since   	3.0.0
	 */
	public $plugin_path;

	/**
	 * The single instance of HayyaBuild.
	 * @var 		object
	 * @access  	private
	 * @since 		3.0.0
	 */
	private static $_instance = false;

	/**
	 * Constructor function.
	 * @access  	public
	 * @since   	3.0.0
	 */
	public function __construct() {
		require_once HAYYAB_PATH . 'includes/class-hayyabuild.php';
		register_activation_hook( __FILE__, array( 'HayyaBuild', 'hayyabuild_activate' ) );
		register_deactivation_hook( __FILE__, array( 'HayyaBuild', 'hayyabuild_deactivate' ) );
		return true;
	} // End __construct()

	/**
	 * Begins execution of the plugin.
	 *
	 * @access  	public
	 * @since       3.0.0
	 * @param       $type       string
	 */
	public static function hayya_start( $type = null ) {
		if ( !self::$_instance ) {
			self::$_instance = new self();
		}
		HayyaBuild::run($type);
	} // End hayya_start()
} // End HayyaBuildStart {} Class

/**
 *
 * @since       3.0.0
 * @param       $type       string
 */
function hayya_get_modules($path = null, $list = null) {
	HayyaModules::hayya_get_modules($path, $list);
} // End hayya_get_modules()

/**
 * Begins execution of the plugin.
 *
 * @since       1.0.0
 * @param       $type       string
 */
function hayya_run($type = null) {
	HayyaBuildStart::hayya_start($type);
} // End hayya_run()

// Run HayyaBuild plugin
hayya_run();
