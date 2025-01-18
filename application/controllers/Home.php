<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    
    public function __construct() {
        parent::__construct();
    }
    

    public function index() {
        $datas = array(
            'title' => 'Home',
        );

        $templates = array(
            'head' => 'templates/user/head',
            'navbar' => 'templates/user/navbar',
            'content' => 'user/home',
            'footer' => 'templates/user/footer',
            'script' => 'templates/user/script',
        );

        $this->load->vars($datas);
        $this->load->view('masterUser', $templates);
    }
}

/* End of file Controllername.php */
