<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MaterialModel extends CI_Model
{

    public function createMaterial($data)
    {

        return $this->db->insert('material', $data);
    }

    public function updateMaterial($materialID, $data)
    {
        $this->db->where('materialID', $materialID);
        return $this->db->update('material', $data);
    }
}

/* End of file MaterialModel.php */
