<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Customers extends Model_Genetic
{
    protected $tab = 'customers_register';
    protected $cells = ['email','username','name','lastname'];
    protected $select;

    function __construct()
    {
        parent::__construct();
        $this->select = $this->construct_principal_select($this->cells);
    }
}
