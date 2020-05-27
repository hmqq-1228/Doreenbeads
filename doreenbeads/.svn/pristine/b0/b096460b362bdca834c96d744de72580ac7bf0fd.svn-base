<?php
if (! $_SESSION['customer_id']) {
	$_SESSION['navigation']->set_snapshot();
	zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}

require(DIR_WS_MODULES . 'require_languages.php');

$str_encrypt = $fun_inviteFriends->encode($_SESSION['customer_id']);
$share_link = zen_href_link(FILENAME_DEFAULT, '&utm_campaign=referrals&referrer_id='.$str_encrypt);
$share_link_encode = urlencode(ereg_replace('&amp;', '&', $share_link));

//	bof send mail
if(isset($_GET['action']) && $_GET['action'] == 'send'){
	$toEmails = trim($_POST['send_emails']);

	$customer_query = "SELECT customers_firstname, customers_lastname, customers_email_address FROM " . TABLE_CUSTOMERS . " WHERE customers_id = :customersID";
	$customer_query = $db->bindVars($customer_query, ':customersID', $_SESSION['customer_id'], 'integer');
	$customer = $db->Execute($customer_query);

	$email_subject = INVITE_FRIENDS_MAIL_TITLE;
	$html_msg['EMAIL_SUBJECT'] = "<br/>\n";
	$html_msg['EMAIL_MESSAGE_HTML'] = INVITE_FRIENDS_MAIL_CONT1;
	$html_msg['EMAIL_MESSAGE_HTML'] .= '<a href="'.$share_link.'&utm_medium=email">'.$share_link.'&utm_medium=email</a>'."<br/>\n";
	
	$fromName = $customer->fields['customers_firstname'].' '.$customer->fields['customers_lastname'];
	$fromMail = $customer->fields['customers_email_address'];

	$html_msg['EMAIL_MESSAGE_HTML'] .= INVITE_FRIENDS_MAIL_CONT2.( trim($fromName) != ''? $fromName : INVITE_FRIENDS_MAIL_CONT3 ) ;
	
	zen_mail('', $toEmails, $email_subject, '', $fromName, $fromMail, $html_msg, 'invitefriends_extra');

	exit();
}
//	eof send mail

$smarty->assign('share_link', $share_link);
$smarty->assign('share_link_encode', $share_link_encode);
$smarty->assign('logo', zen_image(DIR_WS_LANGUAGE_IMAGES.'logo1.png'));
$smarty->assign('logohref', zen_href_link(FILENAME_DEFAULT));
?>