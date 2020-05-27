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
// $Id: westernunion.php,v 1.0 2004/05/02 Farrukh Saeed
//
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_RECEIVER', 'Empfänger');
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_SENDER', 'Absender ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_MCTN', 'MTCN : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_AMOUNT', 'Menge : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_CURRENCY', 'Währung : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_FIRST_NAME', 'Vorname : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_LAST_NAME', 'Nachname : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_ADDRESS', 'Adresse : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_ZIP', 'PLZ : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_CITY', 'Stadt : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_COUNTRY', 'Land : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_PHONE', 'Telefon : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_QUESTION', '	Frage : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_ANSWER', 'Antwort : ');
  
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME', '');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME', '');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS', '');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP', '');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_CITY', '');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY', '');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_PHONE', '862163023611');
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_DISCOUNT','&nbsp;(2% Rabatt wird angeboten wenn der Gesamtbetrag auf 2000 US$ erreicht,<br/> und die Kommission sollte vom Zahler bezahlt werden. <a href="'.HTTP_SERVER.'/page.html?id=124" target="_blank">Klicken Sie hier für Details >></a>)');

  define('MODULE_PAYMENT_WESTERNUNION_TEXT_TITLE', '<strong>Western Union Money Transfer</strong>');
 /*
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_DESCRIPTION', 'Make Payable To:<br><br>' .  '<b>'. MODULE_PAYMENT_WESTERNUNION_ENTRY_FIRST_NAME .'</b>' . MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME . "<br>" .  '<b>'.MODULE_PAYMENT_WESTERNUNION_ENTRY_LAST_NAME . '</b>' .   MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME . "<br>" .  '<b>'.MODULE_PAYMENT_WESTERNUNION_ENTRY_ADDRESS . '</b>' .MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS . "<br>"  .   '<b>'. MODULE_PAYMENT_WESTERNUNION_ENTRY_ZIP . '</b>'.   MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP . "<br>"  .   '<b>'. MODULE_PAYMENT_WESTERNUNION_ENTRY_CITY .   '</b>'.  MODULE_PAYMENT_WESTERNUNION_RECEIVER_CITY . "<br>"  .  '<b>'.  MODULE_PAYMENT_WESTERNUNION_ENTRY_COUNTRY . '</b>'.   MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY . "<br>"  .   '<b>'.  MODULE_PAYMENT_WESTERNUNION_ENTRY_PHONE . '</b>'.   MODULE_PAYMENT_WESTERNUNION_RECEIVER_PHONE . '<br><br>' . "<b>After you send money, please email us (<a href='mailto:service_de@doreenbeads.com'><font style='color:#0000FF;'>service_de@doreenbeads.com</font></a>) with following information:</b><br /><br /><span style=" . "color:#FF0000;font-weight:bold;" . ">1.Your registered email address, order No. on our website and total money for your order.<br /><br />2.The 10-digits Western Union Money Instant Transfer Control Number<br /><br />3.Total amount you send to us (including currency)<br /><br />4.Your information: <ul><li>First Name and Last Name (the same as your passport).</li><li>The City you transferred from.</li><li>Full address.</li><li>Telephone number.</li></ul></span><span style='font-size:12px;font-weight:normal;padding-left:15px;'>(This information must be the same as what you have filled on Western Union Money Transfer form.)</span><br /><br />Once receive your payment, we will begin processing your order and ship it out immediately.");
*/
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_DESCRIPTION', '<table cellpadding="0" cellspacing="0">
                    	<tr>
                        	<th width="105">First Name:</th>
                            <td>' . MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME . '</td>
                        </tr>
                        <tr>
                        	<th>Last Name:</th>
                            <td>' .   MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME . '</td>
                        </tr>
                        <tr>
                        	<th>Address:</th>
                            <td>' .MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS . '</td>
                        </tr>
                        <tr>
                        	<th>ZipCode:</th>
                            <td>'.   MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP . '</td>
                        </tr>
                        <tr>
                        	<th>City:</th>
                            <td>'.  MODULE_PAYMENT_WESTERNUNION_RECEIVER_CITY . '</td>
                        </tr>
                        <tr>
                        	<th>Country:</th>
                            <td>'.   MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY . '</td>
                        </tr>
                        <tr>
                        	<th>Phone number:</th>
                            <td>'.   MODULE_PAYMENT_WESTERNUNION_RECEIVER_PHONE . '</td>
                        </tr>
                    </table>');

  define('MODULE_PAYMENT_WESTERNUNION_TEXT_EMAIL_FOOTER', "Western Union Money Instant Transfer Make Payable To:\n\n" . MODULE_PAYMENT_WESTERNUNION_ENTRY_FIRST_NAME . MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME . "\n" . MODULE_PAYMENT_WESTERNUNION_ENTRY_LAST_NAME . MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME . "\n"  . MODULE_PAYMENT_WESTERNUNION_ENTRY_ADDRESS . MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS . "\n"  . MODULE_PAYMENT_WESTERNUNION_ENTRY_ZIP . MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP . "\n"  . MODULE_PAYMENT_WESTERNUNION_ENTRY_CITY . MODULE_PAYMENT_WESTERNUNION_RECEIVER_CITY . "\n"  . MODULE_PAYMENT_WESTERNUNION_ENTRY_COUNTRY . MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY . "\n"  . MODULE_PAYMENT_WESTERNUNION_ENTRY_PHONE . MODULE_PAYMENT_WESTERNUNION_RECEIVER_PHONE . "\n\n" . "<b>Nach Ihre Überweisung schicken Sie bitte uns ein Email unter die Adresse (<a href='mailto:service_de@doreenbeads.com'><font style='color:#0000FF;'>service_de@doreenbeads.com</font></a>) mit folgenden Information:</b><br /><br /><span style=" . "color:#FF0000;font-weight:bold;" . ">1.Ihre eingetragene E-Mail-Adresse, Bestell-Nr Auf unserer Website und der Gesamtbetrag Ihrer Bestellung.<br /><br />2.Die 10-stellige Western Union Money Instant Transfer Kontrollnummer<br /><br />3.Gesamtbetrag , den Sie an uns (mit Währung) überwiesen<br /><br />4.Ihre Information: <ul><li>Vorname und Nachname (das gleiche wie Ihr Reisepass).</li><li>Die Stadt, in der die Überweisung durchgeführt.</li><li>Vollstädige Adresse.</li><li>Telefon Nummer.</li></ul></span><span style='font-size:12px;font-weight:normal;padding-left:20px;'>(This information must be the same as what you have filled on Western Union Money Transfer form.)</span><br /><br /><strong>Sobald wir Ihre Überweisung erhalten, werden wir Ihre Bestellung bearbeiten und die Produkte Ihnen versenden.</strong>");

?>
