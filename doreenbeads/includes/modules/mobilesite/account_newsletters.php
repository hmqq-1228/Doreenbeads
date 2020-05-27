<?php
/**
 * Header code file for the Account Newsletters page - To change customers Newsletter options
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 3162 2006-03-11 01:39:16Z drbyte $
 */
if (!$_SESSION['customer_id']) {
  $_SESSION['navigation']->set_snapshot();
  zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

$newsletter_query = "SELECT customers_newsletter,customers_email_address
                     FROM   " . TABLE_CUSTOMERS . "
                     WHERE  customers_id = :customersID";

$newsletter_query = $db->bindVars($newsletter_query, ':customersID',$_SESSION['customer_id'], 'integer');
$newsletter = $db->Execute($newsletter_query);

$newsletter_status = $newsletter->fields['customers_newsletter'];
$customers_email_address = $newsletter->fields['customers_email_address'];

$param = array(
  'firstname' => $_SESSION['customer_first_name'],
  'lastname' => $_SESSION['customer_last_name'],
  );

//require(DIR_WS_CLASSES . 'newsletter.php');
//$new_newsletter = new newsletter();

if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
				
  if (isset($_POST['newsletter_general']) && is_numeric($_POST['newsletter_general'])) {
    $newsletter_general = zen_db_prepare_input($_POST['newsletter_general']);
  } else {
    $newsletter_general = 0;
  }

  if ($newsletter_status == 10) {
      $newsletter_status = 0;
  }

  if ($newsletter_general != $newsletter_status) {
      $success_message = '';
      $event_type = 0;
      if ($newsletter_general == 1) {
        $event_type = 10;
        $success_message = SUCCESS_NEWSLETTER_UPDATED;
      }else{
        $event_type = 20;
        $success_message = SUCCESS_NEWSLETTER_UNSUBSCRIBED;
      }

      $response = customers_for_mailchimp_subscribe_event($customers_email_address, $event_type, 20, $param);
      //var_dump($response);

      if($success_message != ''){
        $messageStack->add_session('account_newsletters', $success_message, 'success');
      }
    } else {
        $messageStack->add_session('account_newsletters', WARNING_NEWSLETTER_UPDATE, 'warning');
    }
    zen_redirect(zen_href_link(FILENAME_ACCOUNT_NEWSLETTERS));
  //var_dump($newsletter_general);
  /*if ($newsletter_general != $check) {


    $sql = "UPDATE " . TABLE_CUSTOMERS . "
            SET    customers_newsletter = :customersNewsletter
            WHERE  customers_id = :customersID";

    $sql = $db->bindVars($sql, ':customersID',$_SESSION['customer_id'], 'integer');
    $sql = $db->bindVars($sql, ':customersNewsletter',$newsletter_general, 'integer');
    $db->Execute($sql);
  
  if ($newsletter_general) {

		$new_newsletter->subscribe($_SESSION['customer_id']);
   	    $messageStack->add_session('account_newsletters', SUCCESS_NEWSLETTER_UPDATED, 'success');
   	    zen_redirect(zen_href_link(FILENAME_ACCOUNT_NEWSLETTERS));
   	}else{
		$new_newsletter->unsubscribe($newsletter->fields['customers_email_address']);
   		$messageStack->add_session('account_newsletters', SUCCESS_NEWSLETTER_UNSUBSCRIBED, 'success');
   		zen_redirect(zen_href_link(FILENAME_ACCOUNT_NEWSLETTERS));
   	}
  }else{
  	$messageStack->add_session('account_newsletters', WARNING_NEWSLETTER_UPDATE, 'error');
  	zen_redirect(zen_href_link(FILENAME_ACCOUNT_NEWSLETTERS));
  } 
  */
 
  //zen_redirect(zen_href_link(FILENAME_ACCOUNT, '', 'SSL'));
}
$smarty->assign('check',$newsletter_status);
$smarty->assign('messageStack',$messageStack);
$breadcrumb->add(NAVBAR_TITLE_1, zen_href_link(FILENAME_MYACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2, zen_href_link(FILENAME_MYACCOUNT.'#myaccountemail','','SSL'));
$breadcrumb->add(NAVBAR_TITLE_3);
?>
