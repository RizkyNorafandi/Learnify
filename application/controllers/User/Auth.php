<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    private $max_attempts = 5;
    private $lockout_time = 300; //(dalam detik, 300 detik = 5 menit)


    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }

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
            'content' => 'user/login_page',
            'footer' => '',
            'script' => 'templates/dashboard/script',
        );

        $this->load->vars($datas);
        $this->load->view('master_user', $partials);
    }

    public function login_submit()
    {
        // Validasi form input
        $this->form_validation->set_rules('userEmail', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('userPassword', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('login');
        }

        $userEmail = $this->input->post('userEmail', TRUE);
        $userPassword = $this->input->post('userPassword', TRUE);

        // Cek apakah pengguna telah mencapai batas percobaan login
        $attempts = $this->session->userdata('login_attempts') ?: 0;
        $lockout_time = $this->session->userdata('lockout_time');

        if ($attempts >= $this->max_attempts && time() < $lockout_time) {
            $remaining_time = $lockout_time - time();
            $this->session->set_flashdata('error', "Too many login attempts. Please try again in {$remaining_time} seconds.");
            redirect('login');
        }

        // Cek kredensial user
        $user = $this->User_model->get_user_by_email($userEmail);

        if ($user && password_verify($userPassword, $user['userPassword'])) {
            // Reset login attempts on success
            $this->session->set_userdata('logged_in', TRUE);
            $this->session->set_userdata('userID', $user['id']);
            $this->session->unset_userdata(['login_attempts', 'lockout_time']);

            $this->session->set_flashdata('success', 'Login successful!');
            redirect('Home');
        } else {
            // Increment login attempts
            $attempts++;
            $this->session->set_userdata('login_attempts', $attempts);

            if ($attempts >= $this->max_attempts) {
                $lockout_time = time() + $this->lockout_time;
                $this->session->set_userdata('lockout_time', $lockout_time);
                $this->session->set_flashdata('error', "Too many login attempts. Please try again in {$this->lockout_time} seconds.");
            } else {
                $remaining_attempts = $this->max_attempts - $attempts;
                $this->session->set_flashdata('error', "Invalid email or password. You have {$remaining_attempts} attempts left.");
            }
            redirect('login');
        }
    }
}
