<?php
require ('includes/application_top.php');

$action = (isset ($_REQUEST['action']) ? $_REQUEST['action'] : '');
$date_now = date("Y-m-d H:i:s");
$date_created_start = trim(zen_db_prepare_input($_GET['date_created_start']));
$date_created_end = trim(zen_db_prepare_input($_GET['date_created_end']));
$products_model = trim(zen_db_prepare_input($_GET['products_model']));
$admin_email = trim(zen_db_prepare_input($_GET['admin_email']));

if(zen_not_null($products_model)){
	$search_query .= ' and products_model = "' . $products_model . '"';
}

if(zen_not_null($admin_email)){
	$search_query .= ' and add_admin like "%' . $admin_email . '%"';
}

if(zen_not_null($date_created_start)) {
	$search_query .= ' and add_datetime >= "' . $date_created_start . '"';
}

if(zen_not_null($date_created_end)) {
	$search_query .= ' and add_datetime <= "' . $date_created_end . '"';
}

if (zen_not_null($action)) {
	switch ($action) {
		case 'delete':
			$nas_id = trim(zen_db_prepare_input($_GET['Nid']));
			
			if($nas_id > 0){
				$sql_delete = 'delete from ' . TABLE_PRODUCTS_NON_ACCESSORIES . ' where nas_id = ' . $nas_id;
				$db->Execute($sql_delete);
				
			}
			zen_redirect(zen_href_link('non_accessories', zen_get_all_get_params(array('action', 'Nid'))));
			break;
		case 'add_products':
			$file=$_FILES['add_file'];
			
			if($file['error']||empty($file)){
				$messageStack->add_session('Fail: 文件不能为空'.$file['name'],'error');
				zen_redirect(zen_href_link('non_accessories', zen_get_all_get_params(array('action'))));
			}
			$filename = basename($file['name']);
			$file_ext = substr($filename, strrpos($filename, '.') + 1);
			if($file_ext!='xlsx'&&$file_ext!='xls'){
				$messageStack->add_session('Fail: 文件格式有误，请上传xlsx或者xls格式的文件','error');
				zen_redirect(zen_href_link('non_accessories', zen_get_all_get_params(array('action'))));
			}else{
				set_time_limit(0);
				$messageStack->add_session('Success: File Upload saved successfully '.$file['name'],'success');
				$file_from=$file['tmp_name'];
				$error_info_array=array();
				$dalete_all=false;
				$success_num = 0;
				
				set_include_path('../Classes/');
				include 'PHPExcel.php';
				if($file_ext=='xlsx'){
					include 'PHPExcel/Reader/Excel2007.php';
					$objReader = new PHPExcel_Reader_Excel2007;
				}else{
					include 'PHPExcel/Reader/Excel5.php';
					$objReader = new PHPExcel_Reader_Excel5;
				}
				$objPHPExcel = $objReader->load($file_from);
				$sheet = $objPHPExcel->getActiveSheet();
				
				for($j=2;$j<=$sheet->getHighestRow();$j++){
					$products_model =$sheet->getCellByColumnAndRow(0,$j)->getValue();
					
					if(trim($products_model)==''){
						$error_info_array[] = '第  <b>'.$j.'</b> 行数据有误，商品编号不能为空。';
					}else{
						$check_products = $db->Execute('select products_id from ' . TABLE_PRODUCTS . ' where products_model = "' . $products_model . '"');
						if($check_products->RecordCount() > 0){
							$products_id = $check_products->fields['products_id'];
							
							$check_non_products = $db->Execute('select nas_id from ' . TABLE_PRODUCTS_NON_ACCESSORIES . ' where products_id = ' . $products_id);
							if($check_non_products->RecordCount() == 0 ){
								$sql_data_array = array(
										'products_id' => $products_id,
										'products_model' => $products_model,
										'add_admin' => $_SESSION['admin_email'],
										'add_datetime' => 'now()'
								);
								
								$success_num++;
								zen_db_perform(TABLE_PRODUCTS_NON_ACCESSORIES, $sql_data_array);
							}else{
								$error_info_array[] = '第  <b>'.$j.'</b> 行数据有误，商品编号已存在于到非饰品商品表。';
							}
						}else{
							$error_info_array[] = '第  <b>'.$j.'</b> 行数据有误，商品编号不存在。';
						}
					}
				}
				
				if(sizeof($error_info_array)>=1){
					$messageStack->add_session($success_num . ' 件商品信息导入成功.','caution');
					foreach($error_info_array as $val){
						$messageStack->add_session($val,'error');
					}
				}else{
					$messageStack->add_session('所有商品导入成功','success');
				}
				
				zen_redirect(zen_href_link('non_accessories', zen_get_all_get_params(array('action'))));
			}
			break;
		
		case 'delete_products':
			$file=$_FILES['delete_file'];
			
			if($file['error']||empty($file)){
				$messageStack->add_session('Fail: 文件不能为空'.$file['name'],'error');
				zen_redirect(zen_href_link('non_accessories', zen_get_all_get_params(array('action'))));
			}
			$filename = basename($file['name']);
			$file_ext = substr($filename, strrpos($filename, '.') + 1);
			if($file_ext!='xlsx'&&$file_ext!='xls'){
				$messageStack->add_session('Fail: 文件格式有误，请上传xlsx或者xls格式的文件','error');
				zen_redirect(zen_href_link('non_accessories', zen_get_all_get_params(array('action'))));
			}else{
				set_time_limit(0);
				$messageStack->add_session('Success: File Upload saved successfully '.$file['name'],'success');
				$file_from=$file['tmp_name'];
				$error_info_array=array();
				$dalete_all=false;
				$success_num = 0;
				$products_model_array = array();
			
				set_include_path('../Classes/');
				include 'PHPExcel.php';
				if($file_ext=='xlsx'){
					include 'PHPExcel/Reader/Excel2007.php';
					$objReader = new PHPExcel_Reader_Excel2007;
				}else{
					include 'PHPExcel/Reader/Excel5.php';
					$objReader = new PHPExcel_Reader_Excel5;
				}
				$objPHPExcel = $objReader->load($file_from);
				$sheet = $objPHPExcel->getActiveSheet();
			
				for($j=2;$j<=$sheet->getHighestRow();$j++){
					$products_model =$sheet->getCellByColumnAndRow(0,$j)->getValue();
						
					if(trim($products_model)==''){
						$error_info_array[] = '第  <b>'.$j.'</b> 行数据有误，商品编号不能为空。';
					}else{
						$check_products = $db->Execute('select products_id from ' . TABLE_PRODUCTS . ' where products_model = "' . $products_model . '"');
						if($check_products->RecordCount() > 0){
							$products_id = $check_products->fields['products_id'];
								
							$check_non_products = $db->Execute('select nas_id from ' . TABLE_PRODUCTS_NON_ACCESSORIES . ' where products_id = ' . $products_id);
							if($check_non_products->RecordCount() > 0 ){
								$nas_id = $check_non_products->fields['nas_id'];
								$success_num++;
								$products_model_array[] = $products_model;
								$sql_delete = $db->Execute('delete from ' . TABLE_PRODUCTS_NON_ACCESSORIES . ' where nas_id = ' . $nas_id);
							}else{
								$error_info_array[] = '第  <b>'.$j.'</b> 行数据有误，商品编号没有存在于到非饰品商品表。';
							}
						}else{
							$error_info_array[] = '第  <b>'.$j.'</b> 行数据有误，商品编号不存在。';
						}
					}
				}
				$products_model_str = implode(',', $products_model_array);
				
				if($success_num > 0){
				    zen_insert_operate_logs($_SESSION['admin_id'], '', '非饰品商品批量删除：' . $products_model_str, 2);
				}
				if(sizeof($error_info_array)>=1){
					$messageStack->add_session($success_num . ' 件商品信息删除成功.','caution');
					foreach($error_info_array as $val){
						$messageStack->add_session($val,'error');
					}
				}else{
					$messageStack->add_session('所有商品删除成功','success');
				}
			
				zen_redirect(zen_href_link('non_accessories', zen_get_all_get_params(array('action'))));
			}
				
			break;
			
	}
}
	$sql = 'SELECT nas_id,products_id,products_model,add_admin,add_datetime FROM ' . TABLE_PRODUCTS_NON_ACCESSORIES . ' WHERE nas_status = 10 ' . $search_query . ' ORDER BY nas_id desc';
	$nas_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $sql, $admins_query_numrows);
	$nas_query = $db->Execute($sql);

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
<script language="javascript" src="includes/jquery.js"></script>
<script> window.lang_wdate='en'; </script><script type="text/javascript" src="../includes/templates/cherry_zen/jscript/My97DatePicker/WdatePicker.js"></script>
<style>
#search_table tr{
	height:20px;
}
</style>
<script type="text/javascript">
function init()
{
  cssjsmenu('navbar');
  if (document.getElementById)
  {
    var kill = document.getElementById('hoverJS');
    kill.disabled = true;
  }
}
function delete_confirm(){
	if(confirm('确定从非饰品商品表中删除吗?')){
		return true;
	}else{
		return false;
	}
}
</script>
</head>
<body onLoad="init()">
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<table border="0" width="100%" cellspacing="0" cellpadding="0" >
				<tr>
					<td class="pageHeading">非饰品商品管理</td>
					<td align="right">
						<?php echo zen_draw_form('search_form', 'non_accessories', '', 'get')?>
						<table border="0" width="25%" cellspacing="0" cellpadding="0" height="160px" id="search_table">
							<tr height="30px">
								<td>添加日期：</td>
								<td><?php echo '<input class="Wdate" style="width:120px;" id="date_created_start" name="date_created_start" min-date="%y-%M-%d" datefmt="yyyy-MM-dd HH:mm:ss" value="' . $date_created_start . '" onclick="WdatePicker({startDate:\'%y-%M-%d 00:00:00\',dateFmt:\'yyyy-MM-dd HH:mm:ss\',alwaysUseStartDate:true});" type="text"> - <input class="Wdate" style="width:120px;" id="date_created_end" name="date_created_end" min-date="%y-%M-%d" datefmt="yyyy-MM-dd HH:mm:ss" value="' . $date_created_end . '" onclick="WdatePicker({startDate:\'%y-%M-%d 23:59:59\',dateFmt:\'yyyy-MM-dd HH:mm:ss\',alwaysUseStartDate:true});" type="text"><br/>';?></td>
							</tr>
							<tr>
								<td>产品编号：</td>
								<td><?php echo zen_draw_input_field('products_model', $_GET['products_model'] ? $_GET['products_model'] : '')?></td>
							</tr>
							<tr>
								<td>操作人邮箱：</td>
								<td><?php echo zen_draw_input_field('admin_email',  $_GET['admin_email'] ? $_GET['admin_email'] : '')?></td>
							</tr>
							<tr>
								<td align="right" colspan="2"><?php echo zen_image_submit('button_search_cn.png','搜索');?></td>
							</tr>
						</table>
						<?php echo '</form>';?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table border="0" width="100%" cellspacing="0" cellpadding="2">
				<tr class="dataTableHeadingRow">
					<td width="12%" style="text-align:center;"   class="dataTableHeadingContent">ID</td>
					<td width="28%" style="text-align:center;"  class="dataTableHeadingContent">商品编号</td>
					<td width="30%" style="text-align:center;"  class="dataTableHeadingContent">添加时间</td>
					<td width="28%" style="text-align:center;"  class="dataTableHeadingContent">操作人</td>
					<td width="12%" style="text-align:center;" class="dataTableHeadingContent">操作</td>
				</tr>
				<?php 
					while (!$nas_query->EOF){
				?>
						<tr class="dataTableRowSelected">
							<td class="dataTableContent" style="text-align:center;"  ><?php echo $nas_query->fields['nas_id']; ?></td>
							<td class="dataTableContent" style="text-align:center;" ><?php echo $nas_query->fields['products_model']; ?></td>
							<td class="dataTableContent" style="text-align:center;" ><?php echo $nas_query->fields['add_datetime']; ?></td>
							<td class="dataTableContent" style="text-align:center;" ><?php echo $nas_query->fields['add_admin']; ?></td>
							<td class="dataTableContent" style="text-align:center;" ><a onclick="return delete_confirm();" href="<?php echo zen_href_link('non_accessories', zen_get_all_get_params(array('Nid', 'action')) . 'action=delete&Nid=' . $nas_query->fields['nas_id'])?>"><img src="images/icon_delete.gif" border="0" alt="Delete" title=" Delete "></a></td>
						</tr>
				<?php 
						$nas_query->MoveNext();
					}
				
				?>
				
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table border="0" width="100%" cellspacing="0" cellpadding="4">
				<tr>
					<td class="smallText"><?php echo $nas_split->display_count($admins_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_RESULTS); ?></td>
					<td class="smallText" align="right"><?php echo $nas_split->display_links($admins_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'],zen_get_all_get_params(array('page'))); ?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr height="30px"><td></td></tr>
	<tr>
		<td>
			<table border="0" width="100%" cellspacing="0" cellpadding="4">
				<tr><td><span style="font-size: 15px;font-weight: bold;">新增非饰品商品</span></td></tr>
				<tr height="40px"><td><?php echo zen_draw_form('add_form', 'non_accessories', '', 'post', 'enctype="multipart/form-data" style="margin-left: 20px;"');echo zen_draw_hidden_field('action', 'add_products')?><span>File：</span><?php echo zen_draw_file_field('add_file')?><span><a href="./file/non_accessories_add.xlsx">下载EXCEL模板</a></span><span><input type="submit" name="submit_update_products" style="width:75px;font-size:13px;margin-left:20px;" value="提交"></span><?php echo '</form>';?></td></tr>
				<tr><td><span style="font-size: 15px;font-weight: bold;">批量删除非饰品商品</span></td></tr>
				<tr height="40px"><td ><?php echo zen_draw_form('add_form', 'non_accessories', '', 'post', 'enctype="multipart/form-data" style="margin-left: 20px;"');echo zen_draw_hidden_field('action', 'delete_products')?><span>File：</span><?php echo zen_draw_file_field('delete_file')?><span><a href="./file/non_accessories_delete.xlsx">下载EXCEL模板</a></span><span><input type="submit" name="submit_update_products" style="width:75px;font-size:13px;margin-left:20px;" value="提交"></span><?php echo '</form>';?></td></tr>
			</table>
		</td>
	</tr>
	
</table>

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>