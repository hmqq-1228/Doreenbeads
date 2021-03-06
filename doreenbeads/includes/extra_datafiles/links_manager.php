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
  define('FILENAME_LINKS', 'links');
  define('FILENAME_DEFINE_LINKS', 'define_links');
  define('FILENAME_LINKS_SUBMIT', 'links_submit');
  define('FILENAME_DEFINE_LINKS_SUBMIT', 'define_links_submit');
  define('FILENAME_DEFINE_LINKS_SUCCESS', 'define_links_success');
  define('FILENAME_LINK_LISTING', 'link_listing.php');
  define('FILENAME_POPUP_LINKS_HELP', 'popup_links_help');
  define('FILENAME_LINKS_REDIRECT', 'redirect_links');
  define('TABLE_LINK_CATEGORIES', DB_PREFIX . 'link_categories');
  define('TABLE_LINK_CATEGORIES_DESCRIPTION', DB_PREFIX . 'link_categories_description');
  define('TABLE_LINKS', DB_PREFIX . 'links');
  define('TABLE_LINKS_DESCRIPTION', DB_PREFIX . 'links_description');
  define('TABLE_LINKS_TO_LINK_CATEGORIES', DB_PREFIX . 'links_to_link_categories');
?>