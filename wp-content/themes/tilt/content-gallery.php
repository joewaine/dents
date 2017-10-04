<?php
/**
 * The template for displaying posts in the Gallery post format
 *
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post-entry clearfix'); ?> role="article">
		
		<?php collars_post_links(); ?>
		<?php collars_post_slope_top(); ?>

		<?php
		$args = array(
			'post_type' => 'attachment',
			'numberposts' => -1,
			'post_status' => null,
			'post_parent' => $post->ID
		);

		$attachments = get_posts( $args );

		if ( $attachments ) {
			wp_register_script( 'Carousel', COLLARS_PLUGIN_URL . 'assets/js/owl.carousel.post.min.js', array('jquery'));
			wp_enqueue_script( 'Carousel' );
			$speed = wp_kses_post(get_post_meta( get_the_ID(), 'gallery_delay', true ));
			$effect = wp_kses_post(get_post_meta( get_the_ID(), 'gallery_animation', true ));

			if ( is_rtl() ) {
				$rtl = 'true';
			} else {
				$rtl = 'false';
			}

			echo "
			<script>
				jQuery(document).ready(function() {
					$('.twc_slider_carousel[data-title=\"".esc_attr(get_the_title())."\"]').each(function(index) {
						var transition = '';

						if ( '".$effect."' == 'fade' ) {
							transition  = 'fadeOut';
						}

						var options = {
							items:              1,
							autoplay:           true,
							autoplayTimeout:    ".$speed.",
							autoplayHoverPause: true,
							slideBy:            1,
							smartSpeed:         500,
							animateOut:         transition,
							loop:               true,
							rtl:                ".$rtl."
						};

						var owl = $(this);
						owl.owlCarousel(options);

						owl.closest('.twc_swiper').find('.twc-next').click(function() {
							owl.trigger('next.owl.carousel');
						});
						owl.closest('.twc_swiper').find('.twc-prev').click(function() {
							owl.trigger('prev.owl.carousel');
						});
					});
				});
			</script>";

			if( function_exists( 'aq_resize' ) ){
				echo '<div class="post-preview">
						<div class="twc_swiper carousel-classic carousel-dark nav-hide no-pagination">
							<div class="twc_slider_carousel owl-carousel" data-title="'.esc_attr(get_the_title()).'">';
				foreach ( $attachments as $attachment ) {
					$image_attributes = wp_get_attachment_image_src( $attachment->ID, 'large' );

					echo '<div class="twc_image_wrapper swiper-slide">';
					     echo '<img  alt="'.esc_attr(get_the_title()).'" src="'. aq_resize( $image_attributes[0], 800, wp_kses_post(get_post_meta( get_the_ID(), 'gallery_height', true )), true, true, true ) .'" alt="">';
					echo '</div>';
				}
				echo '	</div>
						<div class="twc-controls">
				            <div class="twc-buttons">
				                <div class="twc-prev"><svg viewBox="0 0 700 750" preserveAspectRatio="none"><polygon xmlns="http://www.w3.org/2000/svg" points="455.377,702 140.303,395.991 455.377,90 471.7,106.797 173.953,395.991 471.7,685.19"></polygon></svg></div>
				                <div class="twc-next"><svg viewBox="0 0 700 750" preserveAspectRatio="none"><polygon xmlns="http://www.w3.org/2000/svg" points="156.626,90 471.7,396.009 156.626,702 140.303,685.202 438.05,396.009 140.303,106.81"></polygon></svg></div>
				            </div>
		                </div>
		        </div></div>';
			} else {
				echo '<div class="post-preview-error"><h5>';
					$url = admin_url( 'themes.php?page=tgmpa-install-plugins' );
					$link = sprintf( __( 'Please install <a href="%s" >Theme Extension plugin</a> plugin to enable this feature!', 'tilt' ), esc_url( $url ) );
					echo $link;
				echo '</h5></div>';
			}
		}
		?>
		
		<?php if ( !is_single() ) : ?>
			<header class="post-entry-header">
				<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tilt' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
			</header><!-- .entry-header -->
		<?php endif; ?>

		<?php if( is_single() ) : ?>
			<header class="post-entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header><!-- .entry-header -->
			<div class="entry-content">
				<?php
				the_content();
				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'tilt' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) );
				?>
			</div><!-- .entry-content -->
			<?php
			if( is_single() && has_tag() && ot_get_option('post_tags') != 'off' ) {
				the_tags( '<div class="tag-links"><span>','</span><span>','</span></div>' );
			} ?>
		<?php elseif( is_search() ) : ?>
			<div class="entry-summary">
				<?php if ( ot_get_option('content_type') != 'excerpt') : ?>
					<?php
					$more = '<div class="read-more"><a class="excerpt-read-more" href="'. get_permalink( $post->ID ) . '" title="'. __( 'Continue reading ', 'tilt' ) . esc_attr( get_the_title( $post->ID ) ).'">'. __( 'Read more', 'tilt' ) .'<i class="fa fa-angle-right"></i></a></div>';
					the_content($more);
					?>
				<?php else : ?>
					<?php the_excerpt(); ?>
				<?php endif; ?>
			</div><!-- .entry-summary -->		
		<?php else : ?>
			<div class="entry-summary">
				<?php if ( ot_get_option('content_type') != 'excerpt') : ?>
					<?php
					$more = '<div class="read-more"><a class="excerpt-read-more" href="'. get_permalink( $post->ID ) . '" title="'. __( 'Continue reading ', 'tilt' ) . esc_attr( get_the_title( $post->ID ) ).'">'. __( 'Read more', 'tilt' ) .'<i class="fa fa-angle-right"></i></a></div>';
					the_content($more);
					?>
				<?php else : ?>
					<?php the_excerpt(); ?>
				<?php endif; ?>
			</div><!-- .entry-summary -->
		<?php endif; ?>
		
		<?php collars_post_meta_footer(); ?>
		<?php collars_post_slope_bot(); ?>

	</article><!-- #post-<?php the_ID(); ?> -->