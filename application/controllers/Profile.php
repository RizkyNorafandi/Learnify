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
        $templates = array(
            'head' => 'Templates/User/head',
            'navbar' => 'Templates/User/navbar',
            'content' => 'User/profile',
            'footer' => '',
            'script' => 'Templates/User/script',
        );

        $this->load->view('masterUser', $templates);
    }
}

/* End of file Learning.php */
