<?php
/*	
*	---------------------------------------------------------------------
*	TWC Footer sidebar
*	--------------------------------------------------------------------- 
*/
?>

<?php $full_width = ' ' . ot_get_option('footer_layout') ?>

<footer class="site-footer">
	<div class="wpb_row">
		<?php if ( is_active_sidebar( 'footer-widget-area-1' ) || is_active_sidebar( 'footer-widget-area-2' ) || is_active_sidebar( 'footer-widget-area-3' ) || is_active_sidebar( 'footer-widget-area-4' )  || is_active_sidebar( 'footer-widget-area-5' )  ) : ?>
			<div class="footer-sidebar">
				<div class="row-inner<?php echo $full_width ?>">
					<?php if ( is_active_sidebar( 'footer-widget-area-1' ) ) : ?>
						<div class="<?php echo ot_get_option('footer_columns', 'vc_col-sm-6') ?>">
							<div class="widget-area">
								<?php dynamic_sidebar( 'footer-widget-area-1' ); ?>
							</div>
						</div>
					<?php endif; ?>

					<?php if ( is_active_sidebar( 'footer-widget-area-2' ) ) : ?>
						<div class="<?php echo ot_get_option('footer_columns', 'vc_col-sm-6') ?>">
							<div class="widget-area">
								<?php dynamic_sidebar( 'footer-widget-area-2' ); ?>
							</div>	
						</div>
					<?php endif; ?>

					<?php if ( is_active_sidebar( 'footer-widget-area-3' ) ) : ?>
						<div class="<?php echo ot_get_option('footer_columns', 'vc_col-sm-6') ?>">
							<div class="widget-area">
								<?php dynamic_sidebar( 'footer-widget-area-3' ); ?>
							</div>	
						</div>
					<?php endif; ?>

					<?php if ( is_active_sidebar( 'footer-widget-area-4' ) ) : ?>
						<div class="<?php echo ot_get_option('footer_columns', 'vc_col-sm-6') ?>">
							<div class="widget-area">
								<?php dynamic_sidebar( 'footer-widget-area-4' ); ?>
							</div>	
						</div>
					<?php endif; ?>

<?php if ( is_active_sidebar( 'footer-widget-area-5' ) ) : ?>
						<div class="<?php echo ot_get_option('footer_columns', 'vc_col-sm-6') ?>">
							<div class="widget-area">
								<?php dynamic_sidebar( 'footer-widget-area-5' ); ?>
							</div>	
						</div>
					<?php endif; ?>


				</div><!-- .row-inner -->
			</div><!-- .footer-sidebar -->
		<?php endif; ?>	
		
		<?php if ( is_active_sidebar( 'copyright-widget-area' ) ) : ?>	
			<div class="site-info">
				<div class="row-inner<?php echo $full_width ?>">
					<div class="copyright-inner">
						<?php dynamic_sidebar( 'copyright-widget-area' ); ?>
					</div>
				</div>
			</div>	
		<?php endif; ?>	
		
	</div><!-- .wpb_row -->
</footer><!-- .site-footer -->