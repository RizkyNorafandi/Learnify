<?php

defined('BASEPATH') or exit('No direct script access allowed');

class profileModel extends CI_Model
{
    public function insertUser($userDatas = NULL)
    {
        $this->db->trans_start();

        $this->db->insert('user', $userDatas);
    }

    public function getUserPhoto($userID)
    {
        $this->db->select('userPhoto');
        $this->db->where('userID', $userID);
        $query = $this->db->get('user'); // Sesuaikan nama tabel
        return !empty($query->row()->userPhoto) ? $query->row()->userPhoto : null;
    }

    public function updateProfile($userID, $data)
    {
        $this->db->where('userID', $userID);
        return $this->db->update('user', $data); // Sesuaikan nama tabel
    }
}

/* End of file ModelName.php */
