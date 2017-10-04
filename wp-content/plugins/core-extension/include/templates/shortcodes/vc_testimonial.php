<?php
$output = $text_align = $img = $img_2 = $name = $author_dec = $q_open = $q_close = $author_top = $author_bottom = $img_url = '';

	extract(shortcode_atts(array(
		'el_class'          => '',
		'img_url'           => '',
		'name'              => 'John Doe',
		'author_dec'        => 'Designer',
		'description'       => '<p>I am testimonial text. Click edit button to change this text.</p>',
		'color_primary'     => '#9ca8ae',
		'color_secondary'   => '#262628',
	), $atts));
			
	$el_class = $this->getExtraClass($el_class);
	$comma = ($author_dec !== '') ? ',' : '';

	if($img_url != '') {
		$img_url = wp_get_attachment_image_src( $img_url, 'large');
		$img_url = $img_url[0];
		$img = '<div class="testimonial-img ta_top"><img src="'. aq_resize($img_url, '300', '300', true) .'" alt="" /></div>';
		$img_2 = '<div class="testimonial-img-2 ta_bottom"><img src="'. aq_resize($img_url, '80', '80', true) .'" alt="" /></div>';
	}

	if($name != '') {
		$author_top = $img.'<div class="testimonial-author ta_top" style="color:' .$color_secondary. '">'.$name.$comma;
			if($author_dec != '') {
				$author_top .= '<span class="testimonial-author-desc">'.$author_dec.'</span>';
			}
		$author_top .= '</div>';
	}

	if($name != '') {
		$author_bottom = $img_2.'<div class="testimonial-author ta_bottom" style="color:' .$color_secondary. '">'.$name.$comma;
		if($author_dec != '') {
			$author_bottom .= '<span class="testimonial-author-desc">'.$author_dec.'</span>';
		}
		$author_bottom .= '</div>';
	}


	$q_open = '<i class="fa fa-quote-left" style="color:' .$color_secondary. '"></i>';
	$q_close = '<i class="fa fa-quote-right" style="color:' .$color_secondary. '"></i>';


	$output .= '<li class="testimonial-wrapper" style="display:none;">';
	$output .=      $author_top;
	$output .=      '<div class="testimonial-content" style="color:' .$color_primary. '">'.$q_open.wpb_js_remove_wpautop($content).$q_close.'</div>';
	$output .=      $author_bottom;
	$output .= '</li>';

echo $output;