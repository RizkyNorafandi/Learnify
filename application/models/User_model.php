<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Fungsi untuk logout (hanya menghapus session)
    public function logout()
    {
        return true;
    }

    public function get_user_by_email($userEmail)
    {
        return $this->db->get_where('user', ['userEmail' => $userEmail])->row_array();
    }


    public function register_user($data)
    {
        $this->db->insert('user', $data); // Insert data into 'user' table
        return $this->db->affected_rows() > 0;
    }
}
