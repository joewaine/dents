<?php
$output = $css_class = $style = $navigation_hide = $color = $anim_style = $position =
$items_row = $items_col = $navigation = $pagination = $hide_pagination = $slide_speed = $autoplay = $stop_hover =
$auto_height = $mouse_drag = $touch_drag = $scroll_basis =
$responsive = $items_tablet = $items_mobile =
$slides
= '';

extract(shortcode_atts(array(
	'custom_width'      => '',
	'custom_height'     => '',
	'navigation'        => '',
	'pagination'        => '',
	'navigation_hide'   => '',
	'slide_speed'       => '1000',
	'autoplay'          => '',
	'stop_hover'        => '',
	'mouse_drag'        => '',
	'style'             => 'slider-minimal',
	'color'             => 'slider-dark',
	'position'          => '',
	'el_class'          => ''
), $atts));


wp_enqueue_script( 'Carousel', COLLARS_PLUGIN_URL . 'assets/js/owl.carousel.min.js', array('jquery'));


// Add custom classes
$css_class          .= $this->getExtraClass($style);
$css_class          .= $this->getExtraClass($color);
$css_class          .= $this->getExtraClass($navigation_hide);
$css_class          .= $this->getExtraClass($position);
$css_class          .= $this->getExtraClass($el_class);
$css_class          .= ($pagination == 'true') ? $this->getExtraClass('no-pagination') : '';
$css_class          .= ($navigation == 'true') ? $this->getExtraClass('no-navigation') : '';


// Add parameter values for initialization
$navigation         = ($navigation != 'true') ? ' data-navigation="true"' : ' data-navigation="false"';
$slide_speed        = ($slide_speed != '') ? ' data-slide-speed="'.$slide_speed.'"' : '';
$autoplay           = ($autoplay != '') ? ' data-autoplay="'.$autoplay.'"' : ' data-autoplay="false"';
$stop_hover         = ($stop_hover != '') ? ' data-stop-hover="'.$stop_hover.'"' : 'data-stop-hover="false"';
$auto_height        = ($auto_height != '') ? ' data-auto-height="'.$auto_height.'"' : 'data-auto-height="false"';
$mouse_drag         = ($mouse_drag != 'true') ? ' data-mouse-drag="true"' : 'data-mouse-drag="false"';
$touch_drag         = ($touch_drag != 'true') ? ' data-touch-drag="true"' : 'data-touch-drag="false"';


// Enable RTL mode if necessary
if ( is_rtl() ) {
	$rtl            = 'true';
} else {
	$rtl            = 'false';
}
$rtl                = ' data-rtl="'.$rtl.'"';



// Extract tab titles
//preg_match_all( '/vc_content_slide([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
//$slide_titles         = array();
//
//if ( isset( $matches[1] ) ) {
//	$slide_titles = $matches[1];
//}
//
//foreach ( $slide_titles as $slide ) {
//
//	$slides        .= 	'<div class="twc_image_wrapper swiper-slide">';
//	$slides        .=       "\n\t\t\t" . wpb_js_remove_wpautop( $content );
//	$slides		   .=	'</div>';
//
//}

$output             .= '<div class="twc_content_slider'.$css_class.'">
							<div class="twc_cs_container owl-carousel" '.
							$navigation.
							$slide_speed.
							$autoplay.
							$stop_hover.
							$mouse_drag.
							$anim_style.
							$scroll_basis.
							$items_tablet.
							$items_tablet.
							$rtl.
							'>
								'."\n\t\t\t" . wpb_js_remove_wpautop( $content ).'
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