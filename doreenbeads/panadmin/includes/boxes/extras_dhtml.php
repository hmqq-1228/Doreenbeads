<?php
/**
 * @package admin
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: extras_dhtml.php 6027 2007-03-21 09:11:58Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

  $za_contents = array();
  $za_heading = array();
  $za_heading = array('text' => BOX_HEADING_EXTRAS, 'link' => zen_href_link(FILENAME_ALT_NAV, '', 'NONSSL'));
if ($za_dir = @dir(DIR_WS_BOXES . 'extra_boxes')) {
  while ($zv_file = $za_dir->read()) {
    if (preg_match('/extras_dhtml.php$/', $zv_file)) {
      require(DIR_WS_BOXES . 'extra_boxes/' . $zv_file);
    }
  }
  $za_dir->close();
}
$za_contents[] = array('text' => 'Testimonial Manage', 'link' => zen_href_link(FILENAME_TESTIMONIAL_MANAGE));
$za_contents[] = array('text' => 'Email Logo Manage', 'link' => zen_href_link('email_logo_manage', '', 'NONSSL'));

//jessa 2010-08-16
$za_contents[] = array('text' => 'Wishlist', 'link' => zen_href_link('wishlist.php', '', 'NONSSL'));
//eof jessa 2010-08-16
$za_contents[] = array('text' => 'Learning Center', 'link' => zen_href_link('learning_center.php', '', 'NONSSL'));
$za_contents[] = array('text' => 'IP Verification', 'link' => zen_href_link('ip_verification', '', 'NONSSL'));
$za_contents[] = array('text' => '标语管理', 'link' => zen_href_link('tags_poster', '', 'NONSSL'));
$za_contents[] = array('text' => '热搜词设置', 'link' => zen_href_link('search_keyword_hot', '', 'NONSSL'));
$za_contents[] = array('text' => '同义词设置', 'link' => zen_href_link('search_keyword_synonym', '', 'NONSSL'));
$za_contents[] = array('text' => '高危国家', 'link' => zen_href_link('high_risk_country', '', 'NONSSL'));
$za_contents[] = array('text' => '高危客户', 'link' => zen_href_link('high_risk_customer', '', 'NONSSL'));
$za_contents[] = array('text' => '站内信类型', 'link' => zen_href_link(FILENAME_MESSAGE_TYPE, '', 'NONSSL'));
$za_contents[] = array('text' => '站内信设置', 'link' => zen_href_link(FILENAME_MESSAGE_LIST, '', 'NONSSL'));
$za_contents[] = array('text' => '站内信发送', 'link' => zen_href_link(FILENAME_MESSAGE_SEND, '', 'NONSSL'));
?>

<!-- extras_dhtml //-->
<?php 
if (sizeof($za_contents)) echo zen_draw_admin_box($za_heading, $za_contents);
?>
<!-- extras_dhtml_eof //-->
