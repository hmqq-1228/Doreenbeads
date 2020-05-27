<?php
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_1_1','Wire Transfer Payment Module(Bank of China) aktivieren');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_1_2','Akzeptieren Sie Wire Transfer Payment?(Bank of China)');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_2_1','Konto Name:');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_2_2','Empfänger Name');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_3_1','Kontonummer:');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_3_2','Empfänger Kontonummer');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_4_1','Empfänger Telefonnummer:');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_4_2','Empfänger Telefonnummer');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_5_1','Bank Name:');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_5_2','Bank Name');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_6_1','Bankfiliale:');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_6_2','Bankfiliale');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_7_1','Swift Code:');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_7_2','Swift Code');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_8_1','Reihenfolge der Anzeige.');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_8_2','Darstellung der Bankfilialen sortieren. Niedrigste wird zuerst angezeigt.'); 
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_9_1','Set Order Status');
  define('MODULE_PAYMENT_WIREBC_TEXT_CONFIG_9_2','Stellen Sie den Status von Aufträgen, die mit diesem Zahlungsmodul auf diesen Wert vorgenommen');
  define('MODULE_PAYMENT_WIREBC_NOTES','Nach Ihrer Überweisung bitte schicken Sie uns ein Email unter service_de@doreenbeads.com mit Ihrer Informationen:<br/>1) Ihr Anmeldename,<br/>2) Bestellnummer, <br/>3) und den Gesamtbetrag<br/>');
  define('MODULE_PAYMENT_WIREBC_TEXT_TITLE_HEAD', '<strong>Banküberweisung(Bank of China)</strong>');
  define('MODULE_PAYMENT_WIREBC_TEXT_TITLE_DISCOUNT','&nbsp;(2% Rabatt wird angeboten wenn der Gesamtbetrag auf 2000 US-Dollar erreicht.<br/> Kommission sollte vom Zahler bezahlt werden. )');
  define('MODULE_PAYMENT_WIREBC_TEXT_TITLE_END','<br /><div style="clear:both; padding-bottom:10px;"><span style="color:#F47504"><strong>Lesen Sie bitte diesen wichtigen Hinweis, bevor Sie weiter zur Kasse gehen.</strong></span> <a href="'.HTTP_SERVER.'/page.html?chapter=0&id=95" target="_blank">Klicken Sie hier>></a></div>');
  
  define('MODULE_PAYMENT_WIREBC_TEXT_BENEFICIARY_BANK','Empfängerbank :');
  define('MODULE_PAYMENT_WIREBC_TEXT_SWIFT_CODE','SWIFT Code :');
  define('MODULE_PAYMENT_WIREBC_TEXT_HOLDER_NAME','Kontoinhaber :');
  define('MODULE_PAYMENT_WIREBC_TEXT_ACCOUNT_NUMBER','Kontonummer :');  
  define('MODULE_PAYMENT_WIREBC_TEXT_BANK_ADDRESS','Bank Adresse :');
  define('MODULE_PAYMENT_WIREBC_TEXT_HOLDER_PHONE','Telefonnummer vom Kontoinhaber :');
  
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
                        	<th width="135">Empfängerbank:</th>
                            <td>' . MODULE_PAYMENT_WIREBC_BENEFICIARY_BANK . '</td>
                        </tr>
                        <tr>
                        	<th>SWIFT Code:</th>
                            <td>' . MODULE_PAYMENT_WIREBC_SWIFT_CODE . '</td>
                        </tr>
                        <tr>
                        	<th>Kontoinhaber:</th>
                            <td>' . MODULE_PAYMENT_WIREBC_HOLDER_NAME . '</td>
                        </tr>
                    </table>
                    <div class="borderbt"></div>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                        	<th width="135">Kontonummer:</th>
                            <td>' . MODULE_PAYMENT_WIREBC_ACCOUNT_NUMBER . '</td>
                        </tr>
                        <tr>
                        	<th>Bank Adresse:</th>
                            <td>' . MODULE_PAYMENT_WIREBC_BANK_ADDRESS . '</td>
                        </tr>
                        <tr>
                        	<th>Telefonnummer vom Kontoinhaber:</th>
                            <td>' . MODULE_PAYMENT_WIREBC_HOLDER_PHONE . '</td>
                        </tr>
                    </table>');
  
  define('MODULE_PAYMENT_WIREBC_TEXT_EMAIL_FOOTER', MODULE_PAYMENT_WIREBC_TEXT_DESCRIPTION);

?>