<?php
defined('BASEPATH') or exit('No direct script access allowed');

class adminModel extends CI_Model
{
    /**
     * Ambil data admin berdasarkan email
     */
    public function get_admin($adminEmail)
    {
        $admin = $this->db->get_where('admin', ['adminEmail' => $adminEmail])->row();
        log_message('debug', 'Admin Query Result: ' . print_r($admin, true));
        return $admin;
    }

    /**
     * Catat percobaan login
     */
    public function log_attempt($ip_address, $adminEmail)
    {
        $this->db->insert('login_attempts', [
            'ip_address' => $ip_address,
            'username' => $adminEmail,
            'attempt_time' => date('Y-m-d H:i:s') // Tambahkan waktu percobaan
        ]);
    }

    /**
     * Cek apakah user/IP melebihi batas percobaan login
     */
    public function is_brute_force($ip_address, $adminEmail)
    {
        $this->db->where('ip_address', $ip_address);
        $this->db->where('username', $adminEmail); // Cek juga berdasarkan email
        $this->db->where('attempt_time >=', date('Y-m-d H:i:s', strtotime('-15 minutes')));
        $attempts = $this->db->get('login_attempts')->num_rows();

        return $attempts >= 5; // Maksimal 5 percobaan dalam 15 menit
    }

    /**
     * Bersihkan percobaan login setelah berhasil
     */
    public function clear_attempts($ip_address, $adminEmail)
    {
        $this->db->where('ip_address', $ip_address);
        $this->db->where('username', $adminEmail);
        $this->db->delete('login_attempts');
    }

    /**
     * Perbarui waktu login terakhir admin
     */
    public function update_last_login($adminId)
    {
        $this->db->where('adminId', $adminId);
        $this->db->update('admin', ['last_login' => date('Y-m-d H:i:s')]);
    }
}
