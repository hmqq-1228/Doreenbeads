<?php
require($language_page_directory.'promotion_display_area.php');
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

$action = $_GET['action'] != '' ? trim($_GET['action']) : ($_POST['action'] != '' ? trim($_POST['action']) : '');

switch($action){	
	case 'view_more':
		$trends_content = '';
		$offset = $_POST['offset'];
		
		$display_area_info_array = array();
		$display_area_info_array = zen_promotion_display_area_data();
		
		$display_area_data = array_slice($display_area_info_array, $offset , MAX_DISPLAY_PAGE_LINKS);
		
		foreach ($display_area_data as $value){
			$trends_category_img = '<div class="trends_banner"><a href="' . $value['picture_href'] . '"><img src="' . $value['picture_url'] . '" /></a></div>';
			$trends_category_content = '<div class="trends_cont">
			<p class="time"><ins></ins>' . $value['promotion_time'] . '</p>
			<p>' . $value['area_name']  . '</p>
			</div>';
				
			$trends_content .= '<div class="trends_wrapper">' . $trends_category_img . $trends_category_content . '</div>' . '<div class="trends_num" style="display:none;"value="' . (intval($offset)+1) . '"></div>';
			$offset++;
		}
		
		echo $trends_content;
		exit;
		break;
	default:
		$display_area_info_array = array();
		$display_area_info_array = zen_promotion_display_area_data();
		$max_trends = sizeof($display_area_info_array);
		
		$display_area_data = array_slice($display_area_info_array, 0 , MAX_DISPLAY_PAGE_LINKS);
}
$smarty->assign ( 'display_area_data', $display_area_data );
$smarty->assign ( 'max_trends', $max_trends );
?>