<?php //Main setting page function
function das_gq_theme_settings_page() {

    $dasPremiumCheck = 'das-premium/das-premium.php';
    $dasPremiumActive = is_plugin_active($dasPremiumCheck); ?>


    <div class="das-settings-admin-wrap" id="theme-settings-wrap">



        <form method="post" class="das-settings-admin-form" action="options.php">

            <?php // get our registered settings from the gq theme functions
            settings_fields('das-gq-settings'); ?>




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

                    <?php if($dasPremiumActive){?>
                    <label for="tab2"
                           class="tab2 tabbed <?php if (isset($_GET['tab']) && $_GET['tab'] == 'client_changes') {
                               echo ' tab-active';
                           } ?>" id="client_changes">
                        <span class="das-text"><?php _e('Client Changes', 'sidebar-support') ?></span>
                    </label>
                    <?php } ?>

                    <label for="tab3" class="tab3 tabbed <?php if (isset($_GET['tab']) && $_GET['tab'] == 'custom_titles') {
                        echo ' tab-active';
                    } ?>" id="custom_titles">
                        <span class="das-text"><?php _e('Custom Titles', 'sidebar-support') ?></span>
                    </label>

                    <label for="tab4" class="tab4 tabbed <?php if (isset($_GET['tab']) && $_GET['tab'] == 'color_options') {
                        echo 'tab-active';
                    } ?>" id="color_options">
                        <span class="das-text"><?php _e('Color Options', 'sidebar-support') ?></span>
                    </label>

                    <label for="tab5" class="tab5 tabbed <?php if (isset($_GET['tab']) && $_GET['tab'] == 'project_board') {
                        echo 'tab-active';
                    } ?>" id="project_board">
                        <span class="das-text"><?php _e('Project Board', 'sidebar-support') ?></span>
                    </label>
                    <?php if($dasPremiumActive){?>
                    <label for="tab6" class="tab6 tabbed <?php if (isset($_GET['tab']) && $_GET['tab'] == 'woocomerce') {
                        echo 'tab-active';
                    } ?>" id="woocomerce">
                        <span class="das-text"><?php _e('WooCommerce', 'sidebar-support') ?></span>
                    </label>
                    <?php } ?>


                    <div id="tab-content1"
                         class="tab-content side-sup-hide-me <?php if (isset($_GET['tab']) && $_GET['tab'] == 'general' || !isset($_GET['tab'])) {
                             echo ' pane-active';
                         } ?>">
                        <section>


                            <h2><?php _e('Template Settings', 'design-approval-system'); ?></h2>
                            <div style=" padding-bottom: 25px !important;">
                                <p style="font-size: 14px; margin-top: -2px; color:#616161 !important;"><?php _e('These settings are for the front end design template where your customer can approve the design etc.', 'design-approval-system'); ?></p>
                            </div>





                            <!-- custom option for padding -->
                            <div class="das-gq-theme-settings-admin-input-wrap company-info-style das-gq-theme-turn-on-custom-colors das-settings-admin-input-wrap company-info-style">
                                <div class="das-gq-theme-settings-admin-input-label das-gq-theme-wp-header-custom"><p class="special"><?php _e('Check the box to turn ON the custom padding option for the Design Template. This will make it so the menu and content fits nicely within your website, if it does not already. Simply define the numbers to suite your desired spacing. Here is how it works. 25px 20px 25px 30px. Lets break it down now. 25px = top padding, 20px = right padding, 25px = bottom padding and 30px = left padding. <br/><br/>The same idea applies to the margin option. However, if you set a Max-Width for the Main Design Template Wrapper too we can add auto to the left and right margin so the frame will be positioned in the middle of the screen. Give it a try, re-type check the box and add in the text you see in the inputs below and click the Save Changes button to see what happens.', 'design-approval-system'); ?></p></div>
                                <p>
                                    <input name="das-gq-theme-options-settings-custom-css-main-wrapper-padding" class="das-gq-theme-settings-admin-input" type="checkbox"  id="das-gq-theme-options-settings-custom-css-main-wrapper-padding" value="1" <?php echo checked( '1', get_option( 'das-gq-theme-options-settings-custom-css-main-wrapper-padding' ) ); ?>/>
                                    <?php
                                    if (get_option( 'das-gq-theme-options-settings-custom-css-main-wrapper-padding' ) == '1') {
                                        _e('<strong>Checked:</strong> Custom style options being used now.', 'design-approval-system');
                                    }
                                    else	{
                                        _e('<strong>Not Checked:</strong> You are using the default styles.', 'design-approval-system');
                                    }
                                    ?>
                                </p>  <p>
                                    <label><?php _e('Padding:', 'design-approval-system'); ?></label>
                                    <input name="das-gq-theme-main-wrapper-padding-input" class="das-gq-theme-settings-admin-input" type="text"  id="das-gq-theme-main-wrapper-padding-input" placeholder="25px 20px 25px 30px " value="<?php echo get_option('das-gq-theme-main-wrapper-padding-input'); ?>" title="Only Numbers and px are allowed"/>
                                </p>
                                <p>
                                    <label><?php _e('Max-Width:', 'design-approval-system'); ?></label>
                                    <input name="das-gq-theme-main-wrapper-width-input" class="das-gq-theme-settings-admin-input" type="text"  id="das-gq-theme-main-wrapper-width-input" placeholder="970px" value="<?php echo get_option('das-gq-theme-main-wrapper-width-input'); ?>" title="Only Numbers and px are allowed"/>
                                </p>
                                <p>
                                    <label><?php _e('Margin:', 'design-approval-system'); ?></label>
                                    <input name="das-gq-theme-main-wrapper-margin-input" class="das-gq-theme-settings-admin-input" type="text"  id="das-gq-theme-main-wrapper-margin-input" placeholder="20px auto 25px auto" value="<?php echo get_option('das-gq-theme-main-wrapper-margin-input'); ?>" title="Only Numbers and px are allowed"/>
                                </p><br/>
                                <p>
                                    <input name="das-gq-theme-options-settings-custom-css-first" class="das-gq-theme-settings-admin-input" type="checkbox"  id="das-gq-theme-options-settings-custom-css-first" value="1" <?php echo checked( '1', get_option( 'das-gq-theme-options-settings-custom-css-first' ) ); ?>/>
                                    <?php
                                    if (get_option( 'das-gq-theme-options-settings-custom-css-first' ) == '1') {
                                        _e('<strong>Checked:</strong> Custom CSS option is being used now.', 'design-approval-system');
                                    }
                                    else	{
                                        _e('<strong>Not Checked:</strong> You are using the default CSS.', 'design-approval-system');
                                    }
                                    ?>
                                </p>
                                <p>
                                    <label class="toggle-custom-textarea-show button button-secondary"><span><?php _e('Show', 'design-approval-system'); ?></span><span class="toggle-custom-textarea-hide"><?php _e('Hide', 'design-approval-system'); ?></span> <?php _e('custom CSS', 'design-approval-system'); ?></label>
                                <div class="das-custom-css-text"><?php _e('<p>If you want to hide all but the design and options then copy and paste the first line below into the CSS input box. The header, footer and nav css below should hide most themes elements, if not you may need to look at the design page source code to pinpoint the id or class to hide the header etc.<p>

<p>header, #header nav, .nav-primary, footer, #footer { display:none; } /* this hides the themes header, footer and nav so you can just see the design and the options. */</p>

.das-custom-upload { display:none; } /* hide the add media button. */', 'design-approval-system'); ?></div>

                                <textarea name="das-gq-theme-main-wrapper-css-input" class="das-gq-theme-settings-admin-input" id="das-gq-theme-main-wrapper-css-input"><?php echo get_option('das-gq-theme-main-wrapper-css-input'); ?></textarea>
                                </p>
                                <div class="clear"></div>


                                <?php $das_premium = is_plugin_active('das-premium/das-premium.php'); ?>

                            </div>
                            <!--/das-gq-theme-settings-admin-input-wrap-->

                            <h3 class="das-margin-top"><?php _e('Approval Name, Date & Message', 'design-approval-system'); ?></h3>
                            <div class="das-settings-admin-input-wrap company-info-style">

                                <p class="special"><?php _e('The clients name, date and message when approving a design will appear under the Project Comments section on the front end.', 'design-approval-system'); ?><br/><br/>

                                        <input name="das-gq-theme-approved-comments-option" class="das-settings-admin-input fleft" type="checkbox" id="das-gq-theme-approved-comments-option" value="1" <?php checked( '1', get_option( 'das-gq-theme-approved-comments-option' ) ); ?> />
                                        <?php
                                        $clientChangesActive = get_option( 'das-gq-theme-approved-comments-option' );

                                        if ($clientChangesActive == '1') {
                                            _e('Checked, This will NOT appear under Project Comments.', 'design-approval-system');
                                        }
                                        else	{
                                            _e('Not checked, This will appear under Project Comments.', 'design-approval-system');
                                        }

                                        ?>
    </p>
                                <div class="clear"></div>
                            </div>
                            <!--/das-settings-admin-input-wrap-->


                            <h3 class="das-margin-top"><?php _e('Media Upload Button', 'design-approval-system'); ?></h3>
                            <div class="das-settings-admin-input-wrap company-info-style">

                                <p class="special"><?php _e('Click the checkbox to add a Media upload button to the Wordpress Comments form or the Client Changes form. With this checked Clients can upload images, pdfs or zips. Clients will not see your whole media library, only the items they upload to their design post.', 'design-approval-system'); ?><br/><br/>
                                    <?php if(isset($das_premium) && $das_premium == true) { ?>
                                        <input name="das-gq-theme-hide-media-button-checkbox" class="das-settings-admin-input fleft" type="checkbox" id="das-gq-theme-hide-media-button-checkbox" value="1" <?php checked( '1', get_option( 'das-gq-theme-hide-media-button-checkbox' ) ); ?> />
                                        <?php
                                        $clientChangesActive = get_option( 'das-gq-theme-hide-media-button-checkbox' );

                                        if ($clientChangesActive == '1') {
                                            _e('Checked, Media button in use', 'design-approval-system');
                                        }
                                        else	{
                                            _e('Not checked, Media button is NOT being used', 'design-approval-system');
                                        }

                                        ?>


                                    <?php  } else { ?>
                                        <input name="das-gq-theme-client-changes-global" class="das-settings-admin-input fleft das-premium-required" type="checkbox" id="das-gq-theme-client-changes-global" value="1" disabled="disabled" />
                                        <?php _e('Premium Plugin Required to use this option', 'design-approval-system'); } ?>     </p>
                                <div class="clear"></div>
                            </div>
                            <!--/das-settings-admin-input-wrap-->




                            <h3 class="das-margin-top"><?php _e('Terms &amp; Conditions Text and Popup', 'design-approval-system'); ?></h3>
                            <div class="das-settings-admin-input-wrap company-info-style">

                                <p class="special"><?php _e('Add any terms and conditions for your clients here. A terms button will appear on the Design Template if you fill this out and when a client goes to approve the design a checkbox will appear for them to check as well. This is for all design posts.', 'design-approval-system');?>
                                </p> <p><label class="toggle-custom-textarea-show-terms button button-secondary"><span><?php _e('Show', 'design-approval-system'); ?></span><span class="toggle-custom-textarea-hide-terms"><?php _e('Hide', 'design-approval-system'); ?></span> <?php _e('Text', 'design-approval-system'); ?></label></p>
                                <textarea name="das-gq-theme-main-wrapper-custom-terms" class="das-gq-theme-settings-admin-input" id="das-gq-theme-main-wrapper-custom-terms"><?php echo get_option('das-gq-theme-main-wrapper-custom-terms'); ?></textarea>
                                <div class="clear"></div>

                                <p class="special"><?php _e('If you check this option everytime you go to a design post the terms popup will always come up first so your clients understand right away your terms and conditions.', 'design-approval-system') ?><br/><br/>

                                    <input name="das-gq-theme-terms-popup-global" class="das-settings-admin-input fleft" type="checkbox" id="das-gq-theme-terms-popup-global" value="1" <?php checked( '1', get_option( 'das-gq-theme-terms-popup-global' ) ); ?> />
                                    <?php
                                    $termsPopupActive = get_option( 'das-gq-theme-terms-popup-global' );

                                    if ($termsPopupActive == '1') {
                                        _e('Checked, you are showing the Terms popup when a design page loads.', 'design-approval-system');
                                    }
                                    else	{
                                        _e('Not checked, you are NOT showing the Terms popup when a design page loads.', 'design-approval-system');
                                    }

                                    ?>
                                </p>



                                <p class="special"><?php _e('Show an Agree to Terms and Conditions checkbox in the popup when approving a design', 'design-approval-system') ?><br/><br/>

                                    <input name="das-gq-theme-agree-to-terms-checkbox" class="das-settings-admin-input fleft" type="checkbox" id="das-gq-theme-agree-to-terms-checkbox" value="1" <?php checked( '1', get_option( 'das-gq-theme-agree-to-terms-checkbox' ) ); ?> />
                                    <?php
                                    $termsCheckboxActive = get_option( 'das-gq-theme-agree-to-terms-checkbox' );

                                    if ($termsCheckboxActive == '1') {
                                        _e('Checked, you are showing the Agree to Terms and Conditions checkbox when approving a design', 'design-approval-system');
                                    }
                                    else	{
                                        _e('Not checked, you are NOT showing the Agree to terms checkbox when approving a design', 'design-approval-system');
                                    }

                                    ?>
                                </p>


                            </div>
                            <!--/das-settings-admin-input-wrap-->

                        </section>
                        <div class="clear"></div>
                        <input type="submit" class="button button-primary das-final-save-all-changes-button" value="<?php _e('Save All Changes'); ?>"/>
                    </div> <!-- #tab-content1 -->

                    <div id="tab-content2"
                         class="tab-content side-sup-hide-me <?php if (isset($_GET['tab']) && $_GET['tab'] == 'client_changes') {
                             echo ' pane-active';
                         } ?>">
                        <section>
                            <?php $das_premium = is_plugin_active('das-premium/das-premium.php');
                            if(isset($das_premium) && $das_premium == true) { ?>
                            <h2><?php _e('Client Changes Options', 'sidebar-support') ?></h2>
                            <div class="das-settings-admin-input-wrap company-info-style" style="padding-top:0;"><p style="margin-top:0;"><?php _e('Checking the option below will allow the Client Changes option to work instead of the Wordpress Comments and show an additional "Project Notes to Customer" textarea on the front end tab for Create New Project. See an example of how the client changes options works here. <a class="das-color-white" href="http://www.slickremix.com/docs/client-changes-setup" target="_blank">https://www.slickremix.com/docs/client-changes-setup</a>', 'design-approval-system') ?></p>
                                <p class="special">

                                <input name="das-gq-theme-client-changes-global" class="das-settings-admin-input fleft" type="checkbox" id="das-gq-theme-client-changes-global" value="1" <?php checked( '1', get_option( 'das-gq-theme-client-changes-global' ) ); ?> />
                                    <?php
                                    $clientChangesActive = get_option( 'das-gq-theme-client-changes-global' );

                                    if ($clientChangesActive == '1') {
                                        _e('Checked, you are using the Client Changes option for requested changes', 'design-approval-system');
                                    }
                                    else	{
                                        _e('Not checked, you are using wordpress comments for clients to request changes', 'design-approval-system');
                                    }

                                    ?>
                                </p>
                                <div class="clear"></div>
                                </div>
                                <!--/das-settings-admin-input-wrap-->


                                <div class="das-settings-admin-input-wrap company-info-style">
                                    <div class="das-settings-admin-input-label"><?php _e('Approval/Changes Text Top', 'design-approval-system'); ?></div>
                                    <textarea name="das-project-popuptext" class="das-settings-admin-input" type="text" id="das-project-popuptext" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('Please check one of the boxes below to approve your design or not. When you choose an option you will then be prompted for more information.', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?>><?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-project-popuptext') : ''; ?></textarea>
                                    <div class="das-settings-admin-input-example"><?php _e('This changes the text for the Approval Popup Up if you are using the Client Changes option.', 'design-approval-system'); ?></div>
                                    <div class="clear"></div>
                                    <a class="das-gq-theme-settings-toggle" href="#"></a>
                                    <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/das-project-popuptext.png" alt="" /></div>
                                    <!--/das-settings-id-answer-->
                                    <div class="clear"></div>
                                </div>
                                <!--/das-settings-admin-input-wrap-->


                                <?php } ?>

                                <div class="das-settings-admin-input-wrap company-info-style">
                                    <div class="das-settings-admin-input-label"><?php _e('Changes Text in popup', 'design-approval-system'); ?></div>

                                    <textarea name="das-changes-popuptext-part-one" class="das-settings-admin-input" type="text" id="das-changes-popuptext-part-one" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('Please let us know what comments you have.', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?>><?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-changes-popuptext-part-one') : ''; ?></textarea>


                                    <div class="clear"></div>
                                    <a class="das-gq-theme-settings-toggle" href="#"></a>
                                    <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/das-changes-popuptext-part-one.png" alt="" /></div>
                                    <!--/das-settings-id-answer-->
                                    <div class="clear"></div>
                                </div>
                                <!--/das-settings-admin-input-wrap-->




                                <h3><?php _e('Approved Text in Popup', 'design-approval-system'); ?></h3>
                                <div class="das-settings-admin-input-wrap company-info-style">
                                    <div class="das-settings-admin-input-label"><?php _e('Approved Text Part One', 'design-approval-system'); ?></div>

                                    <textarea name="das-approval-popuptext-part-one" class="das-settings-admin-input" type="text" id="das-approval-popuptext-part-one" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('Please be sure to check for discrepancies in grammar and spelling. Your signature below represents the final approval. Changes made to the artwork after approved may accrue additional charges and may also cause delays in productions and order delivery.', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?>><?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-approval-popuptext-part-one') : ''; ?></textarea>


                                    <div class="das-settings-admin-input-example"><?php _e('This changes the green text block.', 'design-approval-system'); ?></div>
                                    <div class="clear"></div>
                                    <a class="das-gq-theme-settings-toggle" href="#"></a>
                                    <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/das-approval-popuptext-part-one.png" alt="" /></div>
                                    <!--/das-settings-id-answer-->
                                    <div class="clear"></div>
                                </div>
                                <!--/das-settings-admin-input-wrap-->




                                <div class="das-settings-admin-input-wrap company-info-style">
                                    <div class="das-settings-admin-input-label"><?php _e('Approved Text Part Two', 'design-approval-system'); ?></div>

                                    <textarea name="das-approval-popuptext-part-two" class="das-settings-admin-input" type="text" id="das-approval-popuptext-part-two" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('As the authorized decision maker of my firm I acknowledge that I have reviewed and approved this version designed by', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?>><?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-approval-popuptext-part-two') : ''; ?></textarea>


                                    <div class="das-settings-admin-input-example"><?php _e('This changes the text block under the green text.', 'design-approval-system'); ?></div>
                                    <div class="clear"></div>
                                    <a class="das-gq-theme-settings-toggle" href="#"></a>
                                    <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/das-approval-popuptext-part-two.png" alt="" /></div>
                                    <!--/das-settings-id-answer-->
                                    <div class="clear"></div>
                                </div>
                                <!--/das-settings-admin-input-wrap-->

                        </section>
                    <div class="clear"></div>

                    <input type="submit" class="button button-primary das-final-save-all-changes-button"
                           value="<?php _e('Save All Changes'); ?>"/>
                </div> <!-- #tab-content2 -->

                <div id="tab-content3"
                     class="tab-content side-sup-hide-me <?php if (isset($_GET['tab']) && $_GET['tab'] == 'custom_titles') {
                         echo ' pane-active';
                     } ?>">
                    <section>

                        <h2><?php _e('Custom Title Options', 'design-approval-system'); ?></h2>
                        <div class="das-float-wrap-2column">

                            <div class="das-settings-admin-input-wrap company-info-style">
                                <div class="das-settings-admin-input-label"><?php _e('Terms Button Title', 'design-approval-system'); ?></div>
                                <input name="das-gq-theme-settings-terms-title" class="das-settings-admin-input" type="text" id="das-gq-theme-settings-terms-title" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('Terms', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" value="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-gq-theme-settings-terms-title') : ''; ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?> />
                                <div class="das-settings-admin-input-example"><?php _e('This changes the title for the text "Terms" in the menu button.', 'design-approval-system'); ?></div>
                                <div class="clear"></div>
                                <a class="das-gq-theme-settings-toggle" href="#"></a>
                                <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/terms-title.png" alt="" /></div>
                                <!--/das-settings-id-answer-->
                                <div class="clear"></div>
                            </div>
                            <!--/das-settings-admin-input-wrap-->




                            <div class="das-settings-admin-input-wrap company-info-style">
                                <div class="das-settings-admin-input-label"><?php _e('Project Details Title', 'design-approval-system'); ?></div>
                                <input name="das-gq-theme-settings-title" class="das-settings-admin-input" type="text" id="das-gq-theme-settings-title" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('Project Details', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" value="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-gq-theme-settings-title') : ''; ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?>/>
                                <div class="das-settings-admin-input-example"><?php _e('This changes the title for  the text "Designer\'s Notes" near the bottom of the theme.', 'design-approval-system'); ?></div>
                                <div class="clear"></div>
                                <a class="das-gq-theme-settings-toggle" href="#"></a>
                                <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/project-details-title.png" alt="" /></div>
                                <!--/das-settings-id-answer-->
                                <div class="clear"></div>
                            </div>
                            <!--/das-settings-admin-input-wrap-->



                            <div class="das-settings-admin-input-wrap company-info-style">
                                <div class="das-settings-admin-input-label"><?php _e('Client Title in Project Notes', 'design-approval-system'); ?></div>
                                <input name="das-gq-theme-settings-client-notes-name" class="das-settings-admin-input" type="text" id="das-gq-theme-settings-client-notes-name" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('Client', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" value="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-gq-theme-settings-client-notes-name') : ''; ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?> />
                                <div class="das-settings-admin-input-example"><?php _e('This changes the word "Client" next to where the clients name would be.', 'design-approval-system'); ?></div>
                                <div class="clear"></div>
                                <a class="das-gq-theme-settings-toggle" href="#"></a>
                                <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/client-title.png" alt="" /></div>
                                <!--/das-settings-id-answer-->
                                <div class="clear"></div>
                            </div>
                            <!--/das-settings-admin-input-wrap-->



                            <div class="das-settings-admin-input-wrap company-info-style">
                                <div class="das-settings-admin-input-label"><?php _e('Designer Title in Project Notes', 'design-approval-system'); ?></div>
                                <input name="das-gq-theme-settings-designer-name-title" class="das-settings-admin-input" type="text" id="das-gq-theme-settings-designer-name-title" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('Designer', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" value="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-gq-theme-settings-designer-name-title') : ''; ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?> />
                                <div class="das-settings-admin-input-example"><?php _e('This changes the word "Designer" next to where your name would be. For example you could change it to, Photographer: Your Name.', 'design-approval-system'); ?></div>
                                <div class="clear"></div>
                                <a class="das-gq-theme-settings-toggle" href="#"></a>
                                <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/designer-title.png" alt="" /></div>
                                <!--/das-settings-id-answer-->
                                <div class="clear"></div>
                            </div>
                            <!--/das-settings-admin-input-wrap-->





                            <div class="das-settings-admin-input-wrap company-info-style">
                                <div class="das-settings-admin-input-label"><?php _e('Design Options Title', 'design-approval-system'); ?></div>
                                <input name="das-gq-theme-settings-design-options-title" class="das-settings-admin-input" type="text" id="das-gq-theme-settings-design-options-title" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('Design Options', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" value="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-gq-theme-settings-design-options-title') : ''; ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?> />
                                <div class="das-settings-admin-input-example"><?php _e('This changes the title for the text "Design Options" near the bottom of the theme.', 'design-approval-system'); ?></div>
                                <div class="clear"></div>
                                <a class="das-gq-theme-settings-toggle" href="#"></a>
                                <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/design-options-title.png" alt="" /></div>
                                <!--/das-settings-id-answer-->
                                <div class="clear"></div>
                            </div>
                            <!--/das-settings-admin-input-wrap-->



                            <div class="das-settings-admin-input-wrap company-info-style">
                                <div class="das-settings-admin-input-label"><?php _e('Project Comments Title', 'design-approval-system'); ?></div>
                                <input name="das-gq-theme-settings-client-notes-title" class="das-settings-admin-input" type="text" id="das-gq-theme-settings-client-notes-title" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('Project Notes', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" value="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-gq-theme-settings-client-notes-title') : ''; ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?> />
                                <div class="das-settings-admin-input-example"><?php _e('This changes the title for the text "Project Comments" near the bottom of the theme.', 'design-approval-system'); ?></div>
                                <div class="clear"></div>
                                <a class="das-gq-theme-settings-toggle" href="#"></a>
                                <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/project-comments-title.png" alt="" /></div>
                                <!--/das-settings-id-answer-->
                                <div class="clear"></div>
                            </div>
                            <!--/das-settings-admin-input-wrap-->


                            <div class="das-settings-admin-input-wrap company-info-style">
                                <div class="das-settings-admin-input-label"><?php _e('Invoice Title', 'design-approval-system'); ?></div>
                                <input name="das-view-invoice-title" class="das-settings-admin-input" type="text" id="das-view-invoice-title" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('Invoice', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" value="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-view-invoice-title') : ''; ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?> />
                                <div class="das-settings-admin-input-example"><?php _e('This changes the title for the text "Invoice" near the bottom of the theme.', 'design-approval-system'); ?></div>
                                <div class="clear"></div>
                                <a class="das-gq-theme-settings-toggle" href="#"></a>
                                <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/invoice-title-text.png" alt="" /></div>
                                <!--/das-settings-id-answer-->
                                <div class="clear"></div>
                            </div>
                            <!--/das-settings-admin-input-wrap-->



                            <div class="das-settings-admin-input-wrap company-info-style">
                                <div class="das-settings-admin-input-label"><?php _e('View Invoice Text Link', 'design-approval-system'); ?></div>
                                <input name="das-view-invoice-text" class="das-settings-admin-input" type="text" id="das-view-invoice-text" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('View Invoice', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" value="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-view-invoice-text') : ''; ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?> />
                                <div class="das-settings-admin-input-example"><?php _e('This changes the title for the linked text "View Invoice" near the bottom of the theme.', 'design-approval-system'); ?></div>
                                <div class="clear"></div>
                                <a class="das-gq-theme-settings-toggle" href="#"></a>
                                <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/invoice-link-text.png" alt="" /></div>
                                <!--/das-settings-id-answer-->
                                <div class="clear"></div>
                            </div>
                            <!--/das-settings-admin-input-wrap-->


                            <div class="clear"></div>
                        </div>
                        <!-- das-float-wrap-2column -->

                    </section>
                    <input type="submit" class="button button-primary"
                           value="<?php _e('Save All Changes'); ?>"/>
                </div> <!-- #tab-content3 -->

                <div id="tab-content4"
                     class="tab-content side-sup-hide-me <?php if (isset($_GET['tab']) && $_GET['tab'] == 'color_options') {
                         echo ' pane-active';
                     } ?>">
                    <section>
                        <h2><?php _e('Custom Color Options', 'design-approval-system'); ?></h2>
                        <div class="das-settings-admin-input-wrap company-info-style das-gq-theme-turn-on-custom-colors">

                            <div class="view-all-custom"><a class="icon-view-all das-color-options-open-close-all" href="#"><span class="view-all-articles"><?php _e('open / close', 'design-approval-system'); ?><br>
                                        <?php _e('help photos', 'design-approval-system'); ?><span class="arrow-right"></span></span></a></div>





                            <div class="das-settings-admin-input-label das-wp-header-custom"> <?php _e('Check the box to turn on the custom color options below.', 'design-approval-system'); ?></div>
                            <p>
                                <input name="das-gq-theme-settings-custom-css" class="das-settings-admin-input" type="checkbox"  id="das-gq-theme-settings-custom-css" value="1" <?php echo checked( '1', get_option( 'das-gq-theme-settings-custom-css' ) ); ?>/>
                                <?php


                                if (get_option( 'das-gq-theme-settings-custom-css' ) == '1') {
                                    _e('<strong>Checked:</strong> Custom styles being used now.', 'design-approval-system');
                                }
                                else	{
                                    _e('<strong>Not Checked:</strong> You are using the default theme colors.', 'design-approval-system');
                                }
                                ?>
                            </p>

                            <a class="default-values-gq-theme-option1 das-custom-color-btn" href="javascript:;"><?php _e('Set Default Colors', 'design-approval-system'); ?></a> <a class="default-values-gq-theme-option2 das-custom-color-btn" href="javascript:;"><?php _e('Set Color Option 2', 'design-approval-system'); ?></a>

                            <div class="clear"></div>
                        </div>
                        <!--/das-settings-admin-input-wrap-->

                        <div class="das-float-wrap-2column das-ct-color-options-wrap">




                            <div class="das-settings-admin-input-wrap company-info-style">
                                <div class="das-settings-admin-input-label"><?php _e('Icon', 'design-approval-system'); ?></div>
                                <input name="das-gq-theme-project-icon-color" class="das-settings-admin-input color" type="text" id="das-gq-theme-project-icon-color" value="<?php echo get_option('das-gq-theme-project-icon-color'); ?>" />
                                <div class="das-settings-admin-input-example"></div>
                                <div class="clear"></div>
                                <a class="das-gq-theme-settings-toggle" href="#"></a>
                                <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/gq-color-options.png" alt="" /></div>
                                <!--/das-settings-id-answer-->
                                <div class="clear"></div>
                            </div>
                            <!--/das-settings-admin-input-wrap-->





                            <div class="das-settings-admin-input-wrap company-info-style">
                                <div class="das-settings-admin-input-label"><?php _e('Main header text', 'design-approval-system'); ?></div>
                                <input name="das-gq-theme-project-main-header-text-color" class="das-settings-admin-input color" type="text" id="das-gq-theme-project-main-header-text-color" value="<?php echo get_option('das-gq-theme-project-main-header-text-color'); ?>" />
                                <div class="das-settings-admin-input-example"></div>
                                <div class="clear"></div>
                                <a class="das-gq-theme-settings-toggle" href="#"></a>
                                <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/main-header-text-gq-color.png" alt="" /></div>
                                <!--/das-settings-id-answer-->
                                <div class="clear"></div>
                            </div>
                            <!--/das-settings-admin-input-wrap-->





                            <div class="das-settings-admin-input-wrap company-info-style">
                                <div class="das-settings-admin-input-label"><?php _e('Main header background', 'design-approval-system'); ?></div>
                                <input name="das-gq-theme-project-main-header-background-color" class="das-settings-admin-input color" type="text" id="das-gq-theme-project-main-header-background-color" value="<?php echo get_option('das-gq-theme-project-main-header-background-color'); ?>" />
                                <div class="das-settings-admin-input-example"></div>
                                <div class="clear"></div>
                                <a class="das-gq-theme-settings-toggle" href="#"></a>
                                <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/main-header-backg-gq-color.png" alt="" /></div>
                                <!--/das-settings-id-answer-->
                                <div class="clear"></div>
                            </div>
                            <!--/das-settings-admin-input-wrap-->






                            <div class="das-settings-admin-input-wrap company-info-style">
                                <div class="das-settings-admin-input-label"><?php _e('Main Buttons Hover Background', 'design-approval-system'); ?></div>
                                <input name="das-gq-theme-project-background-main-btns-hover" class="das-settings-admin-input color" type="text" id="das-gq-theme-project-background-main-btns-hover" value="<?php echo get_option('das-gq-theme-project-background-main-btns-hover'); ?>" />
                                <div class="das-settings-admin-input-example"></div>
                                <div class="clear"></div>
                                <a class="das-gq-theme-settings-toggle" href="#"></a>
                                <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/main-buttons-hoverbackg-gq-color.png" alt="" /></div>
                                <!--/das-settings-id-answer-->
                                <div class="clear"></div>
                            </div>
                            <!--/das-settings-admin-input-wrap-->




                            <div class="das-settings-admin-input-wrap company-info-style">
                                <div class="das-settings-admin-input-label"><?php _e('Main Buttons Text Hover', 'design-approval-system'); ?></div>
                                <input name="das-gq-theme-project-text-main-btns-hover" class="das-settings-admin-input color" type="text" id="das-gq-theme-project-text-main-btns-hover" value="<?php echo get_option('das-gq-theme-project-text-main-btns-hover'); ?>" />
                                <div class="das-settings-admin-input-example"></div>
                                <div class="clear"></div>
                                <a class="das-gq-theme-settings-toggle" href="#"></a>
                                <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/main-menu-text-hover-gq-color.png" alt="" /></div>
                                <!--/das-settings-id-answer-->
                                <div class="clear"></div>
                            </div>
                            <!--/das-settings-admin-input-wrap-->




                            <div class="das-settings-admin-input-wrap company-info-style">
                                <div class="das-settings-admin-input-label"><?php _e('Text Color', 'design-approval-system'); ?></div>
                                <input name="das-gq-theme-project-text-color" class="das-settings-admin-input color" type="text" id="das-gq-theme-project-text-color" value="<?php echo get_option('das-gq-theme-project-text-color'); ?>" />
                                <div class="das-settings-admin-input-example"></div>
                                <div class="clear"></div>
                                <a class="das-gq-theme-settings-toggle" href="#"></a>
                                <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/text-color-gq-color.png" alt="" /></div>
                                <!--/das-settings-id-answer-->
                                <div class="clear"></div>
                            </div>
                            <!--/das-settings-admin-input-wrap-->




                            <div class="das-settings-admin-input-wrap company-info-style">
                                <div class="das-settings-admin-input-label"><?php _e('Text link', 'design-approval-system'); ?></div>
                                <input name="das-gq-theme-project-text-link-color" class="das-settings-admin-input color" type="text" id="das-gq-theme-project-text-link-color" value="<?php echo get_option('das-gq-theme-project-text-link-color'); ?>" />
                                <div class="das-settings-admin-input-example"></div>
                                <div class="clear"></div>
                                <a class="das-gq-theme-settings-toggle" href="#"></a>
                                <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/text-link-gq-color.png" alt="" /></div>
                                <!--/das-settings-id-answer-->
                                <div class="clear"></div>
                            </div>
                            <!--/das-settings-admin-input-wrap-->






                            <div class="das-settings-admin-input-wrap company-info-style">
                                <div class="das-settings-admin-input-label"><?php _e('Boxes background', 'design-approval-system'); ?></div>
                                <input name="das-gq-theme-project-background-color-boxes" class="das-settings-admin-input color" type="text" id="das-gq-theme-project-background-color-boxes" value="<?php echo get_option('das-gq-theme-project-background-color-boxes'); ?>" />
                                <div class="das-settings-admin-input-example"></div>
                                <div class="clear"></div>
                                <a class="das-gq-theme-settings-toggle" href="#"></a>
                                <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/boxes-backg-gq-color.png" alt="" /></div>
                                <!--/das-settings-id-answer-->
                                <div class="clear"></div>
                            </div>
                            <!--/das-settings-admin-input-wrap-->




                            <div class="das-settings-admin-input-wrap company-info-style">
                                <div class="das-settings-admin-input-label"><?php _e('Comments even background', 'design-approval-system'); ?></div>
                                <input name="das-gq-theme-project-background-color-even-comment-boxes" class="das-settings-admin-input color" type="text" id="das-gq-theme-project-background-color-even-comment-boxes" value="<?php echo get_option('das-gq-theme-project-background-color-even-comment-boxes'); ?>" />
                                <div class="das-settings-admin-input-example"></div>
                                <div class="clear"></div>
                                <a class="das-gq-theme-settings-toggle" href="#"></a>
                                <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/comments-even-backg-gq-color.png" alt="" /></div>
                                <!--/das-settings-id-answer-->
                                <div class="clear"></div>
                            </div>
                            <!--/das-settings-admin-input-wrap-->







                            <div class="das-settings-admin-input-wrap company-info-style">
                                <div class="das-settings-admin-input-label"><?php _e('Border Color', 'design-approval-system'); ?></div>
                                <input name="das-gq-theme-project-border-color" class="das-settings-admin-input color" type="text" id="das-gq-theme-project-border-color" value="<?php echo get_option('das-gq-theme-project-border-color'); ?>" />
                                <div class="das-settings-admin-input-example"></div>
                                <div class="clear"></div>
                                <a class="das-gq-theme-settings-toggle" href="#"></a>
                                <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/border-color-gq-color.png" alt="" /></div>
                                <!--/das-settings-id-answer-->
                                <div class="clear"></div>
                            </div>
                            <!--/das-settings-admin-input-wrap-->

                            <div class="clear"></div>
                        </div>
                        <!-- das-float-wrap-2column -->

                    </section>
                    <input type="submit" class="button button-primary"
                           value="<?php _e('Save All Changes'); ?>"/>

                </div> <!-- #tab-content4 -->


                <div id="tab-content5"
                     class="tab-content side-sup-hide-me <?php if (isset($_GET['tab']) && $_GET['tab'] == 'project_board') {
                         echo ' pane-active';
                     } ?>">
                    <section>
                        <h2><?php _e('Project Board Options', 'design-approval-system'); ?></h2>
                        <div class="das-settings-admin-input-wrap company-info-style">
                            <div class="das-settings-admin-input-label"><?php _e("Add a Project Board button to the Design Template Menu", 'design-approval-system'); ?></div>
                            <p class="special">
                                <input name="das-gq-theme-settings-project-board-btn" class="das-settings-admin-input" type="checkbox"  id="das-gq-theme-settings-project-board-btn" value="1" <?php echo checked( '1', get_option( 'das-gq-theme-settings-project-board-btn' ) ); ?>/>
                                <?php


                                if (get_option( 'das-gq-theme-settings-project-board-btn' ) == '1') {
                                    _e('<strong>Checked:</strong> Project Board Button has been added', 'design-approval-system');
                                }
                                else	{
                                    _e('<strong>Not Checked:</strong> Project Board Menu Button is OFF.', 'design-approval-system');
                                }
                                ?>
                            </p>
                            <div class="clear"></div>
                            <a class="das-gq-theme-settings-toggle" href="#"></a>
                            <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/project-board-btn.png" alt="" /></div>
                            <!--/das-settings-id-answer-->
                            <div class="clear"></div>
                        </div>
                        <!--/das-settings-admin-input-wrap-->

                        <div class="das-settings-admin-input-wrap company-info-style">
                            <div class="das-settings-admin-input-label"><?php _e('Add a Custom Project Board Link', 'design-approval-system');?></div>
                            <input name="das-gq-theme-settings-project-board-btn-link" class="das-settings-admin-input" type="text" id="das-gq-theme-settings-project-board-btn-link" value="<?php echo get_option('das-gq-theme-settings-project-board-btn-link'); ?>" />
                            <div class="das-settings-admin-input-example"><?php _e('Place a link here for the page or post you placed the shortcode [DASFrontEndManager] on. In our example we made a page called Project Board in wordpress, so this would be our link to the page, <strong>http://your-domain-here.com/project-board/</strong>. You must put the whole url in.', 'design-approval-system'); ?>
                            </div>
                        </div>
                        <!--/das-settings-admin-input-wrap-->


                        <div class="das-settings-admin-input-wrap company-info-style">
                            <div class="das-settings-admin-input-label"><?php _e('Custom Project Button Title', 'design-approval-system');?></div>
                            <input name="das-gq-theme-settings-project-board-btn-custom-name" class="das-settings-admin-input" type="text" id="das-gq-theme-settings-project-board-btn-custom-name" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" value="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-gq-theme-settings-project-board-btn-custom-name') : ''; ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?> />
                            <div class="das-settings-admin-input-example"><?php _e('If you leave this blank the button will be called Project Board', 'design-approval-system'); ?>

                            </div>
                        </div>
                        <!--/das-settings-admin-input-wrap-->


                        <div class="das-settings-admin-input-wrap company-info-style">
                            <div class="das-settings-admin-input-label"><?php _e('Project Board Login Text', 'design-approval-system'); ?></div>

                            <textarea name="das-custom-pb-board-login-message" class="das-settings-admin-input" type="text" id="das-custom-pb-board-login-message" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('Please login to view your projects.', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?>><?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-custom-pb-board-login-message') : ''; ?></textarea>
                            <div class="das-settings-admin-input-example"><?php _e('This text is displayed on your Project Board page.', 'design-approval-system'); ?></div>

                            <div class="clear"></div>
                            <a class="das-gq-theme-settings-toggle" href="#"></a>
                            <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/das-custom-pb-board-login-message.png" alt="" /></div>
                            <!--/das-settings-id-answer-->
                            <div class="clear"></div>
                        </div>
                        <!--/das-settings-admin-input-wrap-->


                        <!--/das-gq-theme-settings-admin-input-wrap-->
                        <h3 class="das-margin-top"><?php _e('Limit Versions & Order Designs Displayed', 'design-approval-system'); ?></h3>
                        <div class="das-settings-admin-input-wrap company-info-style design-limits-style">

                            <p class="special"><?php _e('Set this value to 0 to display all design versions. Or, set the limit for how many of the most recent designs should be displayed.  Also set the amount of
          additional designs to be displayed when the user clicks the "Load More" button.', 'design-approval-system'); ?><br/><br/>
                                <?php _e('Click the checkbox to allow the limiting/load more options below to take effect.', 'design-approval-system'); ?>
                                <?php if(isset($das_premium) && $das_premium == true) { ?>
                                    <br/><br/><input name="das-gq-theme-limit-versions-checkbox" class="das-settings-admin-input fleft"
                                                     type="checkbox" id="das-gq-theme-limit-versions-checkbox"
                                                     value="1" <?php checked('1', get_option('das-gq-theme-limit-versions-checkbox')); ?> />
                                    <?php
                                    $limitDesignsActive = get_option('das-gq-theme-limit-versions-checkbox');

                                    if ($limitDesignsActive == '1') {
                                        _e('Checked, Display limits are in effect', 'design-approval-system');
                                    } else {
                                        _e('Not checked, Display limits are NOT in effect', 'design-approval-system');
                                    }
                                } else {
                                    ?>
                                    <br /><br /><input name="das-gq-theme-client-changes-global" class="das-settings-admin-input fleft das-premium-required" type="checkbox" id="das-gq-theme-client-changes-global" value="1" disabled="disabled" />
                                    <?php _e('Premium Plugin Required to use this option', 'design-approval-system'); } ?>
                            </p>

                            <?php
                            if(isset($das_premium) && $das_premium == true) {
                                ?>
                                <p>
                                    <label><?php _e('Limit (0 = infinite):', 'design-approval-system'); ?></label>
                                    <input name="das-gq-theme-limit-versions-displayed" class="das-gq-theme-settings-admin-input" type="text"
                                           id="das-gq-theme-limit-versions-displayed"
                                           value="<?php
                                           if(!get_option('das-gq-theme-limit-versions-displayed')) {
                                               echo '0';
                                           } else {
                                               echo get_option('das-gq-theme-limit-versions-displayed');
                                           } ?>"
                                           title="Only Numbers are allowed"/>
                                </p><div class="clear"></div>
                                <p>
                                    <label><?php _e('"Load More" Button amount (0 = Load All):', 'design-approval-system'); ?></label>
                                    <input name="das-gq-theme-limit-versions-displayed-load-more" class="das-gq-theme-settings-admin-input" type="text"
                                           id="das-gq-theme-limit-versions-displayed-load-more"
                                           value="<?php
                                           if(!get_option('das-gq-theme-limit-versions-displayed-load-more')) {
                                               echo '0';
                                           } else {
                                               echo get_option('das-gq-theme-limit-versions-displayed-load-more');
                                           } ?>"
                                           title="Only Numbers are allowed"/>
                                </p><div class="clear"></div>
                                <p>
                                    <label><?php _e('Select order Designs are displayed:', 'design-approval-system'); ?></label>
                                    <select name="das-gq-theme-order-versions-displayed" class="das-gq-theme-settings-admin-select" id="das-gq-theme-order-versions-displayed">
                                        <option value="DESC" <?php if( get_option( 'das-gq-theme-order-versions-displayed' ) == 'DESC' ){ echo 'selected'; } ?>>Latest First</option>
                                        <option value="ASC" <?php if( get_option( 'das-gq-theme-order-versions-displayed' ) == 'ASC' ){ echo 'selected'; } ?>>Oldest First </option>
                                    </select>
                                </p>
                                <?php
                            } ?>
                            </p>
                            <div class="clear"></div>
                        </div>
                        <!--/das-settings-admin-input-wrap-->


                    </section>
                    <input type="submit" class="button button-primary das-final-save-all-changes-button"
                           value="<?php _e('Save All Changes'); ?>"/>

                </div> <!-- #tab-content5 -->


                <div id="tab-content6"
                     class="tab-content side-sup-hide-me <?php if (isset($_GET['tab']) && $_GET['tab'] == 'woocomerce') {
                         echo ' pane-active';
                     } ?>">
                    <section>

                        <?php 	if(isset($das_premium) && $das_premium == true) { ?>
                            <h2><?php _e('WooCommerce Options', 'design-approval-system'); ?></h2>



                            <div class="das-settings-admin-input-wrap company-info-style">
                                <div class="das-settings-admin-input-label"><?php _e('Project Board Custom Login URL', 'design-approval-system');?></div>
                                <input name="das-gq-theme-settings-project-board-login-link" class="das-settings-admin-input" type="text" id="das-gq-theme-settings-project-board-login-link" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" value="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-gq-theme-settings-project-board-login-link') : ''; ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?> />
                                <div class="das-settings-admin-input-example"><?php _e('Add a custom login URL if you do not want to use the default login page for wordpress. Since WooCommerce custom login forms redirect clients to the My Account page you will want to check the option below so your clients can get back to the Project Board.', 'design-approval-system'); ?>

                                </div>
                            </div>
                            <!--/das-settings-admin-input-wrap-->

                            <div class="das-settings-admin-input-wrap company-info-style">
                                <div class="das-settings-admin-input-label"><?php _e('My Account Page, Project Board Link', 'design-approval-system');?></div>
                                <p style="margin-top:0;"><?php _e('This will show the Project Board title and a View Project Board link on the My Account page for your clients. If they do not have any projects then this option will not show up in the My Account Page.', 'design-approval-system') ?></p>

                                <p class="special">

                                    <input name="woo-view-project-board-section" class="das-settings-admin-input fleft" type="checkbox" id="woo-view-project-board-section" value="1" <?php checked( '1', get_option( 'woo-view-project-board-section' ) ); ?> />
                                    <?php
                                    $dasWooMyAccountActive = get_option( 'woo-view-project-board-section' );

                                    if ($dasWooMyAccountActive == '1') {
                                        _e('Checked, you are adding this option to the My Account Page.', 'design-approval-system');
                                    }
                                    else	{
                                        _e('Not checked, you are NOT adding this option to the My Account Page.', 'design-approval-system');
                                    }

                                    ?>
                                </p>
                            </div>
                            <!--/das-settings-admin-input-wrap-->


                            <div class="das-settings-admin-input-wrap company-info-style">
                                <div class="das-settings-admin-input-label"><?php _e('DAS Products id column from the Woo Orders Page', 'design-approval-system');?></div>
                                <p style="margin-top:0;"><?php _e('This will hide the additional column that shows the DAS Product ids for the order on the <a href="edit.php?post_type=shop_order">WooCommerce Orders</a> page.', 'design-approval-system') ?></p>
                                <p class="special">

                                    <input name="remove-woo-order-prod-id-column" class="das-settings-admin-input fleft" type="checkbox" id="remove-woo-order-prod-id-column" value="1" <?php checked( '1', get_option( 'remove-woo-order-prod-id-column' ) ); ?> />
                                    <?php
                                    $dasWooRemoveOrderColumn = get_option( 'remove-woo-order-prod-id-column' );

                                    if ($dasWooRemoveOrderColumn == '1') {
                                        _e(' Checked, you are NOT adding the column on the Woo Orders page', 'design-approval-system');
                                    }
                                    else	{

                                        _e('Not checked, you are ADDING the column to the Woo Orders page', 'design-approval-system');
                                    }

                                    ?>
                                </p>
                            </div>
                            <!--/das-settings-admin-input-wrap-->



                            <div class="das-settings-admin-input-wrap company-info-style">
                                <div class="das-settings-admin-input-label"><?php _e('WooCommerce Column Information', 'design-approval-system');?></div>
                                <p style="margin-top:0;"><?php _e('Choose what info from the product you would like to appear in the column. If multiple products are tied to an order they will be listed out.', 'design-approval-system') ?></p>
                                <p class="special">
                                    <?php $dasWooProdIdOptions = get_option('woo-order-prod-id-column-options'); ?>

                                    <select name="woo-order-prod-id-column-options" id="woo-order-prod-id-column-options">
                                         <option value="default" <?php if ($dasWooProdIdOptions == 'default' ) echo 'selected="selected"'; ?>><?php echo('Product(s) ID Number'); ?></option>
                                         <option value="option1" <?php if ($dasWooProdIdOptions == 'option1' ) echo 'selected="selected"'; ?>><?php echo('First word of the design name. Useful if you work with order numbers'); ?></option>
                                  </select>

                                </p>
                            </div>
                            <!--/das-settings-admin-input-wrap-->



                            <div class="das-settings-admin-input-wrap company-info-style">
                                <div class="das-settings-admin-input-label"><?php _e('Hide Create Product Option', 'design-approval-system');?></div>
                                <p style="margin-top:0;"><?php _e('This will hide the WooCommerce Options from the Create Project Tab on the front end.', 'design-approval-system') ?></p>
                                <p class="special">

                                    <input name="woo-hide-option-project-creation-frontend" class="das-settings-admin-input fleft" type="checkbox" id="woo-hide-option-project-creation-frontend" value="1" <?php checked( '1', get_option( 'woo-hide-option-project-creation-frontend' ) ); ?> />
                                    <?php
                                    $dasWooProjectCreationActive = get_option( 'woo-hide-option-project-creation-frontend' );

                                    if ($dasWooProjectCreationActive == '1') {
                                        _e(' Checked, you are NOT adding this option to the Create New Project Tab.', 'design-approval-system');
                                    }
                                    else	{

                                        _e('Not checked, you are ADDING this option to the Create New Project Tab.', 'design-approval-system');
                                    }

                                    ?>
                                </p>
                            </div>
                            <!--/das-settings-admin-input-wrap-->

                        <?php } ?>



                    </section>
                    <input type="submit" class="button button-primary das-final-save-all-changes-button"
                           value="<?php _e('Save All Changes'); ?>"/>
                </div> <!-- #tab-content6 -->

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



















    <!-- <input class="das-settings-admin-submit-btn" name="Reset" type="submit" value="< ?php _e('reset', das-gq-theme-settings-title-color); ?>" />
         <input name="action" type="hidden" value="reset" /> -->

    </form>

    <div class="das-settings-icon-wrap"><a href="https://www.facebook.com/SlickRemix" target="_blank" class="facebook-icon"></a><a class="das-settings-admin-slick-logo" href="http://www.slickremix.com" target="_blank"></a></div>
    </div>
    <!--/das-settings-admin-wrap-->

    <script type="text/javascript" src="<?php echo plugins_url(); ?>/design-approval-system/templates/gq-template/admin/js/jscolor/jscolor.js"></script>
    <script type="text/javascript" src="<?php echo plugins_url(); ?>/design-approval-system/templates/gq-template/admin/js/admin.js"></script>

    <script>

        jQuery( document ).ready(function() {
            jQuery( ".toggle-custom-textarea-show" ).click(function() {
                jQuery('textarea#das-gq-theme-main-wrapper-css-input').slideToggle('fast');
                jQuery('.toggle-custom-textarea-show span').toggle();
                jQuery('.das-custom-css-text').toggle();

            });

            jQuery( ".toggle-custom-textarea-show-terms" ).click(function() {
                jQuery('textarea#das-gq-theme-main-wrapper-custom-terms').slideToggle('fast');
                jQuery('.toggle-custom-textarea-show-terms span').toggle();
                //  jQuery('.das-custom-css-text').toggle();

            });
        });
    </script>
    <?php
}
?>