<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_categories.php 4162 2006-08-17 03:55:02Z ajeh $
 */
  $content = "";
  
  $content .= '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="sideBoxContent">' . "\n";
  for ($i=0;$i<sizeof($box_categories_array);$i++) {
  	//echo $i;
  	//robbie_wei
    //����Ʒ��Ϊ0ʱ������ʾ�����
    $specialCpath=explode("=", $box_categories_array[$i]['path']);
  	$specialPath=explode('_',$specialCpath[1]);
  	if($specialPath[0]=='1670' || $specialPath[0]=='1582' || $specialPath[0]=='1655' || $specialPath[1]=='1666' || $specialPath[1]=='1667' || $specialPath[1]=='1668' || $specialPath[1]=='1669' || $specialPath[0]=='1680') continue;
  	
	if ($box_categories_array[$i]['name'] == ''):continue;
 	endif;
  	//echo $i."<br>";
  	//end robbie
    switch(true) {
// to make a specific category stand out define a new class in the stylesheet example: A.category-holiday
// uncomment the select below and set the cPath=3 to the cPath= your_categories_id
// many variations of this can be done
//      case ($box_categories_array[$i]['path'] == 'cPath=3'):
//        $new_style = 'category-holiday';
//        break;
      case ($box_categories_array[$i]['top'] == 'true'):
        $new_style = 'category-top';
        break;
      case ($box_categories_array[$i]['has_sub_cat']):
        $new_style = 'category-subs';
        break;
      default:
        $new_style = 'category-products';
      }
     if (!(zen_get_product_types_to_category($box_categories_array[$i]['path']) == 3 or ($box_categories_array[$i]['top'] != 'true' and SHOW_CATEGORIES_SUBCATEGORIES_ALWAYS != 1))) {
	  /*jessa 2009-09-21 delete "<a class="' . $new_style . '"" add "<ul class="' . $new_style . '"><li>" and "$content .= '</a></li></ul>';" ��<ul></ul>��ǩ����Ʒ������������������������ʽ��*/
      if ($box_categories_array[$i]['level'] <= 1){
      	
      		$content .= '<ul class="' . $new_style . '"><li><a href="' . zen_href_link(FILENAME_DEFAULT, $box_categories_array[$i]['path']) . '">';
      	
	  

	      if ($box_categories_array[$i]['current']) {
	        if ($box_categories_array[$i]['has_sub_cat']) {
	        	if($box_categories_array[$i]['path']=="cPath=1091"){
	      	   $content.='<table cellpadding=0 cellspacing=0 border=0 width="100%"><tr><td><span class="category-subs-parent">' . $box_categories_array[$i]['name'] . '</span></td><td width=32>'.zen_image("includes/templates/cherry_zen/images/hot.gif").'</td></tr></table>';
	        	}else if($box_categories_array[$i]['path']=="cPath=1665"){
	      	   $content.='<table cellpadding=0 cellspacing=0 border=0 width="100%"><tr><td><span class="category-subs-parent">' . $box_categories_array[$i]['name'] . '</span></td><td width=32>'.zen_image("includes/templates/cherry_zen/images/sale.png").'</td></tr></table>';
	        	}else{
	        		$content .= '<span class="category-subs-parent">' . $box_categories_array[$i]['name'] . '</span>';
	        	}
	          	
	        } else {
	        	if($box_categories_array[$i]['path']=="cPath=1321_1611"||$box_categories_array[$i]['path']=="cPath=1321_1534")
	        	{
	      	   $content.='<table cellpadding=0 cellspacing=0 border=0 width="100%"><tr><td><span class="category-subs-selected">' . $box_categories_array[$i]['name'] . '</span></td><td width=32>'.zen_image("includes/templates/cherry_zen/images/hot.gif").'</td></tr></table>';
	        		
	        	}elseif($box_categories_array[$i]['path']=="cPath=1043_1056"||$box_categories_array[$i]['path']=="cPath=1043_1051"){
	      	   $content.='<table cellpadding=0 cellspacing=0 border=0 width="100%"><tr><td><span class="category-subs-selected">' . $box_categories_array[$i]['name'] . '</span></td><td width=35>'.zen_image("includes/templates/cherry_zen/images/new.gif").'</td></tr></table>';
	        	}else{
	        	$content .= '<span class="category-subs-selected">' . $box_categories_array[$i]['name'] . '</span>';	
	        	}
	        }
	      } else {
	      	   if($box_categories_array[$i]['path']=="cPath=1045"||$box_categories_array[$i]['path']=="cPath=1044_1081"){
	      	   $content.='<table cellpadding=0 cellspacing=0 border=0 width="100%"><tr><td>'.$box_categories_array[$i]['name'].'</td><td width=32>'.zen_image("includes/templates/cherry_zen/images/hot.gif").'</td></tr></table>';
	      	   }elseif($box_categories_array[$i]['path']=="cPath=1043_1056"||$box_categories_array[$i]['path']=="cPath=1043_1051"){
	      	   $content.='<table cellpadding=0 cellspacing=0 border=0 width="100%"><tr><td>'.$box_categories_array[$i]['name'].'</td><td width=35>'.zen_image("includes/templates/cherry_zen/images/new.gif").'</td></tr></table>';
	      	   }elseif($box_categories_array[$i]['path']=="cPath=1630"){
				   	$content.='<table cellpadding=0 cellspacing=0 border=0 width="100%"><tr><td>'.$box_categories_array[$i]['name'].'</td><td width=32>'.zen_image("includes/templates/cherry_zen/images/sale.png").'</td></tr></table>';
			   }else{
	      	   	$content .= $box_categories_array[$i]['name'];
	      	   }
	        	
	      }
	
	      if ($box_categories_array[$i]['has_sub_cat']) {
	        //$content .= CATEGORIES_SEPARATOR;
	      }
		  
	/*jessa 2009-12-27 ע�͵�������Ĳ�Ʒ������ʾ
	      if (SHOW_COUNTS == 'true') {
	        if ((CATEGORIES_COUNT_ZERO == '1' and $box_categories_array[$i]['count'] == 0) or $box_categories_array[$i]['count'] >= 1) {
	          $content .= CATEGORIES_COUNT_PREFIX . $box_categories_array[$i]['count'] . CATEGORIES_COUNT_SUFFIX;
	        }
	      }
	eof jessa 2009-12-27*/	
      	 // if($box_categories_array[$i]['path']=="cPath=1560"){
      	  //	$content .= '</a>'.zen_image("includes/templates/cherry_zen/images/hot.gif",'','','','style="margin-right:10px;padding-bottom:2px;float:right;"').'</li></ul>';
      		
      	 // }else{
      	  	$content .= '</a></li></ul>';
      	  //}
		  
	      $content .= "\n";
      }
    }
  }
//eof jessa 2009-09-21
//����ʾ�ڲ�Ʒ����Ĳ�Ʒ��Ŀ�����������У�ʹ����ʾ��ʽ������?

  if (SHOW_CATEGORIES_BOX_SPECIALS == 'true' or SHOW_CATEGORIES_BOX_PRODUCTS_NEW == 'true' or SHOW_CATEGORIES_BOX_FEATURED_PRODUCTS == 'true' or SHOW_CATEGORIES_BOX_PRODUCTS_ALL == 'true') {
// display a separator between categories and links
    if (SHOW_CATEGORIES_SEPARATOR_LINK == '1') {
      $content .= '<hr id="catBoxDivider" />' . "\n";
    }
    if (SHOW_CATEGORIES_BOX_SPECIALS == 'true') {
      $show_this = $db->Execute("select s.products_id from " . TABLE_SPECIALS . " s where s.status= 1 limit 1");
      if ($show_this->RecordCount() > 0) {
        $content .= '<a class="category-links" href="' . zen_href_link(FILENAME_SPECIALS) . '">' . CATEGORIES_BOX_HEADING_SPECIALS . '</a>' . '<br />' . "\n";
      }
    }
	
	//jessa 2009-12-21 ���bestsellers������
	include_once(DIR_WS_FUNCTIONS . 'functions_customers.php');
	if (!$_SESSION['has_valid_order']) $_SESSION['has_valid_order'] = zen_customer_has_valid_order();
 
	if ($_SESSION['has_valid_order'])
		$content .= '<a class="category-links" href="index.php?main_page=products_all&disp_order=9">Bestsellers ...</a><br />';
	//eof jessa 2009-12-21
	
    if (SHOW_CATEGORIES_BOX_PRODUCTS_NEW == 'true') {
      // display limits
//      $display_limit = zen_get_products_new_timelimit();
      $display_limit = zen_get_new_date_range();

      $show_this = $db->Execute("select p.products_id
                                 from " . TABLE_PRODUCTS . " p
                                 where p.products_status = 1 " . $display_limit . " limit 1");
      if ($show_this->RecordCount() > 0) {
        $content .= '<a class="category-links" href="' . zen_href_link(FILENAME_PRODUCTS_NEW) . '">' . CATEGORIES_BOX_HEADING_WHATS_NEW . '</a>' . '<br />' . "\n";
      }
    }

    if (SHOW_CATEGORIES_BOX_FEATURED_PRODUCTS == 'true') {
      $show_this = $db->Execute("select products_id from " . TABLE_FEATURED . " where status= 1 limit 1");
      if ($show_this->RecordCount() > 0) {
        $content .= '<a class="category-links" href="' . zen_href_link(FILENAME_FEATURED_PRODUCTS) . '">' . CATEGORIES_BOX_HEADING_FEATURED_PRODUCTS . '</a>' . '<br />' . "\n";
      }
    }
    
    if (SHOW_CATEGORIES_BOX_PRODUCTS_ALL == 'true') {
      $content .= '<a class="category-links" href="' . zen_href_link(FILENAME_PRODUCTS_ALL) . '">' . CATEGORIES_BOX_HEADING_PRODUCTS_ALL . '</a>' . "\n";
    }
  }
  $content .= '</div>';
?>