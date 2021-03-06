<?php
/**
 * cash_account.php
 * ���������ļ�
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
  define('CASH_ACCOUNT_NOTIFY_TOP_DESCRIPTION', 'Dear %s <br /><br /> 
                              Please kindly note that we have added %s to your account. <br /><br /> 
                              ※ Detailed information about the <font color="red">credit</font>:<br /><br /> 
                              <b>How to use it?</b><br /><br /> 
                              %s will be deducted from your next order automatically. It will be shown after you clicking "confirm order" button, which is just as picture below shows.<br /><br /> 
                              <img src="'.DIR_WS_IMAGES.'/cash_credit.jpeg" /><br /><br /> 
                              Additional info about this credit:<br /><br /> 
                              <b>%s</b> <br /><br /> 
                              To view the details of your credit account, please login in to <a href="'.HTTP_SERVER.'/index.php?main_page=myaccount">your doreenbeads account</a>, go to “My Account” on our site homepage and click "Credit Account - Balance". Then, you will see all detailed information.<br /><br /> 
                              Thank you for shopping with us!<br /><br /> 
                              Best Wishes,
                              On Behalf of doreenbeads Team <br /><br /> 
                              <a href="'.HTTP_SERVER.'">www.doreenbeads.com</a>
                              ');
    // 删除Banlance时 发送邮件模板 
  define('CASH_ACCOUNT_NOTIFY_DEL_DESCRIPTION','Dear %s <br /><br />
                               Please kindly note that the below credit has been deleted from your account，<br /><br />
                               discussed with Doreenbeads customer service. <br /><br />
                               Deleted amount: %s<br /><br />
                               Original memo: %s<br /><br />
                               Best wishes<br />
                               Doreenbeads Team
                              ');
  define('CASH_ACCOUNT_NOTIFY_DEL_DESCRIPTION','');
  
  define('CASH_ACCOUNT_NOTIFY_CUSTOMER_SUBJECT', ' has been added in your credit account.');
  
  define('CASH_ACCOUNT_NOTIFY_CUSTOMER_SUBJECT1', ' has been recorded in your credit account, you would pay it with your next order.'); 
  
  define('CASH_ACCOUNT_NOTIFY_CONTENTS', 'in your account. This amount will be credited in your next order when you shop with us again. <br />' . '<br />Additional info about this credit:<br />');
  
  define('CASH_ACCOUNT_NOTIFY_CONTENTS1', 'in your account. This amount will be added in your next order when you shop with us again. <br />' . '<br />Additional info about this credit:<br />');
  
  define('CASH_ACCOUNT_NOTIGY_BOTTOM_DESCRIPTION', 'To view the details of your credit account, please login our website , check in "My Account" section and then click "Credit Account - Balance" at <a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">www.doreenbeads.com</a><br />'. "\n\n" . 'and then you will find all detailed information<br /><br />'. "\n\n" .'Thank you for shopping with us!
<br /> '. "\n\n". 'Best wishes for you!<br /> '. "\n\n". ' On Behalf of doreenbeads Team<br />'. "\n\n".'<a href="'.HTTP_SERVER . DIR_WS_CATALOG.'">www.doreenbeads.com</a>');

  define('TEXT_INFO_ADJUSTED_AMOUNT', 'Adjusted Amount');
  ?>
