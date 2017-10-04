<?php

$output = $el_class = $image = $img_size = $img_link = $alignment = $css_animation = $css_animation_delay = $css =
$img_link = $icon = $icon_position = $link_trigger = $link = $a_link = $icon_color = $image_hover = $img_popup =
$imgSrc = $imaSetSrc = $imgSetSrc = $images = $zoom = $iframe_link = $icon_size = $overlay_class = $radius = $shadow =
$shadow_class = '';
$exact_size = false;
extract( shortcode_atts( array(
	'image'                 => $image,
	'img_size'              => 'thumbnail',
	'alignment'             => 'center',
	'shadow'                => '',
	'radius'                => '0px',
	'img_link'              => '',
	'iframe_link'           => '',
	'zoom'                  => '',
	'images'                => '',
	'icon'                  => '',
	'icon_position'         => 'icon-center',
	'icon_size'             => 'icon-small',
	'icon_color'            => '#ffffff',
	'link_trigger'          => 'link_image',
	'link'                  => '',
	'image_hover'           => '',
	'h_overlay'             => '',
	'overlay_color'         => 'rgba(0,0,0,.2)',
	'el_class'              => '',
	'css'                   => '',
	'css_animation'         => '',
	'css_animation_delay'   => ''
), $atts ) );

wp_enqueue_script( 'magnific-popup', COLLARS_PLUGIN_URL . 'assets/js/magnific-popup.js', array('jquery'), '', false );
wp_enqueue_script( 'magnific-popup' );


$img_id = preg_replace( '/[^\d]/', '', $image );
// Set rectangular.

$img = wpb_getImageBySize( array(
	'attach_id' => $img_id,
	'thumb_size' => $img_size,
	'class' => 'vc_single_image-img'
) );


// If link to image popup
if ( $img_link == 'image_popup' ) {
	$imgSrc = wp_get_attachment_image_src($image, 'full');
	$imgSrc = $imgSrc[0];
}

// If link to gallery popup
if ( $img_link == 'gallery_popup' ) {
	$images = explode( ',', $images );
	$imageSet = array();

	foreach ( $images as $image ) {
		$imaSetSrc = wp_get_attachment_image_src($image, 'full');
		$imgSetSrc = $imaSetSrc[0];
		array_push($imageSet, $imgSetSrc);
	}

	$imageSet = implode(",", $imageSet);
}


if ( $img == null ) {
	$img['thumbnail'] = '<img class="vc_img-placeholder vc_single_image-img" src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';
}//' <small>'.__('This is image placeholder, edit your page to replace it.', 'js_composer').'</small>';
$el_class = $this->getExtraClass( $el_class );
$icon_class = $this->getExtraClass( $icon_position );

$img_output = $img['thumbnail'];
$radius = ($radius != '') ? 'style="border-radius:' . $radius . '"' : 'style="border-radius:0"';
$shadow_class = ($shadow !='') ? ' ' . $shadow : '';
$image_string = '<div class="vc_single_image-wrapper" '.$radius.'>' . $img_output;
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'twc_magic_image wpb_single_image wpb_content_element' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
$css_class .= $this->getExtraClass($icon);
$css_class .= $this->getExtraClass($link_trigger);
$css_class .= $this->getExtraClass($image_hover);
$anim_class = $this->getCSSAnimation($css_animation);
($css_animation != '' && $css_animation_delay != '') ? $anim_class .= $this->getExtraClass($css_animation_delay) : '';

if ( in_array( $img_link, array('image_popup', 'gallery_popup', 'video_popup') ) ) {
	$zoom = ($zoom == true ) ? ' data-zoom="'.$zoom.'"' : '';
}

// Add additional classes to images with popups
if ( $img_link == 'image_popup' ) {
	$css_class .= $this->getExtraClass('with-popup image_popup');
} elseif ( $img_link == 'gallery_popup' ) {
	$css_class .= $this->getExtraClass('with-popup gallery_popup');
} elseif ( in_array( $img_link, array( 'video_popup' ) ) ) {
	$css_class .= $this->getExtraClass('with-popup iframe_popup');
}

// Construct link
$link = ($link=='||') ? '' : $link;
$link = vc_build_link($link);
$a_href = $link['url'];
$a_title = $link['title'];
($link['target'] != '') ? $a_target = $link['target'] : $a_target = '_self';
$rel = $link['rel'] !== '' ? ' rel="'.$link['rel'].'"' : '';

// If link is attached to image
if ( $img_link != '' ) {
	if ( $icon != '' ) {
		$icon_color = ' style="color:'.$icon_color.'"';

		if ( $img_link == 'page_link' ) {
			$icon = '<i class="fa fa-external-link '.$icon_size.'"'.$icon_color.'></i>';
		} elseif ( $img_link == 'image_popup' ) {
			$icon = '<i class="fa fa-expand '.$icon_size.'"'.$icon_color.'></i>';
		} elseif ( $img_link == 'gallery_popup' ) {
			$icon = '<i class="icon-grid icons '.$icon_size.'"'.$icon_color.'></i>';
		} elseif ( $img_link == 'video_popup' ) {
			$icon = '<i class="fa fa-play-circle-o '.$icon_size.'"'.$icon_color.'></i>';
		}
	}

	// Start outputting link element
	if ( $link_trigger == 'link_image' ) {
		$a_link = '<a class="link_overlay"';
	} elseif ( $link_trigger == 'link_icon' ) {
		$a_link = '<a class="link_icon"';
	}

	// Add link destination
	if ( $img_link == 'page_link' && strlen( $link['url'] ) > 0 ) {
		$a_link .= ' href="'. esc_attr( $a_href ).'" title="'.esc_attr($a_title).'" target="'.esc_attr( $a_target ) . '"'.$rel;
	} elseif ( $img_link == 'image_popup' ) {
		$a_link .= ' data-type="image" data-image="'. $imgSrc .'"'.$zoom;
	} elseif ( $img_link == 'gallery_popup' ) {
		$a_link .= ' data-type="image" data-image="'. $imageSet .'"'.$zoom;
	} elseif ( in_array( $img_link, array( 'video_popup') ) ) {
		$a_link .= ' data-type="iframe" data-image="'. $iframe_link .'"'.$zoom;
	}

	$a_link .= '>';

	// Add icon if chosen
	if ( $link_trigger == 'link_icon' ) {
		$a_link .= $icon;
		$icon = '';
	}

	// Close the tag
	$a_link .= '</a>';
}

// Overlay
if ( $h_overlay != '' ) {
	$overlay_class = ' img_color_'.$h_overlay;
	$h_overlay = '<div class="img_overlay'.$overlay_class.'" style="background-color:'.$overlay_color.'"></div>';
}


$css_class .= ' vc_align_' . $alignment;

$output .= "\n\t" . '<div class="' . $css_class . $anim_class . $icon_class . $shadow_class . '">';
$output .= "\n\t\t" . '<div class="wpb_wrapper">';
$output .= "\n\t\t\t" . $image_string;
$output .= "\n\t\t\t" . $h_overlay;
$output .= "\n\t\t\t" . $a_link;
$output .= "\n\t\t\t" . $icon;
$output .= "\n\t\t\t" . '</div> ' . $this->endBlockComment( '.vc_single_image-wrapper' );
$output .= "\n\t\t" . '</div> ' . $this->endBlockComment( '.wpb_wrapper' );
$output .= "\n\t" . '</div> ' . $this->endBlockComment( '.wpb_single_image' );

echo $output;