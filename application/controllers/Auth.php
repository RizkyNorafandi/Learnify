<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();


        $this->load->model('userModel');
    }

    public function loginPage() {
        $datas = array(
            'title' => 'Login',
            'hidden' => '',
            'color' => 'blue',
            'is_login_page' => true,
        );

        $partials = array(
            'head' => 'templates/dashboard/header',
            'navbar' => '',
            'content' => 'user/login',
            'footer' => '',
            'script' => 'templates/dashboard/script',
        );

        $this->load->vars($datas);
        $this->load->view('masterUser', $partials);
    }

    public function login() {
        $this->form_validation->set_rules('userEmail', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('userPassword', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('login');
        } else {
            $data = [
                'email' => $this->input->post('userEmail'),
                'password' => $this->input->post('userPassword')
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://localhost/learnify/api/users/login');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'X-CSRF-TOKEN: ' . $this->security->get_csrf_hash()
            ));

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                show_error(curl_error($ch));
                redirect('login');
            }

            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($http_code == 200) {
                $result = json_decode($response);
                $this->session->set_userdata('userID', $result->data->userID);
                $this->session->set_userdata('userEmail', $result->data->userEmail);
                redirect('home');
            } else {
                $this->session->set_flashdata('error', 'Login failed. Please try again.' . $response);
                redirect('login');
            }
        }
    }

    public function registerPage() {
        $datas = array(
            'title' => 'Login',
            'hidden' => '',
            'color' => 'blue',
            'is_login_page' => true,
        );

        $partials = array(
            'head' => 'templates/dashboard/header',
            'navbar' => '',
            'content' => 'user/register',
            'footer' => '',
            'script' => 'templates/dashboard/script',
        );

        $this->load->vars($datas);
        $this->load->view('masterUser', $partials);
    }

    public function register() {
        $this->form_validation->set_rules('userFullname', 'Fullname', 'required');
        $this->form_validation->set_rules('userEmail', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('userPhone', 'Phone', 'required|numeric');
        $this->form_validation->set_rules('userPassword', 'Password', 'required');
        $this->form_validation->set_rules('reenterPassword', 'Password Confirmation', 'required|matches[userPassword]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('register');
        } else {
            $data = [
                'userFullname' => $this->input->post('userFullname'),
                'userEmail' => $this->input->post('userEmail'),
                'userPhone' => $this->input->post('userPhone'),
                'userPassword' => $this->input->post('userPassword')
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://localhost/learnify/api/users/register');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'X-CSRF-TOKEN: ' . $this->security->get_csrf_hash()
            ));

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                show_error(curl_error($ch));
                redirect('register');
            }

            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($http_code == 201) {
                redirect('login');
            } else {
                $this->session->set_flashdata('error', 'Registration failed. Please try again.' . $response);
                redirect('register');
            }
        }
    }
}
