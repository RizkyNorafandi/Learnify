<?php
require_once APPPATH . 'libraries/AdminMiddleware.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Module extends CI_Controller
{



    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('moduleModel');
        AdminMiddleware::is_logged_in();
    }

    public function index()
    {

        // Initialize cURL session
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/learnify/api/Modules/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        $modules = json_decode($response);


        $datas = array(
            'title' => 'Module',
            'hidden' => '',
            'color' => 'blue',
            'modules' => $modules,
            'csrf_token_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
        );

        $partials = array(
            'header' => 'templates/dashboard/header',
            'navigation' => 'templates/dashboard/navigation',
            'content' => 'dashboard/Module',
            'footer' => 'templates/dashboard/footer',
            'script' => 'templates/dashboard/script',
        );


        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }
}

/* End of file Module.php */
