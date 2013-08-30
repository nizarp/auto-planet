<?php

/**
 * Billing controller
 */

session_start(); //we need to call PHP's session object to access it through CI
class Billing extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('billing_model');
    }

    function index()
    {
        $userData = parent::requireLogin();
        
        $this->load->model('jobsheet_model');
        $this->load->library('pagination');
        $this->load->helper('form');
        
        $data['username'] = $userData['username'];
        
        $offset = $this->uri->segment(3, 1);
        $keyword = $this->input->get('search');
        
        $data['title'] = 'Billing - Auto Planet';
        $data['tab'] = 'Billing';
        
        $limit = 10;
        $data['bills'] = $this->billing_model->getAll(($offset-1)*$limit, $limit, $keyword);
        $data['keyword'] = $keyword;
        $data['total'] = $this->billing_model->getTotal($keyword);
        
        $jobsheetList = array('' => '-- Select Jobsheet --');
        $jobsheets = $this->jobsheet_model->getAllCompleted();
        foreach($jobsheets as $jobsheet) {
            $jobsheetList[$jobsheet['id']] = $jobsheet['id'];            
        }
        $data['jobsheets'] = $jobsheetList;
        
        $config['base_url'] = base_url(). 'index.php/billing/page';
        $config['total_rows'] = $this->billing_model->getCount($keyword);
        $config['per_page'] = $limit;        
        $this->pagination->initialize($config);
        
        $this->load->view('templates/header', $data);
        $this->load->view('billing/billing_view', $data);
        $this->load->view('templates/footer');
    }
    
    function search()
    {
        $keyword = $this->input->post('search');
        
        redirect('billing/page/1?search='.$keyword);
    }
    
    function delete($id)
    {
        $userData = parent::requireLogin();
        
        if($userData['username'] != 'admin') {
            redirect('billing', 'refresh');
        } else {        
            $this->billing_model->delete($id);
        }
        
        redirect('billing', 'refresh');
    }
    
    function update($id)
    {
        $data = $this->input->post('data');        
        $this->billing_model->update($id, $data);
    }
    
}

?>