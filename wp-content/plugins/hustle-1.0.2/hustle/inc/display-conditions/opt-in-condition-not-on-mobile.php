<?php

class Opt_In_Condition_Not_On_Mobile extends Opt_In_Condition_Abstract implements Opt_In_Condition_Interface
{
    function is_allowed(Opt_In_Model $optin){
        return !wp_is_mobile();
    }
}