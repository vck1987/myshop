<?php
class Products_model extends CI_Model{
 
    function get_all_product($productId){
    	
        $this->db->select('*');
        $this->db->from('products');
        if($productId > 0){
        	$this->db->where('product_id',$productId);
        }
        if($_REQUEST['limit']>0){
        	$this->db->limit($_REQUEST['limit']);
        }
        
        $products=$this->db->get()->result_array();
        
        return $products;
    }
     
}