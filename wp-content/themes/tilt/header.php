<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="format-detection" content="telephone=no">

		<title><?php wp_title('-', true, 'right'); ?></title>

		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

		<?php if (ot_get_option('favicon')){
			echo '<link rel="shortcut icon" href="'. esc_url(ot_get_option('favicon')) .'" />';
		}

		if (ot_get_option('ipad_favicon_retina')){
			echo '<link rel="apple-touch-icon" sizes="152x152" href="'. esc_url(ot_get_option('ipad_favicon_retina')) .'" >';
		}

		if (ot_get_option('iphone_favicon_retina')){
			echo '<link rel="apple-touch-icon" sizes="120x120" href="'. esc_url(ot_get_option('iphone_favicon_retina')) .'" >';
		}

		if (ot_get_option('ipad_favicon')){
			echo '<link rel="apple-touch-icon" sizes="76x76" href="'. esc_url(ot_get_option('ipad_favicon')) .'" >';
		}

		if (ot_get_option('iphone_favicon')){
			echo '<link rel="apple-touch-icon" href="'. esc_url(ot_get_option('iphone_favicon')) .'" >';
		} ?>

		<?php echo ot_get_option('tracking_code'); ?>
		<?php wp_head(); ?>
	</head>

	<?php
		$blog_template = '';

		if ( is_front_page() && is_home() ) {
			// Default homepage
			(ot_get_option('blog_template') != '') ? $blog_template = ot_get_option('blog_template') : '';
		} elseif ( is_front_page() ) {
			// static homepage
		} elseif ( is_home() || 'post' == get_post_type() || 'portfolio' == get_post_type() ) {
			(ot_get_option('blog_template') != '') ? $blog_template = ot_get_option('blog_template') : '';
		} elseif ( is_search() ) {
			(ot_get_option('blog_template') != '') ? $blog_template = ot_get_option('blog_template') : '';
		}

		$cat_name = intval(get_query_var('cat'));
	?>

	<?php
		$page_layout = (ot_get_option('layout_style') == 'boxed' ) ? 'page-boxed' : '';
	?>

	<body <?php body_class($blog_template); ?>>

	<?php echo ot_get_option('code_after_body'); ?>

	<div id="wrapper" class="<?php echo $page_layout; ?>">

		<?php get_search_form() ?>

		<?php
		$header_class = '';

		// Check if full width header selected
		if ( ot_get_option('layout_style') != 'boxed' && ot_get_option('header_style') == 'full-width' ){
			$header_class .= 'full-width';
		}

		// Check if overlay header selected
		if ( is_page() && ot_get_option('overlay_header') != 'off' && ( in_array( get_the_ID(), ot_get_option('overlay_header_pages', array()) ) ) ){
			$header_class .= ' overlay-header';
		}

		// Check if sticky header enabled
		(ot_get_option('sticky_header') == 'on') ? $header_class .= ' sticky-enabled' : '';

		// Get general styles for header menu and submenu
			$page_id = get_the_ID();

			if ( is_front_page() && is_home() ) {
				// Default homepage
			} elseif ( is_front_page() ) {
				// static homepage
			} elseif ( class_exists( 'WooCommerce' ) && is_woocommerce() ) {
				$page_id = get_option( 'woocommerce_shop_page_id' );
			} elseif ( is_home() || is_single()|| is_category() || is_tax() ||  is_tag() || is_archive() || is_search()  ) {
				$page_id = get_option('page_for_posts');
			}

			if ( get_post_type( get_the_ID() ) === 'portfolio' && !is_archive() ) {
				if ( wp_kses_post(get_post_meta( get_the_ID(), 'meta_header', true )) === 'on' ) {
					$header_class .= ' ' . get_post_meta( get_the_ID(), 'meta_menu_style', true );
				} else {
					$header_class .= ' ' . get_post_meta( get_option('page_for_posts'), 'meta_menu_style', true );
				}
			} elseif ( wp_kses_post(get_post_meta( $page_id, 'meta_header', true )) == 'on' ) {
				if ( !is_page() && is_single() && ot_get_option('post_header') == 'header-default' && (class_exists( 'Woocommerce' ) && !is_woocommerce()) && get_post_type( get_the_ID() ) != 'portfolio' ) {
					$header_class .= ' ' . ot_get_option('menu_style');
				}
				else {
					$header_class .= ' ' . get_post_meta( $page_id, 'meta_menu_style', true );
				}
			} elseif ( ot_get_option('menu_style') != '' ) {
				$header_class .= ' ' . ot_get_option('menu_style');
			}

			if ( get_post_type( get_the_ID() ) === 'portfolio' && !is_archive() ) {
				if ( wp_kses_post(get_post_meta( get_the_ID(), 'meta_sticky_header', true )) === 'on' ) {
					$header_class .= ' ' . get_post_meta( get_the_ID(), 'meta_sticky_menu_style', true );
				} else {
					$header_class .= ' ' . get_post_meta( get_option('page_for_posts'), 'meta_sticky_menu_style', true );
				}
			} elseif ( wp_kses_post(get_post_meta( $page_id, 'meta_sticky_header', true )) == 'on' ) {
				if ( !is_page() && is_single() && ot_get_option('post_header') == 'header-default' && (class_exists( 'Woocommerce' ) && !is_woocommerce()) && get_post_type( get_the_ID() ) != 'portfolio' ) {
					$header_class .= ' ' . ot_get_option('sticky_menu_style');
				}
				else {
					$header_class .= ' ' . get_post_meta( $page_id, 'meta_sticky_menu_style', true );
				}
			} elseif ( ot_get_option('menu_style') != '' ) {
				$header_class .= ' ' . ot_get_option('sticky_menu_style');
			}


		$curr_id = get_the_ID();
		$top_bar = ot_get_option('top_bar', 'off');
		$submenu_style = ot_get_option('submenu_style');
		$header_weight = ot_get_option('header_weight');

		if( $top_bar == 'on' ) { get_sidebar('top'); }

		(ot_get_option('submenu_style') != '') ? $header_class .= ' ' . $submenu_style : '';
		(ot_get_option('header_weight') != '') ? $header_class .= ' ' . $header_weight : '';
		?>

		<header id="site-header" class="<?php echo trim($header_class); ?> header-hidden" role="banner">
			<div id="header-wrapper">
				<div id="header-container" class="clearfix">
					<div id="site-logo">
						<?php get_template_part( 'logo' ); ?>
					</div>

					<nav id="site-navigation" class="<?php echo (ot_get_option('menu_anim_enable') != 'off' ? ot_get_option('animation_type') : '' ) ?>" role="navigation">

						<?php
							wp_nav_menu( array( 'theme_location'  => 'primary',
							                    'container_class' => 'menu-container',
							                    'fallback_cb'     => 'collars_no_menu') );
						?>

						<div class="header-buttons">
							<?php if( class_exists( 'WooCommerce' ) && ot_get_option('cart_button') != 'off' ) : ?>
								<div class="header_cart_wrapper">
									<?php global $woocommerce; ?>
									<a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" title="<?php _e( 'Click to view your shopping cart', 'tilt' ); ?>" class="header_cart_link" >
										<?php woocommerce_cart_button(); ?>
									</a>
									<?php if( ot_get_option('cart_widget') != 'off' ) : woocommerce_cart_widget(); endif; ?>
								</div>
							<?php endif; ?>

							<?php if( ot_get_option('search_button') != 'off' ) : ?>
								<button id="trigger-header-search" class="search_button" type="button">
									<i class="icon-magnifier"></i>
								</button>
							<?php endif; ?>
						</div><!-- .header-buttons -->
					</nav><!-- #site-navigation -->

					<?php if( ot_get_option('search_button') != 'off' ) : ?>
						<div class="header-search"></div>
					<?php endif; ?>

					<a href="#mobile-site-navigation" class="toggle-mobile-menu">
<!--						<i class="fa fa-bars"></i>-->
						<div class="line top"></div>
						<div class="line middle"></div>
						<div class="line bottom"></div>
					</a>
				</div><!-- #header-container -->
			</div><!-- #header-wrapper -->


		</header><!-- #site-header -->

		<?php get_template_part( 'title' ); // Include title.php ?>

		<div id="main" class="clearfix">
