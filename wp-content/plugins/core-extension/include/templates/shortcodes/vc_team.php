<?php
$output = $overlay = '';
	
	$accent_color = '#14b8c0';
	
	if ( function_exists( 'ot_get_option' ) ) {
	  $accent_color = ot_get_option('accent_color');
	}
	
	extract(shortcode_atts(array(
		'el_class'              => '',
		'color_scheme'          => $accent_color,
		'img_url'               => '',
		'height'                => '450',
		'name'                  => 'Michael Smith',
		'position'              => 'Sales Manager',
		'hover_txt'             => '',
		'design'                => 'team-style-1',
		'social'                => '',
		'align'                 => 'align-center',
		'overlay_text_color'    => '',
		'name_color'            => '',
		'position_color'        => '',
		'info_color'            => '',
		'css_animation'         => '',
		'css_animation_delay'   => ''
	), $atts));

	$content = wpb_js_remove_wpautop($content, true);
	
	$el_class = $this->getExtraClass($el_class);
	$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'team_wrapper'.$el_class, $this->settings['base']);
	$css_class .= $this->getCSSAnimation($css_animation);
	($css_animation != '' && $css_animation_delay != '') ? $css_class .= $this->getExtraClass($css_animation_delay) : '';

if($design == 'team-style-1' || $design == 'team-style-2') {
	$css_class .= $this->getExtraClass($align);
}

$overlay_text_color = ( $overlay_text_color != '' ) ? ' style="color:'.$overlay_text_color.'"' : '';
$name_color = ( $name_color != '' ) ? ' style="color:'.$name_color.'"' : '';
$position_color = ( $position_color != '' ) ? ' style="color:'.$position_color.'"' : '';
$info_color = ( $info_color != '' ) ? ' style="color:'.$info_color.'"' : '';

	
	if($hover_txt != '') {
		if ($design == 'team-style-1') {
			$hover_txt =    '<div class="team-overlay" style="background-color:' . $color_scheme . '">
								<figcaption>
									<span'.$overlay_text_color.'>'.$hover_txt.'</span>
								</figcaption>
							</div>';
		} elseif ($design == 'team-style-2') {
			$q_open = '<i class="fa fa-quote-left"></i>';
			$q_close = '<i class="fa fa-quote-right"></i>';

			$hover_txt =    '<div class="team-overlay" style="background-color: rgba('.collars_hex2rgb($color_scheme).', 0.8)">
								<div class="to-inner">
									<figcaption class="team-h-text"'.$overlay_text_color.'>' . $q_open . $hover_txt . $q_close . '</figcaption>
								</div>
							</div>';
		}

		$css_class .= ' add_team_hover';
	}
	
	if($img_url != '') {
		$img_url = wp_get_attachment_image_src( $img_url, 'full');
		$img_url = $img_url[0];
		$img = '<img src="'. aq_resize($img_url, 450, $height, true, true, true) .'" alt="" />';
	} else {
		$img = '';
	}

if($design == 'team-style-3') {
	$overlay = '<div class="team-overlay" style="background-color:rgba('.collars_hex2rgb($color_scheme).', 0.8)">
					<div class="to-inner">
						<figcaption>
							<div class="team_member_position"'.$overlay_text_color.'>'.$position.'</div>
							<div class="team_member_name"'.$overlay_text_color.'>'.$name.'</div>
							<div class="team_social"'.$overlay_text_color.'>' . $content . '</div>
						</figcaption>
					</div>
				</div>
	';
}



	if($design == 'team-style-2') {
		$output .= '<div class="'.$css_class.' team-style-2">
						<figure class="team_image">'.$img.$hover_txt.'</figure>
						<div class="team_member_name"'.$name_color.'>'.$name.'</div>
						<div class="team_member_position"'.$position_color.'>'.$position.'</div>
						<div class="team_info"'.$info_color.'>';
		$output .=          $content;
		$output .=      '</div>
					</div>';
	} elseif ($design == 'team-style-1') {
			$output .= '<div class="'.$css_class.' team-style-1">
							<figure class="team_image">
								'.$img.$hover_txt.'
							</figure>
							<div class="team_member_name"'.$name_color.'>'.$name.'</div>
							<div class="team_member_position"'.$position_color.'>'.$position.'</div>
							<div class="team_info"'.$info_color.'>';
		$output .=          $content;
		$output .=          '</div>
						</div>';
	} else {
		$output .= '<div class="'.$css_class.' team-style-3 add_team_hover">
						<figure class="team_image">'
			                .$img
			                .$overlay.
		                '</figure>';
		$output .=      '</div>';
	}

echo $output;
