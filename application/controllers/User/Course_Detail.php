<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Course_Detail extends CI_Controller {

    public function index()
    {
        $templates = array(
            'head' => 'Templates/User/head',
            'navbar' => '',
            'content' => 'User/course_detail',
            'footer'=> '',
            'script' => 'Templates/User/script',
        );

        $this->load->view('master_user', $templates);
    }

}

/* End of file Learning.php */

?>