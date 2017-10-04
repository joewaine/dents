<div class="masonry">
	<div class="row masonry__container">
		<?php
			if ( have_posts() ) : while ( have_posts() ) : the_post();
			
				/**
				 * Get blog posts by blog layout.
				 */
				get_template_part('loop/content-post', 'search');
			
			endwhile;	
			else : 
				
				/**
				 * Display no posts message if none are found.
				 */
				get_template_part('loop/content','none');
				
			endif;
		?>
	</div>
</div>

<?php get_template_part('inc/content-post', 'pagination'); ?>