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

$promotion_types_arr = array(array('id' => 0 , 'text' =>'请选择...') , array('id' => 1 , 'text' => '正常促销') , array('id' => 2 , 'text' => 'Deals促销'));
$status_arr = array(array('id' => 0 , 'text' =>'请选择...') , array('id' => 1 , 'text' => '未开始') , array('id' => 2 , 'text' => '活动') , array('id' => 3 , 'text' => '已结束'));

$action = (isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : ''));
$search_condition = '';

$type = zen_db_input($_GET['type']);
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

if($type != 0){
	if($search_condition == ''){
		$search_condition .= ' where zp.promotion_type =' . $type;
	}
}
		
if($status != 0){
	if($search_condition == ''){
		if($status == 1){
			$search_condition .= ' where pp_promotion_start_time > now() and zp.promotion_status = 1 and pp.pp_is_forbid = 10 and products_status = 1';
		}elseif($status == 2){
			$search_condition .= ' where pp_promotion_start_time <= now() and pp_promotion_end_time >= now() and zp.promotion_status = 1 and pp.pp_is_forbid = 10 and products_status = 1';
		}else{
			$search_condition .= ' where pp_promotion_end_time <= now() or zp.promotion_status = 0 or pp.pp_is_forbid = 20 or products_status != 1';
		}
	}else{
		if($status == 1){
			$search_condition .= ' and ( pp_promotion_start_time > now() and zp.promotion_status = 1 and pp.pp_is_forbid = 10  and products_status = 1)';
		}elseif($status == 2){
			$search_condition .= ' and ( pp_promotion_start_time <= now() and pp_promotion_end_time >= now() and zp.promotion_status = 1 and pp.pp_is_forbid = 10  and products_status = 1)';
		}else{
			$search_condition .= ' and ( pp_promotion_end_time <= now() or zp.promotion_status = 0 or pp.pp_is_forbid = 20 or products_status != 1)';
		}
	}
}
if($promotion_key != '' && $promotion_key != '折扣区'){
	if($search_condition == ''){
		$search_condition .= ' where pp_promotion_id = "' . $promotion_key . '"';
	}else{
		$search_condition .= ' and pp_promotion_id = "' . $promotion_key . '"';
	}
}
if(sizeof($products_array) != '' ){
	if($search_condition == ''){
		$search_condition .= ' where zpt.products_model in ( "' . implode('","', $products_array) . '" )';
	}else{
		$search_condition .= ' and zpt.products_model in ( "' . implode('","', $products_array) . '" )';
	}
}	


$pageIndex = 1;
If($_GET['page'])
{
	$pageIndex = intval($_GET['page']);
}
$promotion_products_query_raw = "SELECT pp_id, pp_products_id, zpt.products_model, pp_promotion_id,zp.promotion_name, zp.promotion_discount, pp.pp_promotion_start_time, pp.pp_promotion_end_time, pp.pp_forbid_admin, pp.pp_forbid_time, zp.promotion_type , zp.promotion_status , pp.pp_is_forbid, pp.pp_max_num_per_order, zpt.products_status FROM (" . TABLE_PROMOTION_PRODUCTS . " pp INNER JOIN " . TABLE_PROMOTION . " zp ON zp.promotion_id = pp.pp_promotion_id) INNER JOIN " . TABLE_PRODUCTS . " zpt on zpt.products_id = pp.pp_products_id " . $search_condition . " order by pp_promotion_id desc , pp_id desc";
$promotion_products_split = new splitPageResults($pageIndex, MAX_DISPLAY_SEARCH_RESULTS, $promotion_products_query_raw, $query_numrows);
$promotion_products = $db->Execute($promotion_products_query_raw);

switch($action){
	case 'export':
		$promotion_products_query_raw = "SELECT pp_id, pp_products_id, zpt.products_model, pp_promotion_id,zp.promotion_name, zp.promotion_discount, pp.pp_promotion_start_time, pp.pp_promotion_end_time, pp.pp_forbid_admin, pp.pp_forbid_time, zp.promotion_type , zp.promotion_status , pp.pp_is_forbid, pp.pp_max_num_per_order, zpt.products_status FROM (" . TABLE_PROMOTION_PRODUCTS . " pp INNER JOIN " . TABLE_PROMOTION . " zp ON zp.promotion_id = pp.pp_promotion_id) INNER JOIN " . TABLE_PRODUCTS . " zpt on zpt.products_id = pp.pp_products_id " . $search_condition . " order by pp_promotion_id desc , pp_id desc";
		$promotion_products = $db->Execute($promotion_products_query_raw);
		$str = '<table border="1" valign="top" style="font-size:15px;width:600px;text-align: center;border-spacing: 0px;">
					<tr  style="background-color: #fff;height: 40px;">
						<th>商品编号</th>
	  					<th>折扣区</th>
						<th>折扣</th>
						<th>单笔最大购买数</th>
						<th>开始时间</th>
						<th>结束时间</th>
						<th>禁用人</th>
						<th>禁用时间</th>
						<th>状态</th>
						<th>应用场景</th>
					</tr>';

		if($promotion_products->RecordCount() > 0){
			while (!$promotion_products->EOF){
				$current_datetime = date("Y-m-d H:i:s");
				$start_datetime = $promotion_products->fields['pp_promotion_start_time'];
				$end_datetime = $promotion_products->fields['pp_promotion_end_time'];
					
				$promotion_active_state = '';
				if($promotion_products->fields['promotion_status'] == 0 || $promotion_products->fields['pp_is_forbid'] == 20 || $promotion_products->fields['products_status'] != 1 ){
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
								<td>' . $promotion_products->fields['pp_promotion_id'] . '</td>
								<td>' . $promotion_products->fields['promotion_discount'] . '%</td>
								<td>' . ($promotion_products->fields['pp_max_num_per_order'] > 0 ? $promotion_products->fields['pp_max_num_per_order'] : '/') . '</td>
								<td>' . $promotion_products->fields['pp_promotion_start_time']  . '</td>
								<td>' . $promotion_products->fields['pp_promotion_end_time']  . '</td>
								<td>' . ($promotion_products->fields['pp_forbid_admin'] ? $promotion_products->fields['pp_forbid_admin'] : '/') . '</td>
								<td>' . ($promotion_products->fields['pp_forbid_time'] ? $promotion_products->fields['pp_forbid_time'] : '/') . '</td>
								<td>' . $promotion_active_state . '</td>
								<td>' . ($promotion_products->fields['promotion_type'] == 1 ? '正常促销' : 'Deals促销' ) . '</td>
							</tr>';

				$promotion_products->MoveNext();
			}
		}
		$str.= '</table>';
		$promotion_id = str_replace(',' , '_' , $promotion_id);
		outputXlsHeader($str,"促销区部分商品" .date("Ymd"));

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
// 		$("select").change(function(){
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
            <td class="pageHeading"><span style="font-size: 20px;">促销商品信息</span></td>
            <td align="right" class="pageHeading" style="float: right;">
            <?php echo zen_draw_form('search_form', FILENAME_PROMOTION_PRODUCTS , '' , 'get' , 'id="search_form"')?>
				<table border="0" width="100%" cellspacing="0" cellpadding="3">
					<tr><td style="float: right;">应用场景：</td><td><?php echo zen_draw_pull_down_menu('type' , $promotion_types_arr , (isset($_GET['type'])?$_GET['type']: 0) , 'style="width:100px;height:20px;"');?></td></tr>
					<tr><td style="float: right;">状态：</td><td><?php echo zen_draw_pull_down_menu('status' , $status_arr , (isset($_GET['status'])?$_GET['status']: 0) , 'style="width:100px;height:20px;"');?></td></tr>
					<tr><td>折扣区ID：</td><td><?php echo zen_draw_input_field('promotion_key' , (isset($_GET['promotion_search']) ? $_GET['promotion_search'] : '折扣区') , 'onclick="if (this.value == \'折扣区\'){this.value=\'\';this.style.color=\'#000\';}" style="height: 25px;width: 100px;color: darkgray;"');?></td></tr>
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
                <td class="dataTableHeadingContent" align="center">折扣区</td>
                <td class="dataTableHeadingContent" align="center">折扣</td>
                <td class="dataTableHeadingContent" align="center">单笔最大购买数</td>
                <td class="dataTableHeadingContent" align="center">开始时间</td>
                <td class="dataTableHeadingContent" align="center">结束时间</td>
                <td class="dataTableHeadingContent" align="center">状态</td>
                <td class="dataTableHeadingContent" align="center">应用场景</td>
              </tr>
              <?php
              while(!$promotion_products->EOF){
              		$current_datetime = date("Y-m-d H:i:s");
					$start_datetime = $promotion_products->fields['pp_promotion_start_time'];
					$end_datetime = $promotion_products->fields['pp_promotion_end_time'];
					
					$promotion_active_state = '';
					if($promotion_products->fields['promotion_status'] == 0 || $promotion_products->fields['pp_is_forbid'] == 20 || $promotion_products->fields['products_status'] != 1 ){
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
	                <td class="dataTableHeadingContent" align="left"><?php echo $promotion_products->fields['pp_id'] ?></td> 
	                <td class="dataTableHeadingContent" align="center"><?php echo $promotion_products->fields['products_model'] ?></td>
	                 <td class="dataTableHeadingContent" align="center"><?php echo 'ID ' . $promotion_products->fields['pp_promotion_id'] . ' ' . $promotion_products->fields['promotion_name']?></td>
	                <td class="dataTableHeadingContent" align="center"><?php echo $promotion_products->fields['promotion_discount']?>%</td>
	                <td class="dataTableHeadingContent" align="center"><?php echo $promotion_products->fields['pp_max_num_per_order'] > 0 ? $promotion_products->fields['pp_max_num_per_order'] : '/' ?></td>
	                <td class="dataTableHeadingContent" align="center"><?php echo $promotion_products->fields['pp_promotion_start_time']?></td>
	                <td class="dataTableHeadingContent" align="center"><?php echo $promotion_products->fields['pp_promotion_end_time']?></td>
	                <td class="dataTableHeadingContent" align="center"><?php echo $promotion_active_state?></td>
	                <td class="dataTableHeadingContent" align="center"><?php echo $promotion_products->fields['promotion_type'] == 1 ? '正常促销':'Deals活动'?></td>
	              </tr>
             <?php 	$promotion_products->MoveNext();
              }
              ?>
              </table>
              <tr>
	              <td style="padding-top: 10px;">
		              <table border="0" width="100%" cellspacing="0" cellpadding="2">
		              <tr>
		             	 <td class="dataTableHeadingContent" colspan="3" align="left"><?php echo $promotion_products_split->display_count($query_numrows, MAX_DISPLAY_SEARCH_RESULTS,$pageIndex, TEXT_DISPLAY_NUMBER_OF_RESULTS); ?></td>
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