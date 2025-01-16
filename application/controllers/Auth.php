<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function login() {
        $datas = array(
            'title' => 'Login',
            'hidden' => '',
            'color' => 'blue',
            'is_login_page' => true,
        );

        $partials = array(
            'head' => 'templates/dashboard/header',
            'navbar' => '',
            'content' => 'user/login_page',
            'footer' => '',
            'script' => 'templates/dashboard/script',
        );

        $this->load->vars($datas);
        $this->load->view('master_user', $partials);
    }

    public function register() {
        $datas = array(
            'title' => 'Login',
            'hidden' => '',
            'color' => 'blue',
            'is_login_page' => true,
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
