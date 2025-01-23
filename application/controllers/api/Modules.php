<?php

defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Modules extends RestController {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('moduleModel');
    }

    public function index_post() {
        $input = json_decode(trim(file_get_contents('php://input')), true);// mengubah data json menjadi array

        if (is_array($input)) { // jika data yang diterima berupa array, maka akan menjalankan fungsi if
            $this->form_validation->set_data($input);
            $moduleDatas = array(
                'moduleName' => $input['moduleName'] ?? null,
                'moduleDescription' => $input['moduleDescription'] ?? null
            );
            $materialIDs = $input['materialIDs'] ?? null;
        } else { // jika data yang diterima bukan berupa array, maka akan menjalankan fungsi else dan membuat sebuah array dan mengambil data dari permintaan post
            $moduleDatas = array(
                'moduleName' => $this->post('moduleName'),
                'moduleDescription' => $this->post('moduleDescription')
            );
            $materialIDs = $this->post('materialIDs');
        }

        $validate = array( //aturan validasi inputan
            array(
                'field' => 'moduleName',
                'label' => 'Module Name',
                'rules' => 'required|trim|max_length[100]',
            ),
            array(
                'field' => 'moduleDescription',
                'label' => 'Module Description',
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'materialIDs',
                'label' => 'Material ID',
                'rules' => 'numeric'
            )
        );
        $this->form_validation->set_rules($validate);

        $error_messages = array( // mengatur error message
            'required' => '{field} harus diisi.',
            'max_length' => '{field} tidak boleh lebih dari {param} karakter.',
            'numeric' => '{field} harus berupa angka.',
        );

        foreach ($error_messages as $rule => $message) { // 
            $this->form_validation->set_message($rule, $message);
        }

        if ($this->form_validation->run() == FALSE) {
            $this->response([
                'status' => FALSE,
                'message' => $this->form_validation->error_array()
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            try {
                $moduleID = $this->moduleModel->insertModule($moduleDatas, $materialIDs);
    
                $this->response([
                    'status' => TRUE,
                    'data' => [
                        'moduleID' => $moduleID
                    ]
                ], RestController::HTTP_CREATED);
            } catch (\Throwable $th) {
                $this->response([
                    'status' => FALSE,
                    'message' => $th->getMessage()
                ], RestController::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function index_get() {
        $moduleID = $this->get('id');

        if ($moduleID) {
            $data = $this->moduleModel->getModules($moduleID) ->result();
        } else {
            $data = $this->moduleModel->getModules()->result();
        }

        $this->form_validation->set_data(['id' => $moduleID ?: NULL]);
        $this->form_validation->set_rules('id', 'Module ID', 'trim|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->response([
                'status' => FALSE,
                'errors' => $this->form_validation->error_array()
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            $this->response([
                'status' => TRUE,
                'data' => $data
            ], RestController::HTTP_OK);
        }
    }     
}

?>