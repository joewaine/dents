<?php

class Opt_In_Condition_Visitor_Logged_In extends Opt_In_Condition_Abstract implements Opt_In_Condition_Interface
{
    function is_allowed(Opt_In_Model $optin){
        return is_user_logged_in();
    }
}