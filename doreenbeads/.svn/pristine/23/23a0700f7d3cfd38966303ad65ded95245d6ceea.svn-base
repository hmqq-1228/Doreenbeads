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
$date_now = date("Y-m-d H:i:s");

$coupon_status_pickup = trim(zen_db_prepare_input($_GET['coupon_status_pickup']));
$date_created_start = trim(zen_db_prepare_input($_GET['date_created_start']));
$date_created_end = trim(zen_db_prepare_input($_GET['date_created_end']));
$coupon_name = trim(zen_db_prepare_input($_GET['coupon_name']));
$coupon_code = trim(zen_db_prepare_input($_GET['coupon_code']));

if (zen_not_null($action)) {

	switch ($action) {
		case 'insert' :
		case 'forbidden' :
			$error = "";
			
			$coupon_id = zen_db_prepare_input(trim($_GET['coupon_id']));
			$sql = "select coupon_code from " . TABLE_COUPONS . " where coupon_id= " . $coupon_id . " and coupon_status=1";
	        $query = $db->Execute($sql);
			if($query->RecordCount() <= 0) {
				$error = '禁用失败，该Coupon不存在或已禁用!';
			}
			
			if(!empty($error)) {
				$messageStack->add_session($error, 'error');
	            zen_redirect(zen_href_link(FILENAME_COUPON_MANAGE,zen_get_all_get_params(array('action')) . '&action=detail'));  
			}
			
			if (empty($error)) {

				$sql_data_array = array (
					'coupon_status' => 0,
					'admin_email_modified' => $_SESSION['admin_email'],
					'date_modified' => 'now()'
				);

				zen_db_perform(TABLE_COUPONS, $sql_data_array, 'update', "coupon_id = '" . $coupon_id . "'");
				$messageStack->add_session("禁用成功!", 'success');
				zen_redirect(zen_href_link(FILENAME_COUPON_MANAGE, zen_get_all_get_params(array('action', 'coupon_id'))));

			} // end error check

			//echo $action;
			//	zen_redirect(zen_href_link(FILENAME_COUPON_MANAGE, (isset($_GET['page']) ? 'page=' . '&' : '') . 'coupon_id=' . $admins_id));
			break;
			case 'save' :
				$coupon_discount = trim(zen_db_prepare_input($_GET['coupon_discount']));
				$coupon_name = trim(zen_db_prepare_input($_POST['coupon_name']));
            	$coupon_code = str_replace(" ", "", zen_db_prepare_input($_POST['coupon_code']));
            	$coupon_amount = trim(zen_db_prepare_input($_POST['coupon_amount']));
            	$coupon_minimum_order = trim(zen_db_prepare_input($_POST['coupon_minimum_order']));
                $with_promotion = trim(zen_db_prepare_input($_POST['with_promotion']));
                $coupon_number_of_times = trim(zen_db_prepare_input($_POST['coupon_number_of_times']));
                $coupon_addable = trim(zen_db_prepare_input($_POST['coupon_addable']));
                $coupon_number_of_times_total = trim(zen_db_prepare_input($_POST['coupon_number_of_times_total']));
                $coupon_start_time_pickup = trim(zen_db_prepare_input($_POST['coupon_start_time_pickup']));
                $coupon_end_time_pickup = trim(zen_db_prepare_input($_POST['coupon_end_time_pickup']));
                $coupon_start_date = trim(zen_db_prepare_input($_POST['coupon_start_date']));
                $coupon_expire_date = trim(zen_db_prepare_input($_POST['coupon_expire_date']));
                $useful_life_type = trim(zen_db_prepare_input($_POST['useful_life_type']));
                $day_after_add = trim(zen_db_prepare_input($_POST['day_after_add']));
                $languages_id_str = trim(zen_db_prepare_input($_POST['languages_id_str']));
                
                $coupon_currency_code = $minimum_order_currency_code = "USD";
				$coupon_currency_value = $minimum_order_currency_value = $uses_per_user = $coupon_status = 1;
				$error = "";
				//$coupon_vip = 0;
				//$coupon_target = 3;
                if(empty($day_after_add)) {
                	$day_after_add = 0;
                }
                if(empty($coupon_code)) {
                	$error .= "请填写Coupon Code!<br/>";
                }
                if(empty($coupon_amount)) {
                	$error .= "请填写Coupon面额!<br/>";
                }
                if(!is_numeric($coupon_amount)) {
                	$error .= "Coupon面额只能是数字!<br/>";
                }
                if(empty($coupon_minimum_order)) {
                	$error .= "请填写最低消费金额!<br/>";
                }
                if(!is_numeric($coupon_minimum_order)) {
                	$error .= "最低消费金额只能是数字!<br/>";
                }
                if(empty($coupon_number_of_times)) {
                	$error .= "请选择同一客户领取次数!<br/>";
                }
                if($coupon_addable == "") {
                	$error .= "请选择是否允许外部领取!<br/>";
                }
                if($coupon_number_of_times_total == "") {
                	$error .= "请填写总的领取次数!<br/>";
                }
                if(!empty($coupon_addable) && (empty($coupon_start_time_pickup) || empty($coupon_end_time_pickup))) {
                	$error .= "选择允许外部领取后，请设置领取周期!<br/>";
                }
                if(empty($useful_life_type)) {
                	$error .= "请选择有效期!<br/>";
                }
                $coupon_type = "C";
                if($useful_life_type == "10") {
                	$coupon_type = "F";
                	
                	if(empty($coupon_start_date) || empty($coupon_expire_date)) {
                		$error .= "选择时间范围，请设置开始时间和结束时间!<br/>";
                	}
                }
                
                if($coupon_discount == "20") {
                	
                }
                
                if($useful_life_type == "20") {
                	if($day_after_add == "") {
                		$error .= "请填写领取后多少天过期!<br/>";
                	}
                	$coupon_start_date = $coupon_expire_date = "null";
                }
                
                $coupon_exist = $db->Execute('select coupon_id from '. TABLE_COUPONS .' where coupon_code="'.$coupon_code.'" limit 1');
				if($coupon_exist->RecordCount() > 0){
					$error .= "Coupon Code已存在!<br/>";
				}
                
                if(!empty($error)) {
                	$messageStack->add_session($error, 'error');
	                zen_redirect(zen_href_link(FILENAME_COUPON_MANAGE,zen_get_all_get_params(array('action', 'id')) . 'action=new'));
                } else {
                	$save_sql_array = array(
	                          'coupon_name' => $coupon_name,
	                          'coupon_code' => $coupon_code,
	                          'coupon_type' => $coupon_type,
	                          'coupon_amount' => $coupon_amount,
	                          'coupon_currency_code' => $coupon_currency_code,
	                          'coupon_currency_value' => $coupon_currency_value,
	                          'coupon_minimum_order' => $coupon_minimum_order,
	                          'minimum_order_currency_code' => $minimum_order_currency_code,
	                          'uses_per_user' => $uses_per_user,
	                          'coupon_start_date' => $coupon_start_date,
	                          'coupon_expire_date' => $coupon_expire_date,
	                          'day_after_add' => $day_after_add,
	                          //'coupon_target' => $coupon_target,
	                          'coupon_status' => $coupon_status,
	                          //'coupon_vip' => $coupon_vip,
	                          'date_created' => 'now()',
	                          'with_promotion' => $with_promotion,
	                          //'with_vip' => $with_vip,
	                          'coupon_addable' => $coupon_addable,
	                          'coupon_start_time_pickup' => $coupon_start_time_pickup,
	                          'coupon_end_time_pickup' => $coupon_end_time_pickup,
	                          'coupon_number_of_times' => $coupon_number_of_times,
	                          'coupon_number_of_times_total' => $coupon_number_of_times_total,
	                          'admin_email' => $_SESSION['admin_email']
	                          
	                );
	                //print_r($save_sql_array);exit;
	                    
	                if ($coupon_id > 0) {
	                	 $save_sql_array['admin_email_modified'] = $_SESSION['admin_email'];
	                	 $save_sql_array['date_modified'] = 'now()';
	                	zen_db_perform(TABLE_ACTIVITY_SHIPPING, $save_sql_array, "update", "coupon_id = " . $coupon_id);
	
	                }else{
	                	//$save_sql_array['coupon_discount'] = $coupon_discount;
	                	//$save_sql_array['activity_status'] =10;
	                	//$save_sql_array['admin_email'] = $_SESSION['admin_email'];
	                	//$save_sql_array['date_created'] = 'now()';
	                    zen_db_perform(TABLE_COUPONS, $save_sql_array);
	                    $coupon_id = zen_db_insert_id();
	                    $languages_id_array = explode(",", $languages_id_str);
	                    foreach($languages_id_array as $languages_value) {
	                    	$coupon_name = trim(zen_db_prepare_input($_POST['coupon_name_' . $languages_value]));
	                    	$coupon_description = trim(zen_db_prepare_input($_POST['coupon_description_' . $languages_value]));
	                    	if(!empty($coupon_name) || !empty($coupon_description)) {
	                    		$description_sql_array = array(
			                          'coupon_id' => $coupon_id,
			                          'language_id' => $languages_value,
			                          'coupon_name' => $coupon_name,
			                          'coupon_description' => $coupon_description
			                          
			                	);
			                	zen_db_perform(TABLE_COUPONS_DESCRIPTION, $description_sql_array);
	                    	}
	                    }
	                    
	                }
	                
	                $messageStack->add_session('保存成功!', 'success');
	                zen_redirect(zen_href_link(FILENAME_COUPON_MANAGE,zen_get_all_get_params(array('action', 'coupon_discount', 'id'))));   
                }         
           break;
	} // end switch
} // end zen_not_null

$languages = zen_get_languages();
$languages_plus = array(array('id' => '', 'text' => 'All'), array('id' => 999, 'text' => '全部站点'));

$array_languages = array();
$array_languages = array(array('id' => '', 'text' => 'All'), array('id' => 999, 'text' => '全部站点'));
foreach($languages as $value) {
	array_push($array_languages, array('id' => $value['code'], 'text' => $value['name']));
}

$search_query = ' where 1=1';
$search = zen_db_input(zen_db_prepare_input($_GET['search']));
$activity_status = zen_db_input(zen_db_prepare_input($_GET['activity_status']));
$coupon_discount = zen_db_input(zen_db_prepare_input($_GET['coupon_discount']));
$activity_language = zen_db_input(zen_db_prepare_input($_GET['activity_language']));
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
  if (typeof _editor_url == "string") HTMLArea.replace('message_html');
}
// -->
$(function() {
	$("#canbutton").click(function() {
		window.history.back();
	});
	
	$(".jq_activity_amount_add").click(function() {
		var row = $(".jq_activity_amount tr").eq(0).clone(true);
		$(row).find("input").val("");
		$(row).find(".jq_activity_amount_delete").show();
		$(".jq_activity_amount").append(row);
	});
	
	$(".jq_activity_amount_delete").click(function() {
		$(this).parent().parent().remove();
	});
	
	$(".jq_active_choose").click(function() {
		var coupon_discount = $("#coupon_discount  option:selected").val();
		if(coupon_discount == "0") {
			alert("请选择要创建的Coupon类型!");
		} else {
			window.location.href = "<?php echo zen_href_link(FILENAME_COUPON_MANAGE,zen_get_all_get_params(array('action', 'coupon_discount')) . 'action=new');?>&coupon_discount="+ coupon_discount;
		}
		
	});
	
	$("input[type='checkbox']").click( 
		function(){ 
			if($(this).attr("readonly") == "readonly") {
				this.checked = !this.checked;} 
		}
	);
	
	$(".language_title").click(function(){
		$(".jq_index_area").hide();
		$("#jq_textarea_" + $(this).data("id")).show();
		
		$(".language_title").removeClass("checked");
		$(this).addClass("checked");
		
	});
	
	$(".jq_coupon_addable").click(function() {
		if($("input[name='coupon_addable']:checked").val() == "0") {
			$(".jq_tr_coupon_number_of_times_total").hide();
			$(".jq_tr_pickup").hide();
		} else {
			$(".jq_tr_coupon_number_of_times_total").show();
			$(".jq_tr_pickup").show();
		}
	});
});

function submitForm(){
    if ($.trim($('#coupon_code').val()) == '') {alert('请填写Coupon Code!');return false;}
    if ($.trim($('#coupon_amount').val()) == '') {alert('请填写面额!');return false;}
    if ($.trim($('#coupon_minimum_order').val()) == '') {alert('请填写最低消费金额!');return false;}
    if ($.trim($('#coupon_minimum_order').val()) == '') {alert('请填写最低消费金额!');return false;}
    if ($("input[name='coupon_addable']:checked").val() == '1' && ($.trim($('#coupon_start_time_pickup').val()) == '' || $.trim($('#coupon_end_time_pickup').val()) == '')) {alert('选择允许外部领取后，请设置领取周期!');return false;}
    if ($("input[name='useful_life_type']:checked").val() == '') {alert('请选择有效期!');return false;}
    if ($("input[name='useful_life_type']:checked").val() == '10' && ($.trim($('#coupon_start_date').val()) == '' || $.trim($('#coupon_expire_date').val()) == '')) {alert('选择时间范围，请设置开始时间和结束时间!');return false;}
    if ($("input[name='useful_life_type']:checked").val() == '20' && $.trim($('#day_after_add').val()) == '') {alert('请填写领取后多少天过期!');return false;}
    $("#save_form").submit();

}
</script>
<style>
  td{line-height:28px;}
  .table_info{font-size:12px; font-family: Arial;width: 80%} 
  .table_info tr{text-align: left;vertical-align: top;margin-bottom: 10px;line-height: 20px;}
  .table_info tr th{width:180px;}
  .table_info tr td br{}

  .table_desc{margin-left:30px;font-size: 12px; font-size:14px; width:90%;}
  .table_desc tr{height:34px;}
  .table_desc tr th{width:150px;text-align: left;}
  .buttondiv{width: 300px;margin-left: 150px;}
  .buttondiv button{width:100px;}

  .normal_table tr td{text-align: center;}




.simple_button{background: -moz-linear-gradient(center top , #FFFFFF, #CCCCCC) repeat scroll 0 0 #F2F2F2;
    border: 1px solid #656462;
    border-radius: 3px 3px 3px 3px;
    cursor: pointer;
    padding: 3px 20px;}
 .listshow{
	margin: 0;
    padding: 5px 10px;
 }
 #showpromotion{
 	margin-top: 20px;
 }
 #showpromotion th{
 	  background: none repeat scroll 0 0 #D6D6CC;
    font-size: 13px;
    padding: 6px 10px 6px 15px;
    text-align: left;
 }
  #showpromotion th .red{
  	color: #FF0000;
    font-weight: normal;
  }
 #showpromotion td{
 	border-bottom: 1px dashed #CCCCCC;
 }
 .actionBut{
 	 display: table-cell;
    margin-bottom: 5px;
    width: 80px;
 }
 .promotionInput{
 	border: 1px solid #888888;
    height: 20px;
    line-height: 20px;
    width: 160px;
 }
 .short{
 	margin: 0 5px 0 20px;
    width: 50px;
 height: 24px;
    line-height: 24px;
 }
 .promotionName{
 	float: right;
 }
 .promotionLang{
 	float: left;
    line-height: 20px;
 }
 .promotionDiv{
 	 margin: 2px 0;
    overflow: hidden;
 }
 #fileDown{
	padding: 0 0 0 10px;
 }
 #fileDown p{
	 font-size: 13px;
    font-weight: bold;
    margin: 5px 0;
 }
 #fileDown a{
 	 text-decoration: underline;
 }
 #fileDown a:hover{
	color:#ff6600;
 }
 #fileDown input{
	font-size:12px;cursor:pointer;
 }
 #promotion_total{
	 margin-top: 15px;
    padding: 10px;
 }
 #promotion_total h2{
 	font-size: 14px;
    margin: 8px 0;
 }
 .protecting .cal-TextBox{
	background: none repeat scroll 0 0 #FFFFFF;
    color: #6D6D6D;
 }
 #updatePro{
	font-weight:bold;
 }
 
 #promotion_info tr{
 	height:40px; 
 }
 
 .info_column_title{
 	padding-right:5px; 
 	width:100px;
 }
 
 .info_column_content{
 	padding-left:5px; 
 }
 .info_red{
 	color:red;
 }
 .Wdate{
 	width:150px;
 }
 .language_title{
	display: inline-block;
    border: 1px solid #D0CCCC;
    width: 84px;
    text-align: center;
    vertical-align: middle;
    line-height: 25px;
    cursor: pointer;
    position: relative;
    background: white;
    top: 1px;
 }
 .checked{
 	border-bottom:0px;
 	font-weight:bold;
 }
</style>
</head>
<body onLoad="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<?php 
        
        if($_GET['action']=='new'){
        	$languages = zen_get_languages();
            if (isset($_GET['coupon_id']) && $_GET['coupon_id'] != '') {
                $coupon_id = trim(zen_db_prepare_input($_GET['coupon_id']));
                $ann_query_sql = "select * from ".TABLE_ACTIVITY_SHIPPING." where coupon_id = ".$coupon_id;
                $ann_sql_result = $db->Execute($ann_query_sql);
                if (!$ann_sql_result->EOF) {
					$ann_sql_result->fields['activity_amount_section'] = json_decode($ann_sql_result->fields['activity_amount_section'], true);
                    $ann_result = $ann_sql_result->fields;
                }
                $coupon_discount = $ann_result['coupon_discount'];
                if($ann_result['activity_end_time'] <= $date_now || $ann_result['activity_status'] == "20") {
	            	$messageStack->add_session('活动已禁用!', 'error');
	            	zen_redirect(zen_href_link(FILENAME_COUPON_MANAGE,zen_get_all_get_params(array('action', 'id'))));
	            }
            }
            
            
            $readonly = "";
            if($coupon_id > 0 && $ann_result['activity_start_time'] <= $date_now) {
            	$readonly = " readonly='readonly'";
            }
            $shipping_sql = "select code, name from " . TABLE_SHIPPING . " where status=1";
            $shipping_result = $db->Execute($shipping_sql);
            $shipping_info_array = array();
            while (!$shipping_result->EOF) {
                array_push($shipping_info_array, $shipping_result->fields);
                $shipping_result->MoveNext();
            }
            ?>

            <?php if (trim($coupon_id) != '') { ?>
                <h1 style="margin-left:20px;height:50px;">Promotion > Coupon管理 > 编辑Coupon</h1>
                <form  action="<?php echo zen_href_link(FILENAME_COUPON_MANAGE,zen_get_all_get_params(array('action')) . 'action=save');?>" method="post" id="save_form">
                <input type="hidden" name="coupon_id" value="<?php echo $coupon_id ?>" />
            <?php }else{ ?>
                <h1 style="margin-left:20px;height:50px;">Promotion > Coupon管理 > 新建Coupon</h1>
                <?php if(empty($coupon_discount)) {?>
                <div class="buttondiv">请选择:
                		<select id="coupon_discount" name="coupon_discount">
							<option value="10">定额Coupon</option>
						</select>
						<button class="jq_active_choose" style="width:60px; height:22px; font-size:12px;">确定</button>
						<br/>
						
                </div>
                <div style="border:1px dashed #000; width:96%; float:auto; text-align:center; margin: 10 auto;"></div>
                <?php }?>
                <form  action="<?php echo zen_href_link(FILENAME_COUPON_MANAGE,'action=save&coupon_discount=' . $coupon_discount)?>" method="post" id="save_form">
                <input type="hidden" name="coupon_discount" value="<?php echo $coupon_discount;?>" />
            <?php } ?>
            
            <?php if($coupon_discount > 0 || $coupon_id > 0) {?>
            <table border="0" cellspacing="0" cellpadding="0" class="table_desc">                
                <?php if(!empty($readonly)) {?>
                <tr>
                    <th>提示：</th>
                    <td style="color:red;">活动已经开始，只有活动结束时间可修改，其它不能修改!</td>
                </tr>
                <?php }?>
                 <tr>
                    <th>Coupon中文名称：</th>
                    <td>
                    	<input id="coupon_name" name="coupon_name" type="text" /> (不展示在前台，只显示在后台列表中)
                    </td>
                </tr>
                <tr>
                    <th>Coupon名称(选填)：</th>
                    <td>
                    	<table>
                    		<?php 
	                    		$languages_id_array = array();
								foreach($languages as $value){
									$checked = "";
									if(strstr($ann_result['activity_languages_code'], "," . $value['code'] . ",") != "") {
										$checked = " checked='checked'";
									}
									array_push($languages_id_array, $value['id']);
                    		?>
                    		<tr style="height:28px;">
                    			<td><?php echo $value['name'];?>:</td>
                    			<td><?php echo '<input name="coupon_name_' . $value['id'] . '"  type="text"' . $checked . $readonly . '>';?></td>
                    		</tr>
                    		<?php }?>
                    	</table>
                    </td>
                </tr>
                <tr>
                    <th><font color="red">*</font>Coupon Code：</th>
                    <td>
                    	<input id="coupon_code" name="coupon_code" type="text" /> (Coupon Code的命名规则建议为：字母+日期+数字/金额，例如CP<?php echo date("Ymd");?>05)
                    </td>
                </tr>
                <tr>
                    <th><font color="red">*</font>面额：</th>
                    <td>
                    	<input id="coupon_amount" name="coupon_amount" type="text" /> <?php if($coupon_discount == "20") {echo "% off";} else {echo "USD";}?>
                    </td>
                </tr>
                <tr>
                    <th><font color="red">*</font>最低消费金额：</th>
                    <td>
                    	<input id="coupon_minimum_order" name="coupon_minimum_order" type="text" /> USD
                    </td>
                </tr>
                <tr>
                    <th><font color="red">*</font>金额对象：</th>
                    <td>
                    	<select id="with_promotion" name="with_promotion">
                    		<option value="1">商品总金额</option>
                    		<option value="0">正价商品总金额</option>
                    	</select>
                    </td>
                </tr>
                <tr>
                    <th><font color="red">*</font>同一客户领取次数：</th>
                    <td>
                    	<label><input type="radio" name="coupon_number_of_times" type="text" value="10" checked="checked" />1次 &nbsp;&nbsp;</label><label>&nbsp;<input type="radio" name="coupon_number_of_times" type="text" value="20" />不限次数</label>
                    </td>
                </tr>
                <tr>
                    <th><font color="red">*</font>允许外部领取：</th>
                    <td>
                    	<label><input class="jq_coupon_addable" name="coupon_addable" type="radio" value="1" checked="checked" />是&nbsp;&nbsp;&nbsp;</label>&nbsp;&nbsp;&nbsp;<label><input class="jq_coupon_addable" name="coupon_addable" type="radio" value="0" />否</label> (选择“<font color="red">是</font>”表示客户可以在前台自行领取该Coupon)
                    </td>
                </tr>
                <tr class="jq_tr_coupon_number_of_times_total">
                    <th><font color="red">*</font>总领取次数：</th>
                    <td>
                    	<input id="coupon_number_of_times_total" name="coupon_number_of_times_total" type="text" value="0" style="width:40px;" maxlength="3" /> (0代表不限制次数)
                    </td>
                </tr>
                <tr class="jq_tr_pickup">
                    <th><font color="red">*</font>领取周期：</th>
                    <td>
	                    	开始时间：<input class="Wdate" <?php echo $promotion_active_state == '活动'?'':''?> type="text" id="coupon_start_time_pickup" name="coupon_start_time_pickup" min-date ="%y-%M-%d" dateFmt="yyyy-MM-dd HH:mm:ss" value="<?php echo $ann_result['coupon_start_time_pickup'];?>" <?php if(empty($readonly)) {?> onClick="WdatePicker({startDate:'<?php if(!empty($ann_result['coupon_start_time_pickup'])) {echo $ann_result['coupon_start_time_pickup'];} else {echo "%y-%M-%d 00:00:00";}?>',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true});"<?php }?><?php echo $readonly;?> />
	                    	结束时间：<input class="Wdate" <?php echo $promotion_active_state == '活动'?'':''?> type="text" id="coupon_end_time_pickup" name="coupon_end_time_pickup" min-date ="%y-%M-%d" dateFmt="yyyy-MM-dd HH:mm:ss" value="<?php echo $ann_result['coupon_end_time_pickup'];?>" <?php if(empty($readonly)) {?> onClick="WdatePicker({startDate:'<?php if(!empty($ann_result['coupon_end_time_pickup'])) {echo $ann_result['coupon_end_time_pickup'];} else {echo "%y-%M-%d 00:00:00";}?>',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true});"<?php }?><?php echo $readonly;?> /> (时间为北京时间)
                    </td>
                </tr>
                <tr>
                    <th><font color="red">*</font>有效期：</th>
                    <td>
	                    	<label><input type="radio" name="useful_life_type" value="10" checked="checked" />时间范围</label>
	                    	开始时间：<input class="Wdate" <?php echo $promotion_active_state == '活动'?'':''?> type="text" id="coupon_start_date" name="coupon_start_date" min-date ="%y-%M-%d" dateFmt="yyyy-MM-dd HH:mm:ss" value="<?php echo $ann_result['coupon_start_date'];?>" <?php if(empty($readonly)) {?> onClick="WdatePicker({startDate:'<?php if(!empty($ann_result['coupon_start_date'])) {echo $ann_result['coupon_start_date'];} else {echo "%y-%M-%d 00:00:00";}?>',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true});"<?php }?><?php echo $readonly;?> />
	                    	结束时间：<input class="Wdate" <?php echo $promotion_active_state == '活动'?'':''?> type="text" id="coupon_expire_date" name="coupon_expire_date" min-date ="%y-%M-%d" dateFmt="yyyy-MM-dd HH:mm:ss" value="<?php echo $ann_result['coupon_expire_date'];?>" <?php if(empty($readonly)) {?> onClick="WdatePicker({startDate:'<?php if(!empty($ann_result['coupon_expire_date'])) {echo $ann_result['coupon_expire_date'];} else {echo "%y-%M-%d 00:00:00";}?>',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true});"<?php }?><?php echo $readonly;?> /> (时间为北京时间)
                    		<br/>
                    		<label><input type="radio" name="useful_life_type" value="20" />领取后</label>  <input type="text" id="day_after_add" name="day_after_add" style="width:40px;" maxlength="3" /> 天过期(0代表不限制)
                    </td>
                </tr>
                <tr>
                    <th>备注：</th>
                    <td>
                    	<div class="index_language" style="width:100%;"> 
							<?php foreach($languages as $key => $value){
								$checked = "";
								if($key == "0") {
									$checked = " checked";
								}	
							?>
								<div class="language_title<?php echo $checked;?>" data-id="<?php echo $value['id'];?>" ><?php echo $value['name'];?></div>
							<?php }?>
							<?php 
							foreach($languages as $key => $value){
							
								if($key == 0){
									echo '<div style="display: block;" id="jq_textarea_' . $value['id'] . '" class="jq_index_area">' ;
								}else{
									echo '<div style="display: none;" id="jq_textarea_' . $value['id'] . '" class="jq_index_area">';
								}
							?>
								<textarea rows="9" style="width:70%;" data-lang-name="<?php echo $value['name']?>"  class="pDesc" id = "coupon_description_<?php echo $value['id']?>" name="coupon_description_<?php echo $value['id']?>" data-id="<?php echo $value['id'];?>"></textarea></div> 
							
							<?php }?> 
						</div>
                    </td>
                </tr>

                
            </table>
            <input type="hidden" name="languages_id_str" value="<?php echo implode(",", $languages_id_array);?>" />
            </form>
            <br/><br/>
            <div class="buttondiv">
                <button id="submitbtn" onclick="submitForm();return false;">提交</button>&nbsp;&nbsp;&nbsp;&nbsp;
                <button id="canbutton">取消</button>
            </div>
         <?php }?>
 <?php }?>
 
 
 <?php 
        
        if($_GET['action']=='detail'){
        	$coupon_id = trim(zen_db_prepare_input($_GET['coupon_id']));
            $coupon_sql = "select * from " . TABLE_COUPONS . " where coupon_id=" . $coupon_id;
            $coupon_result = $db->Execute($coupon_sql);
            
            $coupon_description_sql = "select cd.id, cd.coupon_name, cd.coupon_description, l.name from " . TABLE_COUPONS_DESCRIPTION . " cd inner join " . TABLE_LANGUAGES  . " l on cd.language_id=l.languages_id where cd.coupon_id=" . $coupon_id . " order by cd.language_id asc";
            $coupon_description_result = $db->Execute($coupon_description_sql);
            
            $coupon_description_array = array();
            while(!$coupon_description_result->EOF) {
            	array_push($coupon_description_array, $coupon_description_result->fields);
            	$coupon_description_result->MoveNext();
            }
            ?>

            <?php if (trim($coupon_id) != '') { ?>
                <h1 style="margin-left:20px;height:50px;">Promotion > Coupon管理 > 查看Coupon</h1>
                <form  action="<?php echo zen_href_link(FILENAME_COUPON_MANAGE,zen_get_all_get_params(array('action')) . 'action=save');?>" method="post" id="save_form">
                <input type="hidden" name="coupon_id" value="<?php echo $coupon_id ?>" />
            <?php }else{ ?>
                <h1 style="margin-left:20px;height:50px;">Promotion > Coupon管理 > Coupon详情</h1>
                <form  action="<?php echo zen_href_link(FILENAME_COUPON_MANAGE,'action=save&coupon_discount=' . $coupon_discount)?>" method="post" id="save_form">
                <input type="hidden" name="coupon_discount" value="<?php echo $coupon_discount;?>" />
            <?php } ?>
            
            <table border="0" cellspacing="0" cellpadding="0" class="table_desc">                
                 <tr>
                    <th>Coupon中文名称：</th>
                    <td>
                    	<?php echo $coupon_result->fields['coupon_name'];?>
                    </td>
                </tr>
                <tr>
                    <th>Coupon名称(选填)：</th>
                    <td>
                    	<table>
                    		<?php 
	                    		$languages_id_array = array();
								foreach($coupon_description_array as $value){
                    		?>
                    		<tr style="height:28px;">
                    			<td><?php echo $value['name'];?>:</td>
                    			<td><?php echo $value['coupon_name'];?></td>
                    		</tr>
                    		<?php }?>
                    	</table>
                    </td>
                </tr>
                <tr>
                    <th>Coupon Code：</th>
                    <td>
                    	<?php echo $coupon_result->fields['coupon_code'];?>
                    </td>
                </tr>
                <tr>
                    <th>Coupon类型：</th>
                    <td>
                    	<?php echo $coupon_result->fields['coupon_type'] == "P" ? "折扣型Coupon" : "定额Coupon";?>
                    </td>
                </tr>
                <tr>
                    <th>面额：</th>
                    <td>
                    	USD <?php echo number_format($coupon_result->fields['coupon_amount'], 2, ".", "");?>
                    </td>
                </tr>
                <tr>
                    <th>最低消费金额：</th>
                    <td>
                    	USD <?php echo number_format($coupon_result->fields['coupon_minimum_order'], 2, ".", "");?>
                    </td>
                </tr>
                <tr>
                    <th>金额对象：</th>
                    <td>
                    	<?php echo !empty($coupon_result->fields['with_promotion']) ? "商品总金额" : "正价商品总金额";?>
                    </td>
                </tr>
                <tr>
                    <th>同一客户领取次数：</th>
                    <td>
                   		<?php echo $coupon_result->fields['coupon_number_of_times'] == "10" ? "1次 " : "不限次数";?>
                    </td>
                </tr>
                <tr>
                    <th>允许外部领取：</th>
                    <td>
                    	<?php echo !empty($coupon_result->fields['coupon_addable']) ? "是" : "否";?>
                    </td>
                </tr>
                <tr class="jq_tr_coupon_number_of_times_total">
                    <th>总领取次数：</th>
                    <td>
                    	<?php echo empty($coupon_result->fields['coupon_number_of_times_total']) ? "不限次数" : $coupon_result->fields['coupon_number_of_times_total'] . "次";?>
                    </td>
                </tr>
                <?php if(!empty($coupon_result->fields['coupon_addable'])) {?>
                <tr class="jq_tr_pickup">
                    <th>领取周期：</th>
                    <td>
                    	<?php 
                    		echo $coupon_result->fields['coupon_start_time_pickup'] . "到" . $coupon_result->fields['coupon_end_time_pickup'];
                    	?>
                    </td>
                </tr>
                <?php }?>
                <tr>
                    <th>有效期：</th>
                    <td>                    	
                    	<?php if($coupon_result->fields['coupon_type'] == "C") {
                    		echo !empty($coupon_result->fields['day_after_add']) ? "领取<font color='red'>" . $coupon_result->fields['day_after_add'] . "天后</font>过期" : "无过期";
                    		
                    	} else {
                    		echo $coupon_result->fields['coupon_start_date'] . "到" . $coupon_result->fields['coupon_expire_date'];
                    	}?>
                    </td>
                </tr>
                <tr>
                    <th>备注：</th>
                    <td>
                    	<div class="index_language" style="width:100%;"> 
							<?php foreach($coupon_description_array as $key => $value){
								$checked = "";
								if($key == "0") {
									$checked = " checked";
								}	
							?>
								<div class="language_title<?php echo $checked;?>" data-id="<?php echo $value['id'];?>" ><?php echo $value['name'];?></div>
							<?php }?>
							<?php 
							foreach($coupon_description_array as $key => $value){
							
								if($key == 0){
									echo '<div style="display: block;" id="jq_textarea_' . $value['id'] . '" class="jq_index_area">' ;
								}else{
									echo '<div style="display: none;" id="jq_textarea_' . $value['id'] . '" class="jq_index_area">';
								}
							?>
								<textarea rows="9" style="width:70%;" data-lang-name="<?php echo $value['name']?>"  class="pDesc" id = "coupon_description_<?php echo $value['id']?>" name="coupon_description_<?php echo $value['id']?>" data-id="<?php echo $value['id'];?>"><?php echo $value['coupon_description'];?></textarea></div> 
							
							<?php }?> 
						</div>
                    </td>
                </tr>
                
                <?php if(!empty($coupon_result->fields['admin_email'])) {?>
                <tr>
                    <th>创建人：</th>
                    <td>
                    	<?php echo $coupon_result->fields['admin_email'];?>
                    </td>
                </tr>
                <tr>
                    <th>创建时间：</th>
                    <td>
                    	<?php echo $coupon_result->fields['date_created'];?>
                    </td>
                </tr>
                <?php }?>
                <?php if(!empty($coupon_result->fields['admin_email_modified'])) {?>
                <tr>
                    <th>修改人：</th>
                    <td>
                    	<?php echo $coupon_result->fields['admin_email_modified'];?>
                    </td>
                </tr>
                <tr>
                    <th>修改时间：</th>
                    <td>
                    	<?php echo $coupon_result->fields['date_modified'];?>
                    </td>
                </tr>
				<?php }?>
                
            </table>
            <input type="hidden" name="languages_id_str" value="<?php echo implode(",", $languages_id_array);?>" />
            </form>
            <br/><br/>
            <div class="buttondiv">
                <button onclick="javascript:window.location.href='<?php echo zen_href_link(FILENAME_COUPON_MANAGE,zen_get_all_get_params(array('action')));?>';">返回</button>&nbsp;&nbsp;&nbsp;&nbsp;
                
                <?php if(!empty($coupon_result->fields['coupon_status'])) {?>
                <button onClick="javascript:if(confirm('是否禁用此条Coupon？此Coupon将无法被客户领取。')) {window.location.href='<?php echo zen_href_link(FILENAME_COUPON_MANAGE,zen_get_all_get_params(array('action')) . '&action=forbidden');?>';};" href=''>禁用</button>
            	<?php }?>
            </div>
 <?php }?>

<?php if(empty($action) || $action == "delete") {?>
<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
	<tr>
<!-- body_text //-->
		<td width="100%">


<?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td class="pageHeading">Promotion > Coupon管理</td>
		<td align="right">
		<table border="0" width="40%" cellspacing="0" cellpadding="0">
			<tr>
				<td style="text-align:right; line-height:28px;">
					<?php
	
	echo zen_draw_form('search', FILENAME_COUPON_MANAGE, '', 'get', 'id="search_form"', true);
	echo '按Coupon领取状态筛选： ' . zen_draw_pull_down_menu('coupon_status_pickup', array(array('id' => '', 'text' => 'All'), array('id' => '100', 'text' => '不可领取'), array('id' => '200', 'text' => '未开始'), array('id' => '300', 'text' => '活动'), array('id' => '400', 'text' => '关闭')), $coupon_status_pickup) . '<br/>';
	echo '按创建时间筛选： <input class="Wdate" style="width:120px;" id="date_created_start" name="date_created_start" min-date="%y-%M-%d" datefmt="yyyy-MM-dd HH:mm:ss" value="' . $date_created_start . '" onclick="WdatePicker({startDate:\'%y-%M-%d 00:00:00\',dateFmt:\'yyyy-MM-dd HH:mm:ss\',alwaysUseStartDate:true});" type="text"> <input class="Wdate" style="width:120px;" id="date_created_end" name="date_created_end" min-date="%y-%M-%d" datefmt="yyyy-MM-dd HH:mm:ss" value="' . $date_created_end . '" onclick="WdatePicker({startDate:\'%y-%M-%d 00:00:00\',dateFmt:\'yyyy-MM-dd HH:mm:ss\',alwaysUseStartDate:true});" type="text"><br/>';
	echo '<input type="submit" value="筛选"><br/>';
	echo '</form>';
	echo zen_draw_form('search', FILENAME_COUPON_MANAGE, '', 'get', 'id="search_form"', true);
	echo zen_draw_input_field('coupon_name', $coupon_name, 'id="coupon_name" placeholder="Coupon名称"') . '&nbsp;<input type="submit" value="搜索"><br/>';
	echo '</form>';
	echo zen_draw_form('search', FILENAME_COUPON_MANAGE, '', 'get', 'id="search_form"', true);
	echo zen_draw_input_field('coupon_code', $coupon_code, 'id="coupon_code" placeholder="Coupon Code"') . '&nbsp;<input type="submit" value="搜索"><br/>';
	echo '</form>';
	
	?>
				</td>
			</tr>
		</table>
		</td>
	</tr>

</table>

<?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td>

<table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr class="dataTableHeadingRow">
		<td width="5%" class="dataTableHeadingContent">ID</td>
		<td width="15%" class="dataTableHeadingContent">中文名称</td>
		<td width="15%" class="dataTableHeadingContent">Coupon Code</td>
		<td width="5%" class="dataTableHeadingContent">面值</td>
		<td width="10%" class="dataTableHeadingContent">最低消费金额</td>
		<td width="7%" class="dataTableHeadingContent">允许外部领取</td>
		<td width="6%" class="dataTableHeadingContent">领取状态</td>
		<td width="10%" class="dataTableHeadingContent">创建人</td>
		<td width="11%" class="dataTableHeadingContent">创建时间</td>
		<td width="4%" class="dataTableHeadingContent">状态</td>
		<td width="5%" class="dataTableHeadingContent" align="right">操作</td>
</tr>

<?php

if(zen_not_null($coupon_status_pickup)) {
	if($coupon_status_pickup == "100") {
		$search_query .= ' and c.coupon_addable=0';
	} else if($coupon_status_pickup == "200") {
		$search_query .= ' and c.coupon_addable=1 and c.coupon_start_time_pickup>"' . $date_now . '"';
	} else if($coupon_status_pickup == "300") {
		$search_query .= ' and c.coupon_addable=1 and c.coupon_start_time_pickup<"' . $date_now . '" and c.coupon_end_time_pickup>"' . $date_now . '"';
	} else if($coupon_status_pickup == "400") {
		$search_query .= ' and c.coupon_status=0';
	}
}

if(zen_not_null($date_created_start) && zen_not_null($date_created_end) && $date_created_end <= $date_created_start) {

} else {
	if(zen_not_null($date_created_start)) {
		$search_query .= ' and c.date_created>="' . $date_created_start . '"';
	}
	
	if(zen_not_null($date_created_end)) {
		$search_query .= ' and c.date_created<="' . $date_created_end . '"';
	}
}



if(zen_not_null($coupon_name)) {
	$search_query .= ' and c.coupon_name like "%' . $coupon_name . '%"';
}

if(zen_not_null($coupon_code)) {
	$search_query .= ' and c.coupon_code="' . $coupon_code . '"';
}


if (zen_not_null($activity_status) && is_numeric($activity_status)) {
	$activity_status = zen_db_input(zen_db_prepare_input($activity_status));
	if($activity_status == "100") {
		$search_query .= ' and activity_start_time>"' . $date_now . '"';
	}
	if($activity_status == "200") {
		$search_query .= ' and activity_start_time<="' . $date_now . '" and activity_end_time>"' . $date_now . '"';
	}
	if($activity_status == "300") {
		$search_query .= ' and (activity_end_time<"' . $date_now . '" or activity_status=20)';
	}
}

if (zen_not_null($coupon_discount) && is_numeric($coupon_discount)) {
	$search_query .= ' and coupon_discount=' . $coupon_discount;
}

if (zen_not_null($activity_language)) {
	if($activity_language == "999") {
		$search_query .= ' and activity_languages_code_all=20';
	} else {
		$search_query .= ' and activity_languages_code like "%,' . $activity_language .',%"';
	}
}

$para_sort = ' order by coupon_id DESC';


$admins_query_raw = "select c.* from " . TABLE_COUPONS . " c" . $search_query . " order by c.coupon_id desc";
$admins_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $admins_query_raw, $admins_query_numrows);
$admins = $db->Execute($admins_query_raw);

$date_now = date("Y-m-d H:i:s");

while (!$admins->EOF) {
	if ((!isset ($_GET['coupon_id']) || (isset ($_GET['coupon_id']) && ($_GET['coupon_id'] == $admins->fields['coupon_id']))) && !isset ($adminInfo) && (substr($action, 0, 3) != 'new')) {
		$adminInfo = new objectInfo($admins->fields);
	}
	
	$likn_defail = zen_href_link(FILENAME_COUPON_MANAGE,zen_get_all_get_params(array('action', 'coupon_id')) . 'action=detail&coupon_id=' . $admins->fields['coupon_id']);

	if (isset ($adminInfo) && is_object($adminInfo) && ($admins->fields['coupon_id'] == $adminInfo->coupon_id)) {
		//echo '<tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_COUPON_MANAGE,zen_get_all_get_params(array('action', 'coupon_id')) . 'coupon_id=' . $admins->fields['coupon_id'] . '&action=new') . '\'">' . "\n";
		echo '<tr id="defaultSelected" class="dataTableRowSelected" onmouseout="rowOutEffect(this)">' . "\n";
	} else {
		echo '<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . "\n";
	}
	
    $fetch_status = "/";
    if(!empty($admins->fields['coupon_addable'])) {
        if($admins->fields['coupon_start_time_pickup'] > $date_now) {
        	$fetch_status = "未开始";
        }

        if($date_now > $admins->fields['coupon_end_time_pickup']) {
			$fetch_status = "已结束";
        }

        if($admins->fields['coupon_start_time_pickup'] <= $date_now && $date_now <= $admins->fields['coupon_end_time_pickup']) {
			$fetch_status = "活动";
        }
    }
?>

		<td class="dataTableContent"><?php echo $admins->fields['coupon_id']; ?></td>
		<td class="dataTableContent"><?php echo $admins->fields['coupon_name']; ?></td>
		<td class="dataTableContent"><?php echo $admins->fields['coupon_code']; ?></td>
		<td class="dataTableContent"><?php echo (!empty($admins->fields['coupon_currency_code'])? "USD" : $admins->fields['coupon_currency_code']) . " " . number_format($admins->fields['coupon_amount'], 2, ".", ""); ?></td>
		<td class="dataTableContent"><?php echo (!empty($admins->fields['minimum_order_currency_code'])? "USD" : $admins->fields['minimum_order_currency_code']) . " " . number_format($admins->fields['coupon_minimum_order'], 2, ".", ""); ?></td>
		<td class="dataTableContent"><?php echo !empty($admins->fields['coupon_addable'])? "是" : "否"; ?></td>
		<td class="dataTableContent"><?php echo $fetch_status; ?></td>
		<td class="dataTableContent"><?php echo !empty($admins->fields['admin_email'])? $admins->fields['admin_email'] : "/"; ?></td>
		<td class="dataTableContent"><?php echo $admins->fields['date_created']; ?></td>
		<td class="dataTableContent"><?php echo $admins->fields['coupon_status']==1?zen_image(DIR_WS_IMAGES . 'icon_green_on.gif', IMAGE_ICON_STATUS_ON):zen_image(DIR_WS_IMAGES . 'icon_red_on.gif', IMAGE_ICON_STATUS_OFF);?></td>
		<td class="dataTableContent" align="right">
<?php echo $button_row_edit; ?>&nbsp;
<?php
 /* echo '<a href="' . zen_href_link(FILENAME_COUPON_MANAGE, 'page=' . $_GET['page'] . 'coupon_id=' . $admins->fields['coupon_id'] . '&action=delete') . '">' . zen_image(DIR_WS_IMAGES . 'icon_delete.gif', ICON_DELETE) . '</a>';*/
?>
<?php echo '<a href="' . $likn_defail . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; ?></td>
</tr>

<?php

	$admins->MoveNext();
}
?>

	<tr>
		<td colspan="11">

<table border="0" width="100%" cellspacing="0" cellpadding="4">
	<tr>
		<td class="smallText"><?php echo $admins_split->display_count($admins_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_RESULTS); ?></td>
		<td class="smallText" align="right"><?php echo $admins_split->display_links($admins_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'],zen_get_all_get_params(array('page'))); ?></td>
	</tr>
	<tr>
		<td class="smallText"></td>
		<td class="smallText" align="right"><a href="<?php echo zen_href_link(FILENAME_COUPON_MANAGE,zen_get_all_get_params(array('action', 'coupon_discount', 'coupon_id')) . '&action=new' );?>"><button style="width:96px;">新建</button></a></td>
	</tr>
</table>

		</td>
	</tr>
</table>
		</td>

<?php

$heading = array ();
$contents = array ();

switch ($action) {

} // end switch action

if ((zen_not_null($heading)) && (zen_not_null($contents)) && 1 == 2) {
	echo '<td width="25%">' . "\n";
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

<?php }?>

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>