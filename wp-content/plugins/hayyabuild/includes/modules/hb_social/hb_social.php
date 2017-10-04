<?php
/**
 * Icon class.
 *
 *
 * @since      1.0.0
 * @package    hayyabuild
 * @subpackage hayyabuild/includes/modules/hb_social
 * @author     ZintaThemes <>
 */
class HayyaModule_hb_social
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
	public $icon = 'fa fa-group';

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
		$this->name 		= __('Social Menu', HAYYAB_BASENAME);
		$this->description 	= __('Create social menu', HAYYAB_BASENAME);

		$this->params = array (
				'align' => array(
						'type' => 'dropdown',
						'heading' => __('Align', HAYYAB_BASENAME),
						'value' => array(
								'hb_left' => __('Left', HAYYAB_BASENAME),
								'hb_center' => __('Center', HAYYAB_BASENAME),
								'hb_right' => __('Right', HAYYAB_BASENAME),
						)
				),
				'size' => array(
						'type' => 'integer_slider',
						'heading' => __('Icone Size', HAYYAB_BASENAME),
						'min' => '1',
						'max' => '20',
						'step' => '1',
				),
				'hb_shadow' => array(
						'type' => 'checkbox',
						'heading' => __('Enable icone shadow', HAYYAB_BASENAME),
						'value' => array(
								'yes' => __('Yes', HAYYAB_BASENAME),
						)
				),
				'facebook' => array(
						'type' => 'link',
						'heading' => __('Facebook', HAYYAB_BASENAME),
						'description' => __('Link to youe facebook page.', HAYYAB_BASENAME),
				),
				'twitter' => array(
						'type' => 'link',
						'heading' => __('Twitter', HAYYAB_BASENAME),
						'description' => __('Link to youe twitter.', HAYYAB_BASENAME),
				),
				'googleplus' => array(
						'type' => 'link',
						'heading' => __('Google Plus', HAYYAB_BASENAME),
						'description' => __('Link to youe Google Plus.', HAYYAB_BASENAME),
				),
				'linkedin' => array(
						'type' => 'link',
						'heading' => __('Linkedin', HAYYAB_BASENAME),
						'description' => __('Link to youe Linkedin.', HAYYAB_BASENAME),
				),
				'youtube' => array(
						'type' => 'link',
						'heading' => __('Youtube', HAYYAB_BASENAME),
						'description' => __('Link to youe youtube.', HAYYAB_BASENAME),
				),
				'vimeo' => array(
						'type' => 'link',
						'heading' => __('Vimeo', HAYYAB_BASENAME),
						'description' => __('Link to youe Vimeo.', HAYYAB_BASENAME),
				),
				'instagram' => array(
						'type' => 'link',
						'heading' => __('Instagram', HAYYAB_BASENAME),
						'description' => __('Link to youe Instagram.', HAYYAB_BASENAME),
				),
				'pinterest' => array(
						'type' => 'link',
						'heading' => __('Pinterest', HAYYAB_BASENAME),
						'description' => __('Link to youe Pinterest.', HAYYAB_BASENAME),
				),
				'flickr' => array(
						'type' => 'link',
						'heading' => __('Flickr', HAYYAB_BASENAME),
						'description' => __('Link to youe flickr.', HAYYAB_BASENAME),
				),
				'github' => array(
						'type' => 'link',
						'heading' => __('Github', HAYYAB_BASENAME),
						'description' => __('Link to youe Github.', HAYYAB_BASENAME),
				),
				'VK' => array(
						'type' => 'link',
						'heading' => __('VK', HAYYAB_BASENAME),
						'description' => __('Link to youe VK.', HAYYAB_BASENAME), // icon  fa-vk
				),
				'tumblr' => array(
						'type' => 'link',
						'heading' => __('Tumblr', HAYYAB_BASENAME),
						'description' => __('Link to youe Tumblr.', HAYYAB_BASENAME),
				),
				//////////////
// 				'naver' => array(
// 						'type' => '"link"',
// 						'heading' => __('"Tumblr"', HAYYAB_BASENAME),
// 						'description' => __('"Link to youe Tumblr."', HAYYAB_BASENAME), // icon
// 				),
// 				'kakao' => array(
// 						'type' => '"link"',
// 						'heading' => __('"Tumblr"', HAYYAB_BASENAME),
// 						'description' => __('"Link to youe Tumblr."', HAYYAB_BASENAME), // icon
// 				),
		);
	}

	/**
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_render($param = null) {
		$args = array(
				'align' => ' '.$param['align'],
				'size' => ' size-'.$param['size'],
				'hb_shadow' => ' hb_shadow',
				'facebook' => '<a class="facebook" href="'.$param['facebook'].'" style="'.$param['style'].'"><i class="fa fa-facebook"></i></a>',
				'twitter' => '<a class="twitter" href="'.$param['twitter'].'" style="'.$param['style'].'"><i class="fa fa-twitter"></i></a>',
				'googleplus' => '<a class="googleplus" href="'.$param['googleplus'].'" style="'.$param['style'].'"><i class="fa fa-google-plus"></i></a>',
				'linkedin' => '<a class="linkedin" href="'.$param['linkedin'].'" style="'.$param['style'].'"><i class="fa fa-linkedin"></i></a>',
				'youtube' => '<a class="youtube" href="'.$param['youtube'].'" style="'.$param['style'].'"><i class="fa fa-youtube"></i></a>',
				'vimeo' => '<a class="vimeo" href="'.$param['vimeo'].'" style="'.$param['style'].'"><i class="fa fa-vimeo"></i></a>',
				'instagram' => '<a class="instagram" href="'.$param['instagram'].'" style="'.$param['style'].'"><i class="fa fa-instagram"></i></a>',
				'pinterest' => '<a class="pinterest" href="'.$param['pinterest'].'" style="'.$param['style'].'"><i class="fa fa-pinterest"></i></a>',
				'flickr' => '<a class="flickr" href="'.$param['flickr'].'" style="'.$param['style'].'"><i class="fa fa-flickr"></i></a>',
				'github' => '<a class="github" href="'.$param['github'].'" style="'.$param['style'].'"><i class="fa fa-github"></i></a>',
				'VK' => '<a class="VK" href="'.$param['VK'].'" style="'.$param['style'].'"><i class="fa fa-vk"></i></a>',
				'tumblr' => '<a class="tumblr" href="'.$param['tumblr'].'" style="'.$param['style'].'"><i class="fa fa-tumblr"></i></a>',
		);
		$classes = $param['class'].$param['hb_shadow'].$param['align'].$param['size'];
		$social = $param['facebook'].$param['twitter'].$param['googleplus'].$param['linkedin'].$param['youtube'].$param['vimeo'].$param['instagram'].$param['pinterest'].$param['flickr'].$param['github'].$param['VK'].$param['tumblr'];
		$html = '<div id="'.$param['id'].'" class="'.$classes.'">'.$social.'</div>';
		return array('output' => $html, 'args'=> $args );
	}

	/**
	 * Public Output funnction.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function public_render($atts, $content = null) {
		return false;
	}
}
?>
