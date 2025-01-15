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
    public function login_post()
    {
        log_message('info', 'Login attempt started.');

        // Ambil input dari JSON body jika ada
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data) {
            $_POST['email'] = $data['email'];
            $_POST['password'] = $data['password'];
        }

        // Aturan validasi
        $this->form_validation->set_rules('email', 'email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'password', 'required');

        if ($this->form_validation->run() == false) {
            $errors = array_filter(explode("\n", strip_tags(validation_errors())));
            $this->response([
                'status' => false,
                'message' => implode(' ', $errors)
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            $email = $this->post('email');
            $password = $this->post('password');

            log_message('info', 'Email: ' . $email);

            $user = $this->User_model->login($email, $password);

            if ($user) {
                $this->session->set_userdata('userID', $user->userID);
                $this->session->set_userdata('userEmail', $user->userEmail);
                $this->response([
                    'status' => true,
                    'message' => 'Login berhasil',
                    'data' => [
                        'userID' => $user->userID,
                        'userFullname' => $user->userFullname,
                        'userEmail' => $user->userEmail,
                        'userPhone' => $user->userPhone,
                        'userAddress' => $user->userAddress,
                        'userPhoto' => $user->userPhoto,
                    ]
                ], RestController::HTTP_OK);
            } else {
                log_message('error', 'Login failed: Invalid email or password.');
                $this->response([
                    'status' => false,
                    'message' => 'Email atau password salah'
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
