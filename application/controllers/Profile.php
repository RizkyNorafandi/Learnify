<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{

    public function index()
    {
        $templates = array(
            'head' => 'Templates/User/head',
            'navbar' => 'Templates/User/navbar',
            'content' => 'User/profile_page',
            'footer' => '',
            'script' => 'Templates/User/script',
        );

        $this->load->view('masterUser', $templates);
    }
}

/* End of file Learning.php */
