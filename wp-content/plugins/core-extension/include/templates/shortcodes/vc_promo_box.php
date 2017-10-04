<?php

$output = $heading = $heading_color = $text = $text_color = $style = $bg_color = $border_color = $radius =
$icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypoicons = $icon_linecons = $icon_simplelineicons =
$b_text = $b_text_color = $b_bg_color = $b_border_color = $b_radius = $bh_text_color = $bh_bg_color = $bh_border_color = $bh_radius =
$b2_text = $b2_text_color = $b2_bg_color = $b2_border_color = $b2_radius = $b2h_text_color = $b2h_bg_color = $b2h_border_color = $b2h_radius =
$a_href = $a_title = $a_target = $a_href2 = $a_title2 = $a_target2 = $second_button = $link = $link2 = $button2_styles =
$type = $icon_color = $icon_bg_color = $icon_border_color = $icon_radius = $icon = $iconClass =
$shadow = $button = $button2 = $el_class = $anim_class = $css_animation_delay
= '';

extract(shortcode_atts(array(
	'heading'                   => '',
	'heading_color'             => '',
	'text'                      => '',
	'text_color'                => '',
	'style'                     => 'twc_pb_simple',
	'bg_color'                  => '',
	'border_color'              => '',
	'radius'                    => '0px',
	'shadow'                    => '',
	'type'                      => 'fontawesome',
	'icon_fontawesome'          => 'fa fa-adjust',
	'icon_openiconic'           => '',
	'icon_typicons'             => '',
	'icon_entypoicons'          => '',
	'icon_linecons'             => '',
	'icon_entypo'               => '',
	'icon_simplelineicons'      => '',
	'icon_color'                => '',
	'icon_bg_color'             => '',
	'icon_border_color'         => '',
	'icon_radius'               => '0px',
	'b_text'                    => 'Buy now',
	'link'                      => '',
	'b_text_color'              => '',
	'b_bg_color'                => '',
	'b_border_color'            => '',
	'b_radius'                  => '0px',
	'bh_text_color'             => '',
	'bh_bg_color'               => '',
	'bh_border_color'           => '',
	'bh_radius'                 => '',
	'second_button'             => '',
	'b2_text'                   => 'More info',
	'link2'                     => '',
	'b2_text_color'             => '',
	'b2_bg_color'               => '',
	'b2_border_color'           => '',
	'b2_radius'                 => '0px',
	'b2h_text_color'            => '',
	'b2h_bg_color'              => '',
	'b2h_border_color'          => '',
	'b2h_radius'                => '',
	'el_class'                  => '',
	'css_animation'             => '',
	'css_animation_delay'       => ''
), $atts));

// Enqueue needed icon font.
vc_icon_element_fonts_enqueue( $type );

// Add custom classes
$css_class              = $this->getExtraClass( $style );
$el_class               = $this->getExtraClass( $el_class );
$anim_class             = $this->getCSSAnimation($css_animation);
($css_animation != '' && $css_animation_delay != '') ? $anim_class .= $this->getExtraClass($css_animation_delay) : '';


// Set up text block
$text_color             = ( $text_color != '' ) ? 'color:'.$text_color : '';
$text                   = '<div class="twc_pb_text" style="'.$text_color.'">'.$text.'</div>';


// Set up heading block
$heading_color          = ( $heading_color != '' ) ? 'color:'.$heading_color : '';
$heading                = '<div class="twc_pb_heading" style="'.$heading_color.'">'.$heading.'</div>';


// Set up icon styles
if ( $style == 'twc_pb_boxed' ) {
	$icon_color         = ($icon_color != '') ? 'color:' . $icon_color : '';
	$icon_bg_color      = ($icon_bg_color != '') ? 'background-color:' . $icon_bg_color : '';
	$icon_border_color  = ($icon_border_color != '') ? 'border-color:' . $icon_border_color : '';
	$icon_radius        = ($icon_radius != '') ? 'border-radius:' . $icon_radius : 'border-radius:0px';
	$icon_array         = array($icon_color, $icon_bg_color, $icon_border_color, $icon_radius);
	$icon_styles        = ' style="' . implode('; ', array_filter($icon_array)) . '"';
	// Define icon
	$iconClass          = isset(${"icon_" . $type}) ? esc_attr(${"icon_" . $type}) : 'fa fa-adjust';
	$icon               = '<i class="' . $iconClass . '"'.$icon_styles.'></i>';
}

// Set up main styles
if ( $style == 'twc_pb_boxed' ) {
	$border_color       = ( $border_color != '' ) ? 'border-color:'.$border_color : '';
	$radius             = ( $radius != '' ) ? 'border-radius:'.$radius : 'border-radius:0px';
	$css_class         .= $this->getExtraClass( $shadow );
}
$bg_color               = ( $bg_color != '' ) ? 'background-color:'.$bg_color : '';
$style_array            = array($heading_color, $text_color, $bg_color, $border_color, $radius);
$main_styles            = ' style="'.implode('; ', array_filter($style_array)).'"';


// Set up BUTTON_1 hover state styles
$bh_text_color          = ( $bh_text_color != '' ) ? ' data-hc="'.$bh_text_color.'"' : ' data-hc="'.$b_text_color.'"';
$bh_bg_color            = ( $bh_bg_color != '' ) ? ' data-hbgc="'.$bh_bg_color.'"' : ' data-hbgc="'.$b_bg_color.'"';
$bh_border_color        = ( $bh_border_color != '' ) ? ' data-hbc="'.$bh_border_color.'"' : ' data-hbc="'.$b_border_color.'"';
$bh_radius              = ( $bh_radius != '' ) ? ' data-hbr="'.$bh_radius.'"' : ' data-hbr="'.$b_radius.'"';
// Set up BUTTON_1 styles
$b_text_color           = ( $b_text_color != '' ) ? 'color:'.$b_text_color : '';
$b_bg_color             = ( $b_bg_color != '' ) ? 'background-color:'.$b_bg_color : '';
$b_border_color         = ( $b_border_color != '' ) ? 'border-color:'.$b_border_color : '';
$b_radius               = ( $b_radius != '' ) ? 'border-radius:'.$b_radius : 'border-radius:0px';
$button_array           = array($b_text_color, $b_bg_color, $b_border_color, $b_radius);
$button_styles          = ' style="'.implode('; ', array_filter($button_array)).'"';
// Set up BUTTON_1 link
$link                   = ($link=='||') ? '' : $link;
$link                   = vc_build_link($link);
$a_href                 = $link['url'];
$a_title                = $link['title'];
$a_target               = ($link['target'] != '') ? $link['target'] : '_self';
$rel                    = $link['rel'] !== '' ? ' rel="'.$link['rel'].'"' : '';
// Define BUTTON_1
$button = '<a href="'.$a_href.'" title="'.$a_title.'" target="'.$a_target.'"'.$rel.' class="twc_custom_button twc_pb_button"'.$button_styles.$bh_text_color.$bh_bg_color.$bh_border_color.$bh_radius.'>'.$b_text.'</a>';


if ( $second_button == true ) {
	// Set up BUTTON_2 hover state styles
	$b2h_text_color     = ( $b2h_text_color != '' ) ? ' data-hc="'.$b2h_text_color.'"' : ' data-hc="'.$b2_text_color.'"';
	$b2h_bg_color       = ( $b2h_bg_color != '' ) ? ' data-hbgc="'.$b2h_bg_color.'"' : ' data-hbgc="'.$b2_bg_color.'"';
	$b2h_border_color   = ( $b2h_border_color != '' ) ? ' data-hbc="'.$b2h_border_color.'"' : ' data-hbc="'.$b2_border_color.'"';
	$b2h_radius         = ( $b2h_radius != '' ) ? ' data-hbr="'.$b2h_radius.'"' : ' data-hbr="'.$b2_radius.'"';
	// Set up BUTTON_2 styles
	$b2_text_color      = ( $b2_text_color != '' ) ? 'color:'.$b2_text_color : '';
	$b2_bg_color        = ( $b2_bg_color != '' ) ? 'background-color:'.$b2_bg_color : '';
	$b2_border_color    = ( $b2_border_color != '' ) ? 'border-color:'.$b2_border_color : '';
	$b2_radius          = ( $b2_radius != '' ) ? 'border-radius:'.$b2_radius : 'border-radius:0px';
	$button2_array      = array($b2_text_color, $b2_bg_color, $b2_border_color, $b2_radius);
	$button2_styles     = ' style="'.implode('; ', array_filter($button2_array)).'"';
	// Set up BUTTON_2 link
	$link2              = ($link2=='||') ? '' : $link2;
	$link2              = vc_build_link($link2);
	$a_href2            = $link2['url'];
	$a_title2           = $link2['title'];
	$a_target2          = ($link2['target'] != '') ? $link2['target'] : '_self';
	$rel2               = $link['rel'] !== '' ? ' rel="'.$link['rel'].'"' : '';
	// Define BUTTON_2
	$button2            = '<a href="'.$a_href2.'" title="'.$a_title2.'" target="'.$a_target2.'"'.$rel2.' class="twc_custom_button twc_pb_button"'.$button2_styles.$b2h_text_color.$b2h_bg_color.$b2h_border_color.$b2h_radius.'>'.$b2_text.'</a>';
}


// Output
$output .=  '<div class="twc_promo_box'.$css_class.$anim_class.$el_class.'">';
$output .=      '<div class="twc_pb_inner"'.$main_styles.'>';
$output .=          '<div class="twc_pb_container clearfix">';
$output .=              '<div class="twc_pb_first">';
$output .=                  $icon;
$output .=              '</div>';

$output .=              '<div class="twc_pb_second">';
$output .=                  $heading;
$output .=                  $text;
$output .=              '</div>';

$output .=              '<div class="twc_pb_third clearfix">';
$output .=                  $button;
$output .=                  $button2;
$output .=              '</div>';

$output .=  '		</div>
				</div>
			</div>';


echo $output;