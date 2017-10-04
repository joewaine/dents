<?php
/**
 * Helper class.
 *
 *
 * @since      1.0.0
 * @package    hayyabuild
 * @subpackage hayyabuild/includes
 * @author     zintaThemes <>
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


class HayyaHelper {

	/**
	 * redirect static varibale
	 *
	 * @since		1.0.0
	 * @access		protected
	 * @var			string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	public static $redirect = array();

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since		1.0.0
	 * @access		protected
	 * @var			string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since		1.0.0
	 * @access		protected
	 * @var			string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 *
	 * @since		3.0.0
	 * @access		public
	 * @var 		array		$options
	 */
	public static $options = array();

	/**
	 * construct function
	 *
	 * @access		public
	 * @since		1.0.0
	 */
	public function __construct() {
        return true;
    }

	/**
	 * Admin notices function.
	 *
	 * @since 	1.0.0
	 * @param 	String 		$message 	notice message
	 * @param 	String 		$type 		notice type
	 */
	public static function __notices($message, $type) {
		add_action('admin_notices', function() use ($message, $type) {
    		echo '<div class="notice notice-'.$type.' is-dismissible"><p>' . __( $message, HAYYAB_BASENAME ) . '</p></div>';
		});
	} // End __notice()

	/**
	 * add or remove slashes
	 *
	 * @param unknown $content
	 * @param unknown $slashes
	 * @return unknown|boolean
	 */
	public static function __slashes($content = null, $slashes = null ) {
		if ( null !== $content &&  null !== $slashes ) {
			if ( $slashes === 'add' ) return addslashes($content);
			else if ( $slashes === 'strip' ) return stripslashes($content);
		} return false;
	} // End __slashes()

	/**
	 * remove slashes if magic_quotes_gpc() is activated
	 *
	 * @param unknown $content
	 * @return unknown|boolean
	 */
	public static function __strip_magic_quotes($content = null) {
        return stripslashes_deep($content);
        // return get_magic_quotes_gpc() ? self::__slashes($content, 'strip') : $content;
	} // End __slashes()

	/**
	 *  Redirect to edit page after save an new element.
	 *
	 * @access 	public
	 * @since 	3.0.0
	 */
	public static function __redirect($redirect = array()) {
		$redirect = self::$redirect;
		if ( is_array($redirect) && !empty($redirect) ) {
			if (isset($redirect['id']) && !empty($redirect['id'])) wp_redirect(admin_url('/admin.php?page=hayyabuild&id='.$redirect['id'].'&action=edit&update=ok'));
			if (isset($redirect['list']) && $redirect['list'] === 'notfound') wp_redirect(admin_url('/admin.php?page=hayyabuild&notfound=1'));
		}
	} // End __redirect()

	/**
	 *  check is it HayyaBuild pages.
	 *
	 * @access 	public
	 * @since 	3.0.0
	 */
	public static function __is_hayy_pages() {
		$page = self::_get('page');
		return $page === 'hayyabuild' || $page === 'hayyabuild_addh' || $page === 'hayyabuild_addc' || $page === 'hayyabuild_addf' || $page === 'hayyabuild_settings' || $page === 'hayyabuild_help';
	} // End __is_hayy_pages()

	/**
	 *  check admin main pages.
	 *
	 * @access 	public
	 * @since 	3.0.0
	 */
	public static function __is_main_pages() {
		$page = self::_get('page');
		return $page === 'hayyabuild' || $page === 'hayyabuild_addh' || $page === 'hayyabuild_addc' || $page === 'hayyabuild_addf';
	} // End __is_main_pages()

	/**
	 *  check admin build page.
	 *
	 * @access 	public
	 * @since 	3.0.0
	 */
	public static function __is_build_pages() {
		$page = self::_get('page'); $action = self::_get('action');
		return  $page === 'hayyabuild_addh' || $page === 'hayyabuild_addc' || $page === 'hayyabuild_addf' || $action === 'edit';
	} // End __is_build_pages()

	/**
	 *  check admin add new pages.
	 *
	 * @access 	public
	 * @since 	3.0.0
	 */
	public static function __is_new_pages() {
		$page = self::_get('page');
		return  $page === 'hayyabuild_addh' || $page === 'hayyabuild_addc' || $page === 'hayyabuild_addf';
	} // End __is_new_pages()

	/**
	 *  check admin add new pages.
	 *
	 * @access 	public
	 * @since 	3.0.0
	 */
	public static function __is_settings_page() {
		return  self::_get('page') === 'hayyabuild_settings';
	} // End __is_settings_pages()

	/**
	 *  check admin add new pages.
	 *
	 * @access 	public
	 * @since 	3.0.0
	 */
	public static function __is_help_page() {
		return  self::_get('page') === 'hayyabuild_help';
	} // End __is_help_pages()

	/**
	 *
	 * @access		public
	 * @since		1.0.0
	 * @param 		string		$param
	 */
	public static function _get($param) {
		if ( isset( $_GET[$param] ) ) return $_GET[$param];
		else return false;
	} // End _get()

	/**
	 *
	 * @param 		string 		$param
	 */
	public static function _post($param) {
		if ( isset( $_POST[$param] ) ) return $_POST[$param];
		else return false;
	} // End _post()


	/**
	 * Get wpdb.
	 *
	 * @since 	1.0.0
	 */
	public static function __hpDB() {
		global $wpdb; return $wpdb;
	} // End __zpdb()

	/**
	 *
	 * @since 	1.0.0
	 */
	public static function __empty( $var = null ) {
		if ( ! isset($var) ) $var = '';
		return $var;
	} // End __empty()

    /**
     * Get wpdb.
     *
     * @since   1.0.0
     */
    public static function __debug( $message ) {
        if ( ! empty($message) ) {
            $message = '<div>'.$message.'</div>';
        }
        return $message;
    } // End __debug()

    /**
     * Get HayyaBuild options.
     *
     * @since   3.0.0
     */
    public static function __options( $atts = null ) {
    	if ( empty(self::$options) ) self::$options = get_option('hayyabuild_settings');
    	return self::$options;
    } // End __options()


    /**
     *
     * @return number
     */
    public static function __mtime() {
        // $time_start = HayyaHelper::__mtime();
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

}
