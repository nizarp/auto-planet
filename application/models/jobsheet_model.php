<?php

/*
 * Jobsheet Model Class
 */

Class Jobsheet_model extends MY_Model
{
    
    public $_table = 'jobsheets';

    function getAll($offset = 0, $limit = 0, $keyword = '') {
        
        if($keyword != '') {
            $this->db->like('name', $keyword);
            $this->db->or_like('reg_no', $keyword);
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
            $this->db->like('name', $keyword);
            $this->db->or_like('reg_no', $keyword);
        }
        $this->db->from($this->_table);
        return $this->db->count_all_results();
        
    }    
    
}
?>
