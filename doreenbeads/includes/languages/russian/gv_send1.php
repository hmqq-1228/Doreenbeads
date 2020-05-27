<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: gv_send.php 3421 2006-04-12 04:16:14Z drbyte $
 */

define('HEADING_TITLE', 'Отправить ' . TEXT_GV_NAME);
define('HEADING_TITLE_CONFIRM_SEND', 'Отправить ' . TEXT_GV_NAME . ' Подтверждение');
define('HEADING_TITLE_COMPLETED', TEXT_GV_NAME . ' Отправили');
define('NAVBAR_TITLE', 'Отправить ' . TEXT_GV_NAME);
define('EMAIL_SUBJECT', 'Сообщение от ' . STORE_NAME);
define('HEADING_TEXT','Пожалуйста, введите имя, адрес электронной почты и сумму ' . TEXT_GV_NAME . ' которую вы хотите отправить. Для получения дополнительной информации, пожалуйста, посмотрите <a href="' . zen_href_link(FILENAME_GV_FAQ, '', 'NONSSL').'">' . GV_FAQ . '.</a>');
define('ENTRY_NAME', 'Имя Получателя:');
define('ENTRY_EMAIL', 'Электронная Почта Получателя:');
define('ENTRY_MESSAGE', 'Ваше Сообщение:');
define('ENTRY_AMOUNT', 'Сумма для отправления:');
define('ERROR_ENTRY_TO_NAME_CHECK', 'Мы не получили имени получателя. Пожалуйста, заполните ее в следующее. ');
define('ERROR_ENTRY_AMOUNT_CHECK', 'The ' . TEXT_GV_NAME . ' сумма указана не правильно. Пожалуйста, попробуйте еще раз.');
define('ERROR_ENTRY_EMAIL_ADDRESS_CHECK', 'Адрес электронной почты правильно? Пожалуйста, попробуйте еще раз.');
define('MAIN_MESSAGE', 'Вы отправляете ' . TEXT_GV_NAME . ' стоимостью %s в %s,  адрес электронной почты является %s. Если эти подробности не правильно, вы можете редактировать своё сообщение, нажав <strong>edit</strong> кнопку.<br /><br />Сообщение, которое вы отправляете:<br /><br />');
define('SECONDARY_MESSAGE', 'Здравствуйте %s,<br /><br />' . 'Вам отправили ' . TEXT_GV_NAME . ' стоимостью %s %s');
define('PERSONAL_MESSAGE', '%s скажет:');
define('TEXT_SUCCESS', 'Поздоавляем вас, что ваш ' . TEXT_GV_NAME . ' отправлён.');
define('TEXT_SEND_ANOTHER', 'Вы хотите отпрвавить другой ' . TEXT_GV_NAME . '?');
define('TEXT_AVAILABLE_BALANCE',  'Счёт подарочного сертификата');

define('EMAIL_GV_TEXT_SUBJECT', 'Подарок от %s');
define('EMAIL_SEPARATOR', '----------------------------------------------------------------------------------------');
define('EMAIL_GV_TEXT_HEADER', 'Поздоавляем вас, что вы получили ' . TEXT_GV_NAME . ' стоимостью %s');
define('EMAIL_GV_FROM', 'Этот ' . TEXT_GV_NAME . ' вам отправили %s');
define('EMAIL_GV_MESSAGE', 'с сообщением, в котором пишет: ');
define('EMAIL_GV_SEND_TO', 'Здравствуйте, %s');
define('EMAIL_GV_REDEEM', 'Чтобы выкупать этот ' . TEXT_GV_NAME . ', нажмите ссылку ниже, пожалуйста. Пожалуйста, запишите ' . TEXT_GV_REDEEM . ': %s  на всякий случай у вас есть вопросы.');
define('EMAIL_GV_LINK', 'Чтобы выкупить, пожалуйста, нажмите здесь');
define('EMAIL_GV_VISIT', ' или посетить ');
define('EMAIL_GV_ENTER', ' и ввести ' . TEXT_GV_REDEEM . ' ');
define('EMAIL_GV_FIXED_FOOTER', 'Если у вас есть проблемы с выкупом ' . TEXT_GV_NAME . ' используя автоматизированную ссылку выше, ' . "\n" .
                                'вы также можете ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM . ' в процессе оформления заказа в нашем магазине.');
define('EMAIL_GV_SHOP_FOOTER', '');
?>