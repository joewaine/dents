<?php
$output = $icon_position = $anim_class = $sonar_color = $hover_class = $icon_hover = $icon_shape =
$iconClass = $type = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypoicons = $icon_linecons =
$icon_simplelineicons = $heading_color = $link = $icon_hover_1 = $icon_hover_2 = '';
	
	$accent_color = '#14b8c0';
	
	if ( function_exists( 'ot_get_option' ) ) {
	  $accent_color = ot_get_option('accent_color');
	}
		
	extract(shortcode_atts(array(
		'type'                  => 'fontawesome',
		'icon_fontawesome'      => 'fa fa-adjust',
		'icon_openiconic'       => '',
		'icon_typicons'         => '',
		'icon_entypoicons'      => '',
		'icon_linecons'         => '',
		'icon_entypo'           => '',
		'icon_simplelineicons'  => '',
		'el_class'              => '',
		'title'                 => 'Your service title',
		'icon_color'            => $accent_color,
		'heading_color'         => '',
		'descr_color'           => '',
		'link'                  => '',
		'icon_position'         => '',
		'border_color'          => '',
		'bg_color'              => '',
		'icon_shape'            => 'service-empty',
		'icon_hover_1'          => '',
		'icon_hover_2'          => '',
		'css_animation'         => '',
		'css_animation_delay'   => ''
	), $atts));

	//Defaults in case restricted options remain selected
	$hover_class = $icon_hover = '';

	$el_class = $this->getExtraClass($el_class);
	$icon_position = $this->getExtraClass($icon_position);

	vc_icon_element_fonts_enqueue( $type );

	$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'service_icon', $this->settings['base']);
	$anim_class .= $this->getCSSAnimation($css_animation);
	($css_animation != '' && $css_animation_delay != '') ? $anim_class .= $this->getExtraClass($css_animation_delay) : '';

	($border_color != '') ? $sonar_color = 'color:' . $border_color . ';' : '';

	if ( $icon_shape == 'service-hexagon' ) {
		($bg_color != '') ? $border_color = 'border-color:' . $bg_color . ';': '';
	}

	if ( $icon_shape != 'service-empty' ) {

		if ( $icon_shape == 'service-hexagon' ) {
			($bg_color != '') ? $border_color = 'border-top-color:' . $bg_color . '; border-bottom-color:' . $bg_color . ';': '';
		} else {
			($border_color != '') ? $border_color = 'border-color:' . $border_color . ';': '';
		}

		($bg_color != '') ? $sonar_color = 'color:' . $bg_color .';' : 'color:#fff;';
		($bg_color != '') ? $bg_color = 'background-color:' . $bg_color . ';': '';
	}



	if ( $icon_hover_1 != '' ) {
		$icon_hover = $icon_hover_1;
	} elseif ( $icon_hover_2 != '' ) {
		$icon_hover = $icon_hover_2;
	}

	$has_icon_anim = ( $icon_hover != '' ) ? $this->getExtraClass( 'has_icon_anim' ) : '';


	if ( $icon_hover == 'h-sonar' && !in_array($icon_shape, array('service-square', 'service-rounded', 'service-circle')) ) {
		$icon_hover = '';
	}

	if ( $icon_shape == 'service-hexagon' ) {
		$icon_hover = '';
	}

	$hover_class = $this->getExtraClass($icon_hover);

	$iconClass = isset( ${"icon_" . $type} ) ? esc_attr( ${"icon_" . $type} ) : 'fa fa-adjust';

	$link = ($link=='||') ? '' : $link;
	$link = vc_build_link($link);
	$a_href = $link['url'];
	$a_title = $link['title'];
	($link['target'] != '') ? $a_target = $link['target'] : $a_target = '_self';
	$rel = $link['rel'] !== '' ? ' rel="'.$link['rel'].'"' : '';

	$descr_color = ($descr_color != '') ? ' style="color:'.$descr_color.';"' : '' ;
	
	if ( strlen( $link['url'] ) > 0 ) {
		$output .= '<div class="'.$css_class.$has_icon_anim. ' ' . $icon_shape . '" style="color:' . $icon_color . '; ' .$bg_color . $border_color. '">
						<i class="' . $iconClass . '">
							<span style="' .$sonar_color. '"></span>
						</i>
					</div>';
		$output .= '<div class="service-content"'.$descr_color.'>
						<h6 style="color:' . $heading_color . ';">' . $title . '</h6>';
		$output .=      "\n\t\t\t".wpb_js_remove_wpautop($content);
		$output .= '</div>';

		$output =   '<div class="service-box'.$el_class.$icon_position.$hover_class.$anim_class.'">
						<a class="wpb_button_a" href="'. esc_attr( $a_href ).'" title="'.esc_attr($a_title).'" target="'.esc_attr( $a_target ).'"'.$rel.'>' . $output . '</a>
					</div>';
	} else {
		$output .= '<div class="service-box'.$el_class.$has_icon_anim.$icon_position.$hover_class.$anim_class.'">
						<div class="'.$css_class. ' ' . $icon_shape . '" style="color:' . $icon_color . '; ' .$bg_color . $border_color. '">
							<i class="' . $iconClass . '">
								<span style="' .$sonar_color. '"></span>
							</i>
						</div>
						<div class="service-content"'.$descr_color.'>
							<h6 style="color:' . $heading_color . ';">' . $title . '</h6>';
		$output .=              "\n\t\t\t".wpb_js_remove_wpautop($content);
		$output .=      '</div>
					</div>';
	}

echo $output;
