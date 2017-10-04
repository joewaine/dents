<?php
$title = $el_class = $value = $label_value= $units = $pie_class = '';
extract(shortcode_atts(array(
'title'         => '',
'el_class'      => '',
'value'         => '50',
'label_value'   => '',
'units'         => '',
'size'          => '',
'bar_color'     => 'bar_themecolor',
'custom_color'  => '',
'track_color'   => '',
'bg_color'      => '',
'width'         => '2',
'text_color'    => '',
'duration'      => '2000',
'easing'        => 'linear',
'css_animation'         => '',
'css_animation_delay'   => ''
), $atts));

if ( function_exists( 'ot_get_option' ) ) {
	$accent_color = ot_get_option('accent_color');
}

wp_register_script( 'progressbar', COLLARS_PLUGIN_URL . '/assets/js/progressbar.min.js', false );
wp_enqueue_script( 'progressbar');
wp_enqueue_script( 'waypoints' );

$el_class = $this->getExtraClass( $el_class );

//$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_pie_chart wpb_content_element' . $el_class, $this->settings['base'], $atts );
//$output = "\n\t".'<div class= "'.$css_class.'" data-pie-value="'.$value.'" data-pie-label-value="'.$label_value.'" data-pie-units="'.$units.'" data-pie-color="'.htmlspecialchars($color).'">';
//    $output .= "\n\t\t".'<div class="wpb_wrapper">';
//        $output .= "\n\t\t\t".'<div class="vc_pie_wrapper">';
//            $output .= "\n\t\t\t".'<span class="vc_pie_chart_back"></span>';
//            $output .= "\n\t\t\t".'<span class="vc_pie_chart_value"></span>';
//            $output .= "\n\t\t\t".'<canvas width="101" height="101"></canvas>';
//            $output .= "\n\t\t\t".'</div>';
//        if ($title!='') {
//        $output .= '<h4 class="wpb_heading wpb_pie_chart_heading">'.$title.'</h4>';
//        }
//        //wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_pie_chart_heading'));
//    $output .= "\n\t\t".'</div>'.$this->endBlockComment('.wpb_wrapper');
//    $output .= "\n\t".'</div>'.$this->endBlockComment('.wpb_pie_chart')."\n";

$color = ($custom_color != '') ? $custom_color : $bar_color;
($color == 'bar_themecolor') ? $color = $accent_color : '';
$size = ($size != '') ? 'style="max-width:' .$size. ';"' : '';

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_content_element vc_pie_container' . $el_class, $this->settings['base'], $atts );
$pie_class = $this->getCSSAnimation($css_animation);
($css_animation != '' && $css_animation_delay != '') ? $pie_class .= $this->getExtraClass($css_animation_delay) : '';

$output = "\n\t".'<div class= "'.$css_class.'">';
	$output .= "\n\t\t".'<div class="wpb_wrapper">';
		$output .= "\n\t\t\t".'<div class="vc_pie_wrapper'.$pie_class.'" ' .$size. ' data-pie-value="'.$value.'" data-pie-label-value="'.$label_value.'" data-pie-units="'.$units.'" data-pie-color="'.$color.'" data-pie-track-color="'.$track_color.'" data-pie-width="'.$width.'" data-pie-text-color="'.$text_color.'" data-pie-bg-color="'.$bg_color.'" data-pie-duration="'.$duration.'" data-pie-easing="'.$easing.'"></div>';
	$output .= "\n\t\t".'</div>'.$this->endBlockComment('.wpb_wrapper');
$output .= "\n\t".'</div>'.$this->endBlockComment('.wpb_pie_chart')."\n";






echo $output;