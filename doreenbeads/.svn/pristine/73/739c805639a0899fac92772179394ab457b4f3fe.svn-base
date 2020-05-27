<?php
require ('includes/application_top.php');
require (DIR_WS_CLASSES . 'customers_group.php');

if(isset($_POST['action']) && $_POST['action'] == 'merge'){
	$customers_id_1 = intval($_POST['customers_id_1']);
	$customers_id_2 = intval($_POST['customers_id_2']);
	$error = "";
	if(empty($customers_id_1)) {
		$error .= "客户ID1不合法!<br/>";
	}
	if(empty($customers_id_2)) {
		$error .= "客户ID2不合法!<br/>";
	}
	if($customers_id_1 == $customers_id_2) {
		$error .= "客户ID1与客户ID2相同，请重新核对!<br/>";
	}
	
	if (!empty ($error)) {
		$messageStack->add_session($error, 'error');
		zen_redirect(zen_href_link(FILENAME_CUSTOMERS_EMAIL_MERGE, zen_get_all_get_params(array ('action')) . 'customers_id_1=' . $customers_id_1 . '&customers_id_2=' . $customers_id_2, 'NONSSL'));
	} else {
		$customers_sql_1 = "select customers_id from " . TABLE_CUSTOMERS . " where customers_id=:customers_id_1";
		$customers_sql_1 = $db->bindVars($customers_sql_1,':customers_id_1',$customers_id_1,'integer');
		$customers_result_1 = $db->Execute($customers_sql_1);
		if($customers_result_1->RecordCount() <= 0) {
			$error .= "客户ID1：" . $customers_id_1 . "不存在!";
			$messageStack->add_session($error, 'error');
			zen_redirect(zen_href_link(FILENAME_CUSTOMERS_EMAIL_MERGE, zen_get_all_get_params(array ('action')) . 'customers_id_1=' . $customers_id_1 . '&customers_id_2=' . $customers_id_2, 'NONSSL'));
		}
		
		$customers_sql_2 = "select customers_id from " . TABLE_CUSTOMERS . " where customers_id=:customers_id_2";
		$customers_sql_2 = $db->bindVars($customers_sql_2,':customers_id_2',$customers_id_2,'integer');
		$customers_result_2 = $db->Execute($customers_sql_2);
		if($customers_result_2->RecordCount() <= 0) {
			$error .= "客户ID2：" . $customers_id_2 . "不存在!";
			$messageStack->add_session($error, 'error');
			zen_redirect(zen_href_link(FILENAME_CUSTOMERS_EMAIL_MERGE, zen_get_all_get_params(array ('action')) . 'customers_id_1=' . $customers_id_1 . '&customers_id_2=' . $customers_id_2, 'NONSSL'));
		}
		
		$orders_sql = "select orders_id, order_total from " . TABLE_ORDERS . " where customers_id=:customers_id_2";
		$orders_sql = $db->bindVars($orders_sql,':customers_id_2',$customers_id_2,'integer');
		$orders_result = $db->Execute($orders_sql);
		$array_orders_id = array();
		$orders_total = 0;
		while(!$orders_result->EOF) {
			array_push($array_orders_id, $orders_result->fields['orders_id']);
			$orders_total += $orders_result->fields['order_total'];
			$orders_result->MoveNext();
		}
		if(empty($array_orders_id)) {
			$error .= "客户ID：" . $customers_id_2 . "账号中无订单，不需要合并!";
			$messageStack->add_session($error, 'error');
			zen_redirect(zen_href_link(FILENAME_CUSTOMERS_EMAIL_MERGE, zen_get_all_get_params(array ('action')) . 'customers_id_1=' . $customers_id_1 . '&customers_id_2=' . $customers_id_2, 'NONSSL'));
		}
		$operate_content = "客户ID：" . $customers_id_2 . "的订单(" . implode(",", $array_orders_id) . ")合并到客户ID：" . $customers_id_1 . "中，总计订单金额为：USD $" . $orders_total;
		zen_insert_operate_logs($_SESSION['admin_id'], $customers_id_2, $operate_content, 1);
		$update_sql = "update " . TABLE_ORDERS . " set customers_id=:customers_id_1 where customers_id=:customers_id_2";
		$update_sql = $db->bindVars($update_sql,':customers_id_1',$customers_id_1,'integer');
      	$update_sql = $db->bindVars($update_sql,':customers_id_2',$customers_id_2,'integer');
		$update_result = $db->Execute($update_sql);
		
		$customers_group = new customers_group();
		$customers_group->correct_group($customers_id_1);
		$customers_group->correct_group($customers_id_2);
		$messageStack->add_session("合并成功!", 'success');
		zen_redirect(zen_href_link(FILENAME_CUSTOMERS_EMAIL_MERGE, zen_get_all_get_params(array ('action', 'customers_id_1', 'customers_id_2')), 'NONSSL'));
	}
	
	exit;
}else{
	$customers_id_1 = intval($_GET['customers_id_1']);
	$customers_id_2 = intval($_GET['customers_id_2']);
	
	$sql = "select date_period from " . TABLE_CUSTOMERS_LOSS . " group by date_period order by auto_id desc limit 5";
	$result = $db_export->Execute($sql);
	$customers_loss_array = array();
	while (!$result->EOF) {
		$customers_loss_array[] = $result->fields;
		$result->MoveNext();
	}
}

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
<?php echo "<script> window.lang_wdate='".$_SESSION['languages_code']."'; </script>";?>
<script type="text/javascript">
	function merge(){
		var customers_id_1 = $.trim($("#customers_id_1").val());
		var customers_id_2 = $.trim($("#customers_id_2").val());
		if(customers_id_1 == "") {
			alert("客户ID1不能为空!");
			return false;
		}
		if(customers_id_2 == "") {
			alert("客户ID2不能为空!");
			return false;
		}
		if(customers_id_1 == customers_id_2) {
			alert("客户ID1与客户ID2相同，请重新核对!");
			return false;
		}
		if(confirm("是否将客户ID：" + customers_id_1 + "与客户ID：" + customers_id_2 + "进行合并？") == true) {
			return true;
		}
		return false;
	}
</script>
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
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<div style="padding: 10px;">
		<p class="pageHeading">客户邮箱合并</p>
		<div style="padding-left: 50px; font-size:14px;">
			<form  name="customers_form" id="customers_form" action="<?php echo zen_href_link(FILENAME_CUSTOMERS_EMAIL_MERGE,zen_get_all_get_params(array('action')) . 'action=merge');?>" method="post" onsubmit="return merge();">
			<input type="hidden" name="action" value="merge" />
			
			 客户ID1:&nbsp;<input type="text" id="customers_id_1" name="customers_id_1" maxlength=8 value="<?php if(!empty($customers_id_1)) {echo $customers_id_1;}?>" /> (客户两个账号中所有的订单都会合并到此账号中)<br/><br/>
			 客户ID2:&nbsp;<input type="text" id="customers_id_2" name="customers_id_2" maxlength=8 value="<?php if(!empty($customers_id_2)) {echo $customers_id_2;}?>" /> (客户该账号中的订单会合并到<span style="font-size:20px; color:red;">客户ID1</span>账号中)
			 </select>
			 <br/><br/>
			<input type="submit" value="合并账号" />
			</form>
			
			<br/><br/>备注：合并完成后请到订单列表页通过客户ID1去搜索订单是否已合并成功

		</div>
		
</div>
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</body>
</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>