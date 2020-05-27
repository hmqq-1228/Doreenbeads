<?php
/**
 * �����ļ������ڿ��������ͼƬ��ʾ
 * 2010-05-03 jessa 
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
$title = '';
$num_categories = $categories->RecordCount();

$row = 0;
$col = 0;
$list_box_contents = '';
if ($num_categories > 0) {
  if ($num_categories < MAX_DISPLAY_CATEGORIES_PER_ROW || MAX_DISPLAY_CATEGORIES_PER_ROW == 0) {
    $col_width = floor(100/$num_categories);
  } else {
    $col_width = floor(100/MAX_DISPLAY_CATEGORIES_PER_ROW);
  }

  while (!$categories->EOF) {
  	$products_count = get_category_info_memcache($categories->fields['categories_id'] , 'products_count');
  	if ($products_count > 0)
  	{
	    if (!$categories->fields['categories_image']) !$categories->fields['categories_image'] = 'pixel_trans.gif';
	    $cPath_new = 'cPath=' . get_category_info_memcache($categories->fields['categories_id'] , 'cPath');
	    $cPath_new = str_replace('=0_', '=', $cPath_new);
		
	    //jessa 2010-09-26 限制一些类别在客户登录可见
	    if ($categories->fields['categories_id'] == '1318'){
	    	if (isset($_SESSION['customer_id']) && zen_not_null($_SESSION['customer_id'])){
	    		$list_box_contents[$row][$col] = array('params' => 'class="categoryListBoxContents"' . ' ' . 'style="width:' . $col_width . '%;"',
	                                           'text' => '<a href="' . zen_href_link(FILENAME_DEFAULT, $cPath_new) . '">' . $categories->fields['categories_name'] . '</a>');
	            $col ++;
			    if ($col > 3) {
			      $col = 0;
			      $row ++;
			    }
	    	}
	    } else {
	    //eof jessa 2010-09-26
		    $list_box_contents[$row][$col] = array('params' => 'class="categoryListBoxContents"' . ' ' . 'style="width:' . $col_width . '%;"',
		                                           'text' => '<a href="' . zen_href_link(FILENAME_DEFAULT, $cPath_new) . '">' . $categories->fields['categories_name'] . '</a>');
		
		    $col ++;
		    if ($col > 3) {
		      $col = 0;
		      $row ++;
		    }
	    }
	}
  	//eof robbie
    $categories->MoveNext();
  }
}
?>

