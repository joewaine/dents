<?php 
	global $wp_query; 
	
	if( isset($wp_query->query['post_type']) ){
		$post_type = $wp_query->query['post_type'];	
	}
?>

<?php if( isset($post_type) ) : ?>

	<h3>This <?php echo esc_html($post_type); ?> feed contains no content.</h3>
	<p>Please add some <?php echo esc_html($post_type); ?> posts to load them here.</p>
	<a href="<?php echo esc_url(admin_url('/edit.php?post_type=' . $post_type)); ?>" class="btn btn--primary"><span class="btn__text">Add <?php echo esc_html(ucfirst($post_type)); ?> Posts Now &rarr;</span></a>

<?php else : ?>

	<h3>This feed contains no content.</h3>

<?php endif; ?>
