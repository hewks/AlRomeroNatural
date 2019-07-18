<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Product extends Model_Genetic
{

    protected $tab = 'product_register';
    protected $cells = ['id', 'product_name','category_id', 'price', 'discount', 'last_buy', 'stock', 'short_description', 'large_description', 'image_url', 'status'];
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
                        'product' => $row->product_name,
                        'category' => $row->category_id,
                        'price' => '$ ' . number_format($row->price, 0, ',', '.'),
                        'lastBuy' => '$ ' . number_format($row->last_buy, 0, ',', '.'),
                        'discount' => '% ' . $row->discount,
                        'stock' => $row->stock,
                        'status' => $row->status,
                        'actions' => '<div class="bs-btn-group-section">
                            <button class="bs-btn-action bs-btn-delete" onClick="sectionAction(\'Productos\',' . $row->id . ', \'delete\')"><i class="fas fa-trash-alt"></i></button>
                            <button class="bs-btn-action bs-btn-edit" onClick="requestEditData(\'Productos\',' . $row->id . ')"><i class="fas fa-edit"></i></button>
                            <button class="bs-btn-action bs-btn-active" onClick="sectionAction(\'Productos\',' . $row->id . ', \'active\')"><i class="fas fa-plus"></i></button>
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
