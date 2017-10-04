<?php
/**
 * Public scripts output class
 *
 *
 * @package    hayyabuild
 * @subpackage hayyabuild/public
 * @author     zintaThemes
 *
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class HayyaHooks extends HayyaPublic
{

	/**
	 *
	 * @since    3.0.0
	 * @access   private
	 * @var array
	 */
	private static $ModulesList = array();

	/**
	 *
	 * @since    3.0.0
	 * @access   private
	 * @var array
	 */
	private static $JSFiles = array();

	/**
	 *
	 * @since    3.0.0
	 * @access   private
	 * @var array
	 */
	private static $CSSFiles = array();

   	/**
   	 * Initialize the class and set its properties.
   	 *
   	 * @since		3.0.0
   	 * @param      	string    $plugin_name       The name of the plugin.
   	 * @param      	string    $version    The version of this plugin.
   	 */
   	public function __construct() {
   		HayyaBuild::get_loader()->add_action( 'setup_theme', $this, 'scripts_start');
		HayyaBuild::get_loader()->add_action( 'template_redirect', $this, 'scripts_modules_start');
   	} // End __construct()

	/**
	*
	* @since		3.0.0
	*/
	public function get_settings() {
		$this->hb_getsettings();
		if ( !empty(parent::$map) && !empty(parent::$settings) ) return true;
		return false;
	} // End get_settings()

   	/**
   	 *
   	 * @since		3.0.0
   	 */
   	public function scripts_start() {
		add_action( 'wp_enqueue_scripts', array($this, 'enqueue_styles') );
   	}

   	/**
   	 *
   	 * @since		3.0.0
   	 */
   	public function scripts_modules_start() {
		if ( $this->get_settings() ) {
			$this->hayya_modules();
			add_action( 'wp_head', array($this, 'head_code') );
		}
		add_action( 'wp_enqueue_scripts', array($this, 'enqueue_modules_styles') );
		add_action( 'wp_enqueue_scripts', array($this, 'enqueue_scripts') );
   	}

   	/**
   	 * This function is provided for demonstration purposes only.
   	 *
   	 * An instance of this class should be passed to the run() function
   	 * defined in Plugin_Name_Loader as all of the hooks are defined
   	 * in that particular class.
   	 *
   	 * The Plugin_Name_Loader will then create the relationship
   	 * between the defined hooks and the functions defined in this
   	 * class.
   	 *
   	 * Register the stylesheets for the public-facing side of the site.
   	 *
   	 * @since    1.0.0
   	 */
   	public function enqueue_styles() {
   		self::register_style();
   		wp_enqueue_style(HAYYAB_BASENAME);
   	} // End enqueue_styles()

   	/**
   	 *
   	 * @since    3.0.0
   	 */
   	public function enqueue_modules_styles() {
   		if ( !empty(self::$CSSFiles) ) {
   			foreach ( self::$CSSFiles as $name => $filePath ) {
				wp_enqueue_style( 'hayya_'.$name , $filePath, array(HAYYAB_BASENAME), HAYYAB_VERSION, 'all' );
			}
   		}
   	}

   	/**
   	 *
   	 *
   	 * @access 	public
   	 * @since 	3.0.0
   	 */
   	public static function register_style() {
   		$options = HayyaHelper::__options();
   		if (isset($options['libraries']) && is_array($options['libraries'])) {
   			foreach ( $options['libraries'] as $key => $value ) {
				if ( $value === 'on' ) $$key = true;
			}
   		} else {
			$includeall = true;
		}
		$dep = array();
   		if ( isset($includeall) || isset($fontawesome) ) {
   			wp_register_style( 'hayya_fontawesome', HAYYAB_URL.'public/assets/libs/font-awesome/css/font-awesome.min.css', array(), HAYYAB_VERSION, 'all' );
   			$dep[] = 'hayya_fontawesome';
   		}
   		if ( isset($includeall) || isset($bootstrap) ) {
   			wp_register_style( 'hayya_bootstrap', 	HAYYAB_URL.'public/assets/libs/bootstrap/css/bootstrap.min.css', array(), HAYYAB_VERSION, 'all' );
   			$dep[] = 'hayya_bootstrap';
   		}
   		wp_register_style( HAYYAB_BASENAME,  HAYYAB_URL.'public/assets/css/hayyabuild.min.css', $dep, HAYYAB_VERSION, 'all' );
   	}

   	/**
   	 * This function is provided for demonstration purposes only.
   	 *
   	 * An instance of this class should be passed to the run() function
   	 * defined in Plugin_Name_Loader as all of the hooks are defined
   	 * in that particular class.
   	 *
   	 * The Plugin_Name_Loader will then create the relationship
   	 * between the defined hooks and the functions defined in this
   	 * class.
   	 *
   	 * Register the stylesheets for the public-facing side of the site.
   	 *
   	 * @since    1.0.0
   	 */
   	public function enqueue_scripts() {
   		self::register_script();
   		wp_enqueue_script(HAYYAB_BASENAME);
   	} // End enqueue_scripts()

   	/**
   	 *
   	 * @param unknown $list
   	 */
   	public function hayya_modules() {
   		$modulesList = '';
   		if ( !empty(parent::$settings) ) {
	   		foreach (parent::$settings as $type => $settings ) {
	   			$modulesList .= $settings['elements_list'];
	   		}
   		}
	   	if (!empty($modulesList)) {
	   		$modulesList = array_unique(array_filter(explode(',', $modulesList)));
	   		if ($ModulesList = HayyaModules::get_modules_public($modulesList)) {
	   			foreach ( $ModulesList as $path => $modules ) {
	   				foreach ( $modules as $module ) {
	   					$file_path = $path.$module.'/'.$module.'.php';
	   					if ( file_exists($file_path) ) {
	   						include_once $file_path;
		   					$class_name = 'HayyaModule_' . $module;
		   					if ( class_exists( $class_name ) ) {
		   						$element = new $class_name();
		   						if ( !empty($element->css_files) ) {
			   						foreach ( $element->css_files as $key => $files ) {
			   							if(filter_var($files, FILTER_VALIDATE_URL) || substr($files, 0, 2) === '//') {
			   								$CSS[$key] = $files;
			   							} else {
				   							$cssFile = $path.$module.'/'.$files;
				   							if (file_exists($cssFile)) $CSS[$key] = site_url().'/'. str_replace(ABSPATH, '', $cssFile);
				   							$file_path = $class_name = $key = $files = $cssFile = '';
			   							}
			   						}
		   						}
		   						if ( !empty($element->js_files) ) {
		   							foreach ( $element->js_files as $key => $files ) {
		   								if(filter_var($files, FILTER_VALIDATE_URL) || substr($files, 0, 2) === '//') {
		   									$JS[$key] = $files;
		   								} else {
			   								$jsFile = $path.$module.'/'.$files;
			   								if (file_exists($jsFile)) $JS[$key] = site_url() .'/'. str_replace(ABSPATH, '', $jsFile);
			   								$file_path = $class_name = $key = $files = $jsFile = '';
		   								}
		   							}
		   						}
		   					}
	   					}
	   				}
	   			}
	   			if ( !empty($CSS) )self::$CSSFiles = $CSS;
	   			if ( !empty($JS) ) self::$JSFiles = $JS;
	   		}
	   	} return false;
   	}

    /**
     *
     *
     * @access 	public
     * @since 	3.0.0
     */
    public static function register_script(){
    	$dep = array('jquery');
    	$options = HayyaHelper::__options();
    	if ( isset($options['libraries']) && !empty($options['libraries']) ) {
    		foreach ( $options['libraries'] as $key => $value ) {
				if ( $value === 'on' ) $$key = true;
			}
    	} else {
			$includeall = true;
		}

    	if ( isset($includeall) || isset($bootstrap) ) {
    		wp_register_script( 'bootstrap', HAYYAB_URL.'public/assets/libs/bootstrap/js/bootstrap.min.js', $dep, HAYYAB_VERSION, true );
    		$dep[] = 'bootstrap';
    	}
		if ( isset($includeall) || isset($scrollmagic) ) {
			wp_register_script( 'TweenMax', HAYYAB_URL.'public/assets/libs/scrollmagic/greensock/TweenMax.min.js', $dep, HAYYAB_VERSION, true );
			// wp_register_script( 'TweenMax-EaselPlugin', HAYYAB_URL.'public/assets/libs/scrollmagic/greensock/plugins/EaselPlugin.min.js', array('TweenLite'), HAYYAB_VERSION, true );
			// wp_register_script( 'TweenLite-EasePack', HAYYAB_URL.'public/assets/libs/scrollmagic/greensock/easing/EasePack.min.js', array('TweenLite'), HAYYAB_VERSION, true );
			// wp_register_script( 'TweenLite-CSSPlugin', HAYYAB_URL.'public/assets/libs/scrollmagic/greensock/plugins/CSSPlugin.min.js', array('TweenLite-EasePack'), HAYYAB_VERSION, true );
			wp_register_script( 'ScrollMagic', HAYYAB_URL.'public/assets/libs/scrollmagic/ScrollMagic.min.js', array('TweenMax'), HAYYAB_VERSION, true );
			wp_register_script( 'GSAP', HAYYAB_URL.'public/assets/libs/scrollmagic/plugins/animation.gsap.min.js', array('ScrollMagic'), HAYYAB_VERSION, true );
			wp_register_script( 'addIndicators', HAYYAB_URL.'public/assets/libs/scrollmagic/plugins/debug.addIndicators.min.js', array('GSAP'), HAYYAB_VERSION, true );
			$dep[] = 'GSAP';
			// $dep[] = 'addIndicators';
		}
		if ( isset(parent::$settings) && is_array(parent::$settings) ) {
			foreach ( parent::$settings as $item => $settings ) {
	    		if ( ( isset($includeall) || isset($nicescroll) ) && isset($settings['smooth_scroll']) ) {
	    			wp_register_script( 'nicescroll' , HAYYAB_URL.'public/assets/js/jquery.nicescroll.min.js', $dep, HAYYAB_VERSION, true );
					$dep[] = 'nicescroll';
	    		}
	    	}
		}
    	if ( !empty(self::$JSFiles) ) {
    		foreach ( self::$JSFiles as $name => $filePath ) {
    			wp_register_script( 'hb_'.$name , $filePath, array(), HAYYAB_VERSION, true );
    			$dep[] = 'hb_'.$name;
    		}
    	}
    	wp_register_script( HAYYAB_BASENAME, HAYYAB_URL.'public/assets/js/hayyabuild.min.js', $dep, HAYYAB_VERSION, true );
    }

    /**
     *
     * Create header script.
     *
     * @access 	public
     * @since 	1.0.0
     */
    public function head_code() {
    	if ( is_array(parent::$settings) ) {
    		echo "\n<!-- HayyaBuild Scripts Start -->\n";
    		$cssstyle = $javascript = '';
    		foreach ( parent::$settings as  $item => $settings ) {
    			$settings['csscode'] = (isset($settings['csscode'])) ? stripslashes( $settings['csscode'] ) : '';
    			$style_settings     = $this->hb_style( $settings );
    			$javascript         .= $this->hb_javascript( $settings, $item )."\n";
    			$cssstyle           .= '#hb_'.$item.' {'.$style_settings."}\n";
    			$cssstyle           .= $settings['csscode']." \n";
    		}
    		$csseditor = get_option('hayyabuild_settings');
    		if (isset($csseditor['csseditor']) ) $csseditor = stripslashes($csseditor['csseditor']);
    		else $csseditor = '';
    		if ( !empty($cssstyle) ) echo "<style type=\"text/css\">\n".$csseditor."\n".$cssstyle."</style>\n";
    		if ( !empty($javascript) ) echo "<script type=\"text/javascript\">\njQuery(function($){ \n".$javascript."});\n</script>\n";
    		echo "<!-- /HayyaBuild Scripts End -->\n";
    	}
    } // End head_code()

    /**
     * HTML output for a public
     *
     * @param 		string 		$output
     */
    private function hb_style( $settings ) {
    	$style = '';
    	if ( $settings['background_type'] == 'background_image' ) {
    		$style = 'background: url(\''.$settings['background_image'].'\');';
    		if ( $settings['background_repeat'] != 'repeat' ) $style .= 'background-repeat: '.$settings['background_repeat'].';';
    		// if ( $settings['background_effect'] && in_array('hb_bgmousemove', $settings['background_effect']) ) {
    			// $style .= 'background-position: 50% 50%;background-size: 100% 100%;';
    		// } else
    		if ( $settings['background_size'] != 'auto' ) {
    			$style .= 'background-size: '.$settings['background_size'].';';
    		}

    	} else if ( $settings['background_type'] == 'background_color' ) {
    		$style = 'background: '.$settings['background_color'].';';
    	}
    	if ( $settings['text_color'] ) $style .= 'color: '.$settings['text_color'].';';
    	if ( $settings['margin_top'] ) $style .= 'margin-top: '.$settings['margin_top'].'px;';
    	if ( $settings['margin_bottom'] ) $style .= 'margin-bottom: '.$settings['margin_bottom'].'px;';
    	if ( $settings['margin_left'] ) $style .= 'margin-left: '.$settings['margin_left'].'px;';
    	if ( $settings['margin_right'] ) $style .= 'margin-right: '.$settings['margin_right'].'px;';
    	if ( $settings['border_top_width'] ) $style .= 'border-top: '.$settings['border_top_width'].'px solid '.$settings['border_color'].';';
    	if ( $settings['border_bottom_width'] ) $style .= 'border-bottom: '.$settings['border_bottom_width'].'px solid '.$settings['border_color'].';';
    	if ( $settings['border_left_width'] ) $style .= 'border-left: '.$settings['border_left_width'].'px solid '.$settings['border_color'].';';
    	if ( $settings['border_right_width'] ) $style .= 'border-right: '.$settings['border_right_width'].'px solid '.$settings['border_color'].';';
    	if ( $settings['padding_top'] ) $style .= 'padding-top: '.$settings['padding_top'].'px;';
    	if ( $settings['padding_bottom'] ) $style .= 'padding-bottom: '.$settings['padding_bottom'].'px;';
    	if ( $settings['padding_left'] ) $style .= 'padding-left: '.$settings['padding_left'].'px;';
    	if ( $settings['padding_right'] ) $style .= 'padding-right: '.$settings['padding_right'].'px;';
    	if ( !empty($settings['height']) ) {
    		if ( $settings['height_m_unit'] == 'percent' ) {
    			$style .= 'width: 100%;';
    			$height_m_unit = 'vh';
    		} else $height_m_unit = $settings['height_m_unit'];
    		$style .= 'min-height: '.$settings['height'].$height_m_unit.';';
    	}
    	return $style;
    } // End hb_style()


    /**
     * HTML output for a public
     *
     * @param 		string 		$output
     */
    private function hb_javascript( $settings = '', $type ) {
    	$javascript = "";
    	if ( isset($settings['smooth_scroll']) ) {
    		$scrollspeed = ( is_numeric($settings['smooth_scroll_speed']) ) ? '{scrollspeed: '.$settings['smooth_scroll_speed'].'}' : '' ;
    		$javascript .= '$("html").niceScroll('.$scrollspeed.');';
    	}
        if ( !empty($settings['scroll_effect']) || !empty($settings['background_effect']) ) {
            $javascript .= "var controller = new ScrollMagic.Controller({globalSceneOptions: {triggerHook: \"onLeave\"}});\n";
            $values_from = $values_to = '';
            if ( $type == 'header' ) {
                // backgroung effect
                if ( isset($settings['background_effect']) && is_array($settings['background_effect']) ) {
                        if ( in_array('bgfixed', $settings['background_effect']) || in_array('bgparallax', $settings['background_effect']) ) {
                        	$values_from    .= 'backgroundPosition: "center 0",';
                        if ( in_array('bgfixed', $settings['background_effect']) && in_array('bgparallax', $settings['background_effect']) ) {
                       		$values_to      .= 'backgroundPosition: "center " + $("#hb_container-'.$type.'").height()*0.3 +"px",';
                        } elseif ( in_array('bgfixed', $settings['background_effect']) && ! in_array('bgparallax', $settings['background_effect']) ) {
                        	$values_to      .= 'backgroundAttachment: "fixed",';
                        } elseif ( ! in_array('bgfixed', $settings['background_effect']) && in_array('bgparallax', $settings['background_effect']) ) {
                        	$values_to      .= 'backgroundPosition: "center -" + $("#hb_container-'.$type.'").height()*0.3 +"px",';
                    	}
                    }
                    if ( in_array('bgzoom', $settings['background_effect']) ) {
                    	$values_from    .= '"background-size": "100% auto",';
                        $values_to      .= '"background-size": "120% auto",';
                    }
                }
                // scroll effect
                if ( isset($settings['scroll_effect']) && is_array($settings['scroll_effect']) ) {
                    if ( in_array('fixed', $settings['scroll_effect']) ) {
                        $values_from    .= 'y: 0,';
                        $values_to      .= 'y: $("#hb_container-'.$type.'").height(),';
                    } elseif ( in_array('parallax', $settings['scroll_effect']) ) {
                        $values_from    .= 'y: 0,';
                        $values_to      .= 'y: $("#hb_container-'.$type.'").height()*0.5,';
                    }
                    if ( in_array('scaleIn', $settings['scroll_effect']) ) {
                        $values_to      .= 'scaleX: 1.2,scaleY: 1.2,';
                    } elseif ( in_array('scaleOut', $settings['scroll_effect']) ) {
                        $values_to      .= 'scaleX: 0.8,scaleY: 0.8,';
                    }
                    if ( in_array('opacity', $settings['scroll_effect']) ) {
                        $values_from    .= 'opacity: 1,';
                        $values_to      .= 'opacity: 0,';
                    }
                }
            } elseif ( $type == 'footer' ) {
                // backgroung effect
                if ( isset($settings['background_effect']) && is_array($settings['background_effect']) ) {
                    if ( in_array('bgfixed', $settings['background_effect']) || in_array('bgparallax', $settings['background_effect']) ) {
                        $values_to      .= 'backgroundPosition: "center 0px",';
                        if ( in_array('bgfixed', $settings['background_effect']) && in_array('bgparallax', $settings['background_effect']) ) {
                            $values_from    .= 'backgroundPosition: "center -" + $("#hb_container-'.$type.'").height()*0.6 +"px",';
                        } elseif ( in_array('bgfixed', $settings['background_effect']) && ! in_array('bgparallax', $settings['background_effect']) ) {
                            $values_from    .= 'backgroundAttachment: "fixed",';
                        } elseif ( ! in_array('bgfixed', $settings['background_effect']) && in_array('bgparallax', $settings['background_effect']) ) {
                            $values_from    .= 'backgroundPosition: "center -" + $("#hb_container-'.$type.'").height()*0.3 +"px",';
                        }
                    }
                    if ( in_array('bgzoom', $settings['background_effect']) ) {
                        $values_from    .= 'backgroundPosition: "center 0",backgroundSize: "120% auto",';
                        $values_to      .= 'backgroundSize: "110% auto",';
                    }
                }
                // scroll effect
                if ( isset($settings['scroll_effect']) && is_array($settings['scroll_effect']) ) {
                    if ( in_array('fixed', $settings['scroll_effect']) ) {
                        $values_from    .= 'y: $("#hb_container-'.$type.'").height()*-1,';
                        $values_to      .= 'y: 0,';
                    } elseif ( in_array('parallax', $settings['scroll_effect']) ) {
                        $values_from    .= 'y: $("#hb_container-'.$type.'").height()*-0.5,';
                        $values_to      .= 'y: 0,';
                    }
                    if ( in_array('scaleIn', $settings['scroll_effect']) ) {
                        $values_from    .= 'scaleX: 1,scaleY: 1,';
                        $values_to      .= 'scaleX: 1.2,scaleY: 1.2,';
                    } elseif ( in_array('scaleOut', $settings['scroll_effect']) ) {
                        $values_from    .= 'scaleX: 1.2,scaleY: 1.2,';
                        $values_to      .= 'scaleX: 1,scaleY: 1,';
                    }
                    if ( in_array('opacity', $settings['scroll_effect']) ) {
                        $values_from    .= 'opacity: 0,';
                        $values_to      .= 'opacity: 1,';
                    }
                }
            }
            if ( $type == 'footer' ) $offset = 'offset: $(window).height()*-1';
            else $offset = '';

            $javascript .= 'var '.$type.'Scene = new ScrollMagic.Scene({ triggerElement: "#hb_before'.$type.'", duration: $("#hb_container-'.$type.'").height() , reverse: true, '.$offset.'})';//.addIndicators()';
            $javascript .= '.setTween( TweenLite.fromTo("#hb_'.$type.'", 0.1, {'.$values_from.'}, {'.$values_to.'ease: Linear.easeNone} ) ).addTo(controller);'; // .addIndicators();';
            // .addIndicators()
        }
        return $javascript;
   	} // End hb_javascript()


} // End HayyaHooks class
