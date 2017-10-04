<?php

/**
 * Interface to check display condition
 *
 * Class Opt_In_Condition_Interface
 */
interface Opt_In_Condition_Interface
{
    function is_allowed( Opt_In_Model $optin );
}