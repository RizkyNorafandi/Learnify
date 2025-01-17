<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

class Courses extends RestController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('courseModel');
    }

    public function index_get($id = 0)
    {

        $check_data = $this->db->get_where('course', ['courseID' => $id])->row_array();

        if ($id) {
            if ($check_data) {
                $data = $this->db->get_where('course', ['courseID' => $id])->row_array();

                $this->response($data, RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Data Tidak Ditemukan'
                ], 404);
            }
        } else {
            $data = $this->db->get('course')->result();
            $this->response($data, RestController::HTTP_OK);
        }
    }

    // POST: Tambah course baru
    public function index_post()
    {
        $data = [
            'courseName' => $this->post('courseName'),
            'classCategory' => $this->post('classCategory'),
            'courseDescription' => $this->post('courseDescription'),
            'coursePrice' => $this->post('coursePrice'),
            'courseTags' => $this->post('courseTags'),
        ];

        $input = json_decode(trim(file_get_contents('php://input')), true);

        $this->form_validation->set_data($input);

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

        // Validasi data di model
        if ($this->form_validation->run() == FALSE) {
            $this->response([
                'status' => false,
                'message' => validation_errors(),
            ], RestController::HTTP_BAD_REQUEST);
            return;
        }
        // Tambahkan data ke database
        if ($this->course_model->insertCourse($data)) {
            $this->response([
                'status' => true,
                'message' => 'Course berhasil ditambahkan!'
            ], RestController::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal menambahkan course. Silakan coba lagi.'
            ], RestController::HTTP_INTERNAL_ERROR);
        }
    }

    // PUT: Update course
    public function course_put($id)
    {
        $data = [
            'courseName' => $this->put('courseName'),
            'classCategory' => $this->put('classCategory'),
            'courseDescription' => $this->put('courseDescription'),
            'coursePrice' => $this->put('coursePrice'),
            'courseTags' => $this->put('courseTags'),
        ];

        // Validasi data di model
        if (!$this->CourseModel->validate_course_data($data)) {
            $this->response([
                'status' => false,
                'message' => $this->form_validation->error_array()
            ], RestController::HTTP_BAD_REQUEST);
            return;
        }

        // Update data di database
        if ($this->CourseModel->update_course($id, $data)) {
            $this->response([
                'status' => true,
                'message' => 'Course berhasil diperbarui!'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal memperbarui course. Silakan coba lagi.'
            ], RestController::HTTP_INTERNAL_ERROR);
        }
    }
}
