<?php
/************************************************
 * Functions for the GQ plugin
 ************************************************/
//MOVED ALL STYLES AND JS FOR THIS TEMPLATE TO THE MAIN THEME PAGE SO AS TO NOT OVERRIDE ANY OTHER TEMAPLTES THAT MAY BE IN USE.

// This is to ajax the comments from the comment form to the database and using js we return the success message.
add_action('comment_post', 'wdp_ajaxcomments_stop_for_ajax', 20, 2);
function wdp_ajaxcomments_stop_for_ajax($comment_ID, $comment_status)
{
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        //If AJAX Request Then
        switch ($comment_status) {
            case '0':
                //notify moderator of unapproved comment
                wp_notify_moderator($comment_ID);
            case '1': //Approved comment
                echo "success";
                $commentdata =& get_comment($comment_ID, ARRAY_A);
                $post =& get_post($commentdata['comment_post_ID']); //Notify post author of comment
                if (get_option('comments_notify') && $commentdata['comment_approved'] && $post->post_author != $commentdata['user_ID'])
                    wp_notify_postauthor($comment_ID, $commentdata['comment_type']);

                //Company Info
                $das_settings_company_name = get_option("das-settings-company-name");
                $das_settings_company_email = get_option("das-settings-company-email");
                $customNameOfDesign = get_post_meta($commentdata['comment_post_ID'], 'custom_name_of_design', true);
                $companyname4 = get_post_meta($commentdata['comment_post_ID'], 'custom_client_name', true);
                $designer_email = get_post_meta($commentdata['comment_post_ID'], 'custom_designers_email', true);
                $version4 = get_post_meta($commentdata['comment_post_ID'], 'custom_version_of_design', true);
                $link4 = get_permalink($commentdata['comment_post_ID']);

                    $headers = __('From', 'design-approval-system').': '. $das_settings_company_name .' <'.$das_settings_company_email.'>';
                    // Who are we going to send this form too
                    $to = $designer_email;
                    //subject to designer
                    $subject = $customNameOfDesign  . ' - ' . $version4 .  ' - ' . $companyname4 . ' sent Design Comments';
                // message to designer
                $message = nl2br('From: ' . $companyname4 . '
                
            ' . $commentdata['comment_content'] . '
            
            ' . $link4 . '
                   
                    ');

                add_filter( 'wp_mail_content_type', 'set_html_content_type' );
                // Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
                remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
                add_filter( 'wp_mail_content_type', function( $message) {
                    return 'text/html';
                });
                // finally send the mail. This works with SMTP plugins or our SMTP options too
                wp_mail($to, $subject, $message, $headers);

                break;
            default:
                echo "error";
        }
        exit;
    }
}

// function add_plugin_caps() {
// gets the author role
//     $role = get_role( 'das_client' );

// This only works, because it accesses the class instance.
// would allow the author to edit others' posts for current theme only
//     $role->add_cap( 'edit_others_posts' ); 
// }
// add_action( 'admin_init', 'add_plugin_caps');

// Hide the wp admin bar options for das clients... best approach is for users to hide this menu bar when setting up das clients. Additionally users that do try to access the edit page will be redirected to the same page.
add_action('admin_enqueue_scripts', 'das_gq_das_client');
add_action('wp_head', 'das_gq_das_client');
function das_gq_das_client()
{
    global $current_user;
    // print_r($current_user->roles);
    $user_role = $current_user->roles;
    foreach ($user_role as $ur) {
        if ($ur == 'das_client') {
            echo '<!-- qq theme CSS override --><style type="text/css"> #wp-admin-bar-new-content, #menu-media, #wp-admin-bar-new-content, #wp-admin-bar-edit, .menu-icon-designapprovalsystem .wp-first-item{display:none;}</style>';
        }
    }
}

if (is_admin()) {
    add_action('admin_init', 'das_gq_theme_settings_page_register_settings');
}

function das_gq_theme_settings_page_register_settings()
{
    register_setting('das-gq-settings', 'das-gq-theme-main-wrapper-custom-terms');
    register_setting('das-gq-settings', 'das-gq-theme-options-settings-custom-css-main-wrapper-padding');
    register_setting('das-gq-settings', 'das-gq-theme-main-wrapper-padding-input');
    register_setting('das-gq-settings', 'das-gq-theme-main-wrapper-width-input');
    register_setting('das-gq-settings', 'das-gq-theme-main-wrapper-margin-input');
    register_setting('das-gq-settings', 'das-gq-theme-settings-project-board-btn');
    register_setting('das-gq-settings', 'das-gq-theme-main-wrapper-css-input');
    register_setting('das-gq-settings', 'das-gq-theme-settings-project-board-btn');
    register_setting('das-gq-settings', 'das-gq-theme-settings-project-board-btn-link');
    register_setting('das-gq-settings', 'das-gq-theme-settings-designer-name-title');
    register_setting('das-gq-settings', 'das-gq-theme-settings-design-options-title');
    register_setting('das-gq-settings', 'das-gq-theme-settings-client-notes-name');
    register_setting('das-gq-settings', 'das-gq-theme-settings-title');
    register_setting('das-gq-settings', 'das-gq-theme-settings-client-notes-title');
    register_setting('das-gq-settings', 'das-gq-theme-settings-terms-title');
    register_setting('das-gq-settings', 'das-gq-theme-options-settings-custom-css-first');
    register_setting('das-gq-settings', 'das-gq-theme-options-settings-custom-css');
    register_setting('das-gq-settings', 'das-gq-theme-settings-custom-css');
    register_setting('das-gq-settings', 'das-gq-theme-project-icon-color');
    register_setting('das-gq-settings', 'das-gq-theme-project-main-header-text-color');
    register_setting('das-gq-settings', 'das-gq-theme-project-main-header-background-color');
    register_setting('das-gq-settings', 'das-gq-theme-project-text-link-color');
    register_setting('das-gq-settings', 'das-gq-theme-project-background-color-boxes');
    register_setting('das-gq-settings', 'das-gq-theme-project-background-color-even-comment-boxes');
    register_setting('das-gq-settings', 'das-gq-theme-project-background-main-btns-hover');
    register_setting('das-gq-settings', 'das-gq-theme-project-text-main-btns-hover');
    register_setting('das-gq-settings', 'das-gq-theme-project-border-color');
    register_setting('das-gq-settings', 'das-gq-theme-project-text-color');
    register_setting('das-gq-settings', 'das-gq-theme-terms-popup-global');
    register_setting('das-gq-settings', 'das-gq-theme-settings-project-board-btn-custom-name');
    register_setting('das-gq-settings', 'das-gq-theme-client-changes-global');
    register_setting('das-gq-settings', 'das-gq-theme-agree-to-terms-checkbox');
    register_setting('das-gq-settings', 'das-gq-theme-hide-media-button-checkbox');
    register_setting('das-gq-settings', 'das-gq-theme-limit-versions-checkbox');
    register_setting('das-gq-settings', 'das-gq-theme-limit-versions-displayed');
    register_setting('das-gq-settings', 'das-gq-theme-limit-versions-displayed-load-more');
    register_setting('das-gq-settings', 'das-gq-theme-order-versions-displayed');
    register_setting('das-gq-settings', 'das-gq-theme-approved-comments-option');
    // Woo Options
    register_setting('das-gq-settings', 'woo-view-project-board-section');
    register_setting('das-gq-settings', 'woo-hide-option-project-creation-frontend');
    register_setting('das-gq-settings', 'das-gq-theme-settings-project-board-login-link');
    register_setting('das-gq-settings', 'remove-woo-order-prod-id-column');
    register_setting('das-gq-settings', 'woo-order-prod-id-column-options');
    // Additional Customizable text areas for popups
    register_setting('das-gq-settings', 'das-project-popuptext');
    register_setting('das-gq-settings', 'das-approval-popuptext-part-one');
    register_setting('das-gq-settings', 'das-approval-popuptext-part-two');
    register_setting('das-gq-settings', 'das-changes-popuptext-part-one');
    register_setting('das-gq-settings', 'das-custom-pb-board-login-message');
    //View invoice custom options
    register_setting('das-gq-settings', 'das-view-invoice-title');
    register_setting('das-gq-settings', 'das-view-invoice-text');


}
if(isset($_GET['das_redirect']) && $_GET['das_redirect'] == 'yes') {
    add_filter('woocommerce_login_redirect', 'das_wc_login_redirect');
}
function das_wc_login_redirect() {
    $redirect = $_GET['redirect_to'];
    return $redirect;
}
// Admin scripts for only the pages we need them on
function das_gq_theme_settings_admin_scripts()
{
    wp_enqueue_script('jquery');
    wp_register_style('my-custom-css', plugins_url('design-approval-system/templates/gq-template/admin/css/admin-settings.css'));
    wp_enqueue_style('my-custom-css');
    wp_register_style('og-admin-css', plugins_url('design-approval-system/admin/css/admin-settings.css'));
    wp_enqueue_style('og-admin-css');
}

if (isset($_GET['page']) && $_GET['page'] == 'das-gq-theme-settings-page') {
    add_action('admin_enqueue_scripts', 'das_gq_theme_settings_admin_scripts');
}