<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{

    public function index()
    {
        $datas = array(
            'title' => 'Login',
            'hidden' => '',
            'color' => 'blue',
            'is_login_page' => true, // Indikator halaman login
            'csrf_token_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
        );

        $partials = array(
            'head' => 'templates/dashboard/header',
            'navbar' => '',
            'content' => 'user/register_page',
            'footer' => '',
            'script' => 'templates/dashboard/script',
        );

        $this->load->vars($datas);
        $this->load->view('master_user', $partials);
    }
}

/* End of file Register.php */
