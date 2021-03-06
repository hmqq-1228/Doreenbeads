<?php
/**
 * @package admin
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: product.php 6131 2007-04-08 06:56:51Z drbyte $
 */

  require('includes/application_top.php');
  //include_once (DIR_FS_CATALOG . DIR_WS_CLASSES . 'language.php');
  require(DIR_WS_MODULES . 'prod_cat_header_code.php');
  
  //jessa 2010-01-29 ���������ļ����ں�����Ҫʹ���ļ��еĺ���  
  require(DIR_WS_FUNCTIONS . 'function_discount.php');
  require(DIR_WS_FUNCTIONS . 'functions_promotion.php');
  require ('includes/fckeditor_php5.php');
  //eof jessa 2010-01-29

  $action = (isset($_GET['action']) ? $_GET['action'] : '');
    // Ultimate SEO URLs v2.100
	// If the action will affect the cache entries
	if (preg_match("/(insert|update|setflag)/i", $action)) {
		include_once(DIR_WS_INCLUDES . 'reset_seo_cache.php');
	}
	
  if (zen_not_null($action)) {
    switch ($action) {
      case 'delete':
        require_once (DIR_FS_CATALOG . DIR_WS_CLASSES . 'language.php');
	      $is_delete = intval($_GET['is_delete']);
	  	  $operate_content='';
		   if($is_delete === 1){
				$db->Execute("update  ".TABLE_PRODUCTS." set products_status=10, products_limit_stock=1 where products_id = ".$_GET['pID']." ");
				update_products_quantity(array('products_id'=>$_GET['pID'], 'products_quantity'=>0));
				$operate_content='商品被编辑,商品状态:删除(点击按钮)';
		   }elseif($is_delete === 0){
				$db->Execute("update  ".TABLE_PRODUCTS." set products_status=0, products_limit_stock=1 where products_id = ".$_GET['pID']." ");
				update_products_quantity(array('products_id'=>$_GET['pID'], 'products_quantity'=>0));
				$operate_content='商品被编辑,商品状态:下架(点击按钮)';
		   }
		   remove_product_memcache($_GET['pID']);
		   
		   
	       zen_insert_operate_logs($_SESSION['admin_id'],$_GET['pID'],$operate_content,2);
	       
		   zen_redirect(zen_href_link(FILENAME_PRODUCT,zen_get_all_get_params(array('action', 'is_delete')) . '&action=new_product'));
		   break;
	   
      case 'setflag':
        if ( ($_GET['flag'] == '0') || ($_GET['flag'] == '1') ) {
          if (isset($_GET['pID'])) {
            zen_set_product_status($_GET['pID'], $_GET['flag']);
          }
        }

        zen_redirect(zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $_GET['cPath'] . '&pID=' . $_GET['pID'] . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')));
        break;

      case 'delete_product_confirm':
      $delete_linked = 'true';
      if ($_POST['delete_linked'] == 'delete_linked_no') {
        $delete_linked = 'false';
      } else {
        $delete_linked = 'true';
      }
      $product_type = zen_get_products_type($_POST['products_id']);
        if (file_exists(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/delete_product_confirm.php')) {
          require(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/delete_product_confirm.php');
         } else {
          require(DIR_WS_MODULES . 'delete_product_confirm.php');
         }
        break;
      case 'move_product_confirm':
        if (file_exists(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/move_product_confirm.php')) {
          require(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/move_product_confirm.php');
         } else {
          require(DIR_WS_MODULES . 'move_product_confirm.php');
         }
        break;
      case 'insert_product_meta_tags':
      case 'update_product_meta_tags':
        if (file_exists(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/update_product_meta_tags.php')) {
          require(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/update_product_meta_tags.php');
         } else {
          require(DIR_WS_MODULES . 'update_product_meta_tags.php');
         }
        break;
      case 'insert_product':
      case 'update_product':
        if (file_exists(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/update_product.php')) {
          require(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/update_product.php');
         } else {
          require(DIR_WS_MODULES . 'update_product.php');
         }
        break;
      case 'copy_to_confirm':
        if (file_exists(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/copy_to_confirm.php')) {
          require(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/copy_to_confirm.php');
         } else {
          require(DIR_WS_MODULES . 'copy_to_confirm.php');
         }
        break;
      case 'new_product_preview_meta_tags':
        if (file_exists(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/new_product_preview_meta_tags.php')) {
          require(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/new_product_preview_meta_tags.php');
         } else {
          require(DIR_WS_MODULES . 'new_product_preview_meta_tags.php');
         }
        break;
      case 'new_product_preview':
        if (file_exists(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/new_product_preview.php')) {
          require(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/new_product_preview.php');
         } else {
          require(DIR_WS_MODULES . 'new_product_preview.php');
         }
        break;
      case 'copy_all_to':      	
      if (file_exists(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/copy_to_confirm.php')) {
          require(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/copy_to_confirm.php');     
         } else {
   //var_dump($_POST['productcheckbox']);
          require(DIR_WS_MODULES . 'copy_to_confirm.php');        
         }
      	break;

      case 'move_All_product_confirm':
    
        if (file_exists(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/move_product_confirm.php')) {
          require(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/move_product_confirm.php');
         } else {
          require(DIR_WS_MODULES . 'move_product_confirm.php');
         }
         break;
      case 'disable_All_product_confirm':  
        if (file_exists(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/disable_product_confirm.php')) {
          require(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/disable_product_confirm.php');
         } else {
          require(DIR_WS_MODULES . 'disable_product_confirm.php');
         }
         break;
		    case 'list_All_product_confirm':
    
        if (file_exists(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/link_product_confirm.php')) {

          require(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/link_product_confirm.php');

         } else {

          require(DIR_WS_MODULES . 'link_product_confirm.php');

         }
         break;
     case 'unlist_All_product_confirm':
    
        if (file_exists(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/link_product_confirm.php')) {

          require(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/link_product_confirm.php');

         } else {
		  $ifUnLink=1;
          require(DIR_WS_MODULES . 'link_product_confirm.php');

         }
         break;
    }
  }

// check if the catalog image directory exists
  if (is_dir(DIR_FS_CATALOG_IMAGES)) {
    if (!is_writeable(DIR_FS_CATALOG_IMAGES)) $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE, 'error');
  } else {
    $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST, 'error');
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
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
if (typeof _editor_url == "string") HTMLArea.replaceAll();
 }
 // -->
  
</script>
<?php if ($action != 'new_product_meta_tags' && $editor_handler != '') include ($editor_handler); ?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onLoad="init()">
<div id="spiffycalendar" class="text"></div>
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<!-- body_text //-->
    <td width="100%" valign="top">
<?php
  if ($action == 'new_product' or $action == 'new_product_meta_tags') {

    if ($action == 'new_product_meta_tags') {
      require(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/collect_info_metatags.php');
    } else {
      require(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/collect_info.php');
    }

  } elseif ($action == 'new_product_preview' or $action == 'new_product_preview_meta_tags') {
    if ($action == 'new_product_preview_meta_tags') {
      require(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/preview_info_meta_tags.php');
    } else {
      require(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/preview_info.php');
    }

  } else {

  require(DIR_WS_MODULES . 'category_product_listing.php');

    $heading = array();
    $contents = array();
    switch ($action) {
      case 'new_category':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_CATEGORY . '</b>');

        $contents = array('form' => zen_draw_form('newcategory', FILENAME_CATEGORIES, 'action=insert_category&cPath=' . $cPath, 'post', 'enctype="multipart/form-data"'));
        $contents[] = array('text' => TEXT_NEW_CATEGORY_INTRO);

        $category_inputs_string = '';
        $languages = zen_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $category_inputs_string .= '<br />' . zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . zen_draw_input_field('categories_name[' . $languages[$i]['id'] . ']', '', zen_set_field_length(TABLE_CATEGORIES_DESCRIPTION, 'categories_name'));
        }

        $contents[] = array('text' => '<br />' . TEXT_CATEGORIES_NAME . $category_inputs_string);
        $contents[] = array('text' => '<br />' . TEXT_CATEGORIES_IMAGE . '<br />' . zen_draw_file_field('categories_image'));

        $dir = @dir(DIR_FS_CATALOG_IMAGES);
        $dir_info[] = array('id' => '', 'text' => "Main Directory");
        while ($file = $dir->read()) {
          if (is_dir(DIR_FS_CATALOG_IMAGES . $file) && strtoupper($file) != 'CVS' && $file != "." && $file != "..") {
            $dir_info[] = array('id' => $file . '/', 'text' => $file);
          }
        }
        $dir->close();

        $default_directory = substr( $cInfo->categories_image, 0,strpos( $cInfo->categories_image, '/')+1);
        $contents[] = array('text' => TEXT_CATEGORIES_IMAGE_DIR . ' ' . zen_draw_pull_down_menu('img_dir', $dir_info, $default_directory));

        $contents[] = array('text' => '<br />' . TEXT_SORT_ORDER . '<br />' . zen_draw_input_field('sort_order', '', 'size="4"'));
		$contents[] = array('text' => '<br />' . 'Categories Level:' . '<br />' . zen_draw_input_field('categories_level', '', 'size="4"'));
        $contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      case 'edit_category':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_CATEGORY . '</b>');

        $contents = array('form' => zen_draw_form('categories', FILENAME_CATEGORIES, 'action=update_category&cPath=' . $cPath, 'post', 'enctype="multipart/form-data"') . zen_draw_hidden_field('categories_id', $cInfo->categories_id));
        $contents[] = array('text' => TEXT_EDIT_INTRO);

        $category_inputs_string = '';
        $languages = zen_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $category_inputs_string .= '<br />' . zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . zen_draw_input_field('categories_name[' . $languages[$i]['id'] . ']', zen_get_category_name($cInfo->categories_id, $languages[$i]['id']), zen_set_field_length(TABLE_CATEGORIES_DESCRIPTION, 'categories_name'));
        }
        $contents[] = array('text' => '<br />' . TEXT_EDIT_CATEGORIES_NAME . $category_inputs_string);
        $contents[] = array('text' => '<br />' . TEXT_EDIT_CATEGORIES_IMAGE . '<br />' . zen_draw_file_field('categories_image'));

        $dir = @dir(DIR_FS_CATALOG_IMAGES);
        $dir_info[] = array('id' => '', 'text' => "Main Directory");
        while ($file = $dir->read()) {
          if (is_dir(DIR_FS_CATALOG_IMAGES . $file) && strtoupper($file) != 'CVS' && $file != "." && $file != "..") {
            $dir_info[] = array('id' => $file . '/', 'text' => $file);
          }
        }
        $dir->close();

        $default_directory = substr( $cInfo->categories_image, 0,strpos( $cInfo->categories_image, '/')+1);
        $contents[] = array('text' => TEXT_CATEGORIES_IMAGE_DIR . ' ' . zen_draw_pull_down_menu('img_dir', $dir_info, $default_directory));
        $contents[] = array('text' => '<br>' . zen_info_image($cInfo->categories_image, $cInfo->categories_name));
        $contents[] = array('text' => '<br>' . $cInfo->categories_image);

        $contents[] = array('text' => '<br />' . TEXT_EDIT_SORT_ORDER . '<br />' . zen_draw_input_field('sort_order', $cInfo->sort_order, 'size="2"'));
		$contents[] = array('text' => '<br />' . 'Categories Level:' . '<br />' . zen_draw_input_field('categories_level', '', 'size="4"'));
        $contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      case 'delete_product':
        if (file_exists(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/sidebox_delete_product.php')) {
          require(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/sidebox_delete_product.php');
         } else {
          require(DIR_WS_MODULES . 'sidebox_delete_product.php');
         }
        break;
      case 'move_product':
        if (file_exists(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/sidebox_move_product.php')) {
          require(DIR_WS_MODULES . $zc_products->get_handler($product_type) . '/sidebox_move_product.php');
         } else {
          require(DIR_WS_MODULES . 'sidebox_move_product.php');
         }
        break;
      case 'copy_to':
        $copy_attributes_delete_first = '0';
        $copy_attributes_duplicates_skipped = '0';
        $copy_attributes_duplicates_overwrite = '0';
        $copy_attributes_include_downloads = '1';
        $copy_attributes_include_filename = '1';

        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_COPY_TO . '</b>');
// WebMakers.com Added: Split Page
        if (empty($pInfo->products_id)) {
          $pInfo->products_id= $pID;
        }

        $contents = array('form' => zen_draw_form('copy_to', $type_admin_handler, 'action=copy_to_confirm&cPath=' . $cPath . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')) . zen_draw_hidden_field('products_id', $pInfo->products_id));
        $contents[] = array('text' => TEXT_INFO_COPY_TO_INTRO);
        $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENT_PRODUCT . '<br /><b>' . $pInfo->products_name  . ' ID#' . $pInfo->products_id . '</b>');
        $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENT_CATEGORIES . '<br /><b>' . zen_output_generated_category_path($pInfo->products_id, 'product') . '</b>');
        $contents[] = array('text' => '<br />' . TEXT_CATEGORIES . '<br />' . zen_draw_pull_down_menu('categories_id', zen_get_category_tree(), $current_category_id));
        $contents[] = array('text' => '<br />' . TEXT_HOW_TO_COPY . '<br />' . zen_draw_radio_field('copy_as', 'link', true) . ' ' . TEXT_COPY_AS_LINK . '<br />' . zen_draw_radio_field('copy_as', 'duplicate') . ' ' . TEXT_COPY_AS_DUPLICATE);

        $contents[] = array('text' => '<br />' . zen_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','3'));

        // only ask about attributes if they exist
        if (zen_has_product_attributes($pInfo->products_id, 'false')) {
          $contents[] = array('text' => '<br />' . TEXT_COPY_ATTRIBUTES_ONLY);
          $contents[] = array('text' => '<br />' . TEXT_COPY_ATTRIBUTES . '<br />' . zen_draw_radio_field('copy_attributes', 'copy_attributes_yes', true) . ' ' . TEXT_COPY_ATTRIBUTES_YES . '<br />' . zen_draw_radio_field('copy_attributes', 'copy_attributes_no') . ' ' . TEXT_COPY_ATTRIBUTES_NO);
// future          $contents[] = array('align' => 'center', 'text' => '<br />' . ATTRIBUTES_NAMES_HELPER . '<br />' . zen_draw_separator('pixel_trans.gif', '1', '10'));
          $contents[] = array('text' => '<br />' . zen_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','3'));
        }

        // only ask if product has discounts
        if (zen_has_product_discounts($pInfo->products_id) == 'true') {
          $contents[] = array('text' => '<br />' . TEXT_COPY_DISCOUNTS_ONLY);
          $contents[] = array('text' => '<br />' . TEXT_COPY_DISCOUNTS . '<br />' . zen_draw_radio_field('copy_discounts', 'copy_discounts_yes', true) . ' ' . TEXT_COPY_DISCOUNTS_YES . '<br />' . zen_draw_radio_field('copy_discounts', 'copy_discounts_no') . ' ' . TEXT_COPY_DISCOUNTS_NO);
          $contents[] = array('text' => '<br />' . zen_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','3'));
        } else {
          $contents[] = array('text' => '<br />' . 'NO DISCOUNTS');
        }

        $contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_copy.gif', IMAGE_COPY) . ' <a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        $contents[] = array('text' => '</form>');

        $contents[] = array('text' => '<br />' . zen_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','3'));
        $contents[] = array('text' => '<form action="' . FILENAME_PRODUCTS_TO_CATEGORIES . '.php' . '?products_filter=' . $pInfo->products_id . '" method="post">');
        $contents[] = array('align' => 'center', 'text' => '<input type="submit" value="' . BUTTON_PRODUCTS_TO_CATEGORIES . '"></form>');

        break;
// attribute features
    case 'attribute_features':
        $copy_attributes_delete_first = '0';
        $copy_attributes_duplicates_skipped = '0';
        $copy_attributes_duplicates_overwrite = '0';
        $copy_attributes_include_downloads = '1';
        $copy_attributes_include_filename = '1';
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_ATTRIBUTE_FEATURES . $pInfo->products_id . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<br />' . '<strong>' . TEXT_PRODUCTS_ATTRIBUTES_INFO . '</strong>' . '<br />');

        $contents[] = array('align' => 'center', 'text' => '<br />' . '<strong>' . zen_get_products_name($pInfo->products_id, $languages_id) . ' ID# ' . $pInfo->products_id . '</strong><br /><br />' .
                                                           '<a href="' . zen_href_link(FILENAME_ATTRIBUTES_CONTROLLER, '&action=attributes_preview' . '&products_filter=' . $pInfo->products_id) . '">' . zen_image_button('button_preview.gif', IMAGE_PREVIEW) . '</a>' .
                                                           '&nbsp;&nbsp;' . '<a href="' . zen_href_link(FILENAME_ATTRIBUTES_CONTROLLER, 'products_filter=' . $pInfo->products_id) . '">' . zen_image_button('button_edit_attribs.gif', IMAGE_EDIT_ATTRIBUTES) . '</a>' .
                                                           '<br /><br />');
        $contents[] = array('align' => 'left', 'text' => '<br />' . '<strong>' . TEXT_PRODUCT_ATTRIBUTES_DOWNLOADS . '</strong>' . zen_has_product_attributes_downloads($pInfo->products_id) . zen_has_product_attributes_downloads($pInfo->products_id, true));
        $contents[] = array('align' => 'left', 'text' => '<br />' . TEXT_INFO_ATTRIBUTES_FEATURES_DELETE . '<strong>' . zen_get_products_name($pInfo->products_id) . ' ID# ' . $pInfo->products_id . '</strong><br /><a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=delete_attributes' . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '') . '&products_id=' . $pInfo->products_id) . '">' . zen_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
        $contents[] = array('align' => 'left', 'text' => '<br />' . TEXT_INFO_ATTRIBUTES_FEATURES_UPDATES . '<strong>' . zen_get_products_name($pInfo->products_id, $languages_id) . ' ID# ' . $pInfo->products_id . '</strong><br /><a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=update_attributes_sort_order' . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '') . '&products_id=' . $pInfo->products_id) . '">' . zen_image_button('button_update.gif', IMAGE_UPDATE) . '</a>');
        $contents[] = array('align' => 'left', 'text' => '<br />' . TEXT_INFO_ATTRIBUTES_FEATURES_COPY_TO_PRODUCT . '<strong>' . zen_get_products_name($pInfo->products_id, $languages_id) . ' ID# ' . $pInfo->products_id . '</strong><br /><a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=attribute_features_copy_to_product' . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '') . '&products_id=' . $pInfo->products_id) . '">' . zen_image_button('button_copy_to.gif', IMAGE_COPY_TO) . '</a>');
        $contents[] = array('align' => 'left', 'text' => '<br />' . TEXT_INFO_ATTRIBUTES_FEATURES_COPY_TO_CATEGORY . '<strong>' . zen_get_products_name($pInfo->products_id, $languages_id) . ' ID# ' . $pInfo->products_id . '</strong><br /><a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=attribute_features_copy_to_category' . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '') . '&products_id=' . $pInfo->products_id) . '">' . zen_image_button('button_copy_to.gif', IMAGE_COPY_TO) . '</a>');

        $contents[] = array('align' => 'center', 'text' => '<br /><a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;

// attribute copier to product
    case 'attribute_features_copy_to_product':
      $_GET['products_update_id'] = '';
      // excluded current product from the pull down menu of products
      $products_exclude_array = array();
      $products_exclude_array[] = $pInfo->products_id;

      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_ATTRIBUTE_FEATURES . $pInfo->products_id . '</b>');
      $contents = array('form' => zen_draw_form('products', FILENAME_CATEGORIES, 'action=update_attributes_copy_to_product&cPath=' . $cPath . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')) . zen_draw_hidden_field('products_id', $pInfo->products_id) . zen_draw_hidden_field('products_update_id', $_GET['products_update_id']) . zen_draw_hidden_field('copy_attributes', $_GET['copy_attributes']));
      $contents[] = array('text' => '<br />' . TEXT_COPY_ATTRIBUTES_CONDITIONS . '<br />' . zen_draw_radio_field('copy_attributes', 'copy_attributes_delete', true) . ' ' . TEXT_COPY_ATTRIBUTES_DELETE . '<br />' . zen_draw_radio_field('copy_attributes', 'copy_attributes_update') . ' ' . TEXT_COPY_ATTRIBUTES_UPDATE . '<br />' . zen_draw_radio_field('copy_attributes', 'copy_attributes_ignore') . ' ' . TEXT_COPY_ATTRIBUTES_IGNORE);
      $contents[] = array('align' => 'center', 'text' => '<br />' . zen_draw_products_pull_down('products_update_id', '', $products_exclude_array, true) . '<br /><br />' . zen_image_submit('button_copy_to.gif', IMAGE_COPY_TO). '&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;

// attribute copier to product
    case 'attribute_features_copy_to_category':
      $_GET['categories_update_id'] = '';

      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_ATTRIBUTE_FEATURES . $pInfo->products_id . '</b>');
      $contents = array('form' => zen_draw_form('products', FILENAME_CATEGORIES, 'action=update_attributes_copy_to_category&cPath=' . $cPath . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')) . zen_draw_hidden_field('products_id', $pInfo->products_id) . zen_draw_hidden_field('categories_update_id', $_GET['categories_update_id']) . zen_draw_hidden_field('copy_attributes', $_GET['copy_attributes']));
      $contents[] = array('text' => '<br />' . TEXT_COPY_ATTRIBUTES_CONDITIONS . '<br />' . zen_draw_radio_field('copy_attributes', 'copy_attributes_delete', true) . ' ' . TEXT_COPY_ATTRIBUTES_DELETE . '<br />' . zen_draw_radio_field('copy_attributes', 'copy_attributes_update') . ' ' . TEXT_COPY_ATTRIBUTES_UPDATE . '<br />' . zen_draw_radio_field('copy_attributes', 'copy_attributes_ignore') . ' ' . TEXT_COPY_ATTRIBUTES_IGNORE);
      $contents[] = array('align' => 'center', 'text' => '<br />' . zen_draw_products_pull_down_categories('categories_update_id', '', '', true) . '<br /><br />' . zen_image_submit('button_copy_to.gif', IMAGE_COPY_TO) . '&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
      
    case 'copyAll':
    	$heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_COPY_SELECTED . '</b>');
    	$contents = array('form' => zen_draw_form('copy_all_to', $type_admin_handler, 'action=copy_all_to&cPath='.$_GET['cPath']. (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')));
        $contents[] = array('text' => TEXT_INFO_COPY_TO_INTRO);
     if(isset($_POST['productcheckbox'])&&$_POST['productcheckbox']!=''){
     	//var_dump($_POST['productcheckbox']);
//     	exit;
     foreach($_POST['productcheckbox'] as $val){     	
     	$Product_ids.='<span class="products_model_span">'.zen_get_products_model($val).zen_draw_hidden_field('productcheckbox[]',$val)."</span>";
     }   
    //$Product_ids=substr($Product_ids, 0,sizeof($Product_ids)-2);     
   }
        $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENT_PRODUCT . '<br /><b>' . $Product_ids. '</b><div style="clear:both;"></div>');
        //$contents[] = array('text' => '<br />' . TEXT_INFO_CURRENT_CATEGORIES . '<br /><b>' . zen_output_generated_category_path($_POST['productcheckbox'][0], 'product') . '</b>');
        $contents[] = array('text' => '<br />' . TEXT_CATEGORIES . '<br />' . zen_draw_pull_down_menu('categories_id', zen_get_category_tree(), $current_category_id));

        $contents[] = array('text' => '<br />' . TEXT_HOW_TO_COPY . '<br />' . zen_draw_radio_field('copy_as', 'link', true) . ' ' . TEXT_COPY_AS_LINK . '<br />' . zen_draw_radio_field('copy_as', 'duplicate') . ' ' . TEXT_COPY_AS_DUPLICATE);

        $contents[] = array('text' => '<br />' . zen_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','3'));
       // only ask about attributes if they exist

        if (zen_has_product_attributes($_POST['productcheckbox'][0], 'false')) {

          $contents[] = array('text' => '<br />' . TEXT_COPY_ATTRIBUTES_ONLY);

          $contents[] = array('text' => '<br />' . TEXT_COPY_ATTRIBUTES . '<br />' . zen_draw_radio_field('copy_attributes', 'copy_attributes_yes', true) . ' ' . TEXT_COPY_ATTRIBUTES_YES . '<br />' . zen_draw_radio_field('copy_attributes', 'copy_attributes_no') . ' ' . TEXT_COPY_ATTRIBUTES_NO);

// future          $contents[] = array('align' => 'center', 'text' => '<br />' . ATTRIBUTES_NAMES_HELPER . '<br />' . zen_draw_separator('pixel_trans.gif', '1', '10'));

          $contents[] = array('text' => '<br />' . zen_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','3'));

        }
       // only ask if product has discounts

        if (zen_has_product_discounts($_POST['productcheckbox'][0]) == 'true') {

          $contents[] = array('text' => '<br />' . TEXT_COPY_DISCOUNTS_ONLY);

          $contents[] = array('text' => '<br />' . TEXT_COPY_DISCOUNTS . '<br />' . zen_draw_radio_field('copy_discounts', 'copy_discounts_yes', true) . ' ' . TEXT_COPY_DISCOUNTS_YES . '<br />' . zen_draw_radio_field('copy_discounts', 'copy_discounts_no') . ' ' . TEXT_COPY_DISCOUNTS_NO);

          $contents[] = array('text' => '<br />' . zen_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','3'));

        } else {

          $contents[] = array('text' => '<br />' . 'NO DISCOUNTS');

        }

$link_url=(isset($_GET['search'])&&$_GET['search']!='')?('&search='.$_GET['search']):'';
        $contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_copy.gif', IMAGE_COPY) . ' <a href="' .  zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '').$link_url) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');

        $contents[] = array('text' => '</form>');

        break;   

    case 'moveAll':
    	$heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_MOVE_PRODUCT . '</b>');
       if(isset($_POST['productcheckbox'])&&$_POST['productcheckbox']!=''){
     	//var_dump($_POST['productcheckbox']);
//     	exit;
       foreach($_POST['productcheckbox'] as $val){
     	
     	$Product_ids.='<span class="products_model_span">'.zen_get_products_model($val).zen_draw_hidden_field('productcheckbox[]',$val)."</span>";
       }

      }
    	
		$contents = array('form' => zen_draw_form('move_products', $type_admin_handler, 'action=move_All_product_confirm&cPath=' . $cPath . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')) );
		$contents[] = array('text' => sprintf(TEXT_MOVE_PRODUCTS_INTRO,$Product_ids ));
        $contents[] = array('text' => '<br />' . TEXT_MOVE . '<br />' . zen_draw_pull_down_menu('move_to_category_id', zen_get_category_tree(), $current_category_id));
        $link_url=(isset($_GET['search'])&&$_GET['search']!='')?('&search='.$_GET['search']):'';
        $contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_move.gif', IMAGE_MOVE) . ' <a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '').$link_url) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
       $contents[] = array('text' => '</form>');
        break;        
     case 'disableAll':
    	$heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DISABLE_PRODUCT . '</b>');
       if(isset($_POST['productcheckbox'])&&$_POST['productcheckbox']!=''){
       		for ($i = 0, $n = sizeof($_POST['productcheckbox']); $i < $n; $i++){
       			$Product_ids.='<span class="products_model_span">'.zen_get_products_model($_POST['productcheckbox'][$i]).zen_draw_hidden_field('product_id[]',$_POST['productcheckbox'][$i])."</span>";
	     		$Product_ids .=  zen_draw_hidden_field('product_status[]', $_POST['product_status'][$_POST['productcheckbox'][$i]]);
	     		$Product_ids .=  zen_draw_hidden_field('product_cPath[]', $_POST['product_cPath'][$_POST['productcheckbox'][$i]]);
       		}
      }
		$contents = array('form' => zen_draw_form('disable_products', $type_admin_handler, 'action=disable_All_product_confirm&page=' . $_POST['currentPage'] . ((isset($_GET['search']) && $_GET['search'] != '') ? ('&search=' . $_GET['search']) : '' )));
		$contents[] = array('text' => sprintf(TEXT_DISABLE_PRODUCTS_INTRO, $Product_ids));
        $link_url=(isset($_GET['search'])&&$_GET['search']!='')?('&search='.$_GET['search']):'';
        $contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_confirm.gif') . ' <a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '').$link_url) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
       $contents[] = array('text' => '</form>');
        break; 
		case 'listAll':
    	$heading[] = array('text' => '<b>List Products</b>');
       if(isset($_POST['productcheckbox'])&&$_POST['productcheckbox']!=''){
     	//var_dump($_POST['productcheckbox']);
//     	exit;
       foreach($_POST['productcheckbox'] as $val){
     	
     	$Product_ids.='<span class="products_model_span">'.zen_get_products_model($val).zen_draw_hidden_field('productcheckbox[]',$val)." </span>";
       }
//         foreach($_POST['productcheckbox'] as $val){
//     	
//     	$Product_idsArr.=$val.",";
//        }
      //$Product_ids=substr($Product_ids, 0,sizeof($Product_ids)-2);
      //$Product_idsArr=substr($Product_idsArr, 0,sizeof($Product_idsArr)-2);
      //var_dump($Product_ids);
     // exit;
      }
    	$link_url=(isset($_GET['search'])&&$_GET['search']!='')?('&search='.$_GET['search']):'';
		$contents = array('form' => zen_draw_form('list_products', $type_admin_handler, 'action=list_All_product_confirm' . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '').$link_url) );
		$contents[] = array('text' => sprintf('Are you sure you want to list these products?<br/><b>%s</b>',$Product_ids ));
        $contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_update.gif', IMAGE_MOVE) . ' <a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '').$link_url) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
       $contents[] = array('text' => '</form>');
        break;
        
        case 'unListAll':
    	$heading[] = array('text' => '<b>Terminate Selected Products</b>');
       if(isset($_POST['productcheckbox'])&&$_POST['productcheckbox']!=''){
       foreach($_POST['productcheckbox'] as $val){
     	
     	$Product_ids.='<span class="products_model_span">'.zen_get_products_model($val).zen_draw_hidden_field('productcheckbox[]',$val)." </span>";
       }
      }
    	$link_url=(isset($_GET['search'])&&$_GET['search']!='')?('&search='.$_GET['search']):'';
		$contents = array('form' => zen_draw_form('unlist_products', $type_admin_handler, 'action=unlist_All_product_confirm' .(isset($_GET['page']) ? '&page=' . $_GET['page'] : '').$link_url) );
		$contents[] = array('text' => sprintf('Are you sure you want to terminate these products?<br/><b>%s</b>',$Product_ids ));
        $contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_update.gif', IMAGE_MOVE) . ' <a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '').$link_url) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
       $contents[] = array('text' => '</form>');
        break;   	
    } // switch

    if ( (zen_not_null($heading)) && (zen_not_null($contents)) ) {
      echo '            <td width="25%" valign="top">' . "\n";

      $box = new box;
      echo $box->infoBox($heading, $contents);

      echo '            </td>' . "\n";
    }
?>

          </tr>
          <tr>
<?php
// Split Page
if ($products_query_numrows > 0 && $action != 'disableAll') {
  if (empty($pInfo->products_id)) {
    $pInfo->products_id= $pID;
  }
?>
            <td class="smallText" align="right"><?php echo $products_split->display_count($products_query_numrows, MAX_DISPLAY_RESULTS_CATEGORIES, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_PRODUCTS) . '<br>' . $products_split->display_links($products_query_numrows, MAX_DISPLAY_RESULTS_CATEGORIES, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'info', 'x', 'y')) ); ?></td>

<?php
}
// Split Page
?>
          </tr>
        </table></td>
      </tr>
    </table>
<?php
  }
?>
    </td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
