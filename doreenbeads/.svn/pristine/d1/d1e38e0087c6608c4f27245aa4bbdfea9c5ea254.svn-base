<?php

/**

 * delcare_orders.php

 * user define

 */


require('includes/application_top.php');
  
require(DIR_WS_CLASSES . 'currencies.php');

$currencies = new currencies();

include(DIR_WS_CLASSES . 'customers_group.php');
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$error = false;
switch ($action){
   case 'insert':
  		$customer_email = zen_db_prepare_input($_POST['customer_email']);
  		$cash_amount = zen_db_prepare_input($_POST['order_total']);
  		$currency_code = zen_db_prepare_input($_POST['currency_code']);
  		$notify_customer = zen_db_prepare_input($_POST['notify_customer']);
  		$comment = zen_db_prepare_input($_POST['comments']);
  		$creator = $_SESSION['admin_id'];
  		if (zen_not_null($customer_email)){
  			$customer_id_query = $db->Execute("select customers_id, customers_level from " . TABLE_CUSTOMERS . " where customers_email_address = '" . $customer_email . "'");
  			if ($customer_id_query->RecordCount() > 0){
  				$customer_id = $customer_id_query->fields['customers_id'];
  				$customer_level = $customer_id_query->fields['customers_level'];
  			} else {
  				$action='new';
  				$error = true;
  				$messageStack->add(TEXT_CUSTOMER_NOT_EXIST);  				
  			}
  		} else {
  			$action='new';
  			$error = true;
  			$messageStack->add(TEXT_CUSTOMER_EMAIL_REQUIRED);  			
  		}
  		
  		if (!is_numeric($cash_amount) || $cash_amount<=0){
  			$action='new';
  			$error = true;
  			 $messageStack->add(TEXT_CASH_AMOUNT_ERROR);  			
  		}
  		
  		if ($error == true){
  			//zen_redirect(zen_href_link(FILENAME_DECLARE_ORDERS));
		} else {
			$amount_dollar = zen_change_currency($cash_amount, $currency_code, 'USD');
  			$db->Execute("insert into " . TABLE_DECLARE_ORDERS . " (customer_id, currency_code, order_total,usd_order_total,creator, create_time, last_modify_time,comments)
  						  values (" . $customer_id . ", '" . zen_db_input($currency_code) . "', '" . zen_db_input($cash_amount). "', '" . zen_db_input($amount_dollar). "', '" . zen_db_input($creator) . "', '" . date('YmdHis') . "', '" . date('YmdHis'). "', '" . zen_db_input($comment) . "')");
			//update customer group
			$customers_group = new customers_group();
    		$new_group=$customers_group->correct_group($customer_id);
			if ($customer_level != 20) {
    			$customer_level = 20;
    			zen_change_customers_level($customer_id, $customer_level);
    		}
  			
  			//email notification
			if ($notify_customer == '1'){
				if($new_group>0){  				
  					$customer_info = $db->Execute('Select customers_firstname, customers_lastname, customers_email_address, customers_group_pricing, 
											   group_percentage, group_name
										  From ' . TABLE_CUSTOMERS . ', ' . TABLE_GROUP_PRICING . '
										 Where customers_group_pricing = group_id
										   
										   And customers_id = ' . (int)$customer_id);
				}else{
					$customer_info = $db->Execute('Select customers_firstname, customers_lastname, customers_email_address 											   
										  From ' . TABLE_CUSTOMERS . '
										 Where customers_id = ' . (int)$customer_id);
				}
				$order_total = $db->Execute('Select sum(value) as total
									   From ' . TABLE_ORDERS_TOTAL . ' as ot, ' . TABLE_ORDERS . " as o
									  Where ot.orders_id = o.orders_id
									    And class = 'ot_total'
									    And o.orders_status in (" . MODULE_ORDER_PAID_VALID_STATUS_ID_GROUP . ")
									    And o.customers_id = " . (int)$customer_id);
		
				$declare_total = $db->Execute('Select sum(usd_order_total) as d_total
									   From ' . TABLE_DECLARE_ORDERS ."
									  Where status>0 and customer_id = " . (int)$customer_id);
  				$total_amt = $order_total->fields['total'] + $declare_total->fields['d_total'];
  				$cash_amount_format = $currencies->format($cash_amount, false, $currency_code);
  					  				 
  				$subject_cash_amount_format = $cash_amount . $currency_code;
  				
  				$customer_name = $customer_info->fields['customers_firstname'] . ' ' . $customer_info->fields['customers_lastname'];
  				$email_subject =DECLARE_ORDER_NOTIFY_CUSTOMER_SUBJECT;
  				if($new_group>0){  			 				
  					$notify_email_text = $customer_name . "\n\n" . DECLARE_ORDER_NOTIFY_TOP_DESCRIPTION . "\n\n" .
	  					'<font color="#FF0000">' . $cash_amount_format . ' </font>'. DECLARE_ORDER_NOTIFY_CONTENTS . '\n\n============================<b>' .  "\n\n" . $comment . 
	  					'\n\n</b>============================' . "\n\n" . DECLARE_ORDER_NOTIFY_CONTENTS_1.$total_amt.DECLARE_ORDER_NOTIFY_CONTENTS_2.$customer_info->fields['group_name'].
  						DECLARE_ORDER_NOTIFY_CONTENTS_3.$customer_info->fields['group_percentage'].DECLARE_ORDER_NOTIFY_CONTENTS_4.DECLARE_ORDER_NOTIGY_BOTTOM_DESCRIPTION;
		  		
  					$html_msg['EMAIL_MESSAGE_HTML'] = 'Dear ' . $customer_name . ',<br /><br />'. 
		  				DECLARE_ORDER_NOTIFY_TOP_DESCRIPTION . '<strong>' .$cash_amount_format . '</strong>' . 
		  	    		DECLARE_ORDER_NOTIFY_CONTENTS. '<div style="width:540px;  #999999; border:1px  #999999 solid;"><b>' . $comment . '</b></div><br />' .
		        		DECLARE_ORDER_NOTIFY_CONTENTS_1. number_format($total_amt, 2).DECLARE_ORDER_NOTIFY_CONTENTS_2.$customer_info->fields['group_name'].DECLARE_ORDER_NOTIFY_CONTENTS_3.$customer_info->fields['group_percentage'].
		  	    		DECLARE_ORDER_NOTIFY_CONTENTS_4.DECLARE_ORDER_NOTIGY_BOTTOM_DESCRIPTION;
  					$html_msg['DECLARE_ORDER_NOTIFY_CONTENTS'] = $cash_amount_format . 
  						DECLARE_ORDER_NOTIFY_CONTENTS . '<div style="width:540px;  #999999; border:1px  #999999 solid;"><b>' . $comment . '</b></div><br />'.
  						DECLARE_ORDER_NOTIFY_CONTENTS_1.$total_amt.DECLARE_ORDER_NOTIFY_CONTENTS_2.$customer_info->fields['group_name'].DECLARE_ORDER_NOTIFY_CONTENTS_3.$customer_info->fields['group_percentage'].DECLARE_ORDER_NOTIFY_CONTENTS_4;
  				}else{
  					$notify_email_text = $customer_name . "\n\n" . DECLARE_ORDER_NOTIFY_TOP_DESCRIPTION . "\n\n" .
	  					'<font color="#FF0000">' . $cash_amount_format . ' </font>'. DECLARE_ORDER_NOTIFY_CONTENTS . '\n\n============================<b>' .  "\n\n" . $comment . '<br/>Click here to see your account informations>> <a href="' . HTTP_SERVER .'/index.php?main_page=account' . '">My Account</a>.<br/><br/>'.
	  					'\n\n</b>============================' . "\n\n" . DECLARE_ORDER_NOTIFY_CONTENTS_1.$total_amt.'</b>.'.
  						DECLARE_ORDER_NOTIGY_BOTTOM_DESCRIPTION;
		  		
  					$html_msg['EMAIL_MESSAGE_HTML'] = 'Dear ' . $customer_name . ',<br /><br />'. 
		  				DECLARE_ORDER_NOTIFY_TOP_DESCRIPTION . '<strong>' .$cash_amount_format . '</strong>' . 
		  	    		DECLARE_ORDER_NOTIFY_CONTENTS. '<div style="width:540px;  #999999; border:1px  #999999 solid;"><b>' . $comment . '</b></div><br />' .
		        		DECLARE_ORDER_NOTIFY_CONTENTS_1. number_format($total_amt, 2).'</b>.<br/>Click here to see your account informations>> <a href="' . HTTP_SERVER .'/index.php?main_page=account' . '">My Account</a>.<br/><br/>'.
		  	    		DECLARE_ORDER_NOTIGY_BOTTOM_DESCRIPTION;
		  	    		
		  	    	$html_msg['DECLARE_ORDER_NOTIFY_CONTENTS'] = $cash_amount_format . 
  						DECLARE_ORDER_NOTIFY_CONTENTS . '<div style="width:540px;  #999999; border:1px  #999999 solid;"><b>' . $comment . '</b></div><br />'.
  						DECLARE_ORDER_NOTIFY_CONTENTS_1.$total_amt.'</b>.<br/>Click here to see your account informations>> <a href="' . HTTP_SERVER .'/index.php?main_page=account' . '">My Account</a>.<br/><br/>';
  				}		
  				$html_msg['DECLARE_ORDER_NOTIFY_CUSTOMER_NAME'] = $customer_name . ',<br /><br />';
  				$html_msg['DECLARE_ORDER_NOTIFY_TOP_DESCRIPTION'] = DECLARE_ORDER_NOTIFY_TOP_DESCRIPTION;   						
  				
  				$html_msg['DECLARE_ORDER_NOTIGY_BOTTOM_DESCRIPTION'] = DECLARE_ORDER_NOTIGY_BOTTOM_DESCRIPTION;
  				  				  				
  				zen_mail($customer_name, $customer_email, $email_subject, $notify_email_text, STORE_NAME, EMAIL_FROM, $html_msg, 'declare_order_notify');
  			}
  			   		  			
  			$messageStack->add_session(TEXT_DECLARE_ORDER_ADD_SUCCESSED, 'success');
  			zen_redirect(zen_href_link(FILENAME_DECLARE_ORDERS, 'page=' . $_GET['page']));
  		}
  	break;
  	

  	case 'deleteconfirm':

  		if (zen_admin_demo()){
  			$_GET['action'] = '';
  			$messageStack->add_session(ERROR_ADMIN_DEMO, 'caution');
  			zen_href_link(FILENAME_DECLARE_ORDERS, 'page=' . $_GET['page']);
  		}

  		$declare_order_id = zen_db_prepare_input($_GET['cID']);
		$customer_id_query = $db->Execute("select customer_id, status from " . TABLE_DECLARE_ORDERS . " where declare_orders_id = " . (int)$declare_order_id);
    	$customer_id = $customer_id_query->fields['customer_id'];
    	$order_status = $customer_id_query->fields['status'];
    	if($order_status > 0){
  			$db->Execute("update " . TABLE_DECLARE_ORDERS . "
						set status=0
					   where declare_orders_id = " . (int)$declare_order_id);
  		  		
  			$customers_group = new customers_group();
    		$customers_group->correct_group($customer_id);
    	}
  		zen_redirect(zen_href_link(FILENAME_DECLARE_ORDERS, 'page=' . $_GET['page']));

  	break;

  	
  	case 'save':

  		$declare_order_id = zen_db_prepare_input($_GET['cID']);
  		$cash_amount = zen_db_prepare_input($_POST['order_total']);
  		$currency_code = zen_db_prepare_input($_POST['currency_code']);
  		$comment = zen_db_prepare_input($_POST['comments']);
  		
  		if (!is_numeric($cash_amount) || $cash_amount<=0){
  			$error = true;
  			$messageStack->add_session(TEXT_CASH_AMOUNT_ERROR);

  		}
  		
  		if ($error == true){
  			zen_redirect(zen_href_link(FILENAME_DECLARE_ORDERS, 'page=' . $_GET['page']));

  		} else {
			$amount_dollar = zen_change_currency($cash_amount, $currency_code, 'USD');
  			$customer_id_query = $db->Execute("select customer_id, status from " . TABLE_DECLARE_ORDERS . " where declare_orders_id = " . (int)$declare_order_id);
    		$customer_id = $customer_id_query->fields['customer_id'];
    		$order_status = $customer_id_query->fields['status'];
  			$db->Execute("update " . TABLE_DECLARE_ORDERS . "
  							 set order_total = '" . zen_db_input($cash_amount) . "',
  							 	 usd_order_total = '" . zen_db_input($amount_dollar) . "',
  							 	 currency_code = '" . zen_db_input($currency_code) . "',							 
  							 	 last_modify_time = '" . date('YmdHis') . "',
  							 	 comments = '". zen_db_input($comment) . "' 							 
  						   where declare_orders_id = " . (int)$declare_order_id);
 			if($order_status > 0){
  				$customers_group = new customers_group();
    			$customers_group->correct_group($customer_id);
 			}  			
  			zen_redirect(zen_href_link(FILENAME_DECLARE_ORDERS, 'page=' . $_GET['page']));
  		}
  }

  //���û���
  if (isset($currencies) && is_object($currencies)){
  	reset($currencies->currencies);
  	$currencies_array = array();
  	while (list($key, $value) = each($currencies->currencies)) {
        $currencies_array[] = array('id' => $key, 'text' => $value['title']);
    }
  }

  if (isset($_GET['email']) && $_GET['email'] != ''){
  	$email = zen_db_prepare_input($_GET['email']);
  	$filter_email = " and c.customers_email_address = '" . $email . "'";
  } else {
 	$email = '';
  	$filter_email = '';
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
<script type="text/javascript">

  <!--

  function init() {
    cssjsmenu('navbar');
    if (document.getElementById) {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }

  }

  // -->

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
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="" align="right">

            <?php
              echo zen_draw_form('declare_order', FILENAME_DECLARE_ORDERS, '', 'get');
              echo 'Search: ' . zen_draw_input_field('email');
            ?>
            </form>
            </td>
          </tr>
        </table>
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
		  <tr>
		    <td><?php echo TEXT_STATUS_DESCRIPTION; ?></td>
		  </tr>
		</table>
		</td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" align="left" style="padding:5px 3px;width:15%;"><?php echo TABLE_HEADING_CUSTOMER_ID; ?></td>
                <td class="dataTableHeadingContent" align="left" style="padding:5px 3px;width:25%;"><?php echo TABLE_HEADING_CUSTOMER_EMAIL; ?></td>                
                <td class="dataTableHeadingContent" align="left" style="padding:5px 3px;width:20%;"><?php echo TABLE_HEADING_CASH_AMOUNT; ?></td>
                <td class="dataTableHeadingContent" align="left" style="padding:5px 3px;width:20%;"><?php echo TABLE_HEADING_CREATE_DATE; ?></td>              
                <td class="dataTableHeadingContent" align="center" style="padding:5px 3px; width:10%;"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right" style="width:10%;"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>

<?php

  $declare_order_query = "select do.declare_orders_id, do.customer_id, c.customers_email_address, do.currency_code, do.order_total,do.create_time,
  							do.creator, do.last_modify_time, do.comments, do.status
  						   from " . TABLE_DECLARE_ORDERS . " as do, " . TABLE_CUSTOMERS . " as c
  						  where do.customer_id = c.customers_id " . $filter_email . " order by do.create_time DESC";

  $declare_order_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $declare_order_query, $declare_order_numrows);
  $declare_order = $db->Execute($declare_order_query);

  while (!$declare_order->EOF) {
    if ((!isset($_GET['cID']) || (isset($_GET['cID']) && ($_GET['cID'] == $declare_order->fields['declare_orders_id']))) && !isset($cInfo) && (substr($action, 0, 3) != 'new')) {
      $cInfo = new objectInfo($declare_order->fields);
    }

    $status_pic = '';

    if ($declare_order->fields['status'] == '1'){
    	$status_pic = zen_image(DIR_WS_IMAGES . 'icon_status_green.gif', 'Active');
    }  elseif ($declare_order->fields['status'] == '0'){
    	$status_pic = zen_image(DIR_WS_IMAGES . 'icon_status_red.gif', 'Deleted');
    }
    
    if (isset($cInfo) && is_object($cInfo) && ($declare_order->fields['declare_orders_id'] == $cInfo->declare_orders_id)) {
      echo '                  <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_DECLARE_ORDERS, 'page=' . $_GET['page'] . '&cID=' . $cInfo->declare_orders_id . '&action=edit' . (($email != '') ? '&email=' . $email : '')) . '\'">' . "\n";

    } else {
      echo '                  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_DECLARE_ORDERS, 'page=' . $_GET['page'] . '&cID=' . $declare_order->fields['declare_orders_id'] . (($email != '') ? '&email=' . $email : '')) . '\'">' . "\n";

    }

?>
                <td class="dataTableContent" style="padding:5px 3px;"><?php echo $declare_order->fields['customer_id']; ?></td>              
                <td class="dataTableContent" style="padding:5px 3px;"><?php echo ($_SESSION['show_customer_email'] ? $declare_order->fields['customers_email_address'] : strstr($declare_order->fields['customers_email_address'], '@', true) . '@'); ?></td>                
                <td class="dataTableContent" style="padding:5px 3px;"><?php echo $currencies->format($declare_order->fields['order_total'], false, $declare_order->fields['currency_code']); ?></td>                
                <td class="dataTableContent" style="padding:5px 3px;"><?php echo $declare_order->fields['create_time']; ?></td>
                <td class="dataTableContent" align="center" style="padding:5px 3px;"><?php echo $status_pic; ?></td>
                <td class="dataTableContent" align="right"><?php if (isset($cInfo) && is_object($cInfo) && ($declare_order->fields['declare_orders_id'] == $cInfo->declare_orders_id) ) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . zen_href_link(FILENAME_DECLARE_ORDERS, 'page=' . $_GET['page'] . '&cID=' . $declare_order->fields['declare_orders_id']) . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>                
              </tr>

<?php
    $declare_order->MoveNext();
  }

?>
              <tr>

                <td colspan="8"><table border="0" width="100%" cellspacing="0" cellpadding="2">

                  <tr>
                    <td class="smallText" valign="top"><?php echo $declare_order_split->display_count($declare_order_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_DECLARE_ORDER); ?></td>
                    <td class="smallText" align="right"><?php echo $declare_order_split->display_links($declare_order_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>

<?php

  if (empty($action)) {

?>

                  <tr>
                    <td colspan="2" align="right"><?php echo '<a href="' . zen_href_link(FILENAME_DECLARE_ORDERS, 'page=' . $_GET['page'] . '&action=new') . '">' . zen_image_button('button_insert.gif', IMAGE_INSERT) . '</a>'; ?></td>
                  </tr>

<?php

  }

?>

                </table></td>

              </tr>

            </table></td>

<?php

  $heading = array();
  $contents = array();
 

  switch ($action) {

    case 'new':

      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_DECLARE_ORDER . '</b>');
      $contents = array('form' => zen_draw_form('declare_order', FILENAME_DECLARE_ORDERS, 'page=' . $_GET['page'] . '&action=insert'));
      $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);
      $contents[] = array('text' => '<br>' . TEXT_INFO_CUSTOMER_EMAIL . '<br>' . zen_draw_input_field('customer_email'));
      $contents[] = array('text' => '<br>' . TEXT_INFO_CASH_AMOUNT . '<br>' . zen_draw_input_field('order_total'));
      $contents[] = array('text' => '<br>' . TEXT_INFO_CURRENCY_CODE . '<br>' . zen_draw_pull_down_menu('currency_code', $currencies_array));
      $contents[] = array('text' => '<br>' . TEXT_INFO_NOTIFY_CUSTOMER . ' ' . zen_draw_checkbox_field('notify_customer', '1', true));
      $contents[] = array('text' => '<br>' . TEXT_INFO_COMMENTS . '<br>' . zen_draw_textarea_field('comments', '', '20', '5', ''));
      $contents[] = array('align' => 'center', 'text' => '<br>' . zen_image_submit('button_insert.gif', IMAGE_INSERT) . '&nbsp;<a href="' . zen_href_link(FILENAME_DECLARE_ORDERS, 'page=' . $_GET['page']) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;

    case 'edit':

      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_DECLARE_ORDER . '</b>');

      $contents = array('form' => zen_draw_form('declare_order', FILENAME_DECLARE_ORDERS, 'page=' . $_GET['page'] . '&cID=' . $cInfo->declare_orders_id . '&action=save'. (($email != '') ? '&email=' . $email : '')));
      $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
      $contents[] = array('text' => '<br>' . TEXT_INFO_CUSTOMER_EMAIL . '<br><b>' . ($_SESSION['show_customer_email'] ? $cInfo->customers_email_address : strstr($cInfo->customers_email_address, '@', true) . '@') . '</b>');
      $contents[] = array('text' => '<br>' . TEXT_INFO_CASH_AMOUNT . '<br>' . zen_draw_input_field('order_total', $cInfo->order_total));
      $contents[] = array('text' => '<br>' . TEXT_INFO_CURRENCY_CODE . '<br>' . zen_draw_pull_down_menu('currency_code', $currencies_array, $cInfo->currency_code));      
      $contents[] = array('text' => '<br>' . TEXT_INFO_COMMENTS . '<br>' . zen_draw_textarea_field('comments', '', '20', '5', $cInfo->comments));
      $contents[] = array('align' => 'center', 'text' => '<br>' . zen_image_submit('button_update.gif', IMAGE_UPDATE) . '&nbsp;<a href="' . zen_href_link(FILENAME_DECLARE_ORDERS, 'page=' . $_GET['page'] . '&cID=' . $cInfo->declare_orders_id) . (($email != '') ? '&email=' . $email : '') . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');

      break;

    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_DECLARE_ORDER . '</b>');

      $contents = array('form' => zen_draw_form('declare_order', FILENAME_DECLARE_ORDERS, 'page=' . $_GET['page'] . '&cID=' . $cInfo->declare_orders_id . '&action=deleteconfirm'. (($email != '') ? '&email=' . $email : '')));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br><b>' . ($_SESSION['show_customer_email'] ? $cInfo->customers_email_address : strstr($cInfo->customers_email_address, '@', true) . '@') . '</b>');
      $contents[] = array('text' => '<br>' . TEXT_INFO_CASH_AMOUNT . ' <b>' .$currencies->format($cInfo->order_total, false, $cInfo->currency_code) . '</b>');
      $contents[] = array('align' => 'center', 'text' => '<br>' . zen_image_submit('button_delete.gif', IMAGE_UPDATE) . '&nbsp;<a href="' . zen_href_link(FILENAME_DECLARE_ORDERS, 'page=' . $_GET['page'] . '&cID=' . $cInfo->declare_orders_id) . (($email != '') ? '&email=' . $email : '') . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');

      break;

    default:
      if (is_object($cInfo)) {
        $heading[] = array('text' => '<b>' . $cInfo->customers_email_address . '</b>');
        $contents[] = array('align' => 'center', 'text' => '<a href="' . zen_href_link(FILENAME_DECLARE_ORDERS, 'page=' . $_GET['page'] . '&cID=' . $cInfo->declare_orders_id . '&action=edit'. (($email != '') ? '&email=' . $email : '')) . '">' . zen_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . zen_href_link(FILENAME_DECLARE_ORDERS, 'page=' . $_GET['page'] . '&cID=' . $cInfo->declare_orders_id . '&action=delete'. (($email != '') ? '&email=' . $email : '') ) . '">' . zen_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');      
        $contents[] = array('text' => '<br>' . TEXT_INFO_CUSTOMER_EMAIL . '<br><b>' . ($_SESSION['show_customer_email'] ? $cInfo->customers_email_address : strstr($cInfo->customers_email_address, '@', true) . '@') . '</b>');        
        $contents[] = array('text' => '<br>' . TEXT_INFO_CASH_AMOUNT . ' <b>' . $currencies->format($cInfo->order_total, false, $cInfo->currency_code) . '</b>');           
        $contents[] = array('text' => '<br>' . TEXT_INFO_CREATOR . ' <b>' . zen_get_admin_name($cInfo->creator) . '</b>');
        $contents[] = array('text' => '<br>' . TEXT_INFO_CREATE_DATE . ' <br><b>' . $cInfo->create_time . '</b>');     
        $contents[] = array('text' => '<br>' . TEXT_INFO_MODIFY_DATE . ' <br><b>' . $cInfo->last_modify_time . '</b>');
        $contents[] = array('text' => '<br>' . TEXT_INFO_COMMENTS . ' <br><b>' . $cInfo->comments . '</b>');
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

  </tr>

</table>


<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>

<br>

</body>

</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>