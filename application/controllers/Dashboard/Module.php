<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Module extends CI_Controller
{



    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('moduleModel');
        $this->session->userdata('adminId') ?: redirect('admin/login');
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


    public function store()
    {
        $this->form_validation->set_rules('moduleName', 'Module Name', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('moduleTags', 'Module Tags', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('moduleDescription', 'Module Description', 'trim|max_length[100]');

        // Pesan kesalahan dalam bentuk array
        $error_messages = array(
            'required' => '{field} harus diisi.',
            'max_length' => '{field} tidak boleh lebih dari {param} karakter.',
        );

        // Mengatur pesan kesalahan menggunakan array
        foreach ($error_messages as $rule => $message) {
            $this->form_validation->set_message($rule, $message);
        }


        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('validation_errors', validation_errors());
            redirect('dashboard/module');
        } else {
            $data = [
                'moduleName' => $this->input->post('moduleName'),
                'moduleTags' => $this->input->post('moduleTags'),
                'moduleDescription' => $this->input->post('moduleDescription'),
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://localhost/learnify/api/Modules/");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($response);

            if ($result->status) {
                $this->session->set_flashdata('success', 'Module berhasil ditambahkan');
                redirect('dashboard/module');
            } else {
                $this->session->set_flashdata('error', $result->message);
                redirect('dashboard/module');
            }
        }
    }

    public function update()
    {
        $moduleID = $this->input->post('moduleID');

        $this->form_validation->set_rules('moduleName', 'Module Name', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('moduleTags', 'Module Tags', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('moduleDescription', 'Module Description', 'trim|max_length[100]');

        // Pesan kesalahan dalam bentuk array
        $error_messages = array(
            'required' => '{field} harus diisi.',
            'max_length' => '{field} tidak boleh lebih dari {param} karakter.',
        );

        // Mengatur pesan kesalahan menggunakan array
        foreach ($error_messages as $rule => $message) {
            $this->form_validation->set_message($rule, $message);
        }

        if ($this->form_validation->run() == FALSE) {
            $validation_errors = validation_errors();
            $this->session->set_flashdata('validation_errors', $validation_errors);
            log_message('error', 'Form validation failed: ' . $validation_errors); // Log validation errors
            redirect('dashboard/module');
        } else {
            $data = [
                'moduleName' => $this->input->post('moduleName'),
                'moduleTags' => $this->input->post('moduleTags'),
                'moduleDescription' => $this->input->post('moduleDescription'),
            ];

            // Log the data being sent
            log_message('debug', 'Data to be sent: ' . json_encode($data));

            $ch = curl_init(); // Inisialisasi cURL
            curl_setopt($ch, CURLOPT_URL, 'http://localhost/learnify/api/Modules/' . $moduleID);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); // Set metode PUT
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Set data yang akan dikirim
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Set return value ke variable
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'X-CSRF-TOKEN: ' . $this->security->get_csrf_hash()
            )); // Set header request

            $response = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($response);

            // Log the response
            log_message('debug', 'API Response: ' . $response);

            if ($result->status) {
                log_message('debug', 'Module successfully updated: ' . json_encode($data)); // Log success
                $this->session->set_flashdata('success', 'Module berhasil Diubah');
                redirect('dashboard/module');
            } else {
                $message = isset($result->message) ? $result->message : 'Terjadi kesalahan saat menghubungi API';
                log_message('error', 'Failed to update module: ' . $message); // Log failure
                $this->session->set_flashdata('error', $message);
                redirect('dashboard/module');
            }
        }
    }
}

/* End of file Module.php */
