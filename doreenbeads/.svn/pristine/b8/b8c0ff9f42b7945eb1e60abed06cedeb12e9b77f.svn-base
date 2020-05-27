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
  function zen_get_link_path($links_id) {
    $lPath = '';
    $category_query = "select l2c.link_categories_id from " . TABLE_LINKS . " l, " . TABLE_LINKS_TO_LINK_CATEGORIES . " l2c where l.links_id = '" . (int)$links_id . "' and l.links_id = l2c.links_id limit 1";
    $number_of_categories = $db->Execute($categories_query);
    if ($number_of_categories->RecordCount() <=0) {
      $category = $db->Execute($category_query);
      $lPath .= $category->fields['link_categories_id'];
    }
    return $lPath;
  }
////
// The HTML image wrapper function
  function zen_links_image($src, $alt = '', $width = '', $height = '', $parameters = '') {
    if ( (empty($src) || ($src == DIR_WS_IMAGES)) && (IMAGE_REQUIRED == 'false') ) {
      return false;
    }
// alt is added to the img tag even if it is null to prevent browsers from outputting
// the image filename as default
    $image = '<img src="' . zen_output_string($src) . '"alt="' . zen_output_string($alt) . '"';
    if (zen_not_null($alt)) {
      $image .= ' title=" ' . zen_output_string($alt) . ' "';
    }
    if ( (CONFIG_CALCULATE_IMAGE_SIZE == 'true') && (empty($width) || empty($height)) ) {
      if ($image_size = @getimagesize($src)) {
        if (empty($width) && zen_not_null($height)) {
          $ratio = $height / $image_size[1];
          $width = $image_size[0] * $ratio;
        } elseif (zen_not_null($width) && empty($height)) {
          $ratio = $width / $image_size[0];
          $height = $image_size[1] * $ratio;
        } elseif (empty($width) && empty($height)) {
          $width = $image_size[0];
          $height = $image_size[1];
        }
      } elseif (IMAGE_REQUIRED == 'false') {
        return false;
      }
    }
    // VJ begin maintain image proportion
    $calculate_image_proportion = 'true';
    if( ($calculate_image_proportion == 'true') && (!empty($width) && !empty($height))) {
      if ($image_size = @getimagesize($src)) {
        $image_width = $image_size[0];
        $image_height = $image_size[1];
        if (($image_width != 1) && ($image_height != 1)) {
          $whfactor = $image_width/$image_height;
          $hwfactor = $image_height/$image_width;
          if ( !($image_width > $width) && !($image_height > $height)) {
            $width = $image_width;
            $height = $image_height;
          } elseif ( ($image_width > $width) && !($image_height > $height)) {
            $height = $width * $hwfactor;
          } elseif ( !($image_width > $width) && ($image_height > $height)) {
            $width = $height * $whfactor;
          } elseif ( ($image_width > $width) && ($image_height > $height)) {
            if ($image_width > $image_height) {
              $height = $width * $hwfactor;
            } else {
              $width = $height * $whfactor;
            }
          }
        }
      }
    }
    //VJ end maintain image proportion
    if (zen_not_null($width) && zen_not_null($height)) {
      $image .= ' width="' . (int)zen_output_string($width) . '" height="' . (int)zen_output_string($height) . '"';
    }
    if (zen_not_null($parameters)) $image .= ' ' . $parameters;
    $image .= ' />';
    return $image;
  }
////  
// Return the links url ----bof by wqz
//  function zen_get_links_url($identifier) {
//  global $db;
//    $link = $db->Execute("select links_id, links_url from " . TABLE_LINKS . " where links_id = '" . (int)$identifier . "'");
//          $links_string = $link->fields['links_url'];
//    return $links_string;
//  }
////
// Return the links url
  function zen_get_links_url($identifier) {
  	global $db;
    $link = $db->Execute("select links_id, links_url from " . TABLE_LINKS . " where links_id = '" . (int)$identifier . "'");
    $links_string = zen_href_link(FILENAME_LINKS_REDIRECT, 'action=links&goto=' . $link->fields['links_id']);
    return $link->fields['links_url'];
  }
//// eof by wqz
// Update the links click statistics
  function zen_update_links_click_count($links_id) {
    global $db;
    $db->Execute("update " . TABLE_LINKS . " set links_clicked = links_clicked + 1 where links_id = '" . (int)$links_id . "'");
  }
  function zen_db_insert_id() {
    return mysql_insert_id();
  }

?>