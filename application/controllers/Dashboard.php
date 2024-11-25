<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('login');
        }
    }

    public function index()
    {
        echo "<h1>Welcome to the Dashboard</h1>";
        echo "<a href='" . site_url('login/logout') . "'>Logout</a>";
    }
}
