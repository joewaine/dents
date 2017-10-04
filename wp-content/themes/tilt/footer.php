	</div><!-- #main  -->

	<?php get_sidebar('footer'); ?>
	
	<nav id="mobile-site-navigation" role="navigation">
		<?php
		if ( has_nav_menu( 'mobile' ) ) {
			wp_nav_menu( array( 'theme_location' => 'mobile', 'container' => false ) );
		} else {
			wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false ) );
		}
		?>

	</nav><!-- #mobile-site-navigation -->

	<?php if (ot_get_option('scroll_to_top_button') == 'on'){
		echo    '<a href="#top" class="scrollToTop invisible">
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 200.387 200.387" style="enable-background:new 0 0 200.387 200.387;" xml:space="preserve">
					<polygon points="5.504,154.449 0,149.102 100.197,45.938 200.387,149.102 194.893,154.449 100.197,56.947         "/>
					<polygon points="100.197,45.938 0,149.102 5.504,154.449 100.197,56.947 194.893,154.449 200.387,149.102     "/>
				</svg>
			</a>';
	} ?>
	
</div><!-- #wrapper -->


<?php echo ot_get_option('code_before_body'); ?>
<?php wp_footer(); ?>
</body>
</html>