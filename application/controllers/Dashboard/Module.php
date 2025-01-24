<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Module extends CI_Controller
{



    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('moduleModel');
        $this->session->userdata('adminId') ?: redirect('admin/login');
    }

    public function index()
    {

        // Initialize cURL session
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/learnify/api/Modules/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $modules = json_decode($response)->data;

        $ch2 = curl_init();
        curl_setopt($ch2, CURLOPT_URL, "http://localhost/learnify/api/Materials/");
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch2);
        curl_close($ch2);
        $materials = json_decode($response)->data;


        $datas = array(
            'title' => 'Module',
            'hidden' => '',
            'color' => 'blue',
            'modules' => $modules,
            'materials' => $materials,
            'csrf_token_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
        );

        $partials = array(
            'header' => 'templates/dashboard/header',
            'navigation' => 'templates/dashboard/navigation',
            'content' => 'dashboard/Module',
            'footer' => 'templates/dashboard/footer',
            'script' => 'templates/dashboard/script',
        );


        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }



    // public function post()
    // {
    //     $this->form_validation->set_rules('moduleName', 'Module Name', 'required|trim|max_length[100]');
    //     $this->form_validation->set_rules('moduleTags', 'Module Tags', 'required|trim|max_length[50]');
    //     $this->form_validation->set_rules('moduleDescription', 'Module Description', 'trim|max_length[100]');
    //     $this->form_validation->set_rules('materials[]', 'Material', 'required');

    //     // Custom error messages
    //     $error_messages = array(
    //         'required' => '{field} harus diisi.',
    //         'max_length' => '{field} tidak boleh lebih dari {param} karakter.',
    //     );

    //     foreach ($error_messages as $rule => $message) {
    //         $this->form_validation->set_message($rule, $message);
    //     }

    //     if ($this->form_validation->run() == FALSE) {
    //         $this->session->set_flashdata('validation_errors', validation_errors());
    //         redirect('dashboard/module');
    //     } else {
    //         $data = [
    //             'moduleName' => $this->input->post('moduleName'),
    //             'moduleTags' => $this->input->post('moduleTags'),
    //             'moduleDescription' => $this->input->post('moduleDescription'),
    //             'materials' => $this->input->post('materials'), // Checkbox values
    //         ];

    //         echo '<pre>';
    //         print_r($data);
    //         echo '</pre>';


    //         $ch = curl_init();
    //         curl_setopt($ch, CURLOPT_URL, "http://localhost/learnify/api/Modules/");
    //         curl_setopt($ch, CURLOPT_POST, 1);
    //         curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //         $response = curl_exec($ch);

    //         if (curl_errno($ch)) {
    //             $error_msg = curl_error($ch);
    //             curl_close($ch);
    //             $this->session->set_flashdata('error', 'Error saat menghubungi API: ' . $error_msg);
    //             redirect('dashboard/module');
    //         }

    //         curl_close($ch);
    //         $result = json_decode($response);

    //         if ($result->status) {
    //             $this->session->set_flashdata('success', 'Module berhasil ditambahkan');
    //             redirect('dashboard/module');
    //         } else {
    //             $this->session->set_flashdata('error', $result->message);
    //             redirect('dashboard/module');
    //         }
    //     }
    // }


    public function store()
    {
        // Validasi data input
        $this->form_validation->set_rules('moduleName', 'Module Name', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('moduleTags', 'Module Tags', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('moduleDescription', 'Module Description', 'trim|max_length[255]');

        // Pesan kesalahan
        $this->form_validation->set_message('required', '{field} harus diisi.');
        $this->form_validation->set_message('max_length', '{field} tidak boleh lebih dari {param} karakter.');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('validation_errors', validation_errors());
            redirect('dashboard/module');
        } else {
            // Ambil data dari form
            $moduleData = [
                'moduleName' => $this->input->post('moduleName'),
                'moduleTags' => $this->input->post('moduleTags'),
                'moduleDescription' => $this->input->post('moduleDescription')
            ];
            $materials = $this->input->post('materials'); // Array materialID

            // Mulai transaksi database
            $this->db->trans_start();

            // Insert ke tabel `module`
            $this->db->insert('module', $moduleData);
            $moduleId = $this->db->insert_id(); // Dapatkan ID module yang baru dibuat

            // Insert ke tabel `module_has_material` jika ada materials
            if (!empty($materials) && is_array($materials)) {
                foreach ($materials as $materialId) {
                    $this->db->insert('module_has_material', [
                        'moduleID' => $moduleId,
                        'materialID' => $materialId
                    ]);
                }
            }

            // Akhiri transaksi database
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('error', 'Gagal menyimpan module.');
                redirect('dashboard/module');
            } else {
                $this->session->set_flashdata('success', 'Module berhasil ditambahkan.');
                redirect('dashboard/module');
            }
        }
    }

    public function update()
    {
        $moduleID = $this->input->post('moduleID');
        $moduleName = $this->input->post('moduleName');
        $moduleTags = $this->input->post('moduleTags');
        $moduleDescription = $this->input->post('moduleDescription');
        $materials = $this->input->post('materials');

        // Validasi input
        if (empty($moduleID) || empty($moduleName)) {
            echo json_encode(['status' => false, 'message' => 'Semua field wajib diisi.']);
            return;
        }

        // Update module
        $data = [
            'moduleName' => $moduleName,
            'moduleTags' => $moduleTags,
            'moduleDescription' => $moduleDescription,
        ];
        $this->db->where('moduleID', $moduleID);
        $updateModule = $this->db->update('module', $data);

        // Update materials di tabel module_has_materials
        $this->db->where('moduleID', $moduleID);
        $this->db->delete('module_has_material'); // Hapus data lama

        if (!empty($materials)) {
            $materialsData = [];
            foreach ($materials as $materialID) {
                $materialsData[] = [
                    'moduleID' => $moduleID,
                    'materialID' => $materialID,
                ];
            }
            $this->db->insert_batch('module_has_material', $materialsData); // Masukkan data baru
        }

        if ($updateModule) {
            redirect('dashboard/module');
        } else {
            redirect('dashboard/module');
        }
    }

    public function delete()
    {
        $moduleID = $this->input->post('moduleID', TRUE);

        // Mulai transaksi database
        $this->db->trans_start();

        // Hapus relasi di module_has_material
        $this->db->where('moduleID', $moduleID);
        $this->db->delete('module_has_material');

        // Hapus module dari tabel module
        $this->db->where('<moduleID></moduleID>', $moduleID);
        $this->db->delete('module');

        // Akhiri transaksi database
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Gagal menghapus module.');
        } else {
            $this->session->set_flashdata('success', 'Module berhasil dihapus!');
        }

        redirect('dashboard/module');
    }




    // public function validate_materials($materials)
    // {
    //     if (is_array($materials) && !empty($materials)) {
    //         foreach ($materials as $material) {
    //             if (!is_numeric($material)) {
    //                 $this->form_validation->set_message('validate_materials', 'Field {field} harus berisi angka yang valid.');
    //                 return FALSE;
    //             }
    //         }
    //         return TRUE;
    //     }

    //     $this->form_validation->set_message('validate_materials', 'Field {field} harus dipilih.');
    //     return FALSE;
    // }


    // public function update()
    // {
    //     $moduleID = $this->input->post('moduleID');

    //     $this->form_validation->set_rules('moduleName', 'Module Name', 'required|trim|max_length[100]');
    //     $this->form_validation->set_rules('moduleTags', 'Module Tags', 'required|trim|max_length[50]');
    //     $this->form_validation->set_rules('moduleDescription', 'Module Description', 'trim|max_length[100]');

    //     // Pesan kesalahan dalam bentuk array
    //     $error_messages = array(
    //         'required' => '{field} harus diisi.',
    //         'max_length' => '{field} tidak boleh lebih dari {param} karakter.',
    //     );

    //     // Mengatur pesan kesalahan menggunakan array
    //     foreach ($error_messages as $rule => $message) {
    //         $this->form_validation->set_message($rule, $message);
    //     }

    //     if ($this->form_validation->run() == FALSE) {
    //         $validation_errors = validation_errors();
    //         $this->session->set_flashdata('validation_errors', $validation_errors);
    //         log_message('error', 'Form validation failed: ' . $validation_errors); // Log validation errors
    //         redirect('dashboard/module');
    //     } else {
    //         $data = [
    //             'moduleName' => $this->input->post('moduleName'),
    //             'moduleTags' => $this->input->post('moduleTags'),
    //             'moduleDescription' => $this->input->post('moduleDescription'),
    //         ];

    //         // Log the data being sent
    //         log_message('debug', 'Data to be sent: ' . json_encode($data));

    //         $ch = curl_init(); // Inisialisasi cURL
    //         curl_setopt($ch, CURLOPT_URL, 'http://localhost/learnify/api/Modules/' . $moduleID);
    //         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); // Set metode PUT
    //         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Set data yang akan dikirim
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Set return value ke variable
    //         curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    //             'Content-Type: application/json',
    //             'X-CSRF-TOKEN: ' . $this->security->get_csrf_hash()
    //         )); // Set header request

    //         $response = curl_exec($ch);
    //         curl_close($ch);
    //         $result = json_decode($response);

    //         // Log the response
    //         log_message('debug', 'API Response: ' . $response);

    //         if ($result->status) {
    //             log_message('debug', 'Module successfully updated: ' . json_encode($data)); // Log success
    //             $this->session->set_flashdata('success', 'Module berhasil Diubah');
    //             redirect('dashboard/module');
    //         } else {
    //             $message = isset($result->message) ? $result->message : 'Terjadi kesalahan saat menghubungi API';
    //             log_message('error', 'Failed to update module: ' . $message); // Log failure
    //             $this->session->set_flashdata('error', $message);
    //             redirect('dashboard/module');
    //         }
    //     }
    // }
}

/* End of file Module.php */
