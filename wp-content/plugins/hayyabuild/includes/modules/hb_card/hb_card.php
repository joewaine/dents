<?php
/**
 * Text class.
 *
 *
 * @since      1.0.0
 * @package    hayyabuild
 * @subpackage hayyabuild/includes/modules/hb_card
 * @author     ZintaThemes <>
 */
class HayyaModule_hb_card
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
	public $icon 		= 'fa fa-id-card';

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

		$this->name 		= __('Card', HAYYAB_BASENAME);
		$this->description 	= __('Bootstrap well', HAYYAB_BASENAME);

		$this->params = array(
			'image' => array(
				'type' => 'image',
				'heading' => __('Select Image', HAYYAB_BASENAME)
			),
			'img_style' => array (
					'type' => 'dropdown',
					'heading' => __('Image Style', HAYYAB_BASENAME),
					'value' => array(
							'default' => __('Default', HAYYAB_BASENAME),
							'hb-circular' => __('Circular', HAYYAB_BASENAME),
							'hb-round_edges' => __('Rounded edges', HAYYAB_BASENAME),
					),
			),
			'title' => array(
					'type' => 'textfield',
					'heading' => __('Title', HAYYAB_BASENAME),
			),
			'hb_text' => array(
					'type' => 'textarea',
					'heading' => __('Card Text', HAYYAB_BASENAME),
					'value' => __('Content text.', HAYYAB_BASENAME)
			),
			'link' => array(
					'type' => 'link',
					'heading' => __('Link', HAYYAB_BASENAME),
					'description' => __('Card button link (url).', HAYYAB_BASENAME)
			),
			'link_title' => array(
					'type' => 'textfield',
					'heading' => __('Link Text', HAYYAB_BASENAME)
			),
			'width' => array(
					'type' => 'textfield',
					'heading' => __('Card Width', HAYYAB_BASENAME),
					'value' => __('100%', HAYYAB_BASENAME)
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
				'image' 		=> '<img id="card_'.$param['id'].'" class="'.$param['img_style'].'" src="'.$param['image'].'" alt="'.$param['title'].'"/>',
				'title' 		=> '<h4 class="hb-card_title">'.$param['title'].'</h4>',
				//'hb_text' 		=> '<p class="hb-card_text">'.$param['hb_text'].'</p>',
				'link_title' 	=> array(
					null 			=> __('Read More..', HAYYAB_BASENAME),
					'else' 			=> $param['link_title']
				),
				'link' 			=> '<hr/><a class="hb-card_link" href="'.$param['link'].'">'.$param['link_title'].'</a>',
				'width'			=> ' max-width: '.$param['width'].';'

		);

		$html = '<div id="'.$param['id'].'" class="'.$param['class'].'" style="'.$param['style'].$param['width'].'">'.
					$param['image'].
					'<div class="hb-card_content">'.
						$param['title'].
						$param['hb_text'].
						$param['link'].
					'</div>
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
