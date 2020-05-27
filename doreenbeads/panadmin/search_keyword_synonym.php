<?php

//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2006 The zen-cart developers                           |
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
//  $Id: admin.php 4701 2006-10-08 01:09:44Z drbyte $
//
require ('includes/application_top.php');

$action = (isset ($_GET['action']) ? $_GET['action'] : '');

if (zen_not_null($action)) {

	switch ($action) {
		// demo active test
		case (zen_admin_demo()) :
			$action = '';
			$messageStack->add_session(ERROR_ADMIN_DEMO, 'caution');
			zen_redirect(zen_href_link(FILENAME_SEARCH_KEYWORD_SYNONYM));
			break;
			//-------------------------------------------------------------------------------------------------------------------------
		case 'insert' :
		case 'save' :
		case 'deleteconfirm' :
			$error = false;
			if ($action == 'insert' || $action == 'save') {
				//去除左右空格、中文空格替换成英文空格、两个空格替换成一个空格
				$keyword_chinese = str_replace("  ", " ", str_replace("　", " ", trim($_POST['keyword_chinese'])));//两个空格或中文空格替换成一个空格
				$keyword_main = str_replace("  ", " ", str_replace("　", " ", trim($_POST['keyword_main'])));//两个空格或中文空格替换成一个空格
				$keyword_synonym = str_replace("  ", " ", str_replace("　", " ", trim($_POST['keyword_synonym'])));//两个空格或中文空格替换成一个空格
				$keyword_status = zen_db_prepare_input(trim($_POST['keyword_status']));

				if (empty ($keyword_chinese) || empty ($keyword_main) || empty ($keyword_synonym)) {
					$error = true;
					$messageStack->add('请输入同义词-zh、原词、同义词', 'error');
				}
			}

			if ($error == false) {
				if (isset ($_GET['auto_id']))
					$admins_id = zen_db_prepare_input($_GET['auto_id']);

				$sql_data_array = array (
					'languages_id' => $_SESSION['languages_id'],
					'keyword_chinese' => $keyword_chinese,
					'keyword_main' => $keyword_main,
					'keyword_synonym' => $keyword_synonym,
					'keyword_status' => $keyword_status,
					'admin_email' => $_SESSION['admin_email'],
					'date_created' => 'now()'
				);
				if ($action == 'insert') {
					zen_db_perform(TABLE_SEARCH_SYNONYM, $sql_data_array);
					$new_auto_id = zen_db_insert_id();
					$admins_id = $new_auto_id;

				}
				elseif ($action == 'save') {
					zen_db_perform(TABLE_SEARCH_SYNONYM, $sql_data_array, 'update', "auto_id = '" . (int) $admins_id . "'");
				}
				elseif ($action == 'deleteconfirm') {

					$db->Execute("delete from " . TABLE_SEARCH_SYNONYM . " where auto_id = '" . (int) $_GET['auto_id'] . "'");
					zen_redirect(zen_href_link(FILENAME_SEARCH_KEYWORD_SYNONYM,zen_get_all_get_params(array('action', 'auto_id'))));

				}

				zen_redirect(zen_href_link(FILENAME_SEARCH_KEYWORD_SYNONYM,zen_get_all_get_params(array('action', 'auto_id')) . '&auto_id=' . $admins_id));

			} // end error check

			//echo $action;
			//	zen_redirect(zen_href_link(FILENAME_SEARCH_KEYWORD_SYNONYM, (isset($_GET['page']) ? 'page=' . '&' : '') . 'auto_id=' . $admins_id));
			break;

			/*-------------------------------------------------------------------------------------------------------------------------
			    case 'deleteconfirm':
			      $new_auto_id = zen_db_prepare_input($_GET['auto_id']);
			      $db->Execute("delete from " . TABLE_SEARCH_SYNONYM . " where auto_id = '" . (int)$new_auto_id . "'");
			      $operate_content= $_GET['auto_id'].'用户被关闭';
			      zen_insert_operate_logs($_SESSION['auto_id'],$_GET['auto_id'],$operate_content,4);
			    	zen_redirect(zen_href_link(FILENAME_SEARCH_KEYWORD_SYNONYM, 'page=' . $_GET['page']).(isset($_GET['search']) ? 'search=' . $_GET['search'] . '&' : '') . (isset($_GET['sort']) ? 'sort=' . $_GET['sort'] . '&' : '') );
			    break;
			*/
	} // end switch
} // end zen_not_null
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
}
// -->
</script>
</head>
<body onLoad="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
	<tr>
<!-- body_text //-->
		<td width="100%" valign="top">


<?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td class="pageHeading">同义词设置</td>
		<td align="right">
		<table border="0" width="20%" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<?php

echo zen_draw_form('search', FILENAME_SEARCH_KEYWORD_SYNONYM, '', 'get', 'id="search_form"', true);
echo '搜索： ' . zen_draw_input_field('search', ((isset ($_GET['search']) && zen_not_null($_GET['search'])) ? zen_db_input(zen_db_prepare_input($_GET['search'])) : ''), 'style="width:175px;" id="search_text"') . zen_hide_session_id();
?>
			<?php echo "<input type='submit' value='确定'>"; ?>
			</form>
			</td>
		</tr>
		</table>
		</td>
	</tr>

</table>

<?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="top">

<table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr class="dataTableHeadingRow">
		<td width="10%" class="dataTableHeadingContent">ID</td>
		<td width="25%" class="dataTableHeadingContent">同义词-zh</td>
		<td width="25%" class="dataTableHeadingContent">原词</td>
		<td width="25%" class="dataTableHeadingContent">同义词</td>
		<td width="10%" class="dataTableHeadingContent">状态</td>
		<td width="5%" class="dataTableHeadingContent" align="right">操作</td>
</tr>

<?php

if (isset ($_GET['search']) && zen_not_null($_GET['search'])) {
	$para_search = zen_db_input(zen_db_prepare_input($_GET['search']));
	$search_query = ' and (keyword_chinese like "%' . $para_search . '%" or keyword_main like "%' . $para_search . '%" or keyword_synonym like "%' . $para_search . '%")';
} else {
	$search_query = '';
}

if (isset ($_GET['sort']) && zen_not_null($_GET['sort'])) {
	switch ($_GET['sort']) {
		case 0 :
			$para_sort = ' order by keyword_chinese ASC';
			break;
		case 1 :
			$para_sort = ' order by keyword_chinese DESC';
			break;
		case 2 :
			$para_sort = ' order by auto_id DESC';
			break;
		case 3 :
			$para_sort = ' order by auto_id ASC';
			break;
	}

} else {
	$para_sort = ' order by auto_id DESC';
}

$admins_query_raw = "select * from " . TABLE_SEARCH_SYNONYM . " where languages_id=" . $_SESSION['languages_id'] . $search_query . $para_sort;
$admins_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $admins_query_raw, $admins_query_numrows);
$admins = $db->Execute($admins_query_raw);

while (!$admins->EOF) {
	if ((!isset ($_GET['auto_id']) || (isset ($_GET['auto_id']) && ($_GET['auto_id'] == $admins->fields['auto_id']))) && !isset ($adminInfo) && (substr($action, 0, 3) != 'new')) {
		$adminInfo = new objectInfo($admins->fields);
	}

	if (isset ($adminInfo) && is_object($adminInfo) && ($admins->fields['auto_id'] == $adminInfo->auto_id)) {
		echo '<tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_SEARCH_KEYWORD_SYNONYM,zen_get_all_get_params(array('action', 'auto_id')) . '&auto_id=' . $admins->fields['auto_id'] . '&action=edit') . '\'">' . "\n";
	} else {
		echo '<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_SEARCH_KEYWORD_SYNONYM,zen_get_all_get_params(array('action', 'auto_id')) . '&auto_id=' . $admins->fields['auto_id'] . '') . '\'">' . "\n";
	}
?>

		<td class="dataTableContent"><?php echo $admins->fields['auto_id']; ?></td>
		<td class="dataTableContent"><?php echo $admins->fields['keyword_chinese']; ?></td>
		<td class="dataTableContent"><?php echo $admins->fields['keyword_main']; ?></td>
		<td class="dataTableContent"><?php echo $admins->fields['keyword_synonym']; ?></td>
		<td class="dataTableContent"><?php echo $admins->fields['keyword_status']==1?zen_image(DIR_WS_IMAGES . 'icon_green_on.gif', IMAGE_ICON_STATUS_ON):zen_image(DIR_WS_IMAGES . 'icon_red_on.gif', IMAGE_ICON_STATUS_OFF);?></td>
		<td class="dataTableContent" align="right">
<?php echo '<a href="' . zen_href_link(FILENAME_SEARCH_KEYWORD_SYNONYM, 'page=' . $_GET['page'] . '&search='.$_GET['search'] . '&sort=' . $_GET['sort'] . '&auto_id=' . $admins->fields['auto_id'] . '&action=edit') . '">' . zen_image(DIR_WS_IMAGES . 'icon_edit.gif', ICON_EDIT) . '</a>'; ?>&nbsp;
<?php
 /* echo '<a href="' . zen_href_link(FILENAME_SEARCH_KEYWORD_SYNONYM, 'page=' . $_GET['page'] . '&auto_id=' . $admins->fields['auto_id'] . '&action=delete') . '">' . zen_image(DIR_WS_IMAGES . 'icon_delete.gif', ICON_DELETE) . '</a>';*/
?>
<?php if (isset($adminInfo) && is_object($adminInfo) && ($admins->fields['auto_id'] == $adminInfo->auto_id)) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . zen_href_link(FILENAME_SEARCH_KEYWORD_SYNONYM, 'page=' . $_GET['page'] . '&search='.$_GET['search'] . '&sort=' . $_GET['sort'] . '&auto_id=' . $admins->fields['auto_id']) . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>
		</td>
</tr>

<?php

	$admins->MoveNext();
}
?>

	<tr>
		<td colspan="5">

<table border="0" width="100%" cellspacing="0" cellpadding="4">
	<tr>
		<td class="smallText" valign="top"><?php echo $admins_split->display_count($admins_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_KEYWORDS); ?></td>
		<td class="smallText" align="right"><?php echo $admins_split->display_links($admins_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'],zen_get_all_get_params(array('page'))); ?></td>
	</tr>
</table>

		</td>
	</tr>

<?php

if (empty ($action) || $action == "insert") {
?>
	<tr>
		<td align="right" colspan="5" class="smallText">
<?php

	echo '<a href="' . zen_href_link(FILENAME_SEARCH_KEYWORD_SYNONYM,zen_get_all_get_params(array('action', 'auto_id')) . '&auto_id=' . $adminInfo->auto_id . '&action=new') . '">' . zen_image_button('button_insert.gif', IMAGE_INSERT) . '</a>';
?>
		</td>
	</tr>
<?php

}
?>
</table>
		</td>

<?php

$heading = array ();
$contents = array ();

switch ($action) {
	//-------------------------------------------------------------------------------------------------------------------------

	case 'new' :
		$heading[] = array (
			'text' => '<b>添加同义词</b>'
		);
		$contents = array (
			'form' => zen_draw_form('new_admin', FILENAME_SEARCH_KEYWORD_SYNONYM, 'action=insert', 'post', 'enctype="multipart/form-data"')
		);
		$contents[] = array (
			'text' => '<br>同义词-zh<br>' . zen_draw_input_field('keyword_chinese', '', zen_set_field_length(TABLE_SEARCH_SYNONYM, 'keyword_chinese', $max = 30))
		);
		$contents[] = array (
			'text' => '<br>原词<br>' . zen_draw_input_field('keyword_main', '', zen_set_field_length(TABLE_SEARCH_SYNONYM, 'keyword_main', $max = 30))
		);
		$contents[] = array (
			'text' => '<br>同义词<br>' . zen_draw_input_field('keyword_synonym', '', zen_set_field_length(TABLE_SEARCH_SYNONYM, 'keyword_synonym', $max = 30))
		);
		$contents[] = array (
			'text' => '<br>状态<br>' . zen_draw_radio_field('keyword_status', '1', true) . '开启&nbsp;&nbsp;&nbsp;&nbsp;' . zen_draw_radio_field('keyword_status', '1', false) . '关闭'
		);
		$contents[] = array (
			'align' => 'center',
			'text' => '<br>' . zen_image_submit('button_save.gif', IMAGE_SAVE) . '&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_SEARCH_KEYWORD_SYNONYM,zen_get_all_get_params(array('action', 'auto_id')) . '&auto_id=' . $_GET['auto_id']) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'
		);
		break;

		//-------------------------------------------------------------------------------------------------------------------------
	case 'edit' :
		$heading[] = array (
			'text' => '<b>ID:' . $adminInfo->auto_id . '</b>'
		);
		$contents = array (
			'form' => zen_draw_form('edit_admin', FILENAME_SEARCH_KEYWORD_SYNONYM, 'page=' . $_GET['page'] . '&search=' . $_GET['search'] . '&sort=' . $_GET['sort'] . '&auto_id=' . $adminInfo->auto_id . '&action=save', 'post', 'enctype="multipart/form-data"')
		);
		$contents[] = array (
			'text' => '<br>同义词-zh<br>' . zen_draw_input_field('keyword_chinese', $adminInfo->keyword_chinese, zen_set_field_length(TABLE_SEARCH_SYNONYM, 'keyword_chinese', $max = 30))
		);
		$contents[] = array (
			'text' => '<br>原词<br>' . zen_draw_input_field('keyword_main', $adminInfo->keyword_main, zen_set_field_length(TABLE_SEARCH_SYNONYM, 'keyword_main', $max = 30))
		);
		$contents[] = array (
			'text' => '<br>同义词<br>' . zen_draw_input_field('keyword_synonym', $adminInfo->keyword_synonym, zen_set_field_length(TABLE_SEARCH_SYNONYM, 'keyword_synonym', $max = 30))
		);
		$contents[] = array (
			'text' => '<br>状态<br>' . '<input type="radio" name="keyword_status" value="1" ' . ($adminInfo->keyword_status == 0 ? '' : 'checked') . ' >开启 <input type="radio" name="keyword_status" value="0" ' . ($adminInfo->keyword_status == 0 ? 'checked' : '') . ' >关闭'
		);

		$contents[] = array (
			'align' => 'center',
			'text' => '<br>' . zen_image_submit('button_save.gif', IMAGE_SAVE) . '&nbsp; <a href="' . zen_href_link(FILENAME_SEARCH_KEYWORD_SYNONYM,zen_get_all_get_params(array('action', 'auto_id')) . '&auto_id=' . $adminInfo->auto_id) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'
		);
		break;

		//-------------------------------------------------------------------------------------------------------------------------
	case 'delete' :
		$heading[] = array (
			'text' => '<b>ID:' . $adminInfo->auto_id . '</b>'
		);
		$contents = array (
			'form' => zen_draw_form('delete_from', FILENAME_SEARCH_KEYWORD_SYNONYM, 'page=' . $_GET['page'] . '&search=' . $_GET['search'] . '&sort=' . $_GET['sort'] . '&auto_id=' . $adminInfo->auto_id . '&action=deleteconfirm', 'post', 'enctype="multipart/form-data"')
		);
		$contents[] = array (
			'text' => '确定要删除当前记录吗？'
		);
		$contents[] = array (
			'text' => '<br><b>' . $adminInfo->keyword_chinese . '</b>'
		);
		$contents[] = array (
			'text' => '<br><b>' . $adminInfo->keyword_main . '</b>'
		);
		$contents[] = array (
			'text' => '<br><b>' . $adminInfo->keyword_synonym . '</b>'
		);
		$contents[] = array (
			'align' => 'center',
			'text' => '<br>' . zen_image_submit('button_delete.gif', IMAGE_DELETE) . '&nbsp;<a href="' . zen_href_link(FILENAME_SEARCH_KEYWORD_SYNONYM,zen_get_all_get_params(array('action', 'auto_id')) . '&auto_id=' . $adminInfo->auto_id) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'
		);
		break;

		/*-------------------------------------------------------------------------------------------------------------------------
		    case 'delete':
		    $heading[] = array('text' => '<b>' . TEXT_HEADING_DELETE_ADMIN . '</b>');
		    $contents = array('form' => zen_draw_form('delete_admin', FILENAME_SEARCH_KEYWORD_SYNONYM, 'page=' . $_GET['page'] . '&auto_id=' . $adminInfo->auto_id . '&action=deleteconfirm'));
		    $contents[] = array('text' => TEXT_DELETE_INTRO);
		    $contents[] = array('text' => '<br><b>' . $adminInfo->keyword_chinese . '</b>');
		    $contents[] = array('align' => 'center',
		                        'text' => '<br>' . zen_image_submit('button_delete.gif', IMAGE_DELETE) . '<a href="' . zen_href_link(FILENAME_SEARCH_KEYWORD_SYNONYM, 'page=' . $_GET['page'] . '&auto_id=' . $adminInfo->auto_id) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
		    break;
		  
		*/
	default :
		//-------------------------------------------------------------------------------------------------------------------------
		if (isset ($adminInfo) && is_object($adminInfo)) {
			$heading[] = array (
				'text' => '<b>ID:' . $adminInfo->auto_id . '</b>'
			);
			$contents[] = array (
				'text' => '<br/><b>同义词-zh:</b>' . $adminInfo->keyword_chinese
			);
			$contents[] = array (
				'text' => '<br/><b>原词:</b>' . $adminInfo->keyword_main
			);
			$contents[] = array (
				'text' => '<br/><b>同义词:</b>' . $adminInfo->keyword_synonym
			);
			$contents[] = array (
				'text' => '<br/><b>状态:</b>' . (!empty ($adminInfo->keyword_status) ? '开启' : '关闭')
			);
			$contents[] = array (
				'align' => 'center',
				'text' => '<a href="' . zen_href_link(FILENAME_SEARCH_KEYWORD_SYNONYM,zen_get_all_get_params(array('action', 'auto_id')) . '&auto_id=' . $adminInfo->auto_id . '&action=edit') . '">' . zen_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . zen_href_link(FILENAME_SEARCH_KEYWORD_SYNONYM,zen_get_all_get_params(array('action', 'auto_id')) . '&auto_id=' . $adminInfo->auto_id . '&action=delete') . '">' . zen_image_button('button_delete.gif', IMAGE_DELETE) . '</a>'
			);
		}

		break;
		//-------------------------------------------------------------------------------------------------------------------------
} // end switch action

if ((zen_not_null($heading)) && (zen_not_null($contents))) {
	echo '<td width="25%" valign="top">' . "\n";
	$box = new box;
	echo $box->infoBox($heading, $contents);
	echo '</td>' . "\n";
}
?>

	</tr>
</table>


		</td>
<!-- body_text_eof //-->
	</tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>