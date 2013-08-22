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
    
}
?>
