<?php
/**
 * Text class.
 *
 *
 * @since      1.0.0
 * @package    hayyabuild
 * @subpackage hayyabuild/includes/modules/hb_gotop
 * @author     ZintaThemes <>
 */
class HayyaModule_hb_gotop
{
	/**
	 * Type of element "header, content, footer, all". 
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $type		The current version of this plugin.
	 */
	public $type 	= 'header';
	
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
	public $icon 		= 'fa fa-angle-double-up';
	
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
	 * @var      string    $js_files	    The current version of this plugin.
	 */
	public $js_files 	= array();
	
	/**
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $activated    Active this element.
	 */
	public $activated = true;
	
	/**
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $categories    The current version of this plugin.
	 */
	public $categories = 'Contents';
	
	/**
	 * Construct function.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function __construct() {
		
		$this->name 		= __('Go Top', HAYYAB_BASENAME);
		$this->description 	= __('Insert go to top link', HAYYAB_BASENAME);
		
		$this->params = array(
				'icon' => array(
						'type' => 'icon',
						'heading' => __('Select icon', HAYYAB_BASENAME),
						'description' => __('Just keep it empty to set this icon ( <i class=\"fa fa-angle-double-up\"></i> ).', HAYYAB_BASENAME),
				),
                'hb_align' => array (
                        'type' => 'dropdown',
                        'heading' => __('Text align', HAYYAB_BASENAME),
                		'value' => array(
                				'left' => __('Left', HAYYAB_BASENAME),
                				'center' => __('Center', HAYYAB_BASENAME),
                				'right' => __('Right', HAYYAB_BASENAME),
                		),
                ) 
		);
	}
	
	/**
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function admin_render($param = null) {
		$args = array('icon' => array( null => 'fa fa-angle-double-up', 'else' => $param['icon'] ));
		$html = '<div id="'.$param['id'].'" class="'.$param['class'].'" style="text-align:'.$param['hb_align'].';"><a href="#hb_header" id="hb_gotop"" style="'.$param['style'].'"> <i class="'.$param['icon'].'" > </i> </a></div>';
		return array('output' => $html, 'args'=> $args );
	}
	
	/**
	 * Public Output funnction.
	 * 
	 * @since    1.0.0
	 * @access   public
	 */
	public function public_render( $output ) { return false; }
	
}
