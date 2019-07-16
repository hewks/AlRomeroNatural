<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Errors extends Model_Genetic
{
    protected $tab = 'errors_register';
    protected $cells = ['type', 'errro', 'error_text', 'created_at'];
    protected $select;

    function __construct()
    {
        parent::__construct();
        $this->select = $this->construct_principal_select($this->cells);
    }
}
