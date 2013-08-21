<?php

/**
 * Home page controller
 */

session_start();
class Home extends CI_Controller {

 function __construct()
 {
   parent::__construct();
 }

 function index()
 {
   if($this->session->userdata('logged_in'))
   {
        $session_data = $this->session->userdata('logged_in');
        redirect('jobsheet');
     
   }
   else
   {
     redirect('login', 'refresh');
   }
 }

 function logout()
 {
   $this->session->unset_userdata('logged_in');
   session_destroy();
   redirect('home', 'refresh');
 }

}

?>


