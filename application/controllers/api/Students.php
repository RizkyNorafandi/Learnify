<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Students extends RestController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Load database
    }

    // Endpoint: GET /students
    public function index_get()
    {
        $id = $this->get('id'); // Ambil parameter 'id' jika ada

        if ($id === NULL) {
            // Jika tidak ada ID, ambil semua data
            $data = $this->db->get('students')->result();
            if ($data) {
                $this->response($data, RestController::HTTP_OK);
            } else {
                $this->response(['message' => 'No students found'], RestController::HTTP_NOT_FOUND);
            }
        } else {
            // Jika ada ID, ambil data berdasarkan ID
            $this->db->where('id', $id);
            $student = $this->db->get('students')->row();
            if ($student) {
                $this->response($student, RestController::HTTP_OK);
            } else {
                $this->response(['message' => 'Student not found'], RestController::HTTP_NOT_FOUND);
            }
        }
    }

    // Endpoint: POST /students
    public function index_post()
    {
        $data = [
            'name' => $this->post('name'),
            'email' => $this->post('email'),
            'phone' => $this->post('phone')
        ];

        // Masukkan data ke tabel students
        if ($this->db->insert('students', $data)) {
            $this->response(['message' => 'Student created successfully'], RestController::HTTP_CREATED);
        } else {
            $this->response(['message' => 'Failed to create student'], RestController::HTTP_BAD_REQUEST);
        }
    }

    // Endpoint: PUT /students
    public function index_put()
    {
        $id = $this->put('id');
        if (!$id) {
            $this->response(['message' => 'ID is required'], RestController::HTTP_BAD_REQUEST);
            return;
        }

        $data = [
            'name' => $this->put('name'),
            'email' => $this->put('email'),
            'phone' => $this->put('phone')
        ];

        // Update data berdasarkan ID
        $this->db->where('id', $id);
        if ($this->db->update('students', $data)) {
            $this->response(['message' => 'Student updated successfully'], RestController::HTTP_OK);
        } else {
            $this->response(['message' => 'Failed to update student'], RestController::HTTP_BAD_REQUEST);
        }
    }


    // Endpoint: DELETE /students
    public function index_delete()
    {
        $id = $this->delete('id');
        if (!$id) {
            $this->response(['message' => 'ID is required'], RestController::HTTP_BAD_REQUEST);
            return;
        }

        // Hapus data berdasarkan ID
        $this->db->where('id', $id);
        if ($this->db->delete('students')) {
            $this->response(['message' => 'Student deleted successfully'], RestController::HTTP_OK);
        } else {
            $this->response(['message' => 'Failed to delete student'], RestController::HTTP_BAD_REQUEST);
        }
    }
}
