<?php
  require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
 // error_reporting(E_ALL^E_NOTICE);
$email = '';
$name  = '';
if($_SESSION['customer_id']){
	$email = $_SESSION['customer_email'];
	$name  = $_SESSION['customer_first_name'] . ' ' . $_SESSION['customer_last_name'];
}

if(isset($_POST['action']) && $_POST['action'] == 'oem_sourcing_process'){
	//var_dump($_POST);die;
	$oem_title_link = zen_db_prepare_input($_POST['oem_title_link']);
	/*if($_SESSION['customer_id']){
		$email = $_SESSION['customer_email'];
		$name  = $_SESSION['customer_first_name'];
	}else{*/
		$email = zen_db_prepare_input($_POST['email']);
		$name = zen_db_prepare_input($_POST['name']);
	//}
	$textarea  = zen_db_prepare_input($_POST['textarea']);
	$oem_loading_oem = zen_db_prepare_input($_POST['oem_loading_oem']);	
	$products_link = zen_db_prepare_input($_POST['products_link']);	
	$pid = zen_db_prepare_input($_POST['pid']);	
	$oem_type = zen_db_prepare_input($_POST['oem_type']);	
	$check_code = zen_db_prepare_input($_POST['check_code']);

	$error = true;
	if(!empty($oem_loading_oem) && $oem_loading_oem != 'true'){
		for($i=0;$i<3;$i++){
			if(zen_db_prepare_input($_POST['attachment_name_'.$i]) != ''){
				$original_attachment_name_array[] = array(
						zen_db_prepare_input($_POST['original_attachment_name_'.$i]),
				);
				$attachment_name_array[] = array(
						zen_db_prepare_input($_POST['attachment_name_'.$i]),
				);
				$attachment_link_array[] = array(
						zen_db_prepare_input($_POST['attachment_link_'.$i]),
				);
				$attachments_list[] = array(
					'file' => DIR_WS_IMAGES . 'oem/' . zen_db_prepare_input($_POST['attachment_name_'.$i]),
				);
			}
		}
		$original_attachment_name = serialize($original_attachment_name_array);
		$attachment_name = serialize($attachment_name_array);
		$attachment_link = serialize($attachment_link_array);
		
	}
	if (isset($pid ) && !empty($pid)) {
		$link = $products_link;
	}else{
		if ($oem_title_link == '') {
			$error = false;
			$messageStack->add('oem_sourcing', TEXT_WRONG_PRODUCT_NAME ,'error');
		}else{
			$link = $oem_title_link;
		}
	}
	if ($email == ''){
		$error = false;
		$messageStack->add('oem_sourcing', ENTRY_EMAIL_ADDRESS_ERROR,'error');
	}elseif(zen_validate_email($email) == false){
		$error = false;
		$messageStack->add('oem_sourcing', ENTRY_EMAIL_ADDRESS_ERROR,'error');
	}
	if ($name == ''){
		$error = false;
		$messageStack->add('oem_sourcing', TEXT_ENTER_YOUR_NAME,'error');
	}
	if ($textarea == ''){
		$error = false;
		$messageStack->add('oem_sourcing', TEXT_ENTER_PRODUCT_OF_YOU_WANT,'error');
	}
	
	if($_SESSION['auto_auth_code_display']['oem_sourcing'] >= 3 || !isset($_SESSION['customer_id']) || $_SESSION['customer_id'] == 0){
		if($_SESSION['verification_code_common'] != $check_code){
			$error = false;
			$messageStack->add('oem_sourcing', TEXT_INPUT_RIGHT_CODE ,'error');
		}
	}
	
	if(!$error){
		//提交出错
	}else{
		$sql_data_array = array(
				'title_link'	 		    => $link,
				'detail_content'  			=> $textarea,
				'original_attachment_name'	=>$original_attachment_name,
				'attachment_name'  			=>$attachment_name,
				'attachment_link'           =>$attachment_link,
				'customer_email'  			=> $email,
				'customer_name'  			=> $name,
				'date_added'	 			=> date('Y-m-d H:i:s'),		
				'languages_id'	 			=> $_SESSION['languages_id'],		
				'oem_type'	 				=> $oem_type	
		);
		//var_dump($sql_data_array);die;
		zen_db_perform(TABLE_OEM_SOURCING, $sql_data_array);
		
		$email_subject = TEXT_OEM_AND_SOURCING_PRO;
		
		$email_text = TEXT_PRODUCT_NAME_OR_LINK . '\n' . $link . '\n';
		$email_text .= $textarea . '\n';
		$email_text .= 'Email:' . '\n' . $email . '\n';
		$email_text .= 'Name:' . '\n' . $name . '\n';
		
		//$html_msg['EMAIL_SUBJECT'] = EMAIL_TESTIMONIAL_PENDING_SUBJECT;
		$html_msg['EMAIL_MESSAGE_HTML'] = "Product Name/Link:" . '<br/>' . $link . '<br/><br/>';
		$html_msg['EMAIL_MESSAGE_HTML'] .= "Detail:" .'<br/>'. zen_db_output_new($textarea) . '<br/><br/>';
		$html_msg['EMAIL_MESSAGE_HTML'] .= 'Email:' . '<br/>' . $email . '<br/>';
		$html_msg['EMAIL_MESSAGE_HTML'] .= 'Name:' . '<br/>' . $name . '<br/><span style="color: grey;">###Customized Service###</span>';

			   //昵称	               收件人邮箱                                             主题		              邮件内容（文本形式）     发件人昵称  发件人邮箱地址   邮件内容（html）	 			                 抄送		
		zen_mail('', SALES_EMAIL_ADDRESS, $email_subject, $email_text, $name, $email, $html_msg, 'oem', $attachments_list, 'false', '');
		//zen_mail('', 'xiaoying.zheng@panduo.com.cn', $email_subject, $email_text, $name, $email, $html_msg, 'oem', $attachments_list, 'false', SALES_EMAIL_CC_TO);
		
		if($name == ''){
			$html_msg2['EMAIL_MESSAGE_HTML']  = TEXT_DEAR_CUSTOMER . '<br/>';
		}else{
			$html_msg2['EMAIL_MESSAGE_HTML']  = sprintf(TEXT_DEAR_FN,$name) . '<br/>';
		}
		
		$html_msg2['EMAIL_MESSAGE_HTML'] .= TEXT_SEASONS_OF_SEND_YOU_EMAIL . '<br/><br/>';	
		$html_msg2['EMAIL_MESSAGE_HTML'] .= '<strong>'. TEXT_PRODUCT_NAME_OR_LINK .'</strong><br/>' . $link . '<br/><br/>';
		$html_msg2['EMAIL_MESSAGE_HTML'] .= '<strong>' .TEXT_DETAILS. '</strong><br/>' . zen_db_output_new($textarea) . '<br/><span style="color: grey;">###Customized Service###</span>';
		//$html_msg['EMAIL_MESSAGE_HTML'] .= '<strong>' .TEXT_EMAIL. '</strong><br/>' . $email . '<br/>';
		//$html_msg['EMAIL_MESSAGE_HTML'] .= '<strong>' .ENTRY_NAME. '</strong><br/>' . $name . '<br/>';

		$email_text2 = sprintf(TEXT_DEAR_FN,$name) . '\n';
		$email_text2 .= TEXT_SEASONS_OF_SEND_YOU_EMAIL . '\n';
		$email_text2 .= TEXT_PRODUCT_NAME_OR_LINK . '\n' . $link . '\n';
		$email_text2 .= TEXT_DETAILS . '\n' .$textarea . '\n';
		if ($_SESSION['auto_auth_code_display']['oem_sourcing'] > 0){
			$_SESSION['auto_auth_code_display']['oem_sourcing']+= 1;
		}else{
			$_SESSION['auto_auth_code_display']['oem_sourcing'] = 1;
		}

// 		zen_mail('', $email, $email_subject, $email_text2, STORE_NAME, EMAIL_FROM, $html_msg2, 'oem',$attachments_list);
// 		zen_mail ( '', $email, $email_subject, $email_text, STORE_NAME, EMAIL_FROM, $html_msg, 'welcome' );

		zen_redirect(zen_href_link(FILENAME_OEM_SOURCING_SUCCESS));
	}

	
	

	
}else{
	$lang_code   = $_SESSION['languages_code'];
	$https_prefix = "http";
	if(ENABLE_SSL) {
		$https_prefix = "https";
	}
	$server_host = $https_prefix . '://' . $_SERVER['SERVER_NAME'];
	if(isset($_GET['products_id']) && $_GET['products_id'] != ''){
		$products_id = $_GET['products_id'];
		$products_image = get_products_info_memcache($products_id, 'products_image');
		$products_model = get_products_info_memcache($products_id, 'products_model');
		$products_name  = get_products_description_memcache($products_id, $_SESSION['languages_id']);
		$products_link  = zen_href_link(FILENAME_PRODUCT_INFO,'products_id='.$products_id);
	}else{
		$products_id = '';
	}
	
}

// testimonial
$testimonial_sql = "select * from " . TABLE_TESTIMONIAL . " where language_id = " . $_SESSION['languages_id'] ." and tm_status = 1 and tm_customer_email not like '%panduo.com%' ORDER BY tm_date_added DESC, tm_id DESC LIMIT 3";
$testimonial_query = $db->Execute($testimonial_sql);
//var_dump($testimonial_query);
$testimonial_array = array();
if ($testimonial_query->RecordCount() > 0){
  	while (!$testimonial_query->EOF){
  		$testimonial_id = $testimonial_query->fields['tm_id'];
  		$testimonial_info = zen_get_testimonial_info($testimonial_id);
  		$testimonial_array[] = array('id' => $testimonial_id,
  									 'avatar'=>$testimonial_info['avatar'],
  									 'content' => $testimonial_info['content'],
  									 'customer_name' => $testimonial_info['customer_name'],
  									 'customer_email' => $testimonial_info['customer_email'],
  									 'customer_id' => $testimonial_info['customer_id'],
  									 'date_added' => $testimonial_info['date_added'],
  									 'reply' => $testimonial_info['reply']);
  		$testimonial_query->MoveNext();
  	}
}
//var_dump($testimonial_array);

$oem_sourcing_products_array_all = get_oem_sourcing_products_memcache();
$oem_sourcing_products_array = array_slice($oem_sourcing_products_array_all, 0, 5);
$products_id_array = array();
$where = ' 1=1 ';
if (sizeof($oem_sourcing_products_array) < 5) {
	if (sizeof($oem_sourcing_products_array) > 0) {
		foreach ($oem_sourcing_products_array as $key => $value) {
			$products_id_array[] = $value['products_id'];
		}
	}
	if (sizeof($products_id_array) > 0) {
		$products_id_str = implode("','", $products_id_array);
		$where .= " and products_id not in ('".$products_id_str."')";
	}	
	$oem_sourcing_products_sql = 'SELECT * FROM ' . TABLE_OEM_SOURCING_PRODUCTS . ' where '.$where.' ORDER BY date_added DESC';
	$oem_sourcing_products_query = $db->Execute($oem_sourcing_products_sql);
	$oem_sourcing_products_sub_array = array();
	if ($oem_sourcing_products_query->RecordCount() > 0){
	  	while (!$oem_sourcing_products_query->EOF){
	  		$oem_sourcing_products_sub_array[] = $oem_sourcing_products_query->fields;
	  		$oem_sourcing_products_query->MoveNext();
	  	}
	}
	$oem_sourcing_products_array_all = array_merge($oem_sourcing_products_array, $oem_sourcing_products_sub_array);
	$oem_sourcing_products_array = array_slice($oem_sourcing_products_array_all, 0, 5);
}
?>