<?php
$output = $title = $tab_id = $icon_name = $iconClass = $type = $icon_fontawesome = $icon_openiconic = $icon_typicons =
$icon_entypoicons = $icon_linecons = $icon_simplelineicons =  '';
//extract(shortcode_atts($this->predefined_atts, $atts));

extract(shortcode_atts( array(
	'title'                 => '',
	'type'                  => '',
	'icon_fontawesome'      => 'fa fa-adjust',
	'icon_openiconic'       => '',
	'icon_typicons'         => '',
	'icon_entypoicons'      => '',
	'icon_linecons'         => '',
	'icon_entypo'           => '',
	'icon_simplelineicons'  => '',
	'tab_id'                => 0
	), $atts));


wp_enqueue_script('jquery_ui_tabs_rotate');
vc_icon_element_fonts_enqueue( $type );

$i_icon = '';
$text_only = '';
$iconClass = '';

if ( $type !== '' ) {
	$iconClass = ( ${'icon_' . $type} ) ? esc_attr( ${'icon_' . $type} ) : 'fa fa-adjust';
	$i_icon =' <i class="'. ${'icon_' . $type} .'"></i>';
} else {
	$text_only = ' text-only"';
}


$tab_title = ( $title !== '' ) ? $title : '';
$icon_only = ( $title !== '' ) ? '' : ' icon-only"';

$tab_nav .= '<ul class="wpb_tabs_nav vc_clearfix twc-tabs-nav-mobile">';
$tab_nav .= '<li><a href="#tab-' . ( $tab_id !== '' ? $tab_id : sanitize_title( $tab_title ) ) . '" class="ui-tabs-anchor twc-tab-nav-mobile' .$icon_only.$text_only. '">' . $i_icon . $tab_title . '</a></li>';
$tab_nav .= '</ul>';

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_tab ui-tabs-panel wpb_ui-tabs-hide vc_clearfix', $this->settings['base'], $atts );
$output .= $tab_nav;
$output .= "\n\t\t\t" . '<div id="tab-'. (empty($tab_id) ? sanitize_title( $title ) : $tab_id) .'" class="'.$css_class.'">';
$output .= ($content=='' || $content==' ') ? __("Empty tab. Edit page to add content here.", "js_composer") : "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
$output .= "\n\t\t\t" . '</div> ' . $this->endBlockComment('.wpb_tab');

echo $output;