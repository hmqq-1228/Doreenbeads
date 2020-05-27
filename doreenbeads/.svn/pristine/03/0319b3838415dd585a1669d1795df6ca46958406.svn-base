<?php 
require($language_page_directory.'promotion_display_area.php');
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

$page_id = $_GET['page'] ? $_GET['page'] : 1;
$action = trim($_POST['action']);
$languageId=(int)$_SESSION["languages_id"]-1;

$breadcrumb->add(PROMOTION_DISPLAY_AREA);

$display_area_info_array = array();
$promotion_display_area_sql = 'SELECT
									zpda.display_area_id,
									zpda.promotion_id,
									zpda.promotion_type,
									zpdd.display_picture_url,
									zpdd.display_area_description
								FROM ' . TABLE_PROMOTION_DISPLAY_AREA . ' zpda
								INNER JOIN ' . TABLE_PROMOTION_DISPLAY_AREA_DESCRIPTION . ' zpdd ON zpda.display_area_id = zpdd.display_area_id
								WHERE zpdd.languages_id = "' . (int)$_SESSION['languages_id'] . '" and zpda.display_status = 10 order by zpda.display_level desc, zpda.display_area_id desc';

$promotion_display_area_query = $db->Execute($promotion_display_area_sql);

if($promotion_display_area_query->RecordCount() > 0){
	$i = 1;
	while(!$promotion_display_area_query->EOF){
		$promotion_id = $promotion_display_area_query->fields['promotion_id'];
		$promotion_type = $promotion_display_area_query->fields['promotion_type'];
		
		if(in_array($promotion_type, array(10 , 20))){
			$promotion_query = $db->Execute('SELECT zpa.related_promotion_ids, zpd.promotion_area_name FROM ' . TABLE_PROMOTION_AREA . ' zpa inner join ' . TABLE_PROMOTION_AREA_DESCRIPTION . ' zpd on zpa.promotion_area_id = zpd.promotion_area_id WHERE zpa.promotion_area_status = 1 and zpa.promotion_area_id = "' . $promotion_id . '" and zpd.languages_id = "' . $_SESSION['languages_id'] . '"');
			if($promotion_query->RecordCount() > 0){
				$discount_area = str_replace(',', '_', $promotion_query->fields['related_promotion_ids']);
				
				$discount_area_query =$db->Execute('SELECT promotion_id , promotion_start_time , promotion_end_time FROM ' . TABLE_PROMOTION . ' WHERE  promotion_id in (' . strval($promotion_query->fields['related_promotion_ids']) . ') and promotion_start_time < now() and promotion_end_time > now() AND promotion_status = 1');
				if($discount_area_query->RecordCount() > 0){
					$min_datetime = $discount_area_query->fields['promotion_start_time'];
					$max_datetime = $discount_area_query->fields['promotion_end_time'];
					
					while(!$discount_area_query->EOF){
						if(strtotime($min_datetime) > strtotime($discount_area_query->fields['promotion_start_time'])){
							$min_datetime = $discount_area_query->fields['promotion_start_time'];
						}
						
						if(strtotime($max_datetime) < strtotime($discount_area_query->fields['promotion_end_time'])){
							$max_datetime = $discount_area_query->fields['promotion_end_time'];
						}
						$discount_area_query->MoveNext();
					}
					$cate_year = (int)substr($min_datetime , 0 , 4);
					$cate_monthNUM = ((int)substr($min_datetime , 5 , 2)) - 1;
					$cate_day = (int)substr($min_datetime , 8 , 2);
					
					$promotion_time = $time_months[$languageId][$cate_monthNUM] . ' ' . $cate_day . ', ' . $cate_year ;
					
					$cate_year = (int)substr($max_datetime , 0 , 4);
					$cate_monthNUM = ((int)substr($max_datetime , 5 , 2)) - 1;
					$cate_day = (int)substr($max_datetime , 8 , 2);
					
					$promotion_time .= ' - ' . $time_months[$languageId][$cate_monthNUM] . ' ' . $cate_day . ', ' . $cate_year ;
					
					switch ($promotion_type){
						case 10:
							$picture_href = zen_href_link(FILENAME_PROMOTION , 'aId=' . $promotion_id . '&off=' . $discount_area);
							break;
						case 20:
							$picture_href = zen_href_link(FILENAME_PROMOTION_DEALS , 'aId=' . $promotion_id . '&off=' . $discount_area);
							break;
					}
					
					$display_area_info_array[$i] = array(
						'display_area_id' => $promotion_display_area_query->fields['display_area_id'],
						'promotion_id' => $promotion_id,
						'promotion_type' => $promotion_type,
						'discount_area' => $discount_area,
						'picture_url' => $promotion_display_area_query->fields['display_picture_url'],
						'picture_href' => $picture_href,
						'promotion_time' => $promotion_time,
						'area_description' => $promotion_display_area_query->fields['display_area_description'],
						'area_name' => $promotion_query->fields['promotion_area_name']
					);
					$i++;
				}else{
					$promotion_display_area_query->MoveNext();
					continue;
				}
			}else{
				$promotion_display_area_query->MoveNext();
				continue;
			}
		
		}else{
			$dailydeal_info_query = $db->Execute('SELECT zdd.area_name ,  zda.start_date , zda.end_date FROM ' . TABLE_DAILYDEAL_AREA . ' zda inner join ' . TABLE_DAILYDEAL_AREA_DESCRIPTION . ' zdd on zda.dailydeal_area_id = zdd.area_id WHERE zda.dailydeal_area_id = "' . $promotion_id . '" AND zda.area_status = 1 AND zda.start_date < NOW() AND zda.end_date > NOW() and zdd.languages_id = "' . $_SESSION['languages_id'] . '"');
		
			$cate_year = (int)substr($dailydeal_info_query->fields['start_date'] , 0 , 4);
			$cate_monthNUM = ((int)substr($dailydeal_info_query->fields['start_date'] , 5 , 2)) - 1;
			$cate_day = (int)substr($dailydeal_info_query->fields['start_date'] , 8 , 2);
				
			$promotion_time = $time_months[$languageId][$cate_monthNUM] . ' ' . $cate_day . ', ' . $cate_year ;
				
			$cate_year = (int)substr($dailydeal_info_query->fields['end_date'] , 0 , 4);
			$cate_monthNUM = ((int)substr($dailydeal_info_query->fields['end_date'] , 5 , 2)) - 1;
			$cate_day = (int)substr($dailydeal_info_query->fields['end_date'] , 8 , 2);
				
			$promotion_time .= ' - ' . $time_months[$languageId][$cate_monthNUM] . ' ' . $cate_day . ', ' . $cate_year ;
			
			if($dailydeal_info_query->RecordCount() > 0){
				$picture_href = zen_href_link(FILENAME_PROMOTION_PRICE , 'g=' . $promotion_id);
				
				$display_area_info_array[$i] = array(
						'display_area_id' => $promotion_display_area_query->fields['display_area_id'],
						'promotion_id' => $promotion_id,
						'promotion_type' => $promotion_type,
						'picture_url' => $promotion_display_area_query->fields['display_picture_url'],
						'picture_href' => $picture_href,
						'promotion_time' => $promotion_time,
						'area_description' => $promotion_display_area_query->fields['display_area_description'],
						'area_name' => $dailydeal_info_query->fields['area_name']
				);
				$i++;
			}
		}
		
		$promotion_display_area_query->MoveNext();
	}
}
$display_area_data = array_slice($display_area_info_array, ($page_id-1)*MAX_DISPLAY_PAGE_LINKS , MAX_DISPLAY_PAGE_LINKS);
$display_area_num = sizeof($display_area_info_array);
$max_page_num = ceil($display_area_num / MAX_DISPLAY_PAGE_LINKS);

?>