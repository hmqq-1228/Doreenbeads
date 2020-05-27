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
  $links_query= ("select lc.link_categories_id, lc.link_categories_sort_order, lcd.link_categories_id, lcd.link_categories_name from " . TABLE_LINK_CATEGORIES . " lc, " . TABLE_LINK_CATEGORIES_DESCRIPTION . " lcd where lc.link_categories_status = '1' and lc.link_categories_id = lcd.link_categories_id and lcd.language_id = '" . (int)$_SESSION['languages_id'] . "' order by lc.link_categories_sort_order, lcd.link_categories_name");
  $links = $db->Execute($links_query);
  if ($links->RecordCount()>0) {
    $number_of_rows = $links->RecordCount()+1;
    $links_array = array();
    if ($_GET['link_categories_id'] == '' ) {
    } else {
      $links_array[] = array('id' => '', 'text' => PULL_DOWN_LINKS_MANAGER);
    }
    while (!$links->EOF) {
      $link_categories_name = ((strlen($links->fields['link_categories_name']) > MAX_DISPLAY_LINK_NAME_LEN) ? substr($links->fields['link_categories_name'], 0, MAX_DISPLAY_LINK_NAME_LEN) . '..' : $links->fields['link_categories_name']);
      $links_array[] = array('id' => $links->fields['link_categories_id'],
                                       'text' => $link_categories_name);
      $links->MoveNext();
    }
      require($template->get_template_dir('tpl_links_select.php',DIR_WS_TEMPLATE, $current_page_base,'sideboxes'). '/tpl_links_select.php');
    $title =  BOX_HEADING_LINK_CATEGORIES;
    $left_corner = false;
    $right_corner = false;
    $right_arrow = false;
    $title_link = false;
    require($template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base,'common') . '/' . $column_box_default);
  }
?>