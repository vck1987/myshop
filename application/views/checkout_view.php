<?php

$this->load->view('common/header'); 
                         
?>

<style>

.row-checkout {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 -16px;
}

.col-25 {
  -ms-flex: 25%; /* IE10 */
  flex: 25%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-75 {
  -ms-flex: 75%; /* IE10 */
  flex: 75%;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}

.container-checkout {
  background-color: #f2f2f2;
  padding: 5px 20px 15px 20px;
  border: 1px solid lightgrey;
  border-radius: 3px;
}

input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

.checkout-btn {
  background-color: #4CAF50;
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 100%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}

.checkout-btn:hover {
  background-color: #45a049;
}



hr {
  border: 1px solid lightgrey;
}

span.price {
  float: right;
  color: grey;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
@media (max-width: 800px) {
  .row-checkout {
    flex-direction: column-reverse;
  }
  .col-25 {
    margin-bottom: 20px;
  }
}
</style>
<?php 
if($checkout_process==1){
	?>
<section class="section">       
	<div class="container-fluid">
		<div class="row-checkout">
			<div class="col-75">
				<div class="container-checkout">
			<p>Order Number : </p><b>#<?php echo $order_id; ?></b></br>
			<p>Order Status : </p><b>Order Placed Successfully</b></br>
			<a href="<?php echo base_url(); ?>" ><button type="button" class="btn btn-primary">Go Home!</button>  </a>
				</div>
			</div>
		</div>
	</div>
</section>


<?php
}else{
	?>
					
<section class="section">       
	<div class="container-fluid">
		<div class="row-checkout">
		<?php
		if($userData['user_id'] > 0){
	
		?>
		
			<div class="col-75">
				<div class="container-checkout">
				<form id="checkout_form" action="<?php echo base_url(); ?>home/checkout_process" method="POST" class="was-validated">

					<div class="row-checkout">
					
					<div class="col-50">
						<h3>Billing Address</h3>
						<label for="fname"><i class="fa fa-user" ></i> Full Name</label>
						<input type="text" id="fname" class="form-control" name="firstname" pattern="^[a-zA-Z ]+$"  value="<?php echo $userData["first_name"].' '.$userData["last_name"]; ?>">
						<label for="email"><i class="fa fa-envelope"></i> Email</label>
						<input type="text" id="email" name="email" class="form-control" pattern="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$" value="<?php echo $userData["email"]; ?>" required>
						<label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
						<input type="text" id="adr" name="address" class="form-control" value="<?php echo $userData["address1"]; ?>" required>
						<label for="city"><i class="fa fa-institution"></i> City</label>
						<input type="text" id="city" name="city" class="form-control" value="<?php echo $userData["address2"]; ?>" pattern="^[a-zA-Z ]+$" required>

						<div class="row">
						<div class="col-50">
							<label for="state">State</label>
							<input type="text" id="state" name="state" class="form-control" pattern="^[a-zA-Z ]+$" required>
						</div>
						<div class="col-50">
							<label for="zip">Zip</label>
							<input type="text" id="zip" name="zip" class="form-control" pattern="^[0-9]{6}(?:-[0-9]{4})?$" required>
						</div>
						</div>
					</div>
					
					
					<div class="col-50">
						<h3>Payment Details</h3>
						<label for="fname">Accepted Payment</label>
						<label for="fname">Cash On Delivery (COD)</label>
						<!-- <label><input type="CHECKBOX" name="q" class="roomselect" value="conform" required> Shipping address same as billing -->
					</label>
						
					</div>
					</div>
					
					<?php
					$i=1;
					$total=0;
					$total_count=$this->input->post('total_count');
					while($i<=$total_count){
				
						$product_id = $this->input->post('product_id_'.$i);
						$item_name_ = $this->input->post('item_name_'.$i);
						$amount_ = $this->input->post('amount_'.$i);
						$quantity_ = $this->input->post('quantity_'.$i);
						$total=$total+$amount_ * $quantity_ ;
						// $sql = "SELECT product_id FROM products WHERE product_title='$item_name_'";
						// $query = mysqli_query($con,$sql);
						// $row=mysqli_fetch_array($query);
						// $product_id=$row["product_id"];
						echo "	
						<input type='hidden' name='prod_id_$i' value='$product_id'>
						<input type='hidden' name='prod_price_$i' value='$amount_'>
						<input type='hidden' name='prod_qty_$i' value='$quantity_'>
						";
						$i++;
					}
					
				echo'	
				<input type="hidden" name="total_count" value="'.$total_count.'">
					<input type="hidden" name="total_price" value="'.$total.'">
					
					<input type="submit" id="submit" value="Continue to checkout" class="checkout-btn">
				</form>
				</div>
			</div>
			';
		}else{
			echo"<script>window.location.href = '".base_url()."home/cartview/'</script>";
		}
		?>

			<div class="col-25">
				<div class="container-checkout">
				
				<?php
				
				if (!empty($this->input->post("cmd"))) {
				
					$user_id = $this->input->post('custom');
					
					
					$i=1;
					?>
					
					<h4>Cart 
					<span class='price' style='color:black'>
					<i class='fa fa-shopping-cart'></i> 
					<b><?php echo $total_count; ?></b>
					</span>
				</h4>

					<table class='table table-condensed'>
					<thead><tr>
					<th >no</th>
					<th >product title</th>
					<th >	qty	</th>
					<th >	amount</th></tr>
					</thead>
					<tbody>
					<?php
					$total=0;
					while($i<=$total_count){
						$item_name_ = $this->input->post('item_name_'.$i);
						
						$item_number_ = $this->input->post('item_number_'.$i);
						
						$quantity_ = $this->input->post('quantity_'.$i);
						
						$amount_ = $this->input->post('amount_'.$i) * $quantity_;
						
						$total=$total+$amount_ ;
						// $sql = "SELECT product_id FROM products WHERE product_title='$item_name_'";
						// $query = mysqli_query($con,$sql);
						// $row=mysqli_fetch_array($query);
						// $product_id=$row["product_id"];
					
						echo "	

						<tr><td><p>$item_number_</p></td><td><p>$item_name_</p></td><td ><p>$quantity_</p></td><td ><p><i class='fa fa-inr'></i> $amount_</p></td></tr>";
						
						$i++;
					}

				echo"

				</tbody>
				</table>
				<hr>
				
				<h3>total<span class='price' style='color:black'><b><i class='fa fa-inr'></i> $total</b></span></h3>";
					
				}
				?>
				</div>
			</div>
		</div>
	</div>
</section>
		
<?php
}
$this->load->view('common/footer'); 
?>