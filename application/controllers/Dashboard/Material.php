<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Material extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('materialModel');
        $this->session->userdata('adminId') ?: redirect('admin/login');
    }

    public function index()
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/learnify/api/Materials/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        $materials = json_decode($response)->data;

        $datas = array(
            'title' => 'Materials',
            'materials' => $materials,
        );

        $partials = array(
            'header' => 'templates/dashboard/header',
            'navigation' => 'templates/dashboard/navigation',
            'content' => 'dashboard/material',
            'footer' => 'templates/dashboard/footer',
            'script' => 'templates/dashboard/script',
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function post()
    {


        $this->form_validation->set_rules('materialName', 'Nama Material ', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('materialContent', 'Konten', 'required');
        $this->form_validation->set_rules('materialTags', 'Tag Material', 'required');

        $error_messages = array(
            'required' => '{field} harus diisi.',
            'max_length' => '{field} tidak boleh lebih dari {param} karakter.',
        );

        foreach ($error_messages as $error => $message) {
            $this->form_validation->set_message($error, $message);
        }

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('dashboard/material');
        } else {
            $data = array(
                'materialName' => $this->input->post('materialName'),
                'materialContent' => $this->input->post('materialContent'),
                'materialTags' => $this->input->post('materialTags'),
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://localhost/learnify/api/Materials/");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($response);

            if ($result->status) {
                $this->session->set_flashdata('success', 'Material berhasil ditambahkan');
                redirect('dashboard/material');
            } else {
                $this->session->set_flashdata('error', $result->message);
                redirect('dashboard/material');
            }
        }
    }

    public function store()
    {
        // Validasi input
        $this->form_validation->set_rules('materialName', 'Nama Material', 'required|trim');
        $this->form_validation->set_rules('materialContent', 'Konten Material', 'trim');
        $this->form_validation->set_rules('materialTags', 'Tags Material', 'trim');
        $this->form_validation->set_rules('materialMediaUrl', 'URL Media', 'required|trim|valid_url');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('dashboard/material');
        }

        // Data material
        $materialData = [
            'materialName' => $this->input->post('materialName', TRUE),
            'materialContent' => $this->input->post('materialContent', TRUE),
            'materialTags' => $this->input->post('materialTags', TRUE),
        ];

        // Mulai transaksi database
        $this->db->trans_start();

        // Simpan data material
        $this->db->insert('material', $materialData);
        $materialId = $this->db->insert_id(); // Dapatkan ID material

        // Data media
        $mediaData = [
            'mediaName' => $this->input->post('materialMediaUrl', TRUE),
        ];
        $this->db->insert('media', $mediaData);
        $mediaId = $this->db->insert_id(); // Dapatkan ID media

        // Simpan relasi di material_has_media
        $pivotData = [
            'materialID' => $materialId,
            'MediaID' => $mediaId,
        ];
        $this->db->insert('material_has_media', $pivotData);

        // Akhiri transaksi database
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Gagal menyimpan material dan media.');
        } else {
            $this->session->set_flashdata('success', 'Material berhasil ditambahkan!');
        }

        redirect('dashboard/material');
    }


    public function update()
    {
        // Validasi input
        $this->form_validation->set_rules('materialName', 'Nama Material', 'required|trim');
        $this->form_validation->set_rules('materialContent', 'Konten Material', 'trim');
        $this->form_validation->set_rules('materialTags', 'Tags Material', 'trim');
        $this->form_validation->set_rules('materialMediaUrl', 'URL Media', 'required|trim|valid_url');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('dashboard/material');
        }

        $materialID = $this->input->post('materialID', TRUE);

        // Data material
        $materialData = [
            'materialName' => $this->input->post('materialName', TRUE),
            'materialContent' => $this->input->post('materialContent', TRUE),
            'materialTags' => $this->input->post('materialTags', TRUE),
        ];

        // Mulai transaksi database
        $this->db->trans_start();

        // Update data material
        $this->db->where('materialID', $materialID);
        $this->db->update('material', $materialData);

        // Data media
        $mediaData = [
            'mediaName' => $this->input->post('materialMediaUrl', TRUE),
        ];

        // Update atau insert data media jika perlu
        $existingMedia = $this->db->get_where('material_has_media', ['materialID' => $materialID])->row();
        if ($existingMedia) {
            $this->db->where('mediaID', $existingMedia->MediaID);
            $this->db->update('media', $mediaData);
        } else {
            $this->db->insert('media', $mediaData);
            $mediaId = $this->db->insert_id();

            $pivotData = [
                'materialID' => $materialID,
                'MediaID' => $mediaId,
            ];
            $this->db->insert('material_has_media', $pivotData);
        }

        // Akhiri transaksi database
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Gagal mengupdate material dan media.');
        } else {
            $this->session->set_flashdata('success', 'Material berhasil diperbarui!');
        }

        redirect('dashboard/material');
    }

    public function update_put()
    {
        $id = $this->input->post('courseID');
        // Set validation rules
        $this->form_validation->set_rules('materialName', 'Nama Material ', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('materialContent', 'Konten', 'required');
        $this->form_validation->set_rules('materialTags', 'Tag Material', 'required');

        $error_messages = array(
            'required' => '{field} harus diisi.',
            'max_length' => '{field} tidak boleh lebih dari {param} karakter.',
        );

        // Set custom error messages
        foreach ($error_messages as $error => $message) {
            $this->form_validation->set_message($error, $message);
        }

        // Run validation
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('dashboard/material');
        } else {
            // Prepare data for PUT request
            $data = array(
                'materialName' => $this->input->post('materialName'),
                'materialContent' => $this->input->post('materialContent'),
                'materialTags' => $this->input->post('materialTags'),
            );

            // Initialize cURL for PUT request
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://localhost/learnify/api/Materials/" . $id);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'X-CSRF-TOKEN: ' . $this->security->get_csrf_hash()
            ));

            // Execute the request and handle response
            $response = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($response);

            if ($result->status) {
                $this->session->set_flashdata('success', 'Material berhasil diperbarui');
                redirect('dashboard/material');
            } else {
                $this->session->set_flashdata('error', $result->message);
                redirect('dashboard/material');
            }
        }
    }

    public function delete()
    {
        $materialID = $this->input->post('materialID', TRUE);

        // Mulai transaksi database
        $this->db->trans_start();

        // Hapus relasi material_has_media
        $this->db->where('materialID', $materialID);
        $relations = $this->db->get('material_has_media')->result();

        foreach ($relations as $relation) {
            // Hapus data media terkait
            $this->db->where('mediaID', $relation->MediaID);
            $this->db->delete('media');
        }

        $this->db->where('materialID', $materialID);
        $this->db->delete('material_has_media');

        // Hapus data material
        $this->db->where('materialID', $materialID);
        $this->db->delete('material');

        // Akhiri transaksi database
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Gagal menghapus material.');
        } else {
            $this->session->set_flashdata('success', 'Material berhasil dihapus!');
        }

        redirect('dashboard/material');
    }
}

/* End of file Material.php */
