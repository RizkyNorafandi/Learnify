<?php
defined('BASEPATH') or exit('No direct script access allowed');

class userModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Fungsi untuk mendaftar pengguna baru
    public function register($data)
    {
        // Hash password sebelum menyimpan
        $data['userPassword'] = password_hash($data['userPassword'], PASSWORD_BCRYPT);
        return $this->db->insert('user', $data);
    }

    // Fungsi untuk login
    public function login($email, $password)
    {
        $this->db->where('userEmail', $email);
        $query = $this->db->get('user');

        if ($query->num_rows() == 1) {
            $user = $query->row();
            // Verifikasi password
            if (password_verify($password, $user->userPassword)) {
                return $user; // Kembalikan data pengguna jika password cocok
            }
        }
        return false; // Jika tidak ada pengguna yang cocok atau password salah
    }

    // Fungsi untuk logout (hanya menghapus session)
    public function logout()
    {
        // Tidak ada operasi database yang diperlukan untuk logout
        return true;
    }
}
