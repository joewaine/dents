<?php
	if( 'no' == get_option('stack_product_rating', 'no') ){
		return false;	
	}
?>

<span class="block"><?php echo wc_get_rating_html(get_the_ID()); ?></span>