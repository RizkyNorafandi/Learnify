<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function index()
    {

        $datas = array(
            'title' => 'Home',
            'hidden' => '',
            'color' => 'blue',
            'is_login_page' => false, // Indikator halaman login
            'csrf_token_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
        );

        $templates = array(
            'head' => 'templates/user/head',
            'navbar' => 'templates/user/navbar',
            'content' => 'user/home',
            'footer' => '',
            'script' => 'templates/user/script',
        );



        $this->load->vars($datas);
        $this->load->view('master_user', $templates);
    }
}

/* End of file Controllername.php */
