<?php
/**
 * The template for displaying posts in the Video post format
 *
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post-entry clearfix'); ?> role="article">
	
		<?php 
		collars_post_links();
		collars_post_slope_top();

		if( get_post_meta( get_the_ID(), 'video_embed', true ) ) { 
			global $wp_embed;
			$video_w = ( isset($content_width) ) ? $content_width : 500;
			$video_h = $video_w/1.61; //1.61 golden ratio
			$embed = $wp_embed->run_shortcode('[embed width="'.$video_w.'"'.$video_h.']'.wp_kses_post(get_post_meta( get_the_ID(), 'video_embed', true )).'[/embed]');
				
			echo '<div class="post-preview"><div class="post-video-wrapper">'. $embed .'</div></div>';
		} ?>

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