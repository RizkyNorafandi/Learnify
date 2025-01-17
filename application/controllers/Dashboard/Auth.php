<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('adminModel');
        $this->load->library('form_validation');
    }


    public function index()
    {

        $datas = array(
            'title' => 'Login admin',
            'hidden' => '',
            'color' => 'blue',
            'is_login_page' => true,
        );

        $partials = array(
            'header' => 'templates/dashboard/header',
            'navigation' => '',
            'content' => 'dashboard/login_admin',
            'footer' => '',
            'script' => 'templates/dashboard/script',
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function login()
    {
        // Validasi input
        $this->form_validation->set_rules('adminEmail', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('adminPassword', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/login');
        }

        $adminEmail = $this->input->post('adminEmail');
        $adminPassword = $this->input->post('adminPassword');
        $ip_address = $this->input->ip_address();

        // Cek Brute Force
        if ($this->adminModel->is_brute_force($ip_address, $adminEmail)) {
            $this->session->set_flashdata('error', 'Terlalu banyak percobaan login. Coba lagi nanti.');
            redirect('admin/login');
        }

        // Verifikasi Admin
        $admin = $this->adminModel->get_admin($adminEmail);
        if (!$admin) {
            log_message('error', 'Admin tidak ditemukan.');
            $this->session->set_flashdata('error', 'Email tidak terdaftar.');
            redirect('admin/login');
        }

        // Debugging hash
        log_message('debug', 'Hash password dari database: ' . $admin->adminPassword);

        // Verifikasi password
        if (!password_verify($adminPassword, $admin->adminPassword)) {
            log_message('error', 'Password salah untuk email: ' . $adminEmail);
            $this->adminModel->log_attempt($ip_address, $adminEmail);
            $this->session->set_flashdata('error', 'Email atau password salah.');
            redirect('admin/login');
        }


        // Periksa Status Admin
        if ($admin->status !== 'active') {
            $this->session->set_flashdata('error', 'Akun ini tidak aktif.');
            redirect('admin/login');
        }

        // Login berhasil: Simpan data ke session
        $this->session->set_userdata([
            'adminId' => $admin->adminId,
            'adminName' => $admin->adminName,
            'adminEmail' => $admin->adminEmail,
            'is_admin_logged_in' => true
        ]);

        // Hapus login attempts
        $this->adminModel->clear_attempts($ip_address, $adminEmail);

        // Tambahkan flashdata untuk pesan sukses
        $this->session->set_flashdata('success', 'Login berhasil! Selamat datang, ' . $admin->adminName . '.');
        redirect('admin/dashboard');
    }


    public function logout()
    {
        $this->session->sess_destroy();
        redirect('admin/login');
    }
}

/* End of file Auth_dashboard.php */
