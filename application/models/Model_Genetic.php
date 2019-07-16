<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Genetic extends CI_Model
{
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
}
