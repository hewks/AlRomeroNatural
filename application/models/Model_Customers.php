<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Customers extends Model_Genetic
{
    protected $tab = 'customers_register';
    protected $cells = ['email', 'username', 'name', 'lastname', 'genre', 'avatar_url'];
    protected $select;

    function __construct()
    {
        parent::__construct();
        $this->select = $this->construct_principal_select($this->cells);
    }

    function email_login($login_data)
    {
        $this->db->from($this->tab);
        $this->db->select('email,username,name,lastname');
        $this->db->where('email', $login_data['email']);
        $this->db->where('password', $login_data['password']);
        $query = $this->db->get()->row();
        return ($query) ? $query : false;
    }
}
