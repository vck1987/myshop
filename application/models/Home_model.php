<?php 
 
    class Home_model extends CI_Model { // Our Home_model class extends the Model class
         
        function category(){
        	$this->db->select('cat_id,cat_title');
        	$this->db->where('active_status',1);
        	$category=$this->db->get('category_master')->result_array();
        	return $category;
        }

        function brand(){
        	$this->db->select('*');
        	$this->db->where('active_status',1);
        	$brands=$this->db->get('brands')->result_array();
        	return $brands;
        }

        function getCarousel(){
        	$this->db->select('caros_id,carousel_path');
        	$this->db->where('display_flag',1);
        	$carousel=$this->db->get('carousel_master')->result_array();
        	return $carousel;
        }
		
		function getCollection(){
        	$this->db->select('collect_id,collection_title,collection_img');
        	$this->db->where('display_flag',1);
        	$collection=$this->db->get('collection_master')->result_array();
        	return $collection;
        }

        function getHomeProducts(){
        	$this->db->select('*');
        	$this->from('products,categories');
        	$this->db->where('product_cat=cat_id');
        	$this->db->limit(10);
        	$homeProduct=$this->db->get()->result_array();
        	print_r($homeProduct);
        	// return $collection;
        }
     
    }
     
/* End of file Home_model.php */
/* Location: ./application/models/Home_model.php */