<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @copyright Originally Programmed By: Christopher Bradley (www.wizardsandwars.com) for OsCommerce
 * @copyright Modified by Jim Keebaugh for OsCommerce
 * @copyright Adapted for Zen Cart
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: unsubscribe.php 3159 2006-03-11 01:35:04Z drbyte $
 */

define('NAVBAR_TITLE', 'Отписаться');
define('HEADING_TITLE', 'Отписаться от наших почтовых сообщений');

define('UNSUBSCRIBE_TEXT_INFORMATION', '<br />Очень жаль, что вы хотите отписаться от наших почтовых сообшений. Если вы сомневаетесь в безопасности нахождения вашего e-mail адреса у нас, то пожалуйста, прочитайте наше <a href="' . zen_href_link(FILENAME_PRIVACY,'','NONSSL') . '"><span class="pseudolink">уведомление о конфиденциальности</span></a>.<br /><br />Наши подписчики получают почту только о товаре, ценах и новых акциях.<br /><br />Если вы всё ещё хотите отписаться, то нажмите кнопку внизу, пожалуйста. ');
define('UNSUBSCRIBE_TEXT_NO_ADDRESS_GIVEN', '<br />Очень жаль, что вы хотите отписаться от наших почтовых рассылок. Если вы сомневаетесь в безопасности нахождения вашего e-mail адреса у нас, то пожалуйста, прочитайте наше <a href="' . zen_href_link(FILENAME_PRIVACY,'','NONSSL') . '"><span class="pseudolink">уведомление о конфиденциальности</span></a>.<br /><br />Наши подписчики получают почту только о товаре, ценах и новых акциях.<br /><br />Если Вы всё ещё хотите отписаться, то нажмите кнопку внизу, пожалуйста. Вы попадете на страницу ваших данных, где вы и можете редактировать вашу подписку. Перед этим, вам нужно войти..');
define('UNSUBSCRIBE_DONE_TEXT_INFORMATION', '<br />Ваш адрес электронный почты, перечислен ниже, был удален из списка "Подписка почтовых сообщений", согласно вашему запросу. <br /><br />');
define('UNSUBSCRIBE_ERROR_INFORMATION', '<br />Адрес электронной почты, который вы указали, не был найден в нашей базе почтовых сообщений или уже был удален из списка подписки почтовых сообщений. <br /><br />');
?>