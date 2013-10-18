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
        $userData = parent::requireLogin();
        $data['username'] = $userData['username'];
        
        $this->load->helper('text');
        $this->load->helper('array');
        $this->load->library('pagination');
        $this->load->model('staff_model');
        $this->load->helper('form');
        
        $offset = $this->uri->segment(3, 1);
        $keyword = $this->input->get('search');
        $data['keyword'] = $keyword;
        
        $data['title'] = 'Wage';
        $data['tab'] = 'Wage';
        
        $staffList = array('' => 'All');
        $staffs = $this->staff_model->getAll();
        foreach($staffs as $staff) {
            $staffList[$staff['id']] = $staff['name'];            
        }
        $data['staffs'] = $staffList;        
        
        if($keyword != '') {
            
            $thisMonth = date('Ym');
            $lastMonth = date('Ym', strtotime('last month'));
            
            $data['this_month_wages'] = $this->wage_model->getAllForMonth($keyword, $thisMonth);
            $data['thisMonthTotal'] = array_sum_by_key($data['this_month_wages'], 'amount');            
            $data['last_month_wages'] = $this->wage_model->getAllForMonth($keyword, $lastMonth);
            $data['lastMonthTotal'] = array_sum_by_key($data['last_month_wages'], 'amount');
            $data['earlier_month_wages'] = $this->wage_model->getAllBeforeMonth($keyword, $lastMonth);
            
            $data['salary'] = $this->staff_model->getSalary($keyword);
            
            $this->load->view('templates/header', $data);
            $this->load->view('wage/staff_wage_view', $data);
            $this->load->view('templates/footer');            
            
        } else {
            $this->config->load('ap_settings');
            $limit = $this->config->item('records_per_page');
            
            $data['wages'] = $this->wage_model->getAll(($offset-1)*$limit, $limit);            

            $config['base_url'] = base_url(). 'index.php/wage/page';
            $config['total_rows'] = $this->wage_model->getCount($keyword);
            $config['per_page'] = $limit;        
            $this->pagination->initialize($config);
            
            $this->load->view('templates/header', $data);
            $this->load->view('wage/wage_view', $data);
            $this->load->view('templates/footer');
        }        
        
    }
    
    function search()
    {
        $keyword = $this->input->post('search');
        
        redirect('wage/page/1?search='.$keyword);
    }
    
    function delete($id)
    {
        $userData = parent::requireLogin();
        
        if($userData['username'] != 'admin') {
            redirect('wage', 'refresh');
        } else {
            $success = $this->wage_model->delete($id);
        }
        
        if($success) {
            echo 1;
        } else {
            echo 0;
        }
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