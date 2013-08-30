<?php

/*
 * Billing Model Class
 */

Class Billing_model extends MY_Model
{
    
    public $_table = 'bill';
    
    function getAll($offset = 0, $limit = 0, $keyword = '') {
        
        if($keyword != '') {
            $this->db->like('id', $keyword);
            $this->db->or_like('jobsheet_id', $keyword);
            $this->db->or_like('name', $keyword);
            $this->db->or_like('reg_no', $keyword);
            $this->db->or_like('chassis_no', $keyword);
        }
        $this->db->order_by("bill_date", "desc");
        if($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        $data = $this->db->get($this->_table);
        return $data->result_array();
    }
    
    function getCount($keyword)
    {
        if($keyword != '') {
            $this->db->like('id', $keyword);
            $this->db->or_like('jobsheet_id', $keyword);
            $this->db->or_like('name', $keyword);
            $this->db->or_like('reg_no', $keyword);
            $this->db->or_like('chassis_no', $keyword);
        }
        $this->db->from($this->_table);
        return $this->db->count_all_results();
        
    }
    
    function getTotal($keyword)
    {
        $this->db->select('SUM(grand_total) as total');
        if($keyword != '') {
            $this->db->like('id', $keyword);
            $this->db->or_like('jobsheet_id', $keyword);
            $this->db->or_like('name', $keyword);
            $this->db->or_like('reg_no', $keyword);
            $this->db->or_like('chassis_no', $keyword);
        }
        $query = $this->db->get($this->_table);
        $data = $query->row_array();
        return $data['total'];
        
    }
    
    
}
?>
