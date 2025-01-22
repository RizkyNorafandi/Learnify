<?php
require_once APPPATH . 'libraries/AdminMiddleware.php';
defined('BASEPATH') or exit('No direct script access allowed');

class Course extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('courseModel'); // Memuat model
        $this->load->library('form_validation');
        $this->session->userdata('adminId') ?: redirect('admin/login');
    }


    public function index()
    {
        // Ambil data courses
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/learnify/api/Courses/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $responseCourses = curl_exec($ch);
        curl_close($ch);
        $courses = json_decode($responseCourses);

        // Ambil data modules
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/learnify/api/Modules/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $responseModules = curl_exec($ch);
        curl_close($ch);
        $modules = json_decode($responseModules);

        // Kirim data ke view
        $datas = array(
            'title' => 'Daftar Course',
            'hidden' => '',
            'color' => 'blue',
            'courses' => $courses->data,
            'modules' => $modules,
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
        $this->form_validation->set_rules('courseCategory', 'Kategori', 'required|trim|max_length[50]');
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
            log_message('error', 'Form validation failed: ' . validation_errors()); // Log validation errors
            redirect('admin/course');
        } else {
            // Validasi berhasil, simpan data
            $file_path = $_FILES['courseThumbnail']['tmp_name'];
            $file_name = $_FILES['courseThumbnail']['name'];
            $mime_type = $_FILES['courseThumbnail']['type'];

            $cfile = curl_file_create($file_path, $mime_type, $file_name);


            $data = [
                'courseName' => $this->input->post('courseName', TRUE),
                'courseCategory' => $this->input->post('courseCategory', TRUE),
                'courseDescription' => $this->input->post('courseDescription', TRUE),
                'coursePrice' => $this->input->post('coursePrice', TRUE),
                'courseTags' => $this->input->post('courseTags', TRUE),
                'courseThumbnail' => $cfile,
            ];


            // Log the data being sent
            log_message('debug', 'Data to be sent: ' . json_encode($data));

            $ch = curl_init(); // Inisialisasi cURL
            curl_setopt($ch, CURLOPT_URL, 'http://localhost/learnify/api/Courses/'); // Set URL
            curl_setopt($ch, CURLOPT_POST, true); // Set metode POST
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // Set data yang akan dikirim
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Set return value ke variable
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: multipart/form-data',
                'X-CSRF-TOKEN: ' . $this->security->get_csrf_hash()
            )); // Set header request

            $response = curl_exec($ch);

            // Log the response
            log_message('debug', 'API Response: ' . $response);

            if (curl_errno($ch)) {
                log_message('error', 'cURL error: ' . curl_error($ch)); // Log cURL errors
                show_error(curl_error($ch));
                redirect('admin/course');
            }

            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get HTTP Code

            // Log the HTTP code
            log_message('debug', 'HTTP Code: ' . $http_code);

            if ($http_code == 201) {
                log_message('debug', 'Course successfully added: ' . json_encode($data)); // Log success
                $this->session->set_flashdata('success', 'Course berhasil ditambahkan!');
                redirect('admin/course');
            } else {
                log_message('error', 'Failed to add course. HTTP Code: ' . $http_code . ' Response: ' . $response); // Log failure
                $this->session->set_flashdata('error', 'Gagal menambahkan course. Silakan coba lagi.');
                redirect('admin/course');
            }
        }
    }




    public function update()
    {
        // Ambil ID Course dari input
        $courseID = $this->input->post('courseID');

        // Atur aturan validasi
        $this->form_validation->set_rules('courseName', 'Nama Course', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('courseCategory', 'Kategori', 'required|trim|max_length[50]');
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
            $this->session->set_flashdata('validation_errors', validation_errors());
            redirect('admin/course'); // Ganti dengan URL halaman utama course
        } else {
            // Validasi berhasil, proses data
            $data = [
                'courseName' => $this->input->post('courseName', TRUE),
                'courseCategory' => $this->input->post('courseCategory', TRUE),
                'courseDescription' => $this->input->post('courseDescription', TRUE),
                'coursePrice' => $this->input->post('coursePrice', TRUE),
                'courseTags' => $this->input->post('courseTags', TRUE),
            ];

            $ch = curl_init(); // Inisialisasi cURL
            curl_setopt($ch, CURLOPT_URL, 'http://localhost/learnify/api/Courses/' . $courseID); // Set URL with course ID
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); // Set metode PUT
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Set data yang akan dikirim
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Set return value ke variable
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'X-CSRF-TOKEN: ' . $this->security->get_csrf_hash()
            )); // Set header request

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                show_error(curl_error($ch));
                redirect('admin/course');
            }

            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get HTTP Code

            if ($http_code == 200) {
                log_message('debug', 'Course successfully updated: ' . json_encode($data)); // Log success
                $this->session->set_flashdata('success', 'Course berhasil diperbarui!');
                redirect('admin/course');
            } else {
                log_message('error', 'Failed to update course. HTTP Code: ' . $http_code . ' Response: ' . $response); // Log failure
                $this->session->set_flashdata('error', 'Gagal memperbarui course. Silakan coba lagi.');
                redirect('admin/course');
            }
        }
    }

    public function delete()
    {

        $courseID = $this->input->post('courseID');

        // Validasi apakah courseID diterima
        if (!$courseID) {
            $this->session->set_flashdata('error', 'ID course tidak valid.');
            redirect('admin/course');
        }

        // Lakukan penghapusan seperti biasa
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost/learnify/api/Courses/cdel?' . http_build_query(['id' => $courseID]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'X-CSRF-TOKEN: ' . $this->security->get_csrf_hash()
        ));

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            $error_message = curl_error($ch);
            curl_close($ch);
            $this->session->set_flashdata('error', 'Kesalahan saat menghapus course: ' . $error_message);
            redirect('admin/course');
        }

        // Dapatkan kode HTTP
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);


        if ($http_code == 200) {
            $this->session->set_flashdata('success', 'Course berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus course. Silakan coba lagi.');
        }

        redirect('admin/course');
    }
}

/* End of file Course.php */
