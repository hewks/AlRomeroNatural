<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Sells extends Model_Genetic
{
    protected $tab = 'sells_register';
    protected $cells = ['id', 'user_id', 'products_id', 'total_price', 'discount', 'created_at', 'products_quantity'];
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
                        'user' => $row->user_id,
                        'products' => $row->products_id,
                        'quantity' => $row->products_quantity,
                        'price' => '$ ' . number_format($row->total_price, 0, ',', '.'),
                        'discount' => '% ' . $row->discount,
                        'date' => '$ ' . $row->created_at,
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
