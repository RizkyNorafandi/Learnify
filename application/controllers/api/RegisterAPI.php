<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class User extends RestController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Load database
    }

    // Endpoint: GET /user
    public function index_get()
    {
        $id = $this->get('userID'); // Ambil parameter 'id' jika ada

        if ($id === NULL) {
            // Jika tidak ada ID, ambil semua data
            $data = $this->db->get('user')->result();
            if ($data) {
                $this->response($data, RestController::HTTP_OK);
            } else {
                $this->response(['message' => 'No user found'], RestController::HTTP_NOT_FOUND);
            }
        } else {
            // Jika ada ID, ambil data berdasarkan ID
            $this->db->where('userID', $id);
            $student = $this->db->get('user')->row();
            if ($student) {
                $this->response($student, RestController::HTTP_OK);
            } else {
                $this->response(['message' => 'Student not found'], RestController::HTTP_NOT_FOUND);
            }
        }
    }

    // Endpoint: POST /user/register
    public function index_post()
    {
        $data = [
            'userFullname' => $this->post('userFullname'),
            'userEmail' => $this->post('userEmail'),
            'userPhone' => $this->post('userPhone'),
            'userPassword' => $this->post('userPassword'),
        ];

        // Validasi input
        if (empty($data['userFullname']) || empty($data['userEmail']) || empty($data['userPassword'])) {
            $this->response(['message' => 'Fullname, Email, and Password are required'], RestController::HTTP_BAD_REQUEST);
            return;
        }

        // Cek apakah email sudah terdaftar
        $this->db->where('userEmail', $data['userEmail']);
        $existingUser = $this->db->get('user')->row();
        if ($existingUser) {
            $this->response(['message' => 'Email already registered'], RestController::HTTP_BAD_REQUEST);
            return;
        }

        // Hash password sebelum disimpan
        $data['userPassword'] = password_hash($data['userPassword'], PASSWORD_DEFAULT);

        // Simpan data ke database
        if ($this->db->insert('user', $data)) {
            $this->response(['message' => 'User registered successfully'], RestController::HTTP_CREATED);
        } else {
            $this->response(['message' => 'Failed to register user'], RestController::HTTP_INTERNAL_ERROR);
        }
    }
}
