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
        if ($id) {
            $check_data = $this->db->get_where('module', ['moduleID' => $id])->row_array();

            if ($check_data) {
                $this->response([
                    'status' => true,
                    'data' => $check_data
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Data Tidak Ditemukan'
                ], RestController::HTTP_NOT_FOUND);
            }
        } else {
            $data = $this->db->get('module')->result();

            $this->response([
                'status' => true,
                'data' => $data
            ], RestController::HTTP_OK);
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

    public function index_post()
    {
        $data = [
            'moduleId' => $this->post('moduleId'),
            'moduleName' => $this->post('moduleName'),
            'moduleTags' => $this->post('moduleTags'),
            'moduleDescription' => $this->post('moduleDescription'),
        ];

        if ($this->moduleModel->create_module($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'Berhasil Meambahkan data'
            ], RestController::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal menambahkan data'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id = $this->put('moduleID');
        $data = [
            'moduleName' => $this->put('moduleName'),
            'moduleTags' => $this->put('moduleTags'),
            'moduleDescription' => $this->put('moduleDescription'),
        ];

        // Log the data being updated
        log_message('debug', 'Data to be updated: ' . json_encode($data));

        if ($this->moduleModel->updateModule($id, $data) > 0) {
            log_message('debug', 'Module successfully updated: ' . json_encode($data));
            $this->response([
                'status' => true,
                'message' => 'Data berhasil diupdate'
            ], RestController::HTTP_OK);
        } else {
            log_message('error', 'Failed to update module: ' . json_encode($data));
            $this->response([
                'status' => false,
                'message' => 'Gagal mengupdate data'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }
}

/* End of file Modules.php */
