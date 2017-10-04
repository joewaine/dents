<?php

class Opt_In_Front_Ajax extends Opt_In {

    function __construct(){

        // When optin is viewed
        add_action("wp_ajax_inc_opt_optin_viewed", array( $this, "optin_viewed" ));
        add_action("wp_ajax_nopriv_inc_opt_optin_viewed", array( $this, "optin_viewed" ));

        // When optin form is submitted
        add_action("wp_ajax_inc_opt_submit_opt_in", array( $this, "submit_optin" ));
        add_action("wp_ajax_nopriv_inc_opt_submit_opt_in", array( $this, "submit_optin" ));

    }


    function submit_optin(){
        $data = $_POST['data'];
        parse_str( $data['form'], $form_data );

        if( !is_email( $form_data['inc_optin_email'] ) )
            wp_send_json_error( __("Invalid email address", Opt_In::TEXT_DOMAIN) );

        $subscribe_data = array_merge( $form_data, array(
                "email" => $form_data['inc_optin_email']
            )
        );

        if( isset( $form_data['inc_optin_first_name'] ) )
            $subscribe_data['f_name'] = $form_data['inc_optin_first_name'];

        if( isset( $form_data['inc_optin_last_name'] ) )
            $subscribe_data['l_name'] = $form_data['inc_optin_last_name'];


        $optin = Opt_In_Model::instance()->get( $data['optin_id'] );

        $provider = $this->get_provider_by_id( $optin->optin_provider );

        $provider = Opt_In::provider_instance( $provider );

        if( !is_subclass_of( $provider, "Opt_In_Provider_Abstract") )
            wp_send_json_error( __("Invalid provider", Opt_In::TEXT_DOMAIN) );


        $optin_type = $data["type"];

        $result = $provider->subscribe( $optin, $subscribe_data );

        if( $result && !is_wp_error( $result ) ){
            $optin->log_conversion( array(
                'page_type' => $data['page_type'],
                'page_id'   => $data['page_id'],
                'optin_id' => $optin->id
            ), $optin_type );
            wp_send_json_success( $result );
        }

        if( is_wp_error( $result ) ){
            /**
             * @var WP_Error $result
             */
            wp_send_json_error( $result->get_error_message() );
        }

        wp_send_json_error( $result );
    }

    function optin_viewed(){
        $data = $_REQUEST['data'];

        $optin_id = is_array( $data ) ?  $data['optin_id'] : null;
        $optin_type = is_array( $data ) ?  $data['type'] : null;

        if( empty( $optin_id ) )
            wp_send_json_error( __("Invalid Request: Opt-In id invalid") );

        $optin = Opt_In_Model::instance()->get( $optin_id );

         $res = $optin->log_view( array(
            'page_type' => $data['page_type'],
            'page_id'   => $data['page_id'],
            'optin_id' => $optin_id,
             'uri' => $data['uri']
        ), $optin_type );

        if( is_wp_error( $res ) || empty( $data ) )
            wp_send_json_error( __("Error saving stats") );
        else
            wp_send_json_success( __("Stats Successfully saved") );

    }
}