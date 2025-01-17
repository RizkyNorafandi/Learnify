<?php

use SebastianBergmann\Environment\Console;

defined('BASEPATH') or exit('No direct script access allowed');

class courseModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    // Fungsi untuk mengambil semua data course
    public function get_courses()
    {
        $query = $this->db->get('course');
        return $query->result();
    }

    public function insertCourse($data)
    {
        return $this->db->insert('course', $data);
    }

    public function updateCourse($courseID, $data)
    {
        $this->db->where('courseID', $courseID);
        return $this->db->update('course', $data);
    }
}
