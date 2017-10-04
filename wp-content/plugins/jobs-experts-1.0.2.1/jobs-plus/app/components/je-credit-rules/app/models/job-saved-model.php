<?php

/**
 * @author:Hoang Ngo
 */
class Job_Saved_Model extends IG_Option_Model
{
    public $status;
    public $credit_use;
    public $free_from;
    public $free_for;

    protected $table = 'job_saved_settings';
    protected $rules = array(
        'credit_use' => 'required',
        'cost' => 'numeric|min_numeric,1',
        'free_from' => 'numeric|min_numeric,0'
    );
}