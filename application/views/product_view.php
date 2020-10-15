<?php 
$this->load->view('common/header'); 
	
?>
		<!-- /BREADCRUMB -->
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},900);
				});
			});
</script>
		<script>
    
    (function (global) {
	if(typeof (global) === "undefined")
	{
		throw new Error("window is undefined");
	}
    var _hash = "!";
    var noBackPlease = function () {
        global.location.href += "#";
		// making sure we have the fruit available for juice....
		// 50 milliseconds for just once do not cost much (^__^)
        global.setTimeout(function () {
            global.location.href += "!";
        }, 50);
    };	
	// Earlier we had setInerval here....
    global.onhashchange = function () {
        if (global.location.hash !== _hash) {
            global.location.hash = _hash;
        }
    };
    global.onload = function () {        
		// noBackPlease();
		// disables backspace on page except on input fields and textarea..
		document.body.onkeydown = function (e) {
            var elm = e.target.nodeName.toLowerCase();
            if (e.which === 8 && (elm !== 'input' && elm  !== 'textarea')) {
                e.preventDefault();
            }
            // stopping event bubbling up the DOM tree..
            e.stopPropagation();
        };		
    };
})(window);
</script>

		<!-- SECTION -->
		<div class="section main main-raised">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- Product main img -->
                                <?php
                                	$url=base_url()."products/".$productId;
								    $postdata=array('url' =>$url);
								    $dataArray=curlGet($postdata) ;
								    $data = json_decode($dataArray,true);
								    
								foreach($data as $row){
									$product_image=$row['product_image'];
						       ?>
                                <div class="col-md-5 col-md-push-2">
	                                <div id="product-main-img">
	                                    <div class="product-preview">
	                                        <img src="<?php echo base_url(); ?>assets/img/products/<?php echo $product_image; ?>" alt="">
	                                    </div>

	                                    <div class="product-preview">
	                                        <img src="<?php echo base_url(); ?>assets/img/products/<?php echo $product_image; ?>" alt="">
	                                    </div>

	                                    <div class="product-preview">
	                                        <img src="<?php echo base_url(); ?>assets/img/products/<?php echo $product_image; ?>" alt="">
	                                    </div>

	                                    <div class="product-preview">
	                                        <img src="<?php echo base_url(); ?>assets/img/products/<?php echo $product_image; ?>" alt="">
	                                    </div>
	                                </div>
	                            </div>
                                
                                <div class="col-md-2  col-md-pull-5">
	                                <div id="product-imgs">
	                                    <div class="product-preview">
	                                        <img src="<?php echo base_url(); ?>assets/img/products/<?php echo $product_image; ?>" alt="">
	                                    </div>

	                                    <div class="product-preview">
	                                        <img src="<?php echo base_url(); ?>assets/img/products/<?php echo $product_image; ?>" alt="">
	                                    </div>

	                                    <div class="product-preview">
	                                        <img src="<?php echo base_url(); ?>assets/img/products/<?php echo $product_image; ?>" alt="">
	                                    </div>

	                                    <div class="product-preview">
	                                        <img src="<?php echo base_url(); ?>assets/img/products/<?php echo $product_image; ?>" alt="">
	                                    </div>
	                                </div>
	                            </div>

                               	<!-- FlexSlider -->
						<div class="col-md-5">
						<div class="product-details">
							<h2 class="product-name"><?php echo $row['product_title']; ?></h2>
							<div>
								<div class="product-rating">
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star-o"></i>
								</div>
								<a class="review-link" href="#review-form">10 Review(s) | Add your review</a>
							</div>
							<div>
								<h3 class="product-price"><i class="fa fa-inr"></i><?php echo $row['product_price']; ?></h3>
								<span class="product-available">In Stock</span>
							</div>
							<p><?php echo $row['product_desc']; ?></p>

							<div class="product-options">
								<label>
									Size
									<select class="input-select">
										<option value="0">X</option>
									</select>
								</label>
								<label>
									Color
									<select class="input-select">
										<option value="0">Red</option>
									</select>
								</label>
							</div>

							<div class="add-to-cart">
								<div class="qty-label">
									Qty
									<div class="input-number">
										
										<span class="qty-up">+</span>
										<span class="qty-down">-</span>
									</div>
								</div>
								<div class="btn-group" style="margin-left: 25px; margin-top: 15px">
								<button class="add-to-cart-btn" pid="<?php echo $row['product_id']; ?>"  id="product" ><i class="fa fa-shopping-cart"></i> add to cart</button>
                                </div>
								
								
							</div>

							<ul class="product-btns">
								<li><a href="#"><i class="fa fa-heart-o"></i> add to wishlist</a></li>
								<li><a href="#"><i class="fa fa-exchange"></i> add to compare</a></li>
							</ul>

							<ul class="product-links">
								<li>Category:</li>
								<li><a href="#">Headphones</a></li>
								<li><a href="#">Accessories</a></li>
							</ul>

						</div>
					</div>
									
					
					<!-- /Product main img -->

					<!-- Product thumb imgs -->
					
					
					
					<!-- /Product thumb imgs -->

					<!-- Product details -->
					
					<!-- /Product details -->

					<!-- Product tab -->
					<div class="col-md-12">
						<div id="product-tab">
							<!-- product tab nav -->
							<ul class="tab-nav">
								<li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
								<li><a data-toggle="tab" href="#tab2">Details</a></li>
								<li><a data-toggle="tab" href="#tab3">Reviews (3)</a></li>
							</ul>
							<!-- /product tab nav -->

							<!-- product tab content -->
							<div class="tab-content">
								<!-- tab1  -->
								<div id="tab1" class="tab-pane fade in active">
									<div class="row">
										<div class="col-md-12">
											<p>Apple iPad Air 2 Wi-Fi tablet was launched in October 2014. The tablet comes with a 9.70-inch display with a resolution of 1536x2048 pixels at a pixel density of 264 pixels per inch (ppi). Apple iPad Air 2 Wi-Fi is powered by a 1.5GHz dual-core Apple A8X processor. It comes with 2GB of RAM.</p>
										</div>
									</div>
								</div>
								<!-- /tab1  -->

								<!-- tab2  -->
								<div id="tab2" class="tab-pane fade in">
									<div class="row">
										<div class="col-md-12">
											<p>Apple iPad Air 2 Wi-Fi tablet was launched in October 2014. The tablet comes with a 9.70-inch display with a resolution of 1536x2048 pixels at a pixel density of 264 pixels per inch (ppi). Apple iPad Air 2 Wi-Fi is powered by a 1.5GHz dual-core Apple A8X processor. It comes with 2GB of RAM.</p>
										</div>
									</div>
								</div>
								<!-- /tab2  -->

								<!-- tab3  -->
								<div id="tab3" class="tab-pane fade in">
									<div class="row">
										<!-- Rating -->
										<div class="col-md-3">
											<div id="rating">
												<div class="rating-avg">
													<span>4.5</span>
													<div class="rating-stars">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star-o"></i>
													</div>
												</div>
												<ul class="rating">
													<li>
														<div class="rating-stars">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
														</div>
														<div class="rating-progress">
															<div style="width: 80%;"></div>
														</div>
														<span class="sum">3</span>
													</li>
													<li>
														<div class="rating-stars">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o"></i>
														</div>
														<div class="rating-progress">
															<div style="width: 60%;"></div>
														</div>
														<span class="sum">2</span>
													</li>
													<li>
														<div class="rating-stars">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
														</div>
														<div class="rating-progress">
															<div></div>
														</div>
														<span class="sum">0</span>
													</li>
													<li>
														<div class="rating-stars">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
														</div>
														<div class="rating-progress">
															<div></div>
														</div>
														<span class="sum">0</span>
													</li>
													<li>
														<div class="rating-stars">
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
															<i class="fa fa-star-o"></i>
														</div>
														<div class="rating-progress">
															<div></div>
														</div>
														<span class="sum">0</span>
													</li>
												</ul>
											</div>
										</div>
										<!-- /Rating -->

										<!-- Reviews -->
										<div class="col-md-6">
											<div id="reviews">
												<ul class="reviews">
													<li>
														<div class="review-heading">
															<h5 class="name">John</h5>
															<p class="date">10 OCT 2020, 8:0 PM</p>
															<div class="review-rating">
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star-o empty"></i>
															</div>
														</div>
														<div class="review-body">
															<p>Good product to use</p>
														</div>
													</li>
													<li>
														<div class="review-heading">
															<h5 class="name">John</h5>
															<p class="date">10 OCT 2020,8:0 PM</p>
															<div class="review-rating">
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star-o empty"></i>
															</div>
														</div>
														<div class="review-body">
															<p>I Liked It</p>
														</div>
													</li>
													<li>
														<div class="review-heading">
															<h5 class="name">John</h5>
															<p class="date">10 OCT 2020,, 8:0 PM</p>
															<div class="review-rating">
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star-o empty"></i>
															</div>
														</div>
														<div class="review-body">
															<p>Very Nice product.</p>
														</div>
													</li>
												</ul>
												<ul class="reviews-pagination">
													<li class="active">1</li>
													<li><a href="#">2</a></li>
													<li><a href="#">3</a></li>
													<li><a href="#">4</a></li>
													<li><a href="#"><i class="fa fa-angle-right"></i></a></li>
												</ul>
											</div>
										</div>
										<!-- /Reviews -->

										<!-- Review Form -->
										<div class="col-md-3 mainn">
											<div id="review-form">
												<form class="review-form">
													<input class="input" type="text" placeholder="Your Name">
													<input class="input" type="email" placeholder="Your Email">
													<textarea class="input" placeholder="Your Review"></textarea>
													<div class="input-rating">
														<span>Your Rating: </span>
														<div class="stars">
															<input id="star5" name="rating" value="5" type="radio"><label for="star5"></label>
															<input id="star4" name="rating" value="4" type="radio"><label for="star4"></label>
															<input id="star3" name="rating" value="3" type="radio"><label for="star3"></label>
															<input id="star2" name="rating" value="2" type="radio"><label for="star2"></label>
															<input id="star1" name="rating" value="1" type="radio"><label for="star1"></label>
														</div>
													</div>
													<button class="primary-btn">Submit</button>
												</form>
											</div>
										</div>
										<!-- /Review Form -->
									</div>
								</div>
								<!-- /tab3  -->
							</div>
							<!-- /product tab content  -->
						</div>
					</div>
					<!-- /product tab -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- Section -->
		<div class="section main main-raised">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
                    
					<?php } ?>
					
					




  <?php $this->load->view('common/footer'); ?>					