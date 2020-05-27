<?php 
require('includes/application_top.php');

function outputXlsHeader($data,$file_name = 'export')
{
	ob_end_clean();
	header('Content-Type: text/xls');
	header ( "Content-type:application/vnd.ms-excel;charset=utf-8" );
	$str = mb_convert_encoding($file_name, 'gbk', 'utf-8');
	header('Content-Disposition: attachment;filename="' .$str . '.xls"');
	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
	header('Expires:0');
	header('Pragma:public');
	$encode = mb_detect_encoding($data, array("ASCII","UTF-8","GB2312","GBK","BIG5"));
	$data = mb_convert_encoding($data, $encode, 'utf-8');

	echo $data;
	die();
}

define('TEXT_DISPLAY_NUMBER_OF_RECORDS', '当前展示  <b>%d</b> - <b>%d</b> (共  <b>%d</b> 条记录)');
$status_arr = array(array('id' => 10 , 'text' =>'All') , array('id' => 1 , 'text' => '开始') , array('id' => 0 , 'text' => '关闭') );

$action = (isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : ''));
$search_condition = '';

if(isset($_GET['status'])){
    $status = (int)zen_db_input($_GET['status']);
}
$areas_id = (int)zen_db_input(trim($_GET['areas_id']));
$areas_name = zen_db_input(trim($_GET['areas_name']));
$products_key = zen_db_input($_GET['products_key']);

if($products_key != ''){
    $products_key_str = explode('<br />', nl2br($products_key));
    $products_array = array();
    
    foreach ($products_key_str as $product){
        $products_array[] = trim($product);
    }
}

if(isset($status) && $status != 10){
    $search_condition = ' and sa.`status` = ' . $status;
}

if(isset($areas_id) && $areas_id > 0){
    $search_condition .= ' and sap.areas_id = ' . $areas_id;
}

if(isset($areas_name) && $areas_name != ''){
    $search_condition .= ' and sa.nameZh like "%' . $areas_name . '%"';
}

if(sizeof($products_array) != '' ){
    $search_condition .= ' and p.products_model in ( "' . implode('","', $products_array) . '" )';
}

$pageIndex = 1;
If($_GET['page'])
{
	$pageIndex = intval($_GET['page']);
}
$promotion_products_query_raw = "select
	sap.id,
	p.products_model,
	sap.areas_id,
	sa.nameZh,
	sa.`status`,
	sap.add_datetime from
	(
		" . TABLE_SUBJECT_AREAS_PRODUCTS . " sap
		INNER JOIN " . TABLE_PRODUCTS . " p ON sap.products_id = p.products_id
	)
INNER JOIN " . TABLE_SUBJECT_AREAS . " sa ON sap.areas_id = sa.id
where sap.id > 0 " . $search_condition . "
ORDER BY sap.areas_id desc";
$promotion_products_query_raw_orgin = $promotion_products_query_raw;
$promotion_products_split = new splitPageResults($pageIndex, MAX_DISPLAY_SEARCH_RESULTS, $promotion_products_query_raw, $query_numrows);
$promotion_products = $db->Execute($promotion_products_query_raw);

switch($action){
	case 'export':
	    $promotion_products = $db->Execute($promotion_products_query_raw_orgin);
		$str = '<table border="1" valign="top" style="font-size:15px;width:600px;text-align: center;border-spacing: 0px;">
					<tr  style="background-color: #fff;height: 40px;">
						<th>商品编号</th>
						<th>商品专区ID</th>
						<th>商品专区名称</th>
						<th>商品专区状态</th>
						<th>上传时间</th>
					</tr>';
		
		if($promotion_products->RecordCount() > 0){
			while (!$promotion_products->EOF){
				$current_datetime = date("Y-m-d H:i:s");
				$start_datetime = $promotion_products->fields['pp_promotion_start_time'];
				$end_datetime = $promotion_products->fields['pp_promotion_end_time'];
					
				$str.='<tr  style="background-color: #fff;height: 40px;">
								<td>' . $promotion_products->fields['products_model'] . '</td>
								<td>' . $promotion_products->fields['areas_id'] . '</td>
								<td>' . $promotion_products->fields['nameZh'] . '</td>
								<td>' . $promotion_products->fields['status']  . '</td>
								<td>' . $promotion_products->fields['add_datetime']  . '</td>
							</tr>';
		
				$promotion_products->MoveNext();
			}
		}
		$str.= '</table>';
		$promotion_id = str_replace(',' , '_' , $promotion_id);
		outputXlsHeader($str,"专区部分商品" .date("Ymd"));

		break;
}
?>

<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title>促销折扣区设置</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
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

  function submit_form(action){
	  $("input[name=action]").val(action);

	  document.getElementById("search_form").submit();
  }

  $(document).ready(function(){
// 	$("select").change(function(){
// 		$(this).parents("form").submit();
// 	});

	$("#products_model_button").toggle(
		function(){
			$(this).text("收起");
			$("#products_model_tr").show();
		},
		function(){
			$(this).text("搜索商品编号");
			$("#products_model_tr").hide();
		}
	);
  });
</script>
</head>
<body onLoad="init()">
<?php require(DIR_WS_INCLUDES . 'header.php');?>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tbody>
  <tr>
  	<td width="100%" valign="top" style="padding: 20px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
    	<tbody>
    	<tr>
            <td class="pageHeading"><span style="font-size: 20px;">专区商品信息</span></td>
            <td align="right" class="pageHeading" style="float: right;">
            <?php echo zen_draw_form('search_form', FILENAME_SUBJECT_PRODUCT_AREA_PRODUCTS , '' , 'get' , 'id="search_form"')?>
				<table border="0" width="100%" cellspacing="0" cellpadding="3">
					<tr><td style="float: right;">状态：</td><td><?php echo zen_draw_pull_down_menu('status' , $status_arr , (isset($_GET['status'])?$_GET['status']: 10) , 'style="width:100px;height:20px;"');?></td></tr>
					<tr><td style="float: right;">商品专区ID：</td><td><?php echo zen_draw_input_field('areas_id' , (isset($_GET['areas_id'])?$_GET['areas_id']: '') , 'style="width:100px;height:20px;"');?></td></tr>
					<tr><td>商品专区名称：</td><td><?php echo zen_draw_input_field('areas_name' , (isset($_GET['areas_name']) ? $_GET['areas_name'] : '') , ' style="height: 25px;width: 100px;color: darkgray;"');?></td></tr>
					<tr><td colspan="2"><span style="color: blue;cursor: pointer;float: right;" id="products_model_button">搜索商品编号</span></td></tr>
					<tr id="products_model_tr" style="display: none;"><td colspan="2"><?php echo zen_draw_textarea_field('products_key' , '', '' , '', '' , 'style="width:168;height:125px;overflow-y:scroll;" maxlength="2000"');?></td></tr>
					<tr><td></td><td><?php echo zen_draw_hidden_field('action' , 'search')?></td></tr>
					<tr><td><?php echo  zen_draw_input_field('button','导出数据','onclick="submit_form(\'export\')" style="width:70px;height:25px;float: right;cursor: pointer;"',false,'button');?></td><td><?php echo  zen_draw_input_field('button','搜索','onclick="submit_form(\'search\');" style="width:70px;height:25px;float: right;cursor: pointer;"',false,'button');?></td></tr>
				</table>
			<?php echo '</form>'; ?>
			</td>
        </tr>
		</tbody>
	</table>
    </td>
  </tr>
<tr><td>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tbody><tr>
            <td valign="top" width='80%'>
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" align="left">ID</td> 
                <td class="dataTableHeadingContent" align="center">商品编号</td>
                <td class="dataTableHeadingContent" align="center">商品专区ID</td>
                <td class="dataTableHeadingContent" align="center">商品专区名称</td>
                <td class="dataTableHeadingContent" align="center">商品专区状态</td>
                <td class="dataTableHeadingContent" align="center">上传时间</td>
              </tr>
              <?php
              while(!$promotion_products->EOF){
              	?>
	              <tr class="dataTableRow">
	                <td class="dataTableHeadingContent" align="left"><?php echo $promotion_products->fields['id'] ?></td> 
	                <td class="dataTableHeadingContent" align="center"><?php echo $promotion_products->fields['products_model'] ?></td>
	                <td class="dataTableHeadingContent" align="center"><?php echo $promotion_products->fields['areas_id']?></td>
	                <td class="dataTableHeadingContent" align="center"><?php echo $promotion_products->fields['nameZh']?></td>
	                <td class="dataTableHeadingContent" align="center"><?php echo $promotion_products->fields['status']?></td>
	                <td class="dataTableHeadingContent" align="center"><?php echo ($promotion_products->fields['add_datetime'] == '' ? '-' : $promotion_products->fields['add_datetime'])?></td>
	              </tr>
             <?php 	$promotion_products->MoveNext();
              }
              ?>
              </table>
              <tr>
	              <td style="padding-top: 10px;">
		              <table border="0" width="100%" cellspacing="0" cellpadding="2">
		              <tr>
		             	 <td class="dataTableHeadingContent" colspan="3" align="left"><?php echo $promotion_products_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS,$pageIndex, TEXT_DISPLAY_NUMBER_OF_RECORDS); ?></td>
		                <td class="dataTableHeadingContent" colspan="5" align="right"><?php echo $promotion_products_split->display_links($query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $pageIndex, zen_get_all_get_params(array('page', 'id' , 'products_key')) . '&products_key=' . urlencode($_GET['products_key'])); ?></td>
		              </tr>
		              </table>
	              </td>
              </tr>
            </td>
            </tr>
  </tbody>
  </table>
</td>
</tr>
</tbody>
</table>
</body>
</html>