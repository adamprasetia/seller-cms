<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MY_Controller extends CI_Controller
{    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('session_login')) {
            redirect('login');
            // $this->session_login['id'] = 1;
            // $this->session_login['fullname'] = 'Adam';
        }else{
            $this->session_login = $this->session->userdata('session_login');
        }
    }
}
