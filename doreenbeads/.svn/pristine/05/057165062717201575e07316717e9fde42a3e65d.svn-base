<?php 
require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));

if (! isset ( $_SESSION ['customer_id'] )) {
	zen_redirect ( zen_href_link ( FILENAME_LOGIN ) );
}




$question_id = (int)zen_db_prepare_input($_GET['id']);
if($question_id > 0 ){

	$query = 'select question_id, question_content, question_reply from ' . TABLE_CUSTOMER_QUESTION . ' where question_status = 1 and language_id = ' . $_SESSION['languages_id'] . ' and  question_id = '.$question_id;

	$var_pageDetails = $db->Execute($query);
	$question = $var_pageDetails->fields['question_content'];
	$answer   = $var_pageDetails->fields['question_reply'];
	//echo $answer;
	$smarty->assign('question',$question);
	$smarty->assign('answer',$answer);
	$smarty->assign('pages',$var_pageDetails);



}


$link = zen_href_link(FILENAME_HELP_CENTER,'','SSL');
$smarty->assign('link',$link);

?>