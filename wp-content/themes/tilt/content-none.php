<?php
/**
 * The template for displaying a "No posts found" message
 *
 */
?>

	<header class="post-entry-header">
		<h2 class="entry-title"><?php _e( 'Nothing Found', 'tilt' ); ?></h2>
	</header>

	<div class="entry-content">
	<div class="row-inner">
		<?php if ( is_search() ) : ?>
		
		<p><?php _e( 'Sorry, but nothing matched your search terms. Please check your spelling or try again with some different keywords.', 'tilt' ); ?></p>
			<?php the_widget( 'WP_Widget_Search' ); ?>
			<?php get_search_form(); ?>

		<?php else : ?>

		<p class="no-posts"><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help. <br/> Type some text and hit enter.', 'tilt' ); ?></p>
			<?php the_widget( 'WP_Widget_Search' ); ?>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div>	
	</div>
