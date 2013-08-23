<?php

/**
 * Staff controller
 */

session_start(); //we need to call PHP's session object to access it through CI
class Staff extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('staff_model');
    }

    function index()
    {
        $userData = parent::requireLogin();
        $data['username'] = $userData['username'];
        
        $offset = $this->uri->segment(3, 1);
        $keyword = $this->input->get('search');
        
        $data['title'] = 'Staff';
        $data['tab'] = 'Staff';
        $limit = 10;
        $data['staffs'] = $this->staff_model->getAll(($offset-1)*$limit, $limit, $keyword);
        $data['keyword'] = $keyword;
        
        $data['roles'] = $this->staff_model->getAllRoles();
        
        $this->load->library('pagination');
        $config['base_url'] = base_url(). 'index.php/staff/page';
        $config['total_rows'] = $this->staff_model->getCount($keyword);
        $config['per_page'] = $limit;        
        $this->pagination->initialize($config);
        $this->load->helper('form');
        
        $this->load->view('templates/header', $data);
        $this->load->view('staff/staff_view', $data);
        $this->load->view('templates/footer');
    }
    
    function search()
    {
        $keyword = $this->input->post('search');
        
        redirect('staff/page/1?search='.$keyword);
    }
    
    /*function delete($id)
    {
        $userData = parent::requireLogin();
        
        if($userData['username'] != 'admin') {
            redirect('staff', 'refresh');
        } else {
            $wages = $this->staff_mdel->getWages($id);
            if(count($wage) > 0) {
                redirect('staff?error=wage', 'refresh');
            }
            $this->staff_model->delete($id);
        }
        
        redirect('staff', 'refresh');
    }*/
    
    function create()
    {
        parent::requireLogin();
        
        $this->load->helper('form');
        $this->load->library('form_validation');     
        $this->form_validation->set_error_delimiters('<div class="red">', '</div>');
        $data['title'] = 'Create Staff';
        $data['tab'] = 'Staff';
        $data['formName'] = 'staff/create';
        
        $data['staff'] = array(
            "id" => '',
            "name" => '',
            "role" => '',
            "address" => '',
            "contact" => '',
            "email" => '',
            "notes" => ''
        );
        
        $data['roles'] = $this->staff_model->getAllRoles();
        
        if ($this->form_validation->run('staff_form') == FALSE)
		{
			$this->load->view('templates/header', $data);
            $this->load->view('staff/staff_form', $data);
            $this->load->view('templates/footer');
            
		} else {
            $data = array(
                "name" => $this->input->post('name'),
                "role" => $this->input->post('role'),
                "address" => $this->input->post('address'),
                "contact" => $this->input->post('contact'),
                "email" => $this->input->post('email'),
                "notes" => $this->input->post('notes'),
                "created_on" => date('Y-m-d')
            );
            
            $this->staff_model->create($data);
            
            redirect('staff', 'refresh');
        }
        
        
    }
    
    function edit($id)
    {
        parent::requireLogin();
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="red">', '</div>');
        $data['title'] = 'Edit Staff';
        $data['tab'] = 'Staff';
        $data['formName'] = 'staff/edit/'.$id;        
        $data['staff'] = $this->staff_model->get($id);
        
        $data['roles'] = $this->staff_model->getAllRoles();
        
        if ($this->form_validation->run('staff_form') == FALSE)
		{
			$this->load->view('templates/header', $data);
            $this->load->view('staff/staff_form', $data);
            $this->load->view('templates/footer');
            
		} else {
            
            $data = array(
                "name" => $this->input->post('name'),
                "role" => $this->input->post('role'),
                "address" => $this->input->post('address'),
                "contact" => $this->input->post('contact'),
                "email" => $this->input->post('email'),
                "notes" => $this->input->post('notes')
            );
            
            $this->staff_model->update($id, $data);
            
            redirect('staff', 'refresh');
        }
        
    }

}

?>