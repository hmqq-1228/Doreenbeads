<?php
require 'includes/application_top.php';
$products_id = (int)$_POST['products_id'];
if(!$products_id){
    echo 'products_id is null';
    exit;
}
$page_name = 'show_package_product_listing';
$page_type = 11;
$html = '';

$main_products_info = get_products_info_memcache($products_id);
$main_products_info['products_name'] = get_products_description_memcache($products_id);
$main_products_info['products_quantity'] = zen_get_products_stock($products_id);
$discount_main_products = get_products_discount_by_products_id($products_id);
if(get_daily_deal_price_by_products_id($products_id)){
	$discount_main_products = get_daily_deal_price_by_products_id($products_id);
	$is_daily_deal_products_main_products = true;
}else{
	$is_daily_deal_products_main_products = false;
}

$last_word_main_products_info = substr($main_products_info['products_model'],- 1 );
if ($last_word_main_products_info == 'S') {
	$main_products_title = TEXT_PRODUCTS_IN_SMALL_PACK;
	$other_package_products_title = TEXT_PRODUCTS_IN_REGULAR_PACK;
}else{
	$main_products_title = TEXT_PRODUCTS_IN_REGULAR_PACK;
	$other_package_products_title = TEXT_PRODUCTS_IN_SMALL_PACK;
}

$html .= '<div class="package_cont" style="display: block;">
			<span id="closebtnlogin">X</span>
			<h3>'. $other_package_products_title .'</h3>';
$html .= '<div class="product_list">
			<ul class="list">';
$other_package_products_array = get_products_package_id_by_products_id($products_id);
foreach($other_package_products_array as $key=>$value){
	$other_products_info = get_products_info_memcache($value);
	$other_products_info['products_name'] = get_products_description_memcache($value);
	$other_products_info['products_quantity'] = zen_get_products_stock($value);
	$discount_other_products = get_products_discount_by_products_id($value);
	if(get_daily_deal_price_by_products_id($value)){
		$discount_other_products = get_daily_deal_price_by_products_id($value);
		$is_daily_deal_products_other_products = true;
	}else{
		$is_daily_deal_products_other_products = false;
	}

	$html .= make_products_html($other_products_info,$discount_other_products,$is_daily_deal_products_other_products);
}
$html .= '</ul></div>';
//$html .= '<h3>'. $main_products_title .'</h3>';
//$html .= '<div class="product_list">
//			<ul class="list">';

//$html .= make_products_html($main_products_info,$discount_main_products,$is_daily_deal_products_main_products);
//$html .= '</ul></div>';
//$html .='</div>';
echo $html;
exit;

function make_products_html($products_info,$discount = 0,$is_daily_deal_products = false){
    $html = '<li>';
    if(!$is_daily_deal_products && $discount){
        $html .= draw_discount_img($discount,'span');
    }
    $href = zen_href_link('product_info', 'products_id=' . $products_info['products_id']);
    //image
    $html .= '<a class="proimg" href="'.$href.'">
    			<img class="lazy-img lazy" src="/includes/templates/cherry_zen/images/loading/130.gif" data-size="130" data-lazyload="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($products_info['products_image'], 130, 130) . '" id="anchor' . $products_info['products_id'] . '" data-original="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($products_info['products_image'], 130, 130) . '" style="display: inline;">
			</a>';
    $html .= '<div class="product_info">';
    //name
    $html .= '<h4><a href="'.$href.'">'.$products_info['products_name'].'['.$products_info['products_model'].']</a></h4>';
    //price table
    $html .= '<table cellspacing="0" cellpadding="0"><tbody>';
    $html .= make_products_price_table($products_info['products_id'],$discount,$is_daily_deal_products);
    $html .= '</tbody></table>';
    //part number
    //product unit
    $product_number_unit = get_product_unit_memcache($products_info['products_id']);
    $product_number_unit_string = $product_number_unit['unit_number'] . $product_number_unit['unit_name'] . '/' . TEXT_PACK_FOR_OTHER_PACKAGE;
    
    $html .= '<p>'.TEXT_PART_NO.'&nbsp;'.$products_info['products_model'].'<span>' . $product_number_unit_string . '</span></p>';
    $html .= '</div>';
    //button
    $html .= make_products_button($products_info);
    $html .= '<div class="clearfix"></div>';
    $html .= '</li>';
    return $html;
}

function make_products_price_table($products_id,$discount = 0,$daily_deal_price = 0){
    $products_price_array = get_products_quantity_price($products_id);
    $count = sizeof($products_price_array)>5?5:sizeof($products_price_array);
    
    $html = '';
    $html .= '<tr>';
    $html .= '<th colspan="'.$count.'">'.TEXT_HEADER_DISCOUNT_PRICES_ACTUAL_PRICE.'</th>';
    $html .='</tr>';
    $html .='<tr>';
    foreach($products_price_array as $key=>$value){
        $currency = new currencies();
        $html .= '<td>';
        if(isset($products_price_array[$key+1])){
            $html .= '<span class="grey">'.$value['discount_qty'].'-'.$products_price_array[$key+1]['discount_qty'].'</span>';
        }else{
            $html .= '<span class="grey">'.$value['discount_qty'].'+</span>';
        }
        if($daily_deal_price){
            $html .= '<del>'.$currency->display_price($value['discount_price'],0).'</del>';
            $html .= '<ins>'.$currency->display_price($discount,0).'</ins>';
        }elseif($discount>0){
            $html .= '<del>'.$currency->display_price($value['discount_price'],0).'</del>';
            $html .= '<ins>'.$currency->display_price($value['discount_price']*(100-$discount)/100,0).'</ins>';
        }else{
            $html .=$currency->display_price($value['discount_price'],0);
        }
       
        $html .='</td>';
    }    
    $html .= '</tr>';
    return $html;
}

function get_products_quantity_price($products_id){
    global $db;
    if(!intval($products_id)){
        return array();
    }
    $products_quantity_array = array();
    $sql = 'select discount_qty,discount_price from '.TABLE_PRODUCTS_DISCOUNT_QUANTITY .' where products_id='.$products_id;
    $products_quantity_result = $db->Execute($sql);
    while(!$products_quantity_result->EOF){
        $products_quantity_array[] = array('discount_qty'=>$products_quantity_result->fields['discount_qty'],'discount_price'=>$products_quantity_result->fields['discount_price']);
        $products_quantity_result->MoveNext();
    }
    return $products_quantity_array;
}

function make_products_button($products_info){
	$page_name = 'show_package_product_listing';
	$page_type = 11;
    $html = '<div class="product_btn">';
    if(empty($products_info['products_status'])) {
    	$html .= '<p class="addwishlist"><div style="background: none repeat scroll 0% 0% rgb(232, 232, 232); width: 75%; margin:  80px auto; border: 1px solid rgb(211, 211, 211); height: 28px; line-height: 28px;  border-radius: 5px; text-align: center;">' . TEXT_REMOVED . '</div></p>';
    } else {    
	    if($products_info['products_quantity']>0 || $products_info['is_sold_out']!=1){
	        	$html .= '<div class="successtips_add successtips_add1">
	            				<span class="bot"></span>
	            				<span class="top"></span>
	            				<ins class="sh">' . TEXT_ENTER_RIGHT_QUANTITY . '</ins>
	            			</div>
	            			<input class="qty addcart_qty_input" min="1" type="number" onblur="if(value.length==0||value==0)value=1" oninput="if(value.length>5)value=value.slice(0,5)" id="' . $page_name . '_' . $products_info['products_id'].'" name="products_id['.$products_info['products_id'].']" value="1" orig_value="1">
	            			<input type="hidden" id="MDO_' . $products_info['products_id'] . '" value="0" /><input type="hidden" id="incart_' . $products_info['products_id'] . '" value="1" />	<br/>';	
	            			$min_units = zen_get_products_quantity_min_units_display($products_info['products_id']);
	            
	            $html .= '	<div class="clearfix"></div> ' . ($min_units ? '<p>'.$min_units.'</p>' : '') . ($products_info['products_limit_stock'] == 1 ? ( '<p>'.sprintf(TEXT_STOCK_HAVE_LIMIT,$products_info['products_quantity'])).'</p>' : '') . '
	            			<div class="tipsbox">
	        				<div class="successtips_add successtips_add2">
	        					<span class="bot"></span>
	        					<span class="top"></span>
	        					<ins class="sh"></ins>
	        				</div>
	        				<a rel="nofollow" class="icon_addcart" href="javascript:void(0);" id="' . $page_name . '_submitp_'.$products_info['products_id'].'" name="submitp_'.$products_info['products_id'].'" onclick="Addtocart_list('.$products_info['products_id'].', ' . $page_type . ',this); return false;"> ' . TEXT_CART_ADD_TO_CART . '</a></div>';
	    		if($products_info['products_quantity']<=0) {
	    			$html .= '<div class="clearfix"></div><div style=" margin:10px 0 0 0; color:#999">'.($products_info['products_stocking_days'] > 7 ? TEXT_AVAILABLE_IN715 : TEXT_AVAILABLE_IN57).'</div>';
	    		}
	    }else {
	         $html .= '<a rel="nofollow" class="icon_soldout" href="javascript:void(0);">'.TEXT_SOLD_OUT.'</a>';
	    }
	    
	    $html .= '<div class="tipsbox">
					<div class="successtips_add successtips_add3">
					<span class="bot"></span>
					<span class="top"></span>
					<ins class="sh"></ins>
	    			</div>
	    			<a rel="nofollow" class="text" href="javascript:void(0);" id="'. $page_name .'wishlist_'.$products_info['products_id'].'" name="'. $page_name .'wishlist_'.$products_info['products_id'].'" onclick="beforeAddtowishlist('.$products_info['products_id'].',' . $page_type . '); return false;">+ '.TEXT_CART_MOVE_TO_WISHLIST.'</a>
	    		</div>
	    	</div>';
    }
    return $html;
}
