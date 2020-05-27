<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: create_account.php 5745 2007-02-01 00:52:06Z ajeh $
 */

define('NAVBAR_TITLE', 'Регистрация');

define('HEADING_TITLE', 'Информация моего счёта');

define('TEXT_ORIGIN_LOGIN', '<strong class="note">ВНИМАНИЕ:</strong> Если у вас уже есть счёт с нами, пожалуйста, войдите в <a href="%s">Войдите в страницу</a>.');

// greeting salutation
define('EMAIL_SUBJECT', 'Добро пожаловать в ' . STORE_NAME);
define('EMAIL_GREET_MR', 'Уважаемый %s,' . "\n\n");
define('EMAIL_GREET_MS', 'Уважаемая %s,' . "\n\n");
define('EMAIL_GREET_NONE', 'Уважаемый %s' . "\n\n");

define('TEXT_REMEMBER_ME', 'Запомнить Меня');
define('EMAIL_WELCOME', 'Добро пожаловать в ' . STORE_NAME . ' (Бусины & Фурнитура & Аксессуар Оптом с бесплатной доставкой). Спасибо вам за регистрацию на нашем сайте, <b>Следующее является информацией вашего счёта:</b>');
define('EMAIL_CUSTOMER_EMAILADDRESS','<strong>Зарегистрированный адрес электронной почты:</strong>');
define('EMAIL_CUSTOMER_PASSWORD','<strong>Пароль:</strong>');
define('EMAIL_CUSTOMER_REG_DESCRIPTION','Сейчас вы можете войти на наш сайт и начать покупать с вашим счётом: <br /><a href="' . zen_href_link(FILENAME_DEFAULT) . '">www.doreenbeads.com</a>');
define('EMAIL_SEPARATOR', '--------------------');
define('EMAIL_COUPON_INCENTIVE_HEADER', 'Поздравляем вас!, Чтобы сделать ваш следуюший визит в наш интернет-магазин более полезным опытом, следующие являются подробностями для купона на скидку, созданный только для вас!' . "\n\n");
define('EMAIL_COUPON_REDEEM', 'Для использования купона на скидку, введите ' . TEXT_GV_REDEEM . ' код во время оплаты:  <strong>%s</strong>' . "\n\n");
define('TEXT_COUPON_HELP_DATE', '<p>Купон действует с %s до %s</p>');

define('EMAIL_GV_INCENTIVE_HEADER', 'Только сегодля, мы отправили вам ' . TEXT_GV_NAME . ' для %s!' . "\n");
define('EMAIL_GV_REDEEM', 'Это ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM . ' является: %s ' . "\n\n" . 'Вы можете ввести ' . TEXT_GV_REDEEM . ' во время оплаты, после вашего выбора в магазине. ');
define('EMAIL_GV_LINK', ' Или, Вы можете выкупить его сейчас по этой ссылке: ' . "\n");

define('EMAIL_GV_LINK_OTHER','Если вы купили ' . TEXT_GV_NAME . ' в ваш счёт, вы можете использоваться ' . TEXT_GV_NAME . ' для себя, или его отправить другу!' . "\n\n");

define('EMAIL_TEXT', 'В частности, мы сейчас специально предоставляем денежный купон в качестве первого подарка для вашей покупки на нашем сайте. Вы можете использовать его для сохранения 6.01US$ <span style="color:red">когда ваша первая покупка достигает 30 USD</span>.<br /><div style="border:1px dashed #FF99CC; padding:6px;"><b>Наслаждайтесь 6.01US$ Денежный Купон</b><br />Код купона: <span style="color:red;">DoreenBeads</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Купон: <span style="color:red;">6.01US$</span><br /><b>**Советы:</b>Когда вы платите и находитесь во 2-ому шагу, пожалуйста, введите DoreenBeads.com в выкупной коробке на нашем сайте, потом 6.01US $ купон будет вычитаться автоматически.<br /><span style="color:red;">Пожалуйста, спешите использовать этот код, потому что он будет истекать через 2 недели.</span></div>');
define('EMAIL_CONTACT', 'Для получения нашей помощи онлайн:<br />1. Нажмите кнопку Онлайн-Помощь на нашем сайте главной страницы<br />2. или отправить нам письмо на <a href="mailto:service_ru@doreenbeads.com">service_ru@doreenbeads.com</a><br /><br />');
define('EMAIL_KINDLY_NOTE', '<span style="color:red;"><b>** Тёплое Примечание: </b></span>сохраните эту электронную почту у себя. Если вы забудете свой пароль в будущем, вы можете проверять и отправлять на неё письмо.');
define('EMAIL_GV_CLOSURE','Sincerely' . "\n" . 'Doreenbeads Команда' . "\n\n\n". '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'.HTTP_SERVER . DIR_WS_CATALOG ."</a>\n\n");

define('EMAIL_DISCLAIMER_NEW_CUSTOMER', 'Этот адрес электронной почты был дан нам вам или одним из наших клиентов. Если вы не зарегистрируете счёт, или чувствуете, что вы получили это письмо по ошибке, пожалуйста, отправьте письмо на %s ');
?>
