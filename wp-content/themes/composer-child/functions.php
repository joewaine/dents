<?php

/* *********************************************************************************************
 PLEASE DO NOT DELETE THIS FUNCTION BECAUSE THIS FUNCTION IS CALLING CHILD THIME CSS FILE
********************************************************************************************* */

function composer_child_themestyles () {
	if (!is_admin()) {		

		wp_register_style('child-theme-style', get_stylesheet_directory_uri() . '/child-theme-style.css', array('composer-plugins-stylesheet','composer-custom-css'), '1.0');	

		wp_enqueue_style('child-theme-style');
	
	}
}
add_action('wp_enqueue_scripts', 'composer_child_themestyles');

/* ******************************************************************************************** */