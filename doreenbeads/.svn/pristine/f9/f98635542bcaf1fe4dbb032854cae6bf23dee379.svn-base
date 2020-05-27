<?php
chdir("../");
@set_time_limit(0);
@ini_set('memory_limit','2048M');
require('includes/application_top.php');
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");
if($_GET['birthday'] == 'set_coupon'){
  global $db;
  $birthday_title_en = 'Birthday Coupon';
  $birthday_message_en = 'Here\'s greetings from Doreenbeads Team,
<br/>
&nbsp;&nbsp;Happy Birthday %s!Today is your birthday,may you be happy!
<br/>
&nbsp;&nbsp;%s, how many friends will you invite to your birthday party? What kind of dishes will you prepare? What about some songs? I guess you will spend the great time with your dear families and friends.
<br/>
&nbsp;&nbsp;In addition to those, we have also prepared a surprise for you: unique birthday gift - <strong><font color="red">&nbsp;$8</font> Birthday Coupon.</strong> We have added it to your <a href="'.HTTP_SERVER.'/index.php?main_page=my_coupon" style="color:red;"> your account</a>. 
<br/>
&nbsp;&nbsp;Tips:
<br/>
1) The $8 coupon could be used with any other discount. But it couldn\'t be compatible with other coupons. 
<br/>
2) The Birthday Coupon is one-off
<br/>
3) The coupon will be available only when the total item price reaches $30.
<br/>
<br/>
&nbsp;&nbsp;Many thanks and wish you joyful everyday!
<br/>
&nbsp;&nbsp;From Doreenbeads Team';
  $bottom_newsletter_en = '<table border="0" cellpadding="0" cellspacing="0" height="1" style="margin-left: 0;margin-top: 10px;">
					<tr>
						<td><a href="http://eepurl.com/graJfv"><img src="https://img.doreenbeads.com/promotion_photo/en/images/20190812/550X100en.jpg" alt="Subscribe to Our Newsletter Now"/></a></td>
					</tr>
				
				</table>';
  $birthday_title_de = 'Gratulation von dorabeads';
  $birthday_message_de = 'Hallo,%s, , heute ist Ihr Geburtstag !
<br/>
Wie werden Sie diesen speziellen Tag verbringen ? Vielleicht mit Ihren Familien oder besten Freunden ? Also, herzlichen Glückwunsch zu Ihrem Geburtstag!
Heute haben wir auch ein spezielles Geburtstagsgeschenk für Sie vorbereitet: ein Geburtstagsgutschein im Wert von $8. Wir haben schon diesen Gutschein auf Ihr Konto gutgeschrieben. <a href="'.HTTP_SERVER.'/de/index.php?main_page=my_coupon" style="color:red;">Ihr Konto ansehen</a>. 
<br/>
&nbsp;&nbsp;Hinweise zum Gutschein:
<br/>
1) Der Geburtstagsgutschein ist kompatibel mit anderen Rabatten(Discount, VIP, usw.), aber man kann nicht gleichzeitig 2 Gutscheine benutzen.
<br/>
2) Der Geburtstagsgutschein ist einmalig einlösbar. 
<br/>
3) Wenn der Gesamtproduktpreis $30 erreicht ,ist Ihr Geburtstagsgutschein erst gültig.
<br/>
<br/>
&nbsp;&nbsp;Vielen Dank und wir wünschen Ihnen einen schönen Tag!
<br/>
&nbsp;&nbsp;Doria,Melanie aus Doreenbeads Team';
  $bottom_newsletter_de = '<table border="0" cellpadding="0" cellspacing="0" height="1" style="margin-left: 0;margin-top: 10px;">
					<tr>
						<td><a href="http://eepurl.com/gq4YqX"><img src="https://img.doreenbeads.com/promotion_photo/de/images/20190812/550X100de.jpg" alt="Abonnieren Sie jetzt unseren Newsletter"/></a></td>
					</tr>
				
				</table>';
  $birthday_title_ru = 'Купон на день рождения';
  $birthday_message_ru = 'Дорогая, %s!
<br/>
Как ваше дело? Надеюсь, что у вас все в порядке.
<br/>
&nbsp;&nbsp;С днем рождения %s, сегодня – ваш день рождения. Желаю вам радости и счастья.  
<br/>
&nbsp;&nbsp;%s,  сколько друзей вы собираетесь пригласить на день рождения? Какие блюда вы готовите? Какие песни вы поете? 
<br/>
&nbsp;&nbsp;Думаю, что это должно быть очень весело и интересно устроить вечеринку у себя дома со всей семьей и друзьями, и вы вместе проводите счастливое время. ^_^ 
<br/>
&nbsp;&nbsp;Мы готовим сюрприз для вас: специальный подарок ---  Купон $8 на день рождения. Мы уже добавили купон в ваш счет. <a href="'.HTTP_SERVER.'/ru/index.php?main_page=my_coupon" style="color:red;">Мой счет</a>. 
<br/>
&nbsp;&nbsp;Правила использования купона:
<br/>
1) Вы можете использовать этот купон вместе с другами скидками, не можете использовать вместе со другами купонами.
<br/>
2) Купон на день рождения одноразовый купон.
<br/>
3) Только стоимость ваших товаров заказа 30 долларов, вы можете использовать купон $8.
<br/>
<br/>
&nbsp;&nbsp;Желаю вам прекрасного дня!
<br/>
&nbsp;&nbsp;С наилучшими пожеланиями.
<br/>
&nbsp;&nbsp;Команда Doreenbeads';
    $bottom_newsletter_ru = '<table border="0" cellpadding="0" cellspacing="0" height="1" style="margin-left: 0;margin-top: 10px;">
					<tr>
						<td><a href="http://eepurl.com/gq3UKT"><img src="https://img.doreenbeads.com/promotion_photo/de/images/20190812/550X100ru.jpg" alt="Подписывайтесь на нашу новостную рассылку"/></a></td>
					</tr>
				
				</table>';
  $birthday_title_fr = 'Coupon d’anniversaire';
  $birthday_message_fr = 'Voici les salutations d’Equipe Doreenbeads !
<br/>
&nbsp;&nbsp;%s, c’est votre anniversaire aujourd’hui, joyeux anniversaire!
<br/>
&nbsp;&nbsp;%s, comment vous passerez votre anniversaire? Passerez une soirée agréable avec votre famille et vos amis? Donnerez un rendez-vous avec votre chéri(e) ? Ou ferez des achats pour le célébrer ? J’espère que vous aurez une très belle journée en ce jour !
<br/>
&nbsp;&nbsp;Comme notre client(e) fidèle, nous avons préparé une surprise pour vous : un cadeau spécial –<strong> un coupon de US$8</strong>. Et nous l’avons ajouté à <a href="'.HTTP_SERVER.'/fr/index.php?main_page=my_coupon" style="color:red;">votre compte.</a>. 
<br/>
&nbsp;&nbsp;Conditions d’en profiter :
<br/>
1) Le coupon est cumulable avec d\'autres offres promotionnelles en cours, mais non-cumulable avec d’autres coupons.
<br/>
2)	Le coupon est valable 1 seule fois.
<br/>
3)	Le coupon est à utiliser dès US$30 de vos achats.
<br/>
<br/>
&nbsp;&nbsp;Très Cordialement
<br/>
&nbsp;&nbsp;Equipe Doreenbeads';
    $bottom_newsletter_fr = '<table border="0" cellpadding="0" cellspacing="0" height="1" style="margin-left: 0;margin-top: 10px;">
					<tr>
						<td><a href="http://eepurl.com/gq3Ndv"><img src="https://img.doreenbeads.com/promotion_photo/fr/images/20190814/dbfr-abonnerheng.jpg" alt="Abonnez-vous ид notre newsletter maintenant"/></a></td>
					</tr>
				
				</table>';
  $birthday_title_es = 'Cupón de Cumpleaños';
  $birthday_message_es = 'Querido %s,
<br/>
&nbsp;&nbsp;Hola, somos de Doreenbeads.
<br/>
&nbsp;&nbsp;Hoy es su cumpleaños, muchas felicidades a usted y deseamos de corazón que hoy tenga una buena combinación de risas, amor y alegría.
<br/>
&nbsp;&nbsp;¿Cómo va a celebrar su cumpleaños? Supongo que quizás vaya a tener una fiesta o una cena especial con sus amigos y familiares a celebrarlo. 
<br/>
&nbsp;&nbsp;Le hemos preparado una sorpresa, el regalo especial para usted—un cupón de 8 dólares para su cumpleaños. Hemos acreditado este cupón a <a href="'.HTTP_SERVER.'/es/index.php?main_page=my_coupon" style="color:red;">su cuenta</a> en nuestra tienda. 
<br/>
&nbsp;&nbsp;Reglas:
<br/>
1）	Usted puede usar este cupón de 8 dólares junto con otros descuentos, pero no se pueden usar otros cupónes al mismo tiempo.
<br/>
2）	El cupón de cumpleaños sólo se puede usar una vez.
<br/>
3）	Se puede usar este cupón cuando el importe de todos sus productos llega a $30.
<br/>
<br/>
&nbsp;&nbsp;¡Que tenga un feliz día!
<br/>
&nbsp;&nbsp;Un saludo,
<br/>
&nbsp;&nbsp;De Equipo Doreenbeads';

  define('STORE_NAME', 'doreenbeads.com');
  define('STORE_NAME', 'doreenbeads.com');
  $prev_page = $_SERVER['HTTP_REFERER'];
  
  $html_msg['EMAIL_FIRST_NAME'] = '';
  $html_msg['EMAIL_LAST_NAME'] = '';
  
  
  $customers_sql = $db->Execute('SELECT customers_id,customers_firstname,customers_lastname,register_languages_id,c.customers_email_address,customers_dob FROM  t_customers c WHERE  month(customers_dob)  = "'.date('m').'" and day(customers_dob) = "'.date('d').'" and customers_dob > "1900-01-01 00:00:00" order by customers_id desc');
  
  $birthday_coupon_select = $db->Execute("SELECT * FROM ".TABLE_COUPONS." WHERE coupon_code='" . CUSTOMERS_COUPON_CODE . "'");
  $birthday_coupon_id = $birthday_coupon_select->fields['coupon_id'];
  $birthday_coupon_amount = $birthday_coupon_select->fields['coupon_amount'];

  while (!$customers_sql->EOF) {
	if($customers_sql->fields['customers_id'] > 0){
		$customers_dob_coupon_sql = "SELECT * FROM ".TABLE_COUPON_CUSTOMER." WHERE cc_coupon_id=".$birthday_coupon_id." AND cc_customers_id=".$customers_sql->fields['customers_id']." AND year(date_created) = ".date('Y')." limit 1";
		$customers_dob_coupon = $db->Execute($customers_dob_coupon_sql);
		if ($customers_dob_coupon->RecordCount() > 0){
			
		}else{
			if($customers_sql->fields['register_languages_id'] == 1){
					$title = $birthday_title_en;
					$html_msg['EMAIL_MESSAGE_HTML'] = sprintf($birthday_message_en,$customers_sql->fields['customers_firstname'],$customers_sql->fields['customers_firstname']);
                    $html_msg['TEXT_EMAIL_NEWSLETTER'] = $bottom_newsletter_en;
			}else if($customers_sql->fields['register_languages_id'] == 2){
					$title = $birthday_title_de;
					$html_msg['EMAIL_MESSAGE_HTML'] = sprintf($birthday_message_de,$customers_sql->fields['customers_firstname']);
                $html_msg['TEXT_EMAIL_NEWSLETTER'] = $bottom_newsletter_de;
			}else if($customers_sql->fields['register_languages_id'] == 3){
					$title = $birthday_title_ru;
					$html_msg['EMAIL_MESSAGE_HTML'] = sprintf($birthday_message_ru,$customers_sql->fields['customers_firstname'],$customers_sql->fields['customers_firstname'],$customers_sql->fields['customers_firstname']);
                $html_msg['TEXT_EMAIL_NEWSLETTER'] = $bottom_newsletter_ru;
			}else if($customers_sql->fields['register_languages_id'] == 4){
					$title = $birthday_title_fr;
					$html_msg['EMAIL_MESSAGE_HTML'] = sprintf($birthday_message_fr,$customers_sql->fields['customers_firstname'],$customers_sql->fields['customers_firstname']);
                    $html_msg['TEXT_EMAIL_NEWSLETTER'] = $bottom_newsletter_fr;
			}else if($customers_sql->fields['register_languages_id'] == 5){
					$title = $birthday_title_es;
					$html_msg['EMAIL_MESSAGE_HTML'] = sprintf($birthday_message_es,$customers_sql->fields['customers_firstname']);
			}else{
					$title = $birthday_title_en;
					$html_msg['EMAIL_MESSAGE_HTML'] = sprintf($birthday_message_en,$customers_sql->fields['customers_firstname'],$customers_sql->fields['customers_firstname']);
			}
			//$get_birthday_coupon_sql = "select coupon_id from t_coupons where coupon_name like 'Birthdaycoupon-".date('Y')."%' limit 1";
			//$get_birthday_coupon = $db->Execute($get_birthday_coupon_sql);
			//if ($get_birthday_coupon->fields['coupon_id'] > 0){
				$db->Execute('INSERT INTO  `t_customers_dob_coupon` (`customers_id` ,`coupon_start_date` ,`coupon_end_date`)VALUES ('.$customers_sql->fields['customers_id'].',  now(),  now());');

				$coupon_customer_sql = 'INSERT INTO ' . TABLE_COUPON_CUSTOMER . ' (cc_coupon_id , cc_customers_id , cc_amount , cc_coupon_start_time , cc_coupon_end_time , cc_coupon_status , website_code, date_created) VALUES (' . $birthday_coupon_id . ' , ' . $customers_sql->fields['customers_id'] . ' , ' . $birthday_coupon_amount . ' , "' . date('Y-m-d H:i:s') . '" , "' . date('Y-m-d H:i:s', strtotime("+3 month")) . '" , 10 , '. WEBSITE_CODE .', now()) ';
                $db->Execute($coupon_customer_sql);


            $html_msg ['COUPON_TEXT_TO_REDEEM'] = '';
            $html_msg ['COUPON_TEXT_VOUCHER_IS'] = '';
            $html_msg ['COUPON_CODE'] = '';
            $html_msg ['COUPON_DESCRIPTION'] = '';
            $html_msg ['COUPON_TEXT_REMEMBER'] = '';
            $html_msg ['COUPON_REDEEM_STORENAME_URL'] = '';

				zen_mail($customers_sql->fields['customers_firstname'].' '.$customers_sql->fields['customers_lastname'], $customers_sql->fields['customers_email_address'], $title, '', STORE_NAME, EMAIL_FROM, $html_msg,'coupon');
			//}

			//zen_mail($customers_sql->fields['customers_firstname'].' '.$customers_sql->fields['customers_lastname'], $customers_sql->fields['customers_email_address'], $title, 'dob', STORE_NAME,'sale@doreenbeads.com', $html_msg, 'coupons', '', 'true');
		}
	}
    $customers_sql->MoveNext();
  }
  echo 'succ';
}
 
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);

?>