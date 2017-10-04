<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $full_width
 * @var $full_height
 * @var $columns_placement
 * @var $content_placement
 * @var $parallax
 * @var $parallax_image
 * @var $css
 * @var $el_id
 * @var $video_bg
 * @var $video_bg_url
 * @var $video_bg_parallax
 * @var $parallax_speed_bg
 * @var $parallax_speed_video
 * @var $content - shortcode content
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Row
 */
$el_class = $full_height = $parallax_speed_bg = $parallax_speed_video = $full_width = $flex_row = $columns_placement = $content_placement = $parallax = $parallax_image = $css = $el_id = $video_bg = $video_bg_url = $video_bg_parallax = $css_animation =
$full_content_width = $content_styles = $style = $section_height_type = $full_height_class = $section_align = '';
$disable_element = '';
$output = $after_output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_script( 'wpb_composer_front_js' );

$el_class = $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );

$css_classes = array(
	'vc_section',
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

if ( 'yes' === $disable_element ) {
	if ( vc_is_page_editable() ) {
		$css_class .= $this->getExtraClass('vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md');
	} else {
		return '';
	}
}

if ($bg_type == 'video' && ($bg_video_mp4 != '' || $bg_video_webm != '' || $bg_video_ogg != '')) {
	wp_enqueue_script( 'MediaElement', COLLARS_PLUGIN_URL . 'assets/js/mediaelement-and-player.min.js', array('jquery'));
	wp_register_style( 'MediaElement', COLLARS_PLUGIN_URL . 'assets/css/mediaelementplayer.css', false, '', 'all' );
	wp_enqueue_style( 'MediaElement' );
}

$el_class = $this->getExtraClass($el_class);
$full_content_width = $this->getExtraClass($full_content_width);

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_section wpb_row main_row'.$el_class, $this->settings['base'], $atts ) );
//$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

($section_id != '') ? $section_id = 'id="'.$section_id.'"' : '';

$styles = array(
	($bg_color != '') ? 'background-color:'.$bg_color.';' : null,
);

$output .= $section_height_type;

if ($full_height === 'full_height') {
	$full_height_class = ' section-full-height';

	if ( $section_align !== '' ) {
		$full_height_class .= ' section-' . $section_align;
	}
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





$output .= '<section '.$section_id.' class="'.$css_class.'"'.$style.'>';
$output .= $overlay;
($full_height === 'full_height') ? $output .= '<div class="row-wrapper'.$full_content_width.$full_height_class.'">' : '';
$output .= '<div class="row_content"><div class="row-inner'.$full_content_width.'"'.$row_inner_width.'>';
$output .= wpb_js_remove_wpautop($content);
$output .= '</div></div>';
($full_height === 'full_height') ? $output .= '</div>' : '';


//$output .= '<section ' . implode( ' ', $wrapper_attributes ) . '>';
//$output .= wpb_js_remove_wpautop( $content );
$output .= '</section>';
$output .= $after_output;

echo $output;