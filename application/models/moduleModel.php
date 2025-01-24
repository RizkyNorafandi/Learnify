<?php

defined('BASEPATH') or exit('No direct script access allowed');

class moduleModel extends CI_Model
{

    public function insertModule($moduleDatas, $materialIDs = NULL)
    {
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

    public function createModule($data)
    {
        $this->db->trans_start(); // Mulai transaksi

        // Simpan data ke tabel module
        $moduleData = [
            'moduleID' => $data['moduleId'],
            'moduleName' => $data['moduleName'],
            'moduleTags' => $data['moduleTags'],
            'moduleDescription' => $data['moduleDescription']
        ];
        $this->db->insert('module', $moduleData);

        // Simpan data ke tabel module_has_materials
        if (!empty($data['materials'])) {
            $materials = $data['materials'];
            $moduleMaterialsData = [];

            foreach ($materials as $materialId) {
                $moduleMaterialsData[] = [
                    'moduleID' => $data['moduleId'],
                    'materialID' => $materialId
                ];
            }

            $this->db->insert_batch('module_has_materials', $moduleMaterialsData); // Simpan banyak sekaligus
        }

        $this->db->trans_complete(); // Selesaikan transaksi

        // Periksa apakah transaksi berhasil
        if ($this->db->trans_status() === FALSE) {
            return false;
        }

        return true;
    }


    public function getModules($moduleID = NULL)
    {
        if ($moduleID) {
            $this->db->select(
                '
                mo.*, 
                GROUP_CONCAT(ma.materialID SEPARATOR "|") AS materialIDs, 
                GROUP_CONCAT(ma.materialName SEPARATOR "|") AS materialNames'
            );
            $this->db->from('module mo');
            $this->db->join('module_has_material mm', 'mo.moduleID = mm.moduleID', 'left');
            $this->db->join('material ma', 'mm.materialID = ma.materialID', 'left');
            $this->db->where('mo.moduleID', $moduleID);
            $query = $this->db->get();
        } else {
            $this->db->select(
                '
                mo.*, 
                GROUP_CONCAT(DISTINCT ma.materialID SEPARATOR "|") AS materialIDs, 
                GROUP_CONCAT(DISTINCT ma.materialName SEPARATOR "|") AS materialNames'
            );
            $this->db->from('module mo');
            $this->db->join('module_has_material mm', 'mo.moduleID = mm.moduleID', 'left');
            $this->db->join('material ma', 'mm.materialID = ma.materialID', 'left');
            $this->db->group_by('mo.moduleID');
            $query = $this->db->get();
        }
        return $query;
    }

    public function updateModule($moduleID, $moduleDatas, $materialIDs = NULL)
    {
        $this->db->where('moduleID', $moduleID); // Tentukan modul mana yang ingin diupdate
        $this->db->update('module', $moduleDatas); // Update data pada tabel 'module'

        // Jika ada material yang diupdate
        if ($materialIDs) {
            // Hapus material lama yang terhubung dengan moduleID
            $this->db->delete('module_has_material', array('moduleID' => $moduleID));

            // Siapkan data baru untuk relasi module dan material
            $materials = array();
            foreach ($materialIDs as $materialID) {
                $materials[] = array(
                    'moduleID' => $moduleID,
                    'materialID' => (int) $materialID
                );
            }

            // Insert batch material baru
            $this->db->insert_batch('module_has_material', $materials);
        }

        return true;
    }

    public function deleteModule($moduleID)
    {

        // Hapus relasi material yang terkait dengan module
        $this->db->where('moduleID', $moduleID);
        $this->db->delete('module_has_material'); // Menghapus relasi material dengan module

        // Hapus data modul itu sendiri
        $this->db->where('moduleID', $moduleID);
        return $this->db->delete('module'); // Menghapus data modul
    }

    public function get_module_count()
    {
        return $this->db->count_all('module');
    }

    public function create_module($data)
    {
        $this->db->insert('module', $data);
        return $this->db->affected_rows();
    }

    public function update_Module($moduleID, $data)
    {
        $this->db->where('moduleID', $moduleID);
        return $this->db->update('module', $data);
    }
}


    


/* End of file moduleModel.php */
