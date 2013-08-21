<?php

/*
 * Login Controller
 */

class Login extends CI_Controller {

 function __construct()
 {
   parent::__construct();
 }

 function index()
 {
   $this->load->helper(array('form'));
   $data['title'] = 'Login';
   
   $this->load->view('templates/header_noauth', $data);
   $this->load->view('login_view');
   $this->load->view('templates/footer');
 }

}

?>


