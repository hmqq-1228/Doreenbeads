<?php 
	if(!isset($myhref) && !isset($mypara)){
		$myhref = FILENAME_ADVANCED_SEARCH_RESULT;
		$mypara = '&'.zen_get_all_get_params(array('cId'));
		$mypara .= isset($_GET['disp_order']) ? '&disp_order='. $_GET['disp_order'] : '';
	}
	if ($normal_category_list_show && $show_matched_property_listing) {
		$content = '<ul class="typetitle">
		              <li class="cate">' . TEXT_MATCH_CATEGORIES . '</li>
		              <li class="refine hover1">' . TEXT_REFINE_BY_WORDS . '</li>
		            </ul>
					<dl class="sidemenu" style="display:none;">';
	}else{
		$content = '<ul class="typetitle">
		              <li class="cate hover1">' . TEXT_MATCH_CATEGORIES . '</li>
		              <li class="refine">' . TEXT_REFINE_BY_WORDS . '</li>
		            </ul>
					<dl class="sidemenu" style="display: block;">';
	}
	$box_categories_array = $list_category_array[0];
	$sizeof_box_categories_array = sizeof($box_categories_array);
	
	$cIdArray = array();
	if (isset ( $_GET ['cId'] ) && $_GET ['cId'] != 0){
		$cIdArray = zen_get_category_full_path_info ( $_GET ['cId'] );
	}
	
	for ($i=0; $i<$sizeof_box_categories_array; $i++) {
		$para_extra = 'cId=' . $box_categories_array[$i]['id'].$mypara.$propertyGet;
		$link = zen_href_link($myhref, $para_extra);
		$name = $box_categories_array[$i]['name'] . ' <span style="color:#666666">('.$box_categories_array[$i]['count'].')</span>';
		$nextlevel = isset($box_categories_array[$i+1]['level']) ? $box_categories_array[$i+1]['level'] : 0;

		if ($box_categories_array[$i]['level'] == 0){
			$name = $box_categories_array[$i]['name'];
			$dtStyle = ' style="border-top-width: 0px;"';
			$pClass = $aClass = $ulStyle = "";
			if(isset($cIdArray[0]['cId']) && $cIdArray[0]['cId'] == $box_categories_array[$i]['id']){
				$pClass = 'menufirstopen';
				$aClass = 'morehover';
				$ulStyle = 'style="display:block"';
			}else{
				$pClass = 'menufirstclose';
				$aClass = $ulStyle = '';
			}

			$max_len = $_SESSION['languages_id']==3 ? 42 : 22;
			$name_new = '';
			while(strlen($name) > $max_len){
				$pos = strrpos(substr($name, 0, $max_len), ' ');
				if($pos > 0){
					$name_new .= mb_substr($name, 0, $pos)."<br/>";
					$name = mb_substr($name, $pos);
				}else{
					$name_new .= mb_substr($name, 0, $max_len)."<br/>";
					$name = mb_substr($name, $max_len);
				}
			}
			$name_new .= $name;
			$name = $name_new;

			if($nextlevel == 0)
				$content .= '<dt><p><a href="'.$link.'" class="nomore '.$aClass.'">'.$name.'</a></p></dt>';
			else
				$content .= '<dt ' . $dtStyle . '><p class="menufirst '.$pClass.'"><a href="'.$link.'" class="more '.$aClass.'">'.$name.'</a></p><ul class="navmore" '.$ulStyle.'>';
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
