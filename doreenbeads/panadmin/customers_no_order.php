<?php
/**
 * @package admin
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: mail.php 7197 2007-10-06 20:35:52Z drbyte $
 */

  require('includes/application_top.php');
  
 	$last_month = time()-30*24*3600;
 	$last_month = date('Y-m-d H:i:s', $last_month);
  	
	$customers_without_order = $db->Execute("select c.customers_id, customers_firstname, customers_lastname, customers_email_address,ci.customers_info_date_account_created
											 from " . TABLE_CUSTOMERS . " c, ".TABLE_CUSTOMERS_INFO." ci
											where c.customers_id not in (select distinct customers_id from ".TABLE_CUSTOMERS_NO_ORDER." where email_status=1)
											and c.customers_id=ci.customers_info_id
											and c.customers_level=0
											and ci.customers_info_date_account_created<='".$last_month."' limit 0,100");
	
	if ($customers_without_order->RecordCount() > 0){
		$customers_details = array();
		$row = 0;
		$col = 0;
		$input_num = 0;
		$customers_num = $customers_without_order->RecordCount();
		while (!$customers_without_order->EOF){
			$customers_details[$row][$col] = array('text' => '<table width="100%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td width="5%" align="center"><input type="checkbox" checked="checked" name="' . 'customer_' . $input_num . '" value="' . $customers_without_order->fields['customers_email_address'] . '" />
																						<input type="hidden" name="customerid_' . $input_num . '" value="' . $customers_without_order->fields['customers_id'] . '">
																						<input type="hidden" name="firstname_' . $input_num . '" value="' . $customers_without_order->fields['customers_firstname'] . '">
																						<input type="hidden" name="lastname_' . $input_num . '" value="' . $customers_without_order->fields['customers_lastname'] . '">
																						<input type="hidden" name="createtime_' . $input_num . '" value="' . $customers_without_order->fields['customers_info_date_account_created'] . '">
																			</td>
																			<td width="25%" align="center">' . $customers_without_order->fields['customers_firstname'] . ' ' . $customers_without_order->fields['customers_lastname'] . '</td>
																			<td width="45%" align="center">' .($_SESSION['show_customer_email'] ? $customers_without_order->fields['customers_email_address'] : strstr($customers_without_order->fields['customers_email_address'], '@', true) . '@'). '</td>
																			<td width="25%" align="center">' . substr($customers_without_order->fields['customers_info_date_account_created'], 0, 10) . '</td>
																		</tr>
																	</table>');
			$input_num++;
			$col++;
			if ($col > 2){
				$col = 0;
				$row++;
			}
			$customers_without_order->MoveNext();
		}
	}else{
		$customers_details = 'Nobody need to be notified.';
	}
  

  //DEBUG:  // these defines will become configuration switches in ADMIN in a future version.
  //DEBUG:  // right now, attachments aren't working right unless only sending HTML messages with NO text-only version supplied.
  if (!defined('EMAIL_ATTACHMENTS_ENABLED'))        define('EMAIL_ATTACHMENTS_ENABLED',false);
  if (!defined('EMAIL_ATTACHMENT_UPLOADS_ENABLED')) define('EMAIL_ATTACHMENT_UPLOADS_ENABLED',false);
  
  
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  
  if ($action == 'set_editor') {
    // Reset will be done by init_html_editor.php. Now we simply redirect to refresh page properly.
    $action='';
    zen_redirect(zen_href_link(FILENAME_CUSTOMERS_NO_ORDER));
  }
  
  if ( ($action == 'send_email_to_user') && !isset($_POST['back_x']) ) {
    // error message if no email address
	$sent_mail_to_customer_num = (int)$_POST['post_total_num'];
	
    if ($sent_mail_to_customer_num == '') {
      $messageStack->add_session(ERROR_NO_CUSTOMER_SELECTED, 'error');
      $_GET['action']='';
      zen_redirect(zen_href_link(FILENAME_CUSTOMERS_NO_ORDER));
    }
  
    $from = zen_db_prepare_input($_POST['from']);
    $subject = zen_db_prepare_input($_POST['subject']);
    //$message = zen_db_prepare_input($_POST['message']);
    //$html_msg['EMAIL_MESSAGE_HTML'] = zen_db_prepare_input($_POST['message_html']);
    $attachment_file = $_POST['attachment_file'];
    $attachment_fname = basename($_POST['attachment_file']);
    $attachment_filetype = $_POST['attachment_filetype'];
  
    // demo active test
    if (zen_admin_demo()) {
      $_GET['action']= '';
      $messageStack->add_session(ERROR_ADMIN_DEMO, 'caution');
      zen_redirect(zen_href_link(FILENAME_CUSTOMERS_NO_ORDER, 'mail_sent_to=' . urlencode($mail_sent_to)));
    }
	
	for ($i = 0; $i < $sent_mail_to_customer_num; $i++){
		$customers_email_address_to[$i] = array('mail_address' => $_POST['customer_' . $i],
												'customer_id' => $_POST['customerid_' . $i],
												'first_name' => $_POST['firstname_' . $i],
												'last_name' => $_POST['lastname_' . $i],
												'createtime' => $_POST['createtime_'.$i]);
	}
  
    //send message using the zen email function
    //echo'EOF-attachments_list='.$attachment_file.'->'.$attachment_filetype;
    $recip_count=0;
    while ($recip_count < sizeof($customers_email_address_to)) {
      $html_msg['EMAIL_FIRST_NAME'] = $customers_email_address_to[$recip_count]['first_name'];
      $html_msg['EMAIL_LAST_NAME']  = $customers_email_address_to[$recip_count]['last_name'];
      $html_msg['EMAIL_REGISTER_TIME'] = $customers_email_address_to[$recip_count]['createtime'];
      $html_msg['EMAIL_MESSAGE_HTML'] = zen_db_prepare_input($_POST['message_html']);
      $message = zen_db_prepare_input($_POST['message']);
      
      //$time_stamp = time() + 15 * 24 * 60 * 60;
    //  $expiration_date = date('F  j, Y', $time_stamp);
      $html_msg['EMAIL_MESSAGE_HTML'] = str_replace('create_time', $html_msg['EMAIL_REGISTER_TIME'], $html_msg['EMAIL_MESSAGE_HTML']);
      $html_msg['EMAIL_MESSAGE_HTML'] = str_replace('first_name', $html_msg['EMAIL_FIRST_NAME'], $html_msg['EMAIL_MESSAGE_HTML']);
      //$html_msg['EMAIL_MESSAGE_HTML'] = str_replace('Expiration_date', $expiration_date, $html_msg['EMAIL_MESSAGE_HTML']);
      $message = str_replace('create_time', $html_msg['EMAIL_REGISTER_TIME'], $message);
      $message = str_replace('first_name', $customers_email_address_to[$recip_count]['first_name'], $message);
      //$message = str_replace('Expiration_date', $expiration_date, $message);
      
      file_put_contents('/var/www/no_order.html', $html_msg['EMAIL_MESSAGE_HTML'].'<br/>'."\r\n",FILE_APPEND);
      //zen_mail($customers_email_address_to[$recip_count]['first_name'] . ' ' . $customers_email_address_to[$recip_count]['last_name'], $customers_email_address_to[$recip_count]['mail_address'], $subject, $message, STORE_NAME, $from, $html_msg, 'direct_email', array('file' => $attachment_file, 'name' => basename($attachment_file), 'mime_type'=>$attachment_filetype) );
      $email_history_date_array = array('customers_id' => $customers_email_address_to[$recip_count]['customer_id'],
      									'email_status' => 1,
      									'send_time' => 'now()',
      									'send_by' => (int)$_SESSION['admin_id']);
      zen_db_perform(TABLE_CUSTOMERS_NO_ORDER, $email_history_date_array);
      $recip_count++;
    }
    if ($recip_count > 0) {
      $messageStack->add_session(sprintf(NO_ORDER_EMAIL_SEND_TO, '(' . $recip_count . ')'), 'success');
    } else {
      $messageStack->add_session(sprintf(NO_ORDER_EMAIL_FAILED_SEND, '(' . $recip_count . ')'), 'error');
    }
    zen_redirect(zen_href_link(FILENAME_CUSTOMERS_NO_ORDER, 'mail_sent_to=' . urlencode($mail_sent_to) . '&recip_count='. $recip_count ));
  }
  
  if ( EMAIL_ATTACHMENTS_ENABLED && $action == 'preview') {
    // PROCESS UPLOAD ATTACHMENTS
    if (isset($_FILES['upload_file']) && zen_not_null($_FILES['upload_file']) && ($_POST['upload_file'] != 'none')) {
      if ($attachments_obj = new upload('upload_file')) {
        $attachments_obj->set_destination(DIR_WS_ADMIN_ATTACHMENTS . $_POST['attach_dir']);
        if ($attachments_obj->parse() && $attachments_obj->save()) {
          $attachment_file = $_POST['attach_dir'] . $attachments_obj->filename;
          $attachment_fname = $attachments_obj->filename;
          $attachment_filetype= $_FILES['upload_file']['type'];
        }
      }
    }
  } 

  // error detection
  if ($action == 'preview') {
  
  	$customers_select_num = 0;
	$customers_counter = 0;
	$total_customers_num = (int)$_POST['customers_num'];
	while ($customers_counter < $total_customers_num){
		if ($_POST['customer_' . $customers_counter] != ''){
			$customers_email_address_to[$customers_select_num] = $_POST['customer_' . $customers_counter];
			$customers_select_num++;
		}
		$customers_counter++;
	}
	
    if (sizeof($customers_email_address_to) == 0) {
      $messageStack->add(ERROR_NO_CUSTOMER_SELECTED, 'error');
    }

    if ( !$_POST['subject'] ) {
      $messageStack->add(ERROR_NO_SUBJECT, 'error');
    }
  
    if ( !$_POST['message'] && !$_POST['message_html'] ) {
      $messageStack->add(ENTRY_NOTHING_TO_SEND, 'error');
    }
  }

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script type="text/javascript">
<!--
function init()
{
  cssjsmenu('navbar');
  if (document.getElementById)
  {
    var kill = document.getElementById('hoverJS');
    kill.disabled = true;
  }
  if (typeof _editor_url == "string") HTMLArea.replace('message_html');
}
// -->
</script>
<?php if ($editor_handler != '') include ($editor_handler); ?>
<script language="javascript" type="text/javascript"><!--

function init_select_all(mail, v){
	for (var i = 0; i < document.mail.elements.length; i++){
		var e = document.mail.elements[i];
		if (e.type == "checkbox"){
			e.checked = v;
		}
	}
}
//--></script>
</head>
<body onLoad="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
      <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td class="pageHeading"><?php echo PAGE_TITLE; ?></td>
          <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          <td class="main"><?php
  // toggle switch for editor
  echo TEXT_EDITOR_INFO . zen_draw_form('set_editor_form', FILENAME_CUSTOMERS_NO_ORDER, '', 'get') . '&nbsp;&nbsp;' . zen_draw_pull_down_menu('reset_editor', $editors_pulldown, $current_editor_key, 'onChange="this.form.submit();"') .
  zen_hide_session_id() .
  zen_draw_hidden_field('action', 'set_editor') .
  '</form>';
?></td>
        </tr>
        
    <tr>
      <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if ( ($action == 'preview') ) {
    //$audience_select = get_audience_sql_query(zen_db_input($_POST['customers_email_address']));
    //$mail_sent_to = $audience_select['query_name'];
?>
        <tr>
          <td><table border="0" width="100%" cellpadding="0" cellspacing="2">
            <tr>
              <td class="smallText"><b><?php echo TEXT_CUSTOMER; ?></b>&nbsp;&nbsp;&nbsp;
			  <?php 
				$customer_num = (int)$_POST['customers_num'];
				$customers_post_name_num = 0;
				$counter = 0;
				while ($counter < $customer_num){
					if ($_POST['customer_' . $counter] != ''){
						$customers_post_name[$customers_post_name_num] = $_POST['firstname' . $counter] . $_POST['lastname_' . $counter] . ': ' . $_POST['customer_' . $counter];
						$customers_post_name_num++;
					}
					$counter++;
				}
				
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">' . "\n" . '<tr>' . "\n";
				echo '<td style="padding:10px; line-height:180%;">' . "\n";
				for ($k = 1; $k <= sizeof($customers_post_name); $k++){
					echo $customers_post_name[$k - 1] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					if ($k % 4 == 0){
						echo '<br>';
					}
				}
				echo '</td>' . "\n";
				echo '</tr>' . "\n" . '</table>' . "\n";
			  ?>
			  </td>
            </tr>
            <tr>
              <td class="smallText"><b><?php echo TEXT_FROM; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo htmlspecialchars(stripslashes($_POST['from'])); ?></td>
            </tr>
            <tr>
              <td class="smallText"><b><?php echo TEXT_SUBJECT; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo htmlspecialchars(stripslashes($_POST['subject'])); ?></td>
            </tr>
            <tr>
              <td class="smallText"><b><hr /><?php echo strip_tags(TEXT_MESSAGE_HTML); ?></b></td>
            </tr>
            <tr>
              <td width="500">
<?php if (EMAIL_USE_HTML != 'true') echo TEXT_WARNING_HTML_DISABLED.'<br />'; ?>
<?php $html_preview = stripslashes($_POST['message_html']); echo (stristr($html_preview, '<br>') ? $html_preview : nl2br($html_preview)); ?><hr /></td>
            </tr>
            <tr>
              <td class="smallText"><b><?php echo strip_tags(TEXT_MESSAGE); ?></b><br /></td>
            </tr>
            <tr>
              <td>
<?php
  $message_preview = ((is_null($_POST['message']) || $_POST['message']=='') ? $_POST['message_html'] : $_POST['message'] );
  $message_preview = (stristr($message_preview, '<br') ? $message_preview : nl2br($message_preview));
  $message_preview = str_replace(array('<br>','<br />'), "<br />\n", $message_preview);
  $message_preview = str_replace('</p>', "</p>\n", $message_preview);
  echo '<tt>' . nl2br(htmlspecialchars(stripslashes(strip_tags($message_preview))) ) . '</tt>';
?>
                <hr />
              </td>
            </tr>
<?php if (EMAIL_ATTACHMENTS_ENABLED && ($upload_file_name != '' || $attachment_file != '')) { ?>
            <tr>
              <td class="smallText"><b><?php echo TEXT_ATTACHMENTS_LIST; ?></b><?php echo '&nbsp;&nbsp;&nbsp;' . ((EMAIL_ATTACHMENT_UPLOADS_ENABLED && zen_not_null($upload_file_name)) ? $upload_file_name : $attachment_file) ; ?></td>
            </tr>
<?php } ?>
            <tr>
              <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
            </tr>
            <tr><?php echo zen_draw_form('mail', FILENAME_CUSTOMERS_NO_ORDER, 'action=send_email_to_user'); ?>
              <td>
<?php
  /* Re-Post all POST'ed variables */
  reset($_POST);
  $customers_num = (int)$_POST['customers_num'];
  $customers_post_num = 0;
  $i = 0;
  while ($i < $customers_num){
  	if ($_POST['customer_' . $i] != ''){
		$customer_email_address[$customers_post_num] = $_POST['customer_' . $i];
		$customer_id[$customers_post_num] = $_POST['customerid_' . $i];
		$customer_first_name[$customers_post_num] = $_POST['firstname_' . $i];
		$customer_last_name[$customers_post_num] = $_POST['lastname_' . $i];
		$customer_register_time[$customers_post_num] = $_POST['createtime_' . $i];
		//$customer_dob[$customers_post_num] = $_POST['dob_' . $i];
		$customers_post_num++;
	}
	$i++;
  }
  
  for ($j = 0; $j < sizeof($customer_email_address); $j++){
  	echo zen_draw_hidden_field('customer_' . $j, $customer_email_address[$j]);
  	echo zen_draw_hidden_field('customerid_' . $j, $customer_id[$j]);
	echo zen_draw_hidden_field('firstname_' . $j, $customer_first_name[$j]);
	echo zen_draw_hidden_field('lastname_' . $j, $customer_last_name[$j]);
	echo zen_draw_hidden_field('createtime_' . $j, $customer_register_time[$j]);
  }
  
  echo zen_draw_hidden_field('from', $_POST['from']);
  echo zen_draw_hidden_field('subject', $_POST['subject']);
  echo zen_draw_hidden_field('message_html', $_POST['message_html']);
  echo zen_draw_hidden_field('message', $_POST['message']);
  echo zen_draw_hidden_field('upload_file', stripslashes($upload_file_name));
  echo zen_draw_hidden_field('attachment_file', $attachment_file);
  echo zen_draw_hidden_field('attachment_filetype', $attachment_filetype);
  echo zen_draw_hidden_field('post_total_num', sizeof($customer_email_address));
?>
                <table border="0" width="100%" cellpadding="0" cellspacing="2">
                  <tr>
                    <td><?php echo zen_image_submit('button_back.gif', IMAGE_BACK, 'name="back"'); ?></td>
                    <td align="right"><?php echo '<a href="' . zen_href_link(FILENAME_CUSTOMERS_NO_ORDER) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a> ' . zen_image_submit('button_send_mail.gif', IMAGE_SEND_EMAIL); ?></td>
                  </tr>
                </table></td></form>
              </tr>
              </table></td>
            </tr>
<?php
} else {
?>
            <tr><?php echo zen_draw_form('mail', FILENAME_CUSTOMERS_NO_ORDER,'action=preview','post', 'onsubmit="return check_form(mail);" enctype="multipart/form-data"'); ?>
              <td><table border="0" cellpadding="0" cellspacing="2">
			  
            <tr>
              <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
            </tr>
			
            <tr>
              <td valign="top" class="main"><?php echo TEXT_CUSTOMER; ?></td>
              <td>
			  <?php
			  	if (is_array($customers_details) && sizeof($customers_details) > 0){
					echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">' . "\n";
					echo '<tr>' . "\n";
					echo '	<td colspan="4" style="border:1px solid #000000;"><input type="checkbox" checked="checked" name="selectall" value="" id="selectall" onclick="init_select_all(this.form, this.checked)" /><label for="selectall">Select All</label><input type="hidden" name="customers_num" value="' . $customers_num . '"></td>';
					echo '</tr>' . "\n";
					for ($row = 0; $row < sizeof($customers_details); $row++){
						echo '<tr>' . "\n";
						for ($col = 0; $col < sizeof($customers_details[$row]); $col++){
							echo '<td width="50%" style="border:1px solid #000000;">' . $customers_details[$row][$col]['text'] . '</td>' . "\n";
						}
						echo '</tr>' . "\n";
					}
					echo '<tr>' . "\n";
					echo '	<td colspan="4" style="border:1px solid #000000;"><input type="checkbox" checked="checked" name="selectall" value="" id="selectall" onclick="init_select_all(this.form, this.checked)" /><label for="selectall">Select All</label><input type="hidden" name="customers_num" value="' . $customers_num . '"></td>';
					echo '</tr>' . "\n";
					echo '</table>' . "\n";
				}else{
					echo $customers_details;
				}			  	
			  ?>			  
			  <td>
            </tr>
            <tr>
              <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
            </tr>
            <tr>
              <td class="main"><?php echo TEXT_FROM; ?></td>
              <td><?php echo zen_draw_input_field('from', EMAIL_FROM, 'size="50"'); ?></td>
            </tr>
            <tr>
              <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
            </tr>
            <tr>
              <td class="main"><?php echo TEXT_SUBJECT; ?></td>
              <td><?php echo zen_draw_input_field('subject', 'You have never paid an order', 'size="50"'); ?></td>
            </tr>
            <tr>
              <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
            </tr>
            <tr>
              <td valign="top" class="main"><?php echo TEXT_MESSAGE_HTML; //HTML version?></td>
              <td class="main" width="750">
<?php if (EMAIL_USE_HTML != 'true') echo TEXT_WARNING_HTML_DISABLED; ?>
<?php  if (EMAIL_USE_HTML == 'true') {
	$email_model = $db->Execute("select title, content, content_html from " . TABLE_NEWSLETTERS . " where title = 'You have never paid an order'");
	$html_code = $email_model->fields['content_html'];
	$text_code = $email_model->fields['content'];

    if ($_SESSION['html_editor_preference_status']=="FCKEDITOR") {
      $oFCKeditor = new FCKeditor('message_html') ;
      $oFCKeditor->Value = $html_code;
      $oFCKeditor->Width  = '97%' ;
      $oFCKeditor->Height = '350' ;
//    $oFCKeditor->Create() ;
      $output = $oFCKeditor->CreateHtml() ; echo $output;
    } else { // using HTMLAREA or just raw "source"
      echo zen_draw_textarea_field('message_html', 'soft', '100%', '25', $html_code, 'id="message_html"');
    }
} ?>              </td>
            </tr>
            <tr>
              <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
            </tr>
            <tr>
              <td valign="top" class="main"><?php echo TEXT_MESSAGE; ?></td>
              <td><?php echo zen_draw_textarea_field('message', 'soft', '100%', '15', $text_code); ?></td>
            </tr>
            
<?php if (defined('EMAIL_ATTACHMENTS_ENABLED') && EMAIL_ATTACHMENTS_ENABLED === true && defined('DIR_WS_ADMIN_ATTACHMENTS') && is_dir(DIR_WS_ADMIN_ATTACHMENTS) && is_writable(DIR_WS_ADMIN_ATTACHMENTS) ) { ?>
            <tr>
              <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
            </tr>
<?php if (defined('EMAIL_ATTACHMENT_UPLOADS_ENABLED') && EMAIL_ATTACHMENT_UPLOADS_ENABLED === true) { ?>
<?php
  $dir = @dir(DIR_WS_ADMIN_ATTACHMENTS);
  $dir_info[] = array('id' => '', 'text' => "admin-attachments");
  while ($file = $dir->read()) {
    if (is_dir(DIR_WS_ADMIN_ATTACHMENTS . $file) && strtoupper($file) != 'CVS' && $file != "." && $file != "..") {
      $dir_info[] = array('id' => $file . '/', 'text' => $file);
    }
  }
  $dir->close();
?>
            <tr>
              <td class="main" valign="top"><?php echo TEXT_SELECT_ATTACHMENT_TO_UPLOAD; ?></td>
              <td class="main"><?php echo zen_draw_file_field('upload_file') . '<br />' . stripslashes($_POST['upload_file']) . zen_draw_hidden_field('prev_upload_file', stripslashes( $_POST['upload_file']) ); ?><br />
<?php echo TEXT_ATTACHMENTS_DIR; ?>&nbsp;<?php echo zen_draw_pull_down_menu('attach_dir', $dir_info); ?></td>
            </tr>
            <tr>
              <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
            </tr>
<?php  } // end uploads-enabled dialog ?>
<?php
  $dir = @dir(DIR_WS_ADMIN_ATTACHMENTS);
  $file_list[] = array('id' => '', 'text' => "(none)");
  while ($file = $dir->read()) {
    if (is_file(DIR_WS_ADMIN_ATTACHMENTS . $file) && strtoupper($file) != 'CVS' && $file != "." && $file != "..") {
      $file_list[] = array('id' => $file , 'text' => $file);
    }
  }
  $dir->close();
?>
            <tr>
              <td class="main" valign="top"><?php echo TEXT_SELECT_ATTACHMENT; ?></td>
              <td class="main"><?php echo zen_draw_pull_down_menu('attachment_file', $file_list, $_POST['attachment_file']); ?></td>
            </tr>
<?php } // end attachments fields ?>
            <tr>
              <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
            </tr>
<?php
  if (isset($_GET['origin'])) {
    $origin = $_GET['origin'];
  } else {
    $origin = FILENAME_DEFAULT;
  }
  if (isset($_GET['mode']) && $_GET['mode'] == 'SSL') {
    $mode = 'SSL';
  } else {
    $mode = 'NONSSL';
  }
?>
            <tr>
              <td colspan="2" align="right"><?php echo zen_image_submit('button_preview.gif', IMAGE_PREVIEW) . '&nbsp;' .
              '<a href="' . zen_href_link($origin, 'cID=' . zen_db_prepare_input($_GET['cID']), $mode) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
            </tr>
          </table></td>
        </form></tr>
<?php
}
?>
<!-- body_text_eof //-->
      </table></td>
    </tr>
  </table></td>
</tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>