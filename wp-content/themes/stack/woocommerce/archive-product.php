<?php 
	/**
	 * @author  TommusRhodus
	 * @version 9.9.9
	 */
	get_header(); 
	
	echo ebor_breadcrumb_section( get_option('stack_shop_title', 'Our Shop') );
?>

<section class="space--sm">
	<div class="container">
		<?php get_template_part('loop/loop-product', get_option('stack_shop_layout', 'column-3')); ?>
	</div><!--end of container-->
</section>
            
<?php get_footer();