<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class moduleModel extends CI_Model {

    public function insertModule($moduleDatas, $materialIDs = NULL) {
        $this->db->trans_start();

        $this->db->insert('module', $moduleDatas);
        $moduleID = $this->db->insert_id();

        if ($materialIDs) {
            $materials = array();
            foreach ($materialIDs as $materialID) {
                $materials[] = array(
                    'moduleID' => $moduleID,
                    'materialID' => (int) $materialID
                );
            }
            $this->db->insert_batch('module_has_material', $materials);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return $moduleID;
        }
    }

    public function getModules($moduleID = NULL) {
        if ($moduleID) {
            $this->db->select('
                mo.*, 
                GROUP_CONCAT(ma.materialID SEPARATOR "|") AS materialIDs, 
                GROUP_CONCAT(ma.materialName SEPARATOR "|") AS materialNames'
            );
            $this->db->from('module mo');
            $this->db->join('module_has_material mm', 'mo.moduleID = mm.moduleID', 'left');
            $this->db->join('material ma', 'mm.materialID = ma.materialID', 'left');
            $this->db->where('mo.moduleID', $moduleID);
            $query = $this->db->get();
            return $query->row_array();
        } else {
            $this->db->select('
                mo.*, 
                GROUP_CONCAT(DISTINCT ma.materialID SEPARATOR "|") AS materialIDs, 
                GROUP_CONCAT(DISTINCT ma.materialName SEPARATOR "|") AS materialNames'
            );
            $this->db->from('module mo');
            $this->db->join('module_has_material mm', 'mo.moduleID = mm.moduleID', 'left');
            $this->db->join('material ma', 'mm.materialID = ma.materialID', 'left');
            $this->db->group_by('mo.moduleID');
            $query = $this->db->get();
            return $query->result_array();
        }
    }

}

/* End of file moduleModel.php */

?>