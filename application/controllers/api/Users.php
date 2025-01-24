<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Users extends RestController {

    public function __construct()
    {
        parent::__construct();

        if ($this->input->method() == 'post' || $this->input->method() == 'put' || $this->input->method() == 'delete') {
            $csrf_token = $this->input->server('X-CSRF-TOKEN');
            $csrf_cookie = $this->input->cookie('csrf_cookie_name');
            if ($csrf_token !== $csrf_cookie) {
                $this->response(['status' => FALSE, 'message' => 'Invalid CSRF token'], RestController::HTTP_FORBIDDEN);
                return;
            }
        }

        $this->load->model('userModel');
    }

    // Endpoint: GET /users
    public function index_get() {
        $id = $this->get('id'); // Ambil parameter 'id' jika ada

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

    //Endpoint: GET /users/count 
    public function count_get()
    {
        $user_count = $this->userModel->get_user_count();
        $this->response([
            'status' => TRUE,
            'user_count' => $user_count
        ], RestController::HTTP_OK);
    }

    // Endpoint: POST /users
    public function index_post()
    {
        $data = [
            'userFullname' => $this->put('userFullname'),
            'userEmail' => $this->put('userEmail'),
            'userPhone' => $this->put('userPhone'),
            'userPassword' => $this->put('userPassword'),
            'userAddress' => $this->put('userAddress'),
            'userPhoto' => $this->put('userPhoto'),
        ];

        // Masukkan data ke tabel user
        if ($this->db->insert('user', $data)) {
            $this->response(['message' => 'Student created successfully'], RestController::HTTP_CREATED);
        } else {
            $this->response(['message' => 'Failed to create student'], RestController::HTTP_BAD_REQUEST);
        }
    }

    // Endpoint: PUT /users
    public function index_put() {
        $id = $this->put('id');
        if (!$id) {
            $this->response(['message' => 'ID is required'], RestController::HTTP_BAD_REQUEST);
            return;
        }

        // Ambil data yang dikirim dalam body PUT
        $data = [
            'userFullname' => $this->put('userFullname'),
            'userEmail' => $this->put('userEmail'),
            'userPhone' => $this->put('userPhone'),
            'userPassword' => $this->put('userPassword'),
            'userAddress' => $this->put('userAddress'),
            'userPhoto' => $this->put('userPhoto'),
        ];

        // Filter data yang tidak dikirim (agar tidak diupdate dengan null)
        $data = array_filter($data, function ($value) {
            return $value !== null;
        });

        // Hash password jika diubah
        if (isset($data['userPassword'])) {
            $data['userPassword'] = password_hash($data['userPassword'], PASSWORD_BCRYPT);
        }

        // Update data berdasarkan ID
        $this->db->where('userID', $id);
        if ($this->db->update('user', $data)) {
            $this->response(['message' => 'User updated successfully'], RestController::HTTP_OK);
        } else {
            $this->response(['message' => 'Failed to update user'], RestController::HTTP_BAD_REQUEST);
        }
    }

    // Endpoint: DELETE /users
    public function index_delete() {
        $id = $this->delete('id');
        if (!$id) {
            $this->response(['message' => 'ID is required'], RestController::HTTP_BAD_REQUEST);
            return;
        }

        // Hapus data berdasarkan ID
        $this->db->where('userID', $id);
        if ($this->db->delete('user')) {
            $this->response(['message' => 'Student deleted successfully'], RestController::HTTP_OK);
        } else {
            $this->response(['message' => 'Failed to delete student'], RestController::HTTP_BAD_REQUEST);
        }
    }

    // Endpoint: POST /users/login
    public function login_post() {
        $email = $this->post('email');
        $password = $this->post('password');
        $user = $this->userModel->login($email, $password);

        if ($user) {
            $this->session->set_userdata('userID', $user->userID);
            $this->session->set_userdata('userEmail', $user->userEmail);
            $this->response([
                'status' => true,
                'message' => 'Login berhasil',
                'data' => [
                    'userID' => $user->userID,
                    'userFullname' => $user->userFullname,
                    'userEmail' => $user->userEmail,
                    'userPhone' => $user->userPhone,
                    'userAddress' => $user->userAddress,
                    'userPhoto' => $user->userPhoto,
                ]
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Email atau password salah'
            ], RestController::HTTP_UNAUTHORIZED);
        }
    }

    // Endpoint: POST /users/register
    public function register_post()
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
        $data['userPassword'] = password_hash($data['userPassword'], PASSWORD_BCRYPT);

        // Simpan data ke database
        if ($this->db->insert('user', $data)) {
            $this->response(['message' => 'User registered successfully'], RestController::HTTP_CREATED);
        } else {
            $this->response(['message' => 'Failed to register user'], RestController::HTTP_INTERNAL_ERROR);
        }
    }

    public function logout_post() {
        $this->session->unset_userdata('userID');
        $this->session->sess_destroy();

        $this->response([
            'status' => true,
            'message' => 'Logout berhasil'
        ], RestController::HTTP_OK);
    }
}
