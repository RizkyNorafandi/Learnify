<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        
        $this->session->userdata('userFullname') ? '' : redirect('login');
    }
    

    public function index()
    {
        $datas = array(
            'title' => 'Home',
            'hidden' => '',
            'color' => 'blue',
            'is_login_page' => false,
        );

        $partials = array(
            'head' => 'templates/user/head',
            'navbar' => 'templates/user/navbar',
            'content' => 'user/home',
            'footer' => 'templates/user/footer',
            'script' => 'templates/user/script',
        );

        $this->load->vars($datas);
        $this->load->view('master_user', $partials);
    }
}

/* End of file Controllername.php */
