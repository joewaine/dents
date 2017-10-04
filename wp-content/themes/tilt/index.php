<?php get_header(); ?>

<?php
if ( get_post_type( get_the_ID() ) === 'portfolio' ) {
	$layout = ot_get_option('portfolio_archive_layout');
} else {
	$layout = ot_get_option('blog_layout');
}
?>

		<div id="container" class="row-inner">
			<?php if( $layout === 'full-width' ) : ?>
		
				<div id="content">

					<?php
					if ( have_posts() ) :
						if ( is_archive() ) {
							if ( get_post_type( get_the_ID() ) === 'portfolio' ) {
								$grid_layout = ot_get_option('portfolio_archive_grid_layout');
							} else {
								$grid_layout = ot_get_option('archive_grid_layout');
							}
						} else {
							$grid_layout = ot_get_option('blog_grid_layout');
						}
						if ( $grid_layout !== '' ) {
							$post_array = array();
							while ( have_posts() ) : the_post();
								$post_array[] = $post->ID;
							endwhile;
							echo do_shortcode( '[ess_grid alias="'.esc_attr($grid_layout).'" posts='.implode(',', $post_array).']' );
						} else {
							while ( have_posts() ) : the_post();
								get_template_part( 'content', get_post_format() );
							endwhile;
						}
					else :
						get_template_part( 'content', 'none' );
					endif;
					?>
					
					<nav class="post-navigation" role="navigation">
						<?php posts_nav_link(' ', __('Newer posts', 'tilt'), __('Older posts', 'tilt'));?>
					</nav>

				</div><!-- #content -->
				
			<?php else : ?>

				<div id="content" class="<?php if( $layout == 'right-sidebar' ) { echo 'float-left'; } else { echo 'float-right'; } ?>">

					<?php
					if ( have_posts() ) :
						if ( is_archive() ) {
							if ( get_post_type( get_the_ID() ) === 'portfolio' ) {
								$grid_layout = ot_get_option('portfolio_archive_grid_layout');
							} else {
								$grid_layout = ot_get_option('archive_grid_layout');
							}
						} else {
							$grid_layout = ot_get_option('blog_grid_layout');
						}
						if ( $grid_layout !== '' ) {
							$post_array = array();
							while ( have_posts() ) : the_post();
								$post_array[] = $post->ID;
							endwhile;
							echo do_shortcode( '[ess_grid alias="'.esc_attr($grid_layout).'" posts='.implode(',', $post_array).']' );
						} else {
							while ( have_posts() ) : the_post();
								get_template_part( 'content', get_post_format() );
							endwhile;
						}
					else :
						get_template_part( 'content', 'none' );
					endif;
					?>
					
					<nav class="post-navigation" role="navigation">
						<?php posts_nav_link(' ', __('Newer posts', 'tilt'), __('Older posts', 'tilt'));?>
					</nav>

				</div><!-- #content -->

				<div id="sidebar" class="<?php if( $layout == 'right-sidebar' ) { echo 'float-right'; } else { echo 'float-left'; } ?>">
					<?php get_sidebar('blog'); ?>
				</div>
			<?php endif; ?>
		</div><!-- #container -->

<?php get_footer(); ?>