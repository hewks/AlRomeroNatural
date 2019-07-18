<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Service extends Model_Genetic
{

    protected $tab = 'service_register';
    protected $cells = ['id', 'service', 'price', 'status'];
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
                        'service' => $row->service,
                        'price' => '$ ' . number_format($row->price, 0, ',', '.'),
                        'status' => $row->status,
                        'actions' => '<div class="bs-btn-group-section">
                            <button class="bs-btn-action bs-btn-delete" onClick="sectionAction(\'Servicios\',' . $row->id . ', \'delete\')"><i class="fas fa-trash-alt"></i></button>
                            <button class="bs-btn-action bs-btn-edit" onClick="requestEditData(\'Servicios\',' . $row->id . ')"><i class="fas fa-edit"></i></button>
                            <button class="bs-btn-action bs-btn-active" onClick="sectionAction(\'Servicios\',' . $row->id . ', \'active\')"><i class="fas fa-plus"></i></button>
                            <button class="bs-btn-action bs-btn-warning" onClick="sectionAction(\'Servicios\',' . $row->id . ', \'pay\')"><i class="fas fa-dollar-sign"></i></button>
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
