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
            'csrf_token_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
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
        } else {
            $data = [
                'adminEmail' => $this->input->post('adminEmail'),
                'adminPassword' => $this->input->post('adminPassword'),
                'ip_address' => $this->input->ip_address()
            ];

            // Inisialisasi cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://localhost/learnify/api/Admins/login');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'X-CSRF-TOKEN: ' . $this->security->get_csrf_hash()
            ));

            // Eksekusi cURL dan dapatkan respons
            $response = curl_exec($ch);

            // Cek error cURL
            if (curl_errno($ch)) {
                log_message('error', 'cURL error: ' . curl_error($ch));
                $this->session->set_flashdata('error', 'Login failed. Please try again later.');
                redirect('admin/login');
            }

            // Dapatkan kode status HTTP
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // Log response for debugging
            log_message('debug', 'API Response: ' . $response);

            if ($http_code == 200) {
                $result = json_decode($response);
                if (isset($result->data->adminId)) {
                    $this->session->set_userdata('adminId', $result->data->adminId);
                    $this->session->set_userdata('adminEmail', $result->data->adminEmail);
                    log_message('debug', 'Login successful: ' . print_r($result->data, true));
                    redirect('admin/dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Login failed. Invalid response from server.');
                    redirect('admin/login');
                }
            } else {
                $this->session->set_flashdata('error', 'Login failed. ' . $response);
                redirect('admin/login');
            }
        }
    }



    public function logout()
    {
        $this->session->sess_destroy();
        redirect('admin/login');
    }
}

/* End of file Auth_dashboard.php */