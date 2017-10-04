<?php 

if(!( function_exists('ebor_check_variant_img_directory') )){
	function ebor_check_variant_img_directory(){
		$upload_dir = wp_upload_dir();
		$stack_key = $upload_dir['basedir'] . '/2017/04/variant_page_builder_key_stack.png';
		return ( file_exists($stack_key) ) ? 'true' : 'false';
	}
}

if(!( function_exists('ebor_get_variant_img_directory') )){
	function ebor_get_variant_img_directory(){
		$upload_dir = wp_upload_dir();
		return $upload_dir['baseurl'] . '/2017/04/';
	}
}

if(!( function_exists('ebor_check_variant_section_img_directory') )){
	function ebor_check_variant_section_img_directory(){
		return 'stack';
	}
}

if(!( function_exists('ebor_get_variant_sections') )){
	function ebor_get_variant_sections(){
		$sections = array(
			"accordion-image-1-bg", 
			"accordion-image-1", 
			"accordion-image-2-bg", 
			"accordion-image-2", 
			"accordion-map-1-bg", 
			"accordion-map-1", 
			"accordion-map-2-bg", 
			"accordion-map-2", 
			"accordion-slider-1-bg", 
			"accordion-slider-1", 
			"accordion-slider-2-bg", 
			"accordion-slider-2", 
			"accordion-video-1-bg", 
			"accordion-video-1", 
			"accordion-video-2-bg", 
			"accordion-video-2", 
			"account-create-1",  
			"account-login-1", 
			"account-recover", 
			"blog-list-simple", 
			"blog-list-simple-sidebar", 
			"blog-cards", 
			"blog-cards-sidebar", 
			"blog-cards-detailed", 
			"blog-cards-sidebar-detailed", 
			"blog-magazine", 
			"blog-magazine-simple", 
			"blog-row",
			"careers-1", 
			"cards-1", 
			"cards-2", 
			"carousel-logo", 
			"carousel-blog",
			"carousel-blog-fullwidth",
			"carousel-portfolio-1", 
			"carousel-portfolio-2", 
			"carousel-products-1", 
			'comments-1',
			"cover-countdown-1", 
			"cover-countdown-2", 
			"cover-features-1", 
			"cover-features-2", 
			"cover-form-1", 
			"cover-form-2", 
			"cover-form-3", 
			"cover-form-4", 
			"cover-form-search-1",
			"cover-image-1", 
			"cover-image-2", 
			"cover-image-3", 
			"cover-image-4", 
			"cover-image-5", 
			"cover-gradient-1", 
			"cover-gradient-2", 
			"cover-slider-1", 
			"cover-text-1", 
			"cover-text-2", 
			"cover-text-3", 
			"cover-text-4", 
			"cover-text-5", 
			"cover-text-typed-1",
			"cover-video-1", 
			"cover-video-2", 
			"cover-video-3", 
			"cover-video-4", 
			"cover-video-5", 
			"cover-video-6", 
			"cover-video-7", 
			"cta-avatar-1-bg", 
			"cta-avatar-1-gradient", 
			"cta-avatar-1", 
			"cta-button", 
			"cta-centered-1-bg", 
			"cta-centered-1-gradient", 
			"cta-centered-1", 
			"cta-centered-2-bg", 
			"cta-centered-2-gradient", 
			"cta-centered-2", 
			"cta-centered-3-bg", 
			"cta-centered-3-gradient", 
			"cta-centered-3", 
			"cta-horizontal-1-bg", 
			"cta-horizontal-1-gradient", 
			"cta-horizontal-1", 
			"cta-horizontal-2-bg", 
			"cta-horizontal-2-gradient", 
			"cta-horizontal-2", 
			"cta-horizontal-3-bg", 
			"cta-horizontal-3-gradient", 
			"cta-horizontal-3", 
			"error-500", 
			"features-large-1", 
			"features-large-2-bg", 
			"features-large-2", 
			"features-large-3-bg", 
			"features-large-3", 
			"features-large-4", 
			"features-large-5", 
			"features-large-6", 
			"features-large-7", 
			"features-large-8", 
			"features-large-9", 
			"features-large-10", 
			"features-large-11", 
			"features-large-12", 
			"features-large-13", 
			"features-large-14", 
			"features-small-1-bg", 
			"features-small-1", 
			"features-small-2-bg", 
			"features-small-2", 
			"features-small-3-bg", 
			"features-small-3", 
			"features-small-4-bg", 
			"features-small-4", 
			"features-small-5-bg", 
			"features-small-5", 
			"features-small-6-bg", 
			"features-small-6", 
			"features-small-7", 
			"features-small-8", 
			"features-small-9-bg", 
			"features-small-9", 
			"features-small-10", 
			"features-small-11-bg", 
			"features-small-11", 
			"features-small-12-bg", 
			"features-small-12", 
			"features-small-13-bg", 
			"features-small-13", 
			'features-small-14-bg',
			"features-small-14", 
			"form-simple-1-bg", 
			"form-simple-1", 
			"form-with-map-1-bg", 
			"form-with-map-1", 
			"form-with-text-1-bg", 
			"form-with-text-1", 
			"form-with-text-2", 
			"gallery-lightbox", 
			"gallery-projects-1", 
			"gallery-projects-2", 
			"gallery-projects-3", 
			"gallery-projects-4", 
			"gallery-projects-5", 
			"gallery-video-1", 
			//"in-page-navigator", 
			"instagram-feed-1-bg", 
			"instagram-feed-1", 
			"instagram-feed-2-bg", 
			"instagram-feed-2", 
			"instagram-feed-3", 
			"map-api-1", 
			"map-api-2", 
			"map-api-3", 
			"map-api-4", 
			"map-iframe-1", 
			"map-iframe-2", 
			"map-iframe-3", 
			"map-iframe-4", 
			"page-title-1-bg", 
			"page-title-1", 
			"page-title-2-bg", 
			"page-title-2", 
			"page-title-3-bg", 
			"page-title-3", 
			"planner-1-bg", 
			"planner-1-gradient", 
			"planner-1", 
			"planner-2-bg", 
			"planner-2-gradient", 
			"planner-2", 
			"pricing-feature-1-bg", 
			"pricing-feature-1", 
			"pricing-feature-2-bg", 
			"pricing-feature-2", 
			"pricing-feature-3-bg", 
			"pricing-feature-3", 
			"pricing-feature-5-bg", 
			"pricing-feature-5", 
			"pricing-plans-1-bg", 
			"pricing-plans-1", 
			"pricing-plans-2-bg", 
			"pricing-plans-2", 
			"pricing-plans-3-bg", 
			"pricing-plans-3", 
			"pricing-plans-4-bg", 
			"pricing-plans-4", 
			"process-1-bg", 
			"process-1", 
			"process-2-bg", 
			"process-2", 
			"process-3-bg", 
			"process-3", 
			"process-4-bg", 
			"process-4", 
			"process-5-bg", 
			"process-5", 
			"process-radial-1", 
			"process-radial-2", 
			"section-title-1-bg", 
			"section-title-1", 
			"signup-detailed-1", 
			"signup-detailed-2", 
			"signup-feature-1", 
			"signup-feature-2", 
			"signup-horizontal-1", 
			"signup-horizontal-2", 
			"signup-horizontal-3", 
			"sigunup-horizontal-1-bg", 
			"sigunup-horizontal-2-bg", 
			"sigunup-horizontal-3-bg", 
			"slider-images-lightbox", 
			"slider-images",
			"slider-images-full", 
			"slider-ken-burns",
			"slider-ken-burns-full", 
			"subscribe-boxed-1-bg", 
			"subscribe-boxed-1-gradient", 
			"subscribe-boxed-1", 
			"subscribe-boxed-2-bg", 
			"subscribe-boxed-2-gradient", 
			"subscribe-boxed-2", 
			"subscribe-horizontal-1-bg",
			"subscribe-horizontal-1-gradient", 
			"subscribe-horizontal-1", 
			"subscribe-horizontal-2-bg", 
			"subscribe-horizontal-2-gradient", 
			"subscribe-horizontal-2", 
			"subscribe-horizontal-3-bg", 
			"subscribe-horizontal-3-gradient", 
			"subscribe-horizontal-3", 
			"subscribe-horizontal-4-bg", 
			"subscribe-horizontal-4-gradient", 
			"subscribe-horizontal-4", 
			"subscribe-image-1-bg", 
			"subscribe-image-1-gradient", 
			"subscribe-image-1", 
			"subscribe-title-1-bg", 
			"subscribe-title-1-gradient", 
			"subscribe-title-1", 
			"subscribe-title-2-bg", 
			"subscribe-title-2-gradient", 
			"subscribe-title-2", 
			"subscribe-title-3-bg", 
			"subscribe-title-3-gradient", 
			"subscribe-title-3", 
			"subscribe-twitter-1-bg", 
			"subscribe-twitter-1-gradient", 
			"subscribe-twitter-1", 
			"subscribe-video-1", 
			"tabs-horizontal-1", 
			"tabs-horizontal-2", 
			"tabs-horiztonal-3", 
			"tabs-images-1", 
			"tabs-vertical-1", 
			"tabs-vertical-2", 
			"tabs-vertical-3", 
			"team-1", 
			"team-2", 
			"team-single",
			"team-carousel", 
			"testimonial-avatar-1-bg", 
			"testimonial-avatar-1", 
			"testimonial-avatar-2-bg", 
			"testimonial-avatar-2", 
			"testimonial-partners-1", 
			"testimonial-slider-1-bg", 
			"testimonial-slider-1", 
			"testimonial-slider-2-bg", 
			"testimonial-slider-2", 
			"text-layout-1-bg", 
			"text-layout-1", 
			"text-layout-2-bg", 
			"text-layout-2", 
			"text-layout-3-bg", 
			"text-layout-3", 
			"text-layout-4-bg", 
			"text-layout-4", 
			"text-layout-5-bg", 
			"text-layout-5", 
			"text-layout-6-bg", 
			"text-layout-6", 
			"text-layout-7", 
			"twitter-feed-1-bg", 
			"twitter-feed-1-gradient", 
			"twitter-feed-1", 
			"twitter-feed-2-bg", 
			"twitter-feed-2-gradient", 
			"twitter-feed-2", 
			"twitter-slider-1-bg", 
			"twitter-slider-1-gradient", 
			"twitter-slider-1", 
			"video-inline-1-bg", 
			"video-inline-1", 
			"video-inline-2-bg", 
			"video-inline-2", 
			"video-inline-3", 
			"video-inline-4-bg", 
			"video-inline-4", 
			"video-modal-1-bg", 
			"video-modal-1", 
			"video-modal-2", 
			"video-modal-3-bg", 
			"video-modal-3", 
			"video-modal-4", 
			"portfolio-titles-outside-1", 
			"portfolio-titles-outside-2", 
			"portfolio-titles-outside-3", 
			"portfolio-titles-inside-1", 
			"portfolio-titles-inside-2", 
			"portfolio-titles-inside-3", 
			"portfolio-titles-hover-1", 
			"portfolio-titles-hover-2", 
			"portfolio-titles-hover-3", 
			"portfolio-tiles", 
			"portfolio-squares", 
			"portfolio-fullscreen", 
			"portfolio-fullwidth-2", 
			"portfolio-fullwidth-3", 
			"shortcode-layout-1", 
			"shortcode-layout-2", 
			"shop-standard-columns-2",
			"shop-standard-columns-3",
			"shop-standard-columns-4",
			"shop-tiles-columns-2",
			"shop-tiles-columns-3",
			"shop-tiles-columns-4"
		);
		
		if( has_filter('variant_add_sections') ) {
			$sections = apply_filters('variant_add_sections', $sections);
		}
		
		return $sections;
	}
}

/**
 * Example function of how to add extra sections to this list from a child theme
 * Add the function below to your child theme, add your extra sections in a
 * /variant_templates/ folder in your child theme. DO NOT modify this parent theme directly.
 */
/*
function variant_add_extra_sections($sections) {
	//List your extra sections filenames (don't add .php)
	$extra_sections = array(
		'extra-example-section'
	);
 
	// combine the two arrays
	$sections = array_merge($extra_sections, $sections);
 
	return $sections;
}
add_filter('variant_add_sections', 'variant_add_extra_sections');
*/