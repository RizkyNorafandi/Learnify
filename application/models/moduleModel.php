<?php
defined('BASEPATH') or exit('No direct script access allowed');

class moduleModel extends CI_Model
{

    public function get_module_count()
    {
        return $this->db->count_all('module');
    }

    public function create_module($data)
    {
        $this->db->insert('module', $data);
        return $this->db->affected_rows();
    }

    public function updateModule($moduleID, $data)
    {
        $this->db->where('moduleID', $moduleID);
        return $this->db->update('module', $data);
    }
}

/* End of file ModuleModel.php */
