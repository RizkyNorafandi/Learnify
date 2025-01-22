<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Orders extends RestController {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('orderModel');
    }
    

    public function index_post() {
      $data = [
        'courseID' => $this->post('courseID'),
        'userID' => $this->post('userID'),
        'orderNumber' => $this->post('orderNumber'),
        'orderStatus' => $this->post('orderStatus'),
      ];

      
    }
}
?>