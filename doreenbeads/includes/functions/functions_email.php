<?php
/**
 * functions_email.php
 * Processes all email activities from Zen Cart
 * Hooks into phpMailer class for actual email encoding and sending
 *
 * @package functions
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: functions_email.php 7336 2007-10-31 12:35:12Z drbyte $
 * 2007-09-30 added encryption support for Gmail Chuck Redman
 */

/**
 * Set email system debugging off or on
 * 0=off
 * 1=show SMTP status errors
 * 2=show SMTP server responses
 * 4=show SMTP readlines if applicable
 * 5=maximum information
 * 'preview' to show HTML-emails on-screen while sending
 */
  date_default_timezone_set('PRC');
  if (!defined('EMAIL_SYSTEM_DEBUG')) define('EMAIL_SYSTEM_DEBUG','0');
  if (!defined('EMAIL_ATTACHMENTS_ENABLED')) define('EMAIL_ATTACHMENTS_ENABLED', true);

  // Gmail transport to use - to enable set to ssl or tls
  if (!defined('SMTPAUTH_EMAIL_PROTOCOL')) define('SMTPAUTH_EMAIL_PROTOCOL', 'none');

/**
 * Send email (text/html) using MIME. This is the central mail function.
 * If using "PHP" transport method, the SMTP Server or other mail application should be configured correctly in server's php.ini
 *
 * @param string $to_name           The name of the recipient, e.g. "Jim Johanssen"
 * @param string $to_email_address  The email address of the recipient, e.g. john.smith@hzq.com
 * @param string $email_subject     The subject of the eMail
 * @param string $email_text        The text of the email, may contain HTML entities
 * @param string $from_email_name   The name of the sender, e.g. Shop Administration
 * @param string $from_email_adrdess The email address of the sender, e.g. info@myzenshop.com
 * @param array  $block             Array containing values to be inserted into HTML-based email template
 * @param string $module            The module name of the routine calling zen_mail. Used for HTML template selection and email archiving.
 *                                  This is passed to the archive function denoting what module initiated the sending of the email
 * @param array  $attachments_list  Array of attachment names/mime-types to be included  (this portion still in testing, and not fully reliable)
**/
  function zen_mail($to_name, $to_address, $email_subject, $email_text, $from_email_name, $from_email_address, $block=array(), $module='default', $attachments_list='', $dbconnect_error = 'false', $cc_address='', $languages_code) {
    global $db, $messageStack, $zco_notifier;

    if(!isset($languages_code) || (isset($languages_code) && empty($languages_code))) {
    	$languages_code = $_SESSION['languages_code'];
    }
     if($module=='link_exchange'){
		$block['CURRENT_EMAIL_LOGO_IMAGE'] = HTTP_SERVER . '/email/' . 'links.png';
		$block['CURRENT_EMAIL_LOGO_LINK']=HTTP_SERVER.'/'.'links-exchange-jewelry-directory.html';
     }else{    
		$email_logo_image_arr=unserialize(zen_get_configuration_key_value('CURRENT_EMAIL_LOGO_IMAGE'));
 		$current_email_logo_image=$email_logo_image_arr[($_SESSION['languages_id']-1)];
  		$email_logo_link_arr=unserialize(zen_get_configuration_key_value('CURRENT_EMAIL_LOGO_LINK'));
  		$current_email_logo_link=$email_logo_link_arr[($_SESSION['languages_id']-1)];
    	$block['CURRENT_EMAIL_LOGO_IMAGE'] = HTTP_SERVER . '/email/' .$_SESSION['language'].'/'. $current_email_logo_image;
    	$block['CURRENT_EMAIL_LOGO_LINK'] = $current_email_logo_link;
     }

	if($module=='checkout'|| $module == 'product_question' || $module == 'contact_us'|| $module == 'EMAIL_MESSAGE_HTML'){
  		$emai_array = explode(",",EMAIL_ARRAY); 
 		$send_to_email = $emai_array[(int)$_SESSION['languages_id']-1]; 
 		if($send_to_email==""){ 
 		    $send_to_email = $emai_array[0]; 
 		} 
 		$email_from = $send_to_email;
  	}elseif($module=='order_status' || $module=='content_only' || $module=='direct_email'){
  		$email_from = $from_email_address;
  	}else{
  		//$email_from = EMAIL_FROM;
  		$email_from = $from_email_address;
  	}
    
    if (!defined('DEVELOPER_OVERRIDE_EMAIL_STATUS') || (defined('DEVELOPER_OVERRIDE_EMAIL_STATUS') && DEVELOPER_OVERRIDE_EMAIL_STATUS == 'site')) 
      if (SEND_EMAILS != 'true') return false;  // if sending email is disabled in Admin, just exit

    if (defined('DEVELOPER_OVERRIDE_EMAIL_ADDRESS') && DEVELOPER_OVERRIDE_EMAIL_ADDRESS != '') $to_address = DEVELOPER_OVERRIDE_EMAIL_ADDRESS;
    
    // ignore sending emails for any of the following pages
    // (The EMAIL_MODULES_TO_SKIP constant can be defined in a new file in the "extra_configures" folder)
    if (defined('EMAIL_MODULES_TO_SKIP') && in_array($module,explode(",",constant('EMAIL_MODULES_TO_SKIP')))) return false;

    // check for injection attempts. If new-line characters found in header fields, simply fail to send the message
    foreach(array($from_email_address, $to_address, $from_email_name, $to_name, $email_subject) as $key=>$value) {
      if (eregi("\r",$value) || eregi("\n",$value)) return false;
    }

    // if no text or html-msg supplied, exit
    if (trim($email_text) == '' && (!zen_not_null($block) || (isset($block['EMAIL_MESSAGE_HTML']) && $block['EMAIL_MESSAGE_HTML'] == '')) ) return false;

    // Parse "from" addresses for "name" <email@address.com> structure, and supply name/address info from it.
    if (eregi(" *([^<]*) *<([^>]*)> *",$from_email_address,$regs)) {
      $from_email_name = trim($regs[1]);
      $from_email_address = $regs[2];
    }
    // if email name is same as email address, use the Store Name as the senders 'Name'
    if ($from_email_name == $from_email_address) $from_email_name = STORE_NAME;

    // loop thru multiple email recipients if more than one listed  --- (esp for the admin's "Extra" emails)...
    foreach(explode(',',$to_address) as $key=>$value) {
      if (eregi(" *([^<]*) *<([^>]*)> *",$value,$regs)) {
        $to_name = str_replace('"', '', trim($regs[1]));
        $to_email_address = $regs[2];
      } elseif (eregi(" *([^ ]*) *",$value,$regs)) {
        $to_email_address = trim($regs[1]);
      }
      if (!isset($to_email_address)) $to_email_address=$to_address; //if not more than one, just use the main one.
      if(preg_match('/^[A-Za-z\d]+([-_.][A-Za-z\d]*)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,9}$/',$to_email_address) <= 0) return false;
      if($to_email_address == '') return false;
      //define some additional html message blocks available to templates, then build the html portion.
      if ($block['EMAIL_TO_NAME']=='')      $block['EMAIL_TO_NAME'] = $to_name;
      if ($block['EMAIL_TO_ADDRESS']=='')   $block['EMAIL_TO_ADDRESS'] = $to_email_address;
      if ($block['EMAIL_SUBJECT']=='')      $block['EMAIL_SUBJECT'] = $email_subject;
      if ($block['EMAIL_FROM_NAME']=='')    $block['EMAIL_FROM_NAME'] = $from_email_name;
      if ($block['EMAIL_FROM_ADDRESS']=='') $block['EMAIL_FROM_ADDRESS'] = $from_email_address;
      $email_html = zen_build_html_email_from_template($module, $block);
      if (!is_array($block) && $block == '' || $block == 'none') $email_html = '';

      // Build the email based on whether customer has selected HTML or TEXT, and whether we have supplied HTML or TEXT-only components
      // special handling for XML content
      if ($email_text == '') {

        $email_text = str_replace(array('<br>','<br />'), "<br />\n", $block['EMAIL_MESSAGE_HTML']);
        $email_text = str_replace('</p>', "</p>\n", $email_text);
        $email_text = ($module != 'xml_record') ? htmlspecialchars(stripslashes(strip_tags($email_text))) : $email_text;
      } else {
        $email_text = ($module != 'xml_record') ? strip_tags($email_text) : $email_text;
      }
     
      if ($module != 'xml_record' && $module != 'default1') {
        if (!strstr($email_text, sprintf(EMAIL_DISCLAIMER, STORE_OWNER_EMAIL_ADDRESS)) && $to_email_address != STORE_OWNER_EMAIL_ADDRESS && !defined('EMAIL_DISCLAIMER_NEW_CUSTOMER')) $email_text .= "\n" . sprintf(EMAIL_DISCLAIMER, STORE_OWNER_EMAIL_ADDRESS);
        if (!strstr($email_text, EMAIL_SPAM_DISCLAIMER) && $to_email_address != STORE_OWNER_EMAIL_ADDRESS) $email_text .= "\n" . EMAIL_SPAM_DISCLAIMER;
      }

      // bof: body of the email clean-up
      // clean up &amp; and && from email text
      while (strstr($email_text, '&amp;&amp;')) $email_text = str_replace('&amp;&amp;', '&amp;', $email_text);
      while (strstr($email_text, '&amp;')) $email_text = str_replace('&amp;', '&', $email_text);
      while (strstr($email_text, '&&')) $email_text = str_replace('&&', '&', $email_text);

      // clean up currencies for text emails
      $zen_fix_currencies = split("[:,]" , CURRENCIES_TRANSLATIONS);
      $size = sizeof($zen_fix_currencies);
      for ($i=0, $n=$size; $i<$n; $i+=2) {
        $zen_fix_current = $zen_fix_currencies[$i];
        $zen_fix_replace = $zen_fix_currencies[$i+1];
        if (strlen($zen_fix_current)>0) {
          while (strpos($email_text, $zen_fix_current)) $email_text = str_replace($zen_fix_current, $zen_fix_replace, $email_text);
        }
      }

      // fix double quotes
      while (strstr($email_text, '&quot;')) $email_text = str_replace('&quot;', '"', $email_text);
      // prevent null characters
      while (strstr($email_text, chr(0))) $email_text = str_replace(chr(0), ' ', $email_text);

      // fix slashes
      $text = stripslashes($email_text);
      $email_html = stripslashes($email_html);
      // eof: body of the email clean-up

      //determine customer's email preference type: HTML or TEXT-ONLY  (HTML assumed if not specified)
      $sql = "select customers_email_format from " . TABLE_CUSTOMERS . " where customers_email_address= :custEmailAddress:";
      $sql = $db->bindVars($sql, ':custEmailAddress:', $to_email_address, 'string');

      $result = $db->Execute($sql);
      $customers_email_format = ($result->RecordCount() > 0) ? $result->fields['customers_email_format'] : '';
      if ($customers_email_format == 'NONE' || $customers_email_format == 'OUT') return; //if requested no mail, then don't send.
//      if ($customers_email_format == 'HTML') $customers_email_format = 'HTML'; // if they opted-in to HTML messages, then send HTML format

      // handling admin/"extra"/copy emails:
      if (ADMIN_EXTRA_EMAIL_FORMAT == 'TEXT' && substr($module,-6)=='_extra') {
        $email_html='';  // just blank out the html portion if admin has selected text-only
      }
      //determine what format to send messages in if this is an admin email for newsletters:
      if ($customers_email_format == '' && ADMIN_EXTRA_EMAIL_FORMAT == 'HTML' && in_array($module, array('newsletters', 'product_notification','link_exchange')) && isset($_SESSION['admin_id'])) {
        $customers_email_format = 'HTML';
      }

      // special handling for XML content
      if ($module == 'xml_record') {
        $email_html = '';
        $customers_email_format =='TEXT';
      }
      //notifier intercept option
      $zco_notifier->notify('NOTIFY_EMAIL_AFTER_EMAIL_FORMAT_DETERMINED');
      $cc_address_array = explode(',', $cc_address);
      $email_reply_to_name    = ($email_reply_to_name)    ? $email_reply_to_name    : (in_array($module, array('contact_us',  'tell_a_friend', 'product_question')) ? $from_email_name    : STORE_NAME);
      $email_reply_to_address = ($email_reply_to_address) ? $email_reply_to_address : (in_array($module, array('contact_us',  'tell_a_friend', 'product_question')) ? $from_email_address : $email_from);
      if (zen_not_null($attachments_list) ) {
      	$attachmentArray = array();
      	//if(count($attachments_list) == count($attachments_list,2)){  //if it is 2d array 
      	if(empty($attachments_list['file']) && !empty($attachments_list[0])){
      		foreach ($attachments_list as $key => $value){
      			if($value['file'] == '' ||  strrchr($value['file'], ".") === false){
      				continue;
      			}
      			$attachmentName = "emailXml/atta/" . date("YmdHis") . mt_rand(10, 99) . strrchr($value['file'], ".");
      			copy($value['file'], $attachmentName);
      			array_push($attachmentArray, $attachmentName);
      		}
      	}else{
      		$attachmentName = "emailXml/atta/" . date("YmdHis") . mt_rand(10, 99) . strrchr($attachments_list['file'], ".");
  			copy($attachments_list['file'], $attachmentName);
  			array_push($attachmentArray, $attachmentName);
      	}      
      } 

      /*******Create email xml start*****copy from 8s*****/
      $xmlFileName = date("YmdHis") . mt_rand(1000, 9999) . ".xml";
      $doc = new DOMDocument("1.0","utf-8");
      $doc->formatOutput=true;
      $root = $doc->createElement("root");
      $root = $doc->appendChild($root);
      $rootAttribute = $doc->createAttribute("module");
      $rootAttribute->appendChild($doc->createTextNode($module));
      $rootAttributeDate = $doc->createAttribute("date_generated");
      $rootAttributeDate->appendChild($doc->createTextNode(date("Y-m-d H:i:s")));
      $root->appendChild($rootAttribute);
      $root->appendChild($rootAttributeDate);
       
      $languagesCode = $doc->createElement("languages_code");
      $languagesCode = $root->appendChild($languagesCode);
      $languagesCode->appendChild($doc->createTextNode($languages_code));
      
      $form = $doc->createElement("from");
      $form = $root->appendChild($form);
      $fromEmailName = $doc->createElement("from_email_name");

      $fromEmailName = $form->appendChild($fromEmailName);
      $fromEmailName->appendChild($doc->createTextNode($from_email_name));
      $fromEmailAddress = $doc->createElement("from_email_address");
      $fromEmailAddress = $form->appendChild($fromEmailAddress);

      $fromEmailAddress->appendChild($doc->createTextNode($from_email_address));
       
      $to = $doc->createElement("to");
      $to = $root->appendChild($to);
      $toName = $doc->createElement("to_name");
      $toName = $to->appendChild($toName);
      $toName->appendChild($doc->createTextNode($to_name));
      $toAddress = $doc->createElement("to_address");
      $toAddress = $to->appendChild($toAddress);
      $toAddress->appendChild($doc->createTextNode($to_email_address));
       
      if(count($cc_address_array) > 0 && !empty($cc_address_array[0])) {
      	$cc = $doc->createElement("cc");
      	$cc = $root->appendChild($cc);
      	foreach ($cc_address_array as $val) {
      		$ccAddress = $doc->createElement("cc_address");
      		$ccAddress = $cc->appendChild($ccAddress);
      		$ccAddress->appendChild($doc->createTextNode(trim($val)));
      	}
      }
       
      $reply = $doc->createElement("reply");
      $reply = $root->appendChild($reply);
      $replyToName = $doc->createElement("reply_to_name");
      $replyToName = $reply->appendChild($replyToName);
      $replyToName->appendChild($doc->createTextNode($email_reply_to_name));
      $replyToEmail = $doc->createElement("reply_to_email");
      $replyToEmail = $reply->appendChild($replyToEmail);
      $replyToEmail->appendChild($doc->createTextNode($email_reply_to_address));
       
      $emailSubject = $doc->createElement("email_subject");
      $emailSubject = $root->appendChild($emailSubject);
      $emailSubject->appendChild($doc->createTextNode($email_subject));
       
      $emailText = $doc->createElement("email_text");
      $emailText = $root->appendChild($emailText);
      $emailText->appendChild($doc->createTextNode($email_text));
       
      $emailHtml = $doc->createElement("email_html");
      $emailHtml = $root->appendChild($emailHtml);
      $emailHtml->appendChild($doc->createTextNode($email_html));
       
      if(count($attachmentArray) > 0) {
      	$attachments = $doc->createElement("attachments");
      	$attachments = $root->appendChild($attachments);
      	foreach($attachmentArray as $filePath) {
      		$attachment = $doc->createElement("attachment");
      		$attachment = $attachments->appendChild($attachment);
      		$attachment->appendChild($doc->createTextNode(HTTP_SERVER . '/' . $filePath));
      	}
      }
      //$doc->save(DIR_FS_CATALOG . "emailXml/orig/" . $xmlFileName);
      
    $dir = 'emailXml/orig/'.date("Ymd").'/';
    
	  if(!is_dir($dir)) {
      
	  	mkdir(DIR_FS_CATALOG . $dir);

	  	chmod(DIR_FS_CATALOG . $dir, 0777);
	  }
	  $doc->save(DIR_FS_CATALOG . $dir . $xmlFileName);
    // var_dump(DIR_FS_CATALOG . $dir.$xmlFileName);exit;
	  $sql_data_array = array(
		'file' => $dir . $xmlFileName,
		'created' => date('Y-m-d H:i:s'),
		'status' => 0
	  );
	  zen_db_perform('t_email_to_crm', $sql_data_array);
	  
      /*******Create email xml end*******/
/**
 * Send the email. If an error occurs, trap it and display it in the messageStack
 */
/*       $ErrorInfo = '';
      $zco_notifier->notify('NOTIFY_EMAIL_READY_TO_SEND');
      if (!($result = $mail->Send())) {
        if (IS_ADMIN_FLAG === true) {
          $messageStack->add_session(sprintf(EMAIL_SEND_FAILED . '&nbsp;'. $mail->ErrorInfo, $to_name, $to_email_address, $email_subject),'error');
        } else {
          $messageStack->add('header',sprintf(EMAIL_SEND_FAILED . '&nbsp;'. $mail->ErrorInfo, $to_name, $to_email_address, $email_subject),'error');
        }
        $ErrorInfo .= $mail->ErrorInfo . '<br />';
      }
      $zco_notifier->notify('NOTIFY_EMAIL_AFTER_SEND');

      // Archive this message to storage log
      // don't archive pwd-resets and CC numbers
      if (EMAIL_ARCHIVE == 'true'  && $module != 'password_forgotten_admin' && $module != 'cc_middle_digs' && $module != 'no_archive') {
        zen_mail_archive_write($to_name, $to_email_address, $from_email_name, $from_email_address, $email_subject, $email_html, $text, $module, $ErrorInfo );
      } // endif archiving */
      
    } // end foreach loop thru possible multiple email addresses
    
    // $zco_notifier->notify('NOTIFY_EMAIL_AFTER_SEND_ALL_SPECIFIED_ADDRESSES');

    // if (EMAIL_FRIENDLY_ERRORS=='false' && $ErrorInfo != '') die('<br /><br />Email Error: ' . $ErrorInfo);

    // return $ErrorInfo;
    
    return '';

  }  // end function


  /**
   * 新的发送邮件方式：从文件发送邮件
   * @author	panduo tech
   * @date		2015/05/29
   * @version	1.0
   */
  function zen_mail_new($mail_array, $dbconnect_error = false){
  	if ($dbconnect_error){
  		define('SEND_EMAILS', 'true');
  		define('STORE_NAME', '8Season-Supplies (Beads & Findings & Supplies OnlineWholesale )');
  		define('CURRENCIES_TRANSLATIONS', '&pound;,?:&euro;,?');
  		define('ADMIN_EXTRA_EMAIL_FORMAT', 'HTML');
  		define('EMAIL_TRANSPORT', 'smtpauth');
  		define('EMAIL_SMTPAUTH_MAIL_SERVER', 'mail.8season.com');
  		define('EMAIL_SMTPAUTH_MAIL_SERVER_PORT', '25');
  		define('EMAIL_SMTPAUTH_MAILBOX', 'supplies@8season.com');
  		define('EMAIL_SMTPAUTH_PASSWORD', 'XieHu_8season');
  		define('EMAIL_FROM', 'supplies@8season.com');
  		define('EMAIL_SEND_MUST_BE_STORE', 'Yes');
  		define('EMAIL_USE_HTML', 'true');
  		define('EMAIL_FRIENDLY_ERRORS', 'true');
  	}
  	 
  	unset($_SESSION['zen_mail_new_error']);
  	$mail =  new PHPMailer();
  	$lang_code = 'en';
  	$mail->SetLanguage($lang_code, DIR_FS_CATALOG . DIR_WS_CLASSES . 'support/');
  	$mail->CharSet =  (defined('CHARSET')) ? CHARSET : "iso-8859-1";
  	$mail->Encoding = (defined('EMAIL_ENCODING_METHOD')) ? EMAIL_ENCODING_METHOD : "7bit";
  	if ((int)EMAIL_SYSTEM_DEBUG > 0 ) $mail->SMTPDebug = (int)EMAIL_SYSTEM_DEBUG;
  
  	/*		switch (EMAIL_TRANSPORT) {
  	 case 'smtp':
  	$mail->IsSMTP();
  	//				$mail->Host = EMAIL_SMTPAUTH_MAIL_SERVER;
  	//				if (EMAIL_SMTPAUTH_MAIL_SERVER_PORT != '25' && EMAIL_SMTPAUTH_MAIL_SERVER_PORT != '') $mail->Port = EMAIL_SMTPAUTH_MAIL_SERVER_PORT;
  	$mail->Host = $mail_array['smtpHost'];
  	if ($mail_array['smtpPort'] != '25' && $mail_array['smtpPort'] != '') $mail->Port = $mail_array['smtpPort'];
  	break;
  	case 'smtpauth':*/
  	$mail->IsSMTP();
  	$mail->SMTPAuth = true;
  	//				$mail->Username = (zen_not_null(EMAIL_SMTPAUTH_MAILBOX)) ? EMAIL_SMTPAUTH_MAILBOX : $email_from;
  	//				$mail->Password = EMAIL_SMTPAUTH_PASSWORD;
  	//				$mail->Host = EMAIL_SMTPAUTH_MAIL_SERVER;
  	//				if (EMAIL_SMTPAUTH_MAIL_SERVER_PORT != '25' && EMAIL_SMTPAUTH_MAIL_SERVER_PORT != '') $mail->Port = EMAIL_SMTPAUTH_MAIL_SERVER_PORT;
  	$mail->Username = (zen_not_null($mail_array['smtpUsername'])) ? $mail_array['smtpUsername'] : '';
  	$mail->Password = $mail_array['smtpPassword'];
  	$mail->Host = $mail_array['smtpHost'];
  	if ($mail_array['smtpPort'] != '25' && $mail_array['smtpPort'] != '') $mail->Port = $mail_array['smtpPort'];
  	/*				break;
  	 case 'PHP':
  	$mail->IsMail();
  	break;
  	case 'Qmail':
  	$mail->IsQmail();
  	break;
  	case 'sendmail':
  	case 'sendmail-f':
  	default:
  	$mail->IsSendmail();
  	if (defined('EMAIL_SENDMAIL_PATH')) $mail->Sendmail = EMAIL_SENDMAIL_PATH;
  	break;
  	}*/
  
  	$mail->Subject  = $mail_array['subject'];
  	$mail->AddAddress($mail_array['toEmail'], $mail_array['toName']);
  	$mail->From     = $mail_array['fromEmail'];
  	$mail->FromName = $mail_array['fromName'];
  	if (zen_not_null($mail_array['cc']) ) foreach ($mail_array['cc'] as $val){
  		$email = trim($val);
  		if (zen_not_null($email)){
  			$mail->AddCC($email);
  		}
  	}
  	$mail->LE = (EMAIL_LINEFEED == 'CRLF') ? "\r\n" : "\n";
  
  	$mail->WordWrap = 76;
  	$mail->AddReplyTo($mail_array['replyEmail'] ? $mail_array['replyEmail'] : $mail_array['fromEmail'], $mail_array['replyName'] ? $mail_array['replyName'] : $mail_array['fromName']);
  
  	if (EMAIL_SEND_MUST_BE_STORE=='Yes') $mail->From = $mail_array['fromEmail'];
  
  	if (EMAIL_TRANSPORT=='sendmail-f' || EMAIL_SEND_MUST_BE_STORE=='Yes') {
  		$mail->Sender = $mail_array['fromEmail'];
  	}
  
  	if (zen_not_null($mail_array['attachment']) ) {
  		if(count($mail_array['attachment']) == count($mail_array['attachment'],2)){  //if it is 2d array
  			foreach ($mail_array['attachment'] as $key => $value){
  				$mail->AddAttachment($value);				 //add all attachments
  			}
  		}else{
  			$mail->AddAttachment($mail_array['attachment']);          // add attachments
  		}
  	}
  
  	$customers_email_format = 'HTML';
  
  	//		if(EMAIL_USE_HTML == 'true' && ($customers_email_format == 'HTML' || (ADMIN_EXTRA_EMAIL_FORMAT != 'TEXT' && substr($module,-6)=='_extra'))) {
  	$mail->IsHTML(true);           // set email format to HTML
  	$mail->Body    = $mail_array['html'];  // HTML-content of message
  	$mail->AltBody = $mail_array['text'];        // text-only content of message
  	//		} else {                           // use only text portion if not HTML-formatted
  	//			$mail->Body    = $text;        // text-only content of message
  	//		}
  
  	if (!$mail->Send()) {
  		$_SESSION['zen_mail_new_error'] = $mail->ErrorInfo;
  		return false;
  	}else{
  		return true;
  	}
  }
  
  
  
  
/**
 * zen_mail_archive_write()
 *
 * this function stores sent emails into a table in the database as a log record of email activity.  This table CAN get VERY big!
 * To disable this function, set the "Email Archives" switch to 'false' in ADMIN!
 *
 * See zen_mail() function description for more details on the meaning of these parameters
 * @param string $to_name
 * @param string $to_email_address
 * @param string $from_email_name
 * @param string $from_email_address
 * @param string $email_subject
 * @param string $email_html
 * @param array $email_text
 * @param string $module
**/
  function zen_mail_archive_write($to_name, $to_email_address, $from_email_name, $from_email_address, $email_subject, $email_html, $email_text, $module, $error_msgs) {
    global $db;
    $to_name = zen_db_prepare_input($to_name);
    $to_email_address = zen_db_prepare_input($to_email_address);
    $from_email_name = zen_db_prepare_input($from_email_name);
    $from_email_address = zen_db_prepare_input($from_email_address);
    $email_subject = zen_db_prepare_input($email_subject);
    $email_html = (EMAIL_USE_HTML=='true') ? zen_db_prepare_input($email_html) : zen_db_prepare_input('HTML disabled in admin');
    $email_text = zen_db_prepare_input($email_text);
    $module = zen_db_prepare_input($module);
    $error_msgs = zen_db_prepare_input($error_msgs);

    /*
    $db->Execute("insert into " . TABLE_EMAIL_ARCHIVE . "
                  (email_to_name, email_to_address, email_from_name, email_from_address, email_subject, email_html, email_text, date_sent, module)
                  values ('" . zen_db_input($to_name) . "',
                          '" . zen_db_input($to_email_address) . "',
                          '" . zen_db_input($from_email_name) . "',
                          '" . zen_db_input($from_email_address) . "',
                          '" . zen_db_input($email_subject) . "',
                          '" . zen_db_input($email_html) . "',
                          '" . zen_db_input($email_text) . "',
                          now() ,
                          '" . zen_db_input($module) . "')");
     */
    return $db;
  }

  //DEFINE EMAIL-ARCHIVABLE-MODULES LIST // this array will likely be used by the email archive log VIEWER module in future
  $emodules_array = array();
  $emodules_array[] = array('id' => 'newsletters', 'text' => 'Newsletters');
  $emodules_array[] = array('id' => 'product_notification', 'text' => 'Product Notifications');
  $emodules_array[] = array('id' => 'direct_email', 'text' => 'One-Time Email');
  $emodules_array[] = array('id' => 'contact_us', 'text' => 'Contact Us');
  $emodules_array[] = array('id' => 'coupon', 'text' => 'Send Coupon');
  $emodules_array[] = array('id' => 'coupon_extra', 'text' => 'Send Coupon');
  $emodules_array[] = array('id' => 'gv_queue', 'text' => 'Send-GV-Queue');
  $emodules_array[] = array('id' => 'gv_mail', 'text' => 'Send-GV');
  $emodules_array[] = array('id' => 'gv_mail_extra', 'text' => 'Send-GV-Extra');
  $emodules_array[] = array('id' => 'welcome', 'text' => 'New Customer Welcome');
  $emodules_array[] = array('id' => 'welcome_extra', 'text' => 'New Customer Welcome-Extra');
  $emodules_array[] = array('id' => 'password_forgotten', 'text' => 'Password Forgotten');
  $emodules_array[] = array('id' => 'password_forgotten_admin', 'text' => 'Password Forgotten');
  $emodules_array[] = array('id' => 'checkout', 'text' => 'Checkout');
  $emodules_array[] = array('id' => 'checkout_extra', 'text' => 'Checkout-Extra');
  $emodules_array[] = array('id' => 'order_status', 'text' => 'Order Status');
  $emodules_array[] = array('id' => 'order_status_extra', 'text' => 'Order Status-Extra');
  $emodules_array[] = array('id' => 'low_stock', 'text' => 'Low Stock Notices');
  $emodules_array[] = array('id' => 'cc_middle_digs', 'text' => 'CC - Middle-Digits');
  $emodules_array[] = array('id' => 'tell_a_friend', 'text' => 'Tell-A-Friend');
  $emodules_array[] = array('id' => 'tell_a_friend_extra', 'text' => 'Tell-A-Friend-Extra');
  $emodules_array[] = array('id' => 'purchase_order', 'text' => 'Purchase Order');
  $emodules_array[] = array('id' => 'payment_modules', 'text' => 'Payment Modules');
  $emodules_array[] = array('id' => 'payment_modules_extra', 'text' => 'Payment Modules-Extra');
  /////////////////////////////////////////////////////////////////////////////////////////
  ////////END SECTION FOR EMAIL FUNCTIONS//////////////////////////////////////////////////
  /////////////////////////////////////////////////////////////////////////////////////////


/**
 * select email template based on 'module' (supplied as param to function)
 * selectively go thru each template tag and substitute appropriate text
 * finally, build full html content as "return" output from class
**/
  function zen_build_html_email_from_template($module='default', $content='') {
    global $messageStack, $current_page_base;
    $block = array();
    if (is_array($content)) {
      $block = $content;
    } else {
      $block['EMAIL_MESSAGE_HTML'] = $content;
    }
    // Identify and Read the template file for the type of message being sent
    $template_filename_base = DIR_FS_EMAIL_TEMPLATES . "email_template_";
    $template_filename = DIR_FS_EMAIL_TEMPLATES . "email_template_" . $current_page_base . ".html";

    if (!file_exists($template_filename)) {
      if (isset($block['EMAIL_TEMPLATE_FILENAME']) && $block['EMAIL_TEMPLATE_FILENAME'] != '' && file_exists($block['EMAIL_TEMPLATE_FILENAME'] . '.html')) {
        $template_filename = $block['EMAIL_TEMPLATE_FILENAME'] . '.html';
      } elseif (file_exists($template_filename_base . str_replace(array('_extra','_admin'),'',$module) . '.html')) {
        $template_filename = $template_filename_base . str_replace(array('_extra','_admin'),'',$module) . '.html';
      } elseif (file_exists($template_filename_base . 'default' . '.html')) {
        $template_filename = $template_filename_base . 'default' . '.html';
      } else {
        $messageStack->add('header','ERROR: The email template file for (' . $template_filename_base . ') or (' . $template_filename . ') cannot be found.','caution');
        return ''; // couldn't find template file, so return an empty string for html message.
      }
    }

    if (!$fh = fopen($template_filename, 'rb')) {   // note: the 'b' is for compatibility with Windows systems
      $messageStack->add('header','ERROR: The email template file (' . $template_filename_base . ') or (' . $template_filename . ') cannot be opened', 'caution');
    }

    $file_holder = fread($fh, filesize($template_filename));
    fclose($fh);

    //strip linebreaks and tabs out of the template
//  $file_holder = str_replace(array("\r\n", "\n", "\r", "\t"), '', $file_holder);
    $file_holder = str_replace(array("\t"), ' ', $file_holder);


    if (!defined('HTTP_CATALOG_SERVER')) define('HTTP_CATALOG_SERVER', HTTP_SERVER);
    //check for some specifics that need to be included with all messages
    if ($block['EMAIL_STORE_NAME']=='')       $block['EMAIL_STORE_NAME']       = STORE_NAME;
    if ($block['EMAIL_STORE_URL']=='')        $block['EMAIL_STORE_URL']        = '<a href="'.HTTP_CATALOG_SERVER . DIR_WS_CATALOG.'">'.STORE_NAME.'</a>';
    if ($block['EMAIL_STORE_OWNER']=='')      $block['EMAIL_STORE_OWNER']      = STORE_OWNER;
    if ($block['EMAIL_FOOTER_COPYRIGHT']=='') $block['EMAIL_FOOTER_COPYRIGHT'] = EMAIL_FOOTER_COPYRIGHT;
    if ($block['EMAIL_DISCLAIMER']=='')       $block['EMAIL_DISCLAIMER']       = sprintf(EMAIL_DISCLAIMER, '<a href="mailto:' . STORE_OWNER_EMAIL_ADDRESS . '">'. STORE_OWNER_EMAIL_ADDRESS .' </a>');
    if ($block['EMAIL_SPAM_DISCLAIMER']=='')  $block['EMAIL_SPAM_DISCLAIMER']  = EMAIL_SPAM_DISCLAIMER;
    if ($block['BASE_HREF']=='')              $block['BASE_HREF']              = HTTP_SERVER . DIR_WS_CATALOG;
    if ($block['EMAIL_DATE_SHORT']=='')       $block['EMAIL_DATE_SHORT']       = zen_date_short(date("Y-m-d"));
    if ($block['EMAIL_DATE_LONG']=='')        $block['EMAIL_DATE_LONG']        = zen_date_long(date("Y-m-d"));
    if ($block['CHARSET']=='')                $block['CHARSET']                = CHARSET;
    //  if ($block['EMAIL_STYLESHEET']=='')       $block['EMAIL_STYLESHEET']       = str_replace(array("\r\n", "\n", "\r"), "",@file_get_contents(DIR_FS_EMAIL_TEMPLATES.'stylesheet.css'));

    if (!isset($block['EXTRA_INFO']))  $block['EXTRA_INFO']  = '';
    if (substr($module,-6) != '_extra' && $module != 'contact_us')  $block['EXTRA_INFO']  = '';

    $block['COUPON_BLOCK'] = '';
    if ($block['COUPON_TEXT_VOUCHER_IS'] && $block['COUPON_TEXT_TO_REDEEM']) {
      $block['COUPON_BLOCK'] = '<div class="coupon-block">' . $block['COUPON_TEXT_VOUCHER_IS'] . $block['COUPON_DESCRIPTION'] . '<br />' . $block['COUPON_TEXT_TO_REDEEM'] . '<span class="coupon-code">' . $block['COUPON_CODE'] . '</span></div>';
    }

    $block['GV_BLOCK'] = '';
    if ($block['GV_WORTH'] && $block['GV_REDEEM'] && $block['GV_CODE_URL']) {
      $block['GV_BLOCK'] = '<div class="gv-block">' . $block['GV_WORTH'] . '<br />' . $block['GV_REDEEM'] . $block['GV_CODE_URL'] . '<br />' . $block['GV_LINK_OTHER'] . '</div>';
    }

    //prepare the "unsubscribe" link:
    if (IS_ADMIN_FLAG === true) { // is this admin version, or catalog?
      $block['UNSUBSCRIBE_LINK'] = str_replace("\n",'',TEXT_UNSUBSCRIBE) . ' <a href="' . zen_catalog_href_link(FILENAME_UNSUBSCRIBE, "addr=" . $block['EMAIL_TO_ADDRESS']) . '">' . zen_catalog_href_link(FILENAME_UNSUBSCRIBE, "addr=" . $block['EMAIL_TO_ADDRESS']) . '</a>';
    } else {
      $block['UNSUBSCRIBE_LINK'] = str_replace("\n",'',TEXT_UNSUBSCRIBE) . ' <a href="' . zen_href_link(FILENAME_UNSUBSCRIBE, "addr=" . $block['EMAIL_TO_ADDRESS']) . '">' . zen_href_link(FILENAME_UNSUBSCRIBE, "addr=" . $block['EMAIL_TO_ADDRESS']) . '</a>';
    }

    //now replace the $BLOCK_NAME items in the template file with the values passed to this function's array    
    foreach ($block as $key=>$value) {
      $file_holder = str_replace('$' . $key, $value, $file_holder);
    }

    //DEBUG -- to display preview on-screen
    if (EMAIL_SYSTEM_DEBUG=='preview') echo $file_holder;

    return $file_holder;
  }


/**
 * Function to build array of additional email content collected and sent on admin-copies of emails:
 *
 */
  function email_collect_extra_info($from, $email_from, $login, $login_email, $login_phone='', $login_fax='') {
    // get host_address from either session or one time for both email types to save server load
    if (!$_SESSION['customers_host_address']) {
      if (SESSION_IP_TO_HOST_ADDRESS == 'true') {
        $email_host_address = @gethostbyaddr($_SERVER['REMOTE_ADDR']);
      } else {
        $email_host_address = OFFICE_IP_TO_HOST_ADDRESS;
      }
    } else {
      $email_host_address = $_SESSION['customers_host_address'];
    }

    // generate footer details for "also-send-to" emails
    $extra_info=array();
    $extra_info['TEXT'] =
      OFFICE_USE . "\t" . "\n" .
      // OFFICE_FROM . "\t" . $from . "\n" .
      OFFICE_EMAIL. "\t" . $email_from . "\n" .
      (trim($login) !='' ? OFFICE_LOGIN_NAME . "\t" . $login . "\n"  : '') .
      (trim($login_email) !='' ? OFFICE_LOGIN_EMAIL . "\t" . $login_email . "\n"  : '') .
      ($login_phone !='' ? OFFICE_LOGIN_PHONE . "\t" . $login_phone . "\n" : '') .
      ($login_fax !='' ? OFFICE_LOGIN_FAX . "\t" . $login_fax . "\n" : '') .
      OFFICE_IP_ADDRESS . "\t" . $_SESSION['customers_ip_address'] . ' - ' . $_SERVER['REMOTE_ADDR'] . "\n" .
      OFFICE_HOST_ADDRESS . "\t" . $email_host_address . "\n" .
      OFFICE_DATE_TIME . "\t" . date("D M j Y G:i:s T") . "\n\n";

    $extra_info['HTML'] = '<table class="extra-info">' .
      '<tr><td class="extra-info-bold" colspan="2">' . OFFICE_USE . '</td></tr>' .
      // '<tr><td class="extra-info-bold">' . OFFICE_FROM . '</td><td>' . $from . '</td></tr>' .
      '<tr><td class="extra-info-bold">' . OFFICE_EMAIL. '</td><td>' . $email_from . '</td></tr>' .
      ($login !='' ? '<tr><td class="extra-info-bold">' . OFFICE_LOGIN_NAME . '</td><td>' . $login . '</td></tr>' : '') .
      ($login_email !='' ? '<tr><td class="extra-info-bold">' . OFFICE_LOGIN_EMAIL . '</td><td>' . $login_email . '</td></tr>' : '') .
      ($login_phone !='' ? '<tr><td class="extra-info-bold">' . OFFICE_LOGIN_PHONE . '</td><td>' . $login_phone . '</td></tr>' : '') .
      ($login_fax !='' ? '<tr><td class="extra-info-bold">' . OFFICE_LOGIN_FAX . '</td><td>' . $login_fax . '</td></tr>' : '') .
      '<tr><td class="extra-info-bold">' . OFFICE_IP_ADDRESS . '</td><td>' . $_SESSION['customers_ip_address'] . ' - ' . $_SERVER['REMOTE_ADDR'] . '</td></tr>' .
      '<tr><td class="extra-info-bold">' . OFFICE_HOST_ADDRESS . '</td><td>' . $email_host_address . '</td></tr>' .
      '<tr><td class="extra-info-bold">' . OFFICE_DATE_TIME . '</td><td>' . date('D M j Y G:i:s T') . '</td></tr>' . '</table>';
    return $extra_info;
  }





/**
 * validates an email address
 *
 * Sample Valid Addresses:
 *
 *     first.last@host.com
 *     firstlast@host.to
 *     "first last"@host.com
 *     "first@last"@host.com
 *     first-last@host.com
 *     first's-address@email.host.4somewhere.com
 *     first.last@[123.123.123.123]
 *
 *     hosts with either external IP addresses or from 2-6 characters will pass (e.g. .jp or .museum)
 *
 *     Invalid Addresses:
 *
 *     first last@host.com
 *     'first@host.com
 * @param string The email address to validate
 * @return booloean true if valid else false
**/
  function zen_validate_email($email) {
    $valid_address = true;

    // fail if contains no @ symbol or more than one @ symbol
    if (substr_count($email,'@') != 1) return false;

    // split the email address into user and domain parts
    // this method will most likely break in that case
    list( $user, $domain ) = explode( "@", $email );
    $valid_ip_form = '[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}';
    $valid_email_pattern = '/^[A-Za-z\d]+([-_.][A-Za-z\d]*)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,9}$/';
    //preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9\._-]+)+$/', $email))
    //preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*?[a-z]+$/is');
    $space_check = '[ ]';

    // strip beginning and ending quotes, if and only if both present
    if( (ereg('^["]', $user) && ereg('["]$', $user)) ){
      $user = ereg_replace ( '^["]', '', $user );
      $user = ereg_replace ( '["]$', '', $user );
      $user = ereg_replace ( $space_check, '', $user ); //spaces in quoted addresses OK per RFC (?)
      $email = $user."@".$domain; // contine with stripped quotes for remainder
    }

    // fail if contains spaces in domain name
    if (strstr($domain,' ')) return false;

    // if email domain part is an IP address, check each part for a value under 256
    if (ereg($valid_ip_form, $domain)) {
      $digit = explode( ".", $domain );
      for($i=0; $i<4; $i++) {
        if ($digit[$i] > 255) {
          $valid_address = false;
          return $valid_address;
          exit;
        }
        // stop crafty people from using internal IP addresses
        if (($digit[0] == 192) || ($digit[0] == 10)) {
          $valid_address = false;
          return $valid_address;
          exit;
        }
      }
    }

      if (ereg($space_check, $email)) { // trap for spaces in
          $valid_address = false;
          return $valid_address;
          exit;
      }

      if ( preg_match($valid_email_pattern, $email)) { // validate against valid email patterns
          $valid_address = true;
      } else {
          $valid_address = false;
          return $valid_address;
          exit;
      }
    return $valid_address;
  }

function zen_validate_url($url){
    $valid_url = true;

    $isMatch1 = preg_match('/((https?:\/\/)|(www\.))([a-z0-9\-\_]+(\.)?)*/i', $url);
    $isMatch2 = preg_match('/(https?:\/\/)?(www)?([a-z0-9\-\_]*[\.])+(com|cn|top|net|wang|xin|shop|beer|art|luxe|ltd|co|cc|club|vip|fun|online|tech|store|red|pro|kim|ink|group|work|ren|link|biz|mobi|site|org|govcn|name|info|tv|asia|cloud|fit|yoga|pub|live|wiki|design)/i', $url);
    $isMatch3 = preg_match('/([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}/i', $url);

    if($isMatch1 != 0 || $isMatch2 != 0 || $isMatch3 != 0){
        $valid_url = false;
    }

    return $valid_url;
}
    
/**
 * 
 * Get remote file contents, preferring faster cURL if available
 * 
 **/
  function remote_get_contents($url)
  {
  	if (function_exists('curl_get_contents') AND function_exists('curl_init'))
  	{
  		return curl_get_contents($url);
  	}
  	else
  	{
  		// A litte slower, but (usually) gets the job done
  		return file_get_contents($url);
  	}
  }
  
  function curl_get_contents($url)
  {
  	// Initiate the curl session
  	$ch = curl_init();
  
  	// Set the URL
  	curl_setopt($ch, CURLOPT_URL, $url);
  
  	// Removes the headers from the output
  	curl_setopt($ch, CURLOPT_HEADER, 0);
  
  	// Return the output instead of displaying it directly
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  
  	// Execute the curl session
  	$output = curl_exec($ch);
  
  	// Close the curl session
  	curl_close($ch);
  
  	// Return the output as a variable
  	return $output;
  }

  function remote_check_email($email){
    if(strpos($email, 'panduo.com.cn')){
    	$result['authentication_status'] = 1;
  		$result['verify_status'] = 1;
  		$result['limit_desc'] = 0;
  		$result['verify_status'] = 1;
  		$result['verify_status_desc'] = 'This is a test email address.';
  		return $result;
  	}
  	$check_account = REMOTE_CHECK_USERNAME;
  	$check_account_password = REMOTE_CHECK_PASSWORD;
  	$api_url = REMOTE_CHECK_URL;
  	$url = $api_url . 'usr=' . $check_account . '&pwd=' . $check_account_password . '&check=' . $email;
  	$result = array();
  	
  	$object	= json_decode(remote_get_contents($url)); // the response is received in JSON format; here we use the function remote_get_contents($url) to detect in witch way to get the remote content
  	
  	$result['authentication_status'] = $object->authentication_status;// (your authentication status: 1 - success; 0 - invalid user)
  	$result['limit_status'] = $object->limit_status;//(1 - verification is not allowed, see limit_desc; 0 - not limited)
  	$result['limit_desc'] = $object->limit_desc;
  	$result['verify_status'] = $object->verify_status;//(entered email is: 1 - OK; 0 - BAD)
  	$result['verify_status_desc'] = $object->verify_status_desc;

  	return $result;
  }
  

?>