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
  $content = "";
  $content .= '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="sideBoxContent">' . "\n";
  $content.= zen_draw_form('links', zen_href_link(FILENAME_LINKS, '', 'NONSSL', false), 'get');
  $content .= zen_draw_pull_down_menu('lPath', $links_array, (isset($_GET['lPath']) ? $_GET['lPath'] : ''), 'onchange="this.form.submit();" size="' . MAX_LINKS_LIST . '" style="width: 100%"') . zen_hide_session_id();
  $content .= zen_draw_hidden_field('main_page', FILENAME_LINKS) . '</form>';
  if (BOX_DISPLAY_VIEW_ALL_LINKS == 'true') {
  $content .= '<br /><a href="' . zen_href_link(FILENAME_LINKS, '', 'NONSSL') . '">' . BOX_INFORMATION_VIEW_ALL_LINKS . '</a>';
}
   if (BOX_DISPLAY_SUBMIT_LINK == 'true') {
  $content .= '<br /><a href="' . zen_href_link(FILENAME_LINKS_SUBMIT, '', 'SSL') . '">' . BOX_INFORMATION_LINKS_SUBMIT . '</a></div>';
}
?>