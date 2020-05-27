<?php
require('includes/application_top.php');
require_once(DIR_FS_CATALOG . DIR_WS_CLASSES . 'excel/PHPExcel.php');
global $db;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
if(zen_not_null($action)){
	switch ($action){
		case 'search':
		$year = zen_db_input($_GET['year']);
		$month = zen_db_input($_GET['month']);
		if($year != ''){
			if($year == 0){
				$year = 2019;
			}else if($year == 1){
				$year = 2020;
			}else if($year == 2){
				$year = 2021;
			}else if($year == 3){
				$year = 2022;
			}else if($year == 4){
				$year = 2023;
			}
		}
		if($month != ''){
			if($month == 0){
				$month = 1;
			}else if($month == 1){
				$month = 2;
			}else if($month == 2){
				$month = 3;
			}else if($month == 3){
				$month = 4;
			}else if($month == 4){
				$month = 5;
			}else if($month == 5){
				$month = 6;
			}else if($month == 6){
				$month = 7;
			}else if($month == 7){
				$month = 8;
			}else if($month == 8){
				$month = 9;
			}else if($month == 9){
				$month = 10;
			}else if($month == 10){
				$month = 11;
			}else if($month == 11){
				$month = 12;
			}
		}
		$time = $year.'/'.$month;
		if($time != ''){
             	if($search_condition == ''){
             	  $search_condition .= " and CONCAT_WS('/',YEAR(pay_time),MONTH(pay_time)) = '". $time ."'" ;
             	}else{
             	  $search_condition .= " and CONCAT_WS('/',YEAR(pay_time),MONTH(pay_time)) = '" . $time . "'" ;
             	}
        }
        $status = zen_db_input($_GET['status']);
        if($status != 4){
        	if($status == 1){
        		$status = 0;
        	}else if($status == 2){
        		$status = 3;
        	}else if($status == 3){
        		$status = 4;
        	}
         	if($search_condition == ''){
              $search_condition .= ' and commission_status ='. $status;
         	}else{
         	  $search_condition .= ' and commission_status ='. $status;
         	}
         }
        $method = zen_db_input($_GET['method']);
        if($method != 2){
        	if($method == 0){
        		$method = 'paypal';
        	}else if($method == 1 ){
        		$method ='balance';
        	}
            if($search_condition == ''){
              $search_condition .= " and  payment_method_return_commission ='". $method . "'";
         	}else{
         	  $search_condition .= " and payment_method_return_commission ='". $method . "'";
         	}
        }
        $id = zen_db_input($_GET['ID']);
        if($id != ''){
        	if($search_condition == ''){
              $search_condition .= " and t1.customers_dropper_id = " . $id;
         	}else{
         	  $search_condition .= " and t1.customers_dropper_id = " . $id;
         	}
        }	
	}
}


	$commission_sql = 'SELECT t1.orders_id,prometers_commission_info_id,t1.customers_dropper_id, sum(round(in_orders_total,2)) in_orders_total,sum(round(return_commission_total,2)) return_commission_total,min(commission_status) commission_status,CONCAT_WS("/",YEAR(pay_time),MONTH(pay_time)) as time,max(t1.payment_method_return_commission) tpm,max(t1.paypal_return_commission) tpl,t2.paypal,t2.payment_method ,max(return_commission_time) return_commission_time FROM ' . TABLE_PROMETERS_COMMISSION_INFO .  ' t1 inner join ' .TABLE_PROMETERS_COMMISSION . ' t2 on t1.customers_dropper_id = t2.customers_dropper_id left join ' . TABLE_ORDERS . ' o on o.orders_id = t1.orders_id
   where o.orders_status in(2,3,4,10,42) AND date_sub(now(), INTERVAL 30 DAY) >= orders_pay_time ' .$search_condition . ' group BY time,customers_dropper_id order by pay_time desc, commission_status asc, customers_dropper_id asc';
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
    $commission_split = new splitPageResults($_GET['page'], 20, $commission_sql, $commission_res->RecordCount());
	$commission = $db->Execute($commission_sql);
	if ($commission->RecordCount() > 0) {
		while ( ! $commission->EOF ) { 
			$commission_status = $commission->fields ['commission_status'];
      $return_commission_time = $commission->fields ['return_commission_time'];
      $orders_id = $commission->fields ['orders_id'];
			if($commission_status == 0 || $commission_status == 1 || $commission_status == 2){
				$status = '待审核';
			
			}else if($commission_status == 3){
                $status = '审核完成';
			}else if($commission_status == 4){
                $status = '支付完成';
      }
      if($commission_status == 3 ){
        $payment_method = $commission->fields['tpm'];
        $paypal = $commission->fields['tpl'];
      }else{
        $payment_method = $commission->fields['payment_method'];
        $paypal = $commission->fields['paypal'];
      }
      
        if($commission_status == 4 ){
          $max_pay_res = 'SELECT payment_method_return_commission,paypal_return_commission  FROM ' . TABLE_PROMETERS_COMMISSION_INFO . ' where return_commission_time = "' . $return_commission_time .'"';
          $max_pay = $db->Execute($max_pay_res);
          $payment_method = $max_pay->fields['payment_method_return_commission'];
          $paypal = $max_pay->fields['paypal_return_commission'];
        }
           $commission_method [$commission->fields ['prometers_commission_info_id']] = array (
           	        'prometers_commission_info_id' => $commission->fields ['prometers_commission_info_id'],
	  				'time' => $commission->fields ['time'],
	  				'customers_dropper_id' => $commission->fields ['customers_dropper_id'],
	  				'in_orders_total' => 'USD ' . round($commission->fields ['in_orders_total'],2),
	  				'return_commission_total' => 'USD ' . round($commission->fields ['return_commission_total'],2),

	  				'commission_status' => $status,
	  				'pay_method' => $payment_method,
	  				'paypal' => isset($paypal)?$paypal:'/'
	  				
	  	   );
	     	$commission->MoveNext();
		}
	}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title>佣金管理</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript" src="includes/jquery.js"></script>
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
               $status_str_arr = array(array('id' => 4, 'text' => '全部'),
                                       array('id' => 1, 'text' => '待审核'),
                                       array('id' => 2, 'text' => '审核完成'),
                                       array('id' => 3, 'text' => '支付完成')
                                      );
               $method_str_arr = array(array('id' => 2, 'text' => '全部'),
                                       array('id' => 0, 'text' => 'Paypal账户'),
                                       array('id' => 1, 'text' => 'Balance')
                                      );
               $year_str_arr = array(array('id' => 0, 'text' => '2019'),
                                       array('id' => 1, 'text' => '2020'),
                                       array('id' => 2, 'text' => '2021'),
                                       array('id' => 3, 'text' => '2022'),
                                       array('id' => 4, 'text' => '2023')
                                      );
               $month_str_arr = array(array('id' => 0, 'text' => '1'),
                                       array('id' => 1, 'text' => '2'),
                                       array('id' => 2, 'text' => '3'),
                                       array('id' => 3, 'text' => '4'),
                                       array('id' => 4, 'text' => '5'),
                                       array('id' => 5, 'text' => '6'),
                                       array('id' => 6, 'text' => '7'),
                                       array('id' => 7, 'text' => '8'),
                                       array('id' => 8, 'text' => '9'),
                                       array('id' => 9, 'text' => '10'),
                                       array('id' => 10, 'text' => '11'),
                                       array('id' => 11, 'text' => '12')
                                      );
            ?> 
        <form name="search" action="<?php echo zen_href_link(FILENAME_COMMISSION)?>" method="get">
          <table width="100%" border="0" cellspacing="5" cellpadding="0">
          	<tr><td  align="right">时间：<?php echo zen_draw_pull_down_menu('year', $year_str_arr , $_GET['year'] ? $_GET['year'] : '' , 'style="width: 100px;height: 20px;"')?>&nbsp&nbsp<?php echo zen_draw_pull_down_menu('month', $month_str_arr , $_GET['month'] ? $_GET['month'] : '' , 'style="width: 100px;height: 20px;"')?>&nbsp&nbsp&nbsp<?php echo zen_draw_hidden_field('action' , 'search')?><span >状态：</span><?php echo zen_draw_pull_down_menu('status', $status_str_arr , $_GET['status'] ? $_GET['status'] : '' , 'style="width: 100px;height: 20px;"')?></td></tr>
          	<tr><td  align="right"><?php echo zen_draw_hidden_field('action' , 'search')?><span >支付方式：</span><?php echo zen_draw_pull_down_menu('method', $method_str_arr , $_GET['method'] ? $_GET['method'] : '' , 'style="width: 100px;height: 20px;"')?>&nbsp&nbsp&nbsp 推广商ID：<?php echo zen_draw_input_field('ID' , $_GET['ID'] ? $_GET['ID'] :'' , 'style="height: 20px;width: 100px;"')?></td></tr>
          	<tr><td  align="right"><?php echo zen_image_submit('button_search_cn.png','Search');?></td></tr>
          </table>
        </form>
    </td>
  </tr>
  <tr>
  	  
  	<td valign="top">
  		<table border="0" width="100%" cellspacing="0" cellpadding="0">          
          <tr>
            <td valign="top">
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" width="150px" align="center">时间</td>
                <td class="dataTableHeadingContent" width="150px" align="center">推广商ID</td>
                <td class="dataTableHeadingContent" width="150px" align="center">引入订单总金额</td>
                <td class="dataTableHeadingContent" width="150px" align="center">佣金</td>
                <td class="dataTableHeadingContent" width="150px" align="center">状态</td>
                <td class="dataTableHeadingContent" width="150px" align="center">支付方式</td>
                <td class="dataTableHeadingContent" width="150px" align="center">Paypal账户</td>
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
              
              	<td class="dataTableHeadingContent" align="center"><?php echo $val['time']?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['customers_dropper_id']?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['in_orders_total']?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['return_commission_total']?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['commission_status']?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['pay_method']?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo $val['paypal'] ? $val['paypal']:'/' ?></td>
                <td class="dataTableHeadingContent" align="center">
                	<a href="<?php echo zen_href_link('commission_audit', zen_get_all_get_params(array('action', 'id', 'orderby')) . 'action=detail&cid=' .$val['customers_dropper_id'].'&pid=' . $val['prometers_commission_info_id']);?>">查看详情</a>

                </td>
              </tr>

          <?php } ?>
               <tr align ="left">
                    <td class="smallText" valign="top" colspan="5"><?php echo $commission_split->display_count($commission_res->RecordCount(), 20, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_RESULTS); ?></td>
                    <td class="smallText" align="right" colspan="7"><?php echo $commission_split->display_links($commission_res->RecordCount(), 20, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'orderby', 'id')) . 'orderby=' . $order_by); ?></td>
              </tr>
          </tr>
  </tr>
  </table>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>















