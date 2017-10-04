<?php
/*	
*	---------------------------------------------------------------------
*	TWC Template part: page title & before content area
*	--------------------------------------------------------------------- 
*/
?>

<?php 
if ( is_404() ) : // 404 error & portfolio post header
	// empty
elseif ( is_page() && get_post_type( get_the_ID() ) !== 'portfolio' ) :  // Page & Single post header options  ?>

	<?php if ( wp_kses_post(get_post_meta( get_the_ID(), 'pre_content_activation', true ) == 'on' )) : ?>

		<div class="pre-content" <?php if ( wp_kses_post(get_post_meta( get_the_ID(), 'pre_content_height', true )) ) { echo 'style="height:'. esc_html(get_post_meta( get_the_ID(), 'pre_content_height', true )) .'"'; } ?>>
		
			<?php if ( wp_kses_post(get_post_meta( get_the_ID(), 'rev_on_off', true )) != 'off' && wp_kses_post(get_post_meta( get_the_ID(), 'rev_slider_header', true )) != '' ) : ?>
				<div class="pre-content-slider"><?php putRevSlider( get_post_meta( get_the_ID(), 'rev_slider_header', true ) ); ?></div>
			<?php endif; ?>		
			
			<?php if ( wp_kses_post(get_post_meta( get_the_ID(), 'pre_content_html', true )) ) : ?>
				<div class="pre-content-html"><?php echo do_shortcode( get_post_meta( get_the_ID(), 'pre_content_html', true ) ); ?></div>
			<?php endif; ?>
s
			<?php ( wp_kses_post(get_post_meta( get_the_ID(), 'page_title', true ) != 'on' )) ? collars_title_slope() : null; ?>

		</div><!-- .pre-content -->
		
	<?php endif; ?>

	<?php if ( wp_kses_post(get_post_meta( get_the_ID(), 'page_title', true )) == 'on' ) : ?>
		<div class="page-header clearfix <?php  echo ( ot_get_option('title_alignment') !== '' ) ? ot_get_option('title_alignment') : null; ?>">
			<div class="row-inner">
				<h1 class="page-title"><?php the_title(); ?></h1><?php if( ot_get_option('breadcrumb') != 'off' ) { collars_bc_plus(); } ?>
			</div>

			<?php collars_title_slope(); ?>

		</div><!-- .page-header -->
	<?php endif; ?>

<?php else : // If not page ?>
	<?php if ( class_exists( 'Woocommerce' ) && is_woocommerce() ) : // If it is WooCommerce product page ?>

		<?php if( get_post_meta( get_option( 'woocommerce_shop_page_id' ), 'pre_content_activation', true ) == 'on' ) : ?>
			<div class="pre-content" <?php if ( wp_kses_post(get_post_meta( get_option( 'woocommerce_shop_page_id' ), 'pre_content_height', true )) ) { echo 'style="height:'. esc_html(get_post_meta( get_option( 'woocommerce_shop_page_id' ), 'pre_content_height', true )) .'"'; } ?>>

				<?php if ( wp_kses_post(get_post_meta( get_option( 'woocommerce_shop_page_id' ), 'rev_on_off', true )) != 'off' && wp_kses_post(get_post_meta( get_option( 'woocommerce_shop_page_id' ), 'rev_slider_header', true )) != '' ) : ?>
					<div class="pre-content-slider"><?php putRevSlider( get_post_meta( get_option( 'woocommerce_shop_page_id' ), 'rev_slider_header', true ) ); ?></div>
				<?php endif; ?>

				<?php if ( wp_kses_post(get_post_meta( get_option( 'woocommerce_shop_page_id' ), 'pre_content_html', true )) ) : ?>
					<div class="pre-content-html"><?php echo do_shortcode( get_post_meta( get_option( 'woocommerce_shop_page_id' ), 'pre_content_html', true ) ); ?></div>
				<?php endif; ?>

				<?php ( wp_kses_post(get_post_meta( get_option( 'woocommerce_shop_page_id' ), 'page_title', true ) != 'on' )) ? collars_title_slope() : null; ?>

			</div><!-- .pre-content -->
		<?php endif; ?>

		<?php if ( wp_kses_post(get_post_meta( get_option( 'woocommerce_shop_page_id' ), 'page_title', true )) == 'on' ) : ?>
			<div class="page-header clearfix <?php echo ( ot_get_option('title_alignment') !== '' ) ? ot_get_option('title_alignment') : null; ?>">
			<div class="row-inner">
				<h1 class="page-title">
					<?php echo woocommerce_page_title(); ?>
				</h1>
				<?php if( ot_get_option('breadcrumb') != 'off' ) {
					if (function_exists('yoast_breadcrumb') && ot_get_option('breadcrumb_yoast') != 'off') {
						yoast_breadcrumb('<p class="breadcrumbs-path breadcrumbs-yoast">', '</p>');
					} else {
						collars_bc_plus();
					}
				} ?>
			</div><!-- .row-inner -->

			<?php collars_title_slope(); ?>

		</div><!-- .page-header -->
		<?php endif; ?>

	<?php elseif ( is_home()|| is_single() ) : // If is blog or single post page ?>

		<?php if ( is_single() && get_post_type( get_the_ID() ) !== 'portfolio' ) { // If post page
			if( get_post_meta( get_option('page_for_posts'), 'pre_content_activation', true ) == 'on' && ot_get_option('post_pre_content') == 'on' ) : ?>
				<div class="pre-content" <?php if ( wp_kses_post(get_post_meta( get_option('page_for_posts'), 'pre_content_height', true )) ) { echo 'style="height:'. esc_html(get_post_meta( get_option('page_for_posts'), 'pre_content_height', true )) .'"'; } ?>>

					<?php if ( wp_kses_post(get_post_meta( get_option('page_for_posts'), 'rev_on_off', true )) != 'off' && wp_kses_post(get_post_meta( get_option('page_for_posts'), 'rev_slider_header', true )) != '' ) : ?>
						<div class="pre-content-slider"><?php putRevSlider( get_post_meta( get_option('page_for_posts'), 'rev_slider_header', true ) ); ?></div>
					<?php endif; ?>

					<?php if ( wp_kses_post(get_post_meta( get_option('page_for_posts'), 'pre_content_html', true )) ) : ?>
						<div class="pre-content-html"><?php echo do_shortcode( get_post_meta( get_option('page_for_posts'), 'pre_content_html', true ) ); ?></div>
					<?php endif; ?>

					<?php ( wp_kses_post(get_post_meta( get_option('page_for_posts'), 'page_title', true ) != 'on' )) ? collars_title_slope() : null; ?>

				</div><!-- .pre-content -->
			<?php endif; ?>
			<?php if( ot_get_option('post_title') != 'off' ) : ?>
				<div class="page-header clearfix <?php echo ( ot_get_option('title_alignment') !== '' ) ? ot_get_option('title_alignment') : null; ?>">
					<div class="row-inner">
						<h1 class="page-title">
							<?php global $wp_query;
							$home_page = get_page( $wp_query->get_queried_object_id() );
							echo get_the_title( $home_page->ID );
							?>
						</h1>
						<?php if( ot_get_option('breadcrumb') != 'off' ) {
							if (function_exists('yoast_breadcrumb') && ot_get_option('breadcrumb_yoast') != 'off') {
								yoast_breadcrumb('<p class="breadcrumbs-path breadcrumbs-yoast">', '</p>');
							} else {
								collars_bc_plus();
							}
						} ?>

					</div><!-- .row-inner -->
					<?php collars_title_slope(); ?>
				</div><!-- .page-header -->
			<?php endif; ?>

		<?php } elseif ( get_post_type( get_the_ID() ) !== 'portfolio' ) { // If blog page
			if( get_post_meta( get_option('page_for_posts'), 'pre_content_activation', true ) == 'on' ) : ?>
				<div class="pre-content" <?php if ( wp_kses_post(get_post_meta( get_option('page_for_posts'), 'pre_content_height', true )) ) { echo 'style="height:'. esc_html(get_post_meta( get_option('page_for_posts'), 'pre_content_height', true )) .'"'; } ?>>

					<?php if ( wp_kses_post(get_post_meta( get_option('page_for_posts'), 'rev_on_off', true )) != 'off' && wp_kses_post(get_post_meta( get_option('page_for_posts'), 'rev_slider_header', true )) != '' ) : ?>
						<div class="pre-content-slider"><?php putRevSlider( get_post_meta( get_option('page_for_posts'), 'rev_slider_header', true ) ); ?></div>
					<?php endif; ?>

					<?php if ( wp_kses_post(get_post_meta( get_option('page_for_posts'), 'pre_content_html', true )) ) : ?>
						<div class="pre-content-html"><?php echo do_shortcode( get_post_meta( get_option('page_for_posts'), 'pre_content_html', true ) ); ?></div>
					<?php endif; ?>

					<?php ( wp_kses_post(get_post_meta( get_option('page_for_posts'), 'page_title', true ) != 'on' )) ? collars_title_slope() : null; ?>

				</div><!-- .pre-content -->
			<?php endif; ?>
			<?php if( get_post_meta( get_option('page_for_posts'), 'page_title', true ) != 'off' ) : ?>
				<div class="page-header clearfix <?php echo ( ot_get_option('title_alignment') !== '' ) ? ot_get_option('title_alignment') : null; ?>">
					<div class="row-inner">
						<h1 class="page-title">
							<?php global $wp_query;
							$home_page = get_page( $wp_query->get_queried_object_id() );
							echo get_the_title( $home_page->ID );
							?>
						</h1>
						<?php if( ot_get_option('breadcrumb') != 'off' ) {
							if (function_exists('yoast_breadcrumb') && ot_get_option('breadcrumb_yoast') != 'off') {
								yoast_breadcrumb('<p class="breadcrumbs-path breadcrumbs-yoast">', '</p>');
							} else {
								collars_bc_plus();
							}
						} ?>
					</div><!-- .row-inner -->
					<?php collars_title_slope(); ?>
				</div><!-- .page-header -->
			<?php endif; ?>

		<?php } ?>

	<?php else : // If not blog ?>

		<div class="page-header clearfix <?php echo ( ot_get_option('title_alignment') !== '' ) ? ot_get_option('title_alignment') : null; ?>">
			<div class="row-inner">
				<h1 class="page-title">
				
					<?php 
					if ( is_front_page() ) : // Home title
						bloginfo('name');
						
					elseif ( is_search() ) : // Search title
						printf( __( 'Search Results for: %s', 'tilt' ), '<span class="search-query">' . get_search_query() . '</span>' );
					elseif ( is_category() || is_tax() ) : // Category & taxonomy title
						echo single_cat_title( '', false );
						
					elseif ( is_tag() ) : // Tag title
						echo single_tag_title( '', false );
						
					elseif ( is_archive() ) : // Archive title
						if ( is_day() ) :
							echo get_the_date();
						elseif ( is_month() ) :
							echo get_the_date( 'F Y' ); 
						elseif ( is_year() ) :
							echo get_the_date( 'Y' );
						elseif ( is_author() ) :
							echo get_the_author();
						else :
							_e( 'Archives', 'tilt' );
						endif; 
							
					endif; ?>
				
				</h1>

				<?php  if ( !is_search() ) :
					if( ot_get_option('breadcrumb') != 'off' ) {
						if (function_exists('yoast_breadcrumb') && ot_get_option('breadcrumb_yoast') != 'off') {
							yoast_breadcrumb('<p class="breadcrumbs-path breadcrumbs-yoast">', '</p>');
						} else {
							collars_bc_plus();
						}
					}
				endif; ?>
			</div><!-- .row-inner -->

			<?php collars_title_slope(); ?>

		</div><!-- .page-header -->
	<?php endif; ?>
<?php endif; ?>