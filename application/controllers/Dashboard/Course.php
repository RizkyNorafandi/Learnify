<?php
require_once APPPATH . 'libraries/AdminMiddleware.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Course extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Course_model'); // Memuat model
        $this->load->library('form_validation');
        AdminMiddleware::is_logged_in();
    }


    public function index()
    {
        // Initialize cURL session
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/learnify/api/courseAPI/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        $courses = json_decode($response, true);

        $datas = array(
            'title' => ' Daftar Course',
            'hidden' => '',
            'color' => 'blue',
            'courses' => $courses,
            'csrf_token_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
        );

        $partials = array(
            'header' => 'templates/dashboard/header',
            'navigation' => 'templates/dashboard/navigation',
            'content' => 'dashboard/Course',
            'footer' => 'templates/dashboard/footer',
            'script' => 'templates/dashboard/script',
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function store()
    {
        // Atur aturan validasi
        $this->form_validation->set_rules('courseName', 'Nama Course', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('classCategory', 'Kategori', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('courseDescription', 'Deskripsi', 'required|trim|max_length[500]');
        $this->form_validation->set_rules('coursePrice', 'Harga', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('courseTags', 'Tags', 'required|trim|max_length[100]');

        // Pesan kesalahan dalam bentuk array
        $error_messages = array(
            'required' => '{field} harus diisi.',
            'max_length' => '{field} tidak boleh lebih dari {param} karakter.',
            'numeric' => '{field} harus berupa angka.',
            'greater_than_equal_to' => '{field} harus lebih besar atau sama dengan {param}.',
        );

        // Mengatur pesan kesalahan menggunakan array
        foreach ($error_messages as $rule => $message) {
            $this->form_validation->set_message($rule, $message);
        }

        // Jalankan validasi
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('validation_errors', validation_errors());
            redirect('admin/course');
        } else {
            // Validasi berhasil, simpan data
            $data = [
                'courseName' => $this->input->post('courseName', TRUE),
                'classCategory' => $this->input->post('classCategory', TRUE),
                'courseDescription' => $this->input->post('courseDescription', TRUE),
                'coursePrice' => $this->input->post('coursePrice', TRUE),
                'courseTags' => $this->input->post('courseTags', TRUE),
            ];

            if ($this->Course_model->insertCourse($data)) {
                $this->session->set_flashdata('success', 'Course berhasil ditambahkan!');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan course. Silakan coba lagi.');
            }

            redirect('admin/course');
        }
    }


    public function update()
    {
        // Ambil ID Course dari input
        $courseID = $this->input->post('courseID');

        // Atur aturan validasi
        $this->form_validation->set_rules('courseName', 'Nama Course', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('classCategory', 'Kategori', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('courseDescription', 'Deskripsi', 'trim|max_length[100]');
        $this->form_validation->set_rules('coursePrice', 'Harga', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('courseTags', 'Tags', 'required|trim|max_length[100]');



        // Pesan kesalahan dalam bentuk array
        $error_messages = array(
            'required' => '{field} harus diisi.',
            'max_length' => '{field} tidak boleh lebih dari {param} karakter.',
            'numeric' => '{field} harus berupa angka.',
            'greater_than_equal_to' => '{field} harus lebih besar atau sama dengan {param}.',
        );

        // Mengatur pesan kesalahan menggunakan array
        foreach ($error_messages as $rule => $message) {
            $this->form_validation->set_message($rule, $message);
        }

        // Menjalanlan validasi
        if ($this->form_validation->run() == FALSE) {
            // Validasi gagal, kembali ke halaman sebelumnya dengan pesan kesalahan
            $this->session->set_flashdata('validation_errors', validation_errors());
            redirect('admin/course'); // Ganti dengan URL halaman utama course
        } else {
            // Validasi berhasil, proses data
            $data = [
                'courseName' => $this->input->post('courseName', TRUE),
                'classCategory' => $this->input->post('classCategory', TRUE),
                'courseDescription' => $this->input->post('courseDescription', TRUE),
                'coursePrice' => $this->input->post('coursePrice', TRUE),
                'courseTags' => $this->input->post('courseTags', TRUE),
            ];

            // Update data ke database
            if ($this->Course_model->updateCourse($courseID, $data)) {
                $this->session->set_flashdata('success', 'Course berhasil diperbarui!');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui course. Silakan coba lagi.');
            }

            // Redirect kembali ke halaman utama course
            redirect('admin/course');
        }
    }
}

/* End of file Course.php */
