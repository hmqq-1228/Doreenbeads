<?php
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
$breadcrumb->add(TEXT_HELP_CENTER);
$action = isset($_GET['action']) ? $_GET['action'] : '';
if ($action == 'question'){
	
	$customer_query = "SELECT customers_firstname, customers_lastname, customers_email_address
						 FROM " . TABLE_CUSTOMERS . "
						 WHERE customers_id = :customersID";
	$customer_query = $db->bindVars($customer_query, ':customersID', $_SESSION['customer_id'], 'integer');
	$customer = $db->Execute($customer_query);
		
	$question = zen_db_prepare_input($_POST['customer_question']);

	if(zen_validate_url($question)){
		$max_question_id = $db->Execute('select max(question_id) max_qid from ' . TABLE_CUSTOMER_QUESTION);
		$insert_qid = $max_question_id->fields['max_qid'] + 1;
		$db->Execute('insert into '.TABLE_CUSTOMER_QUESTION.' (question_id, customer_id, submit_time, question_content) value('.$insert_qid.',' . $_SESSION['customer_id'] . ', "' . date('Y-m-d H:i:m') . '","' . $question . '")');
		$messageStack->add('submit_success', 'Your question has been successfully submitted to the Customer Questions. We will answer it for you as soon as possible.', 'success');

		$email_subject = 'You have new Customer Questions to reply';
		$html_msg['EMAIL_MESSAGE_HTML'] = 'Customer\'s Question: '.$question."<br />\n";
		$html_msg['EMAIL_MESSAGE_HTML'] .= 'Customer\'s Name: '.$customer->fields['customers_lastname']." ".$customer->fields['customers_firstname']."<br />\n";
		$html_msg['EMAIL_MESSAGE_HTML'] .= "Customer's Email: <a href='mailto:".$customer->fields['customers_email_address']."'>".$customer->fields['customers_email_address']."</a><br />\n";
		$html_msg['EMAIL_MESSAGE_SUPPLIES'] = $html_msg['EMAIL_MESSAGE_HTML'];
		zen_mail('Doreenbeads', NOTIFICATION_EMAIL_ADDRESS, $email_subject, '', STORE_NAME, EMAIL_FROM, $html_msg, 'ex_customer_question');
	}

}
?>
