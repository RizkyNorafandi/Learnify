<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

class Courses extends RestController
{

    public function __construct()
    {
        parent::__construct();

        // if ($this->input->method() == 'post' || $this->input->method() == 'put' || $this->input->method() == 'delete') {
        //     $csrf_token = $this->input->server('X-CSRF-TOKEN');
        //     $csrf_cookie = $this->input->cookie('csrf_cookie_name');
        //     if ($csrf_token !== $csrf_cookie) {
        //         $this->response(['status' => FALSE, 'message' => 'Invalid CSRF token'], RestController::HTTP_FORBIDDEN);
        //         return;
        //     }
        // }

        $this->load->model('courseModel');
    }

    public function index_get()
    {

        $id = $this->get('id');

        $check_data = $this->db->get_where('course', ['courseID' => $id])->row_array();

        if ($id) {
            if ($check_data) {
                $data = $this->db->get_where('course', ['courseID' => $id])->result();

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
            $data = $this->db->get('course')->result();
            $this->response([
                'status' => true,
                'data' => $data
            ], RestController::HTTP_OK);
        }
    }

    // POST: Tambah course baru
    public function index_post()
    {
        // Get the JSON input


        // Validate input
        $this->form_validation->set_rules('courseName', 'Nama Course', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('courseCategory', 'Kategori', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('courseDescription', 'Deskripsi', 'required|trim|max_length[500]');
        $this->form_validation->set_rules('coursePrice', 'Harga', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('courseTags', 'Tags', 'required|trim|max_length[100]');

        if ($this->form_validation->run() == FALSE) {
            $response = [
                'status' => false,
                'message' => validation_errors()
            ];
            return $this->response($response, RestController::HTTP_BAD_REQUEST);
        }

        // Prepare data for insertion
        $data = [
            'courseName' => htmlspecialchars($this->post('courseName')),
            'courseCategory' => htmlspecialchars($this->post('courseCategory')),
            'courseDescription' => htmlspecialchars($this->post('courseDescription')),
            'coursePrice' => htmlspecialchars($this->post('coursePrice')),
            'courseTags' => htmlspecialchars($this->post('courseTags')),

        ];

        // Handle file upload
        if (!empty($_FILES['courseThumbnail']['name'])) {
            $this->load->library('upload');
            $config['upload_path'] = FCPATH . 'assets/images/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB
            $config['file_name'] = uniqid();

            $this->upload->initialize($config);

            if ($this->upload->do_upload('courseThumbnail')) {
                $uploadData = $this->upload->data();
                $data['courseThumbnail'] = $uploadData['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
            }
        }

        // Log the data being inserted
        log_message('debug', 'Data to be inserted: ' . json_encode($data));

        // Insert data into the database
        if ($this->courseModel->insertCourse($data)) {
            log_message('debug', 'Course successfully added: ' . json_encode($data));
            $this->response([
                'status' => true,
                'message' => 'Course berhasil ditambahkan!'
            ], RestController::HTTP_CREATED);
        } else {
            log_message('error', 'Failed to add course: ' . json_encode($data));
            $this->response([
                'status' => false,
                'message' => 'Gagal menambahkan course. Silakan coba lagi.'
            ], RestController::HTTP_INTERNAL_ERROR);
        }
    }

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
