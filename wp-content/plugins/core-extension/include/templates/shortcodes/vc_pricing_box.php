<?php
	$output = $el_class = $title = $currency = $price_big = $price_small = $time  = $meta = $add_badge = $box_style =
	$bg_color = $badge_bg = $badge_color = $badge_text = $color = $css_animation = $css_animation_delay = $meta =
	$border_color = $border_width = $padding = '';
	
	if ( function_exists( 'ot_get_option' ) ) {
	  $text_color = ot_get_option('body_text_color');
	}
	
	if ( function_exists( 'ot_get_option' ) ) {
	  $accent_color = ot_get_option('accent_color');
	}

	
	extract(shortcode_atts(array(
		'el_class'              => '',
		'title'                 => 'Standard Pack',
		'currency'              => '$',
		'price_big'             => '10',
		'price_small'           => '99',
		'time'                  => '',
		'meta'                  => 'Most popular choice',
		'add_badge'             => 'off',
		'box_style'             => 'box-classic',
		'bg_color'              => '#ffffff',
		'color'                 => '#262628',
		'header_bg'             => '#262628',
		'header_color'          => '#ffffff',
		'padding'               => '0px',
		'badge_text'            => 'Best Offer',
		'badge_bg'              => '#f47177',
		'badge_color'           => '#ffffff',
		'border_color'          => '',
		'hover_effect'          => '',
		'effect_active'         => '',
		'link'                  => '',
		'css_animation'         => '',
		'css_animation_delay'   => ''
	), $atts));

	$el_class = $this->getExtraClass($el_class);
	$box_style = $this->getExtraClass($box_style);
	$hover_effect = $this->getExtraClass($hover_effect);
	$effect_active = $this->getExtraClass($effect_active);

	$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'pricing-box'.$box_style.$hover_effect.$effect_active.$el_class, $this->settings['base']);
	$css_class .= $this->getCSSAnimation($css_animation);
	($css_animation != '' && $css_animation_delay != '') ? $css_class .= $this->getExtraClass($css_animation_delay) : '';

	$link = ($link=='||') ? '' : $link;
	$link = vc_build_link($link);
	$a_href = $link['url'];
	$a_title = $link['title'];
	($link['target'] != '') ? $a_target = $link['target'] : $a_target = '_self';
	$rel = $link['rel'] !== '' ? ' rel="'.$link['rel'].'"' : '';

	($box_style == ' box-flat' || $box_style == ' box-fancy') ? $title = '<span class="plan-title" style="background-color:'.$header_bg.'; color:'.$header_color.';">'.$title.'</span>' : $title = '<span class="plan-title">'.$title.'</span>';

	$currency = '<span class="plan-currency">'.$currency.'</span>';
	$price_small = '<span class="plan-price-small">'.$price_small.'</span>';
	$price_big = '<span class="plan-price-big">'.$price_big . $price_small . $currency .'</span>';
	$time = '<span class="plan-time">'.$time.'</span>';
	($meta != '') ? $meta = '<span class="plan-meta">'.$meta.'</span>' : $meta = '';

	($border_color != '') ? $border_color = ' border-color:'.$border_color.';' : $border_color = '';
	if ( $border_color != '' ) {
		if ($box_style == ' box-classic') {
			$border_width = ' border-width: 1px;';
		}elseif ($box_style == ' box-flat' || $box_style == ' box-minimal'  || $box_style == ' box-fancy') {
			$border_width = ' border-width: 3px;';
		}
	}


	$output .= '<div class="'.$css_class.'" >';
		$output .= '<div class="pricing-box-inner" style="background-color:'.$bg_color.'; color:'.$color.'; padding-left:'.$padding.'; padding-right:'.$padding.';'.$border_color.$border_width.'">';

			if($add_badge == 'on') {
				$output .= '<div class="plan-badge" style="background-color:'.$badge_bg.'; color:'.$badge_color.';"><span>'.$badge_text.'</span></div>';
			}

			if($box_style == ' box-classic') {
				$output .= '<div class="plan-header" style="color:'.$header_color.';">';
					$output .= $title . $price_big . $time . $meta;
				$output .= '</div>';
				$output .= '<span class="plan-divider" style="background-color:'.$color.';"></span>';
			} elseif($box_style == ' box-minimal') {
				$output .= '<div class="plan-header">';
					$output .= '<span class="plan-title-wrapper" style="background-color:'.$header_bg.'; color:'.$header_color.';">';
						$output .= $title;
					$output .= '</span>';
					$output .= $price_big . $time;
				$output .= '</div>';
			} elseif($box_style == ' box-flat') {
				$output .= '<div class="plan-header" style="background-color:'.$header_bg.'; color:'.$header_color.';">';
					$output .= $title;
					$output .= '<span class="plan-price-wrapper" style="background-color:'.$header_bg.'; color:'.$header_color.'; border-color:'.$bg_color.'; ">';
						$output .= $price_big . $time . $meta;
					$output .= '</span>';

				$output .= '</div>';
			} elseif($box_style == ' box-fancy') {
				$output .= '<div class="plan-header" style="background-color:' . $header_bg . '; color:' . $header_color . ';">';
				$output .= $title . $meta;
				$output .= '<span class="plan-price-wrapper" style="background-color:' . $header_bg . '; color:' . $header_color . '; border-color:' . $bg_color . '; ">';
				$output .= $price_big . $time;
				$output .= '</span>';

				$output .= '</div>';
			}
			$output .= '<div class="plan-features">';
				$output .= wpb_js_remove_wpautop($content);
			$output .= '</div>'; //.plan-features
		$output .= '</div>'; //.pricing-box-container
	$output .= '</div>'; //.pricing-box

	if ( $a_href != '' ) {
		$output = '<a href="'.$a_href.'" title="'.esc_attr($a_title).'" target="'.$a_target.'"'.$rel.'>' . $output . '</a>';
	}


echo $output;