<?php

/**

 * cash_account.php

 * user define

 */
  require('includes/application_top.php');
  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();  
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  $error = false;
  switch ($action){
  	case 'insert':
  		$customer_id = zen_db_prepare_input($_POST['customer_id']);
  		$cash_amount = zen_db_prepare_input($_POST['cash_amount']);
  		$currency_code = zen_db_prepare_input($_POST['currency_code']);

  		$status = 'A';
  		$creator = $_SESSION['admin_id'];
  		$memo = zen_db_prepare_input($_POST['memo']);
  		$notify_customer = zen_db_prepare_input($_POST['notify_customer']);
  		
  		if (zen_not_null($customer_id)){
  			$customer_id_query = $db->Execute("select customers_id, customers_email_address from " . TABLE_CUSTOMERS . " where customers_id = '" . $customer_id . "'");
  			if ($customer_id_query->RecordCount() > 0){
  				$customer_email = $customer_id_query->fields['customers_email_address'];
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
  		
  		if (!is_numeric($cash_amount)){
  			$action='new';
  			$error = true;
  			 $messageStack->add(TEXT_CASH_AMOUNT_ERROR);
  		} else {
			$amount_dollar = zen_change_currency($cash_amount, $currency_code, 'USD');
			if ($amount_dollar > CASH_AMOUNT_MAX || $amount_dollar<CASH_AMOUNT_MIN){
				$action='new';
				$error = true;
				$messageStack->add_session(sprintf(TEXT_CASH_AMOUNT_EXCEED,CASH_AMOUNT_MIN, CASH_AMOUNT_MAX));				
			}
  		}
  		
  		if ($error == true){
			} else {
  			$db->Execute("insert into " . TABLE_CASH_ACCOUNT . " (cac_customer_id, cac_amount, cac_currency_code, cac_creator, cac_create_date, cac_who_modify, cac_modify_date, cac_status, cac_memo) values (" . $customer_id . ", '" . round(floatval($cash_amount), 2) . "', '".$currency_code."', '" . zen_db_input($creator) . "', '" . date('YmdHis') . "', 'NULL', '" . date('YmdHis') . "', '" . zen_db_input($status) . "', '" . zen_db_input($memo) . "')");

  			if ($notify_customer == '1'){
  				$customer_info_query = "select customers_firstname, customers_lastname,customers_gender
  									      from " . TABLE_CUSTOMERS . "
  									     where customers_id = " . $customer_id;
  				$customer_info = $db->Execute($customer_info_query);  				
  				if ($cash_amount > 0){
  					$subject_cash_amount_format = $currency_code . ' ' . $cash_amount;
  					$cash_amount_format = $currencies->format($cash_amount, false, $currency_code); 					
  				} else {
  					$subject_cash_amount_format = '-' . $currency_code . ' ' . abs($cash_amount);
  					$cash_amount_format = '-' . $currencies->format(abs($cash_amount), false, $currency_code);
  				}
  				
  				
  				$customer_name = $customer_info->fields['customers_firstname'] . ' ' . $customer_info->fields['customers_lastname'];
  				$email_subject = $subject_cash_amount_format . CASH_ACCOUNT_NOTIFY_CUSTOMER_SUBJECT;
  				//by zhouliang
  				if ($cash_amount < 0){
  					$email_subject = $subject_cash_amount_format . CASH_ACCOUNT_NOTIFY_CUSTOMER_SUBJECT1;
  				}
  				//end

         		 $html_msg['EMAIL_MESSAGE_HTML'] = sprintf(CASH_ACCOUNT_NOTIFY_TOP_DESCRIPTION, $customer_name, $subject_cash_amount_format, $subject_cash_amount_format, $memo) . "\n\n";

  				/*if($_SESSION['languages_id']==3){
  					if($customer_info->fields['customers_gender']=='f'){
  						$hellto='Дорогая ';
  					}else{
  						$hellto='Дорогой ';
  					}
  					$html_msg['EMAIL_MESSAGE_HTML'] = $hellto.' ' . $customer_name . ',<br /><br />'.
  							CASH_ACCOUNT_NOTIFY_TOP_DESCRIPTION . '<br /><br>Во-вторых, здесь я хочу сообщить, что из-за вашей предыдущей покупки, мы кредитовали <font color="#FF0000">' . $subject_cash_amount_format .
  							' </font>'. CASH_ACCOUNT_NOTIFY_CONTENTS . '<div style="width:540px;  #999999; border:1px  #999999 solid;"><b>' . $memo . '</b></div><br />' .
  							CASH_ACCOUNT_NOTIGY_BOTTOM_DESCRIPTION;
  				}else if($_SESSION['languages_id']==4){
  					$html_msg['EMAIL_MESSAGE_HTML'] = 'Bonjour ' . $customer_name . ',<br /><br />'.
  							CASH_ACCOUNT_NOTIFY_TOP_DESCRIPTION . '<br />Secondly, A la suite de votre dernière commande, nous avons remboursé <font color="#FF0000">' . $subject_cash_amount_format .
  							' </font>'. CASH_ACCOUNT_NOTIFY_CONTENTS . '<div style="width:540px;  #999999; border:1px  #999999 solid;"><b>' . $memo . '</b></div><br />' .
  							CASH_ACCOUNT_NOTIGY_BOTTOM_DESCRIPTION;
  				}else if($_SESSION['languages_id']==5){
  					$html_msg['EMAIL_MESSAGE_HTML'] = 'Estimado(a) ' . $customer_name . ',<br /><br />'.
  							CASH_ACCOUNT_NOTIFY_TOP_DESCRIPTION . '<br />En segundo lugar, quiero informarle que debido a su pedido anterior, le hemos areditado <font color="#FF0000">' . $subject_cash_amount_format .
  							' </font>'. CASH_ACCOUNT_NOTIFY_CONTENTS . '<div style="width:540px;  #999999; border:1px  #999999 solid;"><b>' . $memo . '</b></div><br />' .
  							CASH_ACCOUNT_NOTIGY_BOTTOM_DESCRIPTION;
  				}else if($_SESSION['languages_id']==2){
  					$html_msg['EMAIL_MESSAGE_HTML'] = 'Hallo ' . $customer_name . ',<br /><br />'.
  							CASH_ACCOUNT_NOTIFY_TOP_DESCRIPTION . '<br />Zweitens, hier möchte ich mitteilen, dass wir <font color="#FF0000">' . $subject_cash_amount_format .
  							' </font>'. CASH_ACCOUNT_NOTIFY_CONTENTS . '<div style="width:540px;  #999999; border:1px  #999999 solid;"><b>' . $memo . '</b></div><br />' .
  							CASH_ACCOUNT_NOTIGY_BOTTOM_DESCRIPTION;
  				}else if($_SESSION['languages_id']==6){
  					$html_msg['EMAIL_MESSAGE_HTML'] =  $customer_info->fields['customers_lastname'] . ' 様<br /><br />'.
  							CASH_ACCOUNT_NOTIFY_TOP_DESCRIPTION  .
  							sprintf(CASH_ACCOUNT_NOTIFY_CONTENTS, $subject_cash_amount_format) . '<div style="width:540px;  #999999; border:1px  #999999 solid;"><b>' . $memo . '</b></div><br />' .
  							CASH_ACCOUNT_NOTIGY_BOTTOM_DESCRIPTION;
  				}else if($_SESSION['languages_id']==7){
  					$html_msg['EMAIL_MESSAGE_HTML'] = 'Caro(a) ' . $customer_name . ',<br /><br />'.
  							CASH_ACCOUNT_NOTIFY_TOP_DESCRIPTION  .
  							sprintf(CASH_ACCOUNT_NOTIFY_CONTENTS, $subject_cash_amount_format) . '<div style="width:540px;  #999999; border:1px  #999999 solid;"><b>' . $memo . '</b></div><br />' .
  							CASH_ACCOUNT_NOTIGY_BOTTOM_DESCRIPTION;
  				}else{
  					$html_msg['EMAIL_MESSAGE_HTML'] = 'Dear ' . $customer_name . ',<br /><br />'.
  							CASH_ACCOUNT_NOTIFY_TOP_DESCRIPTION . '<br />Secondly, here I want to let you know that due to your previous purchase,we have credited <font color="#FF0000">' . $subject_cash_amount_format .
  							' </font>'. CASH_ACCOUNT_NOTIFY_CONTENTS . '<div style="width:540px;  #999999; border:1px  #999999 solid;"><b>' . $memo . '</b></div><br />' .
  							CASH_ACCOUNT_NOTIGY_BOTTOM_DESCRIPTION;
  				}
		  		
		        //by zhouliang
  				if ($cash_amount < 0){
  					
					if($_SESSION['languages_id']==3){
	  					if($customer_info->fields['customers_gender']=='f'){
	  						$hellto='Дорогая ';
	  					}else{
	  						$hellto='Дорогой ';
	  					}
	  					$html_msg['EMAIL_MESSAGE_HTML'] = $hellto.' ' . $customer_name . ',<br /><br />';
	  				}else if($_SESSION['languages_id']==4){
	  					$html_msg['EMAIL_MESSAGE_HTML'] = 'Bonjour ' . $customer_name . ',<br /><br />';
	  				}else if($_SESSION['languages_id']==5){
	  					$html_msg['EMAIL_MESSAGE_HTML'] = 'Estimado(a) ' . $customer_name . ',<br /><br />';
	  				}else if($_SESSION['languages_id']==2){
	  					$html_msg['EMAIL_MESSAGE_HTML'] = 'Hallo ' . $customer_name . ',<br /><br />';
	  				}else if($_SESSION['languages_id']==6){
	  					$html_msg['EMAIL_MESSAGE_HTML'] =  $customer_info->fields['customers_lastname'] . ' 様<br /><br />';
	  				}else if($_SESSION['languages_id']==7){
	  					$html_msg['EMAIL_MESSAGE_HTML'] = 'Caro(a) ' . $customer_name . ',<br /><br />';
	  				}else{
	  					$html_msg['EMAIL_MESSAGE_HTML'] = 'Dear ' . $customer_name . ',<br /><br />';
	  				}
	  				
	  				$html_msg['EMAIL_MESSAGE_HTML'] .= CASH_ACCOUNT_NOTIFY_TOP_DESCRIPTION1 . '<br />' . sprintf(CASH_ACCOUNT_NOTIFY_CONTENTS1,  $subject_cash_amount_format) . '<div style="width:540px;  #999999; border:1px  #999999 solid;"><b>' . $memo . '</b></div><br />' .
  								CASH_ACCOUNT_NOTIGY_BOTTOM_DESCRIPTION;
  				}
  				//end
  				$html_msg['CASH_ACCOUNT_NOTIFY_CUSTOMER_NAME'] = $customer_name . ',<br /><br />';
  				$html_msg['CASH_ACCOUNT_NOTIFY_TOP_DESCRIPTION'] = CASH_ACCOUNT_NOTIFY_TOP_DESCRIPTION;   						
  				$html_msg['CASH_ACCOUNT_NOTIFY_CONTENTS'] = '<b>Now due to your previous purchase,we have credited <font color="#FF0000">' . $subject_cash_amount_format . 
  				' </font>'. CASH_ACCOUNT_NOTIFY_CONTENTS . '<div style="width:540px;  #999999; border:1px  #999999 solid;"><b>' . $memo . '</b></div><br />';
  				$html_msg['CASH_ACCOUNT_NOTIGY_BOTTOM_DESCRIPTION'] = CASH_ACCOUNT_NOTIGY_BOTTOM_DESCRIPTION;
  				//by zhouliang
  				if ($cash_amount < 0){
  					$html_msg['CASH_ACCOUNT_NOTIFY_TOP_DESCRIPTION'] = CASH_ACCOUNT_NOTIFY_TOP_DESCRIPTION1; 
  					$html_msg['CASH_ACCOUNT_NOTIFY_CONTENTS'] = '<br />' . sprintf(CASH_ACCOUNT_NOTIFY_CONTENTS1,  $subject_cash_amount_format) . '<div style="width:540px;  #999999; border:1px  #999999 solid;"><b>' . $memo . '</b></div><br />';
  				$html_msg['CASH_ACCOUNT_NOTIGY_BOTTOM_DESCRIPTION'] = CASH_ACCOUNT_NOTIGY_BOTTOM_DESCRIPTION;
  				}*/
  				//$html_msg['EMAIL_DISCLAIMER']=sprintf(EMAIL_DISCLAIMER,'<a href="mailto:'.$order_status_config[($_SESSION['languages_id']-1)]['EMAIL_NOTIFICATIONS_FROM'].'">'.$order_status_config[($_SESSION['languages_id']-1)]['EMAIL_NOTIFICATIONS_FROM'].'</a>');
  				//end
   				/*echo "<pre>";
   				print_r($html_msg);
   				echo "</pre>";exit;*/
  				//zen_mail($customer_name, $customer_email, $email_subject, $notify_email_text, $order_status_config[($_SESSION['languages_id']-1)]['STORE_NAME'], $order_status_config[($_SESSION['languages_id']-1)]['EMAIL_NOTIFICATIONS_FROM'], $html_msg, 'cash_account_notify');
          // var_dump($email_subject);exit;
				zen_mail($customer_name, $customer_email, $email_subject, $notify_email_text, STORE_NAME, EMAIL_FROM, $html_msg, 'cash_account_notify');
  			}

  			$messageStack->add_session(TEXT_CASH_ACCOUNT_ADD_SUCCESSED, 'success');

  			zen_redirect(zen_href_link(FILENAME_CASH_ACCOUNT));

  		}

  	break;  	
  	case 'deleteconfirm':
  		if (zen_admin_demo()){

  			$_GET['action'] = '';

  			$messageStack->add_session(ERROR_ADMIN_DEMO, 'caution');

  			zen_href_link(FILENAME_CASH_ACCOUNT, 'page=' . $_GET['page']);

  		}
  		$cash_account_id = zen_db_prepare_input($_GET['cID']);

  		$db->Execute("update " . TABLE_CASH_ACCOUNT . "

  						 set cac_status = 'X'

  					   where cac_cash_id = " . (int)$cash_account_id);
      //删除banlance 触发邮件模板
       $cac_customer_query = "select cac_customer_id,cac_amount,cac_currency_code,cac_memo
                          from " . TABLE_CASH_ACCOUNT . "
                         where cac_cash_id = " . (int)$cash_account_id;
      $cac_customer_info = $db->Execute($cac_customer_query);
      $customer_info_query = "select customers_firstname, customers_lastname,customers_email_address
                          from " . TABLE_CUSTOMERS . "
                         where customers_id = " . $cac_customer_info->fields['cac_customer_id'];
      $customer_info = $db->Execute($customer_info_query);  
      $customer_email =$customer_info->fields['customers_email_address'];
      $memo = $cac_customer_info->fields['cac_memo'];
      $customer_lastname =$customer_info->fields['customers_lastname'];
      $customer_name = $customer_info->fields['customers_firstname'] . ' ' . $customer_info->fields['customers_lastname'];
      $subject_cash_amount_format = $cac_customer_info->fields['cac_currency_code'] . ' ' . $cac_customer_info->fields['cac_amount'];
      // $email_subject = $subject_cash_amount_format . CASH_ACCOUNT_NOTIFY_CUSTOMER_SUBJECT1;
      $html_msg['EMAIL_MESSAGE_HTML'] = sprintf(CASH_ACCOUNT_NOTIFY_DEL_DESCRIPTION,$customer_name,$subject_cash_amount_format,$memo) . "\n\n";
      zen_mail($customer_name, $customer_email, $email_subject, $notify_email_text, STORE_NAME, EMAIL_FROM, $html_msg, 'cash_account_notify');
      $messageStack->add_session(TEXT_CASH_ACCOUNT_DEL_SUCCESSED, 'success');
  		zen_redirect(zen_href_link(FILENAME_CASH_ACCOUNT, 'page=' . $_GET['page'].(isset($_GET['email'])?'&email='.$_GET['email']:'')));
  	break;  	
  	case 'save':
  		$cash_account_id = zen_db_prepare_input($_GET['cID']);
  		$cash_amount = zen_db_prepare_input($_POST['cash_amount']);
  		$cash_amount_new = $cash_amount;
  		$cash_amount_old = zen_db_prepare_input($_POST['cash_amount_old']);
  		$cac_currency_code_old = zen_db_prepare_input($_POST['cac_currency_code_old']);
  		$cac_order_create = zen_db_prepare_input($_POST['cac_order_create']);
  		$cac_customer_id = zen_db_prepare_input($_POST['cac_customer_id']);
  		$currency_code = zen_db_prepare_input($_POST['currency_code']);
  		$who_modify = $_SESSION['admin_id'];
  		$memo = zen_db_prepare_input($_POST['memo']);  		
  		if($cac_currency_code_old != $currency_code){
  			$currencies_value = $currencies->get_value($cac_currency_code_old);
  			$cash_amount_old = number_format($cash_amount_old/$currencies->get_value($cac_currency_code_old),2,".",",");
  			$cash_amount = number_format($cash_amount/$currencies->get_value($currency_code),2,".",",");
  			$cash_amount_adjust = ($cash_amount - $cash_amount_old)*$currencies->get_value($currency_code);
  		} else {
  			$cash_amount_adjust = $cash_amount -$cash_amount_old ;
  		}
  		if (!is_numeric($cash_amount)){
  			$error = true;
  			$messageStack->add_session(TEXT__CASH_AMOUNT_ERROR);
  		}else{
  			$amount_dollar = zen_change_currency($cash_amount, $currency_code, 'USD');
			if ($amount_dollar > CASH_AMOUNT_MAX || $amount_dollar<CASH_AMOUNT_MIN){
				$error = true;
				$messageStack->add_session(sprintf(TEXT_CASH_AMOUNT_EXCEED,CASH_AMOUNT_MIN, CASH_AMOUNT_MAX));
  			}
  		} 		
  		if ($error == true){
  			zen_redirect(zen_href_link(FILENAME_CASH_ACCOUNT, 'page=' . $_GET['page']));
  		} else {
  			//echo $cash_amount.'---'.$cash_amount_old.'----';	
  			
  			if( $cac_order_create == 2) {
  				//echo 1;
  				$db->Execute("insert into " . TABLE_CASH_ACCOUNT . " (cac_customer_id, cac_amount, cac_currency_code, cac_creator, cac_create_date, cac_status, cac_memo,cac_order_create)
 							  values (" . $cac_customer_id . ", '" . $cash_amount_adjust . "',  '" . zen_db_input($cac_currency_code_old) . "',
   							 '1', '" . date('Y-m-d H:i:s') . "', 'C','Adjusted Amount','1')");
  			}
  		if($cac_currency_code_old == $currency_code && $cash_amount_new != $cash_amount_old) {
				$cac_amount_changed = 0;
  				$cac_amount_changed = $cash_amount_new - $cash_amount_old;
				$db->Execute("update " . TABLE_CASH_ACCOUNT . "
						 set cac_who_modify = '" . zen_db_input($who_modify) . "',
						 	 cac_modify_date = '" . date('YmdHis') . "',
						 	 cac_status = 'C'
					   where cac_cash_id = " . (int)$cash_account_id);

				$db->Execute("insert into " . TABLE_CASH_ACCOUNT . " (cac_customer_id, cac_amount, cac_currency_code, cac_creator, cac_create_date, cac_status, cac_memo,cac_order_create)
						  values (" . $cac_customer_id . ", '" . $cac_amount_changed . "',  '" . zen_db_input($currency_code) . "',
						 '" . $who_modify . "', '" . date('Y-m-d H:i:s') . "', 'C','" . zen_db_input($memo) . "',0)");
				$db->Execute("insert into " . TABLE_CASH_ACCOUNT . " (cac_customer_id, cac_amount, cac_currency_code, cac_creator, cac_create_date, cac_status, cac_memo,cac_order_create)
						  values (" . $cac_customer_id . ", '" . $cash_amount_new . "',  '" . zen_db_input($currency_code) . "',
						 '" . $who_modify . "', '" . date('Y-m-d H:i:s') . "', 'A','" . TEXT_INFO_ADJUSTED_AMOUNT . "','2')");
  				
  			} else {
  				if($cash_amount_adjust != 0) {	  				
					$db->Execute("update " . TABLE_CASH_ACCOUNT . "
							 set cac_who_modify = '" . zen_db_input($who_modify) . "',
							 	 cac_modify_date = '" . date('YmdHis') . "',
							 	 cac_status = 'C'
						   where cac_cash_id = " . (int)$cash_account_id);
					$db->Execute("insert into " . TABLE_CASH_ACCOUNT . " (cac_customer_id, cac_amount, cac_currency_code, cac_creator, cac_create_date, cac_status, cac_memo,cac_order_create)
							  values (" . $cac_customer_id . ", '" . round($cash_amount_adjust, 2) . "',  '" . zen_db_input($cac_currency_code_old) . "',
							 '" . $who_modify . "', '" . date('Y-m-d H:i:s') . "', 'C','" . zen_db_input($memo) . "',0)");
					$db->Execute("insert into " . TABLE_CASH_ACCOUNT . " (cac_customer_id, cac_amount, cac_currency_code, cac_creator, cac_create_date, cac_status, cac_memo,cac_order_create)
							  values (" . $cac_customer_id . ", '" . round($cash_amount, 2) . "',  '" . zen_db_input($cac_currency_code_old) . "',
							 '" . $who_modify . "', '" . date('Y-m-d H:i:s') . "', 'A','" . TEXT_INFO_ADJUSTED_AMOUNT . "','2')");
  				}
  				
  			}
  			zen_redirect(zen_href_link(FILENAME_CASH_ACCOUNT, 'page=' . $_GET['page']));
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
 
  if (isset($_GET['email']) && $_GET['email'] != '' && $_GET['email'] > 0){
  	$email = (int)zen_db_prepare_input($_GET['email']);
  	$filter_email = " and customers_id = '" . $email . "'";
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
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
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
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="" align="right">
            <?php
              echo zen_draw_form('cash_account', FILENAME_CASH_ACCOUNT, '', 'get');
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
                <td class="dataTableHeadingContent" align="left" style="padding:5px 3px;width:13%;"><?php echo TABLE_HEADING_CUSTOMER_ID; ?></td>
                <td class="dataTableHeadingContent" align="left" style="padding:5px 3px;width:20%"><?php echo TABLE_HEADING_CUSTOMER_NAME; ?></td>
                <td class="dataTableHeadingContent" align="left" style="padding:5px 3px;width:27%;"><?php echo TABLE_HEADING_CUSTOMER_EMAIL; ?></td>
                <td class="dataTableHeadingContent" align="left" style="padding:5px 3px;width:10%;"><?php echo TABLE_HEADING_CASH_AMOUNT; ?></td>
                <td class="dataTableHeadingContent" align="left" style="padding:5px 3px;width:12%;"><?php echo TABLE_HEADING_CREATE_DATE; ?></td>
                <td class="dataTableHeadingContent" align="center" style="padding:5px 3px; width:8%;"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right" style="width:10%;"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
				<?php
				
				  $cash_account_query = "select cac_cash_id, cac_customer_id, cac_amount, cac_currency_code, cac_creator, 
				  						        cac_create_date, cac_who_modify, cac_modify_date, cac_status, cac_memo, customers_firstname,
				  						        customers_lastname, customers_email_address
				  						   from " . TABLE_CASH_ACCOUNT . ", " . TABLE_CUSTOMERS . "
				  						  where cac_customer_id = customers_id" . $filter_email . "
				  					   order by cac_cash_id DESC";
				  $cash_account_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $cash_account_query, $cash_account_numrows);
				  $cash_account = $db->Execute($cash_account_query);
				  while (!$cash_account->EOF) {
				    if ((!isset($_GET['cID']) || (isset($_GET['cID']) && ($_GET['cID'] == $cash_account->fields['cac_cash_id']))) && !isset($cInfo) && (substr($action, 0, 3) != 'new')) {
				      $cInfo = new objectInfo($cash_account->fields);
				    }	
				    $status_pic = '';
				    if ($cash_account->fields['cac_status'] == 'A'){
				    	$status_pic = zen_image(DIR_WS_IMAGES . 'icon_status_green.gif', 'Active');
				    } elseif ($cash_account->fields['cac_status'] == 'C'){
				    	$status_pic = zen_image(DIR_WS_IMAGES . 'icon_status_yellow.gif', 'Completion');
				    } elseif ($cash_account->fields['cac_status'] == 'X'){
				    	$status_pic = zen_image(DIR_WS_IMAGES . 'icon_status_red.gif', 'Deleted');
				    }    
				    if (isset($cInfo) && is_object($cInfo) && ($cash_account->fields['cac_cash_id'] == $cInfo->cac_cash_id) && ($cInfo->cac_status == 'A')) {
				      echo '                  <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_CASH_ACCOUNT, 'page=' . $_GET['page'] . '&cID=' . $cInfo->cac_cash_id . '&action=edit' . (($email != '') ? '&email=' . $email : '')) . '\'">' . "\n";
				    } else {
				      echo '                  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_CASH_ACCOUNT, 'page=' . $_GET['page'] . '&cID=' . $cash_account->fields['cac_cash_id'] . (($email != '') ? '&email=' . $email : '')) . '\'">' . "\n";
				    }
				?>
                <td class="dataTableContent" style="padding:5px 3px;"><?php echo $cash_account->fields['cac_customer_id']; ?></td>
                <td class="dataTableContent" style="padding:5px 3px;"><?php echo $cash_account->fields['customers_firstname'] . '&nbsp;' . $cash_account->fields['customers_lastname']; ?></td>
                <td class="dataTableContent" style="padding:5px 3px;"><?php echo ($_SESSION['show_customer_email'] ? $cash_account->fields['customers_email_address'] : strstr($cash_account->fields['customers_email_address'], '@', true) . '@'); ?></td>
                <td class="dataTableContent" style="padding:5px 3px;"><?php echo $currencies->format($cash_account->fields['cac_amount'], false, $cash_account->fields['cac_currency_code']); ?></td>
                <td class="dataTableContent" style="padding:5px 3px;"><?php echo substr($cash_account->fields['cac_create_date'], 0, 10); ?></td>
                <td class="dataTableContent" align="center" style="padding:5px 3px;"><?php echo $status_pic; ?></td>
                <td class="dataTableContent" align="right"><?php if (isset($cInfo) && is_object($cInfo) && ($cash_account->fields['cac_cash_id'] == $cInfo->cac_cash_id) ) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . zen_href_link(FILENAME_CASH_ACCOUNT, 'page=' . $_GET['page'] . '&cID=' . $cash_account->fields['cac_cash_id']) . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
			  <?php
				    $cash_account->MoveNext();
				  }
			  ?>
              <tr>
                <td colspan="8"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $cash_account_split->display_count($cash_account_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_CASH_ACCOUNT); ?></td>
                    <td class="smallText" align="right"><?php echo $cash_account_split->display_links($cash_account_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
				  <?php
				  	  if (empty($action)) {
				  ?>
                  <tr>
                    <td colspan="2" align="right"><?php echo '<a href="' . zen_href_link(FILENAME_CASH_ACCOUNT, 'page=' . $_GET['page'] . '&action=new') . '">' . zen_image_button('button_new_cash_account.gif', IMAGE_NEW_COUNTRY) . '</a>'; ?></td>
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
			  $status_array[] = array('id' => 'A', 'text' => 'A');
			  $status_array[] = array('id' => 'C', 'text' => 'C');
			  $status_array[] = array('id' => 'X', 'text' => 'X');
			  switch ($action) {
			    case 'new':
			      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_CASH_ACCOUNT . '</b>');	 
			      $contents = array('form' => zen_draw_form('cash_account', FILENAME_CASH_ACCOUNT, 'page=' . $_GET['page'] . '&action=insert'));
			      $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);
			      $contents[] = array('text' => '<br>' . TABLE_HEADING_CUSTOMER_ID . ':<br>' . zen_draw_input_field('customer_id'));
			      $contents[] = array('text' => '<br>' . TEXT_INFO_CASH_AMOUNT . '<br>' . zen_draw_input_field('cash_amount'));
			      $contents[] = array('text' => '<br>' . TEXT_INFO_CURRENCY_CODE . '<br>' . zen_draw_pull_down_menu('currency_code', $currencies_array));
			      $contents[] = array('text' => '<br>' . TEXT_INFO_NOTIFY_CUSTOMER . ' ' . zen_draw_checkbox_field('notify_customer', '1', true));
			      $contents[] = array('text' => '<br>' . TEXT_INFO_MEMO . '<br>' . zen_draw_textarea_field('memo', '', '20', '5', ''));
			      $contents[] = array('align' => 'center', 'text' => '<br>' . zen_image_submit('button_insert.gif', IMAGE_INSERT) . '&nbsp;<a href="' . zen_href_link(FILENAME_CASH_ACCOUNT, 'page=' . $_GET['page']) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
			      $contents[] = array('text' => '<br>' . '<table style="margin-left: 10px; ">
<tr><td><strong>定义解释：</strong> </td></tr>
<tr><td>Amount 若是正数，即下次下单该金额会被扣除。(我们欠客户的钱)<br/> 
举例，这边是10USD，那假设下次订单金额是100USD， 就只需付90USD。<br/> 
若是负数，即下次下单该金额会被加上。（客户欠我们的钱）<br/> 
举例，这边是 -5USD，那假设下次订单金额是100USD， 就需要付105USD。
</td></tr>
</table>');
				 break;
			    case 'edit':
			      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_CASH_ACCOUNT . '</b>');
			      $contents = array('form' => zen_draw_form('cash_account', FILENAME_CASH_ACCOUNT, 'page=' . $_GET['page'] . '&cID=' . $cInfo->cac_cash_id . '&action=save'));
			      $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
			      $contents[] = array('text' => '<br>' . TEXT_INFO_CASH_AMOUNT . '<br>' . zen_draw_input_field('cash_amount', $cInfo->cac_amount)."<input type='hidden' name='cash_amount_old' value='$cInfo->cac_amount'><input type='hidden' name='cac_currency_code_old' value='$cInfo->cac_currency_code'><input type='hidden' name='cac_customer_id' value='$cInfo->cac_customer_id'><input type='hidden' name='cac_order_create' value='$cInfo->cac_order_create'><input type='hidden' name='currency_code' value='$cInfo->cac_currency_code'>");
			      $contents[] = array('text' => '<br>' . TEXT_INFO_CURRENCY_CODE . '<br>' . zen_draw_pull_down_menu('cac_currency_code_old', $currencies_array, $cInfo->cac_currency_code, 'disabled="disabled"'));
			      $contents[] = array('text' => '<br>' . TEXT_INFO_MEMO . '<br>' . zen_draw_textarea_field('memo', '', '20', '5', TEXT_INFO_ADJUSTED_AMOUNT));
			      $contents[] = array('align' => 'center', 'text' => '<br>' . zen_image_submit('button_update.gif', IMAGE_UPDATE) . '&nbsp;<a href="' . zen_href_link(FILENAME_CASH_ACCOUNT, 'page=' . $_GET['page'] . '&cID=' . $cInfo->cac_cash_id) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
			      break;
			    case 'delete':
			      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_CASH_ACCOUNT . '</b>');
			      $contents = array('form' => zen_draw_form('cash_account', FILENAME_CASH_ACCOUNT, 'page=' . $_GET['page'] . '&cID=' . $cInfo->cac_cash_id . '&action=deleteconfirm'.(isset($_GET['email'])?'&email='.$_GET['email']:'')));
			      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
			      $contents[] = array('text' => '<br><b>' . ($_SESSION['show_customer_email'] ? $cInfo->customers_email_address : strstr($cInfo->customers_email_address, '@', true) . '@') . '</b>');
			      $contents[] = array('align' => 'center', 'text' => '<br>' . zen_image_submit('button_delete.gif', IMAGE_UPDATE) . '&nbsp;<a href="' . zen_href_link(FILENAME_CASH_ACCOUNT, 'page=' . $_GET['page'] . '&cID=' . $cInfo->cac_cash_id) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
			      break;
			    default:
			      if (is_object($cInfo)) {
			        $heading[] = array('text' => '<b>' . $cInfo->customers_email_address . '</b>');
			        if($cInfo->cac_status == 'A'){
			        	$contents[] = array('align' => 'center', 'text' => '<a href="' . zen_href_link(FILENAME_CASH_ACCOUNT, 'page=' . $_GET['page'] . '&cID=' . $cInfo->cac_cash_id . '&action=edit'.(isset($_GET['email'])?'&email='.$_GET['email']:'')) . '">' . zen_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . zen_href_link(FILENAME_CASH_ACCOUNT, 'page=' . $_GET['page'] . '&cID=' . $cInfo->cac_cash_id . '&action=delete'.(isset($_GET['email'])?'&email='.$_GET['email']:'')) . '">' . zen_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
			        }
			        $contents[] = array('text' => '<br>' . TEXT_INFO_CUSTOMER_NAME . '<br><b>' . $cInfo->customers_firstname . '&nbsp;' . $cInfo->customers_lastname . '</b>');
			        $contents[] = array('text' => '<br>' . TEXT_INFO_CUSTOMER_EMAIL . '<br><b>' . ($_SESSION['show_customer_email'] ? $cInfo->customers_email_address : strstr($cInfo->customers_email_address, '@', true) . '@') . '</b>');
			        $contents[] = array('text' => '<br>' . TEXT_INFO_CASH_AMOUNT . ' <b>' . $currencies->format($cInfo->cac_amount, false, $cInfo->cac_currency_code) . '</b>');
			        $contents[] = array('text' => '<br>' . TEXT_INFO_CREATOR . ' <b>' . zen_get_admin_name($cInfo->cac_creator) . '</b>');
			        $contents[] = array('text' => '<br>' . TEXT_INFO_CREATE_DATE . ' <br><b>' . $cInfo->cac_create_date . '</b>');
			        $contents[] = array('text' => '<br>' . TEXT_INFO_WHO_MODIFY . ' <b>' . zen_get_admin_name($cInfo->cac_who_modify) . '</b>');
			        $contents[] = array('text' => '<br>' . TEXT_INFO_MODIFY_DATE . ' <br><b>' . $cInfo->cac_modify_date . '</b>');
			        $contents[] = array('text' => '<br>' . TEXT_INFO_MEMO . ' <br><b>' . $cInfo->cac_memo . '</b>');
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