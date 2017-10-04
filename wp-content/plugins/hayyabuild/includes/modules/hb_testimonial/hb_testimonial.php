<?php
/**
 * Text class.
 *
 *
 * @since      1.0.0
 * @package    hayyabuild
 * @subpackage hayyabuild/includes/modules/hb_testimonial
 * @author     ZintaThemes <>
 */
class HayyaModule_hb_testimonial
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
	public $icon 		= 'fa fa-quote-left';

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
	public $categories = 'Contents';

	/**
	 * Construct function.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function __construct() {

		$this->name      	= __('Testimonial Module', HAYYAB_BASENAME);
        $this->description  = __('Add Testimonials to your WordPress.', HAYYAB_BASENAME);

		$this->params = array(
				'hb_text' => array(
						'type' => 'textarea',
						'heading' => __('Quote Testimonial', HAYYAB_BASENAME),
						'value' => __('Insert quote testimonial here.', HAYYAB_BASENAME)
				),
				'hb_cite' => array(
                        'type' => 'textfield',
                        'heading' => __('Source of Testimonial', HAYYAB_BASENAME),
                        'description' => __('Identify the source of a testimonial.', HAYYAB_BASENAME),
                ),
				'hb_theme' => array (
                        'type' => 'dropdown',
                        'heading' => __ ( 'Testimonial Theme', HAYYAB_BASENAME ),
						'value' => array(
								'none' => __('None', HAYYAB_BASENAME),
								'default' => __('Default', HAYYAB_BASENAME),
						)
                ),
				'full_stars' => array (
                        'type' => 'checkbox',
                        'heading' => __ ( 'Show Full Stars', HAYYAB_BASENAME ),
						'value' => array(
								'show' => __('Show', HAYYAB_BASENAME),
						)
                )
		);
	}

	/**
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function admin_render($param = null) {
		$args = array(
				'hb_cite' => '<cite>'.$param['hb_cite'].'</cite>',
				'hb_theme' => array(
					'none' => '',
					'default' => ' hb_quote_default'
				),
				'full_stars' => '<div class="hb_rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>'
		);
		$html = '<blockquote id="'.$param['id'].'" class="'.$param['class'].$param['hb_theme'].'" style="'.$param['style'].'">'.
					$param['hb_text'].'<br/>'.
					$param['hb_cite'].$param['full_stars'].
				'</blockquote>';
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
