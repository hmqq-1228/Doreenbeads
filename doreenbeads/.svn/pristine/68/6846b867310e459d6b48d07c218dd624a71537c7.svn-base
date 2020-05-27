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

  require('includes/application_top.php');
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  $error = false;
  $processed = false;
  if (zen_not_null($action)) {
    switch ($action) {
      case 'setflag':
        $status = zen_db_prepare_input($_GET['flag']);
        if ($status == '1') {
          $db->Execute("update " . TABLE_LINK_CATEGORIES . " set link_categories_status = '1' where link_categories_id = '" . (int)$_GET['cID'] . "'");
        } elseif ($status == '0') {
          $db->Execute("update " . TABLE_LINK_CATEGORIES . " set link_categories_status = '0' where link_categories_id = '" . (int)$_GET['cID'] . "'");
        } 
        zen_redirect(zen_href_link(FILENAME_LINK_CATEGORIES, '&cID=' . $_GET['cID']));
        break;
      case 'insert':
      case 'update':
        if (isset($_POST['link_categories_id'])) $link_categories_id = zen_db_prepare_input($_POST['link_categories_id']);
        $link_categories_sort_order = zen_db_prepare_input($_POST['link_categories_sort_order']);
        $link_categories_status = ((zen_db_prepare_input($_POST['link_categories_status']) == 'on') ? '1' : '0');
        $sql_data_array = array('link_categories_sort_order' => $link_categories_sort_order, 
                                'link_categories_status' => $link_categories_status);
        if ($action == 'insert') {
          $insert_sql_data = array('link_categories_date_added' => 'now()');
          $sql_data_array = array_merge($sql_data_array, $insert_sql_data);
          zen_db_perform(TABLE_LINK_CATEGORIES, $sql_data_array);
          $link_categories_id = zen_db_insert_id();
        } elseif ($action == 'update') {
          $update_sql_data = array('link_categories_last_modified' => 'now()');
          $sql_data_array = array_merge($sql_data_array, $update_sql_data);
          zen_db_perform(TABLE_LINK_CATEGORIES, $sql_data_array, 'update', "link_categories_id = '" . (int)$link_categories_id . "'");
        }
        $languages = zen_get_languages();
        for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
          $link_categories_name_array = $_POST['link_categories_name'];
          $link_categories_description_array = $_POST['link_categories_description'];
          $language_id = $languages[$i]['id'];
          $sql_data_array = array('link_categories_name' => zen_db_prepare_input($link_categories_name_array[$language_id]), 
                                  'link_categories_description' => zen_db_prepare_input($link_categories_description_array[$language_id]));
          if ($action == 'insert') {
            $insert_sql_data = array('link_categories_id' => $link_categories_id,
                                     'language_id' => $languages[$i]['id']);
            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);
            zen_db_perform(TABLE_LINK_CATEGORIES_DESCRIPTION, $sql_data_array);
          } elseif ($action == 'update') {
            zen_db_perform(TABLE_LINK_CATEGORIES_DESCRIPTION, $sql_data_array, 'update', "link_categories_id = '" . (int)$link_categories_id . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
          }
        }
        if ($link_categories_image = new upload('link_categories_image')) {
          $link_categories_image->set_destination(DIR_FS_CATALOG_IMAGES . $_POST['img_dir']);
          if ($link_categories_image->parse() && $link_categories_image->save()) {
            $link_categories_image_name = $_POST['img_dir'] . $link_categories_image->filename;
          }
          if ($link_categories_image->filename != 'none' && $link_categories_image->filename != '') {
            $db->Execute("update " . TABLE_LINK_CATEGORIES . "
                          set link_categories_image = '" . $link_categories_image_name . "'
                          where link_categories_id = '" . (int)$link_categories_id . "'");
          } else {
            // remove when set to none
            if ($link_categories_image->filename = 'none' || $_POST['img_dir'] == 'none') {
              $db->Execute("update " . TABLE_LINK_CATEGORIES . "
                            set link_categories_image = ''
                            where link_categories_id = '" . (int)$link_categories_id . "'");
            }
          }
        }
        zen_redirect(zen_href_link(FILENAME_LINK_CATEGORIES, '&cID=' . $link_categories_id));
        break;
      case 'delete_confirm':
        if (isset($_POST['link_categories_id'])) {
          $link_categories_id = zen_db_prepare_input($_POST['link_categories_id']);
          $link_ids = $db->Execute("select links_id from " . TABLE_LINKS_TO_LINK_CATEGORIES . " where link_categories_id = '" . (int)$link_categories_id . "'");
          while (!$link_ids->EOF) {
            zen_remove_link($link_ids['links_id']);
          $link_ids->MoveNext();
          }
          zen_remove_link_category($link_categories_id);
        }
        zen_redirect(zen_href_link(FILENAME_LINK_CATEGORIES));
        break;
      default:
        $link_categories_query = "select lc.link_categories_id, lc.link_categories_image, lc.link_categories_status, lc.link_categories_sort_order, lc.link_categories_date_added, lc.link_categories_last_modified, lcd.link_categories_name, lcd.link_categories_description from " . TABLE_LINK_CATEGORIES . " lc left join " . TABLE_LINK_CATEGORIES_DESCRIPTION . " lcd on lc.link_categories_id = lcd.link_categories_id where lcd.link_categories_id = lc.link_categories_id and lc.link_categories_id = '" . (int)$_GET['cID'] . "' and lcd.language_id = '" . $_SESSION['languages_id'] . "'";
        $link_categories = $db->Execute($link_categories_query);
        $links_count_query = "select count(*) as link_categories_count from " . TABLE_LINKS_TO_LINK_CATEGORIES . " where link_categories_id = '" . (int)$_GET['cID'] . "'";
        $links_count = $db->Execute($links_count_query);
// bof php5 fix - aclarke - 281206
$cInfo_array = array_merge((array)$link_categories->fields, (array)$links_count->fields);
// eof php5 fix - aclarke - 281206 
        $cInfo = new objectInfo($cInfo_array);
    }
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script type="text/javascript" src="includes/menu.js"></script>
<script type="text/javascript" src="includes/general.js"></script>
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
</head>
<body onload="init()">
<div id="spiffycalendar" class="text"></div>
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr><?php echo zen_draw_form('search', FILENAME_LINK_CATEGORIES, '', 'get'); ?>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td class="smallText" align="right"><?php echo HEADING_TITLE_SEARCH . ' ' . zen_draw_input_field('search'); ?></td>
          </form></tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_NAME; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
    <?php
    $search = '';
    if (isset($_GET['search']) && zen_not_null($_GET['search'])) {
      $keywords = zen_db_input(zen_db_prepare_input($_GET['search']));
      $search = " and lcd.link_categories_name like '%" . $keywords . "%'";
      $link_categories_query_raw = "select lc.link_categories_id, lc.link_categories_image, lc.link_categories_status, lc.link_categories_sort_order, lc.link_categories_date_added, lc.link_categories_last_modified, lcd.link_categories_name, lcd.link_categories_description from " . TABLE_LINK_CATEGORIES . " lc left join " . TABLE_LINK_CATEGORIES_DESCRIPTION . " lcd on lc.link_categories_id = lcd.link_categories_id where lcd.language_id = '" . $_SESSION['languages_id'] . "'" . $search . " order by lc.link_categories_sort_order, lcd.link_categories_name";
    } else {
      $link_categories_query_raw = "select lc.link_categories_id, lc.link_categories_image, lc.link_categories_status, lc.link_categories_sort_order, lc.link_categories_date_added, lc.link_categories_last_modified, lcd.link_categories_name, lcd.link_categories_description from " . TABLE_LINK_CATEGORIES . " lc left join " . TABLE_LINK_CATEGORIES_DESCRIPTION . " lcd on lc.link_categories_id = lcd.link_categories_id  where lcd.language_id = '" . $_SESSION['languages_id'] . "' order by lc.link_categories_sort_order, lcd.link_categories_name";
    }
    $link_categories_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $link_categories_query_raw, $link_categories_query_numrows);
    $link_categories = $db->Execute($link_categories_query_raw);
      while (!$link_categories->EOF) {
      if ((!isset($_GET['cID']) || (isset($_GET['cID']) && ($_GET['cID'] == $link_categories->fields['link_categories_id']))) && !isset($cInfo)) { 
        $links_count_query = "select count(*) as link_categories_count from " . TABLE_LINKS_TO_LINK_CATEGORIES . " where link_categories_id = '" . (int)$link_categories->fields['link_categories_id'] . "'";
        $links_count = $db->Execute($links_count_query);

        $cInfo_array = array_merge($link_categories->fields, $links_count->fields);
        $cInfo = new objectInfo($cInfo_array);
      }

      if (isset($cInfo) && is_object($cInfo) && ($link_categories->fields['link_categories_id'] == $cInfo->link_categories_id)) {
        echo '          <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_LINK_CATEGORIES, zen_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->link_categories_id . '&action=edit') . '\'">' . "\n";
      } else {
        echo '          <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_LINK_CATEGORIES, zen_get_all_get_params(array('cID')) . 'cID=' . $link_categories->fields['link_categories_id']) . '\'">' . "\n";
      }
     ?>
                <td class="dataTableContent"><?php echo $link_categories->fields['link_categories_name']; ?></td>
                <td  class="dataTableContent" align="right">
     <?php
      if ($link_categories->fields['link_categories_status'] == '1') {
        echo zen_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_LINK_CATEGORIES, 'action=setflag&flag=0&cID=' . $link_categories->fields['link_categories_id'], 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . zen_href_link(FILENAME_LINK_CATEGORIES, 'action=setflag&flag=1&cID=' . $link_categories->fields['link_categories_id'], 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . zen_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
    ?></td>
                <td class="dataTableContent" align="right"><?php if (isset($cInfo) && is_object($cInfo) && ($link_categories->fields['link_categories_id'] == $cInfo->link_categories_id)) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . zen_href_link(FILENAME_LINK_CATEGORIES, zen_get_all_get_params(array('cID')) . 'cID=' . $link_categories->fields['link_categories_id']) . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
     <?php
        $link_categories->MoveNext();
      }
    ?>
              <tr>
                <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $link_categories_split->display_count($link_categories_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_LINK_CATEGORIES); ?></td>
                    <td class="smallText" align="right"><?php echo $link_categories_split->display_links($link_categories_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'info', 'x', 'y', 'cID'))); ?></td>
                  </tr>
                  <tr>
    <?php
      if (isset($_GET['search']) && zen_not_null($_GET['search'])) {
    ?>
                    <td align="right"><?php echo '<a href="' . zen_href_link(FILENAME_LINK_CATEGORIES) . '">' . zen_image_button('button_reset.gif', IMAGE_RESET) . '</a>'; ?></td>
                    <td align="right"><?php echo '<a href="' . zen_href_link(FILENAME_LINK_CATEGORIES, 'page=' . $_GET['page'] . '&action=new') . '">' . zen_image_button('button_new_category.gif', IMAGE_NEW_CATEGORY) . '</a>'; ?></td>
    <?php
       } else {
     ?>
                    <td align="right" colspan="2"><?php echo '<a href="' . zen_href_link(FILENAME_LINK_CATEGORIES, 'page=' . $_GET['page'] . '&action=new') . '">' . zen_image_button('button_new_category.gif', IMAGE_NEW_CATEGORY) . '</a>'; ?></td>
    <?php
      }
    ?>
                  </tr>
                </table></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();
  switch ($action) {
    case 'new':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_LINK_CATEGORY . '</b>');
      $contents = array('form' => zen_draw_form('new_link_categories', FILENAME_LINK_CATEGORIES, 'action=insert', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_NEW_LINK_CATEGORIES_INTRO);
      $link_category_inputs_string = '';
      $languages = zen_get_languages();
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $link_category_inputs_string .= '<br />' . zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . zen_draw_input_field('link_categories_name[' . $languages[$i]['id'] . ']');
      }
      $link_category_description_inputs_string = '';
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $link_category_description_inputs_string .= '<br />' . zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;<br />' . zen_draw_textarea_field('link_categories_description[' . $languages[$i]['id'] . ']', 'soft', '40', '5');
      }
      $contents[] = array('text' => '<br />' . TEXT_LINK_CATEGORIES_NAME . $link_category_inputs_string);
      $contents[] = array('text' => '<br />' . TEXT_LINK_CATEGORIES_DESCRIPTION . $link_category_description_inputs_string);
      $contents[] = array('text' => '<br />' . TEXT_LINK_CATEGORIES_IMAGE . '<br />' . zen_draw_file_field('link_categories_image'));
      $contents[] = array('text' => '<br />' . TEXT_LINK_CATEGORIES_SORT_ORDER . '<br />' . zen_draw_input_field('link_categories_sort_order', '', 'size="2"'));
      $contents[] = array('text' => '<br />' . TEXT_LINK_CATEGORIES_STATUS . '&nbsp;&nbsp;' . zen_draw_radio_field('link_categories_status', 'on', true) . ' ' . TEXT_LINK_CATEGORIES_STATUS_ENABLE . '&nbsp;&nbsp;' . zen_draw_radio_field('link_categories_status', 'off') . ' ' . TEXT_LINK_CATEGORIES_STATUS_DISABLE);
      $contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . zen_href_link(FILENAME_LINK_CATEGORIES) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_LINK_CATEGORY . '</b>');
      $contents = array('form' => zen_draw_form('edit_link_categories', FILENAME_LINK_CATEGORIES, 'action=update', 'post', 'enctype="multipart/form-data"') . zen_draw_hidden_field('link_categories_id', $cInfo->link_categories_id));
      $contents[] = array('text' => TEXT_EDIT_LINK_CATEGORIES_INTRO);
      $link_category_inputs_string = '';
      $languages = zen_get_languages();
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $link_category_inputs_string .= '<br />' . zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . zen_draw_input_field('link_categories_name[' . $languages[$i]['id'] . ']', zen_get_link_category_name($cInfo->link_categories_id, $languages[$i]['id']));
      }
      $link_category_description_inputs_string = '';
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $link_category_description_inputs_string .= '<br />' . zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;<br />' . zen_draw_textarea_field('link_categories_description[' . $languages[$i]['id'] . ']', 'soft', '40', '5', zen_get_link_category_description($cInfo->link_categories_id, $languages[$i]['id']));
      }
      $contents[] = array('text' => '<br />' . TEXT_LINK_CATEGORIES_NAME . $link_category_inputs_string);
      $contents[] = array('text' => '<br />' . TEXT_LINK_CATEGORIES_DESCRIPTION . $link_category_description_inputs_string);
      $contents[] = array('text' => '<br />' . zen_info_image($cInfo->link_categories_image, $cInfo->link_categories_name) . '<br />' . $cInfo->link_categories_image);
      $contents[] = array('text' => '<br />' . TEXT_LINK_CATEGORIES_IMAGE . '<br />' . zen_draw_file_field('link_categories_image'));
      $contents[] = array('text' => '<br />' . TEXT_LINK_CATEGORIES_SORT_ORDER . '&nbsp;' . zen_draw_input_field('link_categories_sort_order', $cInfo->link_categories_sort_order, 'size="2"'));
      $contents[] = array('text' => '<br />' . TEXT_LINK_CATEGORIES_STATUS . '&nbsp;&nbsp;' . zen_draw_radio_field('link_categories_status', 'on', ($cInfo->link_categories_status == '1') ? true : false) . ' ' . TEXT_LINK_CATEGORIES_STATUS_ENABLE . '&nbsp;&nbsp;' . zen_draw_radio_field('link_categories_status', 'off', ($cInfo->link_categories_status == '0') ? true : false) . ' ' . TEXT_LINK_CATEGORIES_STATUS_DISABLE);
      $contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . zen_href_link(FILENAME_LINK_CATEGORIES, 'cID=' . $cInfo->link_categories_id) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_LINK_CATEGORY . '</b>');
      $contents = array('form' => zen_draw_form('delete_link_categories', FILENAME_LINK_CATEGORIES, 'action=delete_confirm') . zen_draw_hidden_field('link_categories_id', $cInfo->link_categories_id));
      $contents[] = array('text' => TEXT_DELETE_LINK_CATEGORIES_INTRO);
      $contents[] = array('text' => '<br /><b>' . $cInfo->link_categories_name . '</b>');
      if ($cInfo->link_categories_count > 0) $contents[] = array('text' => '<br />' . sprintf(TEXT_DELETE_WARNING_LINKS, $cInfo->link_categories_count));
      $contents[] = array('align' => 'center', 'text' => '<br />' . zen_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . zen_href_link(FILENAME_LINK_CATEGORIES, 'cID=' . $cInfo->link_categories_id) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    default:
      if (isset($cInfo) && is_object($cInfo)) {
        $heading[] = array('text' => '<b>' . $cInfo->link_categories_name . '</b>');
        $contents[] = array('align' => 'center', 'text' => '<a href="' . zen_href_link(FILENAME_LINK_CATEGORIES, zen_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->link_categories_id . '&action=edit') . '">' . zen_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . zen_href_link(FILENAME_LINK_CATEGORIES, zen_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->link_categories_id . '&action=delete') . '">' . zen_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
        $contents[] = array('text' => '<br />' . zen_info_image($cInfo->link_categories_image, $cInfo->link_categories_name, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT) . '<br />' . $cInfo->link_categories_image);
        $contents[] = array('text' => '<br />' . TEXT_INFO_LINK_CATEGORY_DESCRIPTION . ' ' . $cInfo->link_categories_description);
        $contents[] = array('text' => '<br />' . TEXT_DATE_LINK_CATEGORY_CREATED . ' ' . zen_date_short($cInfo->link_categories_date_added));
        if (zen_not_null($cInfo->link_categories_last_modified)) {
          $contents[] = array('text' => '<br />' . TEXT_DATE_LINK_CATEGORY_LAST_MODIFIED . ' ' . zen_date_short($cInfo->link_categories_last_modified));
        }
        $contents[] = array('text' => '<br />' . TEXT_INFO_LINK_CATEGORY_COUNT . ' '  . $cInfo->link_categories_count);
        $contents[] = array('text' => '<br />' . TEXT_INFO_LINK_CATEGORY_SORT_ORDER . ' '  . $cInfo->link_categories_sort_order);
      }
      break;
  }
  if ( (zen_not_null($heading)) && (zen_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";
    $box = new box;
    echo $box->infoBox($heading, $contents);
    echo '            </td>' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
    </table></td>
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