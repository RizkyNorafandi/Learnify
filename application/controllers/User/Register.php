<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }


    public function index()
    {
        $datas = array(
            'title' => 'Login',
            'hidden' => '',
            'color' => 'blue',
            'is_login_page' => true, // Indikator halaman login
            'csrf_token_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
        );

        $partials = array(
            'head' => 'templates/dashboard/header',
            'navbar' => '',
            'content' => 'user/register_page',
            'footer' => '',
            'script' => 'templates/dashboard/script',
        );

        $this->load->vars($datas);
        $this->load->view('master_user', $partials);
    }


    public function submit_post()
    {
        // Define form validation rules
        $this->form_validation->set_rules('userFullname', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('userEmail', 'Email', 'required|trim|valid_email|is_unique[user.userEmail]', [
            'is_unique' => 'This email is already registered.',
        ]);
        $this->form_validation->set_rules('userPhone', 'Phone Number', 'required|trim|numeric');
        $this->form_validation->set_rules('userPassword', 'Password', 'required|min_length[6]|trim');
        $this->form_validation->set_rules('reenterPassword', 'Re-enter Password', 'required|matches[userPassword]|trim');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, reload the form with error messages
            $this->session->set_flashdata('error', validation_errors());
            redirect('register');
        } else {
            // Validation succeeded, process the data
            $data = [
                'userFullname' => $this->input->post('userFullname', TRUE),
                'userEmail' => $this->input->post('userEmail', TRUE),
                'userPhone' => $this->input->post('userPhone', TRUE),
                'userPassword' => password_hash($this->input->post('userPassword', TRUE), PASSWORD_BCRYPT),
            ];

            $insert = $this->User_model->register_user($data);

            if ($insert) {
                $this->session->set_flashdata('success', 'Registration successful! You can now log in.');
                redirect('login');
            } else {
                $this->session->set_flashdata('error', 'Failed to register. Please try again later.');
                redirect('register');
            }
        }
    }
}

/* End of file Register.php */
