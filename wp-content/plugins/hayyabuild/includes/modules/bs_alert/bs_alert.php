<?php
/**
 * Text class.
 *
 *
 * @since      1.0.0
 * @package    hayyabuild
 * @subpackage hayyabuild/includes/modules/bs_alert
 * @author     ZintaThemes <>
 */
class HayyaModule_bs_alert
{
	/**
	 * Type of element "header, content, footer, all".
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    	$type		The current version of this plugin.
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
	public $icon 		= 'fa fa-exclamation-triangle';

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
	public $has_content = true;

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

		$this->name 		= __('Alert Box', HAYYAB_BASENAME);
		$this->description 	= __('Provide contextual feedback messages', HAYYAB_BASENAME);

		$this->params = array(
				'content' => array(
						'type' => 'textarea',
						'heading' => __('Text', HAYYAB_BASENAME),
						'value' => __('Text content.', HAYYAB_BASENAME)
				),
				'theme' => array(
						'type' => 'dropdown',
						'heading' => __('Select theme', HAYYAB_BASENAME),
						'description' => __('Select bootstrap alert theme.', HAYYAB_BASENAME),
						'value' => array(
								'success' => __('Success', HAYYAB_BASENAME),
								'info' => __('Info', HAYYAB_BASENAME),
								'warning' => __('Warning', HAYYAB_BASENAME),
								'danger' => __('Danger', HAYYAB_BASENAME),
						)
				),
				'dismissible' => array(
						'type' => 'checkbox',
						'heading' => __('Dismissible alerts', HAYYAB_BASENAME),
						'description' => __('Build on any alert with close button.', HAYYAB_BASENAME),
						'value' => array(
								'yes' => __('Yes', HAYYAB_BASENAME)
						),
				),
				'icon' => array(
						'type' => 'icon',
						'heading' => __('Icon', HAYYAB_BASENAME)
				),
		);
		
	}

	/**
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function admin_render( $param = array() ) {
		$args = array(
				'icon' 			=> '<span class="'.$param['icon'].'"></span> ',
				'dismissible' 	=> 'dismissible'
		);
		
		$html = '<div id="'.$param['id'].'" class="'.$param['class'].' alert alert-'.$param['theme'].' '.$param['dismissible'].'" role="alert" style="'.$param['style'].'">'.$param['icon'].$param['content'].'</div>';
		return array('output' => $html, 'args'=> $args );
	}

	/**
	 * public Output funnction.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function public_render( $output ) { return $output; }

}
