<?php
/**
 * Icon class.
 *
 *
 * @since      1.0.0
 * @package    hayyabuild
 * @subpackage hayyabuild/includes/modules/hb_twitterButton
 * @author     ZintaThemes <>
 */
class HayyaModule_hb_twitterButton
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
	public $icon = 'fa fa-twitter-square';
	
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
		$this->name 		= __( 'Twitter Button', HAYYAB_BASENAME );
		$this->description 	= __( 'Add twitter button', HAYYAB_BASENAME );
		
		$this->params = array (
		        'type' => array (
                        'type' => 'dropdown',
                        'heading' => __ ( 'Choose a button', HAYYAB_BASENAME ),
                        'description' => __ ( 'Select twitter button type.', HAYYAB_BASENAME ),
		        		'value' => array(
								'follow' => __('Follow button', HAYYAB_BASENAME),
		        				'share' => __('Share link', HAYYAB_BASENAME),
		        				'hashtag' => __('Hashtag Button', HAYYAB_BASENAME),
		        				'mention' => __('Mention Button', HAYYAB_BASENAME)
						)
                ),
                'username' => array(
                        'type' => 'textfield',
                        'heading' => __('Twitter username or hashtag', HAYYAB_BASENAME),
                        'description' => __('add twitter username for follow button or hashtag for hashtag button (don’t add @ or #).', HAYYAB_BASENAME),
                ),
                'large' => array(
                        'type' => 'checkbox',
                        'heading' => __('Large button', HAYYAB_BASENAME),
                        'description' => __('Use a large button.', HAYYAB_BASENAME),
                		'value' => array(
                				'large' => __('large', HAYYAB_BASENAME),
                		)
                ),
//                 'separator1' => array(
//                         'type' => 'separator', 'heading' => __('For follow button only', HAYYAB_BASENAME)
//                 ),
                'count' => array(
                        'type' => 'checkbox',
                        'heading' => __('Show count', HAYYAB_BASENAME),
                        'description' => __('Show number of followers.', HAYYAB_BASENAME),
                		'value' => array(
                				'yes' => __('Yes', HAYYAB_BASENAME),
                		)
                ),
                'url' => array(
                        'type' => 'link',
                        'heading' => __('Share URL ', HAYYAB_BASENAME),
                        'description' => __('Insert share URL.', HAYYAB_BASENAME),
                ),
                'text' => array(
                        'type' => 'textfield',
                        'heading' => __('Share text', HAYYAB_BASENAME),
                        'description' => __('Share text.', HAYYAB_BASENAME),
                ),
				'buttontext' => array('type' => 'hiddenfield', 'value' => 'activated'),
				'link' => array('type' => 'hiddenfield', 'value' => 'activated'),
		);
		
        $this->admin_css = array('hb_twitterButton' => 'css/admin.css');
        $this->js_files = array('twitter_widgets' => '//platform.twitter.com/widgets.js');
	}
	
	/**
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_render($param = null) {
		$args = array(
				'large' => ' data-size="large"',
				'count' => array(
						'empty' =>  ' data-show-count="flase"',
						'yes' => ' data-show-count="true"',
				),
				'type' => array(
						'follow' => array(
								'type' => 'follow',
								'buttontext' => __('Follow @', HAYYAB_BASENAME),
								'link' => $param['username'],
								'url' => '',
								'text' => '',
						),
						'share' => array(
								'type' => 'share',
								'buttontext' => __('Tweet', HAYYAB_BASENAME),
								'link' => 'share',
								'username' => '', 
								'url' => ' data-url="'.$param['url'].'"',
								'text' => ' data-text="'.$param['text'].'"',
						),
						'hashtag' => array(
								'type' => 'hashtag',
								'buttontext' => __('Tweet #', HAYYAB_BASENAME),
								'link' => 'intent/tweet?button_hashtag='.$param['username'],
								'url' => '',
								'text' => '',
						),
						'mention' => array(
								'type' => 'mention',
								'buttontext' => __('Tweet to @', HAYYAB_BASENAME),
								'link' => 'intent/tweet?screen_name='.$param['username'],
								'url' => '',
								'text' => '',
						),
				)
		);
		$html = '<div id="'.$param['id'].'" class="'.$param['class'].'" style="'.$param['style'].'"><a href="https://twitter.com/'.$param['link'].'" class="twitter-'.$param['type'].'-button"'.$param['large'].$param['count'].$param['url'].$param['text'].'>'.$param['buttontext'].$param['username'].'</a></div>';
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
