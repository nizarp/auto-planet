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
    
    function getPaymentModes()
    {
        $query = $this->db->get('payment_modes');
        $data = $query->result_array();
        
        $modes = array();
        foreach($data as $mode) {
            $modes[$mode['id']] = $mode['mode'];
        }
        
        return $modes;
    }
    
    function insertBillCharge($data)
    {
        return $this->db->insert('bill_charges', $data);
    }
    
    function insertBillParts($data)
    {
        $this->db->insert('bill_parts', $data);
    }
    
    function deleteBill($jobsheetId)
    {
        $this->db->select('id');
        $this->db->where(array('jobsheet_id' => $jobsheetId));
        $query = $this->db->get($this->_table);
        $data = $query->row_array();
        
        if(count($data) > 0) {            
            $billId = $data['id'];
            $this->db->delete($this->_table, array('id' => $billId));
            
            $this->db->delete('bill_charges', array('bill_id' => $billId));
            $this->db->delete('bill_parts', array('bill_id' => $billId));
        }     
    }
    
    function delete($id)
    {        
        $this->db->delete('bill_charges', array('bill_id' => $id));
        $this->db->delete('bill_parts', array('bill_id' => $id));
        return $this->db->delete($this->_table, array('id' => $id));
    }
    
}
?>
