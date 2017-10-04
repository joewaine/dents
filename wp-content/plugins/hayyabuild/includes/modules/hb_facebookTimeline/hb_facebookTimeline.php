<?php
/**
 * Icon class.
 *
 *
 * @since      1.0.0
 * @package    hayyabuild
 * @subpackage hayyabuild/includes/modules/hb_facebookTimeline
 * @author     ZintaThemes <>
 */
class HayyaModule_hb_facebookTimeline
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
	public $icon = 'fa fa-facebook';
	
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
		$this->name = __ ( 'Facebook timeline', HAYYAB_BASENAME );
		$this->description = __ ( 'Add latest facebook posts to your website', HAYYAB_BASENAME );
		
		$this->params = array (
                'url' => array(
                        'type' => 'link',
                        'heading' => __('Facebook Page URL', HAYYAB_BASENAME),
                        'description' => __('Facebook Page URL.', HAYYAB_BASENAME),
                ),
                'tabs' => array(
                        'type' => 'dropdown',
                        'heading' => __('Tabs', HAYYAB_BASENAME),
                		'value' => array('timeline' => __('timeline', HAYYAB_BASENAME)),
                ),
                'width' => array(
                        'type' => 'integer_slider',
                        'heading' => __('Width', HAYYAB_BASENAME),
                        'description' => __('Box width.', HAYYAB_BASENAME),
                        'min' => '100',
                        'max' => '700',
                        'step' => '1',
                        'value' => '300'
                ),
                'height' => array(
                        'type' => 'integer_slider',
                        'heading' => __('Height', HAYYAB_BASENAME),
                        'description' => __('Box height.', HAYYAB_BASENAME),
                        'min' => '100',
                        'max' => '700',
                        'step' => '1',
                        'value' => '300'
                ),
                'small_header' => array(
                        'type' => 'checkbox',
                        'heading' => __('Use Small Header', HAYYAB_BASENAME),
                        'description' => __('Use Small Header.', HAYYAB_BASENAME),
                		'value' => array('hb_share' => __('Yes', HAYYAB_BASENAME)),
                ),
                'hide_cover' => array(
                        'type' => 'checkbox',
                        'heading' => __('Hide Cover Photo', HAYYAB_BASENAME),
                        'description' => __('Hide Cover Photo.', HAYYAB_BASENAME),
                		'value' => array('hide' => __('Yes', HAYYAB_BASENAME)),
                ),
                'show_facepile' => array(
                        'type' => 'checkbox',
                        'heading' => __('Show Friends Faces', HAYYAB_BASENAME),
                        'description' => __('Show Friends Faces.', HAYYAB_BASENAME),
                		'value' => array('faces' => __('Yes', HAYYAB_BASENAME)),
                ),
		);
        $this->admin_css = array('hb_facebookTimeline' => 'css/admin.css');
	}
	
	/**
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_render($param = null) {
		$args = array(
				'small_header' 	=> array(null 	=> 'false', 'else' 	=> 'true'),
				'hide_cover' 	=> array(null 	=> 'false', 'else' 	=> 'true'),
				'show_facepile'	=> array(null 	=> 'false', 'else' 	=> 'true'),
		);
		$html = '<div id="'.$param['id'].'" class="'.$param['class'].'" style="'.$param['style'].'"><iframe src="https://www.facebook.com/plugins/page.php?href='.$param['url'].'&tabs='.$param['tabs'].'&width='.$param['width'].'&height='.$param['height'].'&small_header='.$param['small_header'].'&adapt_container_width=true&hide_cover='.$param['hide_cover'].'&show_facepile='.$param['show_facepile'].'" width="'.$param['width'].'" height="'.$param['height'].'" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe></div>';
		return array('output' => $html, 'args'=> $args );
	}
	
	/**
	 * Public Output funnction.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function public_render($atts, $content = '') {
		return false;
	}
}

