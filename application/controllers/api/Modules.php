<?php

use chriskacerguis\RestServer\RestController;

defined('BASEPATH') or exit('No direct script access allowed');

class Modules extends RestController
{


    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('moduleModel');
    }


    public function index_get($id = 0)
    {

        $check_data = $this->db->get_where('module', ['moduleID' => $id])->row_array();

        if ($id) {
            if ($check_data) {
                $data = $this->db->get_where('module', ['moduleID' => $id])->row_array();

                $this->response($data, RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Data Tidak Ditemukan'
                ], 404);
            }
        } else {
            $data = $this->db->get('module')->result();
            $this->response($data, RestController::HTTP_OK);
        }
    }

    //Endpoint: GET /modules/count 
    public function count_get()
    {
        $module_count = $this->moduleModel->get_module_count();
        $this->response([
            'status' => TRUE,
            'module_count' => $module_count
        ], RestController::HTTP_OK);
    }
}

/* End of file Modules.php */
