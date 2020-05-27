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
require(DIR_WS_MODULES . 'require_languages.php');
  require_once(DIR_WS_FUNCTIONS . 'links.php');
// calculate link category path
  if (isset($_GET['lPath'])) {
    $lPath = $_GET['lPath'];
    $current_category_id = $lPath;
    $display_mode = 'links';
  } elseif (isset($_GET['links_id'])) {
    $lPath = zen_get_link_path($_GET['links_id']);
  } else {
    $lPath = '';
    $display_mode = 'categories';
  }
  // links breadcrumb
  $link_categories_query = $db->Execute("select link_categories_name from " . TABLE_LINK_CATEGORIES_DESCRIPTION . " where link_categories_id = '" . (int)$lPath . "' and language_id = '" . (int)$_SESSION['languages_id'] . "'");
  if ($display_mode == 'links') {
  	$breadcrumb->add(NAVBAR_TITLE1, 'links-exchange-jewelry-directory.html');
  	$breadcrumb->add($link_categories_query->fields['link_categories_name']);
  	$page_title=NAVBAR_SUB_TITLE.'-'.$link_categories_query->fields['link_categories_name'];
  	define('NAVBAR_TITLE', $page_title);
  } else {
  	define('NAVBAR_TITLE', NAVBAR_SUB_TITLE);
  	$breadcrumb->add(NAVBAR_TITLE1);
  }
// include template specific file name defines
  $define_page = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_LINKS, 'false');
?>