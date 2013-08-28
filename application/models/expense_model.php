<?php

/*
 * Expense Model Class
 */

Class Expense_model extends MY_Model
{
    
    public $_table = 'expenses';
    
    function getAll($offset = 0, $limit = 0, $keyword = '') {
        
        if($keyword != '') {
            list($startDate, $endDate) = explode('__', $keyword);
            if($startDate != '') {
                $this->db->where('created_on >=', $startDate);
            }
            if($endDate != '') {
                $this->db->where('created_on <=', $endDate);
            }
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
            list($startDate, $endDate) = explode('__', $keyword);
            if($startDate != '') {
                $this->db->where('created_on >=', $startDate);
            }
            if($endDate != '') {
                $this->db->where('created_on <=', $endDate);
            }
        }
        $this->db->from($this->_table);
        return $this->db->count_all_results();
        
    }
    
    function getTotal($keyword)
    {
        $this->db->select('SUM(amount) as sum');
        if($keyword != '') {
            list($startDate, $endDate) = explode('__', $keyword);
            if($startDate != '') {
                $this->db->where('created_on >=', $startDate);
            }
            if($endDate != '') {
                $this->db->where('created_on <=', $endDate);
            }
        }
        $query = $this->db->get($this->_table);
        $data = $query->row_array();
        return $data['sum'];
        
    }
    
    
}
?>
