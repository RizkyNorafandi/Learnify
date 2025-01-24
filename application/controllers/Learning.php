<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Learning extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('materialModel');
    }

    public function index()
    {
        $courseID = $this->input->get('courseID');
        $materialID = $this->input->get('materialID');

        // Get Courses Data for Learning Sidebar
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost/learnify/api/courses?id=' . $courseID);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output1 = curl_exec($ch);
        curl_close($ch);
        $course = json_decode($output1)->data[0];

        // Get Material Data for Learning Content
        $ch2 = curl_init();
        curl_setopt($ch2, CURLOPT_URL, 'http://localhost/learnify/api/Materials?id=' . $materialID);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
        $output2 = curl_exec($ch2);
        curl_close($ch2);
        $material = json_decode($output2)->data;

        $datas = array(
            'title' => $course->courseName,
            'sidebarData' => $course,
            
            'material' => $material,
            'activeMaterialID' => $materialID,
        ); //apakah perlu dicoba? 

        $templates = array(
            'head' => 'Templates/Learning/head',
            'sidebar' => 'Templates/Learning/sidebar',
            'navbar' => 'Templates/Learning/navbar',
            'content' => 'User/learning',
            'script' => 'Templates/Learning/script',
        );

        $this->load->vars($datas);
        $this->load->view('masterLearning', $templates);
    }
}

/* End of file Controllername.php */
