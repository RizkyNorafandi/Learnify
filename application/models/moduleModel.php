<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModuleModel extends CI_Model
{

    public function get_module_count()
    {
        return $this->db->count_all('module');
    }
}

/* End of file ModuleModel.php */
