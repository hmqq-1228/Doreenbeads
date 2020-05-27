<?php
/** oem_sourcing.php
  * 新增文件，找货
  * jessa 2010-03-30
  */
require ('includes/application_top.php');
require(DIR_WS_CLASSES . 'language.php');
require(DIR_WS_FUNCTIONS . 'function_discount.php');

//error_reporting(E_ALL^E_NOTICE);
$action = (isset ( $_GET ['action'] ) ? $_GET ['action'] : '');
if (zen_not_null ( $action )) {
	switch ($action) {
		case 'update_data' :
			set_time_limit ( 0 );
			@ini_set ( 'memory_limit', '256M' );
			set_include_path ( '../Classes/' );
			$startime=microtime(true);
			include 'PHPExcel.php';
			include 'PHPExcel/Reader/Excel2007.php';
			$objReader = new PHPExcel_Reader_Excel2007 ();

			//	产品表格
			$xlsxdir = '../products/oem_sourcing_products/';
			$xlsxfrom = date('Ymd').'.xlsx';
			$xlsxfile = $xlsxdir . $xlsxfrom;
			if(file_exists($xlsxfile)) unlink($xlsxfile);
			move_uploaded_file($_FILES['whereisxlsx2']['tmp_name'], $xlsxfile);

			if (file_exists ( $xlsxfile )) {
				$objPHPExcel = $objReader->load ( $xlsxfile );
				$sheet = $objPHPExcel->getActiveSheet ();
				$error_array = array();
				$products_info = array();
				$count = 0;

				for($j = 2; $j <= $sheet->getHighestRow (); $j ++) {
					$products_info = array();
					$sql_data_array = array();
					$error = false;

					$products_model = trim ( $sheet->getCellByColumnAndRow ( 0, $j )->getValue () );
					$oem_type = trim ( $sheet->getCellByColumnAndRow ( 1, $j )->getValue () );
					$handle_person = trim ( $sheet->getCellByColumnAndRow ( 2, $j )->getValue () );
					if ($products_model == '') {
						$error_array [] = '第' . $j . '行 ，产品编号为空' . "\n";
						$error = true;
						continue;
					}else{
						$check_exists = "SELECT * from " . TABLE_PRODUCTS . " WHERE products_model = '" . $products_model ."' LIMIT 1";
						$check_exists_query = $db->Execute($check_exists);
						if ($check_exists_query->RecordCount() == 0) {
							$error_array [] = '第' . $j . '行 ，产品编号'.$products_model.'不存在' . "\n";
							$error = true;
							continue;
						}
					}
					if ($oem_type == '') {
						$error_array [] = '第' . $j . '行 ，服务类型为空' . "\n";
						$error = true;
						continue;
					}else{
						if (!in_array((int)$oem_type, array(10, 20))) {
							$error_array [] = '第' . $j . '行 ，服务类型'.$oem_type.'错误' . "\n";
							$error = true;
							continue;
						}
					}
					if ($handle_person == '') {
						$error_array [] = '第' . $j . '行 ，提出人为空' . "\n";
						$error = true;
						continue;
					}
					if (!$error) {
						$check_products_exist_sql = 'SELECT products_model from ' . TABLE_OEM_SOURCING_PRODUCTS . ' WHERE products_model = "' . $products_model .'" LIMIT 1';
						$check_products_exist_query = $db->Execute($check_products_exist_sql);
						if ($check_products_exist_query->RecordCount() > 0) {
							$error_array [] = '第' . $j . '行 ，产品编号已存在' . "\n";
							$error = true;
							continue;
						}
					}
					if (!$error) {
						$products_info_sql = 'SELECT * from ' . TABLE_PRODUCTS . ' WHERE products_model = "' . $products_model . '" ORDER BY products_id DESC LIMIT 1';
						$products_info_query = $db->Execute($products_info_sql);
						$products_info = $products_info_query->fields;
						//print_r($products_info);
						$sql_data_array = array (
								'products_model' => $products_model,
								'oem_type' => $oem_type,
								'handle_person' => $handle_person,
								'admin_id' => $_SESSION['admin_id'],
								'admin_name' => $_SESSION['admin_name'],
								'admin_email' => $_SESSION['admin_email'],
								'date_added' => date ( 'Y-m-d H:i:s' ),
								'products_id' => $products_info['products_id'],
								'products_add_time' => $products_info['products_date_added']
						);
						//print_r($sql_data_array);
						zen_db_perform(TABLE_OEM_SOURCING_PRODUCTS, $sql_data_array);
						$count++;
					}			
				}
				if (sizeof($error_array)) {
					foreach($error_array as $value){
						$messageStack->add_session ( $value, 'error' );
					}
					$messageStack->add_session ( $count.'条上传成功', 'success' );
					zen_redirect ( zen_href_link ( 'oem_sourcing_products.php' ) );
				}else{
					$messageStack->add_session ( '上传成功', 'success' );				
					zen_redirect ( zen_href_link ( 'oem_sourcing_products.php' ) );
				}
				//print_r($all_products_array);die;
			}
		break;
	}
}

$where = ' where 1=1 ';
$search = (isset($_GET['search']) && $_GET['search'] != '') ? zen_db_input($_GET['search']) : '' ;
$type = (isset($_GET['t']) && $_GET['t'] != '') ? zen_db_input($_GET['t']) : '' ;

if ($search != '') {$where .= ' and (products_model like "%' . $search . '%" or handle_person like "%' . $search . '%")';}
if ($type != '') {$where .= ' and oem_type = ' . $type;}

$oem_sourcing_products_sql = 'SELECT * FROM ' . TABLE_OEM_SOURCING_PRODUCTS . $where . ' ORDER BY id DESC';
//echo $oem_sourcing_products_sql;
$oem_sourcing_products_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_REPORTS, $oem_sourcing_products_sql, $search_query_numrows);
$oem_sourcing_products_query = $db->Execute($oem_sourcing_products_sql);
//var_dump($oem_sourcing_products_query);
$oem_sourcing_products_array = array();
if ($oem_sourcing_products_query->RecordCount() > 0){
  	while (!$oem_sourcing_products_query->EOF){
  		$oem_sourcing_products_array[] = array('id' => $oem_sourcing_products_query->fields['id'],
  									 'products_id'=>$oem_sourcing_products_query->fields['products_id'],
  									 'products_model' => $oem_sourcing_products_query->fields['products_model'],
  									 'handle_person' => $oem_sourcing_products_query->fields['handle_person'],
  									 'oem_type' => $oem_sourcing_products_query->fields['oem_type'],
  									 'admin_id' => $oem_sourcing_products_query->fields['admin_id'],
  									 'admin_email' => $oem_sourcing_products_query->fields['admin_email'],
  									 'admin_name' => $oem_sourcing_products_query->fields['admin_name'],
  									 'date_added' => $oem_sourcing_products_query->fields['date_added'],
  									 'products_add_time' => $oem_sourcing_products_query->fields['products_add_time']
  									 );
  		$oem_sourcing_products_query->MoveNext();
		}
}
//print_r($oem_sourcing_products_array);
$memcache->delete(md5('get_oem_sourcing_products_memcache' . TABLE_OEM_SOURCING_PRODUCTS));
?>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>

<head>

<meta http-equiv="Content-Type"
	content="text/html; charset=<?php echo CHARSET; ?>">

<title><?php echo TITLE; ?></title>

<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">

<link rel="stylesheet" type="text/css"
	href="includes/cssjsmenuhover.css" media="all" id="hoverJS">

<script language="javascript" src="includes/menu.js"></script>

<script language="javascript" src="includes/general.js"></script>
<script language="javascript" src="includes/jquery.js"></script>
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
  function checkfile(){
	  if($('#whereisxlsx').val()==''||$('#whereistxt').val()==''){
		  alert('输入不能为空');
		  return false;
	  }else{
		  return true;
	  }
  }
  function checkfile2(){
	  if($('#whereisxlsx2').val()==''||$('#whereistxt2').val()==''){
		  alert('输入不能为空');
		  return false;
	  }else{
		  return true;
	  }
  }
</script>
</head>
<body onLoad="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body bof -->
<table border="0" cellpadding="0" cellspacing="0" width="97%" align="center">
  <tr>
  	<td class="pageHeading"><?php echo zen_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT);?></td>
  </tr>
  <tr>
  	<td class="pageHeading"><div style="float:left;">找货/定做商品</div>

		<div style='float:right;font-size:12px;color:#000;text-align:right;'>
			<form action="oem_sourcing_products.php" method="get" name="searchForm">				
				类型：<select name='t' style="width:150px;">
					<option value="">所有</option>
					<option <?php echo isset($_GET['t'])&&$_GET['t']=='10' ? "selected='selected'" : ""; ?> value="10">找货服务</option>
					<option <?php echo isset($_GET['t'])&&$_GET['t']=='20' ? "selected='selected'" : ""; ?> value="20">定做服务</option>
				</select><br/><br/>
				搜索：<input name="search" value="<?php echo $_GET['search']; ?>" placeholder="产品编号/处理人" style="width:150px;" /><br/>
				<input type="submit" value="提交" style="margin:7px 0;" />
			</form>
		</div>

  	</td>
</tr>
  <tr>
  	<td>
  	<?php 
	  if ($action != 'addnew'){
	?>
	  <table border="0" cellpadding="0" cellspacing="0" width="100%">
	  	<tr>
	  	  <td style="width:75%; vertical-align:top">
	  	  	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	  	  	  <tr class="dataTableHeadingRow">
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:5%;text-align:center;">ID</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:20%;text-align:center;">商品编号</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:15%;text-align:center;">类型</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:20%; text-align:center;">上货时间</td>
	  	  	  	<td class="dataTableHeadingContent" style="padding:5px 2px; width:5%; text-align:center;">处理人</td>
	  	  	  </tr>
	  	  	  <?php
	  	  	    for ($i = 0; $i < sizeof($oem_sourcing_products_array); $i++){
	  	  	  ?>
	  	  	  
	  	  	  <tr class="dataTableRow">
	  	  	  
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo $oem_sourcing_products_array[$i]['id']; ?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo $oem_sourcing_products_array[$i]['products_model']; ?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php if($oem_sourcing_products_array[$i]['oem_type'] == 10){ echo '找货服务';}elseif ($oem_sourcing_products_array[$i]['oem_type'] == 20) {echo '订做服务';}else{echo '/';}; ?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo $oem_sourcing_products_array[$i]['products_add_time']; ?></td>
	  	  	  	<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo $oem_sourcing_products_array[$i]['handle_person']; ?></td>
	  	  	  </tr>
	  	  	  <?php } ?>
			  	<td height="40" align="left" colspan="3"><?php echo $oem_sourcing_products_split->display_count($search_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_REPORTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_KEYWORDS);?></td>
			    <td height="40" align="right" colspan="2"><?php echo $oem_sourcing_products_split->display_links($search_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_REPORTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], $split_page_action);?></td>
	  	  	</table>
	  	  </td>
	  	</tr>
	  </table>
	<?php
	  }
  	?>
  	</td>
  </tr>
</table>
<div style="width:100%;">
	<form style="margin: 20px auto;width:97%;display:block;font-size:14px;" action="<?php echo zen_href_link('oem_sourcing_products','action=update_data')?>" method="post" onsubmit='return checkfile2()' enctype="multipart/form-data">
		<div class='inputdiv'>
			<!-- <p class='headertitle'><h3></h3></p> -->
			<b><font size="4">上传找货/定做商品:</font></b> <input style="height:30px;font-size:14px" type="file" id='whereisxlsx2' name='whereisxlsx2'> <a href='./file/template_oem_sourcing_products.xlsx'>下载模板</a>
		</div>
		
		<div class='submitdiv'>
			<input style="height:30px;width:80px;margin-top:15px;font-size:14px" type='submit' name='uploadxlsx2' value='提交'>
		</div>
		
	</form>
</div>
<!-- body eof -->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>