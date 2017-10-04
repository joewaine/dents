<?php
/**
 * Icon class.
 *
 *
 * @since      1.0.0
 * @package    hayyabuild
 * @subpackage hayyabuild/includes/modules/hb_googleMap
 * @author     ZintaThemes <>
 */
class HayyaModule_hb_googleMap
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
	public $icon = 'fa fa-map-o';

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
		$this->name = __ ( 'Google Map', HAYYAB_BASENAME );
		$this->description = __ ( 'Create Google Map', HAYYAB_BASENAME );

		if (! is_admin ()) add_shortcode ( 'hb_googleMap', array ( $this, 'public_render') );

		$this->params = array (
                'latitude' => array(
                        'type' => 'textfield',
                        'heading' => __('Latitude', HAYYAB_BASENAME),
                        'description' => __('Inter latitude for your place.', HAYYAB_BASENAME),
                        'value' => '00.0000',
                ),
                'longitude' => array(
                        'type' => 'textfield',
                        'heading' => __('Longitude', HAYYAB_BASENAME),
                        'description' => __('Enter longitude for your place.', HAYYAB_BASENAME),
                        'value' => '00.0000',
                ),
                'zoom' => array(
                        'type' => 'integer_slider',
                        'heading' => __('Map Zoom', HAYYAB_BASENAME),
                        'value' => '15',
                        'max' => '1',
                        'max' => '20',
                ),
                'placetext' => array(
                        'type' => 'textarea',
                        'heading' => __('Place Content Text', HAYYAB_BASENAME),
                        'description' => __('Enter Place Content Text.', HAYYAB_BASENAME),
                        'value' => '<b>'.get_bloginfo('name').'</b><br/>'.get_bloginfo('description') .'',
                ),
                'mapcontent' => array(
                        'type' => 'textarea',
                        'heading' => __('Content Text', HAYYAB_BASENAME),
                        'description' => __('Insert content text to the map.<br/>You can use HTML code', HAYYAB_BASENAME),
                        'value' => __('Insert content text to the map.<br/>You can use HTML code', HAYYAB_BASENAME)
                ),
                'position' => array (
                        'type' => 'dropdown',
                        'heading' => __('Content Position', HAYYAB_BASENAME),
                        'description' => __('Select the content position.', HAYYAB_BASENAME),
                		'value' => array(
                				'TOP_LEFT' => __('Top Left', HAYYAB_BASENAME),
                				'TOP_RIGHT' => __('Top Right', HAYYAB_BASENAME),
                		),
                ),
                'separator' => array( 'type' => 'separator', 'heading' => '' ),
				'width' => array(
					'type' => 'textfield',
					'heading' => __('Width', HAYYAB_BASENAME),
					'description' => __('Map width.', HAYYAB_BASENAME),
					'value' => '300px',
				),
                'height' => array(
                        'type' => 'textfield',
                        'heading' => __('Map height', HAYYAB_BASENAME),
                        'description' => __('Map height.', HAYYAB_BASENAME),
                        'value' => '300px',
                ),
                'type' => array (
                        'type' => 'dropdown',
                        'heading' => __('Map Type', HAYYAB_BASENAME),
                        'description' => __( 'Select map type.', HAYYAB_BASENAME),
                		'value' => array(
                				'HYBRID' => __('hybrid', HAYYAB_BASENAME),
                				'ROADMAP' => __('roadmap', HAYYAB_BASENAME),
                				'SATELLITE' => __('satellite', HAYYAB_BASENAME),
                				'TERRAIN' => __('terain', HAYYAB_BASENAME),
                		),
                ),
                'color' => array(
                        'type' => 'colorpicker',
                        'heading' => __('Map Overlay Color', HAYYAB_BASENAME),
                        'description' => __('Select map overlay Color.', HAYYAB_BASENAME),
                        'value' => '#0080b3',
                ),
		);
        $this->admin_css = array('hb_googleMap' => 'css/admin.css');
        $this->js_files = array ( 'hb_googleMap' => 'https://maps.googleapis.com/maps/api/js');
	}

	/**
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_render($param = null) {
		$args = array(
				'latitude' => 'latitude="'.$param['latitude'].'"',
				'longitude' => ' longitude="'.$param['longitude'].'"',
				'zoom' => ' zoom="'.$param['zoom'].'"',
				'position' => ' position="'.$param['position'].'"',
				'type' => ' type="'.$param['type'].'"',
				'color' => ' color="'.$param['color'].'"',
		);
		$html = '<div id="'.$param['id'].'" class="'.$param['class'].'">
					<div class="hb_googleMapdiv" id="map-'.$param['id'].'" style="width:'.$param['width'].';height:'.$param['height'].';"></div>
					<div class="hb_googleMapdiv">
						[hb_googleMap  mapID="'.$param['id'].'" '.$param['latitude'].$param['longitude'].$param['zoom'].$param['position'].$param['type'].$param['color'].' ]
							'.$param['placetext'].'
						[/hb_googleMap]
					</div>
					<div id="mapContent-'.$param['id'].'" style="'.$param['style'].'">'.$param['mapcontent'].'</div>
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
        $content = trim(preg_replace('/\s\s+/', ' ', $content));
        $mapID = $latitude = $longitude = $position = $zoom = $type = $height = $color = $styles = '';
        if ( $atts ) {
    		foreach ( $atts as $key => $value ) {
    		    switch ($key) {
					case 'mapid': $mapID = $value;
					break;
					case 'latitude': $latitude = $value;
                    break;
                    case 'longitude': $longitude = $value;
                    break;
                    case 'position': $position = $value;
                    break;
                    case 'placetext': $placetext = $value;
                    break;
                    case 'zoom': $zoom = $value;
                    break;
                    case 'type': $type = $value;
                    break;
                    case 'height': $height = $value;
                    break;
                    case 'color': $color = $value;
                    break;
				}
    		}
        }
        if ( $position === 'TOP_LEFT' ) $Cposition = 'TOP_RIGHT';
        else $Cposition = 'TOP_LEFT';
        $content = str_replace(array("\r\n", "\r", "\n"), "", $content);

		$output = <<<js
        <script type="text/javascript">
            jQuery(document).ready(function() {
                HBGoogleMap({
                    id:         '{$mapID}',
                    latitude:    {$latitude},
                    longitude:   {$longitude},
                    zoom:        {$zoom},
                    type:       '{$type}',
                    color:      '{$color}',
                    position:   '{$position}',
                    Cposition:  '{$Cposition}',
                    content:    '{$content}',
                });
            });
        </script>
js;
		return $output;
	}
}
?>
