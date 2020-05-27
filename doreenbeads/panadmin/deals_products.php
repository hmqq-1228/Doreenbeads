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
$promotion_types_arr = array(array('id' => 0 , 'text' =>'请选择...') , array('id' => 1 , 'text' => '正常促销') , array('id' => 2 , 'text' => 'Deals促销'));
$status_arr = array(array('id' => 0 , 'text' =>'请选择...') , array('id' => 1 , 'text' => '未开始') , array('id' => 2 , 'text' => '活动') , array('id' => 3 , 'text' => '已结束'));

$action = (isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : ''));
$search_condition = '';

$status = zen_db_input($_GET['status']);
$promotion_key = zen_db_input($_GET['promotion_key']);
$products_key = zen_db_input($_GET['products_key']);

if($products_key != ''){
	$products_key_str = explode('<br />', nl2br($products_key));
	$products_array = array();
	
	foreach ($products_key_str as $product){
		$products_array[] = trim($product);
	}
}

if($status != 0){
	if($status == 1){
		$search_condition .= ' and ( dailydeal_products_start_date > now() and area_status = 1 and dailydeal_is_forbid = 10 and products_status = 1)';
	}elseif($status == 2){
		$search_condition .= ' and ( dailydeal_products_start_date <= now() and dailydeal_products_end_date >= now() and area_status = 1 and dailydeal_is_forbid = 10 and products_status = 1)';
	}else{
		$search_condition .= ' and ( dailydeal_products_end_date <= now() or area_status = 0 or dailydeal_is_forbid = 20 or products_status != 1)';
	}
		
}
if($promotion_key != '' && $promotion_key != 'DEALS区ID'){
	$search_condition .= ' and zda.dailydeal_area_id = ' . $promotion_key;
}
if(sizeof($products_array) > 0 && $products_key != ''){
	$search_condition .= ' and zp.products_model in ( "' . implode('","', $products_array) . '" )';
		
}

switch($action){
	case 'export_products':
		$promotion_products_query_raw = "select zdp.dailydeal_promotion_id , zp.products_model, zda.dailydeal_area_id, zda.area_name,zdp.dailydeal_price, dailydeal_products_start_date , dailydeal_products_end_date , dailydeal_forbid_admin , dailydeal_forbid_time , expire_interval , area_status , dailydeal_is_forbid ,products_status, zdp.max_num_per_order from (" . TABLE_DAILYDEAL_PROMOTION ." zdp INNER JOIN " . TABLE_PRODUCTS ." zp on zdp.products_id = zp.products_id) INNER JOIN " . TABLE_DAILYDEAL_AREA . " zda on zdp.area_id = zda.dailydeal_area_id  " . $search_condition . ' order by zda.dailydeal_area_id desc , zdp.dailydeal_promotion_id desc';
		$promotion_products = $db->Execute($promotion_products_query_raw);
		$str = '<table border="1" valign="top" style="font-size:15px;width:600px;text-align: center;border-spacing: 0px;">
					<tr  style="background-color: #fff;height: 40px;">
						<th>商品编号</th>
						<th>开始时间</th>
						<th>结束时间</th>
	  					<th>一口价专区</th>
						<th>一口价（美元）</th>
						<th>单笔最大购买数</th>
						<th>禁用人</th>
						<th>禁用时间</th>
						<th>商品时效</th>
						<th>状态</th>
					</tr>';
	
		if($promotion_products->RecordCount() > 0){
			while (!$promotion_products->EOF){
				$current_datetime = date("Y-m-d H:i:s");
				$start_datetime = $promotion_products->fields['dailydeal_products_start_date'];
				$end_datetime = $promotion_products->fields['dailydeal_products_end_date'];
	
				$promotion_active_state = '';
				if($promotion_products->fields['area_status'] == 0 || $promotion_products->fields['dailydeal_is_forbid'] == 20 || $promotion_products->fields['products_status'] != 1){
					$promotion_active_state = '已结束';
				}else{
					if ($current_datetime <$start_datetime)
					{
						$promotion_active_state = '未开始';
					}else if($current_datetime >=$start_datetime && $current_datetime <= $end_datetime)
					{
						$promotion_active_state = '活动';
					}else if($current_datetime >=$end_datetime)
					{
						$promotion_active_state = '已结束';
					}
				}
	
				$str.='<tr  style="background-color: #fff;height: 40px;">
								<td>' . $promotion_products->fields['products_model'] . '</td>
								<td>' . $promotion_products->fields['dailydeal_products_start_date'] . '</td>
								<td>' . $promotion_products->fields['dailydeal_products_end_date'] . '</td>
								<td>' . $promotion_products->fields['dailydeal_area_id']  . '</td>
								<td>' . $promotion_products->fields['dailydeal_price']  . '</td>
								<td>' . ($promotion_products->fields['max_num_per_order'] > 0 ? $promotion_products->fields['max_num_per_order'] : '/' ) . '</td>
								<td>' . ($promotion_products->fields['dailydeal_forbid_admin'] ? $promotion_products->fields['dailydeal_forbid_admin'] : '/') . '</td>
								<td>' . ($promotion_products->fields['dailydeal_forbid_time'] ? $promotion_products->fields['dailydeal_forbid_time'] : '/') . '</td>
								<td>' . $promotion_products->fields['expire_interval']  . '</td>
								<td>' . $promotion_active_state . '</td>
							</tr>';
	
				$promotion_products->MoveNext();
			}
		}
		$str.= '</table>';
		$promotion_id = str_replace(',' , '_' , $promotion_id);
		outputXlsHeader($str,"一口价部分商品" .date("Ymd"));
	
	break;
	case 'export':
		$promotion_id = zen_db_input($_POST['area_id']);
		$start_time = zen_db_input($_POST['start_date']) . ' 00:00:00';
		$end_time = zen_db_input($_POST['start_date']) . ' 23:59:59';
		
		if($promotion_id != '' ){
			$search_sql = 'SELECT zp.products_model, zdp.area_id, zdp.dailydeal_price, zdp.dailydeal_products_start_date, zdp.dailydeal_products_end_date FROM ' . TABLE_DAILYDEAL_PROMOTION . ' zdp INNER JOIN ' . TABLE_PRODUCTS .' zp on zdp.products_id = zp.products_id WHERE area_id = ' . $promotion_id . ' AND dailydeal_products_start_date >= "' . $start_time . '" and dailydeal_products_start_date <= "' . $end_time . '"';
			$products_query = $db->Execute($search_sql);
			
			$area_info_query = $db->Execute("SELECT area_name, expire_interval from " . TABLE_DAILYDEAL_AREA . " where dailydeal_area_id = " . $promotion_id);
			$area_name = $area_info_query->fields['area_name'];
			$expire_interval = $area_info_query->fields['expire_interval'];
			
			$str = '<table border="1" valign="top" style="font-size:15px;width:600px;text-align: center;border-spacing: 0px;">
				<tr  style="background-color: #fff;height: 40px;">
					<th>商品编号</th>
					<th>一口价专区</th>
					<th>一口价</th>
					<th>开始时间</th>
					<th>结束时间</th>
					<th>商品时效</th>
				</tr>';
			
			if($products_query->RecordCount() > 0){
				while (!$products_query->EOF){
					$str.='<tr  style="background-color: #fff;height: 40px;">
							<td>' . $products_query->fields['products_model'] . '</td>
							<td>ID ' . $products_query->fields['area_id'] . '' . $products_query->fields['area_name'] . '</td>
							<td>' . $products_query->fields['dailydeal_price']  . '</td>
							<td>' . $products_query->fields['dailydeal_products_start_date']  . '</td>
							<td>' . $products_query->fields['dailydeal_products_end_date']  . '</td>
							<td>' . $expire_interval . '</td>
						</tr>';
					
					$products_query->MoveNext();
				}
			}
			$str.= '</table>';
			outputXlsHeader($str,"一口价DEALS商品_" . $area_name . '_' .date("Ymd"));
			
		}
	break;
}

$pageIndex = 1;
If($_GET['page'])
{
	$pageIndex = intval($_GET['page']);
}
$promotion_products_query_raw = "select zdp.dailydeal_promotion_id , zp.products_model, zda.dailydeal_area_id, zda.area_name,zdp.dailydeal_price, dailydeal_products_start_date , dailydeal_products_end_date , dailydeal_forbid_admin , dailydeal_forbid_time , expire_interval , area_status , dailydeal_is_forbid ,products_status, zdp.max_num_per_order from (" . TABLE_DAILYDEAL_PROMOTION ." zdp INNER JOIN " . TABLE_PRODUCTS ." zp on zdp.products_id = zp.products_id) INNER JOIN " . TABLE_DAILYDEAL_AREA . " zda on zdp.area_id = zda.dailydeal_area_id  " . $search_condition . ' order by zda.dailydeal_area_id desc , zdp.dailydeal_promotion_id desc';
$promotion_products_split = new splitPageResults($pageIndex, MAX_DISPLAY_SEARCH_RESULTS, $promotion_products_query_raw, $query_numrows);
$promotion_products = $db->Execute($promotion_products_query_raw);

?>

<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title>一口价Deals商品信息</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript" src="includes/jquery.js"></script>
<script language="javascript" src="includes/javascript/common.js"></script>
<script type="text/javascript" src="../includes/templates/cherry_zen/jscript/My97DatePicker/WdatePicker.js"></script>
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
// 		$("select[name=status]").change(function(){
// 			$(this).parents("form").submit();
// 		});

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
<?php require(DIR_WS_INCLUDES . 'header.php');  ?>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tbody>
  <tr>
  	<td width="100%" valign="top" style="padding: 20px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
    	<tbody>
    	<tr>
            <td class="pageHeading"><span style="font-size: 20px;">一口价Deals商品信息</span></td>
            <td align="right" class="pageHeading" style="float: right;">
            <?php echo zen_draw_form('search_form', FILENAME_DEALS_PRODUCTS , '' , 'get', 'id="search_form"')?>
				<table border="0" width="100%" cellspacing="0" cellpadding="3">
					<tr><td style="float: right;">状态：</td><td><?php echo zen_draw_pull_down_menu('status' , $status_arr , (isset($_GET['status'])?$_GET['status']: 0) , 'style="width:100px;height:20px;"');?></td></tr>
					<tr><td>Deals区ID：</td><td><?php echo zen_draw_input_field('promotion_key' , (isset($_GET['promotion_search']) ? $_GET['promotion_search'] : 'DEALS区ID') , 'onclick="if (this.value == \'DEALS区ID\'){this.value=\'\';this.style.color=\'#000\';}" style="height: 25px;width: 100px;color: darkgray;"');?></td></tr>
					<tr><td colspan="2"><span style="color: blue;cursor: pointer;float: right;" id="products_model_button">搜索商品编号</span></td></tr>
					<tr id="products_model_tr" style="display: none;"><td colspan="2"><?php echo zen_draw_textarea_field('products_key' , '', '' , '', '' , 'style="width:178;height:125px;overflow-y:scroll;" maxlength="2000"');?></td></tr>
					<tr><td></td><td><?php echo zen_draw_hidden_field('action' , 'search')?></td></tr>
					<tr><td><?php echo  zen_draw_input_field('button','导出数据','onclick="submit_form(\'export_products\')" style="width:70px;height:25px;float: right;cursor: pointer;"',false,'button');?></td><td><?php echo  zen_draw_input_field('button','搜索','onclick="submit_form(\'search\');" style="width:70px;height:25px;float: right;cursor: pointer;"',false,'button');?></td></tr>
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
                <td class="dataTableHeadingContent" align="center">一口价专区</td>
                <td class="dataTableHeadingContent" align="center">一口价（美元）</td>
                <td class="dataTableHeadingContent" align="center">单笔最大购买数</td>
                <td class="dataTableHeadingContent" align="center">开始时间</td>
                <td class="dataTableHeadingContent" align="center">结束时间</td>
                <td class="dataTableHeadingContent" align="center">商品时效</td>
                <td class="dataTableHeadingContent" align="center">状态</td>
              </tr>
              <?php
              while(!$promotion_products->EOF){
              		$current_datetime = date("Y-m-d H:i:s");
					$start_datetime = $promotion_products->fields['dailydeal_products_start_date'];
					$end_datetime = $promotion_products->fields['dailydeal_products_end_date'];
					
					$promotion_active_state = '';
					if($promotion_products->fields['area_status'] == 0 || $promotion_products->fields['dailydeal_is_forbid'] == 20 || $promotion_products->fields['products_status'] != 1){
						$promotion_active_state = '已结束';
					}else{
						if ($current_datetime <$start_datetime)
						{
							$promotion_active_state = '未开始';
						}else if($current_datetime >=$start_datetime && $current_datetime <= $end_datetime)
						{
							$promotion_active_state = '活动';
						}else if($current_datetime >=$end_datetime)
						{
							$promotion_active_state = '已结束';
						}
					}
              	?>
	              <tr class="dataTableRow">
	                <td class="dataTableHeadingContent" align="left"><?php echo $promotion_products->fields['dailydeal_promotion_id'] ?></td> 
	                <td class="dataTableHeadingContent" align="center"><?php echo $promotion_products->fields['products_model'] ?></td>
	                <td class="dataTableHeadingContent" align="center">ID <?php echo $promotion_products->fields['dailydeal_area_id'] . ' ' . $promotion_products->fields['area_name']?></td>
	                <td class="dataTableHeadingContent" align="center"><?php echo $promotion_products->fields['dailydeal_price']?></td>
	                <td class="dataTableHeadingContent" align="center"><?php echo $promotion_products->fields['max_num_per_order'] > 0 ? $promotion_products->fields['max_num_per_order'] : '/' ?></td>
	                <td class="dataTableHeadingContent" align="center"><?php echo $promotion_products->fields['dailydeal_products_start_date']?></td>
	                <td class="dataTableHeadingContent" align="center"><?php echo $promotion_products->fields['dailydeal_products_end_date']?></td>
	                <td class="dataTableHeadingContent" align="center"><?php echo $promotion_products->fields['expire_interval']?></td>
	                <td class="dataTableHeadingContent" align="center"><?php echo $promotion_active_state?></td>
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
<tr><td>
<?php echo zen_draw_form('export_form', FILENAME_DEALS_PRODUCTS , '' , 'post')?>
	<table width="35%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td><span style="font-size: 13px;font-weight: bold;margin-left:15px;margin-right: 10px;">导出数据：</span></td>
			<td><span style="font-size: 13px;margin-left:15px;margin-right: 10px;">1.选择一口价专区：</span></td>
			<td>
				<select name="area_id" id="upload_area_id">
						<option value="">请选择</option> 
						<?php 
						$select_area_sql = "select `dailydeal_area_id`, `area_name` from " . TABLE_DAILYDEAL_AREA . " order by dailydeal_area_id desc ";

						$select_area_result = $db->Execute($select_area_sql);
						while(!$select_area_result->EOF){
						?>
							<option value="<?php echo $select_area_result->fields['dailydeal_area_id']?>">[ID:<?php echo $select_area_result->fields['dailydeal_area_id']?>] <?php echo $select_area_result->fields['area_name']?></option> 
						<?php 
							$select_area_result->MoveNext();
						}?>
					</select>
			</td>
		</tr>
		<tr>
			<td><img width="57" height="40" border="0" alt="" src="images/pixel_trans.gif"><?php echo zen_draw_hidden_field('action' , 'export');?></td>
			<td><span style="font-size: 13px;margin-left:15px;margin-right: 10px;">2.选择开始时间：</span></td>
			<td>
			<?php echo str_replace("<input","<input class='Wdate' style='width:125px;'",zen_draw_input_field('start_date', date("Y-m-d") , 'onfocus="WdatePicker()"')); ?>
			</td>
		</tr>
		<tr><td><img width="57" height="40" border="0" alt="" src="images/pixel_trans.gif"></td><td><span><?php echo zen_draw_input_field('button','导出','onclick="this.form.submit();" style="width:70px;height:25px;"',false,'button');?></span></td><td><img width="57" height="40" border="0" alt="" src="images/pixel_trans.gif"></td></tr>
	</table>
	
</td></tr>
</tbody>
</table>
</body>
</html>