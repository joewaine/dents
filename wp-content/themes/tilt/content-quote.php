<?php
/**
 * The template for displaying posts in the Quote post format
 *
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post-entry clearfix'); ?> role="article">
		
		<?php collars_post_links(); ?>
		<?php collars_post_slope_top(); ?>

		<header class="post-entry-header">
			<div class="quoute-text">
				<?php if ( !is_single() ) : ?>
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tilt' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php echo get_the_content(); ?></a></h2>
				<?php endif; ?>

				<?php if ( is_single() ) : ?>
					<h2 class="entry-title"><?php echo get_the_content(); ?></h2>
				<?php endif; ?>

				<span><?php the_title(); ?></span>
			</div>

			<?php collars_post_meta_footer(); ?>
		</header><!-- .entry-header -->
		
		<?php 
		if( is_single() && has_tag() && ot_get_option('post_tags') != 'off' ) {
			the_tags( '<div class="tag-links"><span>','</span><span>','</span></div>' ); 
		} ?>
		<?php collars_post_slope_bot(); ?>

	</article><!-- #post-<?php the_ID(); ?> -->