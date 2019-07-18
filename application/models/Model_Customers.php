<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Customers extends Model_Genetic
{
    protected $tab = 'customers_register';
    protected $cells = ['id','email', 'username', 'name', 'lastname', 'genre', 'avatar_url', 'document', 'document_type', 'phone','status'];
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

    // Past Version
    function all($mode = null)
    {
        $this->db->select($this->select);
        $this->db->from($this->tab);
        switch ($mode) {
            case 'table':
                $data = $this->db->get()->result();
                $query = array();
                foreach ($data as $row) {
                    $query[] = array(
                        'id' => $row->id,
                        'name' => $row->name . ' ' . $row->lastname,
                        'document' => $row->document,
                        'email' => $row->email,
                        'phone' => $row->phone,
                        'status' => $row->status,
                        'actions' => '<div class="bs-btn-group-section">
                            <button class="bs-btn-action bs-btn-delete" onClick="sectionAction(\'Clientes\',' . $row->id . ', \'delete\')"><i class="fas fa-trash-alt"></i></button>
                            <button class="bs-btn-action bs-btn-edit" onClick="requestEditData(\'Clientes\',' . $row->id . ')"><i class="fas fa-file-export"></i></button>
                            <button class="bs-btn-action bs-btn-active" onClick="sectionAction(\'Clientes\',' . $row->id . ', \'active\')"><i class="fas fa-plus"></i></button>
                         </div>'
                    );
                }
                break;
            case null:
                $query = $this->db->get()->result();
                break;
        }
        return ($query) ? $query : false;
    }
}
