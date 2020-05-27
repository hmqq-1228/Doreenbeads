<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
//  Original contrib by Vijay Immanuel for osCommerce, converted to zen by dave@open-operations.com - http://www.open-operations.com
//  $Id: links_manager.php 2006-12-22 Clyde Jones
//
?>
<div id="link_exchange">
<?php
   if ($display_mode == 'categories') {
  	$static_submit_link = HTTP_SERVER . DIR_WS_CATALOG . 'links-exchange-submit-your-site.html';
?>
  


 <br class="clearBoth" />

<?php if (DEFINE_LINKS_STATUS >= '1' and DEFINE_LINKS_STATUS <= '2') { ?>

<?php require($define_page); ?>

<?php } ?> 
<div id="link_submit_site">
 <?php echo '<a href="' . $static_submit_link . '">' . TEXT_SUBMIT_YOUR_SITE . '</a>'; ?>
</div>
<br class="clearBoth" />     
<div id="links_cate">
<table width="100%">
<?php
    $categories_query = $db->Execute("select lc.link_categories_id, lcd.link_categories_name, lcd.link_categories_description, lc.link_categories_image from " . TABLE_LINK_CATEGORIES . " lc, " . TABLE_LINK_CATEGORIES_DESCRIPTION . " lcd where lc.link_categories_id = lcd.link_categories_id and lc.link_categories_status = '1' and lcd.language_id = '" . (int)$_SESSION['languages_id'] . "' order by lc.link_categories_sort_order");
  if ($categories_query->RecordCount() > 0) {
      $rows = 0;
 while (!$categories_query->EOF) {
      $rows++;
      $lPath_new = 'lPath=' . $categories_query->fields['link_categories_id'];
      $links_count = $db->Execute("select count(ls.links_id) as link_amount from " . TABLE_LINKS . " ls, " . TABLE_LINKS_TO_LINK_CATEGORIES . " ltc where ls.links_id = ltc.links_id and ls.links_status = '2' and ltc.link_categories_id=".$categories_query->fields['link_categories_id']);
      $width = (int)(100 / MAX_LINK_CATEGORIES_ROW) . '%';
      $newrow = false;
      if ((($rows / MAX_LINK_CATEGORIES_ROW) == floor($rows / MAX_LINK_CATEGORIES_ROW)) && ($rows != $number_of_categories))
      {
        $newrow = true;
      }
	  //robbie wei
      $link_url = HTTP_SERVER . DIR_WS_CATALOG .'links-exchange-'. $categories_query->fields['link_categories_name'] . '-l-' . $categories_query->fields['link_categories_id'] . '.html';
      $link_url = str_replace(' ', '-', $link_url);
	  $link_url = str_replace('"', '-', $link_url);
?>

<?php /*
<div class="linkstext"><a href="<?php echo $link_url; ?>">
       <?php if (zen_not_null($categories_query->fields['link_categories_image'])) {
          echo zen_links_image(DIR_WS_IMAGES . $categories_query->fields['link_categories_image'], $categories_query->fields['link_categories_name'], SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT,$lPath_new) . '<br />';
        } else {
          echo zen_image(DIR_WS_IMAGES . 'pixel_trans.gif', $categories_query->fields['link_categories_name'], SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT,$lPath_new) . '<br />';
        } ?><br /><?php echo $categories_query->fields['link_categories_name']; ?></a></div>
*/
if($rows%MAX_LINK_CATEGORIES_ROW==1) echo "<tr>";
echo '<td align="left" width="'.$width.'"><a href="' . $link_url . '">'.$categories_query->fields['link_categories_name']."(".$links_count->fields['link_amount'].")".'</a></td>';
//echo '<td align="left" width="'.$width.'"><a href="' . zen_href_link(FILENAME_LINKS, $lPath_new) . '">'.$categories_query->fields['link_categories_name']."(".$links_count->fields['link_amount'].")".'</a></td>';	
if($rows%MAX_LINK_CATEGORIES_ROW==0) echo "</tr>";
?>


<?php
  if ($newrow) {
?>
<?php 
	    }
       	 $categories_query->MoveNext();
      }
    } else {
?>
            <?php echo TEXT_NO_CATEGORIES; ?>
<?php
    }
?>
<tr><td>&nbsp;</td></tr> 
 </table>
</div>
 <div id="link_submit_site">
 <?php echo '<a href="' . $static_submit_link. '">' .TEXT_SUBMIT_YOUR_SITE . '</a>'; ?>
 </div>       
<?php
  } elseif ($display_mode == 'links') {
  	
  	$static_submit_link = HTTP_SERVER . DIR_WS_CATALOG . 'links-exchange-submit-your-site-ls-'.$lPath.'.html';
// create column list
    $define_list = array('LINK_LIST_IMAGE' => LINK_LIST_IMAGE,
                        'LINK_LIST_DESCRIPTION' => LINK_LIST_DESCRIPTION, 
                         'LINK_LIST_COUNT' => LINK_LIST_COUNT);
	//$define_list = array('LINK_LIST_DESCRIPTION' => LINK_LIST_DESCRIPTION);
    asort($define_list);

    $column_list = array();
    reset($define_list);
    while (list($key, $value) = each($define_list)) {
      if ($value > 0) $column_list[] = $key;
    }

    $select_column_list = '';

    for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
      switch ($column_list[$i]) {
        case 'LINK_LIST_IMAGE':
          $select_column_list .= 'l.links_image_url, ld.links_title, ';
          break;
        case 'LINK_LIST_DESCRIPTION':
          $select_column_list .= 'ld.links_description, ';
          break;
        case 'LINK_LIST_COUNT':
          $select_column_list .= 'l.links_clicked, ';
          break;
      }
    }

// check sort order
//$sortorder = "ld.links_title";	
if (DEFINE_SORT_ORDER == 1) $sortorder = "ld.links_title"; 
if (DEFINE_SORT_ORDER == 2) $sortorder = "l.links_date_added desc"; 
if (DEFINE_SORT_ORDER == 3) $sortorder = "l.links_clicked desc"; 

// show the links in a given category

	$categories_info = $db->Execute("select lcd.link_categories_name, lcd.link_categories_description, lc.link_categories_image from " . TABLE_LINK_CATEGORIES . " lc, " . TABLE_LINK_CATEGORIES_DESCRIPTION . " lcd where lc.link_categories_id = lcd.link_categories_id and lc.link_categories_id = '".(int)$current_category_id."' and lcd.language_id = '" . (int)$_SESSION['languages_id'] . "'");

    $listing_sql = "select " . $select_column_list . " l.links_id from " . TABLE_LINKS_DESCRIPTION . " ld, " . TABLE_LINKS . " l, " 
    	. TABLE_LINKS_TO_LINK_CATEGORIES . " l2lc where l.links_status = '2' and l.links_id = l2lc.links_id and ld.links_id = l2lc.links_id   
    	    and l2lc.link_categories_id = '" . (int)$current_category_id . "'" . "order by $sortorder";

?>
 <div class="centerColumn" id="ezPageDefault">
    
<p style="font-size:30px;color:#b24ba8;text-align:center;font-family: Arial,Helvetica,sans-serif;"><?php  echo $categories_info->fields['link_categories_name'];?></p>

<p>&nbsp;</p>     
<div id="link_submit_site">
 <?php echo '<a href="' . $static_submit_link . '">' . TEXT_SUBMIT_YOUR_SITE . '</a>'; ?>
</div> 
<p>&nbsp;</p> 
<?php include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_LINK_LISTING)); ?>
       
     <br class="clearBoth" />     
     <div class="forward"><?php //echo '<a href="' . zen_href_link(FILENAME_LINKS_SUBMIT, zen_get_all_get_params()) . '">' . zen_image_button(BUTTON_IMAGE_SUBMIT_LINK, BUTTON_SUBMIT_LINK_ALT) . '</a>'; ?>
     </div>
     
     <div class="buttonRow back">
     <?php echo "<a href='links-exchange-jewelry-directory.html'>".zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) .'</a>'; ?>
     </div>   
     <br class="clearBoth" />
</div>            
<?php
  }
?>
</div>