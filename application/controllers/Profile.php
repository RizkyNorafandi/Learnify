<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->session->userdata('userID') ?: redirect('login');
    }

    public function index()
    {
        $datas = array(
            'title' => 'Profile'
        );

        $templates = array(
            'head' => 'Templates/User/head',
            'navbar' => 'Templates/User/navbar',
            'content' => 'User/profile',
            'footer' => '',
            'script' => 'Templates/User/script',
        );

        $this->load->vars($datas);
        $this->load->view('masterUser', $templates);
    }
}

/* End of file Learning.php */