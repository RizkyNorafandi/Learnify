<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Material extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('materialModel');
        $this->session->userdata('adminId') ?: redirect('admin/login');
    }

    public function index()
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/learnify/api/Materials/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        $materials = json_decode($response);

        $datas = array(
            'title' => 'Materials',
            'materials' => $materials,
        );

        $partials = array(
            'header' => 'templates/dashboard/header',
            'navigation' => 'templates/dashboard/navigation',
            'content' => 'dashboard/material',
            'footer' => 'templates/dashboard/footer',
            'script' => 'templates/dashboard/script',
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function store()
    {


        $this->form_validation->set_rules('materialName', 'Nama Material ', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('materialContent', 'Konten', 'required');
        $this->form_validation->set_rules('materialTags', 'Tag Material', 'required');

        $error_messages = array(
            'required' => '{field} harus diisi.',
            'max_length' => '{field} tidak boleh lebih dari {param} karakter.',
        );

        foreach ($error_messages as $error => $message) {
            $this->form_validation->set_message($error, $message);
        }

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('dashboard/material');
        } else {
            $data = array(
                'materialName' => $this->input->post('materialName'),
                'materialContent' => $this->input->post('materialContent'),
                'materialTags' => $this->input->post('materialTags'),
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://localhost/learnify/api/Materials/");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($response);

            if ($result->status) {
                $this->session->set_flashdata('success', 'Material berhasil ditambahkan');
                redirect('dashboard/material');
            } else {
                $this->session->set_flashdata('error', $result->message);
                redirect('dashboard/material');
            }
        }
    }

    public function update()
    {
        $id = $this->input->post('courseID');
        // Set validation rules
        $this->form_validation->set_rules('materialName', 'Nama Material ', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('materialContent', 'Konten', 'required');
        $this->form_validation->set_rules('materialTags', 'Tag Material', 'required');

        $error_messages = array(
            'required' => '{field} harus diisi.',
            'max_length' => '{field} tidak boleh lebih dari {param} karakter.',
        );

        // Set custom error messages
        foreach ($error_messages as $error => $message) {
            $this->form_validation->set_message($error, $message);
        }

        // Run validation
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('dashboard/material');
        } else {
            // Prepare data for PUT request
            $data = array(
                'materialName' => $this->input->post('materialName'),
                'materialContent' => $this->input->post('materialContent'),
                'materialTags' => $this->input->post('materialTags'),
            );

            // Initialize cURL for PUT request
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://localhost/learnify/api/Materials/" . $id);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'X-CSRF-TOKEN: ' . $this->security->get_csrf_hash()
            ));

            // Execute the request and handle response
            $response = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($response);

            if ($result->status) {
                $this->session->set_flashdata('success', 'Material berhasil diperbarui');
                redirect('dashboard/material');
            } else {
                $this->session->set_flashdata('error', $result->message);
                redirect('dashboard/material');
            }
        }
    }
}

/* End of file Material.php */
