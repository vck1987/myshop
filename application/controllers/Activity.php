<?php

class Activity extends CI_Controller { // Our Activity class extends the Controller class
     
     function __construct() {
        parent::__construct();
        $this->load->model('activity_model'); // Load our Activity model for our entire class
        $ip_add = getenv("REMOTE_ADDR");
    }

    function categoryhome(){

       
      
        $this->load->view('index',$data);
    }

}
/* End of file Activity.php */
/* Location: ./application/controllers/Activity.php */
