<?php

use SebastianBergmann\Environment\Console;

defined('BASEPATH') or exit('No direct script access allowed');

class CourseModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Fungsi untuk mengambil semua data course
    public function get_courses()
    {
        $query = $this->db->get('course'); // Mengambil semua data dari tabel course
        return $query->result(); // Mengembalikan hasil sebagai array objek
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

    public function get_course_count()
    {
        return $this->db->count_all('course');
    }
}
