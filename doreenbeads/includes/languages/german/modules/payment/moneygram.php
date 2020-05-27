<?php
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_FIRST_NAME', 'Vorname : ');
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_LAST_NAME', 'Nachname : ');
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_ADDRESS', 'Adresse : ');
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_ZIP', 'PLZ: ');
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_CITY', 'Stadt : ');
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_COUNTRY', 'Land: ');
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_PHONE', 'Telefon : ');


  define('MODULE_PAYMENT_MONEYGRAM_ABOUT_INFO', ' ( <a href="'.zen_href_link('page','id=236').'" Ziel="_blank">über Money Gram &gt;&gt;</a> )');
  define('MODULE_PAYMENT_MONEYGRAM_TEXT_HEAD', '<strong>Money Gram</strong>');
  /*
  define('MODULE_PAYMENT_MONEYGRAM_TEXT_DESCRIPTION', '<br>Our Payee Information:<div style="line-height:23px;padding: 8px 0 12px 24px;">' .  '<p><strong>'. 
 MODULE_PAYMENT_MONEYGRAM_ENTRY_FIRST_NAME .'</strong><span>' . MODULE_PAYMENT_MONEYGRAM_RECEIVER_FIRST_NAME . '</span></p>' .  '<p><strong>'.MODULE_PAYMENT_MONEYGRAM_ENTRY_LAST_NAME . '</strong><span>' .   MODULE_PAYMENT_MONEYGRAM_RECEIVER_LAST_NAME . '</span></p>' .  
  '<p><strong>' . MODULE_PAYMENT_MONEYGRAM_ENTRY_ADDRESS . '</strong><span>' . MODULE_PAYMENT_MONEYGRAM_RECEIVER_ADDRESS . '</span></p>'  .   
  '<p><strong>'. MODULE_PAYMENT_MONEYGRAM_ENTRY_ZIP . '</strong><span>'.   MODULE_PAYMENT_MONEYGRAM_RECEIVER_ZIP . '</span></p>'  .   
  '<p><strong>'. MODULE_PAYMENT_MONEYGRAM_ENTRY_CITY .   '</strong><span>'.  MODULE_PAYMENT_MONEYGRAM_RECEIVER_CITY . '</span></p>'  .  
  '<p><strong>'.  MODULE_PAYMENT_MONEYGRAM_ENTRY_COUNTRY . '</strong><span>'.   MODULE_PAYMENT_MONEYGRAM_RECEIVER_COUNTRY . '</span></p>'  .  
  '<p><strong>'.  MODULE_PAYMENT_MONEYGRAM_ENTRY_PHONE . '</strong><span>'.   MODULE_PAYMENT_MONEYGRAM_RECEIVER_PHONE . "</span></p></div>
  <div class='borderbt'></div>");
  */

  define('MODULE_PAYMENT_MONEYGRAM_TEXT_DESCRIPTION', '<table cellpadding="0" cellspacing="0"><tr><th width="135">First Name:</th><td>' . MODULE_PAYMENT_MONEYGRAM_RECEIVER_FIRST_NAME . '</td></tr><tr><th>Last Name:</th><td>' .   MODULE_PAYMENT_MONEYGRAM_RECEIVER_LAST_NAME . '</td></tr>
                            <tr>
                                <th>Address:</th>
                                <td>' . MODULE_PAYMENT_MONEYGRAM_RECEIVER_ADDRESS . '</td>
                            </tr>
                            <tr>
                                <th>ZipCode:</th>
                                <td>'.   MODULE_PAYMENT_MONEYGRAM_RECEIVER_ZIP . '</td>
                            </tr>
                            <tr>
                                <th>City:</th>
                                <td>'.  MODULE_PAYMENT_MONEYGRAM_RECEIVER_CITY . '</td>
                            </tr>
                            <tr>
                                <th>Country:</th>
                                <td>'.   MODULE_PAYMENT_MONEYGRAM_RECEIVER_COUNTRY . '</td>
                            </tr>
                            <tr>
                                <th>Phone number:</th>
                                <td>'.   MODULE_PAYMENT_MONEYGRAM_RECEIVER_PHONE . '</td>
                            </tr>
                        </table>');
  
  define('MODULE_PAYMENT_MONEYGRAM_TEXT_EMAIL_FOOTER', '<br>Unsere Informationen zum Zahlungsempfänger:<div style="line-height:23px;padding: 8px 0 12px 24px;">' .  '<p><b>'. MODULE_PAYMENT_MONEYGRAM_ENTRY_FIRST_NAME .'</b><span style="color:red">' . MODULE_PAYMENT_MONEYGRAM_RECEIVER_FIRST_NAME . '</span></p>' .  '<p><b>'.MODULE_PAYMENT_MONEYGRAM_ENTRY_LAST_NAME . '</b><span style="color:red">' .   MODULE_PAYMENT_MONEYGRAM_RECEIVER_LAST_NAME . '</span></p>' .  '<p><b>' . MODULE_PAYMENT_MONEYGRAM_ENTRY_ADDRESS . '</b><span style="color:red">' . MODULE_PAYMENT_MONEYGRAM_RECEIVER_ADDRESS . '</span></p>'  .   '<p><b>'. MODULE_PAYMENT_MONEYGRAM_ENTRY_ZIP . '</b><span style="color:red">'.   MODULE_PAYMENT_MONEYGRAM_RECEIVER_ZIP . '</span></p>'  .   '<p><b>'. MODULE_PAYMENT_MONEYGRAM_ENTRY_CITY .   '</b><span style="color:red">'.  MODULE_PAYMENT_MONEYGRAM_RECEIVER_CITY . '</span></p>'  .  '<p><b>'.  MODULE_PAYMENT_MONEYGRAM_ENTRY_COUNTRY . '</b><span style="color:red">'.   MODULE_PAYMENT_MONEYGRAM_RECEIVER_COUNTRY . '</span></p>'  .   '<p><b>'.  MODULE_PAYMENT_MONEYGRAM_ENTRY_PHONE . '</b><span style="color:red">'.   MODULE_PAYMENT_MONEYGRAM_RECEIVER_PHONE . "</span></p></div>" . "<b>Nach Ihrer Zahlung schicken Sie bitte uns ein Email unter (<a href='mailto:service@8seasons.com'><font style='color:#0000FF;'>service@8seasons.com</font></a>) mit spezifischen und korrekten folgenden Informationen:</b><ul style='font-weight: normal;line-height: 22px;padding: 10px 0 14px 24px;'><li style='color:red'>1. 8-digits Kontrollnummer.</li><li style='color:red'>2. Gesamtbetrag und Währung.</li><li style='color:red'>3. Ihr Land.</li><li style='color:red'>4. Vollständiger Name des Einzahlers (einschließlich Vorname und Nachname im richtigen Reihenfolge ).</li><li style='color:red'>5. Vollständiger Name des Einzahlers (einschließlich Vorname und Nachname im richtigen Reihenfolge ).</li><li>6. Wenn OK, bitte senden Sie uns nach Ihrer Bezahlung das Bild Ihrer Überweisung Dokument.</li></ul><p style='color:red'>Hinweis: Bitte beachten Sie, bei der Zahlung die richtige Informationen zu schreiben. Sonst können wir das Geld nicht abheben.</p><p style='margin-top:10px;'>Sobald Ihre Zahlung eingegangen ist, werden wir Ihre Bestellung bearbeiten und die von Ihnen bestellte Artikel zu Ihnen schicken.</p>");
?>