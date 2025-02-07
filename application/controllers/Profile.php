<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->session->userdata('userID') ?: redirect('login');
        $this->load->model('userModel');
        $this->load->model('profileModel');
    }

    public function index()
    {
        $userID = $this->session->userdata('userID');
        $user = $this->userModel->getUser($userID);
        $datas = array(
            'title' => 'Profile',
            'user' => $user,
        );
        $templates = array(
            'head' => 'Templates/User/head',
            'navbar' => 'Templates/User/navbar',
            'content' => 'User/profile',
            'footer' => 'Templates/User/footer',
            'script' => 'Templates/User/script',
        );
        $this->load->vars($datas);
        $this->load->view('masterUser', $templates);
    }

    public function updateProfile()
    {
        $userID = $this->session->userdata('userID');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $userData = array(
                'userFullname' => $this->input->post('userFullname', TRUE),
                'userEmail' => $this->input->post('userEmail', TRUE),
                'userPhone' => $this->input->post('userPhone', TRUE),
                'userAddress' => $this->input->post('userAddress', TRUE),
            );

            // Jika ada file gambar (foto profil)
            if (!empty($_FILES['userPhoto']['name'])) {
                // Konfigurasi upload
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = 2048; // Ukuran maksimal dalam KB
                $config['encrypt_name'] = TRUE; // Enkripsi nama file untuk mencegah konflik nama file

                // Load library upload dan set konfigurasi
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                // Validasi upload
                if (!$this->upload->do_upload('userPhoto')) {
                    // Menampilkan kesalahan jika ada masalah upload
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error); // Menyimpan error di session
                    redirect('profile');
                } else {
                    // Mendapatkan nama file yang berhasil diupload
                    $data = $this->upload->data();
                    $userData['userPhoto'] = $data['file_name']; // Simpan nama file gambar
                }
            }

            // Update data pengguna di database menggunakan model
            $updateStatus = $this->userModel->updateUser($userID, $userData);

            // Menangani hasil update
            if (!$updateStatus) {
                // Tampilkan query terakhir untuk debugging jika gagal
                log_message('error', 'Gagal update profil: ' . $this->db->last_query());
                $this->session->set_flashdata('error', 'Gagal mengubah profil. Coba lagi nanti.');
            } else {
                $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
            }

            // Redirect kembali ke halaman profil
            redirect('profile');
        }
    }

    public function update_profile()
    {
        // Validasi form input
        $this->form_validation->set_rules('userFullname', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('userEmail', 'Email', 'required|valid_email|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }

        // Ambil data dari form
        $userID = $this->session->userdata('userID'); // Pastikan sesi userID tersedia
        $data = [
            'userFullname' => $this->input->post('userFullname', true),
            'userEmail' => $this->input->post('userEmail', true),
            'userPhone' => $this->input->post('userPhone', true),
            'userAddress' => $this->input->post('userAddress', true),
        ];

        // Upload foto jika ada file yang diunggah
        if (!empty($_FILES['userPhoto']['name'])) {
            $config['upload_path'] = FCPATH . 'assets/uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB
            $config['file_name'] = 'profile_' . $userID . '_' . time();

            $this->load->library('upload', $config);

            $this->upload->initialize($config);

            if ($this->upload->do_upload('userPhoto')) {
                // Hapus foto lama jika ada
                $oldPhoto = $this->profileModel->getUserPhoto($userID);
                if ($oldPhoto && file_exists('assets/uploads/' . $oldPhoto)) {
                    unlink('assets/uploads/' . $oldPhoto);
                }

                // Simpan nama file foto barux
                $data['userPhoto'] = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect($_SERVER['HTTP_REFERER']);
            }
        }

        // Update data profil ke database
        if ($this->profileModel->updateProfile($userID, $data)) {
            $this->session->set_flashdata('success', 'Profile updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update profile.');
        }

        // Redirect kembali ke halaman profil
        redirect($_SERVER['HTTP_REFERER']);
    }
}
