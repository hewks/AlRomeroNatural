<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Employee extends Model_Genetic
{

    protected $tab = 'employee_register';
    protected $cells = ['id', 'name', 'lastname', 'document', 'document_type', 'email', 'phone', 'liability', 'price', 'salary_pay', 'status'];
    protected $select = '';

    function __construct()
    {
        parent::__construct();
        $this->select = $this->create_select();
    }

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
                        'email' => $row->email,
                        'phone' => $row->phone,
                        'liability' => $row->liability,
                        'price' => '$ ' . number_format($row->price, 0, ',', '.'),
                        'status' => $row->status,
                        'actions' => '<div class="bs-btn-group-section">
                            <button class="bs-btn-action bs-btn-delete" onClick="sectionAction(\'Nomina\',' . $row->id . ', \'delete\')"><i class="fas fa-trash-alt"></i></button>
                            <button class="bs-btn-action bs-btn-edit" onClick="requestEditData(\'Nomina\',' . $row->id . ')"><i class="fas fa-edit"></i></button>
                            <button class="bs-btn-action bs-btn-active" onClick="sectionAction(\'Nomina\',' . $row->id . ', \'active\')"><i class="fas fa-plus"></i></button>
                            <button class="bs-btn-action bs-btn-warning" onClick="sectionAction(\'Nomina\',' . $row->id . ', \'pay\')"><i class="fas fa-dollar-sign"></i></button>
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
