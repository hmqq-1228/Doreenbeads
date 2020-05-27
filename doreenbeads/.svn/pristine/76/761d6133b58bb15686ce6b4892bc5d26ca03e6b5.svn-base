<?php
require('includes/application_top.php');
require_once(DIR_FS_CATALOG . DIR_WS_CLASSES . 'excel/PHPExcel.php');
global $db;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$search_condition = '';
if(zen_not_null($action)){
   switch($action){
   	 case 'search':
   	    $starttime = $_GET['starttime'];
   	    $stoptime = $_GET['stoptime'];
   	    if($starttime != '' && $stoptime != ''){
   	    	    if($search_condition == ''){
             	  $search_condition .= " and commission_audit_time > '" . $starttime . " ' and commission_audit_time < '" . $stoptime . "'"; 
             	}else{
             	   $search_condition .= " and commission_audit_time > '" . $starttime . " ' and commission_audit_time < '" . $stoptime . "'"; 
             	}
   	    }
   	    $status = $_GET['status'];
   	    if($status != '0'){
   	    	if($status == 1){
            $status = 0;
          }else if($status == 2){
            $status = 3;
          }else if($status == 3){
            $status = 4;
          }else if($status == 4){
            $status = 1;
          }else if($status == 5){
            $status = 2;
          }
                if($search_condition == ''){
             	  $search_condition .= " and commission_status = " . $status; 
             	}else{
             	   $search_condition .= " and commission_status = " . $status;; 
             	}
   	    }
   	    $starttimes = $_GET['starttimes'];
   	    $stoptimes = $_GET['stoptimes'];
   	    if($starttimes != '' && $stoptimes != ''){
   	    	    if($search_condition == ''){
             	  $search_condition .= " and return_commission_time > '" . $starttimes . " ' and return_commission_time < '" . $stoptimes . "'"; 
             	}else{
             	   $search_condition .= " and return_commission_time > '" . $starttimes . " ' and return_commission_time < '" . $stoptimes . "'"; 
             	}
   	    }
   	    $method = $_GET['method'];
   	    if($method != 0){
   	    	if($method == 1){
   	    		$method = 'paypal';
   	    	}else if($method ==2){
   	    		$method = 'balance';
   	    	}
   	    	if($search_condition == ''){
             	  $search_condition .= " and t1.payment_method = '" . $method . "'";
             	}else{
             	   $search_condition .= " and t1.payment_method = '" . $method . "'"; 
             	}
   	    }
   	    $admin = $_GET['admin'];
   	    if($admin != ''){
   	    	if($search_condition == ''){
             	  $search_condition .= " and auditor = '" . $admin . "'";
             	}else{
             	   $search_condition .= " and auditor = '" . $admin . "'"; 
             	}
   	    }
   	    $id = $_GET['ID'];
   	    if($id != ''){
   	    	if($search_condition == ''){
             	  $search_condition .= " and customers_dropper_id = '" . $id . "'";
             	}else{
             	   $search_condition .= " and customers_dropper_id = '" . $id . "'"; 
             	}
   	    }
   	  break;
   }

if(isset($_POST['action']) && $_POST['action'] == 'export'){
	$starttime = $_GET['starttime'];
   	    $stoptime = $_GET['stoptime'];
   	    if($starttime != '' && $stoptime != ''){
   	    	    if($search_condition == ''){
             	  $search_condition .= " and commission_audit_time > '" . $starttime . " ' and commission_audit_time < '" . $stoptime . "'"; 
             	}else{
             	   $search_condition .= " and commission_audit_time > '" . $starttime . " ' and commission_audit_time < '" . $stoptime . "'"; 
             	}
   	    }
   	    $status = $_GET['status'];
   	    if($status != '0'){
   	    	if($status == 1){
        		$status = 0;
        	}else if($status == 2){
        		$status = 3;
        	}else if($status == 3){
        		$status = 4;
        	}else if($status == 4){
        		$status = 1;
        	}else if($status == 5){
        		$status = 2;
        	}
                if($search_condition == ''){
             	  $search_condition .= " and commission_status = " . $status; 
             	}else{
             	   $search_condition .= " and commission_status = " . $status;; 
             	}
   	    }
   	    $starttimes = $_GET['starttimes'];
   	    $stoptimes = $_GET['stoptimes'];
   	    if($starttimes != '' && $stoptimes != ''){
   	    	    if($search_condition == ''){
             	  $search_condition .= " and return_commission_time > '" . $starttimes . " ' and return_commission_time < '" . $stoptimes . "'"; 
             	}else{
             	   $search_condition .= " and return_commission_time > '" . $starttimes . " ' and return_commission_time < '" . $stoptimes . "'"; 
             	}
   	    }
   	    $method = $_GET['method'];
   	    if($method != 0){
   	    	if($method == 1){
   	    		$method = 'paypal';
   	    	}else if($method ==2){
   	    		$method = 'balance';
   	    	}
   	    	if($search_condition == ''){
             	  $search_condition .= " and t1.payment_method = '" . $method . "'";
             	}else{
             	   $search_condition .= " and t1.payment_method = '" . $method . "'"; 
             	}
   	    }
   	    $admin = $_GET['admin'];
   	    if($admin != ''){
   	    	if($search_condition == ''){
             	  $search_condition .= " and auditor = '" . $admin . "'";
             	}else{
             	   $search_condition .= " and auditor = '" . $admin . "'"; 
             	}
   	    }
   	    $id = $_GET['ID'];
   	    if($id != ''){
   	    	if($search_condition == ''){
             	  $search_condition .= " and customers_id = '" . $id . "'";
             	}else{
             	   $search_condition .= " and customers_id = '" . $id . "'"; 
             	}
   	    }
	$commission_info_sql = ' SELECT t1.prometers_commission_info_id,t1.customers_dropper_id,t2.customers_id,t1.orders_id,t1.orders_pay_time,t1.in_orders_total,t1.return_commission_total,t1.commission_status,t1.commission_audit_time,t1.return_commission_time,t1.auditor,t1.payment_method,t1.paypal,t2.orders_status FROM ' . TABLE_PROMETERS_COMMISSION_INFO  .' t1 INNER JOIN  ' . TABLE_ORDERS . ' t2 ON t1.orders_id = t2.orders_id ' . $search_condition . ' where orders_pay_time != "" order by commission_status,orders_pay_time desc';
	 $commission_info_res = $db->Execute($commission_info_sql);
     $download = 'download/customers_info.csv';
     $fp = fopen($download, 'w');
     $array_head = array('推广商ID', '引入并下单客户ID', '订单号', '付款时间', '订单金额', '佣金', '佣金状态', '审核时间', '佣金支付时间','审核人/支付人','支付方式','paypal账户');
	foreach($array_head as $array_head_key => $array_head_value) {
		$array_head[$array_head_key] = iconv("utf-8", "gb2312", $array_head_value);
	}
	fputcsv($fp, $array_head);
    while (!$commission_info_res->EOF) {
	    $commission_status = $commission_info_res->fields['commission_status'];
			if($commission_status == 0){
        $status = '待审核';
      }else if($commission_status == 1){
                $status = '返佣中';
      }else if($commission_status == 2){
                $status = '取消返佣';
      }else if($commission_status == 3){
                $status = '审核完成';        
      }else if($commission_status == 4){
                $status = '支付完成';
      }
		$commission_info_res->fields['customers_dropper_id'] = $commission_info_res->fields['customers_dropper_id'] ;
		$commission_info_res->fields['customers_id'] = $commission_info_res->fields['customers_id'] ;
		$commission_info_res->fields['orders_id'] = $commission_info_res->fields['orders_id'] ;
		$commission_info_res->fields['orders_pay_time'] = $commission_info_res->fields['orders_pay_time'] ;
		$commission_info_res->fields['in_orders_total'] = $commission_info_res->fields['in_orders_total'] ;
		$commission_info_res->fields['return_commission_total'] = $commission_info_res->fields['return_commission_total'] ;
		$commission_info_res->fields['commission_status'] = iconv("utf-8", "gb2312", $status);
		$commission_info_res->fields['commission_audit_time'] = $commission_info_res->fields['commission_audit_time']?$commission_info_res->fields['commission_audit_time']:'/' ;
		$commission_info_res->fields['return_commission_time'] = $commission_info_res->fields['return_commission_time']?$commission_info_res->fields['return_commission_time']:'/' ;
		$commission_info_res->fields['auditor'] = $commission_info_res->fields['auditor']?$commission_info_res->fields['auditor']:'/';
		$commission_info_res->fields['payment_method'] = $commission_info_res->fields['payment_method'] ;
		$commission_info_res->fields['paypal'] = $commission_info_res->fields['paypal'] ?$commission_info_res->fields['paypal']:'/';
		fputcsv($fp, $commission_info_res->fields);
		
		$commission_info_res->MoveNext();
	}
	fclose($fp);
    $file = fopen($download, "r");
	header("Content-type:text/html;charset=utf-8"); 
	Header("Content-type: application/octet-stream");
	Header("Accept-Ranges: bytes");
	Header("Accept-Length: " . filesize($download));
	$file_name = '佣金明细.csv';;
	if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) {
		header('Content-type: application/octetstream');
	} else {
		header('Content-Type: application/x-octet-stream');
	}
	header('Content-Disposition: attachment; filename=' . iconv("utf-8", "gb2312", $file_name));
	echo fread($file, filesize($download));
	fclose($file);
	exit;

}
}


  // $commission_status_sql = ' SELECT t1.orders_pay_time,t1.commission_status FROM ' . TABLE_PROMETERS_COMMISSION_INFO  .' t1 INNER JOIN  ' . TABLE_ORDERS . ' t2 ON t1.orders_id = t2.orders_id ';
  // $commission_status_res = $db->Execute($commission_status_sql);
  // $orders_pay_time = $commission_status_res->fields['orders_pay_time'] ;
  // 
	$commission_info_sql = ' SELECT t1.prometers_commission_info_id,t1.customers_dropper_id,t2.customers_id,t1.orders_id,t1.orders_pay_time,t1.in_orders_total,t1.return_commission_total,t1.commission_status,t1.commission_audit_time,t1.return_commission_time,t1.auditor,t1.payment_method pm1,t1.paypal pl1,t1.payment_method_return_commission,t1.paypal_return_commission,t3.paypal pl3,t3.payment_method pm3,t2.orders_status FROM ' . TABLE_PROMETERS_COMMISSION_INFO  .' t1 INNER JOIN  ' . TABLE_ORDERS . ' t2 ON t1.orders_id = t2.orders_id ' . $search_condition . ' inner join ' .TABLE_PROMETERS_COMMISSION . ' t3 on t1.customers_dropper_id = t3.customers_dropper_id  where orders_pay_time != "" order by commission_status,orders_pay_time desc' ;
     $commission_info_res = $db->Execute($commission_info_sql);
if ($commission_info_res->RecordCount() > 0) {
	$i = 1;
	while ( ! $commission_info_res->EOF ) {
		if ( isset($_GET['id']) && $_GET['id'] == $commission_info_res->fields['prometers_commission_info_id']){
			$_GET['page'] = ceil($i / 20);
			$commission_info_res->EOF = true;
		}
		$i++;
		$commission_info_res->MoveNext();
	}
    }
    $commission_split = new splitPageResults($_GET['page'], 20, $commission_info_sql, $commission_query_numrows);
    $commission = $db->Execute($commission_info_sql);
   
if ($commission->RecordCount() > 0) {
		while ( ! $commission->EOF ) { 
      $orders_status = $commission->fields ['orders_status'];
      $orders_pay_time=$commission->fields ['orders_pay_time'];
			$commission_status = $commission->fields ['commission_status']; 
      if($orders_status == 41){
        $commission_status = 2;
        if($commission_status == 2){
          $orders_id = $commission->fields ['orders_id'];
          $db->Execute("update " . TABLE_PROMETERS_COMMISSION_INFO . " set commission_status = 2 where orders_id = " . $orders_id);        
        }
      }
			if($commission_status == 0){
				$status = '待审核';
			}else if($commission_status == 1){
                $orders_id = $commission->fields['orders_id'];
               
                $status = '返佣中';
                if(date('Y-m-d H:i:s',strtotime("-30 day")) > $orders_pay_time ){
                $db->Execute("update " . TABLE_PROMETERS_COMMISSION_INFO . " set commission_status = 0 where orders_id = " . $orders_id);
                }
			}else if($commission_status == 2){
                $status = '取消返佣';
			}else if($commission_status == 3){
                $status = '审核完成';        
      }else if($commission_status == 4){
                $status = '支付完成';
      }
      if($commission_status == 3 || $commission_status == 4){
        $payment_method = $commission->fields['payment_method_return_commission'];
        $paypal = $commission->fields['paypal_return_commission'];
      }else if($commission_status == 0 || $commission_status == 1){
        $payment_method = $commission->fields['pm3'];
        $paypal = $commission->fields['pl3'];
      }elseif($commission_status == 2){
        $payment_method = $commission->fields['pm1'];
        $paypal = $commission->fields['pl1'];
      }
           $commission_method [$commission->fields ['prometers_commission_info_id']] = array (
           	        'prometers_commission_info_id' => $commission->fields ['prometers_commission_info_id'],
	  				'customers_dropper_id' => $commission->fields ['customers_dropper_id'],
	  				'customers_id' => $commission->fields ['customers_id'],
	  				'orders_id' => $commission->fields ['orders_id'],
	  				'orders_pay_time' => isset($commission->fields ['orders_pay_time'])? $commission->fields ['orders_pay_time'] :'/',
	  				'in_orders_total' => 'USD ' . round($commission->fields ['in_orders_total'],2),
	  				'return_commission_total' => 'USD ' . round($commission->fields ['return_commission_total'],2),
	  				'commission_status' => $status,
	  				'commission_audit_time' => $commission->fields ['commission_audit_time'],
	  				'return_commission_time' => $commission->fields ['return_commission_time'],
	  				'auditor' => $commission->fields ['auditor'],
	  				'payment_method' => $payment_method,
	  				'paypal' => $paypal
	  				
	  	   );
	     	$commission->MoveNext();
		}
    
	}

?>


<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title>佣金明细</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript" src="includes/jquery.js"></script>
<script type="text/javascript" src="../includes/templates/cherry_zen/jscript/My97DatePicker/WdatePicker.js"></script>
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
               $status_str_arr = array(array('id' => 0, 'text' => '全部'),
                                       array('id' => 1, 'text' => '待审核'),
                                       array('id' => 2, 'text' => '审核完成'),
                                       array('id' => 3, 'text' => '支付完成'),
                                       array('id' => 4, 'text' => '返佣中'),
                                       array('id' => 5, 'text' => '取消返佣')
                                      );
               $method_str_arr = array(array('id' => 0 , 'text' => '全部'),
                                       array('id' => 1, 'text' => 'Paypal账户'),
                                       array('id' => 2, 'text' => 'Balance')
                                      );
              
            ?> 
        <form name="search" action="<?php echo zen_href_link(FILENAME_COMMISSION_INFO)?>" method="get">
          <table width="100%" border="0" cellspacing="5" cellpadding="0">
          	<tr><td  align="right">审核时间：<?php echo zen_draw_input_field('starttime','', "class = 'Wdate' style='width:140px;' onClick='WdatePicker({dateFmt:&quot;yyyy-MM-dd HH:mm:ss&quot;});'    ") ?>&nbsp&nbsp <?php echo zen_draw_input_field('stoptime', $compare_stop_time ? $compare_stop_time : '', "class = 'Wdate' style='width:140px;' onClick='WdatePicker({dateFmt:&quot;yyyy-MM-dd HH:mm:ss&quot;});'   ");;?><?php echo zen_draw_hidden_field('action' , 'search')?>&nbsp&nbsp&nbsp<span >佣金状态：</span><?php echo zen_draw_pull_down_menu('status', $status_str_arr , $_GET['status'] ? $_GET['status'] : '' , 'style="width: 100px;height: 20px;"')?></td></tr>
          	<tr><td  align="right">支付时间：<?php echo zen_draw_input_field('starttimes','', "class = 'Wdate' style='width:140px;' onClick='WdatePicker({dateFmt:&quot;yyyy-MM-dd HH:mm:ss&quot;});'    ") ?>&nbsp&nbsp <?php echo zen_draw_input_field('stoptimes', $compare_stop_time ? $compare_stop_time : '', "class = 'Wdate' style='width:140px;' onClick='WdatePicker({dateFmt:&quot;yyyy-MM-dd HH:mm:ss&quot;});'   ");;?><?php echo zen_draw_hidden_field('action' , 'search')?><?php echo zen_draw_hidden_field('action' , 'search')?>&nbsp&nbsp&nbsp<span >支付方式：</span><?php echo zen_draw_pull_down_menu('method', $method_str_arr , $_GET['method'] ? $_GET['method'] : '' , 'style="width: 100px;height: 20px;"')?> </td></tr>
          	<tr><td align="right">审核人/支付人：<?php echo zen_draw_input_field('admin' , $_GET['admin'] ? $_GET['admin'] :'' , 'style="height: 20px;width: 100px;"')?>&nbsp&nbsp&nbsp推广商ID：<?php echo zen_draw_input_field('ID' , $_GET['ID'] ? $_GET['ID'] :'' , 'style="height: 20px;width: 100px;"')?></td></tr>
          	<tr><td  align="right"><?php echo zen_image_submit('button_search_cn.png','Search');?></td></tr>
          </table>
        </form>
            <tr align="left"><td>
            <form  name="products_status" id="products_status" action="<?php echo zen_href_link(FILENAME_COMMISSION_INFO,zen_get_all_get_params(array('action')) . 'action=export');?>" method="post">
			<input type="hidden" name="action" value="export" />
			<input type="submit" style="width:50px;height:30px"value="导出" />
			</form>
		    </td></tr>
    </td>
  </tr>
  <tr>
  	  
  	<td valign="top">
  		<table border="0" width="100%" cellspacing="0" cellpadding="0">          
          <tr>
            <td valign="top">
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" width="150px" align="center">推广商ID</td>
                <td class="dataTableHeadingContent" width="150px" align="center">引入并下单客户ID</td>
                <td class="dataTableHeadingContent" width="150px" align="center">订单号</td>
                <td class="dataTableHeadingContent" width="150px" align="center">付款时间</td>
                <td class="dataTableHeadingContent" width="150px" align="center">订单金额</td>
                <td class="dataTableHeadingContent" width="150px" align="center">佣金</td>
                <td class="dataTableHeadingContent" width="150px" align="center">佣金状态</td>
                <td class="dataTableHeadingContent" width="150px" align="center">审核时间</td>
                <td class="dataTableHeadingContent" width="150px" align="center">佣金支付时间</td>
                <td class="dataTableHeadingContent" width="150px" align="center">审核人/支付人</td>
                <td class="dataTableHeadingContent" width="150px" align="center">支付方式</td>
                <td class="dataTableHeadingContent" width="150px" align="center">Paypal账户</td>
              </tr>
              <?php 
              	foreach ($commission_method as $method => $val){
              		// var_dump($val['customers_id']);exit;
					// if ($id == $val['id']) {
					// 	$mInfo = new objectInfo($val);
					// 	echo '<tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link('shipping', zen_get_all_get_params(array('action', 'id', 'orderby')) . 'action=edit&id=' . $val['id'] . '&orderby=' . $order_by, 'NONSSL') . '\'">' . "\n";
					// }else {
					// 	echo '<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link('shipping', zen_get_all_get_params(array('id', 'orderby', 'action')) . 'id=' . $val['id']. '&orderby=' . $order_by, 'NONSSL') . '\'">' . "\n";
					// }
              ?> 
              
              	<td class="dataTableHeadingContent" align="center"><?php echo $val['customers_dropper_id']?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['customers_id']?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['orders_id']?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['orders_pay_time']?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['in_orders_total']?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['return_commission_total']?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['commission_status'] ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['commission_audit_time']?$val['commission_audit_time']:'/' ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['return_commission_time']?$val['return_commission_time']:'/' ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['auditor']?$val['auditor']:'/' ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['payment_method'] ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['paypal']?$val['paypal']:'/' ?></td>
              </tr>

          <?php } ?>

              <tr align="left">
                    <td class="smallText" valign="top" colspan="5"><?php echo $commission_split->display_count($commission_query_numrows, 20, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_RESULTS); ?></td>
                    <td class="smallText" align="right" colspan="7"><?php echo $commission_split->display_links($commission_query_numrows, 20, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'orderby', 'id')) . 'orderby=' . $order_by); ?></td>
              </tr>
          </tr>
  </tr>
  </table>

</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>