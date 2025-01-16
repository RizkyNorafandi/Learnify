<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends CI_Controller {

    public function index() {
        $templates = array(
            'head' => 'Templates/User/head',
            'navbar' => 'Templates/User/navbar',
            'content' => 'User/course',
            'footer'=> 'Templates/User/footer',
            'script' => 'Templates/User/script',
        );

        $this->load->view('master_user', $templates);
    }

}

/* End of file Learning.php */

?>