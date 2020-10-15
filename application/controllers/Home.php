<?php

class Home extends CI_Controller { // Our Home class extends the Controller class
     
     function __construct() {
        parent::__construct();
        $this->load->model('home_model'); // Load our home model for our entire class
        $ip_add = getenv("REMOTE_ADDR");
// echo "<pre>"; print_r($this->session->userdata);

    }

    function index(){

       
      
        $this->load->view('index',$data);
    }

    function productview($productId){
    	$data['productId']=$productId;
    	
    	$this->load->view('product_view',$data);
    }

    function addToCart(){
    	$prod_id=$this->input->post('proId');
    	$user_id=$this->session->userdata('user_id');
    	$ip_add = ($ip_add =='' )?'1':$ip_add ;

    	$this->db->select('*');
    	$this->db-> where('p_id',$prod_id);
    	if($user_id > 0){
			$this->db-> where('user_id',$this->session->userdata('user_id'));
    	}else{
    		$user_id= -1;
    	}
    	$cartData=$this->db->get('cart')->result_array();
    	$productCount=count($cartData);
    	if($productCount){
    		 $html="<div class='alert alert-warning'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<b>Product is already added into the cart Continue Shopping..!</b>
					</div>";
    	}else{
    		$cartArray=array(
    			"p_id" => $prod_id,
    			"ip_add" => $ip_add,
    			"user_id" => $user_id,
    			"qty" => 1
    			);
    		$this->db->insert('cart',$cartArray);
    		$html="<div class='alert alert-success'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<b>Your product is Added Successfully..!</b>
					</div>";
    	}
    	echo $html;
    }

    function count_item(){
    	$user_id=$this->session->userdata('user_id');
    	$ip_add = ($ip_add =='' )?'1':$ip_add ;

    	$this->db->select('count(id) as count_item');
    	if($user_id > 0){
			$this->db-> where('user_id',$this->session->userdata('user_id'));
    	}else{
    		$user_id= -1;
    		$this->db-> where('ip_add',$ip_add);
    		$this->db-> where('user_id < 0');
    	}
    	$cartData=$this->db->get('cart')->row_array();
    	
    	echo $cartData['count_item'];

    }

    function getCartItem(){
    	$user_id=$this->session->userdata('user_id');
    	$ip_add = ($ip_add =='' )?'1':$ip_add ;

		$this->db->select('a.product_id,a.product_title,a.product_price,a.product_desc,a.product_image,b.id,b.qty');
		$this->db->from('products a,cart b');
		$this->db->where('a.product_id=b.p_id ');
		if ($user_id > 0) {
		//When user is logged in this query will execute
		$this->db->where('b.user_id',$user_id);
		}else{
			//When user is not logged in this query will execute
			$this->db->where('b.ip_add',$ip_add);
			$this->db->where('b.user_id < 0');
		}
		$dataArray=$this->db->get()->result_array();
		$cartItemCount=count($dataArray);
		if($cartItemCount > 0){
			$n=0;
			$total_price=0;	
			$html= '';
			foreach ($dataArray as $cartKey => $cartValue) {
				
				$n++;
				$product_id = $cartValue["product_id"];
				$product_title = $cartValue["product_title"];
				$product_price = $cartValue["product_price"];
				$product_image = $cartValue["product_image"];
				$cart_item_id = $cartValue["id"];
				$qty = $cartValue["qty"];
				$total_price=$total_price+($product_price * $qty);

				$html .='<div class="product-widget">
							<div class="product-img">
								<img src="'.base_url().'assets/img/products/'.$product_image.'" alt="">
							</div>
							<div class="product-body">
								<h3 class="product-name"><a href="#">'.$product_title.'</a></h3>
								<h4 class="product-price"><span class="qty">'.$qty.'</span><i class="fa fa-inr"></i>'.$product_price.'</h4>
							</div>
							
						</div>';
			}

			$html .='<div class="cart-summary">
				    <small class="qty">'.$n.' Item(s) selected</small>
				    <h5><i class="fa fa-inr"></i>'.$total_price.'</h5>
				</div>';

			echo $html;
		}
		
	}

	function cartview(){

		$this->load->view('cart_view');
	}

	function cart_checkout(){

		$user_id=$this->session->userdata('user_id');
    	$ip_add = ($ip_add =='' )?'1':$ip_add ;

		$this->db->select('a.product_id,a.product_title,a.product_price,a.product_desc,a.product_image,b.id,b.qty');
		$this->db->from('products a,cart b');
		$this->db->where('a.product_id=b.p_id ');
		if ($user_id > 0) {
			//When user is logged in this query will execute
			$this->db->where('b.user_id',$_SESSION[uid]);
		}else{
			//When user is not logged in this query will execute
			$this->db->where('b.ip_add',$ip_add);
			$this->db->where('b.user_id < 0');
		}
		$dataArray=$this->db->get()->result_array();
		$cartItemCount=count($dataArray);
		if($cartItemCount > 0){
			
				$html='<div class="main ">
							<div class="table-responsive">
							<form method="post" action="login_form.php">
							
					               <table id="cart" class="table table-hover table-condensed" id="">
				    				<thead>
										<tr>
											<th style="width:50%">Product</th>
											<th style="width:10%">Price</th>
											<th style="width:8%">Quantity</th>
											<th style="width:7%" class="text-center">Subtotal</th>
											<th style="width:10%"></th>
										</tr>
									</thead>
									<tbody>';
				foreach ($dataArray as $cartKey => $cartValue){
				$n++;
					$product_id = $cartValue["product_id"];
					$product_title = $cartValue["product_title"];
					$product_price = $cartValue["product_price"];
					$product_image = $cartValue["product_image"];
					$cart_item_id = $cartValue["id"];
					$qty = $cartValue["qty"];
					$total_price=$total_price+$product_price;

				$n=0;
				$total_price=0;

				$html .='<tr>
							<td data-th="Product" >
								<div class="row">
								
									<div class="col-sm-4 "><img src="'.base_url().'assets/img/products/'.$product_image.'" style="height: 70px;width:75px;"/>
									<h4 class="nomargin product-name header-cart-item-name"><a href="'.base_url().'products/'.$product_id.'">'.$product_title.'</a></h4>
									</div>
									<div class="col-sm-6">
										<div style="max-width=50px;">
										<p>'.$product_desc.'</div>
									</div>
									
									
								</div>
							</td>
                            <input type="hidden" name="product_id[]" value="'.$product_id.'"/>
				            <input type="hidden" name="" value="'.$cart_item_id.'"/>
							<td data-th="Price"><input type="text" class="form-control price" value="'.$product_price.'" readonly="readonly"></td>
							<td data-th="Quantity">
								<input type="text" class="form-control qty" value="'.$qty.'" >
							</td>
							<td data-th="Subtotal" class="text-center"><input type="text" class="form-control total" value="'.$product_price.'" readonly="readonly"></td>
							<td class="actions" data-th="">
							<div class="btn-group">
								<a href="#" class="btn btn-info btn-sm update" update_id="'.$product_id.'"><i class="fa fa-refresh"></i></a>
								
								<a href="#" class="btn btn-danger btn-sm remove" remove_id="'.$product_id.'"><i class="fa fa-trash-o"></i></a>		
							</div>							
							</td>
						</tr>';
					}

				$html .='</tbody>
				<tfoot>
					
					<tr>
						<td><a href="store.php" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
						<td colspan="2" class="hidden-xs"></td>
						<td class="hidden-xs text-center"><b class="net_total" ></b></td>
						<div id="issessionset"></div>
                        <td>';

                 if ($user_id > 0) {
                 	$html .='</form>
					
						<form action="checkout.php" method="post">
							<input type="hidden" name="cmd" value="_cart">
							<input type="hidden" name="business" value="vck1987@gmail.com">
							<input type="hidden" name="upload" value="1">';
							  
							$x=0;
							foreach ($dataArray as $Key => $row){
								$x++;
								
									$html .='<input type="hidden" name="total_count" value="'.$x.'">
									<input type="hidden" name="product_id_'.$x.'" value="'.$row["product_id"].'">
									<input type="hidden" name="item_name_'.$x.'" value="'.$row["product_title"].'">
								  	 <input type="hidden" name="item_number_'.$x.'" value="'.$x.'">
								     <input type="hidden" name="amount_'.$x.'" value="'.$row["product_price"].'">
								     <input type="hidden" name="quantity_'.$x.'" value="'.$row["qty"].'">';
								}
							  
							 
									$html .='<input type="hidden" name="return" value="http://localhost/myfiles/public_html/payment_success.php"/>
					                <input type="hidden" name="notify_url" value="http://localhost/myfiles/public_html/payment_success.php">
									<input type="hidden" name="cancel_return" value="http://localhost/myfiles/public_html/cancel.php"/>
									<input type="hidden" name="currency_code" value="USD"/>
									<input type="hidden" name="custom" value="'.$user_id.'"/>
									<input type="submit" id="submit" name="login_user_with_product" name="submit" class="btn btn-success" value="Ready to Checkout">
									</form></td>
									
									</tr>
									
									</tfoot>
									
							</table></div></div>';
                 }else{
                 	$html .='<a href="" data-toggle="modal" data-target="#Modal_register" class="btn btn-success">Ready to Checkout</a></td>
								</tr>
							</tfoot>
				
							</table></div></div>';
                 }
			
		}
		echo $html;
	}

	function checkout(){
		$this->db->select("*");
		$this->db->where("user_id",$this->session->userdata('user_id'));
		$this->db->limit(1);
		$data['userData']=$this->db->get('user_info')->row_array();

		$this->load->view('checkout_view',$data);
	}

	function checkout_process(){
		$user_id=$this->session->userdata('user_id');
		$data['checkout_process']=0;
		if($user_id > 0) {
			$f_name = $this->input->post("firstname");
		    $email = $this->input->post('email');
		    $address = $this->input->post('address');
		    $city = $this->input->post('city');
		    $state = $this->input->post('state');
		    $zip = $this->input->post('zip');
		    $total_count=$this->input->post('total_count');
    		$prod_total = $this->input->post('total_price');

		    $this->db->select("MAX(order_id) as order_id");
		    $order_id=$this->db->get('orders_info')->row_array()['order_id'];
		    		    
		    if(empty($order_id)){
		    	$data['order_id']=1;
		    }else{
		    	$data['order_id']= $order_id + 1;
		    }

		    $orderArray= array(
		    	'order_id' => $data['order_id'],
		    	'user_id' => $user_id,
		    	'f_name' => $f_name,
		    	'email' => $email,
		    	'address' => $address,
		    	'city' => $city,
		    	'state' => $state,
		    	'zip' => $zip, 
		    	'prod_count' => $total_count,
		    	'total_amt' => $prod_total
		    );
		    $this->db->insert('orders_info',$orderArray);

		    $i=1;
	        $prod_id_=0;
	        $prod_price_=0;
	        $prod_qty_=0;
	        while($i<=$total_count){
	            $str=(string)$i;
	            $prod_id_+$str = $this->input->post('prod_id_'.$i);
	            $prod_id=$prod_id_+$str;		
	            $prod_price_+$str = $this->input->post('prod_price_'.$i);
	            $prod_price=$prod_price_+$str;
	            $prod_qty_+$str = $this->input->post('prod_qty_'.$i);
	            $prod_qty=$prod_qty_+$str;
	            $sub_total=(int)$prod_price*(int)$prod_qty;

	            $orderProductArray= array(
			    	'order_id' => $data['order_id'],
			    	'product_id' => $prod_id,
			    	'qty' => $prod_qty_,
			    	'amt' => $sub_total
			
			    );
			    $this->db->insert('order_products',$orderProductArray);
	            
	            $order_prod_id=$this->db->insert_id();
	            if($order_prod_id > 0){
	            	$this->db->where('user_id', $user_id);
	            	$this->db->delete('cart');
	            	// echo $this->db->last_query();
	            	$data['checkout_process']=1;	                
	                    // echo "Order Place Successfully";

	            }else{
	            	$data['checkout_process']=0;
	                $html=(mysqli_error($con));
	            }
	            $i++;


	        }

		}
		
		$this->load->view('checkout_view',$data);
	}


	function register(){
		// session_start();
		$ip_add = ($ip_add =='' )?'1':$ip_add ;

			$f_name = $this->input->post("f_name");
			$l_name = $this->input->post("l_name");
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$repassword = $this->input->post('repassword');
			$mobile = $this->input->post('mobile');
			$address1 = $this->input->post('address1');
			$address2 = $this->input->post('address2');
			$name = "/^[a-zA-Z ]+$/";
			$emailValidation = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/";
			$number = "/^[0-9]+$/";

		if(empty($f_name) || empty($l_name) || empty($email) || empty($password) || empty($repassword) ||
			empty($mobile) || empty($address1) || empty($address2)){
				
				$html="<div class='alert alert-danger'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>PLease Fill all fields..!</b>
					</div>";
	
			} else {
					if(!preg_match($name,$f_name)){
					$html .="<div class='alert alert-warning'>
							<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							<b>this ".$f_name." is not valid..!</b>
						</div>";
					
					}
					if(!preg_match($name,$l_name)){
						$html .="
							<div class='alert alert-warning'>
								<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
								<b>this ".$l_name." is not valid..!</b>
							</div>
						";
						
					}
					if(!preg_match($emailValidation,$email)){
						$html .="
							<div class='alert alert-warning'>
								<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
								<b>this ".$email." is not valid..!</b>
							</div>
						";
						
					}
					if(strlen($password) < 9 ){
						$html .="
							<div class='alert alert-warning'>
								<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
								<b>Password is weak</b>
							</div>
						";
						
					}
					if(strlen($repassword) < 9 ){
						$html .="
							<div class='alert alert-warning'>
								<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
								<b>Password is weak</b>
							</div>
						";
						
					}
					if($password != $repassword){
						$html .="
							<div class='alert alert-warning'>
								<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
								<b>password is not same</b>
							</div>
						";
					}
					if(!preg_match($number,$mobile)){
						$html .="
							<div class='alert alert-warning'>
								<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
								<b>Mobile number $mobile is not valid</b>
							</div>
						";
						
					}
					if(!(strlen($mobile) == 10)){
						$html .="
							<div class='alert alert-warning'>
								<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
								<b>Mobile number must be 10 digit</b>
							</div>
						";
						
					}
				//existing email address in our database
				$this->db->select("user_id");
				$this->db->where("email",$email);
				$this->db->limit(1);
				$userData=$this->db->get('user_info')->row_array();
				 
				$count_email = $userData['user_id'];
				if($count_email > 0){
					$html .="
						<div class='alert alert-danger'>
							<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							<b>Email Address is already available Try Another email address</b>
						</div>
					";
					
				} else {
					$dataArray=array(
								'first_name' => $f_name,
								'last_name' => $l_name,
								'email' => $email,
								'password' => $password,
								'mobile' => $mobile,
								'address1' => $address1,
								'address2' => $address2,
							);
					
					$this->db->insert('user_info',$dataArray);
					$user_id=$this->db->insert_id();
					
					$this->session->set_userdata('user_id', $user_id);
					$this->session->set_userdata('name', $f_name);
					
					// $ip_add = getenv("REMOTE_ADDR");

					$updateArray=array(
						'user_id' => $this->session->userdata('user_id')
					);
					$this->db->where('ip_add',$ip_add);
					$this->db->where('user_id', '-1');
					$this->db->update('cart', $updateArray);
					
						$html .="";
						echo "<script>alert('Registered Successfully') location.href='".base_url()."home/cartview'; </script>";
			            
					
				}
			}
		echo $html;
	}

	#Login script is begin here
	#If user given credential matches successfully with the data available in database then we will echo string login_success
	#login_success string will go back to called Anonymous funtion $("#login").click() 
	function login(){
		$email = $this->input->post("email");
		$password = $this->input->post("password");
		$this->db->select('*');
		$this->db->where( 'email', $email);
		$this->db->where('password', $password);
		$userData=$this->db->get('user_info')->row_array();
		$count=count($userData);
		if($count > 0){
			$this->session->set_userdata('user_id', $userData['user_id']);
			$this->session->set_userdata('name', $userData['first_name']);

			/*if (isset($_COOKIE["product_list"])) {
				$p_list = stripcslashes($_COOKIE["product_list"]);
				//here we are decoding stored json product list cookie to normal array
				$product_list = json_decode($p_list,true);
				for ($i=0; $i < count($product_list); $i++) { 
					//After getting user id from database here we are checking user cart item if there is already product is listed or not
					$verify_cart = "SELECT id FROM cart WHERE user_id = $_SESSION[uid] AND p_id = ".$product_list[$i];
					$result  = mysqli_query($con,$verify_cart);
					if(mysqli_num_rows($result) < 1){
						//if user is adding first time product into cart we will update user_id into database table with valid id
						$update_cart = "UPDATE cart SET user_id = '$_SESSION[uid]' WHERE ip_add = '$ip_add' AND user_id = -1";
						mysqli_query($con,$update_cart);
					}else{
						//if already that product is available into database table we will delete that record
						$delete_existing_product = "DELETE FROM cart WHERE user_id = -1 AND ip_add = '$ip_add' AND p_id = ".$product_list[$i];
						mysqli_query($con,$delete_existing_product);
					}
				}
				//here we are destroying user cookie
				setcookie("product_list","",strtotime("-1 day"),"/");
				//if user is logging from after cart page we will send cart_login
				echo "cart_login";
				
				
			}*/
			//if user is login from page we will send login_success
			// echo "login_success";
			$BackToMyPage = $_SERVER['HTTP_REFERER'];
				if(!isset($BackToMyPage)) {
					header('Location: '.$BackToMyPage);
					echo"<script type='text/javascript'>
					
					</script>";
				} else {
					$homepage=base_url();
					// header('Location: $homepage'); // default page
					echo "<script> location.href='".base_url()."' </script>";
				} 
				
		}else{
                $this->db->select('*');
				$this->db->where( 'admin_email', $email);
				$this->db->where('admin_password', $password);
				$adminData=$this->db->get('admin_info')->row_array();
                
                $count = count($adminData);

            //if user record is available in database then $count will be equal to 1
            if($count == 1){
               
               /* $_SESSION["uid"] = $row["admin_id"];
                $_SESSION["name"] = $row["admin_name"];
                $ip_add = getenv("REMOTE_ADDR");
                //we have created a cookie in login_form.php page so if that cookie is available means user is not login


                    //if user is login from page we will send login_success
                    echo "login_success";

                    echo "<script> location.href='admin/add_product.php'; </script>";
                   */

                }else{
                    echo "<span style='color:red;'>Please register before login..!</span>";
                }
		 }
	}

	#Logout script is begin here
	#Unset the Session of logged in user;
	
	function logout(){
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('name');
		$BackToMyPage = $_SERVER['HTTP_REFERER'];
		if(isset($BackToMyPage)) {
		    header('Location: '.$BackToMyPage);
		} else {
		    header('Location: index.php'); // default page
		}
	}

}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */
