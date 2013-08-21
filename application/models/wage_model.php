<?php

/*
 * Wage Model Class
 */

Class Wage_model extends MY_Model
{
    
    public $_table = 'wages';
    
    function getAll($offset = 0, $limit = 0, $keyword = '') {
        
        if($keyword != '') {
            $this->db->where('staff', $keyword);
        }
        $this->db->order_by("created_on", "desc");
        if($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        $data = $this->db->get($this->_table);
        return $data->result_array();
    }
    
    function getCount($keyword)
    {
        if($keyword != '') {
            $this->db->where('staff', $keyword);
        }
        $this->db->from($this->_table);
        return $this->db->count_all_results();
        
    }    
    
}
?>
