<?php
/**
 * Class Opt_In_Meta_Design
 *
 *
 * @property int $form_location
 * @property array $elements
 * @property string $image_location
 * @property string $image_style
 * @property string $image_src
 * @property Opt_In_Meta_Design_Colors $colors
 * @property Opt_In_Meta_Design_Borders $borders
 * @property string $opening_animation
 * @property string $closing_animation
 * @property string $css
 */
class Opt_In_Meta_Design extends Opt_In_Meta{

    var $defaults = array(
        "success_message" => "Congratulations! You have been subscribed to {name}",
        "form_location" => 0,
        "elements" => array('image'),
        "image_location" => "left",
        "image_style" => "cover",
        "image_src" => "",
        "colors" => array(),
        "borders" => array(),
        "opening_animation" => "",
        "closing_animation" => "",
        "css" => "",
        "input_icons" => "animated_icon" // possible values no_icon|none_animated_icon|animated_icon
    );

    function __construct( array $data, Opt_In_Model $optin  ){
        parent::__construct( $data, $optin );
        if( isset( $this->data['image_src'] ) )
            $this->data['image_src'] = set_url_scheme( $this->data['image_src'], is_ssl() ? "https" : "http" );
    }
    /**
     * @return Opt_In_Meta_Design_Colors
     */
    function get_colors(){
        return new Opt_In_Meta_Design_Colors( $this->data['colors'], $this->optin );
    }

    /**
     * @return Opt_In_Meta_Design_Borders
     */
    function get_borders(){
        return new Opt_In_Meta_Design_Borders( $this->data['borders'], $this->optin );
    }
}