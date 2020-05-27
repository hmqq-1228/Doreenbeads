<?php 
	if($current_page_base == 'promotion'){
		$myhref = FILENAME_PROMOTION;
		$mypara = isset($_GET['off']) ? '&off='. intval($_GET['off']) : '';
	}else if($current_page_base == 'products_common_list'){
		$myhref = FILENAME_PRODUCTS_COMMON_LIST;
		$mypara = '&pn='.$_GET['pn'];
		if($_GET['pn'] == 'matching' || $_GET['pn'] == 'like' || $_GET['pn'] == 'purchased') $mypara .= '&pid='.trim ( $_GET ['pid'] );
	}else{
		$myhref = FILENAME_ADVANCED_SEARCH_RESULT;
		$mypara = '&'.zen_get_all_get_params(array('cId'));
	}

	$content = "";
	$content .= '<dl class="sidemenu"><dd>' . TEXT_MATCH_CATEGORIES . '</dd>';

	$box_categories_array = $list_category_array[0];
	$sizeof_box_categories_array = sizeof($box_categories_array);
	$cIdArray = array();
	if (isset ( $_GET ['cId'] ) && $_GET ['cId'] != 0) $cIdArray = zen_get_category_full_path_info ( $_GET ['cId'] );
	for ($i=0; $i<$sizeof_box_categories_array; $i++) {
		$para_extra = 'cId=' . $box_categories_array[$i]['id'].$mypara;
		$link = zen_href_link($myhref, $para_extra);
		$name = $box_categories_array[$i]['name'].' <span style="color:#666666">('.$box_categories_array[$i]['count'].')</span>';
		$nextlevel = isset($box_categories_array[$i+1]['level']) ? $box_categories_array[$i+1]['level'] : 0;

		if ($box_categories_array[$i]['level'] == 0){
			$name = $box_categories_array[$i]['name'];
			if(isset($cIdArray[0]['cId']) && $cIdArray[0]['cId'] == $box_categories_array[$i]['id']){
				$pClass = 'menufirstopen';
				$aClass = 'morehover';
				$ulStyle = 'style="display:block"';
			}else{
				$pClass = 'menufirstclose';
				$aClass = $ulStyle = '';
			}

			$max_len = 22;
			$name_new = '';
			while(strlen($name) > $max_len){
				$pos = strrpos(substr($name, 0, $max_len), ' ');
				if($pos > 0){
					$name_new .= substr($name, 0, $pos)."<br/>";
					$name = substr($name, $pos);
				}else{
					$name_new .= substr($name, 0, $max_len)."<br/>";
					$name = substr($name, $max_len);
				}
			}
			$name_new .= $name;
			$name = $name_new;

			if($nextlevel == 0)
				$content .= '<dt><p><a href="'.$link.'" class="nomore '.$aClass.'">'.$name.'</a></p></dt>';
			else
				$content .= '<dt><p class="menufirst '.$pClass.'"><a href="'.$link.'" class="more '.$aClass.'">'.$name.'</a></p><ul class="navmore" '.$ulStyle.'>';
		}else if($box_categories_array[$i]['level'] == 1){
			if(isset($cIdArray[1]['cId']) && $cIdArray[1]['cId'] == $box_categories_array[$i]['id'])
				$liClass = 'selectli';
			else
				$liClass = '';

			if($nextlevel == 0)		// 0
				$content .= '<li class="'.$liClass.'"><a href="'.$link.'" class="morelink">'.$name.'</a></li></ul></dt>';
			else if($nextlevel == 1)		// 1
				$content .= '<li class="'.$liClass.'"><a href="'.$link.'" class="morelink">'.$name.'</a></li>';
			else		// 2
				$content .= '<li class="more '.$liClass.'"><a href="'.$link.'" class="morelink">'.$name.'</a><div class="threemore">';
		}else if($box_categories_array[$i]['level'] == 2){
			if($box_categories_array[$i-1]['level'] < 2) $level3count = 0;
			if($level3count > 0 && $level3count % 3 ==0) $content .= '</ul>';
			if($level3count++ % 3 == 0) $content .= '<ul>';

			if(isset($cIdArray[2]['cId']) && $cIdArray[2]['cId'] == $box_categories_array[$i]['id'])
				$liClass = 'class="selectli"';
			else
				$liClass = '';

			$content .= '<li '.$liClass.'><a class="fourmorea" href="'.$link.'">'.$name.'</a>';		// 2
			if($nextlevel == 0)		// 0
				$content .= '</li></ul></div></li></ul></dt>';
			else if($nextlevel == 1)		// 1
				$content .= '</li></ul></div></li>';
			else if($nextlevel == 2)		// 2
				$content .= '</li>';
			else		// 3
				$content .= '';
		}else if($box_categories_array[$i]['level'] == 3){
			if(isset($cIdArray[3]['cId']) && $cIdArray[3]['cId'] == $box_categories_array[$i]['id'])
				$liClass = 'class="selectp"';
			else
				$liClass = '';

			if($current_category_level == 0) $content .= '<p '.$liClass.'><a href="'.$link.'">'.$name.'</a></p>';
			if($nextlevel == 0)		// 0
				$content .= '</li></ul></div></li></ul></dt>';
			else if($nextlevel == 1)		// 1
				$content .= '</li></ul></div></li>';
			else if($nextlevel == 2)		// 2
				$content .= '</li>';
			else		// 3/4
				$content .= '';
		}else if($box_categories_array[$i]['level'] == 4){
			if($nextlevel == 0)		// 0
				$content .= '</li></ul></div></li></ul></dt>';
			else if($nextlevel == 1)		// 1
				$content .= '</li></ul></div></li>';
			else if($nextlevel == 2)		// 2
				$content .= '</li>';
			else		// 3/4
				$content .= '';
		}
	}

	$content .= '</dl>';
	//$content .= '<div class="sidesafe_icon"><a href="http://www.doreenbeads.com/page.html?id=76"><img src="includes/templates/cherry_zen/images/lead_safe.jpg" alt="dorabead safe guarantee"/></a></div>';

	echo $content;
?>
