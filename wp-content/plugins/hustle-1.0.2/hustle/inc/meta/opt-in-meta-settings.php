<?php
/**
 * Class Opt_In_Meta_Settings
 *
 *
 * @property string $shortcode_id
 * @property bool $show_on_all_cats
 * @property array $show_on_these_cats
 * @property bool $show_on_all_tags
 * @property array $show_on_these_tags
 * @property Opt_In_Meta_Settings_After_Content $after_content
 * @property Opt_In_Meta_Settings_Popup $popup
 * @property Opt_In_Meta_Settings_Slide_In $slide_in
 * @property Opt_In_Meta_Settings_Shortcode $shortcode
 * @property Opt_In_Meta_Settings_Widget $widget
 */
class Opt_In_Meta_Settings extends Opt_In_Meta{

    var $defaults = array(
        "shortcode_id" => "",
        "after_content" => array(),
        "popup" => array(),
        "slide_in" => array(),
        "widget" => array()
    );

    /**
     * Returns type data from $this->data
     *
     * @param $type_key
     * @return array
     */
    private function _get_type_data( $type_key ){
        return isset( $this->data[ $type_key ] ) ? (array) $this->data[ $type_key ] : array();
    }

    /**
     * @return Opt_In_Meta_Settings_After_Content
     */
    function get_after_content(){
        return new Opt_In_Meta_Settings_After_Content( $this->_get_type_data( 'after_content' ), $this->optin );
    }

    /**
     * @return Opt_In_Meta_Settings_Popup
     */
    function get_popup(){
        return new Opt_In_Meta_Settings_Popup( $this->_get_type_data( 'popup' ), $this->optin );
    }

    /**
     * @return Opt_In_Meta_Settings_Slide_In
     */
    function get_slide_in(){
        return new Opt_In_Meta_Settings_Slide_In( $this->_get_type_data( 'slide_in' ) , $this->optin );
    }

    /**
     * @return Opt_In_Meta_Settings_Shortcode
     */
    function get_shortcode(){
        return new Opt_In_Meta_Settings_Shortcode( $this->_get_type_data( 'shortcode' ), $this->optin );
    }

    /**
     * @return Opt_In_Meta_Settings_Widget
     */
    function get_widget(){
        return new Opt_In_Meta_Settings_Widget( $this->_get_type_data( 'widget' ), $this->optin );
    }

    function to_array(){

        return array(
                "shortcode_id" => $this->data['shortcode_id'],
                "after_content" => $this->get_after_content()->to_array(),
                "popup" => $this->get_popup()->to_array(),
                "slide_in" => $this->get_slide_in()->to_array(),
                "widget" => $this->get_widget()->to_array()
            );

    }
}