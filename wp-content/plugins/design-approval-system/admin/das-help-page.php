<?php function das_help_page(){ ?>
	<div class="das-help-admin-wrap">
		<a class="buy-extensions-btn" href="http://www.slickremix.com/downloads/category/design-approval-system/" target="_blank"><?php _e('Premium Extension', 'design-approval-system') ?></a>
		<h2><?php _e('DAS System Info', 'design-approval-system') ?></h2>
		<div class="das-admin-help-wrap">
            <h3><?php _e("System Info", "design-approval-system") ?></h3>
            <p>
                <?php _e( 'Please click the box below and copy the report. You will need to paste this information along with your question in our', 'design-approval-system' ); ?>
                <a href="http://www.slickremix.com/support/" target="_blank">
                    <?php _e( 'Support Ticket System', 'design-approval-system' ); ?>
                </a>.
                <?php _e( 'Ask your question then paste the copied text below it.  To copy the system info, click below then press Ctrl + C (PC) or Cmd + C (Mac).', 'design-approval-system' ); ?>
            </p>

            <textarea readonly="readonly" onclick="this.focus();this.select()" id="system-info-textarea" name="fts-sysinfo" title="<?php _e( 'To copy the system info, click here then press Ctrl + C (PC) or Cmd + C (Mac).', 'design-approval-system' ); ?>">
### Begin System Info ###
                <?php
                $theme_data = wp_get_theme();
                $theme      = $theme_data->Name . ' ' . $theme_data->Version; ?>

SITE_URL:                 <?php echo site_url() . "\n"; ?>
Design Approval System Version: <?php echo dasystem_version(). "\n"; ?>

-- Wordpress Configuration:

WordPress Version:        <?php echo get_bloginfo( 'version' ) . "\n"; ?>
Multisite:                <?php echo is_multisite() ? 'Yes' . "\n" : 'No' . "\n" ?>
Permalink Structure:      <?php echo get_option( 'permalink_structure' ) . "\n"; ?>

Active Theme:             <?php echo $theme . "\n"; ?>
PHP Memory Limit:         <?php echo ini_get( 'memory_limit' ) . "\n"; ?>
WP_DEBUG:                 <?php echo defined( 'WP_DEBUG' ) ? WP_DEBUG ? 'Enabled' . "\n" : 'Disabled' . "\n" : 'Not set' . "\n" ?>

-- Webserver Configuration:

PHP Version:              <?php echo PHP_VERSION . "\n"; ?>
Web Server Info:          <?php echo $_SERVER['SERVER_SOFTWARE'] . "\n"; ?>

-- PHP Configuration:

Safe Mode:                <?php echo ini_get( 'safe_mode' ) ? "Yes" : "No\n"; ?>
Upload Max Size:          <?php echo ini_get( 'upload_max_filesize' ) . "\n"; ?>
Post Max Size:            <?php echo ini_get( 'post_max_size' ) . "\n"; ?>
Upload Max Filesize:      <?php echo ini_get( 'upload_max_filesize' ) . "\n"; ?>
Time Limit:               <?php echo ini_get( 'max_execution_time' ) . "\n"; ?>
Max Input Vars:           <?php echo ini_get( 'max_input_vars' ) . "\n"; ?>
Allow URL File Open:      <?php echo ( ini_get( 'allow_url_fopen' ) ) ? 'On (' . ini_get( 'display_errors' ) . ')' : 'N/A'; ?><?php echo "\n"; ?>
Display Erros:            <?php echo ( ini_get( 'display_errors' ) ) ? 'On (' . ini_get( 'display_errors' ) . ')' : 'N/A'; ?><?php echo "\n"; ?>

-- PHP Extensions:

FSOCKOPEN:                <?php echo ( function_exists( 'fsockopen' ) ) ? 'Your server supports fsockopen.' : 'Your server does not support fsockopen.'; ?><?php echo "\n"; ?>
cURL:                     <?php echo ( function_exists( 'curl_init' ) ) ? 'Your server supports cURL.' : 'Your server does not support cURL.'; ?><?php echo "\n"; ?>

-- Active Plugins:

<?php $plugins = get_plugins();
$active_plugins = get_option( 'active_plugins', array() );
foreach ( $plugins as $plugin_path => $plugin ) {
// If the plugin isn't active, don't show it.
                    if ( ! in_array( $plugin_path, $active_plugins ) )
continue;
echo $plugin['Name'] . ': ' . $plugin['Version'] ."\n";
                }
if ( is_multisite() ) :
                    ?>

-- Network Active Plugins:

                    <?php
$plugins = wp_get_active_network_plugins();
$active_plugins = get_site_option( 'active_sitewide_plugins', array() );

foreach ( $plugins as $plugin_path ) {
$plugin_base = plugin_basename( $plugin_path );

                        // If the plugin isn't active, don't show it.
if ( ! array_key_exists( $plugin_base, $active_plugins ) )
continue;

$plugin = get_plugin_data( $plugin_path );

echo $plugin['Name'] . ' :' . $plugin['Version'] ."\n";
                    }
endif;
                ?>

### End System Info ###</textarea>

            <h3><?php _e("Restart Tour", "design-approval-system") ?></h3>
			<div class="use-of-plugin">
				<ol>
					<li><a href="#" id="das-retake-tour"><strong><?php _e("Design Approval System Tour", "design-approval-system") ?></strong></a></li>
				</ol>
			</div>
			<script type="text/javascript">
				jQuery('#das-retake-tour').click(function () {
					//  alert('something');
					jQuery.ajax({
						type: 'POST',
						url: myAjax.ajaxurl,
						//function/addaction call from functions in plugin
						data: {action: "dasplugin_wp_pointers_remove" },
						success: function(data){
							// alert(data);
							console.log('ReTour Worked');
							window.location.href = 'plugins.php';
							return data;
						}
					});
					return false;
				});
			</script>
			<h3><?php _e("FAQs and Tips", "design-approval-system") ?></h3>
			<div class="das-admin-help-faqs-wrap use-of-plugin">
				<ol>
					<li><a href="https://www.slickremix.com/design-approval-system-docs" target="_blank"><?php _e("I'd like to see some Design Approval System Documentation.", "design-approval-system") ?></a></li>
					<li><a href="https://www.slickremix.com/support/" target="_blank"><?php _e("I need Design Approval System Support.", "design-approval-system") ?></a></li>
					<li><a href="https://www.slickremix.com/downloads/category/design-approval-system/" target="_blank"><?php _e("Show me where to get the premium extension for this plugin.", "design-approval-system") ?></a></li>
				</ol>
			</div><!--/das-admin-help-faqs-wrap-->


		</div><!--/das-admin-help-faqs-wrap-->

	</div><!--/das-help-admin-wrap-->
	<?php
}
?>