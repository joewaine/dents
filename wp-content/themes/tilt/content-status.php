<?php
/**
 * The template for displaying posts in the Status post format
 *
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post-entry clearfix'); ?> role="article">
		
		<?php collars_post_links(); ?>
		<?php collars_post_slope_top(); ?>

		<header class="post-entry-header">
			<div class="status-text">
				<?php if( is_single() ) : ?>
					<h2 class="entry-title"><?php the_title(); ?></h2>
					<span><?php echo the_excerpt(); ?></span>
				<?php else : ?>
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tilt' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					<span><?php echo the_excerpt(); ?></span>
				<?php endif; ?>
			</div>
		
			<?php collars_post_meta_footer(); ?>
		</header><!-- .entry-header -->

		<?php
		if( is_single() && has_tag() && ot_get_option('post_tags') != 'off' ) {
			the_tags( '<div class="tag-links"><span>','</span><span>','</span></div>' ); 
		} ?>
		<?php collars_post_slope_bot(); ?>

	</article><!-- #post-<?php the_ID(); ?> -->