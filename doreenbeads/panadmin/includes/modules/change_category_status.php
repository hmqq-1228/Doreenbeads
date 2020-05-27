<?php
	function control_cate_status($as_categories_id = 0, $as_categories_status = 2, $set_products_status = ''){
		global $db;
		$change_tips=false;
		$cateprod_status_return = array();
		$return_array=array();
		if ($as_categories_id > 0) {
			$categories_num = get_category_num($as_categories_id) + 1;
		}
		
		$categories = zen_get_category_tree($as_categories_id, '', '0', '', true);
		zen_set_time_limit(600);
		if ($categories != 0){
			for ($i=0, $n=sizeof($categories); $i<$n; $i++) {
				if ($as_categories_status == 1) {
					$change_open = false;
					$categories_status = -$categories_num;
					$products_status = -$categories_num;
					$change_status = 1;
				} else {
					$change_open = true;
					$categories_status = 1;
					if ($set_products_status == 'set_products_status_on') {
						$products_status = 1;
					}elseif($set_products_status == 'set_products_status_off'){
						$products_status = 0;
					}else{
						$products_status = 1;
						$change_status = -$categories_num;
					}
				}
				
				//
				if ($change_open){
					if(!get_parent_status($categories[$i]['id'])){
						$cateprod_status_return[]['error'] = $categories[$i]['id'] . TEXT_CATEGORIES_PROD_CHANGE_WARNING;
						continue;
					}
				}
				$sql = "update " . TABLE_CATEGORIES . " set categories_status=" . $categories_status . "
	          where categories_id=" . $categories[$i]['id'] . ((isset($change_status) && $change_status !='')?" and categories_status = " . $change_status:"");
				$sql_return = $db->Execute($sql);
				remove_categores_memcache_by_categories_id($categories[$i]['id']);
				
				//捕获错误
				/*if ($sql_return->RecordCount() < 1) {
					$cateprod_status_return[]['error'] = '';
				}*/
				if ($as_categories_status != 1){
				$sql_query = "select products_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id=" . $categories[$i]['id'];
				$category_products = $db->Execute($sql_query);
	
				while (!$category_products->EOF) {
					//$sql = "update " . TABLE_PRODUCTS . " set products_status=" . $products_status . " where products_id=" . $category_products->fields['products_id'] . ((isset($change_status) && $change_status != '')?" and products_status = " . $change_status:"");
					//$db->Execute($sql);
					
					//捕获错误,并返回
					$category_products->MoveNext();
				}
				}
				if ($as_categories_status == 1){
					$check_change_status_query='select p.products_id,p.products_status from '.TABLE_PRODUCTS_TO_CATEGORIES.' ptc, '.TABLE_PRODUCTS.' p  where categories_id='. $categories[$i]['id'].' and p.products_id=ptc.products_id ';
					$check_change_status=$db->Execute($check_change_status_query);
					if($check_change_status->RecordCount()>0){
						while(!$check_change_status->EOF){
							if($check_change_status->fields['products_status']==1){
								if($change_tips==false){
									$check_pro_status_query='select p.products_id ,c.categories_id from '.TABLE_PRODUCTS.' p, '.TABLE_PRODUCTS_TO_CATEGORIES.' ptc , '.TABLE_CATEGORIES.' c  where p.products_id=ptc.products_id  and c.categories_id=ptc.categories_id  and ptc.products_id='.$check_change_status->fields['products_id'].'  and p.products_status=1 and ptc.categories_id <> '.$categories[$i]['id'].' and c.categories_status=1';
								$check_pro_status=$db->Execute($check_pro_status_query);
								if($check_pro_status->RecordCount()==0){
									$change_tips=true;
								}								
								}								
							}
							
							$check_change_status->MoveNext();
						}
					}
					//echo $check_change_status_query.';<br>';
				}
				
			}
		}
		$return_array[0]=$change_tips;
		$return_array[1]=$cateprod_status_return;
		return $return_array;
	}
	
	function get_parent_status($catesta_id = 0){
		global $db;
		if ($catesta_id != 0){
			$parent_resturn_query = "select categories_status from " . TABLE_CATEGORIES . " a, (select parent_id from " . TABLE_CATEGORIES . " where categories_id = " . $catesta_id . " ) b where a.categories_id = b.parent_id";
			$parent_resturn = $db->Execute($parent_resturn_query);
			if ($parent_resturn->RecordCount() == 1){
				if ($parent_resturn->fields['categories_status'] != 1) return false;
			}
			return true;
		}
	}
?>