<?php
/**
 * Public output class
 *
 *
 * @package    hayyabuild
 * @subpackage hayyabuild/public
 * @author     zintaThemes
 *
 *
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }


class HayyaPublic extends HayyaBuild
{

  	/**
   	 * The ID of this plugin.
   	 *
   	 * @since    1.0.0
   	 * @access   private
   	 * @var      string    $plugin_name    The ID of this plugin.
   	 */
   	private $plugin_name;

   	/**
   	 * The version of this plugin.
   	 *
   	 * @since    1.0.0
   	 * @access   private
   	 * @var      string    $version    The current version of this plugin.
   	 */
   	private $version;

   	/**
   	 * setting array for curent element.
   	 *
   	 * @since    1.0.0
   	 * @access   private
   	 * @var      string    $version    The current version of this plugin.
   	 */
   	protected static $settings = array();

   	/**
   	 * setting array for curent element.
   	 *
   	 * @since    1.0.0
   	 * @access   protected
   	 * @var      string    $version    The current version of this plugin.
   	 */
   	protected static $map = NULL;

   	/**
   	 * Initialize the class and set its properties.
   	 *
   	 * @since		1.0.0
   	 * @param      	string    $plugin_name       The name of the plugin.
   	 * @param      	string    $version    The version of this plugin.
   	 */
   	public function __construct() {
   		//if ( empty( self::$map ) ) self::$map = $this->hb_getMap ();
//     		if (!$type) add_filter('the_content', array($this, 'pages_content'));
   	}

    /**
   	 * HayyaBuild output filter
   	 *
   	 * @since		3.0.0
   	 */
    public function hayya_output() {
        add_filter( 'hayya_output', array($this, 'hb_output') );
    }

    /**
     * HayyaBuild output
     *
     * @since		1.0.0
     */
	public function hb_output( $type ) {
		if ( $map = $this->hb_getMap() ) {
            $ids = implode(',', array_map('intval', $map));
        }
		if ( ( $type === 'header' || $type === 'footer' ) && isset($ids) ) {
			$content = $id = $style = $class = $attributes = $settings = '';
			global $wpdb;
			$results = $wpdb->get_row( 'SELECT `settings`,`clean_content` FROM `'.$wpdb->prefix . HAYYAB_BASENAME.'` WHERE `id` IN ('.$ids.') AND `type` = "'.$type.'" LIMIT 1' );
			if ( ! empty($results) ) {

				$settings = preg_replace_callback(
				    '/s:([0-9]+):\"(.*?)\";/',
				    function ($matches) { return "s:".strlen($matches[2]).':"'.$matches[2].'";';     },
				    $results->settings
				);

				$settings 		= maybe_unserialize( $settings );
    			$content 		= do_shortcode( stripslashes( $results->clean_content) );

                if ( ($settings['background_type'] == 'background_video' || $settings['background_type'] == 'background_image') && !empty($settings['background_effect']) ) {
        			foreach ( $settings['background_effect'] as $background_effect ) {
        				if (!empty($background_effect)) $class .= $background_effect.' ';
        			}
                }

                $settings['elements_list'] = @array_filter(explode(',', $settings['elements_list']));
                if ( isset($settings['background_type']) && $settings['background_type'] === 'background_video' ) {
                    $parse       = parse_url($settings['background_video']);
                    $fixed_video = ( isset($settings['fixed_video']) && $settings['fixed_video'] == 'on') ? ' fixed_video' : '' ;
                    if ( $parse['host'] == 'www.youtube.com' || $parse['host'] == 'youtube.com' ) {
                        $video = '<iframe id="video_'.$type.'" class="hb_bgvideo'.$fixed_video.'" src="'.$settings['background_video'].'?autoplay=1&amp;controls=0&amp;loop=1&amp;showinfo=0&amp;autohide=1&amp;modestbranding=1" frameborder="0" allowfullscreen></iframe>';
                    } else {
                        $video = '<video id="video_'.$type.'"  class="hb_bgvideo'.$fixed_video.'" autoplay loop muted poster="'.$settings['background_image'].'"><source src="'.$settings['background_video'].'" type="video/mp4"></video>';
                    }
                    $content  = '<div class="video-bg">'.$video.'</div>'.$content;
                }
    			$id = 'hb_'.$type;
                $content = $this->hb_html( $content, $type, $id, $style, $class, $attributes );
                if ( !empty($settings['scroll_effect']) || !empty($settings['background_effect']) ) {
                	$content = $this->hb_html( $content, 'div', 'hb_container-'.$type);
                }
    		    $content = '<div id="hb_before'.$type.'"></div>'.$content.'<div id="hb_after'.$type.'"></div>';
    			echo $content;
                return true;
            }
		}
		return false;
	} // End hb_output()

   	/**
   	 * HTML output for a public
   	 *
   	 * @package		HayyaBuild
   	 * @param 		string 		$output
	 * @access		private
	 * @since		1.0.0
   	 */
   	private function hb_html( $output = null, $type = null, $id = null, $style = null, $class = null, $attributes = null) {
   		if ($style) $style = ' style="'.$style.'"';
   		if ($class) $class = ' class="'.$class.'"';
   		if ($id) $id = ' id="'.$id.'"';
   		if ($attributes) $attributes = ' '.$attributes;
   		return '<'.$type.$id.$style.$class.$attributes.'>'.$output.'</'.$type.'>';
   	} // End hb_html()

   	/**
   	 *
	 * @package		HayyaBuild
	 * @access		public
	 * @since		1.0.0
   	 */
   	public function hb_getMap() {
   		if ( empty( self::$map )) {
	   		global $wpdb;
            $page = 'all';
            $posts_page = false;

            $item_types = array(
                'header',
                'content',
                'footer'
            );

	   		if ( (is_home() || is_single() || is_archive() || is_tag() || is_author() || is_category() || is_date() || is_search()) && get_option('page_for_posts') ) {
	   		    $page = get_option('page_for_posts');
            $posts_page = true;
	   		} else if ( function_exists('is_shop') && is_shop() ) {
	   		    $page = get_option('woocommerce_shop_page_id');
	   		} else if (is_404()) {
	   		    $page = '404page';
	   		} else if (get_the_ID()) {
                $page = get_the_ID();
            }

	   		foreach ( $item_types as $type ) {
                if ( 'content' !== $type || ! $posts_page ) {
    	   			$hb_id = $wpdb->get_var('SELECT `hb_id` FROM `'.$wpdb->prefix.HAYYAB_BASENAME.'_map` WHERE `object_id` = "'.$page.'" AND `hb_type` = "'.$type.'" LIMIT 1');
    	   			if ( $hb_id ) {
    	   			    if ( $type === 'content' && $page === '404page' ) {
        	   			    add_filter( '404_template', array($this, 'hayya_404_template') );
    	   			    }
    	   			    $map[] = $hb_id;
    	   			} else {
    	   			    $hb_id = $wpdb->get_var('SELECT IFNULL(
                                                    (SELECT `hb_id` FROM `'.$wpdb->prefix.HAYYAB_BASENAME.'_map` WHERE `object_id` = "all" AND `hb_type` = "'.$type.'" LIMIT 1),
                                                    (SELECT `hb_id` FROM `'.$wpdb->prefix.HAYYAB_BASENAME.'_map` WHERE `object_id` = "0" AND `hb_type` = "'.$type.'" LIMIT 1)
                                                );');
    	   			    if ( $hb_id ) {
    	   			        $map[] = $hb_id;
    	   			    }
    	   			}
                }
	   		}
	   		if ( isset($map) && is_array($map) ) return self::$map = $map;
   		} else return self::$map;
   		return false;
   	} // End  hb_getMap()

   	/**
   	 * @return 404 path
   	 */
   	public function hayya_archive_template($param) {
   	    return HAYYAB_PATH . '/public/archive.php';;
   	}

   	/**
   	 * @return 404 path
   	 */
   	public function hayya_404_template($param) {
   	    return HAYYAB_PATH . '/public/404.php';;
   	}

   	/**
   	 * Get settings.
   	 *
	 * @package		HayyaBuild
	 * @access		public
	 * @since		1.0.0
   	 */
	public function hb_getsettings() {
   		if (empty(self::$settings)) {
			if ( $this->hb_getMap() ) {
		   	    global $wpdb;
	   			$ids = implode(',', array_map('intval', self::$map));
	   			$setting = $wpdb->get_results('SELECT `settings`,`type` FROM `'.$wpdb->prefix . HAYYAB_BASENAME.'` WHERE `id` IN ('.$ids.')');
	   			if ( !empty($setting) && is_array($setting) ) {
		   			foreach ( $setting as $settings ) {
			   			$tmp_settings = preg_replace_callback(
		   					'/s:([0-9]+):\"(.*?)\";/',
		   					function ($matches) {return "s:".strlen($matches[2]).':"'.$matches[2].'";';},
		   					$settings->settings
		   				);
			   			$tmp_settings = maybe_unserialize( $tmp_settings );
			   			$itemSettings[$settings->type] = $tmp_settings;
		   			}
	   			} else $itemSettings = false;
	   		} else $itemSettings = false;
	   		return self::$settings = $itemSettings;
   		} else return self::$settings;
   	} // End  hb_getsettings()

	/**
	 * Get elements list
	 *
	 * @package		HayyaBuild
	 * @access		public
	 * @since		1.0.0
	 */
	private function hb_elements() {
		foreach ( $this->settings as $setting ) {
			$settings = preg_replace_callback( '/s:([0-9]+):\"(.*?)\";/', function ($matches) {
				return "s:" . strlen ( $matches [2] ) . ':"' . $matches [2] . '";';
			}, $setting->settings );
			$settings = maybe_unserialize( $settings );
		}
	} // End hb_elements()

	/**
	 * Pages Content.
	 *
	 * @package		HayyaBuild
	 * @access		public
	 * @since		3.0.0
	 */
	public function pages_content($pageContent = null) {
		if ( self::hb_getMap() ) {
			$ids = implode ( ',', array_map( 'intval', self::$map ) );
			if (isset( $ids ) ) {
				global $wpdb;
				$results = $wpdb->get_row( 'SELECT `clean_content` FROM `' . $wpdb->prefix . HAYYAB_BASENAME . '` WHERE `id` IN (' . $ids . ') AND `type` = "content" LIMIT 1' );
				if (!empty( $results )) {
                    return '<div id="hb_beforecontent"></div>
                            <div id="hb_container-content">
                                <div id="hb_content">
                                    ' .do_shortcode( stripslashes( $results->clean_content ) ). '
                                </div>
                            </div>
                            <div id="hb_aftercontent"></div>';
                }
			}
		}
		return $pageContent;
	} // End pages_content()

    /**
    *
    * @package		HayyaBuild
    * @access		public
    * @since		3.1.0
     */
    public static function hayya_shortcode( $id = null ) {
        if ( $id !== null ) {
            global $wpdb;
            if ( $results = $wpdb->get_row( 'SELECT `pages`,`clean_content` FROM `'.$wpdb->prefix.HAYYAB_BASENAME.'` WHERE `id`="'.$id.'" AND `type`="content" LIMIT 1' )) {
                $pages_list = preg_replace_callback(
					'/s:([0-9]+):\"(.*?)\";/',
					function ($matches) { return "s:".strlen($matches[2]).':"'.$matches[2].'";';     },
					$results->pages
                );
                if ( empty($pages_list) ) {
                    $pages_list =  maybe_unserialize( $pages_list );
                    return '<div id="hb_beforecontent_'.$id.'"></div>
                            <div id="hb_container-content_'.$id.'">
                                <div id="hb_content_'.$id.'">'.do_shortcode( stripslashes( $results->clean_content ) ).'</div>
                            </div><div id="hb_aftercontent_'.$id.'"></div>';
                }
            }
        }
    }

	/**
	 *
	 * @package		HayyaBuild
	 * @access		public
	 * @since		3.0.0
	 */
	public static function define_hooks() {
		require_once HAYYAB_PATH. 'includes/class-hayyabuild-hooks.php';
		HayyaBuild::get_loader()->add_filter( 'the_content', new HayyaPublic(), 'pages_content' );
		new HayyaHooks();
	} // End define_hooks()

	/**
	 * HTML output for a public
	 *
	 * @param 		string 		$output
	 */
	private function hb_class($class) {
		if ( $class ) return $class;
		else return false;
	} // End hb_class()

	/**
	 * HTML output for a public
	 *
	 * @param 		string 		$output
	 */
	private function hb_id() {
		return false;
	} // End hb_id()

	/**
	 *
	 * Including header.php
	 *
	 * @since 1.2.0
	 */
	public function hbLoadHeader($template) {
		get_header ( 'hayya' );
		return $template;
	} // End hbLoadHeader()

	/**
	 *
	 * Including footer.php
	 *
	 * @since 1.2.0
	 */
	public function hbLoadFooter($template) {
		return $template;
	} // End hbLoadFooter()

	/**
	 * Get styles.
	 *
	 * @since 1.0.0
	 */
	private function load_styles() {
		if (isset ( $template )) {
			return true;
		}
	} // End load_styles()

	/**
	 * Get scripts.
	 *
	 * @since 1.0.0
	 */
	private function load_scripts() {
		if (isset ( $template )) {
			return true;
		}
	} // End load_scripts()


} // End HayyaPublic {} class
