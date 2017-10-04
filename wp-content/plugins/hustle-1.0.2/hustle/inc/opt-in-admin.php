<?php
if( !class_exists("Opt_In_Admin") ):
/**
 * Class Opt_In_Admin
 */

class Opt_In_Admin extends Opt_In{


    function __construct(){
        add_action( 'admin_menu', array( $this, "register_admin_menu" ) );
        add_action( 'admin_init', array( $this, "init" ) );

        if( $this->_is_optin_admin() ) {
            add_action( 'admin_enqueue_scripts', array( $this, "register_scripts" ) );
            add_action( 'admin_print_styles', array( $this, "register_styles" ) );
            add_action("admin_footer", array($this, "add_layout_templates"));
            add_filter( 'admin_body_class', array( $this, 'admin_body_class' ), 99 );
            add_filter("user_can_richedit", '__return_true'); // allow rich editor in
            add_filter( 'teeny_mce_before_init', array( $this, 'set_tinymce_settings' ) );
            add_filter("wp_default_editor", array( $this, 'set_editor_to_tinymce' ));
            add_filter("teeny_mce_plugins", array( $this, 'remove_despised_editor_plugins' ));

        }

    }

    /**
     * Removes unnesesary editor plugins
     *
     * @param $plugins
     * @return mixed
     */
    function remove_despised_editor_plugins( $plugins ){

        if( ( $k = array_search( "fullscreen", $plugins) ) !== false ){
            unset( $plugins[ $k ] );
        }
        $plugins[] = "paste";
        return $plugins;
    }

    /**
     * Sets default editor to tinymce for opt-in admin
     *
     * @param $editor_type
     * @return string
     */
    function set_editor_to_tinymce( $editor_type ){
        return "tinymce";
    }

    function add_layout_templates(){
        $optin_id = filter_input(INPUT_GET, "optin", FILTER_VALIDATE_INT);
        $optin = $optin_id ? Opt_In_Model::instance()->get( $optin_id ) : $optin_id;
        $this->render("general/layouts", array("optin" => $optin));
        $this->render("general/alert");
    }

    /**
     * Inits admin
     *
     * @since 1.0
     */
    function init(){
        new Opt_In_Admin_Ajax();
    }

    /**
     * Register scripts for the admin page
     *
     * @since 1.0
     */
    function register_scripts(){

        /**
         * Register popup requirements
         */
        lib3()->ui->add( TheLib_Ui::MODULE_CORE );
        lib3()->ui->add( TheLib_Ui::MODULE_SELECT );
        lib3()->ui->add( TheLib_Ui::MODULE_ANIMATION );

        wp_enqueue_script('thickbox');
        wp_enqueue_media();
        wp_enqueue_script('media-upload');

        wp_register_script( 'optin_admin_ace', self::$plugin_url . 'assets/js/vendor/ace/ace.js', array(), self::VERSION, true );

        wp_enqueue_script(  'optin_admin_ace' );
        wp_enqueue_script(  'optin_admin_popup' );
        wp_enqueue_script(  'optin_admin_select2' );

        $tags = array_map(array($this, "terms_to_select2_data"), get_categories(array(
            "hide_empty" =>false,
            'taxonomy' => 'post_tag'
        )));

        $cats = array_map(array($this, "terms_to_select2_data"), get_categories(array(
            "hide_empty" =>false,
        )));


        $posts = array_map(array($this, "posts_to_select2_data"), get_posts(array(
                'numberposts' => -1
         )));
        /**
         * Add all posts
         */
        $allPosts = new stdClass();
        $allPosts->id = "all";
        $allPosts->text = __("ALL POSTS", Opt_In::TEXT_DOMAIN);
        array_unshift($posts, $allPosts);

        $pages = array_map(array($this, "posts_to_select2_data"), get_posts(array(
            'numberposts' => -1,
            'post_type' => 'page'
        )));

        /**
         * Add all pages
         */
        $allPages = new stdClass();
        $allPages->id = "all";
        $allPages->text = __("ALL PAGES", Opt_In::TEXT_DOMAIN);
        array_unshift($pages, $allPages);

        $optin_vars = array(
            'messages' => array(
              'dont_navigate_away' => __("Changes are not saved, are you sure you want to navigate away?", Opt_In::TEXT_DOMAIN),
              'undefined_name_service_provider' => __("Please define proper Opt-In name and service provider", Opt_In::TEXT_DOMAIN),
              'undefined_name' => __("Please define proper Opt-In name", Opt_In::TEXT_DOMAIN),
              'unselected_provider' => __("Please select service provider", Opt_In::TEXT_DOMAIN),
              'error' => __("Error", Opt_In::TEXT_DOMAIN),
              'ok' => __("Ok", Opt_In::TEXT_DOMAIN),
              'sure_to_delete' => __("Are you sure you want to delete this optin?", Opt_In::TEXT_DOMAIN ),
              'something_went_wrong' => __("Something went wrong. Please try again.", Opt_In::TEXT_DOMAIN ),
              'positions' => array(
                  'top_left' => __("Top Left", Opt_In::TEXT_DOMAIN ),
                  'top_center' => __("Top Center", Opt_In::TEXT_DOMAIN ),
                  'top_right' => __("Top Right", Opt_In::TEXT_DOMAIN ),
                  'center_left' => __("Center Left", Opt_In::TEXT_DOMAIN ),
                  'center_right' => __("Center Right", Opt_In::TEXT_DOMAIN ),
                  'bottom_left' => __("Bottom Left", Opt_In::TEXT_DOMAIN ),
                  'bottom_center' => __("Bottom Center", Opt_In::TEXT_DOMAIN ),
                  'bottom_right' => __("Bottom Right", Opt_In::TEXT_DOMAIN ),
                ),
                'settings' => array(
                    'popup' => __("Pop Up", Opt_In::TEXT_DOMAIN ),
                    'slide_in' => __("Slide In", Opt_In::TEXT_DOMAIN ),
                ),
                'conditions' => array(
                    'visitor_logged_in' => __("Visitor is logged in", Opt_In::TEXT_DOMAIN ),
                    'visitor_not_logged_in' => __("Visitor not logged in", Opt_In::TEXT_DOMAIN ),
                    'shown_less_than' => __("{type_name} shown less than", Opt_In::TEXT_DOMAIN ),
                    'only_on_mobile' => __("Only on mobile devices", Opt_In::TEXT_DOMAIN ),
                    'not_on_mobile' => __("Not on mobile devices", Opt_In::TEXT_DOMAIN ),
                    'from_specific_ref' => __("From a specific referrer", Opt_In::TEXT_DOMAIN ),
                    'not_from_specific_ref' => __("Not from a specific referrer", Opt_In::TEXT_DOMAIN ),
                    'not_from_internal_link' => __("Not from an internal link", Opt_In::TEXT_DOMAIN ),
                    'from_search_engine' => __("From a search engine", Opt_In::TEXT_DOMAIN ),
                    'on_specific_url' => __("On specific URL", Opt_In::TEXT_DOMAIN ),
                    'not_on_specific_url' => __("Not on specific URL", Opt_In::TEXT_DOMAIN ),
                    'visitor_has_commented' => __("Visitor has commented before", Opt_In::TEXT_DOMAIN ),
                    'visitor_has_never_commented' => __("Visitor has never commented", Opt_In::TEXT_DOMAIN ),
                    'in_a_country' => __("In a specific Country", Opt_In::TEXT_DOMAIN ),
                    'not_in_a_country' => __("Not in a specific Country", Opt_In::TEXT_DOMAIN )
                ),
                'conditions_body' => array(
                    'visitor_has_commented' => __('Shows the {type_name} if the user has already left a comment. You may want to combine this condition with either "Visitor is logged in" or "Visitor is not logged in".', Opt_In::TEXT_DOMAIN),
                    'visitor_has_never_commented' => __('Shows the {type_name} if the user has never left a comment. You may want to combine this condition with either "Visitor is logged in" or "Visitor is not logged in".', Opt_In::TEXT_DOMAIN),
                    'from_search_engine' => __('Shows the {type_name} if the user arrived via a search engine.', Opt_In::TEXT_DOMAIN),
                    'not_from_internal_link' => __('Shows the {type_name} if the user did not arrive on this page via another page on your site.', Opt_In::TEXT_DOMAIN),
                    'not_on_mobile' => __('Shows the {type_name} to visitors that are using a normal computer or laptop (i.e. not a Phone or Tablet).', Opt_In::TEXT_DOMAIN),
                    'only_on_mobile' => __('Shows the {type_name} to visitors that are using a mobile device (Phone or Tablet).', Opt_In::TEXT_DOMAIN),
                    'visitor_not_logged_in' => __('Shows the {type_name} if the user is not logged in to your site.', Opt_In::TEXT_DOMAIN),
                    'visitor_logged_in' => __('Shows the {type_name} if the user is logged in to your site.', Opt_In::TEXT_DOMAIN),
                ),
                'model' => array(
                    "defaults" => array(
                        "optin_name" => __("A beautiful optin name ...", Opt_In::TEXT_DOMAIN),
                        "optin_title" => __("Subscribe to our Newsletter", Opt_In::TEXT_DOMAIN),
                        "optin_message" => __("Please fill in the form and submit to subscribe", Opt_In::TEXT_DOMAIN),
                        "success_message" => __("Congratulations! You have been subscribed to {name}", Opt_In::TEXT_DOMAIN)
                    ),
                    "errors" => array(
                        'name' => __('Please fill "name" field.', Opt_In::TEXT_DOMAIN),
                        'provider' => __('Please choose a valid provider.', Opt_In::TEXT_DOMAIN),
                        'api_key' => __('Please provide api key.', Opt_In::TEXT_DOMAIN),
                        'mail_list' => __('Please select a mail list.', Opt_In::TEXT_DOMAIN)
                    )
                ),
                "sendy" => array(
                    "enter_url" => __("Please enter installation URL", Opt_In::TEXT_DOMAIN)
                )
            ),
            'url' => get_home_url(),
            'includes_url' => includes_url(),
            "palettes" => $this->get_palettes(),
            'preview_image' => "",//set_url_scheme( self::$plugin_url . "assets/img/preview-image.jpg", is_ssl() ? "https" : "http" ),
            "cats" => $cats,
            "tags" => $tags,
            "posts" => $posts,
            "pages" => $pages,
            'is_edit' => $this->_is_edit(),
            'current' => array(
                "data" => "",
                "settings" => '',
                'design' => '',
                'provider_args' => ''
            )
        );

        if( $this->_is_edit() ){
            $optin = Opt_In_Model::instance()->get( filter_input(INPUT_GET, "optin", FILTER_VALIDATE_INT) );

            $optin_vars['current'] = array(
                    "data" => $optin->get_data(),
                    "settings" => $optin->settings->to_object(),
                    'design' => $optin->design->to_object(),
                    'provider_args' => $optin->provider_args
            );
        }

        $ap_vars = array(
            'url' => get_home_url(),
            'includes_url' => includes_url()
        );





        WDEV_Plugin_Ui::load( self::$plugin_url . "assets/shared-ui", "wpmud");


        wp_register_script( 'optin_wpeditor_init', self::$plugin_url . 'assets/js/admin.min.js', array( 'jquery', 'backbone', 'wp-color-picker', 'jquery-effects-core' ), self::VERSION, true );
        wp_localize_script( 'optin_wpeditor_init', 'optin_vars', $optin_vars );
        wp_enqueue_script( 'optin_wpeditor_init' );

    }

    /**
     * Is the admin page being viewed in edit mode
     *
     * @since 1.0.0.
     *
     * @return mixed
     */
    private function _is_edit(){
        return  (bool) filter_input(INPUT_GET, "optin", FILTER_VALIDATE_INT);
    }

    /**
     * Registers admin menu page
     *
     * @since 1.0
     */
    function register_admin_menu(){
        add_menu_page( __("Hustle", Opt_In::TEXT_DOMAIN) , __("Hustle", Opt_In::TEXT_DOMAIN) , "manage_options", "inc_optins", array( $this, 'render_optins_listing' ), self::$plugin_url . 'assets/img/icon.svg');
        add_submenu_page( 'inc_optins', __("Opt-Ins", Opt_In::TEXT_DOMAIN) , __("Opt-Ins", Opt_In::TEXT_DOMAIN) , "manage_options", 'inc_optins',  array( $this, "render_optins_listing" )  );
        add_submenu_page( 'inc_optins', __("Add New", Opt_In::TEXT_DOMAIN) , __("Add New", Opt_In::TEXT_DOMAIN) , "manage_options", 'inc_optin',  array( $this, "render_optin_settings_page" )  );
    }

    /**
     * Renders menu page based on if we already any optin
     *
    * @since 1.0
     */
    function render_optin_settings_page( ) {

        if( !$this->has_optin( ) ) $optin_id = filter_input( INPUT_GET, "optin", FILTER_VALIDATE_INT );

        $code = filter_input( INPUT_GET, "code" );

        $this->render( "/admin/wpoi-wizard", array(
            "is_edit" => $this->_is_edit(),
            "optin" => $optin_id ? Opt_In_Model::instance()->get( $optin_id ) : $optin_id,
            "providers" => $this->get_providers(),
            "animations" => $this->get_animations(),
            'countries' => $this->get_countries(),
            'widgets_page_url' => get_admin_url(null, "widgets.php"),
            'code' => $code
        ));

    }

    /**
     * Renders Optins listing page
     *
     * @since 1.0
     */
    function render_optins_listing(){
        $optins = Opt_In_Collection::instance()->get_all_optins( null );
        if( count( $optins ) == 0 ) {
            $current_user = wp_get_current_user();
            $this->render("admin/new-welcome", array(
                "user_name" => ucfirst($current_user->display_name)
            ));
        } else {
            $new_optin = isset( $_GET['optin'] ) ? Opt_In_Model::instance()->get( intval($_GET['optin'] ) ) : null;
            $updated_optin = isset( $_GET['optin_updated'] ) ? Opt_In_Model::instance()->get( intval($_GET['optin_updated'] ) ) : null;
            $this->render("admin/listing", array(
                'optins' => Opt_In_Collection::instance()->get_all_optins( null ),
                'types' => array(
                    'after_content' => __('AFTER CONTENT', Opt_In::TEXT_DOMAIN),
                    'popup' => __('POP UP', Opt_In::TEXT_DOMAIN),
                    'slide_in' => __('SLIDE IN', Opt_In::TEXT_DOMAIN),
                    'shortcode' => __("Shortcode", Opt_In::TEXT_DOMAIN),
                    'widget' => __("Widget", Opt_In::TEXT_DOMAIN)
                ),
                'new_optin' =>  $new_optin,
                'updated_optin' =>  $updated_optin,
                'add_new_url' => admin_url("admin.php?page=inc_optin")
            ));
        }

    }

    /**
     * Registers styles for the admin
     *
     *
     */
    function register_styles(){

        wp_enqueue_style('thickbox');

        wp_register_style( 'optin_admin_select2', self::$plugin_url . 'assets/js/vendor/select2/css/select2.min.css', array(), self::VERSION);

        wp_register_style( 'wpoi_admin', self::$plugin_url . 'assets/css/admin.css', array(), self::VERSION);

		wp_enqueue_style( 'optin_admin_select2' );
        wp_enqueue_style( 'wp-color-picker' );

        wp_enqueue_style( 'wdev_ui' );
        wp_enqueue_style( 'wdev_notice' );

        wp_enqueue_style( 'wpoi_admin' );

    }

    function has_optin(){
        return false;
    }

    /**
     * Converts term object to usable object for select2
     * @param $term Term
     * @return stdClass
     */
    function terms_to_select2_data( $term ){
        $obj = new stdClass();
        $obj->id = $term->term_id;
        $obj->text = $term->name;
        return $obj;
    }

    /**
     * Converts post object to usable object for select2
     *
     * @param $post WP_Post
     * @return stdClass
     */
    function posts_to_select2_data($post){
        $obj = new stdClass();
        $obj->id = $post->ID;
        $obj->text = $post->post_title;
        return $obj;
    }


    /**
     * Checks if it's optin admin page
     *
     * @return bool
     */
    private function _is_optin_admin(){
        return isset( $_GET['page'] ) &&  ( "inc_optins" === $_GET['page'] || "inc_optin" === $_GET['page'] );
    }

    /**
     * Saves new optin to db
     *
     * @since 1.0
     *
     * @param $data
     * @return mixed
     */
    protected function save_new( $data ){
        $optin = new Opt_In_Model();

        // Save to optin table
        $optin->optin_name =  $data['optin']['optin_name'];
        $optin->optin_title = $data['optin']['optin_title'];
        $optin->optin_message = $data['optin']['optin_message'];
        $optin->optin_provider = $data['optin']['optin_provider'];
        $optin->optin_mail_list = $data['optin']['optin_mail_list'];
        $optin->active = (int) $data['optin']['active'];
        $optin->test_mode = (int) $data['optin']['test_mode'];
        $optin->save();

        // Save to meta table
        $optin->add_meta( "settings",  $data['settings'] );
        $optin->add_meta( "design",  $data['design'] );
        $optin->add_meta( "provider_args",  $data['provider_args'] );
        $optin->add_meta( "api_key",  $data['optin']['api_key'] );
        $optin->add_meta( "shortcode_id",  $data['settings']['shortcode_id'] );
        return $optin->id;
    }


    protected function update_optin( $data ){
        if( !isset( $data['id'] ) ) return false;

        $optin = Opt_In_Model::instance()->get( $data['id'] );

        // Save to optin table
        $optin->optin_name = $data['optin']['optin_name'];
        $optin->optin_title = $data['optin']['optin_title'];
        $optin->optin_message = $data['optin']['optin_message'];
        $optin->optin_provider = $data['optin']['optin_provider'];
        $optin->optin_mail_list = $data['optin']['optin_mail_list'];
        $optin->active = (int) $data['optin']['active'];
        $optin->test_mode = (int) $data['optin']['test_mode'];
        $optin->save();

        // Save to meta table
        $optin->update_meta( self::get_const( $optin, "KEY_SETTINGS" ) ,  $data['settings'] );
        $optin->update_meta( self::get_const( $optin, "KEY_API_KEY" ) ,  $data['optin']['api_key'] );
        $optin->update_meta( self::get_const( $optin, "KEY_DESIGN" ),  $data['design'] );
        $optin->update_meta( self::get_const( $optin, "PROVIDER_ARGS" ),  $data['provider_args'] );
        $optin->update_meta( "shortcode_id",  $data['settings']['shortcode_id'] );
        return $optin->id;
    }


    /**
     * Modify admin body class to our own advantage!
     *
     * @param $classes
     * @return mixed
     */
    function admin_body_class( $classes ){
        return str_replace(array("wpmud ", "wpmud"), "", $classes);
    }

    /**
     * Modify tinymce editor settings
     *
     * @param $settings
     */
    function set_tinymce_settings( $settings ) {
        $settings['paste_as_text'] = 'true';
        return $settings;
    }

}
endif;