<?php
unset($_SESSION['google_analytics']);
if($_GET['main_page'] == FILENAME_CHECKOUT_PAYMENT || ($_GET['main_page'] == FILENAME_CHECKOUT_SUCCESS && $_SESSION['paid_by_ec'])) {
	if(!isset($_SESSION['google_analytics'])) $_SESSION['google_analytics'] = array();
	$zv_orders_id = isset($_SESSION['order_summary']['order_number']) ? $_SESSION['order_summary']['order_number'] : $_SESSION['order_number_created'];
	
	$_SESSION['google_analytics'][] = $zv_orders_id;
	require_once(DIR_WS_CLASSES . 'order.php');
	$order = new order($zv_orders_id);
	switch (GOOGLE_ANALYTICS_TARGET) {
		case 'delivery':
			$google_analytics = $order->delivery;
			break;
		case 'billing':
			$google_analytics = $order->billing;
			break;
		case 'customers':
		default:
			$google_analytics = $order->customer;
			break;
	}

	$google_analytics['ot_shipping'] = 0;
	$totals = $db->Execute("SELECT value FROM " . TABLE_ORDERS_TOTAL . " WHERE orders_id = '" . (int)$zv_orders_id . "' AND class = 'ot_shipping'");
	if (!$totals->EOF) {
		$google_analytics['ot_shipping'] = $totals->fields['value'];
	}
	
	$siteName = 'auto';
	$_trackTrans = "ga('require', 'ecommerce', 'ecommerce.js');\r\n";
	$_trackTrans .="ga('ecommerce:addTransaction', {
		  'id': '".$zv_orders_id."',      
		  'affiliation': '".$siteName."',
		  'revenue': '".number_format($order->info['total'], 2, '.', '')."',    
		  'shipping': '".number_format($google_analytics['ot_shipping'], 2, '.', '')."', 
		  'tax': '".number_format($order->info['tax'], 2, '.', '')."' 
		});"."\n";

    for ($i=0; $i<sizeof($order->products); $i++) {
        $categories_name = zen_get_categories_name_from_product(zen_get_prid($order->products[$i]['id']));
        if(GOOGLE_ANALYTICS_SKUCODE == 'products_model') {
            $products_skucode = $order->products[$i]['model'];
        } else {
            $products_skucode = $order->products[$i]['id'];
        }
        $products_attributes_name = '';
        if (isset($order->products[$i]['attributes'])) {
            for ($j=0; $j<sizeof($order->products[$i]['attributes']); $j++) {
                $products_attributes_name .= $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'] . GOOGLE_ANALYTICS_PRODUCTS_ATTRIBUTES_DELIMITER;
            }
            $products_attributes_name = substr(GOOGLE_ANALYTICS_PRODUCTS_ATTRIBUTES_BRACKETS, 0, 1) . rtrim($products_attributes_name, GOOGLE_ANALYTICS_PRODUCTS_ATTRIBUTES_DELIMITER) . substr(GOOGLE_ANALYTICS_PRODUCTS_ATTRIBUTES_BRACKETS, 1, 1);
        }

        $_trackTrans.="ga('ecommerce:addItem', {
		  'id': '".$zv_orders_id."',       
		  'name': '".zen_output_string_protected(addslashes($order->products[$i]['name'] . $products_attributes_name))."', 
		  'sku': '".zen_output_string_protected($products_skucode)."',   
		  'category': '".zen_output_string_protected(addslashes($categories_name))."',  
		  'price': '".number_format($order->products[$i]['final_price'], 2, '.', '')."',   
		  'quantity': '".$order->products[$i]['qty']."'   
		}); ". "\n";
    }

	unset($_SESSION['paid_by_ec']);
    unset($_SESSION['google_analytics']);
?>
<script type="text/javascript">
		<?php echo $_trackTrans; ?>
	
		<?php echo "ga('ecommerce:send'); "?>
</script>


<?php
}
?>
<!-- Facebook Pixel Code -->
<script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '2165951040365710');
    fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
               src="https://www.facebook.com/tr?id=2165951040365710&ev=PageView&noscript=1"
    /></noscript>
<!-- End Facebook Pixel Code -->

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '<?php echo FACEBOOK_PIXEL_CODE;?>');
fbq('track', 'PageView');

<?php if($_GET['main_page'] == FILENAME_PRODUCT_INFO){
	$products_id = '';
	$products_price = 0;
	if (isset($_GET['products_id']) && $_GET['products_id'] != ''){
		$products_id = $_GET['products_id'];
		$products_price_array = get_products_max_sale_price($products_id);
		$products_price = floatval($products_price_array[0]['discount_price']);
	}
	$extral_param = "fbq('track', 'ViewContent', {
	    content_type: 'product',
	    content_ids: ['" . $products_id . "'],
	    value: " .  $products_price . ", 
	    currency: 'USD'
	});";
}elseif($_GET['main_page'] == FILENAME_DEFAULT && !$this_is_home_page){
    $products_id_list = '';
    $products_price_list = 0;
    if(sizeof($product_res) > 0){
        foreach($product_res as $prod){
            $products_id_list.='"'.$prod.'",';
            $products_price_array = get_products_max_sale_price($prod);
            $products_price = floatval($products_price_array[0]['discount_price']);
            $products_price_list += round($products_price,2);
        }
    }
    if($products_id_list!=''){
        $products_id_list = '['.substr($products_id_list,0,-1).']';
    }else{
        $products_id_list='""';
    }
    if($products_price_list == 0){
        $products_price_list='0';
    }
    
    $extral_param = "fbq('track', 'ViewContent', {
        content_ids: " . $products_id_list . ",
        content_type: 'product',
        value: " . $products_price_list . ",
        currency: 'USD'
    });";
}elseif($_GET['main_page'] == FILENAME_ADVANCED_SEARCH_RESULT){
    $products_id_list = '';
    $products_price_list = 0;
    if(sizeof($product_res) > 0){
        foreach($product_res as $prod){
            $products_id_list.='"'.$prod.'",';
            $products_price_array = get_products_max_sale_price($prod);
            $products_price = floatval($products_price_array[0]['discount_price']);
            $products_price_list += round($products_price,2);
        }
    }
    if($products_id_list!=''){
        $products_id_list = '['.substr($products_id_list,0,-1).']';
    }else{
        $products_id_list='""';
    }
    
    $extral_param = "fbq('track', 'ViewContent', {
        content_ids: " . $products_id_list . ",
        content_type: 'product',
        value: " . $products_price_list . ",
        currency: 'USD'
    });";
}elseif($_GET['main_page'] == FILENAME_PRODUCTS_COMMON_LIST){
    $products_id_list = '';
    $products_price_list = 0;
    if(sizeof($product_res) > 0){
        foreach($product_res as $prod){
            $products_id_list.='"'.$prod.'",';
            $products_price_array = get_products_max_sale_price($prod);
            $products_price = floatval($products_price_array[0]['discount_price']);
            $products_price_list += round($products_price,2);
        }
    }
    if($products_id_list!=''){
        $products_id_list = '['.substr($products_id_list,0,-1).']';
    }else{
        $products_id_list='""';
    }
    
    $extral_param = "fbq('track', 'ViewContent', {
        content_ids: " . $products_id_list . ",
        content_type: 'product',
        value: " . $products_price_list . ",
        currency: 'USD'
    });";
}elseif($_GET['main_page'] == FILENAME_SHOPPING_CART){
	$cart_id_list = '';
	$cart_price_list = 0;
	
	if(sizeof($products) > 0){
		foreach($products as $prod){
			$cart_id_list.='"'.$prod['id'].'",';
			$cart_price_list += round($prod['price'],2) * $prod['quantity'];
		}
	}
	if($cart_id_list!=''){
		$cart_id_list = '['.substr($cart_id_list,0,-1).']';
	}else{
		$cart_id_list='""';
	}
	if($cart_price_list == 0){
		$cart_price_list='""';
	}
	
	$extral_param = "fbq('track', 'AddToCart', {
        content_ids: " . $cart_id_list . ", 
        content_type: 'product',
        value: " . $cart_price_list . ",
        currency: 'USD'
    });";
}elseif ($_GET['main_page'] == FILENAME_CHECKOUT_SUCCESS){
	$cart_id_list = '';
	$cart_price_list = 0;
	if(sizeof($order->products) > 0){
		foreach($order->products as $prod){
			$cart_id_list.='"'.$prod['id'].'",';
			$cart_price_list += round($prod['final_price'],2) * $prod['qty'];
		}
	}
	if($cart_id_list!=''){
		$cart_id_list = '['.substr($cart_id_list,0,-1).']';
	}else{
		$cart_id_list='""';
	}
	if($cart_price_list == 0){
		$cart_price_list='""';
	}
	$extral_param = "fbq('track', 'Purchase', {  
		content_ids: " . $cart_id_list . ",
		content_type: 'product',
		value: " . $cart_price_list . ",
		currency: 'USD'});";
}elseif ($_GET['main_page'] == FILENAME_CHECKOUT_SHIPPING){
	$extral_param = "fbq('track', 'InitiateCheckout');";
}

echo $extral_param;
?>
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=938912936249294&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<!-- penterest -->
<script type="text/javascript">
!function(e){if(!window.pintrk){window.pintrk=function(){window.pintrk.queue.push(Array.prototype.slice.call(arguments))};var n=window.pintrk;n.queue=[],n.version="3.0";var t=document.createElement("script");t.async=!0,t.src=e;var r=document.getElementsByTagName("script")[0];r.parentNode.insertBefore(t,r)}}("https://s.pinimg.com/ct/core.js");pintrk('load','2612416394623');
pintrk('page', {
	page_name: 'My Page',
	page_category: 'My Page Category'
});</script><noscript><img height="1" width="1" style="display:none;" alt=""src="https://ct.pinterest.com/v3/?tid=2612416394623&noscript=1" />
</noscript>
<!-- penterest EOF -->