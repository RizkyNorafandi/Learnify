<?php  

    defined('BASEPATH') or exit('No direct script access allowed');

    use chriskacerguis\RestServer\RestController;

    class Materials extends RestController {

        public function __construct()
        {
            parent::__construct();
            $this->load->model('materialModel');
        }

        public function index_get()
    {
        $id = $this->get('id');

        $check_data = $this->db->get_where('material', ['materialID' => $id])->row_array();

        if ($id) {
            if ($check_data) {
                $data = $this->materialModel->getMaterialWithMedia($id)->result();

                $this->response([
                    'status' => true,
                    'data' => $data
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Data Tidak Ditemukan'
                ], 404);
            }
        } else {
            $data = $this->materialModel->getMaterialWithMedia()->result();
            $this->response([
                'status' => true,
                'data' => $data
            ], RestController::HTTP_OK);
        }
    }

}

?>

