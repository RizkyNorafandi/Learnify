<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Learning extends CI_Controller {

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
        $material = json_decode($output)->data;
        
        $datas = array(
            'title' => 'Material',
            'material' => $material,
        );

        $templates = array(
            'head' => 'Templates/Learning/head',
            'sidebar' => 'Templates/Learning/sidebar',
            'navbar' => 'Templates/Learning/navbar',
            'content' => 'User/Learning',
            'footer'=> '',
            'script' => 'Templates/Learning/script',
        );

        $this->load->vars($datas);
        $this->load->view('masterLearning', $templates);
    }



}

/* End of file Learning.php */

?>

