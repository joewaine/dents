<?php
	$output = $heading = $description = $type = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypoicons =
	$icon_linecons = $iconc_entypo = $icon_simplelineicons = $ib_style = $bg_color = $border_color = $icon_color =
	$heading_color = $content_color = $accent_color = $link = $el_class = $css_animation = $css_animation_delay =
	$anim_class = $add_link = $button = $link_box_open = $link_box_close = $link_button_open = $link_button_close =
	$borders = $border_accent = $button_color = $btn = $heading_b = $bg_color_back = $radius = $shadow = $bg_color_fb =
	$bg_color_fb_b = $icon_cont_color = $border_color_box = $radius_box =$style_class = $border_color_fb = $border_color_box
	= '';

	$accent_color = '#14b8c0';

if ( function_exists( 'ot_get_option' ) ) {
	$accent_color = ot_get_option('accent_color');
}

extract(shortcode_atts(array(
	'heading'               => '',
	'description'           => '',
	'type'                  => 'fontawesome',
	'icon_fontawesome'      => 'fa fa-adjust',
	'ion_openiconic'        => '',
	'icon_typicons'         => '',
	'icon_entypoicons'      => '',
	'icon_linecons'         => '',
	'iconc_entypo'          => '',
	'icon_simplelineicons'  => '',
	'ib_style'              => '',
	'bg_color'              => '',
	'bg_color_back'         => '',
	'border_color'          => '',
	'icon_color'            => '',
	'icon_cont_color'       => '',
	'heading_color'         => '',
	'content_color'         => '',
	'button_color'          => '',
	'accent_color'          => $accent_color,
	'radius'                => '',
	'shadow'                => '',
	'add_link'              => '',
	'link'                  => '',
	'button'                => '',
	'el_class'              => '',
	'css_animation'         => '',
	'css_animation_delay'   => ''
), $atts));

// Clean up content
$description            = wpb_js_remove_wpautop($description, true);


// Enqueue necessary icon font
vc_icon_element_fonts_enqueue( $type );

// Set appropriate icon class
$icon_class             = isset( ${"icon_" . $type} ) ? esc_attr( ${"icon_" . $type} ) : 'fa fa-adjust';


// Set bg color of flipbox
if ( $ib_style == 'twc_ib_flipbox' && $bg_color != '' ) {
	$bg_color_fb        = ' background-color:'.$bg_color.';';
	if ( $bg_color_back != '') {
		$bg_color_fb_b  = 'background-color:'.$bg_color_back.';';
	} else {
		$bg_color_fb_b  = 'background-color:'.$bg_color.';';
	}
}

// If standard box
if ( $ib_style == '' ) {
	$bg_color           = ($bg_color != '') ? ' background-color:'.$bg_color.';' : '' ;
	$border_color_box   = ( $border_color != '' ) ? ' border: 1px solid '.$border_color.';' : '' ;
	$radius_box         = ($radius != '') ? ' border-radius:'.$radius.';' : '';
}


// Set colors of the content elements
$icon_color             = ($icon_color != '') ?         'color:'.$icon_color.';' : '' ;
$heading_color          = ($heading_color != '') ?   'color:'.$heading_color.';' : '' ;
$content_color          = ($content_color != '') ?   'color:'.$content_color.';' : '' ;
$accent_b_color         = ($accent_color != '') ?   ' border-color:'.$accent_color : '' ;
$accent_color           = ($accent_color != '') ?     ' color:'.$accent_color.';' : '' ;
$button_color           = ($button_color != '') ?     ' style="color:'.$button_color.'; border-color:'.$button_color.'"' : '';
$radius                 = ($radius != '') ?                 ' border-radius:'.$radius.';' : '';


// If minimal box
if ( $ib_style == 'twc_ib_minimal' ) {
	$border_color       = ( $border_color != '' ) ? ' style="border-color:'.$border_color.'"' : '' ;
	$borders            =  '<div class="twc_ib_bl"'.$border_color.'></div>
							<div class="twc_ib_br"'.$border_color.'></div>';
	$border_accent      = ( $accent_color != '' ) ? ' border-color:'.$accent_color.';' : '';
}


// If flipbox
if ( $ib_style == 'twc_ib_flipbox' ) {
	$heading_b         .= '<div class="twc_ib_heading" style="'.$heading_color.'"">'.$heading.'</div>';
	$border_color_fb    = ( $border_color != '' ) ? ' border: 1px solid '.$border_color.';' : '' ;
}


// If flipbox or standard
if ( in_array($ib_style, array('', 'twc_ib_flipbox')) ) {
	$icon_cont_color    = ($icon_cont_color != '') ? ' background-color:'.$icon_cont_color.';' : '' ;
}


// Set up info box link
$link                   = ($link=='||') ? '' : $link;
$link                   = vc_build_link($link);
$a_href                 = $link['url'];
$a_title                = $link['title'];
$a_target               = ($link['target'] != '') ? $link['target'] : '_self';
$rel                    = $link['rel'] !== '' ? ' rel="'.$link['rel'].'"' : '';

// If link is added to info box
if ( strlen( $link['url'] ) > 0 ) {
	if ( $add_link == 'link_box' ) {
		$link_box_open  = '<a href="'.$a_href.'" title="'.$a_title.'" target="'.$a_target.'"'.$rel.'>';
		$link_box_close = '</a>';
		$btn            = '';
	} elseif ( $add_link == 'link_button' ) {
		if ( $button != '' ) {
			$btn =   '<div class="twc_ib_button_container">
							<a href="'.$a_href.'" title="'.$a_title.'" target="'.$a_target.'"'.$rel.'>';
								if ( $ib_style == 'twc_ib_minimal' ) {
									$btn .= '<div class="twc_ib_button" style="'.$accent_color.$accent_b_color.'">'.$button.'</div>';
								} elseif ( in_array($ib_style, array('', 'twc_ib_flipbox')) ) {
									$btn .= '<div class="twc_ib_button"'.$button_color.'>'.$button.'</div>';
								}
			$btn .=  	'</a>
						</div>';
		}
	}
}


// Set info box styling
$style_class            = $this->getExtraClass($ib_style);


// Add custom classes to the element
$shadow_class           = $this->getExtraClass($shadow);
$el_class               = $this->getExtraClass($el_class);


// Add appearance animation
$anim_class            .= $this->getCSSAnimation($css_animation);
($css_animation != '' && $css_animation_delay != '') ? $anim_class .= $this->getExtraClass($css_animation_delay) : '';


// Output
$output .=  '<div class="twc_info_box'.$anim_class.$el_class.'">';
$output .=      $link_box_open;
$output .=		    '<div class="twc_ib_container'.$style_class.$shadow_class.'" style="'.$bg_color.$accent_color.$border_color_box.$radius_box.'">';

$output .=              $borders;

$output .=              '<div class="twc_ib_inner">';

$output .=                  '<div class="twc_ib_front" style="'.$bg_color_fb.$radius.$border_color_fb.'">';

$output .=                      '<div class="twc_ib_icon_container" style="'.$accent_color.'">
									<i class="'.$icon_class.'" style="'.$icon_color.$icon_cont_color.'"></i>
								</div>';

$output .=                      '<div class="twc_ib_heading" style="'.$heading_color.'">'.$heading.'</div>';
$output .=                  '</div>';

$output .=                  '<div class="twc_ib_back" style="'.$bg_color_fb_b.$radius.$border_color_fb.'">';
$output .=                      $heading_b;
$output .=                      '<div class="twc_ib_content" style="'.$content_color.'">'.$description.'</div>';
$output .=                      $btn;
$output .=                  '</div>';


$output .= '			</div>
					</div>';
$output .=      $link_box_close;
$output .=	'</div>';

echo $output;
