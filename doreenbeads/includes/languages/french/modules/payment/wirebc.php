<?php
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_1_1','Activer la Module de paiements (Banque de Chines)');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_1_2','Accepter vous le paiement par wire transfer?(Banque de Chines))');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_2_1','Nom de Compte:');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_2_2','Compte Nom du bénéficiaire');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_3_1','N° de Compte :');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_3_2','N° de compte du bénéficiaire ');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_4_1','Numéros de téléphone du bénéficiaire:');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_4_2','Numéros de téléphone du bénéficiaire');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_5_1','Banque:');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_5_2','Banque');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_6_1','Succursale de Banque:');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_6_2','Succursale de Banque');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_7_1','Swift Code:');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_7_2','Swift Code');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_8_1','Trier ordre d’affichage.');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_8_2','Trier ordre d’affichage. Le plus bas est affichée en premier.'); 
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_9_1','Définir l’état des commandes');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_9_2','Définir l’état des commandes faites par ce module de paiement pour cette valeur');
  define('MODULE_PAYMENT_WIREBC_NOTES','Après le transfert, s’il vous plaît,nous envoyez un e-mail à l’adresse service_fr@doreenbeads.com  comprenant les informations suivantes:<br/>1)L’adresse e-mail d’inscrire sur notre site, et ,<br/>2) le numéro de commande , <br/>3) le montant que vous avez payé');
  define('MODULE_PAYMENT_WIREBC_TEXT_TITLE_HEAD', '<strong>Virement Bancaire (Banque de Chine)</strong>');
  define('MODULE_PAYMENT_WIREBC_TEXT_TITLE_DISCOUNT','&nbsp;(Nous offrons une réduction de 2% pour toutes les commandes avec le montant total supérieur à 2000 $, les frais de commission doivent être payés par le payeur.)');
  define('MODULE_PAYMENT_WIREBC_TEXT_TITLE_END','<br /><div style="clear:both; padding-bottom:10px;"><span style="color:#F47504"><strong>Assurez-vous de lire cette note importante avant de continuer le paiement.</strong></span> <a href="'.HTTP_SERVER.'/page.html?chapter=0&id=95" target="_blank">Cliquer ici>></a></div>');
  
  define('MODULE_PAYMENT_WIREBC_TEXT_BENEFICIARY_BANK','Banque du bénéficiaire :');
  define('MODULE_PAYMENT_WIREBC_TEXT_SWIFT_CODE','SWIFT Code :');
  define('MODULE_PAYMENT_WIREBC_TEXT_HOLDER_NAME','Le nom du titulaire de compte :');
  define('MODULE_PAYMENT_WIREBC_TEXT_ACCOUNT_NUMBER','N° de compte de banque :');  
  define('MODULE_PAYMENT_WIREBC_TEXT_BANK_ADDRESS','Adress de Banque:');
  define('MODULE_PAYMENT_WIREBC_TEXT_HOLDER_PHONE','Le numéro de téléphone du titulaire de compte de banque :');
  
  /*
  define('MODULE_PAYMENT_WIREBC_TEXT_DESCRIPTION', 'Payer à:<br/><br/>' .  
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
                        	<th width="135"> Banque du bénéficiaire: </th>
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
                        	<th width="135"> Numéro de compte de banque:</th>
                            <td>' . MODULE_PAYMENT_WIREBC_ACCOUNT_NUMBER . '</td>
                        </tr>
                        <tr>
                        	<th>Adresse de banque:</th>
                            <td>' . MODULE_PAYMENT_WIREBC_BANK_ADDRESS . '</td>
                        </tr>
                        <tr>
                        	<th>Le numéro de téléphone du titulaire de compte de banque:</th>
                            <td>' . MODULE_PAYMENT_WIREBC_HOLDER_PHONE . '</td>
                        </tr>
                    </table>');
  
  define('MODULE_PAYMENT_WIREBC_TEXT_EMAIL_FOOTER', MODULE_PAYMENT_WIREBC_TEXT_DESCRIPTION);

?>