<?php

class Opt_In_Front extends Opt_In
{

    private $_optin_handles = array();
    private $_optin_layouts = array();
    private $_args_layouts = array();

    private $_styles;

    const Widget_CSS_CLass = "inc_opt_widget_wrap inc_optin";
    const Shortcode_CSS_CLass = "inc_opt_shortcode_wrap inc_optin";
    const Shortcode_Trigger_CSS_CLass = "inc_opt_hustle_shortcode_trigger";
    const AfterContent_CSS_CLass = "inc_opt_after_content_wrap wpoi-animation inc_optin";

    const SHORTCODE = "wd_hustle";

    function __construct()
    {

        new Opt_In_Front_Ajax();
        add_action( 'widgets_init', array( $this, 'register_widget' ) );

        if( is_admin() ) return;

        add_action('wp_enqueue_scripts', array($this, "register_scripts"));
        // Enqueue it in the footer to overrider all the css that comes with the popup
        add_action('wp_footer', array($this, "register_styles"));

        add_action('template_redirect', array($this, "create_popups"));

        add_action("wp_footer", array($this, "add_layout_templates"));

        add_filter("the_content", array($this, "show_after_page_post_content"), 2, 99);


        add_shortcode(self::SHORTCODE, array( $this, "shortcode" ), 10, 2);
    }

    function register_widget() {
        register_widget( 'Opt_In_Widget' );
    }

    function register_scripts()
    {

        if( is_customize_preview() ) return;

        /**
         * Register popup requirements
         */
        lib3()->ui->add( TheLib_Ui::MODULE_CORE );
        lib3()->ui->add( TheLib_Ui::MODULE_ANIMATION );

        wp_register_script('optin_front', self::$plugin_url . 'assets/js/front.min.js', array('jquery', 'underscore'), '1.1', self::VERSION, false);

        wp_localize_script('optin_front', 'Optins', $this->_optin_handles);
        wp_localize_script('optin_front', 'inc_opt', array(
            "ajaxurl" => admin_url("admin-ajax.php", is_ssl() ? 'https' : 'http'),
            'page_id' => get_queried_object_id(),
            'page_type' => $this->current_page_type(),
            'is_upfront' => class_exists( "Upfront" ) && isset( $_GET['editmode'] ) && $_GET['editmode'] === "true",
            'adblock_detector_js' => self::$plugin_url . 'assets/js/front/ads.js',
            'l10n' => array(
                "never_see_again" => __("Never see this message again", Opt_In::TEXT_DOMAIN),
                'success' => __("Congratulations! You have been subscribed to {name}", Opt_In::TEXT_DOMAIN),
                'submit_failure' => __("Something went wrong, please try again.", Opt_In::TEXT_DOMAIN),
                'test_cant_submit' => __("Form can't be submitted in test mode.", Opt_In::TEXT_DOMAIN),
            )
        ));

        wp_enqueue_script('optin_front');
    }

    function register_styles()
    {
        wp_register_style('optin_front', self::$plugin_url . 'assets/css/front.css', array( 'dashicons' ), self::VERSION);


        wp_enqueue_style('optin_form_front');
        wp_enqueue_style('optin_front');
        $this->_inject_styles();
    }

    /**
     * Enqueues popups to be displayed
     *
     *
     */
    function create_popups()
    {

        global $post;
        $categories_array = $this->_get_term_ids($post, "category");
        $tags_array = $this->_get_term_ids($post, "post_tag");
        $enque_adblock_detector  = false;

        /**
         * @var $optin Opt_In_Model
         */
        foreach (Opt_In_Collection::instance()->get_all_optins() as $optin) {

            $handle = $this->_get_unique_id();
            $settings = $optin->get_frontend_settings($post, $categories_array, $tags_array);
            $this->_optin_handles[$handle]["settings"] = $settings;
            $this->_optin_handles[$handle]["design"] = $optin->get_design()->to_object();
            $this->_optin_handles[$handle]["data"] = $optin->get_data();
            $this->_optin_handles[$handle]["shortcode"] = $optin->settings->widget->to_array();
            $this->_optin_handles[$handle]["widget"] = $optin->settings->shortcode->to_array();
            $this->_optin_handles[$handle]["provider_args"] = $optin->provider_args;
            $this->_styles .= $optin->decorated->get_optin_styles();

            $this->_optin_layouts[ $handle ] = $this->_optin_handles[$handle]["design"]->form_location;

            if( $optin->provider_args )
                $this->_args_layouts[ $handle ] = $optin->optin_provider;

            if( ( $settings->popup['appear_after'] === "adblock" && isset( $settings->popup["trigger_on_adblock"] ) &&  $settings->popup["trigger_on_adblock"] === "true" )
                || (   $settings->slide_in['appear_after'] === "adblock" && isset( $settings->slide_in["trigger_on_adblock"] ) &&  $settings->slide_in["trigger_on_adblock"] === "true" ) )
                $enque_adblock_detector = true;
        }

        if( $enque_adblock_detector )
            wp_enqueue_script('optin_front_ads', self::$plugin_url . 'assets/js/front/ads.js', array(),'1.0', self::VERSION, false);
    }

    /**
     * Returns array of terms ids based on $post and $tax
     *
     * @param $post WP_Post|int
     * @param $tax string taxonomy
     * @return array of term ids
     */
    private function _get_term_ids( $post, $tax ){

        $func = create_function('$obj', 'return (string)$obj->term_id;');
        $terms = get_the_terms( $post, $tax );
        return array_map( $func, empty( $terms ) ? array( ) : $terms );
    }

    /**
     * @param $content
     * @return string
     */
    function show_after_page_post_content( $content ){
        global $post;

        $optins = Opt_In_Collection::instance()->get_all_optins();
        $categories_array = $this->_get_term_ids($post, "category");
        $tags_array = $this->_get_term_ids($post, "post_tag");

        /**
         * @var Opt_In_Model $optin
         */

        foreach( $optins as $optin ){
            $settings = $optin->get_frontend_settings($post, $categories_array, $tags_array);
            if( isset( $settings->after_content, $settings->after_content['display'] ) && $settings->after_content['display']  ) {
                $content .= sprintf("<div class='%s' data-id='%s'></div>", self::AfterContent_CSS_CLass . " inc_optin_" . $optin->id, $optin->id);
            }
        }

        remove_filter("the_content", array($this, "show_after_page_post_content"));

        return $content;
    }

    private function _get_unique_id()
    {
        return uniqid("IncOpt");
    }

    private function _inject_styles(){
        ?>
        <style type="text/css" id="inc-opt-styles"><?php echo $this->_styles; ?></style>
        <?php
    }

    /**
     * Returns unique registered layout numbers
     *
     * @since 1.0.1
     * @return array
     */
    private function _get_registered_layouts(){
        return array_unique( $this->_optin_layouts );
    }


    /**
     * Returns unique registered arg layout numbers
     *
     * @since 1.0.1
     * @return array
     */
    private function _get_registered_arg_layouts(){
        return array_unique( $this->_args_layouts );
    }

    /**
     * Adds needed layouts
     *
     * @since 1.0
     */
    function add_layout_templates(){
        foreach( $this->_get_registered_layouts() as $layout_no ){
            $this->render("general/layouts/" . $layout_no );
        }

        foreach( $this->_get_registered_arg_layouts() as $provider_name ){
            $this->render("general/providers/" . $provider_name );
        }
    }

    function shortcode( $atts, $content , $a){
        $atts = shortcode_atts( array(
            'id' => '',
            "type" => ""
        ), $atts, self::SHORTCODE );

        $type = trim( $atts['type'] );
        if( empty( $atts['id'] ) ) return "";



        $optin = Opt_In_Model::instance()->get_by_shortcode( $atts['id'] );

        if( !$optin || !$optin->active ) return "";

        /**
         * Maybe add trigger link
         */
        if( !empty( $content ) && !empty( $type ) && in_array( $type, array("popup", "slide_in") ) && $optin->settings->{$type}->enabled && $optin->settings->{$type}->appear_after === "click" )
            return sprintf("<a href='#' class='%s' data-id='%s' data-type='%s'>%s</a>", self::Shortcode_Trigger_CSS_CLass . " inc_optin_" . $optin->id, $optin->id, esc_attr( $type ),  $content );

        if( !$optin->settings->shortcode->show_in_front()  ) return "";



        return sprintf("<div class='%s' data-id='%s'></div>", self::Shortcode_CSS_CLass . " inc_optin_" . $optin->id, $optin->id);
    }
}