<?php

class Home_activity extends CI_Controller { // Our Home_activity class extends the Controller class
     
     function __construct() {
        parent::__construct();
        $this->load->model('home_activity_model'); // Load our Home_activity model for our entire class
        $ip_add = getenv("REMOTE_ADDR");
    }

    function categoryhome(){

       $category=$this->home_model->category();

       $html="<!-- responsive-nav -->
				<div id='responsive-nav'>
					<!-- NAV -->
					<ul class='main-nav nav navbar-nav'>
                   <li class='active'><a href='".base_url()."'>Home</a></li>";
                    foreach ($category as $catkey => $catvalue) {
                    	$cid = $catvalue["cat_id"];
						$cat_name = $catvalue["cat_title"];

        $html .="<li class='categoryhome' cid=".$cid."><a href='".base_url()."store/".$cid."#'>".strtoupper($cat_name)."</a></li>";
         }

        $html .="</ul>
					<!-- /NAV -->
				</div>
				<!-- /responsive-nav -->";


	echo $html;
      
    }

    function category(){

       $category=$this->home_model->category();

       $html="<div class='aside'>
				<h3 class='aside-title'>Categories</h3>
				<div class='btn-group-vertical'>";
                    foreach ($category as $catkey => $catvalue) {
                    	$cid = $catvalue["cat_id"];
						$cat_name = $catvalue["cat_title"];

						$this->db->select('count(*) as count');
						$this->db->where('product_cat',$cid);
						$count=$this->db->get('products')->row_array()['count'];


        $html .="<div type='button' class='btn navbar-btn category' cid='".$cid."' style='text-align: left;'>
									
									<a href='#'>
										<span >".$cat_name."</span>
										<small class='qty'>(".$count.")</small>
									</a>
								</div>";
         }

    $html .="</div></div>";
	echo $html;
      
    }

	function brand(){
		$brand=$this->home_model->brand();

		$html="<div class='aside'>
				<h3 class='aside-title'>Brand</h3>
				<div class='btn-group-vertical'>";

		foreach ($brand as $brandkey => $brandvalue) {
            	$bid = $brandvalue["brand_id"];
				$brand_name = $brandvalue["brand_title"];

				$this->db->select('count(*) as count');
				$this->db->where('product_brand',$bid);
				$count=$this->db->get('products')->row_array()['count'];

			$html .="<div type='button' class='btn navbar-btn selectBrand' bid='".$bid."' style='text-align: left;'>
							
							<a href='#'>
								<span >".$brand_name."</span>
								<small class='qty'>(".$count.")</small>
							</a>
						</div>";
				}
	$html .="</div>";
	echo $html;

	}

    function products(){
    	$postFieldArray=array();
    	$limit=$this->input->post('limit');

    	if($limit){
    		$url=base_url()."products?limit=".$limit;
    	}else{
    		$url=base_url()."products/";
    	}
    	
        $data=array('url' =>$url,'postfields' =>$postFieldArray );
        $dataArray=curlGet($data) ;
        $data=json_decode($dataArray, 'true');
        $count=count($data);
        $pageno = ceil($count/9);
        foreach($data as $row){
			$pro_id    = $row['product_id'];
            $pro_cat   = $row['product_cat'];
            $pro_brand = $row['product_brand'];
            $pro_title = $row['product_title'];
            $pro_price = $row['product_price'];
            $pro_image = $row['product_image'];
            $cat_name = $row["cat_title"];
        }
    }

    function getproducts(){

	$category=$this->input->post("cat_id");
    $brand=$this->input->post("brand_id");
    $keyword=$this->input->post("keyword");
    $limit = 9;
	if(!empty($this->input->post("setPage"))){
		$pageno = $this->input->post("pageNumber");
		$start = ($pageno * $limit) - $limit;
	}else{
		$start = 0;
	}
	
	$this->db->select('*');
	$this->db->from('products,category_master');
	$this->db->where('product_cat=cat_id');

	if($category > 0){
		$this->db->where('product_cat',$category);
	}

	if($brand > 0){
		$this->db->where('product_brand',$brand);
	}
	
	if(!empty($keyword)){
		$this->db->like('product_keywords', $keyword, 'both');
	}
	
	$this->db->limit($limit,$start);
	$productsData=$this->db->get()->result_array();
	
	// echo $this->db->last_query();
	$dataCount = count($productsData);
		if($dataCount > 0){
			foreach($productsData as $product){
				$pro_id    = $product['product_id'];
	            $pro_cat   = $product['product_cat'];
	            $pro_brand = $product['product_brand'];
	            $pro_title = $product['product_title'];
	            $pro_price = $product['product_price'];
	            $pro_image = $product['product_image'];
	            $cat_name = $product["cat_title"];

	            $html .="<div class='col-md-4 col-xs-6' >
								<a href='".base_url()."home/productview/".$pro_id."'>
								<div class='product'>
									<div class='product-img'>
										<img src='".base_url()."assets/img/products/".$pro_image."' style='max-height: 170px;' alt=''>
										<div class='product-label'>
											<span class='sale'>-30%</span>
											<span class='new'>NEW</span>
										</div>
									</div></a>
									<div class='product-body'>
										<p class='product-category'>".$cat_name."</p>
										<h3 class='product-name header-cart-item-name'><a href='".base_url()."home/productview/".$pro_id."'>".$pro_title."</a></h3>
										<h4 class='product-price header-cart-item-info'>".$pro_price."</h4>
										<div class='product-rating'>
											<i class='fa fa-star'></i>
											<i class='fa fa-star'></i>
											<i class='fa fa-star'></i>
											<i class='fa fa-star'></i>
											<i class='fa fa-star'></i>
										</div>
										<div class='product-btns'>
											<button class='add-to-wishlist'><i class='fa fa-heart-o'></i><span class='tooltipp'>add to wishlist</span></button>
											<button class='add-to-compare'><i class='fa fa-exchange'></i><span class='tooltipp'>add to compare</span></button>
											<button class='quick-view'><i class='fa fa-eye'></i><span class='tooltipp'>quick view</span></button>
										</div>
									</div>
									<div class='add-to-cart'>
										<button pid='".$pro_id."' id='product' class='add-to-cart-btn block2-btn-towishlist' href='#'>
										<i class='fa fa-shopping-cart'></i> add to cart</button>
									</div>
								</div>
							</div>";
	        }
		}
		echo $html;

    }
    function pagination(){
    	$postFieldArray=array();
    	$limit=$this->input->post('limit');

    	if($limit){
    		$url=base_url()."products?limit=".$limit;
    	}else{
    		$url=base_url()."products/";
    	}
    	
        $data=array('url' =>$url,'postfields' =>$postFieldArray );
        $dataArray=curlGet($data) ;
        $data=json_decode($dataArray, 'true');
        $count=count($data);
        $pageno = ceil($count/9);
        for($i=1;$i<=$pageno;$i++){
		echo "<li><a href='#product-row' page='$i' id='page' class='active'>$i</a></li>";
		}
        
    }
    

}

/* End of file Home_activity.php */
/* Location: ./application/controllers/Home_activity.php */
