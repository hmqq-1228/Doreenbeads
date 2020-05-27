<?php
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_1_1','Enable Wire Transfer Payment Module(Bank of China)');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_1_2','Do you want to accept wire transfer payment?(Bank of China)');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_2_1','Account Name:');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_2_2','Receiver Account Name');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_3_1','Account Number:');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_3_2','Receiver Account Number');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_4_1','Receiver Telephone:');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_4_2','Receiver Telephone');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_5_1','Bank Name:');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_5_2','Bank Name');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_6_1','Bank Branch:');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_6_2','Bank Branch');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_7_1','Swift Code:');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_7_2','Swift Code');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_8_1','Sort order of display.');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_8_2','Sort order of display. Lowest is displayed first.'); 
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_9_1','Set Order Status');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_9_2','Set the status of orders made with this payment module to this value');
  define('MODULE_PAYMENT_WIREBC_NOTES','After you send money, please email us at sale@doreenbeads.com with information:<br/>1) your login name,<br/>2) order#, <br/>3) and total amount you send<br/>');
  define('MODULE_PAYMENT_WIREBC_TEXT_TITLE_HEAD', '<strong>Bank Wire Transfer (Bank of China)</strong>');
  define('MODULE_PAYMENT_WIREBC_TEXT_TITLE_DISCOUNT','&nbsp;(2% discount will be offered if total amount reach to 2000 US$,<br/> commission fee should be paid by payer.)');
  define('MODULE_PAYMENT_WIREBC_TEXT_TITLE_END','<br /><div style="clear:both; padding-bottom:10px;"><span style="color:#F47504"><strong>Be sure read this important note before continue checkout.</strong></span> <a href="'.HTTP_SERVER.'/page.html?chapter=0&id=95" target="_blank">Click here>></a></div>');
  
  define('MODULE_PAYMENT_WIREBC_TEXT_BENEFICIARY_BANK','Beneficiary’s Bank :');
  define('MODULE_PAYMENT_WIREBC_TEXT_SWIFT_CODE','SWIFT Code :');
  define('MODULE_PAYMENT_WIREBC_TEXT_HOLDER_NAME','Bank Account Holder’s Name :');
  define('MODULE_PAYMENT_WIREBC_TEXT_ACCOUNT_NUMBER','Bank Account Number :');  
  define('MODULE_PAYMENT_WIREBC_TEXT_BANK_ADDRESS','Bank Address :');
  define('MODULE_PAYMENT_WIREBC_TEXT_HOLDER_PHONE','Bank Account Holder’s Phone :');
  
  /*
  define('MODULE_PAYMENT_WIREBC_TEXT_DESCRIPTION', 'Make Payable To:<br/><br/>' .  
  '<b>' . MODULE_PAYMENT_WIREBC_TEXT_BENEFICIARY_BANK . '</b> ' . MODULE_PAYMENT_WIREBC_BENEFICIARY_BANK . '<br>' .  
  '<b>' . MODULE_PAYMENT_WIREBC_TEXT_SWIFT_CODE . '</b> ' . MODULE_PAYMENT_WIREBC_SWIFT_CODE . '<br>' . 
  '<b>' . MODULE_PAYMENT_WIREBC_TEXT_HOLDER_NAME . '</b> ' . MODULE_PAYMENT_WIREBC_HOLDER_NAME . '<br>' . 
  '<b>' . MODULE_PAYMENT_WIREBC_TEXT_ACCOUNT_NUMBER . '</b> ' . MODULE_PAYMENT_WIREBC_ACCOUNT_NUMBER . '<br>'  .  
  '<b>' . MODULE_PAYMENT_WIREBC_TEXT_BANK_ADDRESS . '</b> ' . MODULE_PAYMENT_WIREBC_BANK_ADDRESS . '<br>'  .   
  '<b>' . MODULE_PAYMENT_WIREBC_TEXT_HOLDER_PHONE . '</b> ' . MODULE_PAYMENT_WIREBC_HOLDER_PHONE . '<br>'  .  
  '<font size=2 color="red"><b>'.MODULE_PAYMENT_WIREBC_NOTES .'</b></font>');
  */
  define('MODULE_PAYMENT_WIREBC_TEXT_DESCRIPTION', '<table cellpadding="0" cellspacing="0">
                    	<tr>
                        	<th width="135">Beneficiary’s Bank:</th>
                            <td>' . MODULE_PAYMENT_WIREBC_BENEFICIARY_BANK . '</td>
                        </tr>
                        <tr>
                        	<th>SWIFT Code:</th>
                            <td>' . MODULE_PAYMENT_WIREBC_SWIFT_CODE . '</td>
                        </tr>
                        <tr>
                        	<th>Holder’s Name:</th>
                            <td>' . MODULE_PAYMENT_WIREBC_HOLDER_NAME . '</td>
                        </tr>
                    </table>
                    <div class="borderbt"></div>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                        	<th width="135">Account Number:</th>
                            <td>' . MODULE_PAYMENT_WIREBC_ACCOUNT_NUMBER . '</td>
                        </tr>
                        <tr>
                        	<th>Bank Address:</th>
                            <td>' . MODULE_PAYMENT_WIREBC_BANK_ADDRESS . '</td>
                        </tr>
                        <tr>
                        	<th>Holder’s Phone:</th>
                            <td>' . MODULE_PAYMENT_WIREBC_HOLDER_PHONE . '</td>
                        </tr>
                    </table>');
  
  define('MODULE_PAYMENT_WIREBC_TEXT_EMAIL_FOOTER', MODULE_PAYMENT_WIREBC_TEXT_DESCRIPTION);

?>