<?php
/**
 * cash_account.php
 * 常量定义文件
 */

  define('HEADING_TITLE', 'Credit Account Manage');
  define('TABLE_HEADING_CUSTOMER_ID', 'Customer ID');
  define('TABLE_HEADING_CUSTOMER_NAME', 'Customer Name');
  define('TABLE_HEADING_CUSTOMER_EMAIL', 'Customer Email');
  define('TABLE_HEADING_CREATOR', 'Creator');
  define('TABLE_HEADING_CREATE_DATE', 'Create Date');
  define('TABLE_HEADING_MODIFY_DATE', 'Modify Date');
  define('TABLE_HEADING_STATUS', 'Status');
  define('TABLE_HEADING_ACTION', 'Action');
  define('TABLE_HEADING_CASH_AMOUNT', 'Amount');
  
  define('TEXT_INFO_HEADING_NEW_CASH_ACCOUNT', 'New Credit Account');
  define('TEXT_INFO_CUSTOMER_EMAIL', 'Customer Email: ');
  define('TEXT_INFO_CASH_AMOUNT', 'Cash Amount: ');
  define('TEXT_INFO_CURRENCY_CODE', 'Currency Code: ');
  define('TEXT_INFO_CREATOR', 'Creator: ');
  define('TEXT_INFO_WHO_MODIFY', 'Who Modify: ');
  define('TEXT_INFO_STATUS', 'Status: ');
  define('TEXT_INFO_MEMO', 'Memo: ');
  define('TEXT_INFO_INSERT_INTRO', 'Please enter the new cash account with its related data');
  
  define('TEXT_INFO_CUSTOMER_NAME', 'Customer Name: ');
  define('TEXT_INFO_HEADING_DELETE_CASH_ACCOUNT', 'Delete Credit Account');
  define('TEXT_INFO_DELETE_INTRO', 'Are you sure you want to delete this credit account?');
  define('TEXT_INFO_HEADING_EDIT_CASH_ACCOUNT', 'Edit Credit Account');
  define('TEXT_INFO_EDIT_INTRO', 'Please make any necessary changes');
  define('TEXT_INFO_CREATE_DATE', 'Create Date: ');
  define('TEXT_INFO_MODIFY_DATE', 'Modify Date: ');
  define('TEXT_INFO_NOTIFY_CUSTOMER', 'Notify Customer');
  
  define('TEXT_DISPLAY_NUMBER_OF_CASH_ACCOUNT', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> credit account)');
  define('TEXT_STATUS_DESCRIPTION', '<b>Status:</b> ' . zen_image(DIR_WS_IMAGES . 'icon_status_green.gif') . '&nbsp;Active Status<b>(A)</b>&nbsp;&nbsp;&nbsp;&nbsp;' . zen_image(DIR_WS_IMAGES . 'icon_status_yellow.gif') . '&nbsp;Completion Status<b>(C)</b>&nbsp;&nbsp;&nbsp;&nbsp;' . zen_image(DIR_WS_IMAGES . 'icon_status_red.gif') . '&nbsp;Deleted Status<b>(X)</b>');
  
  //define error text
  define('TEXT_CUSTOMER_NOT_EXIST', 'Customer does not exist, please check!');
  define('TEXT_CUSTOMER_EMAIL_REQUIRED', 'Customer email is required!');
  define('TEXT_CASH_AMOUNT_ERROR', 'Cash amount format is error, please check!');
  define('TEXT_CREATOR_IS_REQUIRED', 'Creator is required');
  define('TEXT_WHO_MODIFY_REQUIRED', 'Who modify is required');
  define('TEXT_CASH_ACCOUNT_ADD_SUCCESSED', 'Credit account added successed');
  define('TEXT_CASH_ACCOUNT_DEL_SUCCESSED', 'Credit account delete successed');
  define('TEXT_CASH_AMOUNT_EXCEED', 'Cash amount should be min %.2f US$ and max %.2f US$, Please check!');
  
   //email content
  define('CASH_ACCOUNT_NOTIFY_TOP_DESCRIPTION', 'Sehr geehrte %s <br /><br /> 
                              Bitte beachten Sie, dass wir Ihrem Konto %s hinzugefügt haben. <br /><br /> 
                              ※ Detaillierte Informationen zu dem Kredit:<br /><br /> 
                              <b>Wie benutzt man es?</b><br /><br /> 
                              %s wird von Ihrer nächsten Bestellung automatisch abgezogen. Sie können es sehen, nachdem Sie auf den \'Bestellung Aufgeben\' Button geklickt haben, wie das Bild darunten zeigt.<br /><br /> 
                              <img src="'.DIR_WS_IMAGES.'/cash_credit.jpeg" /><br /><br /> 
                              Zusätzliche Informationen zu diesem Kredit:<br /><br /> 
                              <b>%s</b> <br /><br /> 
                              Um die Details Ihres Kreditkontos zu sehen, melden Sie sich bitte in <a href="'.HTTP_SERVER.'/index.php?main_page=myaccount">Ihrem doreenbeads Konto</a> an, gehen Sie zu " Mein Konto " auf unserer Homepage und klicken Sie auf " Kredit Konto　-   Balance ". Dann sehen Sie alle detaillierten Informationen.<br /><br /> 
                              Danke für Ihren Einkauf.<br /><br /> 
                              Viele Grüße,
                              Im Namen von doreenbeads Team <br /><br /> 
                              <a href="'.HTTP_SERVER.'">www.doreenbeads.com</a>
                              ');
  // 删除Banlance时 发送邮件模板 
  define('CASH_ACCOUNT_NOTIFY_DEL_DESCRIPTION','Sehr geehrte(r) %s <br /><br />
                               bitte beachten Sie, dass das unten stehende Guthaben von Ihrem Konto，<br /><br />
                               gelöscht wurde, nachdem es mit dem Doreenbeads-Kundenservice besprochen wurde.  <br /><br />
                               Gelöschte Menge: %s<br /><br />
                               Originalnotiz: %s<br /><br />
                               Mit freundlichen Grüßen<br />
                               Doreenbeads Team
                              ');

  define('CASH_ACCOUNT_NOTIFY_CUSTOMER_SUBJECT', ' schon bei Ihrem Kredit Konto angekommen ist.');
  define('CASH_ACCOUNT_NOTIFY_CUSTOMER_SUBJECT1', ' ist schon in Ihrem Kredit-Konto gutgeschrieben.');
  define('CASH_ACCOUNT_NOTIFY_CONTENTS', 'In Ihrem Konto. Dieser Betrag wird in Ihre nächste Bestellung gutgeschreiben, wenn Sie nochmals bestellen. <br />' . '<br />Weitere Information über diese Gutschrift:<br />');
  define('CASH_ACCOUNT_NOTIFY_CONTENTS1', 'Zweitens möchte ich Ihnen mitteilen, aufgrund Ihrer früheren Kauf haben wir <font color="#FF0000">%s</font> in Ihrem Konto gutgeschrieben. Dieser Betrag wird bei der nächsten Bestellung hinzugefügt, wenn Sie wieder bei uns einkaufen. <br />' . '<br /> Weitere Informationen über diesen Kredit:<br />');
  define('CASH_ACCOUNT_NOTIGY_BOTTOM_DESCRIPTION', 'Loggen Sie sich auf unserer Web, die Details Ihrer Kreditkonto zu checken. Klicken Sie "Mein Konto" und dann "Kredit-Konto-Balance" auf <a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">www.doreenbeads.com</a><br/>Danach werden Sie alle detaillierten Informationen finden.<br/><br/>Herzlichen dank für Ihren Einkauf bei uns!<br/>Mit freundlichen Grüßen!<br/>Im Namen des dorabeads-Team<br/><a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">www.doreenbeads.com</a>');
  define('TEXT_INFO_ADJUSTED_AMOUNT', 'Verrechnungswert');
  ?>
