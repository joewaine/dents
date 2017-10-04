<?php
/*
*	---------------------------------------------------------------------
*	TWC Register the required plugins for this theme
*	---------------------------------------------------------------------
*/

require_once(COLLARS_INCLUDE . '/plugin-activation/tgm-plugin-activation.php');

add_action( 'tgmpa_register', 'tilt_register_required_plugins' );

function tilt_register_required_plugins() {

	$plugins = array(

		array(
			'name'               => 'Tilt Visual Composer', // The plugin name.
			'slug'               => 'tilt-js_composer', // The plugin slug (typically the folder name).
			'source'             => COLLARS_PLUGINS . '/tilt-js_composer.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '5.2.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		array(
			'name'               => 'TWC Theme Extension Plugin', // The plugin name.
			'slug'               => 'core-extension', // The plugin slug (typically the folder name).
			'source'             => COLLARS_PLUGINS . '/core-extension.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '1.7.1.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		array(
			'name'               => 'Revolution Slider', // The plugin name.
			'slug'               => 'revslider', // The plugin slug (typically the folder name).
			'source'             => COLLARS_PLUGINS . '/revslider.zip', // The plugin source.
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '5.4.5.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		array(
			'name'               => 'Essential Grid', // The plugin name.
			'slug'               => 'essential-grid', // The plugin slug (typically the folder name).
			'source'             => COLLARS_PLUGINS . '/essential-grid.zip', // The plugin source.
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '2.1.6', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		array(
			'name'               => 'Contact Form 7', // The plugin name.
			'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
			'source'             => COLLARS_PLUGINS . '/contact-form-7.zip', // The plugin source.
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '4.8.1',
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => 'https://wordpress.org/plugins/contact-form-7', // If set, overrides default API URL and points to an external URL.
		),
//		array(
//            'name'               => 'Envato Toolkit', // The plugin name.
//            'slug'               => 'envato-wordpress-toolkit-master', // The plugin slug (typically the folder name).
//            'source'             => COLLARS_PLUGINS . '/envato-wordpress-toolkit-master.zip', // The plugin source.
//            'required'           => false, // If false, the plugin is only 'recommended' instead of required.
//            'version'            => '1.7.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
//            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
//            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
//            'external_url'       => 'https://github.com/envato/envato-wordpress-toolkit', // If set, overrides default API URL and points to an external URL.
//        ),
		array(
			'name'               => 'Envato Market', // The plugin name.
			'slug'               => 'envato-market', // The plugin slug (typically the folder name).
			'source'             => COLLARS_PLUGINS . '/envato-market.zip', // The plugin source.
			'required'           => false, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '1.0.0-RC2', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url'       => 'https://github.com/envato/wp-envato-market', // If set, overrides default API URL and points to an external URL.
		)

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 */

	$config = array(
		'id'           => 'tilt',                  // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to pre-packaged plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                    // Automatically activate plugins after installation or not.
		'message'      => '<div class="updated"><p><strong>VISUAL COMPOSER UPDATE INFORMATION:</strong></br></br>Please be informed that if you are willing to update <strong>Visual Composer</strong> plugin from any version older than <strong>4.12.1</strong></strong>, you need to <strong>delete your current version of the plugin first</strong> and then install the latest one from <a href="themes.php?page=tgmpa-install-plugins">Appearance > Install Plugins</a> panel.</p></div>',                      // Message to output right before the plugins table.
		'strings'      => array(
			'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		)
	);

	tgmpa( $plugins, $config );
}

/**
 * Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
 */
add_action( 'vc_before_init', 'your_prefix_vcSetAsTheme' );
function your_prefix_vcSetAsTheme() {
	vc_set_as_theme();
}