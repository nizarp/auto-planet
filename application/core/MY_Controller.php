<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class MY_Controller extends CI_Controller {
    
    public function requireLogin() {
        if($this->session->userdata('logged_in'))
        {
            $userData = $this->session->userdata('logged_in');
            return $userData;
        } else {
            redirect('login', 'refresh');
        }
    }
    
}
?>
