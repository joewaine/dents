<?php

class Opt_In_Condition_Visitor_Has_Never_Commented extends Opt_In_Condition_Abstract implements Opt_In_Condition_Interface
{
    function is_allowed(Opt_In_Model $optin){
        return !$this->utils()->has_user_commented();
    }
}