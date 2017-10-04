<?php
$output = $title_tag = $subtitle_tag = '';

	extract(shortcode_atts(array(
		'el_class'              => '',
		'h_size'                => '',
		'title'                 => '',
		'title_tag'             => 'div',
		'title_color'           => '#363b3e',
		'subtitle'              => '',
		'subtitle_tag'          => 'div',
		'subtitle_color'        => '#9ca8ae',
		'alignment'             => 'align-center',
		'divider'               => '',
		'divider_type'          => 'div-narrow',
		'size'                  => 'small',
		'divider_color'         => '#36353c',
		'css_animation'         => '',
		'css_animation_delay'   => ''
	), $atts));
	
	$el_class = $this->getExtraClass($el_class);
	($title_color != '') ? $title_color = ' style="color:'.$title_color.';"' : '';
	($subtitle_color != '') ? $subtitle_color = ' style="color:'.$subtitle_color.';"' : '';
	$div_color_tilt = ($divider != '' && $divider_color != '' ) ? ' fill="'.$divider_color.'"' : '';
	($divider != '' && $divider_color != '' ) ? $divider_color = ' style="background-color:'.$divider_color.';"' : '';

	$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'heading_wrapper'.$el_class, $this->settings['base']);
	$css_class .= $this->getCSSAnimation($css_animation);
	($css_animation != '' && $css_animation_delay != '') ? $css_class .= $this->getExtraClass($css_animation_delay) : '';
	($alignment != '') ? $css_class .= $this->getExtraClass($alignment) : '';
	($h_size != '') ? $css_class .= $this->getExtraClass($h_size) : '';

//	($divider != '' && $divider_size != '' ) ? $css_class .= $this->getExtraClass($divider_size) : '';


	if ( $divider != '' ) :
		if ( $divider_type != 'tilt' ) :
			$div = '<div class="h-divider' .$this->getExtraClass($divider_type). '"' .$divider_color. '></div>';
		elseif ( $divider_type == 'tilt' ) :
			$div = '<div class="separator_wrapper_tilt">
						<div class="separator_tilt ' .$size. '">
							<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
							    <path'.$div_color_tilt.' d="M5 0 L53 0 L48 55 L0 55"></path>
							    <path'.$div_color_tilt.' d="M53 45 L100 45 L95 100 L48 100"></path>
							</svg>
						</div>
					</div>';
		endif;
	endif;


	$output .= '<div class="'.$css_class.'">
					<'.$title_tag.' class="heading_title"'.$title_color.'>'.$title.'</'.$title_tag.'>';
	$output .=      ( $divider == 'div-between' ) ? $div : '';
	$output .=	    '<'.$subtitle_tag.' class="heading_subtitle"' .$subtitle_color. '>'.$subtitle.'</'.$subtitle_tag.'>';
	$output .=      ( $divider == 'div-below' ) ? $div : '';
	$output .=	'</div>';

echo $output;