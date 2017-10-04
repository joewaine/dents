<?php
/**
 * Icon class.
 *
 *
 * @since      1.0.0
 * @package    hayyabuild
 * @subpackage hayyabuild/includes/modules/hb_fbLikeButton
 * @author     ZintaThemes <>
 */
class HayyaModule_hb_fbLikeButton
{
	/**
	 * Type of element "header, content, footer, all".
	 *
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string $type The current version of this plugin.
	 */
	public $type = 'all';

	/**
	 * The name of element.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string $name The current version of this plugin.
	 */
	public $name = '';

	/**
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string $icon The current version of this plugin.
	 */
	public $icon = 'fa fa-facebook-square';

	/**
	 * The version of this plugin.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string $description The current version of this plugin.
	 */
	public $description = '';

	/**
	 * Show settings dialog after click in create.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string $show_settings_on_create The current version of this plugin.
	 */
	public $show_settings_on_create = true;

	/**
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string $is_container The current version of this plugin.
	 */
	public $is_container = false;

	/**
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string $has_content The current version of this plugin.
	 */
	public $has_content = false;

	/**
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string $params The current version of this plugin.
	 */
	public $params = array ();

	/**
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string $css_files The current version of this plugin.
	 */
	public $css_files = array ();

	/**
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string $js_files The current version of this plugin.
	 */
	public $js_files = array ();

	/**
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string $activated Active this element.
	 */
	public $activated = true;

	/**
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string $categories The current version of this plugin.
	 */
	public $categories = 'Contents';

	/**
	 * Construct function.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$this->name = __( 'Facebook Like Button', HAYYAB_BASENAME );
		$this->description = __( 'Add facebook like button to your WordPress', HAYYAB_BASENAME );

		$this->params = array (
		        'action' => array (
                        'type' => 'dropdown',
                        'heading' => __('Action Type', HAYYAB_BASENAME),
                        'description' => __('The verb to display on the button.<br/>Can be either <b>like</b> or <b>recommend</b>.', HAYYAB_BASENAME),
		        		'value' => array(
		        				'like' => __('Like', HAYYAB_BASENAME),
		        				'recommend' => __('Recommend', HAYYAB_BASENAME)
		        		),
                ),
                'colorscheme' => array (
                        'type' => 'dropdown',
                        'heading' => __('Color Scheme', HAYYAB_BASENAME ),
                        'description' => __( 'The color scheme used by the plugin for <br/>any text outside of the button itself.', HAYYAB_BASENAME),
                		'value' => array(
                				'light' => __('Light', HAYYAB_BASENAME),
                				'dark' => __('Dark', HAYYAB_BASENAME)
                		),
                ),
                'href' => array(
                        'type' => 'link',
                        'heading' => __('URL ', HAYYAB_BASENAME),
                        'description' => __('The absolute URL of the page that will be liked.', HAYYAB_BASENAME),
                ),
                'layout' => array (
                        'type' => 'dropdown',
                        'heading' => __( 'Button Layout', HAYYAB_BASENAME ),
                        'description' => __( 'Selects one of the different layouts that are available for the plugin.', HAYYAB_BASENAME),
                		'value' => array(
                				'standard' => __('Standard', HAYYAB_BASENAME),
                				'button' => __('Button', HAYYAB_BASENAME),
                				'button_count' => __('Button Count', HAYYAB_BASENAME),
                				'box_count' => __('Box Count', HAYYAB_BASENAME),
                		),
                ),
                'width' => array(
                        'type' => 'integer_slider',
                        'heading' => __('Box width', HAYYAB_BASENAME),
                        'description' => __('Box width.', HAYYAB_BASENAME),
                        'min' => '10',
                        'max' => '500',
                        'step' => '1',
                        'value' => '200'
                ),
                'height' => array(
                        'type' => 'integer_slider',
                        'heading' => __('Box height', HAYYAB_BASENAME),
                        'description' => __('Box height.', HAYYAB_BASENAME),
                        'min' => '10',
                        'max' => '500',
                        'step' => '1',
                        'value' => '50'
                ),
                'share' => array(
                        'type' => 'checkbox',
                        'heading' => __('Share Button', HAYYAB_BASENAME),
                        'description' => __('Specifies whether to include a share button beside the Like button.', HAYYAB_BASENAME),
                		'value' => array('hb_share' => __('Yes', HAYYAB_BASENAME)),
                ),
                'show_faces' => array(
                        'type' => 'checkbox',
                        'heading' => __('Show Faces', HAYYAB_BASENAME),
                        'description' => __('Specifies whether to display profile photos below the button (standard layout only).', HAYYAB_BASENAME),
                		'value' => array('hb_faces' => __('Yes', HAYYAB_BASENAME)),
                ),
		);
        $this->admin_css = array('hb_fbLikeButton' => 'css/admin.css');
	}

	/**
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_render($param = null) {
		$args = array(
				'href' => 'href='.$param['href'].'&amp;',
				'width'	=> 'width='.$param['width'].'&amp;',
				'share'	=> 'share=true&amp;',
				'show_faces'	=> 'show_faces=true&amp;',
		);
		$src = 'http://www.facebook.com/plugins/like.php?layout='.$param['layout'].'&amp;action='.$param['action'].'&amp;colorscheme='.$param['colorscheme'].'&amp;'.$param['href'].$param['width'].$param['share'].$param['show_faces'];
		$html = '<div id="'.$param['id'].'" class="'.$param['class'].'" style="'.$param['style'].'">
					<iframe src="'.$src.'" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:'.$param['width'].'px; height:'.$param['height'].'px;">
					</iframe>
				</div>';
		return array('output' => $html, 'args'=> $args );
	}

	/**
	 * Public Output funnction.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function public_render($atts, $content = '') { return false; }
}
?>
