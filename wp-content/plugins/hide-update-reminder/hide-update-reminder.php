<?php
/*
Plugin Name: Hide Update Reminder
Plugin URI: http://www.stuffbysarah.net/wordpress-plugins/remove-update-reminder/
Description: Allows you to remove the upgrade Nag screen from view for anyone who cannot update the core files
Author: Sarah Anderson
Version: 1.3.1
Author URI: http://www.stuffbysarah.net/

This plugin is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License
as published by the Free Software Foundation, version 2. This plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for more details.
If you choose to copy all or portions of this code you must follow the GNU GPL rules as outlined on http://wordpress.org/about/gpl/
Thanks to Viper007Bond for the code hints.
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class HideUpdateReminder
{
	function __construct()
	{
		add_action( 'admin_init', array( $this, 'check_user' ) );
	}

	function check_user() {
		if ( ! current_user_can( 'update_core' ) ) {
			remove_action( 'admin_notices', 'update_nag', 3 );
		}
	}
}

$hideupdaterem = new HideUpdateReminder();