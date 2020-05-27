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
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_RECEIVER', 'Bénéficiaire ');
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_SENDER', 'Payeur ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_MCTN', 'MTCN : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_AMOUNT', 'Compte : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_CURRENCY', 'Monnaie : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_FIRST_NAME', 'Prénom : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_LAST_NAME', 'Nom : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_ADDRESS', 'Adresse : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_ZIP', 'Code Postal : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_CITY', 'Ville : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_COUNTRY', 'Pays : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_PHONE', 'Téléphone : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_QUESTION', 'Question : ');
  define('MODULE_PAYMENT_WESTERNUNION_ENTRY_ANSWER', 'Réponse : ');
  
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME', '');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME', '');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS', '');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP', '');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_CITY', '');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY', '');
  define('MODULE_PAYMENT_WESTERNUNION_RECEIVER_PHONE', '862163023611');
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_DISCOUNT','&nbsp;(2% discount will be offered if total amount reach to 2000 US$,<br/> commission fee should be paid by payer. <a href="'.HTTP_SERVER.'/page.html?id=124" target="_blank">Click here for detail >></a>)');

  define('MODULE_PAYMENT_WESTERNUNION_TEXT_TITLE', '<strong>Transfert de l’argent de la Western Union</strong>');
 /*
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_DESCRIPTION', 'Make Payable To:<br><br>' .  '<b>'. MODULE_PAYMENT_WESTERNUNION_ENTRY_FIRST_NAME .'</b>' . MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME . "<br>" .  '<b>'.MODULE_PAYMENT_WESTERNUNION_ENTRY_LAST_NAME . '</b>' .   MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME . "<br>" .  '<b>'.MODULE_PAYMENT_WESTERNUNION_ENTRY_ADDRESS . '</b>' .MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS . "<br>"  .   '<b>'. MODULE_PAYMENT_WESTERNUNION_ENTRY_ZIP . '</b>'.   MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP . "<br>"  .   '<b>'. MODULE_PAYMENT_WESTERNUNION_ENTRY_CITY .   '</b>'.  MODULE_PAYMENT_WESTERNUNION_RECEIVER_CITY . "<br>"  .  '<b>'.  MODULE_PAYMENT_WESTERNUNION_ENTRY_COUNTRY . '</b>'.   MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY . "<br>"  .   '<b>'.  MODULE_PAYMENT_WESTERNUNION_ENTRY_PHONE . '</b>'.   MODULE_PAYMENT_WESTERNUNION_RECEIVER_PHONE . '<br><br>' . "<b>After you send money, please email us (<a href='mailto:service_fr@doreenbeads.com'><font style='color:#0000FF;'>service_fr@doreenbeads.com</font></a>) with following information:</b><br /><br /><span style=" . "color:#FF0000;font-weight:bold;" . ">1.Your registered email address, order No. on our website and total money for your order.<br /><br />2.The 10-digits Western Union Money Instant Transfer Control Number<br /><br />3.Total amount you send to us (including currency)<br /><br />4.Your information: <ul><li>First Name and Last Name (the same as your passport).</li><li>The City you transferred from.</li><li>Full address.</li><li>Telephone number.</li></ul></span><span style='font-size:12px;font-weight:normal;padding-left:15px;'>(This information must be the same as what you have filled on Western Union Money Transfer form.)</span><br /><br />Once receive your payment, we will begin processing your order and ship it out immediately.");
*/
  define('MODULE_PAYMENT_WESTERNUNION_TEXT_DESCRIPTION', '<table cellpadding="0" cellspacing="0">
                    	<tr>
                        	<th width="105">'. MODULE_PAYMENT_WESTERNUNION_ENTRY_FIRST_NAME .'</th>
                            <td>' . MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME . '</td>
                        </tr>
                        <tr>
                        	<th>'.MODULE_PAYMENT_WESTERNUNION_ENTRY_LAST_NAME . '</th>
                            <td>' .   MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME . '</td>
                        </tr>
                        <tr>
                        	<th>' . MODULE_PAYMENT_WESTERNUNION_ENTRY_ADDRESS . '</th>
                            <td>' .MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS . '</td>
                        </tr>
                        <tr>
                        	<th>'. MODULE_PAYMENT_WESTERNUNION_ENTRY_ZIP . '</th>
                            <td>'.   MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP . '</td>
                        </tr>
                        <tr>
                        	<th>'. MODULE_PAYMENT_WESTERNUNION_ENTRY_CITY .   '</th>
                            <td>'.  MODULE_PAYMENT_WESTERNUNION_RECEIVER_CITY . '</td>
                        </tr>
                        <tr>
                        	<th>'.  MODULE_PAYMENT_WESTERNUNION_ENTRY_COUNTRY . '</th>
                            <td>'.   MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY . '</td>
                        </tr>
                        <tr>
                        	<th>'.  MODULE_PAYMENT_WESTERNUNION_ENTRY_PHONE . '</th>
                            <td>'.   MODULE_PAYMENT_WESTERNUNION_RECEIVER_PHONE . '</td>
                        </tr>
                    </table>');

  define('MODULE_PAYMENT_WESTERNUNION_TEXT_EMAIL_FOOTER', "Faites Votre Chèque Au:\n\n" . MODULE_PAYMENT_WESTERNUNION_ENTRY_FIRST_NAME . MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME . "\n" . MODULE_PAYMENT_WESTERNUNION_ENTRY_LAST_NAME . MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME . "\n"  . MODULE_PAYMENT_WESTERNUNION_ENTRY_ADDRESS . MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS . "\n"  . MODULE_PAYMENT_WESTERNUNION_ENTRY_ZIP . MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP . "\n"  . MODULE_PAYMENT_WESTERNUNION_ENTRY_CITY . MODULE_PAYMENT_WESTERNUNION_RECEIVER_CITY . "\n"  . MODULE_PAYMENT_WESTERNUNION_ENTRY_COUNTRY . MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY . "\n"  . MODULE_PAYMENT_WESTERNUNION_ENTRY_PHONE . MODULE_PAYMENT_WESTERNUNION_RECEIVER_PHONE . "\n\n" . "<b>ne fois que vous envoyez de l’argent,  envoyez nous un email (<a href='mailto:service_fr@8seasons.com'><font style='color:#0000FF;'>service_fr@8seasons.com</font></a>) avec les informations suivantes:</b><br /><br /><span style='color:#FF0000;font-weight:bold;'>1.Votre adresse d’email enregistrée, N ° de commande sur notre site et l’argent total de votre commande.<br /><br />2.Le 10-chiffres Numéro de control de Virement de fonds instant par Western Union.<br /><br />3.Montant total que vous nous envoyez (y compris monnaie)<br /><br />4.Votre information: <ul><li>Nom et Prénom (le même que votre passeport).</li><li>The La Ville que vous avez transféré.</li><li>Adresse complète.</li><li>Numéro de téléphone.</li></ul></span>  <span style='font-size:12px;font-weight:normal;padding-left:20px;'>Cette information doit être la même que ce que vous avez rempli sur le formulaire de Virement de fonds par Western Union.)</span><br /><br />&nbsp;Une fois reçu votre paiement, nous commencerons à traiter votre commande et l’expédier immédiatement.");

?>
