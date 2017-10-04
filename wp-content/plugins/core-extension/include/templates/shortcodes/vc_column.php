<?php
$output = $font_color = $el_class = $width = $offset = $left_slope = $right_slope =
$slope_left_class = $slope_right_class = $col_height_type = $height = '';
extract(shortcode_atts(array(
	'font_color'        => '',
	'col_height_type'   => '',
	'height'            => '',
	'textalign'         => '',
	'el_class'          => '',
    'width'             => '1/1',
    'css'               => '',
	'offset'            => '',
	'slope_left'        => '',
	'slope_right'       => '',
	'slope_left_dir'    => 'slope-left-top',
	'slope_right_dir'   => 'slope-right-top',
	'slope_left_width'  => '100px',
	'slope_right_width' => '100px',
	'slope_left_color'  => '',
	'slope_right_color' => '',
	'css_animation'         => '',
	'css_animation_delay'   => ''
), $atts));

$textalign = ($textalign != '') ? 'style="text-align:'.$textalign.';"' : '';


if ($col_height_type == 'fixed_height') {
	if ( $height != '' ) {
		$height = ' style="height:'. intval($height) . 'px;"';
	}
}

$el_class = $this->getExtraClass($el_class);
$width = wpb_translateColumnWidthToSpan($width);
$width = vc_column_offset_class_merge($offset, $width);
$el_class .= ' wpb_column vc_column_container clearfix';
$el_class .= $this->getCSSAnimation($css_animation);
($css_animation != '' && $css_animation_delay != '') ? $el_class .= $this->getExtraClass($css_animation_delay) : '';
$style = $this->buildStyle( $font_color );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $width . $el_class, $this->settings['base'], $atts );
$output .= "\n\t".'<div class="'.$css_class.'"'.$style.'>';
$output .= "\n\t\t".'<div class="vc_column-inner ' . esc_attr( trim( vc_shortcode_custom_css_class( $css ) ) ) . '"'.$height.'>';
$output .= "\n\t\t\t".'<div class="wpb_wrapper" '.$textalign.'>';
$output .= "\n\t\t\t\t".wpb_js_remove_wpautop($content);
$output .= "\n\t\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
$output .= "\n\t\t".'</div>';



//Left slope styling
($slope_left != '') ? $slope_left_class = $this->getExtraClass($slope_left) : null;
($slope_left != '' && $slope_left_width != '') ? $slope_left_width = ' style="width:'.$slope_left_width . '"' : null;
($slope_left != '' && $slope_left_color != '') ? $slope_left_color = ' fill="'.$slope_left_color.'"' : null;


if ( !empty($slope_left) ) {
	$left_slope .= '<div class="column-slope' . $slope_left_class . '"' . $slope_left_width . '>' .
	              '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">';
		if( $slope_left_dir == 'slope-left-top' ) :
			$left_slope .= '<path d="M0 0 L100 0 L100 100 L99 100 Z"' . $slope_left_color . '></path>';
		elseif ( $slope_left_dir == 'slope-left-bottom' ) :
			$left_slope .= '<path d="M100 0 L100 100 L0 100 L99 0 Z"' . $slope_left_color . '></path>';
		endif;
	$left_slope .= '</svg></div>';
}

//Right slope styling
($slope_right != '') ? $slope_right_class = $this->getExtraClass($slope_right) : null;
($slope_right != '' && $slope_right_width != '') ? $slope_right_width = ' style="width:'.$slope_right_width . '"' : null;
($slope_right != '' && $slope_right_color != '') ? $slope_right_color = ' fill="'.$slope_right_color.'"' : null;


if ( !empty($slope_right) ) {
	$right_slope .= '<div class="column-slope' . $slope_right_class . '"' . $slope_right_width . '>' .
	                 '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">';
		if( $slope_right_dir == 'slope-right-top' ) :
			$right_slope .= '<path d="M0 0 L100 0 L1 100 L0 100 Z"' . $slope_right_color . '></path>';
		elseif ( $slope_right_dir == 'slope-right-bottom' ) :
			$right_slope .= '<path d="M0 0 L1 0 L100 100 L0 100 Z"' . $slope_right_color . '></path>';
		endif;
	$right_slope .= '</svg></div>';
}


$output .= $left_slope;
$output .= $right_slope;
$output .= "\n\t".'</div> '.$this->endBlockComment($el_class) . "\n";

echo $output;