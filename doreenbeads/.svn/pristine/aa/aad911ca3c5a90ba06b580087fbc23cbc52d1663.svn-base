<?php

/**
 * Password Reset, by zale
 */

// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_PASSWORD_FORGOTTEN');
$autoJump = false;
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

// remove from snapshot
$_SESSION['navigation']->remove_current_page();

//////bof reset password by zale
$p=$_GET['p'];
$p_tmp = $p;
$p = str_replace(array('%','-'), array('+','/'), $p);
	$rp_id = (int)rc4('panduo', substr(base64_decode($p),0,-8));	//rp email id
	if ($rp_id == 0){ //invalid reset password email id
		$messageStack->add_session('link', INVALID_LINK, 'caution');
  		echo '<script type="text/javascript">window.location.href="'.zen_href_link(FILENAME_LOGIN, '', 'SSL').'"</script>';  	
	}
	$reset_password_query = "SELECT rp_email_address,rp_modify_time,status FROM " . TABLE_RESET_PASSWORD . "
                           WHERE rp_id = :rpId";
  	$reset_password_query = $db->bindVars($reset_password_query, ':rpId', $rp_id, 'integer');  	
  	$reset_password = $db->Execute($reset_password_query); 
  	
  	if ($reset_password->fields['status'] == 1){
  		$date_now = time();
  		$time = $date_now-strtotime($reset_password->fields['rp_modify_time']);
  		$valid_time = ($time > 259200 ? 0 : 1);
  		if ($valid_time == 0){	//链接时间超过72小时，无效
  			$db->Execute('update ' . TABLE_RESET_PASSWORD . ' set rp_modify_time="'.date('Y-m-d H:i:s',$date_now).'",status=0 where rp_id='.$rp_id);
  			zen_redirect(zen_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL'));
  		}
  		
	  	if (isset($_GET['action']) && ($_GET['action'] == 'process')) {	  		
			$new_password = zen_db_prepare_input($_POST['new_password']);
			$confirm_password = zen_db_prepare_input($_POST['confirm_password']);		  
		  	
		    $crypted_password = zen_encrypt_password($new_password);		    
		    $sql = "UPDATE " . TABLE_CUSTOMERS . "
		            SET customers_password = :password
		            WHERE customers_email_address = :emailAddress";		
		    $sql = $db->bindVars($sql, ':password', $crypted_password, 'string');
		    $sql = $db->bindVars($sql, ':emailAddress', $reset_password->fields['rp_email_address'], 'string');    
		    $db->Execute($sql);
		    $db->Execute('update ' . TABLE_RESET_PASSWORD . ' set rp_modify_time="'.date('Y-m-d H:i:s',$date_now).'",status=0 where rp_id='.$rp_id);
		    $messageStack->add('link', SUCCESS_LINK, 'success');
		    
		    //login		    
		    $check_customer_query = "SELECT customers_id, customers_firstname, customers_password,
                                  customers_email_address, customers_default_address_id,
                                  customers_authorization, customers_referral
                             FROM " . TABLE_CUSTOMERS . "
                            WHERE customers_email_address = :email";

			  $check_customer_query  =$db->bindVars($check_customer_query, ':email', $reset_password->fields['rp_email_address'], 'string');
			  $check_customer = $db->Execute($check_customer_query);
		      $ls_old_cookie = $_SESSION['cookie_cart_id'];
		      if (SESSION_RECREATE == 'True') {
		        zen_session_recreate();
		      }
		
		      $check_country_query = "SELECT entry_country_id, entry_zone_id
		                                FROM " . TABLE_ADDRESS_BOOK . "
		                               WHERE customers_id = :customersID
		                                 AND address_book_id = :adressBookID";
		
		      $check_country_query = $db->bindVars($check_country_query, ':customersID', $check_customer->fields['customers_id'], 'integer');
		      $check_country_query = $db->bindVars($check_country_query, ':adressBookID', $check_customer->fields['customers_default_address_id'], 'integer');
		      $check_country = $db->Execute($check_country_query);
		
		      $_SESSION['customer_id'] = $check_customer->fields['customers_id'];
		      $_SESSION['customer_default_address_id'] = $check_customer->fields['customers_default_address_id'];
		      $_SESSION['has_valid_order'] = zen_customer_has_valid_order();
		      $_SESSION['customers_authorization'] = $check_customer->fields['customers_authorization'];
		      $_SESSION['customer_first_name'] = $check_customer->fields['customers_firstname'];
		      $_SESSION['customer_country_id'] = $check_country->fields['entry_country_id'];
		      $_SESSION['customer_zone_id'] = $check_country->fields['entry_zone_id'];
		
		      $sql = "UPDATE " . TABLE_CUSTOMERS_INFO . "
		                 SET customers_info_date_of_last_logon = now(),
		                     customers_info_number_of_logons = customers_info_number_of_logons+1
		               WHERE customers_info_id = :customersID";
		
		      $sql = $db->bindVars($sql, ':customersID',  $_SESSION['customer_id'], 'integer');
		      $db->Execute($sql);
		      $zco_notifier->notify('NOTIFY_LOGIN_SUCCESS');
		      $_SESSION['cart']->restore_contents($ls_old_cookie);
			  setcookie("cookie_cart_id", "", time() - 3600, '/', '.' . BASE_SITE);
			  if (!empty($_REQUEST["permLogin"])) {
					unset($c);
					$c[] = $_SESSION['customer_id'];
					$c[] = $_SESSION['customer_default_address_id'];
					$c[] = $_SESSION['customers_authorization'];
					$c[] = $_SESSION['customer_first_name'];
					$c[] = $_SESSION['customer_last_name'];
					$c[] = $_SESSION['customer_country_id'];
					$c[] = $_SESSION['has_valid_order'];
					$c[] = $check_customer->fields['customers_password'];
					
					$c_str = implode("~~~", $c);
					
					setcookie("zencart_cookie_autologin", $c_str, time() + 7776000, '/', '.' . BASE_SITE);
				}
				$autoJump = true;
		    //eof login
		}
  	}else {
  		$messageStack->add_session('link', INVALID_LINK, 'caution');
  		echo '<script type="text/javascript">window.location.href="'.zen_href_link(FILENAME_LOGIN, '', 'SSL').'"</script>';  
  	}
//////eof reset password by zale
  	
$breadcrumb->add(NAVBAR_TITLE_1, zen_href_link(FILENAME_LOGIN, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2);

// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_PASSWORD_FORGOTTEN');
?>