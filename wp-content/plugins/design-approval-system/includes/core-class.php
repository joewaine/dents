<?php namespace Design_Approval_System;

class Design_Approval_System_Core
{


    public $das_post_id = "";

    function __construct() {

        $this->das_post_id = isset($_POST['das_post_id']) ? $_POST['das_post_id'] : '';

        //DAS License Page
        if (isset($_GET['page']) && $_GET['page'] == 'das-license-page') {
            add_action('admin_footer', array($this, 'das_plugin_license'));
        }
        //Register DAS Taxonomies on plugin activation.
        register_activation_hook(__FILE__, array($this, 'design_approval_system__custom_tax_activate'));
        add_action('init', array($this, 'register_taxonomy_das_categories'));
        //Register DAS Custom Post Type on plugin activation.
        add_filter('cpt_post_types', array($this, 'das_cpt_post_type'));
        register_activation_hook(__FILE__, array($this, 'design_approval_system_activate'));
        add_action('init', array($this, 'das_custom_post_type_init'));
        //Admin CSS
        add_action('admin_enqueue_scripts', array($this, 'das_admin_css'));
        //Admin JS (Actually loads in footer)
        add_action('admin_head', array($this, 'das_admin_js'));
        //Register Settings Page Settings
        add_action('admin_init', array($this, 'das_settings_page_register_settings'));
        //Settings Page Scripts
        if (isset($_GET['page']) && $_GET['page'] == 'design-approval-system-settings-page') {
            add_action('admin_enqueue_scripts', array($this, 'das_main_settings_admin_scripts'));
        }
        //Help Page Scripts
        if (isset($_GET['page']) && $_GET['page'] == 'design-approval-system-help-page') {
            add_action('admin_enqueue_scripts', array($this, 'das_help_settings_admin_scripts'));
        }
        //DAS Dependencies
        add_action('admin_notices', array($this, 'das_dependencies'));
        //Ajax (next three Actions are all Relative to each other.)
        add_action('init', array($this, 'das_check_ajax'));
        // NOTE: adding wp_ajax_nopriv_ before wp_ajax allows you to submit when user is logged in (wp_ajax) or not (wp_ajax_nopriv)
        add_action('wp_ajax_nopriv_my_user_dasChecker', array($this, 'my_user_dasChecker'));
        add_action('wp_ajax_my_user_dasChecker', array($this, 'my_user_dasChecker'));
        // This is for the DESIGN REQUEST/CHANGES submission
        // NOTE: adding wp_ajax_nopriv_ before wp_ajax allows you to submit when user is logged in (wp_ajax) or not (wp_ajax_nopriv)
        add_action('wp_ajax_nopriv_my_client_changes_dasChecker', array($this, 'my_client_changes_dasChecker'));
        add_action('wp_ajax_my_client_changes_dasChecker', array($this, 'my_client_changes_dasChecker'));
        // send email link
        add_action('wp_ajax_nopriv_das_send_message', array($this, 'das_send_message'));
        add_action('wp_ajax_das_send_message', array($this, 'das_send_message'));

        //Override default Wordpress Post Template
        add_filter('single_template', array($this, 'DAS_post_template'), 999);
        //Front End Redirect
        add_action('get_header', array($this, 'das_admin_redirect'));
        //Remove DAS Categories from WooCommerce (needs to be put into WooFor DAS class
        add_action('pre_get_posts', array($this, 'das_woo_pre_get_posts_query'));
        //Start Walkthrough
        add_action('admin_enqueue_scripts', array($this, 'myDasHelpPointers'));

        $old_plugs = $this->old_extenstions_check();
        //If there are old plugins Display notice!
        if ($old_plugs == true) {
            add_action('admin_notices', array($this, 'das_old_plugin_admin_notice'));
            add_action('admin_init', array($this, 'das_old_plugins_ignore'));
        }
        add_action('admin_init', array($this, 'das_old_extenstions_block'));

        $dasSettingsSmtp = get_option('das-settings-smtp');

        add_shortcode('das_company_name', array($this, 'das_company_name'));
        add_shortcode('das_designer_name', array($this, 'das_designer_name'));

        if (is_plugin_active('das-manager/das-manager.php')) {
            add_shortcode('das_manager_name', array($this, 'das_manager_name'));
            add_shortcode('das_manager_email', array($this, 'das_manager_email'));
            add_shortcode('das_manager_changes_comments', array($this, 'das_manager_changes_comments'));
            add_shortcode('das_manager_text', array($this, 'das_manager_text'));
            add_shortcode('das_client_text', array($this, 'das_client_text'));
        }

        add_shortcode('das_client_name', array($this, 'das_client_name'));
        add_shortcode('das_client_email', array($this, 'das_client_email'));
        add_shortcode('das_version_number', array($this, 'das_version_number'));
        add_shortcode('das_name_of_design', array($this, 'das_name_of_design'));
        add_shortcode('das_design_link', array($this, 'das_design_link'));
        add_shortcode('das_date', array($this, 'das_date'));
        add_shortcode('das_designer_notes', array($this, 'das_designer_notes'));
        add_shortcode('das_approved_signature', array($this, 'das_approved_signature'));
        add_shortcode('das_approved_comments', array($this, 'das_approved_comments'));
        add_shortcode('das_changes_comments', array($this, 'das_changes_comments'));
        add_shortcode('das_project_start_end', array($this, 'das_project_start_end'));
        if (is_plugin_active('woocommerce/woocommerce.php') && is_plugin_active('das-premium/das-premium.php')) {
            add_shortcode('das_woo_price', array($this, 'das_woo_price'));

            if(get_option('remove-woo-order-prod-id-column') !== '1') {
                add_action('manage_shop_order_posts_custom_column', array($this, 'wpso23858236_shop_order_column_offercode'), 10, 2);
                add_filter('manage_edit-shop_order_columns', array($this, 'add_sales_column'), 11);
            }
        }
    }



    function get_order_details($order_id){

        // 1) Get the Order object
        $order = wc_get_order( $order_id );

        //  print_r($order);
        // 3) Get the order items
        $items = $order->get_items();

        foreach ( $items as $item_id => $item_data ) {
            //  print_r($items);
            //  echo 'Item ID: ' . $item_id. '<br>';
            $item = explode(" ", $item_data['name']);
            // only the ID portion before the first space happens

            echo '<a href="' . get_the_permalink($item_data['product_id']) . '" target="_blank">';
            if(get_option('woo-order-prod-id-column-options') == FALSE || get_option('woo-order-prod-id-column-options') == 'default' ) {
                echo $item_data['product_id'];
            }
            elseif(get_option('woo-order-prod-id-column-options') == 'option1'){
                echo rtrim($item[0],',');
            }
            echo '</a><br/>';
        }
    }



    function wpso23858236_shop_order_column_offercode( $column, $post_id ) {

        global $woocommerce, $post, $wpdb;

        if ( $column == 'das-id' ) {
            $item = explode(" ", get_the_title($post_id));
            //			echo $post_id; // only the ID portion before the first space happens


            $this->get_order_details($post_id);

        }
    }

    function add_sales_column($columns) {
        $columns['das-id'] = "DAS Product";
        return $columns;
    }


    // DAS COMPANY NAME SHORTCODE
    function das_company_name($atts) {
        $das_settings_company_name = get_option("das-settings-company-name");
        return $das_settings_company_name;
    }

    // DAS DESIGNER NAME SHORTCODE
    function das_designer_name($atts) {
        $das_designer_name = get_post_meta($this->das_post_id, 'custom_designers_name', true);
        return $das_designer_name;
    }


    // DAS CLIENT TEXT SHORTCODE
    function das_manager_text($atts, $content = null) {
        $das_manager_client_version = get_post_meta($this->das_post_id, 'das_manager_client_version', true);
        if ($das_manager_client_version !== 'yes') {
          //  $das_settings_client_email = get_post_meta($this->das_post_id, 'custom_client_name', true);
            // In this case we call do_shortcode again in case the user wants to add shortcodes inside the main shortcode
            return do_shortcode($content);
        }
    }
    // DAS CLIENT TEXT SHORTCODE
    function das_client_text($atts, $content = null) {
        $das_manager_client_version = get_post_meta($this->das_post_id, 'das_manager_client_version', true);
        if (isset($das_manager_client_version) && $das_manager_client_version == 'yes') {
            // In this case we call do_shortcode again in case the user wants to add shortcodes inside the main shortcode
            return do_shortcode($content);
        }
    }


    // DAS CLIENT NAME SHORTCODE
    function das_client_name($atts) {
        $das_client_name = get_post_meta($this->das_post_id, 'custom_client_name', true);
        return $das_client_name;
    }

    // DAS MANAGER NAME SHORTCODE
    function das_manager_name($atts) {
            $das_settings_manager_name = get_post_meta($this->das_post_id, 'custom_manager_name', true);
            return $das_settings_manager_name;
    }

    // DAS MANAGER NAME SHORTCODE
    function das_manager_email($atts) {
        $das_settings_manager_email = get_post_meta($this->das_post_id, 'custom_manager_email', true);
        return $das_settings_manager_email;
    }

    // DAS MANAGER CHANGES
    function das_manager_changes_comments($atts) {
        $das_settings_manager_email = get_post_meta($this->das_post_id, 'custom_manager_notes', true);
        return $das_settings_manager_email;
    }

    // DAS CLIENT EMAIL SHORTCODE
    function das_client_email($atts) {
        $das_client_email = get_post_meta($this->das_post_id, 'custom_clients_email', true);
        return $das_client_email;
    }

    // DAS CUSTOM VERSION OF DESIGN SHORTCODE
    function das_version_number($atts) {
        $das_version_number = get_post_meta($this->das_post_id, 'custom_version_of_design', true);
        return $das_version_number;
    }

    // DAS NAME OF DESIGN SHORTCODE
    function das_name_of_design($atts) {
        $das_name_of_design = get_the_title($this->das_post_id);
        return $das_name_of_design;
    }

    // DAS DESIGN LINK SHORTCODE
    function das_design_link($atts) {
        $das_design_link = get_permalink($this->das_post_id);
        return $das_design_link;
    }

    // DAS DESIGN LINK SHORTCODE
    function das_date($atts) {
        extract(shortcode_atts(array(
            'customize' => 'F j, Y',
        ), $atts));
        return date_i18n($customize);
    }

    // DAS WOO PRICE SHORTCODE
    function das_woo_price($atts) {
        $das_woo_price = get_woocommerce_currency_symbol() . get_post_meta($this->das_post_id, 'custom_woo_design_price', true);
        return $das_woo_price;
    }

    // DAS NAME OF DESIGN SHORTCODE
    function das_changes_comments($atts) {
        $das_changes_comments = get_post_meta($this->das_post_id, 'custom_client_notes', true);
        return $das_changes_comments;
    }

    // DAS NAME OF DESIGN SHORTCODE
    function das_designer_notes($atts) {
        $das_designer_notes = get_post_meta($this->das_post_id, 'custom_designer_notes', true);
        return $das_designer_notes;
    }

    // DAS NAME OF DESIGN SHORTCODE
    function das_project_start_end($atts) {
        $das_project_start_end = get_post_meta($this->das_post_id, 'custom_project_start_end', true);
        return $das_project_start_end;
    }

    // DAS APPROVED DIGITAL SIGNATURE SHORTCODE
    function das_approved_signature($atts) {
        $das_digital_signature = get_post_meta($this->das_post_id, 'custom_client_approved_signature', true);
        return $das_digital_signature;
    }

    // DAS APPROVED COMMENTS SHORTCODE
    function das_approved_comments($atts) {
        $das_approved_comments = get_post_meta($this->das_post_id, 'custom_client_approved_comments', true);
        return $das_approved_comments;
    }

    //**************************************************
    // DAS Send Email to Client Submission Ajax
    //**************************************************
    function das_send_message() {
        // FORM TYPES
        // testEmailSettingsPage
        // sendEmailForClient
        // approvedEmail
        // requestChangesEmail
        // testApprovedEmailToDesigner
        // testApprovedEmailToClient
        // testChangesEmailToClient
        // testChangesEmailToDesigner
        // testSendEmailToClient
        $das_form_type = $_POST['das_form_type'];
        //Company Info
        $das_settings_company_name = get_option("das-settings-company-name");
        $das_settings_company_email = get_option("das-settings-company-email");
        $das_settings_bcc_email = get_option("das-settings-bcc-email");
        $submitApprovedYes = 'Yes';

        if ($das_form_type !== 'testEmailSettingsPage') {
            // Get post info
            $das_post_id = $_POST['das_post_id'];
            //Messages
            $das_settings_email_for_designers_message_to_clients = get_option('das-settings-email-for-designers-message-to-clients');

            $das_settings_approved_dig_sig_message_to_designer = get_option('das-settings-approved-dig-sig-message-to-designer');
            $das_settings_approved_dig_sig_message_to_client = get_option('das-settings-approved-dig-sig-message-to-clients');
            $das_settings_design_requests_message_to_designer = get_option('das-settings-design-requests-message-to-designer');
            $das_settings_design_requests_message_to_clients = get_option('das-settings-design-requests-message-to-clients');

            $customNameOfDesign = get_post_meta($das_post_id, 'custom_name_of_design', true);

            if (is_plugin_active('das-manager/das-manager.php') && get_post_meta($das_post_id, 'das_manager_client_version', true) !== 'yes' ) {
                $companyname4 = get_post_meta($das_post_id, 'custom_manager_name', true);
                $designclientemail = get_post_meta($das_post_id, 'custom_manager_email', true);
            }
            else {
                $companyname4 = get_post_meta($das_post_id, 'custom_client_name', true);
                $designclientemail = get_post_meta($das_post_id, 'custom_clients_email', true);
             }

            $designer_email = get_post_meta($das_post_id, 'custom_designers_email', true);
            $version4 = get_post_meta($das_post_id, 'custom_version_of_design', true);
            $link4 = get_permalink($das_post_id);

            // custom approved options
            $custom_client_approved_signature = $_POST['custom_client_approved_signature'];
            $approved_comments = $_POST['approved_comments'];
            $approved_date = date_i18n('l, F jS, Y \a\t g:ia');
            //Custom Client Changes
            $custom_client_changes = $_POST['custom_client_changes'];
            //Create Post Info Array!
            $post_info_array = array(
                'das_form_type' => $das_form_type,
                'companyname4' => $companyname4,
                'version4' => $version4,
                'link4' => $link4,
                'designclientemail' => $designclientemail,
                'custom_client_approved_signature' => $custom_client_approved_signature,
                'submitApprovedYes' => $submitApprovedYes,
                'customNameOfDesign' => $customNameOfDesign,
                'approved_comments' => $approved_comments,
                'das_settings_company_name' => $das_settings_company_name,
                'custom_client_changes' => $custom_client_changes,
            );
        }
        if ($das_form_type == 'testEmailSettingsPage') {
            $das_settings_smtp_email = get_option('das-smtp-authenticate-username');
            $smtp_checked = get_option('das-settings-smtp');
        }

        //if the errors array is empty, send the mail
        $recipients = array('designer', 'client');

        //which message to show based on the form submitted
        if ($das_form_type == 'sendEmailForClient') {
            $content = $das_settings_email_for_designers_message_to_clients;
        } elseif ($das_form_type == 'approvedEmail') {
            $content_designer = $das_settings_approved_dig_sig_message_to_designer;
            $content = $das_settings_approved_dig_sig_message_to_client;
        } elseif ($das_form_type == 'requestChangesEmail') {
            $content_designer = $das_settings_design_requests_message_to_designer;
            $content = $das_settings_design_requests_message_to_clients;
        }

        // TESTING EMAILS ONLY FROM SETTINGS PAGE
        if ($das_form_type == 'testSendEmailToClient') {
            $content_designer = $das_settings_email_for_designers_message_to_clients;
        }
        // TESTING EMAILS ONLY FROM SETTINGS PAGE
        if ($das_form_type == 'testApprovedEmailToDesigner') {
            $content_designer = $das_settings_approved_dig_sig_message_to_designer;
        }
        // TESTING EMAILS ONLY FROM SETTINGS PAGE
        if ($das_form_type == 'testApprovedEmailToClient') {
            $content_designer = $das_settings_approved_dig_sig_message_to_client;
        }
        // TESTING EMAILS ONLY FROM SETTINGS PAGE
        if ($das_form_type == 'testChangesEmailToClient') {
            $content_designer = $das_settings_design_requests_message_to_clients;
        }
        // TESTING EMAILS ONLY FROM SETTINGS PAGE
        if ($das_form_type == 'testChangesEmailToDesigner') {
            $content_designer = $das_settings_design_requests_message_to_designer;
        }

        // write the beginning of the shortcode so we can check to see if it's in the form before deciding to use default text and form or form and shortcode
        // which means the default text is omitted and the user must fill out all the details of the form using the shortcodes and arrange it how they like.
        //this was done because of previous users who may have had text already filled out on the settings page for the emails.
        $shortcode = '[das_';

        $check_designer = strpos($content_designer, $shortcode);
        $check = strpos($content, $shortcode);
        // Here we rename the das form type so we can pass the proper value so the email template can send the proper info
        if ($das_form_type == 'testSendEmailToClient'){
            $test_das_form_type = 'sendEmailForClient';
        }
        if ($das_form_type == 'testApprovedEmailToDesigner'){
            $test_das_form_type = 'approvedEmail';
        }
        if ($das_form_type == 'testApprovedEmailToClient'){
            $test_das_form_type = 'approvedEmailClient';
        }
        if ($das_form_type == 'testChangesEmailToDesigner'){
            $test_das_form_type = 'requestChangesEmail';
        }
        if ($das_form_type == 'testChangesEmailToClient'){
            $test_das_form_type = 'requestChangesEmailClient';
        }
        if ($das_form_type == 'testSendEmailToClient' ||
            $das_form_type == 'testEmailSettingsPage' ||
            $das_form_type == 'testApprovedEmailToDesigner' ||
            $das_form_type == 'testApprovedEmailToClient' ||
            $das_form_type == 'testChangesEmailToDesigner' ||
            $das_form_type == 'testChangesEmailToClient'
        ) {

            $customNameOfDesign = __('Test Design', 'design-approval-system');
            $version4 = __('Version 1', 'design-approval-system');
            $companyname4 = __('Client Name', 'design-approval-system');
            $link4 = get_option('siteurl');
            $custom_client_changes = __('Comments or requested changes from the client would appear here.', 'design-approval-system');
            $custom_client_approved_signature = __('Test Name');
            $designclientemail = __('Test Name');

            $post_info_array = array(
                'das_form_type' => $test_das_form_type,
                'companyname4' => $companyname4,
                'version4' => $version4,
                'link4' => $link4,
                'designclientemail' => $designclientemail,
                'custom_client_approved_signature' => $custom_client_approved_signature,
                'submitApprovedYes' => $submitApprovedYes,
                'customNameOfDesign' => $customNameOfDesign,
                'approved_comments' => '',
                'das_settings_company_name' => $das_settings_company_name,
                'custom_client_changes' => $custom_client_changes,
            );

        }

        $dasCustomEmailsCheck = 'das-custom-emails/das-custom-emails.php';
        $dasCustomEmailsActive = is_plugin_active($dasCustomEmailsCheck);

        ////////////////////////////////////
        ///////////// Emails //////////////
        //////////////////////////////////

        // Designer Header and To
        $headers_designer [] = __('From', 'design-approval-system') . ': ' . $das_settings_company_name . ' <' . $das_settings_company_email . '>';

      //  if ($das_form_type == 'approvedEmail' || $das_form_type == 'testApprovedEmailToDesigner') {
      //      $headers_designer [] = __('Cc', 'design-approval-system') . ': ' . $das_settings_company_name . ' <' . $das_settings_company_email . '>';
      //  }

        if ($das_form_type !== 'testEmailSettingsPage') {
            // Who are we going to send this form to
            // to designer
            $to_designer = $designer_email;
        }

        // Client Header and To
        $headers [] = __('From', 'design-approval-system') . ': ' . $das_settings_company_name . ' <' . $das_settings_company_email . '>';
        // Who are we going to send this form to
        $to = $designclientemail;


        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        // TEST SMPT/SENDMAIL ON SETTINGS PAGE
        if ($das_form_type == 'testEmailSettingsPage') {
            // SMTP Authenticate?
            if ($smtp_checked == '1') {
                $to_designer = $das_settings_smtp_email;
            } // Default sendmail
            else {
                $to_designer = $das_settings_company_email;
            }

            if ($smtp_checked == '1') {
                //subject
                $subject_designer = 'SMTP Test Email From the Design Approval System';
                // message to designer
                $message_designer = 'Thanks for using our Design Approval System. This email confirms your SMTP Test Email has been delivered.';
            } else {
                //subject
                $subject_designer = 'Test Email From the Design Approval System';
                // message to designer
                $message_designer = 'Thanks for using our Design Approval System. This email confirms your Test Email has been delivered.';
            }

        }

        switch($das_form_type){

            // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            // TEST THE SEND EMAIL TO CLIENT EMAIL
            case 'testSendEmailToClient':
                // Who are we going to send this form too
                // this form gets sent to the designer and client, only the subject will be different for the client if customized. the email that goes to the designer will be a carbon copy of the content that goes to the client.
                $to_designer = $das_settings_company_email;

                if($dasCustomEmailsActive){
                    // We will add the option to customize the subject for the designer email if enough users request it. Till this point no one has in the free version even.
                    if(get_option('das-settings-designers-message-to-clients-subject') == TRUE) {
                        //subject to designer
                        $subject_designer = do_shortcode(get_option('das-settings-designers-message-to-clients-subject'));
                    }
                    else {
                        $subject_designer = $customNameOfDesign . ' - ' . $version4 . ' - ' . $companyname4 . ' - Email Sent Confirmation';
                    }
                    ob_start();
                    $email_template = new \ DAS_email_template_preview();
                    $das_settings_email_for_designers_message_to_clients = $email_template->das_email_template($post_info_array);
                    $das_settings_email_for_designers_message_to_clients = ob_get_contents();
                    ob_clean();

                    $message_designer = do_shortcode($das_settings_email_for_designers_message_to_clients);
                }
                else {
                    $subject_designer = $customNameOfDesign . ' - ' . $version4 . ' - ' . $companyname4;

                    // Build the message
                    if ($check_designer === false) {
                        $message_designer = nl2br('' . !empty($das_settings_email_for_designers_message_to_clients) ? $das_settings_email_for_designers_message_to_clients : 'Please review your design comp for changes and/or errors:' . '
                                
                    From: ' . $das_settings_company_name . '	
                    For: ' . $companyname4 . '
                    ' . $version4 . '
                    
                    <a href="' . $link4 . '">' . $link4 . '</a>
                
                    ');
                    } else {
                        $message_designer = nl2br($das_settings_email_for_designers_message_to_clients);
                    }
                }

                break;
            // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            // TEST THE APPROVED EMAIL TO DESIGNER
            case 'testApprovedEmailToDesigner':
                // Who are we going to send this form to
                // to designer
                $to_designer = $das_settings_company_email;

                if($dasCustomEmailsActive){
                    // We will add the option to customize the subject for the designer email if enough users request it. Till this point no one has in the free version even.
                    if(get_option('das-settings-approved-designers-message-to-designer-subject') == TRUE) {
                        //subject to designer
                        $subject_designer = do_shortcode(get_option('das-settings-approved-designers-message-to-designer-subject'));
                    }
                    else {
                        $subject_designer = $customNameOfDesign . ' - ' . $version4 . ' - ' . $companyname4 . ' - Email Sent Confirmation';
                    }
                    ob_start();
                    $email_template = new \ DAS_email_template_preview();
                    $das_settings_email_for_designers_message_to_clients = $email_template->das_email_template($post_info_array);
                    $das_settings_email_for_designers_message_to_clients = ob_get_contents();
                    ob_clean();

                    $message_designer = do_shortcode($das_settings_email_for_designers_message_to_clients);
                }
                else {

                    //subject to designer
                    $subject_designer = $customNameOfDesign . ' - ' . $version4 . ' - ' . $companyname4 . ' Approved this Design';

                    // Build the message
                    if ($check_designer === false) {
                        // message to designer
                        $message_designer = nl2br('' . !empty($das_settings_approved_dig_sig_message_to_designer) ? $das_settings_approved_dig_sig_message_to_designer : 'This design comp has been approved by the client. Please take the next appropriate step.' . '
                            
                            From: ' . $companyname4 . '
                            Digital Signature: Test Name
                            
                            Design Approved, Yes: <a href="' . $link4 . '">' . $link4 . '</a>
                            
                            This is the approved comments section of the form available to clients.
                            
                            ');
                    } else {
                        $message_designer = nl2br($das_settings_approved_dig_sig_message_to_designer);
                    }
                }
                break;

            // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            // TEST THE APPROVED EMAIL TO CLIENT
            case 'testApprovedEmailToClient':
                // Who are we going to send this form to
                // to designer
                $to_designer = $das_settings_company_email;

                if($dasCustomEmailsActive){
                    // We will add the option to customize the subject for the designer email if enough users request it. Till this point no one has in the free version even.
                    if(get_option('das-settings-approved-designers-message-to-clients-subject') == TRUE) {
                        //subject to designer
                        $subject_designer = do_shortcode(get_option('das-settings-approved-designers-message-to-clients-subject'));
                    }
                    else {
                        //subject to client
                        $subject_designer = $customNameOfDesign . ' - ' . $version4 . ' - ' . $companyname4 . ' Design Approved Confirmation';
                    }
                    ob_start();
                    $email_template = new \ DAS_email_template_preview();
                    $das_settings_email_for_designers_message_to_clients = $email_template->das_email_template($post_info_array);
                    $das_settings_email_for_designers_message_to_clients = ob_get_contents();
                    ob_clean();

                    $message_designer = do_shortcode($das_settings_email_for_designers_message_to_clients);
                }
                else {

                    //subject to client
                    $subject_designer = $customNameOfDesign . ' - ' . $version4 . ' - ' . $companyname4 . ' Design Approved Confirmation';

                    // Build the message
                    if ($check_designer === false) {
                        // message to client
                        // message to client
                        $message_designer = nl2br('' . !empty($das_settings_approved_dig_sig_message_to_client) ? $das_settings_approved_dig_sig_message_to_client : 'Thank you for approving your design comp. We will now take the next steps in finalizing your project. Below is a confirmation of your submission.
                    
As the authorized decision maker of my firm I acknowledge that I have reviewed and approved the proposed design comps designed by your company.' . '
            
                            From: ' . $companyname4 . '
                            Digital Signature: Test Name Here
                            
                            Design Approved, Yes: <a href="' . $link4 . '">' . $link4 . '</a>
                            
                            This is the approved comments section of the form available to clients.
                            
                            Sincerely,
                            ' . $das_settings_company_name . '
                            
                            ');
                    } else {
                        $message_designer = nl2br($das_settings_approved_dig_sig_message_to_client);
                    }
                }
                break;

            // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            // TEST THE CHANGES EMAIL TO DESIGNER
            case 'testChangesEmailToDesigner':
                // Who are we going to send this form to
                // to designer
                $to_designer = $das_settings_company_email;

                if($dasCustomEmailsActive){
                    // We will add the option to customize the subject for the designer email if enough users request it. Till this point no one has in the free version even.
                    if(get_option('das-settings-changes-designers-message-to-designer-subject')) {
                        //subject to designer
                        $subject_designer = do_shortcode(get_option('das-settings-changes-designers-message-to-designer-subject'));
                    }
                    else {
                        //subject to client
                        $subject_designer = $customNameOfDesign . ' - ' . $version4 . ' - ' . $companyname4 . ' sent Design Requests';
                    }
                    ob_start();
                    $email_template = new \ DAS_email_template_preview();
                    $das_settings_email_for_designers_message_to_clients = $email_template->das_email_template($post_info_array);
                    $das_settings_email_for_designers_message_to_clients = ob_get_contents();
                    ob_clean();

                    $message_designer = do_shortcode($das_settings_email_for_designers_message_to_clients);
                }
                else {

                    //subject to designer
                    $subject_designer = $customNameOfDesign . ' - ' . $version4 . ' - ' . $companyname4 . ' sent Design Requests';

                    // Build the message
                    if ($check_designer === false) {
                        // message to designer
                        $message_designer = nl2br('' . !empty($das_settings_design_requests_message_to_designer) ? $das_settings_design_requests_message_to_designer : 'Design comp changes have been requested by this client. Please review and take the next appropriate steps.' .

                            'From: ' . $companyname4 . '
                            ' . $das_settings_design_requests_message_to_designer . '
                            <a href="' . $link4 . '">' . $link4 . '</a>
                            
                            ' . $custom_client_changes . '
                            ');
                    } else {
                        $message_designer = nl2br($das_settings_design_requests_message_to_designer);
                    }
                }
                break;
            // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            // TEST THE CHANGES EMAIL TO CLIENT
            case 'testChangesEmailToClient':
                // Who are we going to send this form to
                // to designer
                $to_designer = $das_settings_company_email;

                if($dasCustomEmailsActive){
                    // We will add the option to customize the subject for the designer email if enough users request it. Till this point no one has in the free version even.
                    if(get_option('das-settings-changes-designers-message-to-clients-subject') == TRUE) {
                        //subject to designer
                        $subject_designer = do_shortcode(get_option('das-settings-changes-designers-message-to-clients-subject'));
                    }
                    else {
                        //subject to client
                        $subject_designer = $customNameOfDesign . ' - ' . $version4 . ' - ' . $companyname4 . ' Design Changes Confirmation';
                    }
                    ob_start();
                    $email_template = new \ DAS_email_template_preview();
                    $das_settings_email_for_designers_message_to_clients = $email_template->das_email_template($post_info_array);
                    $das_settings_email_for_designers_message_to_clients = ob_get_contents();
                    ob_clean();

                    $message_designer = do_shortcode($das_settings_email_for_designers_message_to_clients);
                }
                else {

                    //subject to client
                    $subject_designer = $customNameOfDesign . ' - ' . $version4 . ' - ' . $companyname4 . ' Design Changes Confirmation';

                    // Build the message
                    if ($check_designer === false) {
                        // message to client
                        $message_designer = nl2br('' . !empty($das_settings_design_requests_message_to_clients) ? $das_settings_design_requests_message_to_clients : 'We have received the recent request for changes to your design comp. We will immediately make the changes you have asked for and will be sending another design comp for your review shortly. Below you will find a copy of your notes.' . '
                    
                            <a href="' . $link4 . '">' . $link4 . '</a>
                            
                            ' . $custom_client_changes . '
                            
                            Sincerely,
                            ' . $das_settings_company_name . '
                            ');
                    } else {
                        $message_designer = nl2br($das_settings_design_requests_message_to_clients);
                    }
                }
                break;

            ////////////////////////////////////
            ///////// Designer Emails /////////
            //////////////////////////////////

            // SEND EMAIL LINK MESSAGE (EMAIL CONFIRMATION TO DESIGNER)
            case 'sendEmailForClient':
                //Designer
                if($dasCustomEmailsActive){
                    // We will add the option to customize the subject for the designer email if enough users request it. Till this point no one has in the free version even.
                    // if(!empty(get_option('das-settings-designers-message-to-clients-subject'))) {
                    //subject to designer
                    //     $subject_designer = do_shortcode(get_option('das-settings-designers-message-to-clients-subject'));
                    // }
                    // else {
                    $subject_designer = $customNameOfDesign . ' - ' . $version4 . ' - ' . $companyname4 . ' - Email Sent Confirmation';
                    // }
                    ob_start();
                    $email_template = new \ DAS_email_template_preview();
                    $das_settings_email_for_designers_message_to_clients = $email_template->das_email_template($post_info_array);
                    $das_settings_email_for_designers_message_to_clients = ob_get_contents();
                    ob_clean();
                    $message_designer = do_shortcode($das_settings_email_for_designers_message_to_clients);
                }
                else{
                    //subject to designer
                    $subject_designer = $customNameOfDesign . ' - ' . $version4 . ' - ' . $companyname4 . ' - Email Sent Confirmation';
                    if($check === false) {


                        $message_designer = nl2br('' . !empty($das_settings_email_for_designers_message_to_clients) ? $das_settings_email_for_designers_message_to_clients : 'Please review your design comp for changes and/or errors:' . '
                                
                    From: ' . $das_settings_company_name . '	
                    For: ' . $companyname4 . '
                    ' . $version4 . '
                    
                    <a href="' . $link4 . '">' . $link4 . '</a>
                
                    ');
                    }
                    else {
                        $message_designer = nl2br(do_shortcode($das_settings_email_for_designers_message_to_clients));
                    }
                }


                //CLIENT
                if($dasCustomEmailsActive){
                    if(get_option('das-settings-designers-message-to-clients-subject') == TRUE) {
                        //subject to designer
                        $subject = do_shortcode(get_option('das-settings-designers-message-to-clients-subject'));
                    }
                    else {
                        //subject to client
                        $subject = $customNameOfDesign . ' - ' . $version4 . ' - ' . $companyname4;
                    }

                    // The $message_designer option pulls in the template for us here.
                    $message = $das_settings_email_for_designers_message_to_clients;
                }
                else{
                    //subject to client
                    $subject = $customNameOfDesign . ' - ' . $version4 . ' - ' . $companyname4;

                    // Build the message
                    if ($check === false) {
                        $message = nl2br('' . !empty($das_settings_email_for_designers_message_to_clients) ? $das_settings_email_for_designers_message_to_clients : 'Design comp changes have been requested by this client. Please review and take the next appropriate steps.' . '
                                
                    From: ' . $das_settings_company_name . '	
                    For: ' . $companyname4 . '
                    ' . $version4 . '
                    
                    <a href="' . $link4 . '">' . $link4 . '</a>
                
                    ');
                    } else {
                        $message = nl2br(do_shortcode($das_settings_email_for_designers_message_to_clients));
                    }
                }

                break;

            // APPROVED EMAIL MESSAGE (DESIGNER EMAIL)
            case 'approvedEmail':

                // Custom DAS Manager approved options
                if (is_plugin_active('das-manager/das-manager.php') && get_post_meta($das_post_id, 'das_manager_client_version', true) !== 'yes' && get_post_meta($das_post_id, 'custom_manager_email', true)  == TRUE ) {
                    // this meta says yes approved and makes it possible for the stars to appear on project board. I have hard coded the answer Yes so we don't need to get meta values here.
                    update_post_meta($das_post_id, 'custom_manager_approved', 'Yes');
                    // this meta is the clients actual signature.
                    update_post_meta($das_post_id, 'custom_manager_approved_signature', $custom_client_approved_signature);
                    // this meta is the clients approved comments.
                    update_post_meta($das_post_id, 'custom_manager_approved_comments', $approved_comments);
                    // this meta is the clients approved date.
                    update_post_meta($das_post_id, 'custom_manager_approved_date', $approved_date);

                }
                else {
                    // this meta says yes approved and makes it possible for the stars to appear on project board. I have hard coded the answer Yes so we don't need to get meta values here.
                    update_post_meta($das_post_id, 'custom_client_approved', 'Yes');
                    // this meta is the clients actual signature.
                    update_post_meta($das_post_id, 'custom_client_approved_signature', $custom_client_approved_signature);
                    // this meta is the clients approved comments.
                    update_post_meta($das_post_id, 'custom_client_approved_comments', $approved_comments);
                    // this meta is the clients approved date.
                    update_post_meta($das_post_id, 'custom_client_approved_date', $approved_date);
                }

                if($das_settings_bcc_email == TRUE) {
                    $headers_designer[] = 'BCC:' . $das_settings_bcc_email . ' <' . $das_settings_bcc_email . '>';
                }

                //DESIGNER
                if($dasCustomEmailsActive){
                    if(get_option('das-settings-approved-designers-message-to-designer-subject') == TRUE) {
                        //subject to designer
                        $subject_designer = do_shortcode(get_option('das-settings-approved-designers-message-to-designer-subject'));
                    }
                    else {
                        //subject to designer
                        $subject_designer = $customNameOfDesign . ' - ' . $version4 . ' - ' . $companyname4 . ' Approved this Design';
                    }
                    ob_start();
                    $email_template = new \ DAS_email_template_preview();
                    $das_settings_approved_designer_template = $email_template->das_email_template($post_info_array);

                    $das_settings_approved_designer_template = ob_get_contents();
                    ob_clean();

                    // The $message_designer option pulls in the template for us here.
                    $message_designer = $das_settings_approved_designer_template;
                }
                else{
                    //subject to designer
                    $subject_designer = $customNameOfDesign . ' - ' . $version4 . ' - ' . $companyname4 . ' Approved this Design';
                    // Build the message
                    if ($check_designer === false) {
                        // message to designer
                        $message_designer = nl2br('' . !empty($das_settings_approved_dig_sig_message_to_designer) ? $das_settings_approved_dig_sig_message_to_designer : 'This design has been approved by the client. Please take the next appropriate step.' . '
                    
                    From: ' . $designclientemail . '
                    Digital Signature: ' . $custom_client_approved_signature . '
                    
                    Design Approved, ' . $submitApprovedYes . ': ' . get_permalink($das_post_id) . '
                    
                    ' . $approved_comments . '
                    
                    ');
                    } else {
                        $message_designer = nl2br(do_shortcode($das_settings_approved_dig_sig_message_to_designer));
                    }
                }

                //CLIENT
                if($dasCustomEmailsActive){
                    if(get_option('das-settings-approved-designers-message-to-clients-subject') == TRUE) {
                        //subject to designer
                        $subject = do_shortcode(get_option('das-settings-approved-designers-message-to-clients-subject'));
                    }
                    else {
                        //subject to client
                        $subject = $customNameOfDesign . ' - ' . $version4 . ' - ' . $companyname4 . ' Design Approved Confirmation';
                    }
                    ob_start();
                    //we need to rename the das_form_type so we can pass another option in our email template
                    $das_form_type = 'approvedEmailClient';
                    // THIS WAS COPIED DOWN FROM ABOVE ONLY BECAUSE REWRITING EVERYTHING TO MAKE UP FOR 2 EMAIL CHANGES IS NOT WORTH THE TIME AT THE MOMENT.
                    //Create Post Info Array!
                    $post_info_array = array(
                        'das_form_type' => $das_form_type,
                        'companyname4' => $companyname4,
                        'version4' => $version4,
                        'link4' => $link4,
                        'designclientemail' => $designclientemail,
                        'custom_client_approved_signature' => $custom_client_approved_signature,
                        'submitApprovedYes' => $submitApprovedYes,
                        'customNameOfDesign' => $customNameOfDesign,
                        'approved_comments' => $approved_comments,
                        'das_settings_company_name' => $das_settings_company_name,
                        'custom_client_changes' => $custom_client_changes,
                    );
                    $email_template_client = new \ DAS_email_template_preview();
                    $das_settings_approved_client_template = $email_template_client->das_email_template($post_info_array);

                    $das_settings_approved_client_template = ob_get_contents();
                    ob_clean();

                    // The $message_designer option pulls in the template for us here.
                    $message = $das_settings_approved_client_template;
                }
                else{
                    //subject to client
                    $subject = $customNameOfDesign . ' - ' . $version4 . ' - ' . $companyname4 . ' Design Approved Confirmation';

                    // Build the message
                    if ($check === false) {
                        // message to client
                        $message = nl2br('' . !empty($das_settings_approved_dig_sig_message_to_client) ? $das_settings_approved_dig_sig_message_to_client : 'Thank you for approving your design comp. We will now take the next steps in finalizing your project. Below is a confirmation of your submission.
                    
As the authorized decision maker of my firm I acknowledge that I have reviewed and approved the proposed design comps designed by your company.' . '

                    From: ' . $designclientemail . '
                    Digital Signature: ' . $custom_client_approved_signature . '
                    
                    Design Approved, ' . $submitApprovedYes . ': ' . $customNameOfDesign . '
                    
                    ' . $approved_comments . '
                    
                    Sincerely,
                    ' . $das_settings_company_name . '
                    
                    ');
                    } else {
                        $message = nl2br(do_shortcode($das_settings_approved_dig_sig_message_to_client));
                    }
                }
                break;

            // APPROVED EMAIL MESSAGE (DESIGNER EMAIL)
            case 'requestChangesEmail':


                // Custom DAS Manager approved options
                if (is_plugin_active('das-manager/das-manager.php') && get_post_meta($das_post_id, 'das_manager_client_version', true) !== 'yes' ) {
                    /// this meta is for the clients notes
                    update_post_meta($das_post_id, 'custom_manager_notes', $custom_client_changes);
                }
                else {
                    /// this meta is for the clients notes
                    update_post_meta($das_post_id, 'custom_client_notes', $custom_client_changes);
                }


                //DESIGNER
                if($dasCustomEmailsActive){
                    if(get_option('das-settings-changes-designers-message-to-designer-subject') == TRUE) {
                        //subject to designer
                        $subject_designer = do_shortcode(get_option('das-settings-changes-designers-message-to-designer-subject'));
                    }
                    else {
                        //subject to designer
                        $subject_designer = $customNameOfDesign . ' - ' . $version4 . ' - ' . $companyname4 . ' sent Design Requests';
                    }
                    ob_start();
                    $email_template = new \ DAS_email_template_preview();
                    $das_settings_changes_designer_template = $email_template->das_email_template($post_info_array);

                    $das_settings_changes_designer_template = ob_get_contents();
                    ob_clean();

                    // The $message_designer option pulls in the template for us here.
                    $message_designer = $das_settings_changes_designer_template;
                }
                else{
                    //subject to designer
                    $subject_designer = $customNameOfDesign . ' - ' . $version4 . ' - ' . $companyname4 . ' sent Design Requests';

                    // Build the message
                    if ($check_designer === false) {
                        // message to designer
                        $message_designer = nl2br('' . !empty($das_settings_design_requests_message_to_designer) ? $das_settings_design_requests_message_to_designer : 'Design comp changes have been requested by this client. Please review and take the next appropriate steps.' .

                            'From: ' . $companyname4 . '
                    ' . $das_settings_design_requests_message_to_designer . '
                    <a href="' . $link4 . '">' . $link4 . '</a>
                    
                    ' . $custom_client_changes . '
                    ');
                    } else {
                        $message_designer = nl2br(do_shortcode($das_settings_design_requests_message_to_designer));
                    }
                }

                //CLIENT
                if($dasCustomEmailsActive){
                    if(get_option('das-settings-changes-designers-message-to-clients-subject') == TRUE) {
                        //subject to designer
                        $subject = do_shortcode(get_option('das-settings-changes-designers-message-to-clients-subject'));
                    }
                    else {
                        //subject to client
                        $subject = $customNameOfDesign . ' - ' . $version4 . ' - ' . $companyname4 . ' Design Changes Confirmation';
                    }
                    ob_start();
                    //we need to rename the das_form_type so we can pass another option in our email template
                    $das_form_type = 'requestChangesEmailClient';
                    // THIS WAS COPIED DOWN FROM ABOVE ONLY BECAUSE REWRITING EVERYTHING TO MAKE UP FOR 2 EMAIL CHANGES IS NOT WORTH THE TIME AT THE MOMENT.
                    //Create Post Info Array!
                    $post_info_array = array(
                        'das_form_type' => $das_form_type,
                        'companyname4' => $companyname4,
                        'version4' => $version4,
                        'link4' => $link4,
                        'designclientemail' => $designclientemail,
                        'custom_client_approved_signature' => $custom_client_approved_signature,
                        'submitApprovedYes' => $submitApprovedYes,
                        'customNameOfDesign' => $customNameOfDesign,
                        'approved_comments' => $approved_comments,
                        'das_settings_company_name' => $das_settings_company_name,
                        'custom_client_changes' => $custom_client_changes,
                    );

                    $email_template_client = new \ DAS_email_template_preview();
                    $das_settings_changes_client_template = $email_template_client->das_email_template($post_info_array);

                    $das_settings_changes_client_template = ob_get_contents();
                    ob_clean();

                    // The $message_designer option pulls in the template for us here.
                    $message = $das_settings_changes_client_template;
                }
                else{
                    $subject = $customNameOfDesign . ' - ' . $version4 . ' - ' . $companyname4 . ' Design Changes Confirmation';

                    // Build the message
                    if ($check === false) {
                        // message to client
                        $message = nl2br('' . !empty($das_settings_design_requests_message_to_clients) ? $das_settings_design_requests_message_to_clients : 'We have received the recent request for changes to your design comp. We will immediately make the changes you have asked for and will be sending another design comp for your review shortly. Below you will find a copy of your notes.' . '
                    
                        <a href="' . $link4 . '">' . $link4 . '</a>
                    
                    ' . $custom_client_changes . '
                    
                    Sincerely,
                    ' . $das_settings_company_name . '
                    ');
                    } else {
                        $message = nl2br(do_shortcode($das_settings_design_requests_message_to_clients));
                    }
                }

                break;
        }


        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        // TEST SMPT/SENDMAIL ON SETTINGS PAGE
        if ($das_form_type == 'testEmailSettingsPage') {
            $result = wp_mail($to_designer, $subject_designer, $message_designer, $headers_designer);
            if ($result) {
                echo 'done';
            } else {
                echo 'error';
                exit;
            }
        }

        add_filter('wp_mail_content_type', 'set_html_content_type');
        // Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
        remove_filter('wp_mail_content_type', 'set_html_content_type');
        add_filter('wp_mail_content_type', function ($message_designer) {
            return 'text/html';
        });

        if ($das_form_type !== 'testEmailSettingsPage') {
            // SEND OUR MESSAGE TO DESIGNER AND CLIENT
            foreach ($recipients as $recipient) {

                if ($recipient == 'designer') {
                    wp_mail($to_designer, $subject_designer, $message_designer, $headers_designer);
                }
                if ($recipient == 'client') {
                    wp_mail($to, $subject, $message, $headers);
                }

            }
        }
    }
    //**************************************************
    // Block for Old Extensions
    //**************************************************
    function das_old_extenstions_block() {
        global $current_user;
        $user_id = $current_user->ID;
        $list_old_plugins = array(
            'das-gq-theme/das-gq-theme.php',
            'das-roles-extension/das-roles-extension.php',
            'das-changes-extension/das-changes-extension.php',
            'das-design-login/das-design-login.php',
            'das-public-private-project-board/das-public-private-project-board.php',
            'das-clean-theme/das-clean-theme.php',
            'woocommerce-for-das/woocommerce-for-das.php'
        );
        foreach ($list_old_plugins as $single_plugin) {
            if (is_plugin_active($single_plugin)) {
                //Don't Let Old Plugins Activate
                deactivate_plugins($single_plugin);
                //Clear The hide message so user knows they can't activate old plugins
                delete_user_meta($user_id, 'das_old_plugins_ignore');
            }
        }
    }
    //**************************************************
    // Check for Old Extenstions
    //**************************************************
    function old_extenstions_check() {
        // Check if get_plugins() function exists. This is required on the front end of the
        // site, since it is in a file that is normally only loaded in the admin.
        if (!function_exists('get_plugins')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        $all_plugins = get_plugins();
        $list_old_plugins = array(
            'das-gq-theme/das-gq-theme.php',
            'das-roles-extension/das-roles-extension.php',
            'das-changes-extension/das-changes-extension.php',
            'das-design-login/das-design-login.php',
            'das-public-private-project-board/das-public-private-project-board.php',
            'das-clean-theme/das-clean-theme.php',
            'woocommerce-for-das/woocommerce-for-das.php'
        );

        $any_old_plugins = false;
        if ($all_plugins) {
            foreach ($all_plugins as $single_plugin => $single_plugin_info) {
                //Are there old plugins Install in WordPress
                $any_old_plugins = in_array($single_plugin, $list_old_plugins);
                if ($any_old_plugins) {
                    return true;
                }
            }
        }
    }
    //**************************************************
    // Old Extenstions List
    //**************************************************
    function das_old_plugin_admin_notice() {
        global $current_user;
        //$is_an_admin = in_array('administrator', $current_user->roles);
        $user_id = $current_user->ID;
        /* Check that the user hasn't already clicked to ignore the message */
        if (!get_user_meta($user_id, 'das_old_plugins_ignore')) {
            echo '<div class="das-update-message das_old_plugins_message">';
            printf(__('Please uninstall ALL old DAS Plugins/Extenstions because they will no longer work with this version of DAS. All old features are now included in <a href="http://www.slickremix.com/downloads/das-premium/" target="_blank">DAS Premium</a>. Since you previously purchased one of the old extensions we want to give you 1 Year of DAS Premium for FREE! Please checkout with <a href="http://www.slickremix.com/downloads/das-premium/" target="_blank">DAS Premium</a> using COUPON CODE: <strong>dasmanager100</strong> | <a href="%1$s">HIDE NOTICE</a>'), '?das_old_plugins_ignore=0');
            echo "</div>";
        }
    }
    //**************************************************
    // Ignore Old Extenstions List
    //**************************************************
    function das_old_plugins_ignore() {
        global $current_user;
        $is_an_admin = in_array('administrator', $current_user->roles);
        $user_id = $current_user->ID;
        /* If user clicks to ignore the notice, add that to their user meta */
        if (isset($_GET['das_old_plugins_ignore']) && '0' == $_GET['das_old_plugins_ignore'] && $is_an_admin == true) {
            add_user_meta($user_id, 'das_old_plugins_ignore', 'true', true);
            //delete_user_meta( $user_id, 'das_old_plugins_ignore');
        }
    }
    //**************************************************
    // DAS Admin CSS
    //**************************************************
    function das_admin_css() {
        global $post_type;
        wp_register_style('DAS-ADMIN-CSS', plugins_url('design-approval-system/admin/css/admin.css'));
        wp_enqueue_style('DAS-ADMIN-CSS');
        if ('designapprovalsystem' == $post_type) {
            // custom scripts for the custom post type designapprovalsystem edit post page in the admin area.
            wp_register_style('DAS-post-edit', plugins_url('design-approval-system/admin/css/post-edit.css'));
            wp_enqueue_style('DAS-post-edit');
            wp_enqueue_script('jquery-ui-core');
            wp_enqueue_script('jquery-ui-tabs');
            wp_register_script('das-admin', plugins_url('admin/js/admin.js', dirname(__FILE__)));
            wp_enqueue_script('das-admin');
        }
    }
    //**************************************************
    // DAS Admin JS
    //**************************************************
    function das_admin_js() {
        global $post_type;
        if ('designapprovalsystem' == $post_type) { ?>
            <script>
                jQuery('#custom_post_template option[value="default"]').removeAttr('selected');
                jQuery('#custom_post_template option[value="default"]').remove();
                jQuery(document).ready(function () {
                    if (jQuery("#custom_post_template").selectedIndex <= 0) {
                        jQuery('#custom_post_template option[value="das-slick-template-v4.php"]').attr('selected, selected');
                    }
                    // This selector is called every time a select box is changed
                    jQuery("select#custom_client_name").change(function () {
                        // varible to hold string
                        var str = "";
                        var finalString = "";
                        jQuery("select#custom_client_name option:selected").each(function () {
                            // when the select box is changed, we add the value text to the varible
                            str += jQuery(this).text() + " ";
                        });
                        var matches = str.match(/\[(.*?)\]/);
                        if (matches) {
                            var submatch = matches[1];
                        }
                        // then display it in the following class
                        jQuery("#custom_clients_email").val(submatch);
                    })
                    // This selector is called every time a select box is changed
                    jQuery("select#custom_designers_name").change(function () {
                        // varible to hold string
                        var str = "";
                        var finalString = "";
                        jQuery("select#custom_designers_name option:selected").each(function () {
                            // when the select box is changed, we add the value text to the varible
                            str += jQuery(this).text() + " ";
                        });
                        var matches = str.match(/\[(.*?)\]/);
                        if (matches) {
                            var submatch = matches[1];
                        }
                        // then display it in the following class
                        jQuery("#custom_designers_email").val(submatch);
                    })
                    // This selector is called every time a select box is changed
                    jQuery("select#custom_manager_name").change(function () {
                        // varible to hold string
                        var str = "";
                        var finalString = "";
                        jQuery("select#custom_manager_name option:selected").each(function () {
                            // when the select box is changed, we add the value text to the varible
                            str += jQuery(this).text() + " ";
                        });
                        var matches = str.match(/\[(.*?)\]/);
                        if (matches) {
                            var submatch = matches[1];
                        }
                        // then display it in the following class
                        jQuery("#custom_manager_email").val(submatch);
                    })
                });
            </script>
            <?php
        }
    }
    //**************************************************
    // DAS Help Page Scripts
    //**************************************************
    function das_help_settings_admin_scripts() {
        wp_register_style('og-admin-css', plugins_url('design-approval-system/admin/css/admin-settings.css'));
        wp_enqueue_style('og-admin-css');
    }
    //**************************************************
    // DAS Admin Redirect
    //**************************************************
    function das_admin_redirect() {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        // Redirect all users that try to access the site url on front end to view active projects coming from the content loop. (*ie. http://www.slickremix.com/testblog/?post_type=designapprovalsystem&page=design-approval-system-projects-page). So anything containing the word ?post_type=designapprovalsystem in the URL will get redirected to the home page
        if (false !== strpos($url, '?post_type=designapprovalsystem')) {
            wp_redirect(home_url());
            exit;
        }
    }
    //**************************************************
    // Create DAS Taxonmies
    //**************************************************
    function register_taxonomy_das_categories() {
        $das_labels = array(
            'name' => _x(__('Project Names', 'design-approval-system'), 'das_categories'),
            'singular_name' => _x(__('Project Name', 'design-approval-system'), 'das_categories'),
            'search_items' => _x(__('Search Project Names', 'design-approval-system'), 'das_categories'),
            //'popular_items' => _x( 'Popular Project Names', 'das_categories' ),
            'all_items' => _x(__('All Project Names', 'design-approval-system'), 'das_categories'),
            'parent_item' => _x(__('Parent Project Name', 'design-approval-system'), 'das_categories'),
            'parent_item_colon' => _x(__('Parent Project Name', 'design-approval-system'), 'das_categories'),
            'edit_item' => _x(__('Edit Project Name', 'design-approval-system'), 'das_categories'),
            'update_item' => _x(__('Update Project Name', 'design-approval-system'), 'das_categories'),
            'add_new_item' => _x(__('Add New Project Name', 'design-approval-system'), 'das_categories'),
            'new_item_name' => _x(__('New Project Name', 'design-approval-system'), 'das_categories'),
            'separate_items_with_commas' => _x(__('Separate Project Names with commas', 'design-approval-system'), 'das_categories'),
            'add_or_remove_items' => _x(__('Add or remove Project Names', 'design-approval-system'), 'das_categories'),
            'choose_from_most_used' => _x(__('Choose from the most used Project Names', 'design-approval-system'), 'das_categories'),
            'menu_name' => _x(__('Project Names', 'design-approval-system'), 'das_categories'),
        );
        $das_labels_args = array(
            'labels' => $das_labels,
            'public' => true,
            'show_in_nav_menus' => true,
            'show_ui' => true,
            //'show_tagcloud' => true,
            'hierarchical' => true,
            'update_count_callback' => '_update_post_term_count',
            'rewrite' => true,
            'query_var' => true
        );
        register_taxonomy('das_categories', array('Design Approval System'), $das_labels_args);
    }
    //**************************************************
    // DAS Activation
    //**************************************************
    function design_approval_system__custom_tax_activate() {
        //Register DAS Taxonomies on Activation
        $this->register_taxonomy_das_categories();
        flush_rewrite_rules();
    }
    //**************************************************
    // Add DAS Custom Post Type
    //**************************************************
    function das_cpt_post_type($post_types) {
        $post_types[] = __('Design Approval System', 'design-approval-system');
        return $post_types;
    }
    //**************************************************
    // Create DAS Custom Post Type
    //**************************************************
    function das_custom_post_type_init() {
        $das_cpt_args = array(
            'label' => __('Design Approval System', 'design-approval-system'),
            'labels' => array(
                'menu_name' => __('Projects', 'design-approval-system'),
                'name' => __('All Your Designs', 'design-approval-system'),
                'singular_name' => __('Project', 'design-approval-system'),
            ),
            'public' => true,
            'show_ui' => true,
            'capability_type' => 'post',
            'has_archive' => false,
            'hierarchical' => true,
            'rewrite' => array('slug' => 'designs'),
            'query_var' => 'Design Approval System',
            'menu_icon' => '',
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'excerpt',
                'trackbacks',
                'custom-fields',
                'comments',
                'revisions',
                'thumbnail',
                'author',
            ),
            // Set the available taxonomies here
            'taxonomies' => array('das_categories', 'post_tag')
        );
        register_post_type('Design Approval System', $das_cpt_args);
    }
    //**************************************************
    // Register DAS Custom Post Type on Activation
    //**************************************************
    function design_approval_system_activate() {
        $this->das_custom_post_type_init();
        flush_rewrite_rules();
    }
    //**************************************************
    // Register Settings (General Function)
    //**************************************************
    function register_settings($settings_name, $settings) {
        foreach ($settings as $key => $setting) {
            register_setting($settings_name, $setting);
        }
    }
    //**************************************************
    // Register Settings Page Scripts and Styles
    //**************************************************
    function das_main_settings_admin_scripts() {
        wp_enqueue_script('jquery');
        // This is all we need to call our media manager scripts and styles for the logo upload button
        // wp_enqueue_media('media');
        wp_register_style('og-admin-css', plugins_url('design-approval-system/admin/css/admin-settings.css'));
        wp_enqueue_style('og-admin-css');
    }
    //**************************************************
    // Register Setttings Page Settings
    //**************************************************
    function das_settings_page_register_settings() {
        $settings_page_options = array(
            //Main Settings
            'das_default_theme_logo_image',
            'das-settings-company-name',
            'das-settings-company-email',
            'das-settings-bcc-email',
            //SMTP Settings
            'das-settings-smtp',
            'das-smtp-server',
            'das-smtp-port',
            'das-smtp-checkbox-authenticate',
            'das-smtp-authenticate-username',
            'das-smtp-authenticate-password',
            //Email Settings
            'das-settings-email-for-designers-message-to-clients',
            'das-settings-approved-dig-sig-message-to-designer',
            'das-settings-approved-dig-sig-message-to-clients',
            'das-settings-approved-dig-sig-thank-you',
            'das-settings-approve-login-overide',
            'das-settings-das-ssl-or-tls-option',
            //Branding Settings
            'das-settings-plural-pb-fep-name',
            'das-settings-singular-pb-fep-name',
            'das-settings-pb-fep-name',
            //Client Changes Settings
            'das-settings-design-requests-message-to-designer',
            'das-settings-design-requests-message-to-clients',
            'das-settings-design-requests-thank-you',
            'das-settings-add-design-requests-message-to-designer',
            'das-settings-add-design-requests-message-to-clients',
            'das-settings-changes-login-overide',
            //Roles Settings
            'das-settings-designer-role',
            'das-settings-client-role',
            //Premium Settings
            'das-settings-register-new-das-client',
        );
        $this->register_settings('design-approval-system-settings', $settings_page_options);
    }
    //*************************************************************
    // Required Settings Fields
    //*************************************************************
    function das_dependencies() {
        $output = '';
        $das_settings_company_name = get_option('das-settings-company-name');
        $das_settings_company_email = get_option('das-settings-company-email');
        $output .= empty($das_settings_company_name) || empty($das_settings_company_email) ? '<div class="error"><p>' . __('Warning: The <strong>Design Approval System</strong> plugin needs you to fill the in REQUIRED fields on <a href="edit.php?post_type=designapprovalsystem&page=design-approval-system-settings-page"><strong>settings page</strong></a>.', 'design-approval-system') . '</p></div>' : '';
        echo $output;
    }
    //*************************************************************
    // Override default Wordpress Post Template with DAS Template
    //*************************************************************
    function DAS_post_template($das_post_template_load) {
        global $post;
        if ($post->post_type == 'designapprovalsystem') {
            //Get Selected Template for Design Post Page.
            $das_post_template = get_post_meta($post->ID, 'custom_das_template_options', true);
            //Theme Locations for Template file in root of theme or "DAS" folder.
            $overridden_template_in_folder = locate_template('das/' . $das_post_template);
            $overridden_template = locate_template($das_post_template);
            //Check if Theme has a custom template file in DAS folder
            if ($overridden_template_in_folder != '') {
                $das_post_template_load = $overridden_template_in_folder;
                //echo "DAS Template in folder";
            } //Check if Theme has a custom template file.
            elseif ($overridden_template != '') {
                // locate_template() returns path to file
                // if either the child theme or the parent theme have overridden the template
                $das_post_template_load = $overridden_template;
                // echo "DAS Template in root";
            } //Theme has no custom file so use DEFAULT custom theme file!
            else {
                //GQ Theme Template
                if ($das_post_template == 'das-gq-theme-main.php' || $das_post_template !== 'das-gq-theme-main.php') {
                    $das_post_template_load = WP_CONTENT_DIR . '/plugins/design-approval-system/templates/post-page-template.php';
                }
            }
        }
        return $das_post_template_load;
    }
    //**************************************************
    // DAS Ajax
    //**************************************************
    function das_check_ajax() {
        // SRL added 6-6-13 to allow us to record the approved information directly to db
        wp_register_script("dasChecker_script", DAS_PLUGIN_PATH . '/design-approval-system/templates/slickremix/js/my_dasChecker_script.js', array('jquery'));
        wp_localize_script('dasChecker_script', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
        wp_enqueue_script('jquery');
        wp_enqueue_script('dasChecker_script');
    }
    //**************************************************
    // Check User level for Project Board Edit Button
    //**************************************************
    function is_admin_logged_in() {
        global $user_ID;
        if ($user_ID && current_user_can('level_10')) :
            return true;
        else :
            return false;
        endif;
    }
    //**************************************************
    // Restore Post (Project Board Button)
    //**************************************************
    function wp_das_restore_post_link() {
        // http://wordpress.stackexchange.com/questions/95348/add-frontend-restore-link
        global $post;
        $post_id = $_GET['ids'];
        // no post?
        if (!$post_id || !is_numeric($post_id)) {
            return false;
        }
        $_wpnonce = wp_create_nonce('untrash-post_' . $post_id);
        $url = admin_url('post.php?post=' . $post_id . '&action=untrash&_wpnonce=' . $_wpnonce);
        $url = ' <a href="' . $url . '">Restore from Trash</a>';
        return $url;
    }
    //**************************************************
    // Delete Post (Project Board Button)
    //**************************************************
    function wp_das_delete_post_link($text = 'Trash', $confirm_required = true) {
        global $post;
        $delLink = get_delete_post_link($post->ID);
        return $confirm_required
            ? '<a href="' . $delLink . '" onclick="javascript:if(!confirm(\'' . __('Are you sure you want to remove this post?', 'design-approval-system') . '\')) return false;" />' . $text . "</a>"
            : '<a href="' . $delLink . '">' . $text . "</a>";
    }
    //**************************************************
    // Remove DAS Categories from Woo (Woo For DAS)
    //**************************************************
    function das_woo_pre_get_posts_query($q) {
        if (!$q->is_main_query()) return;
        if (!$q->is_post_type_archive()) return;
        if (!is_admin()) {
            $q->set('tax_query', array(array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => array('DAS Designs'), // Don't display products in the membership category on the shop page . For multiple category , separate it with comma.
                'operator' => 'NOT IN'
            )));
        }
        remove_action('pre_get_posts', array($this, 'das_woo_pre_get_posts_query'));
    }
    //**************************************************
    // Call to Walkthrough
    //**************************************************
    function myDasHelpPointers() {
        $pointers = array(
            array(
                'id' => 'xyz123',
                'screen' => 'settings_page_options-general',
                'target' => '#screen-meta-links',
                'title' => 'Show plugin help',
                'content' => 'Enable to see all the help texts or disable to view it tight.',
                'position' => array(
                    'edge' => 'top', // top, bottom, left, right
                    'align' => 'left' // top, bottom, left, right, middle
                )
            ),
            array(
                'id' => 'xyz124',
                'screen' => 'settings_page_options-general',
                'target' => '#screen-meta-links',
                'title' => 'Show plugin help',
                'content' => 'Enable to see all the help texts or disable to view it tight.',
                'position' => array(
                    'edge' => 'right',
                    'align' => 'right'
                )
            ),
        );
        new DAS_Admin_Pointer($pointers);
    }
    //**************************************************
    // Does Client Have A Project with Design Versions
    //**************************************************
    function get_customer_project_and_version_count() {
        //require_once(ABSPATH .'wp-includes/pluggable.php');
        $user_id = isset($current_user->ID) ? $current_user->ID : '';
        $user_blogs = get_blogs_of_user($user_id);
        foreach ($user_blogs as $user_blog) {
            if ($user_blog->path == '/') {
                # do nothing
            } else {
                $user_blog_id = $user_blog->userblog_id;
            }
        }
        $user = wp_get_current_user();
        $this_users_email = $user->user_email;
        //Custom DAS Post Type
        $post_type = 'designapprovalsystem';
        //Custom DAS Taxonomies (aka Categories)
        $tax = 'das_categories';
        $client = get_terms($tax);
        //Client and Terms arrays.
        $clients_emails = array();
        $clients_names = array();
        $term_names = array();
        $post_counts = array();
        //Loop to custom taxonomy to build Client and Terms arrays.
        foreach ($client as $term) :
            $args = array(
                'post_type' => $post_type,
                'post_per_page' => -1,
                'nopaging' => true,
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                'tax_query' => array(
                    array(
                        'taxonomy' => $tax,
                        'field' => 'ID',
                        'terms' => array($term->term_id)
                    ),
                ),
                'orderby' => 'title',
                'order' => 'DCS'
            );
            $my_query2 = new \WP_Query($args);
            $post_counts[] = $my_query2->post_count;
            if ($my_query2->have_posts()) :
                while ($my_query2->have_posts()) : $my_query2->the_post();
                    global $post;
                    $clients_email = get_post_meta($post->ID, 'custom_clients_email', true);
                    $clients_emails[] = $clients_email;
                    $term_names[$term->name] = $clients_email;
                    $clients_names[] = get_post_meta($post->ID, 'custom_client_name', true);
                    $title_approved_checker = get_post_meta($post->ID, 'custom_client_approved', true);
                    $approved_main_designs_count[$clients_email][$term->name][] = $title_approved_checker;
                endwhile; endif;
        endforeach;
        $final_count = array();
        $projects_count = 0;
        $post_count = 0;
        //END Build Arrays
        //Clean up Clients Array So no duplicate client titles happen.
        $final_clients_emails = array_unique($clients_emails);
        //Start loop for displaying Client Name [Final Build loop]
        foreach ($final_clients_emails as $key => $value)  :
            if ($value == $this_users_email) {
                $projects_count++;
                foreach ($clients_names as $number => $title) {
                    if ($number == $key) {
                        $client_title = $title;
                    }
                }
                //Client Name value for check.
                $client_value = $value;
                $counter = 0;
                //loop for displaying Project Name
                foreach ($term_names as $key => $value) :
                    $term_value = $value;
                    if ($client_value == $value) {
                        $projects_count++;
                        foreach ($client as $term) :
                            $args = array(
                                'post_type' => $post_type,
                                'post_per_page' => -1,
                                'nopaging' => true,
                                'post_status' => 'publish',
                                'ignore_sticky_posts' => 1,
                                'orderby' => 'date',
                                'order' => 'DSC',
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => $tax,
                                        'field' => 'ID',
                                        'terms' => array($term->term_id)
                                    ),
                                ),
                                'orderby' => 'date',
                                'order' => 'DSC'
                            );
                            $my_query = new \WP_Query($args);
                            if ($my_query->have_posts()) : ?>
                                <?php while ($my_query->have_posts()) : $my_query->the_post();
                                    global $post;
                                    $final_client_value = get_post_meta($post->ID, 'custom_clients_email', true);
                                    $final_term_value = $term->name;
                                    //Design Link creation
                                    if (($term_value == $final_client_value) && ($key == $final_term_value)) {
                                        $post_count++;
                                    }
                                endwhile; endif; ?>
                        <?php endforeach;
                    }
                    $counter++;
                endforeach;
            }
        endforeach;


        //Final Counts
        $final_count['projects'] = $projects_count;
        $final_count['versions'] = $post_count;

        wp_reset_query();
        wp_reset_postdata();
        //Return Count Arrray
        return $final_count;
    }


    /**
     * My DAS Plugin License
     *
     * Put in place to only show the Activate Plugin license if the input has a value
     *
     * @since 4.2.5
     */
    function das_plugin_license() {
        wp_enqueue_script('jquery'); ?>
        <style>
            .das-activation-msg {
                margin: 14px 0 25px;
                font-size: 13px;
            }

            .das-license-master-form th {
                background: #f9f9f9;
                padding: 14px;
                border-bottom: 1px solid #ccc;
                margin: -14px -14px 20px;
                width: 100%;
                display: block
            }

            .das-license-master-form .form-table tr {
                float: left;
                margin: 0 15px 15px 0;
                background: #fff;
                border: 1px solid #ccc;
                width: 30.5%;
                max-width: 350px;
                padding: 14px;
                min-height: 220px;
                position: relative;
                box-sizing: border-box
            }

            .das-license-master-form .form-table td {
                padding: 0;
                display: block
            }

            .das-license-master-form td input.regular-text {
                margin: 0 0 8px;
                width: 100%
            }

            .das-license-master-form .edd-license-data[class*=edd-license-] {
                position: absolute;
                background: #fafafa;
                padding: 14px;
                border-top: 1px solid #eee;
                margin: 20px -14px -14px;
                min-height: 67px;
                width: 100%;
                bottom: 14px;
                box-sizing: border-box
            }

            .das-license-master-form .edd-license-data p {
                font-size: 13px;
                margin-top: 0
            }

            .das-license-master-form tr {
                display: none
            }

            .das-license-master-form tr.das-license-wrap {
                display: block
            }

            .das-license-master-form .edd-license-msg-error {
                background: rgba(255, 0, 0, 0.49)
            }

            .das-license-master-form tr.das-license-wrap {
                display: block
            }

            .das-license-master-form .edd-license-msg-error {
                background: #e24e4e !important;
                color: #FFF
            }

            .das-license-wrap .edd-license-data p {
                color: #1e981e
            }

            .edd-license-msg-error p {
                color: #FFF !important
            }

            .designapprovalsystem_page_das-license-page .button-secondary {
                display: none;
            }</style>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                if (jQuery('#das_custom_emails_license_key').val() !== '') {
                    jQuery('#das_custom_emails_license_key').next('label').find('.button-secondary').show()
                }
                if (jQuery('#das_premium_license_key').val() !== '') {
                    jQuery('#das_premium_license_key').next('label').find('.button-secondary').show()
                }
                if (jQuery('#das_manager_license_key').val() !== '') {
                    jQuery('#das_manager_license_key').next('label').find('.button-secondary').show()
                }

            });
        </script>
        <?php
    }

}//END CLASS Design_Approval_System_Core
new Design_Approval_System_Core();