<?php
require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));

function select_lc_categories($parent_id=0, &$arr=array(), $path=''){
	global $db;

	$parent_id = intval($parent_id);
	$lc_categories_sql = "select lcc.lc_categories_id, lccd.lc_categories_name ,lcc.parent_id, lcc.lc_categories_images, lccd.lc_categories_description
				from ". TABLE_LC_CATEGORIES ." lcc, ". TABLE_LC_CATEGORIES_DESC ." lccd 
				where lcc.parent_id = ".$parent_id." 
				and lcc.lc_categories_id = lccd.lc_categories_id 
				and lccd.language_id='" . $_SESSION['languages_id'] . "' 
				and lcc.categories_status=1 
				order by lcc.lc_categories_id";

	$lc_categories = $db->Execute($lc_categories_sql);
	if($lc_categories->RecordCount()>0){
		while (!$lc_categories->EOF) {
			$path2 = ($path=='' ? '' : $path.'_').$lc_categories->fields['lc_categories_id'];
			$images = explode(',', $lc_categories->fields['lc_categories_images']);
			if ($images['0'] == '') {
				$sub_image_array = array();
				$sub_image_sql = "select a.article_id ,a.article_images, a.video_image, las.article_steps_images
									from ". TABLE_LC_ARTICLE." a left join ".TABLE_LC_ARTICLE_STEPS." las on (a.article_id = las.article_id)
									where a.categories_path like '%:".$lc_categories->fields['lc_categories_id'].":%' 
									order by a.article_id desc limit 1";
				$sub_image_result = $db->Execute($sub_image_sql);
				if($sub_image_result->RecordCount()>0){
					while (!$sub_image_result->EOF) {
						$sub_image_array = array("aid" => $sub_image_result->fields['article_id'],
												"article_images" => $sub_image_result->fields['article_images'],
												"video_image" => $sub_image_result->fields['video_image'],
												"article_steps_images" => $sub_image_result->fields['article_steps_images']
						);
						$sub_image_result->MoveNext();
					}
				}
				//var_dump($sub_image_array);
				
				if (!empty($sub_image_array['article_images'])) {
					$images['0'] = $sub_image_array['article_images'];
				}elseif (!empty($sub_image_array['article_steps_images'])) {
					$images['0'] = $sub_image_array['article_steps_images'];
				}elseif (!empty($sub_image_array['video_image'])) {
					$images['0'] = $sub_image_array['video_image'];
				}else{
					$images['0'] = '../includes/templates/cherry_zen/images/'.$_SESSION['language'].'/200X200.png ';
				}
			}
			$arr[$parent_id][] = array("id" => $lc_categories->fields['lc_categories_id'],
									"path" => $path2,
									"name" => $lc_categories->fields['lc_categories_name'],
									"parent_id" => $lc_categories->fields['parent_id'],
									"images" => $images['0'],
									"desc" => $lc_categories->fields['lc_categories_description'],
									"url" => zen_href_link('learning_center', 'cid='.$lc_categories->fields['lc_categories_id'])
			);
			select_lc_categories($lc_categories->fields['lc_categories_id'], $arr, $path2);
			$lc_categories->MoveNext();
		}
	}
	return $arr;
}

$lc_categories_array1 = select_lc_categories();

	$lc_categories_array_list1 = array_shift($lc_categories_array1);

	foreach ($lc_categories_array_list1 as $key => $value) {
		$lc_categories_array_result1[] = $value;
	}

	foreach ($lc_categories_array_result1 as $key => $value) {
		foreach ($lc_categories_array1 as $key1 => $value1) {

			foreach ($value1 as $key2 => $value2) {
				if ($value2['parent_id'] == $value['id']) {
					$lc_categories_array_result1[$key][$value['id']] = $value1;
				}
			}
		}
	}
	foreach ($lc_categories_array1 as $key => $value) {
		foreach ($value as $key1 => $value1) {
			$lc_categories_array_sum1[] = $value1;
		}
	}

	/*echo '<pre>';
	print_r($lc_categories_array_sum);
	echo '</pre>';*/

	foreach ($lc_categories_array_result1 as $key => $value) {
		foreach ($value[$value['id']] as $key1 => $value1) {
			foreach ($lc_categories_array_sum1 as $key2 => $value2) {				
				if ($value2['parent_id'] == $value1['id']) {
					$list[] = $value2;
				}			
			}
		$lc_categories_array_result1[$key][$value['id']][$key1][$value1['id']] = $list;
		unset($list);
		}
	}

// index
if(empty($_GET['cid']) && empty($_GET['aid'])){ 
	$ishomepage = true;
	$lc_categories_array = select_lc_categories();

	$lc_categories_array_list = array_shift($lc_categories_array);

	foreach ($lc_categories_array_list as $key => $value) {
		$lc_categories_array_result[] = $value;
	}

	foreach ($lc_categories_array_result as $key => $value) {

		foreach ($lc_categories_array as $key1 => $value1) {
			foreach ($value1 as $key2 => $value2) {
				if ($value2['parent_id'] == $value['id']) {
					$lc_categories_array_result[$key][$value['id']] = $value1;
				}
			}
		}
	}
	foreach ($lc_categories_array as $key => $value) {
		foreach ($value as $key1 => $value1) {
			$lc_categories_array_sum[] = $value1;
		}
	}

	/*echo '<pre>';
	print_r($lc_categories_array_sum);
	echo '</pre>';*/

	foreach ($lc_categories_array_result as $key => $value) {
		foreach ($value[$value['id']] as $key1 => $value1) {
			foreach ($lc_categories_array_sum as $key2 => $value2) {				
				if ($value2['parent_id'] == $value1['id']) {
					$list[] = $value2;
				}			
			}
		$lc_categories_array_result[$key][$value['id']][$key1][$value1['id']] = $list;
		unset($list);
		}
	}
}elseif(!empty($_GET['cid'])){
	$ishomepage = false;
	$cid = $_GET['cid'];
	$view = $_GET['view'];
	$lc_categories_array_result = array();
	$cid_sql = "select lccd.lc_categories_name 
				from ". TABLE_LC_CATEGORIES_DESC ." lccd, ". TABLE_LC_CATEGORIES ." lcc
				where lccd.lc_categories_id = '".$cid."'
				and lcc.lc_categories_id = lccd.lc_categories_id
				and lcc.categories_status = 1
				and lccd.language_id='". $_SESSION['languages_id']."' " ;
	$cid_result = $db->Execute($cid_sql);
	/*if ($cid_result->EOF) {
		die('sorry,it has something wrong, please refresh your page');
	}*/
	if($cid_result->RecordCount()>0){
		while (!$cid_result->EOF) {
			$lc_categories_array_result[0] = array("name" => $cid_result->fields['lc_categories_name'],
													"id" => $cid);
			$cid_result->MoveNext();
		}
	}
	
	$lc_cate_sql = "select lcc.lc_categories_id, lccd.lc_categories_name ,lcc.parent_id, lcc.lc_categories_images, lccd.lc_categories_description
				from ". TABLE_LC_CATEGORIES ." lcc, ". TABLE_LC_CATEGORIES_DESC ." lccd 
				where lcc.parent_id = ".$cid." 
				and lcc.lc_categories_id = lccd.lc_categories_id 
				and lccd.language_id='" . $_SESSION['languages_id'] . "' 
				and lcc.categories_status=1 
				order by lcc.lc_categories_id desc";

	$lc_cate = $db->Execute($lc_cate_sql);
	if (isset($lc_cate->fields)) {
		if($lc_cate->RecordCount()>0){
			while (!$lc_cate->EOF) {
				$sub_image_array = array();
				$sub_image_sql = "select a.article_id ,a.article_images, a.video_image, las.article_steps_images
									from ". TABLE_LC_ARTICLE." a left join ".TABLE_LC_ARTICLE_STEPS." las on (a.article_id = las.article_id)
									where a.categories_path like '%:".$lc_cate->fields['lc_categories_id'].":%' 
									order by a.article_id desc limit 1";
				$sub_image_result = $db->Execute($sub_image_sql);
				if($sub_image_result->RecordCount()>0){
					while (!$sub_image_result->EOF) {
						$sub_image_array = array("aid" => $sub_image_result->fields['article_id'],
												"article_images" => $sub_image_result->fields['article_images'],
												"video_image" => $sub_image_result->fields['video_image'],
												"article_steps_images" => $sub_image_result->fields['article_steps_images']
						);
						$sub_image_result->MoveNext();
					}
				}
				//var_dump($sub_image_array);
				
				if (!empty($sub_image_array['article_images'])) {
					$images['0'] = $sub_image_array['article_images'];
				}elseif (!empty($sub_image_array['article_steps_images'])) {
					$images['0'] = $sub_image_array['article_steps_images'];
				}elseif (!empty($sub_image_array['video_image'])) {
					$images['0'] = $sub_image_array['video_image'];
				}else{
					$images['0'] = '../includes/templates/cherry_zen/images/'.$_SESSION['language'].'/200X200.png ';
				}
				$lc_categories_array_result[0][$cid][] = array("id" => $lc_cate->fields['lc_categories_id'],
												"name" => getstrbylength($lc_cate->fields['lc_categories_name'], 20),
												"parent_id" => $lc_cate->fields['parent_id'],
												"images" => $images['0'],
												"desc" => $lc_cate->fields['lc_categories_description'],
												"url" => zen_href_link('learning_center', 'cid='.$lc_cate->fields['lc_categories_id'])
				);
				$lc_cate->MoveNext();
			}
/*			echo '<pre>';
			print_r($lc_categories_array_result);
			echo '</pre>';
			exit;*/
		}
	}else{
		$article_sql = "select a.article_id, a.title_abbreviation, a.article_images,a.video_image, las.article_steps_images
				from ".TABLE_LC_ARTICLE." a left join ".TABLE_LC_ARTICLE_STEPS." las on (a.article_id = las.article_id)
				where a.lc_categories_id = ".$cid." 
				and a.language_id='" . $_SESSION['languages_id'] . "' 
				and a.article_status=1 
				group by a.article_id
				order by a.article_id desc";
		$article_result = $db->Execute($article_sql);
		if($article_result->RecordCount()>0){
			while (!$article_result->EOF) {
				if (!empty($article_result->fields['article_images'])) {
						$image = $article_result->fields['article_images'];
					}elseif(!empty($article_result->fields['article_steps_images'])){
						$image = $article_result->fields['article_steps_images'];
					}elseif(!empty($article_result->fields['video_image'])){
						$image = $article_result->fields['video_image'];
					}else{
						$image = '../includes/templates/cherry_zen/images/'.$_SESSION['language'].'/200X200.png ';
					}
				$lc_categories_array_result[0][$cid][] = array("id" => $article_result->fields['article_id'],
														"name" => getstrbylength($article_result->fields['title_abbreviation'], 20),
														"main_images" => $article_result->fields['article_images'],
														"images" => $image,
														"url" => zen_href_link('learning_center', 'aid='.$article_result->fields['article_id'])
				);
				$article_result->MoveNext();
			}
		}
	}
	
}elseif (!empty($_GET['aid'])) {
	$aid = $_GET['aid'];
	$article_sql2 = "select article_title , article_images, article_summary, video_position, video_code, parts_num, tools_num, material_list
				from ".TABLE_LC_ARTICLE."  
				where article_id = ".$aid." 	 
				and language_id='" . $_SESSION['languages_id'] . "' 
				and article_status=1 ";

	$article_result2 = $db->Execute($article_sql2);
	if($article_result2->RecordCount()>0){
		while (!$article_result2->EOF) {
			$article_list_array2 = array("aid" => $aid,
								"title" => $article_result2->fields['article_title'],
								"images" => $article_result2->fields['article_images'],
								"article_summary" => $article_result2->fields['article_summary'],
								"video_position" => $article_result2->fields['video_position'],
								"video_code" => stripslashes($article_result2->fields['video_code']),
								"parts_num" => $article_result2->fields['parts_num'],
								"tools_num" => $article_result2->fields['tools_num'],
								"material_list" => $article_result2->fields['material_list']
			);
			$article_result2->MoveNext();
		}
	}
	/*echo '<pre>';
	print_r($article_list_array2);
	echo '</pre>';
	*/
	$article_steps_sql = "select article_steps_images, article_steps_summary, article_steps_url
				from ".TABLE_LC_ARTICLE_STEPS."  
				where article_id = ".$aid."
				order by article_steps_id " 
				;

	$article_steps_result = $db->Execute($article_steps_sql);
	if($article_steps_result->RecordCount()>0){
		while (!$article_steps_result->EOF) {
			$article_steps_array[] = array("article_steps_images" => $article_steps_result->fields['article_steps_images'],
											"article_steps_summary" => $article_steps_result->fields['article_steps_summary'],
											"article_steps_url" => $article_steps_result->fields['article_steps_url'],
											
			);
			$article_steps_result->MoveNext();
		}
	}
	$parts_num = explode(',', $article_list_array2['parts_num']);
	foreach ($parts_num as $key => $value) {
		$parts_arr[] = "'".$value."'";
	}
	$parts_num1 = implode(',', $parts_arr);

	$tools_num = explode(',', $article_list_array2['tools_num']);
	foreach ($tools_num as $key => $value) {
		$tools_arr[] = "'".$value."'";
	}
	$tools_num1 = implode(',', $tools_arr);

	$nums = $parts_num1.','.$tools_num1;

	$parts_num_sql = "select p.products_id
						from ".TABLE_PRODUCTS." p 
						where p.products_model in (".$nums.")
						and p.products_status = 1 ";

	$parts_num_result = $db->Execute($parts_num_sql);
	$product_res = array();
	if($parts_num_result->RecordCount()>0){
		while (!$parts_num_result->EOF) {
			$product_res[] = $parts_num_result->fields['products_id'];
			$parts_num_result->MoveNext();
		}
	} 
	if(sizeof($product_res) > 0){
		$products_id_str = implode(',', $product_res);
		$product_info_pre = array();
		 
		$products_info_query = $db->Execute("select p.products_id,p.products_model, p.products_image, p.products_weight,p.products_limit_stock,p.product_is_call, p.products_type,
								 	p.products_price, pd.products_name, p.products_quantity_order_min, p.products_quantity_order_max, p.products_volume_weight, p.products_qty_box_status , p.products_date_added,p.products_status
		       						from ".TABLE_PRODUCTS." p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id
		       						where pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
		       						and p.products_id in (".$products_id_str.")");
		 
		if($products_info_query->RecordCount() > 0){
			while(!$products_info_query->EOF){
				$product_info_pre[$products_info_query->fields['products_id']] = $products_info_query->fields;
				 
				$products_info_query->MoveNext();
			}
		}
		
		foreach($product_res as $prod_val){
			$products_id = $prod_val;
			$listing = $product_info_pre[$products_id];
			
			if (sizeof($listing) == 0) {
				continue;
			}
			$listing['products_quantity'] = zen_get_products_stock($products_id);
	
			if (isset($customer_basket_products[$products_id])) {  //if item already in cart
	            $procuct_qty = $customer_basket_products[$products_id];
	            $bool_in_cart = 1;
	        } else {
	            $procuct_qty = 0;
	            $bool_in_cart = 0;
	        }
	        
			$link = zen_href_link('product_info', ($_GET['cPath'] > 0 ? 'cPath=' . $_GET['cPath'] . '&' : '') . 'products_id=' . $listing['products_id']);
			
			$imgsrc = HTTP_IMG_SERVER. 'bmz_cache/' .  get_img_size($listing['products_image'],"310","310");
			$pro_array['image'] = '<a href="' . $link . '" class="dlgallery-img lazy"><img src="' . $imgsrc.'" alt="'. zen_output_string($listing['products_name']) .'" width="143" height="143"></a>';	
			/*other package size check WSL*/
			$other_package_products_array = get_products_package_id_by_products_id($products_id);
			if (sizeof($other_package_products_array) > 0) {
				$pro_array['image'] .= '<a href="'.zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$products_id).'#other_package_size_products'.'" style="display:block;bottom:8px;text-decoration:underline;text-align:center;">'.TEXT_OTHER_PACKAGE_SIZE.'</a>';
			}
			/*end*/
			$pro_array['name'] = '<a class="dlgallery-text" href="'.$link.'">'.zen_name_add_space(getstrbylength ( htmlspecialchars ( zen_clean_html ($listing['products_name']) ), 35 )).'</a>';
			$pro_array['price'] = zen_get_products_display_price_new($listing['products_id'], 'mobile_gallery');
			//*正常列表页也显示WSL*/
	        //if($_GET['pn']=='promotion'){
			    $discount_amount = zen_show_discount_amount($products_id);
			    if($discount_amount)
			        $pro_array['discount'] = '<div class="floatprice"><span>'.$discount_amount.'%<br/>off</span></div>';
			    else $pro_array['discount']='';
			/* }else{
			    $pro_array['discount']='';
			} */
			
			$the_button = zen_get_qty_input_and_button_gallery($listing, $bool_in_cart, $procuct_qty, $page_type);
					
			$pro_array['cart'] = $the_button;
			
			$product_info = $listing;
			$product_info['discount_amount'] = $discount_amount;
			$product_info['show_name'] = zen_name_add_space(getstrbylength ( htmlspecialchars ( zen_clean_html ($listing['products_name']) ), 80 ));
			$product_info['is_in_cart'] = $bool_in_cart;
			$product_info['cart_qty'] = $procuct_qty;
			$product_info['link'] = $link;
			$product_info['main_image_src'] = $imgsrc;
			$product_info['other_package_products'] = $other_package_products_array;
			$product_info['price_html'] = $pro_array['price'];
			
			$product_info_list[] = $product_info;
			
			$list_box_contents_property[] = $pro_array;
	    }
	}
}

/*echo '<pre>';
print_r($lc_categories_array_result);
echo '</pre>';
exit;*/
$smarty->assign ( 'ishomepage', $ishomepage );
$smarty->assign ( 'cid', $_GET['cid'] ); 
$smarty->assign ( 'aid', $_GET['aid'] );
$smarty->assign ( 'view', $view );
$smarty->assign ( 'allcate', $lc_categories_array_result );
$smarty->assign ( 'article', $article_list_array2 );
$smarty->assign ( 'articlesteps', $article_steps_array );
$smarty->assign('current_page',$current_page);
$smarty->assign('split_page_link_info',$split_page_link_info);
$smarty->assign('split_page_count_info',$split_page_count_info);
$smarty->assign('product_info_list',$product_info_list);
$smarty->assign('learning_center_url',zen_href_link('learning_center', zen_get_all_get_params(array('cid'))));
$smarty->assign('learning_center_index',zen_href_link('learning_center'));
?>