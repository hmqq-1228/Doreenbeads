<?php
require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));

$area_id = intval($_GET['aId']);
$languages_id = intval($_SESSION['languages_id']);

if($area_id >0)
{
	$result = get_product_promotion_area_info($area_id,$languages_id,2);
	
	$area_info = array(
			"area_info" =>null,
			"area_products"=> array()
	);
	
	if($result ->RecordCount() >0)
	{
		$area_info['area_info'] = array(
				"area_id" =>$result ->fields['promotion_area_id'],
				"area_name" =>$result ->fields['promotion_area_name'],
				"area_name_en" =>$result ->fields['promotion_area_name_en'],
				"area_status" =>$result ->fields['promotion_area_status'],
				"area_languages" =>$result ->fields['promotion_area_languages'],
				"related_promotion_ids" =>$result ->fields['related_promotion_ids'],
				"area_type" =>$result ->fields['promotion_area_type'],
		);
	}
	
	if($area_info &&  $area_info['area_info']['area_status'] == 1 &&  $area_info['area_info']['area_type'] == 2 && in_array($languages_id, explode(',', $area_info['area_info']['area_languages'])))
	{
		
		$detail_result = get_product_promotion_deals_info($area_id,$area_info['area_info']['related_promotion_ids']);
				
		if($detail_result ->RecordCount() > 0)
		{ 
			
			$all_marketing_infos = get_deals_marketing_info();
			$max_marketing_count = count($all_marketing_infos);
			  
			while(!$detail_result->EOF)
			{  
				$product_id = $detail_result ->fields['pp_products_id'];   
				$product_info = get_products_info_memcache($product_id);
				if($product_info['products_status'] == 1){
					$product_info['products_name'] = get_products_description_memcache($product_id,$languages_id);  
					$product_info ['show_name'] = htmlspecialchars ( zen_clean_html ($product_info['products_name']) );
					$product_info ['products_quantity'] = zen_get_products_stock($product_id);
					$product_info ['weight'] = $product_info ['products_weight'];
					$product_info ['vweight'] = $product_info ['products_volume_weight'];
					$product_info ['shipping_weight'] = $product_info ['vweight'] > $product_info ['weight'] ? $product_info ['vweight'] :$product_info ['weight'] ;
					$product_info ['per_pack_qty'] = $product_info['per_pack_qty'];
					if($product_info['products_limit_stock']==1 && $product_info['products_quantity']!=0){
						$product_info ['addtocart_max'] = $product_info['products_quantity'];
					}
					$unit_info = get_product_unit_memcache($product_id);
					$product_info ['unit_number'] = $unit_info['unit_number'];
					$product_info ['unit_name'] = $unit_info['unit_name'];
	
					$product_info ['image'] = $product_info ['products_image'];
					$product_info ['main_image_src'] = HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size ( $product_info ['image'], 500, 500 ); 
					
					//date info
					$product_info ['start_datetime'] = $detail_result ->fields['pp_promotion_start_time']; 
					$product_info ['end_datetime'] = $detail_result ->fields['pp_promotion_end_time']; 
					
					//price info 
					$product_info['discount_off'] =  round($detail_result ->fields['promotion_discount']); 
					$original_price = zen_get_products_quantity_discounts($product_id);
					$original_price = $original_price ? $original_price : $product_info[products_price];
					$original_price = round($original_price,2);
					$product_info['original_price'] =  $original_price;
					$product_info['sale_price'] = round($product_info['original_price'] * (100 - $product_info['discount_off']) / 100,2);
					$product_info['save_price'] = round($product_info['original_price'] - $product_info['sale_price'],2);
					 
					//markting info
					$rand_index = mt_rand(0, $max_marketing_count >1 ? $max_marketing_count -1 : 0); 
					$product_info['marketing_title'] = $max_marketing_count >1 ? $all_marketing_infos[$rand_index]:$all_marketing_infos[0];
					$product_info['sold_qty'] = get_deals_sold_info($product_id);
					
					#var_dump($product_info);die();
					$area_info['area_products'][] = $product_info;
				}
				$detail_result->MoveNext();
			} 
		}
	}else{
		record_valid_url();
		zen_redirect(zen_href_link(FILENAME_DEFAULT));
	}
}

if(!$area_info || sizeof($area_info['area_products']) == 0 ){
	//记录无效链接
	record_valid_url();
	//eof
}

if(!$area_info)
{
	zen_redirect(zen_href_link(FILENAME_DEFAULT));
}else
{ 
	$breadcrumb->add($area_info['area_info']['area_name']);
}

#var_dump($area_info);die();

?>