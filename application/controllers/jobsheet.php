<?php

/**
 * Jobsheet controller
 */

session_start(); //we need to call PHP's session object to access it through CI
class Jobsheet extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('jobsheet_model');
    }

    function index()
    {
        $userData = parent::requireLogin();
        $data['username'] = $userData['username'];
        
        $offset = $this->uri->segment(3, 1);
        $keyword = $this->input->get('search');
        
        $data['title'] = 'Jobsheet';
        $data['tab'] = 'Jobsheet';
        
        $this->config->load('ap_settings');
        $limit = $this->config->item('records_per_page');
        
        $jobsheets = $this->jobsheet_model->getAll(($offset-1)*$limit, $limit, $keyword);
        foreach($jobsheets as $key => $jobsheet) {
            $jobsheets[$key]['labour_count'] = count($this->jobsheet_model->getLabourCharges($jobsheet['id']));
            $jobsheets[$key]['parts_count'] = count($this->jobsheet_model->getJobsheetParts($jobsheet['id']));
        }        
        $data['jobsheets'] = $jobsheets;
        $data['keyword'] = $keyword;
        
        $this->load->library('pagination');
        $config['base_url'] = base_url(). 'index.php/jobsheet/page';
        $config['total_rows'] = $this->jobsheet_model->getCount($keyword);
        $config['per_page'] = $limit;        
        $this->pagination->initialize($config);
        $this->load->helper('form');
        
        $this->load->view('templates/header', $data);
        $this->load->view('jobsheet/jobsheet_view', $data);
        $this->load->view('templates/footer');
    }
    
    function search()
    {
        $keyword = $this->input->post('search');
        
        redirect('jobsheet/page/1?search='.$keyword);
    }
    
    function delete($id)
    {
        $userData = parent::requireLogin();
        
        if($userData['username'] != 'admin') {
            redirect('jobsheet', 'refresh');
        } else {        
            $success = $this->jobsheet_model->delete($id);
        }
        
        if($success) {
            echo 1;
        } else {
            echo 0;
        }
    }    
    
    function update($id)
    {
        $data = $this->input->post('data');
        $this->jobsheet_model->update($id, $data);
    }
    
    function create()
    {
        parent::requireLogin();
        
        $this->load->helper('form');
        $this->load->library('form_validation');     
        $this->load->model('staff_model');
        $this->load->model('part_model');
        
        $this->form_validation->set_error_delimiters('<div class="red">', '</div>');
        $data['title'] = 'Create Jobsheet';
        $data['tab'] = 'Jobsheet';
        $data['formName'] = 'jobsheet/create';
        
        $jobtypeList = array('' => 'Select Jobtype');
        $jobtypes = $this->jobsheet_model->getAllJobtypes();
        foreach($jobtypes as $jobtype) {
            $jobtypeList[$jobtype['id']] = $jobtype['type'];            
        }
        $data['jobtypes'] = $jobtypeList;
        
        $staffList = array('' => 'Select Staff');
        $staffs = $this->staff_model->getAll();
        foreach($staffs as $staff) {
            $staffList[$staff['id']] = $staff['name'];            
        }
        $data['staffs'] = $staffList;
        
        $partsList = array('' => 'Select Part');
        $parts = $this->part_model->getAll();
        foreach($parts as $part) {
            $partsList[$part['id']] = $this->getPartNameForAutoComplete($part);
        }
        $data['parts'] = $partsList;
        
        $data['jobsheet'] = array(
            "id" => '',
            "name" => '',
            "address" => '',
            "contact" => '',
            "created_on" => date('d/m/Y'),
            "reg_no" => '',
            "mileage" => '',
            "chassis_no" => '',
            "engine_no" => '',
            "promised_date" => '',
            "delivered_date" => '',
            "estimated_amount" => '',
            "status" => '',
            "notes" => ''
        );
        
        $this->form_validation->set_message('alpha_space', 
                'The %s field may only contain alphabetic and space characters.');
        $this->form_validation->set_message('registration_check', 
                'The %s field may only contain alpha-numeric characters and dashes.');
        
        $this->config->load('form_validation');
        $config = $this->config->item('jobsheet_form');
        
        $config[] = array(
            'field' => "delivered_date",
            'label' => "Delivered Date",
            'rules' => "delivered_date_check[".$this->input->post('created_on')."]"
        );
        
        $this->form_validation->set_message('delivered_date_check', 
                'The %s should be greater than Jobsheet Date.');
        
        $labourInput = $this->input->post('labour_charges');
        if(!empty($labourInput)) 
        {
            $data['jobsheet']['labour_charges'] = $labourInput;
            foreach(array_keys($labourInput) as $key) 
            {
                $config[] = array(
                    'field' => "labour_charges[$key][job_type]",
                    'label' => "Job Type",
                    'rules' => "required"
                );
                $config[] = array(
                    'field' => "labour_charges[$key][staff]",
                    'label' => "Staff",
                    'rules' => "required"
                );
                $config[] = array(
                    'field' => "labour_charges[$key][amount]",
                    'label' => "Labour Amount",
                    'rules' => "required|numeric"
                );
            }
        }        
        
        $partsInput = $this->input->post('jobsheet_parts');
        if(!empty($partsInput)) 
        {
            $data['jobsheet']['jobsheet_parts'] = $partsInput;
            foreach(array_keys($partsInput) as $key) 
            {
                $stock = $this->part_model->getStock($partsInput[$key]['part_id']) + 1;
                $config[] = array(
                    'field' => "jobsheet_parts[$key][part_id]",
                    'label' => "Parts Name",
                    'rules' => "required"
                );
                $config[] = array(
                    'field' => "jobsheet_parts[$key][qty]",
                    'label' => "Quantity".(isset($partsInput[$key]['part_id']) 
                        ? ' for "'. $partsList[$partsInput[$key]['part_id']]. '" ' : '' ),
                    'rules' => "required|numeric|less_than[$stock]"
                );
            }
        }        
        
        $this->form_validation->set_rules($config);
        
        if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('templates/header', $data);
            $this->load->view('jobsheet/jobsheet_form', $data);
            $this->load->view('templates/footer');
            
		} else {
            $data = array(
                "name" => $this->input->post('name'),
                "address" => $this->input->post('address'),
                "contact" => $this->input->post('contact'),
                "created_on" => 
                    date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('created_on')))),
                "reg_no" => $this->input->post('reg_no'),
                "mileage" => round($this->input->post('mileage'),2),
                "chassis_no" => $this->input->post('chassis_no'),
                "engine_no" => $this->input->post('engine_no'),
                "promised_date" => 
                    date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('promised_date')))),
                "delivered_date" => 
                ($this->input->post('delivered_date') != '')
                    ? date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('delivered_date'))))
                    : NULL,
                "estimated_amount" => 
                    round($this->input->post('estimated_amount'),2),
                "status" => 'open',
                "notes" => $this->input->post('notes')
            );
            
            $this->jobsheet_model->create($data);
            $jobsheetId = $this->db->insert_id();
            
            if($jobsheetId) {
                // Update Labour charges
                if(!empty($labourInput)) {
                    $this->jobsheet_model->updateJobsheetCharges($jobsheetId, $labourInput);
                }

                // Update Jobsheet Parts
                if(!empty($partsInput)) {
                    $this->jobsheet_model->updateJobsheetParts($jobsheetId, $partsInput);
                }
            }            
            
            redirect('jobsheet', 'refresh');
        }
        
        
    }
    
    function view($id)
    {
        parent::requireLogin();
        
        $this->load->model('staff_model');
        $this->load->model('part_model');
        $this->load->helper('text');
        
        $data['title'] = 'Jobsheet Summary';
        $data['tab'] = 'Jobsheet';        
        
        $data['jobsheet'] = $this->jobsheet_model->get($id);
        $data['jobsheet']['labour_charges'] = $this->jobsheet_model->getLabourCharges($id);
        $data['jobsheet']['jobsheet_parts'] = $this->jobsheet_model->getJobsheetParts($id);
        
        $jobtypeList = array('' => 'Select Jobtype');
        $jobtypes = $this->jobsheet_model->getAllJobtypes();
        foreach($jobtypes as $jobtype) {
            $jobtypeList[$jobtype['id']] = $jobtype['type'];            
        }
        $data['jobtypes'] = $jobtypeList;
        
        $staffList = array('' => 'Select Staff');
        $staffs = $this->staff_model->getAll();
        foreach($staffs as $staff) {
            $staffList[$staff['id']] = $staff['name'];            
        }
        $data['staffs'] = $staffList;
        
        $partsList = array('' => 'Select Part');
        $parts = $this->part_model->getAll();
        foreach($parts as $part) {
            $partsList[$part['id']] = $this->getPartNameForAutoComplete($part);
        }
        $data['parts'] = $partsList;
        
        $this->load->view('templates/header', $data);
        $this->load->view('jobsheet/jobsheet_summary', $data);
        $this->load->view('templates/footer');        
        
    }
    
    function edit($id)
    {
        parent::requireLogin();
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('staff_model');
        $this->load->model('part_model');
        
        $data['jobsheet'] = $this->jobsheet_model->get($id);
        if($data['jobsheet']['status'] == 'complete' || $data['jobsheet']['status'] == 'close') {
            redirect('jobsheet/view/'.$id);
        }
        
        $this->form_validation->set_error_delimiters('<div class="red">', '</div>');
        $data['title'] = 'Edit Jobsheet';
        $data['tab'] = 'Jobsheet';
        $data['formName'] = 'jobsheet/edit/'.$id;        
        $data['jobsheet'] = $this->jobsheet_model->get($id);
        $data['jobsheet']['created_on'] = date('d/m/Y', strtotime($data['jobsheet']['created_on']));
        $data['jobsheet']['promised_date'] = date('d/m/Y', strtotime($data['jobsheet']['promised_date']));
        $data['jobsheet']['delivered_date'] = 
                (!empty($data['jobsheet']['delivered_date'])) 
                ? date('d/m/Y', strtotime($data['jobsheet']['delivered_date'])) 
                : '';
        $data['jobsheet']['labour_charges'] = $this->jobsheet_model->getLabourCharges($id);
        $data['jobsheet']['jobsheet_parts'] = $this->jobsheet_model->getJobsheetParts($id);
        
        $jobtypeList = array('' => 'Select Jobtype');
        $jobtypes = $this->jobsheet_model->getAllJobtypes();
        foreach($jobtypes as $jobtype) {
            $jobtypeList[$jobtype['id']] = $jobtype['type'];            
        }
        $data['jobtypes'] = $jobtypeList;
        
        $staffList = array('' => 'Select Staff');
        $staffs = $this->staff_model->getAll();
        foreach($staffs as $staff) {
            $staffList[$staff['id']] = $staff['name'];            
        }
        $data['staffs'] = $staffList;
        
        $partsList = array('' => 'Select Part');
        $parts = $this->part_model->getAll();
        foreach($parts as $part) {
            $partsList[$part['id']] = $this->getPartNameForAutoComplete($part);
        }
        $data['parts'] = $partsList;
        
        $this->form_validation->set_message('alpha_space', 
                'The %s field may only contain alphabetic and space characters.');
        $this->form_validation->set_message('registration_check', 
                'The %s field may only contain alpha-numeric characters and dashes.');
        
        $this->config->load('form_validation');
        $config = $this->config->item('jobsheet_form');
        
        $config[] = array(
            'field' => "delivered_date",
            'label' => "Delivered Date",
            'rules' => "delivered_date_check[".$this->input->post('created_on')."]"
        );
        
        $this->form_validation->set_message('delivered_date_check', 
                'The %s should be greater than Jobsheet Date.');
        
        $labourInput = $this->input->post('labour_charges');
        if(!empty($labourInput)) 
        {
            $data['jobsheet']['labour_charges'] = $labourInput;
            foreach(array_keys($labourInput) as $key) 
            {
                $config[] = array(
                    'field' => "labour_charges[$key][job_type]",
                    'label' => "Job Type",
                    'rules' => "required"
                );
                $config[] = array(
                    'field' => "labour_charges[$key][staff]",
                    'label' => "Staff",
                    'rules' => "required"
                );
                $config[] = array(
                    'field' => "labour_charges[$key][amount]",
                    'label' => "Labour Amount",
                    'rules' => "required|numeric"
                );                
            }
        }
        
        $partsInput = $this->input->post('jobsheet_parts');
        if(!empty($partsInput)) 
        {
            $data['jobsheet']['jobsheet_parts'] = $partsInput;
            foreach(array_keys($partsInput) as $key) 
            {
                $stock = $this->part_model->getStock($partsInput[$key]['part_id']) 
                        + $this->jobsheet_model->getPartsCount($id, $partsInput[$key]['part_id'])
                        + 1;
                $config[] = array(
                    'field' => "jobsheet_parts[$key][part_id]",
                    'label' => "Parts Name",
                    'rules' => "required"
                );
                $config[] = array(
                    'field' => "jobsheet_parts[$key][qty]",
                    'label' => "Quantity".(isset($partsInput[$key]['part_id']) 
                        ? ' for "'. $partsList[$partsInput[$key]['part_id']]. '" ' : '' ),
                    'rules' => "required|numeric|less_than[$stock]"
                );
            }
        }
        
        
        $this->form_validation->set_rules($config);
        
        if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('templates/header', $data);
            $this->load->view('jobsheet/jobsheet_form', $data);
            $this->load->view('templates/footer');
            
		} else {
            
            $data = array(
                "name" => $this->input->post('name'),
                "address" => $this->input->post('address'),
                "contact" => $this->input->post('contact'),
                "created_on" => 
                    date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('created_on')))),
                "reg_no" => $this->input->post('reg_no'),
                "mileage" => round($this->input->post('mileage'),2),
                "chassis_no" => $this->input->post('chassis_no'),
                "engine_no" => $this->input->post('engine_no'),
                "promised_date" => 
                    date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('promised_date')))),
                "delivered_date" => 
                    ($this->input->post('delivered_date') != '')
                    ? date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('delivered_date'))))
                    : NULL,
                "estimated_amount" => 
                    round($this->input->post('estimated_amount'),2),
                "status" => $this->input->post('status'),
                "notes" => $this->input->post('notes')
            );
            
            $this->jobsheet_model->update($id, $data);
            $this->jobsheet_model->updateJobsheetCharges($id, $labourInput);
            $this->jobsheet_model->updateJobsheetParts($id, $partsInput);
            
            redirect('jobsheet', 'refresh');
        }
        
    }

    function getPartNameForAutoComplete($part) {

        $formattedName = $part['part_name'];

        if(!empty($part['part_no'])) {
            $formattedName = $part['part_no'] . ' - ' . $formattedName;
        }

        if(!empty($part['hsn_code'])) {
            $formattedName = $formattedName . ' [' . $part['hsn_code'] . ']';
        }

        return $formattedName;
    }

}

?>