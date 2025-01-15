<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CourseModel extends CI_Model
{

    // Validasi data course
    public function validate_course_data($data)
    {
        $this->load->library('form_validation');

        // Atur aturan validasi
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules('courseName', 'Nama Course', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('classCategory', 'Kategori', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('courseDescription', 'Deskripsi', 'required|trim|max_length[500]');
        $this->form_validation->set_rules('coursePrice', 'Harga', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('courseTags', 'Tags', 'required|trim|max_length[100]');

        // Set pesan kesalahan
        $this->form_validation->set_message('required', '{field} harus diisi.');
        $this->form_validation->set_message('max_length', '{field} tidak boleh lebih dari {param} karakter.');
        $this->form_validation->set_message('numeric', '{field} harus berupa angka.');
        $this->form_validation->set_message('greater_than_equal_to', '{field} harus lebih besar atau sama dengan {param}.');

        return $this->form_validation->run();
    }

    // Tambahkan course baru
    public function insert_course($data)
    {
        return $this->db->insert('course', $data);
    }

    // Perbarui course
    public function update_course($id, $data)
    {
        $this->db->where('CourseID', $id);
        return $this->db->update('course', $data);
    }
}
