<?php
$output = $image = $img_output = $img_id = $img_size = $image_effect = $h_overlay = $overlay_color =
$heading = $text = $heading_color = $text_color =
$add_link = $link = $link_image = $link_heading = $link_button = $iframe_link = $images =
$style = $align = $bg_color = $bg_color2 = $border_color = $radius = $slope =
$button_styles = $button = $button_alt = $button_array = $b_text_color = $b_bg_color = $b_border_color = $b_radius =
$bh_styles = $bh_array = $bh_text_color = $bh_bg_color = $bh_border_color = $bh_radius = $b_cont
= '';

$accent_color = '#14b8c0';

if ( function_exists( 'ot_get_option' ) ) {
	$accent_color = ot_get_option('accent_color');
}

extract(shortcode_atts(array(
	'image'                 => '',
	'img_size'              => '',
	'image_effect'          => '',
	'h_overlay'             => 'rgba(0,0,0,.2)',
	'overlay_color'         => '',
	'heading'               => '',
	'heading_color'         => '',
	'text'                  => '',
	'text_color'            => '',
	'add_link'              => '',
	'link'                  => '',
	'iframe_link'           => '',
	'images'                => '',
	'link_image'            => '',
	'link_heading'          => '',
	'link_button'           => '',
	'style'                 => 'twc_imb_standard',
	'align'                 => '',
	'bg_color'              => '',
	'border_color'          => '',
	'radius'                => '0px',
	'shadow'                => '',
	'button'                => '',
	'b_text_color'          => '',
	'b_bg_color'            => '',
	'b_border_color'        => '',
	'b_radius'              => '',
	'bh_text_color'         => '',
	'bh_bg_color'           => '',
	'bh_border_color'       => '',
	'bh_radius'             => '',

	'el_class'              => '',
	'css_animation'         => '',
	'css_animation_delay'   => ''
), $atts));

if ( in_array( $add_link, array( 'gallery_popup', 'video_popup' ) ) ) {
	wp_enqueue_script( 'magnific-popup', COLLARS_PLUGIN_URL . 'assets/js/magnific-popup.js', array('jquery'), '', false );
	wp_enqueue_script( 'magnific-popup' );
}


// Add custom classes
$css_class              = $this->getExtraClass( $style );
$css_class             .= $this->getExtraClass( $align );
$css_class             .= $this->getExtraClass( $image_effect );
$css_class             .= $this->getExtraClass( $shadow );
// Add additional classes to images with popups
if ( $add_link == 'image_popup' ) {
	$css_class         .= $this->getExtraClass('with-popup image_popup');
} elseif ( $add_link == 'gallery_popup' ) {
	$css_class         .= $this->getExtraClass('with-popup gallery_popup');
} elseif ( $add_link == 'video_popup' ) {
	$css_class         .= $this->getExtraClass('with-popup iframe_popup');
}
$el_class               = $this->getExtraClass( $el_class );
$anim_class             = $this->getCSSAnimation($css_animation);
($css_animation != '' && $css_animation_delay != '') ? $anim_class .= $this->getExtraClass($css_animation_delay) : '';


// Set up image overlay
if ( $h_overlay != '' ) {
	$overlay_class = ' img_color_'.$h_overlay;
	$h_overlay = '<div class="img_overlay'.$overlay_class.'" style="background-color:'.$overlay_color.'"></div>';
} else {
	$h_overlay = '';
}

// Set up image
$img_id                 = preg_replace( '/[^\d]/', '', $image );
$img                    = wpb_getImageBySize( array(
								'attach_id' => $img_id,
								'thumb_size' => $img_size,
								'class' => 'twc_imb_img'
							) );
$img_output             = '<div class="twc_imb_image">'.$img['thumbnail'].$h_overlay.'</div>';


// Set up heading
$heading                = ($heading != '' ) ? '<div class="twc_imb_heading" style="color:'.$heading_color.'">'.$heading.'</div>' : '';


// Set up text
$text                   = ($text != '' ) ?  '<div class="twc_imb_text" style="color:'.$text_color.'">'.$text.'</div>' : '';


// Set up button hover state styles
if ( $b_bg_color != '' || $b_border_color != '' || $bh_bg_color != '' || $bh_border_color != '' ) {
	$b_cont          = $this->getExtraClass( 'b_cont' );
}
$bh_text_color          = ( $bh_text_color != '' ) ? 'data-hc="'.$bh_text_color.'"' : ' data-hc="'.$b_text_color.'"';
$bh_bg_color            = ( $bh_bg_color != '' ) ? 'data-hbgc="'.$bh_bg_color.'"' : ' data-hbgc="'.$b_bg_color.'"';
$bh_border_color        = ( $bh_border_color != '' ) ? 'data-hbc="'.$bh_border_color.'"' : ' data-hbc="'.$b_border_color.'"';
$bh_radius              = ( $bh_radius != '' ) ? 'data-hbr="'.$bh_radius.'"' : ' data-hbr="'.$b_radius.'"';
$bh_array               = array(' ', $bh_text_color, $bh_bg_color, $bh_border_color, $bh_radius);
$bh_styles              = implode(' ', array_filter($bh_array)).'"';

// Set up button styles
$b_text_color           = ( $b_text_color != '' ) ? 'color:'.$b_text_color : '';
$b_bg_color             = ( $b_bg_color != '' ) ? 'background-color:'.$b_bg_color : '';
$b_border_color         = ( $b_border_color != '' ) ? 'border-color:'.$b_border_color : '';
$b_radius               = ( $b_radius != '' ) ? 'border-radius:'.$b_radius : 'border-radius:0px';
$button_array           = array($b_text_color, $b_bg_color, $b_border_color, $b_radius);
$button_styles          = ' style="'.implode('; ', array_filter($button_array)).'"';
// Define button
$button = '<div class="twc_custom_button twc_imb_button'.$b_cont.'"'.$button_styles.$bh_styles.'>'.$button.'</div>';


// Set up image box link
if ( $add_link != '' ) {
	if ( $add_link == 'link' ) {
		// If regular link
		$link           = ($link=='||') ? '' : $link;
		$link           = vc_build_link($link);
		$a_href         = $link['url'];
		$a_title        = $link['title'];
		$a_target       = ($link['target'] != '') ? $link['target'] : '_self';
		$rel            = $link['rel'] !== '' ? ' rel="'.$link['rel'].'"' : '';

		if ( strlen( $link['url'] ) > 0 ) {
			$a_open     = '<a href="'.$a_href.'" title="'.$a_title.'" target="'.$a_target.'"'.$rel.'>';
			$a_close    = '</a>';
		}
	} elseif ( $add_link == 'image_popup' ) {
		// If popup with image
		$imgSrc         = wp_get_attachment_image_src($image, 'full');
		$imgSrc         = $imgSrc[0];

		$a_open         = '<a href="'.$imgSrc.'" data-type="image" data-image="'. $imgSrc .'">';
		$a_close        = '</a>';
	} elseif ( $add_link == 'gallery_popup' ) {
		$images         = explode( ',', $images );
		$imageSet       = array();

		foreach ( $images as $image ) {
			$imaSetSrc  = wp_get_attachment_image_src($image, 'full');
			$imgSetSrc  = $imaSetSrc[0];
			array_push($imageSet, $imgSetSrc);
		}

		$imageSet       = implode(",", $imageSet);
		$a_open         = '<a data-type="image" data-image="'. $imageSet .'">';
		$a_close        = '</a>';
	} elseif ( $add_link == 'video_popup' ) {
		$a_open         = '<a href="'.$iframe_link.'" data-type="iframe" data-image="'. $iframe_link .'">';
		$a_close        = '</a>';
	}


	// Add link to individual elements
	if ( $link_image == 'true' && $img_id != '' ) {
		$img_output     = $a_open . $img_output . $a_close;
	}
	if ( $link_heading == 'true' && $heading != '' ) {
		$heading        = $a_open . $heading . $a_close;
	}
	if ( $link_button == 'true' && $button != '' ) {
		$button         = $a_open . $button . $a_close;
	} else { $button = ''; }
}


// If minimalistic design
if ( in_array( $style, array('twc_imb_minimal', 'twc_imb_modern') ) ) {
	$button_alt         = $button;
	$button             = '';
}


// Set up main styles
$bg_color               = ( $bg_color != '' ) ? 'background-color:'.$bg_color : '';
if ( $style == 'twc_imb_modern' ) {
	$bg_color2          = ' style="'.$bg_color.'"';
	$bg_color           = '';
}
$border_color           = ( $border_color != '' ) ? 'border:1px solid '.$border_color : '';
$radius                 = ( $radius != '' ) ? 'border-radius:'.$radius : 'border-radius:0px';
$style_array            = array($bg_color, $border_color, $radius);
$main_styles            = ' style="'.implode('; ', array_filter($style_array)).'"';


// Output
$output .=  '<div class="twc_image_box'.$css_class.$anim_class.$el_class.'">';
$output .=      '<div class="twc_imb_inner"'.$main_styles.'>';
$output .=          '<div class="twc_imb_container">';
$output .=              '<div class="twc_imb_first">';
$output .=                  $img_output;
$output .=                  $button_alt;
$output .=              '</div>';

$output .=              '<div class="twc_imb_second"'.$bg_color2.'>';
$output .=                  $heading;
$output .=                  $text;
$output .=              '</div>';

$output .=              '<div class="twc_imb_third">';
$output .=                  $button;
$output .=              '</div>';

$output .=  '		</div>
				</div>
			</div>';

echo $output;
