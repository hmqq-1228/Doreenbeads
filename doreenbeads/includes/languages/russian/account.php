<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: account.php 3595 2006-05-07 06:39:23Z drbyte $
 */

define('NAVBAR_TITLE', 'Мои настройки');
define('HEADING_TITLE', 'Информация о моих настройках');

define('OVERVIEW_TITLE', 'Мои заказы');
define('OVERVIEW_SHOW_ALL_ORDERS', '(показать все заказы)');
define('OVERVIEW_PREVIOUS_ORDERS', 'Предыдущие заказы');
define('TABLE_HEADING_DATE', 'Дата');
define('TABLE_HEADING_ORDER_NUMBER', '№');
define('TABLE_HEADING_SHIPPED_TO', 'Доставка');
define('TABLE_HEADING_STATUS', 'Статус');
define('TABLE_HEADING_TOTAL', 'Всего');
define('TABLE_HEADING_VIEW', 'Просмотр');

define('MY_ACCOUNT_TITLE', 'Мои настройки');
define('MY_ACCOUNT_INFORMATION', 'Просмотр и редактирование профиля.');
define('MY_ACCOUNT_ADDRESS_BOOK', 'Просмотр и редактирование записей в адресной книге.');
define('MY_ACCOUNT_PASSWORD', 'Изменить пароль.');

define('MY_ORDERS_TITLE', 'Мои заказы');
define('MY_ORDERS_VIEW', 'Обзор заказов.');

define('EMAIL_NOTIFICATIONS_TITLE', 'Рассылка');
define('EMAIL_NOTIFICATIONS_NEWSLETTERS', 'Подписаться или отказаться от рассылки.');
define('EMAIL_NOTIFICATIONS_PRODUCTS', 'Посмотреть/изменить настройку подписки на новости о товарах.');

define('TEXT_INVITED_WRITE_REVIEWS', 'Уважаемый клиент,<br />Приглашаем Вас писать отзыв о заказе, пожалуйста, нажмите  ' . zen_image_button(BUTTON_IMAGE_VIEW_SMALL, BUTTON_VIEW_SMALL_ALT) . ' кнопку следующих заказов,чтобы просмотреть Ваши заказы,написать отзыв о продукте, рассказать нам, что вы думаете и поделиться своим мнением с другими.Ваши комментарии о нашей продукции будут высоко оценены, большое спасибо!');

define('TEXT_CREDIT_ACCOUNT','<b><font color="#FF6600"> Благодаря вашей предыдущей покупке,сейчас Вы получаете  <big>%s%.2f</big>  в вашем кредитном счете!!</font></b> Пожалуйста,нажмите  <a href="' . zen_href_link('cash_account', '', 'SSL') . '">Смотреть Мой Кредитный Счет</a> для подробности.</b>');
define('TEXT_CREDIT_ACCOUNT1','<b>Ура!</b> Все ваши предыдущие покупки здесь составляют: US $%.2f .');
define('TEXT_CREDIT_ACCOUNT2','Поздравляем, вы уже стали нашим <b>%s</b> VIP клиентом. <b>%.2f</b>%% скидок будет применяется в вашем следующем заказе. В сочетании с RCD, общая скидка будет  <b>%.2f</b>%%.<br />');
define('TEXT_GROUP_ACCOUNT1', 'Накопите %.2f US$  больше количеств заказов, чтобы достигнуть следующего уровня  <b>%s</b>, <b>%.2f</b>%% скидок. Вы можете посмотреть нашу <a target="_blank" href="' . zen_href_link(FILENAME_EZPAGES, 'id=65') . '">VIP политику</a>.<br /><br />');
define('TEXT_GROUP_ACCOUNT2', '<br/> Вы будете становиться нашим VIP клиентом, а затем наслаждаетесь<a target="_blank" href="' . zen_href_link(FILENAME_EZPAGES, 'id=65') . '">VIP скидкой</a> в том случае,когда ваш новый заказ достигает %.2f US$.<br /><br />');

define('TEXT_ALREADY_INCART0', 'Все детали этого ордена уже в корзине, можно изменить количество непосредственно в корзине.');
define('TEXT_ALREADY_INCART1', 'Пункт %s уже в корзине, можно изменить количество непосредственно в корзине.');
define('TEXT_ALREADY_INCART2', 'Предметы %s которые уже находятся в вашей корзине, можно изменить количество непосредственно в корзине.');

define('TEXT_REORDER_REMOVED_TIPS', '%s был удален и не может быть добавлен в корзину. По любым вопросам, пожалуйста, свободно связаться с нами через service_ru@doreenbeads.com.');
?>
