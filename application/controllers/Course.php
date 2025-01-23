<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->session->userdata('userID') ?: redirect('login');
    }

    public function index() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/learnify/api/courses");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $courses = json_decode($output)->data;
        
        $datas = array(
            'title' => 'Course',
            'courses' => $courses,
        );

        $templates = array(
            'head' => 'Templates/User/head',
            'navbar' => 'Templates/User/navbar',
            'content' => 'User/course',
            'footer'=> 'Templates/User/footer',
            'script' => 'Templates/User/script',
        );

        $this->load->vars($datas);
        $this->load->view('masterUser', $templates);
    }

    public function details() {
        $courseID = $this->input->get('id');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost/learnify/api/courses?id='.$courseID);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $course = json_decode($output)->data[0];

        $datas = array(
            'title' => $course->courseName,
            'course' => $course,
            'courseID' => $course->courseID,
            'materialID' => $course->modules[0]->materials[0]->materialID,
        );

        $templates = array(
            'head' => 'Templates/User/head',
            'navbar' => '',
            'content' => 'User/courseDetails',
            'footer'=> '',
            'script' => 'Templates/User/script',
        );

        $this->load->vars($datas);
        $this->load->view('masterUser', $templates);
    }



}

/* End of file Learning.php */

?>