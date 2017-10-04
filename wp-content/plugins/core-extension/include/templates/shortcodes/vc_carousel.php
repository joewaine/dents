<?php
$output = $image_set = $image = $css_class = $style = $navigation_hide = $color = $anim_style = $imgSrc =
$items_row = $items_col = $navigation = $pagination = $hide_pagination = $slide_speed = $pagination_speed = $autoplay = $stop_hover =
$auto_height = $mouse_drag = $touch_drag = $scroll_basis = $space = $hover = $overlay = $custom_width = $custom_height =
$width = $height = $responsive = $items_tablet = $items_mobile = $radius = $h_overlay = $overlay_class = $overlay_color =
$link = $img_link = $icon = $icon_position = $icon_color = $target = $image_hover = $position = '';

extract(shortcode_atts(array(
	'images'            => '',
	'items_row'         => '1',
	'responsive'        => '',
	'items_tablet'      => '1',
	'items_mobile'      => '1',
	'custom_width'      => '',
	'custom_height'     => '',
	'navigation'        => '',
	'pagination'        => '',
	'navigation_hide'   => '',
	'slide_speed'       => '500',
	'pagination_speed'  => '',
	'autoplay'          => '',
	'stop_hover'        => '',
	'scroll_basis'      => '1',
	'mouse_drag'        => '',
	'style'             => 'carousel-classic',
	'color'             => 'carousel-light',
	'position'          => '',
	'space'             => '0',
	'hover'             => '',
	'anim_style'        => 'slide',
    'radius'            => '0px',
	'img_link'			=> '',
	'icon'				=> '',
	'icon_position'		=> 'icon-center',
	'icon_color'		=> '#ffffff',
	'link'				=> '',
	'target'			=> '_self',
	'image_hover'		=> '',
	'h_overlay'			=> '',
	'overlay_color'		=> 'rgba(0,0,0,.2)',
	'el_class'          => ''
), $atts));


wp_enqueue_script( 'Carousel', COLLARS_PLUGIN_URL . 'assets/js/owl.carousel.min.js', array('jquery'));

$images = explode( ',', $images );

$css_class .= $this->getExtraClass($style);
$css_class .= $this->getExtraClass($color);
$css_class .= $this->getExtraClass($navigation_hide);
$css_class .= $this->getExtraClass($position);
$css_class .= $this->getExtraClass($image_hover);
$css_class .= $this->getExtraClass($el_class);
$css_class .= ($img_link == 'gallery_popup') ? $this->getExtraClass('gallery-popup') : '';
$css_class .= ($pagination == 'true') ? $this->getExtraClass('no-pagination') : '';
$css_class .= ($navigation == 'true') ? $this->getExtraClass('no-navigation') : '';
$icon_class = $this->getExtraClass( $icon_position );
$icon_class .= $this->getExtraClass( $icon );

// Add additional classes to images with popups
if ( $img_link == 'gallery_popup' ) {
	$css_class .= $this->getExtraClass('with-popup gallery_popup');
	wp_enqueue_script( 'magnific-popup', COLLARS_PLUGIN_URL . 'assets/js/magnific-popup.js', array('jquery'), '', false );
	wp_enqueue_script( 'magnific-popup' );
}



($items_row != '') ? $items_row = ' data-items-row="'.$items_row.'"' : '';
//($items_col != '') ? $items_col = ' data-items-col="'.$items_col.'"' : '';
$navigation = ($navigation != 'true') ? ' data-navigation="true"' : ' data-navigation="false"';
//$pagination_speed = ($pagination_speed != '' && $pagination == '') ? 'data-pagination-speed="'.$pagination_speed.'"' : '';
//$pagination = ($pagination != 'true' && $items_col == '1') ? ' data-pagination="true"' : ' data-pagination="false"';
$slide_speed = ($slide_speed != '') ? ' data-slide-speed="'.$slide_speed.'"' : '';
$autoplay = ($autoplay != '') ? ' data-autoplay="'.$autoplay.'"' : ' data-autoplay="false"';
$stop_hover = ($stop_hover != '') ? ' data-stop-hover="'.$stop_hover.'"' : 'data-stop-hover="false"';
$auto_height = ($auto_height != '') ? ' data-auto-height="'.$auto_height.'"' : 'data-auto-height="false"';
$mouse_drag = ($mouse_drag != 'true') ? ' data-mouse-drag="true"' : 'data-mouse-drag="false"';
$touch_drag = ($touch_drag != 'true') ? ' data-touch-drag="true"' : 'data-touch-drag="false"';
$anim_style = ($anim_style != '') ? ' data-transition="'.$anim_style.'"' : 'data-transition="slide"';
$scroll_basis = ($items_row != '1' && $scroll_basis != '') ? ' data-scroll-basis="'.$scroll_basis.'"' : 'data-scroll-basis=1';
$space = ($space != '') ? ' data-space="'.$space.'"' : '';
$radius = ($radius != '') ? ' style="border-radius:'.$radius.'"' : '';

if ( is_rtl() ) {
	$rtl = 'true';
} else {
	$rtl = 'false';
}
$rtl = ' data-rtl="'.$rtl.'"';

if ( $responsive != '' ) {
	$responsive     = ( $responsive != '' ) ? ' data-responsive="'.$responsive.'"' : '';
	$items_tablet   = ( $items_tablet != '' ) ? ' data-items-tablet="'.$items_tablet.'"' : '';
	$items_mobile   = ( $items_mobile != '' ) ? ' data-items-mobile="'.$items_mobile.'"' : '';
}

// Overlay
if ( $h_overlay != '' ) {
	$overlay_class = ' img_color_'.$h_overlay;
	$h_overlay = '<div class="img_overlay'.$overlay_class.'" style="background-color:'.$overlay_color.'"></div>';
}

// Add icon to images
if ( $img_link != '' ) {
	if ( $icon != '' ) {
		$icon_color = ' style="color:'.$icon_color.'"';

		if ( $img_link == 'page_link' ) {
			$icon = '<i class="fa fa-external-link"'.$icon_color.'></i>';
		} elseif ( $img_link == 'gallery_popup' ) {
			$icon = '<i class="fa fa-expand"'.$icon_color.'></i>';
		}
	}
}

$i = 0;
$links = explode(",", $link);
foreach ( $images as $image ) {

	$imaSrc = wp_get_attachment_image_src($image, 'full');
	$imgSrc = $imaSrc[0];

	$width = ($custom_width == '') ? $imaSrc[1] : $custom_width;
	$height = ($custom_height == '') ? $imaSrc[2] : $custom_height;

	// Get appropriate link
	$href = isset($links[$i]) ? $links[$i] : null;

	if ( $img_link == 'page_link' && isset($links[$i])) {
		$href = $links[$i];
		$l_overlay = '<a class="link_overlay" href="'.$href.'" target="'.$target.'"></a>';
	} elseif ( $img_link == 'gallery_popup' ) {
		$l_overlay = '<a class="link_overlay" href="'.$imgSrc.'"></a>';
	} else {
		$href = null;
		$l_overlay = '';
	}

	$image_src = ( $custom_width !== '' && $custom_height !== '' ) ? aq_resize($imgSrc, $width, $height, true) : $imgSrc;

	$image_set .= 	'<div class="twc_image_wrapper swiper-slide'.$icon_class.'"'.$radius.'>
						<img '.$hover.' src="'. $image_src .'" alt="">
						'.$h_overlay.$l_overlay.$icon.
					'</div>';

	$i++;
}

$output .= '<div class="twc_swiper'.$css_class.'">
				<div class="twc_slider_carousel owl-carousel" '.
				$items_row.
				$responsive.
				$items_tablet.
				$items_mobile.
				$navigation.
//				$pagination.
				$slide_speed.
				$autoplay.
				$stop_hover.
				$mouse_drag.
				$anim_style.
				$space.
				$scroll_basis.
				$items_tablet.
				$items_tablet.
				$rtl.
				'>
					'.$image_set.'

	           </div>
	            <div class="twc-controls">
		            <div class="twc-buttons">
		                <div class="twc-prev"><svg viewBox="0 0 700 750" preserveAspectRatio="none"><polygon xmlns="http://www.w3.org/2000/svg" points="455.377,702 140.303,395.991 455.377,90 471.7,106.797 173.953,395.991 471.7,685.19"></polygon></svg></div>
		                <div class="twc-next"><svg viewBox="0 0 700 750" preserveAspectRatio="none"><polygon xmlns="http://www.w3.org/2000/svg" points="156.626,90 471.7,396.009 156.626,702 140.303,685.202 438.05,396.009 140.303,106.81"></polygon></svg></div>
		            </div>
		            <div class="twc-pagination"></div>
		        </div>
            </div>';

echo $output;