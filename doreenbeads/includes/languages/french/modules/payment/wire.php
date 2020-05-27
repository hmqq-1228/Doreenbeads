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
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_1_1','Activer la Module de paiements de  Wire Transfer');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_1_2','Accepter vous le paiement par wire transfer?');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_2_1','Nom de Compte :');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_2_2','Compte Nom du bénéficiaire');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_3_1','N° de compte du bénéficiaire:');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_3_2','N° de Compte ');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_4_1','Numéros de téléphone du bénéficiaire:');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_4_2','Numéros de téléphone du bénéficiaire');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_5_1','Banque:');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_5_2','Banque');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_6_1','Succursale de Banque:');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_6_2','Succursale de Banque');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_7_1','Swift Code:');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_7_2','Swift Code');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_8_1','Trier ordre d’affichage.');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_8_2','Trier ordre d’affichage. Le plus bas est affichée en premier.'); 
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_9_1','Définir l’état des commandes');
  define('MODULE_PAYMENT_WIRE_TEXT_CONFIG_9_2','Définir l’état des commandes faites par ce module de paiement pour cette valeur');
  
  define('MODULE_PAYMENT_WIRE_TEXT_TITLE', '<strong>Virement Bancaire (Citibank)</strong>');
//  define('MODULE_PAYMENT_WIRE_TEXT_DESCRIPTION', 'Make Payable To:<br/><br/>' .  '<b>'. MODULE_PAYMENT_WIRE_TEXT_CONFIG_2_1 . '</b>' . MODULE_PAYMENT_WIRE_NAME . '<br>' .  '<b>'.MODULE_PAYMENT_WIRE_TEXT_CONFIG_3_1 . '</b>' . MODULE_PAYMENT_WIRE_ACCOUNT . '<br>' . '<b>'. MODULE_PAYMENT_WIRE_TEXT_CONFIG_5_1 . '</b>' . MODULE_PAYMENT_WIRE_BANK_NAME . '<br>'  .   '<b>'. MODULE_PAYMENT_WIRE_TEXT_CONFIG_6_1 . '</b>' . MODULE_PAYMENT_WIRE_BANK_ADDRESS . '<br>'  .  '<b>'. MODULE_PAYMENT_WIRE_TEXT_CONFIG_7_1 . '</b>' . MODULE_PAYMENT_WIRE_SWIFT_CODE . '<br>' . '<font size=2 color="red"><b>'.MODULE_PAYMENT_WIRE_NOTE .'</b></font>');
  
  define('MODULE_PAYMENT_WIRE_NOTES','Après le transfert, s’il vous plaît,nous envoyez un e-mail à l’adresse service_fr@doreenbeads.com  comprenant les informations suivantes:<br/>1) L’adresse e-mail d’inscrire sur notre site, et ,<br/>2) le numéro de commande , <br/>3) le montant que vous avez payé<br/>');
  define('MODULE_PAYMENT_WIRE_TEXT_BENEFICIARY_BANK','BENEFICIARY’S BANK :');
  define('MODULE_PAYMENT_WIRE_TEXT_SWIFT_CODE','SWIFT CODE :');
  define('MODULE_PAYMENT_WIRE_TEXT_BANK_ADDRESS','Adresse de BANQUE  :');
  define('MODULE_PAYMENT_WIRE_TEXT_BENEFICIARY','BÉNÉFICIAIRE :');
  define('MODULE_PAYMENT_WIRE_TEXT_ACCOUNT_NO','N° de Compte:');  
  
  switch ($_SESSION['currency']){
      case 'USD':
          define('MODULE_PAYMENT_WIRE_ACCOUNT_NO_NEW', '1094167015<font style="color:grey">（Si vous transférez de l’argent de Hong Kong, veuillez utiliser ce compte ：40941760）</font>');
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
          define('MODULE_PAYMENT_WIRE_ACCOUNT_NO_NEW', '1094167015<font style="color:grey">（Si vous transférez de l’argent de Hong Kong, veuillez utiliser ce compte ：40941760）</font>');
          break;
  }
  define('MODULE_PAYMENT_WIRE_TEXT_DESCRIPTION', '<table cellpadding="0" cellspacing="0">
                    	<tr>
                        	<th width="135">'.MODULE_PAYMENT_WIRE_TEXT_BENEFICIARY_BANK.'</th>
                            <td>' . MODULE_PAYMENT_WIRE_BENEFICIARY_BANK . '</td>
                        </tr>
                        <tr>
                        	<th>' . MODULE_PAYMENT_WIRE_TEXT_SWIFT_CODE . '</th>
                            <td>' . MODULE_PAYMENT_WIRE_SWIFT_CODE . '</td>
                        </tr>
                        <tr>
                        	<th>' . MODULE_PAYMENT_WIRE_TEXT_BANK_ADDRESS . '</th>
                            <td>' . MODULE_PAYMENT_WIRE_BANK_ADDRESS . '</td>
                        </tr>
                    </table>
                    <div class="borderbt"></div>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                        	<th width="135">' . MODULE_PAYMENT_WIRE_TEXT_ACCOUNT_NO . '</th>
                            <td>' . MODULE_PAYMENT_WIRE_ACCOUNT_NO_NEW . '</td>
                        </tr>
                        <tr>
                        	<th>' . MODULE_PAYMENT_WIRE_TEXT_BENEFICIARY . '</th>
                            <td>' . MODULE_PAYMENT_WIRE_BENEFICIARY . '</td>
                        </tr>  
                    </table>');

  
  define('MODULE_PAYMENT_WIRE_TEXT_EMAIL_FOOTER', MODULE_PAYMENT_WIRE_TEXT_DESCRIPTION);
  define('MODULE_PAYMENT_WIRE_TEXT_TITLE_DISCOUNT','&nbsp;(Nous offrons une réduction de 2% pour toutes les commandes avec le montant total supérieur à 2000 $, les frais de commission doivent être payés par le payeur.)');

?>
