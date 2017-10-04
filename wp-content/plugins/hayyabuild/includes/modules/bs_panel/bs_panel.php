<?php
/**
 * Text class.
 *
 *
 * @since      1.0.0
 * @package    hayyabuild
 * @subpackage hayyabuild/includes/modules/bs_panel
 * @author     ZintaThemes <>
 */
class HayyaModule_bs_panel
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
	public $icon 		= 'glyphicon glyphicon-blackboard';
	
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
	public $categories = 'Bootstrap';
	
	/**
	 * Construct function.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function __construct() {
		
		$this->name 		= __('Bootstrap Panel', HAYYAB_BASENAME);
		$this->description 	= __('put your DOM in a box', HAYYAB_BASENAME);
		
		$this->params = array(
				'panel_header' => array(
						'type' => 'textfield',
						'heading' => __('Header Text', HAYYAB_BASENAME),
						'value' => '',
						'description' => __('Keep it empty to hide panel header.', HAYYAB_BASENAME),
				),
				'panel_body' => array(
						'type' => 'textarea',
						'heading' => __('Text', HAYYAB_BASENAME),
						'value' => __('Insert text.', HAYYAB_BASENAME),
				),
				'panel_footer' => array(
						'type' => 'textfield',
						'heading' => __('Footer Text', HAYYAB_BASENAME),
						'value' => '',
						'description' => __('Keep it empty to hide panel footer.', HAYYAB_BASENAME),
				),
				'theme' => array(
						'type' => 'dropdown',
						'heading' => __('Select theme', HAYYAB_BASENAME),
						'description' => __('Select bootstrap alert theme.', HAYYAB_BASENAME),
						'value' => array(
								'default' => __('Default', HAYYAB_BASENAME),
								'primary' => __('Primary', HAYYAB_BASENAME),
								'success' => __('Success', HAYYAB_BASENAME),
								'info' => __('Info', HAYYAB_BASENAME),
								'warning' => __('Warning', HAYYAB_BASENAME),
								'danger' => __('Danger', HAYYAB_BASENAME),
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
				'panel_header' => '<div class="panel-heading">'.$param['panel_header'].'</div>',
				'panel_footer' => '<div class="panel-footer">'.$param['panel_footer'].'</div>',
				'theme'	=> 'panel-'.$param['theme'],
		);
		$html = '<div id="'.$param['id'].'" class="'.$param['class'].' panel '.$param['theme'].'" style="'.$param['style'].'">'.$param['panel_header'].'<div class="panel-body">'.$param['panel_body'].'</div>'.$param['panel_footer'].'</div>';
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
