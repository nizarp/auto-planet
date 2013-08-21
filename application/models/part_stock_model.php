<?php

/*
 * Part Model Class
 */

Class Part_stock_model extends MY_Model
{
    
    public $_table = 'parts_stock';
    
    function getByPartID($partId) {
        $query = $this->db->get_where($this->_table, array('part_id' => $partId));
        return $query->row_array();
    }
    
}
?>
