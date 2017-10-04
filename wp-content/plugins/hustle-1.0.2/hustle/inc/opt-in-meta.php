<?php

abstract class Opt_In_Meta {

    protected  $data;
    protected  $optin;

    function __construct( array $data, Opt_In_Model $optin ){
        $this->data = $data;
        $this->optin = $optin;
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

        if( !empty( $this->data ) && isset( $this->data->{$field} ) )
            return in_array( strtolower( $this->data->{$field} ), array("true", "false", "null") ) ? ( $this->data->{$field} === "true" || $this->data->{$field} === true )  : $this->data->{$field} ;


        if( !empty( $this->data ) && isset( $this->data[ $field ] ) )
            return  is_string( $this->data[ $field ] )  && in_array( strtolower( $this->data[ $field ] ), array("true", "false", "null") )   ?  ( $this->data[ $field ] === "true" || $this->data[ $field ] === true ) : $this->data[ $field ] ;

    }

    function to_object(){
        return (object) $this->to_array();
    }

    function to_array(){
        if( isset( $this->defaults ) && is_array( $this->defaults   ) )
            return wp_parse_args( $this->data,  $this->defaults );

        return $this->data;
    }

    function to_json(){
        return json_encode( $this->to_array() );
    }

}










