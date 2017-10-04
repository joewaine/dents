<?php
/**
 * Text class.
 *
 *
 * @since      1.0.0
 * @package    hayyabuild
 * @subpackage hayyabuild/includes/modules/bs_well
 * @author     ZintaThemes <>
 */
class HayyaModule_bs_well
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
	public $icon 		= 'fa fa-th-large';
	
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
	 * @var      string    $has_content	    The current version of this plugin.
	 */
	public $has_content = false;

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
	public $categories = 'Bootstrap';
	
	/**
	 * Construct function.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function __construct() {
		
		$this->name 		= __('Bootstrap Well', HAYYAB_BASENAME);
		$this->description 	= __('Bootstrap well', HAYYAB_BASENAME);
		
		$this->params = array(
				'content' => array(
						'type' => 'textarea',
						'heading' => __('Text', HAYYAB_BASENAME),
						'value' => __('Text content.', HAYYAB_BASENAME)
				),
				'size' => array(
						'type' => 'dropdown',
						'heading' => __('Padding control', HAYYAB_BASENAME),
						'description' => __('Control padding and rounded corners.', HAYYAB_BASENAME),
						'value' => '{sm: '.__('"Small"', HAYYAB_BASENAME).', lg: '.__('"Large"', HAYYAB_BASENAME).'}',
						'value' => array(
								'default' => __('Default', HAYYAB_BASENAME),
								'sm' => __('Small', HAYYAB_BASENAME),
								'lg' => __('Large', HAYYAB_BASENAME),
						)
				),
		);
	}
	
	/**
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function admin_render($param = null) {
		$args = array(
				'size' => array(
						 null => '',
						'default' => '',
						'else' => ' well-'.$param['size'].' ',
				),
		);
		$html = '<div id="'.$param['id'].'" class="'.$param['class'].' well'.$param['size'].'" style="'.$param['style'].'">'.$param['content'].'</div>';
		return array('output' => $html, 'args'=> $args );
	}
	
	/**
	 * Public Output funnction.
	 * 
	 * @since    1.0.0
	 * @access   public
	 */
	public function public_render( $output ) { return $output; }
	
}
