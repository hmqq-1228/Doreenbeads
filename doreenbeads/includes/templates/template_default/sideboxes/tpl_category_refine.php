<?php 
switch($current_page_base){
	case 'promotion':
  	$content = "";
	if(isset($_GET['cId'])&&$_GET['cId']!=0){
			$content.='<div class="cateDivOn">';
			$content.='<div class="categoryOnTopBg"></div>'; 
					}else{
			$content.='<div class="cateDiv">';
			$content.='<div class="categoryTopBg"></div>'; 			
					}
			$content.='<a href="javascript:void(0)" class="matchCateDiv">'.TEXT_MATCH_CATEGORIES.'</a>';
  	$box_categories_array=$list_category_array[0];
    for ($i=0;$i<sizeof($box_categories_array);$i++) {
	
    switch($box_categories_array[$i]['level']) {
      case 0:
        $new_style = 'firstDiv';
        break;
      case 1:
        $new_style = 'secondDiv';
        break;
      case 2:
        $new_style = 'thirdDiv';
        break;        
      default:
        $new_style = 'subDiv';
      }
		
		$para_extra=isset($_GET['off'])?'cId='.$box_categories_array[$i]['id'].'&off='.(int)($_GET['off']):'cId='.$box_categories_array[$i]['id'];
		if($box_categories_array[$i]['level'] == 1&&$box_categories_array[($i+1)]['level']==2){
			$extra_style=($box_categories_array[$i]['id']==$_GET['cId']||$box_categories_array[$i]['id']==$list_category_array[1])?' select_current_cate':'';
			$content.='<div class="sub_more'.$extra_style.'">';	
			$content.='<a href="'.zen_href_link(FILENAME_PROMOTION, $para_extra).'" title="'.$box_categories_array[$i]['name'].'"  class="'.$new_style.' cate_have_three">'.$box_categories_array[$i]['name'].' ('.$box_categories_array[$i]['count'].')</a>'; 		
		}elseif($box_categories_array[$i]['level'] == 2&&$box_categories_array[($i-1)]['level']!=2){
			$content.='<div class="cate_sub_part">';
			$content.='<a href="'.zen_href_link(FILENAME_PROMOTION, $para_extra).'" title="'.$box_categories_array[$i]['name'].'"  class="'.$new_style.'">'.$box_categories_array[$i]['name'].' ('.$box_categories_array[$i]['count'].')</a>'; 		
		}
		else{
			if($box_categories_array[$i]['level'] ==0){
				$content.='<a href="'.zen_href_link(FILENAME_PROMOTION, $para_extra).'" title="'.$box_categories_array[$i]['name'].'"  class="'.$new_style.'">'.$box_categories_array[$i]['name'].'</a>';
			}elseif($box_categories_array[$i]['level'] ==1&&($box_categories_array[$i]['id']==$_GET['cId']||$box_categories_array[$i]['id']==$list_category_array[1])){
				$content.='<a href="'.zen_href_link(FILENAME_PROMOTION, $para_extra).'" title="'.$box_categories_array[$i]['name'].'"  class="'.$new_style.' selected_category">'.$box_categories_array[$i]['name'].' ('.$box_categories_array[$i]['count'].')</a>';
			}else{
				$content.='<a href="'.zen_href_link(FILENAME_PROMOTION, $para_extra).'" title="'.$box_categories_array[$i]['name'].'"  class="'.$new_style.'">'.$box_categories_array[$i]['name'].' ('.$box_categories_array[$i]['count'].')</a>';
			}								 		
		}
		
        if($box_categories_array[$i]['level'] == 2&&$box_categories_array[($i+1)]['level']!=2){
			$content.='</div></div>';
		}	
  }
  	if(isset($_GET['cId'])&&$_GET['cId']!=0){
  		$content.='<div class="categoryOnBotBg"></div></div>';
  	}else{
  		$content.='<div class="categoryBotBg"></div></div>';
  	}
  	echo $content;
	break;
	default:
}
?>
