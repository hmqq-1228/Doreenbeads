<?php
@ set_time_limit(0);
@ ini_set('memory_limit', '6144M');
require ('includes/application_top.php');
require ("includes/access_ip_limit.php");
// require("solrclient/Apache/Solr/Service.php");
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");
$time = time();
$time_30 = date('Y-m-d H:i:s', ($time - (86400 * 30)));
$time_30_unix_timestamp = strtotime($time_30);

// 拷贝数据库
if (isset ($_GET['copy']) && (int) $_GET['copy'] == 1) {
	$returnvalue = 1;
	//Tianwen.Wan20160331->测试站不用copy
	if(!isset($_GET['skip_copy'])) {
		system('sh /usr/bin/dorabeads_copy.sh', $returnvalue);
	} else {
		$returnvalue = 0;
	}
	
	if ($returnvalue != 0) {
		echo '拷贝数据库发生错误，错误码: ' . $returnvalue . '<br/>';
	} else {
		//$endtime = microtime(true);
		//echo '拷贝数据库完成，用时: '.number_format(($endtime-$startime), 4, ".", "").'<br>';

		//$startime = microtime(true);
		$subject_id = array ();
		$subject_query = $db->Execute("select sap.areas_id, sap.products_id from t_subject_areas_products sap, t_subject_areas sa where sap.areas_id=sa.id and sa.status=1");
		if ($subject_query->RecordCount() > 0) {
			while (!$subject_query->EOF) {
				$subject_id[$subject_query->fields['products_id']][] = intval($subject_query->fields['areas_id']);
				$subject_query->MoveNext();
			}
		}
		file_put_contents("log/products_subjects.txt", json_encode($subject_id));

		//     var_dump(array_key_exists('56817', $products_promotion_areas));
		//     var_dump($products_promotion_areas['56817']);
		/*
		$db->Execute("update ".TABLE_PRODUCTS." set products_subjects=''");
		foreach($subject_id as $key => $value) {
			$db->Execute("update ".TABLE_PRODUCTS." set products_subjects='" . json_encode($value) . "' where products_id='" . $key . "'");
		}
		*/

		$products_ordered_array = array ();
		$products_ordered_sql = 'select products_id, sum(products_quantity) as products_ordered  from ' . TABLE_ORDERS_PRODUCTS . ' where orders_id in(select orders_id from ' . TABLE_ORDERS . ' where date_purchased>"' . $time_30 . '" and orders_status in (' . MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP . ')) GROUP BY products_id';
		$products_ordered_result = $db->Execute($products_ordered_sql);
		while (!$products_ordered_result->EOF) {
			$products_ordered_array[$products_ordered_result->fields['products_id']] = $products_ordered_result->fields['products_ordered'];
			$products_ordered_result->MoveNext();
		}
		file_put_contents("log/products_ordered_array.txt", json_encode($products_ordered_array));

		//if (file_get_contents("http://" . $_SERVER['HTTP_HOST'] . "/solrUpdate.php?merge=1")) {
		/*
		file_get_contents("http://img.doreenbeads.com/solrUpdate.php?lang=1");
		file_get_contents("http://img.doreenbeads.com/solrUpdate.php?lang=4");
		file_get_contents("http://img.doreenbeads.com/solrUpdate.php?lang=2");
		file_get_contents("http://img.doreenbeads.com/solrUpdate.php?lang=3");
		*/

		$featured_products_array = array ();
		$featured_query = $db->Execute("select products_id from t_featured where  status=1 ");
		if ($featured_query->RecordCount() > 0) {
			while (!$featured_query->EOF) {
				$featured_products_array[$featured_query->fields['products_id']] = 1;
				$featured_query->MoveNext();
			}
		}

		$check_binded_array = array ();
		$check_binded = $db->Execute("select products_id from " . TABLE_MY_PRODUCTS . "");
		if ($check_binded->RecordCount() > 0) {
			while (!$check_binded->EOF) {
				$check_binded_array[$check_binded->fields['products_id']] = 1;
				$check_binded->MoveNext();
			}
		}
		
		file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", "----------------------------------------------------------------\r\n" . $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . number_format((microtime(true) - $startime), 4, ".", "") . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
		
		$array_language = array (
			1 => 'en',
			4 => 'fr',
			2 => 'de',
			3 => 'ru'
		);

		foreach ($array_language as $languages_id => $lan) {
			$startime = microtime(true);
			$startdate = date("Y-m-d H:i:s");
			$time = time();
			$time_30 = date('Y-m-d H:i:s', ($time - (86400 * 30)));
			$time_30_unix_timestamp = strtotime($time_30);
		
			/*
			$lang_query = $db->Execute("select code from t_languages where languages_id='" . $languages_id . "' limit 1");
			if ($lang_query->RecordCount() > 0) {
				$lan = $lang_query->fields['code'];
			} else {
				die('Invalid language id');
			}
			*/
		
			$category_all_array = array ();
			$category_all_sql = 'select c.categories_id,cd.categories_name from  ' . TABLE_CATEGORIES . ' c , ' . TABLE_CATEGORIES_DESCRIPTION . ' cd where cd.categories_id=c.categories_id and c.categories_status=1 and cd.language_id= ' . $languages_id;
			$category_all = $db->Execute($category_all_sql);
			while (!$category_all->EOF) {
				$category_all_array[$category_all->fields['categories_id']] = $category_all->fields['categories_name'];
				$category_all->MoveNext();
			}
		
			/*
			$featured_products_array=array();
			$featured_query = $db->Execute("select products_id from t_featured where  status=1 ");
			if($featured_query->RecordCount()>0){
				while(!$featured_query->EOF){
					$featured_products_array[$featured_query->fields['products_id']]=1;
					$featured_query->MoveNext();
				}
			}
			*/
		
			//        $sqlForProducts = "select p.products_id as products_id ,products_quantity_order_min,products_model,products_price,products_image,products_date_added,products_weight,products_name,products_description,products_name_without_catg,products_quantity,products_status from t_products p, t_products_description pd where p.products_id = pd.products_id and p.products_status > 0 LIMIT 0,30";
			$sqlForProducts = "select p.products_qty_box_status,p.products_quantity_order_max,p.products_id as products_id ,products_quantity_order_min,products_ordered,
						        					products_model,products_price,products_price_sorter,products_image,products_date_added,products_weight,products_name,
						        					products_name_without_catg,products_status,products_limit_stock,is_mixed,products_viewed,products_status,p.is_sold_out
						        					from t_products p, t_products_description pd 
						        					where p.products_id = pd.products_id and p.products_status = 1 and pd.language_id=" . $languages_id;
			$productsResult = $db->Execute($sqlForProducts);
			$parts = array ();
			$i = 0;
			$products_subjects = json_decode(file_get_contents("log/products_subjects.txt"), true);
			$products_ordered_array = json_decode(file_get_contents("log/products_ordered_array.txt"), true);
			$extra_score_str = "";
			/*
			$extra_score_str = "产品分值=30天内平均每天下单量分值+库存量分值+添加时间分值+修改时间分值)*是否促销分值(是则*1.1)\r\n";
			$extra_score_str .= "30天内平均每天下单量分值：30天平均每天下单量*200/30(不足30天的算在架天数)，如果该值大于800只算800\r\n";
			$extra_score_str .= "库存量分值：库存量大于100只算100\r\n";
			$extra_score_str .= "添加时间分值：500/商品添加时间到当前日期的天数(天数超过180只算180)\r\n";
			$extra_score_str .= "修改时间分值：100/商品修改时间到当前日期的天数(天数超过180只算180)\r\n";
			$extra_score_str .= "是否促销分值：商品如果是促销状态则总分值*1.1\r\n";
			*/
			$extra_score = 0;
			$extra_score_str .= "Update " . date("Y-m-d H:i:s") . "\r\n";
		
			//促销区处理
			$products_promotion_areas = array ();
// 			if (zen_is_promotion_time()) {
				$promotion_area_query_sql = "SELECT DISTINCT pa.promotion_area_id,pp.pp_products_id
														FROM " . TABLE_PROMOTION_AREA . "  AS pa
														INNER JOIN " . TABLE_PROMOTION . " AS p ON CONCAT(',',pa.related_promotion_ids,',') LIKE  CONCAT('%,',p.promotion_id,',%') AND CONCAT(',',pa.promotion_area_languages,',') LIKE  '%," . $languages_id . ",%'
														INNER JOIN " . TABLE_PROMOTION_PRODUCTS . " AS pp ON p.promotion_id = pp.pp_promotion_id
														WHERE pa.promotion_area_status = 1 and pp.pp_is_forbid = 10 and p.promotion_start_time <= '" . date('Y-m-d H:i:s') . "' and p.promotion_end_time > '" . date('Y-m-d H:i:s') . "'";
		
				$promotion_area_query = $db->Execute($promotion_area_query_sql);
		
				if ($promotion_area_query->RecordCount() > 0) {
					while (!$promotion_area_query->EOF) {
						$products_promotion_area_key = $promotion_area_query->fields['pp_products_id'];
		
						$products_promotion_areas[$products_promotion_area_key][] = $promotion_area_query->fields['promotion_area_id'];
		
						$promotion_area_query->MoveNext();
					}
				}
// 			}
		
			//file_put_contents("log/products_promotion_areas.txt", serialize($products_promotion_areas)); 
		
			//$products_promotion_areas = unserialize(file_get_contents("log/products_promotion_areas.txt"));
		
			while (!$productsResult->EOF) {
				$subject_id = array ();
				$promotion_area_id = array ();
		
				$product_id = $productsResult->fields['products_id'];
		
				/*
				$check_binded = $db->Execute("select customers_id from ".TABLE_MY_PRODUCTS." where products_id='".$productsResult->fields['products_id']."' limit 1");
				if($check_binded->RecordCount()>0){
					$db->Execute("update ".TABLE_PRODUCTS." set products_status=0 where products_id='".$productsResult->fields['products_id']."'");
					$productsResult->fields['products_status']=0;
				}
				*/
				if(isset($check_binded_array[$productsResult->fields['products_id']])) {
					$productsResult->fields['products_status'] = 0;
				}
				if (FACEBOOK_LIKE_PRODUCT_ID == $productsResult->fields['products_id'] || in_array($productsResult->fields['products_id'], array (
						SPINTOWIN_PRODUCT1_ID,
						SPINTOWIN_PRODUCT2_ID,
						SPINTOWIN_PRODUCT3_ID
					))) {
					$productsResult->fields['products_status'] = 0;
				}
				if ($productsResult->fields['products_status'] > 0) {
					$categories_id = $db->Execute("select categories_id,first_categories_id,second_categories_id,three_categories_id,four_categories_id,five_categories_id,six_categories_id from t_products_to_categories where products_id='" . $productsResult->fields['products_id'] . "'");
					$categories = array ();
					$categories_name = array ();
					while (!$categories_id->EOF) {
						$fid = $categories_id->fields['first_categories_id'];
						$sid = $categories_id->fields['second_categories_id'];
						$tid = $categories_id->fields['three_categories_id'];
						$oid = $categories_id->fields['four_categories_id'];
						$iid = $categories_id->fields['five_categories_id'];
						$xid = $categories_id->fields['six_categories_id'];
						$catearray = array (
							$fid,
							$sid,
							$tid,
							$oid,
							$iid,
							$xid
						);
						zen_get_category_id_array($catearray, 0);
						$categories_id->MoveNext();
					}
					//property
					$properties = array ();
					$property_name = array ();
					$product_property_query = $db->Execute("select zp2.property_id, zpd.property_name from t_products_to_property ptp, t_property zp, t_property_group pg, t_property zp2, t_property_description zpd
																								where ptp.product_id='" . $productsResult->fields['products_id'] . "'
																								and ptp.property_group_id=pg.property_group_id
																								and pg.is_basic=1
																								and zp.property_status=1
																								and pg.group_status=1
																								and ptp.property_id=zp.property_id
																								AND zp2.property_id=zp.property_display_id
																								AND zp2.property_id=zpd.property_id
																								AND zpd.languages_id=" . (int) $languages_id . " group by zp2.property_id");
					while (!$product_property_query->EOF) {
						$properties[] = $product_property_query->fields['property_id'];
						$property_name[] = $product_property_query->fields['property_name'];
						$product_property_query->MoveNext();
					}
		
					$is_featured = 0;
					if ($featured_products_array[$productsResult->fields['products_id']] == 1) {
						$is_featured = 1;
					}
		
					$is_new_arrival = 0;
					if (strtotime($productsResult->fields['products_date_added']) > (time() - 2592000)) {
						$is_new_arrival = 1;
					}
		
					$is_promotion = 0;
					$promotion_type = 0;
					$promotion_start_time = 0;
					$promotion_end_time = 0;
// 					if (zen_is_promotion_time()) {
						$promotion_query = $db->Execute("select pp_id, zp.promotion_id from " . TABLE_PROMOTION_PRODUCTS . " zpp, " . TABLE_PROMOTION . " zp where zpp.pp_promotion_id=zp.promotion_id and zp.promotion_status=1 and zpp.pp_products_id='" . $productsResult->fields['products_id'] . "' and zpp.pp_is_forbid = 10   and zp.promotion_start_time <= '" . date('Y-m-d H:i:s') . "' and zp.promotion_end_time > '" . date('Y-m-d H:i:s') . "'");
						if ($promotion_query->RecordCount() > 0) {
							$check_time = $db->Execute("select promotion_start_time,promotion_end_time,promotion_status from " . TABLE_PROMOTION . " where promotion_id='" . $promotion_query->fields['promotion_id'] . "'");
							
							$promotion_start_time = strtotime($check_time->fields['promotion_start_time']);
							$promotion_end_time = strtotime($check_time->fields['promotion_end_time']) == false ? PHP_INT_MAX : strtotime($check_time->fields['promotion_end_time']);
							if ($promotion_start_time < time() && $promotion_end_time > time() && $check_time->fields['promotion_status'] > 0) {
								$is_promotion = 1;
							} else {
								$is_promotion = 0;
								$promotion_start_time = 0;
								$promotion_end_time = 0;
							}
							$promotion_type = $promotion_query->fields['promotion_id'];
						}
		
						//购销区
						if ($is_promotion && array_key_exists($product_id, $products_promotion_areas)) {
							$promotion_area_id = $products_promotion_areas[$product_id];
						}
// 					}
					/*Tianwen.Wan20160125废弃
					//	购买次数 xiaoyong.lv 20150619
					$products_ordered_query = $db->Execute("select transaction_times from t_products_transaction where products_id='".$productsResult->fields['products_id']."' limit 1");
					if($products_ordered_query->RecordCount()==0){
						$ordered_times = 0;
						$transaction_data = array('products_id'=>$productsResult->fields['products_id'], 'transaction_times'=>0);
						zen_db_perform('t_products_transaction', $transaction_data);
					}else{
						$ordered_times = $products_ordered_query->fields['transaction_times'];
					}
					*/
		
					$is_hot_seller = 0;
					//$hot_query = $db->Execute("select products_id from t_products_order_num where products_id='".$productsResult->fields['products_id']."'");
					//if($hot_query->RecordCount()>0){
					//	$is_hot_seller = 1;
					//}
		
					if ($productsResult->fields['is_sold_out'] == 1) {
						$stock_sort = 10;
					}
					elseif ($productsResult->fields['products_quantity'] == 0 && $productsResult->fields['products_limit_stock'] == 0) {
						$stock_sort = 20;
					} else {
						$stock_sort = 30;
					}
					$productsResult->fields['products_quantity'] = zen_get_products_stock( $productsResult->fields['products_id']  );
		
					//	subject_area
					/*
					$subject_id = array();
					$subject_query = $db->Execute("select sap.areas_id from t_subject_areas_products sap, t_subject_areas sa where sap.areas_id=sa.id and sa.status=1 and  sap.products_id='".$productsResult->fields['products_id']."'");
					if($subject_query->RecordCount()>0){
						while (!$subject_query->EOF) {
							$subject_id[] = $subject_query->fields['areas_id'];
							
							$subject_query->MoveNext();
						} 
					}
					*/
					if (!empty ($products_subjects[$productsResult->fields['products_id']])) {
						$subject_id = $products_subjects[$productsResult->fields['products_id']];
					}
		
					//Tianwen.Wan20160125上面的方法改成下面的方式
					$products_ordered = $ordered_times = 0;
					if (isset ($products_ordered_array[$productsResult->fields['products_id']]) && !empty ($products_ordered_array[$productsResult->fields['products_id']])) {
						//如果在架天数小于30
						if ($productsResult->fields['products_date_added'] >= $time_30) {
							$products_ordered = $ordered_times = $products_ordered_array[$productsResult->fields['products_id']] * 200 / (($time -strtotime($productsResult->fields['products_date_added'])) / 86400);
							//console("a:".$productsResult->fields['products_id']."|".$ordered_times . "-" . $products_ordered_array[$productsResult->fields['products_id']] * 1000 . "|" . $productsResult->fields['products_date_added'] . "|" . ($time - strtotime($productsResult->fields['products_date_added'])) / 86400);
						} else {
							$products_ordered = $ordered_times = $products_ordered_array[$productsResult->fields['products_id']] * 200 / 30;
							//console("b:".$productsResult->fields['products_id']."|".$ordered_times . "-" . $products_ordered_array[$productsResult->fields['products_id']] * 1000 . "|" . $productsResult->fields['products_date_added'] . "|" . "30");
						}
						if ($ordered_times > 800) {
							$ordered_times = 800;
						}
					}
		
					$products_quantity_score = $productsResult->fields['products_quantity'];
					if ($products_quantity_score > 100) {
						$products_quantity_score = 100;
					}
		
					$products_date_added_score = 0;
					if (!empty ($productsResult->fields['products_date_added']) && $productsResult->fields['products_date_added'] != "0000-00-00 00:00:00") {
						$products_date_added_days = ($time -strtotime($productsResult->fields['products_date_added'])) / 86400;
						if ($products_date_added_days > 180) {
							$products_date_added_days = 180;
						}
						$products_date_added_score = 500 / $products_date_added_days;
					}
		
					$products_last_modified_score = 0;
					if (!empty ($productsResult->fields['products_last_modified']) && $productsResult->fields['products_last_modified'] != "0000-00-00 00:00:00") {
						$products_last_modified_days = ($time -strtotime($productsResult->fields['products_last_modified'])) / 86400;
						if ($products_last_modified_days > 180) {
							$products_last_modified_days = 180;
						}
						$products_last_modified_score = 100 / $products_last_modified_days;
					}
		
					$is_promotion_score = 1;
					if ($is_promotion == 1) {
						$is_promotion_score = 1.1;
					}
		
					$extra_score = number_format(($ordered_times + $products_quantity_score + $products_date_added_score + $products_last_modified_score) * $is_promotion_score, 4, ".", "");
					$extra_score_str .= "[" . $productsResult->fields['products_id'] . "]=>" . $extra_score . "=(" . number_format($ordered_times, 14, ".", "") . "+" . number_format($products_quantity_score, 14, ".", "") . "+" . number_format($products_date_added_score, 14, ".", "") . "+" . number_format($products_last_modified_score, 14, ".", "") . ")*" . $is_promotion_score . "\r\n";
		
					$parts[$i] = array (
						'id' => 'en-' . $productsResult->fields['products_id'],
						'products_id' => $productsResult->fields['products_id'],
						'products_model' => $productsResult->fields['products_model'],
						'products_image' => $productsResult->fields['products_image'],
						'products_weight' => $productsResult->fields['products_weight'],
						'products_date_added' => $productsResult->fields['products_date_added'],
						'products_name' => $productsResult->fields['products_name'],
						'products_description' => '',
						'products_quantity' => (int) $productsResult->fields['products_quantity'],
						'products_status' => $productsResult->fields['products_status'],
						'products_price' => $productsResult->fields['products_price'],
						'products_price_sorter' => $productsResult->fields['products_price_sorter'],
						'products_name_without_catg' => $productsResult->fields['products_name_without_catg'],
						'categories_id' => $categories,
						'categories_name' => $categories_name,
						'products_quantity_order_min' => $productsResult->fields['products_quantity_order_min'],
						'products_ordered' => (int) $products_ordered,
						'products_viewed' => (int) $productsResult->fields['products_viewed'],
						'products_qty_box_status' => $productsResult->fields['products_qty_box_status'],
						'properties_id' => $properties,
						'properties_name' => $property_name,
						'is_new' => $is_new_arrival,
						'is_featured' => $is_featured,
						'is_promotion' => $is_promotion,
						'promotion_type' => $promotion_type,
						'promotion_area_id' => $promotion_area_id,
						'promotion_start_time' => $promotion_start_time,
						'promotion_end_time' => $promotion_end_time,
						'is_hot_seller' => $is_hot_seller,
						'is_mixed' => $productsResult->fields['is_mixed'],
						'extra_score' => $extra_score,
						'subject_id' => $subject_id,
						'stock_sort' => $stock_sort
					);
					$i++;
				}
				$productsResult->MoveNext();
		
			}
		
			file_put_contents("log/products_score.txt", $extra_score_str);
		
			$getDataTime = microtime(true);
		
			$solr = new Apache_Solr_service(SOLR_HOST, SOLR_PORT, '/solr/dorabeads_' . $lan);
			if (!$solr->ping()) {
				echo 'Solr server not responding';
				exit;
			}
		
			$solr->deleteByQuery("*:*");
			//$solr->commit();
		
			foreach ($parts as $item => $fields) {
				$part = new Apache_Solr_Document();
				foreach ($fields as $key => $value) {
					if (is_array($value)) {
						foreach ($value as $datum) {
							$part->setMultiValue($key, $datum);
						}
					} else {
						$part-> $key = $value;
					}
				}
				$documents[] = $part;
			}
		
			// 创建索引
			try {
				$solr->addDocuments($documents);
				$solr->commit();
				$solr->optimize();
			} catch (Exception $e) {
				echo $e->getCode() . "<br />";
				echo $e->getTraceAsString();
			}
			
			//释放内存
			$extra_score_str = null;
			
			$productsResult = null;
			$categories = null;
			$categories_name = null;
			$products_ordered = null;
			$properties = null;
			$property_name = null;
			$is_new_arrival = null;
			$is_featured = null;
			$is_promotion = null;
			$promotion_type = null;
			$promotion_area_id = null;
			$promotion_start_time = null;
			$promotion_end_time = null;
			$is_hot_seller = null;
			$extra_score = null;
			$subject_id = null;
			
			$parts = null;
			$documents = null;
			/*
			$end = microtime(true);
			$lastime = microtime(true);
			echo '数据组装花费: '.number_format(($getDataTime-$startime), 4, ".", "").'秒<br>';
			echo '数据组装花费: '.number_format(($getDataTime-$startime), 4, ".", "").'秒<br>';
			echo 'solr数据提交花费: '.number_format(($lastime-$getDataTime), 4, ".", "").'秒<br>';
			echo '总花费: '.number_format(($lastime-$startime), 4, ".", "").'秒<br>';
			*/
			file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . number_format((microtime(true) - $startime), 4, ".", "") . "\t" . json_encode($_GET) . "\tlanguages_id:" . $languages_id . "\r\n", FILE_APPEND);
		}
		//}
		echo '生成solr完成，花费: ' . number_format((microtime(true) - $startime), 4, ".", "") . '秒';
	}
	
}

if (isset ($_GET['lang']) && (int) $_GET['lang'] > 0) {

}
if (empty ($_GET['copy'])) {

}

function zen_get_category_id_array($array, $key = 0) {
	global $category_all_array, $categories, $categories_name;
	if ($array[$key] && $category_all_array[$array[$key]]) {
		if (!in_array($array[$key], $categories)) {
			$categories[] = $array[$key];
			$categories_name[] = $category_all_array[$array[$key]];
		}
		return zen_get_category_id_array($array, ($key +1));
	} else {
		return false;
	}
}
?>
