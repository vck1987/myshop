<?php 

class Store extends CI_Controller { // Our Store class extends the Controller class
     
     function __construct() {
        parent::__construct();
        // $this->load->model('store_model'); // Load our Store model for our entire class
        // ini_set('display_errors', 1);
    }

    function index($categoryId){
    	// echo $categoryId; die;
    	$postFieldArray = array();

    	if($categoryId > 0){
    		$postFieldArray ['cat_id'] = $categoryId;
    	}
    	
    	$url=base_url()."products/category/".$categoryId;
        $data=array('url' =>$url,'postfields' =>$postFieldArray );
        $dataArray=curlGet($data);
        $data=json_decode($dataArray, 'true');
    	
    	$this->load->view('store', $data);
    }


}