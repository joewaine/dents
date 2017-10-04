<?php

/**
 * Class Opt_In_Decorator
 *
 * @property string $mail_service_label
 */
class Opt_In_Decorator extends Opt_In
{
    private $_optin;

    function __construct( Opt_In_Model $optin ){
        $this->_optin = $optin;
    }

    /**
     * Implements getter magic method
     *
     *
     * @since 1.0.0
     *
     * @param $field
     * @return mixed
     */
    function __get( $field ){

        if( method_exists( $this, "get_" . $field ) )
            return $this->{"get_". $field}();

        if( !empty( $this->_optin ) && isset( $this->_optin->{$field} ) )
            return $this->_optin->{$field};

    }

    private function  _get_stylable_elements()
    {
        return array(
            'main_background' => '.wpoi-hustle .wpoi-optin',
            'title_color' => '.wpoi-hustle h2.wpoi-title',
            'link_color' => '.wpoi-hustle .wpoi-message p a',
            'content_color' => '.wpoi-hustle .wpoi-message, .wpoi-hustle .wpoi-message p',
            'link_hover_color' => '.wpoi-hustle .wpoi-message p a:hover',
            'form_background' => '.wpoi-hustle .wpoi-form',
            'fields_background' => '.wpoi-hustle form .wpoi-element',
            'label_color' => '.wpoi-hustle form label, .wpoi-hustle form label span, .wpoi-hustle form wpoi-icon',
            'button_background' => '.wpoi-hustle form button',
            'button_label' => '.wpoi-hustle form button',
            'fields_color' => '.wpoi-hustle form > .wpoi-element input',
            'error_color' => '.wpoi-hustle form .i-error, .wpoi-hustle form .i-error + span',
            'button_hover_background' => '.wpoi-hustle form button:hover',
            'button_hover_label' => '.wpoi-hustle form button:hover',
            'checkmark_color' => '.wpoi-hustle .wpoi-success-message .wpoi-icon',
            'success_color' => '.wpoi-hustle .wpoi-success-message .wpoi-content, .wpoi-hustle .wpoi-success-message .wpoi-content p',
            'close_color' => 'a.inc-opt-close-popup',
            'nsa_color' => '.wpoi-nsa > a, .wpoi-nsa > a.inc_opt_never_see_again',
            'overlay_background' => '.wpoi-popup-overlay',
            'close_hover_color' => 'a.inc-opt-close-popup:hover, a.inc-opt-close-popup:active, a.inc-opt-close-popup:focus',
            'nsa_hover_color' => '.wpoi-nsa > a:hover, .wpoi-nsa > a.inc_opt_never_see_again:hover',
            'radio_background' => '.wpoi-hustle form .wpoi-mcg-option input[type="radio"] + label:before',
            'radio_checked_background' => '.wpoi-hustle form .wpoi-mcg-option input[type="radio"] + label:after',
            'checkbox_background' => '.wpoi-hustle form .wpoi-mcg-option input[type="checkbox"] + label:before',
            'checkbox_checked_color' => '.wpoi-hustle form .wpoi-mcg-option input[type="checkbox"]:checked + label:before',
            'mcg_title_color' => '.wpoi-hustle form .wpoi-mcg-list-name, .wpoi-hustle .wpoi-submit-failure',
            'mcg_label_color' => '.wpoi-hustle form .wpoi-mcg-option input[type="checkbox"] + label, .wpoi-hustle form .wpoi-mcg-option input[type="radio"] + label'
        );

    }

    private function _get_layout_colors()
    {
        if ( !$this->_optin->design->colors->customize )
            return $this->get_palette( $this->_optin->design->colors->palette );
        else
            return $this->_optin->design->colors->to_array();
    }


    public function get_optin_styles(){

        $styles = "";
        $prefix = ' .inc_optin_' . $this->_optin->id . " ";
        $stylable_elements = $this->_get_stylable_elements();
        $colors = $this->_get_layout_colors();

        // Color styles
        foreach( (array) $stylable_elements as $key => $el ){
            $color_type = strpos( $key, "background" ) ? 'background' : 'color';
            if( isset( $colors[ $key ] ) ){
                $color = $colors[ $key ];
                $styles .=  ( $prefix . $el . "{ " . $color_type . ": " . $color .";} " );
            }
        }

        $success_tick_color = "#1FC5B6"; // hardcoding for now
        $styles .= ($prefix . ".wpoi-success-icon path { fill: $success_tick_color }" );

//        $styles = str_replace("}", "} " . '.inc_optin_' . $this->_optin->id, $styles);

        // main container dropshadow
        if( $this->_optin->design->borders->drop_shadow )
            $styles .= $prefix . $stylable_elements['main_background'] . "{box-shadow:0px 0px " . $this->_optin->design->borders->dropshadow_value . "px " . $this->_optin->design->borders->shadow_color  ."}";

        //main container border
        if( $this->_optin->design->borders->rounded_corners )
            $styles .= ( $prefix .  $stylable_elements['main_background'] . "{border-radius:" . $this->_optin->design->borders->corners_radius ."px;}"  );


        if( $this->_optin->design->borders->fields_style !== "joined" ) {
            $styles .= ($prefix . $stylable_elements['button_label'] . "{border-radius:" . $this->_optin->design->borders->button_corners_radius . "px !important;}");
            $styles .= ($prefix . $stylable_elements['fields_background'] . "{border-radius:" . $this->_optin->design->borders->fields_corners_radius . "px;}");
        }else{
            $styles .= ($prefix . $stylable_elements['button_label'] . "{border-radius: 0px !important;}");
            $styles .= ($prefix . $stylable_elements['fields_background'] . "{border-radius: 0px;}");
        }

        $styles = str_replace(",", ", " . '.inc_optin_' . $this->_optin->id, $styles);
//        $styles = $this->_str_replace_last( '.inc_optin_' . $this->_optin->id, " ", $styles );


        //Popup border radius
        if( $this->_optin->design->borders->rounded_corners )
            $styles .= ( " .wpmui-popup" . trim( $prefix )  . "{border-radius:" . $this->_optin->design->borders->corners_radius ."px;}"  );

        // Custom styles
        $styles .= Opt_In::prepare_css($this->_optin->design->css, $prefix );


        return $styles;
    }

    function _str_replace_last( $search , $replace , $str ) {
        if( ( $pos = strrpos( $str , $search ) ) !== false ) {
            $search_length  = strlen( $search );
            $str    = substr_replace( $str , $replace , $pos , $search_length );
        }
        return $str;
    }

    /**
     * Returns a string representation of the display environments configured for the optin
     *
     * @return string
     */
    public function display_environments( $optin_type ){
       if( 'shortcode' ===  $optin_type  )
           return sprintf( __('[%s id="%s"]', Opt_In::TEXT_DOMAIN), Opt_In_Front::SHORTCODE, $this->_optin->get_meta( 'shortcode_id' ) );

        if( 'widget' ===  $optin_type   )
            return $this->_get_hosting_sidebars() === array() ? __("Active in no widget area.", Opt_In::TEXT_DOMAIN) : sprintf( __("Active in sidebars: <span class='wpoi-listing-active-in-sidebars'>%s</span>", Opt_In::TEXT_DOMAIN), implode(", ", $this->_get_hosting_sidebars()) );

        $optin_settings = $this->_optin->get_settings()->to_object();
        $res = '';



        if( filter_var( $optin_settings->{$optin_type}['show_on_all_cats'], FILTER_VALIDATE_BOOLEAN ) ) {
            $res .= __( 'ALL CATEGORIES', Opt_In::TEXT_DOMAIN );
            if( !empty( $optin_settings->{$optin_type}['show_on_these_cats'] ) ) {
                $res .= __( ' except ', Opt_In::TEXT_DOMAIN ) . $this->get_titles( (array) $optin_settings->{$optin_type}['show_on_these_cats'], 'cat');
            }
        }else{
            $res .= count( (array) $optin_settings->{$optin_type}['show_on_these_cats'] ) . _n( ' category', ' categories', count( (array) $optin_settings->{$optin_type}['show_on_these_cats'] ), Opt_In::TEXT_DOMAIN );
        }

        if( filter_var( $optin_settings->{$optin_type}['show_on_all_tags'], FILTER_VALIDATE_BOOLEAN ) ) {
            $res .= __( ', ALL TAGS', Opt_In::TEXT_DOMAIN );
            if( !empty( $optin_settings->{$optin_type}['show_on_these_tags'] ) ) {
                $res .= __( ' except ', Opt_In::TEXT_DOMAIN ) . $this->get_titles( (array) $optin_settings->{$optin_type}['show_on_these_tags'], 'tag');
            }
        }else{
            $res .= ', ' . count( (array) $optin_settings->{$optin_type}['show_on_these_tags'] ) . _n( ' tag', ' tags', count( (array) $optin_settings->{$optin_type}['show_on_these_tags'] ), Opt_In::TEXT_DOMAIN );
        }

        $excluded_pages = empty( $optin_settings->{$optin_type}['excluded_pages'] ) ? array() : (array) $optin_settings->{$optin_type}['excluded_pages'];
        $selected_pages = empty( $optin_settings->{$optin_type}['selected_pages'] ) ? array() : (array) $optin_settings->{$optin_type}['selected_pages'];

        if( ( array() === $excluded_pages && array() === $selected_pages ) || array() !== $excluded_pages ||  in_array("all", $selected_pages )) {
            $res .= __( ', ALL PAGES', Opt_In::TEXT_DOMAIN );
            if( array() !== $excluded_pages ) {
                $res .= __( ' except ', Opt_In::TEXT_DOMAIN ) . $this->get_titles( $excluded_pages, 'post');
            }
        }else{
            $res .= ', ' . count( $selected_pages ) . _n( ' page', ' pages', count( $selected_pages ) , Opt_In::TEXT_DOMAIN );
        }

        $excluded_posts = empty( $optin_settings->{$optin_type}['excluded_posts'] ) ? array() : (array) $optin_settings->{$optin_type}['excluded_posts'];
        $selected_posts = empty( $optin_settings->{$optin_type}['selected_posts'] ) ? array() : (array) $optin_settings->{$optin_type}['selected_posts'];

        if( ( array() === $excluded_posts && array() === $selected_posts ) || array() !== $excluded_posts || in_array("all", $selected_posts ) ) {
            $res .= __( ', ALL POSTS', Opt_In::TEXT_DOMAIN );
            if( array() !== $excluded_posts ) {
                $res .= __( ' except ', Opt_In::TEXT_DOMAIN ) . $this->get_titles( $excluded_posts, 'post');
            }
        }else{
            $res .= ', ' . count( $selected_posts ) . _n( ' post', ' posts', count( $selected_posts ) , Opt_In::TEXT_DOMAIN );
        }
        return $res;
    }

    private function get_titles( $ids, $type ) {
        $out = '';
        foreach ((array)$ids as $index => $id) {
            $title = '';
            $id = (int) $id;
            switch($type){
                case 'post':
                    $title = sprintf('<a target="_blank" href="%s">%s</a>', get_the_permalink( $id ), get_the_title( $id ) );
                    break;
                case 'tag':
                    $tag = get_tag( $id );
                    $title = sprintf('<a target="_blank" href="%s">%s</a>', get_tag_link( $id ), $tag->name );
                    break;
                case 'cat':
                    $title =  sprintf('<a target="_blank" href="%s">%s</a>', get_category_link( $id ), get_cat_name( $id )) ;
                    break;
            }

            if($index > 0){
                if($index == (count($ids) -1) ){
                    $out .= __( ' and ', Opt_In::TEXT_DOMAIN ) . $title;
                } else {
                    $out .= ', ' . $title;
                }
            }else {
                $out .= $title;
            }
        }
        return $out;
    }

    private function _get_hosting_sidebars(){
        global $wp_registered_widgets, $wp_registered_sidebars;

        $sidebars_widgets = wp_get_sidebars_widgets();
        $widgets_settings = get_option('widget_inc_opt_widget');

        $sidebars = array();
        $hosting_sidebars = array();
       foreach( (array) $sidebars_widgets as $sidebar_index => $widgets ){
           foreach( (array) $widgets as $key => $widget_id ){
               $matches = preg_match("/^" . Opt_In_Widget::Widget_Id ."\\-\\d+/", $widget_id );
                if( $matches ){

                     $params =  $wp_registered_widgets[$widget_id]['params'];
                    if( isset( $params[0], $params[0]['number'] ) ){
                        $sidebars[$sidebar_index] = $params[0]['number'];
                        if( $this->_optin->id === $widgets_settings[ $sidebars[$sidebar_index] ]['optin_id'] ){
                            $hosting_sidebars[] = $wp_registered_sidebars[$sidebar_index]['name'];
                        }
                    }

                }

           }

       }


        return $hosting_sidebars;
    }


    /**
     * Gets provider name from $id
     *
     * @param $id
     * @return bool
     */
    function get_service_name_from_id( $id ){
        foreach( $this->_providers as $provider ){
            if( $provider['id'] === $id )
                return $provider['name'];
        }

        return false;
    }

    /**
     * Returns provider's label and 'No Email Service' in case it's not set
     *
     * @return string
     */
    function get_mail_service_label(){

        $label = $this->get_service_name_from_id( $this->_optin->optin_provider );
        $label = !$label ? ucfirst( $this->_optin->optin_provider ) : $label;

        if( empty( $this->_optin->optin_provider ) )
            $label = __("No Email Service", Opt_In::TEXT_DOMAIN);

        if( !empty( $this->_optin->optin_provider ) &&  intval( $this->_optin->test_mode ) )
            $label = __("Test Mode", Opt_In::TEXT_DOMAIN);

        return $label;
    }

    /**
     * Returns link to edit page on specific tab
     *
     * @param $tab
     * @return string
     */
    function get_edit_url( $tab ){
        if( empty( $this->_optin->optin_provider ) ||  intval( $this->_optin->test_mode )  )
            $url = admin_url("admin.php?page=inc_optin&optin=" . $this->_optin->id);
        else
            $url = admin_url("admin.php?page=inc_optin&optin=" . $this->_optin->id . "#" . $tab);

        return esc_url( $url );
    }
}