<?php 
 
    class Activity_model extends CI_Model { // Our Home_model class extends the Model class
         
        function category(){
        	$this->db->select('cat_id,category_name');
        	$this->db->where('active_status',1);
        	$category=$this->db->get('category_master')->result_array();
        	return $category;
        }
		
		
    }
     
/* End of file Home_model.php */
/* Location: ./application/models/Home_model.php */