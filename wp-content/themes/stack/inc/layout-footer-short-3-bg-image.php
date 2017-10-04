<?php $image = get_option('stack_footer_background_image'); ?>

<footer class="footer-3 text-center-xs space--xs imagebg">
	
	<?php if( $image ) : ?>
		<div class="background-image-holder">
			<img src="<?php echo esc_url($image); ?>" alt="Footer Background" />
		</div>
	<?php endif; ?>
	
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<?php get_template_part('inc/content-footer', 'logo'); ?>
			</div>
			<div class="col-sm-6 text-right text-center-xs">
				<?php get_template_part('inc/content-footer', 'social'); ?>
			</div>
		</div><!--end of row-->
		<div class="row">
			<div class="col-sm-6">
				<p class="type--fine-print"><?php echo esc_html(get_bloginfo('description')); ?></p>
			</div>
			<div class="col-sm-6 text-right text-center-xs">
				<?php get_template_part('inc/content-footer', 'copyright'); ?>
			</div>
		</div><!--end of row-->
	</div><!--end of container-->
</footer>