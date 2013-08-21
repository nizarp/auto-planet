<?php

/*
 * Custom Model Class
 */

Class MY_Model extends CI_Model
{
    
    protected $_table;

    function get($id)
    {
        $query = $this->db->get_where($this->_table, array('id' => $id));
        return $query->row_array();
    }
    
    function create($data)
    {
        return $this->db->insert($this->_table, $data);
    }
    
    function delete($id) 
    {
        return $this->db->delete($this->_table, array('id' => $id));
    }
    
    function update($id, $data)
    {
        return $this->db->update($this->_table, $data, array('id' => $id));
    }
    
    function getCount($keyword)
    {
        return $this->db->count_all_results($this->_table);        
    } 
    
}

?>
