<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: email_extras.php 7161 2007-10-02 10:58:34Z drbyte $
 */

// office use only
  define('OFFICE_FROM','<strong>От:</strong>');
  define('OFFICE_EMAIL','<strong>Электронная Почта:</strong>');

  define('OFFICE_SENT_TO','<strong>Отправили в:</strong>');
  define('OFFICE_EMAIL_TO','<strong>На Электронную Почту:</strong>');

  define('OFFICE_USE','<strong>Только для Служебного пользования:</strong>');
  define('OFFICE_LOGIN_NAME','<strong>Имя для входа:</strong>');
  define('OFFICE_LOGIN_EMAIL','<strong>Электронная Почта для входа:</strong>');
  define('OFFICE_LOGIN_PHONE','<strong>Телефон:</strong>');
  define('OFFICE_LOGIN_FAX','<strong>Факс:</strong>');
  define('OFFICE_IP_ADDRESS','<strong>IP Адрес:</strong>');
  define('OFFICE_HOST_ADDRESS','<strong>адрес хоста:</strong>');
  define('OFFICE_DATE_TIME','<strong>Дата и Время:</strong>');
  if (!defined('OFFICE_IP_TO_HOST_ADDRESS')) define('OFFICE_IP_TO_HOST_ADDRESS', 'ВЫКЛ');

// email disclaimer
  define('EMAIL_DISCLAIMER', 'Этот адрес электронной почты был нам дан вами или одним из наших клиентов. Если вы чувствуете, что вы получили это письмо по ошибке, пожалуйста, отправляйте письмо на %s ');
  define('EMAIL_SPAM_DISCLAIMER','Это письмо отправили в соответствии с американским законом CAN-SPAM, который был в силу 01.01.2004. Запросы на удаление могут быть отправлены на этот адрес и будут почитаны и уважаемы.');
  define('EMAIL_FOOTER_COPYRIGHT','Авторское право (c) ' . date('Y') . ' <a href="' . zen_href_link(FILENAME_DEFAULT) . '" target="_blank">' . STORE_NAME . '</a>. Поддержан <a href="https://www.doreenbeads.com/" target="_blank">DoreenBeads</a>');
  define('TEXT_UNSUBSCRIBE', "\n\nЧтобы отписаться от будущих информационных бюллетеней и рекламных сообшений, просто нажмите следующую ссылку: \n");

// email advisory for all emails customer generate - tell-a-friend and GV send
  define('EMAIL_ADVISORY', '-----' . "\n" . '<strong>IMPORTANT:</strong> Для вашей защиты и предотвращения злоупотребления, все электронные письма отправлены через этот зарегистрированный вэб-сайт и их содержание записано и доступно для владельца магазина. Если вы чувствуете, что вы получили это письмо по ошибке, пожалуйста, отправьте письмо на ' . STORE_OWNER_EMAIL_ADDRESS . "\n\n");

// email advisory included warning for all emails customer generate - tell-a-friend and GV send
  define('EMAIL_ADVISORY_INCLUDED_WARNING', '<strong>Это сообщение включает все письма отправленые с этого сайта:</strong>');
define('TEXT_EMAIL_NEWSLETTER', '<table border="0" cellpadding="0" cellspacing="0" height="1" style="margin-left: 0;margin-top: 10px;">
					<tr>
						<td><a href="http://eepurl.com/gq3UKT"><img src="https://img.doreenbeads.com/promotion_photo/de/images/20190812/550X100ru.jpg" alt="Подписывайтесь на нашу новостную рассылку"/></a></td>
					</tr>
				
				</table>');


// Admin additional email subjects
  define('SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO_SUBJECT','[СОЗДАТЬ СЧЁТ]');
  define('SEND_EXTRA_TELL_A_FRIEND_EMAILS_TO_SUBJECT','[РАССКАЗАТЬ ДРУГУ]');
  define('SEND_EXTRA_NEW_ORDERS_EMAILS_TO_SUBJECT','[НОВЫЙ ЗАКАЗ]');
  define('SEND_EXTRA_CC_EMAILS_TO_SUBJECT','[ДОПОЛНИТЕЛЬНАЯ ИНФОРМАЦИЯ ЗАКАЗА CC] #');

// Low Stock Emails
  define('EMAIL_TEXT_SUBJECT_LOWSTOCK','Предупреждение: Низкие Запасы Склада');
  define('SEND_EXTRA_LOW_STOCK_EMAIL_TITLE','Сообшение низких запасов склада: ');

// for when gethost is off
  define('OFFICE_IP_TO_HOST_ADDRESS', 'Запрещённый');
?>