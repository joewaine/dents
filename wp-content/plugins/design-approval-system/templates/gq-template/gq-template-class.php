<?php
namespace Design_Approval_System;



class GQ_Theme extends Design_Approval_System_Core {
	function __construct() {
		add_action('wp_enqueue_scripts', array($this,'das_gq_head'));
		//Settings option. Add Padding to #Prime Wrapper. DO NOT MESS WITH SPACING BELOW.
		$das_gq_theme_custom_css_checked_padding =  get_option('das-gq-theme-options-settings-custom-css-main-wrapper-padding');
		if ($das_gq_theme_custom_css_checked_padding == '1') {
			add_action('wp_head', array($this,'das_gq_theme_head_padding'));
		}
		//Settings option. Add Custom CSS to the header of gq theme pages only
		$das_gq_theme_custom_css_checked_css =  get_option( 'das-gq-theme-options-settings-custom-css-first' );
		if ($das_gq_theme_custom_css_checked_css == '1') {
			add_action('wp_head', array($this,'das_gq_theme_head_css'));
		}
		//Settings option. Add Padding to #Prime Wrapper. DO NOT MESS WITH SPACING BELOW.
		$das_gq_theme_settings_custom_css =  get_option('das-gq-theme-settings-custom-css');
		if ($das_gq_theme_settings_custom_css == '1') {
			add_action('wp_head', array($this,'das_gq_theme_custom_override_css'));
		}
		if (isset($dasSettingsSmtp)&& $dasSettingsSmtp == '1') {
			// SMTP Option https://codex.wordpress.org/Plugin_API/Action_Reference/phpmailer_init
			add_action('phpmailer_init', array($this, 'my_phpmailer'));
			add_action( 'phpmailer_init', array($this, 'WCMphpmailerException'));
		}

	}
	function my_phpmailer($phpmailer){
		$das_smtp_checkbox_authenticate = get_option('das-smtp-checkbox-authenticate');

		//SMTP Authenticate?
		if ($das_smtp_checkbox_authenticate == '1') {
			$das_smtp_checkbox_authenticate_final = true;
		}
		else{
			$das_smtp_checkbox_authenticate_final = false;
		}

		$phpmailer->IsSMTP();  // telling the class to use SMTP
		$phpmailer->SMTPDebug  = 1;
		$phpmailer->SMTPAuth   = $das_smtp_checkbox_authenticate_final;
		$phpmailer->SMTPSecure = get_option( 'das-settings-das-ssl-or-tls-option');
		$phpmailer->Port       = get_option( 'das-smtp-port' );
		$phpmailer->Host       = get_option( 'das-smtp-server' );
		$phpmailer->Username   = get_option( 'das-smtp-authenticate-username' );
		$phpmailer->Password   = get_option( 'das-smtp-authenticate-password' );
	}

	//**************************************************
	// Add Premium functions
	//**************************************************
	function  das_gq_head() {
		global $post_type;
		if( 'designapprovalsystem' == $post_type ) {
			wp_register_style( 'das-gq-theme-styles', plugins_url( 'gq-template/css/styles.css', dirname(__FILE__) ) );
			wp_enqueue_style('das-gq-theme-styles');
			wp_register_style( 'das-gq-theme-font-aweseom-min', plugins_url( 'gq-template/css/font-awesome.min.css', dirname(__FILE__) ) );
			wp_enqueue_style('das-gq-theme-font-aweseom-min');
			wp_register_style( 'das-gq-theme-popup', plugins_url( 'gq-template/css/magnific-popup.css', dirname(__FILE__) ) );
			wp_enqueue_style('das-gq-theme-popup');
			// this is the new way to fire the upload option
			//   wp_enqueue_media();
			//  wp_enqueue_script('jquery');
			wp_register_script('das-gq-theme-jqueryform', plugins_url('design-approval-system/templates/slickremix/js/jquery.form.js'));
			wp_enqueue_script('das-gq-theme-jqueryform');
			wp_register_script('das-gq-theme-magnificpopupjs', plugins_url('design-approval-system/templates/gq-template/js/jquery.magnific-popup.js'));
			wp_enqueue_script('das-gq-theme-magnificpopupjs');
			wp_register_script('das-gq-theme-ajaxValidate', plugins_url('design-approval-system/templates/gq-template/js/jquery.validate.min.js'));
			wp_enqueue_script('das-gq-theme-ajaxValidate');
			wp_register_script('das-gq-theme-ajaxcomments', plugins_url('design-approval-system/templates/gq-template/js/ajax-comments.js'));
			wp_enqueue_script('das-gq-theme-ajaxcomments');
		}
	}
	//**************************************************
	// GQ Theme Head Padding
	//**************************************************
	function  das_gq_theme_head_padding() {
		$das_gq_theme_custom_css_padding =  get_option('das-gq-theme-main-wrapper-padding-input');
		$das_gq_theme_custom_css_margin =  get_option('das-gq-theme-main-wrapper-margin-input');
		$das_gq_theme_custom_css_max_width =  get_option('das-gq-theme-main-wrapper-width-input');
		$output = '<style type="text/css">';
		$output .= '.das-main-template-wrapper-all {';
		//padding
		$output .= !empty($das_gq_theme_custom_css_padding) ? 'padding: '.get_option('das-gq-theme-main-wrapper-padding-input').' !important;' : '';
		//margin
		$output .= !empty($das_gq_theme_custom_css_margin) ? 'margin: '.get_option('das-gq-theme-main-wrapper-margin-input').' !important;' : '';
		//max width
		$output .= !empty($das_gq_theme_custom_css_max_width) ? 'max-width: '.get_option('das-gq-theme-main-wrapper-width-input').' !important;' : '';
		$output .= '}</style>';
		echo $output;
	}
	//**************************************************
	// GQ Theme Custom CSS (from settings page)
	//**************************************************
	function  das_gq_theme_head_css() {
		echo '<style type="text/css">'.get_option('das-gq-theme-main-wrapper-css-input').'</style>';
	}
	//**************************************************
	// GQ Theme Custom Override CSS (from settings page)
	//**************************************************
	function  das_gq_theme_custom_override_css() {
		$output = '<style>';
		$output .= '.das-main-template-wrapper [class^="icon-"], .das-main-template-wrapper [class*=" icon-"] {
            color: #'.get_option('das-gq-theme-project-icon-color').' !important;
        }
        .das-template-box-1header, .das-template-box-2header, .das-template-box-3header, .das-template-box-4header {
            color: #'.get_option('das-gq-theme-project-main-header-text-color').';
            background: #'.get_option('das-gq-theme-project-main-header-background-color').';
        }
        .das-template-box-1-frame a, .das-template-box-2-frame a, .das-template-box-3-frame a, .das-template-box-4-frame a, .das-frame-logout-btn a {
            color: #'.get_option('das-gq-theme-project-text-link-color').' !important;
        }
        .das-template-box-1-frame a:hover, .das-template-box-2-frame a:hover {
            color: #'.get_option('das-gq-theme-project-text-main-btns-hover').' !important;
        }
        .das-template-box-1-frame .das-frame-inside a:hover, .das-template-box-2-frame .das-frame-inside a:hover {
            background:#'.get_option('das-gq-theme-project-background-main-btns-hover').' !important;
        }
        .das-template-box-1-frame, .das-template-box-2-frame, .das-template-box-3-frame, .das-template-box-4-frame {
            border: 1px solid #'.get_option('das-gq-theme-project-border-color').';
            color:#'.get_option('das-gq-theme-project-text-color').';
        }
        .das-template-box-1-frame, .das-template-box-2-frame, .das-box-3-frame-inside, .das-box-4-frame-inside {
            background:#'.get_option('das-gq-theme-project-background-color-boxes').' !important;
        }
        .das-box-4-frame-inside ul.das-comment-list li:nth-child(even) {
            background-color: #'.get_option('das-gq-theme-project-background-color-even-comment-boxes').'; 
        }
        </style>';
		echo $output;
	}
	//****************************************************************************************************
	// Check Current User Role additional security check so clients can't view other clients projects
	//****************************************************************************************************
	function das_get_current_user_role_gq_theme() {
		global $wp_roles;
		$current_user = wp_get_current_user();
		$roles = $current_user->roles;
		$role = array_shift($roles);
		return isset($wp_roles->role_names[$role]) ? translate_user_role($wp_roles->role_names[$role] ) : false;
	}
	function das_get_current_redirect_user() {
		global $wp_roles, $post;
		$current_user = wp_get_current_user();
		$current_user_role = $this->das_get_current_user_role_gq_theme();

        // OLD method we need to keep for existing users
        $emailCheckerCurrentUser = $current_user->user_email;
        $emailCheckeronPage = get_post_meta($post->ID, 'custom_clients_email', true);

        // NEW method check we are adding on top of the old one,
        // because now we are allowing the designer to change the client email on a different design if they want too.
		$emailChecker2CurrentUser = $current_user->user_login;
		$emailChecker2onPage = get_post_meta($post->ID, 'custom_client_name', true);

		if($current_user_role == 'DAS Client') {
			if ($emailCheckerCurrentUser == $emailCheckeronPage || $emailChecker2CurrentUser == $emailChecker2onPage ){
			    //show the page
			}
			else {
                wp_redirect(home_url()); exit;
            }
		}
	}
	//**************************************************
	// Build and Display GQ Theme
	//**************************************************
	function GQ_Theme_Display() {
		global $post;

		$this->das_get_current_redirect_user();


		if (!is_user_logged_in() && get_option('das-gq-theme-settings-project-board-login-link') == TRUE && get_option('das-settings-approve-login-overide') !== '1') {
			wp_redirect(get_option('das-gq-theme-settings-project-board-login-link') . '?das_redirect=yes&redirect_to='.get_permalink()); exit;
		}
		elseif(!is_user_logged_in() && get_option('das-settings-approve-login-overide') !== '1') {

			wp_redirect(wp_login_url(get_permalink())); exit;
		}




		//WordPress Header
		get_header();
		if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<div class="das-main-template-wrapper-all">
			<div class="designers-photo-wrap">
				<div class="designers-photo-content"> <?php echo the_content() ?> </div><!--/designers-photo-content-->
				<div class="clear"></div>
			</div><!--designers-photo-wrap-->
			<div class="show-notes"><?php _e('Expand Menu', 'design-approval-system') ?></div>
			<div class="das-main-template-wrapper">
			<?php
			/********************************************************
			das-template-box-1
			 ********************************************************/
			?>
			<div class="das-template-box-1">
				<div class="das-template-box-1-content">
					<div class="das-template-box-1header"><i class="icon-file-text"></i> <?php echo get_post_meta($post->ID, 'custom_name_of_design', true); ?></div>
					<div class="das-template-box-1-frame"><div class="das-btn-backg">
							<?php if (get_option( 'das-gq-theme-settings-project-board-btn' ) == '1') { ?><div class="das-frame-inside"><a class="das-gq-theme-project-board-btn default-das-btn" href="<?php if (get_option( 'das-gq-theme-settings-project-board-btn-link' ) == '') {  echo admin_url( 'edit.php?post_type=designapprovalsystem&page=design-approval-system-projects-page', 'http' );
								}
								else	{  echo get_option( 'das-gq-theme-settings-project-board-btn-link' );
								}
								?>"><?php if (get_option( 'das-gq-theme-settings-project-board-btn-custom-name' )) { print get_option( 'das-gq-theme-settings-project-board-btn-custom-name' ); } else { _e('Project Board', 'design-approval-system'); } ?></a></div><!--das-frame-inside-->
								<!-- get_option( 'das-gq-theme-settings-project-board-btn-link' ); -->
								<?php
							}
							?>
							<?php
							//Check terms are set and show the terms buttons or not
							$custom_design_terms_button = get_post_meta($post->ID, 'custom_gq-theme-terms-conditions', true);
							$global_terms_button = get_option('das-gq-theme-main-wrapper-custom-terms');
							$terms_custom_title = get_option('das-gq-theme-settings-terms-title');
							if ($custom_design_terms_button || $global_terms_button) {
								?> <div class="das-frame-inside"><a href="javascript:;" class="default-das-btn das-terms-conditions-btn">
										<?php if ($terms_custom_title) {
											echo get_option('das-gq-theme-settings-terms-title');
										}
										else {
											_e('Terms', 'design-approval-system');
										}
										?>
									</a></div><!--das-frame-inside--><?php
							}
							?>
							<div class="das-frame-inside das-versions-history"><a href="javascript:;" class="versions das-versions-btn"><?php echo get_post_meta($post->ID, 'custom_version_of_design', true); // the next number after the / comes from our jquery count of li's in the version popup?> / </a></div><!--das-frame-inside-->
						</div><!--das-btns-backg-->
						<div class="clear"></div>
					</div><!--das-template-box-1-frame-->
				</div><!--das-template-box-1-content-->
			</div><!--das-template-box-1-->
			<?php
			/********************************************************
			das-template-box-2
			 ********************************************************/
			?>
			<div class="das-template-box-2">
				<div class="das-template-box-2-content">

					<?php $login_required = get_post_meta($post->ID, 'custom_login_no_login', true);
					if(is_user_logged_in()) { ?>
						<div class="das-frame-logout-btn"><a href="<?php echo wp_logout_url( get_permalink() ); ?>" class="logout-btn"><?php _e('Logout', 'design-approval-system'); ?></a></div><!--das-frame-logout-btn-->
					<?php } ?>
					<div class="das-template-box-2header"><i class="icon-edit"></i> <?php
						if (get_option( 'das-gq-theme-settings-client-options-title' ) == '') { ?>
							<?php _e('Design Options', 'design-approval-system'); ?>
							<?php
						}
						else	{  echo get_option( 'das-gq-theme-settings-client-options-title' );
						}
						?>
					</div>
					<div class="das-template-box-2-frame">
						<div class="das-btn-backg">
							<?php

							if (get_option( 'das-gq-theme-client-changes-global' ) == '1') {
								$comment_status = 'no';
							}
							else {
								$comment_status = get_post_meta($post->ID, 'das_global_comment_status_meta', true);
							}



							$alreadyapproved = get_post_meta($post->ID, 'custom_client_approved', true);
                            $alreadyapprovedManager = get_post_meta($post->ID, 'custom_manager_approved', true);

							if ($alreadyapproved == 'Yes' || $alreadyapprovedManager == "Yes") { ?>
								<div class="das-frame-inside"><div class="approved-wrap default-das-btn"><?php _e('Approved', 'design-approval-system'); ?></div></div><?php
							}
							else { ?>
								<div class="das-frame-inside <?php if($comment_status == 'no') {?>das-frame-inside-60<?php } ?>"><div class="not-approved-wrap"><a href="javascript:;" class="design-option-btn design-approval-btn-gq default-das-btn">
											<?php if(get_option('das-gq-theme-client-changes-global') == '1')
											{ _e('Approve or Request Changes', 'design-approval-system');
											}
											else { _e('Approve', 'design-approval-system'); } ?></a></div><div class="approved-wrap default-das-btn" style="display:none"><?php _e('Approved', 'design-approval-system'); ?></div></div>
							<?php }
							if(get_option( 'das-gq-theme-client-changes-global' ) !== '1' && is_user_logged_in() == true && comments_open() == '1') { ?>
								<div class="das-frame-inside"><a href="javascript:;" class="design-option-btn design-revision-btn-gq default-das-btn"><?php _e('Comment', 'design-approval-system'); ?></a></div><!--.das-frame-inside-->
							<?php } ?>

							<div class="das-frame-inside <?php if($comment_status == 'no') {?>das-frame-inside-40<?php } ?>"><a href="javascript:;" class="hide-notes"><?php _e('Hide Menus', 'design-approval-system'); ?></a></div>
						</div><!--das-btns-backg-->
						<div class="clear"></div>
					</div><!--das-template-box-2-frame-->
				</div><!--das-template-box-2-content-->
			</div><!--das-template-box-2-->
			<?php
			/********************************************************
			das-template-box-3
			 ********************************************************/
			?>
			<div class="das-template-box-3">
				<div class="das-template-box-3-content">
					<div class="das-template-box-3header"><i class="icon-list-alt"></i>
						<?php
						if (get_option( 'das-gq-theme-settings-title' ) == '') { ?>
							<?php  _e('Project Details', 'design-approval-system'); ?>
							<?php
						}
						else	{  echo get_option( 'das-gq-theme-settings-title' );
						}
						?></div>
					<div class="das-template-box-3-frame">
						<div class="das-box-3-frame-inside">
							<div class="das-row-wrap"><div class="das-col1">
									<?php
                                    $das_manager_client_version = get_post_meta($post->ID, 'custom_manager_name', true);
                                    if (!empty($das_manager_client_version)) {
                                        _e('Manager:', 'design-approval-system');
                                    }
                                    else {
                                        if (get_option('das-gq-theme-settings-client-notes-name') == '') {
                                            _e('Client:', 'design-approval-system'); ?><?php } else {
                                            echo get_option('das-gq-theme-settings-client-notes-name'); ?>:<?php
                                        }
                                    }?></div><div class="das-col2"><?php if (!empty($das_manager_client_version)) { echo get_post_meta($post->ID, 'custom_manager_name', true);} else { echo get_post_meta($post->ID, 'custom_client_name', true);}?>
                                </div></div>
							<div class="das-row-wrap"><div class="das-col1">
									<?php if ( get_option('das-gq-theme-settings-designer-name-title') == '') { ?><?php _e('Designer:', 'design-approval-system'); ?>
									<?php } else {
										echo get_option( 'das-gq-theme-settings-designer-name-title' );?>:<?php
									}?></div><div class="das-col2"><?php echo get_post_meta($post->ID, 'custom_designers_name', true); ?></div></div>
							<div class="das-row-wrap"><div class="das-col1"><?php _e('Project Name:', 'design-approval-system'); ?></div><div class="das-col2"><?php echo get_post_meta($post->ID, 'custom_name_of_design', true); ?></div></div>
							<div class="das-row-wrap"><div class="das-col1"><?php _e("Today's Date:", 'design-approval-system'); ?></div><div class="das-col2"><?php echo date_i18n('l, F jS, Y \a\t g:ia'); ?></div></div>
							<?php if (get_post_meta($post->ID, 'custom_project_start_end', true) == '') { ?>
							<?php }
							else { ?>
								<div class="das-row-wrap"><div class="das-col1"><?php _e('Project Due:', 'design-approval-system'); ?></div><div class="das-col2"><?php echo get_post_meta($post->ID, 'custom_project_start_end', true); ?></div></div>
							<?php	} ?>
							<div class="das-row-wrap"><div class="das-col1"><?php _e('Version:', 'design-approval-system'); ?></div><div class="das-col2 das-versions-col"><?php echo get_post_meta($post->ID, 'custom_version_of_design', true);  _e(' of', 'design-approval-system');?> </div></div>
							<?php if (get_post_meta($post->ID, 'custom_designer_notes', true) == '') { ?>
							<?php }
							else { ?>
								<div class="das-row-wrap" style="display:none;"><div class="das-col1"><?php _e('Project Brief:', 'design-approval-system'); ?></div><div class="das-col2 das-project-brief"><?php echo get_post_meta($post->ID, 'custom_designer_notes', true); ?></div></div>

							<?php	}


							$das_custom_invoice_attach = get_post_meta($post->ID, 'custom_invoice_attach', true);
							if ($das_custom_invoice_attach !== '') { ?>
								<div class="das-row-wrap">

								<div class="das-col1"><strong><?php

										$invoice_custom_title = get_option('das-view-invoice-title');
										$invoice_custom_text = get_option('das-view-invoice-text');

										if ($terms_custom_title) {
											echo get_option('das-view-invoice-title');
										}
										else {
											_e('Invoice:', 'design-approval-system');
										}
										?></strong></div>

								<div class="das-col2">

								<div class="das-custom-template-checkout-buttons-wrap">

								<?php


								if($das_custom_invoice_attach !== '') { ?>
									<div class="das-view-invoice-btn"><a href="<?php echo $das_custom_invoice_attach ?>" target="_blank"><?php 	if ($invoice_custom_text) {
												echo get_option('das-view-invoice-title');
											}
											else {
												_e('View Invoice', 'design-approval-system');
											} ?></a></div>

									</div>
									</div>
									</div>
								<?php } }

                            // BEGIN WOO CHECKOUT BUTTON
                            // make sure woocommerce plugin is active and woo for das is active before returning shortcode
                            if(is_plugin_active('woocommerce/woocommerce.php') && is_plugin_active('das-premium/das-premium.php') ) {
                                $das_woo_product = get_post_meta($post->ID, 'das_design_woo_product_id', true);
                                $das_custom_woo_product = get_post_meta($post->ID, 'custom_woo_product', true);
                                if (!empty($das_woo_product) && $das_custom_woo_product == 'yes-woo-product') { ?>
                                    <div class="das-row-wrap"><strong>


                                            <?php if(get_post_meta($post->ID, 'custom_woo_po_text', true) == 'yes') {
                                                _e('<span class="po-extra-bold">Purchase Order:</span>', 'design-approval-system');
                                            } else {
                                                _e('Price:', 'design-approval-system');
                                            }?>

                                        </strong> <div class="main-checkout-tab"><?php echo do_shortcode('[add_to_cart id="'.$das_woo_product.'"]'); ?></div></div>

                                <?php }
                            }
                            // END WOO CHECKOUT BUTTON

							$das_postid = get_the_ID();

							if( current_user_can('das_designer') || current_user_can('administrator') ) {
								if (get_option('das-settings-email-for-designers-message-to-clients') == '') {
									$das_settings_email_for_designers_message_to_clients = __('Please review your design comp for changes and/or errors:', 'design-approval-system');
								}
								else{
									$das_settings_email_for_designers_message_to_clients = get_option('das-settings-email-for-designers-message-to-clients');
								}?>
								<?php // send the email for client to see design link and use ajax to do it, script at the bottom of the page ?>
								<form class="myform" id="sendEmailforDesigner" method="post" name="sendEmailforDesigner">
									<input type="hidden" name="postid" class="das_post_id" value="<?php echo $das_postid; ?>"/>
									<div class="das-row-wrap edit-and-send-email-options">
                                        <a href="<?php if(get_post_meta($post->ID, 'custom_manager_email', true) == TRUE){echo get_option('das-gq-theme-settings-project-board-btn-link');?>?das_post=<?php echo $post->ID; ?>&tab=2&manager=yes<?php } else { echo get_option('das-gq-theme-settings-project-board-btn-link');?>?das_post=<?php echo $post->ID; ?>&tab=2<?php }  ?>">

                                            <?php _e('Edit Post', 'design-approval-system'); ?></a> | <span id="send-email-for-designer" class="edit-link"><a href="javascript:;"><?php _e('Send Email', 'design-approval-system'); ?></a></span></span> <span id="send-email-for-designer-done"><?php _e('Thank-you. Your email has been sent.', 'design-approval-system'); ?></div>
								</form>
							<?php } ?>
							<div class="pop-up-backg"></div><!--pop-up-backg--->
							<div class="clear"></div>
						</div><!--das-box-3-frame-inside -->
					</div><!--das-template-box-3-frame-->
				</div><!--das-template-box-3-content-->
			</div><!--das-template-box-3-->
			<?php
			/********************************************************
			das-template-box-4
			 ********************************************************/
			?>
			<div class="das-template-box-4">
				<div class="das-template-box-4-content">
					<div class="das-template-box-4header"><i class="icon-comments"></i> <?php
						if(get_option( 'das-gq-theme-settings-client-notes-title' ) == '') {
                            _e('Project Comments', 'design-approval-system');
						}
						else	{
                            echo get_option( 'das-gq-theme-settings-client-notes-title' );
						}
						?></div>
					<div class="das-template-box-4-frame">
						<div class="das-box-4-frame-inside">


                            <?php if(is_plugin_active('das-manager/das-manager.php') && get_post_meta($post->ID, 'das_manager_client_version', true) !== 'yes'){

                                    $client_name =  __('Manager', 'design-approval-system');
                            }
                            else {
                                if ( get_option('das-gq-theme-settings-client-notes-name') == '') {
                                    $client_name =  __('Client', 'design-approval-system'); ?>
                                <?php }
                                else {
                                    $client_name = get_option( 'das-gq-theme-settings-client-notes-name' );?>
                                <?php }
                            }?>

                            <?php if ( get_option('das-gq-theme-settings-designer-notes-name') == '') {
                                $designer_name =  __('Designer', 'design-approval-system'); ?>
                            <?php }
                            else {
                                $designer_name = get_option( 'das-gq-theme-settings-client-notes-name' )?>
                            <?php }?>







                            <?php if (get_post_meta($post->ID, 'custom_client_approved_signature', true) !== '' && get_option('das-gq-theme-approved-comments-option') !== '1' || get_post_meta($post->ID, 'custom_manager_approved_signature', true) !== '' && get_option('das-gq-theme-approved-comments-option') !== '1') { ?>

                                    <?php if (get_post_meta($post->ID, 'custom_client_approved_date', true) !== '') { ?>
                                        <p class="custom_approved_comments_p"><strong><?php _e('Approved:', 'design-approval-system'); ?></strong> <?php echo get_post_meta($post->ID, 'custom_client_approved_signature', true); ?><br/>
                                        <strong><?php _e('Date:', 'design-approval-system'); ?></strong> <?php echo get_post_meta($post->ID, 'custom_client_approved_date', true); ?>
                                    <?php  }
                                    if (get_post_meta($post->ID, 'custom_manager_approved_date', true) !== '') { ?>
                                        <p class="custom_approved_comments_p"><strong><?php _e('Approved:', 'design-approval-system'); ?></strong> <?php echo get_post_meta($post->ID, 'custom_manager_approved_signature', true); ?><br/>
                                        <strong><?php _e('Date:', 'design-approval-system'); ?></strong> <?php echo get_post_meta($post->ID, 'custom_manager_approved_date', true); ?>
                                    <?php  }
                                if ( get_post_meta($post->ID, 'custom_manager_approved_comments', true) !== '') { ?><br/><strong><?php _e('Feedback:', 'design-approval-system'); ?></strong> <span class="custom_approved_comments_p_text"><?php echo get_post_meta($post->ID, 'custom_manager_approved_comments', true) ?></span><?php  }

                                    if (get_post_meta($post->ID, 'custom_client_approved_comments', true) !== '') { ?><br/><strong><?php _e('Feedback:', 'design-approval-system'); ?></strong> <span class="custom_approved_comments_p_text"><?php echo get_post_meta($post->ID, 'custom_client_approved_comments', true) ?></span><?php  }?>
                                    </p>
                            <?php }
                            else { ?>
                                <p class="custom_approved_comments_p custom_approved_comments_p_ajax" style="display:none"><strong><?php _e('Approved:', 'design-approval-system'); ?></strong> <span class="custom_approved_signature"></span><br/><strong><?php _e('Date:', 'design-approval-system'); ?></strong> <span class="custom_approved_date_text"></span><br/><strong><?php _e('Feedback:', 'design-approval-system'); ?></strong> <span class="custom_approved_comments_p_text"></span></p>
                            <?php } ?>





                            <?php if (get_post_meta($post->ID, 'custom_designer_notes', true) !== '') { ?>
                                <p class="custom_designer_notes_p"><strong><?php echo $designer_name ?> <?php _e('Note', 'design-approval-system'); ?></strong>  . <?php echo get_post_meta($post->ID, 'custom_designer_notes', true); ?></p>
                            <?php }
                            else { ?>
                                <p class="custom_approved_comments_p custom_designer_notes_p_ajax" style="display:none"><strong><?php _e('Designer Note', 'design-approval-system'); ?></strong>  . <span class="custom_designer_notes_p_text"></span> </p>
                            <?php  }?>

							<?php if (get_option('das-gq-theme-client-changes-global') == '1') { ?>

								<div class="custom_client_notes_div"> <?php if (get_post_meta($post->ID, 'custom_client_notes', true) !== '') { ?><strong><?php echo $client_name ?></strong> . <?php
									echo get_post_meta($post->ID, 'custom_client_notes', true); ?><?php } ?></div>


							<?php } else { require_once dirname(__FILE__) . '/framework/comments-for-each.php'; } ?>
						</div><!--das-box-4-frame-inside -->
					</div>
				</div><!--das-template-box-4-content-->
			</div><!--das-template-box-4-->
			<?php
			/********************************************************
			revision-form-wrap-gq (comments section)
			 ********************************************************/
			if(comments_open()) { ?>
				<div id="revision-form-wrap-gq">
					<div class="status-area1">
						<h2><?php _e('Comment', 'design-approval-system'); ?></h2>
						<div class="das-form-text"><?php _e('Today\'s Date:', 'design-approval-system'); ?> <?php echo date_i18n('l, F jS, Y \a\t g:ia'); ?>
							<?php
							// need to create option in settings to show this right away or show the logged in required below.
							// $comment_registration_active = get_option('comment_registration');  && is_user_logged_in()
							if ( $post->comment_status == 'open') {
								// here is the custom comment form
								$comments_args = array(
									'id_form'           => 'das-gq-commentform',
									'id_submit'         => 'das-gq-submit',
									// 'title_reply'       => __( '' , 'das-gq-theme' ),
									// 'title_reply_to'    => __( '' , 'das-gq-theme'  ),
									// 'cancel_reply_link' => __( '' , 'das-gq-theme' ),
									'label_submit'      => __( 'Post Comment' , 'design-approval-system' ),
									'comment_field' =>  '<p class="comment-form-comment"><textarea id="comment" class="required" name="comment" cols="45" rows="8" aria-required="true">' .
										'</textarea></p>',
									'must_log_in' => '',
									'logged_in_as' => '',
									'comment_notes_before' => '',
									'comment_notes_after' => '<p class="das-form-allowed-tags">' .
										sprintf(
											__( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'das-gq-theme'  ),
											' <code>' . allowed_tags() . '</code>'
										) . '</p>',
									//  'fields' => apply_filters( 'comment_form_default_fields', array(
									//    'author' =>
									//      '<p class="das-gq-comment-form-author">' .
									//      '<label for="author">' . __( 'Name', 'das-gq-theme' ) . '</label> ' .
									//      ( $req ? '<span class="required">*</span>' : '' ) .
									//      '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
									//      '" size="30"' . $aria_req . ' /></p>',
									//    'email' =>
									//      '<p class="das-gq-comment-form-email"><label for="email">' . __( 'Email', 'das-gq-theme' ) . '</label> ' .
									//      ( $req ? '<span class="required">*</span>' : '' ) .
									//      '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
									//      '" size="30"' . $aria_req . ' /></p>',
									//    'url' =>
									//      '<p class="das-gq-comment-form-url"><label for="url">' .
									//      __( 'Website', 'das-gq-theme' ) . '</label>' .
									//      '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
									//      '" size="30" /></p>'
									//    )
									//  ),
								);
								comment_form($comments_args);
							}
							elseif ( $comment_registration_active == 1 ) {  ?>
								<a href="<?php echo $slickUrl ?>" class="default-das-btn das-login-note"><?php _e('Please login to post changes.', 'design-approval-system') ?></a>
							<?php } ?>
						</div><!--.das-form-text-->
					</div><!--.status-area1-->
				</div><!--#revision-form-wrap-gq-->
			<?php    } // end if
			/********************************************************
			das-versions
			 ********************************************************/
            $thisPermalink = get_permalink();
			?>
			<div id="das-versions">
				<div class="status-area1">
					<h2><?php _e('Version History', 'design-approval-system'); ?></h2>
					<div class="das-form-text"><?php _e('Today\'s Date:', 'design-approval-system'); ?> <?php echo date_i18n('l, F jS, Y \a\t g:ia'); ?><br/><ul id="das-nav"><?php
							if ( 'designapprovalsystem' == get_post_type() ) {
								$das_cats = wp_get_post_terms( $post->ID, 'das_categories' );
								if ( $das_cats ) {
									$das_cats_ids = array();
									foreach( $das_cats as $individual_das_cats ) $das_cats_ids[] = $individual_das_cats->term_id;
									$args = array(
										'tax_query' => array(
											array(
												'taxonomy'  => 'das_categories',
												'terms' 	=> $das_cats_ids,
												'operator'  => 'IN'
											)
										),
										'posts_per_page' 		=> -1,
										'ignore_sticky_posts' 	=> 1
									);
									$my_query = new \wp_query( $args );
									if( $my_query->have_posts() ) {
										while ( $my_query->have_posts() ) :
											$my_query->the_post();

                                            $current_user_role = $this->das_get_current_user_role_gq_theme();
                                            // private project board version list
                                            if(is_plugin_active('das-manager/das-manager.php') && $current_user_role == 'DAS Client' && get_post_meta($post->ID, 'custom_manager_name', true) == FALSE) {
                                                ?>
                                                <li class=""><a href="<?php the_permalink() ?>" rel="bookmark"><?php
                                                        $das_manager_client_version = get_post_meta($post->ID, 'custom_manager_name', true);
                                                        if (!empty($das_manager_client_version)) {
                                                            _e('Manager', 'design-approval-system');
                                                        } else {
                                                            _e('Client', 'design-approval-system');
                                                            //    }
                                                        } ?> <?php echo get_post_meta($post->ID, 'custom_version_of_design', true); ?>
                                                        &nbsp;.&nbsp; <?php _e('Created:', 'design-approval-system') ?> <?php echo get_the_date();

                                                        if(is_plugin_active('das-manager/das-manager.php') && get_post_meta($post->ID, 'custom_manager_approved', true) == 'Yes') {

                                                            echo '<div class="das-approved-design-subtitle das-manager-premium-star"></div>';

                                                        }
                                                        if(get_post_meta($post->ID, 'custom_client_approved', true) == 'Yes'){
                                                            echo '<div class="das-approved-design-subtitle das-premium-star"></div>';
                                                        }
                                                        ?></a>
                                                </li>
                                                <?php
                                            }
                                            // public project board version list
                                            if(!is_plugin_active('das-manager/das-manager.php') || is_plugin_active('das-manager/das-manager.php') && $current_user_role !== 'DAS Client') {

                                                $thePermalink = get_permalink($post->ID);

                                                ?>
                                                <li class="<?php if($thisPermalink == $thePermalink){ echo 'das-version-active';}  ?>"><a href="<?php the_permalink() ?>" rel="bookmark"><?php
                                                        $das_manager_client_version = get_post_meta($post->ID, 'custom_manager_name', true);
                                                        if (!empty($das_manager_client_version)) {
                                                            _e('Manager:', 'design-approval-system');
                                                        } else {
                                                            _e('Client', 'design-approval-system');
                                                            //    }
                                                        } ?> <?php echo get_post_meta($post->ID, 'custom_version_of_design', true); ?>
                                                        &nbsp;.&nbsp; <?php _e('Created:', 'design-approval-system') ?> <?php echo get_the_date();

                                                        if(is_plugin_active('das-manager/das-manager.php') && get_post_meta($post->ID, 'custom_manager_approved', true) == 'Yes') {

                                                            echo '<div class="das-approved-design-subtitle das-manager-premium-star"></div>';

                                                        }
                                                        if(get_post_meta($post->ID, 'custom_client_approved', true) == 'Yes'){
                                                            echo '<div class="das-approved-design-subtitle das-premium-star"></div>';
                                                        }
                                                         ?></a>
                                                </li>
                                                <?php
                                            }

                                            endwhile;
									}
									wp_reset_query();
								}
							} ?>
						</ul>
					</div>
				</div>
			</div><!--#das-versions-->
			<?php
			/********************************************************
			das-terms-conditions
			 ********************************************************/
			?>
			<div id="das-terms-conditions">
				<div class="status-area1">
					<h2><?php if ($terms_custom_title) {
							echo get_option('das-gq-theme-settings-terms-title');
						}
						else {
							_e('Terms & Conditions', 'design-approval-system');
						}
						?></h2>
					<div class="das-form-text">
						<?php
						//Check if settings page terms are empty, if so do the next statement.
						$custom_design_terms = get_post_meta($post->ID, 'custom_gq-theme-terms-conditions', true);
						$global_terms = get_option('das-gq-theme-main-wrapper-custom-terms');
						$terms_custom_title = get_option('das-gq-theme-settings-terms-title');
						if ($custom_design_terms) {
							echo get_post_meta($post->ID, 'custom_gq-theme-terms-conditions', true);
						}
						elseif ($global_terms) {
							echo get_option('das-gq-theme-main-wrapper-custom-terms');
						}
						else{
							_e('There are currently no terms set for this design.', 'design-approval-system');
						}
						?>
					</div><!--.form-text-->
				</div>
			</div><!--#das-terms-conditions-->
			<?php
			/********************************************************
			approved-form-wrap-gq
			 ********************************************************/
			?>
			<div id="approved-form-wrap-gq">
				<script>
					jQuery(document).ready(function() {
					    // handles the count for the Version 1 / ? menu tab and also the Version 1 of ? column
                        jQuery('.das-versions-btn').append(jQuery('ul#das-nav li').length);
                        jQuery('.das-versions-col').append(jQuery('ul#das-nav li').length);

						// Option for eproof
						// var data = jQuery('#artwork-guidlines-popup').html();
						var data = jQuery('#das-terms-conditions .status-area1').html();
						jQuery('#artwork-guidlines-popup-copy').html(data);
						jQuery('#das-approved-checkbox').on('change', function() {
							jQuery('.das-settings-admin-input').not(this).prop('checked', false);
							jQuery('#approved-form-wrap-gq .status-area2').hide();
							if (this.checked) {
								jQuery('#approved-form-wrap-gq .status-area1').show().css({"padding-top": "20px", "border-top": "1px solid #ddd", "margin-top": "20px"});
							}
						})
						jQuery('#view-terms-das').click(function() {
							jQuery('#artwork-guidlines-popup-copy').toggle();
						})
						jQuery('#das-not-approved-checkbox').on('change', function() {
							jQuery('.das-settings-admin-input').not(this).prop('checked', false);
							jQuery('#approved-form-wrap-gq .status-area1, .approved-thankyou-form-wrap').hide();
							if (this.checked) {
								jQuery('#approved-form-wrap-gq .status-area2').show().css({"padding-top": "20px", "border-top": "1px solid #ddd", "margin-top": "20px"});
							}
						})
					});
				</script>
				<?php if(get_option('das-gq-theme-client-changes-global') == '1') { ?>
				<h2 class="das-approval-header-popup-main"><?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-gq-theme-settings-project-board-btn-custom-name') : _e('Project', 'design-approval-system'); ?>
					<span class='das-approval-header-popup-approval'><?php _e('Approval', 'design-approval-system'); ?></span>
					<span class="das-approval-header-popup-approved color-green"><?php _e('Approved', 'design-approval-system'); ?></span>
					<span class="das-approval-header-popup-not-approved color-red"><?php _e('Not Approved', 'design-approval-system'); ?></span>
				</h2>

				<div class="proofing-popup-options-wrap">

					<p><?php if(get_option('das-project-popuptext') == '' || get_option('das-project-popuptext') == NULL) { ?>
							<?php _e('Please check one of the boxes below to approve your design or not. When you choose an option you will then be prompted for more information.', 'design-approval-system');
						}
						else {
							echo get_option('das-project-popuptext');
						}?>
					</p>






					<label for="das-approved-checkbox"><input name="das-gq-theme-terms-popup-global" class="das-settings-admin-input fleft" type="radio" id="das-approved-checkbox" value="1" /> <?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-gq-theme-settings-project-board-btn-custom-name') : _e('Project', 'design-approval-system'); ?> <?php _e('is <span class="color-green">approved</span>.', 'design-approval-system'); ?></label>
					<div class="clear"></div>
					<label for="das-not-approved-checkbox"> <input name="das-gq-theme-terms-popup-global" class="das-settings-admin-input fleft das-not-approved-checkbox" type="radio" id="das-not-approved-checkbox" value="1" />  <?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-gq-theme-settings-project-board-btn-custom-name') : _e('Project', 'design-approval-system'); ?> <?php _e('is <span class="color-red">NOT approved</span>.', 'design-approval-system'); ?></label>
				</div><!--proofing-popup-options-wrap-->
				<div class="status-area1 approved-js-action-after-submit" style="display:none">
					<?php } else { ?>
					<div class="status-area1 approved-js-action-after-submit">

						<?php } ?>


						<h2><?php _e('Status:', 'design-approval-system'); ?> <span class="color-green"><?php _e('Approved', 'design-approval-system'); ?></span></h2>
						<div class="das-form-text"><?php _e('Today\'s Date:', 'design-approval-system'); ?> <?php echo date_i18n('l, F jS, Y \a\t g:ia'); ?></div>
						<div class="clear"></div>
						<?php
						// Added SRL 8/24/14
						$approveLoginOveride = get_option('das-settings-approve-login-overide');
						if ( is_user_logged_in() || $approveLoginOveride) {
						?>

						<div class="das-form-text">
									
									
									
									
									
									
									
									
								<span>
					 <?php 	// Approval popup custom text
					 if(get_option('das-approval-popuptext-part-one') == '' || get_option('das-approval-popuptext-part-one') == NULL) {
						 _e('Please be sure to check for discrepancies in grammar and spelling. Your signature below represents the final approval. Changes made to the artwork after approved may accrue additional charges and may also cause delays in productions and order delivery.');
					 }
					 else {
						 echo get_option('das-approval-popuptext-part-one');
					 }?>
       </span>


							<?php // Approval popup custom text part two
							if(get_option('das-approval-popuptext-part-two') == '' || get_option('das-approval-popuptext-part-two') == NULL) {
								_e('As the authorized decision maker of my firm I acknowledge that I have reviewed and approved this version designed by', 'design-approval-system');
							}
							else {
								echo get_option('das-approval-popuptext-part-two');
							}

							?> <?php echo get_option('das-settings-company-name'); ?> <?php _e('presented on', 'design-approval-system');?> <?php echo date_i18n('l, F jS, Y \a\t g:ia'); ?>.












						</div>
						<!--/approved-form-text-->
						<div class="digital-signature-wrap">
							<?php
							//Check if Variable is empty if so do default text
							if (get_option('das-settings-approved-dig-sig-message-to-designer') == '') {
								$das_settings_approved_dig_sig_message_to_designer = __('This version has been approved by the client. Please take the next appropriate step.', 'design-approval-system');
							}
							else{
								$das_settings_approved_dig_sig_message_to_designer = get_option('das-settings-approved-dig-sig-message-to-designer');
							}
							if (get_option('das-settings-approved-dig-sig-message-to-clients') == '') {
								$das_settings_approved_dig_sig_message_to_clients = __('Thank you for approving this version. We will now take the next steps in finalizing your project. Below is a confirmation of your submission.
									As the authorized decision maker of my firm I acknowledge that I have reviewed and approved this version designed by', 'das-gq-theme', get_option('das-settings-company-name'));
							}
							else{
								$das_settings_approved_dig_sig_message_to_clients = get_option('das-settings-approved-dig-sig-message-to-clients');
							}
							?>
							<form class="myform" id="sendDigitalSignature" method="post" action="" name="sendDigitalSignature">
								<input id="human1" type="text"  name="human1" />
								<input name="email1" class="design-client-email" value="<?php echo get_post_meta($post->ID, 'custom_clients_email', true); ?>" />
								<div class="label-digital-signature">
									<label><?php _e('Digital Signature', 'design-approval-system'); ?></label>
									<input type="hidden" name="postid" class="das_post_id" value="<?php echo $das_postid; ?>"/>
									<!-- note: this name used to be a1 but it is now changed to a more comprehensive name -->
									<input type="text" maxlength="60" name="custom_client_approved_signature" id="custom_client_approved_signature" value="<?php echo get_post_meta( $post->ID, 'custom_client_approved_signature', true); ?>" />
									<!-- note: value="Yes" tells DAS to save the approved meta info to make the stars appear in project board -->
									<input type="hidden" value="Yes" name="submitApprovedYes" id="submitApprovedYes" />
									<input type="hidden" name="designer_email" class="design-client-email" value="<?php echo get_post_meta($post->ID, 'custom_designers_email', true); ?>" />
									<input type="hidden" value="<?php echo get_permalink() ?>" name="designtitle" />
									<input type="hidden" value="<?php echo get_post_meta($post->ID, 'custom_name_of_design', true); ?>" name="customNameOfDesign" />
									<input type="hidden" value="<?php echo get_post_meta($post->ID, 'custom_version_of_design', true); ?>" name="version4"  />
									<input type="hidden" value="<?php echo get_post_meta($post->ID, 'custom_client_name', true); ?>" name="companyname4"  />
									<input type="hidden" value="<?php echo get_option('das-settings-company-name'); ?>" name="dasSettingsCompanyName" />
									<input type="hidden" value="<?php echo get_option('das-settings-company-email'); ?>" name="dasSettingsCompanyEmail" />
									<input type="hidden" value="<?php echo $das_settings_approved_dig_sig_message_to_designer; ?>" name="dasSettingsApprovedDigSigMessageToDesigner" />
									<input type="hidden" value="<?php echo $das_settings_approved_dig_sig_message_to_clients; ?>" name="dasSettingsApprovedDigSigMessageToClients" />
									<input type="hidden" value="<?php echo get_post_meta($post->ID, 'custom_das_template_options', true); ?>" name="templateName" />
                                    <input type="hidden" value="<?php echo date_i18n('l, F jS, Y \a\t g:ia'); ?>" name="approvedDate" id="approved-date" />


									<label><?php _e('Comments', 'design-approval-system'); ?></label>
									<textarea id="approved-comments"  name="approvedComments" style="min-height:150px; font-weight:normal;" placeholder="Not Required"></textarea>

									<?php
									if (get_option( 'das-gq-theme-agree-to-terms-checkbox' ) == '1') { ?>
										<label class="das-settings-admin-input-label" for="das-gq-theme-agree-to-terms"><input name="das-gq-theme-agree-to-terms" class="das-settings-admin-input fleft" type="checkbox" id="das-gq-theme-agree-to-terms" /> <span><?php _e('I read and agree with the', 'design-approval-system'); ?> <a href="javascript:;" id="view-terms-das"><?php _e('Terms & Conditions', 'design-approval-system'); ?></a>.</span></label>

										<!-- this is where we duplicate the global terms with jquery above -->
										<div id="artwork-guidlines-popup-copy"></div>
									<?php }
									else { ?>
										<input name="das-gq-theme-agree-to-terms" class="das-settings-admin-input fleft" type="checkbox" id="das-gq-theme-agree-to-terms" checked="checked" style="display:none;" />
									<?php } ?>



									<a id="das-submit" class="das-submit-signature" rel="<?php echo $post->ID; ?>"><?php _e('Submit', 'design-approval-system'); ?></a>
									<div class="clear"></div>
								</div>
							</form>
						</div>
						<!--/status-area1-->
					</div>
					<!--/digital-signature-wrap-->
					<div class="clear"></div>
					<div class="approved-thankyou-form-wrap">
						<div class="dig-sig-thank-you-message">
							<?php
							$company_name = get_option('das-settings-company-name');
							if (get_option('das-settings-approved-dig-sig-thank-you') == '') {
								_e('Thank you for approving your design comp.<br/> '.$company_name.' will now take the next steps in finalizing your project.', 'design-approval-system');
							}
							else{
								echo get_option('das-settings-approved-dig-sig-thank-you');
							}
							?>
						</div>
						<!--/dig-sig-thank-you-message-->
						<?php }
						else if ( !is_user_logged_in() ) {  ?>
							<a href="<?php echo $slickUrl ?>" class="default-das-btn das-login-note"><?php _e('Please login to approve.', 'design-approval-system'); ?></a>
						<?php } ?>
					</div>
					<!--/approved-thankyou-form-wrap-->
					<div class="status-area2 approved-js-action-after-submit" style="display:none">
						<h2><?php _e('Status:', 'design-approval-system'); ?> <span class="color-red"><?php _e('Not Approved', 'design-approval-system'); ?></span></h2>
						<div class="das-form-text">


							<?php _e('Today\'s Date:', 'design-approval-system'); ?> <?php echo date_i18n('l, F jS, Y \a\t g:ia'); ?><br/><br/>

							<?php // Approval popup custom changes text
							if(get_option('das-changes-popuptext-part-one') == '' || get_option('das-changes-popuptext-part-one') == NULL) {
								_e('Please let us know what comments you have.', 'design-approval-system');
							}
							else {
								echo get_option('das-changes-popuptext-part-one');
							}

							?>


						</div>

						<?php //Check if Variable is empty if so do default text
						if (get_option('das-settings-design-requests-message-to-designer') == '') {
							$das_settings_design_requests_message_to_designer = 'Design comp changes have been requested by this client. Please review and take the next appropriate steps.';
						}
						else{
							$das_settings_design_requests_message_to_designer = get_option('das-settings-design-requests-message-to-designer');
						}
						if (get_option('das-settings-design-requests-message-to-clients') == '') {
							$company_name = get_option('das-settings-company-name');
							$das_settings_design_requests_message_to_clients = 'We have received the recent request for changes to your design comp. '.$company_name.' will immediately make the changes you have asked for and will be sending another design comp for your review shortly. Below you will find a copy of your notes.';
						}
						else{
							$das_settings_design_requests_message_to_clients = get_option('das-settings-design-requests-message-to-clients');
						}

						if(is_plugin_active('das-premium/das-premium.php')) {
							require_once ABSPATH . '/wp-content/plugins/das-premium/includes/das-changes-extension/das-changes-extension-template.php';
						}

						?>

					</div>
					<!--/approved-thankyou-form-wrap .status-area2-->
					<div class="design-request-thankyou-form-wrap">
						<div class="design-request-thank-you-message">
							<?php
							if (get_option('das-settings-design-requests-thank-you') == '') {
								$company_name = get_option('das-settings-company-name');
								echo 'We have received the recent request for changes to your design comp. '.$company_name.' will immediately make the changes you have asked for and will be sending another design comp for your review shortly.';
							}
							else{
								echo get_option('das-settings-design-requests-thank-you');
							}
							?>
						</div>
						<!--/dig-sig-thank-you-message-->
						<div class="clear"></div>
					</div>
					<!--/#approved-form-wrap-gq-->
					<!-----/status-Approcoved FORM--END------>
					<div class="clear"></div>
				</div><!--.das-main-template-wrapper-->
			</div><!--.das-main-template-wrapper-all-->
		<?php endwhile; ?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {




				// jQuery(".das-comment-list li:odd").css("background", "rgb(248, 248, 248)");
				//	  $.magnificPopup.open({
				//		 items: {
				// 		 type:'inline',
				//		 src: '#approved-form-wrap-gq',
				//		 midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
				//	 	}
				//	  });
				$('.design-approval-btn-gq').magnificPopup({
					items: {
						type:'inline',
						src: '#approved-form-wrap-gq',
						midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
					}
				});
				$('.das-terms-conditions-btn').magnificPopup({
					items: {
						type:'inline',
						src: '#das-terms-conditions',
						midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
					}
				});
				<?php // option from the GQ settings page
				$termsPopupActive = get_option( 'das-gq-theme-terms-popup-global' );
				if ($termsPopupActive) { ?>
				$.magnificPopup.open({
					items: {
						type:'inline',
						src: '#das-terms-conditions',
						midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
					}
				});
				<?php }
				else { ?>
				$('.das-versions-btn').magnificPopup({
					items: {
						type:'inline',
						src: '#das-terms-conditions',
						midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
					}
				});
				<?php } ?>
				$('.das-versions-btn').magnificPopup({
					items: {
						type:'inline',
						src: '#das-versions',
						midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
					}
				});
				$('.design-revision-btn-gq').magnificPopup({
					items: {
						type:'inline',
						src: '#revision-form-wrap-gq',
						midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
					}

				});
				//			$('.design-revision-btn-gq').click(function () {
				//				$('.status-area1').show();
				//		});
				//			$('.design-approval-btn-gq').click(function () {
				//				$('.pop-up-backg, .approved-form-wrap').fadeIn();
				//			});
				$('.hide-notes, .hide-notes-footer').click(function () {
					$('.das-main-template-wrapper').hide();
					$('.show-notes').show();
					$('.show-notes a').fadeIn(1000);
				});
				$('.show-notes').click(function () {
					$('.das-main-template-wrapper').slideDown();
					$('.show-notes').hide();
				});
				<?php
				if (is_user_logged_in() == true && get_option('das-gq-theme-hide-media-button-checkbox') == '1') {  ?>
				// Adds the Add Media Button next to our Post Comment button on the comment form
				$('.form-submit').prepend('<a href="javascript:;" class="das-custom-upload ls_test_media das-client-changes-media-btn"><?php _e('Add Media', 'design-approval-system'); ?></a>');
				<?php } ?>
				// Makes sure the media uploader is on the upload tab when openened instead of the media library
				wp.media.controller.Library.prototype.defaults.contentUserSetting=false;
				jQuery(document).on("DOMNodeInserted", function(){
					// Lock uploads to "Uploaded to this post"
					jQuery('select.attachment-filters [value="uploaded"]').attr( 'selected', true ).parent().trigger('change');
				});
				// Uploading files
				var file_frame;
				var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
				var set_to_post_id = <?php echo $post->ID ?>; // Set this
				jQuery('.ls_test_media').live('click', function( event ){
					event.preventDefault();
					// If the media frame already exists, reopen it.
					if ( file_frame ) {
						// Set the post ID to what we want
						file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
						// Open frame
						file_frame.open();
						return;
					} else {
						// Set the wp.media post id so the uploader grabs the ID we want when initialised
						wp.media.model.settings.post.id = set_to_post_id;
					}
					// Create the media frame.
					file_frame  = wp.media(
						{
							button: { text: '<?php _e('Insert Media or Zip', 'design-approval-system'); ?>', },
							frame:   'select',
							state:   'mystate',
							// This is commented out so we can see the zip icon too if zips are uploaded
							// library:   {type: 'image'},
							multiple:   false
						});
					file_frame.states.add([
						new wp.media.controller.Library({
							id:         'mystate',
							title: '<?php _e('Insert Media (zip multiple files)', 'design-approval-system'); ?>',
							priority:   20,
							toolbar:    'select',
							filterable: 'uploaded',
							library:    wp.media.query( file_frame.options.library ),
							multiple:   file_frame.options.multiple ? 'reset' : false,
							editable:   false,
							displayUserSettings: false,
							displaySettings: false,
							allowLocalEdits: false,
							//AttachmentView: ?
						}),
					]);
					// When an image is selected, run a callback.
					file_frame.on( 'select', function() {
						// We set multiple to false so only get one image from the uploader
						attachment = file_frame.state().get('selection').first().toJSON();
						// Restore the main post ID
						wp.media.model.settings.post.id = wp_media_post_id;
						Object:
							//attachment.alt - image alt
							//attachment.author - author id
							//attachment.caption
							// attachment.dateFormatted
							//- date of image uploaded
							//attachment.description
							//attachment.editLink - edit link of media
							attachment.filename
						//attachment.height
						//attachment.icon - don't know WTF?))
						//attachment.id - id of attachment
						// attachment.link 
						//- public link of attachment, for example ""http://site.com/?attachment_id=115""
						attachment.menuOrder
						//attachment.mime - mime type, for example image/jpeg"
						//attachment.name - name of attachment file, for example "my-image"
						//attachment.status - usual is "inherit"
						//attachment.subtype - "jpeg" if is "jpg"
						//attachment.title
						//attachment.type - "image"
						//attachment.uploadedTo
						attachment.url
						// - http url of image, for example "http://site.com/wp-content/uploads/2012/12/my-image.jpg"
						//attachment.width
						// jQuery('.das-template-box-4header').append(attachment.dateFormatted.link.url);
						var $edit = $("#comment, #custom_client_changes");
						var curValue = $edit.val();
						var newValue = curValue + ' <a href="' + attachment.url  + '" target="_blank">' + attachment.filename + '</a><br/>';
						$edit.val(newValue);
						// Do something with attachment.id and/or attachment.url here
					});
					file_frame.open();
				});
				// not really sure what this is suppose to do	
				// Restore the main ID when the add media button is pressed
				// jQuery('a.add_media').on('click', function() {
				//   wp.media.model.settings.post.id = wp_media_post_id;
			});
		</script>
		<div class="clear"></div>
		</div>
		<?php
		//Wordpress Footer	
		get_footer();
	}
}