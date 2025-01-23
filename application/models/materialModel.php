<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MaterialModel extends CI_Model
{

    public function getMaterialWithMedia($materialId = NULL)
    {
        if ($materialId) {
            $this->db->select('
                ma.*, 
                GROUP_CONCAT(DISTINCT me.mediaID SEPARATOR "|") AS mediaIDs, 
                GROUP_CONCAT(DISTINCT me.mediaName SEPARATOR "|") AS mediaNames, 
                GROUP_CONCAT(DISTINCT me.mediaType SEPARATOR "|") AS mediaTypes, 
            ');
            $this->db->from('material ma');
            $this->db->join('material_has_media mm', 'mm.materialID = ma.materialID', 'left');
            $this->db->join('media me', 'me.mediaID = mm.mediaID', 'left');
            $this->db->group_by('ma.materialID', $materialId);
            $query = $this->db->get();
            return $query->row_array();
        } else {
            $this->db->select('
            ma.*, 
            GROUP_CONCAT(DISTINCT me.mediaID SEPARATOR "|") AS mediaIDs, 
            GROUP_CONCAT(DISTINCT me.mediaName SEPARATOR "|") AS mediaNames, 
            GROUP_CONCAT(DISTINCT me.mediaType SEPARATOR "|") AS mediaTypes, 
        ');
            $this->db->from('material ma');
            $this->db->join('material_has_media mm', 'mm.materialID = ma.materialID', 'left');
            $this->db->join('media me', 'me.mediaID = mm.mediaID', 'left');
            $this->db->group_by('ma.materialID');
            $query = $this->db->get();
        }

        return $query;
    }



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
