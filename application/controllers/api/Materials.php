<?php

defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Materials extends RestController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('materialModel');
    }

    // public function index_get()
    // {
    //     $id = $this->get('materialID');

    //     $check_data = $this->db->get_where('material', ['materialID' => $id])->row_array();

    //     if ($id) {
    //         if ($check_data) {
    //             $data = $this->materialModel->getMaterialWithMedia($id)->row_array();

    //             $this->response([
    //                 'status' => true,
    //                 'data' => $data
    //             ], RestController::HTTP_OK);
    //         } else {
    //             $this->response([
    //                 'status' => false,
    //                 'message' => 'Data Tidak Ditemukan'
    //             ], 404);
    //         }
    //     } else {
    //         $data = $this->materialModel->getMaterialWithMedia()->result();
    //         $this->response([
    //             'status' => true,
    //             'data' => $data
    //         ], RestController::HTTP_OK);
    //     }
    // }


    public function index_get()
    {
        $id = $this->get('id'); // Mendapatkan materialID dari request GET

        if ($id) {
            // Cek apakah data dengan materialID tertentu ada
            $check_data = $this->db->get_where('material', ['materialID' => $id])->row_array();

            if ($check_data) {
                // Ambil data material beserta media terkait
                $data = $this->materialModel->getMaterialWithMedia($id)->row_array();

                $this->response([
                    'status' => true,
                    'data' => $data
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Data Tidak Ditemukan'
                ], RestController::HTTP_NOT_FOUND);
            }
        } else {
            // Jika materialID tidak disediakan, ambil semua data
            $data = $this->materialModel->getMaterialWithMedia()->result();

            $this->response([
                'status' => true,
                'data' => $data
            ], RestController::HTTP_OK);
        }
    }



    // public function index_get()
    // {

    //     $id = $this->get('materialID');

    //     $check_data = $this->db->get_where('material', ['materialID' => $id])->row_array();

    //     if ($id) {
    //         if ($check_data) {
    //             $data = $this->db->get_where('material', ['materialID' => $id])->row_array();

    //             $this->response($data, RestController::HTTP_OK);
    //         } else {
    //             $this->response([
    //                 'status' => false,
    //                 'message' => 'Data Tidak Ditemukan'
    //             ], 404);
    //         }
    //     } else {
    //         $data = $this->db->get('material')->result();
    //         $this->response($data, RestController::HTTP_OK);
    //     }
    // }

    public function index_post()
    {
        $data = [
            'materialName' => $this->post('materialName'),
            'materialTags' => $this->post('materialTags'),
            'materialContent' => $this->post('materialContent'),
        ];


        if ($this->materialModel->createMaterial($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'Data berhasil ditambahkan'
            ], RestController::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal menambahkan data'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

    public function index_put($id)
    {
        // Decode JSON input
        $input = json_decode(trim(file_get_contents('php://input')), true);

        // Prepare data array for update
        $data = [
            'materialName' => $input['materialName'],
            'materialTags' => $input['materialTags'],
            'materialContent' => $input['materialContent'],
        ];

        // Log the data being updated
        log_message('debug', 'Data to be updated: ' . json_encode($data));

        // Update the material data in the database
        if ($this->materialModel->updateMaterial($id, $data)) {
            log_message('debug', 'Material successfully updated: ' . json_encode($data));
            $this->response([
                'status' => true,
                'message' => 'Material berhasil diperbarui!'
            ], RestController::HTTP_OK);
        } else {
            log_message('error', 'Failed to update material: ' . json_encode($data));
            $this->response([
                'status' => false,
                'message' => 'Gagal memperbarui material. Silakan coba lagi.'
            ], RestController::HTTP_INTERNAL_ERROR);
        }
    }
}
