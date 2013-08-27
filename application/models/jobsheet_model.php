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
            $this->db->or_like('chassis_no', $keyword);
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
    
    function getLabourCharges($jobsheetId)
    {
        $data = $this->db->get_where('jobsheet_charges', array('jobsheet_id' => $jobsheetId));
        return $data->result_array();
    }
    
    function getJobsheetParts($jobsheetId)
    {
        $data = $this->db->get_where('jobsheet_parts', array('jobsheet_id' => $jobsheetId));
        return $data->result_array();
    }
    
    function getAllJobtypes()
    {
        $data = $this->db->get('job_types');
        return $data->result_array();
    }
    
    function updateJobsheetCharges($jobsheetId, $labourData)
    {
        $this->db->delete('jobsheet_charges', array('jobsheet_id' => $jobsheetId));
        
        foreach($labourData as $labour) {
            $data = array(
                'jobsheet_id' => $jobsheetId,
                'staff' => $labour['staff'],
                'job_type' => $labour['job_type'],
                'amount' => $labour['amount']
            );
            
            $this->db->insert('jobsheet_charges', $data);
        }
    }
    
    function updateJobsheetParts($jobsheetId, $partsData)
    {
        $this->deleteJobsheetParts($jobsheetId);
        
        foreach($partsData as $part) {
            
            // Assign parts to Jobsheet
            $data = array(
                'jobsheet_id' => $jobsheetId,
                'part_id' => $part['part_id'],
                'qty' => $part['qty']
            );            
            $this->db->insert('jobsheet_parts', $data);
            
            // Minus from existing stock
            $this->db->where('part_id', $part['part_id']);
            $this->db->set('quantity', "quantity - ".$part['qty'], FALSE);
            $this->db->update('parts_stock');
        }
    }
    
    function deleteJobsheetParts($jobsheetId) 
    {
        $this->db->select('jobsheet_id, parts.id, qty, quantity as stock');
        $this->db->from('jobsheet_parts');
        $this->db->join('parts', 'parts.id = jobsheet_parts.part_id', 'left');
        $this->db->join('parts_stock', 'parts_stock.part_id = parts.id', 'left');
        $this->db->where('jobsheet_parts.jobsheet_id', $jobsheetId);
        $query = $this->db->get();
        $data = $query->result_array();
        
        // Add parts to existing stock
        foreach($data as $partsData) {
            $updateData = array(
                'quantity' => $partsData['stock'] + $partsData['qty']
            );
            $this->db->where('part_id', $partsData['id']);            
            $this->db->update('parts_stock', $updateData);            
        }
        
        // Delete Jobsheet Parts
        $this->db->where('jobsheet_id', $jobsheetId);
        $this->db->delete('jobsheet_parts');
        
    }
    
    function getPartsCount($id, $partId)
    {
        $this->db->where('part_id', $partId);
        $this->db->where('jobsheet_id', $id);
        $query = $this->db->get('jobsheet_parts');
        $data = $query->row_array();
        if(isset($data['qty'])) {
            return $data['qty'];
        }
        
        return 0;
    }
    
}
?>
