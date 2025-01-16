<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Course_Detail extends CI_Controller {

    public function index() {
        $courseID = $this->input->get('id');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost/learning/api/courses?id='.$courseID);
        
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