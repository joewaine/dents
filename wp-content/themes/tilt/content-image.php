<?php
/**
 * The template for displaying posts in the Image post format
 *
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post-entry clearfix'); ?> role="article">
	
		<?php collars_post_links(); ?>
		<?php collars_post_slope_top(); ?>

		<?php 	
		$img_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); 
		
		if( get_post_meta( get_the_ID(), 'image_embed', true ) ) { 
			global $wp_embed;
			$embed = $wp_embed->run_shortcode('[embed width="800"]'.wp_kses_post(get_post_meta( get_the_ID(), 'image_embed', true )).'[/embed]');
			echo '<div class="post-preview ext-image">'. $embed .'</div>';
		} elseif( $img_url != '' ){
			if( is_single() ){
				echo '<div class="post-preview">'. get_the_post_thumbnail($post->ID, "large") .'</div>';
			} else {
				if( function_exists( 'aq_resize' ) ){
					echo '<div class="post-preview"><a href="'. esc_url(get_permalink()) .'" class="local-image"></a><img alt="'.esc_attr(get_the_title()).'" src="'. aq_resize($img_url, 800, 500, true, true, true) .'" /></div>';
				} else {
					echo '<div class="post-preview-error"><h5>';
						$url = admin_url( 'themes.php?page=tgmpa-install-plugins' );
						$link = sprintf( __( 'Please install <a href="%s" >Theme Extension plugin</a> plugin to enable this feature!', 'tilt' ), esc_url( $url ) );
						echo $link;
					echo '</h5></div>';
				}
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