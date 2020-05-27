<?php
//	require language from customer_service
if (file_exists($language_page_directory . $template_dir . '/customer_service.php')) {
	require($language_page_directory . $template_dir . '/customer_service.php');
} else if (file_exists($language_page_directory.'customer_service.php')){
	require($language_page_directory.'customer_service.php');
}

$breadcrumb->add(TEXT_HELP_CENTER, zen_href_link(FILENAME_CUSTOMER_SERVICE));
//	if have pagename, require the page
$pagename = isset($_GET['pagename']) ? $_GET['pagename'] : '';
if ($pagename != '') {
	if (file_exists($language_page_directory . $template_dir . '/' . $pagename . '.php')) {
		require($language_page_directory . $template_dir . '/' . $pagename . '.php');
	} else if (file_exists($language_page_directory.$pagename . '.php')){
		require($language_page_directory.$pagename . '.php');
	}
	if (file_exists(DIR_WS_MODULES . 'pages/' . $pagename . '/header_php.php')) {
		require(DIR_WS_MODULES . 'pages/' . $pagename . '/header_php.php');
		array_pop($breadcrumb->_trail);
	}
	switch ($pagename){
		case 'shipping_calculator' : $pageDetails_head = TEXT_SHIPPING_CALCULATOR; $pageDetails_img = 'shipcal_icon'; break;
	}
	$breadcrumb->add(TEXT_CUSTOMER_CARE, zen_href_link(FILENAME_HELP_CENTER));
	$breadcrumb->add($pageDetails_head);
}

//	if have id, get ezpage by id
$ezpage_id = (int)zen_db_prepare_input($_GET['id']);
if($ezpage_id == 138) {
	header('HTTP/1.1 302 Object Moved');
	zen_redirect(zen_href_link(FILENAME_OEM_SOURCING, '', 'NONSSL'));
	exit;
}

if($ezpage_id == 180) {
	header('HTTP/1.1 302 Object Moved');
	zen_redirect(zen_href_link(FILENAME_PAGE_NOT_FOUND, '', 'NONSSL'));
	exit;
}
if($ezpage_id > 0 && $ezpage_id != 180){
	$var_pageDetails = $db->Execute("select ze.pages_id , zed.pages_title , zed.pages_breadcrumb , zed.pages_html_text_web from " . TABLE_EZPAGES . " ze inner join " . TABLE_EZPAGES_DESCRIPTION . " zed on zed.pages_id = ze.pages_id where ze.status_page_web = 10 
											and languages_id= ".$_SESSION['languages_id'] . "
											and ze.pages_id = " . (int)$ezpage_id);
	$pageDetails = $var_pageDetails->fields['pages_html_text_web']; 
	$pageDetails_head = $var_pageDetails->fields['pages_title'];
	if($var_pageDetails->RecordCount() == 0 || trim($var_pageDetails->fields['pages_html_text_web']) == ''){
		header('HTTP/1.1 302 Object Moved');
		zen_redirect(zen_href_link(FILENAME_PAGE_NOT_FOUND, '', 'NONSSL'));
	}
	switch($ezpage_id){
		case 182: $pageDetails_img = 'aboutcom_icon'; break;
		case 181: $pageDetails_img = 'shipmethod_icon'; break;
		case 183: $pageDetails_img = 'order_icon'; break;
		case 15: $pageDetails_img = 'payment_icon'; break;
		case 184: $pageDetails_img = 'myaccount_icon'; break;
		case 46: $pageDetails_img = 'track_icon'; break;
		case 185: $pageDetails_img = 'customer_icon'; break;
		case 65: $pageDetails_img = 'vippolicy_icon'; break;
		case 186: $pageDetails_img = 'cusduty_icon'; break;
		case 138: $pageDetails_img = 'customize_icon'; break;
		case 187: $pageDetails_img = 'item_icon'; break;
		case 18: $pageDetails_img = 'learning_icon'; break;
		case 188: $pageDetails_img = 'product_icon'; break;
		case 64: $pageDetails_img = 'newlastest_icon'; break;
		case 189: $pageDetails_img = 'website_icon'; break;
		case 180: $pageDetails_img = 'cusques_icon'; break;
		case 227: $pageDetails_img = 'shipusa_icon'; break;
	}
	if ($ezpage_id == 18) {
		zen_redirect(zen_href_link(FILENAME_DEFAULT));exit;
	}
	$customer_care_arr = array(181,15,46,65,138,64);
	if(in_array($ezpage_id, $customer_care_arr))
		$breadcrumb->add(TEXT_CUSTOMER_CARE, zen_href_link(FILENAME_HELP_CENTER));
	$breadcrumb->add($pageDetails_head);
}
//print_r($var_pageDetails); 
//	search result, or 'customer question' page
$action = isset($_GET['action']) ? $_GET['action'] : '';
if ($action == 'search' || $ezpage_id == 180){
	$pageDetails_img = 'cusques_icon';
	$search_word = zen_db_prepare_input($_POST['faq_search']);
	if (isset($_GET['sw']) && $_GET['sw'] != ''){
		$search_word = zen_db_prepare_input($_GET['sw']);
	}
	if ($ezpage_id == 180){
		$query = 'select question_id, question_content, question_reply from ' . TABLE_CUSTOMER_QUESTION . ' where question_status = 1 and language_id = ' . $_SESSION['languages_id'] . ' order by question_id DESC';
		$pageDetails_head = TEXT_CUSTOMER_QUESTIONS;
		$breadcrumb->add(TEXT_CUSTOMER_QUESTIONS);
	}else{
		$query = 'select question_id, question_content, question_reply from ' . TABLE_CUSTOMER_QUESTION . ' where question_status = 1 and language_id = ' . $_SESSION['languages_id'] . ' and (question_content like "%'.$search_word.'%" or question_reply like "%'.$search_word.'%") order by question_id DESC';
		$breadcrumb->add(TEXT_SEARCH_RESULT);
	}
	$result_split = new splitPageResults($query, 10);
	$result = $db->Execute($result_split->sql_query);
	
	$search_result_content = array();
	if ($result->RecordCount() > 0){
		while (!$result->EOF){
			$reply = trim($result->fields['question_reply']);
			$question = trim($result->fields['question_content']);
			if (zen_not_null($search_word)){
				$reply = preg_replace('/('.$search_word.')(?![^<>]*>)/i', '<span class="hp-search-words">\1</span>', $reply); 
				$question = preg_replace('/('.$search_word.')(?![^<>]*>)/i', '<span class="hp-search-words">\1</span>', $question); 
			}
			$search_result_content[] = array('question_id' => $result->fields['question_id'],
													'question_content' => $question,
													'reply' => $reply
												);
			$result->MoveNext();
		}
	}
}

if($pagename == '' && !$ezpage_id && $action == ''){
	$breadcrumb->add(TEXT_CUSTOMER_CARE);
	$pageDetails_head = TEXT_CUSTOMER_CARE;
	$pageDetails_img = 'customer_service';
}
?>
