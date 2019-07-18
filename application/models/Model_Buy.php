<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Buy extends Model_Genetic
{

    protected $tab = 'buy_register';
    protected $cells = ['id', 'ref', 'product_id', 'product_quantity', 'product_buy_price', 'total_price', 'user_id', 'created_at'];
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
                        'product' => $row->product_id,
                        'quantity' => $row->product_quantity,
                        'unity' => '$ ' . number_format($row->product_buy_price,0,',','.'),
                        'total' => '$ ' . number_format($row->total_price,0,',','.'),
                        'date' => $row->created_at,
                        'user' => $row->user_id
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
