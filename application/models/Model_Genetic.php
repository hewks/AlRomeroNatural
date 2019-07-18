<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Genetic extends CI_Model
{
    // New Version
    function construct_principal_select($cells)
    {
        // from ['cell_1','cell_2','cell_3'...]
        // to 'cell_1,cell_2,cell_3...'
        $select = '';
        foreach ($cells as $key => $cell) {
            if ($key < count($cells)) {
                $select .= $cell . ',';
            } else {
                $select .= $cell;
            }
        }
        return $select;
    }

    function search_with_in($search)
    {
        // $search = array(
        //     'search' => 'email',
        //     'output' => 'id,username,email',
        //     'value' => 'storreso@me.co',
        $this->db->from($this->tab);
        $this->db->select($search['output']);
        $this->db->where($search['search'], $search['value']);
        $query = $this->db->get()->row();
        return ($query) ? $query : false;
    }

    function bool_search_with($search)
    {
        // $search = array(
        //     'search' => 'email',
        //     'output' => 'id',
        //     'value' => 'storreso@me.co',
        $this->db->from($this->tab);
        $this->db->select($search['output']);
        $this->db->where($search['search'], $search['value']);
        $query = $this->db->get()->row();
        return ($query) ? true : false;
    }

    function create($new_data)
    {
        // $new_data format
        // depends the table
        return ($this->db->insert($this->tab, $new_data)) ? true : false;
    }

    function update_with_id($edit_data)
    {
        // $edit_data format
        // depends the table
        $this->db->where('id', $edit_data['id']);
        return ($this->db->update($this->tab, $edit_data)) ? true : false;
    }

    // Past Version
    function create_select()
    {
        $select = '';
        foreach ($this->cells as $index => $cell) {
            $select .= ($index < count($this->cells) - 1) ? $cell . ',' : $cell;
        }
        return $select;
    }

    function create_custom($new_data, $table)
    {
        return ($this->db->insert($table, $new_data)) ? true : false;
    }

    function search_by($by, $search)
    {
        $this->db->select($by);
        $this->db->from($this->tab);
        $this->db->where($by, $search);
        return ($this->db->get()->row()) ? true : false;
    }

    function search_custom($search_select, $table)
    {
        $this->db->select($search_select);
        $this->db->from($table);
        $query = $this->db->get()->result();
        return ($query) ? $query : false;
    }

    function search_data_where($data, $where)
    {
        $this->db->select($data);
        $this->db->from($this->tab);
        $this->db->where($where);
        $query = $this->db->get()->row();
        return ($query) ? $query : false;
    }

    function validate($login_data, $by = 'id')
    {
        $this->db->select($by);
        $this->db->from($this->tab);
        $this->db->where($login_data);
        return ($this->db->get()->row()) ? true : false;
    }

    function delete($id)
    {
        $update_data = array(
            'status' => 0,
            'updated_at' => date('Y-m-d H-i-s')
        );
        $this->db->where('id', $id);
        return ($this->db->update($this->tab, $update_data)) ? true : false;
    }

    function active($id)
    {
        $update_data = array(
            'status' => 1,
            'updated_at' => date('Y-m-d H-i-s')
        );
        $this->db->where('id', $id);
        return ($this->db->update($this->tab, $update_data)) ? true : false;
    }

    function one($id)
    {
        $this->db->select($this->select);
        $this->db->from($this->tab);
        $this->db->where('id', $id);
        $query = $this->db->get()->row();
        return ($query) ? $query : false;
    }

    function edit($edit_data)
    {
        $this->db->where('id', $edit_data['id']);
        return ($this->db->update($this->tab, $edit_data)) ? true : false;
    }

    function chart_data_request($table, $data, $time)
    {
        $month = date('m');
        $year = date('Y');
        $day = date('d');

        $this->db->select($data);
        $this->db->from($table);

        switch ($time) {
            case 'year':
                $this->db->where('YEAR(created_at) = ' . $year);
                break;
            case 'month':
                $this->db->where('MONTH(created_at) = ' . $month . ' AND YEAR(created_at) = ' . $year);
                break;
            case 'day':
                $this->db->where('DAY(created_at) = ' . $day . ' AND MONTH(created_at) = ' . $month . ' AND YEAR(created_at) = ' . $year);
                break;
        }

        $query = $this->db->get()->result();
        return ($query) ? (array) $query : false;
    }

    function get_payment_date($id)
    {
        $this->db->select('payed_date');
        $this->db->from($this->tab);
        $this->db->where('id', $id);
        $query = $this->db->get()->row()->payed_date;
        return ($query) ? $query : false;
    }

    function get_payment($id, $cell)
    {
        $this->db->select($cell);
        $this->db->from($this->tab);
        $this->db->where('id', $id);
        $query = $this->db->get()->row();
        $query = $query->price;
        return ($query) ? $query : false;
    }

    function change_payment_status($id)
    {
        $update_data = array(
            'payed_date' => date('Y-m-d H-i-s')
        );
        $this->db->where('id', $id);
        return ($this->db->update($this->tab, $update_data)) ? true : false;
    }

    function search_product_stock($product)
    {
        $this->db->select('stock');
        $this->db->from('product_register');
        $this->db->where('id', $product);
        $query = $this->db->get()->row();
        return ($query) ? $query->stock : false;
    }

    function change_product_stock($product, $type, $quantity)
    {
        $old_stock = $this->search_product_stock($product);
        switch ($type) {
            case 'buy':
                $update_data = array('stock' => $old_stock + $quantity);
                $this->db->where('id', $product);
                return ($this->db->update('product_register', $update_data)) ? true : false;
                break;
            case 'sell':
                if ($old_stock >= $quantity) {
                    $update_data = array('stock' => $old_stock - $quantity);
                    $this->db->where('id', $product);
                    return ($this->db->update('product_register', $update_data)) ? true : false;
                }
                break;
        }
    }

    function change_product_last_buy($product, $new_last_buy)
    {
        $update_data = array('last_buy' => $new_last_buy);
        $this->db->where('id', $product);
        return ($this->db->update('product_register', $update_data)) ? true : false;
    }

}
