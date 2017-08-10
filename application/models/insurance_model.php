<?php

/*
 * Insurance Model Class
 */

Class Insurance_model extends MY_Model
{
    
    public $_table = 'insurance';    
    
    function getAll()
    {

        $result = array();
        $query = $this->db->get('insurance');
        
        foreach ($query->result() as $row) {
            $result[] = $row;
        }

        return $result;
    }

    function getInsuranceData($id) {
        $query = $this->db->get_where('insurance', array('id' => $id));
        return $query->row_array();
    }
    
}
?>
