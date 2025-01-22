<?php
defined('BASEPATH') or exit('No direct script access allowed');


use chriskacerguis\RestServer\RestController;

class Admins extends RestController
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('adminModel');
    }

    public function login_post()
    {
        $adminEmail = trim($this->post('adminEmail'));
        $adminPassword = trim($this->post('adminPassword'));
        $ip_address = $this->post('ip_address');

        // Validasi input
        if (empty($adminEmail) || empty($adminPassword)) {
            $this->response([
                'status' => FALSE,
                'message' => 'Email dan password harus diisi.'
            ], RestController::HTTP_BAD_REQUEST);
            return;
        }

        // Cek Brute Force
        if ($this->adminModel->is_brute_force($ip_address, $adminEmail)) {
            $this->response([
                'status' => FALSE,
                'message' => 'Terlalu banyak percobaan login. Coba lagi nanti.'
            ], RestController::HTTP_FORBIDDEN);
            return;
        }

        // Verifikasi Admin
        $admin = $this->adminModel->get_admin($adminEmail);
        if (!$admin) {
            $this->response([
                'status' => FALSE,
                'message' => 'Email tidak terdaftar.'
            ], RestController::HTTP_NOT_FOUND);
            return;
        }

        // Verifikasi password
        if (!password_verify($adminPassword, $admin->adminPassword)) {
            $this->adminModel->log_attempt($ip_address, $adminEmail);
            $this->response([
                'status' => FALSE,
                'message' => 'Email atau password salah.'
            ], RestController::HTTP_UNAUTHORIZED);
            return;
        }

        // Periksa Status Admin
        if ($admin->status !== 'active') {
            $this->response([
                'status' => FALSE,
                'message' => 'Akun ini tidak aktif. Hubungi administrator untuk bantuan.'
            ], RestController::HTTP_FORBIDDEN);
            return;
        }

        // Login berhasil: Kirim data ke klien
        $this->response([
            'status' => TRUE,
            'message' => 'Login berhasil!',
            'data' => [
                'adminId' => $admin->adminId,
                'adminName' => $admin->adminName,
                'adminEmail' => $admin->adminEmail
            ]
        ], RestController::HTTP_OK);
    }
}

/* End of file Auth_admin.php */
