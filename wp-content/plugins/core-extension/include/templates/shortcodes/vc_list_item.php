<?php
$output = $iconClass = $type = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypoicons = $icon_linecons =
$icon_simplelineicons = $el_class = $icon_color = $css_animation = $css_animation_delay = '';
	
	$accent_color = '#14b8c0';
	
	if ( function_exists( 'ot_get_option' ) ) {
	  $accent_color = ot_get_option('accent_color');
	}
		
	extract(shortcode_atts(array(
		'type'                  => '',
		'icon_fontawesome'      => '',
		'icon_openiconic'       => '',
		'icon_typicons'         => '',
		'icon_entypoicons'      => '',
		'icon_linecons'         => '',
		'icon_entypo'           => '',
		'icon_simplelineicons'  => '',
		'icon_color' => $accent_color,
		'link' => '',
		'css_animation' => '',
		'css_animation_delay' => '',
		'el_class' => ''
	), $atts));
	
	$el_class = $this->getExtraClass($el_class);
	vc_icon_element_fonts_enqueue( $type );

	$iconClass = isset( ${"icon_" . $type} ) ? esc_attr( ${"icon_" . $type} ) : 'fa fa-adjust';

	($icon_color != '') ? $icon_color = ' style="color:'.$icon_color.'"' : '';
	
	$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'custom-list-item'.$el_class, $this->settings['base']);
	$css_class .= $this->getCSSAnimation($css_animation);
	($css_animation != '' && $css_animation_delay != '') ? $css_class .= $this->getExtraClass($css_animation_delay) : '';

	$link = ($link=='||') ? '' : $link;
	$link = vc_build_link($link);
	$a_href = $link['url'];
	$a_title = $link['title'];
	($link['target'] != '') ? $a_target = $link['target'] : $a_target = '_self';
	$rel = $link['rel'] !== '' ? ' rel="'.$link['rel'].'"' : '';

	if ( $a_href != '' ) {
		$output .= '<i class="'.$iconClass.'"'.$icon_color.'></i>';
		$output = '<div class="'.$css_class.'">' . $output .'<a class="custom-list-item-inner" href="'.esc_attr( $a_href ).'" title="'.esc_attr($a_title).'" target="'.esc_attr( $a_target ).'"'.$rel.'>'. wpb_js_remove_wpautop($content).'</a></div>';
	} else {
		$output .= '<div class="'.$css_class.'"><i class="'.$iconClass.'"'.$icon_color.'></i><div class="custom-list-item-inner">'.wpb_js_remove_wpautop($content).'</div></div>';
	}
	
echo $output;
