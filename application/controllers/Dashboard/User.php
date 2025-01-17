<?php
require_once APPPATH . 'libraries/AdminMiddleware.php';
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('userModel'); // Memuat model
        $this->load->library('form_validation');
        AdminMiddleware::is_logged_in();
    }

    public function index()
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/learnify/api/Users/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        $users = json_decode($response);

        $datas = array(
            'title' => ' Daftar User',
            'hidden' => '',
            'color' => 'blue',
            'users' => $users,
        );

        $partials = array(
            'header' => 'templates/dashboard/header',
            'navigation' => 'templates/dashboard/navigation',
            'content' => 'dashboard/user',
            'footer' => 'templates/dashboard/footer',
            'script' => 'templates/dashboard/script',
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }
}

/* End of file User.php */
