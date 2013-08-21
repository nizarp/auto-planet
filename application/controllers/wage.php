<?php

/**
 * Wage controller
 */

session_start(); //we need to call PHP's session object to access it through CI
class Wage extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('wage_model');
    }

    function index()
    {
        parent::requireLogin();   
        
        $this->load->helper('text');
        $this->load->library('pagination');
        $this->load->model('staff_model');
        $this->load->helper('form');
        
        $offset = $this->uri->segment(3, 1);
        $keyword = $this->input->get('search');
        
        $data['title'] = 'Wage';
        $data['tab'] = 'Wage';
        $limit = 10;
        $data['wages'] = $this->wage_model->getAll(($offset-1)*$limit, $limit, $keyword);
        $data['keyword'] = $keyword;
        
        $staffList = array('' => 'All');
        $staffs = $this->staff_model->getAll();
        foreach($staffs as $staff) {
            $staffList[$staff['id']] = $staff['name'];            
        }
        $data['staffs'] = $staffList;
        
        $config['base_url'] = base_url(). 'index.php/wage/page';
        $config['total_rows'] = $this->wage_model->getCount($keyword);
        $config['per_page'] = $limit;        
        $this->pagination->initialize($config);
        
        $this->load->view('templates/header', $data);
        $this->load->view('wage/wage_view', $data);
        $this->load->view('templates/footer');
    }
    
    function search()
    {
        $keyword = $this->input->post('search');
        
        redirect('wage/page/1?search='.$keyword);
    }
    
    function delete($id)
    {
        parent::requireLogin();
        
        $this->wage_model->delete($id);
        
        redirect('wage', 'refresh');
    }
    
    function create()
    {
        parent::requireLogin();
        
        $this->load->helper('form');
        $this->load->library('form_validation');     
        $this->form_validation->set_error_delimiters('<div class="red">', '</div>');
        $data['title'] = 'Add Wage';
        $data['tab'] = 'Wage';
        $data['formName'] = 'wage/create';
        
        $staffList = array('' => '-- Select --');
        $this->load->model('staff_model');
        $staffs = $this->staff_model->getAll();
        foreach($staffs as $staff) {
            $staffList[$staff['id']] = $staff['name'];            
        }
        $data['staffs'] = $staffList;
        
        $data['wage'] = array(
            "id" => '',            
            "amount" => '',
            "staff" => '',
            "description" => '',
            "created_on" => date('d/m/Y')
        );
        
        if ($this->form_validation->run('wage_form') == FALSE)
		{
			$this->load->view('templates/header', $data);
            $this->load->view('wage/wage_form', $data);
            $this->load->view('templates/footer');
            
		} else {
            $data = array(                
                "amount" => $this->input->post('amount'),
                "staff" => $this->input->post('staff'),
                "description" => $this->input->post('description'),
                "created_on" => 
                    date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('created_on'))))
            );
            
            $this->wage_model->create($data);
            
            redirect('wage', 'refresh');
        }
        
        
    }
    
    function edit($id)
    {
        parent::requireLogin();
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="red">', '</div>');
        $data['title'] = 'Edit Wage';
        $data['tab'] = 'Wage';
        $data['formName'] = 'wage/edit/'.$id;        
        $data['wage'] = $this->wage_model->get($id);
        $data['wage']['created_on'] = date('d/m/Y', strtotime($data['wage']['created_on']));
        
        $staffList = array('' => '-- Select --');
        $this->load->model('staff_model');
        $staffs = $this->staff_model->getAll();
        foreach($staffs as $staff) {
            $staffList[$staff['id']] = $staff['name'];            
        }
        $data['staffs'] = $staffList;
        
        if ($this->form_validation->run('wage_form') == FALSE)
		{
			$this->load->view('templates/header', $data);
            $this->load->view('wage/wage_form', $data);
            $this->load->view('templates/footer');
            
		} else {
            
            $data = array(                
                "amount" => $this->input->post('amount'),
                "staff" => $this->input->post('staff'),
                "description" => $this->input->post('description'),
                "created_on" => 
                    date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('created_on'))))
            );
            
            $this->wage_model->update($id, $data);
            
            redirect('wage', 'refresh');
        }
        
    }

}

?>