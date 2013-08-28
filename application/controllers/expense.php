<?php

/**
 * Expense controller
 */

session_start(); //we need to call PHP's session object to access it through CI
class Expense extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('expense_model');
    }

    function index()
    {
        $userData = parent::requireLogin();
        $data['username'] = $userData['username']; 
        
        $offset = $this->uri->segment(3, 1);
        $keyword = $this->input->get('search');
        
        $data['title'] = 'Expense';
        $data['tab'] = 'Expense';
        $limit = 10;
        $data['expenses'] = $this->expense_model->getAll(($offset-1)*$limit, $limit, $keyword);
        $data['keyword'] = $keyword;
        $data['total'] = $this->expense_model->getTotal($keyword);
        
        $this->load->library('pagination');
        $config['base_url'] = base_url(). 'index.php/expense/page';
        $config['total_rows'] = $this->expense_model->getCount($keyword);
        $config['per_page'] = $limit;        
        $this->pagination->initialize($config);
        $this->load->helper('form');
        
        $this->load->view('templates/header', $data);
        $this->load->view('expense/expense_view', $data);
        $this->load->view('templates/footer');
    }
    
    function search()
    {
        $startDate = $this->input->post('start_date');
        $endDate = $this->input->post('end_date');

        if(strtotime(str_replace('/', '-', $startDate)) || strtotime(str_replace('/', '-', $endDate))) {
            $keyword = "";
            if(strtotime(str_replace('/', '-', $startDate))) {
                $keyword.= date('Y-m-d', strtotime(str_replace('/', '-', $startDate)));
            }
            $keyword.= '__';
            if(strtotime(str_replace('/', '-', $endDate))) {
                $keyword.= date('Y-m-d', strtotime(str_replace('/', '-', $endDate)));
            }
        } else {
            $keyword = '';
        }        
        
        redirect('expense/page/1?search='.$keyword);
    }
    
    function delete($id)
    {
        $userData = parent::requireLogin();
        
        if($userData['username'] != 'admin') {
            redirect('expense', 'refresh');
        } else {
            $this->expense_model->delete($id);
        }
        
        redirect('expense', 'refresh');
    }    
    
    function update($id)
    {
        parent::requireLogin();
        
        $data = $this->input->post('data');        
        $this->expense_model->update($id, $data);
    }
    
    function create()
    {
        parent::requireLogin();
        
        $this->load->helper('form');
        $this->load->library('form_validation');     
        $this->form_validation->set_error_delimiters('<div class="red">', '</div>');
        $data['title'] = 'Create Expense';
        $data['tab'] = 'Expense';
        $data['formName'] = 'expense/create';
        
        $data['expense'] = array(
            "id" => '',
            "purpose" => '',
            "amount" => '',
            "created_on" => date('d/m/Y'),
            "bill_no" => '',
            "notes" => ''
        );
        
        if ($this->form_validation->run('expense_form') == FALSE)
		{
			$this->load->view('templates/header', $data);
            $this->load->view('expense/expense_form', $data);
            $this->load->view('templates/footer');
            
		} else {
            $data = array(
                "purpose" => $this->input->post('purpose'),
                "amount" => $this->input->post('amount'),
                "created_on" => 
                    date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('created_on')))),
                "bill_no" => $this->input->post('bill_no'),
                "notes" => $this->input->post('notes')
            );
            
            $this->expense_model->create($data);
            
            redirect('expense', 'refresh');
        }
        
        
    }
    
    function edit($id)
    {
        parent::requireLogin();
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="red">', '</div>');
        $data['title'] = 'Edit Expense';
        $data['tab'] = 'Expense';
        $data['formName'] = 'expense/edit/'.$id;        
        $data['expense'] = $this->expense_model->get($id);
        $data['expense']['created_on'] = date('d/m/Y', strtotime($data['expense']['created_on']));
        
        if ($this->form_validation->run('expense_form') == FALSE)
		{
			$this->load->view('templates/header', $data);
            $this->load->view('expense/expense_form', $data);
            $this->load->view('templates/footer');
            
		} else {
            
            $data = array(
                "purpose" => $this->input->post('purpose'),
                "amount" => $this->input->post('amount'),
                "created_on" => 
                    date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('created_on')))),
                "bill_no" => $this->input->post('bill_no'),
                "notes" => $this->input->post('notes')
            );
            
            $this->expense_model->update($id, $data);
            
            redirect('expense', 'refresh');
        }
        
    }

}

?>