<?php
$output = $color = $size = $icon = $target = $link = $el_class = $title = $border_radius = $icon_name =
$iconClass = $type = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypoicons = $icon_linecons =
$icon_simplelineicons = '';

	extract(shortcode_atts(array(
		'color'                 => 'btn_themecolor',
		'size'                  => 'wpb_regularsize',
		'type'                  => '',
		'icon_fontawesome'      => 'fa fa-adjust',
		'icon_openiconic'       => '',
		'icon_typicons'         => '',
		'icon_entypoicons'      => '',
		'icon_linecons'         => '',
		'icon_entypo'           => '',
		'icon_simplelineicons'  => '',
		'margin_left'           => '0px',
		'margin_right'          => '0px',
		'link'                  => '',
		'button_style'          => '',
		'icon_pos'              => 'icon-left',
		'border_radius'         => 'sharp',
		'button_align'          => '',
		'button_width'          => '',
		'el_class'              => '',
		'title'                 => __('Text on the button', 'core-extension'),
		'css_animation'         => '',
		'css_animation_delay'   => ''
	), $atts));


	$a_class = '';

	vc_icon_element_fonts_enqueue( $type );

	$iconClass = isset( ${"icon_" . $type} ) ? esc_attr( ${"icon_" . $type} ) : '';


	$link = ($link=='||') ? '' : $link;
	$link = vc_build_link($link);
	$a_href = $link['url'];
	$a_title = $link['title'];
	($link['target'] != '') ? $a_target = $link['target'] : $a_target = '_self';
	$rel = $link['rel'] !== '' ? ' rel="'.$link['rel'].'"' : '';

	$color           = ( $color != '' ) ? ' wpb_'.$color : '';
	$size            = ( $size != '' && $size != 'wpb_regularsize' ) ? ' wpb_'.$size : ' '.$size;
	$radius          = ( $border_radius != '' ) ? ' wpb_'.$border_radius : '';
	$i_icon          = ( $iconClass != '' ) ? ' <i class="'. $iconClass .'"></i>' : '';
	$button_style    = ( $button_style != '' ) ? ' wpb_btn-minimal' : '';
	$el_class        = $this->getExtraClass($el_class);

	$margin_left     = ( $margin_left != '') ? ' margin-left:'.$margin_left.';' : '';
	$margin_right    = ( $margin_right != '') ? ' margin-right:'.$margin_right.';' : '';
	$margins         = ( $margin_left != '' || $margin_right != '' ) ? ' style="'.$margin_left.$margin_right.'"' : '';
	
	$css_class       = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_button'.$color.$size.$el_class.$button_style.$radius, $this->settings['base']);
	$css_class      .= $this->getCSSAnimation($css_animation);
	($css_animation != '' && $css_animation_delay != '') ? $css_class .= $this->getExtraClass($css_animation_delay) : '';
	($button_align != '') ? $css_class .= $this->getExtraClass($button_align) : '';


	if ( $a_href != '' ) {
		$output .= ( $icon_pos == 'icon-left' ) ? '<span class="' .$icon_pos. '">'.$i_icon.$title.'</span>' :
												  '<span class="' .$icon_pos. '">'.$title.$i_icon.'</span>' ;
		$output = '<a class="wpb_button_a '.$css_class.$button_width.' '.$a_class.'" title="'.esc_attr( $a_title ).'" href="'.esc_attr( $a_href ).'" target="'.esc_attr( $a_target ).'"'.$rel.$margins.'>' . $output . '</a>';
	} else {
		$output .= ( $icon_pos == 'icon-left' ) ? '<button class="'.$css_class.$button_width.'"'.$margins.'><span class="' .$icon_pos. '">'.$i_icon.$title.'</span></button>' :
												  '<button class="'.$css_class.$button_width.'"'.$margins.'><span class="' .$icon_pos. '">'.$title.$i_icon.'</span></button>' ;
	}

echo $output . $this->endBlockComment('button') . "\n";