<?php
$output = $el_class = $bg_image = $bg_color = $bg_image_repeat = $font_color = $padding = $margin_bottom = $styles =
$style = $parallax_speed = $row_height = $bg_styles = $bg_style = $bg_parallax_speed = $top_slope = $bottom_slope =
$slope_top_pos = $slope_top_dir = $slope_top_height = $slope_top_color = $slope_bottom = $slope_bottom_pos =
$content_fadeout_cont =$slope_bottom_dir = $slope_bottom_height = $slope_bottom_color = $slope_top_class =
$slope_bottom_class = $row_align = $bg_type = $parallax_video = $video_speed = $overlay_pattern = $overlay_pattern_op =
$row_height_type = $data_height = $bg_video = $bg_v_source = $bg_video_mp4 = $bg_video_webm = $bg_video_ogg =
$vimeo_link = $youtube_link = $custom_pattern = $scale_speed = $wrapper_class = $content_styles =$slope_bot_order =
$slope_top_order = $shadow = $video_poster = $m_video = $slope_height_tablet = $slope_height_mobile = $flex_row = $row_inner_width = '';
extract(shortcode_atts(array(
	'el_class'              => '',
	'gap'                   => '',
	'equal_height'          => '',
	'columns_placement'     => '',
	'content_placement'     => '',
	'flex_row'              => '',
	'bg_color'              => '',
	'font_color'            => '',
	'font_weight'           => '',
	'bg_image'              => '',
	'overlay_color'         => '',
	'overlay_pattern'       => '',
	'custom_pattern'        => '',
	'overlay_pattern_op'    => '0.20',
	'full_content_width'    => '',
	'row_height_type'       => '',
	'height'                => '',
	'row_align'             => 'align-middle',
	'bg_repeat'             => '',
	'bg_position'           => '',
	'bg_attachment'         => '',
	'bg_cover'              => '',
	'bg_type'               => '',
	'video_poster'          => '',
	'bg_v_source'           => '',
	'bg_video_mp4'          => '',
	'bg_video_webm'         => '',
	'bg_video_ogg'          => '',
	'vimeo_link'            => '',
	'youtube_link'          => '',
	'parallax_video'        => '',
	'video_speed'           => '',
	'row_separator'         => 'no-separator',
	'section_id'            => '',
	'textalign'             => '',
	'top'                   => '60px',
	'bottom'                => '60px',
	'row_mobile_style'      => '',
	'parallax_bg'           => '',
	'scale_bg'              => '',
	'content_fadeout'       => '',
	'fadeout_speed'         => '',
	'speed'                 => '0.20',
	'scale_speed'           => '0.20',
	'row_show_on'           => '',
	'slope_top'             => '',
	'slope_top_pos'         => 'slope-top-inside',
	'slope_top_dir'         => 'slope-top-left',
	'slope_top_height'      => '100px',
	'slope_top_color'       => '#fff',
	'slope_top_order'       => '',
	'slope_bottom'          => '',
	'slope_bottom_pos'      => 'slope-bottom-inside',
	'slope_bottom_dir'      => 'slope-bottom-left',
	'slope_bottom_height'   => '100px',
	'slope_bottom_color'    => '#fff',
	'slope_bot_order'       => '',
	'slope_height_tablet'   => '',
	'slope_height_mobile'   => ''
), $atts));

wp_enqueue_script( 'wpb_composer_front_js' );

if ($bg_type == 'video' && ($bg_video_mp4 != '' || $bg_video_webm != '' || $bg_video_ogg != '')) {
	wp_enqueue_script( 'MediaElement', COLLARS_PLUGIN_URL . 'assets/js/mediaelement-and-player.min.js', array('jquery'));
	wp_register_style( 'MediaElement', COLLARS_PLUGIN_URL . 'assets/css/mediaelementplayer.css', false, '', 'all' );
	wp_enqueue_style( 'MediaElement' );
}

$el_class = $this->getExtraClass($el_class);
$full_content_width = $this->getExtraClass($full_content_width);
//$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_row main_row '.get_row_css_class().$el_class, $this->settings['base']);
$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_row main_row'.$el_class, $this->settings['base'], $atts ) );

if ($row_separator != 'row-shadow-top' && $row_separator != 'row-shadow-bottom') {
	$css_class .= $this->getExtraClass($row_separator);
} else {
	$shadow = '<div class="'.$row_separator.'"></div>';
}

if ( $gap !== '' ) {
	$css_class .= $this->getExtraClass('twc_column-gap-' . $gap);
}

if ( $equal_height !== '' ) {
	$flex_row = true;
	$css_class .= $this->getExtraClass('twc_row-equal-height');
}

if (  $columns_placement !== '' ) {
	$flex_row = true;
	$css_class .= $this->getExtraClass('twc_row-flex-align-' . $columns_placement);
}

if (  $content_placement !== '' ) {
	$flex_row = true;
	$css_class .= $this->getExtraClass('twc_row-content-align-' . $content_placement);
}

if ( $flex_row !== '' ) {
	$css_class .= $this->getExtraClass('twc_row-flex');
}

if ( $flex_row !== '' && $gap !== '' && $full_content_width === '' ) {
	$row_inner_width = ' style=" max-width:' . esc_attr(intval(ot_get_option('content_width')) + $gap) . 'px"';
}


$css_class .= $this->getExtraClass($row_mobile_style);
($section_id != '') ? $section_id = 'id="'.$section_id.'"' : '';
($row_show_on != '') ? $css_class .= $this->getExtraClass( str_replace(',', ' ', $row_show_on) ) : '';

$styles = array(
	($bg_color != '') ? 'background-color:'.$bg_color.';' : null,
	($textalign != '') ? 'text-align:'.$textalign.';' : null,
	($font_color != '') ? 'color:'.$font_color.';' : null,
	($font_weight != '') ? 'font-weight:'.$font_weight.';' : null,
);

if ($row_height_type == 'fixed_height') {
	if ( $height != '' ) {
		if ( strpos($height,'%') !== false ) {
//			$row_height = intval($height) . 'vh';
			$data_height = intval($height);
			$data_height = ' data-height="'.$data_height.'"';
		} elseif ( strpos($height,'px') !== false ) {
			$row_height = $height;
		}
		$row_height =  ($row_height != '') ? ' height:' . $row_height . ';' : '';
		$wrapper_class .= $this->getExtraClass($row_height_type);
	}

	if ( $flex_row === '' ) {
		$wrapper_class .=$this->getExtraClass($row_align);
	}
}

$top    = ($top != '') ? ' padding-top:'.$top.';' : '';
$bottom = ($bottom != '') ? ' padding-bottom:'.$bottom.';' : '';

//$row_height = ($row_height != '') ? $row_height : '';
$content_styles = ($top != '' || $bottom != '') ? ' style="' . $top . $bottom . $row_height . '"' : '';

// custom slope height
if ( $slope_height_tablet !== ''  ) {
	$css_class .= $this->getExtraClass('custom-slope-tablet');
	$slope_height_tablet = intval($slope_height_tablet);
	$slope_height_tablet = ' data-slope-tablet="'.$slope_height_tablet.'"';
}
if ( $slope_height_mobile !== ''  ) {
	$css_class .= $this->getExtraClass('custom-slope-mobile');
	$slope_height_mobile = intval($slope_height_mobile);
	$slope_height_mobile = ' data-slope-mobile="'.$slope_height_mobile.'"';
}


$detect = new Mobile_Detect;

if ( $bg_type != 'video' ) {

	if($bg_image != '') {
		$image_url = wp_get_attachment_image_src( $bg_image, 'full');
		$image_url = $image_url[0];
	}

	$bg_styles = array(
		($bg_image != '') ? 'background-image:url('.$image_url.');' : null,
		($bg_image != '' && $bg_position != '') ? 'background-position:'.$bg_position.';' : null,
		($bg_image != '' && $bg_attachment != '' && $parallax_bg != 'parallax-bg') ? 'background-attachment:fixed;' : null,
		($bg_image != '' && $bg_cover != '') ? 'background-size:'.$bg_cover.';' : null,
		($bg_image != '' && $bg_repeat != '' && $bg_cover == '') ? 'background-repeat:'.$bg_repeat.';' : null
	);

	$bg_styles = array_filter($bg_styles);

	if( !empty($bg_styles) ){
		$bg_style = implode(' ', $bg_styles);
		$bg_style = ' style="'.$bg_style.'"';
	}

} elseif ( $bg_type == 'video' ) {
	($parallax_video != '') ? $parallax_video = $this->getExtraClass($parallax_video) : '';
	$video_speed = ' data-parallax-speed="'.$speed.'"';

	// If mobile - don't load video
	if ( $detect->isMobile() ) {
		$m_video = ' video-mobile';
	}

		// Video poster
	if ( $video_poster !== '' ) {
		$poster_url = wp_get_attachment_image_src( $video_poster, 'full');
		$poster_url = $poster_url[0];
		$video_poster = '<div class="video-poster" style="background-image:url('.$poster_url.'); background-position:center center; background-size:cover; background-repeat:no-repeat;"></div>';
	}


	if ( $bg_v_source == '' && ($bg_video_mp4 != '' || $bg_video_webm != '' || $bg_video_ogg != '') ) {
		$bg_video = '<div class="bg-video'.$parallax_video.$m_video.'"'.$video_speed.'>';
		$bg_video .= $video_poster;
		if ( !$detect->isMobile() ) {
			$bg_video .= '<video autoplay="true" preload="auto" muted="muted" controls="controls" data-mejsoptions=\'{"alwaysShowControls": true}\'>';
			$bg_video .= ($bg_video_mp4 != '') ? '<source type="video/mp4" src="'.$bg_video_mp4.'">' : '';
			$bg_video .= ($bg_video_webm != '') ? '<source type="video/webm" src="'.$bg_video_webm.'">' : '';
			$bg_video .= ($bg_video_ogg != '') ? '<source type="video/ogg" src="'.$bg_video_ogg.'">' : '';
			$bg_video .= '</video>';
		}
		$bg_video .= '</div>';

	} elseif ( $bg_v_source == 'vimeo' && $vimeo_link != '' ) {
		$video_id=explode('vimeo.com/', $vimeo_link);
		$video_id=$video_id[1];
		$data['video_type'] = 'vimeo';
		$data['video_id'] = $video_id;
//		$xml = simplexml_load_file("http://vimeo.com/api/v2/video/$video_id.xml");
		$xml = simplexml_load_file("https://vimeo.com/api/oembed.xml?url=$vimeo_link");
		$urlParts = explode("/", parse_url($vimeo_link, PHP_URL_PATH));
		$videoId = (int)$urlParts[count($urlParts)-1];

//		foreach ($xml->video as $video) {
			$data['width'] = (string) $xml[0] -> width;
			$data['height'] = (string) $xml[0] -> height;
//		}

		$bg_video  = '<div class="bg-video'.$parallax_video.$m_video.'"'.$video_speed.'>';
		$bg_video .= $video_poster;
		if ( !$detect->isMobile() ) {
			$bg_video .= '<div class="bg-vimeo">';
			$bg_video .=        '<iframe class="vimeo-player" src="//player.vimeo.com/video/'.$videoId.'?api=1&amp;title=0&amp;byline=0&amp;portrait=0&amp;badge=0&amp;color=0&amp;autoplay=1&amp;loop=1" data-width="'.$data['width'].'" data-height="'.$data['height'].'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
			$bg_video .=        '</div>';
		}
		$bg_video .= '</div>';

	} elseif ( $bg_v_source == 'youtube' && $youtube_link != '' ) {
		wp_register_script( 'vc_youtube_iframe_api_js', 'https://www.youtube.com/iframe_api', array(), WPB_VC_VERSION, true );
		wp_enqueue_script( 'vc_youtube_iframe_api_js' );

		preg_match('#(?<=(?:v|i)=)[a-zA-Z0-9-]+(?=&)|(?<=(?:v|i)\/)[^&\n]+|(?<=embed\/)[^"&\n]+|(?<=(?:v|i)=)[^&\n]+|(?<=youtu.be\/)[^&\n]+#', $youtube_link, $matches);
		$bg_video  = '<div class="bg-video'.$parallax_video.$m_video.'"'.$video_speed.'>';
		$bg_video .= $video_poster;
//		if ( !$detect->isMobile() ) {
			$bg_video .= '<div class="bg-youtube" data-youtube-id="'.$matches[0].'">';
			$bg_video .= '</div>';
//		}
		$bg_video .= '</div>';
	}
}


$styles = array_filter($styles);

if( !empty($styles) ){
	$style = implode(' ', $styles);
	$style = ' style="'.$style.'"';
}


//Top slope styling
($slope_top != '') ? $slope_top_class .= $this->getExtraClass($slope_top) : null;
($slope_top != '' && $slope_top_pos != '') ? $slope_top_class .= $this->getExtraClass($slope_top_pos) : null;
($slope_top != '' && $slope_top_order != '') ? $slope_top_class .= $this->getExtraClass($slope_top_order) : null;
($slope_top != '' && $slope_top_height != '') ? $slope_top_height = ' style="height:'.$slope_top_height . '"' : null;
($slope_top != '' && $slope_top_color != '') ? $slope_top_color = ' fill="'.$slope_top_color.'"' : null;


if ( !empty($slope_top) ) {
	$top_slope .= '<div class="row-slope' . $slope_top_class . '"' . $slope_top_height . '>' .
	                '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none">';
					if ( $slope_top_pos == 'slope-top-inside' ) :
						if( $slope_top_dir == 'slope-top-left' ) :
							$top_slope .= '<path d="M0 0 L100 0 L100 2 L0 100 Z"' . $slope_top_color . '></path>';
						elseif ( $slope_top_dir == 'slope-top-right' ) :
							$top_slope .= '<path d="M0 0 L100 0 L100 100 L0 2 Z"' . $slope_top_color . '></path>';
						endif;
					elseif ( $slope_top_pos == 'slope-top-outside' ) :
						if( $slope_top_dir == 'slope-top-left' ) :
							$top_slope .= '<path d="M0 100 L0 98 L100 0 L100 100 Z"' . $slope_top_color . '></path>';
						elseif ( $slope_top_dir == 'slope-top-right' ) :
							$top_slope .= '<path d="M0 0 L100 98 L100 100 L0 100 Z"' . $slope_top_color . '></path>';
						endif;
					endif;
	$top_slope .= '</svg></div>';
}

//Bottom slope styling
($slope_bottom != '') ? $slope_bottom_class .= $this->getExtraClass($slope_bottom) : null;
($slope_bottom != '' && $slope_bottom_pos != '') ? $slope_bottom_class .= $this->getExtraClass($slope_bottom_pos) : null;
($slope_bottom != '' && $slope_bot_order != '') ? $slope_bottom_class .= $this->getExtraClass($slope_bot_order) : null;
($slope_bottom != '' && $slope_bottom_height != '') ? $slope_bottom_height = ' style="height:'.$slope_bottom_height . '"' : null;
($slope_bottom != '' && $slope_bottom_color != '') ? $slope_bottom_color = ' fill="'.$slope_bottom_color.'"' : null;


if ( !empty($slope_bottom) ) {
	$bottom_slope .= '<div class="row-slope' . $slope_bottom_class . '"' . $slope_bottom_height . '>' .
	              '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none">';
	if ( $slope_bottom_pos == 'slope-bottom-inside' ) :
		if( $slope_bottom_dir == 'slope-bottom-left' ) :
			$bottom_slope .= '<path d="M0 100 L0 98 L100 0 L100 100 Z"' . $slope_bottom_color . '></path>';
		elseif ( $slope_bottom_dir == 'slope-bottom-right' ) :
			$bottom_slope .= '<path d="M0 0 L100 98 L100 100 L0 100 Z"' . $slope_bottom_color . '></path>';
		endif;
	elseif ( $slope_bottom_pos == 'slope-bottom-outside' ) :
		if( $slope_bottom_dir == 'slope-bottom-left' ) :
			$bottom_slope .= '<path d="M0 0 L100 0 L100 2 L0 100 Z"' . $slope_bottom_color . '></path>';
		elseif ( $slope_bottom_dir == 'slope-bottom-right' ) :
			$bottom_slope .= '<path d="M0 0 L100 0 L100 100 L0 2 Z"' . $slope_bottom_color . '></path>';
		endif;
	endif;
	$bottom_slope .= '</svg></div>';
}

//Overlay styling
if ( !$detect->isMobile() ) {
	if($parallax_bg == 'parallax-bg') {
		$bg_parallax_speed = ' data-parallax-speed="'.$speed.'"';
	}
	if($scale_bg == 'scale-bg') {
		$scale_speed = ' data-scaling-speed="'.$scale_speed.'"';
	}
}
$parallax_bg = $this->getExtraClass($parallax_bg);
$scale_bg = $this->getExtraClass($scale_bg);
$content_fadeout_cont = ($content_fadeout == 'content-fadeout') ? ' cont_fade_out' : '';
$content_fadeout = $this->getExtraClass($content_fadeout);


$background = ($bg_image != '' && $bg_type == 'image') ? '<div class="bg-image bg-init'.$parallax_bg.$scale_bg.'"' . $bg_parallax_speed . $scale_speed . $bg_style.'></div>' : '';
$overlay_color = (($bg_type == 'image' || $bg_type == 'video' ) && $overlay_color != '') ? '<div class="overlay-color" style="background-color:' .$overlay_color. '"></div>' : '';

$overlay_pattern_op = ($overlay_pattern != '' && $overlay_pattern_op !='' ) ? 'opacity:'.$overlay_pattern_op.';' : '';
if ( $custom_pattern != '' && $overlay_pattern == 'custom' ) {
	$custom_pattern = wp_get_attachment_image_src( $custom_pattern, 'full');
	$custom_pattern = $custom_pattern[0];
	$overlay_pattern = '<div class="overlay-pattern" style="background-image:url('.$custom_pattern.'); '.$overlay_pattern_op.'"></div>';
} elseif ($overlay_pattern != '') {
	$overlay_pattern = '<div class="overlay-pattern" style="background-image:url(' . COLLARS_PLUGIN_URL . 'assets/patterns/'.$overlay_pattern.'.png); '.$overlay_pattern_op.'"></div>';
}

$overlay = '<div class="row-overlay">'.$background.$bg_video.$overlay_color.$overlay_pattern.$shadow.'</div>';


$output .= '<section '.$section_id.' class="'.$css_class.'"'.$slope_height_tablet.$slope_height_mobile.$style.'>';
$output .= $overlay;
$output .= $top_slope;

($row_height_type == 'fixed_height') ? $output .= '<div class="row-wrapper'.$wrapper_class.$full_content_width.'"'.$data_height.'>' : '';
$output .= '<div class="row_content'.$content_fadeout_cont.'"'.$content_styles.'><div class="row-inner'.$full_content_width.$content_fadeout.'"'.$row_inner_width.'>';
$output .= wpb_js_remove_wpautop($content);
$output .= '</div></div>';
($row_height_type == 'fixed_height') ? $output .= '</div>' : '';

$output .= $bottom_slope . '</section>'.$this->endBlockComment('row');

echo $output;