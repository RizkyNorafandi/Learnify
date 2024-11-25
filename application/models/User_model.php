<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function check_user($username, $password) {
        $this->db->where('username', $username);
        $this->db->where('password', md5($password));
        $query = $this->db->get('users'); // 'users' adalah nama tabel dalam database

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }
}
