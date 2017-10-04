<?php
require realpath(__DIR__.'/../../..').'/wp-load.php';
function sn_updater(){ 
	global $wpdb;
	
	$function_call = $_POST['function_call'];
	$id            = $_POST['param2'];
	$style         = $_POST['param'];
	$lock          = $_POST['param3'];
	$note 		   = $_POST['param4'];

	if($function_call == "lock") {
		update_post_meta( $id, 'lock_notes_on', sanitize_text_field($lock) );
	} elseif($function_call == "move") {
		update_post_meta( $id, 'notes-position', sanitize_text_field($style) );
	} elseif ($function_call == "resize") {
		update_post_meta( $id, 'textarea-size', sanitize_text_field($style) );
	} elseif ($function_call == "note") {
		update_post_meta( $id, 'note', sanitize_text_field($note) );
	} elseif ($function_call == "toggle_notes_in_admin_bar") {
		update_option('admin_bar_notes', $id);
	}
	//echo $style. " ID: ".$id;   
}
sn_updater();