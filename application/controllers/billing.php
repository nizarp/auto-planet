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
        
        $this->config->load('ap_settings');
        $limit = $this->config->item('records_per_page');
        
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
            $success = $this->billing_model->delete($id);
        }
        
        if($success) {
            echo 1;
        } else {
            echo 0;
        }
    }
    
    function update($id)
    {
        $userData = parent::requireLogin();
        
        $data = $this->input->post('data');        
        $this->billing_model->update($id, $data);
    }
    
    function create($jobsheetId)
    {
        $userData = parent::requireLogin();
        
        $this->load->helper('form');
        $this->load->library('form_validation');     
        $this->load->model('jobsheet_model');
        $this->load->model('billing_model');
        $this->load->model('part_model');
        $this->load->model('insurance_model');
        
        $this->form_validation->set_error_delimiters('<div class="red">', '</div>');
        $data['title'] = 'Create Bill';
        $data['tab'] = 'Billing';
        $data['formName'] = "billing/create/$jobsheetId";        
        $data['jobsheet'] = $jobsheet = $this->jobsheet_model->get($jobsheetId);
        $data['billNo'] = $this->billing_model->getNextBillNo();
        
        if($jobsheet['status'] != 'complete' && $jobsheet['status'] != 'close') {
            redirect('billing', 'refresh');
        }
        
        $data['paymentModes'] = $this->billing_model->getPaymentModes();
        $data['jobsheet']['labour_charges'] = $this->jobsheet_model->getLabourCharges($jobsheetId);
        $data['jobsheet']['jobsheet_parts'] = $this->jobsheet_model->getJobsheetParts($jobsheetId);

        if($jobsheet['is_claim'] != 0 && $jobsheet['insurance_id'] != '') {
            $data['insurance'] = $this->insurance_model->getInsuranceData($jobsheet['insurance_id']);
        }

        $this->config->load('ap_settings');
        $data['labourTaxSgst'] = $this->config->item('labour_tax_sgst');
        $data['labourTaxCgst'] = $this->config->item('labour_tax_cgst');
        $data['partsTaxSgst'] = $this->config->item('parts_tax_sgst');
        $data['partsTaxCgst'] = $this->config->item('parts_tax_cgst');
        
        $jobtypes = $this->jobsheet_model->getAllJobtypes();
        foreach($jobtypes as $jobtype) {
            $jobtypeList[$jobtype['id']] = $jobtype['type'];            
        }
        $data['jobtypes'] = $jobtypeList;
        
        $parts = $this->part_model->getAll();
        foreach($parts as $part) {
            $partsList[$part['id']] = $part;
        }
        $data['parts'] = $partsList;
        //print_r($parts); die;
        
        $data['bill'] = array(
            'payment_mode' => ''
        );
        
        if (!isset($_POST['jobsheet_id']))
		{
			$this->load->view('templates/header', $data);
            $this->load->view('billing/billing_form', $data);
            $this->load->view('templates/footer');
            
		} else {
            
            $data = array(
                'jobsheet_id' => $this->input->post('jobsheet_id'),
                'name' => $jobsheet['name'],
                'bill_date' => $this->input->post('bill_date'),
                'billing_address' => $jobsheet['address'],
                'billing_contact' => $jobsheet['contact'],
                'payment_mode' => $this->input->post('payment_mode'),
                'reg_no' => $jobsheet['reg_no'],
                'chassis_no' => $jobsheet['chassis_no'],
                'round_off' => $this->input->post('round_off'),
                'grand_total' => $this->input->post('grand_total')
            );

            if($jobsheet['is_claim'] != 0 && $jobsheet['insurance_id'] != '') {
                $data['billing_address'] = $this->input->post('billing_address');
            }
            
            $this->billing_model->deleteBill($jobsheetId);
            
            $this->billing_model->create($data);            
            $billingId = $this->db->insert_id();
            
            if($billingId) {
                
                // Labour Changes
                $billCharges = $this->input->post('bill_charges');
                foreach($billCharges as $billCharge) {
                    $data = array(
                        'bill_id' => $billingId,
                        'job_description' => $billCharge['description'],
                        'amount' => $billCharge['amount'],
                        'tax' => $billCharge['tax'],
                        'total' => $billCharge['total']
                    );
                    
                    $this->billing_model->insertBillCharge($data);                    
                }
                
                // Parts
                $billParts = $this->input->post('bill_parts');
                if(!empty($billParts)) {
                    foreach($billParts as $billPart) {
                        $data = array(
                            'bill_id' => $billingId,
                            'part_name' => $billPart['part_name'],
                            'rate' => $billPart['rate'],
                            'tax' => $billPart['tax'],
                            'quantity' => $billPart['quantity'],
                            'total' => $billPart['total']
                        );
                        
                        $this->billing_model->insertBillParts($data);                    
                    }
                }
                $status = array('status' => 'close');
                $this->jobsheet_model->update($jobsheetId, $status);
            }
            
            redirect('billing', 'refresh');
            
        }
    }
    
}

?>