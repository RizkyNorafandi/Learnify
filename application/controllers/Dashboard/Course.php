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
        $courses = json_decode($responseCourses)->data;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/learnify/api/Modules/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $responseModules = curl_exec($ch);
        curl_close($ch);
        $modules = json_decode($responseModules)->data;

        // Kirim data ke view
        $datas = array(
            'title' => 'Daftar Course',
            'hidden' => '',
            'color' => 'blue',
            'courses' => $courses,
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


    // public function store()
    // {
    //     log_message('info', 'store() called');

    //     // Atur aturan validasi
    //     $this->form_validation->set_rules('courseName', 'Nama Course', 'required|trim|max_length[100]');
    //     $this->form_validation->set_rules('courseDescription', 'Deskripsi', 'required|trim|max_length[500]');
    //     $this->form_validation->set_rules('coursePrice', 'Harga', 'required|numeric|greater_than_equal_to[0]');
    //     $this->form_validation->set_rules('courseTags', 'Tags', 'required|trim|max_length[100]');
    //     $this->form_validation->set_rules('modules[]', 'Module', 'required|trim|max_length[100]'); // Menambahkan 'required'

    //     // Pesan kesalahan dalam bentuk array
    //     $error_messages = array(
    //         'required' => '{field} harus diisi.',
    //         'max_length' => '{field} tidak boleh lebih dari {param} karakter.',
    //         'numeric' => '{field} harus berupa angka.',
    //         'greater_than_equal_to' => '{field} harus lebih besar atau sama dengan {param}.',
    //     );

    //     // Mengatur pesan kesalahan menggunakan array
    //     foreach ($error_messages as $rule => $message) {
    //         $this->form_validation->set_message($rule, $message);
    //     }

    //     // Jalankan validasi
    //     if ($this->form_validation->run() == FALSE) {
    //         $this->session->set_flashdata('validation_errors', validation_errors());
    //         log_message('error', 'Form validation failed: ' . validation_errors());
    //         redirect('admin/course');
    //     } else {
    //         $data = [
    //             'courseName' => htmlspecialchars($this->input->post('courseName', TRUE)),
    //             'courseDescription' => htmlspecialchars($this->input->post('courseDescription', TRUE)),
    //             'coursePrice' => htmlspecialchars($this->input->post('coursePrice', TRUE)),
    //             'courseTags' => htmlspecialchars($this->input->post('courseTags', TRUE)),
    //             'modules' => $this->input->post('modules', TRUE),
    //         ];

    //         // Cek apakah file thumbnail diupload
    //         if (!empty($_FILES['courseThumbnail']['name'])) {
    //             // Validasi berhasil, simpan data
    //             $file_path = $_FILES['courseThumbnail']['tmp_name'];
    //             $file_name = $_FILES['courseThumbnail']['name'];
    //             $mime_type = $_FILES['courseThumbnail']['type'];

    //             // Buat cfile hanya jika file diupload
    //             $cfile = curl_file_create($file_path, $mime_type, $file_name);
    //             $data['courseThumbnail'] = $cfile; // Tambahkan ke data
    //         } else {
    //             $data['courseThumbnail'] = null; // Atur ke null jika tidak ada file
    //         }

    //         // Log the data being sent
    //         log_message('debug', 'Data to be sent: ' . json_encode($data));

    //         $ch = curl_init(); // Inisialisasi cURL
    //         curl_setopt($ch, CURLOPT_URL, 'http://localhost/learnify/api/Courses/'); // Set URL
    //         curl_setopt($ch, CURLOPT_POST, true); // Set metode POST
    //         curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // Set data yang akan dikirim
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Set return value ke variable
    //         curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    //             'Content-Type: multipart/form-data',
    //             'X-CSRF-TOKEN: ' . $this->security->get_csrf_hash()
    //         )); // Set header request

    //         $response = curl_exec($ch);

    //         // Log the response
    //         log_message('debug', 'API Response: ' . $response);

    //         if (curl_errno($ch)) {
    //             log_message('error', 'cURL error: ' . curl_error($ch)); // Log cURL errors
    //             curl_close($ch);
    //             show_error(curl_error($ch));
    //             redirect('admin/course');
    //         }

    //         $result = json_decode($response);
    //         $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get HTTP Code
    //         curl_close($ch);

    //         // Log the HTTP code
    //         log_message('debug', 'HTTP Code: ' . $http_code);

    //         if ($http_code == 201) {
    //             log_message('debug', 'Course successfully added: ' . json_encode($data)); // Log success
    //             $this->session->set_flashdata('success', 'Course berhasil ditambahkan!');
    //             redirect('admin/course');
    //         } else {
    //             $error_message = isset($result->message) ? $result->message : 'Gagal menambahkan course. Silakan coba lagi.'; // Cek apakah message ada
    //             log_message('error', 'Failed to add course. HTTP Code: ' . $http_code . ' Response: ' . $error_message); // Log failure
    //             $this->session->set_flashdata('error', $error_message);
    //             redirect('admin/course');
    //         }
    //     }
    // }

    public function store()
    {
        log_message('info', 'store() called');

        // Atur aturan validasi
        $this->form_validation->set_rules('courseName', 'Nama Course', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('courseDescription', 'Deskripsi', 'required|trim|max_length[500]');
        $this->form_validation->set_rules('coursePrice', 'Harga', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('courseTags', 'Tags', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('modules[]', 'Module', 'required'); // Menambahkan 'required'

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
            log_message('error', 'Form validation failed: ' . validation_errors());
            redirect('admin/course');
        } else {
            // Data yang akan disimpan
            $data = [
                'courseName' => htmlspecialchars($this->input->post('courseName', TRUE)),
                'courseDescription' => htmlspecialchars($this->input->post('courseDescription', TRUE)),
                'coursePrice' => $this->input->post('coursePrice', TRUE),
                'courseTags' => htmlspecialchars($this->input->post('courseTags', TRUE)),
            ];

            // Handle file upload jika ada
            if (!empty($_FILES['courseThumbnail']['name'])) {
                $this->load->library('upload');
                $config['upload_path'] = FCPATH . 'assets/images/'; // Path folder untuk menyimpan file
                $config['allowed_types'] = 'jpg|jpeg|png'; // Jenis file yang diperbolehkan
                $config['max_size'] = 2048; // Ukuran maksimum file (2MB)
                $config['file_name'] = uniqid(); // Gunakan nama file unik untuk menghindari konflik

                $this->upload->initialize($config);

                if ($this->upload->do_upload('courseThumbnail')) {
                    $uploadData = $this->upload->data(); // Data file yang diupload
                    $data['courseThumbnail'] = $uploadData['file_name']; // Simpan nama file ke array data
                } else {
                    // Tangani kesalahan upload
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('admin/course');
                }
            } else {
                $data['courseThumbnail'] = null; // Jika tidak ada file yang diupload, set thumbnail ke null
            }


            // Simpan data ke tabel course
            $this->db->insert('course', $data);
            $courseID = $this->db->insert_id(); // Dapatkan ID course yang baru ditambahkan

            // Simpan data module jika ada
            $modules = $this->input->post('modules', TRUE);
            if (!empty($modules)) {
                $moduleData = [];
                foreach ($modules as $moduleID) {
                    $moduleData[] = [
                        'courseID' => $courseID,
                        'moduleID' => $moduleID,
                    ];
                }
                $this->db->insert_batch('course_has_module', $moduleData); // Insert batch ke tabel relasi
            }

            // Jika berhasil, arahkan ke halaman course dengan pesan sukses
            $this->session->set_flashdata('success', 'Course berhasil ditambahkan!');
            log_message('info', 'Course successfully added with ID: ' . $courseID);
            redirect('admin/course');
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
        $result = json_decode($response);
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
