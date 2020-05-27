<?php
/**
 * �����ļ���������ʾ�˿͵�����
 * jessa 2010-06-17
 * header_php.php
 */
	
	require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
	
	if (!$_SESSION['customer_id']) {
		$_SESSION['navigation']->set_snapshot();
		zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
	}
	
	$breadcrumb->add(NAVBAR_TITLE);
	$error = false;
	$seucces = false;

	if (isset($_POST['action']) && $_POST['action'] == 'write_new'){
		if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != ''){
			$customer_id = $_SESSION['customer_id'];
			//$testimonial_title = zen_db_input(trim($_POST['title']));
			$testimonial_content = zen_db_input(trim($_POST['content']));

			$date = date('Ymd');
			$customer_query = "SELECT customers_firstname, customers_lastname, customers_email_address
						 FROM " . TABLE_CUSTOMERS . "
						 WHERE customers_id = :customersID";
			$customer_query = $db->bindVars($customer_query, ':customersID', $_SESSION['customer_id'], 'integer');
			$customer = $db->Execute($customer_query);
			$customer_email = $customer->fields['customers_email_address'];
			$customer_name = $customer->fields['customers_firstname'] . ' ' . $customer->fields['customers_lastname'];	
		
			if (zen_not_null($testimonial_content)){
				if(zen_validate_url($testimonial_content)){
					$db->Execute("Insert Into " . TABLE_TESTIMONIAL . " (tm_content, tm_customer_id, tm_status, tm_date_added, language_id)
						  Values ('" . $testimonial_content . "', " . (int)$customer_id . ", 1, " . $date . ", " . $_SESSION['languages_id'] . ")");
					$success = true;
					if (TESTIMONIAL_APPROVAL == '1' && SEND_EXTRA_TESTIMONIAL_NOTIFICATION_EMAILS_TO_STATUS == '1' and defined('SEND_EXTRA_TESTIMONIAL_NOTIFICATION_EMAILS_TO') and SEND_EXTRA_TESTIMONIAL_NOTIFICATION_EMAILS_TO !='') {
						$email_text  = sprintf(EMAIL_TESTIMONIAL_CONTENT_DETAILS, $testimonial_content) . "\n\n" ;
						$email_subject = EMAIL_TESTIMONIAL_PENDING_SUBJECT;
						$html_msg['EMAIL_SUBJECT'] = EMAIL_TESTIMONIAL_PENDING_SUBJECT;
						$html_msg['EMAIL_MESSAGE_HTML'] =sprintf(EMAIL_TESTIMONIAL_CUSTOMER_NAME,$customer_name).'<br/>'.sprintf(EMAIL_TESTIMONIAL_CUSTOMER_EMAIL,$customer_email).'<br />Date Added: '. date("m/d/Y") . '<br />'.
							sprintf(EMAIL_TESTIMONIAL_COMMENT,$testimonial_content)."<br/>";
						$extra_info=email_collect_extra_info($name,$email_address, $customer_name, $customer_email);
						$html_msg['EXTRA_INFO'] = $extra_info['HTML'];
						//print_r($html_msg);exit;
						zen_mail('', SEND_EXTRA_TESTIMONIAL_NOTIFICATION_EMAILS_TO, $email_subject, $email_text . $extra_info['TEXT'], STORE_NAME, EMAIL_FROM, $html_msg, 'testimonial_extra');
					}

					if ($_SESSION['auto_auth_code_display']['testimonial'] > 0){
						$_SESSION['auto_auth_code_display']['testimonial']+= 1;
					}else{
						$_SESSION['auto_auth_code_display']['testimonial'] = 1;
					}

					$messageStack->add('success', TEXT_SUCCESS_WRITE_TESTIMONIAL, 'success');
					zen_redirect(zen_href_link(FILENAME_TESTIMONIAL,'&page=1#testimonial_0','SSL'));
				}else{
					$error = true;
					$messageStack->add('check_form', TEXT_CHECK_URL);
				}
			} else {
				$error = true;
				$messageStack->add('check_form', TEXT_ERROR_COMMENT_REQUIRED);
			}
		}else {
			$customer_name = trim($_POST['customer_name']);
			$customer_email = trim($_POST['customer_email']);
			$testimonial_content = trim($_POST['content']);
			$date = date('Ymd');
			if (zen_not_null($customer_name) && zen_not_null($customer_email) && zen_not_null($testimonial_content)){
				$db->Execute("Insert Into " . TABLE_TESTIMONIAL . " (tm_content, tm_customer_email, tm_customer_name, tm_status, tm_date_added, language_id)
						  Values ('" . $testimonial_content . "', '" . $customer_email . "', '" . $customer_name . "', 1, " . $date . ", " . $_SESSION['languages_id'] . ")");
				$success = true;
				if (TESTIMONIAL_APPROVAL == '1' && SEND_EXTRA_TESTIMONIAL_NOTIFICATION_EMAILS_TO_STATUS == '1' and defined('SEND_EXTRA_TESTIMONIAL_NOTIFICATION_EMAILS_TO') and SEND_EXTRA_TESTIMONIAL_NOTIFICATION_EMAILS_TO !='') {
					$email_text  = sprintf(EMAIL_TESTIMONIAL_CONTENT_DETAILS, $testimonial_content) . "\n\n" ;
					$email_subject = EMAIL_TESTIMONIAL_PENDING_SUBJECT;
					$html_msg['EMAIL_SUBJECT'] = EMAIL_TESTIMONIAL_PENDING_SUBJECT;
					$html_msg['EMAIL_MESSAGE_HTML'] =sprintf(EMAIL_TESTIMONIAL_CUSTOMER_NAME,$customer_name).'<br/>'.sprintf(EMAIL_TESTIMONIAL_CUSTOMER_EMAIL,$customer_email).'<br />Date Added: '. date("m/d/Y") . '<br />'.
					sprintf(EMAIL_TESTIMONIAL_COMMENT,$testimonial_content)."<br/>"; 
					$extra_info=email_collect_extra_info($name,$email_address, $customer_name, $customer_email);
					$html_msg['EXTRA_INFO'] = $extra_info['HTML']; 
					//print_r($html_msg);exit;
					//zen_mail('', SEND_EXTRA_TESTIMONIAL_NOTIFICATION_EMAILS_TO, $email_subject, $email_text . $extra_info['TEXT'], STORE_NAME, EMAIL_FROM, $html_msg, 'testimonial_extra');
					zen_mail('', TESTIMONIAL_EMAILS_TO, $email_subject, $email_text . $extra_info['TEXT'], STORE_NAME, EMAIL_FROM, $html_msg, 'testimonial_extra');
					
				}
				$messageStack->add('success', TEXT_SUCCESS_WRITE_TESTIMONIAL, 'success');
			} else {
				if (!zen_not_null($customer_name)){
					$error = true;
					$messageStack->add('check_form', TEXT_ERROR_CUSTOMER_NAME);
				} 
				if (!zen_not_null($customer_email)){
					$error = true;
					$messageStack->add('check_form', TEXT_ERROR_CUSTOMER_EMAIL);
				}
				if (!zen_not_null($testimonial_content)){
					$error = true;
					$messageStack->add('check_form', TEXT_ERROR_COMMENT_REQUIRED);
				}
			}
		}
	}
	$customer_id = $_SESSION['customer_id'];
	$show_testimonial = false;
	$testimonial_query = "select tm_id 
						 from t_testimonial 
   					where tm_status = 1 and language_id = " . $_SESSION['languages_id'] . "
						order By tm_date_added Desc, tm_id Desc";
	$page_size = 5;
	$testimonial_split = new splitPageResults($testimonial_query, $page_size);
	$testimonial = $db->Execute($testimonial_split->sql_query);
	
	$testimonial_array = array();
	if ($testimonial->RecordCount() > 0){
		$show_testimonial = true;
		while (!$testimonial->EOF){
			$testimonial_id = $testimonial->fields['tm_id'];
			$testimonial_info = zen_get_testimonial_info($testimonial_id);
			
			$customer_info = zen_get_customers_info_WSL($testimonial_info['customer_id']);
			
			/* $customer_info = zen_get_customers_info($testimonial_info['customer_id']);
			var_dump($customer_info);exit; */
	
			/* $customer_info_query = "select c.customers_id , c.customers_firstname, c.customers_country_id , c.customers_lastname, c.customers_email_address,
  								   ct.countries_name
  							   from " . TABLE_CUSTOMERS . " c, " . TABLE_COUNTRIES . " ct
  							 where c.customers_id = " . $testimonial_info['customer_id'] . "  							
  							   and c.customers_country_id = ct.countries_id";
		
			$customer_info = $db->Execute($customer_info_query); */
			//echo $customer_info_query;
			//var_dump($testimonial_info);
			//var_dump($customer_info);
			
			$raw_date = $testimonial_info['date_added'];
			$time = mktime(0, 0, 0, (int)substr($raw_date, 5, 2), (int)substr($raw_date, 8, 2), (int)substr($raw_date, 0, 4));
			$testimonial_array[] = array('id' => $testimonial_id,
									 'content' => $testimonial_info['content'],
									 'customer_name' => $testimonial_info['customer_name'],
//									 'customer_email' => $testimonial_info['customer_email'],
//									 'customer_id' => $testimonial_info['customer_id'],
									 'reply' => $testimonial_info['reply'],
									 'avatar' => $testimonial_info['avatar'],
									 'customer_country' => $customer_info['default_country'],
									 'date_added' => date('M d, Y', $time));
			$testimonial->MoveNext();
		}		
	}
	
	//print_r($testimonial_array);
	if($testimonial_split){
		$fenye = $testimonial_split->display_links_mobile(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')) );
	
		$current_page_number = $testimonial_split->current_page_number;

		$page_start = ($current_page_number-1)*($page_size)+1;
		$page_end = ($current_page_number)*($page_size);
	
		if($page_end>$coupon_total){
			$page_end = $coupon_total;
		}
	
		$smarty->assign('page_start',$page_start."-");
		$smarty->assign('page_end',$page_end);
		$smarty->assign('fenye',$fenye);
		$smarty->assign('coupon_total',"/total:".$coupon_total);
	}
	
	if($_SESSION['auto_auth_code_display']['testimonial'] >= 3){
		$smarty->assign('auto_auth_code_display', true);
	}else{
		$smarty->assign('auto_auth_code_display', false);
	}
	
	$smarty->assign('testimonial_array',$testimonial_array);
	$customer_query = "SELECT customers_firstname, customers_lastname, customers_email_address
						 FROM " . TABLE_CUSTOMERS . "
						 WHERE customers_id = :customersID";
	$customer_query = $db->bindVars($customer_query, ':customersID', $_SESSION['customer_id'], 'integer');
	$customer = $db->Execute($customer_query);
	$customer_email = $customer->fields['customers_email_address'];
	$customer_name = $customer->fields['customers_firstname'] . ' ' . $customer->fields['customers_lastname'];
	
	$smarty->assign('customer_email',$customer_email);
	$smarty->assign('customer_name',$customer_name);	
	$smarty->assign('messageStack',$messageStack);
	
	
?>
