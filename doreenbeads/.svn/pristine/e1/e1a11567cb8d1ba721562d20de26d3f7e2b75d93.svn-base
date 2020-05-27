<?php
require('includes/application_top.php');
require_once(DIR_FS_CATALOG . DIR_WS_CLASSES . 'excel/PHPExcel.php');
require(DIR_FS_CATALOG . DIR_WS_FUNCTIONS . 'functions_shipping.php');
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$id = (isset($_GET['id']) ? $_GET['id'] : ($action == 'new' || $action == 'updates' ? 0 : 1));
global $db;
$max_shipping_id = $db->Execute('select id from t_shipping order by id desc limit 1');
if ($max_shipping_id->RecordCount() == 1){
	$max_shipping_id = (int)$max_shipping_id->fields['id'];
}
if(zen_not_null($action)){
	switch ($action){
		case 'save':
		case 'insert':
			$error = false;
			//bof t_shipping
			$operate_time = date('Y-m-d H:i:s');			
			$sql_data_array= array(array('fieldName'=>'discount', 'value'=>zen_db_prepare_input($_POST['s_discount']), 'type'=>'float'),
                           		   array('fieldName'=>'extra_oil', 'value'=>zen_db_prepare_input($_POST['s_extra_oil']), 'type'=>'float'),
                           		   array('fieldName'=>'extra_amt', 'value'=>zen_db_prepare_input($_POST['s_extra_amt']), 'type'=>'float'),
                           		   array('fieldName'=>'extra_times', 'value'=>zen_db_prepare_input($_POST['s_extra_times']), 'type'=>'float'),
                           		   array('fieldName'=>'cal_remote', 'value'=>$_POST['s_cal_remote'], 'type'=>'integer'),
                           		   array('fieldName'=>'cal_volume', 'value'=>$_POST['s_cal_volume'], 'type'=>'integer'),
                           		   array('fieldName'=>'ask_delivered_days', 'value'=>$_POST['s_ask_days'], 'type'=>'integer'),
								   array('fieldName'=>'time_unit', 'value'=>$_POST['s_time_unit'], 'type'=>'integer'),
								   array('fieldName'=>'track_url', 'value'=>$_POST['s_track_url'], 'type'=>'string'),
								   array('fieldName'=>'status', 'value'=>$_POST['s_status'], 'type'=>'integer'),
								   array('fieldName'=>'modify_datetime', 'value'=>$operate_time, 'type'=>'string'));
			if ($action == 'insert'){
				$new_id = zen_db_prepare_input($_POST['s_id']);
				$new_code = zen_db_prepare_input($_POST['s_code']);
				$check_id = $db->Execute('select id from ' . TABLE_SHIPPING . ' where id = ' . $new_id);
				if ($check_id->RecordCount() > 0){
					$messageStack->add_session('id已存在，添加失败!', 'error');
					$error = true;
				}
				$check_code = $db->Execute('select id from ' . TABLE_SHIPPING . ' where code = "' . $new_code . '"');
				if ($check_code->RecordCount() > 0){
					$messageStack->add_session('代码已存在，添加失败!', 'error');
					$error = true;
				}
				if (!$error){
					$id = $new_id;
					$sql_data_array1 = array(array('fieldName'=>'id', 'value'=>$new_id, 'type'=>'integer'),
											 array('fieldName'=>'code', 'value'=>$new_code, 'type'=>'string'),
											 array('fieldName'=>'name', 'value'=>zen_db_prepare_input($_POST['s_name']), 'type'=>'string'));
					$sql_data_array = array_merge($sql_data_array1, $sql_data_array);
					$db->perform(TABLE_SHIPPING, $sql_data_array);
				}				
			}else{
				$where_clause = "id = :id";
				$where_clause = $db->bindVars($where_clause, ':id', $id, 'integer');
				$db->perform(TABLE_SHIPPING, $sql_data_array, 'update', $where_clause);
			}			
			//eof
			if (!$error){
				//bof currency
//				if (isset($_POST['currency']) && $_POST['currency'] > 0){
//					$db->Execute('update ' . TABLE_CONFIGURATION . ' set configuration_value = ' . zen_db_prepare_input($_POST['currency']) . ' where configuration_key = "MODULE_SHIPPING_CHIANPOST_CURRENCY"');
//				}
				//eof
				
				//bof t_shipping_info, title
				$query = $db->Execute('select id from t_shipping_info where id = ' . $id);
				$language = zen_get_languages();
				if ($query->RecordCount() > 0){
					foreach ($language as $key => $val){
						$sql_data_array= array(array('fieldName'=>'title', 'value'=>zen_db_prepare_input($_POST['s_title'][$val['id']]), 'type'=>'string'));
						$where_clause = "id = :id and language_id = " . $val['id'];
						$where_clause = $db->bindVars($where_clause, ':id', $id, 'integer');
						$db->perform(TABLE_SHIPPING_INFO, $sql_data_array, 'update', $where_clause);
					}
				}else{
					foreach ($language as $key => $val){
						$sql_data_array= array(array('fieldName'=>'id', 'value'=>$id, 'type'=>'integer'),
					                           array('fieldName'=>'code', 'value'=>$_POST['s_code'], 'type'=>'string'),
					                           array('fieldName'=>'language_id', 'value'=>$val['id'], 'type'=>'integer'),
					                           array('fieldName'=>'title', 'value'=>zen_db_prepare_input($_POST['s_title'][$val['id']]), 'type'=>'string'));
						$db->perform(TABLE_SHIPPING_INFO, $sql_data_array);
					}					
				}
				//eof
				
				//bof t_shipping_day
				$code_query = $db->Execute('select code from ' . TABLE_SHIPPING . ' where id = ' . $id);
				$code = $code_query->fields['code'];
				$country_id_array = $_POST['country_id'];
				$day_low_array = $_POST['s_day_low'];
				$day_high_array = $_POST['s_day_high'];
				for ($i = 0; $i < sizeof($country_id_array); $i++){
					if ($day_low_array[$i] != '' && $day_high_array[$i] != ''){
						$iso_code = '';
						if($country_id_array[$i] != ''){
							$country_query = $db->Execute('select countries_iso_code_2 from ' . TABLE_COUNTRIES . ' where countries_id = ' . $country_id_array[$i]);
							$iso_code = $country_query->fields['countries_iso_code_2'];
						}
						$day_low = ($day_low_array[$i] < $day_high_array[$i] ? $day_low_array[$i] : $day_high_array[$i]);
						$day_high = ($day_high_array[$i] > $day_low_array[$i] ? $day_high_array[$i] : $day_low_array[$i]);
						$day_query = $db->Execute('select code from ' . TABLE_SHIPPING_DAY . ' where code = "' . $code . '" and country_iso2 = "' . $iso_code . '"');
						$sql_data_array= array(array('fieldName'=>'code', 'value'=>$code, 'type'=>'string'),
								array('fieldName'=>'country_iso2', 'value'=>$iso_code, 'type'=>'string'),
								array('fieldName'=>'day_low', 'value'=>$day_low, 'type'=>'string'),
								array('fieldName'=>'day_high', 'value'=>$day_high, 'type'=>'string'));
						if ($day_query->RecordCount() > 0){
							$db->perform(TABLE_SHIPPING_DAY, $sql_data_array, 'update', 'code="' . $code . '" and country_iso2 = "' . $iso_code . '"');
						}else{
							$db->perform(TABLE_SHIPPING_DAY, $sql_data_array);
						}
					}
				}
				//bof
				zen_redirect(zen_href_link('shipping', zen_get_all_get_params(array('action'))));
			}else{
				zen_redirect(zen_href_link('shipping', zen_get_all_get_params(array('action')) . 'action=new'));
			}
			break;
		case 'delday':
			$del_id = zen_db_prepare_input($_GET['id']);
			$del = false;
			if ($del_id != ''){
				$del_code_result = $db->Execute('select code from ' . TABLE_SHIPPING . ' where id = ' . $del_id);
				$del_code = $del_code_result->fields['code'];
				if ($del_code != ''){
					$del_country = zen_db_prepare_input($_GET['c']);
					if ($del_code != '' && $del_country != ''){
						$db->Execute('delete from ' . TABLE_SHIPPING_DAY . ' where country_iso2 = "' . $del_country . '" and code = "' . $del_code . '"');
						$del = true;						
					}
				}
			}
			if ($del){
				$messageStack->add_session('删除天数成功!', 'success');
			}else{
				$messageStack->add_session('删除天数失败!', 'caution');
			}
			zen_redirect(zen_href_link('shipping', zen_get_all_get_params(array('action', 'c')) . 'action=edit'));
			break;
		case 'process' :
			require(DIR_WS_MODULES . 'shipping.php');
			break;
		case 'search' :
             $status = zen_db_input($_GET['status']);
             $EID  = zen_db_input($_GET['EID']);
             $code = zen_db_input($_GET['code']);
             $name = zen_db_input($_GET['name']);
             if($status != 3){
             	if($status == 2){
             		$status = 0;
             	}
             	if($search_condition == ''){
                  $search_condition .= ' where status ='. $status;
             	}
             }
             if($_GET['EID'] != ''){
             	if($search_condition == ''){
             	  $search_condition .= ' where erp_id like "%'. $EID . '%"';
             	}else{
             	  $search_condition .= ' and erp_id like "%'. $EID . '%"';
             	}
             }
             if($_GET['code'] != ''){
             	if($search_condition == ''){
             	  $search_condition .= ' where code like "%'. $code . '%"';
             	}else{
             	  $search_condition .= ' and code like "%'. $code . '%"';
             	}
             }
             if($_GET['name'] != ''){
             	if($search_condition == ''){
             		$search_condition .= ' where name like "%'. $name .'%"';
             	}else{
             		$search_condition .= ' and name like "%'. $name .'%"';
             	}
             }
	        break;
	}
}
// $order_by = (isset($_POST['orderbyselect']) && $_POST['orderbyselect'] != '' ? $_POST['orderbyselect'] : (isset($_GET['orderby']) ? $_GET['orderby'] : 'id'));
// $order_by = (isset($_GET['orderby']) ? $_GET['orderby'] : (isset($_POST['orderbyselect']) && $_POST['orderbyselect'] != '' ? $_POST['orderbyselect'] : 'id'));
// $order = str_replace('-', ' ', $order_by);
$shipping_sql = 'select * from ' . TABLE_SHIPPING . $search_condition .' order by status desc ';
$shipping_result = $db->Execute($shipping_sql);
if ($shipping_result->RecordCount() > 0) {
	$i = 1;
	while ( ! $shipping_result->EOF ) {
		if ( isset($_GET['id']) && $_GET['id'] == $shipping_result->fields['id']){
			$_GET['page'] = ceil($i / 20);
			$shipping_result->EOF = true;
		}
		$i++;
		$shipping_result->MoveNext();
	}
}
$shipping_split = new splitPageResults($_GET['page'], 20, $shipping_sql, $shipping_query_numrows);
$shipping = $db->Execute($shipping_sql);
if ($shipping->RecordCount() > 0) {
	while ( ! $shipping->EOF ) {
		$shipping_day = get_all_shipping_day($shipping->fields ['code']);
	  	$shipping_title = get_shipping_title($shipping->fields ['id']);
	  	$shipping_method [$shipping->fields ['code']] = array (
	  				'id' => $shipping->fields ['id'],
	  				'status' => $shipping->fields ['status'],
	  				'name' => $shipping->fields ['name'],
	  				'title' => $shipping_title,
	  				'shipping_day' => $shipping_day,
	  				'code' => $shipping->fields ['code'],
	  				'extra_oil' => $shipping->fields ['extra_oil'],
	  				'extra_amt' => $shipping->fields ['extra_amt'],
	  				'discount' => $shipping->fields ['discount'],
	  				'cal_volume' => $shipping->fields ['cal_volume'],
	  				'cal_remote' => $shipping->fields ['cal_remote'],
	  				'min_weight_kg' => $shipping->fields ['min_weight_kg'],
	  				'max_weight_kg' => $shipping->fields ['max_weight_kg'],
	  				'extra_times' => $shipping->fields ['extra_times'],
	  				'split_type' => $shipping->fields ['split_type'],
	  				'cal_type' => $shipping->fields ['cal_type'],
	  				'track_url' => $shipping->fields ['track_url'],
	  				'disable_country' => $shipping->fields ['disable_country'],
	  				'disable_postcode' => $shipping->fields ['disable_postcode'],
	  				'disable_city' => $shipping->fields ['disable_city'],
	  				'disable_product' => $shipping->fields ['disable_product'],
	  				'erp_id' => $shipping->fields ['erp_id'],
	  				'ask_delivered_days' => $shipping->fields ['ask_delivered_days'],
	  				'time_unit' => $shipping->fields ['time_unit'],
	  				'modify_datetime' => $shipping->fields ['modify_datetime']
	  	);
	  	$shipping->MoveNext();
	}
}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title>Shipping Modules</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript" src="includes/jquery.js"></script>
<script language="javascript" src="includes/shipping.js"></script>
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

$(function(){
	$('.add_country_day').click(function(){
		if($('.country_time_else').length == 0){
			$('.table_country_time tr').addClass('country_time_else');
			$('.table_country_time tr td:first').html('<td><input type="hidden" name="country_id[]">其他:</td>');
		}
		$('.country_time_else').before('<tr><td><?php echo zen_get_country_list('country_id[]');?></td><td><input type="text" name="s_day_low[]"> <input type="text" name="s_day_high[]"> <a href="javascript:void(0);" class="delete_day"><img src="images/icon_delete.gif"></a></td></tr>');
	})
})
</script>
</head>
<body onLoad="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>

<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td>
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading">Shipping Modules</td>
            <td class="pageHeading" align="right">
            	<a href="<?php echo zen_href_link('shipping', 'action=updates'. '&orderby=' . $order_by);?>" style="position:absolute; right:590px;bottom: 665px;">更新运费数据</a>
            	<a href="<?php echo zen_href_link('shipping', zen_get_all_get_params(array('action', 'id')) . 'action=new', 'NONSSL');?>" style="position:absolute; right:480px;bottom: 665px;"><?php echo zen_image_button('button_insert_cn.png');?></a>            	
            </td>            
          </tr>
        </table>
        </td>
        <td align="right">
        	<!-- <?php 
            	$order_by_array = array(array('id' => 'id', 'text' => '编号'),
										array('id' => 'id-desc', 'text' => '编号降序'),
										array('id' => 'code', 'text' => '代码'),
										array('id' => 'code-desc', 'text' => '代码降序'),
										array('id' => 'extra_oil', 'text' => '燃油率'),
										array('id' => 'extra_oil-desc', 'text' => '燃油率降序'),
										array('id' => 'discount', 'text' => '折扣'),
										array('id' => 'discount-desc', 'text' => '折扣降序'));
            	echo zen_draw_form('orderby', 'shipping', zen_get_all_get_params(array('action')));
            	echo '排序: ' . zen_draw_pull_down_menu('orderbyselect', $order_by_array, $order_by, 'onchange="this.form.submit();"');
            	echo '</form>';
            ?> -->
             <?php
               $status_str_arr = array(array('id' => 3, 'text' => '全部'),
                                       array('id' => 1, 'text' => '开启'),
                                       array('id' => 2, 'text' => '关闭')
                                      );
            ?> 
            <form name="search" action="<?php echo zen_href_link(FILENAME_SHIPPINGS)?>" method="get">
            	<table width="100%" border="0" cellspacing="5" cellpadding="0">
            		<tr><td  align="right"><?php echo zen_draw_hidden_field('action' , 'search')?><span >状态：</span><?php echo zen_draw_pull_down_menu('status', $status_str_arr , $_GET['status'] ? $_GET['status'] : '' , 'style="width: 100px;height: 20px;"')?></td></tr>
            		<tr><td  align="right">请输入ERP ID：<?php echo zen_draw_input_field('EID' , $_GET['EID'] ? $_GET['EID'] :'' , 'style="height: 25px;width: 100px;"')?></td></tr>
            		<tr><td  align="right">请输入代码：<?php echo zen_draw_input_field('code' , $_GET['code'] ? $_GET['code'] :'' , 'style="height: 25px;width: 100px;"')?></td></tr>
            		<tr><td  align="right">请输入运输方式名称：<?php echo zen_draw_input_field('name' , $_GET['name'] ? $_GET['name'] :'' , 'style="height: 25px;width: 100px;"')?></td></tr>
            		<tr><td  align="right"><?php echo zen_image_submit('button_search_cn.png','Search');?></td></tr>
            	</table>
            </form>
      </td>
      </tr>
      <tr>
        <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">          
          <tr>
            <td valign="top">
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent">ID</td>
                <td class="dataTableHeadingContent">ERP ID</td>
                <td class="dataTableHeadingContent">名称</td>
                <td class="dataTableHeadingContent">代码</td>
                <td class="dataTableHeadingContent">折扣</td>
                <td class="dataTableHeadingContent">燃油率</td>
                <td class="dataTableHeadingContent">定额附加</td>
                <td class="dataTableHeadingContent">额外倍数</td>
                <td class="dataTableHeadingContent">考虑偏远</td>
                <td class="dataTableHeadingContent">考虑体积</td>
                <td class="dataTableHeadingContent">状态</td>
                <td class="dataTableHeadingContent">最近更新时间</td>
                <td class="dataTableHeadingContent">编辑</td>
              </tr>
              <?php 
              	if (!isset($_GET['id']) && $action != 'new' && $action != 'updates'){
					$first_method = reset($shipping_method);
					$id = $first_method['id'];
	            }
              	foreach ($shipping_method as $method => $val){
					
					if ($id == $val['id']) {
						$mInfo = new objectInfo($val);
						echo '<tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link('shipping', zen_get_all_get_params(array('action', 'id', 'orderby')) . 'action=edit&id=' . $val['id'] . '&orderby=' . $order_by, 'NONSSL') . '\'">' . "\n";
					}else {
						echo '<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link('shipping', zen_get_all_get_params(array('id', 'orderby', 'action')) . 'id=' . $val['id']. '&orderby=' . $order_by, 'NONSSL') . '\'">' . "\n";
					}
              ?>              
                <td class="dataTableHeadingContent"><?php echo $val['id']?></td>
                <td class="dataTableHeadingContent"><?php echo $val['erp_id']?></td>
                <td class="dataTableHeadingContent"><?php echo $val['name']?></td>
                <td class="dataTableHeadingContent"><?php echo $val['code']?></td>
                <td class="dataTableHeadingContent"><?php echo $val['discount']?></td>
                <td class="dataTableHeadingContent"><?php echo $val['extra_oil']?></td>
                <td class="dataTableHeadingContent"><?php echo $val['extra_amt']?></td>
                <td class="dataTableHeadingContent"><?php echo $val['extra_times']?></td>
                <td class="dataTableHeadingContent"><?php echo $val['cal_remote']?></td>
                <td class="dataTableHeadingContent"><?php echo $val['cal_volume']?></td>
                <td class="dataTableHeadingContent"><?php echo ($val['status'] ? '<img src="images/icon_status_green.gif">' : '<img src="images/icon_status_yellow.gif">')?></td>
                <td class="dataTableHeadingContent"><?php echo $val['modify_datetime'];?></td>
                <td class="dataTableHeadingContent">
                <a href="<?php echo zen_href_link('shipping', zen_get_all_get_params(array('action', 'id', 'orderby')) . 'action=edit&id=' . $val['id']. '&orderby=' . $order_by);?>"><?php echo zen_image(DIR_WS_IMAGES . 'icon_edit.gif', ICON_EDIT);?></a>
                <?php
                	if (isset($mInfo) && is_object($mInfo) && ($val['id'] == $mInfo->id)) {
						echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', '');
					} else {
						echo '<a href="' . zen_href_link('shipping', zen_get_all_get_params(array('id')) . 'id=' . $val['id'], 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>';
					}
				?>
                </td>
              </tr>
              <?php } ?>
              <tr>
                    <td class="smallText" valign="top" colspan="5"><?php echo $shipping_split->display_count($shipping_query_numrows, 20, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_SHIPPING_METHODS); ?></td>
                    <td class="smallText" align="right" colspan="6"><?php echo $shipping_split->display_links($shipping_query_numrows, 20, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'orderby', 'id')) . 'orderby=' . $order_by); ?></td>
                  </tr>
              </table>
              </td>
              </tr>
              <tr><td align="right"><a href="<?php echo zen_href_link('shipping', zen_get_all_get_params(array('action', 'id')) . 'action=new', 'NONSSL');?>"><?php echo zen_image_button('button_insert_cn.png');?></a></td></tr>
              </table>
            </td>
<?php
$heading = array();
$contents = array();
$language = zen_get_languages();
// echo '<pre>';
// print_r($language);exit;
switch ($action) {
	case 'edit':
		$heading[] = array('text' => '<b>ID:' . $mInfo->id . ' ' . $mInfo->name . ' ' . $mInfo->code . '</b>');
		$contents = array('form' => zen_draw_form('shipping', 'shipping', zen_get_all_get_params(array('action', 'id', 'orderby')) . 'action=save&id=' . $mInfo->id. '&orderby=' . $order_by, 'post', '', true));		
		$str_table = '<table border="0" cellspacing="0" cellpadding="10">';
		if ($mInfo->id == 3){
			$currency_query = $db->Execute('select configuration_value from ' . TABLE_CONFIGURATION . ' where configuration_key = "MODULE_SHIPPING_CHIANPOST_CURRENCY"');
			$currency = $currency_query->fields['configuration_value'];
			$str_table .= '<tr><td width="80">汇率:</td><td>' . $currency . '</td></tr>';
		}
		foreach ($language as $key => $val){
			$str_table .= '<tr><td width="80">前台名称(' . $val['code'] . '):</td><td>' . zen_draw_input_field('s_title[' . $val['id'] . ']', $mInfo->title[$val['id']], 'style="width:300px;"') . '</td></tr>';
		}		
		$country_num = sizeof($mInfo->shipping_day);
		$str_day = '<table border="0" cellspacing="0" cellpadding="5" class="table_country_time">';
		if ($country_num > 0){			
			foreach ($mInfo->shipping_day as $key => $val){
				if ($key == 'default' || $key == ''){
					$country_name = ($country_num == 1 ? '所有' : '其他');
				}else{
					$c = $db->Execute('select countries_name, countries_id, countries_iso_code_2 from ' . TABLE_COUNTRIES . ' where countries_iso_code_2 = "' . $key . '"');
					$country_name = ($c->fields['countries_name'] != '' ? $c->fields['countries_name'] : ($country_num == 1 ? '所有' : '其他'));
				}
				if ($country_name == '其他'){
					$str_day_else = '<tr class="country_time_else"><td>' . zen_draw_hidden_field('country_id[]', $c->fields['countries_id']) . $country_name . ':</td><td>' . zen_draw_input_field('s_day_low[]', $val['day_low']) . ' ' . zen_draw_input_field('s_day_high[]', $val['day_high']) . '</td></tr>';
				}else{
					$str_day .= '<tr><td>' . zen_draw_hidden_field('country_id[]', $c->fields['countries_id']) . $country_name . ':</td><td>' . zen_draw_input_field('s_day_low[]', $val['day_low']) . ' ' . zen_draw_input_field('s_day_high[]', $val['day_high']);
					if ($country_name != '所有'){
						 $str_day .= ' ' . '<a href="' . zen_href_link('shipping', zen_get_all_get_params(array('id', 'action')) . 'id=' . $mInfo->id . '&action=delday&c=' . $c->fields['countries_iso_code_2'], 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_delete.gif') . '</a>' . '</td></tr>';
					}
				}
			}			
		}else{
			$str_day .= '<tr><td>所有:</td><td>' . zen_draw_input_field('s_day_low[]') . ' ' . zen_draw_input_field('s_day_high[]') . '</td></tr>';
			$str_day_else = '';
		}
		$operate_time = date('Y-m-d H:i:s');
		$str_day .= $str_day_else;
		$str_day .= '</table>';
		$str_table .= '<tr><td>运送国家&天数:</td><td>' . $str_day . '</td></tr>';
		$str_table .= '<tr><td>运输时间单位:</td><td>' . zen_draw_radio_field('s_time_unit', '10', ($mInfo->time_unit == 10 ? true : false)) . 'days' . zen_draw_radio_field('s_time_unit', '20', ($mInfo->time_unit == 10 ? false : true)) . 'workdays' . '</td></tr>';
		$str_table .= '<tr><td>回访邮件发送时间:</td><td>' . zen_draw_input_field('s_ask_days', $mInfo->ask_delivered_days) . '</td></tr>';
		$str_table .= '<tr><td>折扣:</td><td>' . zen_draw_input_field('s_discount', $mInfo->discount) . '</td></tr>';
		$str_table .= '<tr><td>燃油率:</td><td>' . zen_draw_input_field('s_extra_oil', $mInfo->extra_oil) . '</td></tr>';
		$str_table .= '<tr><td>定额附加:</td><td>' . zen_draw_input_field('s_extra_amt', $mInfo->extra_amt) . '</td></tr>';
		$str_table .= '<tr><td>额外倍数:</td><td>' . zen_draw_input_field('s_extra_times', $mInfo->extra_times) . '</td></tr>';
		$str_table .= '<tr><td>跟踪网址:</td><td>' . zen_draw_input_field('s_track_url', $mInfo->track_url) . '</td></tr>';
		$str_table .= '<tr><td>考虑偏远:</td><td>' . zen_draw_radio_field('s_cal_remote', '1', ($mInfo->cal_remote ? true : false)) . '是' . zen_draw_radio_field('s_cal_remote', '0', ($mInfo->cal_remote ? false : true)) . '否' . '</td></tr>';
		$str_table .= '<tr><td>考虑体积:</td><td>' . zen_draw_radio_field('s_cal_volume', '1', ($mInfo->cal_volume ? true : false)) . '是' . zen_draw_radio_field('s_cal_volume', '0', ($mInfo->cal_volume ? false : true)) . '否' . '</td></tr>';
		$str_table .= '<tr><td>状态:</td><td>' . zen_draw_radio_field('s_status', '1', ($mInfo->status ? true : false)) . '开启' . zen_draw_radio_field('s_status', '0', ($mInfo->status ? false : true)) . '关闭' . '</td></tr>';
		$str_table .= '<tr><td>最近更新时间：</td><td>'.$operate_time.'</td></tr>';
		$str_table .= '<tr><td colspan="2">' . zen_image_submit('button_submit_cn.png') . ' <a href="' . zen_href_link('shipping', zen_get_all_get_params(array('id', 'action')) . 'id=' . $mInfo->id, 'NONSSL') . '">' . zen_image_button('button_cancel_cn.png', IMAGE_CANCEL) . '</a> <a href="javascript:void(0);" class="add_country_day" style="position:relative;bottom:10px;">添加国家和时间</a></td></tr>';
		$str_table .= '</table>';
		$str_table .= '</form>';
		$contents[] = array('text' => $str_table);
		break;
	case 'new':
	    $operate_time = date('Y-m-d H:i:s');
		$heading[] = array('text' => '<b>添加新运送方式</b>');
		$contents = array('form' => zen_draw_form('shipping', 'shipping', zen_get_all_get_params(array('action', 'orderby')) . 'action=insert&orderby=' . $order_by, 'post', '', true));
		$str_table = '<table border="0" cellspacing="0" cellpadding="10">';
		$str_table .= '<tr><td width="80">ID:</td><td>' . zen_draw_input_field('s_id',$max_shipping_id+1) . '</td></tr>';
		$str_table .= '<tr><td width="80">名称:</td><td>' . zen_draw_input_field('s_name') . '</td></tr>';
		$str_table .= '<tr><td width="80">代码:</td><td>' . zen_draw_input_field('s_code') . '</td></tr>';
		
		foreach ($language as $key => $val){
			$str_table .= '<tr><td width="80">前台名称(' . $val['code'] . '):</td><td>' . zen_draw_input_field('s_title[' . $val['id'] . ']', '', 'style="width:300px;"') . '</td></tr>';
		}
		
		$str_day = '<table border="0" cellspacing="0" cellpadding="5" class="table_country_time">';
		$str_day .= '<tr><td>所有:' . zen_draw_hidden_field('country_id[]') . '</td><td>' . zen_draw_input_field('s_day_low[]') . ' ' . zen_draw_input_field('s_day_high[]') . '</td></tr>';
		$str_day .= '</table>';
		
		$str_table .= '<tr><td>运送国家&天数:</td><td>' . $str_day . '</td></tr>';
		$str_table .= '<tr><td>运输时间单位:</td><td>' . zen_draw_radio_field('s_time_unit', '10', true) . 'days' . zen_draw_radio_field('s_time_unit', '20', false) . 'workdays' . '</td></tr>';
		$str_table .= '<tr><td>回访邮件发送时间:</td><td>' . zen_draw_input_field('s_ask_days', '0')  . '</td></tr>';
		$str_table .= '<tr><td>折扣:</td><td>' . zen_draw_input_field('s_discount', '1') . '</td></tr>';
		$str_table .= '<tr><td>燃油率:</td><td>' . zen_draw_input_field('s_extra_oil', '0') . '</td></tr>';
		$str_table .= '<tr><td>定额附加:</td><td>' . zen_draw_input_field('s_extra_amt', '0') . '</td></tr>';
		$str_table .= '<tr><td>额外倍数:</td><td>' . zen_draw_input_field('s_extra_times', '1.02') . '</td></tr>';
		$str_table .= '<tr><td>跟踪网址:</td><td>' . zen_draw_input_field('s_track_url', '') . '</td></tr>';
		$str_table .= '<tr><td>考虑偏远:</td><td>' . zen_draw_radio_field('s_cal_remote', '1', false) . '是' . zen_draw_radio_field('s_cal_remote', '0', true) . '否' . '</td></tr>';
		$str_table .= '<tr><td>考虑体积:</td><td>' . zen_draw_radio_field('s_cal_volume', '1', false) . '是' . zen_draw_radio_field('s_cal_volume', '0', true) . '否' . '</td></tr>';
		$str_table .= '<tr><td>状态:</td><td>' . zen_draw_radio_field('s_status', '1', true) . '开启' . zen_draw_radio_field('s_status', '0', false) . '关闭' . '</td></tr>';
		$str_table .= '<tr><td>最近更新时间：</td><td>'.$operate_time.'</td></tr>';
		$str_table .= '<tr><td colspan="2">' . zen_image_submit('button_submit_cn.png') . ' <a href="' . zen_href_link('shipping', '', 'NONSSL') . '">' . zen_image_button('button_cancel_cn.png', IMAGE_CANCEL) . '</a> <a href="javascript:void(0);" class="add_country_day" style="position:relative;bottom:10px;">添加国家和时间</a></td></tr>';
		$str_table .= '</table>';
		$str_table .= '</form>';
		$contents[] = array('text' => $str_table);
		break;
	case 'updates':
		$heading[] = array('text' => '<b>更新/添加运费数据</b>');
		$contents = array('form' => zen_draw_form('shipping_data', 'shipping', zen_get_all_get_params(array('action', 'orderby')) . 'action=process'. '&orderby=' . $order_by, 'post', 'enctype="multipart/form-data"', true));
		
		$str_table = '<table border="0" cellspacing="0" cellpadding="10">';
		$str_table .= '<tr><td><b>代码: </b></td><td>' . zen_draw_input_field('method_code', $_SESSION['method_code']) . ' <span class="fieldRequired">* 必须滴</span></td></tr>';
		$str_table .= '<tr><td><b>地域运费: </b></td><td>' . zen_draw_file_field('postage_file') . '</td></tr>';
		$str_table .= '<tr><td><b>国家分区: </b></td><td>' . zen_draw_file_field('country_file') . '</td></tr>';
		$str_table .= '</table>';
		$str_table .= '</form>';
		
		$contents[] = array('text' => $str_table);
		$contents[] = array('align' => 'center', 'text' => '<br>' . zen_image_submit('button_submit_cn.png') . ' <a href="' . zen_href_link('shipping', '&orderby=' . $order_by, 'NONSSL') . '">' . zen_image_button('button_cancel_cn.png', IMAGE_CANCEL) . '</a>');
		break;
	default:
		$heading[] = array('text' => '<b>ID:' . $mInfo->id . ' ' . $mInfo->name . ' ' . $mInfo->code . '</b>');
		$contents[] = array('text' => '<div style="float:right;"><a href="' . zen_href_link('shipping', zen_get_all_get_params(array('action', 'id', 'orderby')) . 'action=edit&id=' . $mInfo->id . '&orderby=' . $order_by) . '">' . zen_image_button('button_edit_cn.png') . '</a></div>');
		
		$country_num = sizeof($mInfo->shipping_day);
		if ($country_num > 0){
			$str_day = '<table border="0" cellspacing="0" cellpadding="5">';
			foreach ($mInfo->shipping_day as $key => $val){
				if ($key == 'default' || $key == ''){
					$country_name = ($country_num == 1 ? '所有' : '其他');
				}else{
					$c = $db->Execute('select countries_name from ' . TABLE_COUNTRIES . ' where countries_iso_code_2 = "' . $key . '"');
					$country_name = ($c->fields['countries_name'] != '' ? $c->fields['countries_name'] : ($country_num == 1 ? '所有' : '其他'));
				}
				if ($country_name == '其他'){
					$str_day_else = '<tr><td>' . $country_name . ':</td><td>' . $val['day_low'] . '-' . $val['day_high'] . '天</td></tr>';
				}else{
					$str_day .= '<tr><td>' . $country_name . ':</td><td>' . $val['day_low'] . '-' . $val['day_high'] . '天</td></tr>';
				}
			}
			$str_day .= $str_day_else;
			$str_day .= '</table>';
		}
		$str_table = '<table border="0" cellspacing="0" cellpadding="10">';
		if ($mInfo->id == 3){
			$currency_query = $db->Execute('select configuration_value from ' . TABLE_CONFIGURATION . ' where configuration_key = "MODULE_SHIPPING_CHIANPOST_CURRENCY"');
			$currency = $currency_query->fields['configuration_value'];
			$str_table .= '<tr><td width="80">汇率:</td><td>' . $currency . '</td></tr>';
		}
// 		$str_table .= '<tr><td width="80">前台名称:</td><td>' . $mInfo->title . '</td></tr>';
		foreach ($language as $key => $val){
			$str_table .= '<tr><td width="80">前台名称(' . $val['code'] . '):</td><td>' . $mInfo->title[$val['id']] . '</td></tr>';
		}
		$time_unit = 'days';
		if ($mInfo->time_unit == 20) {
			$time_unit = 'workdays';
		}
		$str_table .= '<tr><td>运送国家&天数:</td><td>' . $str_day . '</td></tr>';
		$str_table .= '<tr><td>运输时间单位:</td><td>' . $time_unit . '</td></tr>';
		$str_table .= '<tr><td>回访邮件发送时间:</td><td>' . $mInfo->ask_delivered_days  . '</td></tr>';
		$str_table .= '<tr><td>折扣:</td><td>' . $mInfo->discount . '</td></tr>';
		$str_table .= '<tr><td>燃油率:</td><td>' . $mInfo->extra_oil . '</td></tr>';
		$str_table .= '<tr><td>定额附加:</td><td>' . $mInfo->extra_amt . '</td></tr>';
		$str_table .= '<tr><td>额外倍数:</td><td>' . $mInfo->extra_times . '</td></tr>';
		$str_table .= '<tr><td>跟踪网址:</td><td>' . $mInfo->track_url . '</td></tr>';
		$str_table .= '<tr><td>考虑偏远:</td><td>' . $mInfo->cal_remote . '</td></tr>';
		$str_table .= '<tr><td>考虑体积:</td><td>' . $mInfo->cal_volume . '</td></tr>';
		$str_table .= '<tr><td>状态:</td><td>' . $mInfo->status . '</td></tr>';	
		$str_table .= '<tr><td>最近更新时间：</td><td>'.$mInfo->modify_datetime.'</td></tr>';	
		$str_table .= '</table>';
		$contents[] = array('text' => $str_table);
		break;
}
if ( (zen_not_null($heading)) && (zen_not_null($contents)) ) {
	echo '<td width="25%" valign="top">';
	$box = new box;
	echo $box->infoBox($heading, $contents);
	echo '</td>';
}
?>
          </tr>
       </table>
    </td>
  </tr>
</table>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>