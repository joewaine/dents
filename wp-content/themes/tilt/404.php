<?php get_header(); ?>

	<div id="container" class="no-sidebar">
		<div id="content" class="full-width">
			<article id="post-0" class="post error404 not-found clearfix" role="article">

				<div class="entry-content error-content">
					<div class="row-inner">
						<h1><?php _e( '404 ERROR', 'tilt' ); ?></h1>
						<h2><?php _e( 'Hey there mate! Sorry, but nothing here...', 'tilt' ); ?></h2>
						<p><?php _e( 'By the way, maybe searching might help?', 'tilt' ); ?></p>
						<i class="icon-magnifier error-search"></i>
						<?php get_search_form(); ?>

					</div>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->
		</div><!-- #content -->
	</div><!-- #container -->

<?php

//print_r(ot_get_option('custom_fonts'));

?>

<?php get_footer(); ?>