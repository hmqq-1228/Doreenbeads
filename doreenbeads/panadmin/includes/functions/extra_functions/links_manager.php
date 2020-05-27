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
  function zen_get_link_category_name($link_category_id, $language_id) {
  global $db;
    $link_category = $db->Execute("select link_categories_name from " . TABLE_LINK_CATEGORIES_DESCRIPTION . " where link_categories_id = '" . (int)$link_category_id . "' and language_id = '" . (int)$_SESSION['languages_id'] . "'");
    return $link_category->fields['link_categories_name'];
  }

  function zen_get_link_category_description($link_category_id, $language_id) {
global $db;
    $link_category = $db->Execute("select link_categories_description from " . TABLE_LINK_CATEGORIES_DESCRIPTION . " where link_categories_id = '" . (int)$link_category_id . "' and language_id = '" . (int)$_SESSION['languages_id'] . "'");
    return $link_category->fields['link_categories_description'];
  }

  function zen_remove_link_category($link_category_id) {
global $db;
    $link_category_image = $db->Execute("select link_categories_image from " . TABLE_LINK_CATEGORIES . " where link_categories_id = '" . (int)$link_category_id . "'");
    $duplicate_image = $db->Execute("select count(*) as total from " . TABLE_LINK_CATEGORIES . " where link_categories_image = '" . zen_db_input($link_category_image->fields['link_categories_image']) . "'");
    if ($duplicate_image->fields['total'] < 2) {
      if (file_exists(DIR_FS_CATALOG_IMAGES . $link_category_image->fields['link_categories_image'])) {
        @unlink(DIR_FS_CATALOG_IMAGES . $link_category_image->fields['link_categories_image']);
      }
    }

    $db->Execute("delete from " . TABLE_LINK_CATEGORIES . " where link_categories_id = '" . (int)$link_category_id . "'");
    $db->Execute("delete from " . TABLE_LINK_CATEGORIES_DESCRIPTION . " where link_categories_id = '" . (int)$link_category_id . "'");
    $db->Execute("delete from " . TABLE_LINKS_TO_LINK_CATEGORIES . " where link_categories_id = '" . (int)$link_category_id . "'");
  }

  function zen_remove_link($link_id) {
 global $db;
    $db->Execute("delete from " . TABLE_LINKS . " where links_id = '" . (int)$link_id . "'");
    $db->Execute("delete from " . TABLE_LINKS_TO_LINK_CATEGORIES . " where links_id = '" . (int)$link_id . "'");
    $db->Execute("delete from " . TABLE_LINKS_DESCRIPTION . " where links_id = '" . (int)$link_id . "'");
  }

// clone of zen_info_image() sans file_exists (which doesn't work on remote files)
  function zen_link_info_image($image, $alt, $width = '', $height = '') {
 global $db;
    if (zen_not_null($image)) {
      $image = zen_image($image, $alt, $width, $height);
    } else {
      $image = TEXT_IMAGE_NONEXISTENT;
    }
    return $image;
  }
function zen_set_links_status($links_id, $status) {
global $db;
    if ($status == '1') {
      return $db->Execute("update " . TABLE_LINKS . " set links_status = '1' where links_id = '" . $links_id . "'");
    } elseif ($status == '2') {
      return $db->Execute("update " . TABLE_LINKS . " set links_status = '2' where links_id = '" . $links_id . "'");
    } else {
      return -1;
    }
  }  
  
?>
