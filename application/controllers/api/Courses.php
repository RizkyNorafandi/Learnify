<?php

defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Courses extends RestController
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('courseModel');
        $this->load->model('materialModel');
    }

    public function index_get()
    {

        $courseID = $this->get('id');

        $check_data = $this->db->get_where('course', ['courseID' => $courseID])->row_array();

        if ($courseID) {
            if ($check_data) {
                $data = $this->courseModel->getCourses($courseID)->result_array();

                foreach ($data as $key => $value) {
                    $data[$key]['moduleIDs'] = explode('|', $value['moduleIDs']);
                    $data[$key]['moduleNames'] = explode('|', $value['moduleNames']);
                    $data[$key]['moduleDescriptions'] = explode('|', $value['moduleDescriptions']);

                    $data[$key]['modules'] = [];
                    for ($i = 0; $i < count($data[$key]['moduleIDs']); $i++) {
                        $data[$key]['modules'][] = [
                            'moduleID' => $data[$key]['moduleIDs'][$i],
                            'moduleName' => $data[$key]['moduleNames'][$i],
                            'moduleDescription' => $data[$key]['moduleDescriptions'][$i],
                            'materials' => $this->materialModel->getMaterialsByModuleID($data[$key]['moduleIDs'][$i])->result_array()
                        ];
                    }
                }

                unset($data[0]['moduleIDs']);
                unset($data[0]['moduleNames']);
                unset($data[0]['moduleDescriptions']);

                $this->response([
                    'status' => true,
                    'data' => $data
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Data Tidak Ditemukan'
                ], 404);
            }
        } else {
            $data = $this->courseModel->getCourses()->result();
            $this->response([
                'status' => true,
                'data' => $data
            ], RestController::HTTP_OK);
        }
    }

    // POST: Tambah course baru

    public function index_post()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        log_message('info', 'index_post() called');

        // Validasi input
        $this->form_validation->set_rules('courseName', 'Nama Course', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('courseDescription', 'Deskripsi', 'required|trim|max_length[500]');
        $this->form_validation->set_rules('coursePrice', 'Harga', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('courseTags', 'Tags', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('modules[]', 'Modules', 'required'); // Array validation

        if ($this->form_validation->run() == FALSE) {
            return $this->response([
                'status' => false,
                'message' => validation_errors()
            ], RestController::HTTP_BAD_REQUEST);
        }

        // Persiapkan data course
        $data = [
            'courseName' => htmlspecialchars($this->post('courseName')),
            'courseDescription' => htmlspecialchars($this->post('courseDescription')),
            'coursePrice' => htmlspecialchars($this->post('coursePrice')),
            'courseTags' => htmlspecialchars($this->post('courseTags')),
        ];

        // Handle file upload jika ada
        if (!empty($_FILES['courseThumbnail']['name'])) {
            $this->load->library('upload');
            $config['upload_path'] = FCPATH . 'assets/images/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['file_name'] = uniqid();

            $this->upload->initialize($config);

            if ($this->upload->do_upload('courseThumbnail')) {
                $uploadData = $this->upload->data();
                $data['courseThumbnail'] = $uploadData['file_name'];
            } else {
                return $this->response([
                    'status' => false,
                    'message' => $this->upload->display_errors()
                ], RestController::HTTP_BAD_REQUEST);
            }
        }

        // Mulai transaksi
        $this->db->trans_start();

        // Insert course
        $courseId = $this->courseModel->insertCourse($data);

        if (!$courseId) {
            $this->db->trans_rollback();
            return $this->response([
                'status' => false,
                'message' => 'Gagal menyimpan course.'
            ], RestController::HTTP_INTERNAL_ERROR);
        }

        // Insert modules
        $modules = $this->post('modules');
        if (!empty($modules)) { // Pastikan modules tidak kosong
            $this->courseModel->insertCourseModules($courseId, $modules);
        }

        // Selesaikan transaksi
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return $this->response([
                'status' => false,
                'message' => 'Gagal menyimpan course dan modules.'
            ], RestController::HTTP_INTERNAL_ERROR);
        }

        return $this->response([
            'status' => true,
            'message' => 'Course dan modules berhasil disimpan.'
        ], RestController::HTTP_CREATED);
    }



    // public function index_post()
    // {
    //     // Validasi input
    //     $this->form_validation->set_rules('courseName', 'Nama Course', 'required|trim|max_length[100]');
    //     $this->form_validation->set_rules('courseCategory', 'Kategori', 'required|trim|max_length[50]');
    //     $this->form_validation->set_rules('courseDescription', 'Deskripsi', 'required|trim|max_length[500]');
    //     $this->form_validation->set_rules('coursePrice', 'Harga', 'required|numeric|greater_than_equal_to[0]');
    //     $this->form_validation->set_rules('courseTags', 'Tags', 'required|trim|max_length[100]');
    //     $this->form_validation->set_rules('modules[]', 'Modules', 'required'); // Array validation

    //     if ($this->form_validation->run() == FALSE) {
    //         $response = [
    //             'status' => false,
    //             'message' => validation_errors()
    //         ];
    //         return $this->response($response, RestController::HTTP_BAD_REQUEST);
    //     }

    //     // Persiapkan data course
    //     $data = [
    //         'courseName' => htmlspecialchars($this->post('courseName')),
    //         'courseCategory' => htmlspecialchars($this->post('courseCategory')),
    //         'courseDescription' => htmlspecialchars($this->post('courseDescription')),
    //         'coursePrice' => htmlspecialchars($this->post('coursePrice')),
    //         'courseTags' => htmlspecialchars($this->post('courseTags')),
    //     ];

    //     // Handle file upload jika ada
    //     if (!empty($_FILES['courseThumbnail']['name'])) {
    //         $this->load->library('upload');
    //         $config['upload_path'] = FCPATH . 'assets/images/';
    //         $config['allowed_types'] = 'jpg|jpeg|png';
    //         $config['max_size'] = 2048; // Maksimal 2MB
    //         $config['file_name'] = uniqid();

    //         $this->upload->initialize($config);

    //         if ($this->upload->do_upload('courseThumbnail')) {
    //             $uploadData = $this->upload->data();
    //             $data['courseThumbnail'] = $uploadData['file_name'];
    //         } else {
    //             return $this->response([
    //                 'status' => false,
    //                 'message' => $this->upload->display_errors()
    //             ], RestController::HTTP_BAD_REQUEST);
    //         }
    //     }

    //     // Mulai transaksi untuk menyimpan data
    //     $this->db->trans_start();

    //     // Insert course ke database
    //     $courseId = $this->courseModel->insertCourse($data);

    //     if ($courseId) {
    //         // Tambahkan modules jika course berhasil disimpan
    //         $modules = $this->post('modules'); // Expecting an array of module IDs
    //         foreach ($modules as $moduleId) {
    //             $this->db->insert('course_has_module', [
    //                 'course_id' => $courseId,
    //                 'module_id' => $moduleId,
    //             ]);
    //         }

    //         $this->db->trans_complete();

    //         // Cek status transaksi
    //         if ($this->db->trans_status() === FALSE) {
    //             return $this->response([
    //                 'status' => false,
    //                 'message' => 'Gagal menyimpan data course atau modules.'
    //             ], RestController::HTTP_INTERNAL_ERROR);
    //         }

    //         // Berhasil
    //         return $this->response([
    //             'status' => true,
    //             'message' => 'Course dan modules berhasil ditambahkan!'
    //         ], RestController::HTTP_CREATED);
    //     } else {
    //         $this->db->trans_rollback(); // Rollback jika terjadi kesalahan
    //         return $this->response([
    //             'status' => false,
    //             'message' => 'Gagal menambahkan course. Silakan coba lagi.'
    //         ], RestController::HTTP_INTERNAL_ERROR);
    //     }
    // }


    // PUT: Update course
    public function index_put($id)
    {
        $input = json_decode(trim(file_get_contents('php://input')), true);

        $data = [
            'courseName' => $input['courseName'],
            'courseCategory' => $input['courseCategory'],
            'courseDescription' => $input['courseDescription'],
            'coursePrice' => $input['coursePrice'],
            'courseTags' => $input['courseTags'],
        ];

        // Handle file upload
        if (!empty($input['courseThumbnail'])) {
            $data['courseThumbnail'] = $input['courseThumbnail'];
        }

        // Log the data being updated
        log_message('debug', 'Data to be updated: ' . json_encode($data));

        // Update data di database
        if ($this->courseModel->updateCourse($id, $data)) {
            log_message('debug', 'Course successfully updated: ' . json_encode($data));
            $this->response([
                'status' => true,
                'message' => 'Course berhasil diperbarui!'
            ], RestController::HTTP_OK);
        } else {
            log_message('error', 'Failed to update course: ' . json_encode($data));
            $this->response([
                'status' => false,
                'message' => 'Gagal memperbarui course. Silakan coba lagi.'
            ], RestController::HTTP_INTERNAL_ERROR);
        }
    }

    public function index_delete()
    {
        $courseID = $this->delete('id');

        if (!$courseID) {
            $this->response([
                'status' => false,
                'message' => 'ID course tidak ditemukan.'
            ], RestController::HTTP_BAD_REQUEST);
            return;
        }

        if ($this->courseModel->deleteCourse($courseID)) {
            $this->response([
                'status' => true,
                'message' => 'Course berhasil dihapus!'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal menghapus course. Silakan coba lagi.'
            ], RestController::HTTP_INTERNAL_ERROR);
        }
    }

    public function addModule_post()
    {
        $data = [
            'courseID' => $this->post('courseID'),
            'moduleIDs' => $this->post('moduleIDs'),
        ];

        $input = json_decode(trim(file_get_contents('php://input')), true);

        $this->form_validation->set_data($input);

        $this->form_validation->set_rules('courseID', 'ID Course', 'required|trim|numeric');
        // $this->form_validation->set_rules('moduleIDs', 'Judul Modul', 'required|trim|max_length[100]');

        // Pesan kesalahan dalam bentuk array
        $error_messages = array(
            'required' => '{field} harus diisi.',
            'max_length' => '{field} tidak boleh lebih dari {param} karakter.',
            'numeric' => '{field} harus berupa angka.',
        );

        // Mengatur pesan kesalahan menggunakan array
        foreach ($error_messages as $rule => $message) {
            $this->form_validation->set_message($rule, $message);
        }

        // Validasi data di model
        if ($this->form_validation->run() == FALSE) {
            $this->response([
                'status' => false,
                'message' => validation_errors(),
            ], RestController::HTTP_BAD_REQUEST);
            return;
        }
        // Tambahkan data ke database
        if ($this->courseModel->insertModule($data)) {
            $this->response([
                'status' => true,
                'message' => 'Modul berhasil ditambahkan!'
            ], RestController::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal menambahkan modul. Silakan coba lagi.'
            ], RestController::HTTP_INTERNAL_ERROR);
        }
    }

    public function count_get()
    {
        $course_count = $this->courseModel->get_course_count();
        $this->response([
            'status' => TRUE,
            'course_count' => $course_count
        ], RestController::HTTP_OK);
    }

    public function cdel_get()
    {
        $courseID = $this->get('id');

        // Delete the course from the database
        if ($this->courseModel->deleteCourse($courseID)) {
            $this->response([
                'status' => true,
                'message' => 'Course berhasil dihapus!'
            ], RestController::HTTP_OK);
        } else {
            log_message('error', 'Failed to delete course: ' . $courseID);
            $this->response([
                'status' => false,
                'message' => 'Gagal menghapus course. Silakan coba lagi.'
            ], RestController::HTTP_INTERNAL_ERROR);
        }
    }
}
