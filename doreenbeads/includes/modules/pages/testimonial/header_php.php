<?php
/**
 * �����ļ���������ʾ�˿͵�����
 * jessa 2010-06-17
 * header_php.php
 */

	require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
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
						//zen_mail('', SEND_EXTRA_TESTIMONIAL_NOTIFICATION_EMAILS_TO, $email_subject, $email_text . $extra_info['TEXT'], STORE_NAME, EMAIL_FROM, $html_msg, 'testimonial_extra');
						zen_mail('', TESTIMONIAL_EMAILS_TO, $email_subject, $email_text . $extra_info['TEXT'], STORE_NAME, EMAIL_FROM, $html_msg, 'testimonial_extra');
						zen_mail('dorabeads-supplises', SALES_EMAIL_ADDRESS, $email_subject, '', $customer_name, $customers_email, $html_msg, 'contact_us', '', 'false', SALES_EMAIL_CC_TO);
					}


					$messageStack->add('success', TEXT_SUCCESS_WRITE_TESTIMONIAL, 'success');
				}else{
					$error = true;
					$messageStack->add('check_form', TEXT_CHECK_URL);
				}

			} else {
				$error = true;
				$messageStack->add('check_form', TEXT_ERROR_COMMENT_REQUIRED);
			}
		} else {
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
					zen_mail('', SEND_EXTRA_TESTIMONIAL_NOTIFICATION_EMAILS_TO, $email_subject, $email_text . $extra_info['TEXT'], STORE_NAME, EMAIL_FROM, $html_msg, 'testimonial_extra');
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
  
	$show_testimonial = false;
	$str='';
	$lan_post = zen_db_prepare_input($_POST['lan']);
	$lan_get  = zen_db_prepare_input($_GET['lan']);
	if($lan_post !='' &&  $lan_post != 99){
		$str .= "and language_id=".$lan_post;
		$_SESSION['testimoniallan'] =  $lan_post;
	}else if($lan_get !='' &&  $lan_get != 99){
		$str .= "and language_id=".$lan_get;
		$_SESSION['testimoniallan'] =  $lan_get;
	}else if($lan_post ==99){
		$str='';
		$_SESSION['testimoniallan'] = '';
	}else if($_SESSION['testimoniallan']!=''){
		$str .= "and language_id=".$_SESSION['testimoniallan'];
	}
	
	
  $testimonial_query = "Select tm_id From " . TABLE_TESTIMONIAL . " Where tm_status = 1 ".$str." and tm_customer_email not like '%panduo.com.cn%' Order By tm_date_added Desc, tm_id Desc"; 
  if(isset($_GET['tm_id'])&&$_GET['tm_id']!=''){
  	$tm_id = zen_db_prepare_input($_GET['tm_id']);
  	$get_position=$db->Execute("select count(tm_id) as num from " . TABLE_TESTIMONIAL . " where  tm_status = 1 
  					  and tm_id > ".(int)$tm_id."
  					  Order By tm_date_added Desc, tm_id Desc");
  	
  	$position_num=$get_position->fields['num']+1;
  	
  	$position_page=ceil($position_num/15);
  	$_GET['page']=$position_page;
  }
  
  //$num=isset($_GET['page'])?15:5;
  $testimonial_split = new splitPageResults($testimonial_query,15);
  $testimonial = $db->Execute($testimonial_split->sql_query);
  
  $testimonial_array = array();
	if ($testimonial->RecordCount() > 0){
		$show_testimonial = true;
		while (!$testimonial->EOF){
			$testimonial_id = $testimonial->fields['tm_id'];
			$testimonial_info = zen_get_testimonial_info($testimonial_id);
			$customer_info = zen_get_customers_info($testimonial_info['customer_id']);
			$raw_date = $testimonial_info['date_added'];
			$time = mktime(0, 0, 0, (int)substr($raw_date, 5, 2), (int)substr($raw_date, 8, 2), (int)substr($raw_date, 0, 4));
			$testimonial_array[] = array('id' => $testimonial_id,
									 'content' => $testimonial_info['content'],
									 'customer_name' => $testimonial_info['customer_name'],
									 'reply' => $testimonial_info['reply'],
									 'avatar' => $testimonial_info['avatar'],
									 'customer_country' => $customer_info['default_country'],
									 'date_added' => date('M d, Y', $time));
			$testimonial->MoveNext();
		}
	}
?>
