<?php
/*
	This is file is for creating the das settings page for Wordpress's backend
*/
// SRL added 6-6-13 to allow us to record the approved information directly to db
//**************************************************
// DAS Email Shortcode options for Setting page
//**************************************************
function das_email_shortcode() {?>
	<option value="" selected><?php  _e('Insert Email Shortcode Option', 'design-approval-system') ?></option>
	<option value="[das_date customize='F j, Y g:i a']"><strong>[das_date customize='F j, Y g:i a']</strong> <?php  _e('- Date Email Sent.</a>', 'design-approval-system') ?></option>
	<option value="[das_project_start_end]"><strong>[das_project_start_end]</strong> <?php  _e('- When the project will start and end. Example: 2-30-17 thru 3-20-17', 'design-approval-system') ?></option>
	<option value="[das_company_name]"><strong>[das_company_name]</strong> <?php  _e('- Company Name', 'design-approval-system') ?></option>
	<option value="[das_name_of_design]"><strong>[das_name_of_design]</strong> <?php  _e('- Name of Design', 'design-approval-system') ?></option>
	<option value="[das_version_number]"><strong>[das_version_number]</strong> <?php  _e('- Design Version Number', 'design-approval-system') ?></option>
	<option value="[das_designer_name]"><strong>[das_designer_name]</strong> <?php  _e('- Designer Name', 'design-approval-system') ?></option>
	<option value="[das_designer_notes]"><strong>[das_designer_notes]</strong> <?php  _e('- Design Notes Message', 'design-approval-system') ?></option>
	<option value="[das_woo_price]"><strong>[das_woo_price]</strong> <?php  _e('- Price (Premium Option)', 'design-approval-system') ?></option>
	<option value="[das_client_name]"><strong>[das_client_name]</strong> <?php  _e('- Client Name', 'design-approval-system') ?></option>
	<option value="[das_client_email]"><strong>[das_client_email]</strong> <?php  _e('- Client Email', 'design-approval-system') ?></option>
	<option value="[das_approved_signature]"><strong>[das_approved_signature]</strong> <?php  _e('- Approved Digital Signature', 'design-approval-system') ?></option>
	<option value="[das_approved_comments]"><strong>[das_approved_comments]</strong> <?php  _e('- Approved Comments', 'design-approval-system') ?></option>
	<option value="[das_changes_comments]"><strong>[das_changes_comments]</strong> <?php  _e('- Changes Comments', 'design-approval-system') ?></option>
	<option value="[das_design_link]"><strong>[das_design_link]</strong> <?php  _e('- Design Approval Link', 'design-approval-system') ?></option>
	<?php
}
//Main setting page function
function das_settings_page() {

	wp_register_script( "das_settings_page_script", WP_PLUGIN_URL.'/design-approval-system/admin/js/admin.js', array('jquery') );
	wp_register_script( "das_settings_page_script2", WP_PLUGIN_URL.'/design-approval-system/templates/slickremix/js/jquery.form.js', array('jquery') );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'das_settings_page_script' );
	wp_enqueue_script( 'das_settings_page_script2' );

	$dasPremiumCheck = 'das-premium/das-premium.php';
	$dasPremiumActive = is_plugin_active($dasPremiumCheck);
	?>

	<div class="das-settings-admin-wrap">

		<form method="post" class="das-settings-admin-form" action="options.php">
			<?php // get our registered settings from the gq theme functions
			settings_fields('design-approval-system-settings'); ?>

			<div class="das-tabs-master-wrap">

				<div class="tabs" id="tabs">

					<label for="tab1"
						   class="tab1 tabbed <?php if (isset($_GET['tab']) && $_GET['tab'] == 'general') {
							   echo 'tab-active';
						   } elseif (!isset($_GET['tab'])) {
							   echo 'tab-active';
						   } ?>" id="general">
						<span class="das-text"><?php _e('General', 'sidebar-support') ?></span>
					</label>


					<label for="tab3" class="tab3 tabbed <?php if (isset($_GET['tab']) && $_GET['tab'] == 'smtp') {
						echo ' tab-active';
					} ?>" id="smtp">
						<span class="das-text"><?php _e('SMTP', 'sidebar-support') ?></span>
					</label>

					<label for="tab4" class="tab4 tabbed <?php if (isset($_GET['tab']) && $_GET['tab'] == 'emails') {
						echo 'tab-active';
					} ?>" id="emails">
						<span class="das-text"><?php _e('Emails', 'sidebar-support') ?></span>
					</label>

					<label for="tab2"
						   class="tab2 tabbed <?php if (isset($_GET['tab']) && $_GET['tab'] == 'project_board') {
							   echo ' tab-active';
						   } ?>" id="project_board">
						<span class="das-text"><?php _e('Project Board', 'sidebar-support') ?></span>
					</label>

					<div id="tab-content1"
						 class="tab-content side-sup-hide-me <?php if (isset($_GET['tab']) && $_GET['tab'] == 'general' || !isset($_GET['tab'])) {
							 echo ' pane-active';
						 } ?>">
						<section>

							<h2>
								<?php _e('Design Approval System Settings', 'design-approval-system') ?>
							</h2>
							<a class="buy-extensions-btn" href="http://www.slickremix.com/downloads/category/design-approval-system/" target="_blank">
								<?php _e('Get Extensions Here!', 'design-approval-system') ?>
							</a>
							<div class="use-of-plugin">
								<?php _e("Fill out the settings below. Company Name, Email and Select User and Email Settings are Required.", "design-approval-system") ?>
							</div>


							<!-- hiding this until future use -->
							<div class="das-settings-admin-input-wrap company-info-style" style="display:none">
								<div class="das-settings-admin-input-label">
									<?php _e('Company Logo (required)', 'design-approval-system') ?>
									: <a class="question1">
										<?php _e('?', 'design-approval-system') ?>
									</a></div>
								<input id="das_default_theme_logo_image" name="das_default_theme_logo_image" class="das-settings-admin-input" type="text"  value="<?php // echo get_option('das_default_theme_logo_image'); ?>" />
								<input id="das_logo_image_button" class="upload_image_button" type="button" value="<?php _e('Upload Image') ?>" />
								<div class="das-settings-admin-input-example upload-logo-size">
									<?php _e('This logo will be displayed at the top of all your design posts. Size for the "default" template is 124px X 20px.', 'design-approval-system') ?>
								</div>
								<div class="clear"></div>
								<div class="das-settings-id-answer answer1">
									<ul>
										<li>
											<?php _e('Your logo will be placed at the left right of the page.', 'design-approval-system') ?>
										</li>
									</ul>
									<img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/admin/images/how-to/admin-help-logo.jpg" alt="Header Logo Example" /> <a class="im-done button button-secondary">
										<?php _e('close', 'design-approval-system') ?>
									</a> </div>
								<!--/das-settings-id-answer-->

								<div class="clear"></div>
							</div>
							<!--/das-settings-admin-input-wrap-->

							<div class="das-settings-admin-input-wrap company-info-style">
								<div class="das-settings-admin-input-label">
									<?php _e('Company Name (required)', 'design-approval-system') ?>
								</div>
								<input name="das-settings-company-name" class="das-settings-admin-input" type="text" id="das-settings-company-name" value="<?php echo get_option('das-settings-company-name'); ?>" />
								<div class="das-settings-admin-input-example">
									<?php _e('This is used as the from name on all outgoing emails, and will also appear on the approval form too.') ?>
								</div>
							</div>
							<!--/das-settings-admin-input-wrap-->

							<div class="das-settings-admin-input-wrap company-info-style">
								<div class="das-settings-admin-input-label">
									<?php _e('Company Email Address (required)', 'design-approval-system') ?>
								</div>
								<input name="das-settings-company-email" class="das-settings-admin-input" type="text" id="das-settings-company-email" value="<?php echo get_option('das-settings-company-email'); ?>" />
								<div class="das-settings-admin-input-example">
									<?php _e('This is used as the from email address on all outgoing emails and is also where the test emails will go when testing out the <a href="edit.php?post_type=designapprovalsystem&page=design-approval-system-settings-page&tab=emails">Emails.</a>', 'design-approval-system') ?>
								</div>
							</div>
							<!--/das-settings-admin-input-wrap-->


                            <div class="das-settings-admin-input-wrap company-info-style">
                                <div class="das-settings-admin-input-label">
                                    <?php _e('BCC Email for Approved Designs', 'design-approval-system') ?>
                                </div>
                                <input name="das-settings-bcc-email" class="das-settings-admin-input" type="text" id="das-settings-bcc-email" value="<?php echo get_option('das-settings-bcc-email'); ?>" />
                                <div class="das-settings-admin-input-example">
                                    <?php _e('Add an email address here to get a BCC copy of the Approved design email (only one email allowed). Designers and Clients get all emails by default. ', 'design-approval-system') ?>
                                </div>
                            </div>
                            <!--/das-settings-admin-input-wrap-->

							<div class="das-settings-admin-input-wrap company-info-style">
								<div class="das-settings-admin-input-label">
									<?php _e('Should Clients be logged in to View Designs?', 'design-approval-system') ?>
								</div>
								<input name="das-settings-approve-login-overide" class="das-settings-admin-input fleft" type="checkbox" id="das-settings-approve-login-overide" value="1" <?php checked( '1', get_option( 'das-settings-approve-login-overide' ) ); ?> />
								<?php
								$approveLoginOveride = get_option( 'das-settings-approve-login-overide' );

								if ($approveLoginOveride == '1') {
									_e('Checked, you are not requiring clients to login before approving designs.', 'design-approval-system');
								}
								else	{
									_e('Not checked, you require clients to be logged in before approving.', 'design-approval-system');
								}

								?>
								<div class="das-custom-checkbox-wrap">
									<?php _e('This is a good option if you are just trying to get something approved quicky without the hassle of creating a user for your client.<br/><br/><strong>PLEASE NOTE:</strong> Your client will not be able to add comments about changes if they did not want to approve the project (unless you are using the Client Changes add on that comes with DAS Premium). Also your clients will not be able to view their own personal project board. You cannot have this checked if you\'re using the Media Upload option either that is available in DAS Premium.', 'design-approval-system') ?>
								</div>
							</div>
							<!--/das-settings-admin-input-wrap-->


							<h3 class="das-margin-top">
								<?php _e('Select User and Email Settings', 'design-approval-system') ?>
							</h3>
							<div class="subtext-of-title">
								<?php _e('These settings are for the roles used to create the drop down selections on the post page. ("Designers Name", "Clients Name", "Clients Email")', 'design-approval-system') ?>
							</div>
							<div class="das-settings-admin-input-wrap">
								<div class="das-settings-admin-input-label">
									<?php _e('What role is used for', 'design-approval-system') ?> <strong><?php _e('Designers', 'design-approval-system') ?></strong>?</div>
								<div class="das-settings-role-wrap">
									<?php

									$das_designer_role = get_option('das-settings-designer-role') ;

									global $wp_roles;
									$das_roles = get_editable_roles();

									echo '<select name="das-settings-designer-role" id="das-settings-designer-role">';

									echo '<option value="">- '.__('Please select the role used for Designers', 'design-approval-system').' -</option>';

									foreach ($das_roles as $role => $details) {
										echo '<option value="'.esc_attr($role).'"', $das_designer_role == esc_attr($role) ? 'selected="selected"':'','>'.$details['name'].'</option>';
									}
									echo '</select>';
									?>
								</div>
								<div class="das-settings-admin-input-example">
									<?php _e('NOTE: Determines which users will be displayed under the drop down for picking the "Designers Name" when creating a design.', 'design-approval-system') ?>
								</div>
								<div class="clear"></div>
							</div>
							<!--/das-settings-admin-input-wrap-->

							<div class="das-settings-admin-input-wrap">
								<div class="das-settings-admin-input-label">
									<?php _e('What role is used for', 'design-approval-system') ?> <strong><?php _e('Clients', 'design-approval-system') ?></strong>?</div>
								<div class="das-settings-role-wrap">
									<?php
									$das_client_role = get_option('das-settings-client-role');

									global $wp_roles;
									$das_roles = get_editable_roles();

									echo '<select name="das-settings-client-role" id="das-settings-client-role">';

									echo '<option value="">- '.__('Please select the role used for Clients', 'design-approval-system').' -</option>';

									foreach ($das_roles as $role => $details) {
										echo '<option value="'.esc_attr($role).'"', $das_client_role == esc_attr($role) ? 'selected="selected"':'','>'.$details['name'].'</option>';
									}

									echo '</select>';
									?>
								</div>
								<div class="das-settings-admin-input-example">
									<?php _e('NOTE: Determines which users will be displayed under the drop down for picking the "Client Name" & "Client Email" when creating a design.') ?>
								</div>
								<div class="clear"></div>
							</div>
							<!--/das-settings-admin-input-wrap-->

						</section>
						<input type="submit" class="button button-primary das-final-save-all-changes-button"
							   value="<?php _e('Save All Changes'); ?>"/>
						<div class="clear"></div>
					</div> <!-- #tab-content1 -->

					<div id="tab-content2"
						 class="tab-content side-sup-hide-me <?php if (isset($_GET['tab']) && $_GET['tab'] == 'project_board') {
							 echo ' pane-active';
						 } ?>">
						<section>
							<h3>
								<?php _e('Customize Project Board Branding', 'design-approval-system') ?>
							</h3>
							<div class="subtext-of-title">
								<?php _e('Add your own custom name in place of the word Project Board, Project or Projects on the Project Board. <a href="http://www.slickremix.com/testblog/project-board/" target="_blank">Example Project Board</a>', 'design-approval-system') ?>
							</div>
							<div class="das-settings-admin-input-wrap company-info-style pb-board-and-fep-options">
								<label>
									<?php _e("Replace the word 'Project'.") ?>
								</label>
								<input name="das-settings-singular-pb-fep-name" class="das-settings-admin-input" type="text" id="das-settings-singular-pb-fep-name" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('Project', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" value="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-settings-singular-pb-fep-name') : ''; ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?> />
								<label>
									<?php _e("Replace the word 'Projects'.") ?>
								</label>
								<input name="das-settings-plural-pb-fep-name" class="das-settings-admin-input" type="text" id="das-settings-plural-pb-fep-name" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('Projects', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" value="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-settings-plural-pb-fep-name') : ''; ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?> />
								<label>
									<?php _e("Replace the word 'Project Board'.") ?>
								</label>
								<input name="das-settings-pb-fep-name" class="das-settings-admin-input" type="text" id="das-settings-pb-fep-name" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('Project Designs', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" value="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-settings-pb-fep-name') : ''; ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?>  />
							</div>
							<!--/das-settings-admin-input-wrap-->

						</section>
						<div class="clear"></div>

						<input type="submit" class="button button-primary"
							   value="<?php _e('Save All Changes'); ?>"/>
					</div> <!-- #tab-content2 -->

					<div id="tab-content3"
						 class="tab-content side-sup-hide-me <?php if (isset($_GET['tab']) && $_GET['tab'] == 'smtp') {
							 echo ' pane-active';
						 } ?>">
						<section>
							<h3>
								<?php _e('SMTP Info', 'design-approval-system') ?>
							</h3>
							<div class="subtext-of-title">
								<?php _e('You are welcome to try our SMTP options for sending mail. If you need more options or are having trouble getting setup please note that our plugin will work alongside any <a href="plugin-install.php?s=SMTP&tab=search&type=term">SMTP plugins available in the wordpress repo</a>.', 'design-approval-system') ?>

							</div>
							<div class="das-settings-admin-input-wrap company-info-style ">
								<div class="das-settings-admin-input-label">
									<?php _e('Send emails using SMTP. Need Help or having problems connecting?', 'design-approval-system') ?>
									<a href="http://www.slickremix.com/docs/gmail-or-server-smtp-setup/" target="_blank">
										<?php _e('See Instructions', 'design-approval-system') ?>
									</a></div>
								<div class="das-settings-admin-input-label das-smtp-custom"></div>
								<input name="das-settings-smtp" class="das-settings-admin-input" type="checkbox"  id="das-settings-smtp" value="1" <?php checked( '1', get_option( 'das-settings-smtp' ) ); ?>/>
								<?php

								$smtp_checked =  get_option( 'das-settings-smtp' );

								if ($smtp_checked == '1') {
									_e('Checked, you are now using SMTP to send emails. You must contact your host provider if you are unsure of the settings to enter.', 'design-approval-system');
								}
								else	{
									_e('Not checked, you are using sendmail. If your experiencing email troubles we suggest you check the box and enter your SMTP info.', 'design-approval-system');
								}
								?>
								<div class="smpt-form-wrap">
									<label>
										<?php  _e('SMTP Server') ?>
									</label>
									<input type="text" name="das-smtp-server" id="das-smtp-server" value="<?php echo get_option( 'das-smtp-server' ); ?>" placeholder="<?php  _e('mail.yourdomain.com or smtp.gmail.com etc.', 'design-approval-system') ?>">
									<?php $dasSSLorTLSoption = get_option( 'das-settings-das-ssl-or-tls-option'); ?>
									<label>
										<?php  _e('SSL / TLS') ?>
									</label>
									<select id="das-settings-das-ssl-or-tls-option" name="das-settings-das-ssl-or-tls-option">
										<option value="" <?php if ($dasSSLorTLSoption == '' ) echo 'selected="selected"'; ?>><?php echo('None'); ?></option>
										<option value="ssl" <?php if ($dasSSLorTLSoption == 'ssl' ) echo 'selected="selected"'; ?>><?php echo('SSL'); ?></option>
										<option value="tls" <?php if ($dasSSLorTLSoption == 'tls' ) echo 'selected="selected"'; ?>><?php echo('TLS'); ?></option>
									</select>
									<div class="clear"></div>
									<label>
										<?php  _e('SMTP Port') ?>
									</label>
									<input type="text" name="das-smtp-port" value="<?php echo get_option( 'das-smtp-port' ); ?>"  placeholder="<?php  _e('Typically port 465 for ssl and port 587 for tls', 'design-approval-system') ?>">
									<label class="checkbox-label">
										<?php  _e('SMTP Authenticate?') ?>
									</label>
									<input class="checkbox-input" type="checkbox" name="das-smtp-checkbox-authenticate" id="das-smtp-checkbox-authenticate" value="1" <?php echo checked( '1', get_option( 'das-smtp-checkbox-authenticate' ) ); ?>/>
									<div class="clear"></div>
									<label>
										<?php  _e('Authenticate Username') ?>
									</label>
									<input type="text" name="das-smtp-authenticate-username" id="das-smtp-authenticate-username" value="<?php echo get_option( 'das-smtp-authenticate-username' ); ?>" placeholder="<?php  _e('example@yourdomain.com', 'design-approval-system') ?>">
									<label>
										<?php  _e('Authenticate Password') ?>
									</label>
									<input type="password" name="das-smtp-authenticate-password" id="das-smtp-authenticate-password" value="<?php $hash = wp_hash_password( get_option( 'das-smtp-authenticate-password' ) ); echo $hash // https://codex.wordpress.org/Function_Reference/wp_hash_password ?>">
									<label></label>
									<input type="submit" class="button button-primary" style="float:none; width:200px; margin-left:3px;" value="<?php _e('Save SMTP Settings', 'design-approval-system'); ?>">
									<div class="clear"></div>
									<br/>
									<div class="das-custom-checkbox-wrap">
										<div style="text-transform: none; font-weight: normal; ">
											<p>
												<?php _e('<strong>SEND TEST EMAIL USING BASIC SENDMAIL OR SMTP EMAIL SETTINGS</strong><ol class="smtp-check-list"><li>Make sure all settings have been saved.</li><li>To send a SMTP test email make sure you have the SMTP option checked and the settings filled out, otherwise it will send the test email using the default sendmail method.</li><li>The test email will be sent to the one you added in the Company Email Address field or the SMTP Authenticate Username field if you have checked the use SMTP checkbox.</li></ol>', 'design-approval-system') ?>
											</p>
											<?php $das_smtp_checkbox = get_option('das-settings-smtp'); ?>
											<a href="javascript:;" id="send-email-settings-page-test" class="button button-secondary">

												<script type="text/javascript" >
													jQuery(document).ready(function() {

														jQuery('body').on('click', '#send-email-settings-page-test', function() {
															jQuery.ajax({
																type: 'POST',
																data: {
																	action: "das_send_message",
																	'das_form_type': "testEmailSettingsPage",
																},
																url: myAjax.ajaxurl,
																success: function (result) {
																	console.log(result);
																	if (result == 'done0') {
																		jQuery('#send-email-settings-page-test').hide();
																		jQuery('#send-email-settings-page-test-done').fadeIn('slow');
																	}
																	else {
																		jQuery('#send-email-settings-page-test-error').html("<strong>CONNECTION FAILED:</strong> Please check your settings again as something appears to be incorrect.");
																		jQuery('#send-email-settings-page-test').hide();
																		jQuery('#send-email-settings-page-test-error').fadeIn('slow');
																	}
																	return false;
																}

															}); // end of ajax()
															return false;
														});

														jQuery('select.das-settings-email-for-designers-message-to-clients-select').change(function() {
															var currentVal = jQuery('#das-settings-email-for-designers-message-to-clients').val();
															jQuery('#das-settings-email-for-designers-message-to-clients').val(currentVal + jQuery(this).val());
														});
														jQuery('select.das-settings-approved-dig-sig-message-to-designer-select').change(function() {
															var currentVal = jQuery('#das-settings-approved-dig-sig-message-to-designer').val();
															jQuery('#das-settings-approved-dig-sig-message-to-designer').val(currentVal + jQuery(this).val());
														});
														jQuery('select.das-settings-approved-dig-sig-message-to-clients-select').change(function() {
															var currentVal = jQuery('#das-settings-approved-dig-sig-message-to-clients').val();
															jQuery('#das-settings-approved-dig-sig-message-to-clients').val(currentVal + jQuery(this).val());
														});
														jQuery('select.das-settings-design-requests-message-to-designer-select').change(function() {
															var currentVal = jQuery('#das-settings-design-requests-message-to-designer').val();
															jQuery('#das-settings-design-requests-message-to-designer').val(currentVal + jQuery(this).val());
														});
														jQuery('select.das-settings-design-requests-message-to-clients-select').change(function() {
															var currentVal = jQuery('#das-settings-design-requests-message-to-clients').val();
															jQuery('#das-settings-design-requests-message-to-clients').val(currentVal + jQuery(this).val());
														});
													});
												</script>
												<?php _e('Send Test Email', 'design-approval-system') ?>
											</a>
											<div id="send-email-settings-page-test-done" style="display:none; border: 1px solid rgb(177, 245, 144);
color: rgb(0, 0, 0);
background: rgb(229, 255, 211);
padding-left: 15px;
text-align: left;" class="smtp-test-email-send-button"><strong>
													<?php _e('SUCCESS:', 'design-approval-system'); ?>
												</strong>
												<?php _e('Your', 'design-approval-system'); ?> <?php
												//SMTP Authenticate?
												if ($das_smtp_checkbox == '1') {
													_e('SMTP Test Email has been sent to ', 'design-approval-system'); ?>
													<a href="mailto:<?php echo get_option('das-smtp-authenticate-username'); ?>"><?php echo get_option('das-smtp-authenticate-username'); ?></a>
													<?php
												}
												//SMTP Authenticate?
												if (!$das_smtp_checkbox == '1') {
													_e('Default Test Email has been sent to ', 'design-approval-system'); ?>
													<a href="mailto:<?php echo get_option('das-settings-company-email'); ?>"><?php echo get_option('das-settings-company-email'); ?></a>.
													<?php
													_e('You may need to check your spam folder for the first email unless you use SMTP.', 'design-approval-system');
												}?>
											</div>
											<div id="send-email-settings-page-test-error" style="display:none;border: 1px solid rgb(245, 144, 144); color: rgb(0, 0, 0); background: rgb(255, 211, 211);padding-left: 15px;
text-align: left;" class="smtp-test-email-send-button"></div>
										</div>
									</div>
								</div>
								<div class="clear"></div>
							</div>
							<!--/das-settings-admin-input-wrap-->

						</section>
						<input type="submit" class="button button-primary"
							   value="<?php _e('Save All Changes'); ?>"/>
					</div> <!-- #tab-content3 -->

					<div id="tab-content4"
						 class="tab-content side-sup-hide-me <?php if (isset($_GET['tab']) && $_GET['tab'] == 'emails') {
							 echo ' pane-active';
						 } ?>">
						<section>
							<h3>
								<?php  _e('Email Shortcode Options', 'design-approval-system') ?>
							</h3>
							<div class="shortcode-text-wrap">
								<?php  _e('The shortcodes below this list can be used to format your email for the following 5 forms.', 'design-approval-system') ?>

								<ol>
									<li><?php  _e('New Design Email for Client', 'design-approval-system') ?></li>
									<li><?php  _e('Approved Digital Signature Email for Designer', 'design-approval-system') ?></li>
									<li><?php  _e('Approved Digital Signature Email for Client', 'design-approval-system') ?></li>
									<li><?php  _e('Design Changes Request Email for Designer', 'design-approval-system') ?></li>
									<li><?php  _e('Design Changes Request Email for Client', 'design-approval-system') ?></li>
								</ol>
								<ul>
									<li><strong>[das_date customize='F j, Y g:i a']</strong> <?php  _e('- Date Email Sent. <a href="https://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">See date format options</a>', 'design-approval-system') ?></li>
									<li><strong>[das_project_start_end]</strong> <?php  _e('- When the project will start and end. Example: 2-30-17 thru 3-20-17', 'design-approval-system') ?></li>
									<li><strong>[das_company_name]</strong> <?php  _e('- Company Name', 'design-approval-system') ?></li>
									<li><strong>[das_name_of_design]</strong> <?php  _e('- Name of Design', 'design-approval-system') ?></li>
									<li><strong>[das_version_number]</strong> <?php  _e('- Design Version Number', 'design-approval-system') ?></li>
									<li><strong>[das_designer_name]</strong> <?php  _e('- Designer Name', 'design-approval-system') ?></li>
									<li><strong>[das_designer_notes]</strong> <?php  _e('- Design Notes Message', 'design-approval-system') ?></li>
									<li><strong>[das_woo_price]</strong> <?php  _e('- Price (<a href="https://www.slickremix.com/downloads/das-premium/" target="_blank">Premium Option</a>)', 'design-approval-system') ?></li>
									<li><strong>[das_client_name]</strong> <?php  _e('- Client Name', 'design-approval-system') ?></li>
									<li><strong>[das_client_email]</strong> <?php  _e('- Client Email', 'design-approval-system') ?></li>
									<li><strong>[das_approved_signature]</strong> <?php  _e('- Approved Digital Signature', 'design-approval-system') ?></li>
									<li><strong>[das_approved_comments]</strong> <?php  _e('- Approved Comments', 'design-approval-system') ?></li>
									<li><strong>[das_changes_comments]</strong> <?php  _e('- Changes Comments (<a href="https://www.slickremix.com/downloads/das-premium/" target="_blank">Premium Option</a>)', 'design-approval-system') ?></li>
									<li><strong>[das_design_link]</strong> <?php  _e('- Design Approval Link', 'design-approval-system') ?></li>
								</ul>
							</div>

							<h3>
								<?php  _e('New Design Email for Client', 'design-approval-system') ?>
							</h3>

							<div class="subtext-of-title">
								<?php  _e('These settings are for the email to your client, letting them know their design is ready to be reviewed.<br/>
      It also Includes a confirmation email to you the Designer too.', 'design-approval-system') ?>
							</div>
							<div class="das-settings-admin-input-wrap">
								<div class="das-settings-admin-input-label">
									<?php _e('Message to Client (optional)', 'design-approval-system') ?> <a class="question4">?</a></div>

								<select class="das-shortcode-select das-settings-email-for-designers-message-to-clients-select">
									<?php echo das_email_shortcode(); ?>
								</select>
								<textarea name="das-settings-email-for-designers-message-to-clients" class="das-settings-admin-input" id="das-settings-email-for-designers-message-to-clients"><?php echo get_option('das-settings-email-for-designers-message-to-clients'); ?></textarea>

								<div class="das-settings-admin-input-example">
									<?php  _e("*NOTE* If you do not fill this out the <a class='question4'>default text</a> will be used. HTML formatting allowed.", "design-approval-system") ?>
								</div>
								<div class="clear"></div>
								<div class="das-settings-id-answer answer4">
									<h4>
										<?php _e('The default text for this field is:', 'design-approval-system') ?>
									</h4>
									<ul>
										<li>
											<?php _e('Please review your design comp for changes and/or errors:', 'design-approval-system') ?>
										</li>
									</ul>
<span>
<?php _e('Example of Email', 'design-approval-system') ?>
</span> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/admin/images/how-to/help-designers-email.jpg" /> <a class="im-done button button-secondary">
										<?php _e('close', 'design-approval-system') ?>
									</a>
								</div>
								<!--/das-settings-id-answer-->
								<input type="submit" class="button button-primary das-margin-bottom-buttons" value="Save Changes">

								<a href="javascript:;" class="button button-secondary testSendEmailToClient">Send Test Email</a>

								<?php if(is_plugin_active('das-custom-emails/das-custom-emails.php')) { $newThis = new DAS_CUSTOM_EMAILS_Customizer(); ?>
									<a href="<?php echo $newThis->get_customizer_url(); ?>&autofocus[section]=das-settings-email_text#newDesignEmail" class="button button-secondary">Edit Email Template</a>
								<?php } ?>

								<script type="text/javascript">
									jQuery(document).ready(function() {

										jQuery('body').on('click', '.testSendEmailToClient', function() {
											jQuery.ajax({
												type: 'POST',
												data: {
													action: "das_send_message",
													'das_form_type': "testSendEmailToClient",
												},
												url: myAjax.ajaxurl,
												success: function (result) {
													console.log(result);
													if (result == '0') {
														jQuery('.testSendEmailToClient').html('<?php _e('Email Sent to', 'design-approval-system')?> <?php echo get_option('das-settings-company-email'); ?>');
													}
													return false;
												}

											}); // end of ajax()
											return false;
										});
										jQuery('body').on('click', '.testApprovedEmailToDesigner', function() {
											jQuery.ajax({
												type: 'POST',
												data: {
													action: "das_send_message",
													'das_form_type': "testApprovedEmailToDesigner",
												},
												url: myAjax.ajaxurl,
												success: function (result) {
													console.log(result);
													if (result == '0') {
														jQuery('.testApprovedEmailToDesigner').html('<?php _e('Email Sent to', 'design-approval-system')?> <?php echo get_option('das-settings-company-email'); ?>');
													}
													return false;
												}

											}); // end of ajax()
											return false;
										});
										jQuery('body').on('click', '.testApprovedEmailToClient', function() {
											jQuery.ajax({
												type: 'POST',
												data: {
													action: "das_send_message",
													'das_form_type': "testApprovedEmailToClient",
												},
												url: myAjax.ajaxurl,
												success: function (result) {
													console.log(result);
													if (result == '0') {
														jQuery('.testApprovedEmailToClient').html('<?php _e('Email Sent to', 'design-approval-system')?> <?php echo get_option('das-settings-company-email'); ?>');
													}
													return false;
												}

											}); // end of ajax()
											return false;
										});
										jQuery('body').on('click', '.testChangesEmailToDesigner', function() {
											jQuery.ajax({
												type: 'POST',
												data: {
													action: "das_send_message",
													'das_form_type': "testChangesEmailToDesigner",
												},
												url: myAjax.ajaxurl,
												success: function (result) {
													console.log(result);
													if (result == '0') {
														jQuery('.testChangesEmailToDesigner').html('<?php _e('Email Sent to', 'design-approval-system')?> <?php echo get_option('das-settings-company-email'); ?>');
													}
													return false;
												}

											}); // end of ajax()
											return false;
										});
										jQuery('body').on('click', '.testChangesEmailToClient', function() {
											jQuery.ajax({
												type: 'POST',
												data: {
													action: "das_send_message",
													'das_form_type': "testChangesEmailToClient",
												},
												url: myAjax.ajaxurl,
												success: function (result) {
													console.log(result);
													if (result == '0') {
														jQuery('.testChangesEmailToClient').html('<?php _e('Email Sent to', 'design-approval-system')?> <?php echo get_option('das-settings-company-email'); ?>');
													}
													return false;
												}

											}); // end of ajax()
											return false;
										});



									});
								</script>
								<div class="clear"></div>
							</div>
							<!--/das-settings-admin-input-wrap-->

							<h3 class="das-margin-top">
								<?php _e('Approved Digital Signature Email and Popup Message', 'design-approval-system') ?>
							</h3>
							<div class="subtext-of-title">
								<?php _e('These settings are for the email to you, the designer, letting you know the client has approved the design. <br/>
      It also includes a confirmation email to your Client too.', 'design-approval-system') ?>
							</div>
							<div class="das-settings-admin-input-wrap">
								<div class="das-settings-admin-input-label">
									<?php _e('Message to Designer (optional)', 'design-approval-system') ?>
									<a class="question5">
										<?php _e('?', 'design-approval-system') ?>
									</a></div>
								<select class="das-shortcode-select das-settings-approved-dig-sig-message-to-designer-select">
									<?php echo das_email_shortcode(); ?>
								</select>
								<textarea name="das-settings-approved-dig-sig-message-to-designer" class="das-settings-admin-input" id="das-settings-approved-dig-sig-message-to-designer"><?php echo get_option('das-settings-approved-dig-sig-message-to-designer'); ?></textarea>
								<div class="das-settings-admin-input-example">
									<?php _e("*NOTE* If you do not fill this out the <a class='question5'>default text</a> will be used. HTML formatting allowed.", "design-approval-system") ?>
								</div>
								<div class="clear"></div>
								<div class="das-settings-id-answer answer5">
									<h4>
										<?php _e('The default text for this field is:', 'design-approval-system') ?>
									</h4>
									<ul>
										<li>
											<?php _e("This design comp has been approved by the client. Please take the next appropriate step.", "design-approval-system") ?>
										</li>
									</ul>
<span>
<?php _e('Example of Email', 'design-approval-system') ?>
</span> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/admin/images/how-to/help-approval-designer.jpg" /> <a class="im-done button button-secondary">
										<?php _e('close', 'design-approval-system') ?>
									</a> </div>
								<!--/das-settings-id-answer-->
								<input type="submit" class="button button-primary das-margin-bottom-buttons" value="Save Changes">
								<a href="javascript:;" class="button button-secondary testApprovedEmailToDesigner">Send Test Email</a>
								<?php if(is_plugin_active('das-custom-emails/das-custom-emails.php')) {?>
									<a href="<?php echo $newThis->get_customizer_url(); ?>&autofocus[section]=das-settings-approved_email_to_designers_text#approvedEmailDesigner" class="button button-secondary">Edit Email Template</a>
								<?php } ?>
								<div class="clear"></div>
							</div>
							<!--/das-settings-admin-input-wrap-->

							<div class="das-settings-admin-input-wrap">
								<div class="das-settings-admin-input-label">
									<?php _e('Message to Client (optional)', 'design-approval-system') ?>
									<a class="question6">
										<?php _e('?', 'design-approval-system') ?>
									</a></div>
								<select class="das-shortcode-select das-settings-approved-dig-sig-message-to-clients-select">
									<?php echo das_email_shortcode(); ?>
								</select>
								<textarea name="das-settings-approved-dig-sig-message-to-clients" class="das-settings-admin-input" type="text" id="das-settings-approved-dig-sig-message-to-clients"><?php echo get_option('das-settings-approved-dig-sig-message-to-clients'); ?></textarea>
								<div class="das-settings-admin-input-example">
									<?php _e("*NOTE* If you do not fill this out the <a class='question6'>default text</a> will be used. HTML formatting allowed.", "design-approval-system") ?>
								</div>
								<div class="clear"></div>
								<div class="das-settings-id-answer answer6">
									<h4>
										<?php _e('The default text for this field is:', 'design-approval-system') ?>
									</h4>
									<ul>
										<li>
											<?php _e('Thank you for approving your design comp. We will now take the next steps in finalizing your project. Below is a confirmation of your submission.<br/>
            As the authorized decision maker of my firm I acknowledge that I have reviewed and approved the proposed design comps designed by [Your Company Name].', 'design-approval-system') ?>
										</li>
									</ul>
<span>
<?php _e('Example of Email', 'design-approval-system') ?>
</span> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/admin/images/how-to/help-approval-email.jpg" /> <a class="im-done button button-secondary">
										<?php _e('close', 'design-approval-system') ?>
									</a> </div>
								<!--/das-settings-id-answer-->
								<input type="submit" class="button button-primary das-margin-bottom-buttons" value="Save Changes">
								<a href="javascript:;" class="testApprovedEmailToClient button button-secondary">Send Test Email</a>
								<?php if(is_plugin_active('das-custom-emails/das-custom-emails.php')) {?>
									<a href="<?php echo $newThis->get_customizer_url(); ?>&autofocus[section]=das-settings-approved_email_to_client_text#approvedEmailClient" class="button button-secondary">Edit Email Template</a>
								<?php } ?>
								<div class="clear"></div>
							</div>
							<!--/das-settings-admin-input-wrap-->

							<div class="das-settings-admin-input-wrap">
								<div class="das-settings-admin-input-label">
									<?php _e('Thank You Message to Client after Digital Signature form is submitted (optional)', 'design-approval-system') ?> <a class="question7">?</a></div>
								<textarea name="das-settings-approved-dig-sig-thank-you" class="das-settings-admin-input" type="text" id="das-settings-approved-dig-sig-thank-you"><?php echo get_option('das-settings-approved-dig-sig-thank-you'); ?></textarea>
								<div class="das-settings-admin-input-example">
									<?php _e("*NOTE* If you do not fill this out the <a class='question7'>default text</a> will be used.", "design-approval-system") ?>
								</div>
								<div class="clear"></div>
								<div class="das-settings-id-answer answer7">
									<h4>
										<?php _e('The default text for this field is:', 'design-approval-system') ?>
									</h4>
									<ul>
										<li>
											<?php _e('Thank you for approving your design comp.<br/>"My Company Name" will now take the next steps in finalizing your project.', 'design-approval-system') ?>
										</li>
									</ul>
<span>
<?php _e('Example of Pop Up Message that appears when a client approves a design', 'design-approval-system') ?>
</span> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/admin/images/how-to/help-approval-popup.jpg" /> <a class="im-done button button-secondary">
										<?php _e('close', 'design-approval-system') ?>
									</a> </div>
								<!--/das-settings-id-answer-->
								<div class="clear"></div>
							</div>
							<!--/das-settings-admin-input-wrap-->

							<?php if(is_plugin_active('das-premium/das-premium.php')) {
								include('../wp-content/plugins/das-premium/includes/das-changes-extension/admin/das-changes-extension-settings-page.php');
							}?>


							<h3 class="das-margin-top">
								<?php _e('Create New Customer Email Message', 'design-approval-system') ?>
							</h3>
							<div class="subtext-of-title">
								<?php _e('This area is for the email message to the DAS Client that comes from using the Custom front end registration form that creates new DAS Clients') ?>
							</div>
							<div class="das-settings-admin-input-wrap">
								<div class="das-settings-admin-input-label">
									<?php _e('Email Message', 'design-approval-system') ?>
								</div>
								<textarea name="das-settings-register-new-das-client" class="das-settings-admin-input" type="text" id="das-settings-register-new-das-client"><?php echo get_option('das-settings-register-new-das-client'); ?></textarea>
								<div class="das-settings-admin-input-example">
									<?php _e("*NOTE* If you do not fill this out the DAS Client will only receive the username and password.<br/>No shortcode options available. HTML formatting allowed.", "design-approval-system") ?>
								</div> <?php if(is_plugin_active('das-custom-emails/das-custom-emails.php')) {?>
									<a href="<?php echo $newThis->get_customizer_url(); ?>&autofocus[section]=das-settings-new_client_text#newCustomerEmail" class="button button-secondary">Edit Email Template</a>
								<?php } ?>
								<div class="clear"></div>
							</div>
							<!--/das-settings-admin-input-wrap-->

						</section>
						<input type="submit" class="button button-primary das-final-save-all-changes-button"
							   value="<?php _e('Save All Changes'); ?>"/>

					</div> <!-- #tab-content4 -->

				</div>

				<div class="clear"></div>

			</div>
			<script>
				jQuery(document).ready(function ($) {

					//create hash tag in url for tabs
					jQuery('.das-settings-admin-wrap #tabs').on('click', "label.tabbed", function () {
						var myURL = document.location;
						document.location = myURL + "&tab=" + jQuery(this).attr('id');

					})

				});
			</script>
			<div class="clear"></div>
		</form>
		<div class="das-settings-icon-wrap"><a href="https://www.facebook.com/SlickRemix" target="_blank" class="facebook-icon"></a><a class="das-settings-admin-slick-logo" href="http://www.slickremix.com" target="_blank"></a></div>
	</div>
	<!--/das-settings-admin-wrap-->

	<form class="myform" id="settingsTestEmail" method="post" action="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/form-processes/settings-page-test-email-process.php" name="settingsTestEmail">
		<input type="hidden" value="<?php echo get_option('das-settings-company-name'); ?>" name="dasSettingsCompanyName" />
		<input type="hidden" value="<?php echo get_option( 'das-smtp-authenticate-username' ); ?>" name="dasSettingsCompanyEmail" />
		<input type="hidden" value="<?php echo get_option( 'das-settings-company-email' ); ?>" name="dasSettingsCompanyEmail" />
		<!-- <input type="submit"/> -->
	</form>
	<div style="display:none" id="output"></div>
<?php } ?>