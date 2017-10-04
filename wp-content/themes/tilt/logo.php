<?php
/*	
*	---------------------------------------------------------------------
*	TWC Template part: Logo
*	--------------------------------------------------------------------- 
*/
	

// Logo URLs	
$default_logo = ot_get_option('logo');
$retina_logo = ot_get_option('logo_retina');
$sticked_logo = ot_get_option('logo_sticked');
$sticked_retina_logo = ot_get_option('logo_retina_sticked');


$page_id = get_the_ID();

if ( is_front_page() && is_home() ) {
	// Default homepage
} elseif ( is_front_page() ) {
	// static homepage
} elseif ( class_exists( 'WooCommerce' ) && is_woocommerce() ) {
	$page_id = get_option( 'woocommerce_shop_page_id' );
} elseif ( is_home() || is_single() || is_category() || is_tax() ||  is_tag() || is_archive() || is_search() ) {
	$page_id = get_option('page_for_posts');
}

$page_header_id = $page_sticky_header_id = $page_id;

if ( !is_page() && is_single() && ot_get_option('post_header') == 'header-default' && (class_exists( 'Woocommerce' ) && !is_woocommerce()) && get_post_type( get_the_ID() ) != 'portfolio' ) {}
else {
	if ( get_post_type( get_the_ID() ) === 'portfolio' && !is_archive() && wp_kses_post(get_post_meta( get_the_ID(), 'meta_sticky_header', true )) === 'on' ) $page_header_id = get_the_ID();
	if ( wp_kses_post(get_post_meta( $page_header_id, 'meta_header', true )) == 'on' ) {
		(get_post_meta( $page_header_id, 'meta_logo', true )) ? $default_logo = get_post_meta( $page_header_id, 'meta_logo', true ) : '';
		(get_post_meta( $page_header_id, 'meta_logo_retina', true )) ? $retina_logo = get_post_meta( $page_header_id, 'meta_logo_retina', true ) : '';
	}

	if ( get_post_type( get_the_ID() ) === 'portfolio' && !is_archive() && wp_kses_post(get_post_meta( get_the_ID(), 'meta_sticky_header', true )) === 'on' ) $page_sticky_header_id = get_the_ID();
	if ( wp_kses_post(get_post_meta( $page_sticky_header_id, 'meta_sticky_header', true )) == 'on' ) {
		(get_post_meta( $page_sticky_header_id, 'meta_sticky_logo', true )) ? $sticked_logo = get_post_meta( $page_sticky_header_id, 'meta_sticky_logo', true ) : '';
		(get_post_meta( $page_sticky_header_id, 'meta_sticky_logo_retina', true )) ? $sticked_retina_logo = get_post_meta( $page_sticky_header_id, 'meta_sticky_logo_retina', true ) : '';
	}
}

if ($default_logo != ''){
	echo '  <a href="'. home_url() .'">
			<img src="'. esc_attr($default_logo) .'" alt="', esc_attr(bloginfo('name')) .'" class="default-logo" />';

	if ($retina_logo != ''){
		echo	'<img src="'. esc_attr($retina_logo) .'" alt="', esc_attr(bloginfo('name')) .'" class="retina-logo" />';
	} else {
		echo	'<img src="'. esc_attr($default_logo) .'" alt="', esc_attr(bloginfo('name')) .'" class="retina-logo" />';
	}

	if ( ot_get_option('sticky_header') == 'on' ) {
		if ($sticked_logo != '') {
			echo '<img src="'. esc_attr($sticked_logo) .'" alt="', esc_attr(bloginfo('name')) .'" class="sticked-logo" />';
			if ($sticked_retina_logo != '') {
				echo '<img src="'. esc_attr($sticked_retina_logo) .'" alt="', esc_attr(bloginfo('name')) .'" class="sticked-retina-logo" />';
			} else {
				echo '<img src="'. esc_attr($sticked_logo) .'" alt="', esc_attr(bloginfo('name')) .'" class="sticked-retina-logo" />';
			}
		} else {
			echo '<img src="'. esc_attr($default_logo) .'" alt="', esc_attr(bloginfo('name')) .'" class="sticked-logo" />';
			if ($sticked_retina_logo != '') {
				echo '<img src="'. esc_attr($sticked_retina_logo) .'" alt="', esc_attr(bloginfo('name')) .'" class="sticked-retina-logo" />';
			} else {
				echo '<img src="'. esc_attr($default_logo) .'" alt="', esc_attr(bloginfo('name')) .'" class="sticked-retina-logo" />';
			}
		}
	}

	echo '</a>';
} else {
	echo '<h1 class="site-title"><a href="'. esc_url(home_url()) .'" title="', esc_attr(bloginfo('name')) .'" rel="home">', bloginfo('name') .'</a></h1>';
}
