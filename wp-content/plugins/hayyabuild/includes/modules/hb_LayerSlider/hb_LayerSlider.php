<?php
/**
 * Icon class.
 *
 *
 * @since      1.3.0
 * @package    hayyabuild
 * @subpackage hayyabuild/includes/modules/hb_LayerSlider
 * @author     ZintaThemes <>
 */
class HayyaModule_hb_LayerSlider
{
	/**
	 * Type of element "header, content, footer, all". 
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $type		The current version of this plugin.
	 */
	public $type 	= 'all';
	
	/**
	 * The name of element.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $name		The current version of this plugin.
	 */
	public $name 		= '';

	/**
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $icon	    The current version of this plugin.
	 */
	public $icon 		= 'fa fa-wordpress';
	
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $description The current version of this plugin.
	 */
	public $description = '';

	/**
	 * Show settings dialog after click in create.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $show_settings_on_create    The current version of this plugin.
	 */
	public $show_settings_on_create = true;

	/**
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $is_container    The current version of this plugin.
	 */
	public $is_container = false;
	
	/**
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $params		    The current version of this plugin.
	 */
	public $params 	= array();
	
	/**
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $css_files	    The current version of this plugin.
	 */
	public $css_files 	= array();

	/**
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $admin_css	    Admin style file.
	 */
	public $admin_css 	= array();
	
	/**
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $js_files	    The current version of this plugin.
	 */
	public $js_files 	= array();
	
	/**
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $activated    Active this element.
	 */
	public $activated = false;
	
	/**
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $categories    The current version of this plugin.
	 */
	public $categories = 'Plugins';
	
	/**
	 * Construct function.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function __construct() {
		$this->name 		= __('Layer Slider', HAYYAB_BASENAME);
		$this->description 	= __('Responsive Wordpress Slider Plugin', HAYYAB_BASENAME);
    	
    	$sliders = array();
		if (  is_admin() && function_exists('is_plugin_active') &&is_plugin_active('LayerSlider/layerslider.php') ) {
			
            global $wpdb;
    		$sliders_list = $wpdb->get_results( 'SELECT `id`,`name`,`flag_deleted` FROM `'.$wpdb->prefix.'layerslider`', OBJECT );
    		
    		if ( !empty($sliders) ) {
	    		foreach ($sliders_list as $value) {
	    			if ( $value->flag_deleted != '1' ) $sliders[$value->id] = $value->name;
	    		}
    		}
    		
    		if ( !empty($sliders) ) $this->activated = true;
    		
        }
   		$this->params = array(
   				'slider' => array(
   						'type' => 'dropdown',
   						'heading' => __('Select Slider', HAYYAB_BASENAME),
   						'description' => __('You have to create sliders.', HAYYAB_BASENAME),
   						'value' => $sliders 
   				)
   		);
   		
	}
	
	/**
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function admin_render($param = null) {
		return '<div id="'.$param['id'].'" class="'.$param['class'].'" style="'.$param['style'].'">
					<div class="hayya_hide_from_backend">
						[layerslider id="'.$param['slider'].'"]
					</div>
					<div class="hayya_show_at_backend">
						'.__('Module name', HAYYAB_BASENAME).': '.$this->name.'<br/>
						'.__('Slider ID', HAYYAB_BASENAME).': '.$param['slider'].'<br/>
					</div>
				</div>';
	}
	
	/**
	 * Public Output funnction.
	 * 
	 * @since    1.0.0
	 * @access   public
	 */
	public function public_render( $atts, $content = null ) {return false;}
	
}
