<?php

/*
 * Part Model Class
 */

Class Part_model extends MY_Model
{
    
    public $_table = 'parts';
    
    function getAll($offset = 0, $limit = 0, $keyword = '') {
        
        $this->db->select('parts.*');
        $this->db->from('parts');
        if($keyword != '') {
            $this->db->like('part_name', $keyword);
            $this->db->or_like('id', $keyword);
            $this->db->or_like('part_no', $keyword);
            $this->db->or_like('hsn_code', $keyword);
        }
        $this->db->order_by("part_name");
        if($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        $data = $this->db->get();
        return $data->result_array();
    }
    
    function getCount($keyword)
    {
        if($keyword != '') {
            $this->db->like('part_name', $keyword);
        }
        $this->db->from($this->_table);
        return $this->db->count_all_results();
        
    }
    
    function getStock($partId)
    {
        $query = $this->db->get_where('parts', array('id' => $partId));
        $data = $query->row_array();
        if(isset($data['quantity'])) {
            return $data['quantity'];
        }
        
        return 0;
    }
    
}
?>
