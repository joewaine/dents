<?php
/**
 * Icon class.
 *
 *
 * @since      1.0.0
 * @package    hayyabuild
 * @subpackage hayyabuild/includes/modules/hb_twitterTimeline
 * @author     ZintaThemes <>
 */
class HayyaModule_hb_twitterTimeline
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
	public $icon = 'fa fa-twitter';
	
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
		$this->name 		= __( 'Twitter Timeline', HAYYAB_BASENAME );
		$this->description 	= __( 'Add latest tweets to your website', HAYYAB_BASENAME );
		
		$this->params = array (
                'template' => array (
                        'type' => 'dropdown',
                        'heading' => __ ( 'Timeline template', HAYYAB_BASENAME ),
                        'description' => __ ( 'Choose Timeline template type.', HAYYAB_BASENAME ),
                		'value' => array(
                				'list' => __('List template', HAYYAB_BASENAME),
                				'grid' => __('Grid template', HAYYAB_BASENAME),
                		)
                ),
                'url' => array(
                        'type' => 'link',
                        'heading' => __('Twitter URL', HAYYAB_BASENAME),
                        'description' => __('twitter URL.<br/>you can use collections URL', HAYYAB_BASENAME),
                ),
                'width' => array(
                        'type' => 'integer_slider',
                        'heading' => __('Widget width', HAYYAB_BASENAME),
                        'description' => __('Widget width.', HAYYAB_BASENAME),
                        'min' => '150',
                        'max' => '520',
                        'step' => '1',
                        'value' => '300'
                ),
//                 'separator2' => array('type' => 'separator', 'heading' => __('For list template only.', HAYYAB_BASENAME)),
                'height' => array(
                        'type' => 'integer_slider',
                        'heading' => __('Widget height', HAYYAB_BASENAME),
                        'description' => __('Widget height.', HAYYAB_BASENAME),
                        'min' => '200',
                        'max' => '600',
                        'step' => '1',
                        'value' => '500'
                ),
                'limit' => array(
                        'type' => 'integer_slider',
                        'heading' => __('Number of tweets', HAYYAB_BASENAME),
                        'description' => __('Display a specific number of items between 1 and 20 by customizing your embed HTML.', HAYYAB_BASENAME),
                        'min' => '1',
                        'step' => '1',
                        'max' => '20',
                        'value' => '5',
                ),
                'noheader' => array(
                        'type' => 'checkbox',
                        'heading' => __('No header', HAYYAB_BASENAME),
                        'description' => __('Hides the timeline header.', HAYYAB_BASENAME),
                		'value' => array(
                				'noheader' => __('Hides header', HAYYAB_BASENAME)
                		)
                ),
                'nofooter' => array(
                        'type' => 'checkbox',
                        'heading' => __('No footer', HAYYAB_BASENAME),
                        'description' => __('Hides the timeline footer.', HAYYAB_BASENAME),
                		'value' => array(
                				'nofooter' => __('Hides footer', HAYYAB_BASENAME)
                		)
                ),
                'noborders' => array(
                        'type' => 'checkbox',
                        'heading' => __('No borders', HAYYAB_BASENAME),
                        'description' => __('Removes all borders within the widget including borders surrounding the widget area and separating Tweets.', HAYYAB_BASENAME),
                		'value' => array(
                				'noborders' => __('Removes all borders', HAYYAB_BASENAME)
                		)
                ),
                'noscrollbar' => array(
                        'type' => 'checkbox',
                        'heading' => __('No scrollbar', HAYYAB_BASENAME),
                        'description' => __('Crops and hides the main timeline scrollbar, if visible.<br/>Please consider that hiding standard user interface components can affect the accessibility of your website.', HAYYAB_BASENAME),
                		'value' => array(
                				'noscrollbar' => __('No scrollbar', HAYYAB_BASENAME)
                		)
                ),
                'transparent' => array(
                        'type' => 'checkbox',
                        'heading' => __('Transparent background', HAYYAB_BASENAME),
                        'description' => __('Removes the widget’s background color.', HAYYAB_BASENAME),
                		'value' => array(
                				'transparent' => __('Transparent', HAYYAB_BASENAME)
                		)
                ),
		);
        $this->admin_css = array('hb_twitterTimeline' => 'css/admin.css');
        $this->js_files = array('twitter_widgets' => '//platform.twitter.com/widgets.js');
	}
	
	/**
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_render($param = null) {
		$args = array(
				'template' => array(
						'list' => 'twitter-timeline',
						'else' => 'twitter-grid',
				),
				'limit' => ' data-tweet-limit="'.$param['limit'].'"',
		);
		
		$dataChrome = ' data-chrome="'.$param['noheader'].' '.$param['nofooter'].' '.$param['noborders'].' '.$param['noscrollbar'].' '.$param['transparent'].'"';
		
		$html = '<div id="'.$param['id'].'" class="'.$param['class'].'" style="'.$param['style'].'">
					<a class="'.$param['template'].'"'.$param['limit'].' width="'.$param['width'].'" height="'.$param['height'].'" href="'.$param['url'].'"'.$dataChrome.'></a>
					<div class="hayya_show_at_backend">
						'.__('Module name', HAYYAB_BASENAME).': '.$this->name.'<br/>
						'.__('Twitter URL', HAYYAB_BASENAME).': '.$param['url'].'
					</div>
				</div>';
		return array('output' => $html, 'args'=> $args );
	}
	
	/**
	 * Public Output funnction.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function public_render($atts, $content = '') {
		$output = '';
		return $output;
	}
}

