<?php
/**
 * Icon class.
 *
 *
 * @since      1.0.0
 * @package    hayyabuild
 * @subpackage hayyabuild/includes/modules/hb_menu
 * @author     ZintaThemes <>
 */
class HayyaModule_hb_menu
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
	public $icon = 'fa fa-list';

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
		$this->name 		= __( 'Menu', HAYYAB_BASENAME );
		$this->description 	= __( 'Create Wordpress menu', HAYYAB_BASENAME );

		if (! is_admin ()) {
			add_shortcode ( 'hb_menu', array ( $this, 'public_render') );
		} else {
			$menu_list = get_terms ( 'nav_menu', array ( 'hide_empty' => true, 'fields' => 'names' ) );
			$menu = array();
			if ( is_array($menu_list) && !empty($menu_list) ) {
				foreach ( $menu_list as $value ) {
					$menu[$value] = $value;
				}
			}

			$this->params = array (
					'menu' => array (
							'type' => 'dropdown',
							'heading' => __('Select Menu', HAYYAB_BASENAME),
							'description' => __('You have to create a menu.', HAYYAB_BASENAME),
							'value' => $menu
					),
					'menutitle' => array(
							'type' => 'html',
							'height' => '2',
							'heading' => __('Menu Title', HAYYAB_BASENAME),
							'description' => __('You can use HTML code.', HAYYAB_BASENAME),
					),
					'hb_align' => array (
	                        'type' => 'dropdown',
	                        'heading' => __('Menu align', HAYYAB_BASENAME),
							'value' => array(
									'left' => __('Left', HAYYAB_BASENAME),
									'center' => __('Center', HAYYAB_BASENAME),
									'right' => __('Right', HAYYAB_BASENAME),
							),
	                )
			);
		}
	}

	/**
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_render($param = null) {
		$args = array(
				'menutitle' => array(
						'none' => '',
						'else' => '<li class="hb_menutitle"> '.$param['menutitle'].' </li>',
				)
		);

		$html = '<div id="'.$param['id'].'" class="'.$param['class'].'">
					<div class="hayya_hide_from_backend">
						<a class="hb_toggleMenu" href="#"><i class="fa fa-navicon"></i></a>
						<ul class="hb_menuul hb_'.$param['hb_align'].'" style="'.$param['style'].'">
						'.$param['menutitle'].'[hb_menu  menu="'.$param['menu'].'"]
						</ul>
					</div>
					<div class="hayya_show_at_backend">
						'.__('Module name', HAYYAB_BASENAME).': '.$this->name.'<br/>
						'.__('Menu', HAYYAB_BASENAME).': '.$param['menu'].'<br/>
						'.__('Menu Title', HAYYAB_BASENAME).': '.$param['menutitle'].'<br/>
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
	public function public_render($atts, $content = null) {
		$output = '';
        if ( $atts ) {
    		foreach ( $atts as $key => $value ) {
    			if ($key == 'menu') {
    				$menu = wp_nav_menu ( array (
    						'sort_column' => 'menu_order',
    						'theme_location' => 'main_nav',
    						'container' => '',
    						'menu' => $value,
    						'menu_class' => '',
    						'items_wrap' => '%3$s',
    						'echo' => false
    				) );
    				if ($menu) {
    					$output = $menu;
    				}
    			}
    		}
        }

		return $output;
	}
}
?>
