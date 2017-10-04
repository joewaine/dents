<?php

$output = $text = $text_color = $size = $style = $dc_color = $bg_color = $border_color = $radius =
$css_animation = $css_animation_delay = $el_class = $dropcap = $dc_styles = $size = $height = $line_height = $width =
$font_size = $margin_right = $margin_left = $align_c
= '';

extract(shortcode_atts(array(
	'text'               => '',
	'text_color'            => '',
	'size'                  => '2',
	'style'                 => '',
	'dc_color'              => '',
	'bg_color'              => '',
	'border_color'          => '',
	'radius'                => '',
	'el_class'              => '',
	'css_animation'         => '',
	'css_animation_delay'   => ''
), $atts));

// Add custom classes
$el_class = $this->getExtraClass( $el_class );
$anim_class = $this->getCSSAnimation($css_animation);
($css_animation != '' && $css_animation_delay != '') ? $anim_class .= $this->getExtraClass($css_animation_delay) : '';

$text_color = ( $text_color != '' ) ? ' style="color:'.$text_color.'"' : '';

// Create a drop cap
if ( $text != '' ) {
	$dropcap = $text[0];
	$text = substr($text, 1, strlen($text)-1);
}

// Create drop cap styles
$dc_color = ( $dc_color != '' ) ? 'color:'.$dc_color.';' : '';
$size = intval($size);
$l = 21;
$line_height = 'line-height:'.($size*($l-4)).'px;';
$font_size = 'font-size:'.($size*($l+$size-2)).'px;';
if ( is_rtl() ) {
	$margin_left = 'margin-left:'.($size+$l-12).'px;';
} else {
	$margin_right = 'margin-right:'.($size+$l-12).'px;';
}


if ( $style == 'twc_dc_container' ) {
	$bg_color = ( $bg_color != '' ) ? 'background-color:'.$bg_color.';' : '';
	$line_height = 'line-height:'.($size*($l-3)-4).'px;';
	$width = 'width:'.($size*($l-3)).'px;';
	$font_size = 'font-size:'.($size*($l-10)).'px;';
	if ( is_rtl() ) {
		$margin_left = 'margin-left:'.($l-15+($size*3)).'px;';
	} else {
		$margin_right = 'margin-right:'.($l-15+($size*3)).'px;';
	}
	$align_c = $this->getExtraClass('dc-container');
	$border_color = ( $border_color != '' ) ? 'border-color:'.$border_color.';' : '';
	$radius = ( $radius != '' ) ? 'border-radius:'.$radius.';' : 'border-radius: 0px;';
}
$dc_array = array($dc_color, $bg_color, $border_color, $radius, $height, $line_height, $width, $font_size, $margin_right, $margin_left);
$dc_styles = ' style="'.implode(' ', array_filter($dc_array)).'"';

// Output
$output .=  '<div class="twc_dropcaps">';
$output .=      '<div class="twc_dc_inner"'.$text_color.'>';
$output .=          '<span class="dropcap'.$align_c.'"'.$dc_styles.'>'.$dropcap.'</span>';
$output .=           $text;

$output .=  '	</div>
			</div>';


echo $output;