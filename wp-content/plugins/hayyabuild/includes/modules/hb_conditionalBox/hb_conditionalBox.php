<?php
/**
 * Icon class.
 *
 *
 * @since      1.0.0
 * @package    hayyabuild
 * @subpackage hayyabuild/includes/modules/hb_conditionalBox
 * @author     ZintaThemes <>
 */
class HayyaModule_hb_conditionalBox
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
	public $icon 		= 'fa fa-object-group';

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
		
		if ( is_admin() ) {
	
			$this->name 		= __('Conditional Box', HAYYAB_BASENAME);
			$this->description 	= __('You can use this box to display content under a specific conditions.', HAYYAB_BASENAME);
			
			add_filter('before_hayyabuild_save', array( $this, 'before_hayyabuild_save'));
			
			$this->params = array(
	
					'is_user_logged_in' => array(
							'type' => 'dropdown',
							'heading' => __('Logged in user', HAYYAB_BASENAME),
							'description' => __('Show or hide this box when the current visitor is a logged in.', HAYYAB_BASENAME),
							'value'	  => array(
									'none' => __('Show in any case', HAYYAB_BASENAME),
									'show' => __('Show', HAYYAB_BASENAME),
									'hide' => __('Hide', HAYYAB_BASENAME),
							)
					),
					'is_front_page' => array(
							'type' => 'dropdown',
							'heading' => __('Front page', HAYYAB_BASENAME),
							'description' => __('Show or hide this box when the current page is main URL.', HAYYAB_BASENAME),
							'value'	  => array(
									'none' => __('Show in any case', HAYYAB_BASENAME),
									'show' => __('Show', HAYYAB_BASENAME),
									'hide' => __('Hide', HAYYAB_BASENAME),
							)
					),
					'is_home' => array(
							'type' => 'dropdown',
							'heading' => __('Posts index', HAYYAB_BASENAME),
							'description' => __('Show or hide this box when the current page is blog posts index.', HAYYAB_BASENAME),
							'value'	  => array(
									'none' => __('Show in any case', HAYYAB_BASENAME),
									'show' => __('Show', HAYYAB_BASENAME),
									'hide' => __('Hide', HAYYAB_BASENAME),
							)
					),
					'is_single' => array(
							'type' => 'dropdown',
							'heading' => __('Single Post page', HAYYAB_BASENAME),
							'description' => __('Show or hide this box when Post page is being displayed.', HAYYAB_BASENAME),
							'value'	  => array(
									'none' => __('Show in any case', HAYYAB_BASENAME),
									'show' => __('Show', HAYYAB_BASENAME),
									'hide' => __('Hide', HAYYAB_BASENAME),
							)
					),
					'is_author' => array(
							'type' => 'dropdown',
							'heading' => __('Author page', HAYYAB_BASENAME),
							'description' => __('Show or hide this box when any Author page is being displayed.', HAYYAB_BASENAME),
							'value'	  => array(
									'none' => __('Show in any case', HAYYAB_BASENAME),
									'show' => __('Show', HAYYAB_BASENAME),
									'hide' => __('Hide', HAYYAB_BASENAME),
							)
					),
					'show_pages' => array(
							'type' => 'textfield',
							'heading' => __('Show in pages', HAYYAB_BASENAME),
							'description' => __('Add pages ID’s and separate them with comma (,) .', HAYYAB_BASENAME),
					),
					'hide_pages' => array(
							'type' => 'textfield',
							'heading' => __('Hide from pages', HAYYAB_BASENAME),
							'description' => __('Add pages ID’s and separate them with comma (,) .', HAYYAB_BASENAME),
					),
			);
			
		} else {
			add_shortcode( 'hayya_conditional', array( $this, 'public_render' ) );
		}
		

	}

	/**
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function admin_render($param = null) {
		return '<div id="'.$param['id'].'" class="'.$param['class'].'" style="'.$param['style'].'"></div>';
	}

	/**
	 * Public Output funnction.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function public_render( $atts, $content = null ) {
		$return = $content;
		if ( !empty($content) ) {
			foreach ($atts as $key => $value) {
				if ($key !== 'show_pages' && $key !== 'hide_pages') {
					if ( function_exists($key) ) {
						$status = call_user_func($key);
						if ( $atts[$key] === 'hide' && $status ) $return = '';
						else if ( $atts[$key] === 'show' && !$status ) $return = '';
					}
				} else {
					$pages = array();
					$show_pages = explode(',', $value);
					foreach ( $show_pages as $page ) $pages[] = (int) trim($page);
					if ( $key === 'show_pages' ) if ( !is_page($pages) ) $return = '';
					if ( $key === 'hide_pages' ) if ( is_page($pages) ) $return = '';
				}
			}
		}
		return do_shortcode( $return );
	}
	
	/**
	 * Clean Public output
	 * 
	 * @param array $args
	 * @return unknown
	 */
	public function before_hayyabuild_save($args = array()) {
		if ( class_exists('Sunra\PhpSimple\HtmlDomParser') && !empty($args['content'])) {
			$content = $args['content'];
			$parser = new Sunra\PhpSimple\HtmlDomParser();
			$dom 	= $parser->str_get_html( $content );
			$attrs = array('is_user_logged_in', 'is_front_page', 'is_home', 'is_single', 'is_author', 'show_pages', 'hide_pages');
			$shortcode_attrs = '';
			$return = false;
			foreach ($dom->find('.hb_conditionalBox') as $key => $value) {
				if ( !empty($value) ) {
					foreach ($attrs as $attr ) {
						if ( isset($value->attr['data-hb-'.$attr]) && !empty($value->attr['data-hb-'.$attr]) && $value->attr['data-hb-'.$attr] !== 'none' ) {
							$shortcode_attrs .= $attr.'="'.$value->attr['data-hb-'.$attr].'" ';
						}
					}
					if (!empty($shortcode_attrs)) {
						$return = true;
						$value->outertext = '[hayya_conditional '.$shortcode_attrs.']'.$value->outertext.'[/hayya_conditional]';
					}
				}
			}
			$args['content'] = $dom->save();
		}
		return $args;
	} // End before_hayyabuild_save()

} // End HayyaModule_hb_conditionalBox Class

