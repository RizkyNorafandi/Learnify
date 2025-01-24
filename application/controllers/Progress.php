<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Progress extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        //Do your magic here


    }


    public function index() {}

    public function mark_complete()
    {
        // Ambil data dari form
        $userID = $this->input->post('userID');
        $materialID = $this->input->post('materialID');

        // Validasi data
        if (empty($userID) || empty($materialID)) {
            $this->session->set_flashdata('error', 'Invalid data!');
            redirect($_SERVER['HTTP_REFERER']);
        }

        // Load model
        $this->load->model('Progress_model');

        // Update progress
        $result = $this->Progress_model->markAsComplete($userID, $materialID);

        if ($result) {
            $this->session->set_flashdata('success', 'Progress marked as complete!');
        } else {
            $this->session->set_flashdata('error', 'Failed to mark progress as complete!');
        }

        // Redirect kembali ke halaman sebelumnya
        redirect($_SERVER['HTTP_REFERER']);
    }
}

/* End of file Controllername.php */
