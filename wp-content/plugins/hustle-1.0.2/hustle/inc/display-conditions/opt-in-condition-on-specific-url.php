<?php

class Opt_In_Condition_On_Specific_Url extends Opt_In_Condition_Abstract implements Opt_In_Condition_Interface
{
    function is_allowed(Opt_In_Model $optin){
        return isset( $this->args->urls ) ? $this->utils()->check_url( $this->utils()->get_current_url(), $this->args->urls ) : true;
    }
}