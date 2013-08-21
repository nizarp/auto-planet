<?php

/*
 * Staff Model Class
 */

Class Staff_model extends MY_Model
{
    
    public $_table = 'staff';
    
    function getAll($offset = 0, $limit = 0, $keyword = '') {
        
        if($keyword != '') {
            $this->db->like('name', $keyword);
        }
        $this->db->order_by("name");
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
        }
        $this->db->from($this->_table);
        return $this->db->count_all_results();
        
    }
    
    function getAllRoles()
    {
        $query = $this->db->get('staff_roles');
        $roles = array();
        foreach ($query->result() as $row)
        {
            $roles[$row->id] = $row->role;
        }
        return $roles;
    }
    
}
?>
