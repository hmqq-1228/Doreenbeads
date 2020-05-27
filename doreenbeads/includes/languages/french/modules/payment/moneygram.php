<?php
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_FIRST_NAME', 'Prénom : ');
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_LAST_NAME', 'Nom: ');
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_ADDRESS', 'Adresse : ');
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_ZIP', 'Code postal : ');
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_CITY', 'Ville : ');
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_COUNTRY', 'Pays: ');
  define('MODULE_PAYMENT_MONEYGRAM_ENTRY_PHONE', 'Téléphone : ');


  define('MODULE_PAYMENT_MONEYGRAM_ABOUT_INFO', ' ( <a href="'.zen_href_link('page','id=236').'" target="_blank">Sur Money Gram &gt;&gt;</a> )');
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

  define('MODULE_PAYMENT_MONEYGRAM_TEXT_DESCRIPTION', '<table cellpadding="0" cellspacing="0"><tr><th width="135">'. MODULE_PAYMENT_MONEYGRAM_ENTRY_FIRST_NAME .'</th><td>' . MODULE_PAYMENT_MONEYGRAM_RECEIVER_FIRST_NAME . '</td></tr><tr><th>'.MODULE_PAYMENT_MONEYGRAM_ENTRY_LAST_NAME . '</th><td>' .   MODULE_PAYMENT_MONEYGRAM_RECEIVER_LAST_NAME . '</td></tr>
                            <tr>
                                <th>' . MODULE_PAYMENT_MONEYGRAM_ENTRY_ADDRESS . '</th>
                                <td>' . MODULE_PAYMENT_MONEYGRAM_RECEIVER_ADDRESS . '</td>
                            </tr>
                            <tr>
                                <th>'. MODULE_PAYMENT_MONEYGRAM_ENTRY_ZIP . '</th>
                                <td>'.   MODULE_PAYMENT_MONEYGRAM_RECEIVER_ZIP . '</td>
                            </tr>
                            <tr>
                                <th>'. MODULE_PAYMENT_MONEYGRAM_ENTRY_CITY .   '</th>
                                <td>'.  MODULE_PAYMENT_MONEYGRAM_RECEIVER_CITY . '</td>
                            </tr>
                            <tr>
                                <th>'.  MODULE_PAYMENT_MONEYGRAM_ENTRY_COUNTRY . '</th>
                                <td>'.   MODULE_PAYMENT_MONEYGRAM_RECEIVER_COUNTRY . '</td>
                            </tr>
                            <tr>
                                <th>'.  MODULE_PAYMENT_MONEYGRAM_ENTRY_PHONE . '</th>
                                <td>'.   MODULE_PAYMENT_MONEYGRAM_RECEIVER_PHONE . '</td>
                            </tr>
                        </table>');
  
  define('MODULE_PAYMENT_MONEYGRAM_TEXT_EMAIL_FOOTER', '<br>Les infos du bénéficiaire:<div style="line-height:23px;padding: 8px 0 12px 24px;">' .  '<p><b>'. MODULE_PAYMENT_MONEYGRAM_ENTRY_FIRST_NAME .'</b><span style="color:red">' . MODULE_PAYMENT_MONEYGRAM_RECEIVER_FIRST_NAME . '</span></p>' .  '<p><b>'.MODULE_PAYMENT_MONEYGRAM_ENTRY_LAST_NAME . '</b><span style="color:red">' .   MODULE_PAYMENT_MONEYGRAM_RECEIVER_LAST_NAME . '</span></p>' .  '<p><b>' . MODULE_PAYMENT_MONEYGRAM_ENTRY_ADDRESS . '</b><span style="color:red">' . MODULE_PAYMENT_MONEYGRAM_RECEIVER_ADDRESS . '</span></p>'  .   '<p><b>'. MODULE_PAYMENT_MONEYGRAM_ENTRY_ZIP . '</b><span style="color:red">'.   MODULE_PAYMENT_MONEYGRAM_RECEIVER_ZIP . '</span></p>'  .   '<p><b>'. MODULE_PAYMENT_MONEYGRAM_ENTRY_CITY .   '</b><span style="color:red">'.  MODULE_PAYMENT_MONEYGRAM_RECEIVER_CITY . '</span></p>'  .  '<p><b>'.  MODULE_PAYMENT_MONEYGRAM_ENTRY_COUNTRY . '</b><span style="color:red">'.   MODULE_PAYMENT_MONEYGRAM_RECEIVER_COUNTRY . '</span></p>'  .   '<p><b>'.  MODULE_PAYMENT_MONEYGRAM_ENTRY_PHONE . '</b><span style="color:red">'.   MODULE_PAYMENT_MONEYGRAM_RECEIVER_PHONE . "</span></p></div>" . "<b>Apès avoir fait le paimement, veuillez nous envoyer une lettre: (<a href='mailto:service@8seasons.com'><font style='color:#0000FF;'>service@8seasons.com</font></a>) comportant les infos ci-dessous:</b><ul style='font-weight: normal;line-height: 22px;padding: 10px 0 14px 24px;'><li style='color:red'>1.le N°de contrôle de 8 chiffres.</li><li style='color:red'>2. Le montant vous avez payé et le genre de monnaie.</li><li style='color:red'>3. Votre pays.</li><li style='color:red'>4. Nom complet du Payeur (y compris le prénom et nom de famille).</li><li style='color:red'></li><li>5. Si c’est possible, s’il vous plaît nous offrir la photo de votre document de remise après que vous avez effectué le paiement.</li></ul><p style='color:red'>Note: S’il vous plaît assurez-vous que vous avez écrit les informations correctes au moment du paiement, sinon, nous ne pouvions pas retirer de l’argent.</p><p style='margin-top:10px;'>Une fois que nous recevons votre paiement, nous commencerons à traiter votre commande et l’expédierons le plus tôt possible.</p>");
?>