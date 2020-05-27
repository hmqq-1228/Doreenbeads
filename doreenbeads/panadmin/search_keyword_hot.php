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
			zen_redirect(zen_href_link(FILENAME_SEARCH_KEYWORD_HOT));
			break;
			//-------------------------------------------------------------------------------------------------------------------------
		case 'insert' :
		case 'save' :
		case 'deleteconfirm' :
			$error = false;
			if ($action == 'insert' || $action == 'save') {
				//去除左右空格、中文空格替换成英文空格、两个空格替换成一个空格
				$keyword_chinese = str_replace("  ", " ", str_replace("　", " ", trim($_POST['keyword_chinese'])));//两个空格或中文空格替换成一个空格
				$keyword = str_replace("  ", " ", str_replace("　", " ", trim($_POST['keyword'])));//两个空格或中文空格替换成一个空格
				$keyword_status = zen_db_prepare_input(trim($_POST['keyword_status']));

				if (empty ($keyword) || empty ($keyword_chinese)) {
					$error = true;
					$messageStack->add('请输入热搜词-zh和热搜词', 'error');
				}
			}

			if ($error == false) {
				if (isset ($_GET['auto_id']))
					$admins_id = zen_db_prepare_input($_GET['auto_id']);

				$sql_data_array = array (
					'languages_id' => $_SESSION['languages_id'],
					'keyword_chinese' => $keyword_chinese,
					'keyword' => $keyword,
					'keyword_status' => $keyword_status,
					'admin_email' => $_SESSION['admin_email'],
					'date_created' => 'now()'
				);
				if ($action == 'insert') {
					zen_db_perform(TABLE_SEARCH_HOT, $sql_data_array);
					$new_auto_id = zen_db_insert_id();
					$admins_id = $new_auto_id;

				}
				elseif ($action == 'save') {
					zen_db_perform(TABLE_SEARCH_HOT, $sql_data_array, 'update', "auto_id = '" . (int) $admins_id . "'");
				}
				elseif ($action == 'deleteconfirm') {

					$db->Execute("delete from " . TABLE_SEARCH_HOT . " where auto_id = '" . (int) $_GET['auto_id'] . "'");
					zen_redirect(zen_href_link(FILENAME_SEARCH_KEYWORD_HOT, (isset ($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . (isset ($_GET['search']) ? 'search=' . $_GET['search'] . '&' : '') . (isset ($_GET['sort']) ? 'sort=' . $_GET['sort'] . '&' : '')));

				}

				zen_redirect(zen_href_link(FILENAME_SEARCH_KEYWORD_HOT, (isset ($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . (isset ($_GET['search']) ? 'search=' . $_GET['search'] . '&' : '') . (isset ($_GET['sort']) ? 'sort=' . $_GET['sort'] . '&' : '') . 'auto_id=' . $admins_id));

			} // end error check

			//echo $action;
			//	zen_redirect(zen_href_link(FILENAME_SEARCH_KEYWORD_HOT, (isset($_GET['page']) ? 'page=' . '&' : '') . 'auto_id=' . $admins_id));
			break;
		case 'get_search_keyword_hot' :
			require_once(DIR_FS_CATALOG . DIR_WS_CLASSES . 'excel/PHPExcel.php');
		 	$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->setCellValue('A1', '语种');
			$objPHPExcel->getActiveSheet()->setCellValue('B1', '关键词');
			$objPHPExcel->getActiveSheet()->setCellValue('C1', '搜索次数');
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(34);
			
			$last_month = date("Y-m-d H:i:s", strtotime("-1 month"));
			$keyword_index = 2;
			$languages = zen_get_languages ();
			foreach($languages as $languages_info) {
				$keyword_hot_sql = "select sk_key_word, count(*) count from " . TABLE_SEARCH_KEYWORD . " where languages_id=" . $languages_info['id'] . " and sk_key_word!='' and sk_search_date>'" . $last_month . "' group by sk_key_word order by count desc limit 20";
				$keyword_hot_result = $db->Execute($keyword_hot_sql);

				while (!$keyword_hot_result->EOF) {
					$objPHPExcel->getActiveSheet()->setCellValue('A' . $keyword_index, $languages_info['id']);
					$objPHPExcel->getActiveSheet()->setCellValue('B' . $keyword_index, $keyword_hot_result->fields['sk_key_word']);
					$objPHPExcel->getActiveSheet()->setCellValue('C' . $keyword_index, $keyword_hot_result->fields['count']);
					
					$keyword_index++;
					$keyword_hot_result->MoveNext();
				}
			}
		
			header("Content-type:text/html;charset=utf-8"); 
			Header("Content-type: application/octet-stream");
			$file_name = '推荐热搜词' . date("Ymd") . '.xlsx';
			if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) {
				header('Content-type: application/octetstream');
			} else {
				header('Content-Type: application/x-octet-stream');
			}
			header('Content-Disposition: attachment; filename=' . iconv("utf-8", "gb2312", $file_name));
          	//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
          	$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            $objWriter->save('php://output'); //文件通过浏览器下载
            break;
	
		case 'get_search_keyword_hot_template' :
			$download = 'file/searck_keyword_recommend.xls';
			$file = fopen($download, "r");
			header("Content-type:text/html;charset=utf-8"); 
			Header("Content-type: application/octet-stream");
			Header("Accept-Ranges: bytes");
			Header("Accept-Length: " . filesize($download));
			$file_name = '热搜词上传模板.xlsx';
			if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) {
				header('Content-type: application/octetstream');
			} else {
				header('Content-Type: application/x-octet-stream');
			}
			header('Content-Disposition: attachment; filename=' . $file_name);
			echo fread($file, filesize($download));
			fclose($file);
			break;
		case 'import_search_keyword' :
			set_time_limit(0);
			@ ini_set('memory_limit', '256M');
			set_include_path('../Classes/');
			$startime = microtime(true);
			include 'PHPExcel.php';
			include 'PHPExcel/Reader/Excel5.php';
			$objReader = new PHPExcel_Reader_Excel5();

			$file = $_FILES['xlsx_file'];
			$filename = basename($file['name']);
			$ext_name = substr($filename, strrpos($filename, '.') + 1);

			$error = $error_empty = $error_has_exist = '';
			$i = 0;
			if (empty($ext_name)) {
				$error .= '请先选择文件';
			} else if ($ext_name != 'xlsx') {
				$error .= '文件格式有误，请上传xlsx格式的文件';
			} else {
				if (file_exists($file['tmp_name'])) {
					$objPHPExcel = $objReader->load($file['tmp_name']);
					$sheet = $objPHPExcel->getActiveSheet();
					
					for ($j = 2; $j <= $sheet->getHighestRow(); $j++) {
						$languages_id = zen_db_prepare_input($sheet->getCellByColumnAndRow(0, $j)->getValue());
						$keyword = zen_db_prepare_input($sheet->getCellByColumnAndRow(1, $j)->getValue());
						$keyword_chinese = zen_db_prepare_input($sheet->getCellByColumnAndRow(2, $j)->getValue());
						if (empty ($languages_id)) {
							$error_empty .= 'line' . $j . '语种信息为空' . '<br/>';
							continue;
						}
						if (empty ($languages_id)) {
							$error_empty .= 'line' . $j . '热搜词为空' . '<br/>';
							continue;
						}
						if (empty ($languages_id)) {
							$error_empty .= 'line' . $j . '热搜词-zh为空' . '<br/>';
							continue;
						}
						
							
						$sql_products_exist = "SELECT keyword FROM " . TABLE_SEARCH_HOT . " WHERE keyword = :keyword and languages_id = :languages_id limit 1";
						$sql_products_exist = $db->bindVars($sql_products_exist, ':keyword', $keyword, 'string');
						$sql_products_exist = $db->bindVars($sql_products_exist, ':languages_id', $languages_id, 'integer');
						$products_exist_result = $db->Execute($sql_products_exist);
						if ($products_exist_result->RecordCount() <= 0) {
							$keyword_data_array = array(
								'languages_id'=>$languages_id,
								'keyword_chinese'=>$keyword_chinese,
								'keyword'=>$keyword,
								'keyword_status'=>1,
								'admin_email'=>$_SESSION['admin_email'],
								'date_created'=>'now()'
							);
							zen_db_perform(TABLE_SEARCH_HOT, $keyword_data_array);
							
							$i++;
						}else{
							$error_has_exist .= '第' . $j . '行【热搜词：' . $keyword . '，语种：' . $languages_id .'】在热搜词表已存在，添加失败' . '<br/>';
							continue;
						}
						
						$operate_content = '新增搜索热搜词: ' . $keyword . "，语种：" . $languages_id;
						zen_insert_operate_logs($_SESSION['admin_id'], $products_model, $operate_content, 2);

					}
				} else {
					$error .= '未知错误' . '<br/>';
				}
				if (!empty ($error_empty)) {
					$error .= $error_empty;
				}
				if (!empty ($error_has_exist)) {
					$error .= $error_has_exist;
				}
			}
			if ($i > 0) {
				$success = '成功新增'. $i .'条记录';
				$messageStack->add_session($success, 'success');
			}
			if (!empty ($error)) {
				$messageStack->add_session($error, 'error');
			}
			zen_redirect(zen_href_link(FILENAME_SEARCH_KEYWORD_HOT, zen_get_all_get_params(array (
					'action'
				)), 'NONSSL'));
			
			break;

			/*-------------------------------------------------------------------------------------------------------------------------
			    case 'deleteconfirm':
			      $new_auto_id = zen_db_prepare_input($_GET['auto_id']);
			      $db->Execute("delete from " . TABLE_SEARCH_HOT . " where auto_id = '" . (int)$new_auto_id . "'");
			      $operate_content= $_GET['auto_id'].'用户被关闭';
			      zen_insert_operate_logs($_SESSION['auto_id'],$_GET['auto_id'],$operate_content,4);
			    	zen_redirect(zen_href_link(FILENAME_SEARCH_KEYWORD_HOT, 'page=' . $_GET['page']).(isset($_GET['search']) ? 'search=' . $_GET['search'] . '&' : '') . (isset($_GET['sort']) ? 'sort=' . $_GET['sort'] . '&' : '') );
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
		<td class="pageHeading">热搜词设置</td>
		<td align="right">
		<table border="0" width="20%" cellspacing="0" cellpadding="0">
			<tr>
				<td style="text-align:right; line-height:28px;">
					<?php
	
	echo zen_draw_form('search', FILENAME_SEARCH_KEYWORD_HOT, '', 'get', 'id="search_form"', true);
	echo '状态： ' . zen_draw_pull_down_menu('keyword_status', array(array('id' => '', 'text' => '所有'), array('id' => '1', 'text' => '开启'), array('id' => '0', 'text' => '关闭')), $_GET['keyword_status']) . '<br/>';
	echo '排序： ' . zen_draw_pull_down_menu('sort', array(array('id' => '2', 'text' => '添加时间'), array('id' => '10', 'text' => '按总点击次数降序'), array('id' => '20', 'text' => '按近一个月点击次数降序')), $_GET['sort']) . '<br/>';
	echo '关键词： ' . zen_draw_input_field('search', ((isset ($_GET['search']) && zen_not_null($_GET['search'])) ? zen_db_input(zen_db_prepare_input($_GET['search'])) : ''), 'style="width:175px;" id="search_text"') . '<br/>';
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
		<td width="25%" class="dataTableHeadingContent">热搜词-zh</td>
		<td width="25%" class="dataTableHeadingContent">热搜词</td>
		<td width="10%" class="dataTableHeadingContent">总点击次数</td>
		<td width="15%" class="dataTableHeadingContent">近一个月点击次数</td>
		<td width="8%" class="dataTableHeadingContent">状态</td>
		<td width="7%" class="dataTableHeadingContent" align="right">操作</td>
</tr>

<?php

$search_query = '';
if (isset ($_GET['search']) && zen_not_null($_GET['search'])) {
	$para_search = zen_db_input(zen_db_prepare_input($_GET['search']));
	$search_query = ' and (keyword_chinese like "%' . $para_search . '%" or keyword like "%' . $para_search . '%")';
}

if (isset ($_GET['keyword_status']) && zen_not_null($_GET['keyword_status']) && is_numeric($_GET['keyword_status']) != '') {
	$keyword_status = zen_db_input(zen_db_prepare_input($_GET['keyword_status']));
	$search_query .= ' and keyword_status=' . $keyword_status;
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
		case 10 :
			$para_sort = ' order by search_count_all DESC, auto_id DESC';
			break;
		case 20 :
			$para_sort = ' order by search_count_month DESC, auto_id DESC';
			break;
		default:
			$para_sort = ' order by auto_id DESC';
	}

} else {
	$para_sort = ' order by auto_id DESC';
}

$admins_query_raw = "select * from " . TABLE_SEARCH_HOT . " where languages_id=" . $_SESSION['languages_id'] . $search_query . $para_sort;
$admins_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $admins_query_raw, $admins_query_numrows);
$admins = $db->Execute($admins_query_raw);

while (!$admins->EOF) {
	if ((!isset ($_GET['auto_id']) || (isset ($_GET['auto_id']) && ($_GET['auto_id'] == $admins->fields['auto_id']))) && !isset ($adminInfo) && (substr($action, 0, 3) != 'new')) {
		$adminInfo = new objectInfo($admins->fields);
	}

	if (isset ($adminInfo) && is_object($adminInfo) && ($admins->fields['auto_id'] == $adminInfo->auto_id)) {
		echo '<tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_SEARCH_KEYWORD_HOT,zen_get_all_get_params(array('action', 'auto_id')) . '&auto_id=' . $admins->fields['auto_id'] . '&action=edit') . '\'">' . "\n";
	} else {
		echo '<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_SEARCH_KEYWORD_HOT,zen_get_all_get_params(array('action', 'auto_id')) . '&auto_id=' . $admins->fields['auto_id'] . '') . '\'">' . "\n";
	}
?>

		<td class="dataTableContent"><?php echo $admins->fields['auto_id']; ?></td>
		<td class="dataTableContent"><?php echo $admins->fields['keyword_chinese']; ?></td>
		<td class="dataTableContent"><?php echo $admins->fields['keyword']; ?></td>
		<td class="dataTableContent"><?php echo $admins->fields['search_count_all']; ?></td>
		<td class="dataTableContent"><?php echo $admins->fields['search_count_month']; ?></td>
		<td class="dataTableContent"><?php echo $admins->fields['keyword_status']==1?zen_image(DIR_WS_IMAGES . 'icon_green_on.gif', IMAGE_ICON_STATUS_ON):zen_image(DIR_WS_IMAGES . 'icon_red_on.gif', IMAGE_ICON_STATUS_OFF);?></td>
		<td class="dataTableContent" align="right">
<?php echo '<a href="' . zen_href_link(FILENAME_SEARCH_KEYWORD_HOT,zen_get_all_get_params(array('action', 'auto_id')) . '&auto_id=' . $admins->fields['auto_id'] . '&action=edit') . '">' . zen_image(DIR_WS_IMAGES . 'icon_edit.gif', ICON_EDIT) . '</a>'; ?>&nbsp;
<?php
 /* echo '<a href="' . zen_href_link(FILENAME_SEARCH_KEYWORD_HOT, 'page=' . $_GET['page'] . '&auto_id=' . $admins->fields['auto_id'] . '&action=delete') . '">' . zen_image(DIR_WS_IMAGES . 'icon_delete.gif', ICON_DELETE) . '</a>';*/
?>
<?php if (isset($adminInfo) && is_object($adminInfo) && ($admins->fields['auto_id'] == $adminInfo->auto_id)) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . zen_href_link(FILENAME_SEARCH_KEYWORD_HOT, 'page=' . $_GET['page'] . '&search='.$_GET['search'] . '&sort=' . $_GET['sort'] . '&auto_id=' . $admins->fields['auto_id']) . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?></td>
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
		<td align="left" colspan="2" class="smallText">
<?php

	echo '<a href="' . zen_href_link(FILENAME_SEARCH_KEYWORD_HOT,zen_get_all_get_params(array('action', 'auto_id')) . '&action=get_search_keyword_hot') . '" target="_blank"><input type="button" value="获取推荐热搜词" style="cursor:pointer;" /></a>';
?>
		</td>
		<td align="right" colspan="3" class="smallText">
<?php

	echo '<a href="' . zen_href_link(FILENAME_SEARCH_KEYWORD_HOT,zen_get_all_get_params(array('action', 'auto_id')) . '&auto_id=' . $adminInfo->auto_id . '&action=new') . '">' . zen_image_button('button_insert.gif', IMAGE_INSERT) . '</a>';
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
			'text' => '<b>添加热搜词</b>'
		);
		$contents = array (
			'form' => zen_draw_form('new_admin', FILENAME_SEARCH_KEYWORD_HOT, 'action=insert', 'post', 'enctype="multipart/form-data"')
		);
		$contents[] = array (
			'text' => '<br>热搜词-zh<br>' . zen_draw_input_field('keyword_chinese', '', zen_set_field_length(TABLE_SEARCH_HOT, 'keyword_chinese', $max = 30))
		);
		$contents[] = array (
			'text' => '<br>热搜词<br>' . zen_draw_input_field('keyword', '', zen_set_field_length(TABLE_SEARCH_HOT, 'keyword', $max = 30))
		);
		$contents[] = array (
			'text' => '<br>状态<br>' . zen_draw_radio_field('keyword_status', '1', true) . '开启&nbsp;&nbsp;&nbsp;&nbsp;' . zen_draw_radio_field('keyword_status', '1', false) . '关闭'
		);
		$contents[] = array (
			'align' => 'center',
			'text' => '<br>' . zen_image_submit('button_save.gif', IMAGE_SAVE) . '&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_SEARCH_KEYWORD_HOT, 'page=' . $_GET['page'] . '&search=' . $_GET['search'] . '&sort=' . $_GET['sort'] . '&auto_id=' . $_GET['auto_id']) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'
		);
		break;

		//-------------------------------------------------------------------------------------------------------------------------
	case 'edit' :
		$heading[] = array (
			'text' => '<b>ID:' . $adminInfo->auto_id . '</b>'
		);
		$contents = array (
			'form' => zen_draw_form('edit_admin', FILENAME_SEARCH_KEYWORD_HOT, 'page=' . $_GET['page'] . '&search=' . $_GET['search'] . '&sort=' . $_GET['sort'] . '&auto_id=' . $adminInfo->auto_id . '&action=save', 'post', 'enctype="multipart/form-data"')
		);
		$contents[] = array (
			'text' => '<br>热搜词-zh<br>' . zen_draw_input_field('keyword_chinese', $adminInfo->keyword_chinese, zen_set_field_length(TABLE_SEARCH_HOT, 'keyword_chinese', $max = 30))
		);
		$contents[] = array (
			'text' => '<br>热搜词<br>' . zen_draw_input_field('keyword', $adminInfo->keyword, zen_set_field_length(TABLE_SEARCH_HOT, 'keyword', $max = 30))
		);
		$contents[] = array (
			'text' => '<br>状态<br>' . '<input type="radio" name="keyword_status" value="1" ' . ($adminInfo->keyword_status == 0 ? '' : 'checked') . ' >开启 <input type="radio" name="keyword_status" value="0" ' . ($adminInfo->keyword_status == 0 ? 'checked' : '') . ' >关闭'
		);

		$contents[] = array (
			'align' => 'center',
			'text' => '<br>' . zen_image_submit('button_save.gif', IMAGE_SAVE) . '&nbsp; <a href="' . zen_href_link(FILENAME_SEARCH_KEYWORD_HOT, 'page=' . $_GET['page'] . '&search=' . $_GET['search'] . '&sort=' . $_GET['sort'] . '&auto_id=' . $adminInfo->auto_id) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'
		);
		break;

		//-------------------------------------------------------------------------------------------------------------------------
	case 'delete' :
		$heading[] = array (
			'text' => '<b>ID:' . $adminInfo->auto_id . '</b>'
		);
		$contents = array (
			'form' => zen_draw_form('delete_from', FILENAME_SEARCH_KEYWORD_HOT, 'page=' . $_GET['page'] . '&search=' . $_GET['search'] . '&sort=' . $_GET['sort'] . '&auto_id=' . $adminInfo->auto_id . '&action=deleteconfirm', 'post', 'enctype="multipart/form-data"')
		);
		$contents[] = array (
			'text' => '确定要删除当前记录吗？'
		);
		$contents[] = array (
			'text' => '<br><b>' . $adminInfo->keyword_chinese . '</b>'
		);
		$contents[] = array (
			'text' => '<br><b>' . $adminInfo->keyword . '</b>'
		);
		$contents[] = array (
			'align' => 'center',
			'text' => '<br>' . zen_image_submit('button_delete.gif', IMAGE_DELETE) . '&nbsp;<a href="' . zen_href_link(FILENAME_SEARCH_KEYWORD_HOT,zen_get_all_get_params(array('action', 'auto_id')) . '&auto_id=' . $adminInfo->auto_id) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'
		);
		break;

		/*-------------------------------------------------------------------------------------------------------------------------
		    case 'delete':
		    $heading[] = array('text' => '<b>' . TEXT_HEADING_DELETE_ADMIN . '</b>');
		    $contents = array('form' => zen_draw_form('delete_admin', FILENAME_SEARCH_KEYWORD_HOT, 'page=' . $_GET['page'] . '&auto_id=' . $adminInfo->auto_id . '&action=deleteconfirm'));
		    $contents[] = array('text' => TEXT_DELETE_INTRO);
		    $contents[] = array('text' => '<br><b>' . $adminInfo->keyword_chinese . '</b>');
		    $contents[] = array('align' => 'center',
		                        'text' => '<br>' . zen_image_submit('button_delete.gif', IMAGE_DELETE) . '<a href="' . zen_href_link(FILENAME_SEARCH_KEYWORD_HOT, 'page=' . $_GET['page'] . '&auto_id=' . $adminInfo->auto_id) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
		    break;
		  
		*/
	default :
		//-------------------------------------------------------------------------------------------------------------------------
		if (isset ($adminInfo) && is_object($adminInfo)) {
			$heading[] = array (
				'text' => '<b>ID:' . $adminInfo->auto_id . '</b>'
			);
			$contents[] = array (
				'text' => '<br/><b>热搜词-zh:</b>' . $adminInfo->keyword_chinese
			);
			$contents[] = array (
				'text' => '<br/><b>热搜词:</b>' . $adminInfo->keyword
			);
			$contents[] = array (
				'text' => '<br/><b>状态:</b>' . (!empty ($adminInfo->keyword_status) ? '开启' : '关闭')
			);
			$contents[] = array (
				'align' => 'center',
				'text' => '<a href="' . zen_href_link(FILENAME_SEARCH_KEYWORD_HOT,zen_get_all_get_params(array('action', 'auto_id')) . '&auto_id=' . $adminInfo->auto_id . '&action=edit') . '">' . zen_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . zen_href_link(FILENAME_SEARCH_KEYWORD_HOT, 'page=' . $_GET['page'] . '&search=' . $_GET['search'] . '&sort=' . $_GET['sort'] . '&auto_id=' . $adminInfo->auto_id . '&action=delete') . '">' . zen_image_button('button_delete.gif', IMAGE_DELETE) . '</a>'
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

<form enctype="multipart/form-data" method="post" action="<?php echo zen_href_link(FILENAME_SEARCH_KEYWORD_HOT,zen_get_all_get_params(array('action', 'auto_id')) . 'action=import_search_keyword');?>">
<tr style="line-height:38px; font-size:16px;">
	<td align="left" colspan="5" style="padding-left:26px;">
		批量导入热搜词：<input type="file" id="xlsx_file" name="xlsx_file"> <a href="<?php echo zen_href_link(FILENAME_SEARCH_KEYWORD_HOT,zen_get_all_get_params(array('action', 'auto_id')) . 'action=get_search_keyword_hot_template');?>" target="_blank">下载EXCEL模板</a><br/>
		<input style="font-size:16px; padding:0px 10px 0px 10px;" type="submit" value="上传" /><br/>
	</td>
</tr>
</form>

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