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
fbq('init', '<?php echo FACEBOOK_PIXEL_CODE;?>'); // Insert your pixel ID here.
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
	$is_mobile = false;
	if ($is_mobilesite == 1) {
		$is_mobile = true;
	}
	$products_array = $_SESSION['cart']->get_isvalid_checkout_products_optimize(0, 0, false, $is_mobile);
	$products = $products_array['data'];
	
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
}elseif ($_GET['main_page'] == FILENAME_CHECKOUT){
	$extral_param = "fbq('track', 'InitiateCheckout');";
}

echo $extral_param;
?>
</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=938912936249294&ev=PageView&noscript=1"/></noscript>
<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code -->

<!-- Google Code for &#20877;&#33829;&#38144;&#20195;&#30721; -->
<!-- Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. For instructions on adding this tag and more information on the above requirements, read the setup guide: google.com/ads/remarketingsetup -->
<script type="text/javascript">
<?php 
switch($_GET['main_page']){
	case FILENAME_DEFAULT:
		if($this_is_home_page){
			$google_conversion_content = 'var google_tag_params = {
											ecomm_pagetype:"home"
										};';
		}else{
			$products_id_list = '';
			$products_price_list = 0;
			if(sizeof($product_info_list) > 0){
				foreach ($product_info_list as $product_info){
					$products_id_list.='"'.$product_info['products_id'].'",';
					$products_price_array = get_products_max_sale_price($product_info['products_id']);
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
			
			$google_conversion_content = 'var google_tag_params = {
											ecomm_prodid:'.$products_id_list.',
											ecomm_pagetype:"category",
											ecomm_totalvalue:'.$products_price_list.'
										};';
		}
		break;
	case FILENAME_PRODUCT_INFO:
		if (isset($_GET['products_id']) && $_GET['products_id'] != ''){
			$products_id = zen_output_string_protected($_GET['products_id']);
			$products_price_array = get_products_max_sale_price($products_id);
			$products_price = floatval($products_price_array[0]['discount_price']);
		}
		$google_conversion_content = 'var google_tag_params = { 
											ecomm_prodid:"'.$products_id.'",
											ecomm_pagetype:"product",
											ecomm_totalvalue:'.round($products_price,2).'
										};';
		break;
	case FILENAME_SHOPPING_CART:
		$cart_id_list = '';
		$cart_price_list = 0;
		foreach($products as $prod){
			$cart_id_list.='"'.$prod['id'].'",';
			$cart_price_list+=round($prod['price'],2) * $prod['quantity'];
		}
		if($cart_id_list!=''){
			$cart_id_list = '['.substr($cart_id_list,0,-1).']';
		}else{
			$cart_id_list='""';
		}
		if($cart_price_list == 0){
			$cart_price_list='0';
		}
		$google_conversion_content = 'var google_tag_params = {
											ecomm_prodid:'.$cart_id_list.',
											ecomm_pagetype:"cart",
											ecomm_totalvalue:'.$cart_price_list.'
									};';
		break;
	case FILENAME_CHECKOUT:
		$cart_id_list = '';
		$cart_price_list = 0;
		//Tianwen.Wan20160624购物车优化
		$products_array = $_SESSION['cart']->get_isvalid_checkout_products_optimize(0, 0, false, true);
		$products = $products_array['data'];
		foreach($products as $prod){
			$cart_id_list.='"'.$prod['id'].'",';
			$cart_price_list += round($prod['price'],2) * $prod['quantity'];
		}
		if($cart_id_list!=''){
			$cart_id_list = '['.substr($cart_id_list,0,-1).']';
		}else{
			$cart_id_list='""';
		}
		if($cart_price_list == 0){
			$cart_price_list='0';
		}
		$google_conversion_content = 'var google_tag_params = {
										ecomm_prodid:'.$cart_id_list.',
										ecomm_pagetype:"purchase",
										ecomm_totalvalue:'.$cart_price_list.'
								};';

		break;
	case FILENAME_ADVANCED_SEARCH_RESULT:
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
		
			$google_conversion_content = 'var google_tag_params = {
											ecomm_prodid:'.$products_id_list.',
											ecomm_pagetype:"searchresults",
											ecomm_totalvalue:'.$products_price_list.'
										};';
			break;
	case FILENAME_PRODUCTS_COMMON_LIST:
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
			
		$google_conversion_content = 'var google_tag_params = {
								ecomm_prodid:'.$products_id_list.',
								ecomm_pagetype:"category",
								ecomm_totalvalue:'.$products_price_list.'
							};';
	
		break;
	default:
		$google_conversion_content = 'var google_tag_params = {
											ecomm_pagetype:"other"
										};';
		break;		
}
echo $google_conversion_content . "\n";
?>
</script>
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = <?php echo ADWORDS_PROMOTION_CODE;?>;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
<?php 
	if(isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0){
		echo 'var google_user_id = ' . $_SESSION['customer_id'];
	}
?>
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/<?php echo ADWORDS_PROMOTION_CODE;?>/?guid=ON&amp;script=0<?php echo ((isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0) ? '&amp;userId=' . $_SESSION['customer_id'] : '')?>"/>
</div>
</noscript>

<!-- Google Code for &#20877;&#33829;&#38144;&#20195;&#30721; -->
<!-- Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. For instructions on adding this tag and more information on the above requirements, read the setup guide: google.com/ads/remarketingsetup -->
<script type="text/javascript">
$(document).ready(function(){
	if($(".reminder_wrap").length > 0){
		$(".mian_wrap").css("margin-top","0");
		$(".order_main").css("margin-top","0");
		$("#headSearchDiv").css("margin-top","0");
	}
	<?php 
		//Tianwen.Wan20160228生成首页才异步
		if(empty($_GET['cPath']) && ($_GET['generate_index'] == "true" || $_GET['main_page'] == "index")) {
	?>
	$.post('ajax/ajax_user_status.php',{action:'all_status', website:'mobiesite'},function(data){
		if(typeof(JSON)=='undefined'){
			var returnInfo=eval('('+data+')');
		}else{
			var returnInfo=JSON.parse(data);	
		}
		if(returnInfo.error == 0) {
			if(returnInfo.count_cart > 0) {
				$(".jq_head_cart").removeClass("head_cart");
				$(".jq_head_cart").addClass("head_cart_on");
				$(".jq_head_cart span").text(returnInfo.count_cart);
				if(returnInfo.count_cart > 99){
                   $(".jq_head_cart").removeClass("head_cart");
				   $(".jq_head_cart").addClass("head_cart_on");
				   $(".jq_head_cart span").text('99+');
				}
			}
			// if(returnInfo.count_cart > 99){
			// 	  $(".jq_head_cart").removeClass("head_cart");
			// 	   $(".jq_head_cart").addClass("head_cart_on");
			//  	   $(".jq_head_cart span").text('99+');
			// }else if(0<returnInfo.count_cart<= 99 ){
		 // 		$(".jq_head_cart").removeClass("head_cart");
			// 	$(".jq_head_cart").addClass("head_cart_on");
			// 	$(".jq_head_cart span").text(returnInfo.count_cart);
			// }
			// $(".jq_customer_info").html(returnInfo.customer_info);
			// $("#footChangeCuurency p").text(returnInfo.customers_currency);
			// $(".wrap-page").prepend(returnInfo.station_letter_content);
		}
	});
	
	<?php 
		}
	?>
	show_index_login_window();
});
</script>

<?php if($_GET['main_page'] == FILENAME_CHECKOUT_SUCCESS){?>
    <script src="https://apis.google.com/js/platform.js?onload=renderOptIn" async defer></script>
    
    <script>
      window.renderOptIn = function() {
        window.gapi.load('surveyoptin', function() {
          window.gapi.surveyoptin.render(
            {
              // REQUIRED FIELDS
              "merchant_id": 9784950,
              "order_id": "<?php echo $zv_orders_id;?>",
              "email": "<?php echo $_SESSION['customer_email'];?>",
              "delivery_country": "<?php echo $order->delivery['country_iso_code_2'];?>",
              "estimated_delivery_date": "<?php echo date('Y-m-d', strtotime("+30 days"))?>",
            });
        });
      }
    </script>
<?php }?>