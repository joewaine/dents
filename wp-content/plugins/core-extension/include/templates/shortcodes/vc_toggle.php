<?php
$output = $title = $el_class = $open = $css_animation = $css_animation_delay = '';
extract(shortcode_atts(array(
    'title' => __("Toggle title", "js_composer"),
    'el_class' => '',
    'open' => 'false',
    'css_animation'         => '',
    'css_animation_delay'   => ''
), $atts));

$el_class = $this->getExtraClass($el_class);
$open = ( $open == 'true' ) ? ' vc_toggle_active' : '';
$el_class .= ( $open == ' vc_toggle_active' ) ? ' vc_toggle_active' : '';

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_toggle_' . $open, $this->settings['base'], $atts );
$css_class .= $this->getCSSAnimation($css_animation);
($css_animation != '' && $css_animation_delay != '') ? $css_class .= $this->getExtraClass($css_animation_delay) : '';

$output .= '<div class="vc_toggle '.$css_class.'">';
$output .= '<div class="vc_toggle_title">'. apply_filters( 'wpb_toggle_heading', '<h4>' . esc_html( $title ) . '</h4>', array(
	'title' => $title,
	'open' => $open
) );
$output .= '</div>';
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_toggle_content' . $el_class, $this->settings['base'], $atts );
$output .= '<div class="vc_toggle_content">'.wpb_js_remove_wpautop($content, true).'</div>'.$this->endBlockComment('toggle')."\n";
$output .= '</div>';

echo $output;