<?php
class Product_model extends CI_Model{
 
    function get_all_product(){
        $result=$this->db->get('products');
        return $result;
    }
     
}