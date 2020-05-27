<?php
require('includes/application_top.php');	
require ('includes/fckeditor_php5.php');
$action = (isset($_GET['action']) ? $_GET['action'] : '');
if ($action == 'save'){
	$id = intval($_GET['qID']);
	$question_id = zen_db_prepare_input($_POST['question_id']);
	$c_question = zen_db_prepare_input($_POST['c_question']);
	$reply = zen_db_prepare_input($_POST['pages_html_text']);
//	$name = zen_db_prepare_input($_POST['customer_name']);
//	$fname = zen_db_prepare_input($_POST['customer_fname']);
	$c_id = zen_db_prepare_input($_POST['customer_id']);
	$time = zen_db_prepare_input($_POST['submit_time']);
//	$email = zen_db_prepare_input($_POST['customer_email']);

	$sql_data_array = array('question_id' => $question_id,
								'customer_id' => $c_id,
//								'question_reply' => $reply,
//								'question_content' => $c_question,
								'submit_time' => $time,
								'question_status' => 1,									
								'reply_time' => date('Y-m-d H:i:s'));
	$languages = zen_get_languages();
	for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
		$sql_data_array['question_reply'] = $reply[$languages[$i]['id']];
		$sql_data_array['question_content'] = $c_question[$languages[$i]['id']];
		$sql_data_array['language_id'] = $languages[$i]['id'];

		$result = $db->Execute('select * from ' . TABLE_CUSTOMER_QUESTION . ' where question_id = ' . $question_id . ' and language_id = "'.$languages[$i]['id'].'"');
		if ($result->RecordCount() == 0){
			zen_db_perform(TABLE_CUSTOMER_QUESTION, $sql_data_array);				 
		}else {
			zen_db_perform(TABLE_CUSTOMER_QUESTION, $sql_data_array, 'update', "question_id = '" . $question_id . "' and language_id = '" . $languages[$i]['id'] . "'");
		}
	}
	$messageStack->add_session('Question ID '.$question_id.' updated successfully!', 'success');	
				
/*
		//bof send mail to customer
		if ($name != ''){
			$email_subject = TEXT_EMAIL_SUBJECT_EN;
			$email_content = sprintf(TEXT_EMAIL_CONTENT_EN, $fname, $c_question[$languages[$i]['id']]);
			$html_msg['EMAIL_MESSAGE_HTML'] = $email_content;
			zen_mail($name, $email, $email_subject, $email_content, STORE_NAME, EMAIL_FRONT_DESK, $html_msg, 'product_question');
			$messageStack->add_session(sprintf(TEXT_SEND_MAIL_SUCCESS, $name), 'success');
		}
		//eof send mail to customer
*/
	zen_redirect(zen_href_link(FILENAME_CUSTOMER_QUESTION, 'page=' . $_GET['page'] . '&qID=' . $_GET['qID']));		
}elseif ($action == 'set_status'){
	$id = intval($_GET['qID']);
	$current = $_GET['current'];
	$db->Execute('update ' . TABLE_CUSTOMER_QUESTION . ' set question_status = ' . $current . ' where id = ' . $id);
}elseif ($action == 'delete_confirm'){
	$id = $_GET['qID'];
	if ((int)$id != ''){
		$db->Execute('delete from ' . TABLE_CUSTOMER_QUESTION . ' where id = ' .(int)$id);
		$messageStack->add_session('delete question '.$id.' successfully!', 'success');
		zen_redirect(zen_href_link(FILENAME_CUSTOMER_QUESTION, 'page=' . $_GET['page']));
	}
}elseif ($action == 'insert_confirm'){
	$languages = zen_get_languages();
	$c_question = zen_db_prepare_input($_POST['c_question']);
	$reply = zen_db_prepare_input($_POST['pages_html_text']);

	$sql_data_array = array();
	unset($insert_qid);
	for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
		$sql_data_array = array('question_reply' => $reply[$languages[$i]['id']],
									'question_content' => $c_question[$languages[$i]['id']],
									'language_id' => $languages[$i]['id'],
									'question_status' => 1,
									'submit_time' => date('Y-m-d H:i:s'),								 
									'reply_time' => date('Y-m-d H:i:s')
		);
		if(!isset($insert_qid)){
			$max_question_id = $db->Execute('select max(question_id) max_qid from ' . TABLE_CUSTOMER_QUESTION);
			$max_qid = $max_question_id->fields['max_qid'];
			$insert_qid = $max_qid + 1;
		}
		$sql_data_array['question_id'] = $insert_qid;
		zen_db_perform(TABLE_CUSTOMER_QUESTION, $sql_data_array);
	}

	$messageStack->add_session('insert question successfully!', 'success');	
	zen_redirect(zen_href_link(FILENAME_CUSTOMER_QUESTION));
}
?>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" media="print" href="includes/stylesheet_print.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script type="text/javascript">
<!--
function init(){
	cssjsmenu('navbar');
	if (document.getElementById){
		var kill = document.getElementById('hoverJS');
		kill.disabled = true;
	}
}
//-->
</script>
<script language="javascript" type="text/javascript"><!--
function couponpopupWindow(url) {
	window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=280,screenX=150,screenY=150,top=150,left=150')
}
//--></script>
</head>
<body onLoad="init()">
<!-- header //-->
<div class="header-area">
<?php
	require(DIR_WS_INCLUDES . 'header.php');
?>
</div>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2" id="customer_question_content">
<!--
<?php/* if ($action == 'edit' || $action == 'insert') {
	//bof customer name
	$customer_name = '';
		
	if (isset($_GET['qID']) and zen_not_null($_GET['qID'])) {
		$customer_id_result = $db->Execute("select distinct customer_id, submit_time from " . TABLE_CUSTOMER_QUESTION . " where id = '" . $_GET['qID'] . "'");
		$customer_id = $customer_id_result->fields['customer_id'];
		$submit_time = $customer_id_result->fields['submit_time'];
		$customer = $db->Execute('select c.customers_firstname fn, c.customers_lastname ln, c.customers_email_address email from ' . TABLE_CUSTOMERS . ' c where c.customers_id = ' . $customer_id);
		if ($customer->RecordCount() == 1){
			$customer_fname = $customer->fields['fn'];
			$customer_lname = $customer->fields['ln'];
			$customer_name = $customer_fname . ' ' . $customer_lname;
			$customer_email = $customer->fields['email'];			
		}
	} 
	//eof
	$action_form = ($action == 'edit' ? 'save' : 'insert_confirm');
	$cancel_link = ($action == 'edit' ? zen_href_link(FILENAME_CUSTOMER_QUESTION, 'page=' . $_GET['page'] . '&qID=' . $_GET['qID']) : zen_href_link(FILENAME_CUSTOMER_QUESTION));
	echo zen_draw_form('customer_question', FILENAME_CUSTOMER_QUESTION, 'page=' . $_GET['page'] . '&qID=' . $_GET['qID'] . '&action='.$action_form, 'post');
*/
?>
	<tr>
		<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
			<tr>
				<td colspan="2" class="main" align="left" valign="top" nowrap><?php echo zen_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . $cancel_link . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
			</tr>
		</table></td>
	</tr>
		
	<tr>
		<td><table border="0" cellspacing="0" cellpadding="2">
		<?php if ($action == 'edit') { ?>
			<tr>
				<td class="main">Question ID: </td>
				<td class="main"><?php echo zen_draw_input_field('question_id', $_GET['question_id'], 'readonly');?></td>
			</tr>
			 
			<tr>
				<td class="main">Customer Name: </td>
				<td class="main"><?php echo zen_draw_input_field('customer_name', $customer_name, 'readonly') . zen_draw_hidden_field('customer_id', $customer_id) . zen_draw_hidden_field('customer_fname', $customer_fname);?></td>
			</tr>
			 
			<tr>
				<td class="main">Customer Email: </td>
				<td class="main"><?php echo zen_draw_input_field('customer_email', ($_SESSION['show_customer_email'] ? $customer_email : strstr($customer_email, '@', true) . '@'), 'readonly', false, 'text', false);?></td>
			</tr>
			 
			<tr>
				<td class="main">Submit Time: </td>
				<td class="main"><?php echo zen_draw_input_field('submit_time', $submit_time, 'readonly');?></td>
			</tr>
		<?php } ?>	
			<tr>
				<td class="main">Question: </td>
				<td class="main">
			<?php
				if (isset($_GET['qID']) and zen_not_null($_GET['qID'])) {
					$customer_question_sql = "select * from " . TABLE_CUSTOMER_QUESTION . " where question_id = '" . $_GET['question_id'] . "'";
					$customer_question = $db->Execute($customer_question_sql);
					$question_content = $customer_question->fields['question_content'];
				} else {
					$question_content = '';
				}
				echo zen_draw_textarea_field('c_question', '', '100', '1', $question_content);						
			?>
				</td>
			</tr>			 

			<tr>
				<td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
			</tr>
			 
			<tr>
				<td valign="top" class="main">Reply: </td>
				<td class="main">
			<?php 
				if (isset($_GET['qID']) and zen_not_null($_GET['qID'])) {
					$customer_question_sql = "select * from " . TABLE_CUSTOMER_QUESTION . " where question_id = '" . $_GET['question_id'] . "'";
					$customer_question = $db->Execute($customer_question_sql);
					$question_reply = $customer_question->fields['question_reply'];
				} else {
					$question_reply = '';
				}
				if ($_SESSION['html_editor_preference_status']=="FCKEDITOR") {						
					$oFCKeditor = new FCKeditor('pages_html_text') ;
					$oFCKeditor->Width  = '80%' ;
					$oFCKeditor->Height = '500' ;
					$oFCKeditor->Value = $question_reply ;
					echo $oFCKeditor->CreateHtml();
				} else { // using HTMLAREA or just raw "source"
					echo zen_draw_textarea_field('pages_html_text', 'soft', '100%', '20', $question_reply);
				}
			?>
				</td>
			</tr>

			<tr>
				<td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
			</tr>

		</table></td>
	</tr>

	<tr>
		<td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
	</tr>

	<tr>
		<td><table border="0" width="100%" cellspacing="0" cellpadding="2">
			<tr>
				<td colspan="2" class="main" align="left" valign="top" nowrap><?php echo zen_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . $cancel_link . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
			</tr>
		</table></td>
	</form>
	</tr>

<?php// }else{ ?>
-->

	<tr>
		<td width="100%">
			<table border="0" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td class="pageHeading">CUSTOMER QUESTION</td>
					<td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
					<td align="right"></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><table border="0" width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
					<tr class="dataTableHeadingRow">
						<td class="dataTableHeadingContent" align="center">Question ID</td>
						<td class="dataTableHeadingContent">Customer Name</td>
						<td class="dataTableHeadingContent">Customer Email</td>
						<td class="dataTableHeadingContent">Question</td>
						<td class="dataTableHeadingContent">Submit Time</td>
						<td class="dataTableHeadingContent">Reply Time</td>
						<td class="dataTableHeadingContent">Language</td>
						<td class="dataTableHeadingContent" align="center">Status</td>
						<td class="dataTableHeadingContent" align="center">Action</td>
					</tr>
<?php
	$question_query_raw = 'select question_id, id, customer_id, submit_time, question_status, question_reply, reply_time, question_content, language_id from ' . TABLE_CUSTOMER_QUESTION . ' order by question_id desc';
	// Split Page
	// reset page when page is unknown
	if (($_GET['page'] == '' or $_GET['page'] <= 1) and $_GET['qID'] != '') {
		$check_page = $db->Execute($question_query_raw);
		$check_count=1;
		if ($check_page->RecordCount() > MAX_DISPLAY_SEARCH_RESULTS_ORDERS) {
			while (!$check_page->EOF) {
				if ($check_page->fields['id'] == $_GET['qID'])
					break;
				$check_count++;
				$check_page->MoveNext();
			}
			$_GET['page'] = round((($check_count/MAX_DISPLAY_SEARCH_RESULTS_ORDERS)+(fmod_round($check_count,MAX_DISPLAY_SEARCH_RESULTS_ORDERS) !=0 ? .5 : 0)),0);
		} else {
			$_GET['page'] = 1;
		}
	}

	$question_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_ORDERS, $question_query_raw, $question_query_numrows);
	$question = $db->Execute($question_query_raw);
	while (!$question->EOF) {
		$customer_name = '';
		$customer = $db->Execute('select c.customers_firstname fn, c.customers_lastname ln, c.customers_email_address email from ' . TABLE_CUSTOMERS . ' c where c.customers_id = ' . $question->fields['customer_id']);
		if ($customer->RecordCount() == 1){
			$customer_name = $customer->fields['fn'] . ' ' . $customer->fields['ln'];
		}
		$question->fields['customer_name'] = $customer_name;
		$question->fields['customer_email'] = $customer->fields['email'];
		$status_pic = '';
		if ($question->fields['question_status'] == 1){
			$status_pic = zen_image(DIR_WS_IMAGES . 'icon_status_green.gif');
			$set_status = 0;
		}	elseif ($question->fields['question_status'] == 0){
			$status_pic = zen_image(DIR_WS_IMAGES . 'icon_status_red.gif');
			$set_status = 1;
		}
			
		if ((!isset($_GET['qID']) || (isset($_GET['qID']) && ($_GET['qID'] == $question->fields['id']))) && !isset($qInfo))
			$qInfo = new objectInfo($question->fields);

		if (isset($qInfo) && is_object($qInfo) && ($question->fields['id'] == $qInfo->id)) {
			echo '<tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_CUSTOMER_QUESTION, zen_get_all_get_params(array('qID', 'action', 'question_id')) . 'qID=' . $question->fields['id'] . '&question_id=' . $question->fields['question_id'] . '&action=edit', 'NONSSL') . '\'">' . "\n";
		} else {
			echo '<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_CUSTOMER_QUESTION, zen_get_all_get_params(array('qID', 'action', 'question_id')) . 'qID=' . $question->fields['id']. '&question_id=' . $question->fields['question_id'] . '&action=edit', 'NONSSL') . '\'">' . "\n";
		}
?>
						<td class="dataTableContent" align="center"><?php echo $question->fields['question_id']; ?></td>
						<td class="dataTableContent"><?php echo $question->fields['customer_name']; ?></td>
						<td class="dataTableContent"><?php echo $question->fields['customer_email']; ?></td>					  
						<td class="dataTableContent"><?php echo $question->fields['question_content']; ?></td>
						<td class="dataTableContent"><?php echo $question->fields['submit_time']; ?></td>
						<td class="dataTableContent"><?php echo $question->fields['reply_time']; ?></td>
						<td class="dataTableContent"><?php echo $question->fields['language_id']; ?></td>
						<td class="dataTableContent" align="center">
							<?php echo '<a href="' . zen_href_link(FILENAME_CUSTOMER_QUESTION, 'action=set_status&current=' . $set_status . '&qID='.$question->fields['id'].'&question_id=' . $question->fields['question_id'] . ($_GET['page'] > 0 ? '&page=' . $_GET['page'] : ''), 'NONSSL') . '">' . $status_pic . '</a>';?>
						</td>
						<td class="dataTableContent" align="center">
							<?php if (isset($qInfo) && is_object($qInfo) && ($question->fields['id'] == $qInfo->id)) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . zen_href_link(FILENAME_CUSTOMER_QUESTION, zen_get_all_get_params(array('question_id', 'qID')) . 'question_id=' . $question->fields['question_id'] . '&qID=' . $question->fields['id']) . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>
						</td>
					</tr>
<?php
		$question->MoveNext();
	}
?>
					<tr>
						<td colspan="9" align="right"><?php echo '<a href="' . zen_href_link(FILENAME_CUSTOMER_QUESTION, 'action=insert') . '">' . zen_image_button('button_insert.gif') . '</a>'; ?></td>
					</tr>	

					<tr>
						<td colspan="9"><table border="0" width="100%" cellspacing="0" cellpadding="2">
							<tr>
								<td class="smallText" valign="top"><?php echo $question_split->display_count($question_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_ORDERS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ORDERS); ?></td>
								<td class="smallText" align="right"><?php echo $question_split->display_links($question_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_ORDERS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'qID', 'action'))); ?></td>
						</table></td>
					</tr>
				</table></td>
<?php
	$heading = array();
	$contents = array();

	switch ($action) {
		case 'delete':
			$heading[] = array('text' => '<b>Delete question('.$qInfo->question_id.') confirm</b>');
			$contents = array('form' => zen_draw_form('customer_question', FILENAME_CUSTOMER_QUESTION, 'page=' . $_GET['page'] . '&qID=' . $_GET['qID'] . '&action=delete_confirm', 'post'));
			$contents[] = array('text' => 'Are you sure you want to delete this question?');		  
			$contents[] = array('align' => 'center', 'text' => '<br>' . zen_image_submit('button_confirm.gif') . ' <a href="' . zen_href_link(FILENAME_CUSTOMER_QUESTION, 'page=' . $_GET['page'] . '&qID=' . $_GET['qID']) . '">' . zen_image_button('button_cancel.gif') . '</a>');
			break;

		case 'insert':
			$heading[] = array('text' => '<b>New Question</b>');
			$contents = array('form' => zen_draw_form('customer_question', FILENAME_CUSTOMER_QUESTION, 'page=' . $_GET['page'] . '&action=insert_confirm', 'post'));
			$languages = zen_get_languages();
			$c_question = $pages_html_text = '';
			for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
				$c_question .= '<br />'.zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;'.  zen_draw_textarea_field('c_question['. $languages[$i]['id'] .']', '', '40', '15');
				$pages_html_text .= '<br />'.zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;'.	zen_draw_textarea_field('pages_html_text['. $languages[$i]['id'] .']', '', '40', '15');
			}
			$contents[] = array('text' => '<br />Question:<br>' . $c_question);
			$contents[] = array('text' => '<br />Reply:<br>' . $pages_html_text);

//			$contents[] = array('text' => '<br />Question:<br />' . zen_draw_textarea_field('c_question', '', '40', '15'));
//			$contents[] = array('text' => '<br />Reply:<br />' . zen_draw_textarea_field('pages_html_text', '', '40', '15'));
			$contents[] = array('text' => '<br />'. zen_image_submit('button_save.gif', IMAGE_SAVE). ' <a href="' . zen_href_link(FILENAME_CUSTOMER_QUESTION) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
			break;

		default:
			if (isset($qInfo) && is_object($qInfo)) {
				$heading[] = array('text' => '<strong>Question ID[' . $qInfo->question_id . ']&nbsp;&nbsp;' . zen_datetime_short($qInfo->submit_time) . '</strong>');
				$contents = array('form' => zen_draw_form('customer_question', FILENAME_CUSTOMER_QUESTION, 'page=' . $_GET['page'] . '&qID=' . $qInfo->id . '&action=save', 'post'));
				$contents[] = array('text' => zen_draw_hidden_field('question_id', $qInfo->question_id));
				$contents[] = array('text' => '<br />Customer Name:<br>' . $qInfo->customer_name);
				$contents[] = array('text' => '<br />Customer Email:<br>' . $qInfo->customer_email. zen_draw_hidden_field('customer_email', $qInfo->customer_email));
				$contents[] = array('text' => '<br />Submit Time:<br>' . $qInfo->submit_time . zen_draw_hidden_field('submit_time', $qInfo->submit_time));

				$languages = zen_get_languages();
				$c_question = $pages_html_text = '';
				for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
					$customer_question_sql = "select * from " . TABLE_CUSTOMER_QUESTION . " where question_id = '" . $qInfo->question_id . "' and language_id = '" . $languages[$i]['id'] . "'";
					$customer_question = $db->Execute($customer_question_sql);
					$c_question .= '<br />'.zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;'.  zen_draw_textarea_field('c_question['. $languages[$i]['id'] .']', '', '40', '15', $customer_question->fields['question_content']);
					$pages_html_text .= '<br />'.zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;'.	zen_draw_textarea_field('pages_html_text['. $languages[$i]['id'] .']', '', '40', '15', $customer_question->fields['question_reply']);
				}
				$contents[] = array('text' => '<br />Question:<br>' . $c_question);
				$contents[] = array('text' => '<br />Reply:<br>' . $pages_html_text);
				if (zen_not_null($qInfo->reply_time)){
					$contents[] = array('text' => '<br />Reply Time:<br>' . $qInfo->reply_time);
				}
				$contents[] = array('text' => '<br />'. zen_image_submit('button_save.gif', IMAGE_SAVE). '<a href="' . zen_href_link(FILENAME_CUSTOMER_QUESTION, 'page=' . $_GET['page'] . '&qID=' . $qInfo->id . '&question_id=' . $qInfo->question_id . '&action=delete') . '">' . zen_image_button('button_delete.gif') . '</a>');
			}
	}

	if ( (zen_not_null($heading)) && (zen_not_null($contents)) ) {
		echo '<td width="25%" valign="top">' . "\n";
		$box = new box;
		echo $box->infoBox($heading, $contents);
		echo '</td>' . "\n";
	}
?>
			</tr>
		</table></td>
	</tr>
<?php// } ?>
</table>
<!-- body_eof //-->

<!-- footer //-->
<div class="footer-area">
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</div>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
