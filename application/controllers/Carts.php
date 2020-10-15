<?php

class Carts extends CI_Controller { // Our Carts class extends the Controller class
     
     function __construct() {
        parent::__construct();
        // $this->load->model('carts_model'); // Load our carts model for our entire class
       $ip_add = getenv("REMOTE_ADDR");
    }

    function index()
	{
	     /*************Retrieve an array with all products *****/

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
     
    
	}


    function cart_checkout(){

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
// echo "<pre>"; print_r($cartValue);
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
                        <td><a href="'.base_url().'store/" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
                        <td colspan="2" class="hidden-xs"></td>
                        <td class="hidden-xs text-center"><b class="net_total" ></b></td>
                        <div id="issessionset"></div>
                        <td>';

                 if ($user_id > 0) {
                    $html .='</form>
                    
                        <form action="'.base_url().'home/checkout/" method="post">
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
                                    <input type="hidden" name="currency_code" value="INR"/>
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
            
        }else{
            $html='<div class="main ">
                    <div class="table-responsive">
                        <table id="cart" class="table table-hover table-condensed" id="">
                            <thead>
                                <tr>
                                    <th>No Item Added into a Cart</th>
                                
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>';
        }
        echo $html;
    }

    function removeItemFromCart(){
        $remove_id = $this->input->post("rid");
        $user_id=$this->session->userdata('user_id');
        $ip_add = ($ip_add =='' )?'1':$ip_add ;

        if($user_id > 0){
            $this->db->where('user_id', $user_id);
            $this->db->where('p_id', $remove_id);
            
        }else{
            $this->db->where('ip_add', $ip_add);
            $this->db->where('p_id', $remove_id);
        }
        $this->db->delete('cart');

        $html="<div class='alert alert-danger'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <b>Product is removed from cart</b>
                </div>";
    }

}
/* End of file cart.php */
/* Location: ./application/controllers/cart.php */
