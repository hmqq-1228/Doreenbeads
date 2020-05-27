<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: password_forgotten.php 3086 2006-03-01 00:40:57Z drbyte $
 */

define('NAVBAR_TITLE_1', 'Вход');
define('NAVBAR_TITLE_2', 'Забыли Пароль');
define('HEADING_TITLE', 'Забыли ваш пароль?');
define('TEXT_MAIN', 'Введите ваш адрес электронной почты регистрации и мы вышлём вам письмо с инструкциями по сбросу пароля.');
define('TEXT_NO_EMAIL_ADDRESS_FOUND', 'Счёт с этом адресом электронной почты не может быть найден.  - Если вам нужно создать счёт, пожалуйста, <a href="'.zen_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL').'">нажмите здесь.</a>');
define('EMAIL_PASSWORD_REMINDER_SUBJECT', STORE_NAME . ' - Сброс пароля');
define('TEXT_DEAR', 'Уважаемый ');
define('EMAIL_PASSWORD_REMINDER_BODY', '<br />Добро пожаловать в Doreenbeads!<br /><br />' . "\n\n" . 'Если вы забыли свой пароль, пожалуйста, посетите следующую веб-страницу для сброса пароля ( ссылка действует в течение 72 часов):' . '<br /><br />'
."\n\n".'<a href="%s">%s</a>'. '<br /><br />'."\n\n" . 'Если вы не принимаете восстановить пароль, пожалуйста, нажмите следующюю ссылку, чтобы отменить:' . '<br /><br />'."\n\n".'<a href="%s">%s</a>' . '<br /><br />'."\n\n".'По любым вопросам или проблемам, пожалуйста, не стесняйтесь <a href="mailto:'.EMAIL_FROM.'">с нами связаться</a>, мы рады вам помочь.'. '<br /><br />'."\n\n" . 'С наилучшим пожеланием' . '<br />' . "\n" . ' Doreenbeads сервисная команда' . '<br />' . "\n" .'<a href="'. HTTP_SERVER.'">'. HTTP_SERVER.'</a>');
define('TEXT_SUCCESS_PASSWORD_SENT', 'Мы отправим вам электронное письмо на ваш адрес электронной почты: %s через 2-5 минутов, что позволит вам сбросить пароль за 72 часа.');
define('TEXT_CHECK_CODE', 'Утверждающий Код:');
define('TEXT_FORGOT_EMAIL_ADDRESS', 'Если вы также забыли ваш адрес элекронной почты регистрации, пожалуйста <a href="mailto:'.EMAIL_FROM.'">свяжитесь с нами</a>.');
define('TEXT_INPUT_RIGHT_CODE', 'пожалуйста, введите правильный утверждающий код!');
?>
