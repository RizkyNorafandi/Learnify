<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class profileModel extends CI_Model {
    public function insertUser ($userDatas = NULL) {
        $this->db->trans_start();

        this->db->insert('user', $userDatas);
        
    }

    

}

/* End of file ModelName.php */

?>