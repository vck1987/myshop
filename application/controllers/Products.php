<?php

class Products extends CI_Controller { // Our Products class extends the Controller class
     
     function __construct() {
        parent::__construct();
        $this->load->model('products_model'); // Load our Products model for our entire class
        // echo "<pre>"; print_r($this->cart);
    }

    function index($productId){
        // echo "here".$productId;
        $products=$this->products_model->get_all_product($productId);
        echo json_encode($products);
        
    }

    function add_to_cart(){
    	$data = array(
    		'id' => $this->input->post('product_id'),
    		'name' => $this->input->post('product_name'),
    		'price' => $this->input->post('product_price'),
    		'qty' => $this->input->post('quantity'),
    	);
    	$this->cart->insert($data);
    	echo $this->show_cart();
    }

function show_cart(){
	$output = '';
	$no = 0;
	foreach ($this->cart->contents() as $items) {
		$no++;
		$output .='
		<tr>
		<td>'.$items['name'].'</td>
		<td>'.number_format($items['price']).'</td>
		<td>'.$items['qty'].'</td>
		<td>'.number_format($items['subtotal']).'</td>
		<td><button type="button" id="'.$items['rowid'].'" class="romove_cart btn btn-danger btn-sm">Cancel</button></td>
		</tr>';
		}
		$output .= '
    <tr>
<th colspan="3">Total</th>
<th colspan="2">'.'Rp '.number_format($this->cart->total()).'</th>
    </tr>
';
return $output;
}
function load_cart(){
	echo $this->show_cart();
}
function delete_cart(){$data = array(
	'rowid' => $this->input->post('row_id'),
	'qty' => 0,);
$this->cart->update($data);
echo $this->show_cart();
}

}