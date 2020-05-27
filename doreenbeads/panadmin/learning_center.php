<?php
require('includes/application_top.php');
require_once(DIR_FS_CATALOG . DIR_WS_CLASSES . 'excel/PHPExcel.php');
require(DIR_FS_CATALOG . DIR_WS_FUNCTIONS . 'functions_shipping.php');
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$id = (isset($_GET['id']) ? $_GET['id'] : ($action == 'new' || $action == 'updates' ? 0 : 1));
$parentId = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0;
global $db;
if(zen_not_null($action)){
	switch ($action){
		case 'save':
		case 'insert':
			$error = false;
			//bof t_shipping			
			$sql_data_array= array(array('fieldName'=>'discount', 'value'=>zen_db_prepare_input($_POST['s_discount']), 'type'=>'float'),
                           		   array('fieldName'=>'extra_oil', 'value'=>zen_db_prepare_input($_POST['s_extra_oil']), 'type'=>'float'),
                           		   array('fieldName'=>'extra_amt', 'value'=>zen_db_prepare_input($_POST['s_extra_amt']), 'type'=>'float'),
                           		   array('fieldName'=>'extra_times', 'value'=>zen_db_prepare_input($_POST['s_extra_times']), 'type'=>'float'),
                           		   array('fieldName'=>'cal_remote', 'value'=>$_POST['s_cal_remote'], 'type'=>'integer'),
                           		   array('fieldName'=>'cal_volume', 'value'=>$_POST['s_cal_volume'], 'type'=>'integer'),
                           		   array('fieldName'=>'categories_status', 'value'=>$_POST['s_status'], 'type'=>'integer'));
			if ($action == 'insert'){
				$new_id = zen_db_prepare_input($_POST['s_id']);
				$new_code = zen_db_prepare_input($_POST['s_code']);
				$check_id = $db->Execute('select id from ' . TABLE_SHIPPING . ' where id = ' . $new_id);
				if ($check_id->RecordCount() > 0){
					$messageStack->add_session('id已存在，添加失败!', 'error');
					$error = true;
				}
				$check_code = $db->Execute('select id from ' . TABLE_SHIPPING . ' where code = "' . $new_code . '"');
				if ($check_code->RecordCount() > 0){
					$messageStack->add_session('代码已存在，添加失败!', 'error');
					$error = true;
				}
				if (!$error){
					$id = $new_id;
					$sql_data_array1 = array(array('fieldName'=>'id', 'value'=>$new_id, 'type'=>'integer'),
											 array('fieldName'=>'code', 'value'=>$new_code, 'type'=>'string'),
											 array('fieldName'=>'name', 'value'=>zen_db_prepare_input($_POST['s_name']), 'type'=>'string'));
					$sql_data_array = array_merge($sql_data_array1, $sql_data_array);
					$db->perform(TABLE_SHIPPING, $sql_data_array);
				}				
			}else{
				$where_clause = "id = :id";
				$where_clause = $db->bindVars($where_clause, ':id', $id, 'integer');
				$db->perform(TABLE_SHIPPING, $sql_data_array, 'update', $where_clause);
			}			
			//eof
			if (!$error){
				//bof currency
//				if (isset($_POST['currency']) && $_POST['currency'] > 0){
//					$db->Execute('update ' . TABLE_CONFIGURATION . ' set configuration_value = ' . zen_db_prepare_input($_POST['currency']) . ' where configuration_key = "MODULE_SHIPPING_CHIANPOST_CURRENCY"');
//				}
				//eof
				
				//bof t_shipping_info, title
				$query = $db->Execute('select id from t_shipping_info where id = ' . $id);
				$language = zen_get_languages();
				if ($query->RecordCount() > 0){
					foreach ($language as $key => $val){
						$sql_data_array= array(array('fieldName'=>'title', 'value'=>zen_db_prepare_input($_POST['s_title'][$val['id']]), 'type'=>'string'));
						$where_clause = "id = :id and language_id = " . $val['id'];
						$where_clause = $db->bindVars($where_clause, ':id', $id, 'integer');
						$db->perform(TABLE_SHIPPING_INFO, $sql_data_array, 'update', $where_clause);
					}
				}else{
					foreach ($language as $key => $val){
						$sql_data_array= array(array('fieldName'=>'id', 'value'=>$id, 'type'=>'integer'),
					                           array('fieldName'=>'code', 'value'=>$_POST['s_code'], 'type'=>'string'),
					                           array('fieldName'=>'language_id', 'value'=>$val['id'], 'type'=>'integer'),
					                           array('fieldName'=>'title', 'value'=>zen_db_prepare_input($_POST['s_title'][$val['id']]), 'type'=>'string'));
						$db->perform(TABLE_SHIPPING_INFO, $sql_data_array);
					}					
				}
				//eof
				
				//bof t_shipping_day
				$code_query = $db->Execute('select code from ' . TABLE_SHIPPING . ' where id = ' . $id);
				$code = $code_query->fields['code'];
				$country_id_array = $_POST['country_id'];
				$day_low_array = $_POST['s_day_low'];
				$day_high_array = $_POST['s_day_high'];
				for ($i = 0; $i < sizeof($country_id_array); $i++){
					if ($day_low_array[$i] != '' && $day_high_array[$i] != ''){
						$iso_code = '';
						if($country_id_array[$i] != ''){
							$country_query = $db->Execute('select countries_iso_code_2 from ' . TABLE_COUNTRIES . ' where countries_id = ' . $country_id_array[$i]);
							$iso_code = $country_query->fields['countries_iso_code_2'];
						}
						$day_low = ($day_low_array[$i] < $day_high_array[$i] ? $day_low_array[$i] : $day_high_array[$i]);
						$day_high = ($day_high_array[$i] > $day_low_array[$i] ? $day_high_array[$i] : $day_low_array[$i]);
						$day_query = $db->Execute('select code from ' . TABLE_SHIPPING_DAY . ' where code = "' . $code . '" and country_iso2 = "' . $iso_code . '"');
						$sql_data_array= array(array('fieldName'=>'code', 'value'=>$code, 'type'=>'string'),
								array('fieldName'=>'country_iso2', 'value'=>$iso_code, 'type'=>'string'),
								array('fieldName'=>'day_low', 'value'=>$day_low, 'type'=>'string'),
								array('fieldName'=>'day_high', 'value'=>$day_high, 'type'=>'string'));
						if ($day_query->RecordCount() > 0){
							$db->perform(TABLE_SHIPPING_DAY, $sql_data_array, 'update', 'code="' . $code . '" and country_iso2 = "' . $iso_code . '"');
						}else{
							$db->perform(TABLE_SHIPPING_DAY, $sql_data_array);
						}
					}
				}
				//bof
			}else{
				zen_redirect(zen_href_link('learning_center', zen_get_all_get_params(array('action')) . 'action=new'));
			}
			break;
		case 'delday':
			$del_id = zen_db_prepare_input($_GET['id']);
			$del = false;
			if ($del_id != ''){
				$del_code_result = $db->Execute('select code from ' . TABLE_SHIPPING . ' where id = ' . $del_id);
				$del_code = $del_code_result->fields['code'];
				if ($del_code != ''){
					$del_country = zen_db_prepare_input($_GET['c']);
					if ($del_code != '' && $del_country != ''){
						$db->Execute('delete from ' . TABLE_SHIPPING_DAY . ' where country_iso2 = "' . $del_country . '" and code = "' . $del_code . '"');
						$del = true;						
					}
				}
			}
			if ($del){
				$messageStack->add_session('删除天数成功!', 'success');
			}else{
				$messageStack->add_session('删除天数失败!', 'caution');
			}
			zen_redirect(zen_href_link('learning_center', zen_get_all_get_params(array('action', 'c')) . 'action=edit'));
			break;
		case 'process' :
			require(DIR_WS_MODULES . 'shipping.php');
			break;
		case 'update_status':
			$lcCategoriesId = intval($_GET['lc_categories_id']);
			$status = intval($_GET['status']);
			if(!empty($lcCategoriesId)) {
				$db->Execute('update ' . TABLE_LC_CATEGORIES . ' set categories_status=' . $status . ' where lc_categories_id = ' . $lcCategoriesId . '');
				$db->Execute('update ' . TABLE_LC_CATEGORIES . ' set categories_status=' . $status . ' where categories_path like "%' . $lcCategoriesId . '%"');
				$db->Execute('update ' . TABLE_LC_ARTICLE . ' set article_status=' . $status . ' where categories_path like "%' . $lcCategoriesId . '%"');
			}
	        $messageStack->add_session('修改状态成功!', 'success');
	        zen_redirect(zen_href_link('learning_center', zen_get_all_get_params(array('action', 'status', 'lc_categories_id')), 'NONSSL'));
		break;
		case 'delete_category':
			$lcCategoriesId = intval($_GET['lc_categories_id']);
			if(!empty($lcCategoriesId)) {
				$db->Execute('delete from ' . TABLE_LC_CATEGORIES_DESC . ' where lc_categories_id in (select lc_categories_id from ' . TABLE_LC_CATEGORIES . ' where categories_path like "%:' . $lcCategoriesId . ':%") and language_id=' . $_SESSION['languages_id'] . '');
				$db->Execute('delete from ' . TABLE_LC_CATEGORIES . ' where lc_categories_id = ' . $lcCategoriesId . '');
				$db->Execute('delete from ' . TABLE_LC_CATEGORIES . ' where categories_path like "%:' . $lcCategoriesId . ':%"');
				$db->Execute('delete from ' . TABLE_LC_ARTICLE_STEPS . ' where article_id in (select article_id from ' . TABLE_LC_ARTICLE . ' where categories_path like "%:' . $lcCategoriesId . ':%")');
				$db->Execute('delete from  ' . TABLE_LC_ARTICLE . ' where categories_path like "%:' . $lcCategoriesId . ':%"');
			}
	        $messageStack->add_session('删除类别成功!', 'success');
	        zen_redirect(zen_href_link('learning_center', zen_get_all_get_params(array('action', 'lc_categories_id')), 'NONSSL'));
		break;
		case 'index_submit':
			$languageCode = strtoupper($_SESSION['languages_code']);
			$title = trim($_POST['title']);
			$desc = addslashes(trim($_POST['desc']));
			$imgOld = trim($_POST['img_old']);
			if(!empty($title)) {
				$db->Execute('update ' . TABLE_CONFIGURATION . ' set configuration_value="' . $title . '" where configuration_key = "LC_INDEX_TITLE_' . $languageCode . '"');
			}
			if(!empty($desc)) {
				$db->Execute('update ' . TABLE_CONFIGURATION . ' set configuration_value="' . $desc . '" where configuration_key = "LC_INDEX_DESC_' . $languageCode . '"');
			}
			
			if($_FILES['img']['size'] >= 2048 * 1024) {
				$messageStack->add_session('大图不能超过2M!', 'caution');
				zen_redirect(zen_href_link('learning_center'));
				zen_redirect(zen_href_link('learning_center'));
			}
			if (!empty($_FILES['img']['size']) && $categories_image = new upload('img')) {
	          $categories_image->set_destination(DIR_FS_CATALOG_IMAGES . 'learning_center');
	          if ($categories_image->parse() && $categories_image->save()) {
	            $categories_image_name = 'learning_center/' . $categories_image->filename;
	          }
	          if ($categories_image->filename != 'none' && $categories_image->filename != '') {
	            $db->Execute('update ' . TABLE_CONFIGURATION . ' set configuration_value="' . $categories_image_name . '" where configuration_key = "LC_INDEX_IMG_' . $languageCode . '"');
	            if(!empty($imgOld)) {
	            	@unlink(DIR_FS_CATALOG_IMAGES . $imgOld);
	            }
	          } else {
	            //echo '上传失败';exit;
	          }
	        }
	        $messageStack->add_session('修改成功!', 'success');
	        zen_redirect(zen_href_link('learning_center'));
		break;
		case 'new_category_submit':
			$languageCode = strtoupper($_SESSION['languages_code']);
			$lcCategoriesId = trim($_POST['lc_categories_id']);
			$lcCategoriesName = trim($_POST['lc_categories_name']);
			$lcCategoriesDescription = trim($_POST['lc_categories_description']);
			$isSpecial = intval($_POST['is_special']);
			$jqDeleteIndex = trim($_POST['jq_delete_index']);
			$jqDeleteValue = trim($_POST['jq_delete_value']);
			$lcCategoriesImagesStr = "";
			$time = date("Y-m-d H:i:s", time());

			//$imgOld = trim($_POST['img_old']);
			if(!empty($lcCategoriesName)) {
				if(!empty($jqDeleteIndex)) {
					$deleteIndexArray = explode("|", $jqDeleteIndex);
					$deleteValueArray = explode("|", $jqDeleteValue);
				}
				//$db->Execute('update ' . TABLE_CONFIGURATION . ' set configuration_value="' . $title . '" where configuration_key = "LC_INDEX_TITLE_' . $languageCode . '"');
				for($i = 1; $i <= 5; $i++) {
					if($_FILES['lc_categories_images' . $i]['size'] >= 2048 * 1024) {
						$messageStack->add_session('图片不能超过2M!', 'caution');
						if(!empty($lcCategoriesId)) {
							zen_redirect(zen_href_link('learning_center', zen_get_all_get_params(array('action')) . 'action=new_category' . '&parent_id=' . $parentId . '&lc_categories_id=' . $lcCategoriesId, 'NONSSL'));
						} else {
							zen_redirect(zen_href_link('learning_center', zen_get_all_get_params(array('action')) . 'action=new_category' . '&parent_id=' . $parentId, 'NONSSL'));
						}
					}
					if (!empty($_FILES['lc_categories_images' . $i]['size']) && $categories_image = new upload('lc_categories_images' . $i)) {
			          $categories_image->set_destination(DIR_FS_CATALOG_IMAGES . 'learning_center');
			          if ($categories_image->parse() && $categories_image->save()) {
			            //$categories_image_name = $categories_image->filename;
			            $lcCategoriesImagesStr .= 'learning_center/' . $categories_image->filename . ",";
			          }
			          if ($categories_image->filename != 'none' && $categories_image->filename != '') {
			            //$db->Execute('update ' . TABLE_CONFIGURATION . ' set configuration_value="' . $categories_image->filename . '" where configuration_key = "LC_INDEX_IMG_' . $languageCode . '"');
			            if(!empty($_POST['lc_categories_images_old' . $i])) {
			            	@unlink(DIR_FS_CATALOG_IMAGES . $_POST['lc_categories_images_old' . $i]);
			            }
			          } else {
			            //echo '上传失败';exit;
			          }
			        } else {
			        	if(!in_array($i, $deleteIndexArray)) {
			        		if(!empty($_POST['lc_categories_images_old' . $i])) {
				        		$lcCategoriesImagesStr .= $_POST['lc_categories_images_old' . $i] . ",";
				        		//echo $_POST['lc_categories_images_old' . $i] . ",";
				        	}
			        	}
			        }
				}
				foreach($deleteValueArray as $image) {
					if(!empty($image)) {
						@unlink(DIR_FS_CATALOG_IMAGES . $image);
					}
				}
				$lcCategoriesImagesStr = substr($lcCategoriesImagesStr, 0, strlen($lcCategoriesImagesStr) - 1);
				
				//$db->Execute('update ' . TABLE_LC_CATEGORIES . ' set lc_categories_images="' . $title . '" where configuration_key = "LC_INDEX_TITLE_' . $languageCode . '"');
				//echo $lcCategoriesName . "-" . $lcCategoriesDescription . "-" . $lcCategoriesImagesStr;exit;
				$categoriesPath = "";
				if(!empty($parentId)) {
					$categoriesPathQuery = $db->Execute("select lc_categories_id, categories_path from " . TABLE_LC_CATEGORIES . " where lc_categories_id=" . $parentId . "");
	        		if ($categoriesPathQuery->RecordCount() > 0) {
	        			$categoriesPath = ":" . !empty($categoriesPathQuery->fields['categories_path']) ? ($categoriesPathQuery->fields['categories_path']) : ($categoriesPathQuery->fields['lc_categories_id']);
	        		}
				}
				
				$sql_data_array= array(array('fieldName'=>'lc_categories_images', 'value'=>$lcCategoriesImagesStr, 'type'=>'string'),
						//array('fieldName'=>'parent_id', 'value'=>$parentId, 'type'=>'integer'),
						//array('fieldName'=>'categories_path', 'value'=>$categoriesPath, 'type'=>'string'),
						array('fieldName'=>'sort_order', 'value'=>0, 'type'=>'integer'),
						array('fieldName'=>'admin_id', 'value'=>$_SESSION['admin_id'], 'type'=>'integer'),
						array('fieldName'=>'admin_email', 'value'=>$_SESSION['admin_email'], 'type'=>'string'),
						//array('fieldName'=>'date_added', 'value'=>$time, 'type'=>'date'),
						array('fieldName'=>'last_modified', 'value'=>$time, 'type'=>'date'),
						array('fieldName'=>'categories_status', 'value'=>1, 'type'=>'integer'),
						array('fieldName'=>'display_pic', 'value'=>0, 'type'=>'integer'),
						array('fieldName'=>'chinese_info', 'value'=>$lcCategoriesName, 'type'=>'string'),
						array('fieldName'=>'is_special', 'value'=>$isSpecial, 'type'=>'string'));
				if (!empty($lcCategoriesId)){
					$db->perform(TABLE_LC_CATEGORIES, $sql_data_array, 'update', 'lc_categories_id=' . $lcCategoriesId);
					$sql_data_array= array(array('fieldName'=>'lc_categories_name', 'value'=>$lcCategoriesName, 'type'=>'string'),
						array('fieldName'=>'lc_categories_description', 'value'=>$lcCategoriesDescription, 'type'=>'string'));
					$db->perform(TABLE_LC_CATEGORIES_DESC, $sql_data_array, 'update', 'lc_categories_id=' . $lcCategoriesId);
					
					$messageStack->add_session('修改成功!', 'success');
					zen_redirect(zen_href_link('learning_center', 'parent_id=' . $parentId));
				}else{
					$insert_sql_data = array(array('fieldName'=>'parent_id', 'value'=>$parentId, 'type'=>'integer'),
						array('fieldName'=>'categories_path', 'value'=>$categoriesPath, 'type'=>'string'),
						array('fieldName'=>'date_added', 'value'=>$time, 'type'=>'date'),
					);
					$sql_data_array = array_merge($sql_data_array, $insert_sql_data);
					$db->perform(TABLE_LC_CATEGORIES, $sql_data_array);
					$autoId = zen_db_insert_id();
					$sign = "";
					if(empty($parentId)) {
						$sign = ":";
					}
					$db->Execute("update " . TABLE_LC_CATEGORIES . " set categories_path=concat(categories_path, '" . $sign . $autoId . ":') where lc_categories_id=" . $autoId . "");
					$sql_data_array= array(array('fieldName'=>'lc_categories_id', 'value'=>$autoId, 'type'=>'integer'),
						array('fieldName'=>'language_id', 'value'=>$_SESSION['languages_id'], 'type'=>'integer'),
						array('fieldName'=>'lc_categories_name', 'value'=>$lcCategoriesName, 'type'=>'string'),
						array('fieldName'=>'lc_categories_description', 'value'=>$lcCategoriesDescription, 'type'=>'string'));
					$db->perform(TABLE_LC_CATEGORIES_DESC, $sql_data_array);
					$messageStack->add_session('增加成功!', 'success');
					zen_redirect(zen_href_link('learning_center', zen_get_all_get_params(array('action')) . 'parent_id=' . $parentId, 'NONSSL'));
				}
				
			} else {
				$messageStack->add_session('请填写名称!', 'caution');
				zen_redirect(zen_href_link('learning_center', zen_get_all_get_params(array('action')) . 'action=new_category' . '&parent_id=' . $parentId, 'NONSSL'));
			}
			zen_redirect(zen_href_link('learning_center'));
		break;
		case 'new_article_preview':
			$languagesId = $_SESSION['languages_id'];
			$articleId = trim($_POST['article_id']);
			$stepCount = intval($_POST['step_count']);
			$articleTitle = trim($_POST['article_title']);
			$titleAbbreviation = trim($_POST['title_abbreviation']);
			$articleSummary = addslashes(trim($_POST['article_summary']));
			$videoPosition = trim($_POST['video_position']);
			$videoCode = addslashes(trim($_POST['video_code']));
			$materialList = addslashes(trim($_POST['material_list']));
			$partsNum = str_replace("，", ",", trim($_POST['parts_num']));
			$toolsNum = str_replace("，", ",", trim($_POST['tools_num']));
		break;
		case 'new_article_submit':
			$languagesId = $_SESSION['languages_id'];
			$articleId = trim($_POST['article_id']);
			$stepCount = intval($_POST['step_count']);
			$articleTitle = trim($_POST['article_title']);
			$titleAbbreviation = trim($_POST['title_abbreviation']);
			$articleSummary = addslashes(trim($_POST['article_summary']));
			$videoPosition = trim($_POST['video_position']);
			$videoCode = addslashes(trim($_POST['video_code']));
			$materialList = addslashes(trim($_POST['material_list']));
			$partsNum = str_replace("，", ",", trim($_POST['parts_num']));
			$toolsNum = str_replace("，", ",", trim($_POST['tools_num']));
			$isWatermark = trim($_POST['is_watermark']);
			$jqDeleteIndex = trim($_POST['jq_delete_index']);
			$jqDeleteValue = trim($_POST['jq_delete_value']);
			$time = date("Y-m-d H:i:s", time());
			if(!empty($articleTitle) && !empty($titleAbbreviation)) {
				if(!empty($jqDeleteIndex)) {
					$deleteIndexArray = explode("|", $jqDeleteIndex);
					$deleteValueArray = explode("|", $jqDeleteValue);
				}
				if($_FILES['article_images']['size'] >= 2048 * 1024) {
					$messageStack->add_session('主图不能超过2M!', 'caution');
					if(!empty($articleId)) {
						zen_redirect(zen_href_link('learning_center', zen_get_all_get_params(array('action')) . 'action=new_article' . '&parent_id=' . $parentId . '&article_id=' . $articleId, 'NONSSL'));
					} else {
						zen_redirect(zen_href_link('learning_center', zen_get_all_get_params(array('action')) . 'action=new_article' . '&parent_id=' . $parentId, 'NONSSL'));
					}
				}
				if (!empty($_FILES['article_images']['size']) && $articleImagesUpload = new upload('article_images')) {
			          $articleImagesUpload->set_destination(DIR_FS_CATALOG_IMAGES . 'learning_center');
			          if ($articleImagesUpload->parse() && $articleImagesUpload->save()) {
			            $articleImages = 'learning_center/' . $articleImagesUpload->filename;
			            if(!empty($isWatermark)) {
			            	imageWaterMark(DIR_FS_CATALOG_IMAGES . $articleImages, 5, DIR_FS_CATALOG_IMAGES . "watermark.png", HTTP_SERVER,5,"#FF0000"); 
			            }
			          }
			          if ($articleImagesUpload->filename != 'none' && $articleImagesUpload->filename != '') {
			            if(!empty($_POST['video_image_old'])) {
			            	@unlink(DIR_FS_CATALOG_IMAGES . $_POST['article_images_old']);
			            }
			          } else {
			            //echo '上传失败';exit;
			          }
				} elseif(!empty($_POST['article_images_old'])) {
					$articleImages = $_POST['article_images_old'];
				}
				
				if($_FILES['video_image']['size'] >= 2048 * 1024) {
					$messageStack->add_session('视频图不能超过2M!', 'caution');
					if(!empty($articleId)) {
						zen_redirect(zen_href_link('learning_center', zen_get_all_get_params(array('action')) . 'action=new_article' . '&parent_id=' . $parentId . '&article_id=' . $articleId, 'NONSSL'));
					} else {
						zen_redirect(zen_href_link('learning_center', zen_get_all_get_params(array('action')) . 'action=new_article' . '&parent_id=' . $parentId, 'NONSSL'));
					}
				}
				if (!empty($_FILES['video_image']['size']) && $videoImageUpload = new upload('video_image')) {
			          $videoImageUpload->set_destination(DIR_FS_CATALOG_IMAGES . 'learning_center');
			          if ($videoImageUpload->parse() && $videoImageUpload->save()) {
			            //$articleImage_name = $articleImage->filename;
			            $videoImage = 'learning_center/' . $videoImageUpload->filename;
			            if(!empty($isWatermark)) {
			            	imageWaterMark(DIR_FS_CATALOG_IMAGES . $videoImage, 5, DIR_FS_CATALOG_IMAGES . "watermark.png", HTTP_SERVER,5,"#FF0000"); 
			            }
			          }
			          if ($videoImageUpload->filename != 'none' && $videoImageUpload->filename != '') {
			            if(!empty($_POST['video_image_old'])) {
			            	@unlink(DIR_FS_CATALOG_IMAGES . $_POST['video_image_old']);
			            }
			          } else {
			            //echo '上传失败';exit;
			          }
				} elseif(!empty($_POST['video_image_old'])) {
					$videoImage = $_POST['video_image_old'];
				}

				$sql_data_array= array(array('fieldName'=>'lc_categories_id', 'value'=>$parentId, 'type'=>'integer'),
					//array('fieldName'=>'parent_id', 'value'=>$parentId, 'type'=>'integer'),
					//array('fieldName'=>'categories_path', 'value'=>$categoriesPath, 'type'=>'string'),
					array('fieldName'=>'article_title', 'value'=>$articleTitle, 'type'=>'string'),
					array('fieldName'=>'title_abbreviation', 'value'=>$titleAbbreviation, 'type'=>'string'),
					array('fieldName'=>'article_summary', 'value'=>$articleSummary, 'type'=>'string'),
					array('fieldName'=>'admin_id', 'value'=>$_SESSION['admin_id'], 'type'=>'integer'),
					array('fieldName'=>'admin_email', 'value'=>$_SESSION['admin_email'], 'type'=>'string'),
					array('fieldName'=>'article_status', 'value'=>1, 'type'=>'integer'),
					array('fieldName'=>'article_images', 'value'=>$articleImages, 'type'=>'string'),
					array('fieldName'=>'video_position', 'value'=>$videoPosition, 'type'=>'integer'),
					array('fieldName'=>'video_code', 'value'=>$videoCode, 'type'=>'string'),
					array('fieldName'=>'video_image', 'value'=>$videoImage, 'type'=>'string'),
					array('fieldName'=>'parts_num', 'value'=>$partsNum, 'type'=>'string'),
					array('fieldName'=>'tools_num', 'value'=>$toolsNum, 'type'=>'string'),
					array('fieldName'=>'language_id', 'value'=>$languagesId, 'type'=>'integer'),
					array('fieldName'=>'material_list', 'value'=>$materialList, 'type'=>'string'),
					array('fieldName'=>'is_watermark', 'value'=>$isWatermark, 'type'=>'integer'));
					if(!empty($articleId)) {
						$db->perform(TABLE_LC_ARTICLE, $sql_data_array, 'update', 'article_id=' . $articleId);
						
						$db->Execute("delete from " . TABLE_LC_ARTICLE_STEPS . " where article_id=" . $articleId . "");
						for($i = 1; $i <= $stepCount; $i++) {
							$articleStepsImages = "";
							$articleStepsUrl = trim($_POST['article_steps_url' . $i]);
							$articleStepsSummary = addslashes(trim($_POST['article_steps_summary' . $i]));
							
							if($_FILES['article_steps_images' . $i]['size'] >= 2048 * 1024) {
								$messageStack->add_session('步骤图不能超过2M!', 'caution');
								if(!empty($articleId)) {
									zen_redirect(zen_href_link('learning_center', zen_get_all_get_params(array('action')) . 'action=new_article' . '&parent_id=' . $parentId . '&article_id=' . $articleId, 'NONSSL'));
								} else {
									zen_redirect(zen_href_link('learning_center', zen_get_all_get_params(array('action')) . 'action=new_article' . '&parent_id=' . $parentId, 'NONSSL'));
								}
							}
							if (!empty($_FILES['article_steps_images' . $i]['size']) && $articleImage = new upload('article_steps_images' . $i)) {
						          $articleImage->set_destination(DIR_FS_CATALOG_IMAGES . 'learning_center');
						          if ($articleImage->parse() && $articleImage->save()) {
						            //$articleImage_name = $articleImage->filename;
						            $articleStepsImages = 'learning_center/' . $articleImage->filename;
						            if(!empty($isWatermark)) {
						            	imageWaterMark(DIR_FS_CATALOG_IMAGES . $articleStepsImages, 5, DIR_FS_CATALOG_IMAGES . "watermark.png", HTTP_SERVER,5,"#FF0000"); 
						            }
						          }
						          if ($articleImage->filename != 'none' && $articleImage->filename != '') {
						            if(!empty($_POST['article_steps_images_old' . $i])) {
						            	@unlink(DIR_FS_CATALOG_IMAGES . $_POST['article_steps_images_old' . $i]);
						            }
						          } else {
						            //echo '上传失败';exit;
						          }
							} elseif(!empty($_POST['article_steps_images_old' . $i]) && !in_array($i, $deleteIndexArray)) {
								$articleStepsImages = $_POST['article_steps_images_old' . $i];
							}
							if((!empty($articleStepsImages) || !empty($articleStepsSummary)) && !in_array($i, $deleteIndexArray)) {
								$sql_data_array= array(array('fieldName'=>'article_id', 'value'=>$articleId, 'type'=>'integer'),
									array('fieldName'=>'sort_order', 'value'=>0, 'type'=>'integer'),
									array('fieldName'=>'article_steps_images', 'value'=>$articleStepsImages, 'type'=>'string'),
									array('fieldName'=>'article_steps_url', 'value'=>$articleStepsUrl, 'type'=>'string'),
									array('fieldName'=>'article_steps_summary', 'value'=>$articleStepsSummary, 'type'=>'string'));
									
								$db->perform(TABLE_LC_ARTICLE_STEPS, $sql_data_array);
							}
						}
						foreach($deleteValueArray as $image) {
							if(!empty($image)) {
								@unlink(DIR_FS_CATALOG_IMAGES . $image);
							}
						}
						//$sql_data_array= array(array('fieldName'=>'lc_categories_name', 'value'=>$lcCategoriesName, 'type'=>'string'),
						//	array('fieldName'=>'lc_categories_description', 'value'=>$lcCategoriesDescription, 'type'=>'string'));
						//$db->perform(TABLE_LC_CATEGORIES_DESC, $sql_data_array, 'update', 'lc_categories_id=' . $lcCategoriesId);
						$messageStack->add_session('修改文章成功!', 'success');
						zen_redirect(zen_href_link('learning_center', zen_get_all_get_params(array('action', 'page')) . '&parent_id=' . $parentId . '&page=' . $page, 'NONSSL'));
					} else {
						$categoryInfo = $db->Execute("select categories_path from " . TABLE_LC_CATEGORIES . " where lc_categories_id=" . $parentId . "");
						$categoriesPath = "";
						if(!empty($categoryInfo->fields['categories_path'])) {
							$categoriesPath = $categoryInfo->fields['categories_path'];
						}
						$insert_sql_data = array(array('fieldName'=>'categories_path', 'value'=>$categoriesPath, 'type'=>'string'),
							array('fieldName'=>'date_added', 'value'=>$time, 'type'=>'date'),
						);
						$sql_data_array = array_merge($sql_data_array, $insert_sql_data);

						$db->perform(TABLE_LC_ARTICLE, $sql_data_array);
						$autoId = zen_db_insert_id();
						
						for($i = 1; $i <= $stepCount; $i++) {
							$articleStepsImages = "";
							$articleStepsUrl = trim($_POST['article_steps_url' . $i]);
							$articleStepsSummary = trim($_POST['article_steps_summary' . $i]);
							
							if($_FILES['article_steps_images' . $i]['size'] >= 2048 * 1024) {
								$messageStack->add_session('步骤图不能超过2M!', 'caution');
								if(!empty($articleId)) {
									zen_redirect(zen_href_link('learning_center', zen_get_all_get_params(array('action')) . 'action=new_article' . '&parent_id=' . $parentId . '&article_id=' . $articleId, 'NONSSL'));
								} else {
									zen_redirect(zen_href_link('learning_center', zen_get_all_get_params(array('action')) . 'action=new_article' . '&parent_id=' . $parentId, 'NONSSL'));
								}
							}
							if (!empty($_FILES['article_steps_images' . $i]['size']) && $articleImage = new upload('article_steps_images' . $i)) {
						          $articleImage->set_destination(DIR_FS_CATALOG_IMAGES . 'learning_center');
						          if ($articleImage->parse() && $articleImage->save()) {
						            //$articleImage_name = $articleImage->filename;
						            $articleStepsImages = 'learning_center/' . $articleImage->filename;
						            if(!empty($isWatermark)) {
						            	imageWaterMark(DIR_FS_CATALOG_IMAGES . $articleStepsImages, 5, DIR_FS_CATALOG_IMAGES . "watermark.png", HTTP_SERVER,5,"#FF0000"); 
						            }
						          }
						          if ($articleImage->filename != 'none' && $articleImage->filename != '') {
						            if(!empty($_POST['lc_categories_images_old' . $i])) {
						            	@unlink(DIR_FS_CATALOG_IMAGES . $_POST['article_steps_images_old' . $i]);
						            }
						          } else {
						            //echo '上传失败';exit;
						          }
							} elseif(!empty($_POST['article_steps_images' . $i])) {
								$articleStepsImages = $_POST['article_steps_images' . $i];
							}
							
							if(!empty($articleStepsImages)) {
								$sql_data_array= array(array('fieldName'=>'article_id', 'value'=>$autoId, 'type'=>'integer'),
									array('fieldName'=>'sort_order', 'value'=>0, 'type'=>'integer'),
									array('fieldName'=>'article_steps_images', 'value'=>$articleStepsImages, 'type'=>'string'),
									array('fieldName'=>'article_steps_url', 'value'=>$articleStepsUrl, 'type'=>'string'),
									array('fieldName'=>'article_steps_summary', 'value'=>$articleStepsSummary, 'type'=>'string'));
									
								$db->perform(TABLE_LC_ARTICLE_STEPS, $sql_data_array);
							}
						}
						$messageStack->add_session('添加文章成功!', 'success');
						zen_redirect(zen_href_link('learning_center', zen_get_all_get_params(array('action')) . '&parent_id=' . $parentId, 'NONSSL'));
					}
			} else {
				$messageStack->add_session('请填写文章标题和标题缩写!', 'caution');
				if(!empty($articleId)) {
					zen_redirect(zen_href_link('learning_center', zen_get_all_get_params(array('action')) . 'action=new_article' . '&parent_id=' . $parentId . '&article_id=' . $articleId, 'NONSSL'));
				} else {
					zen_redirect(zen_href_link('learning_center', zen_get_all_get_params(array('action')) . 'action=new_article' . '&parent_id=' . $parentId, 'NONSSL'));
				}
				
			}
		break;
		case 'update_status_article':
			$articleId = intval($_GET['article_id']);
			$status = intval($_GET['status']);
			if(!empty($articleId)) {
				$db->Execute('update ' . TABLE_LC_ARTICLE . ' set article_status=' . $status . ' where article_id = ' . $articleId . '');
			}
	        $messageStack->add_session('修改状态成功!', 'success');
	        zen_redirect(zen_href_link('learning_center', zen_get_all_get_params(array('action', 'status', 'article_id')), 'NONSSL'));
		break;
		case 'delete_article':
			$articleId = intval($_GET['article_id']);
			if(!empty($articleId)) {
				$db->Execute('delete from ' . TABLE_LC_ARTICLE . ' where article_id = ' . $articleId . '');
				$db->Execute('delete from ' . TABLE_LC_ARTICLE_STEPS . ' where article_id = ' . $articleId . '');
			}
	        $messageStack->add_session('删除文章成功!', 'success');
	        zen_redirect(zen_href_link('learning_center', zen_get_all_get_params(array('action', 'article_id')) . '&parent_id=' . $parentId . '&page=' . $page, 'NONSSL'));
		break;
	}
}

if(empty($action) || $action == 'new_category' || $action == 'new_article') {
	$breads = "";
	if(!empty($parentId)) {
		$categoryCurrent = $db->Execute('select categories_path from ' . TABLE_LC_CATEGORIES . ' where lc_categories_id=' . $parentId);
		
		$categoryArr = explode(":", $categoryCurrent->fields['categories_path']);
		if(count($categoryArr) > 0) {
			foreach($categoryArr as $categoryValue) {
				if(!empty($categoryValue)) {
					$categoryPath = $db->Execute('select lccd.lc_categories_name from ' . TABLE_LC_CATEGORIES . ' lcc inner join ' . TABLE_LC_CATEGORIES_DESC . ' lccd on lcc.lc_categories_id=lccd.lc_categories_id where lcc.lc_categories_id=' . $categoryValue . ' and lccd.language_id=' . $_SESSION['languages_id']);
					if($categoryPath->RecordCount() > 0) {
						//$breads .= " > <a href='" .  zen_href_link('learning_center', zen_get_all_get_params(array('parent_id')) . 'parent_id=' . $categoryValue, 'NONSSL') . "'>" . $categoryPath->fields['chinese_info'] . "</a>";
						$breads .= " > " . $categoryPath->fields['lc_categories_name'];
					}
				}
			}
		}
	} 
	if($action == 'new_category') {
		$lcCategoriesId = intval($_GET['lc_categories_id']);		
		if(!empty($lcCategoriesId)) {
			$categoryCurrent = $db->Execute('select lccd.lc_categories_name from ' . TABLE_LC_CATEGORIES . ' lcc inner join ' . TABLE_LC_CATEGORIES_DESC . ' lccd on lcc.lc_categories_id=lccd.lc_categories_id where lcc.lc_categories_id=' . $lcCategoriesId . ' and lccd.language_id=' . $_SESSION['languages_id']);
			$breads .= " > " . $categoryCurrent->fields['lc_categories_name'];
			
		} else {
			$breads .= " > 新建";
		}
	}
	if($action == 'new_article') {		
		$articleId = intval($_GET['article_id']);
		if(!empty($articleId)) {
			$categoryCurrent = $db->Execute('select article_title from ' . TABLE_LC_ARTICLE . ' where article_id=' . $articleId . ' and language_id=' . $_SESSION['languages_id']);
			$breads .= " > " . $categoryCurrent->fields['article_title'];
			
		} else {
			$breads .= " > 新建";
		}
	}
}

if(empty($action)) {
	$order_by = (isset($_POST['orderbyselect']) && $_POST['orderbyselect'] != '' ? $_POST['orderbyselect'] : (isset($_GET['orderby']) ? $_GET['orderby'] : 'id'));
	
	$type = intval($_GET['type']);
	$search = trim($_GET['search']);
	
	$isCategory = 0;
	$searchLike = "";
	$parentIdStr = " and 1=2";
	$previousId = 0;
	if($type == "1" && !empty($search)) {
		$parentIdStr = "";
		$isCategory = 2;
		$searchLike = " and article_title like '%" . $search . "%'";
	} else if($type == "2" && !empty($search)) {
		$parentIdStr = "";
		$isCategory = 1;
		$searchLike = " and lcdc.lc_categories_name like '%" . $search . "%'";
	} else {
		$categoryInfo = $db->Execute('select categories_path from ' . TABLE_LC_CATEGORIES . ' where parent_id=' . $parentId);
		if($categoryInfo->RecordCount() <= 0) {
			$articleInfo = $db->Execute('select categories_path from ' . TABLE_LC_ARTICLE . ' where lc_categories_id=' . $parentId);
			if($articleInfo->RecordCount() > 0) {
				$isCategory = 2;
				$parentIdStr = " and lc_categories_id=" . $parentId . "";
			}
		} else {
			$isCategory = 1;
			$parentIdStr = " and parent_id=" . $parentId . "";
		}
	}
	
	// $order_by = (isset($_GET['orderby']) ? $_GET['orderby'] : (isset($_POST['orderbyselect']) && $_POST['orderbyselect'] != '' ? $_POST['orderbyselect'] : 'id'));
	//$order = str_replace('-', ' ', $order_by);
	
	$categoryPreviousInfo = $db->Execute("select parent_id from " . TABLE_LC_CATEGORIES . " where lc_categories_id=" . $parentId);
	if(!empty($categoryPreviousInfo->fields['parent_id'])) {
		$previousId = $categoryPreviousInfo->fields['parent_id'];
	}
	
	if($isCategory == 1) {
		$shipping_sql = 'select lcc.*, lcdc.lc_categories_name from ' . TABLE_LC_CATEGORIES . ' lcc inner join ' . TABLE_LC_CATEGORIES_DESC . ' lcdc on lcc.lc_categories_id=lcdc.lc_categories_id where language_id=' . $_SESSION['languages_id'] . $parentIdStr . $searchLike . ' order by lc_categories_id desc';
		$shipping_result = $db->Execute($shipping_sql);
		if ($shipping_result->RecordCount() > 0) {
			$i = 1;
			while ( ! $shipping_result->EOF ) {
				if ( isset($_GET['id']) && $_GET['id'] == $shipping_result->fields['lc_categories_id']){
					$_GET['page'] = ceil($i / 20);
					$shipping_result->EOF = true;
				}
				$i++;
				$shipping_result->MoveNext();
			}
		}
		$shipping_split = new splitPageResults($_GET['page'], 20, $shipping_sql, $shipping_query_numrows);
		$shipping = $db->Execute($shipping_sql);
		if ($shipping->RecordCount() > 0) {
			while ( ! $shipping->EOF ) {
				$shipping_method[] = array (
							'id' => $shipping->fields['lc_categories_id'],
							'chinese_info' => $shipping->fields['lc_categories_name'],
							'admin_email' => $shipping->fields['admin_email'],
							'categories_status' => $shipping->fields['categories_status'],
							'date_added' => $shipping->fields['date_added']
				);
				$shipping->MoveNext();
			}
		}
	} else {
		$shipping_sql = 'select * from ' . TABLE_LC_ARTICLE . ' where language_id=' . $_SESSION['languages_id'] . $parentIdStr . $searchLike . ' order by article_id desc';
		$shipping_result = $db->Execute($shipping_sql);
		if ($shipping_result->RecordCount() > 0) {
			$i = 1;
			while ( ! $shipping_result->EOF ) {
				if ( isset($_GET['id']) && $_GET['id'] == $shipping_result->fields['article_id']){
					$_GET['page'] = ceil($i / 20);
					$shipping_result->EOF = true;
				}
				$i++;
				$shipping_result->MoveNext();
			}
		}
		$shipping_split = new splitPageResults($_GET['page'], 20, $shipping_sql, $shipping_query_numrows);
		$shipping = $db->Execute($shipping_sql);
		if ($shipping->RecordCount() > 0) {
			while ( ! $shipping->EOF ) {
				$shipping_method[] = array (
							'id' => $shipping->fields['article_id'],
							'chinese_info' => $shipping->fields['article_title'],
							'admin_email' => $shipping->fields['admin_email'],
							'categories_status' => $shipping->fields['article_status'],
							'date_added' => $shipping->fields['date_added']
				);
				$shipping->MoveNext();
			}
		}
	}
	
}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title>Learning Center</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript" src="includes/jquery.js"></script>
<script language="javascript" src="includes/shipping.js"></script>
<script type="text/javascript">
  <!--
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
  }
  // -->

$(function(){
	$('.add_country_day').click(function(){
		if($('.country_time_else').length == 0){
			$('.table_country_time tr').addClass('country_time_else');
			$('.table_country_time tr td:first').html('<td><input type="hidden" name="country_id[]">其他:</td>');
		}
		$('.country_time_else').before('<tr><td><?php echo zen_get_country_list('country_id[]');?></td><td><input type="text" name="s_day_low[]"> <input type="text" name="s_day_high[]"> <a href="javascript:void(0);" class="delete_day"><img src="images/icon_delete.gif"></a></td></tr>');
	});
	
	var count = $("#step_count").val();
	$(".jq_add_row").click(function() {
		count++;
		var appendRow = '<tr><td class="dataTableHeadingContent" width="10%"></td><td colspan="3" width="90%">' + count + '、 图片：<input class="jq_image" type="file" name="article_steps_images' + count + '"> 链接：<input type="text" style="width:400px;" maxlength="50" class="jq_article_steps_url" name="article_steps_url' + count + '"></td></tr><tr><td class="dataTableHeadingContent"></td><td colspan="3">    文字描述：<textarea rows="5" name="article_steps_summary' + count + '"></textarea></td></tr>';
		$(".jq_table_container").append(appendRow);
		$("#step_count").val(count);
	});
	
	$(".jq_add_picture").click(function() {
		count++;
		var appendRow = '<tr><td class="dataTableHeadingContent" width="10%">图片' + count + '：</td> <td width="90%"><input class="jq_image" type="file" name="lc_categories_images' + count + '"></td></tr>';
		$(".jq_table_container").append(appendRow);
		$("#step_count").val(count);
	});
	
	$(".jq_image").live("change", function() {
		var fileUrl = $(this).val();
		var suffix = fileUrl.substring(fileUrl.lastIndexOf('.') + 1).toLowerCase();
		if(suffix != "jpg" && suffix != "jpeg" && suffix != "png" && suffix != "gif" && suffix != "bmp") {
			alert("文件不合法，仅支持jpg、jpeg、png、gif、bmp格式!");
			$(this).val("");
		}
	});
	
	var indexInfo = "";
	var valueInfo = "";
	$(".jq_delete").live("click", function() {
		var index = $("#jq_delete_index").val();
		var value = $("#jq_delete_value").val();
		indexInfo += $(this).data("index") + "|";
		valueInfo += $(this).data("value") + "|";
		$("#jq_delete_index").val(indexInfo);
		$("#jq_delete_value").val(valueInfo);
		$(this).hide();
		$(this).next().show();
	});
	
	$(".jq_submit").live("click", function() {
		$("#form_article").attr("action", $(this).data("url"));
		$("#form_article").attr("target", "_self");
		$("#form_article").submit();
	});
	
	$(".jq_preview").live("click", function() {
		$("#form_article").attr("action", $(this).data("url"));
		$("#form_article").attr("target", "_blank");
		$("#form_article").submit();
	});
	
});

function checkIndexSubmit() {
	if($.trim($("#title").val()) == "") {
		alert("标题不能为空!");
		return false;
	}
	if($.trim($("#desc").val()) == "") {
		alert("描述不能为空!");
		return false;
	}
}
function checkNewArticleSubmit() {
	if($.trim($("#article_title").val()) == "") {
		alert("请填写文章标题!");
		return false;
	}
	if($.trim($("#title_abbreviation").val()) == "") {
		alert("请填写标题缩写!");
		return false;
	}
	
	var index = 0;
	$(".jq_article_steps_url").each(function() {
			var $this = $(this);
			if($.trim($this.val()) != "" && $this.parent().find(".jq_image").val() == "" && ($this.parent().find(".jq_article_steps_images_old").val() == undefined || $this.parent().find(".jq_article_steps_images_old").val() == "")) {
				index++;
			}
		}
	);
	if(index > 0) {
		alert("填写了链接地址，请上传图片!");
		return false;
	}
	
	if($("#video_position").children('option:selected').val() != "" && $.trim($("#video_code").val()) == "") {
		alert("嵌入代码不能为空!");
		return false;
	}
}
</script>
</head>
<body onLoad="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>

<?php if(empty($action)) {?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td>
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading" width="40%">Learning Center<?php echo $breads;?></td>
            <td class="pageHeading" align="right" width="30%"><img src="images/icon_green_on.gif"> 启用 <img src="images/icon_red_on.gif"> 禁用</td>
            <td class="pageHeading" align="right" width="30%">
            	<form action='<?php echo zen_href_link('learning_center');?>' method='get'>
					搜索：
					<select name="type">
						<option value="1">文章</option>
						<option value="2">类别</option>
					</select>
					<input type="text" name="search" />
					<input style="cursor:pointer;" type="submit" value='确定'>
				</form>
            </td>            
          </tr>
          <tr>
            <td class="pageHeading">
            <?php if(!empty($search)) {?>
	            <button onclick="window.location.href='learning_center.php';">返回</button>
	        <?php } else {?>
	            <?php if(empty($parentId)) {?>
	            <button onclick="window.location.href='learning_center.php?action=index';">编辑首页</button>
	            <?php } else {?>
	            <button onclick="location.href='<?php echo zen_href_link('learning_center', zen_get_all_get_params(array('action', 'parent_id')) . 'parent_id=' . $previousId, 'NONSSL');?>';">返回</button>
	            <?php }?>
	            
	            <?php if($isCategory == 0 && !empty($parentId)) {?>
	            <button onclick="window.location.href='<?php echo zen_href_link('learning_center', zen_get_all_get_params(array('action', 'parent_id')) . 'action=new_category&parent_id=' . $parentId, 'NONSSL');?>';">新增类别</button>
	            <button onclick="window.location.href='<?php echo zen_href_link('learning_center', zen_get_all_get_params(array('action', 'parent_id')) . 'action=new_article&parent_id=' . $parentId, 'NONSSL');?>';">新增文章</button>
	            <?php } elseif($isCategory == 1 || empty($parentId)) {?>
	            <button onclick="window.location.href='<?php echo zen_href_link('learning_center', zen_get_all_get_params(array('action', 'parent_id')) . 'action=new_category&parent_id=' . $parentId, 'NONSSL');?>';">新增类别</button>
	            <?php } elseif($isCategory == 2) {?>
	            <button onclick="window.location.href='<?php echo zen_href_link('learning_center', zen_get_all_get_params(array('action', 'parent_id')) . 'action=new_article&parent_id=' . $parentId, 'NONSSL');?>';">新增文章</button>
	            <?php }?>
            <?php }?>
            </td>
            <td class="pageHeading" align="right">
            	
            </td>            
          </tr>
        </table>
        </td>
        <td align="right">
        	<?php 
        		/*
            	$order_by_array = array(array('id' => 'id', 'text' => '编号'),
										array('id' => 'id-desc', 'text' => '名称'),
										array('id' => 'code', 'text' => '编号'),
										array('id' => 'code-desc', 'text' => '代码降序'),
										array('id' => 'extra_oil', 'text' => '燃油率'),
										array('id' => 'extra_oil-desc', 'text' => '燃油率降序'),
										array('id' => 'discount', 'text' => '折扣'),
										array('id' => 'discount-desc', 'text' => '折扣降序'));
            	echo zen_draw_form('orderby', 'shipping', zen_get_all_get_params(array('action')));
            	echo '排序: ' . zen_draw_pull_down_menu('orderbyselect', $order_by_array, $order_by, 'onchange="this.form.submit();"');
            	echo '</form>';
            	*/
            ?>
      </td>
      </tr>
      <tr>
        <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">          
          <tr>
            <td valign="top">
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" width="10%">ID</td>
                <td class="dataTableHeadingContent" width="30%">名称</td>
                <td class="dataTableHeadingContent" width="20%">创建时间</td>
                <td class="dataTableHeadingContent" width="15%">创建人</td>
                <td class="dataTableHeadingContent" width="15%">状态</td>
                <td class="dataTableHeadingContent" width="10%">编辑</td>
              </tr>
              <?php 
              if(!empty($shipping_method)) {
              	if (!isset($_GET['id']) && $action != 'new' && $action != 'updates'){
					$first_method = reset($shipping_method);
					$id = $first_method['id'];
	            }
              	foreach ($shipping_method as $method => $val){
					
					if ($id == $val['id']) {
						$mInfo = new objectInfo($val);
						echo '<tr id="defaultSelected" class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . "\n";
					}else {
						echo '<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . "\n";
					}
              ?>              
                <td class="dataTableContent"><?php echo $val['id']?></td>
                <td class="dataTableContent">
				<?php if($isCategory == 1) {?>
				<a href="<?php echo zen_href_link('learning_center', zen_get_all_get_params(array('parent_id', 'type', 'search')) . 'parent_id=' . $val['id'], 'NONSSL');?>"><?php echo $val['chinese_info']?></a>
				<?php } else {?>
				<?php echo $val['chinese_info']?>
				<?php }?>
				</td>
                <td class="dataTableContent"><?php echo $val['date_added']?></td>
                <td class="dataTableContent"><?php echo $val['admin_email']?></td>
                <td class="dataTableContent">
				<?php 
				if($isCategory == 1) {
					echo ($val['categories_status'] ? '<a onClick="javascript:return confirm(\'确定将当前信息改为 禁用 吗?一旦更改，下属内容的状态均会更新为最新状态。\n                                        ' . $val['chinese_info'] . '\');" href="' . zen_href_link('learning_center', zen_get_all_get_params(array('action')) . 'action=update_status&lc_categories_id=' . $val['id']. '&status=0') . '"><img src="images/icon_green_on.gif"></a>' : '<a onClick="javascript:return confirm(\'确定将当前信息改为 启用 吗?一旦更改，下属内容的状态均会更新为最新状态。\n                                        ' . $val['chinese_info'] . '\');" href="' . zen_href_link('learning_center', zen_get_all_get_params(array('action')) . 'action=update_status&lc_categories_id=' . $val['id']. '&status=1') . '"><img src="images/icon_red_on.gif"></a>');
				} else {
					echo ($val['categories_status'] ? '<a onClick="javascript:return confirm(\'确定将当前信息改为 禁用 吗?\n                                        ' . $val['chinese_info'] . '\');" href="' . zen_href_link('learning_center', zen_get_all_get_params(array('action')) . 'action=update_status_article&article_id=' . $val['id']. '&status=0') . '"><img src="images/icon_green_on.gif"></a>' : '<a onClick="javascript:return confirm(\'确定将当前信息改为 启用 吗?\n                                        ' . $val['chinese_info'] . '\');" href="' . zen_href_link('learning_center', zen_get_all_get_params(array('action')) . 'action=update_status_article&article_id=' . $val['id']. '&status=1') . '"><img src="images/icon_red_on.gif"></a>');
				}
				?>
				</td>
                <td class="dataTableContent">
                


                <?php
                	if($isCategory == 1) {
						echo '<a href="' . zen_href_link('learning_center', zen_get_all_get_params(array('action', 'lc_categories_id', 'parent_id', 'orderby')) . 'action=new_category&lc_categories_id=' . $val['id']. '&parent_id=' . $parentId. '&orderby=' . $order_by) .'">' . zen_image(DIR_WS_IMAGES . 'icon_edit.gif', ICON_EDIT) . '</a> 
						<a onClick="javascript:return confirm(\'确定要删除当前信息吗？一旦删除，下属内容都将会被删除。\n' . $val['chinese_info'] . '\');" href="' . zen_href_link('learning_center', zen_get_all_get_params(array('action', 'lc_categories_id')) . 'action=delete_category&lc_categories_id=' . $val['id']) . '">' . zen_image(DIR_WS_IMAGES . 'icon_delete.gif', 'Delete') . '</a>';
					} else {
						echo '<a href="' . zen_href_link('learning_center', zen_get_all_get_params(array('action', 'article_id', 'parent_id', 'orderby')) . 'action=new_article&article_id=' . $val['id']. '&parent_id=' . $parentId. '&orderby=' . $order_by) .'">' . zen_image(DIR_WS_IMAGES . 'icon_edit.gif', ICON_EDIT) . '</a> 
						<a onClick="javascript:return confirm(\'确定要删除当前信息吗？\n' . $val['chinese_info'] . '\');" href="' . zen_href_link('learning_center', zen_get_all_get_params(array('action', 'article_id')) . 'action=delete_article&article_id=' . $val['id']) . '">' . zen_image(DIR_WS_IMAGES . 'icon_delete.gif', 'Delete') . '</a>';
					}
				?>
                </td>
              </tr>
              <?php }
              }
               ?>
              <tr>
                    <td class="smallText" valign="top" colspan="3"><?php echo $shipping_split->display_count($shipping_query_numrows, 20, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_SHIPPING_METHODS); ?></td>
                    <td class="smallText" align="right" colspan="3"><?php echo $shipping_split->display_links($shipping_query_numrows, 20, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'orderby', 'id')) . 'orderby=' . $order_by); ?></td>
                  </tr>
                  <tr>
                    <td class="smallText" valign="top" colspan="6">
                    
                    <?php if(!empty($search)) {?>
			            <button onclick="window.location.href='learning_center.php';">返回</button>
			        <?php } else {?>
			            <?php if(empty($parentId)) {?>
			            <button onclick="window.location.href='learning_center.php?action=index';">编辑首页</button>
			            <?php } else {?>
			            <button onclick="location.href='<?php echo zen_href_link('learning_center', zen_get_all_get_params(array('action', 'parent_id')) . 'parent_id=' . $previousId, 'NONSSL');?>';">返回</button>
			            <?php }?>
			            
			            <?php if($isCategory == 0 && !empty($parentId)) {?>
			            <button onclick="window.location.href='<?php echo zen_href_link('learning_center', zen_get_all_get_params(array('action', 'parent_id')) . 'action=new_category&parent_id=' . $parentId, 'NONSSL');?>';">新增类别</button>
			            <button onclick="window.location.href='<?php echo zen_href_link('learning_center', zen_get_all_get_params(array('action', 'parent_id')) . 'action=new_article&parent_id=' . $parentId, 'NONSSL');?>';">新增文章</button>
			            <?php } elseif($isCategory == 1 || empty($parentId)) {?>
			            <button onclick="window.location.href='<?php echo zen_href_link('learning_center', zen_get_all_get_params(array('action', 'parent_id')) . 'action=new_category&parent_id=' . $parentId, 'NONSSL');?>';">新增类别</button>
			            <?php } elseif($isCategory == 2) {?>
			            <button onclick="window.location.href='<?php echo zen_href_link('learning_center', zen_get_all_get_params(array('action', 'parent_id')) . 'action=new_article&parent_id=' . $parentId, 'NONSSL');?>';">新增文章</button>
			            <?php }?>
		            <?php }?>
		            
					</td>
                  </tr>
              </table>
              </td>
              </tr>
              </table>
            </td>
<?php
$heading = array();
$contents = array();
$language = zen_get_languages();
// echo '<pre>';
// print_r($language);exit;
switch ($action) {
	case 'edit':
		//$heading[] = array('text' => '<b>ID:' . $mInfo->id . ' ' . $mInfo->name . ' ' . $mInfo->code . '</b>');
		$contents = array('form' => zen_draw_form('shipping', 'shipping', zen_get_all_get_params(array('action', 'id', 'orderby')) . 'action=save&id=' . $mInfo->id. '&orderby=' . $order_by, 'post', '', true));		
		$str_table = '<table border="0" cellspacing="0" cellpadding="10" style="display:none;">';
		if ($mInfo->id == 3){
			$currency_query = $db->Execute('select configuration_value from ' . TABLE_CONFIGURATION . ' where configuration_key = "MODULE_SHIPPING_CHIANPOST_CURRENCY"');
			$currency = $currency_query->fields['configuration_value'];
			$str_table .= '<tr><td width="80">汇率:</td><td>' .  $currency . '</td></tr>';
		}
		foreach ($language as $key => $val){
			$str_table .= '<tr><td width="80">前台名称(' . $val['code'] . '):</td><td>' . zen_draw_input_field('s_title[' . $val['id'] . ']', $mInfo->title[$val['id']], 'style="width:300px;"') . '</td></tr>';
		}		
		$country_num = sizeof($mInfo->shipping_day);
		$str_day = '<table border="0" cellspacing="0" cellpadding="5" class="table_country_time">';
		if ($country_num > 0){			
			foreach ($mInfo->shipping_day as $key => $val){
				if ($key == 'default' || $key == ''){
					$country_name = ($country_num == 1 ? '所有' : '其他');
				}else{
					$c = $db->Execute('select countries_name, countries_id, countries_iso_code_2 from ' . TABLE_COUNTRIES . ' where countries_iso_code_2 = "' . $key . '"');
					$country_name = ($c->fields['countries_name'] != '' ? $c->fields['countries_name'] : ($country_num == 1 ? '所有' : '其他'));
				}
				if ($country_name == '其他'){
					$str_day_else = '<tr class="country_time_else"><td>' . zen_draw_hidden_field('country_id[]', $c->fields['countries_id']) . $country_name . ':</td><td>' . zen_draw_input_field('s_day_low[]', $val['day_low']) . ' ' . zen_draw_input_field('s_day_high[]', $val['day_high']) . '</td></tr>';
				}else{
					$str_day .= '<tr><td>' . zen_draw_hidden_field('country_id[]', $c->fields['countries_id']) . $country_name . ':</td><td>' . zen_draw_input_field('s_day_low[]', $val['day_low']) . ' ' . zen_draw_input_field('s_day_high[]', $val['day_high']);
					if ($country_name != '所有'){
						 $str_day .= ' ' . '<a href="' . zen_href_link('learning_center', zen_get_all_get_params(array('id', 'action')) . 'id=' . $mInfo->id . '&action=delday&c=' . $c->fields['countries_iso_code_2'], 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_delete.gif') . '</a>' . '</td></tr>';
					}
				}
			}			
		}else{
			$str_day .= '<tr><td>所有:</td><td>' . zen_draw_input_field('s_day_low[]') . ' ' . zen_draw_input_field('s_day_high[]') . '</td></tr>';
			$str_day_else = '';
		}
		$str_day .= $str_day_else;
		$str_day .= '</table>';
		$str_table .= '<tr><td>运送国家&天数:</td><td>' . $str_day . '</td></tr>';
		$str_table .= '<tr><td>折扣:</td><td>' . zen_draw_input_field('s_discount', $mInfo->discount) . '</td></tr>';
		$str_table .= '<tr><td>燃油率:</td><td>' . zen_draw_input_field('s_extra_oil', $mInfo->extra_oil) . '</td></tr>';
		$str_table .= '<tr><td>定额附加:</td><td>' . zen_draw_input_field('s_extra_amt', $mInfo->extra_amt) . '</td></tr>';
		$str_table .= '<tr><td>额外倍数:</td><td>' . zen_draw_input_field('s_extra_times', $mInfo->extra_times) . '</td></tr>';
		$str_table .= '<tr><td>考虑偏远:</td><td>' . zen_draw_radio_field('s_cal_remote', '1', ($mInfo->cal_remote ? true : false)) . '是' . zen_draw_radio_field('s_cal_remote', '0', ($mInfo->cal_remote ? false : true)) . '否' . '</td></tr>';
		$str_table .= '<tr><td>考虑体积:</td><td>' . zen_draw_radio_field('s_cal_volume', '1', ($mInfo->cal_volume ? true : false)) . '是' . zen_draw_radio_field('s_cal_volume', '0', ($mInfo->cal_volume ? false : true)) . '否' . '</td></tr>';
		$str_table .= '<tr><td>状态:</td><td>' . zen_draw_radio_field('s_status', '1', ($mInfo->status ? true : false)) . '开启' . zen_draw_radio_field('s_status', '0', ($mInfo->status ? false : true)) . '关闭' . '</td></tr>';
		$str_table .= '<tr><td colspan="2">' . zen_image_submit('button_submit_cn.png') . ' <a href="' . zen_href_link('learning_center', zen_get_all_get_params(array('id', 'action')) . 'id=' . $mInfo->id, 'NONSSL') . '">' . zen_image_button('button_cancel_cn.png', IMAGE_CANCEL) . '</a> <a href="javascript:void(0);" class="add_country_day" style="position:relative;bottom:10px;">添加国家和时间</a></td></tr>';
		$str_table .= '</table>';
		$str_table .= '</form>';
		$contents[] = array('text' => $str_table);
		break;
	case 'new':
		$heading[] = array('text' => '<b>添加新运送方式</b>');
		$contents = array('form' => zen_draw_form('shipping', 'shipping', zen_get_all_get_params(array('action', 'orderby')) . 'action=insert&orderby=' . $order_by, 'post', '', true));
		$str_table = '<table border="0" cellspacing="0" cellpadding="10">';
		$str_table .= '<tr><td width="80">ID:</td><td>' . zen_draw_input_field('s_id') . '</td></tr>';
		$str_table .= '<tr><td width="80">名称:</td><td>' . zen_draw_input_field('s_name') . '</td></tr>';
		$str_table .= '<tr><td width="80">代码:</td><td>' . zen_draw_input_field('s_code') . '</td></tr>';
		
		foreach ($language as $key => $val){
			$str_table .= '<tr><td width="80">前台名称(' . $val['code'] . '):</td><td>' . zen_draw_input_field('s_title[' . $val['id'] . ']', '', 'style="width:300px;"') . '</td></tr>';
		}
		
		$str_day = '<table border="0" cellspacing="0" cellpadding="5" class="table_country_time">';
		$str_day .= '<tr><td>所有:' . zen_draw_hidden_field('country_id[]') . '</td><td>' . zen_draw_input_field('s_day_low[]') . ' ' . zen_draw_input_field('s_day_high[]') . '</td></tr>';
		$str_day .= '</table>';
		
		$str_table .= '<tr><td>运送国家&天数:</td><td>' . $str_day . '</td></tr>';
		$str_table .= '<tr><td>折扣:</td><td>' . zen_draw_input_field('s_discount', '1') . '</td></tr>';
		$str_table .= '<tr><td>燃油率:</td><td>' . zen_draw_input_field('s_extra_oil', '0') . '</td></tr>';
		$str_table .= '<tr><td>定额附加:</td><td>' . zen_draw_input_field('s_extra_amt', '0') . '</td></tr>';
		$str_table .= '<tr><td>额外倍数:</td><td>' . zen_draw_input_field('s_extra_times', '1.02') . '</td></tr>';
		$str_table .= '<tr><td>考虑偏远:</td><td>' . zen_draw_radio_field('s_cal_remote', '1', false) . '是' . zen_draw_radio_field('s_cal_remote', '0', true) . '否' . '</td></tr>';
		$str_table .= '<tr><td>考虑体积:</td><td>' . zen_draw_radio_field('s_cal_volume', '1', false) . '是' . zen_draw_radio_field('s_cal_volume', '0', true) . '否' . '</td></tr>';
		$str_table .= '<tr><td>状态:</td><td>' . zen_draw_radio_field('s_status', '1', true) . '开启' . zen_draw_radio_field('s_status', '0', false) . '关闭' . '</td></tr>';
		$str_table .= '<tr><td colspan="2">' . zen_image_submit('button_submit_cn.png') . ' <a href="' . zen_href_link('learning_center', '', 'NONSSL') . '">' . zen_image_button('button_cancel_cn.png', IMAGE_CANCEL) . '</a> <a href="javascript:void(0);" class="add_country_day" style="position:relative;bottom:10px;">添加国家和时间</a></td></tr>';
		$str_table .= '</table>';
		$str_table .= '</form>';
		$contents[] = array('text' => $str_table);
		break;
	case 'updates':
		$heading[] = array('text' => '<b>更新/添加运费数据</b>');
		$contents = array('form' => zen_draw_form('shipping_data', 'shipping', zen_get_all_get_params(array('action', 'orderby')) . 'action=process'. '&orderby=' . $order_by, 'post', 'enctype="multipart/form-data"', true));
		
		$str_table = '<table border="0" cellspacing="0" cellpadding="10">';
		$str_table .= '<tr><td><b>代码: </b></td><td>' . zen_draw_input_field('method_code', $_SESSION['method_code']) . ' <span class="fieldRequired">* 必须滴</span></td></tr>';
		$str_table .= '<tr><td><b>地域运费: </b></td><td>' . zen_draw_file_field('postage_file') . '</td></tr>';
		$str_table .= '<tr><td><b>国家分区: </b></td><td>' . zen_draw_file_field('country_file') . '</td></tr>';
		$str_table .= '</table>';
		$str_table .= '</form>';
		
		$contents[] = array('text' => $str_table);
		$contents[] = array('align' => 'center', 'text' => '<br>' . zen_image_submit('button_submit_cn.png') . ' <a href="' . zen_href_link('learning_center', '&orderby=' . $order_by, 'NONSSL') . '">' . zen_image_button('button_cancel_cn.png', IMAGE_CANCEL) . '</a>');
		break;
	default:
		//$heading[] = array('text' => '<b>ID:' . $mInfo->id . ' ' . $mInfo->name . ' ' . $mInfo->code . '</b>');
		$contents[] = array('text' => '<div style="float:right;"><a href="' . zen_href_link('learning_center', zen_get_all_get_params(array('action', 'id', 'orderby')) . 'action=edit&id=' . $mInfo->id . '&orderby=' . $order_by) . '">' . zen_image_button('button_edit_cn.png') . '</a></div>');
		
		$country_num = sizeof($mInfo->shipping_day);
		if ($country_num > 0){
			$str_day = '<table border="0" cellspacing="0" cellpadding="5">';
			foreach ($mInfo->shipping_day as $key => $val){
				if ($key == 'default' || $key == ''){
					$country_name = ($country_num == 1 ? '所有' : '其他');
				}else{
					$c = $db->Execute('select countries_name from ' . TABLE_COUNTRIES . ' where countries_iso_code_2 = "' . $key . '"');
					$country_name = ($c->fields['countries_name'] != '' ? $c->fields['countries_name'] : ($country_num == 1 ? '所有' : '其他'));
				}
				if ($country_name == '其他'){
					$str_day_else = '<tr><td>' . $country_name . ':</td><td>' . $val['day_low'] . '-' . $val['day_high'] . '天</td></tr>';
				}else{
					$str_day .= '<tr><td>' . $country_name . ':</td><td>' . $val['day_low'] . '-' . $val['day_high'] . '天</td></tr>';
				}
			}
			$str_day .= $str_day_else;
			$str_day .= '</table>';
		}
		$str_table = '<table border="0" cellspacing="0" cellpadding="10" style="display:none;">';
		if ($mInfo->id == 3){
			$currency_query = $db->Execute('select configuration_value from ' . TABLE_CONFIGURATION . ' where configuration_key = "MODULE_SHIPPING_CHIANPOST_CURRENCY"');
			$currency = $currency_query->fields['configuration_value'];
			$str_table .= '<tr><td width="80">汇率:</td><td>' . $currency . '</td></tr>';
		}
// 		$str_table .= '<tr><td width="80">前台名称:</td><td>' . $mInfo->title . '</td></tr>';
		foreach ($language as $key => $val){
			$str_table .= '<tr><td width="80">前台名称(' . $val['code'] . '):</td><td>' . $mInfo->title[$val['id']] . '</td></tr>';
		}
		$str_table .= '<tr><td>运送国家&天数:</td><td>' . $str_day . '</td></tr>';
		$str_table .= '<tr><td>折扣:</td><td>' . $mInfo->discount . '</td></tr>';
		$str_table .= '<tr><td>燃油率:</td><td>' . $mInfo->extra_oil . '</td></tr>';
		$str_table .= '<tr><td>定额附加:</td><td>' . $mInfo->extra_amt . '</td></tr>';
		$str_table .= '<tr><td>额外倍数:</td><td>' . $mInfo->extra_times . '</td></tr>';
		$str_table .= '<tr><td>考虑偏远:</td><td>' . $mInfo->cal_remote . '</td></tr>';
		$str_table .= '<tr><td>考虑体积:</td><td>' . $mInfo->cal_volume . '</td></tr>';
		$str_table .= '<tr><td>状态:</td><td>' . $mInfo->status . '</td></tr>';		
		$str_table .= '</table>';
		$contents[] = array('text' => $str_table);
		break;
}
if ( (zen_not_null($heading)) && (zen_not_null($contents)) ) {
	echo '<td width="25%" valign="top">';
	$box = new box;
	echo $box->infoBox($heading, $contents);
	echo '</td>';
}
?>
          </tr>
       </table>
    </td>
  </tr>
</table>
<?php }?>

<?php if($action == 'index') {
	$languageCode = strtoupper($_SESSION['languages_code']);
	$learningTitle = $db->Execute('select configuration_value from ' . TABLE_CONFIGURATION . ' where configuration_key = "LC_INDEX_TITLE_' . $languageCode . '"');
	$learningImg = $db->Execute('select configuration_value from ' . TABLE_CONFIGURATION . ' where configuration_key = "LC_INDEX_IMG_' . $languageCode . '"');
	$learningDesc = $db->Execute('select configuration_value from ' . TABLE_CONFIGURATION . ' where configuration_key = "LC_INDEX_DESC_' . $languageCode . '"');
?>
<form enctype="multipart/form-data" method="post" action="learning_center.php?action=index_submit" onsubmit="return checkIndexSubmit();">
	<table width="100%" cellspacing="2" cellpadding="2" border="0">
	  <tbody>
	    <tr>
	      <td width="100%" valign="top"><table width="100%" cellspacing="0" cellpadding="2" border="0">
	          <tbody>
	            <tr>
	              <td><table width="100%" cellspacing="0" cellpadding="0" border="0">
	                  <tbody>
	                    <tr>
	                      <td class="pageHeading">Learning Center首页编辑</td>
	                      <td align="right" class="pageHeading"></td>
	                    </tr>
	                  </tbody>
	                </table></td>
	              <td align="right"></td>
	            </tr>
	            <tr>
	              <td valign="top"><table width="100%" cellspacing="0" cellpadding="0" border="0">
	                  <tbody>
	                    <tr>
	                      <td valign="top"><table width="100%" cellspacing="0" cellpadding="2" border="0">
	                          <tbody>
	                            <tr>
	                              <td width="10%" class="dataTableHeadingContent"><font color="red">*</font> 标题：</td>
	                              <td width="90%"><input type="text" id="title" name="title" maxlength="50" style="width:400px;" value="<?php echo $learningTitle->fields['configuration_value'];?>" /></td>
	                            </tr>
	                            <tr>
	                              <td class="dataTableHeadingContent"><font color="red">*</font> 大图：</td>
	                              <td><input class="jq_image" type="file" name="img" /><input type="hidden" name="img_old" value="<?php echo $learningImg->fields['configuration_value'];?>" /> <?php if(!empty($learningImg->fields['configuration_value'])) {echo "<a href='../images/" . $learningImg->fields['configuration_value'] . "' target='_blank'>查看图片</a>";}?></td>
	                            </tr>
	                            <tr>
	                              <td class="dataTableHeadingContent"><font color="red">*</font> 描述：</td>
	                              <td><textarea id="desc" name="desc" rows="5"><?php echo stripslashes($learningDesc->fields['configuration_value']);?></textarea></td>
	                            </tr>
	                            <tr>
	                              <td align="right" class="smallText"><input type="submit" value="保存" /></td>
	                              <td align="left" class="smallText"><input type="button" value="取消" onclick="history.back();" /></td>
	                            </tr>
	                            <tr>
	                              <td align="left" colspan="2" class="smallText" style="color:red;">注释：<br/>首页展示的分类图片，通过固定规则获取；分类描述，在对应分类信息中编辑。此处不提供编辑功能。</td>
	                            </tr>
	                          </tbody>
	                        </table></td>
	                    </tr>
	                  </tbody>
	                </table></td>
	            </tr>
	          </tbody>
	        </table></td>
	    </tr>
	  </tbody>
	</table>
</form>
<?php }?>

<?php if($action == 'new_category') {
	$lcCategoriesId = $_GET['lc_categories_id'];
	$languageCode = strtoupper($_SESSION['languages_code']);
	$categoriesImageStr = "";
	$stepCount = 3;
	if(!empty($lcCategoriesId)) {
		//echo 'select * from ' . TABLE_LC_CATEGORIES . ' c left join ' . TABLE_LC_CATEGORIES_DESC . ' cd on c.lc_categories_id = cd.lc_categories_id where c.lc_categories_id=' . $parentId . ' and cd.language_id=1';
		$categoryInfo = $db->Execute('select c.lc_categories_images, c.is_special, cd.lc_categories_name, cd.lc_categories_description from ' . TABLE_LC_CATEGORIES . ' c left join ' . TABLE_LC_CATEGORIES_DESC . ' cd on c.lc_categories_id = cd.lc_categories_id where c.lc_categories_id=' . $lcCategoriesId . ' and cd.language_id=' . $_SESSION['languages_id'] . '');
		if(!empty($categoryInfo->fields['lc_categories_name'])) {
			$imageArr = explode(",", $categoryInfo->fields['lc_categories_images']);
			if(count($imageArr) > $stepCount) {
				$stepCount = count($imageArr);
			}
			for($i = 1; $i <= $stepCount; $i++) {
				$openImg = "";
				$j = $i - 1;
				if(!empty($imageArr[$j])) {
					$openImg = " <a href='../images/" . $imageArr[$j] . "' target='_blank'>查看图片</a> &nbsp;&nbsp;&nbsp;&nbsp;<a class='jq_delete' href='javascript:void(0);' style='color:red' data-index='" . $i . "' data-value='" . $imageArr[$j] . "'>删除</a><label colr='gray' style='display:none;'>已删除</label>";
				}
				$categoriesImageStr .= '<tr>
	                              <td class="dataTableHeadingContent">图片' . $i . '：</td>
	                              <td><input class="jq_image" type="file" name="lc_categories_images' . $i . '" /><input type="hidden" name="lc_categories_images_old' . $i . '" value="' . $imageArr[$j] . '" />' . $openImg . '</td>
	                            </tr>';
			}
		}
	} else {
		$categoryInfo = null;
		for($i = 1; $i <= $stepCount; $i++) {
			$categoriesImageStr .= '<tr>
                              <td class="dataTableHeadingContent">图片' . $i . '：</td>
                              <td><input class="jq_image" type="file" name="lc_categories_images' . $i . '" /><input type="hidden" name="lc_categories_images_old' . $i . '" value="" /></td>
                            </tr>';
		}
	}
?>
<form enctype="multipart/form-data" method="post" action="learning_center.php?action=new_category_submit&parent_id=<?php echo $parentId;?>">
	<input type="hidden" name="lc_categories_id" value="<?php echo $lcCategoriesId;?>" />
	<input type="hidden" name="step_count" id="step_count" value="<?php echo $stepCount;?>" />
	<input type="hidden" name="jq_delete_index" id="jq_delete_index" value="" />
	<input type="hidden" name="jq_delete_value" id="jq_delete_value" value="" />
	<table width="100%" cellspacing="2" cellpadding="2" border="0">
	  <tbody>
	    <tr>
	      <td width="100%" valign="top"><table width="100%" cellspacing="0" cellpadding="2" border="0">
	          <tbody>
	            <tr>
	              <td><table width="100%" cellspacing="0" cellpadding="0" border="0">
	                  <tbody>
	                    <tr>
	                      <td class="pageHeading">Learning Center<?php echo $breads;?></td>
	                      <td align="right" class="pageHeading"></td>
	                    </tr>
	                  </tbody>
	                </table></td>
	              <td align="right"></td>
	            </tr>
	            <tr>
	              <td valign="top"><table width="100%" cellspacing="0" cellpadding="0" border="0">
	                  <tbody>
	                    <tr>
	                      <td valign="top"><table width="100%" cellspacing="0" cellpadding="2" border="0">
	                          <tbody>
	                            <tr>
	                              <td width="10%" class="dataTableHeadingContent"><font color="red">*</font> 名称：</td>
	                              <td width="90%"><input type="text" name="lc_categories_name" maxlength="50" style="width:400px;" value="<?php echo !empty($categoryInfo) ? $categoryInfo->fields['lc_categories_name'] : "";?>" /></td>
	                            </tr>
	                            <tr>
	                              <td class="dataTableHeadingContent">描述：</td>
	                              <td><textarea name="lc_categories_description" rows="5"><?php echo !empty($categoryInfo) ? stripslashes($categoryInfo->fields['lc_categories_description']) : "";?></textarea></td>
	                            </tr>
	                            <?php echo $categoriesImageStr;?>
	                            <tr>
									<td colspan="2">
										<table class="jq_table_container" width="100%" cellspacing="0" cellpadding="0">
										</table>
									</td>
								</tr>
								<tr>
	                              <td>&nbsp;</td>
	                              <td><a href="javascript:void(0);" style="font-size:20px; color:bule;" class="jq_add_picture">添加图片</a></td>
	                            </tr>
	                            <tr>
									<td colspan="2">&nbsp;</td>
								</tr>
								<?php if(empty($parentId)) {?>
								<tr>
	                              <td class="dataTableHeadingContent">是否特殊显示：</td>
	                              <td><input type="radio" name="is_special" value="1"<?php if(!empty($categoryInfo) && !empty($categoryInfo->fields['is_special'])) { echo " checked='checked'"; }?>>是  &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="is_special" value="0"<?php if(empty($categoryInfo) || empty($categoryInfo->fields['is_special'])) { echo " checked='checked'"; }?>>否</td>
	                            </tr>
	                            <?php }?>
	                            <tr>
	                              <td align="right" class="smallText"><input type="submit" value="保存" /></td>
	                              <td align="left" class="smallText"><input type="button" value="取消" onclick="history.back();" /></td>
	                            </tr>
	                            <tr>
	                              <td align="left" colspan="2" class="smallText" style="color:red;">注释：<br/>首页展示的分类图片，通过固定规则获取；分类描述，在对应分类信息中编辑。此处不提供编辑功能。</td>
	                            </tr>
	                          </tbody>
	                        </table></td>
	                    </tr>
	                  </tbody>
	                </table></td>
	            </tr>
	          </tbody>
	        </table></td>
	    </tr>
	  </tbody>
	</table>
</form>
<?php }?>

<?php if($action == 'new_article') {
	$articleId = $_GET['article_id'];
	$languageCode = strtoupper($_SESSION['languages_code']);
	$categoriesImageStr = "";
	$stepCount = 3;
	if(!empty($articleId)) {
		//echo 'select * from ' . TABLE_LC_CATEGORIES . ' c left join ' . TABLE_LC_CATEGORIES_DESC . ' cd on c.lc_categories_id = cd.lc_categories_id where c.lc_categories_id=' . $parentId . ' and cd.language_id=1';
		$articleInfo = $db->Execute('select lca.article_title, lca.title_abbreviation, lca.article_summary, lca.article_images, lca.video_position, lca.video_code, lca.video_image, lca.parts_num, lca.tools_num, lca.material_list, lca.is_watermark from ' . TABLE_LC_ARTICLE . ' lca where lca.article_id=' . $articleId . ' and lca.language_id=' . $_SESSION['languages_id'] . '');
		if(!empty($articleInfo->fields['article_title'])) {
			$articleQuery =  $db->Execute('select article_steps_images, article_steps_url, article_steps_summary from ' . TABLE_LC_ARTICLE_STEPS . ' where article_id=' . $articleId . " order by article_steps_id");
			$arraySteps = array();
			$i = 1;
			while(!$articleQuery->EOF) {
				$stepStr = "";
				$viewImage = "";
				if($i == 1) {
					$stepStr = "步骤：";
				} else {
					$stepStr = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				}
				if(!empty($articleQuery->fields['article_steps_images'])) {
					$viewImage = '<a href="../images/' . $articleQuery->fields['article_steps_images'] . '" target="_blank">查看图片</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				}
				array_push($arraySteps, '<tr>
	                              <td class="dataTableHeadingContent">' . $stepStr . ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="jq_delete" href="javascript:void(0);" style="color:red" data-index="' . $i . '" data-value="' . $articleQuery->fields['article_steps_images'] . '">删除</a><label colr="gray" style="display:none;">已删除</label></td>
	                              <td colspan="3">' . $i . '、 图片：<input class="jq_image" type="file" name="article_steps_images' . $i . '" /><input type="hidden" class="jq_article_steps_images_old" name="article_steps_images_old' . $i . '" value="' . $articleQuery->fields['article_steps_images'] . '" /> ' . $viewImage . ' 链接：<input type="text" class="jq_article_steps_url" name="article_steps_url' . $i . '" maxlength="50" style="width:400px;" value="' . $articleQuery->fields['article_steps_url'] . '" /></td>
	                            </tr>
	                            <tr>
	                              <td class="dataTableHeadingContent"></td>
	                              <td colspan="3">    文字描述：<textarea name="article_steps_summary' . $i . '" rows="5">' . stripslashes($articleQuery->fields['article_steps_summary']) . '</textarea></td>
	                            </tr>');
				$i++;
				$articleQuery->MoveNext();
			}
			/*
			$imageArr = explode(",", $categoryInfo->fields['lc_categories_images']);
			for($i = 1; $i <= 5; $i++) {
				$openImg = "";
				$j = $i - 1;
				if(!empty($imageArr[$j])) {
					$openImg = " <a href='../images/" . $imageArr[$j] . "' target='_blank'>查看图片</a>";
				}
				$categoriesImageStr .= '<tr>
	                              <td class="dataTableHeadingContent">图片' . $i . '：</td>
	                              <td><input class="jq_image" type="file" name="lc_categories_images' . $i . '" /><input type="hidden" name="lc_categories_images_old' . $i . '" value="' . $imageArr[$j] . '" />' . $openImg . '</td>
	                            </tr>';
			}*/
			if($articleQuery->RecordCount() > $stepCount) {
				$stepCount = $articleQuery->RecordCount();
			}
			for($i = 1; $i <= $stepCount; $i++) {
				//$openImg = "";
				$j = $i - 1;
				$stepStr = "";
				if($i == 1) {
					$stepStr = "步骤：";
				}
				if(!empty($arraySteps[$j])) {
					//$openImg = " <a href='../images/" . $imageArr[$j] . "' target='_blank'>查看图片</a>";
					$categoriesImageStr .= $arraySteps[$j];
				} else {
					$categoriesImageStr .= '<tr>
	                              <td class="dataTableHeadingContent">' . $stepStr . '</td>
	                              <td colspan="3">' . $i . '、 图片：<input class="jq_image" type="file" name="article_steps_images' . $i . '" /><input type="hidden" name="article_steps_images_old' . $i . '" /> 链接：<input type="text" class="jq_article_steps_url" name="article_steps_url' . $i . '" maxlength="50" style="width:400px;" value="" /></td>
	                            </tr>
	                            <tr>
	                              <td class="dataTableHeadingContent"></td>
	                              <td colspan="3">    文字描述：<textarea name="article_steps_summary' . $i . '" rows="5"></textarea></td>
	                            </tr>';
				}
				
			}
		}
		//print_r($categoriesImageStr);exit;
	} else {
		$articleInfo = null;
		for($i = 1; $i <= 3; $i++) {
			$stepStr = "";
			if($i == 1) {
				$stepStr = "步骤：";
			}
			$categoriesImageStr .= '<tr>
	                      <td class="dataTableHeadingContent">' . $stepStr . '</td>
	                      <td colspan="3">' . $i . '、 图片：<input class="jq_image" type="file" name="article_steps_images' . $i . '" /><input type="hidden" name="article_steps_images_old' . $i . '" /> 链接：<input type="text" class="jq_article_steps_url" name="article_steps_url' . $i . '" maxlength="50" style="width:400px;" value="" /></td>
	                    </tr>
	                    <tr>
	                      <td class="dataTableHeadingContent"></td>
	                      <td colspan="3">    文字描述：<textarea name="article_steps_summary' . $i . '" rows="5"></textarea></td>
	                    </tr>';
		}
	}
?>
<form id="form_article" enctype="multipart/form-data" method="post" action="learning_center.php?action=new_article_submit&parent_id=<?php echo $parentId?>" onsubmit="return checkNewArticleSubmit();">
	<input type="hidden" name="article_id" value="<?php echo $articleId;?>" />
	<input type="hidden" name="step_count" id="step_count" value="<?php echo $stepCount;?>" />
	<input type="hidden" name="jq_delete_index" id="jq_delete_index" value="" />
	<input type="hidden" name="jq_delete_value" id="jq_delete_value" value="" />
	<table width="100%" cellspacing="2" cellpadding="2" border="0">
	  <tbody>
	    <tr>
	      <td width="100%" valign="top"><table width="100%" cellspacing="0" cellpadding="2" border="0">
	          <tbody>
	            <tr>
	              <td><table width="100%" cellspacing="0" cellpadding="0" border="0">
	                  <tbody>
	                    <tr>
	                      <td class="pageHeading">Learning Center<?php echo $breads;?></td>
	                      <td align="right" class="pageHeading"></td>
	                    </tr>
	                  </tbody>
	                </table></td>
	              <td align="right"></td>
	            </tr>
	            <tr>
	              <td valign="top"><table width="100%" cellspacing="0" cellpadding="0" border="0">
	                  <tbody>
	                    <tr>
	                      <td valign="top"><table width="100%" cellspacing="0" cellpadding="2" border="0">
	                          <tbody>
	                            <tr>
	                              <td width="10%" class="dataTableHeadingContent"><font color="red">*</font> 文章标题：</td>
	                              <td width="30%"><input type="text" id="article_title" name="article_title" maxlength="50" style="width:400px;" value="<?php echo !empty($articleInfo) ? $articleInfo->fields['article_title'] : "";?>" /></td>
	                              <td width="10%" class="dataTableHeadingContent"><font color="red">*</font> 标题缩写：</td>
	                              <td width="50%"><input type="text" id="title_abbreviation" name="title_abbreviation" maxlength="50" style="width:400px;" value="<?php echo !empty($articleInfo) ? $articleInfo->fields['title_abbreviation'] : "";?>" /></td>
	                            </tr>
	                            <tr>
	                              <td class="dataTableHeadingContent">主图：</td>
	                              <td colspan="3"><input class="jq_image" type="file" name="article_images" /><input type="hidden" name="article_images_old" value="<?php echo !empty($articleInfo) ? $articleInfo->fields['article_images'] : "";?>" />
	                              <?php if(!empty($articleInfo) && !empty($articleInfo->fields['article_images'])) {
	                              	echo "<a href='../images/" . $articleInfo->fields['article_images'] . "' target='_blank'>查看图片</a>";
	                              }?>
	                              </td>
	                            </tr>
	                            <tr>
	                              <td class="dataTableHeadingContent">综述：</td>
	                              <td colspan="3"><textarea name="article_summary" rows="5"><?php echo !empty($articleInfo) ? stripslashes($articleInfo->fields['article_summary']) : "";?></textarea></td>
	                            </tr>
	                            <tr>
	                              <td class="dataTableHeadingContent">物料清单：</td>
	                              <td colspan="3"><textarea name="material_list" rows="5"><?php echo !empty($articleInfo) ? stripslashes($articleInfo->fields['material_list']) : "";?></textarea></td>
	                            </tr>
								<?php echo $categoriesImageStr;?>
								<tr>
									<td colspan="4">
										<table class="jq_table_container" width="100%" cellspacing="0" cellpadding="0">
										</table>
									</td>
								</tr>
	                            <tr>
	                              <td>&nbsp;</td>
	                              <td>&nbsp;</td>
	                              <td colspan="2"><a href="javascript:void(0);" style="font-size:20px; color:bule;" class="jq_add_row">添加步骤</a></td>
	                            </tr>
	                            <tr>
	                              <td class="dataTableHeadingContent">视频：</td>
	                              <td colspan="3">位置：视频插入在
	                              <select id="video_position" name="video_position" id="video_position">
	                              	<option value="">请选择</option>
	                              	<option value="10"<?php if(!empty($articleInfo) && $articleInfo->fields['video_position'] == "10") {echo " selected";}?>>文章标题</option>
	                              	<option value="20"<?php if(!empty($articleInfo) && $articleInfo->fields['video_position'] == "20") {echo " selected";}?>>主图</option>
	                              	<option value="30"<?php if(!empty($articleInfo) && $articleInfo->fields['video_position'] == "30") {echo " selected";}?>>综述</option>
	                              	<option value="40"<?php if(!empty($articleInfo) && $articleInfo->fields['video_position'] == "40") {echo " selected";}?>>物料清单</option>
	                              	<option value="50"<?php if(!empty($articleInfo) && $articleInfo->fields['video_position'] == "50") {echo " selected";}?>>步骤</option>
	                              	<option value="60"<?php if(!empty($articleInfo) && $articleInfo->fields['video_position'] == "60") {echo " selected";}?>>配件</option>
	                              	<option value="70"<?php if(!empty($articleInfo) && $articleInfo->fields['video_position'] == "70") {echo " selected";}?>>工具</option>
	                              </select>之后
	                              </td>
	                            </tr>
	                            <tr>
	                              <td class="dataTableHeadingContent"></td>
	                              <td colspan="3">    视频图：<input class="jq_image" type="file" name="video_image" /><input type="hidden" name="video_image_old" value="<?php echo !empty($articleInfo) ? $articleInfo->fields['video_image'] : "";?>"/>
	                              <?php if(!empty($articleInfo) && !empty($articleInfo->fields['video_image'])) {
	                              	echo "<a href='../images/" . $articleInfo->fields['video_image'] . "' target='_blank'>查看图片</a>";
	                              }?>
	                              </td>
	                            </tr>
	                            <tr>
	                              <td class="dataTableHeadingContent"></td>
	                              <td colspan="3">    嵌入代码：<textarea id="video_code" name="video_code" rows="5"><?php echo !empty($articleInfo) ? stripslashes($articleInfo->fields['video_code']) : "";?></textarea></td>
	                            </tr>
	                            <tr>
	                              <td class="dataTableHeadingContent">配件商品编号：</td>
	                              <td colspan="3"><input type="text" name="parts_num" maxlength="50" style="width:600px;" value="<?php echo !empty($articleInfo) ? $articleInfo->fields['parts_num'] : "";?>" /><br/><font color="#CCC7FF">(注：多个编号请个英文下的","号隔开)</font></td>
	                            </tr>
	                            <tr>
	                              <td class="dataTableHeadingContent">配件工具编号：</td>
	                              <td colspan="3"><input type="text" name="tools_num" maxlength="50" style="width:600px;" value="<?php echo !empty($articleInfo) ? $articleInfo->fields['tools_num'] : "";?>" /><br/><font color="#CCC7FF">(注：多个编号请个英文下的","号隔开)</font></td>
	                            </tr>
	                            <tr>
	                              <td class="dataTableHeadingContent">图片是否加水印：</td>
	                              <td colspan="3"><input type="radio" value="1" name="is_watermark"<?php if(!empty($articleInfo) && !empty($articleInfo->fields['is_watermark'])) { echo " checked='checked'"; }?> />是 &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" value="0" name="is_watermark"<?php if(empty($articleInfo) || empty($articleInfo->fields['is_watermark'])) { echo " checked='checked'"; }?> />否</td>
	                            </tr>
	                            <tr>
	                              <td align="right" colspan="2" class="smallText"><input type="button" value="保存" class="jq_submit" data-url="learning_center.php?action=new_article_submit&parent_id=<?php echo $parentId?>" /></td>
	                              <td align="left" colspan="2" class="smallText">&nbsp;&nbsp;<input type="button" value="取消" onclick="history.back();" /> &nbsp;&nbsp;<input type="button" value="预览" class="jq_preview" data-url="learning_center.php?action=new_article_preview&parent_id=<?php echo $parentId?>" style="display:none;" /></td>
	                            </tr>
	                          </tbody>
	                        </table></td>
	                    </tr>
	                  </tbody>
	                </table></td>
	            </tr>
	          </tbody>
	        </table></td>
	    </tr>
	  </tbody>
	</table>
</form>
<?php }?>

</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>