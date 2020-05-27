<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: time_out.php 3027 2006-02-13 17:15:51Z drbyte $
 */

define('NAVBAR_TITLE', 'Ожидания Входа');
define('HEADING_TITLE', 'Ой! Ваша сессия истекла.');
define('HEADING_TITLE_LOGGED_IN', 'Ой! Извините, но вы не можете выполнять запрашиваемые действия. ');
define('TEXT_INFORMATION', '<p>Если вы размещаете заказ, пожалуйста, войдите и ваша корзина будет восстановлена. Затем вы можете вернуться к оформлению заказа и завершить окончательные покупки.</p><p>Если вы завершили заказ и хотите рассмотреть его' . (DOWNLOAD_ENABLED == 'Действительно' ? ', или имеете загрузку и хотите восстановить его' : '') . ', Пожалуйста, перейдите на <a href="' . zen_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">Мой Счёт</a> страницу для просмотра вашего заказа.</p>');

define('TEXT_INFORMATION_LOGGED_IN', 'Вы всё ещё входите в свой счёт и можете продолжать покупать. Пожалуйста, выберите назначение из меню.');

define('HEADING_RETURNING_CUSTOMER', 'Вход');
define('TEXT_PASSWORD_FORGOTTEN', 'Забыли Ваш Пароль?')
?>