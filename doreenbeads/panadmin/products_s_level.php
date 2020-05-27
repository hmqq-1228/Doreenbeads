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
?>
<?php


$action = (isset ($_GET['action']) ? $_GET['action'] : '');

if (zen_not_null($action)) {

	switch ($action) {
		// demo active test
		case (zen_admin_demo()) :
			$action = '';
			$messageStack->add_session(ERROR_ADMIN_DEMO, 'caution');
			zen_redirect(zen_href_link(FILENAME_PRODUCTS_S_LEVEL));
			break;
			//-------------------------------------------------------------------------------------------------------------------------
		case 'get_template' :
			$download = 'file/products_s_level.xlsx';
			$file = fopen($download, "r");
			header("Content-type:text/html;charset=utf-8"); 
			Header("Content-type: application/octet-stream");
			Header("Accept-Ranges: bytes");
			Header("Accept-Length: " . filesize($download));
			$file_name = '新建不更新库存商品' . date("Ymd") . '.xlsx';
			if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) {
				header('Content-type: application/octetstream');
			} else {
				header('Content-Type: application/x-octet-stream');
			}
			header('Content-Disposition: attachment; filename=' . $file_name);
			echo fread($file, filesize($download));
			fclose($file);
			exit;

		case 'get_template_del' :
			$download = 'file/products_s_level_del.xlsx';
			$file = fopen($download, "r");
			header("Content-type:text/html;charset=utf-8"); 
			Header("Content-type: application/octet-stream");
			Header("Accept-Ranges: bytes");
			Header("Accept-Length: " . filesize($download));
			$file_name = '新建删除不更新库存商品' . date("Ymd") . '.xlsx';
			if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) {
				header('Content-type: application/octetstream');
			} else {
				header('Content-Type: application/x-octet-stream');
			}
			header('Content-Disposition: attachment; filename=' . $file_name);
			echo fread($file, filesize($download));
			fclose($file);
			exit;

		case 'upload' :
			set_time_limit(0);
			@ ini_set('memory_limit', '256M');
			set_include_path('../Classes/');
			$startime = microtime(true);
			include 'PHPExcel.php';
			include 'PHPExcel/Reader/Excel2007.php';
			$objReader = new PHPExcel_Reader_Excel2007();

			$file = $_FILES['xlsx_file'];
			$filename = basename($file['name']);
			$ext_name = substr($filename, strrpos($filename, '.') + 1);

			$error = $error_empty = $error_no_exist = $error_not_sale = $error_duplicate = '';
			if (empty($ext_name)) {
				$error .= '请先选择文件';
			} else if ($ext_name != 'xlsx') {
				$error .= '文件格式有误，请上传xlsx格式的文件';
			} else {
				if (file_exists($file['tmp_name'])) {
					$objPHPExcel = $objReader->load($file['tmp_name']);
					$sheet = $objPHPExcel->getActiveSheet();
					for ($j = 2; $j <= $sheet->getHighestRow(); $j++) {
						$products_model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0, $j)->getValue());
						$comment = zen_db_prepare_input($sheet->getCellByColumnAndRow(1, $j)->getValue());
						$number = $j -1;
						if (empty ($products_model)) {
							$error_empty .= 'line' . $j . '商品编号为空' . '<br/>';
							continue;
						}
						$sql_products_id = "SELECT products_id, products_status, products_limit_stock FROM " . TABLE_PRODUCTS . " WHERE products_model = :products_model limit 1";
						$sql_products_id = $db->bindVars($sql_products_id, ':products_model', $products_model, 'string');
						$products_id_result = $db->Execute($sql_products_id);
						if ($products_id_result->RecordCount() > 0) {
							if ($products_id_result->fields['products_status'] != "1" || $products_id_result->fields['products_limit_stock'] == "1") {
								$error_not_sale .= $products_model . ",";
								continue;
							} else {
								$sql_products_exist = "SELECT products_model FROM " . TABLE_PRODUCTS_S_LEVEL . " WHERE products_model = :products_model limit 1";
								$sql_products_exist = $db->bindVars($sql_products_exist, ':products_model', $products_model, 'string');
								$products_exist_result = $db->Execute($sql_products_exist);
								if ($products_exist_result->RecordCount() > 0) {
									$error_duplicate .= $products_model . ",";
									continue;
								}
							}

						} else {
							$error_no_exist .= $products_model . ",";
							continue;
						}
						$sql_data_array = array (
							'products_id' => $products_id_result->fields['products_id'],
							'products_model' => $products_model,
							'date_created' => 'now()',
							'admin_email' => $_SESSION['admin_email'],
							'comment' => $comment
						);
						zen_db_perform(TABLE_PRODUCTS_S_LEVEL, $sql_data_array);
						$db->Execute("update " . TABLE_PRODUCTS_STOCK . " set products_quantity=50000, modify_time=" . time() . " where products_id=" . $products_id_result->fields['products_id']);
						
						$operate_content = '新增不更新库存商品: ' . $products_model;
						zen_insert_operate_logs($_SESSION['admin_id'], $products_model, $operate_content, 2);

					}
				} else {
					$error .= '未知错误' . '<br/>';
				}
				if (!empty ($error_empty)) {
					$error .= $error_empty;
				}
				if (!empty ($error_no_exist)) {
					$error .= substr($error_no_exist, 0, -1) . '不存在<br/>';
				}
				if (!empty ($error_not_sale)) {
					$error .= substr($error_not_sale, 0, -1) . '为滞销/下架状态商品<br/>';
					;
				}
				if (!empty ($error_duplicate)) {
					$error .= substr($error_duplicate, 0, -1) . '已存在于不更新库存表中';
				}
			}
			if (!empty ($error)) {
				$messageStack->add_session($error, 'error');
			}
			zen_redirect(zen_href_link(FILENAME_PRODUCTS_S_LEVEL, zen_get_all_get_params(array (
					'action'
				)), 'NONSSL'));
			break;
		case 'save' :
		case 'deleteconfirm' :
			$auto_id = zen_db_prepare_input($_GET['auto_id']);
			$products_model = zen_db_prepare_input($_GET['products_model']);
			$error = '';
			$sql = "delete FROM " . TABLE_PRODUCTS_S_LEVEL . " WHERE auto_id = :auto_id limit 1";
			$sql = $db->bindVars($sql, ':auto_id', $auto_id, 'string');
			$result = $db->Execute($sql);
			$operate_content = '删除不更新库存商品: ' . $products_model;
			zen_insert_operate_logs($_SESSION['admin_id'], $products_model, $operate_content, 2);
			$error = $operate_content . '成功';

			$messageStack->add_session($error, 'success');
			zen_redirect(zen_href_link(FILENAME_PRODUCTS_S_LEVEL, zen_get_all_get_params(array (
				'action',
				'products_model'
			)), 'NONSSL'));
			break;
		case 'truncate' :
			$error = '';
			$sql = "truncate table " . TABLE_PRODUCTS_S_LEVEL;
			$result = $db->Execute($sql);
			if ($result) {
				$operate_content = '清空不更新库存商品';
				zen_insert_operate_logs($_SESSION['admin_id'], 'ALL', $operate_content, 2);
				$error = $operate_content . '成功';

				$messageStack->add_session($error, 'success');
			} else {
				$operate_content = '清空不更新库存商品';
				zen_insert_operate_logs($_SESSION['admin_id'], 'ALL', $operate_content, 2);
				$error = $operate_content . '失败';

				$messageStack->add_session($error, 'error');
			}

			zen_redirect(zen_href_link(FILENAME_PRODUCTS_S_LEVEL, zen_get_all_get_params(array (
				'action'
			)), 'NONSSL'));
			break;

			case 'delete_all':
				set_time_limit(0);
				@ ini_set('memory_limit', '256M');
				set_include_path('../Classes/');
				$startime = microtime(true);
				include 'PHPExcel.php';
				include 'PHPExcel/Reader/Excel2007.php';
				$objReader = new PHPExcel_Reader_Excel2007();

				$file = $_FILES['xlsx_file'];
				$filename = basename($file['name']);
				$ext_name = substr($filename, strrpos($filename, '.') + 1);

				$error = $error_empty = $error_no_exist = $error_not_sale = $error_duplicate = '';
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
							$products_model = zen_db_prepare_input($sheet->getCellByColumnAndRow(0, $j)->getValue());
							$number = $j -1;
							if (empty ($products_model)) {
								$error_empty .= 'line' . $j . '商品编号为空' . '<br/>';
								continue;
							}
							
								
							$sql_products_exist = "SELECT products_model FROM " . TABLE_PRODUCTS_S_LEVEL . " WHERE products_model = :products_model limit 1";
							$sql_products_exist = $db->bindVars($sql_products_exist, ':products_model', $products_model, 'string');
							$products_exist_result = $db->Execute($sql_products_exist);
							if ($products_exist_result->RecordCount() > 0) {
								$sql_products_delete = "DELETE FROM " . TABLE_PRODUCTS_S_LEVEL . " WHERE products_model = :products_model limit 1";
								$sql_products_delete = $db->bindVars($sql_products_delete, ':products_model', $products_model, 'string');
								$products_exist_result = $db->Execute($sql_products_delete);
								$i++;
							}else{
								$error_no_exist = $products_model . '在不更新库存商品表中不存在，删除失败';
								continue;
							}
							
							$operate_content = '删除不更新库存商品: ' . $products_model;
							zen_insert_operate_logs($_SESSION['admin_id'], $products_model, $operate_content, 2);

						}
					} else {
						$error .= '未知错误' . '<br/>';
					}
					if (!empty ($error_empty)) {
						$error .= $error_empty;
					}
					if (!empty ($error_no_exist)) {
						$error .= $error_no_exist;
					}
				}
				if ($i > 0) {
					$success = '成功删除'. $i .'条记录';
					$messageStack->add_session($success, 'success');
				}
				if (!empty ($error)) {
					$messageStack->add_session($error, 'error');
				}
				zen_redirect(zen_href_link(FILENAME_PRODUCTS_S_LEVEL, zen_get_all_get_params(array (
						'action'
					)), 'NONSSL'));
				break;

			/*-------------------------------------------------------------------------------------------------------------------------
			    case 'deleteconfirm':
			      $new_auto_id = zen_db_prepare_input($_GET['auto_id']);
			      $db->Execute("delete from " . TABLE_PRODUCTS_S_LEVEL . " where auto_id = '" . (int)$new_auto_id . "'");
			      $operate_content= $_GET['auto_id'].'用户被关闭';
			      zen_insert_operate_logs($_SESSION['auto_id'],$_GET['auto_id'],$operate_content,4);
			    	zen_redirect(zen_href_link(FILENAME_PRODUCTS_S_LEVEL, 'page=' . $_GET['page']).(isset($_GET['search']) ? 'search=' . $_GET['search'] . '&' : '') . (isset($_GET['sort']) ? 'sort=' . $_GET['sort'] . '&' : '') );
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
<?php echo "<script> window.lang_wdate='".$_SESSION['languages_code']."'; </script>";?>
<script type="text/javascript" src="../includes/templates/cherry_zen/jscript/My97DatePicker/WdatePicker.js"></script>
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
		<td class="pageHeading">不更新库存商品管理</td>
		<td align="right">
		<table border="0" width="30%" cellspacing="0" cellpadding="0">
		<tr>
			<td align="right" style="line-height:32px;">
				<?php
				echo zen_draw_form('search', FILENAME_PRODUCTS_S_LEVEL, '', 'get', 'id="search_form"', true);
				echo '添加日期： ' . zen_draw_input_field('date_start', ((isset ($_GET['date_start']) && zen_not_null($_GET['date_start'])) ? zen_db_input(zen_db_prepare_input($_GET['date_start'])) : ''), 'onClick="WdatePicker();"  onfocus="RemoveFormatString(this, \'' . DATE_FORMAT_STRING . '\')" class="Wdate" style="width:92px;" id="date_start"') . '-' .  zen_draw_input_field('date_end', ((isset ($_GET['date_end']) && zen_not_null($_GET['date_end'])) ? zen_db_input(zen_db_prepare_input($_GET['date_end'])) : ''), 'onClick="WdatePicker();"  onfocus="RemoveFormatString(this, \'' . DATE_FORMAT_STRING . '\')" class="Wdate" style="width:105px;" id="date_end"');
				?>
				<?php echo "<input type='submit' value='筛选'>"; ?>
				</form>
				<br/>
				<?php
				echo zen_draw_form('search', FILENAME_PRODUCTS_S_LEVEL, '', 'get', 'id="search_form"', true);
				echo '搜索： ' . zen_draw_input_field('search', ((isset ($_GET['search']) && zen_not_null($_GET['search'])) ? zen_db_input(zen_db_prepare_input($_GET['search'])) : ''), 'style="width:204px; color:#333333" id="search_text"  onblur="if(this.value==\'\')this.value=\'产品编号、操作人邮箱\', this.style.color=\'#333333\'" onfocus="if(this.value==\'产品编号、操作人邮箱\')this.value=\'\', this.style.color=\'#000\'" value="产品编号、操作人邮箱"');
				?>
				<?php echo "<input type='submit' value='确定'>"; ?>
				</form>
				<br/>
				<?php
				echo zen_draw_form('search', FILENAME_PRODUCTS_S_LEVEL, '', 'get', 'id="search_comment"', true);
				echo '搜索： ' . zen_draw_input_field('comment', ((isset ($_GET['comment']) && zen_not_null($_GET['comment'])) ? zen_db_input(zen_db_prepare_input($_GET['comment'])) : ''), 'style="width:204px; color:#333333" id="search_comment"  placeholder = "备注"');
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
		<td width="20%" class="dataTableHeadingContent">商品编号</td>
		<td width="25%" class="dataTableHeadingContent">添加时间</td>
		<td width="15%" class="dataTableHeadingContent">操作人</td>
		<td width="20%" class="dataTableHeadingContent">备注</td>
		<td width="10%" class="dataTableHeadingContent" align="center">操作</td>
</tr>

<?php
$date_start = zen_db_input(zen_db_prepare_input($_GET['date_start']));
$date_end = zen_db_input(zen_db_prepare_input($_GET['date_end']));
$para_search  = zen_db_input(zen_db_prepare_input($_GET['search']));
$search_comment  = zen_db_input(zen_db_prepare_input($_GET['comment']));
$search_query = '';

if (zen_not_null($para_search)) {
	if($para_search != '产品编号、操作人邮箱') {
		$search_query = ' and (products_model like "%' . $para_search . '%" or admin_email like "%' . $para_search . '%")';
	}
} else if(!empty($date_start) || !empty($date_end)) {
	if(!empty($date_start)) {
		$date_start .= ' 00:00:00';
		$search_query .= ' and date_created>="' . $date_start . '"';
	}
	if(!empty($date_end)) {
		$date_end .= ' 23:59:59';
		$search_query .= ' and date_created<="' . $date_end . '"';
	}
} else if (zen_not_null($search_comment)){ 
	$search_query = ' and (comment like "%' . $search_comment . '%")';	
} else {
	$search_query = '';
}

$para_sort = ' order by auto_id DESC';


$admins_query_raw = "select * from " . TABLE_PRODUCTS_S_LEVEL . " where 1=1" . $search_query . $para_sort;
$admins_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $admins_query_raw, $admins_query_numrows);
$admins = $db->Execute($admins_query_raw);

while (!$admins->EOF) {
	if ((!isset ($_GET['auto_id']) || (isset ($_GET['auto_id']) && ($_GET['auto_id'] == $admins->fields['auto_id']))) && !isset ($adminInfo) && (substr($action, 0, 3) != 'new')) {
		$adminInfo = new objectInfo($admins->fields);
	}

	if (isset ($adminInfo) && is_object($adminInfo) && ($admins->fields['auto_id'] == $adminInfo->auto_id)) {
		echo '<tr class="dataTableRow" id="defaultSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" ">' . "\n";
	} else {
		echo '<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" ">' . "\n";
	}
?>

		<td class="dataTableContent"><?php echo $admins->fields['auto_id']; ?></td>
		<td class="dataTableContent"><?php echo $admins->fields['products_model']; ?></td>
		<td class="dataTableContent"><?php echo $admins->fields['date_created']; ?></td>
		<td class="dataTableContent"><?php echo $admins->fields['admin_email']; ?></td>
		<td class="dataTableContent"><?php echo $admins->fields['comment'] == '' ? '/':$admins->fields['comment']; ?></td>
		<td class="dataTableContent" align="center">
<?php


	/* echo '<a href="' . zen_href_link(FILENAME_PRODUCTS_S_LEVEL, 'page=' . $_GET['page'] . '&auto_id=' . $admins->fields['auto_id'] . '&action=delete') . '">' . zen_image(DIR_WS_IMAGES . 'icon_delete.gif', ICON_DELETE) . '</a>';*/
?>
<?php echo '<a onClick="javascript:return confirm(\'确定从不更新库存表中删除吗?\');" href="' . zen_href_link(FILENAME_PRODUCTS_S_LEVEL, 'action=deleteconfirm&page=' . $_GET['page'] . '&search='.$_GET['search'] . '&sort=' . $_GET['sort'] . '&auto_id=' . $admins->fields['auto_id'] . '&products_model=' . $admins->fields['products_model']) . '">' . zen_image(DIR_WS_IMAGES . 'icon_delete.gif', ICON_DELETE) . '</a>'; ?></td>
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


	echo '<a onClick="javascript:return confirm(\'确定清空不更新库存表中的商品?\');" href="' . zen_href_link(FILENAME_PRODUCTS_S_LEVEL, 'page=' . $_GET['page'] . '&search=' . $_GET['search'] . '&sort=' . $_GET['sort'] . '&auto_id=' . $adminInfo->auto_id . '&action=truncate') . '"><input type="button" value="清空所有商品" /></a>';
	//echo '<input type="button" value="清空所有商品" onclick="javascript:window.location.href=' . zen_href_link(FILENAME_PRODUCTS_S_LEVEL, 'action=empty&page=' . $_GET['page'] . '&search=' . $_GET['search'] . '&sort=' . $_GET['sort'] . '&auto_id=' . $adminInfo->auto_id) . '">';
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
	<form enctype="multipart/form-data" method="post" action="<?php echo zen_href_link(FILENAME_PRODUCTS_S_LEVEL, 'page=' . $_GET['page'] . '&search=' . $_GET['search'] . '&sort=' . $_GET['sort'] . '&auto_id=' . $adminInfo->auto_id . '&action=upload');?>">
	<tr style="line-height:38px; font-size:16px;">
		<td align="left" colspan="5" style="padding-left:26px;">
			新增不更新库存商品<br/>
			File：<input type="file" id="xlsx_file" name="xlsx_file"> <a href="<?php echo zen_href_link(FILENAME_PRODUCTS_S_LEVEL, 'action=get_template');?>" target="_blank">下载EXCEL模版</a><br/>
			<input style="font-size:16px; padding:0px 10px 0px 10px;" type="submit" value="提交" /><br/>
		</td>
	</tr>
	</form>
	<br/>
	<form enctype="multipart/form-data" method="post" action="<?php echo zen_href_link(FILENAME_PRODUCTS_S_LEVEL, 'page=' . $_GET['page'] . '&search=' . $_GET['search'] . '&sort=' . $_GET['sort'] . '&auto_id=' . $adminInfo->auto_id . '&action=delete_all');?>">
	<tr style="line-height:38px; font-size:16px;">
		<td align="left" colspan="5" style="padding-left:26px;">
			批量删除不更新库存商品<br/>
			File：<input type="file" id="xlsx_file" name="xlsx_file"> <a href="<?php echo zen_href_link(FILENAME_PRODUCTS_S_LEVEL, 'action=get_template_del');?>" target="_blank">下载EXCEL模版</a><br/>
			<input style="font-size:16px; padding:0px 10px 0px 10px;" type="submit" value="提交" /><br/>
		</td>
	</tr>
	</form>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>