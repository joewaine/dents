<?php
/*
*	---------------------------------------------------------------------
*	Tilt Custom user styles
*	---------------------------------------------------------------------
*/

function collars_custom_css() {
	$custom_css = '';

	//Predefined colors for individual pages
	$accent_color = ot_get_option('accent_color');
	$curr_id = get_the_ID();

	$header_styles = ot_get_option('show_menu_styles');

	$header_bg = ot_get_option('header_bg');

	$menu_bottom_border = ot_get_option('menu_bottom_border');

	// Accent color (background-color)
	if ($accent_color !='') {
		$custom_css .= '
			.wpb_button.wpb_btn_themecolor span,
			.vc_icon_element-background.icon_bg_themecolor,
			.themecolor_bg,
			input[type=\'submit\'],
			th,
			#wp-calendar #today,
			.vc_progress_bar .vc_single_bar.bar_themecolor .vc_bar,
			#site-navigation .header_cart_button .cart_product_count,
			.woocommerce a.added_to_cart,.woocommerce-page a.added_to_cart,
			.header-search .search-input,
			.pricing-box .plan-badge,
			p.form-submit #submit,
			.post-arrows a,
			body.blog-tiled #content .read-more .excerpt-read-more:hover,
			body.blog-clear #content .read-more .excerpt-read-more:hover,

			.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active,
			#comments .comment-reply-link:hover,
			.owl-controls .owl-pagination .owl-page.active,
			.menu-container ul li.new:after,
			.woocommerce-MyAccount-content mark, .woocommerce-Address .edit

			{background-color:'. $accent_color .';}

			.wpb_button.wpb_btn_themecolor.wpb_btn-minimal:hover span,
			.wpb_btn_white:hover span,
			.tilt .esg-loader.spinner2,
			.woocommerce-MyAccount-navigation-link.is-active a
			{background-color:'. $accent_color .'!important;}

			.carousel-minimal .twc-controls .twc-buttons .twc-prev:hover svg, .carousel-minimal .twc-controls .twc-buttons .twc-next:hover svg, .scrollToTop:hover svg polygon {fill:'. $accent_color .';}';

		$custom_css .= '::selection{background-color:'. $accent_color .'; color: #fff; }::-moz-selection{background-color:'. $accent_color .'; color: #fff; }';

		// Header menu accent (color)
		$custom_css .= '
			#site-header #site-navigation .menu-container > ul > li:hover > a,
			#site-header #site-navigation .search_button:hover,
			#site-header #site-navigation .header_cart_link:hover,
			#site-header #site-navigation ul li.current-menu-item > a,
			#site-header #site-navigation ul li.current_page_parent > a,
			#site-header #site-navigation ul li.current-menu-ancestor > a,
			#site-header #site-navigation ul li.megamenu ul li.current-menu-item > a,
			#site-header #site-navigation ul li.megamenu ul li.current-page-parent > a,
			#site-header #site-navigation ul li.megamenu ul li.current-menu-ancestor > a,

			.tilt .esg-entry-cover .esg-center a:hover,
			.tilt .esg-entry-cover .esg-bottom a
			{color:'. $accent_color .' !important;}

			#site-navigation .menu-container ul li ul li a:hover,
			.twc_modal_window .modal-dialog .twc_mw_cont .twc_mw_header .twc_mw_close:hover,
			.menu-container .menu > .menu-item.button-accent > a
			{background-color:'. $accent_color .';}

			#site-header #site-navigation ul li ul li.current-menu-item > a:hover,
			#site-header #site-navigation ul li ul li.current_page_parent > a:hover,
			#site-header #site-navigation ul li.megamenu ul li.current-menu-item > a:hover,

			.tilt .esg-entry-cover .esg-bottom a:hover
			{color: #fff !important}
			';


		// Accent color (border-color)
		$custom_css .= '
			.wpb_button.wpb_btn_themecolor.wpb_btn-minimal span,
			input[type=\'submit\'],
			th,
			#comments .comment-reply-link:hover,
			#site-navigation,
			#site-navigation ul li ul,
			body.blog-tiled #content .read-more .excerpt-read-more:hover,
			body.blog-clear #content .read-more .excerpt-read-more:hover,
			.wpb_tabs.wpb_content_element.tabs_header .wpb_tabs_nav li.ui-tabs-active a,
			.tilt .eg-tilted-blog-wrapper .esg-media-cover-wrapper,
			#sidebar .widget_nav_menu ul li a:hover

			{border-color:'. $accent_color .';}

			#main #content article.format-status .status-text .entry-title,
			body.blog-clear #content article.post-entry .post-preview,
			#main #content article.format-quote .quoute-text,
			#main #content article.format-link .link-text,
			.vc_icon_element-outline.icon_bg_themecolor,
			.testimonials-style-3,
			.wpb_tour .wpb_tour_tabs_wrapper,
			blockquote,
			.woocommerce-MyAccount-navigation-link.is-active a

			{border-color:'. $accent_color .' !important;}
			';


		// Accent color (color)
		$custom_css .= '
			.widget-area .widget .tagcloud a:hover,
			.post-navigation a:hover
			{background-color:'. $accent_color .';}

			article.format-image .post-preview a:after
			{background-color:'. $accent_color .'; background-color:rgba('. collars_hex2rgb($accent_color) .', 0.75);}

			article.format-image .post-preview a:hover:after,
			article.format-image .post-preview a.touch-hover:after
			{background-color:'. $accent_color .'; background-color:rgba('. collars_hex2rgb($accent_color) .', 1);}

			a,
			.separator_container a:hover,
			.separator_wrapper .separator_container a i,
			.wpb_toggle.wpb_toggle_title_active:after, #content h4.wpb_toggle.wpb_toggle_title_active:after,

			.wpb_tabs.wpb_content_element .wpb_tabs_nav li.ui-tabs-active a,
			.wpb_tabs.wpb_content_element .wpb_tabs_nav li a:hover,
			.wpb_tour .wpb_tour_tabs_wrapper .wpb_tabs_nav li.ui-tabs-active a,
			.wpb_tour .wpb_tour_tabs_wrapper .wpb_tabs_nav li a:hover,
			.wpb_accordion .wpb_accordion_wrapper .wpb_accordion_header.ui-accordion-header-active a,
			.vc_icon_element-inner.icon_themecolor,

			#comments p.logged-in-as a:last-child,
			#main #content article.format-link .link-text a:hover,
			.tag-links a:hover,
			article.error404 .row-inner i:hover,
			#comments .comment-metadata a:hover,
			body.blog-tilt #content .read-more .excerpt-read-more:hover,
			body.blog-tiled #content article.post-entry .entry-meta-footer a:hover,
			body.blog-clear #content article.post-entry .entry-meta-footer a:hover,
			body.blog-tilt #content article.post-entry .entry-meta-footer a:hover,
			.wpb_button.wpb_btn_themecolor.wpb_btn-minimal span,
			.wpb_toggle:hover, #content h4.wpb_toggle:hover,
			.wpb_accordion .wpb_accordion_wrapper .wpb_accordion_header a:hover,
			.wpb_accordion .wpb_accordion_wrapper .ui-state-active:after,
			.testimonials-style-3 .testimonial-author span,
			.testimonials-style-4 .testimonial-author span,
			.team-style-3 .team_image .team-overlay .to-inner figcaption .team_social a:hover,
			.tilt .esg-filterbutton.selected,
			.tilt .eg-tilted-blog-wrapper .esg-content:last-child a,
			.tilt .eg-tilted-blog-wrapper .esg-content a:hover,
			.tilt .eg-tilted-blog-single-wrapper .esg-content a:hover,
			#sidebar .widget_nav_menu ul li a:hover,
			.blog article.post-entry h1.entry-title a:hover,
			article.post-entry h1.entry-title a:hover,
			.woocommerce .widget_shopping_cart ul li .quantity .amount, .woocommerce-page .widget_shopping_cart ul li .quantity .amount

			{color:'. $accent_color .';}
			';
	}

	// Accent color WooCommerce
	if (class_exists( 'WooCommerce' )){
		$custom_css .= '


			#site-header #site-navigation .header_cart_widget .woocommerce ul li:hover a:not(.remove),
			#site-navigation .header_cart_widget .woocommerce .buttons a:first-child:hover,
			.woocommerce .widget_shopping_cart .buttons a:first-child:hover, .woocommerce-page .widget_shopping_cart .buttons a:first-child:hover,
			.widget_shopping_cart .header_cart_widget .woocommerce ul li .quantity .amount,
			.woocommerce ul li.product-category:hover h3,
			.woocommerce ul li.product-category:hover h3 mark,
			.woocommerce ul.products li.product .product-inner .star-rating span:before, .woocommerce-page ul.products li.product .product-inner .star-rating span:before,
			.woocommerce .cart-collaterals .shipping_calculator h2 a:hover, .woocommerce-page .cart-collaterals .shipping_calculator h2 a:hover,
			.widget a:not(.button):hover,
			.woocommerce table.cart .cart_item .product-name a:hover, .woocommerce-page #content table.cart .cart_item .product-name a:hover,
			.woocommerce #content div.product .product_meta a, .woocommerce-page #content div.product .product_meta a,
			.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active,
			.woocommerce .star-rating span:before, .woocommerce-page .star-rating span:before,
			.woocommerce #order_review tr.order-total td,
			.woocommerce-info a

			{color:'. $accent_color .';}
		';

		$custom_css .= '
			.woocommerce a.button,
			.woocommerce button.button,
			.woocommerce input.button,
			.woocommerce #respond input#submit,
			.woocommerce #content input.button,
			.woocommerce-page a.button,
			.woocommerce-page button.button,
			.woocommerce-page input.button,
			.woocommerce-page #respond input#submit,
			.woocommerce-page #content input.button,
			.woocommerce a.button.alt,
			.woocommerce button.button.alt,
			.woocommerce input.button.alt,
			.woocommerce #respond input#submit.alt,
			.woocommerce #content input.button.alt,
			.woocommerce-page a.button.alt,
			.woocommerce-page button.button.alt,
			#site-navigation .header_cart_widget .woocommerce .buttons a:last-child:hover,
			.woocommerce .widget_shopping_cart .buttons a:last-child:hover, .woocommerce-page .widget_shopping_cart .buttons a:last-child:hover,
			.woocommerce-page input.button.alt,
			.woocommerce-page #respond input#submit.alt,
			.woocommerce-page #content input.button.alt,
			.woocommerce .widget_price_filter .ui-slider-horizontal .ui-slider-range, .woocommerce-page .widget_price_filter .ui-slider-horizontal .ui-slider-range,
			.woocommerce-message a.button

			{background-color:'. $accent_color .';}
		';

		$custom_css .= '
			.woocommerce nav.woocommerce-pagination ul li span.current,
			.woocommerce nav.woocommerce-pagination ul li a:hover,
			.woocommerce nav.woocommerce-pagination ul li a:focus,
			.woocommerce #content nav.woocommerce-pagination ul li span.current,
			.woocommerce #content nav.woocommerce-pagination ul li a:hover,
			.woocommerce #content nav.woocommerce-pagination ul li a:focus,
			.woocommerce-page nav.woocommerce-pagination ul li span.current,
			.woocommerce-page nav.woocommerce-pagination ul li a:hover,
			.woocommerce-page nav.woocommerce-pagination ul li a:focus,
			.woocommerce-page #content nav.woocommerce-pagination ul li span.current,
			.woocommerce-page #content nav.woocommerce-pagination ul li a:hover,
			.woocommerce-page #content nav.woocommerce-pagination ul li a:focus

			{background-color:'. $accent_color .';}
		';
	}


	// Layout & Content width
	if( ot_get_option('layout_style') == 'boxed' ){
		$layout_width = ot_get_option('content_width', '1200');
		$custom_css .= '#wrapper{max-width:'. $layout_width .'px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.2); -moz-box-shadow: 0 0 20px rgba(0, 0, 0, 0.2); -webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);}';
		$custom_css .= '#header-wrapper{max-width:'. $layout_width .'px;}';
	}

	if( ot_get_option('layout_style') != 'boxed' && ot_get_option('header_style') == 'fixed-width'){
		$custom_css .= '#top-bar-wrapper{padding:0px;}';
		$custom_css .= '#site-header #header-container, #top-bar{max-width:'. ot_get_option('content_width', '1200') .'px; }';
		$custom_css .= '#topleft-widget-area{padding-left:0px;} #topright-widget-area{padding-right:0px;}';
	}

	$row_width = ot_get_option('content_width', '1200');
	$custom_css .= '.row-inner, .row-wrapper {max-width:'. $row_width .'px;}';

	$custom_css .= '#container.no-sidebar.no-vc, #container.row-inner, .site-info .row-inner, .page-header .row-inner{max-width:'. ot_get_option('content_width', '1200') .'px;}';

	// Body type
	$body_font = ot_get_option('body_font');

	$body_font_styles = array(
		( ! empty( $body_font['font-family'] ) ) ? 'font-family: \''. str_replace("+", " ", $body_font['font-family']) .'\'' : 'font-family: Open Sans, Helvetica, Arial, sans-serif',
		( ! empty( $body_font['font-weight'] ) ) ? 'font-weight:'. $body_font['font-weight'] : null,
		( ! empty( $body_font['font-style'] ) ) ? 'font-style:'. $body_font['font-style'] : null,
		( ! empty( $body_font['line-height'] ) ) ? 'line-height:'. $body_font['line-height'] : null,
		( ! empty( $body_font['letter-spacing'] ) ) ? 'letter-spacing:'. $body_font['letter-spacing'] : null,
		( ! empty( $body_font['text-transform'] ) ) ? 'text-transform:'. $body_font['text-transform'] : null,
		'color:'. ot_get_option('body_text_color', '#81898f'),
		'font-size:'. ot_get_option('body_size', '14px')
	);

	$body_font_style = implode('; ', array_filter($body_font_styles));
	$custom_css .= 'body{'.$body_font_style.'}';

	$custom_css .= ( ! empty( $body_font['font-family'] ) ) ? 'select, input, textarea, .wpb_button{font-family: \''. str_replace("+", " ", $body_font['font-family']) .'\'}' : 'select, input, textarea, .wpb_button{font-family:Open Sans}';

	// Menu type
	$custom_css .= (ot_get_option('menu_font_size') != '') ?'#site-header #site-navigation .menu-container > ul > li > a {font-size:'. ot_get_option('menu_font_size') .' !important;}' : '';
	$menu_font = ot_get_option('menu_font');
	( ! empty( $menu_font['font-family'] ) ) ? $menu_font_family = $menu_font['font-family'] : $menu_font_family = 'Open Sans';
	$menu_font_family = str_replace("+", " ", $menu_font_family);

	$custom_css .= '#site-navigation{font-family: \''. $menu_font_family .'\' , sans-serif;}';

	if ( ! empty( $menu_font ) ){
		$menu_font_styles = array(
			( ! empty( $menu_font['font-weight']) )? 'font-weight:'. $menu_font['font-weight'] : null,
			( ! empty( $menu_font['font-style'] ) ) ? 'font-style:'. $menu_font['font-style'] : null,
			( ! empty( $menu_font['letter-spacing'] ) ) ? 'letter-spacing:'. $menu_font['letter-spacing'] : null,
			( ! empty( $menu_font['text-transform'] ) ) ? 'text-transform:'. $menu_font['text-transform'] : null,

		);

		$menu_font_style = implode('; ', array_filter($menu_font_styles));
		$custom_css .= '#site-navigation ul li{'.$menu_font_style.'}';
	}


	// Heading type
	$heading_font = ot_get_option('heading_font');
	$heading_font_styles = array(
		( ! empty( $heading_font['font-family'] ) ) ? 'font-family: \''. str_replace("+", " ", $heading_font['font-family']) .'\'' : 'font-family: Open Sans, Helvetica, Arial, sans-serif',
		( ! empty( $heading_font['font-weight'] ) ) ? 'font-weight:'. $heading_font['font-weight'] : null,
		( ! empty( $heading_font['font-style'] ) ) ? 'font-style:'. $heading_font['font-style'] : null,
		( ! empty( $heading_font['line-height'] ) ) ? 'line-height:'. $heading_font['line-height'] : null,
		( ! empty( $heading_font['letter-spacing'] ) ) ? 'letter-spacing:'. $heading_font['letter-spacing'] : null,
		( ! empty( $heading_font['text-transform'] ) ) ? 'text-transform:'. $heading_font['text-transform'] : null,
	);
	$heading_font_style = implode('; ', array_filter($heading_font_styles));
	$custom_css .= 'h1, h2, h3, h4, h5, h6 {'.$heading_font_style.'}';


	// Post heading type
	$post_content_font = ot_get_option('post_heading_font');
	$post_content_font_styles = array(
		( ! empty( $post_content_font['font-family'] ) ) ? 'font-family: \''. str_replace("+", " ", $post_content_font['font-family']) .'\'' : 'font-family: Open Sans, Helvetica, Arial, sans-serif',
		( ! empty( $post_content_font['font-weight'] ) ) ? 'font-weight:'. $post_content_font['font-weight'] : null,
		( ! empty( $post_content_font['font-style'] ) ) ? 'font-style:'. $post_content_font['font-style'] : null,
		( ! empty( $post_content_font['line-height'] ) ) ? 'line-height:'. $post_content_font['line-height'] : null,
		( ! empty( $post_content_font['letter-spacing'] ) ) ? 'letter-spacing:'. $post_content_font['letter-spacing'] : null,
		( ! empty( $post_content_font['text-transform'] ) ) ? 'text-transform:'. $post_content_font['text-transform'] : null,
	);
	$post_content_font_style = implode('; ', array_filter($post_content_font_styles));
	$custom_css .= '.post-entry-header h1.entry-title, .post-entry-header h2.entry-title, h2.entry-title {'.$post_content_font_style.'}';


	// Post content type
	$post_content_font = ot_get_option('post_content_font');
	$post_content_font_styles = array(
		( ! empty( $post_content_font['font-family'] ) ) ? 'font-family: \''. str_replace("+", " ", $post_content_font['font-family']) .'\'' : 'font-family: Open Sans, Helvetica, Arial, sans-serif',
		( ! empty( $post_content_font['font-weight'] ) ) ? 'font-weight:'. $post_content_font['font-weight'] : null,
		( ! empty( $post_content_font['font-style'] ) ) ? 'font-style:'. $post_content_font['font-style'] : null,
		( ! empty( $post_content_font['line-height'] ) ) ? 'line-height:'. $post_content_font['line-height'] : null,
		( ! empty( $post_content_font['letter-spacing'] ) ) ? 'letter-spacing:'. $post_content_font['letter-spacing'] : null,
		( ! empty( $post_content_font['text-transform'] ) ) ? 'text-transform:'. $post_content_font['text-transform'] : null,
	);
	$post_content_font_style = implode('; ', array_filter($post_content_font_styles));
	$custom_css .= 'article.post-entry .entry-summary p, article.post-entry .entry-content p {'.$post_content_font_style.'}';


	// Visual Composer heading type
	$vc_heading_font = ot_get_option('vc_heading_font');
	$vc_heading_font_styles = array(
		( ! empty( $vc_heading_font['font-family'] ) ) ? 'font-family: \''. str_replace("+", " ", $vc_heading_font['font-family']) .'\'' : 'font-family: Open Sans, Helvetica, Arial, sans-serif',
		( ! empty( $vc_heading_font['font-weight'] ) ) ? 'font-weight:'. $vc_heading_font['font-weight'] : null,
		( ! empty( $vc_heading_font['font-style'] ) ) ? 'font-style:'. $vc_heading_font['font-style'] : null,
		( ! empty( $vc_heading_font['line-height'] ) ) ? 'line-height:'. $vc_heading_font['line-height'] : null,
		( ! empty( $vc_heading_font['letter-spacing'] ) ) ? 'letter-spacing:'. $vc_heading_font['letter-spacing'] : null,
		( ! empty( $vc_heading_font['text-transform'] ) ) ? 'text-transform:'. $vc_heading_font['text-transform'] : null,
	);
	$vc_heading_font_style = implode('; ', array_filter($vc_heading_font_styles));
	$custom_css .= '
		.heading_wrapper .heading_title,
		.heading_wrapper.h-large .heading_title,
		.heading_wrapper.h-extralarge .heading_title
		{'.$vc_heading_font_style.'}';

	$vc_heading_font_sub = ot_get_option('vc_heading_font_sub');
	$vc_heading_font_sub_styles = array(
		( ! empty( $vc_heading_font_sub['font-family'] ) ) ? 'font-family: \''. str_replace("+", " ", $vc_heading_font_sub['font-family']) .'\'' : 'font-family: Open Sans, Helvetica, Arial, sans-serif',
		( ! empty( $vc_heading_font_sub['font-weight'] ) ) ? 'font-weight:'. $vc_heading_font_sub['font-weight'] : null,
		( ! empty( $vc_heading_font_sub['font-style'] ) ) ? 'font-style:'. $vc_heading_font_sub['font-style'] : null,
		( ! empty( $vc_heading_font_sub['line-height'] ) ) ? 'line-height:'. $vc_heading_font_sub['line-height'] : null,
		( ! empty( $vc_heading_font_sub['letter-spacing'] ) ) ? 'letter-spacing:'. $vc_heading_font_sub['letter-spacing'] : null,
		( ! empty( $vc_heading_font_sub['text-transform'] ) ) ? 'text-transform:'. $vc_heading_font_sub['text-transform'] : null,
	);
	$vc_heading_font_sub_styles = implode('; ', array_filter($vc_heading_font_sub_styles));
	$custom_css .= '
		.heading_wrapper .heading_subtitle,
		.heading_wrapper.h-large .heading_subtitle,
		.heading_wrapper.h-extralarge .heading_subtitle
		{'.$vc_heading_font_sub_styles.'}';



	// Widget type
	$widget_font = ot_get_option('widget_font');

	$widget_font_styles = array(
		( ! empty( $widget_font['font-family'] ) ) ? 'font-family: \''. str_replace("+", " ", $widget_font['font-family']) .'\'' : 'font-family: Open Sans, Helvetica, Arial, sans-serif',
		( ! empty( $widget_font['font-weight'] ) ) ? 'font-weight:'. $widget_font['font-weight'] : null,
		( ! empty( $widget_font['font-style'] ) ) ? 'font-style:'. $widget_font['font-style'] : null,
		( ! empty( $widget_font['line-height'] ) ) ? 'line-height:'. $widget_font['line-height'] : null,
		( ! empty( $widget_font['letter-spacing'] ) ) ? 'letter-spacing:'. $widget_font['letter-spacing'] : null,
		( ! empty( $widget_font['text-transform'] ) ) ? 'text-transform:'. $widget_font['text-transform'] : null,

	);

	$widget_font_style = implode('; ', array_filter($widget_font_styles));
	$custom_css .= '.widget .widget-title{'.$widget_font_style.'}';

	// Get right ID
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

	// Check if custom menu styles enabled
	if ($header_styles == 'on' && wp_kses_post(get_post_meta( $page_id, 'meta_header', true )) != 'on') {

		// Header style
		($header_bg != '') ? $custom_css .= '#site-header.menu-light #header-wrapper, #site-header.menu-dark #header-wrapper {background-color:'. $header_bg .';}' : '';

		// Menu style
		(ot_get_option('default_menu_link') != '') ? $custom_css .= '
			#site-header.menu-dark #site-logo .site-title a, #site-header.menu-light #site-logo .site-title a,
			#site-header.menu-dark #site-navigation .menu-container > ul > li > a, #site-header.menu-light #site-navigation .menu-container > ul > li > a,
			#site-header.menu-dark #site-navigation .search_button, #site-header.menu-light #site-navigation .search_button,
			#site-header #site-navigation .header_cart_button,
			.toggle-mobile-menu i
			{color:'. ot_get_option('default_menu_link') .'}' : '';
		(ot_get_option('default_menu_link_h') != '') ? $custom_css .= '
			#site-header.menu-dark #site-navigation .menu-container > ul > li:not(.current_page_item):hover > a, #site-header.menu-light #site-navigation .menu-container > ul > li:not(.current_page_item):hover > a,
			#site-header.menu-dark #site-navigation .search_button:hover , #site-header.menu-light #site-navigation .search_button:hover ,
			#site-header #site-navigation .header_cart_wrapper:hover .header_cart_button
			{color:'. ot_get_option('default_menu_link_h') .'!important}' : '';
		(ot_get_option('menu_hover_bg') != '') ? $custom_css .= '
			#site-header #site-navigation .menu-container > ul > li:hover > a {background-color:'. ot_get_option('menu_hover_bg'). '}' : '';
		($menu_bottom_border != '') ? $custom_css .= '
			#site-header #header-wrapper
			{border-bottom:1px solid '. $menu_bottom_border . '}' : '';
	}

	(ot_get_option('header_shadow') == 'on') ? $custom_css .= '
		#site-header #header-wrapper
		{
		-webkit-box-shadow: 0px 2px 3px 0 rgba(0,0,0,.2);
		-moz-box-shadow: 0px 2px 3px 0 rgba(0,0,0,.2);
		box-shadow: 0px 2px 3px 0 rgba(0,0,0,.2);
		}' : '';


	// Check if custom submenu styles enabled
	if (ot_get_option('show_submenu_styles') == 'on') {

		// Submenu style
		(ot_get_option('submenu_background') != '') ? $custom_css .= '
			#site-header.submenu-dark #site-navigation .menu-container > ul > li > ul, 	#site-header.submenu-light #site-navigation .menu-container > ul > li > ul
			{background-color:'. ot_get_option('submenu_background'). '}' : '';
		(ot_get_option('submenu_link_color') != '') ? $custom_css .= '
			#site-header.submenu-dark #site-navigation .menu-container > ul > li > ul li a, #site-header.submenu-light #site-navigation .menu-container > ul > li > ul li a
			{color:'. ot_get_option('submenu_link_color'). '}' : '';
		(ot_get_option('submenu_link_hover_color') != '') ? $custom_css .= '
			#site-header.submenu-dark #site-navigation .menu-container > ul > li.megamenu > ul > li > ul > li > a:hover, #site-header.submenu-light #site-navigation .menu-container > ul > li.megamenu > ul > li > ul > li a:hover,
			#site-header.submenu-dark #site-navigation .menu-container > ul > li:not(.megamenu) > ul > li  a:hover, #site-header.submenu-light #site-navigation .menu-container > ul > li:not(.megamenu) > ul > li a:hover,
			#site-header #site-navigation .menu-container > ul > li:not(.megamenu) > .sub-menu > li.current-menu-ancestor > a:hover,
			#site-navigation .menu-container ul li ul li:not(.menu-item-has-children) a:hover
			{color:'. ot_get_option('submenu_link_hover_color'). '!important}' : '';
		(ot_get_option('submenu_hover_bg') != '') ? $custom_css .= '
			#site-header.submenu-dark #site-navigation .menu-container > ul > li.megamenu > ul > li > ul > li > a:hover, #site-header.submenu-light #site-navigation .menu-container > ul > li.megamenu > ul > li > ul > li a:hover,
			#site-header.submenu-dark #site-navigation .menu-container > ul > li:not(.megamenu) > ul > li  a:hover, #site-header.submenu-light #site-navigation .menu-container > ul > li:not(.megamenu) > ul > li a:hover,
			#site-navigation .menu-container ul li ul li:not(.menu-item-has-children) a:hover
			{background-color:'. ot_get_option('submenu_hover_bg'). '!important}' : '';
		(ot_get_option('megamenu_separator_color') != '') ? $custom_css .= '
			#site-header.submenu-dark #site-navigation .menu-container > ul > li.megamenu > ul > li, #site-header.submenu-light #site-navigation .menu-container > ul > li.megamenu > ul > li
			{border-right-color:'. ot_get_option('megamenu_separator_color'). '}' : '';
	}

	// Header height
	$logo_height = intval(ot_get_option('retina_logo_height'));
	$logo_height = $logo_height !== 0 ? $logo_height . 'px' : '';

	$logo_width = intval(ot_get_option('retina_logo_width'));
	$logo_width = $logo_width !== 0 ? $logo_width . 'px' : '';

	$logo_height_sticky = intval(ot_get_option('retina_logo_height_sticked'));
	$logo_height_sticky = $logo_height_sticky !== 0 ? $logo_height_sticky . 'px' : '';

	$logo_width_sticky = intval(ot_get_option('retina_logo_width_sticked'));
	$logo_width_sticky = $logo_width_sticky !== 0 ? $logo_width_sticky . 'px' : '';

	(ot_get_option('header_height') != '') ? $custom_css .= '
		#site-header #header-container {height:'. ot_get_option('header_height') .';}
		#site-navigation .menu-container ul li a, #site-navigation .search_button, #site-navigation .header_cart_link, #site-logo .site-title{line-height:'. intval(ot_get_option('header_height')) .'px;}
		#site-logo img {height:'.$logo_height.'} #site-logo img {width:'.$logo_width.'}
		#site-navigation .menu-container ul li.button {margin-top:' . (intval(ot_get_option('header_height'))-36)/2 . 'px}' : '';

	// Header styling
	$header_page_id = $header_sticky_page_id = $page_id;
	if ( !is_page() && is_single() && ot_get_option('post_header') == 'header-default' && (class_exists( 'Woocommerce' ) && !is_woocommerce()) && get_post_type( get_the_ID() ) != 'portfolio' ) {
		// do nothing
	} else {
		// Header
		if ( get_post_type( get_the_ID() ) === 'portfolio' && !is_archive() && wp_kses_post(get_post_meta( get_the_ID(), 'meta_header', true )) == 'on' ) $header_page_id = get_the_ID();
		if ( wp_kses_post(get_post_meta( $header_page_id, 'meta_header', true )) == 'on') {
				$custom_css .= '#site-header.menu-light #header-wrapper {background-color: #fff; background-color:rgba( 255,255,255, '.get_post_meta( $header_page_id, 'meta_menu_opacity', true ) / 100 .');}';
				$custom_css .= '#site-header.menu-dark #header-wrapper {background-color: #262628; background-color:rgba( 33, 33, 38, '.get_post_meta( $header_page_id, 'meta_menu_opacity', true ) / 100 .');}';
		} else {
			if ( $header_bg !='' && ot_get_option('show_menu_styles') == 'on' ) {
				$custom_css .= '#site-header #header-wrapper {background-color:'. $header_bg .'; background-color:rgba('. collars_hex2rgb($header_bg) .', '.ot_get_option('sticky_menu_opacity', '100') / 100 .');}';
			} else {
				$custom_css .= '#site-header.menu-light #header-wrapper {background-color: #fff; background-color:rgba( 255,255,255, '.ot_get_option('menu_opacity', '100') / 100 .');}';
				$custom_css .= '#site-header.menu-dark #header-wrapper {background-color: #262628; background-color:rgba( 33, 33, 38, '.ot_get_option('menu_opacity', '100') / 100 .');}';
			}
		}

		// Sticky header
		if ( get_post_type( get_the_ID() ) === 'portfolio' && !is_archive() && wp_kses_post(get_post_meta( get_the_ID(), 'meta_sticky_header', true )) == 'on' ) $header_sticky_page_id = get_the_ID();
		if ( wp_kses_post(get_post_meta( $header_sticky_page_id, 'meta_sticky_header', true )) == 'on') {
				$custom_css .= '#site-header.sticked-menu-light #header-wrapper.header-sticked {background-color: #fff; background-color:rgba( 255,255,255, '.get_post_meta( $header_sticky_page_id, 'meta_sticky_menu_opacity', true ) / 100 .');}';
				$custom_css .= '#site-header.sticked-menu-dark #header-wrapper.header-sticked {background-color: #262628; background-color:rgba( 33, 33, 38, '.get_post_meta( $header_sticky_page_id, 'meta_sticky_menu_opacity', true ) / 100 .');}';
		} elseif ( ot_get_option('sticky_header') == 'on' ) {
			if ( $header_bg !='' && ot_get_option('show_menu_styles') == 'on' ) {
				$custom_css .= '#site-header #header-wrapper.header-sticked {background-color:'. $header_bg .'; background-color:rgba('. collars_hex2rgb($header_bg) .', '.ot_get_option('sticky_menu_opacity', '100') / 100 .');}';
			} else {
				(ot_get_option('sticky_menu_style') == 'sticked-light') ? $custom_css .= '#site-header #header-wrapper.header-sticked {background-color: #fff; background-color:rgba( 255,255,255, '.ot_get_option('sticky_menu_opacity', '100') / 100 .');}' : '';
				(ot_get_option('sticky_menu_style') == 'sticked-dark') ? $custom_css .= '#site-header #header-wrapper.header-sticked {background-color: #262628; background-color:rgba( 33, 33, 38, '.ot_get_option('sticky_menu_opacity', '100') / 100 .');}' : '';
			}
		}
	}

	// Sticky header height
	if ( ot_get_option('sticky_header') == 'on' ) {
		(ot_get_option('sticky_header_height') != '') ? $custom_css .= '
			.sticky-enabled #header-wrapper.header-sticked #header-container {height:'. intval(ot_get_option('sticky_header_height')) .'px;}
			.sticky-enabled #header-wrapper.header-sticked #site-navigation .menu-container > ul > li > a, .sticky-enabled #header-wrapper.header-sticked #site-navigation .search_button, .sticky-enabled #header-wrapper.header-sticked #site-navigation .header_cart_link, .sticky-enabled #header-wrapper.header-sticked #site-logo .site-title{line-height:'. intval(ot_get_option('sticky_header_height')) .'px;}
			.sticky-enabled #header-wrapper.header-sticked #site-logo img {height:'.$logo_height_sticky.'; width:'.$logo_width_sticky.';}
			.sticky-enabled #header-wrapper.header-sticked #site-navigation .menu-container ul li.button {margin-top:' . (intval(ot_get_option('sticky_header_height'))-36)/2 . 'px}' : '';
		(ot_get_option('logo_top_sticked') != '') ? $custom_css .= '.sticky-enabled #header-wrapper.header-sticked #site-logo {margin-top:'. intval(ot_get_option('logo_top_sticked')) .'px}' : '';
		(ot_get_option('logo_left_sticked') != '') ? $custom_css .= '.sticky-enabled #header-wrapper.header-sticked #site-logo {margin-left:'. intval(ot_get_option('logo_left_sticked')) .'px}' : '';
	}

	// Top bar style
	(ot_get_option('top_bar_bg') != '') ? $custom_css .= '#top-bar-wrapper{background:'. ot_get_option('top_bar_bg') .'}' : '';
	(ot_get_option('top_bar_text_color') != '') ? $custom_css .= '#top-bar-wrapper, #top-bar-wrapper a, #top-bar ul li ul li a:after{color:'. ot_get_option('top_bar_text_color') .'}' : '';
	(ot_get_option('top_bar_link_hover') != '') ? $custom_css .= '#top-bar-wrapper a:hover{color:'. ot_get_option('top_bar_link_hover') .'}' : '';

	// Logo
	(ot_get_option('logo_top') != '') ? $custom_css .= '#site-header.menu-dark #site-logo, #site-header.menu-light #site-logo {margin-top:'. intval(ot_get_option('logo_top')) .'px}' : '';
	(ot_get_option('logo_left') != '') ? $custom_css .= '#site-header.menu-dark #site-logo, #site-header.menu-light #site-logo {margin-left:'. intval(ot_get_option('logo_left')) .'px}' : '';
	(ot_get_option('logo_retina') != '') ? $custom_css .= '#site-logo img.retina-logo{width:'.$logo_width.'; height:'.$logo_height.';}' : '';

	//Submenu animation duration
	$anim_duration = ot_get_option('anim_duration') / 1000;
	($anim_duration != '') ? $custom_css .= '#site-navigation .menu-container > ul > li > .sub-menu {transition-duration:'. $anim_duration .'s !important; -webkit-transition-duration:'. $anim_duration .'s !important}' : '';

	// Mobile menu
	(ot_get_option('mmenu_bg') != '') ? $custom_css .= '.mm-menu { background:'. ot_get_option('mmenu_bg') .';}' : '';
	(ot_get_option('mmenu_header') != '') ? $custom_css .= '.mm-menu .mm-header {background-color:'. ot_get_option('mmenu_header') .'}' : '';
	(ot_get_option('mmenu_color') != '') ? $custom_css .= '.mm-menu {color:'. ot_get_option('mmenu_color') .'}' : '';

	// Width at which menu should switch to mobile version
	$m_breakpoint = (ot_get_option('switch_to_mobile') != '') ? ot_get_option('switch_to_mobile') : '768px';
	$custom_css .= '@media only screen and (max-width : '. $m_breakpoint .') { .toggle-mobile-menu {display: block} #site-navigation {display:none} }';

	// Headings
	(ot_get_option('h1') != '') ? $custom_css .= 'h1 {font-size:'. ot_get_option('h1') .'}' : '';
	(ot_get_option('h2') != '') ? $custom_css .= 'h2 {font-size:'. ot_get_option('h2') .'}' : '';
	(ot_get_option('h3') != '') ? $custom_css .= 'h3 {font-size:'. ot_get_option('h3') .'}' : '';
	(ot_get_option('h4') != '') ? $custom_css .= 'h4 {font-size:'. ot_get_option('h4') .'}' : '';
	(ot_get_option('h5') != '') ? $custom_css .= 'h5 {font-size:'. ot_get_option('h5') .'}' : '';
	(ot_get_option('h6') != '') ? $custom_css .= 'h6 {font-size:'. ot_get_option('h6') .'}' : '';
	(ot_get_option('headings_color') != '') ? $custom_css .= '
		h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a,
		.woocommerce-page.woocommerce-cart .cart-empty,
		#site-navigation .header_cart_widget .woocommerce .buttons a,
		#site-navigation .header_cart_widget .woocommerce .total
		{color:'. ot_get_option('headings_color') .'}' : '';

	// Content style
	(ot_get_option('link_color') != '') ? $custom_css .= 'a {color:'. ot_get_option('link_color') .'}' : '';
	(ot_get_option('link_hover_color') != '') ? $custom_css .= '
		a:hover	{color:'. ot_get_option('link_hover_color') .'}' : '';

	// Page background
	(ot_get_option('page_background') != '') ? $custom_css .= '#wrapper {background-color:'. ot_get_option('page_background') .'}' : '';

	// Body background
	$body_bg = ot_get_option('body_background');
	if ( ot_get_option('layout_style') === 'boxed') {
		if (  ot_get_option('use_pattern') === 'on' ) {
			if ( ! empty( $body_bg ) ){
				$body_styles = array(
					( ! empty( $body_bg['background-color'] ) ) ? 'background-color:'. $body_bg['background-color'] : null,
					( ! empty( $body_bg['background-position'] ) ) ? 'background-position:'. $body_bg['background-position'] : 'background-position:center',
					( ! empty( $body_bg['background-attachment'] ) ) ? 'background-attachment:'. $body_bg['background-attachment'] : null,
				);

				$body_styles = implode('; ', array_filter($body_styles));
				$custom_css .= 'body{'.$body_styles.'}';
			}

			$custom_css .= 'body{background-image: url('. COLLARS_URI .'/library/images/patterns/'. ot_get_option('background_pattern') .'.png);}';
		} else {
			if ( ! empty( $body_bg ) ){
				$body_styles = array(
					( ! empty( $body_bg['background-color'] ) ) ? 'background-color:'. $body_bg['background-color'] : null,
					( ! empty( $body_bg['background-image'] ) ) ? 'background-image: url('. $body_bg['background-image'] .')' : null,
					( ! empty( $body_bg['background-repeat'] ) ) ? 'background-repeat:'. $body_bg['background-repeat'] : null,
					( ! empty( $body_bg['background-position'] ) ) ? 'background-position:'. $body_bg['background-position'] : null,
					( ! empty( $body_bg['background-attachment'] ) ) ? 'background-attachment:'. $body_bg['background-attachment'] : null,
					( ! empty( $body_bg['background-size'] ) ) ? 'background-size:'. $body_bg['background-size'] : null,
				);

				$body_styles = implode('; ', array_filter($body_styles));
				$custom_css .= 'body{'.$body_styles.'}';
			}
		}
	}

	// Pre-content style
		$pre_header_bg = get_post_meta( $page_id, 'pre_content_bg', true);
		if ( ! empty( $pre_header_bg ) ){
			$pre_header_styles = array(
				( ! empty( $pre_header_bg['background-color'] ) ) ? 'background-color:'. $pre_header_bg['background-color'] : null,
				( ! empty( $pre_header_bg['background-image'] ) ) ? 'background-image: url('. $pre_header_bg['background-image'] .')' : null,
				( ! empty( $pre_header_bg['background-repeat'] ) ) ? 'background-repeat:'. $pre_header_bg['background-repeat'] : null,
				( ! empty( $pre_header_bg['background-position'] ) ) ? 'background-position:'. $pre_header_bg['background-position'] : null,
				( ! empty( $pre_header_bg['background-attachment'] ) ) ? 'background-attachment:'. $pre_header_bg['background-attachment'] : null,
				( ! empty( $pre_header_bg['background-size'] ) ) ? 'background-size:'. $pre_header_bg['background-size'] : null,

			);

			$pre_header_styles = implode('; ', array_filter($pre_header_styles));
			$custom_css .= '.pre-content{'.$pre_header_styles.'}';
		}

	// Pre-content and Title slope color
	$title_slope_color = get_post_meta( $page_id, 'title_slope_color', true);
	if ( !empty($title_slope_color) ){
		$custom_css .= '#title-slope svg path { fill:'.$title_slope_color.';}';
	}

	// Title background
	$title_bg = ot_get_option('title_bg');
	if ( ! empty( $title_bg ) ){
		$title_styles = array(
			(! empty( $title_bg['background-color'] ) ) ? 'background-color:'. $title_bg['background-color'] : null,
			(! empty( $title_bg['background-image'] ) ) ? 'background-image: url('. $title_bg['background-image'] .')' : null,
			(! empty( $title_bg['background-repeat'] ) ) ? 'background-repeat:'. $title_bg['background-repeat'] : null,
			(! empty( $title_bg['background-position'] ) ) ? 'background-position:'. $title_bg['background-position'] : null,
			(! empty( $title_bg['background-attachment'] ) ) ? 'background-attachment:'. $title_bg['background-attachment'] : null,
			(! empty( $title_bg['background-size'] ) ) ? 'background-size:'. $title_bg['background-size'] : null,

		);

		$title_styles = implode('; ', array_filter($title_styles));
		$custom_css .= '.page-header{'.$title_styles.'}';
	}


	// Page title options
	(ot_get_option('title_color') != '') ? $custom_css .= '.page-header h1.page-title {color:'. ot_get_option('title_color') .';}' : '';
	(ot_get_option('title_text_size') != '') ? $custom_css .= '.page-header h1.page-title {font-size:'. ot_get_option('title_text_size') .'}' : '';
	$title_font = ot_get_option('title_font');
	$title_font_styles = array(
		( ! empty( $title_font['font-family'] ) ) ? 'font-family: \''. str_replace("+", " ", $title_font['font-family']) .'\'' : 'font-family: Open Sans, Helvetica, Arial, sans-serif',
		( ! empty( $title_font['font-weight'] ) ) ? 'font-weight:'. $title_font['font-weight'] : null,
		( ! empty( $title_font['font-style'] ) ) ? 'font-style:'. $title_font['font-style'] : null,
		( ! empty( $title_font['line-height'] ) ) ? 'line-height:'. $title_font['line-height'] : null,
		( ! empty( $title_font['letter-spacing'] ) ) ? 'letter-spacing:'. $title_font['letter-spacing'] : null,
		( ! empty( $title_font['text-transform'] ) ) ? 'text-transform:'. $title_font['text-transform'] : null,
	);
	$title_font_style = implode('; ', array_filter($title_font_styles));
	$custom_css .= '.page-header h1.page-title, .page-header.tl-br .page-title, .page-header.tr-bl .page-title {'.$title_font_style.'}';

	(ot_get_option('breadcrumbs_color') != '') ? $custom_css .= '.breadcrumbs-path, .breadcrumbs-path a, .breadcrumbs-separator, .breadcrumbs-yoast .breadcrumb_last {color:'. ot_get_option('breadcrumbs_color') .';}' : '';
	(ot_get_option('breadcrumbs_color_link') != '') ? $custom_css .= '.breadcrumbs-path a {color:'. ot_get_option('breadcrumbs_color_link') .'}' : '';
	(ot_get_option('breadcrumbs_hover_color') != '') ? $custom_css .= '.breadcrumbs-path a:hover {color:'. ot_get_option('breadcrumbs_hover_color') .';}' : '';
	(ot_get_option('breadcrumbs_color_divider') != '') ? $custom_css .= '.breadcrumbs-path .separator, .breadcrumbs-yoast span {color:'. ot_get_option('breadcrumbs_color_divider') .'}' : '';
	(ot_get_option('breadcrumbs_text_size') != '') ? $custom_css .= '.breadcrumbs-path {font-size:'. ot_get_option('breadcrumbs_text_size') .'}' : '';

	$breadcrumbs_font = ot_get_option('breadcrumbs_font');
	$breadcrumbs_font_styles = array(
		( ! empty( $breadcrumbs_font['font-family'] ) ) ? 'font-family: \''. str_replace("+", " ", $breadcrumbs_font['font-family']) .'\'' : 'font-family: Open Sans, Helvetica, Arial, sans-serif',
		( ! empty( $breadcrumbs_font['font-weight'] ) ) ? 'font-weight:'. $breadcrumbs_font['font-weight'] : null,
		( ! empty( $breadcrumbs_font['font-style'] ) ) ? 'font-style:'. $breadcrumbs_font['font-style'] : null,
		( ! empty( $breadcrumbs_font['line-height'] ) ) ? 'line-height:'. $breadcrumbs_font['line-height'] : null,
		( ! empty( $breadcrumbs_font['letter-spacing'] ) ) ? 'letter-spacing:'. $breadcrumbs_font['letter-spacing'] : null,
		( ! empty( $breadcrumbs_font['text-transform'] ) ) ? 'text-transform:'. $breadcrumbs_font['text-transform'] : null,
	);
	$breadcrumbs_font_style = implode('; ', array_filter($breadcrumbs_font_styles));
	$custom_css .= '.breadcrumbs-path p,.breadcrumbs-path a, .breadcrumbs-separator {'.$breadcrumbs_font_style.'}';

	// Title padding top
	$title_padding_top = (ot_get_option('header_height')) ? intval(ot_get_option('header_height')) : 0;

	if ( !is_page() && is_single() ) {
		if ( ot_get_option('post_title') != 'off' && ot_get_option('post_pre_content') == 'off' ) {
			(ot_get_option('title_padding_top') != '') ? $title_padding_top += intval(ot_get_option('title_padding_top')) : '';
		}
	} else {
		if ( wp_kses_post(get_post_meta( $page_id, 'page_title', true )) == 'on' && wp_kses_post(get_post_meta( $page_id, 'pre_content_activation', true )) == 'off' ) {
			(ot_get_option('title_padding_top') != '') ? $title_padding_top += intval(ot_get_option('title_padding_top')) : '';
		}
	}
	$custom_css .= '.page-header{padding-top:'. $title_padding_top .'px;}';

	// Title padding bottom
	$title_padding_bot = (ot_get_option('title_padding_bottom')) ? intval(ot_get_option('title_padding_bottom')) : 0;
	(wp_kses_post(get_post_meta( $page_id, 'title_slope_enable', true )) == 'on') ? $title_padding_bot += intval(wp_kses_post(get_post_meta( $page_id, 'title_slope_height', true ))) : '';
	$custom_css .= '.page-header{padding-bottom:'. $title_padding_bot .'px;}';

	// Title slope decoration
	(ot_get_option('title_slope_height') != '') ? $custom_css .= '#title-slope {height:' . ot_get_option('title_slope_height') .'}' : '';
	(ot_get_option('title_slope_color') != '') ? $custom_css .= '#title-slope path {fill:' . ot_get_option('title_slope_color') .'}' : '';

	// Main content padding
	$content_padding_top = (wp_kses_post(get_post_meta( $page_id, 'content_padding_top', true )) != '' && 'portfolio' != get_post_type()) ? intval(wp_kses_post(get_post_meta( $page_id, 'content_padding_top', true ))) : '';
	if ( is_front_page() && is_home() ) {
		// Default homepage
	} elseif ( is_front_page() ) {

	}elseif ( is_home() && get_post_meta( get_option('page_for_posts'), 'page_title', true ) == 'off' ) {
		$content_padding_top += intval(ot_get_option('header_height'));
	} elseif (is_singular('post') && ot_get_option('post_title') == 'off' ) {
		$content_padding_top += intval(ot_get_option('header_height'));
	}
	$custom_css .= '#main {padding-top:'. $content_padding_top .'px;}';
	$content_padding_bottom = (wp_kses_post(get_post_meta( $page_id, 'content_padding_bottom', true )) != '') ? intval(wp_kses_post(get_post_meta( $page_id, 'content_padding_bottom', true ))) : '';
	$custom_css .= '#main {padding-bottom:'. $content_padding_bottom.'px;}';

	// Sidebar styles
	(ot_get_option('sidebar_title_color') != '') ? $custom_css .= '.page-sidebar .widget .widget-title, #wp-calendar thead th {color:'. ot_get_option('sidebar_title_color') .'}' : '';
	(ot_get_option('sidebar_text_color') != '') ? $custom_css .= '
		.page-sidebar .widget,
		#wp-calendar tbody,
		.widget-area .widget .tagcloud a,
		.widget_search:before,
		#wp-calendar caption,
		.woocommerce .widget_shopping_cart ul li .quantity, .woocommerce-page .widget_shopping_cart ul li .quantity,
		.woocommerce .widget_product_search #searchform div #s, .woocommerce-page .widget_product_search #searchform div #s,
		.woocommerce .widget_product_search #searchform div:after, .woocommerce-page .widget_product_search #searchform div:after
		{color:'. ot_get_option('sidebar_text_color') .'}' : '';
	(ot_get_option('sidebar_link_color') != '') ? $custom_css .= '
		.page-sidebar a,
		 .woocommerce .product-categories > li.cat-item:before, .woocommerce-page .product-categories > li.cat-item:before,
		 .woocommerce .product-categories > li.cat-item .children li:before, .woocommerce-page .product-categories > li.cat-item .children li:before
		 {color:'. ot_get_option('sidebar_link_color') .'}' : '';
	(ot_get_option('sidebar_link_hover_color') != '') ? $custom_css .= '.page-sidebar a:not(.button):hover{color:'. ot_get_option('sidebar_link_hover_color') .'}' : '';
	(ot_get_option('sidebar_divider_color') != '') ? $custom_css .= '
		.page-sidebar .widget ul li,
		.page-sidebar .widget ul ul,
		.widget-area .widget .tagcloud a,
		.widget_search,
		.woocommerce .widget_product_search #searchform div #s, .woocommerce-page .widget_product_search #searchform div #s
		{border-color:'. ot_get_option('sidebar_divider_color') .'}' : '';

	// Footer background
	$footer_bg = ot_get_option('footer_bg');
	if ( ! empty( $footer_bg ) ){
		$footer_styles = array(
			(! empty( $footer_bg['background-color'] ) ) ? 'background-color:'. $footer_bg['background-color'] : null,
			(! empty( $footer_bg['background-image'] ) ) ? 'background-image: url('. $footer_bg['background-image'] .')' : null,
			(! empty( $footer_bg['background-repeat'] ) ) ? 'background-repeat:'. $footer_bg['background-repeat'] : null,
			(! empty( $footer_bg['background-position'] ) ) ? 'background-position:'. $footer_bg['background-position'] : null,
			(! empty( $footer_bg['background-attachment'] ) ) ? 'background-attachment:'. $footer_bg['background-attachment'] : null,
			(! empty( $footer_bg['background-size'] ) ) ? 'background-size:'. $footer_bg['background-size'] : null,

		);

		$footer_styles = implode('; ', array_filter($footer_styles));
		$custom_css .= '.footer-sidebar{'.$footer_styles.'}';
	}
	// Footer style
	(ot_get_option('footer_text_color') != '') ? $custom_css .= '
		.footer-sidebar .widget,
		.footer-sidebar .widget_search:before,
		.footer-sidebar #wp-calendar tbody,
		.footer-sidebar #wp-calendar caption
		{color:'. ot_get_option('footer_text_color') .'}
		.footer-sidebar .widget_search {border-color:'. ot_get_option('footer_text_color') .'}' : '';
	(ot_get_option('footer_link') != '') ? $custom_css .= '
		.footer-sidebar .widget a,
		.footer-sidebar .widget-area .widget .tagcloud a
		{color:'. ot_get_option('footer_link') .'}
		.footer-sidebar .widget-area .widget .tagcloud a {border-color:'. ot_get_option('footer_link') .'}' : '';
	(ot_get_option('footer_link_hover') != '') ? $custom_css .= '.footer-sidebar .widget a:hover {color:'. ot_get_option('footer_link_hover') .'}' : '';
	(ot_get_option('footer_widget_title') != '') ? $custom_css .= '.footer-sidebar .widget .widget-title, .footer-sidebar #wp-calendar thead th {color:'. ot_get_option('footer_widget_title') .'}' : '';


	// Copyright background
	$copyright_bg = ot_get_option('copyright_bg');
	if ( ! empty( $copyright_bg ) ){
		$copyright_styles = array(
			(! empty( $copyright_bg['background-color'] ) ) ? 'background-color:'. $copyright_bg['background-color'] : null,
			(! empty( $copyright_bg['background-image'] ) ) ? 'background-image: url('. $copyright_bg['background-image'] .')' : null,
			(! empty( $copyright_bg['background-repeat'] ) ) ? 'background-repeat:'. $copyright_bg['background-repeat'] : null,
			(! empty( $copyright_bg['background-position'] ) ) ? 'background-position:'. $copyright_bg['background-position'] : null,
			(! empty( $copyright_bg['background-attachment'] ) ) ? 'background-attachment:'. $copyright_bg['background-attachment'] : null,
			(! empty( $copyright_bg['background-size'] ) ) ? 'background-size:'. $copyright_bg['background-size'] : null,

		);

		$copyright_styles = implode('; ', array_filter($copyright_styles));
		$custom_css .= '.site-info{'.$copyright_styles.'}';
	}

	// Copyright style
	(ot_get_option('copyright_text_color') != '') ? $custom_css .= '
		.site-info .widget,
		.site-info .widget_search:before,
		.site-info #wp-calendar tbody,
		.site-info #wp-calendar caption
		{color:'. ot_get_option('copyright_text_color') .'}
		.site-info .widget_search {border-color:'. ot_get_option('footer_text_color') .'}' : '';
	(ot_get_option('copyright_link') != '') ? $custom_css .= '
		.site-info .widget a,
		.site-info .widget-area .widget .tagcloud a
		{color:'. ot_get_option('copyright_link') .'}
		.site-info .widget_search {border-color:'. ot_get_option('footer_text_color') .'}' : '';
	(ot_get_option('copyright_link_hover') != '') ? $custom_css .= '
		.site-info .widget a:hover
		{color:'. ot_get_option('copyright_link_hover') .'}' : '';
	(ot_get_option('copyright_widget_title') != '') ? $custom_css .= '
		.site-info .widget .widget-title, .site-info #wp-calendar thead th
		{color:'. ot_get_option('copyright_widget_title') .'}' : '';

	// Blog & post typography
	(ot_get_option('post_heading_color') != '') ? $custom_css .= 'article.post-entry h1.entry-title a {color:'. ot_get_option('post_heading_color') .';}' : '';
	(ot_get_option('post_color') != '') ? $custom_css .= 'body #content article.post-entry p {color:'. ot_get_option('post_color') .';}' : '';
	(ot_get_option('meta_color') != '') ? $custom_css .= '
		body.blog-clear #content article.post-entry .entry-meta, body.blog-clear #content article.post-entry .entry-meta,
		body.blog-clear #content article.post-entry .entry-meta, body.blog-clear #content article.post-entry .entry-meta-footer
		{color:'. ot_get_option('meta_color') .';}' : '';

	// Mobile style
	if ( class_exists('Mobile_Detect') ){
		$detect = new Mobile_Detect;
		if ( $detect->isMobile() ) {
			$custom_css .= '@media only screen and (max-width : 1024px){
				.wpb_row, .bg-image, .bg-video .pre-content {background-attachment:scroll !important;}
			}';
		}
	}

	// Add custom fonts

	$custom_fonts = ot_get_option('custom_fonts');
	if ( $custom_fonts !== '' ) {
		foreach ( $custom_fonts as $font ) {
			if ( !empty($font['custom_font_style']) ) {
				$custom_css .= $font['custom_font_style'];
			}
		}
	}


	// Custom CSS from option panel
	$custom_css .= ot_get_option('custom_css');

	wp_add_inline_style( 'main', $custom_css );
}

add_action('wp_enqueue_scripts', 'collars_custom_css');
?>