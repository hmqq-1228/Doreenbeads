<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |   
// | http://www.zen-cart.com/index.php                                    |   
// |                                                                      |   
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: wire.php,v 1.0 2004/05/02 Farrukh Saeed
//
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_1_1','Enable Wire Transfer Payment Module');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_1_2','Do you want to accept wire transfer payment?');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_2_1','Account Name:');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_2_2','Receiver Account Name');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_3_1','Account Number:');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_3_2','Receiver Account Number');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_4_1','Receiver Telephone:');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_4_2','Receiver Telephone');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_5_1','Bank Name:');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_5_2','Bank Name');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_6_1','Bank Branch:');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_6_2','Bank Branch');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_7_1','Swift Code:');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_7_2','Swift Code');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_8_1','Sort order of display.');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_8_2','Sort order of display. Lowest is displayed first.'); 
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_9_1','Set Order Status');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_9_2','Set the status of orders made with this payment module to this value');
  
  define('MODULE_PAYMENT_WIRE_TEXT_TITLE', '<strong>Bank Wire Transfer (Citibank)</strong>');
//  define('MODULE_PAYMENT_WIRE_TEXT_DESCRIPTION', 'Make Payable To:<br/><br/>' .  '<b>'. MODULE_PAYMENT_WIRE_TEXT_CONFIG_2_1 . '</b>' . MODULE_PAYMENT_WIRE_NAME . '<br>' .  '<b>'.MODULE_PAYMENT_WIRE_TEXT_CONFIG_3_1 . '</b>' . MODULE_PAYMENT_WIRE_ACCOUNT . '<br>' . '<b>'. MODULE_PAYMENT_WIRE_TEXT_CONFIG_5_1 . '</b>' . MODULE_PAYMENT_WIRE_BANK_NAME . '<br>'  .   '<b>'. MODULE_PAYMENT_WIRE_TEXT_CONFIG_6_1 . '</b>' . MODULE_PAYMENT_WIRE_BANK_ADDRESS . '<br>'  .  '<b>'. MODULE_PAYMENT_WIRE_TEXT_CONFIG_7_1 . '</b>' . MODULE_PAYMENT_WIRE_SWIFT_CODE . '<br>' . '<font size=2 color="red"><b>'.MODULE_PAYMENT_WIRE_NOTE .'</b></font>');
  
  define('MODULE_PAYMENT_WIRE_NOTES','After you send money, please email us at sale@doreenbeads.com with information:<br/>1) your login name,<br/>2) order#, <br/>3) and total amount you send<br/>');
  define('MODULE_PAYMENT_WIRE_TEXT_BENEFICIARY_BANK','Beneficiary’s Bank :');
  define('MODULE_PAYMENT_WIRE_TEXT_SWIFT_CODE','SWIFT Code :');
  define('MODULE_PAYMENT_WIRE_TEXT_BANK_ADDRESS','Bank Address :');
  define('MODULE_PAYMENT_WIRE_TEXT_BENEFICIARY','Beneficiary :');
  define('MODULE_PAYMENT_WIRE_TEXT_ACCOUNT_NO','Account Number :');  
  
  switch ($_SESSION['currency']){
      case 'USD':
          define('MODULE_PAYMENT_WIRE_ACCOUNT_NO_NEW', '1094167015<font style="color:grey">（If you transfer money from Hong Kong please use this account ：40941760）</font>');
          break;
      case 'EUR':
          define('MODULE_PAYMENT_WIRE_ACCOUNT_NO_NEW', '1094167023');
          break;
      case 'GBP':
          define('MODULE_PAYMENT_WIRE_ACCOUNT_NO_NEW', '1094167031');
          break;
      case 'JPY':
          define('MODULE_PAYMENT_WIRE_ACCOUNT_NO_NEW', '1094167058');
          break;
      case 'CAD':
          define('MODULE_PAYMENT_WIRE_ACCOUNT_NO_NEW', '1094167066');
          break;
      case 'AUD':
          define('MODULE_PAYMENT_WIRE_ACCOUNT_NO_NEW', '1094167074');
          break;
      default:
          define('MODULE_PAYMENT_WIRE_ACCOUNT_NO_NEW', '1094167015<font style="color:grey">（If you transfer money from Hong Kong please use this account ：40941760）</font>');
          break;
  }
  define('MODULE_PAYMENT_WIRE_TEXT_DESCRIPTION', '<table cellpadding="0" cellspacing="0">
                    	<tr>
                        	<th width="135">Beneficiary’s Bank:</th>
                            <td>' . MODULE_PAYMENT_WIRE_BENEFICIARY_BANK . '</td>
                        </tr>
                        <tr>
                        	<th>SWIFT Code:</th>
                            <td>' . MODULE_PAYMENT_WIRE_SWIFT_CODE . '</td>
                        </tr>
                        <tr>
                        	<th>Bank Address:</th>
                            <td>' . MODULE_PAYMENT_WIRE_BANK_ADDRESS . '</td>
                        </tr>
                    </table>
                    <div class="borderbt"></div>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                        	<th width="135">Account Number:</th>
                            <td>' . MODULE_PAYMENT_WIRE_ACCOUNT_NO_NEW . '</td>
                        </tr>
                        <tr>
                        	<th>Beneficiary:</th>
                            <td>' . MODULE_PAYMENT_WIRE_BENEFICIARY . '</td>
                        </tr>  
                    </table>');

  
  define('MODULE_PAYMENT_WIRE_TEXT_EMAIL_FOOTER', MODULE_PAYMENT_WIRE_TEXT_DESCRIPTION);
  define('MODULE_PAYMENT_WIRE_TEXT_TITLE_DISCOUNT','&nbsp;(2% discount will be offered if total amount reach to 2000 US$,<br/> commission fee should be paid by payer. )');

?>
