<?php

defined('BASEPATH') or exit('No direct script access allowed');

class learning extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    // Fungsi untuk mengambil semua data course
    public function get_material()
    {
        $query = $this->db->get('material');
        return $query->result();
    }

    // Fungsi untuk mengambil course berdasarkan courseID dan moduleID
    public function getMaterial($materialID = NULL) {
        if ($materialID) {
            $this->db->select('
                ma.*, 
                GROUP_CONCAT(ma.materialID SEPARATOR "|") AS materialIDs,
                GROUP_CONCAT(ma.materialName SEPARATOR "|") AS materialNames,
                GROUP_CONCAT(ma.materialContent SEPARATOR "|") AS materialContent
            ');
            $this->db->from('material ma');
            // $this->db->join('course_has_module cm', 'cm.courseID = co.courseID', 'left');
            // $this->db->join('module mo', 'mo.moduleID = cm.moduleID', 'left');
            $this->db->where('ma.materialID', $materialID);
            $query = $this->db->get();
        } else {
            $this->db->select('
                ma.*, 
                GROUP_CONCAT(ma.materialID SEPARATOR "|") AS materialIDs,
                GROUP_CONCAT(ma.materialName SEPARATOR "|") AS materialNames,
                GROUP_CONCAT(ma.materialContent SEPARATOR "|") AS materialContent
            ');
            $this->db->from('course co');
            $this->db->join('course_has_module cm', 'cm.courseID = co.courseID', 'left');
            $this->db->join('module mo', 'mo.moduleID = cm.moduleID', 'left');
            $this->db->group_by('co.courseID');
            $query = $this->db->get();
        }
        return $query;
    }
    

    // Fungsi untuk menambahkan course baru
    public function insertCourse($data)
    {
        return $this->db->insert('course', $data);
    }

    // Fungsi untuk memperbarui data course
    public function updateCourse($courseID, $data)
    {
        $this->db->where('CourseID', $courseID);
        return $this->db->update('course', $data);
    }

    public function deleteCourse($courseID)
    {
        $this->db->where('courseID', $courseID);
        return $this->db->delete('course');
    }
}
