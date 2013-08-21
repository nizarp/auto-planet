<?php

/*
 * Part Model Class
 */

Class Part_model extends MY_Model
{
    
    public $_table = 'parts';
    
    function getAll($offset = 0, $limit = 0, $keyword = '') {
        
        $this->db->select('parts.*, parts_stock.quantity');
        $this->db->from('parts');
        $this->db->join('parts_stock', 'parts_stock.part_id = parts.id', 'left');
        if($keyword != '') {
            $this->db->like('name', $keyword);
        }
        $this->db->order_by("name");
        if($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        $data = $this->db->get();
        return $data->result_array();
    }
    
    function getCount($keyword)
    {
        if($keyword != '') {
            $this->db->like('name', $keyword);
        }
        $this->db->from($this->_table);
        return $this->db->count_all_results();
        
    }
    
}
?>
