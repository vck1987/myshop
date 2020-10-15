 <?php $this->load->view('common/header'); ?>



   <div class="main main-raised">
        <div class="container mainn-raised" style="width:100%;">
  
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
   

    <!-- Wrapper for slides -->
    <div class="carousel-inner">

		<?php 
			$carousel=$this->home_model->getCarousel(); 
			foreach ($carousel as $carouselKey => $carouselValue) {
			$carousel_path=base_url().$carouselValue['carousel_path'];
			// echo $carousel_path; die;
			$active=($carouselKey==0)?'active' : '';
		?>
      <div class="item <?php echo $active; ?>">
        <img src="<?php echo $carousel_path; ?>" alt="MyShop" style="width:100%;">
        
      </div>
<?php } ?>
       
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control _26sdfg" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only" >Previous</span>
    </a>
    <a class="right carousel-control _26sdfg" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>
     


		<!-- SECTION -->
		<div class="section mainn mainn-raised">
		
		
			<!-- container -->
			<div class="container">
			
				<!-- row -->
				<div class="row">
					<?php 
						$collection=$this->home_model->getCollection(); 
						foreach ($collection as $collectionKey => $collectionValue) {
						$collection_img=base_url().$collectionValue['collection_img'];
						 // echo $collection_img; die;
					
					?>
     

					<!-- shop -->
					<div class="col-md-4 col-xs-6">
						<a href="<?php echo base_url(); ?>product.php?p=<?php echo $collectionValue['collect_id']; ?>"><div class="shop">
							<div class="shop-img">
								<img src="<?php echo $collection_img; ?>" alt="">
							</div>
							<div class="shop-body">
								<h3><?php echo $collectionValue['collection_title']; ?><br>Collection</h3>
								<a href="<?php echo base_url(); ?>store/<?php echo $collectionValue['collect_id']; ?>" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div></a>
					</div>
					<!-- /shop -->
					<?php } ?>

				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->
		  
		

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title">
							<h3 class="title">New Products</h3>
							<div class="section-nav">
								<ul class="section-tab-nav tab-nav">
									<li class="active"><a data-toggle="tab" href="#tab1">Laptops</a></li>
									<li><a data-toggle="tab" href="#tab1">Smartphones</a></li>
									<li><a data-toggle="tab" href="#tab1">Cameras</a></li>
									<li><a data-toggle="tab" href="#tab1">Accessories</a></li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /section title -->

					<!-- Products tab & slick -->
					<div class="col-md-12 mainn mainn-raised">
						<div class="row">
							<div class="products-tabs">
								<!-- tab -->
								<div id="tab1" class="tab-pane active">
									<div class="products-slick" data-nav="#slick-nav-1" >
									
									<?php
				     					$url=base_url()."products?limit=10";
								        $data=array('url' =>$url,'postfields' =>$postFieldArray );
								        $dataArray=curlGet($data) ;
								        $data=json_decode($dataArray, 'true');
								        foreach($data as $row){
											$pro_id    = $row['product_id'];
					                        $pro_cat   = $row['product_cat'];
					                        $pro_brand = $row['product_brand'];
					                        $pro_title = $row['product_title'];
					                        $pro_price = $row['product_price'];
					                        $pro_image = $row['product_image'];
					                        $cat_name = $row["cat_title"];
					                 ?>

		                        		<div class='product'>
											<a href='<?php echo base_url(); ?>home/productview/<?php echo $pro_id; ?>'>
												<div class='product-img'>
													<img src='<?php echo base_url(); ?>assets/img/products/<?php echo $pro_image; ?>' style='max-height: 170px;' alt=''>
													<div class='product-label'>
														<span class='sale'>-30%</span>
														<span class='new'>NEW</span>
													</div>
												</div>
											</a>
											<div class='product-body'>
												<p class='product-category'><?php echo $cat_name; ?></p>
												<h3 class='product-name header-cart-item-name'>
													<a href='<?php echo base_url(); ?>home_activity/productview/<?php echo $pro_id; ?>'><?php echo $pro_title; ?></a>
												</h3>
												<h4 class='product-price header-cart-item-info'><?php echo $pro_price; ?></h4>
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
													<a href='<?php echo base_url(); ?>home/productview/<?php echo $pro_id; ?>'>
														<button class='quick-view'><i class='fa fa-eye'></i><span class='tooltipp'>quick view</span></button>
													</a>
												</div>
											</div>
											<div class='add-to-cart'>
												<button pid='<?php echo $pro_id;?>' id='product' class='add-to-cart-btn block2-btn-towishlist' href='#'>
													<i class='fa fa-shopping-cart'></i> add to cart</button>
											</div>
										</div>
                               
							
                        
			<?php } ?>
	
										<!-- product -->
										
	
										<!-- /product -->
										
										
										<!-- /product -->
									</div>
									<div id="slick-nav-1" class="products-slick-nav"></div>
								</div>
								<!-- /tab -->
							</div>
						</div>
					</div>
					<!-- Products tab & slick -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

</div>
		
   
 <?php $this->load->view('common/footer'); ?>