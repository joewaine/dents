<?php
/**
 * The template for displaying search forms
 */
?>
	<div class="searchform-overlay">
		<div class="searchform-overlay-inner">
			<div class="searchform-wrapper">
				<form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<label for="s"><?php _e( 'Type and press enter to search', 'tilt' );?></label>
					<input type="text" name="s" class="search-input" />
				</form>
			</div>
		</div>
	</div>