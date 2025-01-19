<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Auth extends RestController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model'); // Memuat model pengguna
        $this->load->library('form_validation'); // Memuat library form_validation
        $this->load->library('session'); // Memuat library session
    }

    // Fungsi untuk login


    //endpoint login
    public function login_post()
    {
        // Validasi form input
        $this->form_validation->set_rules('userEmail', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('userPassword', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->response([
                'status' => FALSE,
                'message' => validation_errors()
            ], RestController::HTTP_BAD_REQUEST);
            return;
        }

        $userEmail = $this->post('userEmail', TRUE);
        $userPassword = $this->post('userPassword', TRUE);

        // Cek apakah pengguna telah mencapai batas percobaan login
        $attempts = $this->session->userdata('login_attempts') ?: 0;
        $lockout_time = $this->session->userdata('lockout_time');

        if ($attempts >= $this->max_attempts && time() < $lockout_time) {
            $remaining_time = $lockout_time - time();
            $this->response([
                'status' => FALSE,
                'message' => "Too many login attempts. Please try again in {$remaining_time} seconds."
            ], RestController::HTTP_BAD_REQUEST);
            return;
        }

        // Cek kredensial user
        $user = $this->User_model->get_user_by_email($userEmail);

        if ($user && password_verify($userPassword, $user['userPassword'])) {
            // Reset login attempts on success
            $this->session->set_userdata('logged_in', TRUE);
            $this->session->set_userdata('userID', $user['id']);
            $this->session->unset_userdata(['login_attempts', 'lockout_time']);

            $this->response([
                'status' => TRUE,
                'message' => 'Login successful!'
            ], RestController::HTTP_OK);
        } else {
            // Increment login attempts
            $attempts++;
            $this->session->set_userdata('login_attempts', $attempts);

            if ($attempts >= $this->max_attempts) {
                $lockout_time = time() + $this->lockout_time;
                $this->session->set_userdata('lockout_time', $lockout_time);
                $this->response([
                    'status' => FALSE,
                    'message' => "Too many login attempts. Please try again in {$this->lockout_time} seconds."
                ], RestController::HTTP_BAD_REQUEST);
            } else {
                $remaining_attempts = $this->max_attempts - $attempts;
                $this->response([
                    'status' => FALSE,
                    'message' => "Invalid email or password. You have {$remaining_attempts} attempts left."
                ], RestController::HTTP_UNAUTHORIZED);
            }
        }
    }



    // Fungsi untuk logout
    public function logout_post()
    {
        // Hapus session pengguna
        $this->session->unset_userdata('userID');
        $this->session->sess_destroy();

        $this->response([
            'status' => true,
            'message' => 'Logout berhasil'
        ], RestController::HTTP_OK);
    }
}
