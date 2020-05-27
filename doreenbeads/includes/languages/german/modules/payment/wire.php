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
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_1_1','Wire Transfer Payment Module aktivieren');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_1_2','Akzeptieren wire transfer payment?');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_2_1','Konto  Name:');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_2_2','Empfänger Kontoname');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_3_1','Kontonummer:');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_3_2','Empfänger Kontonummer');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_4_1','Empfänger Telefonnummer:');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_4_2','Empfänger Telefonnummer');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_5_1','Bank Name:');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_5_2','Bank Name');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_6_1','Bank Filiale:');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_6_2','Bank Filiale');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_7_1','Swift Code:');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_7_2','Swift Code');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_8_1','Reihenfolge der Anzeige');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_8_2','Darstellung der Bankfilialen sortieren. Niedrigste wird zuerst angezeigt.'); 
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_9_1','Bestell-Status einstellen');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_9_2','Stellen Sie den Status von Aufträgen, die mit diesem Zahlungsmodul auf diesen Wert vorgenommen');
  
  define('MODULE_PAYMENT_WIRE_TEXT_TITLE', '<strong>Banküberweisung (Citibank)</strong>');
//  define('MODULE_PAYMENT_WIRE_TEXT_DESCRIPTION', 'Make Payable To:<br/><br/>' .  '<b>'. MODULE_PAYMENT_WIRE_TEXT_CONFIG_2_1 . '</b>' . MODULE_PAYMENT_WIRE_NAME . '<br>' .  '<b>'.MODULE_PAYMENT_WIRE_TEXT_CONFIG_3_1 . '</b>' . MODULE_PAYMENT_WIRE_ACCOUNT . '<br>' . '<b>'. MODULE_PAYMENT_WIRE_TEXT_CONFIG_5_1 . '</b>' . MODULE_PAYMENT_WIRE_BANK_NAME . '<br>'  .   '<b>'. MODULE_PAYMENT_WIRE_TEXT_CONFIG_6_1 . '</b>' . MODULE_PAYMENT_WIRE_BANK_ADDRESS . '<br>'  .  '<b>'. MODULE_PAYMENT_WIRE_TEXT_CONFIG_7_1 . '</b>' . MODULE_PAYMENT_WIRE_SWIFT_CODE . '<br>' . '<font size=2 color="red"><b>'.MODULE_PAYMENT_WIRE_NOTE .'</b></font>');
  
  define('MODULE_PAYMENT_WIRE_NOTES','Nach Ihrer Überweisung bitte schicken Sie uns ein Email unter service_de@doreenbeads.com mit Ihrer Informationen:<br/>1) Ihr Anmeldename,<br/>2) Bestellnummer, <br/>3) und den Gesamtbetrag<br/>');
  define('MODULE_PAYMENT_WIRE_TEXT_BENEFICIARY_BANK','BENEFICIARY’S BANK :');
  define('MODULE_PAYMENT_WIRE_TEXT_SWIFT_CODE','SWIFT CODE :');
  define('MODULE_PAYMENT_WIRE_TEXT_BANK_ADDRESS','BANK ADDRESS :');
  define('MODULE_PAYMENT_WIRE_TEXT_BENEFICIARY','BENEFICIARY :');
  define('MODULE_PAYMENT_WIRE_TEXT_ACCOUNT_NO','ACCOUNT NO :');  
  
  switch ($_SESSION['currency']){
      case 'USD':
          define('MODULE_PAYMENT_WIRE_ACCOUNT_NO_NEW', '1094167015<font style="color:grey">（Wenn Sie Geld aus Hongkong überweisen, verwenden Sie bitte dieses Konto ：40941760）</font>');
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
          define('MODULE_PAYMENT_WIRE_ACCOUNT_NO_NEW', '1094167015<font style="color:grey">（Wenn Sie Geld aus Hongkong überweisen, verwenden Sie bitte dieses Konto ：40941760）</font>');
          break;
  }
  define('MODULE_PAYMENT_WIRE_TEXT_DESCRIPTION', '<table cellpadding="0" cellspacing="0">
                    	<tr>
                        	<th width="135">Empfängerbank:</th>
                            <td>' . MODULE_PAYMENT_WIRE_BENEFICIARY_BANK . '</td>
                        </tr>
                        <tr>
                        	<th>SWIFT Code:</th>
                            <td>' . MODULE_PAYMENT_WIRE_SWIFT_CODE . '</td>
                        </tr>
                        <tr>
                        	<th>Bank Adresse:</th>
                            <td>' . MODULE_PAYMENT_WIRE_BANK_ADDRESS . '</td>
                        </tr>
                    </table>
                    <div class="borderbt"></div>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                        	<th width="135">Kontonummer:</th>
                            <td>' . MODULE_PAYMENT_WIRE_ACCOUNT_NO_NEW . '</td>
                        </tr>
                        <tr>
                        	<th>Empfänger:</th>
                            <td>' . MODULE_PAYMENT_WIRE_BENEFICIARY . '</td>
                        </tr>  
                    </table>');

  
  define('MODULE_PAYMENT_WIRE_TEXT_EMAIL_FOOTER', MODULE_PAYMENT_WIRE_TEXT_DESCRIPTION);
  define('MODULE_PAYMENT_WIRE_TEXT_TITLE_DISCOUNT','&nbsp;(2% Rabatt wird angeboten wenn der Gesamtbetrag auf 2000 US-Dollar erreicht.<br/> Kommission sollte vom Zahler bezahlt werden. )');

?>
