<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
<?php 
if(in_array($_GET['main_page'], array(FILENAME_DEFAULT , FILENAME_ADVANCED_SEARCH_RESULT , FILENAME_PRODUCTS_COMMON_LIST , FILENAME_PRODUCT_INFO , FILENAME_SHOPPING_CART , FILENAME_CHECKOUT_PAYMENT))){
	$criteo_str = '<script type="text/javascript">
window.criteo_q = window.criteo_q || [];
window.criteo_q.push(
     { event: "setAccount", account: 40310 },';
	
	if(isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0 && isset($_SESSION['customer_email']) && $_SESSION['customer_email'] != '' ){
		$md5_customer_email = md5(strtolower($_SESSION['customer_email']));
		$criteo_str .= '
     { event: "setHashedEmail", email: "' . $md5_customer_email . '" },';
	}
	
	$criteo_str .= '
     { event: "setSiteType", type: "m" },
     ';
	
	switch($_GET['main_page']){
		case FILENAME_DEFAULT:
			if($this_is_home_page){
				$criteo_str .= '{ event: "viewHome" }';
			}else{
				$products_id_list = '';
				$criteo_str .= '{ event: "viewList", item: ';
				
				if(sizeof($product_info_list) > 0){
					foreach($product_info_list as $prod){
						$products_id_list .= '"' . $prod['products_id'] . '",';
					}
				}
				
				if($products_id_list != ''){
					$products_id_list = '[' . substr($products_id_list , 0 , -1) . ']';
				}else{
					$products_id_list = '""';
				}
				
				$criteo_str .= $products_id_list . ' }';
			}
			break;
		case FILENAME_ADVANCED_SEARCH_RESULT:
			$products_id_list = '';
			$criteo_str .= '{ event: "viewList", item: ';
			
			if(sizeof($product_res) > 0){
				foreach($product_res as $prod){
					$products_id_list .= '"' . $prod. '",';
				}
			}
			
			if($products_id_list != ''){
				$products_id_list = '[' . substr($products_id_list , 0 , -1) . ']';
			}else{
				$products_id_list = '""';
			}
			
			$criteo_str .= $products_id_list . ' }';
			break;
		case FILENAME_PRODUCTS_COMMON_LIST:
			$products_id_list = '';
			$criteo_str .= '{ event: "viewList", item: ';
			
			if(sizeof($product_res) > 0){
				foreach($product_res as $prod){
					$products_id_list .= '"' . $prod . '",';
				}
			}
			
			if($products_id_list != ''){
				$products_id_list = '[' . substr($products_id_list , 0 , -1) .']';
			}else{
				$products_id_list = '""';
			}
			
			$criteo_str .= $products_id_list . ' }';
			break;
		case FILENAME_PRODUCT_INFO:
			$criteo_str .= '{ event: "viewItem", item: "' . $_GET['products_id'] . '" }';
			break;
		case FILENAME_SHOPPING_CART:
			$cart_id_list = '';
			$criteo_str .= '{ event: "viewBasket", item: ';
			
			if(sizeof($products) > 0){
				foreach($products as $prod){
					$cart_id_list .= '{ id: "' . $prod['id'] . '", price: ' . round($prod['price'] , 2) . ', quantity: ' . $prod['quantity'] . ' },';
				}
			}
			if($cart_id_list!=''){
				$cart_id_list = '[' . substr($cart_id_list , 0 , -1) . ']';
			}else{
				$cart_id_list = '""';
			}
			
			$criteo_str .= $cart_id_list . ' }';
			break;
		case FILENAME_CHECKOUT_PAYMENT:
			$cart_id_list = '';
			$criteo_str .= '{ event: "trackTransaction" , id: "' . $_SESSION['order_number_created'] . '", item:';
	
			if(sizeof($order->products)){
				foreach ($order->products as $products){
					$cart_id_list .= '{ id: "' . $products['id'] . '", price: ' . round($products['final_price'] , 2) . ', quantity: ' . $products['qty'] . ' },';
				}
			}
			
			if($cart_id_list!=''){
				$cart_id_list = '[' . substr($cart_id_list , 0 , -1) . ']';
			}else{
				$cart_id_list = '""';
			}
			
			$criteo_str .= $cart_id_list . ' }';
			break;
	
	}
	
	$criteo_str .= '
);';
	$criteo_str .= '</script>';
	
	echo $criteo_str;
}

?>