<?php

/**

 * @package admin

 * @copyright Copyright 2003-2006 Zen Cart Development Team

 * @copyright Portions Copyright 2003 osCommerce

 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0

 * @version $Id: customers.php 4280 2006-08-26 03:32:55Z drbyte $

 */



  require('includes/application_top.php');

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  $cID = zen_db_prepare_input($_GET['cID']);

  $error = false;

  $processed = false;

  $channel_status_array = array(
  		array('id' => 0 , 'text' => 'All') , 
  		array('id' => 10 , 'text' => '已激活') ,
  		array('id' => 20 , 'text' => '已享用') ,
  		array('id' => 30 , 'text' => '已过期') ,
  		array('id' => 40 , 'text' => '已关闭') 
  );
  
  if (zen_not_null($action)) {

    switch ($action) {
      case 'check_customer':
    		$error_info = array('is_error' => false , 'error_info' => '');
    		$customers_email= zen_db_prepare_input($_GET['customers_email']);
    		$customers = $db->Execute("select c.customers_id from ".TABLE_CUSTOMERS." c where c.customers_email_address = '".$customers_email."'");
    		
    		if($customers->RecordCount() > 0){
    			$channel = $db->Execute("select c.customers_id,c.customers_email_address,cn.create_time,channel_operator from ".TABLE_CHANNEL." cn ,".TABLE_CUSTOMERS." c where c.customers_id = cn.channel_customers_id and  cn.channel_customers_id = " . (int)$customers->fields['customers_id'] . " and channel_status in (10 , 20) ");
    			if($channel->RecordCount() > 0){
    				$error_info['is_error'] = true;
    				$error_info['error_info'] = '您所输入的邮箱已经存在于列表中';
    			}
    		}else{
    			$error_info['is_error'] = true;
    			$error_info['error_info'] = '系统中找不到该客户邮箱';
    		}
    		echo json_encode($error_info);
    		exit;
    		break;
	  case 'insert':
		     $error_message = '';
			 $customers_email= zen_db_prepare_input($_POST['customers_email']);
			 $customers = $db->Execute("select c.customers_id from ".TABLE_CUSTOMERS." c where c.customers_id = '".$customers_email."'");

			 if($customers->RecordCount() > 0){
				$channel = $db->Execute("select cn.create_time,channel_operator from ".TABLE_CHANNEL." cn where cn.channel_customers_id = " . (int)$customers->fields['customers_id'] . " and channel_status in (10 , 20) ");
				if($channel->RecordCount() > 0){
					$error_message = '您所输入的ID已经存在于列表中';
				}else{
					  $sql_data_array = array('channel_customers_id' => (int)$customers->fields['customers_id'],
						  		'channel_start_datetime' => 'now()',
						  		'channel_end_datetime' => date('Y-m-d H-i-s' , time() + 365*24*60*60),
                                'create_time' => 'now()',
                                'channel_operator' => $_SESSION['admin_id']
                               
                                );
					  
					  zen_db_perform(TABLE_CHANNEL, $sql_data_array);
					  zen_redirect(zen_href_link(FILENAME_CHANNEL, 'NONSSL'));

				}

			 }else{
				$error_message = '系统中找不到该客户ID';
			 }
			
			break;
//       case 'update':
// 			 $error_message = '';
// 			 $customers_email= zen_db_prepare_input($_POST['customers_email']);
// 			 $customers = $db->Execute("select c.customers_id from ".TABLE_CUSTOMERS." c where c.customers_email_address = '".$customers_email."'");

// 			 if($customers->RecordCount() > 0){
// 				$channel = $db->Execute("select c.customers_id,c.customers_email_address,cn.create_time,channel_operator from ".TABLE_CHANNEL." cn ,".TABLE_CUSTOMERS." c where c.customers_id = cn.channel_customers_id and  cn.channel_customers_id = " . (int)$customers->fields['customers_id'] . "");
// 				if($channel->RecordCount() > 0){
// 					$error_message = '您所输入的邮箱已经存在于列表中';
// 				}else{
// 					  $sql_data_array = array('channel_customers_id' => (int)$customers->fields['customers_id'],
// 					  			'channel_start_datetime' => 'now()',
// 					  			'channel_end_datetime' => 'date_sub(now(),interval -1 year)',
//                                 'modified_admin' => $_SESSION['admin_email'],
//                                 'date_modified' => 'now()'
                               
//                                 );
// 					  zen_db_perform(TABLE_CHANNEL, $sql_data_array,'update', "channel_id = '" . (int)$_POST['channel_id'] . "'");
// 					  zen_redirect(zen_href_link(FILENAME_CHANNEL, 'cID=' . $_GET['cID'] . (isset($_GET['page']) ? '&page=' . $_GET['page'] : ''), 'NONSSL'));

// 				}

// 			 }else{
// 				$error_message = '系统中找不到该客户邮箱';
// 			 }
			
// 			break;
        
		case 'delete':
			if($db->Execute("update ".TABLE_CHANNEL." set channel_status = 40 , modified_admin = '" . $_SESSION['admin_email'] . "' , date_modified = now() where channel_id = '" . (int)$_POST['channel_id'] . "'")){
				$messageStack->add_session('删除成功', 'success');
				zen_redirect(zen_href_link(FILENAME_CHANNEL, (isset($_GET['page']) ? '&page=' . $_GET['page'] : ''), 'NONSSL'));
				
			}

			
        break;

      default:
		if(isset($cID) && $cID > 0){
			$customers = $db->Execute("select c.customers_id,c.customers_email_address,cn.create_time,channel_operator,cn.channel_id,cn.create_time,cn.modified_admin,cn.date_modified from ".TABLE_CHANNEL." cn ,".TABLE_CUSTOMERS." c where c.customers_id = cn.channel_customers_id and   cn.channel_id = '" . (int)$cID . "' group by cn.channel_customers_id  ");
			
			$cInfo = new objectInfo($customers->fields);
		}
        

    }

  }

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
<script type="text/javascript" src="../includes/templates/cherry_zen/jscript/My97DatePicker/WdatePicker.js"></script>

<?php

  if ($action == 'edit' || $action == 'update' || $action == 'new') {

?>

<?php

  }

?>

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
  function process_json(data){
		var returnInfo=eval('('+data+')');
		return returnInfo;
	}
  
  function add_check(){
	var error = false;
	var customers_email = $("input[name=customers_email]").val();

	if(!(customers_email == null || customers_email == '')){
		$.ajax({
			type:"GET",
			url:"channel.php",
			data:{action:"check_customer" , customers_email:customers_email},
			async:false,
			success:function(data){
				var returnInfo = process_json(data);
				
				if(returnInfo.error == true){
					alert(returnInfo.error_info);
					error = true;
				}
			}
		});
	}else{
		alert("请输入客户ID");
		error = true;
	}
	
	return !error;

  }

</script>

</head>

<body onLoad="init()">

<!-- header //-->

<?php require(DIR_WS_INCLUDES . 'header.php'); ?>

<!-- header_eof //-->



<!-- body //-->

<table border="0" width="100%" cellspacing="2" cellpadding="2">

  <tr>

<!-- body_text //-->

    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">




<!--end-->

      <tr>

        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">

          <tr><?php echo zen_draw_form('search', FILENAME_CHANNEL, '', 'get', '', true); ?>

            <td class="pageHeading">特殊VIP管理</td>

            <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>

            <td class="smallText" align="right">
				<table border="0" width="100%" cellspacing="5" cellpadding="0">
					<tr><td align="right"><span>状态：</span><span><?php echo zen_draw_pull_down_menu('channel_status_search', $channel_status_array , ($_GET['channel_status_search'] ? $_GET['channel_status_search'] : 0))?></span></td></tr>
					<tr><td align="right"><span>搜索客户邮箱：</span><span><?php echo zen_draw_input_field('channel_customers_email' , ($_GET['channel_customers_email'] ? $_GET['channel_customers_email'] : ''))?></span></td></tr>
					<tr><td align="right"><span>通过添加时间筛选：</span>
					<span>
					<?php
						echo str_replace("<input","<input class='Wdate' style='width:125px;'",zen_draw_input_field('starttime', (isset($_GET['starttime']))?$_GET['starttime']: '', 'onClick="WdatePicker();"')) . '&nbsp;--';
					?>
					<?php
					    echo str_replace("<input","<input class='Wdate' style='width:125px;'",zen_draw_input_field('stoptime', (isset($_GET['stoptime']))?$_GET['stoptime']: '', 'onClick="WdatePicker();"  '))
					?>
					</span></td></tr>
					<tr><td align="right"><span><button type="submit">搜索</button></span></td></tr>
					<tr><td><span class="alert" id="search_error"></span></td></tr>
				</table>
            </td>

			<?php echo '</form>'?>
          </tr>

        </table></td>

      </tr>

      <tr>

        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">

          <tr>

<?php

// Sort Listing

          switch ($_GET['list_order']) {

              default:

              $disp_order = "cn.channel_id DESC";

          }

?>        
		

             <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
			<form action="<?php echo $_SERVER['REQUEST_URI'];?>" method='post' id="customerForm" onsubmit="return changeAction()">
              <tr class="dataTableHeadingRow">
              
              <td class="specialCustomerTable">
              <ul>
               

                <li class="dataTableHeadingContent customer_id" style="width:16%;" align="left" valign="top">

                  <?php echo '客户邮箱'; ?>

                </li>

				<li class="dataTableHeadingContent customer_id" style="width:16%;" align="center" valign="top">

                  <?php echo '添加时间'; ?>

                </li>
                
                <li class="dataTableHeadingContent customer_id" style="width:20%;" align="center" valign="top">

                  <?php echo '添加人'; ?>

                </li>

				<li class="dataTableHeadingContent customer_id" style="width:16%;" align="center" valign="top">

                  <?php echo '最后下单时间'; ?>

                </li>
                
                <li class="dataTableHeadingContent customer_id" style="width:16%;" align="center" valign="top">

                  <?php echo '状态'; ?>

                </li>

                <li class="dataTableHeadingContent customer_info" style="text-align: right;"><?php echo '操作'; ?>&nbsp;</li>
 				
</ul></td>
              </tr>

<?php
	$filter_str = '';
	if(isset($_GET['channel_status_search']) && $_GET['channel_status_search'] > 0){
		$filter_str .= ' and cn.channel_status = ' . (int)$_GET['channel_status_search'];
	}
 	if((isset($_GET['starttime']) && $_GET['starttime'] != '') &&(isset($_GET['stoptime']) && $_GET['stoptime'] != '')){
	    if($_GET['starttime'] <= $_GET['stoptime']){
		    $starttime = $_GET['starttime'];
		    $stoptime = $_GET['stoptime'];
		    	
		    $filter_str .= " and cn.create_time >= '".$starttime." 00:00:00' and cn.create_time  <= '".$stoptime." 23:59:59'";
	    }
	 }
	 if(isset($_GET['channel_customers_email']) && $_GET['channel_customers_email'] != ''){
	 	$customers_email = zen_db_prepare_input(trim($_GET['channel_customers_email']));
	 	$filter_str .= ' and c.customers_email_address like "%' . $customers_email . '%"';
	 }

    $customers_query_raw = " select c.customers_id,c.customers_email_address,cn.create_time,channel_operator,cn.channel_status,cn.channel_start_datetime,cn.channel_end_datetime,cn.channel_id,cn.create_time,cn.modified_admin,cn.date_modified from ".TABLE_CHANNEL." cn ,".TABLE_CUSTOMERS." c where  c.customers_id = cn.channel_customers_id " . $filter_str . " order by $disp_order";

//echo $customers_query_raw;exit;

// Split Page

// reset page when page is unknown
//echo $customers_query_raw;exit;
if (($_GET['page'] == '' or $_GET['page'] == '1') and $_GET['cID'] != '') {

  $check_page = $db->Execute($customers_query_raw);

  $check_count=1;

  if ($check_page->RecordCount() > MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER) {

    while (!$check_page->EOF) {

      if ($check_page->fields['channel_id'] == $_GET['cID']) {

        break;

      }

      $check_count++;

      $check_page->MoveNext();

    }

    $_GET['page'] = round((($check_count/MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER)+(fmod_round($check_count,MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER) !=0 ? .5 : 0)),0);

//    zen_redirect(zen_href_link(FILENAME_CUSTOMERS, 'cID=' . $_GET['cID'] . (isset($_GET['page']) ? '&page=' . $_GET['page'] : ''), 'NONSSL'));

  } else {

    $_GET['page'] = 1;

  }

}



    $customers_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER, $customers_query_raw, $customers_query_numrows);

    $customers = $db->Execute($customers_query_raw);

    while (!$customers->EOF) {
	 if ((!isset($_GET['cID']) || (isset($_GET['cID']) && ($_GET['cID'] == $customers->fields['channel_id']))) && !isset($cInfo)) {

        $cInfo = new objectInfo($customers->fields);
	 }
	 
	 switch ($customers->fields['channel_status']){
	 	case 10:
	 		$channel_status = '已激活';
 			break;
 		case 20:
 			$channel_status = '已享用';
 			break;
 		case 30:
 			$channel_status = '已过期';
 			break;
 		case 40:
 			$channel_status = '已关闭';
 			break;
	 }
	 if (isset($cInfo) && is_object($cInfo) && ($customers->fields['channel_id'] == $cInfo->channel_id)) {

        echo '          <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . "\n";

      } else {

        echo '          <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" >' . "\n";

      }
   
?>

<td class="specialCustomerTable">
<ul>
			

			<li class="dataTableContent customer_id" style="width:16%;" align="left" valign="top">

                  <?php echo $_SESSION['show_customer_email'] ? $customers->fields['customers_email_address'] : strstr($customers->fields['customers_email_address'], '@', true) . '@'; ?>

                </li>

				<li class="dataTableContent customer_id" style="width:16%;" align="center" valign="top">

                  <?php echo $customers->fields['create_time']; ?>

                </li>
                
                <li class="dataTableContent customer_id" style="width:20%;" align="center" valign="top">

                  <?php
					$admin = $db->Execute("select admin_email from " . TABLE_ADMIN . " where admin_id='" . $customers->fields['channel_operator'] . "' order by admin_id desc");
					if ($admin->RecordCount() != 0) {
						echo $admin->fields['admin_email'];
					} ?>

                </li>

				<li class="dataTableContent customer_id" style="width:16%;" align="center" valign="top">

                  <?php
				  $customers_orders = $db->Execute("select orders_id, date_purchased, order_total, currency, currency_value from " . TABLE_ORDERS . " where customers_id='" . $customers->fields['customers_id'] . "' order by date_purchased desc");	  
				  if($customers_orders->RecordCount() != 0){
					 echo $customers_orders->fields['date_purchased'];
				  }else{
					echo '无订单记录';
				  }
				  ?>

                </li>
                
                <li class="dataTableContent customer_id" style="width:16%;" align="center" valign="top">

                  <?php echo $channel_status; ?>

                </li>

                <li class="dataTableHeadingContent customer_info" style="text-align: right;">
				<?php if (isset($cInfo) && is_object($cInfo) && ($customers->fields['channel_id'] == $cInfo->channel_id)) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . zen_href_link(FILENAME_CHANNEL, zen_get_all_get_params(array('cID','action')) . 'cID=' . $customers->fields['channel_id'] . ($_GET['page'] > 0 ? '&page=' . $_GET['page'] : ''), 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</li>

               
				       				
</ul></td>
              </tr>

<?php

      $customers->MoveNext();

    }

?>

			<tr>
			
			<td align='right'><input onclick="location.href='<?php echo zen_href_link(FILENAME_CHANNEL,'action=new');?>'" type="button" style="height: 30px;width: 80px;" value='<?php echo '新建';?>'/></div></td>
			</tr>
			</form> 
              <tr>

                <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">

                  <tr>

                    <td class="smallText" valign="top"><?php echo $customers_split->display_count($customers_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_RESULTS); ?></td>

                    <td class="smallText" align="right"><?php echo $customers_split->display_links($customers_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'info', 'x', 'y', 'cID'))); ?></td>

                  </tr>

                </table></td>

              </tr>

            </table>
           
            </td>

<?php

// BOF Set variables for login_as_customer module



  $place_order_button = 'includes/languages/english/images/buttons/button_placeorder.gif';

  $login_as_customer = 'index.php?main_page=login_as_customer';

  if (ENABLE_SSL_CATALOG == 'true') {

$url = HTTPS_SERVER . DIR_WS_HTTPS_CATALOG;

} elseif (ENABLE_SSL_CATALOG == 'false') {

$url = HTTP_SERVER .  DIR_WS_CATALOG; 

}

  $p_url = $url;

  $p_url .= $login_as_customer;

//EOF Setf Variables for login_as_customer module

  $heading = array();

  $contents = array();



  switch ($action) {
      case 'new':

			$heading[] = array('text' => '<b>新建信息</b>');

			$contents = array('form' => zen_draw_form('channel', FILENAME_CHANNEL, zen_get_all_get_params(array('action')) .  'action=insert', 'post', '', true));
			$contents[] = array('text' => '<br />客户ID：');

			

			$contents[] = array('text' => '<br /><input style="margin-left: 10px;width: 250px;" type="text" name="customers_email"/>');

			$contents[] = array('text' => '<br /><input style="margin-left: 30px;height: 30px;width: 80px;" type="submit" value="确定" onclick="return add_check();"/>  <input onclick="location.href=\''.zen_href_link(FILENAME_CHANNEL).'\'" type="button" style="margin-left: 30px;height: 30px;width: 80px;" value="取消"/></form>');




			 break;
// 	  case 'edit':
// 		    if (isset($cInfo) && is_object($cInfo)) {
// 				$heading[] = array('text' => '<b>编辑信息</b>');

// 				$contents = array('form' => zen_draw_form('channel', FILENAME_CHANNEL, zen_get_all_get_params(array('action')) .  'action=update', 'post', '', true));
// 				$contents[] = array('text' => '<br />客户邮箱：');

				

// 				$contents[] = array('text' => '<br /><input style="margin-left: 10px;width: 250px;" type="text" name="customers_email" value="'. $cInfo->customers_email_address.'"/>');

// 				$contents[] = array('text' => '<input type="hidden" name="channel_id" value="'. $cInfo->channel_id.'"/>');

// 				$contents[] = array('text' => '<br /><input style="margin-left: 30px;height: 30px;width: 80px;" type="submit" value="确定"/>  <input onclick="location.href=\''.zen_href_link(FILENAME_CHANNEL).'\'" type="button" style="margin-left: 30px;height: 30px;width: 80px;" value="取消"/></form>');

// 			}

// 			 break;
	  
	  case 'update':
			
			if($error_message != ''){
				$heading[] = array('text' => '<b>编辑信息</b>');

				$contents = array('form' => zen_draw_form('channel', FILENAME_CHANNEL, zen_get_all_get_params(array('action')) .  'action=update', 'post', '', true));
				$contents[] = array('text' => '<br />客户ID：');

				

				$contents[] = array('text' => '<br /><input style="margin-left: 10px;width: 250px;" type="text" name="customers_email" value="'. $customers_email.'"/>');
				
				$contents[] = array('text' => '<p style="margin-left: 10px;color:red;">'.$error_message.'</p>');
				$contents[] = array('text' => '<input type="hidden" name="channel_id" value="'. $_POST['channel_id'].'"/>');

				$contents[] = array('text' => '<br /><input style="margin-left: 30px;height: 30px;width: 80px;" type="submit" value="确定"/>  <input onclick="location.href=\''.zen_href_link(FILENAME_CHANNEL).'\'" type="button" style="margin-left: 30px;height: 30px;width: 80px;" value="取消"/></form>');

			}else{

				if (isset($cInfo) && is_object($cInfo)) {
				$customers_orders = $db->Execute("select orders_id, date_purchased, order_total, currency, currency_value from " . TABLE_ORDERS . " where customers_id='" . $cInfo->customers_id . "' order by date_purchased desc");
				
				$heading[] = array('text' => '<b>编辑信息</b>');
				
				$contents[] = array('text' => '<br />客户邮箱： ' . $cInfo->customers_email_address);
				
				$contents[] = array('text' => '<br />添加时间: ' .$cInfo->create_time);
				
				if ($customers_orders->RecordCount() != 0) {

				  $contents[] = array('text' => '<br />最后下单时间： ' . $customers_orders->fields['date_purchased']);

				}
				
				$admin = $db->Execute("select admin_email from " . TABLE_ADMIN . " where admin_id='" . $cInfo->channel_operator . "' order by admin_id desc");
				if ($admin->RecordCount() != 0) {
					$contents[] = array('text' => '<br />添加人： ' . $admin->fields['admin_email']);
				}
				
				$contents[] = array('text' => '<br />添加时间： ' . $cInfo->fields['create_time']);
				if(!empty($cInfo->fields['modified_admin'])) {
					$contents[] = array('text' => '<br />修改人： ' . $cInfo->fields['modified_admin']);
				}
				if(!empty($admin->fields['date_modified'])) {
					$contents[] = array('text' => '<br />修改时间： ' . $cInfo->fields['date_modified']);
				}

			  }else{
				$heading[] = array('text' => '<b>编辑信息</b>');
				$contents[] = array('text' => '<br />暂无记录');
			  }
			 
			}
			break;

	  case 'insert':
			
			if($error_message != ''){
				$heading[] = array('text' => '<b>新建信息</b>');

				$contents = array('form' => zen_draw_form('channel', FILENAME_CHANNEL, zen_get_all_get_params(array('action')) .  'action=insert', 'post', '', true));
				$contents[] = array('text' => '<br />客户邮箱：');

				$contents[] = array('text' => '<br /><input style="margin-left: 10px;width: 250px;" type="text" name="customers_email" value="'.$customers_email.'"/>');

				$contents[] = array('text' => '<p style="margin-left: 10px;color:red;">'.$error_message.'</p>');

				$contents[] = array('text' => '<br /><input style="margin-left: 30px;height: 30px;width: 80px;" type="submit" value="确定"/>  <input onclick="location.href=\''.zen_href_link(FILENAME_CHANNEL).'\'" type="button" style="margin-left: 30px;height: 30px;width: 80px;" value="取消"/></form>');
			}else{

				if (isset($cInfo) && is_object($cInfo)) {
				$customers_orders = $db->Execute("select orders_id, date_purchased, order_total, currency, currency_value from " . TABLE_ORDERS . " where customers_id='" . $cInfo->customers_id . "' order by date_purchased desc");

				
				$heading[] = array('text' => '<b>编辑信息</b>');

				$contents[] = array('text' => '<br />客户邮箱： ' . $cInfo->customers_email_address);
				
				$contents[] = array('text' => '<br />添加时间: ' .$cInfo->create_time);
				
				if ($customers_orders->RecordCount() != 0) {

				  $contents[] = array('text' => '<br />最后下单时间： ' . $customers_orders->fields['date_purchased']);

				}
				
				$admin = $db->Execute("select admin_email from " . TABLE_ADMIN . " where admin_id='" . $cInfo->channel_operator . "' order by admin_id desc");
				if ($admin->RecordCount() != 0) {
					$contents[] = array('text' => '<br />添加人： ' . $admin->fields['admin_email']);
				}
				
				$contents[] = array('text' => '<br />添加时间： ' . $cInfo->create_time);
				if(!empty($cInfo->fields['modified_admin'])) {
					$contents[] = array('text' => '<br />修改人： ' . $cInfo->fields['modified_admin']);
				}
				if(!empty($admin->fields['date_modified'])) {
					$contents[] = array('text' => '<br />修改时间： ' . $cInfo->fields['date_modified']);
				}

			  }else{
				$heading[] = array('text' => '<b>编辑信息</b>');
				$contents[] = array('text' => '<br />暂无记录');
			  }
			 
			}
			break;

      case 'confirmdelete':
		  if (isset($cInfo) && is_object($cInfo)) {
				$heading[] = array('text' => '<b>删除信息</b>');

				$contents = array('form' => zen_draw_form('channel', FILENAME_CHANNEL, zen_get_all_get_params(array('action')) .  'action=delete', 'post', '', true));
				$contents[] = array('text' => '<br />确认要删除该客户吗？');

				$contents[] = array('text' => '<p style="margin-left: 10px;margin-top: 10px;font-weight: bold;">'.strstr($cInfo->customers_email_address, '@', true) . '@'.'</p>');
				
				$contents[] = array('text' => '<input type="hidden" name="channel_id" value="'. $cInfo->channel_id.'"/>');

				$contents[] = array('text' => '<br /><input style="margin-left: 80px;height: 30px;width: 60px;" type="submit" value="确定"/>  <input onclick="location.href=\''.zen_href_link(FILENAME_CHANNEL).'\'" type="button" style="margin-left: 15px;height: 30px;width: 60px;" value="取消"/></form>');		
		   }
      break;

    default:
      if (isset($cInfo) && is_object($cInfo)) {
      	switch ($cInfo->channel_status){
      		case 10:
      			$channel_status = '已激活';
      			break;
      		case 20:
      			$channel_status = '已享用';
      			break;
      		case 30:
      			$channel_status = '已过期';
      			break;
      		case 40:
      			$channel_status = '已关闭';
      			break;
      	}
        $customers_orders = $db->Execute("select orders_id, date_purchased, order_total, currency, currency_value from " . TABLE_ORDERS . " where customers_id='" . $cInfo->customers_id . "' order by date_purchased desc");

		
        $heading[] = array('text' => '<b>编辑信息</b>');

		$contents[] = array('text' => '<br />客户邮箱： ' . strstr($cInfo->customers_email_address, '@', true) . '@');
		
		$contents[] = array('text' => '<br />状态： ' . $channel_status);
		
		if ($customers_orders->RecordCount() != 0) {

          $contents[] = array('text' => '<br />最后下单时间： ' . $customers_orders->fields['date_purchased']);

        }
		
		$admin = $db->Execute("select admin_email from " . TABLE_ADMIN . " where admin_id='" . $cInfo->channel_operator . "' order by admin_id desc");
		if ($admin->RecordCount() != 0) {
			$contents[] = array('text' => '<br />添加人： ' . $admin->fields['admin_email']);
		}
		
		$contents[] = array('text' => '<br />添加时间： ' . $cInfo->create_time);
		$contents[] = array('text' => '<br />修改人： ' . ($cInfo->modified_admin ? $cInfo->modified_admin : '/'));
		$contents[] = array('text' => '<br />修改时间： ' . ($cInfo->date_modified ? $cInfo->date_modified: '/') );
		
		if(!empty($cInfo->channel_status) && $cInfo->channel_status != 40 && $cInfo->channel_status != 30){
			$contents[] = array('text' => '<br />
			<input onclick="location.href=\''.zen_href_link(FILENAME_CHANNEL, zen_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->channel_id . '&action=confirmdelete', 'NONSSL').'\'" type="button" style="margin-left: 30px;height: 30px;width: 80px;" value="禁用"/>');
		}
		
      }else{
		$heading[] = array('text' => '<b>编辑信息</b>');
		$contents[] = array('text' => '<br />暂无记录');
	  }
      break;

  }



  if ( (zen_not_null($heading)) && (zen_not_null($contents)) ) {

    echo '            <td width="25%" valign="top">' . "\n";



    $box = new box;

    echo $box->infoBox($heading, $contents);



    echo '            </td>' . "\n";

  }

?>

          </tr>

        </table></td>

      </tr>



    </table></td>

<!-- body_text_eof //-->

  </tr>

</table>


<!-- body_eof //-->



<!-- footer //-->

<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>

<!-- footer_eof //-->

<br>

</body>

</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>

