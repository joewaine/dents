<?php
/**
 *
 * Templates list.
 *
 * @since       1.3.0
 * @package     hayyabuild
 * @subpackage  hayyabuild/includes
 * @author      zintaThemes <>
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'HayyaTemplates' ) ) {

    class HayyaTemplates {

        /**
         * The ID of this plugin.
         *
         * @since   1.3.0
         * @access  private
         * @var     string      $plugin_name    name of this plugin.
         */
        private $plugin_name    = null;

        /**
         * The version of this plugin.
         *
         * @since   1.3.0
         * @access  private
         * @var     string      $version        The current version of this plugin.
         */
        private $version        = null;

        /**
         * Templates list array.
         *
         * @since   1.3.0
         * @access  private
         * @var     string      $version        The current version of this plugin.
         */
        public $templates        = array();

        /**
         * Initialize the class and set its properties.
         *
         * @since   1.3.0
         * @param   string      $plugin_name    The name of this plugin.
         * @param   string      $version        The version of this plugin.
         */
        public function __construct($plugin_name, $version) {
            $this->Templates();
        }

                /**
         *
         * @param unknown $param
         */
        public function template_save() {
        	require_once HAYYAB_PATH . 'includes/class-hayyabuild-parser.php';
        	$HayyaParser = new HayyaParser;
            global $wpdb;
            $tpl = HayyaHelper::_post( 'tpl' );
            $name = HayyaHelper::_post( 'name' );
            $pages = maybe_serialize(HayyaHelper::_post( 'pages' ));
            $template = $this->templates[$tpl];
            $site_url = get_site_url();

            $json_file = HAYYAB_PATH . 'includes/data/'.$tpl.'.json';
            $ext = pathinfo($json_file, PATHINFO_EXTENSION);
            if ( file_exists($json_file) && is_file($json_file) && $ext === 'json' ) {
                if ( $content = file_get_contents($json_file) ) {
                    $data = json_decode( $content, true );
                    if (json_last_error() === 0) {
                        foreach ($data as $key => $value) {
                            if ( $key === 'settings') {
                                $settings = maybe_unserialize($value);
                                foreach ($settings as $k => $v) {
                                    if (!is_array($v)) {
                                        $settings[$k] = str_replace('<--site_url-->', $site_url, $v);
                                    }
                                }
                                $data['settings'] = maybe_serialize($settings);
                            }
                        }
                        $data['name'] = $name;
                        $data['status'] = 'draft';
                        $data['added_date'] = $data['modified_date'] = date( "Y-m-d H:i:s" );
                        $data['content']= str_replace('<--site_url-->', $site_url, $data['content']);
                        $content = $HayyaParser->cleanAdminHTML( $data['content'] );
                        $data['content'] = HayyaHelper::__slashes($content, 'add');;
                        $data['clean_content'] =  HayyaHelper::__slashes($HayyaParser->cleanPublicHTML( $content ), 'add');
                        $data['pages'] = $pages;
                        if ( $wpdb->insert( $wpdb->prefix . HAYYAB_BASENAME, $data, '' ) ) {
                            if ( $id = $wpdb->insert_id ) {
                                HayyaHelper::$redirect['id'] = $id;
                                add_action( 'admin_init', array('HayyaHelper', '__redirect'), 11);
                                return true;
                            }
                        }
                    }
                }
            }
            HayyaHelper::__notices( __('EROR06: Someting happen, Can\'t update database', HAYYAB_BASENAME), 'success' );
            exit();
            return false;
        }

        /**
         * Templates list.
         *
         * @since   1.3.0
         */
        private function Templates() {

            $this->templates = array(

            		// headers list
            		'header01' => array(
            				'name' => 'Header 1',
            				'description' => 'HayyaBuild template header',
            				'type' => 'header',
            		),
            		'header02' => array(
            				'name' => 'Header 2',
            				'description' => 'HayyaBuild template header',
            				'type' => 'header',
            		),
            		'header03' => array(
            				'name' => 'Header 3',
            				'description' => 'HayyaBuild template header',
            				'type' => 'header',
            		),
            		'header04' => array(
            				'name' => 'Header 4',
            				'description' => 'HayyaBuild template header',
            				'type' => 'header',
            		),
            		'header05' => array(
            				'name' => 'Header 5',
            				'description' => 'HayyaBuild template header',
            				'type' => 'header',
            		),
            		'header06' => array(
            				'name' => 'Header 6',
            				'description' => 'HayyaBuild template header',
            				'type' => 'header',
            		),
	                'header07' => array(
		                    'name' => 'Header 7',
		                    'description' => 'HayyaBuild template header',
		                    'type' => 'header',
	                ),
	                'header08' => array(
		                    'name' => 'Header 8',
		                    'description' => 'HayyaBuild template header',
		                    'type' => 'header',
	                ),
	                'header09' => array(
		                    'name' => 'Header 9',
		                    'description' => 'HayyaBuild template header',
		                    'type' => 'header',
	                ),
	                'header10' => array(
		                    'name' => 'Header 10',
		                    'description' => 'HayyaBuild template header',
		                    'type' => 'header',
	                ),
	                'header11' => array(
		                    'name' => 'Header 11',
		                    'description' => 'HayyaBuild template header',
		                    'type' => 'header',
	                ),
            		'header12' => array(
            				'name' => 'Header 12',
            				'description' => 'HayyaBuild template header',
            				'type' => 'header',
            		),

            		// content list
            		'content01' => array(
            				'name' => 'Pages Content 01',
            				'description' => 'HayyaBuild pages Content',
            				'type' => 'content',
            		),
            		'content02' => array(
            				'name' => 'Pages Content 02',
            				'description' => 'HayyaBuild pages Content',
            				'type' => 'content',
            		),
            		'content03' => array(
            				'name' => 'Pages Content 03',
            				'description' => 'HayyaBuild pages Content',
            				'type' => 'content',
            		),
                    '404_error' => array(
            				'name' => '404 Error Page Content',
            				'description' => 'HayyaBuild 404 Error Page Content',
            				'type' => 'content',
            		),

	                // footers list
            		'footer01' => array(
            				'name' => 'Footer 1',
            				'description' => 'HayyaBuild template footer',
            				'type' => 'footer',
            		),
            		'footer02' => array(
            				'name' => 'Footer 2',
            				'description' => 'HayyaBuild template footer',
            				'type' => 'footer',
            		),
            		'footer03' => array(
            				'name' => 'Footer 3',
            				'description' => 'HayyaBuild template footer',
            				'type' => 'footer',
            		),

	                'footer04' => array(
		                    'name' => 'Footer 4',
		                    'description' => 'HayyaBuild template footer',
		                    'type' => 'footer',
	                ),
	                'footer05' => array(
		                    'name' => 'Footer 5',
		                    'description' => 'HayyaBuild template footer',
		                    'type' => 'footer',
	                ),
	                'footer06' => array(
		                    'name' => 'Footer 6',
		                    'description' => 'HayyaBuild template footer',
		                    'type' => 'footer',
	                ),
	                'footer07' => array(
		                    'name' => 'Footer 7',
		                    'description' => 'HayyaBuild template footer',
		                    'type' => 'footer',
	                ),
	                'footer08' => array(
		                    'name' => 'Footer 8',
		                    'description' => 'HayyaBuild template footer',
		                    'type' => 'footer',
	                ),
	                'footer09' => array(
		                    'name' => 'Footer 9',
		                    'description' => 'HayyaBuild template footer',
		                    'type' => 'footer',
	                ),
            );
        }

    } // end of class HayyaAdmin

}
