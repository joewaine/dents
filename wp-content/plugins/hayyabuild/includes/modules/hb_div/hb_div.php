<?php
/**
 * Icon class.
 *
 *
 * @since      1.0.0
 * @package    hayyabuild
 * @subpackage hayyabuild/includes/modules/hb_div
 * @author     ZintaThemes <>
 */
class HayyaModule_hb_div
{
	/**
	 * Type of element "header, content, footer, all".
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string		$type		The current version of this plugin.
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
	public $icon 		= 'fa fa-square-o';

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
	public $is_container = true;

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
	public $categories = 'Containers';

	/**
	 * Construct function.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function __construct() {

		$this->name 		= __('Content Box', HAYYAB_BASENAME);
		$this->description 	= __('Insert content box.', HAYYAB_BASENAME);

		$this->params = array(

				'width' => array(
						'type' => 'dropdown',
						'heading' => __('DIV width', HAYYAB_BASENAME),
						'description' => __('Make this DIV as a contanier or a container-fluid', HAYYAB_BASENAME),
						'value'	  => array(
								'' => __('Default', HAYYAB_BASENAME),
								'container' => __('Container', HAYYAB_BASENAME),
								'container-fluid' => __('Container Fluid', HAYYAB_BASENAME),
						)
				),
				'hb_align' => array (
                        'type' => 'dropdown',
                        'heading' => __ ( 'Text align', HAYYAB_BASENAME ),
						'value' => array(
								'' => __('Default', HAYYAB_BASENAME),
								'left' => __('Left', HAYYAB_BASENAME),
								'center' => __('Center', HAYYAB_BASENAME),
								'right' => __('Right', HAYYAB_BASENAME),
						)
                )
// 				'bottom' => array(
// 						'type' => '"checkbox"',
// 						'heading' => __('"Put it at bottom"'),
// 						'description' => __('" this DIV at ."'),
// 						'value' => array(
// 								'yes' => __('"Yes"'),
// 						)
// 				),
		);

	}

	/**
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function admin_render($param = null) {
		$args = array( 'hb_align' => ' text-align:'.$param['hb_align'].';' );
		$html = '<div id="'.$param['id'].'" class="'.$param['class'].' '.$param['width'].'" style="'.$param['style'].$param['hb_align'].'"></div>';
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
