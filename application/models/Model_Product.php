<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Product extends Model_Genetic
{

    protected $tab = 'product_register';
    protected $cells = ['id', 'product_name', 'category_id', 'price', 'discount', 'last_buy', 'stock', 'short_description', 'large_description', 'fav', 'image_url', 'status'];
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
                        'fav' => $row->fav,
                        'status' => $row->status,
                        'actions' => '<div class="bs-btn-group-section">
                            <button class="bs-btn-action bs-btn-delete" onClick="sectionAction(\'Productos\',' . $row->id . ', \'delete\')"><i class="fas fa-trash-alt"></i></button>
                            <button class="bs-btn-action bs-btn-edit" onClick="requestEditData(\'Productos\',' . $row->id . ')"><i class="fas fa-edit"></i></button>
                            <button class="bs-btn-action bs-btn-active" onClick="sectionAction(\'Productos\',' . $row->id . ', \'active\')"><i class="fas fa-plus"></i></button>
                            <button class="bs-btn-action bs-btn-check" onClick="sectionAction(\'Productos\',' . $row->id . ', \'fav\')"><i class="fas fa-check"></i></button>
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

    function return_principal_products()
    {
        $this->db->from($this->tab);
        $this->db->select('product_name,price,short_description,image_url');
        $this->db->where('fav', 2);
        $query = $this->db->get()->result();
        return ($query) ? $query : array();
    }

    function return_fav($product)
    {
        $this->db->from($this->tab);
        $this->db->where('id', $product);
        $this->db->select('fav');
        $query = $this->db->get()->row();
        return ($query) ? $query->fav : false;
    }

    function change_fav($product)
    {
        $fav = ($this->return_fav($product) == '1') ? '2' : '1';
        $update_data = array(
            'fav' => $fav,
            'updated_at' => date('Y-m-d H-i-s')
        );
        $this->db->where('id', $product);
        $this->db->update($this->tab, $update_data);
        return ($fav == 2) ? true : false;
    }

    function search_product_data($product)
    {
        $this->db->from($this->tab);
        $this->db->select('product_name,id,price,stock,discount');
        $this->db->where('id', $product);
        $query = $this->db->get()->row();
        return ($query) ? (array) $query : false;
    }
}
