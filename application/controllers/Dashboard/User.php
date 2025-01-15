<?php
require_once APPPATH . 'libraries/AdminMiddleware.php';
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Course_model'); // Memuat model
        $this->load->library('form_validation');
        AdminMiddleware::is_logged_in();
    }

    public function index()
    {
        $datas = array(
            'title' => ' Daftar User',
            'hidden' => '',
            'color' => 'blue',
            'courses' => $this->Course_model->get_courses()
        );

        $partials = array(
            'header' => 'templates/dashboard/header',
            'navigation' => 'templates/dashboard/navigation',
            'content' => 'dashboard/Course',
            'footer' => 'templates/dashboard/footer',
            'script' => 'templates/dashboard/script',
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }
}

/* End of file User.php */
