<?php

/**
 * Parts controller
 */

session_start(); //we need to call PHP's session object to access it through CI
class Part extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('part_model');
    }

    function index()
    {
        parent::requireLogin();   
        
        $this->load->helper('text');
        
        $offset = $this->uri->segment(3, 1);
        $keyword = $this->input->get('search');
        
        $data['title'] = 'Parts';
        $data['tab'] = 'Part';
        $limit = 10;
        $data['parts'] = $this->part_model->getAll(($offset-1)*$limit, $limit, $keyword);
        $data['keyword'] = $keyword;
        
        $this->load->library('pagination');
        $config['base_url'] = base_url(). 'index.php/part/page';
        $config['total_rows'] = $this->part_model->getCount($keyword);
        $config['per_page'] = $limit;        
        $this->pagination->initialize($config);
        $this->load->helper('form');
        
        $this->load->view('templates/header', $data);
        $this->load->view('part/part_view', $data);
        $this->load->view('templates/footer');
    }
    
    function search()
    {
        $keyword = $this->input->post('search');
        
        redirect('part/page/1?search='.$keyword);
    }
    
    function delete($id)
    {
        parent::requireLogin();
        
        $this->part_model->delete($id);
        
        redirect('part', 'refresh');
    }
    
    function create()
    {
        parent::requireLogin();
        
        $this->load->helper('form');
        $this->load->library('form_validation');     
        $this->form_validation->set_error_delimiters('<div class="red">', '</div>');
        $data['title'] = 'Add Parts';
        $data['tab'] = 'Part';
        $data['formName'] = 'part/create';
        
        $data['part'] = array(
            "id" => '',
            "name" => '',
            "dealer_price" => '',
            "mrp" => '',
            "description" => ''
        );
        
        if ($this->form_validation->run('part_form') == FALSE)
		{
			$this->load->view('templates/header', $data);
            $this->load->view('part/part_form', $data);
            $this->load->view('templates/footer');
            
		} else {
            $data = array(
                "name" => $this->input->post('name'),
                "dealer_price" => round($this->input->post('dealer_price'),2),
                "mrp" => round($this->input->post('mrp'),2),
                "description" => $this->input->post('description')
            );
            
            $this->part_model->create($data);
            
            redirect('part', 'refresh');
        }
        
        
    }
    
    function edit($id)
    {
        parent::requireLogin();
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="red">', '</div>');
        $data['title'] = 'Edit Parts';
        $data['tab'] = 'Part';
        $data['formName'] = 'part/edit/'.$id;        
        $data['part'] = $this->part_model->get($id);
        
        if ($this->form_validation->run('part_form') == FALSE)
		{
			$this->load->view('templates/header', $data);
            $this->load->view('part/part_form', $data);
            $this->load->view('templates/footer');
            
		} else {
            
            $data = array(
                "name" => $this->input->post('name'),
                "dealer_price" => round($this->input->post('dealer_price'),2),
                "mrp" => round($this->input->post('mrp'),2),
                "description" => $this->input->post('description')
            );
            
            $this->part_model->update($id, $data);
            
            redirect('part', 'refresh');
        }
        
    }
    
    function updatestock()
    {
        $partId = $this->input->post('id');
        $quantity = (int)$this->input->post('value');
        
        $this->load->model('part_stock_model');
        
        $stock = $this->part_stock_model->getByPartID($partId);
        if(count($stock) > 0) {
            $this->part_stock_model->update($stock['id'], array('quantity' => $quantity));
        } else {
            $this->part_stock_model->create(array('part_id' => $partId, 'quantity' => $quantity));
        }
        
        echo $quantity;
    }

}

?>