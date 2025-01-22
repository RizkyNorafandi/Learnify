<?php
require_once APPPATH . 'libraries/AdminMiddleware.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('courseModel');
        $this->session->userdata('adminId') ?: redirect('admin/login');
    }


    public function index()
    {
        // Initialize cURL session
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/learnify/api/Courses/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        $courses = json_decode($response);

        $datas = array(
            'title' => 'Dashboard',
            'hidden' => '',
            'color' => 'blue',
            'courses' => $courses,
        );

        $partials = array(
            'header' => 'templates/dashboard/header',
            'navigation' => 'templates/dashboard/navigation',
            'content' => 'dashboard/dashboard',
            'footer' => 'templates/dashboard/footer',
            'script' => 'templates/dashboard/script',
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }
}
