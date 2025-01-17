<?php
defined('BASEPATH') or exit('No direct script access allowed');

class userModel extends CI_Model
{
    // Fungsi untuk mendaftar pengguna baru
    public function register($data)
    {
        // Hash password sebelum menyimpan
        $data['userPassword'] = password_hash($data['userPassword'], PASSWORD_BCRYPT);
        return $this->db->insert('user', $data);
    }

    // Fungsi untuk login
    public function login($email, $password) {
        $this->db->where('userEmail', $email);
        $query = $this->db->get('user');

        if ($query->num_rows() == 1) {
            $user = $query->row();
            if (password_verify($password, $user->userPassword)) {
                return $user;
            }
        }
        return false;
    }

    // Fungsi untuk logout (hanya menghapus session)
    public function logout()
    {
        // Tidak ada operasi database yang diperlukan untuk logout
        return true;
    }
}
