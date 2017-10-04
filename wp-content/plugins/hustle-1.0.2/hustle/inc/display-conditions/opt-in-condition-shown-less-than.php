<?php

class Opt_In_Condition_Shown_Less_Than extends Opt_In_Condition_Abstract implements Opt_In_Condition_Interface
{

    function is_allowed(Opt_In_Model $optin){
        if( !isset( $this->args->less_than ) )
            return true;

        $type = $this->optin_type;
        $show_count = isset( $_COOKIE[ "wpoi-optin-{$type}-shown-count-" . $optin->id ] ) ?  (int) $_COOKIE[ "wpoi-optin-{$type}-shown-count-" . $optin->id ] : 0;
        return $show_count < (int) $this->args->less_than;
    }
}