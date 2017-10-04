<?php
/**
 * Text class.
 *
 *
 * @since      1.0.0
 * @package    hayyabuild
 * @subpackage hayyabuild/includes/modules/bs_progress
 * @author     ZintaThemes <>
 */
class HayyaModule_bs_progress
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
	public $icon 		= 'fa fa-tasks';
	
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
		
		$this->name 		= __('Progress bar', HAYYAB_BASENAME);
		$this->description 	= __('Provide up-to-date feedback', HAYYAB_BASENAME);
		
		$this->params = array(
				'text' => array(
						'type' => 'textfield',
						'heading' => __('Text', HAYYAB_BASENAME),
						'value' => __('Text content.', HAYYAB_BASENAME)
				),
				'width' => array(
						'type' => 'integer_slider',
						'heading' => __('Progress width', HAYYAB_BASENAME),
						'description' => __('Progress width ( percentage ).', HAYYAB_BASENAME)
				),
				'theme' => array(
						'type' => 'dropdown',
						'heading' => __('Select theme', HAYYAB_BASENAME),
						'description' => __('Select bootstrap alert theme.', HAYYAB_BASENAME),
						'value' => '{danger: '.__('Danger', HAYYAB_BASENAME).'}',
						'value' => array(
								'none' => __('None', HAYYAB_BASENAME),
								'success' => __('Success', HAYYAB_BASENAME),
								'info' => __('Info', HAYYAB_BASENAME),
								'warning' => __('Warning', HAYYAB_BASENAME),
								'danger' => __('Danger', HAYYAB_BASENAME),
						)
				),
				'striped' => array(
						'type' => 'checkbox',
						'heading' => __('Striped ?', HAYYAB_BASENAME),
						'description' => __('Uses a gradient to create a striped effect. Not available in IE9 and below.', HAYYAB_BASENAME),
						'value' => array(
								'yes' => __('Yes', HAYYAB_BASENAME),
						)
				),
				'animated' => array(
						'type' => 'checkbox',
						'heading' => __('Animated', HAYYAB_BASENAME),
						'description' => __('Animate the stripes right to left. Not available in IE9 and below.', HAYYAB_BASENAME),
						'value' => array(
								'yes' => __('Yes', HAYYAB_BASENAME),
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
				'striped'	=> ' progress-bar-striped',
				'animated'	=> ' active',
				'theme' => array(
						null => '',
						'none' => '',
						'else' => ' progress-bar-'.$param['theme'],
				),
				'width' => array(
						null => '0',
						'else' => $param['width'],
				),
		);
		$html = '<div id="'.$param['id'].'" class="'.$param['class'].'" style="'.$param['style'].'">
					<div class="progress">
						<div class="progress-bar'.$param['theme'].$param['striped'].''.$param['animated'].'" role="progressbar" aria-valuenow="'.$param['width'].'" aria-valuemin="0" aria-valuemax="100" style="width: '.$param['width'].'%;">
							'.$param['text'].'
						</div>
					</div>
				 </div>';
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
