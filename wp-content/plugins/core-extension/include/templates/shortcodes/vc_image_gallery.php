<?php
$images = $popup = $custom_width = $custom_height = $border =
$items_row = $responsive = $items_tablet = $items_mobile = $items_md = $items_sm = $items_class =
$space = $title = $image_set = $a_open = $a_close = $icon =
$image_hover = $h_overlay = $overlay_color = $overlay_class =
$output = $el_class = $anim_class = $css_animation = $css_animation_delay = $css_class
= '';

extract(shortcode_atts(array(
	'images'                => '',
	'popup'                 => '',
	'border'                => '',
	'custom_width'          => '300',
	'custom_height'         => '300',
	'items_row'             => '3',
	'responsive'            => '',
	'items_tablet'          => '3',
	'items_mobile'          => '3',
	'space'                 => '0',
	'el_class'              => '',
	'image_hover'           => '',
	'h_overlay'             => '',
	'overlay_color'         => 'rgba(0,0,0,.2)',
	'icon'                  => '',
	'icon_color'            => '#ffffff',
	'css_animation'         => '',
	'css_animation_delay'   => ''
), $atts));

// Add custom classes
$el_class               = $this->getExtraClass( $el_class );
$anim_class             = $this->getCSSAnimation($css_animation);
($css_animation != '' && $css_animation_delay != '') ? $anim_class .= $this->getExtraClass($css_animation_delay) : '';


// Assign responsive classes
$items_def              = $items_row;
$items_class           .= $this->getExtraClass( 'twc-ig-lg-'.$items_def );
if ( $responsive == 'true' ) {
	$items_md           = $items_tablet;
	$items_sm           = $items_mobile;
	$items_class       .= $this->getExtraClass( 'twc-ig-md-'.$items_md );
	$items_class       .= $this->getExtraClass( 'twc-ig-sm-'.$items_sm );
}
$items_class           .= $this->getExtraClass( $image_hover );


// Add border around images
$border                 = ( $border != '' ) ? 'style="border:1px solid '.$border.'"' : '';


// Add hover effect if necessary
$css_class             .= $this->getExtraClass( $image_hover );
if ( in_array($h_overlay, array( 'overlay', 'overlay_h' )) ) {
	$overlay_class     .= $this->getExtraClass( 'img_color_'.$h_overlay );
	$h_overlay          = '<div class="img_overlay'.$overlay_class.'" style="background-color:'.$overlay_color.'"></div>';
}


// Add icon to image
if ( in_array($icon, array('img_icon', 'img_icon_h')) ) {
	$icon_class         = $this->getExtraClass( $icon );
	$icon               = '<i class="icon-frame'.$icon_class.'" style="color:'.$icon_color.'"></i>';
}


// Fix for 1px space appearing
if ( $space == '0' || $space == '' ) {
	$css_class         .= $this->getExtraClass( 'no-space' );
}


// If gallery popup enabled
if ( $popup == 'true' ) {
	$css_class          .= $this->getExtraClass( 'with-popup' );
	wp_enqueue_script( 'magnific-popup', COLLARS_PLUGIN_URL . 'assets/js/magnific-popup.js', array('jquery'), '', false );
	wp_enqueue_script( 'magnific-popup' );
}


// Set up images
$i = 0;
$images = explode( ',', $images );
foreach ( $images as $image ) {
	$imaSrc             = wp_get_attachment_image_src($image, 'full');
	$imgSrc             = $imaSrc[0];
	$metadata           = wp_get_attachment_metadata( $image, true );

	if ( isset($metadata['file']) ) {
		$path               = pathinfo($metadata['file']);
		$title              = $path['filename'];

		if ( $popup == 'true' ) {
			$a_open         = '<a href="'.$imgSrc.'" title="'.$title.'" target="_self">';
			$a_close        = '</a>';
		}

		// Get appropriate link
		$image_set         .= 	'<div class="twc_ig_wrapper'.$items_class.'" style="padding:'.$space.'px">
								<div class="twc_ig_inner" '.$border.'>';
		$image_set         .=           $a_open;
		$image_set		   .=		    '<img width="'.$custom_width.'" height="'.$custom_height.'" src="'. aq_resize($imgSrc, $custom_width, $custom_height, true) .'" alt="'.$title.'">';
		$image_set         .=           $h_overlay;
		$image_set         .=           $icon;
		$image_set         .=           $a_close;
		$image_set         .=       '</div>
							</div>';
		$i++;
	}
}


// Output
$output                .=  '<div class="twc_image_gallery'.$css_class.'">';
$output                .=      '<div class="twc_ig_container clearfix">';
$output                .=           $image_set;
$output                .=  '	</div>
							</div>';

echo $output;