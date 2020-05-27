<?php
require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));

// code for lc_categories
function select_lc_categories($parent_id=0, &$arr=array(), $path=''){
	global $db;

	$parent_id = intval($parent_id);
	$lc_categories_sql = "select lcc.lc_categories_id, lccd.lc_categories_name ,lcc.parent_id, lcc.lc_categories_images, lccd.lc_categories_description, lcc.is_special
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
									"images" => $images[0],
									"is_special" => $lc_categories->fields['is_special'],
									"desc" => $lc_categories->fields['lc_categories_description']
			);
			unset($images);
			select_lc_categories($lc_categories->fields['lc_categories_id'], $arr, $path2);
			$lc_categories->MoveNext();
		}
	}
	return $arr;
}

function get_lc_category_path($cid){
	global $db;

	$cid = intval($cid);
	$sql = "select  lccd.lc_categories_name,lcc.parent_id 
				from ". TABLE_LC_CATEGORIES ." lcc, ". TABLE_LC_CATEGORIES_DESC ." lccd 
				where lcc.lc_categories_id = ".$cid." 
				and lcc.lc_categories_id = lccd.lc_categories_id 
				and lccd.language_id='" . $_SESSION['languages_id'] . "' 
				and lcc.categories_status=1 
				order by lcc.lc_categories_id limit 1";
	$lc_categories = $db->Execute($sql);
	$path = array();
	if($lc_categories->RecordCount()>0){
		$path[] = array('id'=>$cid, 'name'=>$lc_categories->fields['lc_categories_name']);
		if($lc_categories->fields['parent_id'] > 0){
			$path = array_merge($path, get_lc_category_path($lc_categories->fields['parent_id']));
		}
	}
	return $path;
}

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
//var_dump($lc_categories_array_list);
/*echo '<pre>';
print_r($lc_categories_array_result);
echo '</pre>';*/
//var_dump($lc_categories_array);

// recent articles
$recently_article_sql = "select a.article_id, a.title_abbreviation 
				from ".TABLE_LC_ARTICLE." a 
				where a.language_id='" . $_SESSION['languages_id'] . "' 
				and a.article_status=1 
				order by a.date_added desc limit 5";
$recently_article_result = $db->Execute($recently_article_sql);
if($recently_article_result->RecordCount()>0){
	while (!$recently_article_result->EOF) {
		$recently_article_array[] = array("aid" => $recently_article_result->fields['article_id'],
												"title" => $recently_article_result->fields['title_abbreviation']
		);
		$recently_article_result->MoveNext();
	}
}
//var_dump($recently_article_array);

// code for display html
// first list
if(isset($_POST['cate_id'])){ 
	$cate_id = $_POST['cate_id'];
	$view = $_POST['view'];

	$sub_sql = "select  lccd.lc_categories_name, lcc.lc_categories_images, lccd.lc_categories_description , lcc.is_special
				from ". TABLE_LC_CATEGORIES ." lcc, ". TABLE_LC_CATEGORIES_DESC ." lccd 
				where lcc.lc_categories_id = ".$cate_id." 
				and lcc.lc_categories_id = lccd.lc_categories_id 
				and lccd.language_id='" . $_SESSION['languages_id'] . "' 
				and lcc.categories_status=1 
				order by lcc.lc_categories_id desc";
	$sub_sql_result = $db->Execute($sub_sql);
	if ($sub_sql_result->EOF) {
		die('<font style="font-size:16px">Sorry, the page was not found.    Please refresh the page.</font>');
	}
	if($sub_sql_result->RecordCount()>0){
		while (!$sub_sql_result->EOF) {
			$sub_sql_result_array = array("name" => $sub_sql_result->fields['lc_categories_name'],
											"images" => $sub_sql_result->fields['lc_categories_images'],
											"is_special" => $sub_sql_result->fields['is_special'],
											"desc" => $sub_sql_result->fields['lc_categories_description']
			);
			$sub_sql_result->MoveNext();
		}
	}
	$cate_name = $sub_sql_result_array['name'];
	$cate_imgs = $sub_sql_result_array['images'];
	$imgs_arr = explode(',', $cate_imgs);
	$cate_desc = $sub_sql_result_array['desc'];

	$breadcrumb->add( TEXT_LEARNING_CENTER, zen_href_link('learning_center') );
	$breadcrumb->add($cate_name);
	
	if ($sub_sql_result_array['is_special'] == '1') {

		$cate_id_sql = "select lcc.lc_categories_id, lccd.lc_categories_name
						from ". TABLE_LC_CATEGORIES ." lcc, ". TABLE_LC_CATEGORIES_DESC ." lccd 
						where lcc.parent_id = ".$cate_id." 
						and lcc.lc_categories_id = lccd.lc_categories_id 
						and lccd.language_id='" . $_SESSION['languages_id'] . "' 
						and lcc.categories_status=1 
						order by lcc.lc_categories_id";
		$cate_id_sql_result = $db->Execute($cate_id_sql);
		if($cate_id_sql_result->RecordCount()>0){
			while (!$cate_id_sql_result->EOF) {
				$sub_image_array = array();
				$sub_image_sql = "select a.article_id ,a.article_images, a.video_image, las.article_steps_images
									from ". TABLE_LC_ARTICLE." a left join ".TABLE_LC_ARTICLE_STEPS." las on (a.article_id = las.article_id)
									where a.categories_path like '%:".$cate_id_sql_result->fields['lc_categories_id'].":%' 
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
				$cate_id_sql_result_array[] = array("id" => $cate_id_sql_result->fields['lc_categories_id'],
										"name" => $cate_id_sql_result->fields['lc_categories_name'],
										"images" => $images['0']
				);
				$cate_id_sql_result->MoveNext();
			}
		}
		/*echo '<pre>';
		print_r($cate_id_sql_result_array);
		echo '</pre>';*/

		/*foreach ($lc_categories_array_result as $key => $value) {
			if ($value['id'] == $cate_id) {
				$first_cate_array = $value[$value['id']];
			}
		}*/
		//var_dump($first_cate_array);
		foreach ($cate_id_sql_result_array as $key => $value) {
			$double_sql = "select lcc.lc_categories_id, lccd.lc_categories_name,lcc.parent_id
							from ". TABLE_LC_CATEGORIES ." lcc, ". TABLE_LC_CATEGORIES_DESC ." lccd 
							where lcc.parent_id = ".$value['id']." 
							and lcc.lc_categories_id = lccd.lc_categories_id 
							and lccd.language_id='" . $_SESSION['languages_id'] . "' 
							and lcc.categories_status=1 
							order by lcc.lc_categories_id desc";
			$double_sql_result = $db->Execute($double_sql);
			if($double_sql_result->RecordCount()>0){
				while (!$double_sql_result->EOF) {
					$sub_image_array = array();
					$sub_image_sql = "select a.article_id ,a.article_images, a.video_image, las.article_steps_images
										from ". TABLE_LC_ARTICLE." a left join ".TABLE_LC_ARTICLE_STEPS." las on (a.article_id = las.article_id)
										where a.categories_path like '%:".$double_sql_result->fields['lc_categories_id'].":%' 
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
					$double_sql_result_array[$value['id']][] = array("id" => $double_sql_result->fields['lc_categories_id'],
												"pid" => $double_sql_result->fields['parent_id'],
												"name" => $double_sql_result->fields['lc_categories_name'],
												"images" => $images['0']
					);
					$double_sql_result->MoveNext();
				}
			}
		}
		//var_dump($double_sql_result_array);

		foreach ($cate_id_sql_result_array as $key => $value) {
			$hahaha[] = $value['id'];
			$article_sql = "select a.article_id, a.title_abbreviation ,a.lc_categories_id, a.article_images,a.video_image, a.article_summary, las.article_steps_images
					from ".TABLE_LC_ARTICLE." a left join ".TABLE_LC_ARTICLE_STEPS." las on (a.article_id = las.article_id)
					where a.lc_categories_id = ".$value['id']." 	 
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
					$article_array[$value['id']][] = array("aid" => $article_result->fields['article_id'],
															"title" => $article_result->fields['title_abbreviation'],
															"cate_id" => $article_result->fields['lc_categories_id'],
															"images" => $image,
															"desc" => $article_result->fields['article_summary']
					);
					$article_result->MoveNext();
				}
			}
		}

		//var_dump($article_array);

		require($template->get_template_dir('/tpl_lc_first_list_default.php', DIR_WS_TEMPLATE, $current_page_base, 'templates'). '/tpl_lc_first_list_default.php');

		die();
	}elseif($sub_sql_result_array['is_special'] == '0'){
		$cate_id_sql = "select lcc.lc_categories_id, lccd.lc_categories_name, lcc.lc_categories_images
						from ". TABLE_LC_CATEGORIES ." lcc, ". TABLE_LC_CATEGORIES_DESC ." lccd 
						where lcc.parent_id = ".$cate_id." 
						and lcc.lc_categories_id = lccd.lc_categories_id 
						and lccd.language_id='" . $_SESSION['languages_id'] . "' 
						and lcc.categories_status=1 
						order by lcc.lc_categories_id desc";
		$cate_id_sql_result = $db->Execute($cate_id_sql);
		if ($cate_id_sql_result->EOF) {
			die('<font style="font-size:16px">Sorry, the page was not found.    Please refresh the page.</font>');
		}
		if($cate_id_sql_result->RecordCount()>0){
			while (!$cate_id_sql_result->EOF) {
				$sub_image_array = array();
				$sub_image_sql = "select a.article_id ,a.article_images, a.video_image, las.article_steps_images
									from ". TABLE_LC_ARTICLE." a left join ".TABLE_LC_ARTICLE_STEPS." las on (a.article_id = las.article_id)
									where a.categories_path like '%:".$cate_id_sql_result->fields['lc_categories_id'].":%' 
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
				$cate_id_sql_result_array[] = array("id" => $cate_id_sql_result->fields['lc_categories_id'],
										"name" => $cate_id_sql_result->fields['lc_categories_name'],
										"images" => $images['0']
				);
				$cate_id_sql_result->MoveNext();
			}
		}
		//var_dump($cate_id_sql_result_array);
		//exit;

		require($template->get_template_dir('/tpl_lc_first_common_list_default.php', DIR_WS_TEMPLATE, $current_page_base, 'templates'). '/tpl_lc_first_common_list_default.php');

		die();
	}
	
}

// second list
if (isset($_POST['second_id'])) {

	$second_id = intval($_POST['second_id']);
	$view = $_POST['view'];

	$sub_sql = "select  lccd.lc_categories_name, lcc.lc_categories_images, lccd.lc_categories_description 
				from ". TABLE_LC_CATEGORIES ." lcc, ". TABLE_LC_CATEGORIES_DESC ." lccd 
				where lcc.lc_categories_id = ".$second_id." 
				and lcc.lc_categories_id = lccd.lc_categories_id 
				and lccd.language_id='" . $_SESSION['languages_id'] . "' 
				and lcc.categories_status=1 
				order by lcc.lc_categories_id desc";
	$sub_sql_result = $db->Execute($sub_sql);
	if ($sub_sql_result->EOF) {
		die('<font style="font-size:16px">Sorry, the page was not found.    Please refresh the page.</font>');
	}
	if($sub_sql_result->RecordCount()>0){
		while (!$sub_sql_result->EOF) {
			$sub_image_array = array();
				$sub_image_sql = "select a.article_id ,a.article_images, a.video_image, las.article_steps_images
									from ". TABLE_LC_ARTICLE." a left join ".TABLE_LC_ARTICLE_STEPS." las on (a.article_id = las.article_id)
									where a.categories_path like '%:".$sub_sql_result->fields['lc_categories_id'].":%' 
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
			$sub_sql_result_array = array("name" => $sub_sql_result->fields['lc_categories_name'],
											"images" => $images['0'],
											"desc" => $sub_sql_result->fields['lc_categories_description']
			);
			$sub_sql_result->MoveNext();
		}
	}
	//var_dump($sub_sql_result_array);
	$second_name = $sub_sql_result_array['name'];
	$second_imgs = $sub_sql_result_array['images'];
	$imgs_arr = explode(',', $cate_imgs);
	$second_desc = $sub_sql_result_array['desc'];

	$path = get_lc_category_path($second_id);
	krsort($path);
	$first_id = $path['1']['id'];
	$breadcrumb->add( TEXT_LEARNING_CENTER, zen_href_link('learning_center') );
	foreach($path as $c){
		$breadcrumb->add($c['name'],'javascript:void(0)" cate_id='.$c['id'].' class="clicktocat'  );
	}

	/*foreach ($lc_categories_array_result as $key => $value) {
		foreach ($value[$value['id']] as $key1 => $value1) {
			if ($value1['id'] == $second_id) {
				$second_cate_array = $value1[$value1['id']];
			}
		}	
	}*/

	$second_cate_sql = "select lcc.lc_categories_id, lccd.lc_categories_name,lcc.parent_id
							from ". TABLE_LC_CATEGORIES ." lcc, ". TABLE_LC_CATEGORIES_DESC ." lccd 
							where lcc.parent_id = ".$second_id." 
							and lcc.lc_categories_id = lccd.lc_categories_id 
							and lccd.language_id='" . $_SESSION['languages_id'] . "' 
							and lcc.categories_status=1 
							order by lcc.lc_categories_id desc";
		$second_cate_result = $db->Execute($second_cate_sql);
		if($second_cate_result->RecordCount()>0){
			while (!$second_cate_result->EOF) {
				$sub_image_array = array();
				$sub_image_sql = "select a.article_id ,a.article_images, a.video_image, las.article_steps_images
									from ". TABLE_LC_ARTICLE." a left join ".TABLE_LC_ARTICLE_STEPS." las on (a.article_id = las.article_id)
									where a.categories_path like '%:".$second_cate_result->fields['lc_categories_id'].":%' 
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
				$second_cate_array[] = array("id" => $second_cate_result->fields['lc_categories_id'],
											"pid" => $second_cate_result->fields['parent_id'],
											"name" => $second_cate_result->fields['lc_categories_name'],
											"images" => $images['0']
				);
				$second_cate_result->MoveNext();
			}
		}

	//var_dump($second_cate_array);
	if (empty($second_cate_array)) {
		$second_list_sql = "select a.article_id, a.title_abbreviation ,a.lc_categories_id, a.article_images,a.video_image, a.article_summary, las.article_steps_images
				from ".TABLE_LC_ARTICLE." a left join ".TABLE_LC_ARTICLE_STEPS." las on (a.article_id = las.article_id)
				where a.lc_categories_id = ".$second_id." 	 
				and a.language_id='" . $_SESSION['languages_id'] . "' 
				and a.article_status=1
				group by a.article_id
				order by a.article_id desc
				";

		$second_list_result = $db->Execute($second_list_sql);
		if($second_list_result->RecordCount()>0){
			while (!$second_list_result->EOF) {
				if (!empty($second_list_result->fields['article_images'])) {
						$image = $second_list_result->fields['article_images'];
					}elseif(!empty($second_list_result->fields['article_steps_images'])){
						$image = $second_list_result->fields['article_steps_images'];
					}elseif(!empty($second_list_result->fields['video_image'])){
						$image = $second_list_result->fields['video_image'];
					}else{
						$image = '../includes/templates/cherry_zen/images/'.$_SESSION['language'].'/200X200.png ';
					}
				$second_list_array[] = array("aid" => $second_list_result->fields['article_id'],
									"title" => $second_list_result->fields['title_abbreviation'],
									"cate_id" => $second_list_result->fields['lc_categories_id'],
									"images" => $image,
									"desc" => $second_list_result->fields['article_summary']
				);
			$second_list_result->MoveNext();
			}
		}
	/*echo '<pre>';
	print_r($second_list_array);
	echo '</pre>';*/
	}
	

	require($template->get_template_dir('/tpl_lc_second_list_default.php', DIR_WS_TEMPLATE, $current_page_base, 'templates'). '/tpl_lc_second_list_default.php');

	die();
}

if (isset($_POST['article_id'])) {

	$article_id = $_POST['article_id'];

	$article_sql = "select article_title , article_images, article_summary,title_abbreviation, video_position, video_code, video_position, parts_num, tools_num, material_list,lc_categories_id 
				from ".TABLE_LC_ARTICLE."  
				where article_id = ".$article_id." 	 
				and language_id='" . $_SESSION['languages_id'] . "' 
				and article_status=1 
				order by article_id desc";

	$article_result = $db->Execute($article_sql);
	if($article_result->RecordCount()>0){
		while (!$article_result->EOF) {
			$article_list_array = array("aid" => $article_id,
								"title" => $article_result->fields['article_title'],
								"sub_title" => $article_result->fields['title_abbreviation'],
								"article_images" => $article_result->fields['article_images'],
								"article_summary" => $article_result->fields['article_summary'],
								"video_position" => $article_result->fields['video_position'],
								"video_code" => stripslashes($article_result->fields['video_code']),
								"video_position" => $article_result->fields['video_position'],
								"parts_num" => $article_result->fields['parts_num'],
								"tools_num" => $article_result->fields['tools_num'],
								"material_list" => $article_result->fields['material_list']
			);
			$article_result->MoveNext();
		}
	}
	/*echo '<pre>';
	print_r($article_list_array);
	echo '</pre>';
*/
	$parts_num = explode(',', $article_list_array['parts_num']);
	foreach ($parts_num as $key => $value) {
		$parts_arr[] = "'".$value."'";
	}
	$parts_num1 = implode(',', $parts_arr);

	$tools_num = explode(',', $article_list_array['tools_num']);
	foreach ($tools_num as $key => $value) {
		$tools_arr[] = "'".$value."'";
	}
	$tools_num1 = implode(',', $tools_arr);

	$article_steps_sql = "select article_steps_images, article_steps_summary, article_steps_url
				from ".TABLE_LC_ARTICLE_STEPS."  
				where article_id = ".$article_id."
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
/*	echo '<pre>';
	print_r($article_steps_array);
	echo '</pre>';*/
	
	$parts_num_sql = "select p.products_id
						from ".TABLE_PRODUCTS." p 
						where p.products_model in (".$parts_num1.")
						and p.products_status = 1 ";

	$parts_num_result = $db->Execute($parts_num_sql);
	$product_res1 = array();
	if($parts_num_result->RecordCount()>0){
		while (!$parts_num_result->EOF) {
			$product_res1[] = $parts_num_result->fields['products_id'];
			$parts_num_result->MoveNext();
		}
	}

	$tools_num_sql = "select p.products_id
						from ".TABLE_PRODUCTS." p 
						where p.products_model in (".$tools_num1.")
						and p.products_status = 1";

	$tools_num_result = $db->Execute($tools_num_sql);
	$product_res2 = array();
	if($tools_num_result->RecordCount()>0){
		while (!$tools_num_result->EOF) {
			$product_res2[] = $tools_num_result->fields['products_id'];
			$tools_num_result->MoveNext();
		}
	}

	$path = get_lc_category_path($article_result->fields['lc_categories_id']);
	krsort($path);
	$breadcrumb->add( TEXT_LEARNING_CENTER, zen_href_link('learning_center') );
	foreach($path as $n => $c){
		if(count($path) > 2){ 
			if ($n == '0') {
				$breadcrumb->add($c['name'],'javascript:void(0)" tid='.$c['id'].' class="third_click');
			}elseif ($n == '1') {
				$breadcrumb->add($c['name'],'javascript:void(0)" second_id='.$c['id'].' first_id='.$path['2']['id'].' class="second_click');
			}else{
				$breadcrumb->add($c['name'],'javascript:void(0)" cate_id='.$c['id'].' class="clicktocat');
			}
		}else{
			if ($n == '0') {
				$breadcrumb->add($c['name'],'javascript:void(0)" second_id='.$c['id'].' first_id='.$path['1']['id'].' class="second_click');
			}elseif ($n == '1') {
				$breadcrumb->add($c['name'],'javascript:void(0)" cate_id='.$c['id'].' class="clicktocat');
			}
		}
	}
	$breadcrumb->add(getstrbylength($article_list_array['sub_title'],20));

	require($template->get_template_dir('/tpl_learning_center_details_default.php', DIR_WS_TEMPLATE, $current_page_base, 'templates'). '/tpl_learning_center_details_default.php');

	die();
}

// third list
if (isset($_POST['third_id'])) {

	$third_id = intval($_POST['third_id']);
	$sub_sql = "select  lccd.lc_categories_name, lccd.lc_categories_description 
				from ". TABLE_LC_CATEGORIES ." lcc, ". TABLE_LC_CATEGORIES_DESC ." lccd 
				where lcc.lc_categories_id = ".$third_id." 
				and lcc.lc_categories_id = lccd.lc_categories_id 
				and lccd.language_id='" . $_SESSION['languages_id'] . "' 
				and lcc.categories_status=1 
				order by lcc.lc_categories_id desc";
	$sub_sql_result = $db->Execute($sub_sql);
	if($sub_sql_result->RecordCount()>0){
		while (!$sub_sql_result->EOF) {
			$sub_sql_array = array("name" => $sub_sql_result->fields['lc_categories_name'],
								"desc" => $sub_sql_result->fields['lc_categories_description']
			);
		$sub_sql_result->MoveNext();
		}
	}

	$third_name = $sub_sql_array['name'];
	$third_desc = $sub_sql_array['desc'];

	$path = get_lc_category_path($third_id);
	krsort($path);
	$breadcrumb->add( TEXT_LEARNING_CENTER, zen_href_link('learning_center') );
	foreach($path as $n => $c){
		if ($n == '0') {
			$breadcrumb->add($c['name'],'javascript:void(0)" third_id='.$c['id'].' class="third_click');
		}elseif ($n == '1') {
			$breadcrumb->add($c['name'],'javascript:void(0)" second_id='.$c['id'].' first_id='.$path['2']['id'].' class="second_click');
		}else{
			$breadcrumb->add($c['name'],'javascript:void(0)" cate_id='.$c['id'].' class="clicktocat');
		}
	}
	$first_id = $path['2']['id'];
	$second_id = $path['1']['id'];

	$third_list_sql = "select a.article_id, a.title_abbreviation ,a.lc_categories_id, a.video_image, a.article_images, a.article_summary, las.article_steps_images
			from ".TABLE_LC_ARTICLE." a left join ".TABLE_LC_ARTICLE_STEPS." las on (a.article_id = las.article_id)
			where a.lc_categories_id = ".$third_id." 	 
			and a.language_id='" . $_SESSION['languages_id'] . "' 
			and a.article_status=1
			group by a.article_id
			order by a.article_id desc
				";

	$third_list_result = $db->Execute($third_list_sql);
	if($third_list_result->RecordCount()>0){
		while (!$third_list_result->EOF) {
				if (!empty($third_list_result->fields['article_images'])) {
						$image = $third_list_result->fields['article_images'];
					}elseif(!empty($third_list_result->fields['article_steps_images'])){
						$image = $third_list_result->fields['article_steps_images'];
					}elseif(!empty($third_list_result->fields['video_image'])){
						$image = $third_list_result->fields['video_image'];
					}else{
						$image = '../includes/templates/cherry_zen/images/'.$_SESSION['language'].'/200X200.png ';
					}
			$third_list_array[] = array("aid" => $third_list_result->fields['article_id'],
								"title" => $third_list_result->fields['title_abbreviation'],
								"cate_id" => $third_list_result->fields['lc_categories_id'],
								"images" => $image,
								"desc" => $third_list_result->fields['article_summary']
			);
		$third_list_result->MoveNext();
		}
	}
	/*echo '<pre>';
	print_r($third_list_array);
	echo '</pre>';*/

	

	require($template->get_template_dir('/tpl_lc_third_list_default.php', DIR_WS_TEMPLATE, $current_page_base, 'templates'). '/tpl_lc_third_list_default.php');

	die();
}
$breadcrumb->add( TEXT_LEARNING_CENTER );
?>