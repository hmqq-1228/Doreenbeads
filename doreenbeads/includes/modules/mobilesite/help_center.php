<?php 
require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));

// if (! isset ( $_SESSION ['customer_id'] )) {
// 	zen_redirect ( zen_href_link ( FILENAME_LOGIN ) );
// }


//	require language from customer_service

// if (file_exists($language_page_directory . $template_dir . '/customer_service.php')) {
// 	require($language_page_directory . $template_dir . '/customer_service.php');
// } else if (file_exists($language_page_directory.'customer_service.php')){
// 	require($language_page_directory.'customer_service.php');
// }

$query = 'select question_id ,question_content from ' . TABLE_CUSTOMER_QUESTION . ' where question_status = 1 and language_id = ' . $_SESSION['languages_id'] ;


$result = $db->Execute($query);
//var_dump($result);
 while (!$result->EOF){
	$arr[] = array(
	//	'id'		=> $result->fields['question_id'],
 		'link'		=> zen_href_link(FILENAME_HELP_CENTER_ANSWER,"id=".$result->fields['question_id'],'SSL'),	
		'question'	=> $result->fields['question_content'],	
	);
	$result->MoveNext();
 }
 
 $virtual_shipping_question_query = 'select question_id ,question_content from ' . TABLE_CUSTOMER_QUESTION . ' where question_status = 1 and question_id in (93, 94, 95, 96, 99) and language_id = ' . $_SESSION['languages_id'] ;
 $virtual_shipping_question_result = $db->Execute($virtual_shipping_question_query);
 
 while (!$virtual_shipping_question_result->EOF){
     $virtual_shipping_arr[] = array(
         'link'		=> zen_href_link(FILENAME_HELP_CENTER_ANSWER,"id=".$virtual_shipping_question_result->fields['question_id'],'SSL'),
         'question'	=> $virtual_shipping_question_result->fields['question_content'],
     );
     $virtual_shipping_question_result->MoveNext();
 }
 
//var_dump($arr);
//echo $answer;
//echo $arr[0][question];
//$smarty->assign('question',$question);
//$smarty->assign('answer',$answer);
$smarty->assign('arr',$arr);
$smarty->assign('virtual_shipping_arr',$virtual_shipping_arr);



?>





