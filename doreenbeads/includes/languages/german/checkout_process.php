<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @translators: cyaneo/hugo13/wflohr/maleborg/webchills	http://www.zen-cart.at
 * @version $Id: checkout_process.php 627 2010-08-30 15:05:14Z webchills $
 */

define('EMAIL_TEXT_SUBJECT', 'Wir haben Ihre Zahlung für die Bestellung Nr. %s erhalten'); 
define('EMAIL_TEXT_HEADER', 'Bestellbestätigung');
define('EMAIL_TEXT_PAYMENT_HEADER', 'Payment Confirmation from Doreenbeads');
define('EMAIL_TEXT_FROM', ' von '); //added to the EMAIL_TEXT_HEADER, above on text-only emails
define('EMAIL_THANKS_FOR_SHOPPING', 'Vielen Dank für Ihre Bestellung!');
define('EMAIL_THANKS_FOR_PAYMENT','Danke für Ihren Einkauf bei uns! Sie haben erfolgreich bezahlt und wir werden Ihre Bestellung so schnell wie möglich verpacken und verschicken.');
define('EMAIL_DETAILS_FOLLOW', 'Unten sehen Sie die Details Ihrer Bestellung:');
define('EMAIL_TEXT_ORDER_NUMBER', 'Bestellnummer:');
define('EMAIL_TEXT_INVOICE_URL', 'Detaillierte Rechnung:');
define('EMAIL_TEXT_INVOICE_URL_CLICK', 'Für eine detaillierte Rechnung bitte hier klicken');
define('EMAIL_TEXT_DATE_ORDERED', 'Bestelldatum:');
define('EMAIL_TEXT_PRODUCTS', 'Artikel');
define('EMAIL_TEXT_SUBTOTAL', 'Zwischensumme:');
define('EMAIL_TEXT_TAX', 'MwSt.:');
define('EMAIL_TEXT_SHIPPING', 'Versandkosten:');
define('EMAIL_TEXT_TOTAL', 'Gesamt:');
define('EMAIL_TEXT_DELIVERY_ADDRESS', 'Lieferanschrift');
define('EMAIL_TEXT_BILLING_ADDRESS', 'Rechnungsanschrift');
define('EMAIL_TEXT_PAYMENT_METHOD', 'Zahlungsweise');
define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('TEXT_EMAIL_VIA', 'via');
define('EMAIL_GREET_MR', 'Hallo  %s' . "\n\n");
define('EMAIL_GREET_MS', 'Hallo  %s' . "\n\n");
// suggest not using # vs No as some spamm protection block emails with these subjects
define('EMAIL_ORDER_NUMBER_SUBJECT', ' Bestellnummer ');
define('HEADING_ADDRESS_INFORMATION', 'Lieferinformationen');
define('HEADING_SHIPPING_METHOD', 'Versandart');
define('HEADING_ADDRESS_TITLE', 'Wir versenden Ihr Paket an folgende Lieferadresse ');
define('TEXT_TXT_CHECKOUT_SHIPPING_ADDRESS', '<br /><span style="color:red;">Wichtiger Hinweis auf <b>Versandadresse</b>:</span> Sicher Sie bitte, dass die obige Versandadresse richtig ist.Normalerweise beim Erhalten Ihrer Zahlung werden wir sofort schnell Ihre Pakete absenden. Deshalb Sie finden, die Adresse falsch ist, kontaktieren Sie bitte innerhalb 24 Stunden uns.<br /><br />');

define('TEXT_EMAIL_SUBSCRIBE','<font color="red"><b>*Bitte beachten Sies:</b></font> Wir empfehlen Ihnen, unsere Newsletter für unsere <b>neuesten Angebote, Urlaub-Verkaufsförderung, Neue Angebote-Annoncen</b> und andere anzumelden.<a href="http://eepurl.com/bbtJ" name = "subscribe_newsletter">Klicken zu abonnieren.>></a>');
define('TEXT_EMAIL_THANKS_FOR_SHOPPING','<p class="important"><font color="red">Herzlichen Glückwunsch,

    	 	Ihre Bestellung ist gelungen und in unserem Back-End System geschrieben. Klicken Sie <a href="' . HTTP_SERVER . '/page.html?chapter=0&id=5#P5" target="_blank">Manuell PayPal-Erklärung</a> (oder rollen nach dem Boden der Email), mit Ihrer Zahlung fertig zu sein, wenn Sie noch nicht die Bestellung bezahlten. </font></p>');
define('TEXT_BEIJING_TIME',' (Beijinger Zeit (CST) +0800)');
define('EMAIL_ORDER_TRACK_REMIND','<font color="red">Bitte überprüfen Sie unsere <b>Benachrichtigung</b>im Mailbox:</font><br />
	Wir aktualisieren immer rechtzeitig die Umstände Ihrer Bestellung. Nach Ihrer erfolgreichen Bezahlung bekommen Sieinnerhalb von 2 Werktagen eine Benachrichtigung. Wenn Sie nach 2 Werktagen kein Email bekommen haben,kontaktieren Sie bitte uns. Wir werden Ihre Bestellung so schnell wie möglich überprüfen und Ihr Paket ohne Verzögerung abzuschicken. <br /> <br />
	<font color="red">Bekommen ich ein Email,  <b>wenn ein oder einige Produkt(e) nicht lieferbar ist (sind)?</b></font><br /><br />
	In der Regel haben wir genuge Artikel auf Lager. Auf unvorhergesehenen Fall sind manche Artikel nicht lieferbar, und nach unserer Richtlinien bieten wir 3 Möglichkeiten.<br /> 
	1. Wir schicken die vorher fehlende Artikel direkt zu Ihnen, sobald sie wieder auf Lager sind;<br />
	2. Wir schicken die vorher fehlende Artikel mit Ihrer nächsten Bestellung mit;<br />
	3. Sie können auch andere Artikel als Ersatz auf der Webseite auswählen. Dann kontaktieren Sie uns per Email.<br /><br />
	Sie bekommen die detaillierte Informationen durch eine Benachrichtigung per Email und können sich eine Entscheidung treffen.<br /><br />
	<font color="red">Achtung:</font> Wenn Sie Mitteilung über unlieferbare Artikel vorm Versand bekommen möchten, bitte beantworten Sie das rechtzeitg, damit wir mit Ihnen darüber diskutieren können.<br /><br />
	(Bitte beachten Sie! Bitte prüfen Sie Ihren Spam Hefter, wenn Sie kein Email von uns bekommen haben. Das Email wird vielleicht blockiert.)
	');

define('TEXT_CHECKOUT_SHIPPING_ADDRESS','<br /><span style="color:red;">Wichtiger Hinweis auf <b>Versandadresse</b>:</span> Sicher Sie bitte, dass die obige Versandadresse richtig ist.Normalerweise beim Erhalten Ihrer Zahlung werden wir sofort schnell Ihre Pakete absenden. Deshalb Sie finden, die Adresse falsch ist, kontaktieren Sie bitte innerhalb 24 Stunden uns.<br /><br />');
define('TEXT_PAYPAL_OFFLINE_INFO','<div id="congratulation" style="font:12px"><strong><a href name="PAYPAL_ERROR"></a>Glückwunsch!</strong></div>
<p class="importnat">Ihre Bestellung ist gelungen und in unserem Back-Ende System geschrieben. Sie können auch die Details der Bestellung überprüfen, darum Sie in &quot;Mein Konto&quot;, gehen, der auf dem oben recht Teil dieser Seite liegt.<br/>
Wir senden auch eine Email mit den Details der Bestellung in Ihrer registrierten Email.<br />
  <br />
</p>

<div id="orderinformation" style="background-color:#CCCCFF;font:12px">
	<strong>Ihre Bestellung:Gesamtsumme & Versandart </strong></div>
	<p>Die Gesamtsumme der Bestellung:<strong><font color="red">%s</font></strong><br />
	Die Versandart der Bestellung:<strong><font color="red">%s</font></strong><br />
	Jetzt sollen Sie per Manuell PayPal uns die Zahlung senden! <br /><br />
</p>

<div id="payment" style="background-color:#CCCCFF;font:12px"><strong>Erklärung über Zahlung per Manuell PayPal</strong></div>

<p class="importnat">

	<font color="red"><strong>Erstens</strong></font>, loggen Sie sich in Ihrem PayPal Konto bei

	 <a href="http://www.paypal.com" target="_blank"><font color="Green">www.paypal.com</font></a> ein. Klicken Sie den Druckknopf 

	 <img src="/images/offline/send_money.bmp" alt="Send Money" width="77.5" height="18" /> 

	 in Ihrer Konto Seite .<br /><br />

	 <img src="/images/offline/send_money_main.bmp" alt="Paypal Main Page" 

			width="387.9" height="172.8" /></p>

	 <br /><p class="importnat"> <font color="red"><strong>Zweitens</strong></font>, gehen Sie nun auf die &quot;Geld senden&quot; Seite. 

	Bitte geben Sie <strong>sale@doreenbeads.com</strong> (Achtung: nicht supplies@8season<font color="red">s</font>.com) in die Nach (Email) Box ein und füllen Sie Ihre Gesamtsumme aus.

	Wählen Sie die &quot;Waren&quot; Option im &quot;Geld senden für&quot; Rahmen. Und dann klicken Sie &quot;weiter&quot; 

	 ,auf die nächste Seite zu gehen.<br /><br />

  <img src="/images/offline/send_money_content.bmp" alt="Paypal-Geld senden Seite" width="299.7" 

  	height="421.2" /><br />

  <br /><font color="red"><strong>Drittens</strong></font>, auf der neuen Seite rollen Sie bitte Ihren Bildschirm nach unten, die “Email nach Empfänger” Option zu erreichen. Geben Sie bitte Ihre Bestellnummer und unsere Website in die Themen Box ein (Sie können diese Informationen eingeben wie: Zahlung nach meiner Bestellnummer – bei 8season-supplies.com). Endlich klicken Sie “ Geld senden” Druckknopf, die Zahlung fertig zu haben. <br /><br />

  <img src="/images/offline/send_money_email.bmp" alt="Paypal-Email Content" 

  	width="565.2" height="238.5" /> 

  </p>

  <br /><p class="importnat"><font color="red"><strong>Schließlich</strong></font>, nach der erfolgreichen Abrechnung senden Sie bitte so schnell wie möglich uns eine Email, genannt von Ihrer wichtigen Information 

  (Meine Emailadresse: <strong><a href="mailto:sale@doreenbeads.com">sale@doreenbeads.com</a> (Achtung: nicht supplies@8season<font color="red">s</font>.com)</strong>).

  So arrangieren wir sofort, Ihre Pakete zu versenden, wenn unsere Finanzabteilung die Beträge überprüfen .

  <br /><p class="importnat">

  		<strong>Wenn Sie immer manche Probleme haben, kontaktieren Sie bitte frei uns unter sale@doreenbeads.com. 

  			Wir sind bereit, jederzeit Ihnen zu helfen. </strong><br /><br />

</p><br />');
define('EMAIL_THANKS_FOR_PAYMENT','Danke für den Einkauf bei uns! Sie haben die Zahlung erfolgreich gemacht, wir werden Ihre Bestellung so schnell wie möglich versenden.');

define('TEXT_PAYMENT_FAILURE', 'Es tut uns leid! Die Zahlung ist misslungen vielleicht wegen der unkorrekten Karte-Informationen. Sie k?nnten mit eine andere Karte noch einmal versuchen. Wenn es noch misslungen ist, bitte kontaktieren Sie uns per <a href=mailto:sale_de@doreenbeads.com>sale_de@doreenbeads.com</a>.');
?>