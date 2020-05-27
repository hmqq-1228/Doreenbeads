<?php
/**
products are sorted by different types: featured, promotion,hotseller,normal one by one, that is a circle
different types have different number of products in one page, if normal product is not enough, it will be
replaced by promotion products, and so on.

 **/

$condition_best_match['sort'] = 'stock_sort desc,products_ordered desc, products_viewed desc, products_date_added desc';
$condition_best_match['fl'] = 'products_id, score';

$best_match_query='products_status:1 AND categories_id:'.(int)$current_category_id.$properties_select;

$current_time = time();
if(in_array($_GET['pack'], array('0', '1', '2'))){
	$best_match_query .= ' AND package_size:' . $_GET['pack'];
}
if(is_numeric($_GET['products_filter_onsale']) && $_GET['products_filter_onsale'] == 1) {
	$best_match_query .= ' AND ((+promotion_start_time:[0 TO ' . $current_time . '] AND +promotion_end_time:[' . $current_time . ' TO ' . PHP_INT_MAX . ']) OR (+daily_deal_start_time:[0 TO ' . $current_time . '] AND +daily_deal_end_time:[' . $current_time . ' TO ' . PHP_INT_MAX . ']))';
}
if(is_numeric($_GET['products_filter_in_stock']) && $_GET['products_filter_in_stock'] == 1) {
	$best_match_query .= ' AND -products_quantity:0';
	//$solr_select_query .= ' AND +products_quantity:[1 TO ' . PHP_INT_MAX . ']';
}
if(is_numeric($_GET['products_filter_mixed']) && $_GET['products_filter_mixed'] == 1) {
	$best_match_query .= ' AND is_mixed:1';
}
if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0) {
    $products_display_solr_str = '';
} else {
    $products_display_solr_str = ' AND is_display:1';
}
$best_match_query .= $products_display_solr_str;

$featured_solr_res = $solr->search($best_match_query, $search_offset, $item_per_page ,$condition_best_match);
$product_featured = $featured_solr_res->response->docs;
$featured_total = $featured_solr_res->response->numFound;
$featured_cnt = 0;
$product_res = array();
foreach($product_featured as $prod_val){
	$product_res[] = $prod_val->products_id;
	$featured_cnt++;
}
if($featured_cnt < $display_product_cnt){
	$not_featured_num = $display_product_cnt - $featured_cnt;
	$promotion_res = array();
	$hot_seller_res = array();
	$normal_res = array();
	$promotion_offset = 0;
	$hot_seller_offset = 0;
	$normal_offset = 0;
	$promotion_cnt = 0;
	$hot_seller_cnt=0;
	$normal_cnt=0;
	if($featured_total==0){
		$featured_page = 1;
	}else{
		$featured_page = ceil($featured_total / $item_per_page);
	}
	//when promotion is open
// 	if(SHOW_PROMOTION_AREA_STATUS==1 && strtotime(SHOW_PROMOTION_AREA_START_TIME)<time() && strtotime(SHOW_PROMOTION_AREA_END_TIME)>time()){
		$display_structure = array(
				'1'=>array('promotion'=>0.4, 'hot_seller'=>0.4, 'normal'=>0.2),
				'2'=>array('promotion'=>0.3, 'hot_seller'=>0.3, 'normal'=>0.4),
				'3'=>array('promotion'=>0.2, 'hot_seller'=>0.3, 'normal'=>0.5)
				
		);
				
	//calculate offset
	if($current_page>$featured_page && ($featured_total>0 || $current_page>1)){
		switch($featured_page){
			case 1:
				$promotion_rate = 0.4;
				$hot_seller_rate = 0.4;
				$normal_rate = 0.2;
				break;
			case 2:
				$promotion_rate = 0.3;
				$hot_seller_rate = 0.3;
				$normal_rate = 0.4;
				break;
			default:
				$promotion_rate = 0.2;
				$hot_seller_rate = 0.3;
				$normal_rate = 0.5;
				break;
		}
		$promotion_solr_count = $solr->search($best_match_query.' AND is_promotion:1', 0, $item_per_page ,$condition_best_match);
		$promotion_total = $promotion_solr_count->response->numFound;
		foreach($promotion_solr_count->response->docs as $promotion_val){
			$promotion_res[] = $promotion_val->products_id;
		}
		$hot_seller_solr_count = $solr->search($best_match_query.' AND is_promotion:0 AND is_hot_seller:1', 0, $item_per_page ,$condition_best_match);
		$hot_seller_total = $hot_seller_solr_count->response->numFound;
		foreach($hot_seller_solr_count->response->docs as $hot_val){
			$hot_seller_res[] = $hot_val->products_id;
		}
		$normal_solr_count = $solr->search($best_match_query.' AND is_promotion:0 AND is_hot_seller:0', 0, $item_per_page ,$condition_best_match);
		$normal_total = $normal_solr_count->response->numFound;
		foreach($normal_solr_count->response->docs as $normal_val){
			$normal_res[] = $normal_val->products_id;
		}
		$first_page_res = array();
		$promotion_per_page = $item_per_page*$promotion_rate;
		$hot_seller_per_page = $item_per_page*$hot_seller_rate;
		$normal_per_page = $item_per_page*$normal_rate;
		
		for($i=0;$i<$item_per_page;){
			
			//promotion product
			if($promotion_cnt<$promotion_per_page){
				if(sizeof($promotion_res)>0){
					$first_page_res[] = 'promotion';
					unset($promotion_res[$promotion_cnt]);
								
				}elseif(sizeof($hot_seller_res)>0){
					$first_page_res[] = 'hot_seller';
					unset($hot_seller_res[$hot_seller_cnt]);					
					$hot_seller_cnt++;
					$hot_seller_per_page++;
				}else{
					$first_page_res[] = 'normal';
					unset($normal_res[$normal_cnt]);					
					$normal_cnt++;
					$normal_per_page++;
				}
				$promotion_cnt++;
				$i++;
			}
			if(sizeof($first_page_res)>=$item_per_page) break;
			
			//hot seller product
			if($hot_seller_cnt<$hot_seller_per_page){
				if(sizeof($hot_seller_res)>0){
					$first_page_res[] = 'hot_seller';
					unset($hot_seller_res[$hot_seller_cnt]);
			
				}elseif(sizeof($promotion_res)>0){
					$first_page_res[] = 'promotion';
					unset($promotion_res[$promotion_cnt]);
					$promotion_cnt++;
					$promotion_per_page++;
				}else{
					$first_page_res[] = 'normal';
					unset($normal_res[$normal_cnt]);
					$normal_cnt++;
					$normal_per_page++;
				}
				$hot_seller_cnt++;
				$i++;
			}
			if(sizeof($first_page_res)>=$item_per_page) break;
			
			//normal product
			if($normal_cnt<$normal_per_page){
				if(sizeof($normal_res)>0){
					$first_page_res[] = 'normal';
					unset($normal_res[$normal_cnt]);
			
				}elseif(sizeof($promotion_res)>0){
					$first_page_res[] = 'promotion';
					unset($promotion_res[$promotion_cnt]);
					$promotion_cnt++;
					$promotion_per_page++;
				}else{
					$first_page_res[] = 'hot_seller';
					unset($hot_seller_res[$hot_seller_cnt]);
					$hot_seller_cnt++;
					$hot_seller_per_page++;
				}
				$normal_cnt++;
				$i++;
			}
		}
		//print_r($first_page_res);exit;
		for($j=0;$j<$item_per_page - $featured_total % $item_per_page;$j++){
			switch($first_page_res[$j]){
				case 'promotion':
					$promotion_offset++;
					break;
				case 'hot_seller':
					$hot_seller_offset++;
					break;
				default:
					$normal_offset++;
					break;
			}
		}
		
		$delta = 0;
		if($featured_page==1 && $current_page>2){			
			$promotion_offset+=$item_per_page*$display_structure[2]['promotion']+$item_per_page*($current_page-3)*$display_structure[3]['promotion'];			
			$hot_seller_offset+=$item_per_page*$display_structure[2]['hot_seller']+$item_per_page*($current_page-3)*$display_structure[3]['hot_seller'];
			$normal_offset+=$item_per_page*$display_structure[2]['normal']+$item_per_page*($current_page-3)*$display_structure[3]['normal'];
			
		}elseif($current_page>2){
			$promotion_offset+=$item_per_page*($current_page-3)*$display_structure[3]['promotion'];
			$hot_seller_offset+=$item_per_page*($current_page-3)*$display_structure[3]['hot_seller'];
			$normal_offset+=$item_per_page*($current_page-3)*$display_structure[3]['normal'];
				
		}
		if($normal_offset>$normal_total){
			$delta = $normal_offset - $normal_total;
			$normal_offset = $normal_total;
			$promotion_offset+=$delta;
			if($promotion_offset>$promotion_total){
				$delta=$promotion_offset-$promotion_total;
				$promotion_offset=$promotion_total;
				$hot_seller_offset+=$delta;
			}
		}
		if($hot_seller_offset>$hot_seller_total){
			$delta = $hot_seller_offset-$hot_seller_total;
			$hot_seller_offset = $hot_seller_total;
			$promotion_offset+=$delta;
			if($promotion_offset>$promotion_total){
				$delta=$promotion_offset-$promotion_total;
				$promotion_offset=$promotion_total;
				$normal_offset+=$delta;
			}
		}
		if($promotion_offset>$promotion_total){
			$delta=$promotion_offset-$promotion_total;
			$promotion_offset=$promotion_total;
			$hot_seller_offset+=$delta;
			if($hot_seller_offset>$hot_seller_total){
				$delta=$hot_seller_offset-$hot_seller_total;
				$hot_seller_offset=$hot_seller_total;
				$normal_offset+=$delta;
			}
		}
		$promotion_res = array();
		$hot_seller_res = array();
		$normal_res = array();
		//echo $promotion_offset.', '.$hot_seller_offset.', '.$normal_offset;exit;
	}
		$promotion_solr_res = $solr->search($best_match_query.' AND is_promotion:1', $promotion_offset, $not_featured_num ,$condition_best_match);
		foreach($promotion_solr_res->response->docs as $promotion_val){
			$promotion_res[] = $promotion_val->products_id;
		}		
		$hot_solr_res = $solr->search($best_match_query.' AND is_promotion:0 AND is_hot_seller:1', $hot_seller_offset, $not_featured_num ,$condition_best_match);
		foreach($hot_solr_res->response->docs as $hot_val){
			$hot_seller_res[] = $hot_val->products_id;
		}		
		$normal_solr_res = $solr->search($best_match_query.' AND is_promotion:0 AND is_hot_seller:0', $normal_offset, $not_featured_num ,$condition_best_match);
		foreach($normal_solr_res->response->docs as $normal_val){
			$normal_res[] = $normal_val->products_id;
		}
				
		switch($current_page){
			case 1:
				$promotion_rate = 0.4;
				$hot_seller_rate = 0.4;
				$normal_rate = 0.2;
				break;
			case 2:
				$promotion_rate = 0.3;
				$hot_seller_rate = 0.3;
				$normal_rate = 0.4;
				break;
			default:
				$promotion_rate = 0.2;
				$hot_seller_rate = 0.3;
				$normal_rate = 0.5;
				break;
		}
		
// 	}else{
// //when promotion is closed
// 		$display_structure = array(
// 				'1'=>array('promotion'=>0, 'hot_seller'=>0.8, 'normal'=>0.2),
// 				'2'=>array('promotion'=>0, 'hot_seller'=>0.6, 'normal'=>0.4),
// 				'3'=>array('promotion'=>0, 'hot_seller'=>0.5, 'normal'=>0.5)
		
// 		);
		
// 		//calculate offset
// 		if($current_page>$featured_page && ($featured_total>0 || $current_page>1)){
// 			switch($featured_page){
// 				case 1:
// 					$promotion_rate = 0;
// 					$hot_seller_rate = 0.8;
// 					$normal_rate = 0.2;
// 					break;
// 				case 2:
// 					$promotion_rate = 0;
// 					$hot_seller_rate = 0.6;
// 					$normal_rate = 0.4;
// 					break;
// 				default:
// 					$promotion_rate = 0;
// 					$hot_seller_rate = 0.5;
// 					$normal_rate = 0.5;
// 					break;
// 			}
			
// 			$hot_seller_solr_count = $solr->search($best_match_query.' AND is_hot_seller:1', 0, $item_per_page ,$condition_best_match);
// 			$hot_seller_total = $hot_seller_solr_count->response->numFound;
// 			foreach($hot_seller_solr_count->response->docs as $hot_val){
// 				$hot_seller_res[] = $hot_val->products_id;
// 			}
// 			$normal_solr_count = $solr->search($best_match_query.' AND is_hot_seller:0', 0, $item_per_page ,$condition_best_match);
// 			$normal_total = $normal_solr_count->response->numFound;
// 			foreach($normal_solr_count->response->docs as $normal_val){
// 				$normal_res[] = $normal_val->products_id;
// 			}
// 			$first_page_res = array();
			
// 			$hot_seller_per_page = $item_per_page*$hot_seller_rate;
// 			$normal_per_page = $item_per_page*$normal_rate;
// 		for($i=0;$i<$item_per_page;){
			
// 			//hot seller product
// 			if($hot_seller_cnt<$hot_seller_per_page){
// 				if(sizeof($hot_seller_res)>0){
// 					$first_page_res[] = 'hot_seller';
// 					unset($hot_seller_res[$hot_seller_cnt]);
			
// 				}else{
// 					$first_page_res[] = 'normal';
// 					unset($normal_res[$normal_cnt]);
// 					$normal_cnt++;
// 					$normal_per_page++;
// 				}
// 				$hot_seller_cnt++;
// 				$i++;
// 			}
// 			if(sizeof($first_page_res)>=$item_per_page) break;
			
// 			//normal product
// 			if($normal_cnt<$normal_per_page){
// 				if(sizeof($normal_res)>0){
// 					$first_page_res[] = 'normal';
// 					unset($normal_res[$normal_cnt]);
			
// 				}else{
// 					$first_page_res[] = 'hot_seller';
// 					unset($hot_seller_res[$hot_seller_cnt]);
// 					$hot_seller_cnt++;
// 					$hot_seller_per_page++;
// 				}
// 				$normal_cnt++;
// 				$i++;
// 			}
// 		}
// 			//print_r($first_page_res);exit;
// 			for($j=0;$j<$item_per_page - $featured_total % $item_per_page;$j++){
// 				switch($first_page_res[$j]){
// 					case 'promotion':
// 						$promotion_offset++;
// 						break;
// 					case 'hot_seller':
// 						$hot_seller_offset++;
// 						break;
// 					default:
// 						$normal_offset++;
// 						break;
// 				}
// 			}
			
// 			$delta = 0;
// 			if($featured_page==1 && $current_page>2){
				
// 				$hot_seller_offset+=$item_per_page*$display_structure[2]['hot_seller']+$item_per_page*($current_page-3)*$display_structure[3]['hot_seller'];
// 				$normal_offset+=$item_per_page*$display_structure[2]['normal']+$item_per_page*($current_page-3)*$display_structure[3]['normal'];
					
// 			}elseif($current_page>2){
				
// 				$hot_seller_offset+=$item_per_page*($current_page-3)*$display_structure[3]['hot_seller'];
// 				$normal_offset+=$item_per_page*($current_page-3)*$display_structure[3]['normal'];
		
// 			}
// 			if($normal_offset>$normal_total){
// 				$delta = $normal_offset - $normal_total;
// 				$normal_offset = $normal_total;
// 				$hot_seller_offset+=$delta;				
// 			}
// 			if($hot_seller_offset>$hot_seller_total){
// 				$delta = $hot_seller_offset-$hot_seller_total;
// 				$hot_seller_offset = $hot_seller_total;
// 				$normal_offset+=$delta;				
// 			}
						
// 			$promotion_res = array();
// 			$hot_seller_res = array();
// 			$normal_res = array();
// 			//echo $promotion_offset.', '.$hot_seller_offset.', '.$normal_offset;exit;
// 		}
// 		$hot_solr_res = $solr->search($best_match_query.' AND is_hot_seller:1', $hot_seller_offset, $not_featured_num ,$condition_best_match);
// 		foreach($hot_solr_res->response->docs as $hot_val){
// 			$hot_seller_res[] = $hot_val->products_id;
// 		}
// 		$normal_solr_res = $solr->search($best_match_query.' AND is_hot_seller:0', $normal_offset, $not_featured_num ,$condition_best_match);
// 		foreach($normal_solr_res->response->docs as $normal_val){
// 			$normal_res[] = $normal_val->products_id;
// 		}
		
// 		switch($current_page){
// 			case 1:
// 				$promotion_rate = 0;
// 				$hot_seller_rate = 0.8;
// 				$normal_rate = 0.2;
// 				break;
// 			case 2:
// 				$promotion_rate = 0;
// 				$hot_seller_rate = 0.6;
// 				$normal_rate = 0.4;
// 				break;
// 			default:
// 				$promotion_rate = 0;
// 				$hot_seller_rate = 0.5;
// 				$normal_rate = 0.5;
// 				break;
// 		}
// 	}
	
	$promotion_cnt = 0;
	$hot_seller_cnt=0;
	$normal_cnt=0;
	$promotion_per_page = $item_per_page*$promotion_rate;
	$hot_seller_per_page = $item_per_page*$hot_seller_rate;
	$normal_per_page = $item_per_page*$normal_rate;
	
	for($i=0;$i<$not_featured_num;){
		
		//promotion product
		if($promotion_cnt<$promotion_per_page){
			if(sizeof($promotion_res)>0){
				$product_res[] = $promotion_res[$promotion_cnt];
				unset($promotion_res[$promotion_cnt]);				
				
			}elseif(sizeof($hot_seller_res)>0){
				$product_res[] = $hot_seller_res[$hot_seller_cnt];
				unset($hot_seller_res[$hot_seller_cnt]);
				$hot_seller_cnt++;
				$hot_seller_per_page++;
			}else{
				$product_res[] = $normal_res[$normal_cnt];
				unset($normal_res[$normal_cnt]);
				$normal_cnt++;
				$normal_per_page++;
			}
			$promotion_cnt++;
			$i++;
		}
		if(sizeof($product_res)>=$display_product_cnt) break;
		
		//hot seller product
		if($hot_seller_cnt<$hot_seller_per_page){
			if(sizeof($hot_seller_res)>0){
				$product_res[] = $hot_seller_res[$hot_seller_cnt];
				unset($hot_seller_res[$hot_seller_cnt]);				
		
			}elseif(sizeof($promotion_res)>0){
				$product_res[] = $promotion_res[$promotion_cnt];
				unset($promotion_res[$promotion_cnt]);
				$promotion_cnt++;
				$promotion_per_page++;
			}else{
				$product_res[] = $normal_res[$normal_cnt];
				unset($normal_res[$normal_cnt]);
				$normal_cnt++;
				$normal_per_page++;
			}
			$hot_seller_cnt++;
			$i++;
		}
		if(sizeof($product_res)>=$display_product_cnt) break;
		
		//normal product
		if($normal_cnt<$normal_per_page){
			if(sizeof($normal_res)>0){
				$product_res[] = $normal_res[$normal_cnt];
				unset($normal_res[$normal_cnt]);
		
			}elseif(sizeof($promotion_res)>0){
				$product_res[] = $promotion_res[$promotion_cnt];
				unset($promotion_res[$promotion_cnt]);
				$promotion_cnt++;
				$promotion_per_page++;
			}else{
				$product_res[] = $hot_seller_res[$hot_seller_cnt];
				unset($hot_seller_res[$hot_seller_cnt]);
				$hot_seller_cnt++;
				$hot_seller_per_page++;
			}
			$normal_cnt++;
			$i++;
		}

	}
	
}
//var_dump($product_res);exit;

?>