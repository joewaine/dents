<?php
/**
 * Icon class.
 *
 *
 * @since      1.3.0
 * @package    hayyabuild
 * @subpackage hayyabuild/includes/modules/hb_ContactForm7
 * @author     ZintaThemes <>
 */
class HayyaModule_hb_ContactForm7
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
	public $icon 		= 'fa fa-envelope-o';
	
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
	 * @var      string    $admin_css	    Admin style file.
	 */
	public $admin_css 	= array();
	
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
	public $activated = false;
	
	/**
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $categories    The current version of this plugin.
	 */
	public $categories = 'Plugins';
	
    /**
     *
     * @since    1.0.0
     * @access   public
     * @var      string    $categories    The current version of this plugin.
     */
    private $formsList = array();
    
	/**
	 * Construct function.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function __construct() {
		$this->name 		= __('Contact Form 7', HAYYAB_BASENAME);
		$this->description 	= __('customize the form and the mail contents flexibly with simple markup', HAYYAB_BASENAME);
        $contactform 		= '';
		
		if (  is_admin() && function_exists('is_plugin_active') && is_plugin_active('contact-form-7/wp-contact-form-7.php') ) {
		    $this->activated = true;
            $args = array('post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1);
            if( $cf7Forms = get_posts( $args ) ){
                foreach($cf7Forms as $cf7Form){
                    $contactform[$cf7Form->ID] = $cf7Form->post_title;
                }
                $this->formsList = $contactform;
            }
        }
        
   		$this->params = array(
   				'contactform' => array(
   						'type' => 'dropdown',
   						'heading' => __('Select Form', HAYYAB_BASENAME),
   						'description' => __('You have to create a forms.', HAYYAB_BASENAME),
   						'value' => $contactform
   				),
   				'hbtitle' => array(
   						'type' => 'textfield',
   						'heading' => __('Form Title', HAYYAB_BASENAME),
   						'value' => '',
   				)
   		);
	}
	
	/**
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function admin_render($param = null) {
		return '<div id="'.$param['id'].'" class="'.$param['class'].'" style="'.$param['style'].'">
					<div class="hayya_hide_from_backend">
						[contact-form-7 id="'.$param['contactform'].'" title="'.$param['hbtitle'].'"]
					</div>
					<div class="hayya_show_at_backend">
						'.__('Module name', HAYYAB_BASENAME).': '.$this->name.'<br/>
						'.__('Form ID', HAYYAB_BASENAME).': '.$param['contactform'].'<br/>
						'.__('Form title', HAYYAB_BASENAME).': '.$param['hbtitle'].'<br/>
					</div>
				</div>';
	}
	
	/**
	 * Public Output funnction.
	 * 
	 * @since    1.0.0
	 * @access   public
	 */
	public function public_render( $atts, $content = null ) {
		return false;
	}
	
}
