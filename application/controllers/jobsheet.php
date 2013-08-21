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
        parent::requireLogin();   
        
        $offset = $this->uri->segment(3, 1);
        $keyword = $this->input->get('search');
        
        $data['title'] = 'Jobsheet';
        $data['tab'] = 'Jobsheet';
        $limit = 10;
        $data['jobsheets'] = $this->jobsheet_model->getAll(($offset-1)*$limit, $limit, $keyword);
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
        parent::requireLogin();
        
        $this->jobsheet_model->delete($id);
        
        redirect('jobsheet', 'refresh');
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
        
        $this->form_validation->set_error_delimiters('<div class="red">', '</div>');
        $data['title'] = 'Create Jobsheet';
        $data['tab'] = 'Jobsheet';
        $data['formName'] = 'jobsheet/create';
        
        $jobtypeList = array('' => 'Select');
        $jobtypes = $this->jobsheet_model->getAllJobtypes();
        foreach($jobtypes as $jobtype) {
            $jobtypeList[$jobtype['id']] = $jobtype['type'];            
        }
        $data['jobtypes'] = $jobtypeList;
        
        $staffList = array('' => 'Select');
        $staffs = $this->staff_model->getAll();
        foreach($staffs as $staff) {
            $staffList[$staff['id']] = $staff['name'];            
        }
        $data['staffs'] = $staffList;
        
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
            "estimated_amount" => '',
            "status" => '',
            "notes" => ''
        );
        
        $this->form_validation->set_message('alpha_space', 
                'The %s field may only contain alphabetic and space characters.');
        $this->form_validation->set_message('registration_check', 
                'The %s field may only contain alpha-numeric characters and dashes.');
        
        if ($this->form_validation->run('jobsheet_form') == FALSE)
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
                "estimated_amount" => 
                    round($this->input->post('estimated_amount'),2),
                "status" => $this->input->post('status'),
                "notes" => $this->input->post('notes')
            );
            
            $this->jobsheet_model->create($data);
            
            redirect('jobsheet', 'refresh');
        }
        
        
    }
    
    function edit($id)
    {
        parent::requireLogin();
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('staff_model');
        
        $this->form_validation->set_error_delimiters('<div class="red">', '</div>');
        $data['title'] = 'Edit Jobsheet';
        $data['tab'] = 'Jobsheet';
        $data['formName'] = 'jobsheet/edit/'.$id;        
        $data['jobsheet'] = $this->jobsheet_model->get($id);
        $data['jobsheet']['created_on'] = date('d/m/Y', strtotime($data['jobsheet']['created_on']));
        $data['jobsheet']['promised_date'] = date('d/m/Y', strtotime($data['jobsheet']['promised_date']));
        $data['jobsheet']['labour_charges'] = $this->jobsheet_model->getLabourCharges($id);
        
        $jobtypeList = array('' => 'Select');
        $jobtypes = $this->jobsheet_model->getAllJobtypes();
        foreach($jobtypes as $jobtype) {
            $jobtypeList[$jobtype['id']] = $jobtype['type'];            
        }
        $data['jobtypes'] = $jobtypeList;
        
        $staffList = array('' => 'Select');
        $staffs = $this->staff_model->getAll();
        foreach($staffs as $staff) {
            $staffList[$staff['id']] = $staff['name'];            
        }
        $data['staffs'] = $staffList;
        
        $this->form_validation->set_message('alpha_space', 
                'The %s field may only contain alphabetic and space characters.');
        $this->form_validation->set_message('registration_check', 
                'The %s field may only contain alpha-numeric characters and dashes.');
        
        if ($this->form_validation->run('jobsheet_form') == FALSE)
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
                "estimated_amount" => 
                    round($this->input->post('estimated_amount'),2),
                "status" => $this->input->post('status'),
                "notes" => $this->input->post('notes')
            );
            
            $this->jobsheet_model->update($id, $data);
            
            redirect('jobsheet', 'refresh');
        }
        
    }

}

?>