<?php
require('includes/application_top.php');
require_once(DIR_FS_CATALOG . DIR_WS_CLASSES . 'excel/PHPExcel.php');
global $db;
$action = (isset($_GET['action']) ? $_GET['action'] : '');

 $commission_sql = 'SELECT a.prometers_commission_info_id, a.customers_dropper_id, a.orders_id,a.in_orders_total,a.orders_pay_time,a.return_commission_total,a.commission_status,a.auditor,a.return_commission_time,a.commission_audit_time FROM ' . TABLE_PROMETERS_COMMISSION_INFO . ' a,'. TABLE_ORDERS .' o WHERE customers_dropper_id = ' . $_GET['cid'] . ' AND a.orders_id = o.orders_id AND date_sub(now(), INTERVAL 30 DAY) >= orders_pay_time AND orders_status IN (2, 3, 4, 10, 42) and CONCAT_WS("/",YEAR(pay_time),MONTH(pay_time)) = ( select CONCAT_WS("/",YEAR(pay_time),MONTH(pay_time)) from ' . TABLE_PROMETERS_COMMISSION_INFO . ' where prometers_commission_info_id = '. $_GET['pid'] . ')';
 $commission_res = $db->Execute($commission_sql);
 if ($commission_res->RecordCount() > 0) {
	$i = 1;
	while ( ! $commission_res->EOF ) {
		if ( isset($_GET['id']) && $_GET['id'] == $commission_res->fields['prometers_commission_info_id']){
			$_GET['page'] = ceil($i / 20);
			$commission_res->EOF = true;
		}
		$i++;
		$commission_res->MoveNext();
	}
    }
    $commission_split = new splitPageResults($_GET['page'], 20, $commission_sql, $commission_query_numrows);
 $auditor = '';
 $id = '';
 if(zen_not_null($action)){
	switch ($action){
        case 'commission_audit':
            $auditor = $_SESSION['admin_name'];
            $id = $_GET['orders_id'];
            $commission_status = $db->Execute('select commission_status,customers_dropper_id,prometers_commission_info_id from ' . TABLE_PROMETERS_COMMISSION_INFO . ' where orders_id = ' . $_GET['orders_id']);
            $customers_dropper_id = $commission_status->fields['customers_dropper_id'];
            $prometers_commission_info_id = $commission_status->fields['prometers_commission_info_id'];
            $pay_sql= 'select payment_method,paypal from ' . TABLE_PROMETERS_COMMISSION . ' where customers_dropper_id = ' .$customers_dropper_id;
            $pay_res = $db->Execute($pay_sql);
            $payment_method = $pay_res->fields['payment_method'];
            $paypal = $pay_res->fields['paypal'];
            $date = $db->Execute("select CONCAT_WS('/',YEAR(orders_pay_time),MONTH(orders_pay_time)) time from " . TABLE_PROMETERS_COMMISSION_INFO . " where prometers_commission_info_id = " . $prometers_commission_info_id);
            $time = $date->fields['time'];
            if($id != ''){
            	$update_sql = 'update ' . TABLE_PROMETERS_COMMISSION_INFO . ' set  commission_status = 3 , commission_audit_time = now(),auditor = "' . $auditor . '" where orders_id = ' . $_GET['orders_id'];
              $update_sql2 = 'update ' . TABLE_PROMETERS_COMMISSION_INFO . ' set  payment_method_return_commission = "'  . $payment_method . '" , paypal_return_commission = "'  . $paypal . '"  where CONCAT_WS("/",YEAR(orders_pay_time),MONTH(orders_pay_time)) = "' . $time . '" and commission_status =3 ';
            	$db->Execute($update_sql);
              $db->Execute($update_sql2);
            }
        break;
        case 'commission_pay':
            $auditor = $_SESSION['admin_name'];
            $commission_status = $db->Execute('select commission_status,customers_dropper_id from ' . TABLE_PROMETERS_COMMISSION_INFO . ' where orders_id = ' . $_GET['orders_id']);
            $customers_dropper_id = $commission_status->fields['customers_dropper_id'];
            
            $error = false;
            if($commission_status->fields['commission_status'] == 0){
            	$messageStack->add_session('请先审核该笔订单', 'error');
              zen_redirect(zen_href_link('commission_audit', zen_get_all_get_params(array ('action', 'coupons')), 'NONSSL'));
			      
            }else{
            	$update_sql = 'update ' . TABLE_PROMETERS_COMMISSION_INFO . ' set  commission_status = 4 , return_commission_time = now() , auditor = "' . $auditor . '" where orders_id = ' . $_GET['orders_id'];
            	$db->EXecute($update_sql);
            }
          
        break;
        case 'commission_audit_all':
        
        $id = 'select group_concat(a.prometers_commission_info_id)  id from ' . TABLE_PROMETERS_COMMISSION_INFO . ' a,' . TABLE_ORDERS . ' o where customers_dropper_id = ' . $_GET['cid'] . ' and a.orders_id = o.orders_id and date_sub(now(),interval 30 day) >= orders_pay_time and o.orders_status in(2,3,4,10,42) and CONCAT_WS("/",YEAR(orders_pay_time),MONTH(orders_pay_time)) = ( select CONCAT_WS("/",YEAR(orders_pay_time),MONTH(orders_pay_time)) from ' . TABLE_PROMETERS_COMMISSION_INFO . ' where prometers_commission_info_id = ' . $_GET['pid'].')';
            $id_res = $db->EXecute($id);
            $id = $id_res->fields['id'];
            $auditor = $_SESSION['admin_name'];
            // $commission_status = $db->Execute('select commission_status,customers_dropper_id,prometers_commission_info_id from ' . TABLE_PROMETERS_COMMISSION_INFO . ' where orders_id = ' . $_GET['orders_id']);
            // $customers_dropper_id = $commission_status->fields['customers_dropper_id'];
            // $prometers_commission_info_id = $commission_status->fields['prometers_commission_info_id'];
            $pay_sql= 'select payment_method,paypal from ' . TABLE_PROMETERS_COMMISSION . ' where customers_dropper_id = ' .$_GET['cid'];
            $pay_res = $db->Execute($pay_sql);
            $payment_method = $pay_res->fields['payment_method'];
            $paypal = $pay_res->fields['paypal'];
             $date = $db->Execute("select CONCAT_WS('/',YEAR(orders_pay_time),MONTH(orders_pay_time)) time from " . TABLE_PROMETERS_COMMISSION_INFO . " where prometers_commission_info_id = " . $_GET['pid']);
            $time = $date->fields['time'];
            if($id != ''){
	            $update_sql = 'update ' . TABLE_PROMETERS_COMMISSION_INFO .' set commission_status = 3 , commission_audit_time = now(), auditor = "' . $auditor . '" where prometers_commission_info_id in( ' . $id . ') and commission_status !=3 '; 
              $update_sql2 = 'update ' . TABLE_PROMETERS_COMMISSION_INFO . ' set  payment_method_return_commission = "'  . $payment_method . '" , paypal_return_commission = "'  . $paypal . '"  where CONCAT_WS("/",YEAR(orders_pay_time),MONTH(orders_pay_time)) = "' . $time . '" and commission_status = 3';
	            $db->Execute($update_sql);
              $db->Execute($update_sql2);
             
            }
        break;
        case 'commission_pay_all':
        
          $id = 'select group_concat(a.prometers_commission_info_id)  id from ' . TABLE_PROMETERS_COMMISSION_INFO . ' a,' . TABLE_ORDERS . ' o where customers_dropper_id = ' . $_GET['cid'] . ' and a.orders_id = o.orders_id and date_sub(now(),interval 30 day) >= orders_pay_time and o.orders_status in(2,3,4,10,42) and CONCAT_WS("/",YEAR(orders_pay_time),MONTH(orders_pay_time)) = ( select CONCAT_WS("/",YEAR(orders_pay_time),MONTH(orders_pay_time)) from ' . TABLE_PROMETERS_COMMISSION_INFO . ' where prometers_commission_info_id = ' . $_GET['pid'].')';
	          $id_res = $db->EXecute($id);
	          $id = $id_res->fields['id'];
	          $auditor = $_SESSION['admin_name'];
              $commission_status = $db->Execute('select min(commission_status),commission_status from ' . TABLE_PROMETERS_COMMISSION_INFO . ' where prometers_commission_info_id in( ' . $id . ') group by prometers_commission_info_id');
              if($commission_status->fields['min(commission_status)'] == 0){
            	$messageStack->add_session('有未审核的订单', 'error');
              zen_redirect(zen_href_link('commission_audit', zen_get_all_get_params(array ('action', 'coupons')), 'NONSSL'));
              }else{
            	$update_sql = 'update ' . TABLE_PROMETERS_COMMISSION_INFO .' set commission_status = 4 , return_commission_time = now(), auditor = "' . $auditor . '" where prometers_commission_info_id in( ' . $id . ') and commission_status != 4'; 
	            $db->EXecute($update_sql);
            
              }
        break;
	}
 }

 $commission = $db->Execute($commission_sql);
 if ($commission->RecordCount() > 0) {

		while ( ! $commission->EOF ) { 
      $commission_status = $commission->fields ['commission_status'];
			if($commission_status == 0 || $commission_status == 1 ){
        $status = '待审核';
      }else if($commission_status == 3){
                $status = '审核完成';
      }else if($commission_status == 4){
                $status = '支付完成';
      }

           $commission_method [$commission->fields ['prometers_commission_info_id']] = array (
           	        'prometers_commission_info_id' => $commission->fields ['prometers_commission_info_id'],
	  				'customers_dropper_id' => $commission->fields ['customers_dropper_id'],
	  				'orders_id' => $commission->fields ['orders_id'],
	  				'orders_pay_time' => $commission->fields ['orders_pay_time'],
	  				'in_orders_total' => 'USD ' . round($commission->fields ['in_orders_total'],2),
	  				'return_commission_total' => 'USD ' . round($commission->fields ['return_commission_total'],2),
	  				'commission_status' => $status,
	  				'commission_audit_time' => $commission->fields['commission_audit_time'],
	  				'return_commission_time' => $commission->fields ['return_commission_time'],
	  				'auditor' => $commission->fields ['auditor']
	  				
	  	   );
	     	$commission->MoveNext();
		}
	}


?>


<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title>佣金审核</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript" src="includes/jquery.js"></script>
<script language="javascript" src="includes/commission.js"></script>
<style>
   .disableHref{
	    cursor:default;
	    color:#E5E0E0;
	    text-decoration:none;
    }
</style>
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
            <!-- <td class="pageHeading" widht="100px">佣金管理</td>         	 -->
                       
          </tr>
        </table>
        </td>
      </tr>
    </td>
    <td align="right">
        <?php 
           $commission_sql1 = 'SELECT min(commission_status) cs FROM ' . TABLE_PROMETERS_COMMISSION_INFO . ' a,'. TABLE_ORDERS .' o WHERE customers_dropper_id = ' . $_GET['cid'] . ' AND a.orders_id = o.orders_id AND date_sub(now(), INTERVAL 30 DAY) >= orders_pay_time AND o.orders_status IN (2, 3, 4, 10, 42) and CONCAT_WS("/",YEAR(pay_time),MONTH(pay_time)) = ( select CONCAT_WS("/",YEAR(pay_time),MONTH(pay_time)) from ' . TABLE_PROMETERS_COMMISSION_INFO . ' where prometers_commission_info_id = '. $_GET['pid'] . ')';
           $commission_res1 = $db->Execute($commission_sql1);
           
           $comm_status = $commission_res1->fields['cs'];
        ?>
          <?php if ($comm_status == 3 ) {?>
            <button id="commission_audit_all" disabled="disabled" onclick="location.href='<?php echo zen_href_link('commission_audit', zen_get_all_get_params(array('action', 'id', 'orderby')) . 'action=commission_audit_all&id=' .$id);?>'"/>批量审核</button>
          <?php }else if($comm_status == 0){ ?>
            <button id="commission_audit_all"  onclick="location.href='<?php echo zen_href_link('commission_audit', zen_get_all_get_params(array('action', 'id', 'orderby')) . 'action=commission_audit_all&id=' .$id);?>'"/>批量审核</button>
          <?php } ?>
          <?php if ($comm_status == 4 ) {?>
            <button id="commission_audit_all" disabled="disabled" onclick="location.href='<?php echo zen_href_link('commission_audit', zen_get_all_get_params(array('action', 'id', 'orderby')) . 'action=commission_audit_all&id=' .$id);?>'"/>批量审核</button>
            <button id="commission_pay_all"  disabled="disabled" onclick="location.href='<?php echo zen_href_link('commission_audit', zen_get_all_get_params(array('action', 'id', 'orderby')) . 'action=commission_pay_all&id=' .$id);?>'"/>批量支付</button>
          <?php } else{?>

            <button id="commission_pay_all"   onclick="location.href='<?php echo zen_href_link('commission_audit', zen_get_all_get_params(array('action', 'id', 'orderby')) . 'action=commission_pay_all&id=' .$id);?>'"/>批量支付</button>
          <?php } ?>






        
    </td>
  </tr>
  		<table border="0" width="100%" cellspacing="0" cellpadding="0">          
          <tr>
            <td valign="top">
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" width="150px" align="center">推广商ID</td>
                <td class="dataTableHeadingContent" width="150px" align="center">引入订单号</td>
                <td class="dataTableHeadingContent" width="150px" align="center">订单付款时间</td>
                <td class="dataTableHeadingContent" width="150px" align="center">订单金额</td>
                <td class="dataTableHeadingContent" width="150px" align="center">佣金</td>
                <td class="dataTableHeadingContent" width="150px" align="center">佣金状态</td>
                <td class="dataTableHeadingContent" width="150px" align="center">佣金审核时间</td>
                <td class="dataTableHeadingContent" width="150px" align="center">佣金支付时间</td>
                <td class="dataTableHeadingContent" width="150px" align="center">审核人/支付人</td>
                <td class="dataTableHeadingContent" width="150px" align="center">操作</td>
              </tr>
          
            	<?php 

              	foreach ($commission_method as $method => $val){
					// if ($id == $val['id']) {
					// 	$mInfo = new objectInfo($val);
					// 	echo '<tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link('shipping', zen_get_all_get_params(array('action', 'id', 'orderby')) . 'action=edit&id=' . $val['id'] . '&orderby=' . $order_by, 'NONSSL') . '\'">' . "\n";
					// }else {
					// 	echo '<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link('shipping', zen_get_all_get_params(array('id', 'orderby', 'action')) . 'id=' . $val['id']. '&orderby=' . $order_by, 'NONSSL') . '\'">' . "\n";
					// }
              ?>
              <td class="dataTableHeadingContent" align="center"><?php echo $val['customers_dropper_id']?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['orders_id']?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['orders_pay_time']?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['in_orders_total']?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['return_commission_total']?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['commission_status']?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['commission_audit_time']?$val['commission_audit_time']:'/' ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['return_commission_time']?$val['return_commission_time']:'/' ?></td>
               <td class="dataTableHeadingContent" align="center"><?php echo $val['auditor']?$val['auditor']:'/' ?></td>
                <td class="dataTableHeadingContent" align="center" id="caozuo">
                    <?php if ($val["commission_status"] == '审核完成' ) {?>
                    <button id="commission_audit" disabled="disabled" onclick="location.href='<?php echo zen_href_link('commission_audit', zen_get_all_get_params(array('action', 'id', 'orderby')) . 'action=commission_audit&id=' .$val["customers_dropper_id"] .'&orders_id=' . $val["orders_id"]);?>'"/>审核</button>
                    <?php }else if($val["commission_status"] == '待审核'){ ?>
                      <button id="commission_audit"  onclick="location.href='<?php echo zen_href_link('commission_audit', zen_get_all_get_params(array('action', 'id', 'orderby')) . 'action=commission_audit&id=' .$val["customers_dropper_id"] .'&orders_id=' . $val["orders_id"]);?>'"/>审核</button>
                    <?php } ?>
                    <?php if ($val["commission_status"] == '支付完成' ) {?>
                      <button id="commission_audit" disabled="disabled" onclick="location.href='<?php echo zen_href_link('commission_audit', zen_get_all_get_params(array('action', 'id', 'orderby')) . 'action=commission_audit&id=' .$val["customers_dropper_id"] .'&orders_id=' . $val["orders_id"]);?>'"/>审核</button>
                      <button id="commission_pay" disabled="disabled" onclick="location.href='<?php echo zen_href_link('commission_audit', zen_get_all_get_params(array('action', 'id', 'orderby')) . 'action=commission_pay&id=' .$val["customers_dropper_id"] .'&orders_id=' . $val["orders_id"]);?>'"/>支付完成</button>
                    <?php } else{?>

                      <button id="commission_pay" onclick="location.href='<?php echo zen_href_link('commission_audit', zen_get_all_get_params(array('action', 'id', 'orderby')) . 'action=commission_pay&id=' .$val["customers_dropper_id"] .'&orders_id=' . $val["orders_id"]);?>'"/>支付完成</button>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>	
            <tr align="left">
                    <td class="smallText" valign="top" colspan="5"><?php echo $commission_split->display_count($commission_res->RecordCount(), 20, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_RESULTS); ?></td>
                    <td class="smallText" align="right" colspan="7"><?php echo $commission_split->display_links($commission_query_numrows, 20, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'orderby', 'id')) . 'orderby=' . $order_by); ?></td>
            </tr>
          
       </tr>
   </table>

</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>