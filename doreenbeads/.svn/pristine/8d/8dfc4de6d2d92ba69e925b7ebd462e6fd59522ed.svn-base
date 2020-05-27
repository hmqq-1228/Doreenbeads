<?php
chdir("../");
@ set_time_limit(0);
@ ini_set("memory_limit', '2048M");
require ("includes/application_top.php");
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");

if(isset ($_GET['action'])) {
	$limit = "";
	if($_GET['action'] == "check_products") {//Tianwen.Wan20160509->检查商品图片请在图片服务器上检测
		//Tianwen.Wan20160509->商品图片错误数据修复sql
		//update t_products set products_image=REPLACE(products_image, 'H.', '.') where products_model in(select identity_code from t_check_images where identity_code like '%H');
		//update t_products set products_image=REPLACE(products_image, 'S.', '.') where products_model in(select identity_code from t_check_images where identity_code like '%S');
		if($_GET['limit'] == "day") {
			$limit = " limit 300";
		}
		$identity_type = 20;
		$result = $db_main_server->Execute("select p.products_id, p.products_model, p.products_image, pic.image_total from " . TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_IMAGE_COUNT . " pic on p.products_id=pic.products_id where p.products_status=1 order by p.products_id desc" . $limit);
		//echo "select p.products_id, p.products_model, p.products_image, pic.image_total from " . TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_IMAGE_COUNT . " pic on p.products_id=pic.products_id where p.products_status=1 order by p.products_id desc" . $limit;exit;
		while (!$result->EOF) {
			//if(substr($result->fields['products_model'], 0, 1) == "T") {
			//	$result->MoveNext();
			//	continue;
			//}
			//$image_src = HTTP_IMG_SERVER . 'bmz_cache/images/' . get_img_size($result->fields['products_image'], 80, 80);
			//if(@fopen($image_src, 'r')) { 
			$image_src = 'bmz_cache/' . get_img_size($result->fields['products_image'], 80, 80);//Tianwen.Wan20160509->这个路径8seasons和doreenbeads不一样
			//拷贝来自main_product_image.php
			$products_image_extension = substr($result->fields['products_image'], strrpos($result->fields['products_image'], '.'));
			$products_image_base = str_replace($products_image_extension, '', $result->fields['products_image']);
			
			$file_exists_image = true;
			if(!empty($result->fields['image_total'])) {
				if($result->fields['image_total'] >= 4) {
					$result->fields['image_total'] = 3;
				}
				$file_exists_count = 0;
				//检查非第一张
				for($image_taotal = 1; $image_taotal < $result->fields['image_total']; $image_taotal++) {
					$image_src_temp = 'bmz_cache/' . get_img_size($products_image_base . '_0' . $image_taotal . $products_image_extension, 80, 80);
					if(file_exists($image_src_temp)) {
						$file_exists_count++;
					}
				}
				if($file_exists_count + 1 < $result->fields['image_total']) {
					$file_exists_image = false;
				}
			} else {
				$image_src_b = 'bmz_cache/' . get_img_size($products_image_base . '_01' . $products_image_extension, 80, 80);
				$image_src_c = 'bmz_cache/' . get_img_size($products_image_base . '_02' . $products_image_extension, 80, 80);
				
				
				if(file_exists($image_src_c) && (!file_exists($image_src_b) || !file_exists($image_src))) {
					$file_exists_image = false;
				}
			}
			if(!file_exists($image_src)) {
				$file_exists_image = false;
			}
			
			
			if($file_exists_image) { 
				$exist = $db_main_server->Execute("select identity_id from " . TABLE_CHECK_IMAGES . " where identity_id=" . $result->fields['products_id'] . " and identity_type=" . $identity_type);
				if($exist->RecordCount() > 0) {
					$db_main_server->Execute("delete from " . TABLE_CHECK_IMAGES . " where identity_id=" . $result->fields['products_id'] . " and identity_type=" . $identity_type);
					$operate_content = '商品已补全图片，编号: ' . $result->fields['products_model'];
	        		//zen_insert_operate_logs(0, $result->fields['products_model'], $operate_content, 2);
	        		//Tianwen.Wan20160509->调用重数据库只能用该方法
	        		$db_main_server->Execute("insert into " . TABLE_OPERATION_LOGS . " (ol_logs_operator, ol_logs_target, ol_logs_content, ol_logs_date, ol_logs_cate) values ('system', '" . $result->fields['products_model'] . "', '" . $operate_content . "', 'now()', 2)");
				}
			}
			else {
				/*
				$sql_data_array = array (
					'identity_id' => $result->fields['products_id'],
					'identity_code' => $result->fields['products_model'],
					'date_created' => 'now()'
				);
				zen_db_perform(TABLE_CHECK_IMAGES, $sql_data_array);
				*/
				$data_url = "";
				$db_main_server->Execute("replace into " . TABLE_CHECK_IMAGES . "(identity_id, identity_type, identity_code, date_created, remark, data_url) values (" . $result->fields['products_id'] . ", " . $identity_type . ", '" . $result->fields['products_model'] . "', now(), '" . $image_src . "', '" . $data_url . "')");
			}
			$result->MoveNext();
		}
		
		//删除已下架或T商品
		$db_main_server->Execute("delete from " . TABLE_CHECK_IMAGES . " where identity_id in(select products_id from " . TABLE_PRODUCTS . " where products_status!=1 or products_model like 'T%')");
	} else if($_GET['action'] == "check_categories") {//Tianwen.Wan20160509->检查类别图片请在主服务器上检测
		if($_GET['limit'] == "day") {
			$limit = " limit 10";
		}
		$identity_type = 10;
		$result = $db->Execute("select categories_id, categories_image from " . TABLE_CATEGORIES . " where categories_status=1 and parent_id!=0 order by categories_id desc" . $limit);
		while (!$result->EOF) {
			//console($cPath_array);
			//$image_src = HTTP_IMG_SERVER . 'bmz_cache/images/' . get_img_size($result->fields['products_image'], 80, 80);
			//if(@fopen($image_src, 'r')) { 
			$image_src = 'images/' . $result->fields['categories_image'];
			if(file_exists($image_src) && !empty($result->fields['categories_image'])) { 
				$exist = $db->Execute("select identity_id from " . TABLE_CHECK_IMAGES . " where identity_id=" . $result->fields['categories_id'] . " and identity_type=" . $identity_type);
				if($exist->RecordCount() > 0) {
					$db->Execute("delete from " . TABLE_CHECK_IMAGES . " where identity_id=" . $result->fields['categories_id'] . " and identity_type=" . $identity_type);
					$operate_content = '类别已补全图片，ID: ' . $result->fields['categories_id'];
	        		zen_insert_operate_logs(0, $result->fields['identity_id'], $operate_content, 3);
				}
			}
			else {
				/*
				$sql_data_array = array (
					'identity_id' => $result->fields['categories_id'],
					'identity_code' => $result->fields['products_model'],
					'date_created' => 'now()'
				);
				zen_db_perform(TABLE_CHECK_IMAGES, $sql_data_array);
				*/				
				$data_url = zen_href_link(FILENAME_DEFAULT, 'cPath=' .  get_products_info_memcache($result->fields['categories_id'] , 'cPath'));
				$db->Execute("replace into " . TABLE_CHECK_IMAGES . "(identity_id, identity_type, identity_code, date_created, remark, data_url) values (" . $result->fields['categories_id'] . ", " . $identity_type . ", '', now(), '" . $image_src . "', '" . $data_url . "')");
			}
			$result->MoveNext();
		}
		
		//删除已关闭类别
		$db->Execute("delete from " . TABLE_CHECK_IMAGES . " where identity_id in(select categories_id from " . TABLE_CATEGORIES . " where categories_status!=1)");
	}
}
echo 'success';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>