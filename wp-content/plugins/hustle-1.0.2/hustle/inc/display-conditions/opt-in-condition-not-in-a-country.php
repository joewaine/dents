<?php

class Opt_In_Condition_Not_In_A_Country extends Opt_In_Condition_Abstract implements Opt_In_Condition_Interface
{
    function is_allowed(Opt_In_Model $optin){
        return isset( $this->args->countries ) ?  $this->utils()->test_country( $this->args->countries ) : true;
    }
}