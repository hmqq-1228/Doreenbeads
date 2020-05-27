<?php
@setlocale ( LC_TIME, 'ru_RU.UTF-8');
define('DATE_FORMAT_SHORT', '%m/%d/%Y'); // this is used for strftime()
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT', 'm/d/Y'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

if (! function_exists('zen_date_raw')) {
	function zen_date_raw($date, $reverse = false) {
		if ($reverse) {
			return substr ( $date, 0, 2 ) . substr ( $date, 3, 2 ) . substr ( $date, 6, 4 );
		} else {
			return substr ( $date, 6, 4 ) . substr ( $date, 3, 2 ) . substr ( $date, 0, 2 );
		}
	}
}

define('TEXT_PAYMENT_PROMPT',"Прошу вас предоставлять квитанцию об оплате, чтобы мы подтвердить вашу информацию.");
define('TEXT_PAYMENT_HSBS_CHINA','<p>1. Передавая деньги нам, пожалуйста, запишите свой номер заказа в колонке замечаний формы банковского перевода. </p>
<p>2. Пожалуйста <a href="mailto:serivce_ru@doreenbeads.com" style="color:#008FED;">отправьте нам</a> платежную информацию после передачи денег, чтобы мы подтвердить вашу информацию и отправить посылку своевременно.</p>
<p>3. Вы получаете скидку 2%, если общая сумма ваших заказов достигает 2000 долларов. И плательщик должен быть заплатить комиссию.</p>');
// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead
// of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'RUB');
define('TEXT_REGULAR_AMOUNT','Regular amount');
define('TEXT_CART_PRODUCT_DISCOUNTS', 'discounted-priced amount');

// Global entries for the <html> tag
define('HTML_PARAMS', 'dir="ltr" lang="en"');
define('TEXT_QUESEMAIL_NAME', 'Имя Клиентов');
// charset for web pages and emails
define('CHARSET', 'utf-8');
define('TEXT_TIME','Bремя');
define('DISCRIPTION', 'Описание');
define('TEXT_CREATE_MEMO','Записка');
define('TEXT_HEADER_MY_ACCOUNT','Мой Счёт');
define('TEXT_NO_WATERMARK_PICTURE', 'Предоставить Картины Без Водяных Знаков');

define('TEXT_TRUSTBOX_WIDGET_CONTENT', '<!-- TrustBox widget - Micro Review Count -->
<div style="left: -25px;position: relative;height: 10px;" class="trustpilot-widget" data-locale="ru-RU" data-template-id="5419b6a8b0d04a076446a9ad" data-businessunit-id="5742c0810000ff00058d3c5b" data-style-height="50px" data-style-width="100%" data-theme="light">
<a href="https://ru.trustpilot.com/review/doreenbeads.com" target="_blank">Trustpilot</a>
</div>
<!-- End TrustBox widget -->');

define('TEXT_TEL_NUMBER', '(+86) 571-28197839');
define('CHECKOUT_ZIP_CODE_ERROR', 'Проверьте, пожалуйста, свой почтовый индекс, правильный формат:');
define('TEXT_OR', 'или');

// Define the name of your Gift Certificate as Gift Voucher, Gift Certificate,
// Zen Cart Dollars, etc. here for use through out the shop
define('TEXT_GV_NAME', 'Подарочный Сертификат');
define('TEXT_GV_NAMES', 'Подарочный Сертификат');

// used for redeem code, redemption code, or redemption id
define('TEXT_GV_REDEEM', 'Код Погашения');

// used for redeem code sidebox
define('BOX_HEADING_GV_REDEEM', TEXT_GV_NAME );
define('BOX_GV_REDEEM_INFO', 'Код Погашения: ');

// text for gender
define('MALE', 'Господин.');
define('FEMALE', 'Дамы.');
define('TEXT_MALE','Мужчина');
define('TEXT_FEMALE','Женщина');
define('MALE_ADDRESS', 'Господин.');
define('FEMALE_ADDRESS', 'Дамы.');

// text for date of birth example
define('DOB_FORMAT_STRING', 'мм/дд/гггг');

// text for sidebox heading links
define('BOX_HEADING_LINKS', '');

// categories box text in sideboxes/categories.php
define('BOX_HEADING_CATEGORIES', 'Категории');

// manufacturers box text in sideboxes/manufacturers.php
define('BOX_HEADING_MANUFACTURERS', 'Производители');

define('HEADER_TITLE_PACKING_SLIP', 'Пошлина За Обработку');

// whats_new box text in sideboxes/whats_new.php
define('BOX_HEADING_WHATS_NEW', 'Новинки');
define('CATEGORIES_BOX_HEADING_WHATS_NEW', 'Новинки ...');

define('BOX_HEADING_FEATURED_PRODUCTS', 'Рекомендуемый');
define('CATEGORIES_BOX_HEADING_FEATURED_PRODUCTS', 'Рекомендуемые товары ...');
define('TEXT_NO_FEATURED_PRODUCTS', 'Больше рекомендуемые товары добавлены в ближайшее время, заходите позже, пожалуйста.');

define('TEXT_NO_ALL_PRODUCTS', 'Больше товары добавлены в ближайшее время, заходите позже, пожалуйста.');
define('CATEGORIES_BOX_HEADING_PRODUCTS_ALL', 'Все товары ...');

// quick_find box text in sideboxes/quick_find.php
define('BOX_HEADING_SEARCH', 'Поиск');
define('BOX_SEARCH_ADVANCED_SEARCH', 'Расширенный поиск');

// specials box text in sideboxes/specials.php
define('BOX_HEADING_SPECIALS', 'Специальные');
define('CATEGORIES_BOX_HEADING_SPECIALS', 'Специальные ...');

// reviews box text in sideboxes/reviews.php
define('BOX_HEADING_REVIEWS', 'Отзывы');
define('BOX_REVIEWS_WRITE_REVIEW', 'Пишите отзыв для этого товара, пожалуйста.');
define('BOX_REVIEWS_NO_REVIEWS', 'В настоящее время нет отзыва для товара.');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s самая высокая оценка: 5 звёзд, вы можете дать нам оценку в соответствии с реальной ситуацией!');

// shopping_cart box text in sideboxes/shopping_cart.php
define('BOX_HEADING_SHOPPING_CART', 'Корзина');
define('BOX_SHOPPING_CART_EMPTY', 'Ваша корзина пустая.');
define('BOX_SHOPPING_CART_DIVIDER', 'ea.-&nbsp;');

// order_history box text in sideboxes/order_history.php
define('BOX_HEADING_CUSTOMER_ORDERS', 'Быстро заказать снова');

// best_sellers box text in sideboxes/best_sellers.php
define('BOX_HEADING_BESTSELLERS', 'Литер продажи');
define('BOX_HEADING_BESTSELLERS_IN', 'Литер продажи в <br />&nbsp;&nbsp;');

// notifications box text in sideboxes/products_notifications.php
define('BOX_HEADING_NOTIFICATIONS', 'Внимание');
define('BOX_NOTIFICATIONS_NOTIFY', 'Сообщите мне о новинках, пожалуйста <strong>%s</strong>');
define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', 'Не сообщите мне о новинках, пожалуйста <strong>%s</strong>');

// manufacturer box text
define('BOX_HEADING_MANUFACTURER_INFO', 'Информамия производителя');
define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s Главная');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'Другие товары');

// languages box text in sideboxes/languages.php
define('BOX_HEADING_LANGUAGES', 'Языки');

// currencies box text in sideboxes/currencies.php
define('BOX_HEADING_CURRENCIES', 'Курсы');

// information box text in sideboxes/information.php
define('BOX_HEADING_INFORMATION', 'Информация');
define('BOX_INFORMATION_PRIVACY', 'Заявление о конфиденциальности');
define('BOX_INFORMATION_CONDITIONS', 'Условия для исполюзования');
define('BOX_INFORMATION_SHIPPING', 'Доставка &amp; Возврат');
define('BOX_INFORMATION_CONTACT', 'Свяжитесь с нами');
define('BOX_BBINDEX', 'Форум');
define('BOX_INFORMATION_UNSUBSCRIBE', 'Отписаться от новостей');

define('BOX_INFORMATION_SITE_MAP', 'Карта сайта');

// information box text in sideboxes/more_information.php - were TUTORIAL_
define('BOX_HEADING_MORE_INFORMATION', 'больше информации');
define('BOX_INFORMATION_PAGE_2', 'Страница 2');
define('BOX_INFORMATION_PAGE_3', 'Страница 3');
define('BOX_INFORMATION_PAGE_4', 'Страница 4');

// tell a friend box text in sideboxes/tell_a_friend.php
define('BOX_HEADING_TELL_A_FRIEND', 'Расскажите другу');
define('BOX_TELL_A_FRIEND_TEXT', 'Расскажите кому-нибудь, которого вы знаете, об этом товаре.');

// wishlist box text in includes/boxes/wishlist.php
define('BOX_HEADING_CUSTOMER_WISHLIST', 'Мой список пожеланий');
define('BOX_WISHLIST_EMPTY', 'У вас нет товара в вашем списке пожеланий');
define('IMAGE_BUTTON_ADD_WISHLIST', 'В список пожеланий');
define('TEXT_MOVE_TO_WISHLIST', ' Добавить в пожелания');
define('TEXT_WISHLIST_COUNT', 'Тепербь %s товары в вашем список пожеланий.');
define('TEXT_DISPLAY_NUMBER_OF_WISHLIST', 'Показать <strong>%d</strong> до <strong>%d</strong> (из <strong>%d</strong> товаров в вашем списке пожеланий)');

// New billing address text
define('SET_AS_PRIMARY', 'Оставляйте личный адрес');
define('NEW_ADDRESS_TITLE', 'Адрес для выставления счета');

// javascript messages
define('JS_ERROR', 'Ошибки произошли во время обработки вашей формы.\n\n Пожалуйста, делайте следующие исправления:\n\n');

define('JS_REVIEW_TEXT', '* Пожалуйста, добавдяйте еще ​​несколько слов в вашую комментарию, пожалуйста. Отзыв должен иметь по крайней мере ' . REVIEW_TEXT_MIN_LENGTH . ' знаков.');
define('JS_REVIEW_RATING', '*Пожалуйста, выберите рейтинг для этого товара.');

define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Пожалуйста, выберите способ оплаты для вашего заказа.');

define('JS_ERROR_SUBMITTED', 'Эта форма уже была представлена. Нажмите ОК и ждать этого процесса для завершения, пожалуйста.');

define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Выберите способ оплаты для вашего заказа, пожалуйста.');
define('ERROR_CONDITIONS_NOT_ACCEPTED', 'Пожалуйста, подтверждите условия, которые связанны с этом заказом, установив флажок ниже.');
define('ERROR_PRIVACY_STATEMENT_NOT_ACCEPTED', 'Пожалуйста, подтверждите личное заявление, установив флажок ниже.');

define('CATEGORY_COMPANY', 'Информация о компании');
define('CATEGORY_PERSONAL', 'Ваша дичная информация');
define('CATEGORY_ADDRESS', 'Ваш адрес');
define('CATEGORY_CONTACT', 'Ваша контактная информация');
define('CATEGORY_OPTIONS', 'Выборы');
define('CATEGORY_PASSWORD', 'Ваш пароль');
define('CATEGORY_LOGIN', 'Войти');
define ( 'CREATE_NEW_ACCOUNT', 'Создать Новый Счет' );
define('TEXT_NEW_CUSTOMER','Новый Клиент');
define('TEXT_RETURN_CUSTOMER','Возвращаемый Клиент');
define('TEXT_PLACEHOLDER1','Enter your email or telephone number');
define('TEXT_PLACEHOLDER2','Enter your paypal account');
define('PULL_DOWN_DEFAULT', 'Выберите вашу страну, пожалуйста');
define('PLEASE_SELECT', 'Выберите, пожалуйста...');
define('TYPE_BELOW', 'Укажите выбор ниже, пожалуйста ...');

define('ENTRY_COMPANY', 'Название компании:');
define('ENTRY_COMPANY_ERROR', 'Пожалуйста, введите название компании.');
define('ENTRY_COMPANY_TEXT', '');
define('ENTRY_GENDER', 'Пол:');
define('ENTRY_GENDER_ERROR', 'Укажите пол, пожалуйста.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME', 'Имя:');
define('ENTRY_FIRST_NAME_ERROR', 'Пожалуйста, введите ваше имя (не менее 1 символа).');
define('ENTRY_FIRST_NAME_TEXT', '*'); 
define('ENTRY_LAST_NAME', 'Фамилия:');
define('ENTRY_LAST_NAME_ERROR', 'Пожалуйста, введите вашу фамилию (не менее 1 символа).');
define('ENTRY_FL_NAME_SAME_ERROR', 'Фамилия совпадает с именем. Пожалуйста, измените его.');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH', 'Дата рождения:');

define('ENTRY_DATE_OF_BIRTH_ERROR', 'Для регистрации требует вся дата рождения (год-месяц-день) ');
define('ENTRY_DATE_OF_BIRTH_TEXT', '*');
define('ENTRY_EMAIL_ADDRESS', 'Адрес электронной почты');
define('ENTRY_EMAIL_ADDRESS_ERROR', "Правилен ли ваш адрес электронной почты ?Он должен как минимум содержать6 символов.Пожалуйста, попробуйте еще раз.");
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Извините, наша система не понимает твой ​​адрес электронной почты. Пожалуйста, попробуйте еще раз.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'У нашей системы уже есть запись об этом адресе электронной почты - попробуйте войти с этим адресом электронной почты. Если вы не используетесь этом адресом больше, вы можете исправить его в странице Мой Счёт.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS_MOBILE', 'Адрес электронной почты в нашей записи - пожалуйста, <a href="'.zen_href_link(FILENAME_LOGIN).'">войдите</a> прямо.');
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_NICK', 'Ласкательное имя для форума:');
define('ENTRY_NICK_TEXT', '*'); // note to display beside nickname input
                                   // field
define('ENTRY_NICK_DUPLICATE_ERROR', 'Это даскательное имя уже используется. Пожалуйста, попробуйте другое.');
define('ENTRY_NICK_LENGTH_ERROR', 'Пожалуйста, попробуйте еще раз. Ваше ласкательное имя должно содержать не менее ' . ENTRY_NICK_MIN_LENGTH . ' знака.');
define('ENTRY_STREET_ADDRESS', 'Адрес Улицы:');
define('ENTRY_STREET_ADDRESS_ERROR', 'Ваш Адрес Улицы должен содержать минимум ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' знаков.');
define('ENTRY_STREET_ADDRESS_TEXT', '*');
define('ENTRY_SUBURB', 'Адресная строка 2:');
define('ENTRY_SUBURB_ERROR', '');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE', 'почтовый индекс:');
define('ENTRY_POST_CODE_ERROR', 'Ваш почтовый индекс должен содержать минимум' . ENTRY_POSTCODE_MIN_LENGTH . ' знака.');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY', 'Город:');
define('ENTRY_CUSTOMERS_REFERRAL', 'Реферальный код:');

define('ENTRY_CITY_ERROR', 'Ваш Город должен содержать минимум ' . ENTRY_CITY_MIN_LENGTH . ' знака.');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE', 'Область:');
define('ENTRY_EXISTS_ERROR', 'Этот адрес уже существует.');
define('ENTRY_STATE_ERROR', 'Ваша область должна содержать минимум ' . ENTRY_STATE_MIN_LENGTH . ' знака.');
define('ENTRY_STATE_ERROR_SELECT', 'Пожалуйста, выберите область из областей выпадающего меню.');
define('ENTRY_STATE_TEXT', '*');
define('JS_STATE_SELECT', '-- Выбирайте, пожалуйста --');
define('ENTRY_COUNTRY', 'Страна:');
define('ENTRY_COUNTRY_ERROR', 'Вы должны выбрать страну от стран выпадающего меню.');
define('ENTRY_AGREEN_ERROR_SELECT', 'Вы не согласны с Doreenbeads.com <a href="page.html?id=137" target="_blank" style="color:#900;text-decoration:underline">Правила и Условия</a>');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_PUERTORICO_ERROR', 'Вы должны выбрать "Пуэрто-Рико" из стран выпадающего меню, когда ваша страна является "Пуэрто-Рико.');
define('ENTRY_TELEPHONE_NUMBER', 'Телефон:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Ваш номер телефона должен содержать минимум ' . ENTRY_TELEPHONE_MIN_LENGTH . ' знака.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER', 'Номер факса:');
define('ENTRY_FAX_NUMBER_ERROR', '');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER', 'Подписать на Новостную рассылку.');
define('ENTRY_NEWSLETTER_TEXT', 'Подписка');
define('ENTRY_NEWSLETTER_YES', 'Подписаться');
define('ENTRY_NEWSLETTER_NO', 'Отписаться');
define('ENTRY_NEWSLETTER_ERROR', '');
define('ENTRY_PASSWORD', 'Пароль:');
define('ENTRY_PASSWORD_ERROR', 'Это должно быть не менее 5 символов (должны содержать буквы и цифры).');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', ' Пароль Подтверждения должен совпадать с паролем.');
define('ENTRY_PASSWORD_TEXT', '* (по крайней мере ' . ENTRY_PASSWORD_MIN_LENGTH . ' знаков)');
define('ENTRY_PASSWORD_CONFIRMATION', 'Пароль Подтверждения:');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT', 'Текущий пароль:');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'Ваш пароль должен содержать минимум ' . ENTRY_PASSWORD_MIN_LENGTH . ' знаков.');
define('ENTRY_PASSWORD_NEW', 'Новый пароль:');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'Ваш новый пароль должен содержать минимум ' . ENTRY_PASSWORD_MIN_LENGTH . ' знаков.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', ' Пароль подтверждения должен совподать с новым паролем.');
define('PASSWORD_HIDDEN', '--HIDDEN--');

define('FORM_REQUIRED_INFORMATION', '* Необходимая информация');
define('ENTRY_REQUIRED_SYMBOL', '*');

// constants for use in zen_prev_next_display function
define('TEXT_RESULT_PAGE', '');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Показать <strong>%d</strong> до <strong>%d</strong> (из <strong>%d</strong> товааров)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Показать <strong>%d</strong> до <strong>%d</strong> (из <strong>%d</strong> заказов)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Показать <strong>%d</strong> до <strong>%d</strong> (из <strong>%d</strong> отзывов)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Показать <strong>%d</strong> до <strong>%d</strong> (из <strong>%d</strong> новые товаров)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Показать <strong>%d</strong> до <strong>%d</strong> (из <strong>%d</strong> специальных)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_FEATURED_PRODUCTS', 'Показать <strong>%d</strong> до <strong>%d</strong> (из <strong>%d</strong> Рекомендуемых товаров)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_ALL', 'Показать <strong>%d</strong> до <strong>%d</strong> (из <strong>%d</strong> товаров)');

define('PREVNEXT_TITLE_FIRST_PAGE', 'Первая Страница');
define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'Предыдущая Страница');
define('PREVNEXT_TITLE_NEXT_PAGE', 'Следующая Страница');
define('PREVNEXT_TITLE_LAST_PAGE', 'Последняя Страница');
define('PREVNEXT_TITLE_PAGE_NO', 'Страница %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Предыдущий набор  %d Страницы');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Следующий набор  %d Страницы');
define('PREVNEXT_BUTTON_FIRST', '&lt;&lt;ПЕРВЫЙ');
define('PREVNEXT_BUTTON_PREV', '[<< Предыдущий]');
define('PREVNEXT_BUTTON_NEXT', '[Следующий >>]');
define('PREVNEXT_BUTTON_LAST', 'ПОСЛЕДНИЙ>>');
define('PREVNEXT_BUTTON_NEXT_NEW', 'Следующий');

define('TEXT_BASE_PRICE', 'Начиная с: ');

define('TEXT_CLICK_TO_ENLARGE', 'Большое фото');

define('TEXT_SORT_PRODUCTS', 'Сортировка товаров ');
define('TEXT_DESCENDINGLY', 'по убыванию');
define('TEXT_ASCENDINGLY', 'по возрастанию');
define('TEXT_BY', ' по ');

define('TEXT_REVIEW_BY', ' %s');
define('TEXT_REVIEW_WORD_COUNT', '%s слова');
define('TEXT_REVIEW_RATING', 'Рейтинг: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Дата добавления: %s');
define('TEXT_NO_REVIEWS', 'Теперь нет отзывов для товара.');

define('TEXT_NO_NEW_PRODUCTS','К сожалению, не нашли. Вы могли бы попытаться отфильтровать другими условиями.');

define('TEXT_UNKNOWN_TAX_RATE', 'Налог на Продажу');

define('TEXT_REQUIRED', '<span class="errorText">Требуется</span>');

define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Warning: Installation directory exists at: %s. Please remove this directory for security reasons.');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Warning: I am able to write to the configuration file: %s. This is a potential security risk - please set the right user permissions on this file (read-only, CHMOD 644 or 444 are typical). You may need to use your webhost control panel/file-manager to change the permissions effectively. Contact your webhost for assistance. <a href="http://tutorials.zen-cart.com/index.php?article=90" target="_blank">See this FAQ</a>');
define('ERROR_FILE_NOT_REMOVEABLE', 'Error: Could not remove the file specified. You may have to use FTP to remove the file, due to a server-permissions configuration limitation.');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Warning: The sessions directory does not exist: ' . zen_session_save_path () . '. Sessions will not work until this directory is created.');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Warning: I am not able to write to the sessions directory: ' . zen_session_save_path () . '. Sessions will not work until the right user permissions are set.');
define('WARNING_SESSION_AUTO_START', 'Warning: session.auto_start is enabled - please disable this PHP feature in php.ini and restart the web server.');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Warning: The downloadable products directory does not exist: ' . DIR_FS_DOWNLOAD . '. Downloadable products will not work until this directory is valid.');
define('WARNING_SQL_CACHE_DIRECTORY_NON_EXISTENT', 'Warning: The SQL cache directory does not exist: ' . DIR_FS_SQL_CACHE . '. SQL caching will not work until this directory is created.');
define('WARNING_SQL_CACHE_DIRECTORY_NOT_WRITEABLE', 'Warning: I am not able to write to the SQL cache directory: ' . DIR_FS_SQL_CACHE . '. SQL caching will not work until the right user permissions are set.');
define('WARNING_DATABASE_VERSION_OUT_OF_DATE', 'Your database appears to need patching to a higher level. See Admin->Tools->Server Information to review patch levels.');
define('WARNING_COULD_NOT_LOCATE_LANG_FILE', 'WARNING: Could not locate language file: ');

define('TEXT_CCVAL_ERROR_INVALID_DATE', 'Введённый срок действия для кредитной карты является недействительным. Пожалуйста, проверьте дату и попробуйте еще раз.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'Введеный номер кредитной карты  недействительный. Пожалуйста, проверьте номер и попробуйте еще раз.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'Номер кредитной карты, начиная с %s не был введен правильно, или мы не принимаем такую ​​карту. Пожалуйста, попробуйте еще раз или используйтесь другой кредитной картой.');

define('BOX_INFORMATION_DISCOUNT_COUPONS', 'Купон на скидку');
define('BOX_INFORMATION_GV', TEXT_GV_NAME . ' Часто Задаваемые Вопросы');
define('VOUCHER_BALANCE', TEXT_GV_NAME . ' Баланс ');
define('BOX_HEADING_GIFT_VOUCHER', TEXT_GV_NAME . ' Счёт');
define('GV_FAQ', TEXT_GV_NAME . ' Часто Задаваемые Вопросы');
define('ERROR_REDEEMED_AMOUNT', 'Поздравляем, что вы искуплены ');
define('ERROR_NO_REDEEM_CODE', 'Вы не введили ' . TEXT_GV_REDEEM . '.');
define('ERROR_NO_INVALID_REDEEM_GV', 'недействительный ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM );
define('TABLE_HEADING_CREDIT', 'Кредиты Доступные');
define('GV_HAS_VOUCHERA', 'У вас есть средства в ваш ' . TEXT_GV_NAME . ' Счёт. Если вы хотите <br />Вы можете отправлять эти средства на <a class="pageResults" href="');

define('GV_HAS_VOUCHERB', '"><strong>пишите электронное письмо</strong></a> кому-то');
define('ENTRY_AMOUNT_CHECK_ERROR', 'Вы не имеют достаточно средств, чтобы отправить эту сумму.');
define('BOX_SEND_TO_FRIEND', 'Отправить ' . TEXT_GV_NAME . ' ');

define('VOUCHER_REDEEMED', TEXT_GV_NAME . ' Искуплены');
define('CART_COUPON', 'Купон :');
define('CART_COUPON_INFO', 'Больше информации');
define('TEXT_SEND_OR_SPEND', 'У вас есть баланс в вашем ' . TEXT_GV_NAME . ' счёте. Вы можете потратить баланс или отправить его кому-то еще. Для отправки, нажмите на кнопку ниже, пожалуйста.');
define('TEXT_BALANCE_IS', 'Ваш ' . TEXT_GV_NAME . ' Баланс: ');
define('TEXT_AVAILABLE_BALANCE', 'Ваш ' . TEXT_GV_NAME . ' Счёт');

define('TABLE_HEADING_PAYMENT_METHOD', 'Способ оплаты');
// payment method is GV/Discount
define('PAYMENT_METHOD_GV', 'Подарочный сертификат/Купон');
define('PAYMENT_MODULE_GV', 'GV/DC');

define('TABLE_HEADING_CREDIT_PAYMENT', 'Кредиты Доступные');

define('TEXT_INVALID_REDEEM_COUPON', 'Недействительный код купона');
define('TEXT_INVALID_REDEEM_COUPON_MINIMUM', 'Вы должны оплатить по крайней мере %s чтобы искупать этот купон');
define('TEXT_INVALID_REDEEM_COUPON_MINIMUM_1', '%s купон может быть использован, когда сумма вашего заказа достигает %s.');
define('TEXT_INVALID_STARTDATE_COUPON', 'Этот купон ещё не могут использован');
define('TEXT_INVALID_FINISHDATE_COUPON', 'Этот купон истек');
define('TEXT_INVALID_USES_COUPON', 'Этот купон может быть использован только ');
define('TIMES', ' разы.');
define('TIME', ' раз.');
define('TEXT_INVALID_USES_USER_COUPON', 'Вы использовались кодом купона: %s максимальное раз для каждого клиента. ');
define('REDEEMED_COUPON', 'купон стоит ');
define('REDEEMED_MIN_ORDER', 'для заказа выше ');
define('REDEEMED_RESTRICTIONS', ' [Product-Category restrictions apply]');
define('TEXT_ERROR', 'Произошла ошибка');
define('TEXT_INVALID_COUPON_PRODUCT', 'Это код купона недействителен на любой продукт в вашей корзине в настоящее время.');
define('TEXT_VALID_COUPON', 'Поздравляем, что вы искупили купон на скидку');
define('TEXT_REMOVE_REDEEM_COUPON_ZONE', 'Код купона, который вы ввели, недействителен для адреса, который вы выбрали.');

// more info in place of buy now
define('MORE_INFO_TEXT', '... больше информации');

// IP Address
define('TEXT_YOUR_IP_ADDRESS', 'Ваш IP адрес:');

// Generic Address Heading
define('HEADING_ADDRESS_INFORMATION', 'информация адреса');

// cart contents
define('PRODUCTS_ORDER_QTY_TEXT_IN_CART', 'Количество в корзине: ');
define('PRODUCTS_ORDER_QTY_TEXT', 'Добавлять в корзину: ');

define('TEXT_PRODUCT_WEIGHT_UNIT', 'граммы');

// Shipping
// jessa 2009-08-11
// update define('TEXT_SHIPPING_WEIGHT','lbs');
define('TEXT_SHIPPING_WEIGHT', 'граммы');
define('TEXT_SHIPPING_BOXES', 'Каробочки');
// eof jessa

// Discount Savings
define('PRODUCT_PRICE_DISCOUNT_PREFIX', 'Экономить: ');
define('PRODUCT_PRICE_DISCOUNT_PERCENTAGE', '% скидка');
define('PRODUCT_PRICE_DISCOUNT_AMOUNT', ' скидка');

// Sale Maker Sale Price
define('PRODUCT_PRICE_SALE', 'Скидка:&nbsp;');

// universal symbols
define('TEXT_NUMBER_SYMBOL', '# ');

// banner_box
define('BOX_HEADING_BANNER_BOX', 'Спонсоры');
define('TEXT_BANNER_BOX', 'Посетите наш Спонсоры, пожалуйста ...');

// banner box 2
define('BOX_HEADING_BANNER_BOX2', 'Вы видели ...');
define('TEXT_BANNER_BOX2', 'Оплатите за это сегодня, пожалуйста!');

// banner_box - all
define('BOX_HEADING_BANNER_BOX_ALL', 'Спонсоры');
define('TEXT_BANNER_BOX_ALL', 'Посетите наш Спонсоры, пожалуйста ...');

// boxes defines
define('PULL_DOWN_ALL', 'Выбирайте, пожалуйста');
define('PULL_DOWN_MANUFACTURERS', '- Сброс -');
// shipping estimator
define('PULL_DOWN_SHIPPING_ESTIMATOR_SELECT', 'Выбирайте, пожалуйста');

// general Sort By
define('TEXT_INFO_SORT_BY', 'Сортировать по: ');

// close window image popups
define('TEXT_CLOSE_WINDOW', ' - Нажмите на картинку, чтобы закрыть');
// close popups
define('TEXT_CURRENT_CLOSE_WINDOW', '[ Закрыть окно ]');

// iii 031104 added: File upload error strings
define('ERROR_FILETYPE_NOT_ALLOWED', 'Ошибка:  Тип файла не допускается.');
define('WARNING_NO_FILE_UPLOADED', 'Предупреждение:  Нет файла закачано.');
define('SUCCESS_FILE_SAVED_SUCCESSFULLY', 'Успех:  Файл успешно сохранен.');
define('ERROR_FILE_NOT_SAVED', 'Ошибка:  Файл не успешно сохранен.');
define('ERROR_DESTINATION_NOT_WRITEABLE', 'Ошибка:  назначение не могут быть записано.');
define('ERROR_DESTINATION_DOES_NOT_EXIST', 'Ошибка: назначение не существует.');
define('ERROR_FILE_TOO_BIG', 'Предупреждение: Файл был слишком велик для закачатки!<br />Заказать можно но, свяжитесь с сайта на помощи для закачатки, пожалуйста');
// End iii added

define('TEXT_BEFORE_DOWN_FOR_MAINTENANCE', 'ВНИМАНИЕ: Этот веб-сайт планируется ввести в закрытку на техническое обслуживание на: ');
define('TEXT_ADMIN_DOWN_FOR_MAINTENANCE', 'ВНИМАНИЕ: В настоящее время этот веб-сайт закрыт на техническое обслуживание для публики');

define('PRODUCTS_PRICE_IS_FREE_TEXT', 'Это бесплатный!');
define('PRODUCTS_PRICE_IS_CALL_FOR_PRICE_TEXT', 'Запрос цены');
define('TEXT_CALL_FOR_PRICE', 'Запрос цены');

define('TEXT_INVALID_SELECTION', ' Ваш выбор недействительный: ');
define('TEXT_ERROR_OPTION_FOR', ' На вариант для: ');
define('TEXT_INVALID_USER_INPUT', 'Использователю необходимо ввести<br />');

// product_listing
define('PRODUCTS_QUANTITY_MIN_TEXT_LISTING', 'Минимум: ');
define('PRODUCTS_QUANTITY_UNIT_TEXT_LISTING', 'Единицы: ');
define('PRODUCTS_QUANTITY_IN_CART_LISTING', 'в корзине:');
define('PRODUCTS_QUANTITY_ADD_ADDITIONAL_LISTING', 'Добавить Дополнительный:');

define('PRODUCTS_QUANTITY_MAX_TEXT_LISTING', 'Максимально:');

define('TEXT_PRODUCTS_MIX_OFF', '*Нельзя Смешать');
define('TEXT_PRODUCTS_MIX_ON', '*Можно Смешать');

define('TEXT_PRODUCTS_MIX_OFF_SHOPPING_CART', '<br />*Нельзя смешивать выборы по этому товару, чтобы соответствовать минимальным требованиям количества.*<br />');
define('TEXT_PRODUCTS_MIX_ON_SHOPPING_CART', '*Стоимость смешанного товара<br />');

define('ERROR_MAXIMUM_QTY', 'Количество товаров, которые добавлены в вашу корзину, было скорректирована из-за ограничения на максимальное количество, которое вам позволяют купить. Смотрите, этот товар, пожалуйста: ');
define('ERROR_CORRECTIONS_HEADING', 'Исправляйте следующие, пожалуйста: <br />');
define('ERROR_QUANTITY_ADJUSTED', 'Количество товаров, которые добавлены в вашу корзину, было скорректировано. Товар, который вы хотите, не доступен в дробном количестве. Количество товара: ');
define('ERROR_QUANTITY_CHANGED_FROM', ', был изменен с: ');
define('ERROR_QUANTITY_CHANGED_TO', ' до ');

// Downloads Controller
define('DOWNLOADS_CONTROLLER_ON_HOLD_MSG', 'ВНИМАНИЕ: Скачивания не доступны, пока оплата не была подтвержденна');
define('TEXT_FILESIZE_BYTES', ' байты');
define('TEXT_FILESIZE_MEGS', ' MB');

// shopping cart errors
define('ERROR_PRODUCT', 'Товар: ');
define('ERROR_PRODUCT_STATUS_SHOPPING_CART', '<br />Извините, что этот продукт был удален из нашего инвентаря в это время.<br /Этот продукт был удален из вашей корзины.');
define('ERROR_PRODUCT_QUANTITY_MIN', ' ... Ошибки минимального количества - ');
define('ERROR_PRODUCT_QUANTITY_UNITS', ' ... Ошибки Единицы Количество - ');
define('ERROR_PRODUCT_OPTION_SELECTION', '<br /> ... Недопустимые значения выбра ');
define('ERROR_PRODUCT_QUANTITY_ORDERED', '<br /> Вы заказали в целом: ');
define('ERROR_PRODUCT_QUANTITY_MAX', ' ... Ошибки минимального количества- ');
define('ERROR_PRODUCT_QUANTITY_MIN_SHOPPING_CART', ', существует ограничение минимального количества. ');
define('ERROR_PRODUCT_QUANTITY_UNITS_SHOPPING_CART', ' ... Ошибки единицы количество   - ');
define('ERROR_PRODUCT_QUANTITY_MAX_SHOPPING_CART', ' ... Ошибки минимального количества- ');

define('WARNING_SHOPPING_CART_COMBINED', 'NOTICE: Вы будете оплатить за все товары в этой корзине, которая была смешанна с товарами, которые вы добавили раньше. Поэтому, пожалуйста, рассмотрите корзину перед оплатой.');

// error on checkout when $_SESSION['customers_id' does not exist in customers
// table
define('ERROR_CUSTOMERS_ID_INVALID', 'Информация клиента не может быть подтвержденна!<br />Войдите, пожалуйста, или воссоздайте ваш счёт...');

define('TABLE_HEADING_FEATURED_PRODUCTS', '<a href="featured_products.html" id="featured_products">Рекомендуемые товары</a>');

define('TABLE_HEADING_NEW_PRODUCTS', '<a href="products_new.html" id="products_new">Новые товары для %s</a>');
define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Ожидаемые товары');
define('TABLE_HEADING_DATE_EXPECTED', 'Дата поступления');
// define('TABLE_HEADING_SPECIALS_INDEX', '<a href="specials.html"
// id="specials">Monthly Specials For %s</a>');
define('TABLE_HEADING_SPECIALS_INDEX', '<a href="https://www.doreenbeads.com/40-off-huge-discounts-c-1375.html" id="specials">Эксклюзивные огромные скидки</a>');
define('CAPTION_UPCOMING_PRODUCTS', 'Эти товары скоро будут в наличии');
define('SUMMARY_TABLE_UPCOMING_PRODUCTS', 'Таблица содержит список товаров, которые должны быть в наличии на складе в ближайшее время, а также даты товаров ожидаемого');

// meta tags special defines
define('META_TAG_PRODUCTS_PRICE_IS_FREE_TEXT', 'Это Бесплатный!');

// customer login
define('TEXT_SHOWCASE_ONLY', 'Свяжитесь с нами');
// set for login for prices
define('TEXT_LOGIN_FOR_PRICE_PRICE', 'Цена недоступна');
define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE', 'Вход для цены');
// set for show room only
define('TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM', ''); // blank for prices or
                                                      // enter
                                                      // your own text
define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM', 'только выставочный зал только');

// authorization pending
define('TEXT_AUTHORIZATION_PENDING_PRICE', 'Цена недоступна');
define('TEXT_AUTHORIZATION_PENDING_BUTTON_REPLACE', 'ОЖИДАНИЕ АКТИВАЦИИ');
define('TEXT_LOGIN_TO_SHOP_BUTTON_REPLACE', 'Вход в магазин');

// text pricing
define('TEXT_CHARGES_WORD', 'Расчетная стоимость:');
define('TEXT_PER_WORD', '<br />Цена за каждое слово: ');
define('TEXT_WORDS_FREE', ' Слово(а) бесплатное ');
define('TEXT_CHARGES_LETTERS', 'Расчетная стоимость:');
define('TEXT_PER_LETTER', '<br />Цена за каждую букву: ');
define('TEXT_LETTERS_FREE', ' Буква(ы) бесплатная ');
define('TEXT_ONETIME_CHARGES', '*одноразовые платежи = ');
define('TEXT_ONETIME_CHARGES_EMAIL', "\t" . '*одноразовые платежи = ');
define('TEXT_ATTRIBUTES_QTY_PRICES_HELP', 'Частные скидки');
define('TABLE_ATTRIBUTES_QTY_PRICE_QTY', 'КОЛИЧЕСТВО');
define('TABLE_ATTRIBUTES_QTY_PRICE_PRICE', 'ЦЕНА');
define('TEXT_ATTRIBUTES_QTY_PRICES_ONETIME_HELP', 'Частные скидки');

// textarea attribute input fields
define('TEXT_MAXIMUM_CHARACTERS_ALLOWED', ' максимальные допустимые знаки');
define('TEXT_REMAINING', 'остальный');

// Shipping Estimator
define('CART_SHIPPING_OPTIONS', 'Примерная стоимость доставки');
define('CART_SHIPPING_OPTIONS_LOGIN', 'Пожалуйста <a href="' . zen_href_link ( FILENAME_LOGIN, '', 'SSL') . '"><span class="pseudolink">Вход</span></a>, чтобы показать ваш личные стоимтоси доставки.');
define('CART_SHIPPING_METHOD_TEXT', 'Доступные способы доставки');
define('CART_SHIPPING_METHOD_RATES', 'Курс');
define('CART_SHIPPING_METHOD_TO', 'Доставить в: ');
define('CART_SHIPPING_METHOD_TO_NOLOGIN', 'Доставлять в: <a href="' . zen_href_link ( FILENAME_LOGIN, '', 'SSL') . '"><span class="pseudolink">Вход</span></a>');
define('CART_SHIPPING_METHOD_FREE_TEXT', 'Бесплатная Доставка');
define('CART_SHIPPING_METHOD_ALL_DOWNLOADS', '- Закачивания');
define('CART_SHIPPING_METHOD_RECALCULATE', 'Пересчитать');
define('CART_SHIPPING_METHOD_ZIP_REQUIRED', 'истинный');
define('CART_SHIPPING_METHOD_ADDRESS', 'Адрес:');
define('CART_OT', 'Примерная общая стоимость:');
define('CART_OT_SHOW', 'истинный'); // set to false if you don't want order
                                       // totals
define('CART_ITEMS', 'Товары в корзине: ');
define('CART_SELECT', 'Выбирайите');
define('ERROR_CART_UPDATE', '<strong>Пожалуйста, продолжите купить...</strong><br/>');
define('IMAGE_BUTTON_UPDATE_CART', 'Обновить');
define('EMPTY_CART_TEXT_NO_QUOTE', 'Ой! Ваша сессия истекла ... Обновляйте ваш корзину для расчёта доставки,пожалуйста...');
define('CART_SHIPPING_QUOTE_CRITERIA', 'Расчёт доставки зависит от вам выбранного адресной информации:');

// multiple product add to cart
define('TEXT_PRODUCT_LISTING_MULTIPLE_ADD_TO_CART', 'Добавлять: ');
define('TEXT_PRODUCT_ALL_LISTING_MULTIPLE_ADD_TO_CART', 'Добавлять: ');
define('TEXT_PRODUCT_FEATURED_LISTING_MULTIPLE_ADD_TO_CART', 'Добавлять: ');
define('TEXT_PRODUCT_NEW_LISTING_MULTIPLE_ADD_TO_CART', 'Добавлять: ');
// moved SUBMIT_BUTTON_ADD_PRODUCTS_TO_CART to button_names.php as
// BUTTON_ADD_PRODUCTS_TO_CART_ALT

// discount qty table
define('TEXT_HEADER_DISCOUNT_PRICES_PERCENTAGE', 'Qty Discounts Off Price(Единица: Пакет)');
define('TEXT_HEADER_DISCOUNT_PRICES_ACTUAL_PRICE', 'Цена в зависимости от количества упаковок');
define('TEXT_HEADER_DISCOUNT_PRICES_AMOUNT_OFF', 'Qty Discounts Off Price(Единица: Пакет)');
define('TEXT_FOOTER_DISCOUNT_QUANTITIES', '* Наверное, купоны изменяется в зависимости от вариантов выше');
define('TEXT_HEADER_DISCOUNTS_OFF', 'Qty Discounts Unavailable ...');

// sort order titles for dropdowns
define('PULL_DOWN_ALL_RESET', '- СБРОС - ');
define('TEXT_INFO_SORT_BY_PRODUCTS_NAME', 'Название Товара');
define('TEXT_INFO_SORT_BY_PRODUCTS_NAME_DESC', 'Название Товара - по убыванию');
define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE', 'Цена - возрастания цена');
define('TEXT_INFO_SORT_BY_QTY_DATE', 'Количество на складе - с более до менее');
define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE_DESC', 'Цена - убывания цена');
define('TEXT_INFO_SORT_BY_PRODUCTS_MODEL', 'Артикул');
define('TEXT_INFO_SORT_BY_PRODUCTS_DATE_DESC', 'Дата добавлена - Сначала новые');
define('TEXT_INFO_SORT_BY_PRODUCTS_DATE', 'Дата добавлена - Сначала старые');
// jessa 2009-12-16
define('TEXT_INFO_SORT_BY_PRODUCTS_ORDER', 'Проданный - с высокой до низкой');
// eof jessa 2009-12-16
define('TEXT_INFO_SORT_BY_PRODUCTS_SORT_ORDER', 'Демонстрации по умолчанию');
define('TEXT_INFO_SORT_BY_BEST_MATCH','Максимальному совпадению');
define('TEXT_INFO_SORT_BY_BEST_SELLERS','Лидеры продаж');

// downloads module defines
define('TABLE_HEADING_DOWNLOAD_DATE', 'Ссылка Истекает');
define('TABLE_HEADING_DOWNLOAD_COUNT', 'Остальной');
define('HEADING_DOWNLOAD', 'Чтобы скачать ваши файлы, нажмите кнопку "Скачать" и выберите "Сохранить на диск" из всплывающего меню, пожалуйста.');
define('TABLE_HEADING_DOWNLOAD_FILENAME', 'Название файла');
define('TABLE_HEADING_PRODUCT_NAME', 'Название товара');
define('TABLE_HEADING_PRODECT_PRICE', 'Цена');
define('TABLE_HEADING_PRODUCT_IMAGE', 'Картина Товара');
define('TABLE_HEADING_PRODUCT_MODEL', 'Артикул.');
define('TABLE_HEADING_BYTE_SIZE', 'Размер Файла');
define('TEXT_DOWNLOADS_UNLIMITED', 'Неограниченный');
define('TEXT_DOWNLOADS_UNLIMITED_COUNT', '--- *** ---');

// misc
define('COLON_SPACER', ':&nbsp;&nbsp;');

// table headings for cart display and upcoming products
define('TABLE_HEADING_QUANTITY', 'Количество.');
define('TABLE_HEADING_PRODUCTS', 'Название Товара');
define('TABLE_HEADING_PRICE', 'Цена');
define('TABLE_HEADING_IMAGE', 'Картина Товара');
define('TABLE_HEADING_MODEL', 'Артикул');
define('TABLE_HEADING_TOTAL', 'Всего');

// create account - login shared
define('TABLE_HEADING_PRIVACY_CONDITIONS', 'Заявление о конфиденциальности');
define('TEXT_PRIVACY_CONDITIONS_DESCRIPTION', 'Подтверждите, что вы соглашаетесь с заявлением о конфиденциальности, пожалуймта, тикав следующее окно. Заявление о конфиденциальности, может быть прочитанно <a href="' . zen_href_link ( FILENAME_PRIVACY, '', 'SSL') . '"><span class="pseudolink">здесь</span></a>.');
define('TEXT_PRIVACY_CONDITIONS_CONFIRM', 'Я прочитал и согласился с вашим заявлением о конфиденциальности.');
define('TABLE_HEADING_ADDRESS_DETAILS', 'Подробность Адреса');
define('TABLE_HEADING_PHONE_FAX_DETAILS', 'Дополнительная Контактная Подробность');
define('TABLE_HEADING_DATE_OF_BIRTH', 'Подтверждите ваш возраст, пожалуйста');
define('TABLE_HEADING_LOGIN_DETAILS', 'Подробность для Входа');
define('TABLE_HEADING_REFERRAL_DETAILS', 'Вы упомянули о нас?');

define('ENTRY_EMAIL_PREFERENCE', 'Подробности информационного бюллетеня и электронной почты');
define('ENTRY_EMAIL_HTML_DISPLAY', 'HTML');
define('ENTRY_EMAIL_TEXT_DISPLAY', 'TEXT-только');
define('EMAIL_SEND_FAILED', 'ОШИБКА: Не удалось отправить письмо на: "%s" <%s> с темой: "%s"');

define('DB_ERROR_NOT_CONNECTED', 'Ошибка - Не удалось подключиться к базе данных');

// account
define('TEXT_TRANSACTIONS', 'Сделки');
define('TEXT_ORDER_STATUS_PENDING', 'В ожидании');
define('TEXT_ALL_ORDERS', 'Все заказы');
define('TEXT_MY_ORDERS', 'Мои заказы');
define('TEXT_ORDER_STATUS_PROCESSING', 'Обработанный');
define('TEXT_ORDER_STATUS_SHIPPED', 'Высыланный');
define('TEXT_UPDATE', 'Обновлять');
define('TEXT_ORDER_CANCELED', 'Отмененный');
define('TEXT_ORDER_STATUS_UPDATE', 'Обновлять');
define('TEXT_DELIVERED', 'доставлять');
define('TEXT_ORDER_STATUS_CANCELLED', 'Отмененный');
define('TEXT_ORDER_HISTORY', 'История');
define('TEXT_LATESTS', 'Последние Новости');
define('TEXT_PACKAGE_NUMBER', 'Номер пакета');
define('TEXT_RESULT_COST', 'Result cost');
define('TEXT_ACCOUNT_SERVICE', 'Сервис для счёта');
define('TEXT_MY_TICKETS', 'Системные Сообщения');
define('TEXT_DOWNLOAD_PRICTURES', 'Скачать Картины');
define('TEXT_ADDRESS_BOOK', 'Адресная Книга');
define('TEXT_ACCOUNT_SETTING', 'Установить счёт');
define('TEXT_ACCOUNT_INFORMATION', 'Установить счёт');
define('TEXT_ACCOUNT_PASSWORD', 'Пароль счёта');
define('TEXT_CASH_ACOUNT', ' Кредитный счет');
define('TEXT_BLANCE', 'Баланс');
define('TEXT_EMAIL_NOTIFICATIONS', 'Уведомления по электронной почте');
define('TEXT_MODIFY_SUBSCRITION', 'Изменить подписку');
define('TEXT_AFFILIATE_PROGRAM', 'Affiliate Program');
define('TEXT_MY_COMMISSION', 'My Commission');
define('TEXT_SETTINGS', 'Setting');
define('TEXT_REQUIRED_FIELDS', 'Обязательно заполненное поле');
define('TEXT_PRODUCTS_NOTIFICATION', 'уведомление о товарах');
define('ENTRY_SUBURB1', 'Адресная строка 1:');
define('TEXT_MAKE_PAYMENT', 'Оплатить');
define('TEXT_CART_MOVE_WISHLIST', 'Переместить в Список Пожеланий');
define('TEXT_PAYMENT_QUICK_PEORDER', 'Быстро заказать снова ');
define('TEXT_PAYMENT_ORDER_INQUIRY', '<a href="mailto:sale_ru@doreenbeads.com">Запрос Заказа</a>');
define('TEXT_PAYMENT_TRACK_INFO', 'Инфо Отслеживания');
define('TEXT_ACTION', 'Действия');
define('PRODUCTS_QUICK_ORDER_BY_NO', 'Быстро добавлять товары');

// EZ-PAGES Alerts
define('TEXT_EZPAGES_STATUS_HEADER_ADMIN', 'WARNING: EZ-PAGES HEADER - On for Admin IP Only');
define('TEXT_EZPAGES_STATUS_FOOTER_ADMIN', 'WARNING: EZ-PAGES FOOTER - On for Admin IP Only');
define('TEXT_EZPAGES_STATUS_SIDEBOX_ADMIN', 'WARNING: EZ-PAGES SIDEBOX - On for Admin IP Only');

// extra product listing sorter
define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER', '');
define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES', 'Товары, начинающиеся с ...');
define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES_RESET', '-- Сброс --');

define('TEXT_INPUT_RIGHT_CODE', 'Введите правый действительный код, пожалуйста !');
define('AIRMAIL_NOTE_DESCRIPTION', 'Извините, что сообщить вам, что стоимость доставки авиапочты (10-19 дней) к некоторым странам была увеличенна. Цена установленна почтой. Таким образом, в некоторых случаях, стоимость доставки авиапочты может выше, чем EMS, если так, то мы сильно рекомендуем вам использоваться EMS. Мы будем продолжать, чтобы найти лучшую цену для доставки. Извинения еще раз за вызванные неудобства. Ваше доброе понимание и поддержка является самой высокой оценкой.');
define('BOX_HEADING_PACKING_SERVICE', 'Сервис для Упаковки');
define('TEXT_PACKING_SERVICE_CONTENT', 'Мы предлагаем вам упаковки и обслуживание обработки для удовлетворения ваших потребностей для каких-нибудь специальных пакетов или товаров, которые мы производили по вашему требованию.');
define('TEXT_PRODUCT_DETAILS', 'Смотреть подробности');
define('TEXT_HEADER_MORE', 'Больше');
define('TEXT_HEADER_CLEARANCE', 'Распродажа');
define('TEXT_CLEARANCE', 'Распродажа');
define('TEXT_NO_PRODUCTS_IN_CLEARANCE', 'Здесь нет товаров на Распродаже');
define('TEXT_CLEARANCE_CATE_HREF', 'Смотреть все %s ');
define('TEXT_HEADER_TOP_SELLER', 'Лидеры продаж');

define('TEXT_PRODUCT_IMAGE', 'Картины товара');
define('TEXT_ITEM_NAMES', 'Название товара');
define('TEXT_PRICE_WORDS', 'Цена');
define('TEXT_WEIGHT_WORDS', 'Вес:');
define('TEXT_ADD_WORDS', 'Добавлять:');
define('TEXT_NO_PRODUCTS_IN_CLEARANCE', 'Здесь нет товаров на Распродаже');

define('TEXT_DHL_REMOTE_FEE', '%s Дистанционный гонорар через DHL Express необходим, EMS не доступен вашему адресу!');
define('TEXT_WIN_POP_TITLE', '');
define('TEXT_WIN_POP_NOTICE', '');

define('NOTE_CHECKOUT_SHIPPING_AIRMAIL', 'Прочитайте это важное примечание, пожалуйста >>');
define('NOTE_CHECKOUT_SHIPPING_AIRMAIL_CONTENT', 'A. Due to The eighteenth National Congress of the Communist Party of China, parcels via air mail may be delayed for certain days. We are very sorry about this. If items are need urgently, please kindly choose another shipping methods. <br>B. If your order contains watches, please kindly choose other kind of shipping method since custom do very strict check on all airmail parcel, it is not permitted to ship watches.<br><br>For more information, contact us at<a href=mailto:service_ru@doreenbeads.com> service_ru@doreenbeads.com</a>.');

// account add items 2013-4-12
define('TEXT_ACCOUNT_SET', 'Установка счёта');
define('TEXT_PROFILE_SET', 'Собственная Установка');
define('TEXT_CHANGE_PASSWORD', 'Изменить пароль');
define('TEXT_CHANGE_EMAIL', 'Изменить адрес электронной почты');
define('TEXT_AVARTAR', 'Аватар:');
define('TEXT_UPLOAD_FOR_CHECKING', 'Закачать успешно, подождите для рассмотрения, пожалуйста.');
define('ENTRY_YOUR_BUSINESS_WEB', 'Ваш бизнес-веб:');
define('ENTRY_CELL_PHONE', 'Мобильный телефон:');
define('TEXT_SUBMIT', 'представлять');
define('TEXT_UPLOAD', 'Закачать');
define('TEXT_CHOOSE_SYSTEM_AVARTAR', 'Выбирайте картину из системы базы, пожалуйста');
define('TEXT_UPLOAD_LOCAL_IMG', 'Закачать медиа-файлы с вашего компьютера');
define('TEXT_AVATAR_IS_PUBLIC_TO_OTHERS', 'Внимание: Ваш аватар виден другими клиентами на нашем сайте.');
define('TEXT_CROPPED_PICTURE', 'Обрезанное фото');
define('TEXT_CUT', 'обрезать');
define('TEXT_RECHANGE_PIC', 'Выбирайте фото ещё раз, пожалуйста');
define('ENTRY_YOU_COUNTRY', 'Ваша страна:');
define('ERROR_CURRENT_PASSWORD_NOT_MATCHING', 'Ваш текущий пароль не совпадает с паролем, который в наших записях. Попробуйте еще раз, пожалуйста.');
define('ENTRY_NAME', 'Имя:');

define('TEXT_LANG_YEAR', 'Год');
define('TEXT_LANG_MONTH', 'Месяц');
define('TEXT_LANG_DAY', 'День');
// END OF account add items 2013-4-12

// login items 2013-4-16
define('TEXT_CREATE_ACCOUNT_BENEFITS', 'Зарегистрируйтесь, чтобы получить <b>US$ 6.01</b> денежных купона и наслаждаться VIP скидкой до  <b>10%</b>');
define('LOGIN_EMAIL_ADDRESS', 'Электронная Почта:');
define('LENGHT_CHARACTERS', 'Это должно быть не менее 5 символов (должны содержать буквы и цифры).');
define('TEXT_YOUR_COUNTRY', 'Ваша Страна: ');
define('SUBCIBBE_TO_RECEIVE_EMAIL', 'Подписаться на получение наших специальных предложений электронной почты.');
define('AGREEN_TO_TERMS_AND_CONDITIONS', 'Я  соглашаюсь с Doreenbeads.com <a href="https://www.doreenbeads.com/page.html?id=157" target="_blank">Товары и Условия</a>.');
// end of login items

// account_edit items 2013-4-19
define('TEXT_LANG_YEAR', 'год');
define('TEXT_LANG_MONTH', 'месяц');
define('SET_AS_RECIPIENT_ADDRESS', 'Установить как адрес получателя по умолчанию');
// end of account_edit items

// account_order items 2013-4-19
define('TEXT_ORDER_DATE', 'Дата заказа');
define('TEXT_ORDER_DATE_DATE', 'Дата заказа:');
define('TEXT_ORDER_NUMBER', 'Номер Заказа');
define('TEXT_ORDER_NUMBER_LABEL', 'Номер Заказа:');
define('TEXT_ORDER_TOTAL', 'Заказ Всего');
define('TEXT_ORDER_STATUS', 'Статус Заказа');
define('TEXT_ORDER_STATUS_LABEL', 'Статус Заказа:');
define('TEXT_ORDER_DETAILS', 'Подробности');
define('TEXT_ORDER_PRODUCT_PART', 'Быстро заказать товар: артикул>>');
define('TEXT_ORDER_NO_EXISTS', 'Нет заказа существует');
define('TEXT_DISCOUNT_OFF_SHOW', 'скидка');
define('TEXT_HANDING_FEE', 'Пошлина за обработку');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Демонстрация <strong>%d</strong> до <strong>%d</strong> (of <strong>%d</strong> заказы)');
define('SUCCESS_PASSWORD_UPDATED', 'Ваш пароль был успешно обновлен');
define('TEXT_AVATAR_UPLOAD_SUCCESSFULLY', 'Картина была утвержденна. Спасибо !');
// end of account_order items

// bof v1.0, zale 20130424
define('EXTRA_NOTE', '2-3 дня является временем доставки с нашего склада в адрес вашего китайского агента.');
define('TEXT_NOTE_SPTYA', '<font color="red">Добавляйте адрес вашего китайского агента в <a href="' . zen_href_link ( FILENAME_CHECKOUT_SHIPPING ) . '#comments">Отзывы для заказа.</a></font>');
define('TEXT_DETAILS_SPTYA', '<font color="red">Подробности:</font><br />
<font color="red">1、</font>Выбирайте агент доставки в Китае, которому вы доверяете и знакомы.<br />
<font color="red">2、</font>Предоставите нам  адрес и контактную информацию этого агента доставки, пожалуйста. ( лучше на китайском языке, если это возможно ) в <font weight="700" color="blue">Отзывы для заказа</font>.<br />
<font color="red">3、</font>Мы доставляем ваш ​​товар в его место. Вы просто оплатите нам за стоимость доставки из нашего города в адрес агента доставки, которые вы выбирали. Обычно лишь около <font color="blue">1-2 USD/кг</font>, вы можете оплатить за его после подтверждения заказа и агента. И около 2-3 дней агент сможет получить посылку.<br /><br />
<span style="color:red;">Note:</span> Не беспокойтесь о проблеме пошлины, вы получите посылку без взимания налога.');

define('TEXT_DETAILS_TRSTV', '<font color="red">Подробности:</font><br />
<font color="red">1、</font>Ваша посылка будет отправлена в наш Суйфэньхэ агент доставки (расходится в провинции Хэйлунцзян, Китай) сначала.<br />
<font color="red">2、</font>Тогда наш агент будет доставлять вашу посылку до Владивостока (Владивосток, находится на юго-востоке России). <br />
<font color="red">3、</font>Когда посылка прибудет там, местный агент доставки будет связываться с вами, сообщить вам посылка прибыла, а затем вы можете выбрать способ доставки для вашей посылки от Владивостока до вашего города по вашеу предпочтению. Также вы должны оплатить за ваше внутреннее стоимость доставки.<br /><br />
<font color="red">Короче говоря:</font><br />
Стоимость доставки = Стоимость от нашей компании до Владивостока была показана  (взимается dorabeads) + Стоимость из Владивостока до вашего места (взимается вашим местным перевозчиком доставки, стоимость около <font color="blue">1-3 USD / кг</font>)<br/><br />
  
Как наш Суйфэньхэ агент доставки, он является опытным и надежным агентом доставки, который сотрудничается с нами очень хорошо.<br /><br />
<span style="color:red;">Внимание:</span> Не беспокойтесь о проблеме пошлинв, вы получите посылку без взимания налога.');

define('TEXT_DETAILS_TRSTM', '<font color="red">ПОдробности:</font> <br />
<font color="red">1、</font>Мы будем грузить товары в китайско-российскую логистическую компанию（ Находиться в Пекин, Китай）, которая несет ответственность за перевозку товаров в Москву. <br>
<font color="red">2、</font>Когда прибыва в Москву, работник по логистике будет связаться с вами, сообщить вам, что ваша посылка прибыла, а затем вы можете выбрать способ доставки для вашей посылки от Москвы до вашего адреса по вашеу предпочтению. Работник будет грузить товары к вам по вашей инструкции. Также вы должны оплатить за ваше внутреннее стоимость доставки. <br /><br />
  
<font color="red">Короче говоря:</font><br />
The shipping cost = стоимость от нашей компании до Москвы была показана (взимается dorabeads) + Стоимость из Москвы до вашего места (взимается Китайско-Российской логистической компании, стоимость около <font color="blue">1 USD / кг</font>)<br /><br />
  
Как Китайско-Российская логистическая компания, она является опытным и надежным агентом доставки, у которого есть большая страховая политика.  <span style="background:yellow;color:black;">Наши посылки, которые эта компания отправляет, всегда приходят гладко.</span><br /><br />
<span style="color:red;">Внимание:</span> Не беспокойтесь о проблеме пошлинв, вы получите посылку без взимания налога.');

define('TEXT_DETAILS_TRSTMA', 'Ваши товары будут доставленны в один из следующих городов, который является самым ближайшим от вашего адреса доставки по воздуху:
  <span style="color:#008FED;margin: 10px 0;">Москва, Санкт-Петербурк, Красноярск, Новосибирск, Екатеринбург, Иркутск, Омск, Камчатка, Сахалин, Якутск</span>
  a. Когда посылка приходит в город, который является рядом с вашим местоположением, наш агент доставки будет связаться с вами. Тогда вы можете сам забрать посылку, в таком случае, вам не придется оплатить за дополнительную стоимость доставки. (Обратите внимание, пожалуйста, что если вы живете близко от Москвы, вы должны забрать посылку вовремя, так как оплата за хранения посылки на Москвском складе взимается.)<br><br>
  b. Если вы не можете сам забрать посылку , вы можете просить работника, который с вами связались, чтобы доставить посылку в ваш адрес способом доставки, который вы хотите. Этот работник будет грузить товары к вам по вашей инструкции. Также вы должны оплатить за вашу внутреннюю стоимость доставки.<br><br>
  Стоимость доставки = Стоимость была показана, когда вы оплатили (взимается 8years) + Стоимость из города до вашего места (взимается логистической компании).<br><br>
  <font color="#ff0000">Внимание:</font> Чтобы вашу посылку доставляют успешно, компания доставки требует фото или копия удостоверения личности получателя. Добро это отправите на  <a href="mailto:service_ru@doreenbeads.com">service_ru@doreenbeads.com</a>. По всем вопросам, свяжитесь с нами, пожалуйста.');
define('TEXT_TRSTM','А. Мы перевезём ваш груз до логистической компании,кто будет доставлять груз до Москвы.<br>
Б. Когда ваш груз доставлен до Москвы,работник в логистической компании свяжется с Вамим и вы можете выбирать способ доставки с Москвы до вашего города.Вы должены платить за внутринациональную перевозку.<br>
<b>Стоимость доставки</b> = та стоимость доставки,показанная при оформлении заказа (платить 8seasons) + плата за перевозку с Москвы до вашего города(платить наличными логистической компании,примерно 0.3-0.5 USD / kg ).');

define('TEXT_DETAILS_YNKQY', 'Ваши товары будут доставлены в один из следующих городов, который является самым ближайшим от вашего адреса доставки  <b>на машине</b>:
<span style="color:#008FED;margin: 10px 0;">Москва, Санкт-Петербурк, Красноярск, Новосибирск, Екатеринбург, Иркутск, Омск, Якутск, Уссури, Хабаровск, Тюмень, Владивосток, Якутск</span>
a. Когда посылка приходит в город, который является рядом с вашим местоположением, наш агент доставки будет связаться с вами. Тогда вы можете сам забрать посылку, в таком случае, вам не придется оплатить за дополнительную стоимость доставки. (Обратите внимание, пожалуйста, что если вы живёте близко от Москвы, вы должны забрать посылку вовремя, так как оплата за хранения посылки на Москвском складе взимается.)<br><br>
b. Если вы не можете сам забрать посылку , вы можете просить работника, который с вами связались, чтобы доставить посылку в ваш адрес способом доставки, который вы хотите. Этот работник будет грузить товары к вам по вашей инструкции. Также вы должны оплатить за вашу внутреннюю стоимость доставки.<br><br>
<b>Стоимость доставки</b> = Стоимость была показана, когда вы оплатили (взимается doreenbeads) + Стоимость из города до вашего места (взимается логистической компании).<br><br>
<font color="#ff0000">Внимание:</font> Чтобы ваша посылка доставляется успешно, Компания доставки требует фото или копия удостоверения личности получателя. Добро это отправите на <a href="mailto:service_ru@doreenbeads.com">service_ru@doreenbeads.com</a>. По всем вопросам, свяжитесь с нами, пожалуйста.');

define('TEXT_READ_NOTE', 'Прочитайте эту заметку, пожалуйста.');
define('TEXT_SPTYA', 'Вы должны выбрать агент доставки в Китае, а затем расскажите нам его адрес доставки на китайском языке, пожалуйста. Надеюсь,вы добро понимаете, что вам надо оплатить за доставку из вашего города до ващего агента.');

define('EXTRA_NOTE_CN', 'Мы взимаем стоимость доставки в основе вашего фактического местоположения.');

define('NOTE_EMS', '<font color="red">Если вы купили <strong>watches</strong> или <strong>что-то острое</strong>как ножницы, не выбирайте EMS,пожалуйста. Почему?>></font>');
define('NOTE_EMS_CONTENT', '<span style=color:red;>Для клиента, который купил часы или острый товар:</span> Если ваш заказ содержит <strong>часы</strong> или <strong>что-то острое</strong> как ножницы и острые плоскогубцы для носа, не выбирайте EMS,пожалуйста.<div style="margin-top:8px; color:#333">Причина: Таможня строго проверяет, если таможня обнаруживает EMS посылку с часами или острым товаром, посылка будет возвращенна из таможни, также почта будет наказана таможней.<br/> Если вы предпочитаете использоваться EMS или если стоимость доставки EMS является самой дешевой, вы можете рассмотреть на то, что заказать запрещенные товары отдельно с другими товарами или не стесняйтесь связаться с нами по почте <a href=mailto:service_ru@doreenbeads.com>service_ru@doreenbeads.com</a>, мы будем давать вам самое хорошее предложение.</div>');

define('NOTE_USPS', '<font color="red">Если вы купили <strong>watches</strong> или <strong>что-то острое</strong>как ножницы, не выбирайте USPS,пожалуйста. Почему?>></font>');
define('NOTE_USPS_CONTENT', '<span style=color:red;>Для клиента, который купил часы или острый товар:</span> Если ваш заказ содержит <strong>часы</strong> или <strong>что-то острое</strong> как ножницы и острые плоскогубцы для носа, не выбирайте USPS,пожалуйста.<div style="margin-top:8px; color:#333">Причина: Таможня строго проверяет, если таможня обнаруживает USPS посылку с часами или острым товаром, посылка будет возвращенна из таможни, также почта будет наказана таможней.<br/> Если вы предпочитаете использоваться USPS или если стоимость доставки USPS является самой дешевой, вы можете рассмотреть на то, что заказать запрещенные товары отдельно с другими товарами или не стесняйтесь связаться с нами по почте <a href=mailto:service_ru@doreenbeads.com>service_ru@doreenbeads.com</a>, мы будем давать вам самое хорошее предложение.</div>');

define('TEXT_NOTE_ABOUT_TAX', ' Прочитайте примечание о налоге, пожалуйста! Подробности>>');
define('TEXT_NOTE_ABOUT_TAX_CONTENT', 'Примечание о Налоге:  По нашим опытам, Налог имеет большой шанс быть взиман для посылки, отправленная Fedex в вашу страну, поэтому мы предлагаем вам положить эту информацию в свой ум, выбирайте наиболее благоприятный способ, пожалуйста.');

define('NOTE_FEDEX','<font color="red">Заказ с часами не рекомендуется использовать FedEx! Почему?>></font>');
define('NOTE_FEDEX_CONTENT','Для клиента, который купил часы: Если Ваш заказ содержит часы, мы не рекомендуем вас выбирать FedEx. Вы можете выбрать любые другие способы доставки. <br/><font style="color:red;font-weight:bold;">Причина</font>: FedEx делает строгую проверку электронных продуктов, если они нашли посылку с часами, то пакет будет держан в таможне.  <br/>Если вы предпочитаете использовать FedEx или у вас есть вопрос,пожалуйста,не стесняйтесь связаться с нами <a href=mailto:service_ru@doreenbeads.com>service_ru@doreenbeads.com</a>,мы дадим вам лучшее предложение.');

define('TEXT_NOTE_USE_ENGLISH' , 'Почему Fedex требует адрес на английском языке?');
define('TEXT_NOTE_USE_ENGLISH_DESCRIPTION' , 'Fedex требует адрес на английском языке, чтобы не принести запоздание при отправке, пожалуйста, оставьте комментарий для вашего адреса на английском языке во время проверки. Если у вас его нет, обратитесь к нашей обслуживанией клиента: <a href="mailto:service_ru@doreenbeads.com">service_ru@doreenbeads.com</a>');

define('TEXT_NOTE_ABOUT_WATCH', 'Пожалуйста, не забудьте прочитать примечание о часах. Подробности>>');
define('TEXT_NOTE_ABOUT_WATCH_CONTENT', 'Если ваш заказ содержит часы выше 20% в количестве, пожалуйста, не выбирайте DHL (прямой), так как DHL строго проверяет посылку с электрическими продуктами, как часы. Посылка не будет разрешенна доставлять.');

define('NOTE_TARIFF', 'Примечание о ценности объявления таможенной пошлины');
define('NOTE_TARIFF_CONTENT', 'Для этого способа доставки, мы будем отмечать подходящую сумму (около 15GBP-40GBP) на посылке, так что вам не придется оплатить за налог. <br />Если вы хотите, чтобы отмечать реальную сумму на посылке, 20% пошлин необходимо, поэтому мы сильно рекомендуем вам, что просто оставить его нам, мы будем обращаться с этим корректно.');
define('NOTE_TARIFF_CONTENT_US', 'Для этого способа доставки, мы будем отмечать подходящую цену(около 15GBP-40GBP) на упаковке, так что вам не надо платить никаких налогов. <br />Если вы хотите отметить реальную цену на упаковке, 20% таможенной пошлины необходимо, поэтому мы настоятельно рекомендуем Вам, чтобы просто оставить его нам,и мы будем управлять им правильно.');

define('TEXT_HOW_DOES_IT_WORKS', 'Как это работает?');
define('TEXT_HOW_DOES_IT_WORKS_1', 'Как это работает? Копия удостоверения личности требуется.');

define('TEXT_POBOX_REMINDER', 'Напоминание: Чтобы обеспечить вашу посылку доставленна гладко, любезно предоставляйте адрес улицы вместо только почтового адреса, пожалуйста,.');

define('TEXT_YOUR_ITEMS_BE_SHIPPED', 'Ваши товары будут погруженны вместе в');
define('TEXT_BOXES', 'коробочки');

define('TEXT_WOOD_PRODUCTS_NOTICE', 'Деревянный / бамбуковый продукт не рекомендуют погрузить DHL, почему?');

define('NOTE_GREECE', '<a href="' . HTTP_SERVER . '/page.html?id=215' . '" target="_blank">Обязательно прочитайте примечание о пошлине >></a>');

define('TEXT_DETAILS_SFHYZXB', 'Это не от двери до двери. Вы должны забрать посылку на вашей местной почте. Когда посылка приходит на местную почту, вы получите уведомление, чтобы вы забрать вашу посылку с удостоверением личности. Не беспокойтесь о пошлине, мы позаботимся обо всём.<br>
Доброе примечание: Максимальный вес:30кг за каждую посылку. Если ваш заказ весит более 30 кг, мы будем разделять его на несколько посылок.');

define('TEXT_DETAILS_SFHKY', 'От двери до двери. Посылка будет отправленна прежде вмего до Уссури, а затем отгружённа на местную почту воздушной перевозкой. Когда он прибудет на местную почту, работник будет отправлять вашу посылку до вашего дома. Не беспокойтесь о Пошлине, мы позаботимся обо всём  .Parcel will be sent to Уссури first, then being transported to your local post office by air plane. When it arrives in local post office, the post man will dispatch the parcel to your home. No worries about Custom, we will take care of everything. <br>Advantage: A. Free of tax problem B. Can be tracked online: <a href=http://www.sfhpost.com>www.sfhpost.com</a>.<br>преимущество: А. Без пошлины B. Может отслеживать он-лайн.<br>Доброе примечание: Maxim weight: Максимальный вес:20кг за каждую посылку. Если ваш заказ весит более 20 кг, мы будем разделять его на несколько посылок.');

define('TEXT_NOTE_SPTYA', '<font color="red">Добавляйте ваш адрес китайского агента в <a href="' . zen_href_link ( FILENAME_CHECKOUT_SHIPPING ) . '#comments">Отзыва Заказа.</a></font>');

define('TEXT_NO_AVAILABLE_SHIPPING_METHOD', '<font color="red"><b>NOTE: </b></font>Если нет доступного способа доставки для вашего адреса доставки, это может быть лучшим выбором <a href="mailto:service_ru@doreenbeads.com">чтобы с нами связаться</a> потом вы продолжаете оплатить.');

define('TEXT_ITEM', 'Товар');
define('TEXT_PRICE', 'Цена');
define('TEXT_SHIPPING_METHOD', 'Способ доставки');
define('TEXT_SHIPPING_METHODS', 'Способы доставки');
define('TEXT_DAYS', 'Дни');
define('TEXT_NOTE', 'Внимание');
define('TEXT_DAYS_LAN', 'день');
define('TEXT_DAYS_LAN_24', 'дня');
define('TEXT_DAYS_LAN_ELSE', 'дней');
define('TEXT_WORKDAYS', 'рабочих день');
define('TEXT_WORKDAYS_24', 'рабочих дня');
define('TEXT_WORKDAYS_ELSE', 'рабочих дней');

define('TEXT_DAYS_ALT_S_Q', 'дни от медленного к быстрому');
define('TEXT_DAYS_ALT_Q_S', 'дни от быстрого к медленному');
define('TEXT_PRICE_ALT_L_H', 'цена от низкой до высокой');
define('TEXT_PRICE_ALT_H_L', 'цена от высокой до низкой');

define ( 'TEXT_SHIPPING_FEE', 'Стоимость доставки рассчитывают по объему и весу' );
define ( 'TEXT_CLICK_HERE_FOR_MORE_LINK', '<a href="' . HTTP_SERVER . '/page.html?id=160" target="_blank">Нажмите здесь для подробности.</a>' );
define ( 'TEXT_SHIPPING_NOTE','Пожалуйста, обратите внимание на то, что верхняя стоимость доставки уже включена дополнительную плату за доставку отдалённой области (это по просьбе %s --- ');
define ( 'TEXT_TOTAL_BOX_NUMBER', 'Общее количество коробоки' );
define('TEXT_SHIPPING_VIRTUAL_COUPON_ACTIVITY', 'Выберите эту услугу сейчас, вы можете получить купон на 2 доллара (без минимального потребления ， один купон на одного клиента).');

// eof

// login items 2013-4-16
define('TEXT_CREATE_ACCOUNT_BENEFITS', 'Зарегистрируйтесь, чтобы получить <strong>US$ 6.01</strong>  денежных купона и наслаждаться VIP скидкой до <strong>10%</strong>');
define('LOGIN_EMAIL_ADDRESS', 'Электронная почта:');
define('LENGHT_CHARACTERS', 'Это должно быть не менее 5 знаков. ');
define('TEXT_YOUR_COUNTRY', 'Ваша страна: ');
define('SUBCIBBE_TO_RECEIVE_EMAIL', 'Подписаться на получение наши специальные предложения электронной почты.');
define('AGREEN_TO_TERMS_AND_CONDITIONS', 'Я соглашаются с Doreenbeads.com правилами и условиями. ');
// end of login items

define('ENTRY_EMAIL_FORMAT_ERROR', 'Формат вашей электронной почты не является правильным, попробуйте еще раз.');
define('TEXT_VIEW_INVOICE', 'Смотреть инвойс');

define('TEXT_DISCOUNT_OFF', 'скидка');
define('TEXT_BE_THE_FIRST', 'Будьте первым');
define('TEXT_WRITE_A_REVIEW', 'Написать Отзыв');
define('TEXT_READ_REVIEW', 'Прочитать Отзыв');
define('TEXT_SHIPPING_WEIGHT_LIST', 'Вес доставки:');
define('TEXT_MODEL', 'Артикул.');
define('TEXT_INFO_SORT_BY_STOCK_LIMIT', 'Склад - с больше до меньше');
define('TEXT_STOCK_HAVE_LIMIT', '%s уп. в наличии');
define('TEXT_PROMOTION_ITEMS', 'для товаров не с акциями');

define('TEXT_PASSWORD_FORGOTTEN', 'Забыли ваш пароль?');
define('TEXT_LOGIN_ERROR', 'Извините, нет соответствующего адреса электронной почты и / или пароля.');

define('TEXT_ADDCART_MIN_COUNT', '%s---Минимальная количества заказа от %s  Количество  автоматически  обновляется  %s');
define('TEXT_ADDCART_MAX_COUNT', '%s Максимальнаяколичества заказа от %s  Количество  автоматически  обновляется  %s');
define('TEXT_ADDCART_NUM_ERROR', '<img height="20" width="20" title=" Caution " alt="Caution" src="includes/templates/template_default/images/icons/warning.gif">Извините, но у нас есть только %s пакетов доступны на данный момент. Обновляйте количество. По всем вопросам, пожалуйста, добро свяжитесь с нами по почте: service_ru@doreenbeads.com');
define('TEXT_ADDCART_NUM_ERROR_ALERT', 'Доступное количество для этого товара являются (%s). Пожалуйста, выбирайте в рамках доступного количества или наверное, вы предпочитаете купить другие товары. Большое спасибо за ваше доброе понимание!');

define('TEXT_MOVE_TO_WISHLIST_SUCCESS', 'Товар (ы) Добавлен Успешно в Список желаний! <a href="' . zen_href_link('wishlist', '', 'SSL') . '">Смотреть список желаний</a>');
define('TEXT_HAD_BEEN_IN_WISHLIST','Этот продукт был в списке пожелания ! <a href="'.zen_href_link('wishlist','','SSL').'">Смотреть ваши продукты в списке пожелания</a>');
define('TEXT_MOVE_TO_WISHLIST_SUCCESS_NOTICE', 'Все товары уже в Список желаний! <a href="' . zen_href_link('wishlist', '', 'SSL') . '">Смотреть список пожеланий</a>');
define('TEXT_VIEW_SHIPPING_WEIGHT', 'Смотреть Вес Доставки');
define('TEXT_PRODUCT_WEIGHT', 'Вес товара');
define('TEXT_WORD_PACKAGE_BOX_WEIGHT', 'Вес коробки для упаковки');
define('TEXT_WORD_SHIPPING_WEIGHT', 'Вес Доставки');
define('TEXT_WORD_VOLUME_WEIGHT', 'Объемный вес');
define('TEXT_CALCULATE_BY_VOLUME','Доставка рассчитана в соответствии с объемном весом посылки(посылок).');
define('TEXT_SHIPPING_COST_IS_CAL_BY', 'Стоимость доставки рассчитывается по весу продукта плюс Вес коробки.');

define('TEXT_CART_TOTAL_PRODUCT_PRICE', 'Общая цена товара');
define('TEXT_CART_ORIGINAL_PRICE', 'Сумма по обычной цене ');
define('TEXT_CART_PRODUCT_DISCOUNT', 'Цена со скидкой');
define('TEXT_CART_DISCOUNT_PRICE', 'Скидка на скидку -ценовую');
define('TEXT_CART_ORIGINAL_PRICES','Original Price');
define('TEXT_CART_DISCOUNT','Discount');
define('TEXT_PROMOTION_SAVE','Promotion Save');
define('TEXT_ORDER_DISCOUNT','Скидка заказа');
define('TEXT_CART_VIP_DISCOUNT','VIP Скидка');
define('TEXT_RCD','RCD');
define('PROMOTION_SAVED', 'Экономьте');
define('PROMOTION_DAILY_DEALS', 'СБ и ВС Продажи');
define('FACEBOOK_DAILY_DEALS','Facebook Горячие продажи');
//define('PROMOTION_DAILY_DEALS', '$0.79 торговля');
define('TEXT_CART_PRODUCT_DISCOUNTS', 'discounted-priced amount');
define('TEXT_FREE_SHIPPING', 'Бесплатная Доставка');

define('TEXT_CART_QUICK_ADD_NOW', 'Сейчас быстро добавлять');
define('TEXT_CART_QUICK_ADD_NOW_TITLE', 'Пожалуйста, введите артикул нашего товара(например B06512) и количество вы хотите заказать, используясь формой ниже:');
define('TEXT_CART_ADD_TO_CART', 'В корзину');
define('TEXT_ADD_TO_CART_SUCCESS', 'Добавлять в корзину успешно!');
define('TEXT_VIEW_CART', 'Смотреть корзину');

define('TEXT_CART_ADD_MORE_ITEMS_CART', 'Добавлять больше товары');
define('TEXT_ITEMS_ADDED_SUCCESSFULLY', 'ТОвары добавлённы успешно.');
define('TEXT_QUICKADD_ERROR_EMPTY', 'Пожалуйста, введите по крайней мере один артикул и количество товара');
define('ERROR_PLEASE_CHOOSE_ONE', 'Выберите, пожалуйста, как минимум один элемент.');
define('TEXT_QUICKADD_ERROR_WRONG', 'Извините, некоторые товары были не доступны. Пожалуйста, удаляйте неправильный артикул / количество');

define('TEXT_BY_PART_NO', 'Номер детали.');
define('TEXT_BY_SPREADSHEET', 'Электронные таблицы');
define('TEXT_EXAMPLE', 'Пример');
define('TEXT_SAMPLE_FROM_YOUR_SPREADSHEET', 'Образец: из таблицы, скопируйте и вставьте затененной области - как показано выше.');
define('TEXT_EXPORT_CART', 'Экспорт Корзина');
define('TEXT_PLEASE_ENTER_AT_LEAST', 'Пожалуйста, введите по крайней мере No.и QTY одного товары.');
define('TEXT_ITEMS_NOT_FOUND', 'Следующие элементы не были добавлены в корзину, потому что Номер не был найден. %s');
define('TEXT_ITEMS_WAS_REMOVED', 'Следующие элементы не были добавлены в корзину, потому что она была удалена. %s');
define('TEXT_ITEMS_WERE_ALREADY_IN_YOUR_CART', 'Следующие элементы были уже в вашей корзине и Количества теперь обновляются. Если это необходимо, вы можете проверить количества товаров. %s');
define('TEXT_ITEMS_QTY_WAT_NOT_FOUND', 'Следующие элементы не были добавлены в корзину, так как Количества товара не был найден. %s');
define('TEXT_ITEMS_MODIFIED_DUE_TO_LIMITED', 'КОЛИЧЕСТВА из следующих товаров были изменены из-за ограниченной доступности. %s');


define('TEXT_CART_JS_WRONG_P_NO', 'Неправильный артикул. Чтобы продолжать, Вы должны удалить этот товара из списка.');
define('TEXT_CART_JS_SORRY_NOT_FIND', 'Извините, некоторые товары не были найдены, удаляйте неправильный номер, пожалуйста');
define('TEXT_CART_JS_NO_STOCK', 'Нет запасов на складе. Чтобы продолжать, Вам надо удалять этот артикул из списка.');

define('TEXT_PAYMENT_DOWNLOAD', 'скачать');
define('TEXT_PAYMENT_PRINT', 'печать');
define('TEXT_PAYMENT_PROMOTION_DISCOUNT', 'Акция и Скидка');

define('TEXT_EYOUBAO', 'Это китайско-русский логистический услуг, начатый ​​PONY EXPRESS и китайской логистической компанией, характеризуется высокой скоростью доставки, конкурентоспособной ценой и гарантией безопасности. Он постепенно становится предпочтительным выбором китайско-русских  продавцов трансграничной электронной коммерции.<br><br>
Преимущества: <br>
1 Электроничные продукты разрешённы;<br>
2 Отбой для завершения он-лайн отслеживать: Вы можете отслеживать на <a href="http://set.zhy-sz.com/" target="_blank">http://set.zhy-sz.com/</a> (official website) or <a href="http://www.ponyexpress.ru/en/trace.php" target="_blank">http://www.ponyexpress.ru/en/trace.php</a> (страна назначения) в процессе всей дороги;<br>
3 Гарантия: Если посылка не добралась до места назначения в течение 32 дней, обшая стоимость доставки будет возвращённа, если стоимость доставки вы заплатили меньше 50USD. А если стоимость доставки вы заплатили больше 50USD, то будет возвращен 50USD. <br>
(Не включая специальные причины: А. Причина со стороны покупателя, как неправильный адрес доставки, не может искать получателья, без подписи и т.д. Б. По причине форс-мажорных факторов, как войны, стихийное бедствие, дутье и т.д. );<br>
4 О страховании: Вы можете выбрать страхование как вы хотите. Когда ваша посылка очень большой, вам посоветовали купить страхование, которое является 3% обьявлённой суммы для посылки. Например, если вы хотите объявить 1000USD для вашей посылки, страхоание будет 30USD. И если посылка потеряется, 1000USD будут возыращённы.<br><br>
Недостатки: <br>
1 Вес ограничения: 31kg. Если ваша посылка весит больше, чем 31 кг, мы будем разделять его на несколько посылок;<br>
2 Размер ограничения: 60cmx55cmx45cm;<br>
3 Нет ничего запрещённого.<br>');

define('TEXT_XXEUB', 'Способ доставки только требуется около 7-15 дней для доставки.Посылка будет доставлена ​​получателю на местную почту. информация отслеживания доступна на: <a href="https://tools.usps.com/go/TrackConfirmAction_input" target="_blank">https://tools.usps.com/go/TrackConfirmAction_input</a>.<br><br>
Преимущества: <br>
1 По сравнению с авиапочтой, этому нужно всего 7-15 дней, чтобы добраться до места назначения. Иногда посылка даже может доставленна покупателю в течение 4-6 дней. <br>
2 Бесплатная пошлина;<br>
3 PO BOX адрес разрешён;<br><br>
Недостатки:<br>Если посылка весит более 2 кг, ваш заказ будет разделен на две части. <br><br>
Теплое Примечание: номер телефона значительно облегчит доставку. <br>');
define('TEXT_HMJZ', '(Общее количество коробок: 1)');
// /////////////////////////////////////////////////////////
// dorabeads v1.5
define('TEXT_AVATAR_UPLOAD_TIPS', '<div style="font-weight:normal;font-size:15px;text-align:left;padding:0px 15px 0px 15px;line-height:23px;color:#ff6600">Если вы выбираете файл картины с вашего компьютера, пожалуйста, любезно обратите внимание:<p style="margin-top:5px">1. 50 KB max.<br>2. Только Jpg, gif, png, bmp .<br>3. Размер Рекомендуемый: 50x50, 100x100.<br>4.Ваш аватар виден другими клиентами на <br>&nbsp;&nbsp;&nbsp;нашем сайте.</p></div>');
define('TEXT_CASH_CREATED_MEMO_1', 'Ваш сумма кредита была использована для заказа: Номер #%s');

define('TEXT_TARIFF_TITLE_1', 'Please write down your Customs No.. It helps customs clearance. <br /><br/>Тарифный номер:<input name="tariff" id="tariff" style="margin-top: -10px;" type="text"/>( необязательное поле )<input type="hidden" name="tariff_alert" id="tariff_alert" value=""/><input type="hidden" name="tariff_title" id="tariff_title" value="CPF/CNPJ No."/>');

define('TEXT_TARIFF_TITLE_2', 'Please write down your Customs No.. It helps customs clearance. <br /><br/><FONT COLOR="RED">*</FONT> CPF/CNPJ номер:<input name="tariff" id="tariff" style="margin-top: -10px;" type="text"/>( Обязательное для заполнения поле )<input type="hidden" name="tariff_alert" id="tariff_alert" value="Please write down your CPF/CNPJ No.."/><input type="hidden" name="tariff_title" id="tariff_title" value="CPF/CNPJ No."/><br /><br/><FONT COLOR="RED"><b>Note：</b></FONT>Все посылки в Бразилию через Экспресс требуют CPF / CNPJ. Если у вас нет, пожалуйста выберите воздушную почту.');

define('TEXT_TARIFF_TITLE_3', 'Please write down your Customs No.. It helps customs clearance. <br /><br/><FONT COLOR="RED">*</FONT> EORI No. :<input name="tariff" id="tariff" style="margin-top: -10px;" type="text"/>( required field )<input type="hidden" name="tariff_alert" id="tariff_alert" value="Please write down your EORI No.."/><input type="hidden" name="tariff_title" id="tariff_title" value="EORI No."/><br /><br/><FONT COLOR="RED"><b>Внимание：</b></FONT>FedEx(Агент) требует номер EORI. Если у вас нет, выбирайте другой способ доставки, пожалуйста. ');

define('TEXT_TARIFF_TITLE_4', 'Please write down your Customs No.. It helps customs clearance. <br /><br/>EORI номер:<input name="tariff" id="tariff" style="margin-top: -10px;" type="text"/>( optional field )<input type="hidden" name="tariff_alert" id="tariff_alert" value=""/><input type="hidden" name="tariff_title" id="tariff_title" value="EORI No."/>');

define('TEXT_TARIFF_TITLE_5', 'Please write down your Customs No.. It helps customs clearance. <br /><br/>Тарифный номер:<input name="tariff" id="tariff" style="margin-top: -10px;" type="text"/>( optional field )<input type="hidden" name="tariff_alert" id="tariff_alert" value=""/><input type="hidden" name="tariff_title" id="tariff_title" value="Custom No."/>');

// bof dorabeads v1.7, zale
define('TEXT_VERIFY_NUMBER', 'Номер подтверждения');
define('TEXT_TRACKING_NUMBER', 'Трёк-код');
define('TEXT_TERMS_CONDITIONS', 'Правила и Условия');
define('TEXT_PRIVACY_POLICY', 'Политика конфиденциальности');
define('TEXT_SHOPPING_CART_OUTSTOCK_NOTE', 'Следующие продукты были перемещены из корзины в свой список пожеланий, так как они не в наличии на данный момент, которые будут доступны в ближайшее время. Просто нажмите пополнить уведомления запасов, чтобы получить новость о пополнении запаов во время.');
define('TEXT_SHOPPING_CART_DOWN_NOTE', 'Эти продукты были удалены из корзины, так как они нет в наличии. Если вам это нужно, свяжитесь с нами за помощью пожалуйста,<a href="mailto:service_ru@doreenbeads.com">service_ru@doreenbeads.com</a>.');
define('TEXT_VIEW_LESS_SHOPPING_CART', 'Показать меньше');
define('TEXT_SHOPING_CART_SELECT_SIMILAR_ITEMS', 'Выбрать похожие товары');
define('TEXT_SHOPING_CART_EMPTY_INVALID_ITEMS', 'Пустые Неэффективные Элементы');
define('TEXT_SHOPING_CART_CONFIRM_EMPTY_INVALID_ITEMS', 'Подтверждаете ли вы опорожнять недопустимых элементов?');
define('PROMOTION_LEFT', 'Оставляться');
define('TEXT_SIMILAR_PRODUCTS', 'Подобные Продукты');

define('TEXT_CODE_DAY', 'Д');
define('TEXT_CODE_HOUR', 'ч');
define('TEXT_CODE_MIN', 'м');
define('TEXT_CODE_SECOND', 'с');
// eof v1.7

define('TEXT_IMPORTANT_NOTE', 'Важное примечание');
define('TEXT_PAY_SUCCESS_TIP_TiTLE', 'Тепло Обратите внимание:');
define('TEXT_PAY_SUCCESS_TIP', 'Принимая во внимание текущую напряженную ситуацию в глобальной эпидемии, полеты будут становиться все более тесными,поэтому, возможно, возникнут некоторые задержки с доставкой, пожалуйста, поймите.
Мы сделаем все возможное, чтобы вы получили товар как можно скорее.');
define('TEXT_PLEASE_KINDLY_CHECK', 'Пожалуйста, проверьте ваш адрес доставки, чтобы подтвердить его правильность. Обычно мы отправляем посылку в течение 1-2 дней после получения оплаты. Поэтому, если вы замечаете, что ваш адрес доставки не правильно написан, <a href="mailto:service_ru@doreenbeads.com" style="color:#008FED;">свяжитесь с нами</a> в течение 24 часов как можно скорее.');

define('TEXT_SEARCH_RESULT_TITLE', 'Результаты поиска:');
define('TEXT_SEARCH_RESULT_NORMAL', 'Вы искали <span>%s</span>, <span>%d</span> результаты поиска по <span>%s</span>.');
define('TEXT_SEARCH_RESULT_SYNONYM', 'Таким образом, мы искали <i>%s</i> для вас.');
define('TEXT_RELATED_SEARCH','Связанные');
define('TEXT_SEARCH_TIPS','<div class="search_error_cont">
        <dl>
            <dt>Вид Рекомендация:</dt>
            <dd><span>-</span><p>Проверьте ваши введенные слова, чтобы убедиться, что это правильно.</p></dd>
            <dd><span>-</span><p>Если номер детали, которую вы искали, недоступен, <a href="mailto:service_ru@doreenbeads.com">свяжитесь с нами</a>.</p></dd>
            <dd><span>-</span><p>Используйте подобные слова с разным написанием.</p></dd>
        </dl>
        <div class="action"><a href="'.zen_href_link(FILENAME_DEFAULT).'" class="continue_shopping">Продолжить покупки</a><a href="'.zen_href_link(FILENAME_WHO_WE_ARE,'id=99999' ).'" class="contact_us">Связаться с нами</a></div>
    </div>');
define('TEXT_SEARCH_RESULT_FIND_MORE','Найти больше из следующих');

define('TEXT_CART_ARE_U_SURE_DELETE', 'Вы уверены, что удалить этот товар?');
define('TEXT_DOWNLOAD', 'скачать');
define('TEXT_SHIPPING_CHARGE', 'расходы по доставке:');
define('TEXT_CART_VIP_DISCOUNT', 'VIP Скидка');
define('TEXT_CART_JS_WRONG_NO', 'Неправильный артикул.');
define('TEXT_NO_STOCK', 'Нет в наличии. ');
define('TEXT_YES', 'Да');
define('TEXT_NO', 'Нет');
define('TEXT_PER_PACK', 'за упаковку');
define('TEXT_GRAMS', 'граммы');
define('TEXT_CREDIT_BALANCE', 'Кредитный Баланс:');

define('TEXT_UNIT_KG', 'кг');
define('TEXT_UNIT_GRAM', 'Грамм');
define('TEXT_UNIT_POUND', 'фунт');
define('TEXT_UNIT_OUNCE', 'унция');

define('TEXT_UBI_NOTE', 'Линия UBI запрещёна грузить любые деревянные или бамбуковые продукты. Подробности》');
define('TEXT_UBI_NOTE_CONTENT', 'Если в вашем заказе включает деревянные или бамбуковые изделия, пожалуйста, не выбирайте линию UBI ,так как этому способу доставки запрещён грузить любые деревянные или бамбуковые продукты. Вы можете либо изменить способ доставки для всего заказа или заказать эти элементы по отдельности с помощью других методов. Если нужна помощь или совет, пожалуйста, нажмите Контакты или напишите нам по адресу <a href="mailto:service_ru@doreenbeads.com">service_ru@doreenbeads.com</a> в любое время.');

define('TEXT_VIEW_LIST', 'Cписок');
define('TEXT_VIEW_GALLERY', 'Галерея');

define('HEADER_TITLE_NORMAL','Нормальный');
define('TEXT_SERVICE_EMAIL', 'service_ru@doreenbeads.com');
define('TEXT_SERVICE_SKYPE', 'service.8seasons_ru');

// v2.20
define('TEXT_MY_COUPON', 'Купон');

define('NOTE_RUSSIAN_NOTE', 'Для этого способа доставки, посылка будет отправлена после 5 февраля. Детали>>');
define('NOTE_RUSSIAN_NOTE_CONTENT', '<font style="color:#ff0000;">Доброе примечание:</font> Скоро наступает Китайский Новый год 2014 по лунному календарю. И  это способ доставки не работает <font style="color:#ff0000;">с 21 января до 6 февраля</font>, поэтому мы отправим ваш заказ после праздника. Если  вам очень нужны товары, вам можно выбрать другой способ доставки (воздушная перевозка маленького размера или EMS), мы отправим ваш заказ до нашего праздника <font style="color:#ff0000;">(до 29 января)</font>.Спасибо за вашу добрую поддержку и понимание. С уважением Команда doreenbeads.');

define('TEXT_ESTSHIPPING_TIME', 'Примерные сроки доставки');

define('TEXT_NEWSLETTER_SUCC', 'Успех! Спасибо за Вашу регистрацию!');
define('TEXT_NEWSLETTER_JOIN', 'ВСТУПАТЬ');
define('TEXT_NEWSLETTER_EMAIL_ADDRESS', 'Адрес электронной почты');

define('TEXT_MORE_PRO','Больше');
define('TEXT_VIEW_LESS','Меньше');
define('TEXT_CLEAR_ALL','Удалить все');
define('TEXT_ITEM_FOUND_3','Найдено <b>%s</b> товаров');
define('TEXT_ITEM_FOUND_2','Найдено <b>%s</b> товары');
define('TEXT_ITEM_FOUND','Найдено <b>%s</b> товар');
define('TEXT_REFINE_BY_WORDS','Сортиро- вать по');

define('TEXT_SUB_WHICH_TYPE', 'Какой вы тип?');
define('TEXT_SUB_WHOLESALER', 'Оптовик');
define('TEXT_SUB_RETAILER', 'Торговец');
define('TEXT_SUB_DIY_FANS', 'Любитель «Сделай Сам»');
define('TEXT_SUB_OTHERS', 'Другие');

define('TEXT_SET_COUPON', "Ура! Поздравляем, что %s купон уже в Вашем счете. Вы можете проверить его в <a href='".HTTP_SERVER."/index.php?main_page=my_coupon' style='text-decoration: underline;'>\"Мой Купон\"</a>.");

define('TEXT_JOIN_NOW_COUPON', 'ЗАРЕГИСТРИРУЙТЕСЬ И ПОЛУЧАТЬ <span>$6,01 КУПОН</span>');
define('TEXT_JOIN_PASSWORD', 'Пароль');
define('TEXT_JOIN_NOW_DISCOUNT_UP', 'VIP СКИДКА ДО 10%');
define('TEXT_JOIN_NOW_SIGN_UP', 'Подписка на новости о новых поступлениях,<br/> специальных предложениях, скидке и больше！');
define('TEXT_JOIN_NOW_DEAR_CUSTOMERS', 'дорогой клиент');
define('TEXT_JOIN_NOW_RETURN_CUSTOMERS_LOGIN', 'Постоянный Клиент? <a href="'.zen_href_link(FILENAME_LOGIN).'" class="link_color">Войти</a>');

define('TEXT_UNIT_PRICE', 'Цена начиная от <span class="productSpecialPrice">%s</span> руб за %s');
define('TEXT_SILVER_REPORT', 'Наша серебряная фурнитура для бижутерии уже проходят проверку формальных институтов Китая, которые широко признаны как ILAC и членов APLAC [<a target="_blank" href="silver_report.html">Нажмите для Испытательного Отчета</a>].');
define('TEXT_SWAROVSKI_CERTIFICATE', 'Как агент Swarovski, у нас есть официальный сертификат агента, вы будете получать подлинные хрустальные элементы австрийский Swarovski <a target="_blank" href="swarovski_certificate.html">[Нажмите здесь для сертификата]</a>.');

define('EMAIL_PAYMENT_INFORMATION_ADDRESS','jiahui.xu@panduo.com.cn');
define('TESTIMONIAL_CC_ADDRESS','dan.lin@panduo.com.cn,daling.rao@panduo.com.cn');
define('AVATAR_CHECK_ADDRESS', 'notification_ru@doreenbeads.com' );
define('AVATAR_CHECK_CC_ADDRESS', 'chahua.wang@panduo.com.cn' );
define('SALES_EMAIL_ADDRESS', 'service_ru@doreenbeads.com');
define('SALES_EMAIL_CC_TO', 'dan.lin@panduo.com.cn,yunan.zhang@panduo.com.cn,chahua.wang@panduo.com.cn');
define('TEXT_PRICE_AS_LOW_AS', 'Всего лишь');

define('TEXT_BACKORDER', 'Предзаказ');
define('TEXT_ARRIVAL_DATE','Ожидаемая дата пополнения товара: %s.');
define('TEXT_READY_DAYS', 'Ожидающий Период Прибытия: %s дней.');
define('TEXT_ESTIMATE_DAYS', 'Ожидающий Период Прибытия: %s дней.');
define('TEXT_PREORDER','<font style="color:#ff0000" class="text_preorder_class" title="Товара временно нет в наличии, и вы уже оформили предварительный заказ.">&lt;Предзаказ&gt;</font> ');

define('TEXT_CART_ERROR_NOTE_PRODUCT_LESS','Доступны только %s пакет (ы) %s. Количество обновляется до %s автоматически.');
define('TEXT_CART_ERROR_HAS_BUY_FACEBOOKLIKE_PRODUCT','Каждый вентилятор Facebook получите 1 комплект бесплатного образца %s. Вы уже получили его в порядке %s, поэтому он был удален из корзины.');
define('TEXT_GET_COUPON', 'Поздравления! У вас есть купоны до %s. Пожалуйста, зарегистрируйтесь в «<a href="'.zen_href_link(FILENAME_MY_COUPON).'">Мой купон</a>».');
define('TEXT_ALREADY_GET', 'Ой, каждый купон только может быть получен один раз.');
define('TEXT_GET_COUPON_EXPIRED', 'Извините, Время получения купонов истекло, не может получить купоны.');

// include email extras
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_EMAIL_EXTRAS )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_EMAIL_EXTRAS )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_EMAIL_EXTRAS);
}

// include template specific header defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_HEADER )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_HEADER )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_HEADER);
}
// include template specific footer defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_FOOTER )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_FOOTER )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_FOOTER);
}

// include template specific button name defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_BUTTON_NAMES )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_BUTTON_NAMES )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_BUTTON_NAMES);
}

// include template specific icon name defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_ICON_NAMES )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_ICON_NAMES )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_ICON_NAMES);
}

// include template specific other image name defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_OTHER_IMAGES_NAMES )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_OTHER_IMAGES_NAMES )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_OTHER_IMAGES_NAMES);
}

// credit cards
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_CREDIT_CARDS )) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_CREDIT_CARDS )) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_CREDIT_CARDS);
}

// include template specific whos_online sidebox defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/' . FILENAME_WHOS_ONLINE . '.php')) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_WHOS_ONLINE . '.php')) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . FILENAME_WHOS_ONLINE . '.php');
}

// include template specific meta tags defines
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir . '/meta_tags.php')) {
	$template_dir_select = $template_dir . '/';
} else {
	$template_dir_select = '';
}
if (file_exists ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . 'meta_tags.php')) {
	require_once (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/' . $template_dir_select . 'meta_tags.php');
}

// END OF EXTERNAL LANGUAGE LINKS
/*testimonial  mailto */
define('TESTIMONIAL_EMAILS_TO', 'service_ru@doreenbeads.com');
/*coupon about to expire notice*/
define('TEXT_COUPON_NOTICE_FIRST', '<p class="tleft">У вас купон, который скоро истекает.  <br />
					Код купона <span>%s</span>. Крайний срок <span>%s</span>.');
define('TEXT_VIEW_MORE', 'смотреть дальше');					
define('TEXT_COUPON_NITICE_SECOND', '<br />					
		Искренне советую вам использовать купон как можно раньше.</p>
					<a href="javascript:viod(0)" class="guidebtn">Хорошо, я знаю.</a> ');

/*ask a question*/
define('TEXT_PART_NO','Артикул :');
define("EMAIL_QUESTION_SUBJECT","Вопрос для подробностей об этом предмете");
define('EMAIL_QUESTION_TOP_DESCRIPTION',"Ваши вопросы о предмете %s в сайте dorabeads мы уже получили.");

define('EMAIL_QUESTION_MESSAGE_HTML',"%s<br /><br />\n\nУважаемый %s,<br /><br />\n\nЖелаю Вам хорошего дня!\n\n<br /><br />Большое спасибо за контакт с dorabeads. Мы уже получили ваш вопрос, и один из наших дружественных работников свяжется с Вами как можно скорее в течение 24 часов. Просьба ждать с терпением.<br /><br />\n\nЕсли вам нужна оперативная помощь, пожалуйста, свяжитесь с нами через онлайн-чат или позвоните нашему обслуживанию клиентов на (+86)0571-28197839 во время наших рабочих часов: с 8:30 AM до 6:30 PM (GMT +08:00) Пекин, Китай с воскресенья по пятницу.<br /><br />\n\nСпасибо за ваше время, Мы скоро свяжемся с Вами!<br /><br />\n\n--------------------------------------Ваш Вопрос---------------------------------------<br />%s<br /><br />%s<div style='clear:both;'>Всего хорошего<br />\nDoreenbeads Team<br />\n<a href=".HTTP_SERVER.">www.doreenbeads.com</a></div>");
/*address line 1 2 same error*/
define('ENTRY_FS_ADDRESS_SAME_ERROR','Мы заметили, что ваш Адрес строки 2 такой же, как Адресная строка 1, пожалуйста, переписывайте Адресную строку 2 или просто оставляйте её пустой.');
define('TEXT_REMOVED','Удалены');
define('TEXT_REFUND_BALANCE', 'Возвращенный кредитный баланс для заказа: #');
/*facebook_coupon*/
define('FACEBOOK_LINK', 'http://vk.com/dorabeads');
/*满减活动*/
define('TEXT_PROMOTION_DISCOUNT_FULL_SET_MINUS', 'Скидка на заказ');


/*other package size*/
define('TEXT_OTHER_PACKAGE_SIZE', "Другие Размеры Упаковки");
define('TEXT_MAIN_PRODUCT','Основные товары');
define('TEXT_PRODUCTS_WITH_OTHER_PACKAGE_SIZES','Товары с Другими Размерами Упаковки');
define('TEXT_PACK_FOR_OTHER_PACKAGE', 'Упаковка');
define('TEXT_PRODUCTS_IN_SMALL_PACK', 'Товары в малых обновлений');
define('TEXT_PRODUCTS_IN_REGULAR_PACK', "Товары в регулярных обновлений");

define('TEXT_SHIPPING_CALCULATE_TIPS','<span style="color:red;font-weight:bold">Внимание:</span>Пожалуйста, обратите внимание, что расчёт  Доставки применяется здесь только к заказам  <span style="font-weight:bold">свыше $ 19.99.</span>Если стоимость заказа меньше US $19.99, то мы будем взимать US $2,99 стоимость доставкипо крайней мере.');
define('TEXT_LOGO_TITLE', 'БЕСПЛАТНАЯ ДОСТАВКА по всему');
define('TEXT_DEAR_FN','дорогой %s' . "\n\n");
define('TEXT_DEAR_CUSTOMER','Уважаемый клиент');

define('TEXT_AVAILABLE_IN715','Готовое Время: 7~15 Рабочих дней');
define('TEXT_AVAILABLE_IN57','Готовое Время: 3~5 Рабочих дней');
define('TEXT_PRICE_TITLE_SHOW', 'Самая льготная цена. Если запасов не хватает, то около 5-15 дней потребуется на подготовку. ');
define('TEXT_PRODUCTS_DAYS_FOR_PREPARATION_TIP', 'то около 5-15 дней потребуется на подготовку');

define('TEXT_NOTE_HOLIDAY_5','<p style="margin:0px; padding-top:5px;padding-right:20px;"><b>Сообщение  отпуска:</b><br/>
1 октября --наш национальный праздник. Наш праздник будет <b>с 1 октября по 4 октября (GMT + 8)</b>. В течение этого периода, наш офис закроет. Чтобы избежать задержки доставки пакетов, мыискренно советуем Вам заказать <b>до 29 сентября</b>. 
		<br/>Doreenbeads команды</p>');
define('TEXT_NOTE_HOLIDAY_6','<p style="margin:0px; padding-top:5px;padding-right:20px;"><b>Сообщение  отпуска:</b><br/>
Уважаемые клиенты, у нас национальный праздник <b>с октября 1-го по 4-й (октября GMT + 8)</b>. В течение этого периода, вы можете заказать новые заказы, как обычно. Мы организуем поставки, как только мы вернулись из отдыха на <b>5-й октября  (GMT + 8)</b>. И мы будем обрабатывать заказы в соответствии с правилом "первым пришел, первым вышел". Таким образом, мы искренно советуем, что вы лучше заказать как можно раньше.
		<br/>Doreenbeads команды</p>');

define('ENTRY_EMAIL_ADDRESS_REMOTE_CHECK_ERROR','Неверный электронной почты. Пожалуйста заполньте правильную электронную почту.');

define('SET_AS_DEFAULT_ADDRESS', 'установить основной адрес');
define('SET_AS_DEFAULT_ADDRESS_SUCCESS', 'Ваш Основной Адрес доставки обновил успешно.');

define('ALERT_EMAIL', 'Входите ваш адрес электронной почты. Спасибо!');
define('ENTER_PASSWORD_PROMPT' , 'Пожалуйста введите ваш пароль.');
define('TEXT_CONFIRM_PASSWORD', 'Не забудьте повторно ввести пароль!');
define('TEXT_CONFIRM_PASSWORD_PROMPT' , 'Пожалуйста, подтвердите ваш пароль.');
define('TEXT_ENTER_FIRESTNAME', 'Пожалуйста, введите ваше имя (не менее 1 символа).');
define('TEXT_ENTER_LASTNAME', 'Пожалуйста, введите вашу фамилию (не менее 1 символа).');
define('TEXT_EMAIL_NOTE','Обязательно заполните правильной электронной почте.');

define('TEXT_PROMOTION_DISCOUNT_NOTE','Стоимость товаров по нормальной цене в вашем заказе до {TOTAL}. Скидка {NEXT} на эти товары, если стоимость товаров по нормальной цене в вашем заказе до {REACH}.');

define('TEXT_SMALL_PACK','Малая упаковка');

define('TEXT_NDDBC_INFO_OUR_WEBSITE', 'Чтобы вернуться к нашему сайту,пожалуйста <a href="%s">нажимите здесь>></a>');
define('TEXT_NDDBC_INFO_PREVIOUS_PAGE', 'вернуться на предыдущую страницу <a href="%s">кликнуть здесь</a>');
define('TEXT_NDDBC_INFO','<p class="STYLE1">Уважаемый клиент,</p>
<p class="STYLE1">
Добро пожаловать в наш сайт. <br /><br />
В настоящее время на нашему сайте случилась маленькая ошибка. Когда вы посещаете наш сайт, он может привести вас к ненормальной странице.  <br />
Но, не волнуйтесь, ваша предыдущая информация на нашем сайте уже были хорошо сохранены.<br /><br />

<strong>%s</strong><br /><br />

Если вы всегда видите эту страницу, когда вы посещаете наш сайт. Напишите нам по почте: <a href="mailto:service_ru@doreenbeads.com">service_ru@doreenbeads.com</a><br />

Спасибо Вам за ваше доброе понимание! Извините за это неудобство.<br /><br />

С наилучшими пожеланиями<br />
Doreenbeads Команда
');

define('TEXT_LOG_OFF','Выход');
define('TEXT_TO_VIEW', 'Просмотреть &gt;&gt;');
define('TEXT_CUSTOM_NO','Таможенный номер');
define('ENTRY_TARIFF_REQUIRED_TEXT' , 'Пожалуйста, запишите свой номер таможни. Это помогает в таможенном оформлении.');
define('ENTRY_BACKUP_EMAIL_REQUESTED_TEXT' , 'Заполните,пожалуйста, свой постоянный адрес электронной почты, поэтому мы можем связаться с Вами вовремя.');
define('TEXT_EMAIL_HAS_SUBSCRIBED','Эта электронная почта уже регистрировала.');

define('TEXT_ENTER_BIRTHDAY_ERROR','Укажите действительную дату рождения.');
define('TEXT_BIRTHDAY_TIPS', 'Заполните дату своего рождения, чтобы получить специальный подарок в свой день рождения.');

define('ERROR_PRODUCT_PRODUCTS_BEEN_REMOVED','Добавить в Корзину Не удалось, этот продукт был удален из нашего инвентаря в это время.');
define('KEYWORD_FORMAT_STRING', 'Ключевые Слова');
define('TEXT_DEAR_CUSTOMER_NAME', 'Покупатель');

define('TEXT_CHANGED_YOUR_EMAIL_TITLE','Вы Изменили Свой Адрес Электронной Почты Счета Doreenbeads');
define('TEXT_HANDINGFEE_INFO','Due to the  labor cost increase, we add 0.99 USD handling fee on a few parcels. Only when an order\'s item amount is less than 9.99USD, the handling fee is needed.');
define('TEXT_CHANGED_YOUR_EMAIL_CONTENT','Уважаемый %s,<br/><br/>
Вы успешно изменили свой адрес электронной почты счета Doreenbeads.<br/><br/>

Ваш старый адрес электронной почты: %s<br/>
Ваш новый адрес электронной почты: %s<br/>
Обновленное время: %s<br/><br/>

Если вы не запрашивали это изменение, пожалуйста, <a href="mailto:service_ru@doreenbeads.com">свяжитесь с нами</a>. <br/><br/>

С уважением,<br/><br/>

Команда Doreenbeads');
define('TEXT_ENTER_BIRTHDAY_OVER_DATE','Дата рождения не может предшествовать сегодняшнему дню');
define('TEXT_SHIPPING_METHOD_DISPLAY_TIPS', 'Мы скрываем некоторые методы доставки, которые не часто используются, <a id="show_all_shipping">показать все способы доставок>></a>');

define('TEXT_BUYER_PROTECTION','Защита Покупателя');
define('TEXT_BUYER_PROTECTION_TIPS','<p>Полное воврат <span>(не получаете заказ)</span></p><p>Полное или частное воврат<span>(товар есть порок)</span></p>');
define('TEXT_FOOTER_ENTER_EMAIL_ADDRESS','Введите Ваша электроная почта здесь.');
define('TEXT_IMAGE','изображение');
define('TEXT_DELETE', 'Удалять');
define('TEXT_PRODUCTS_NAME', 'Название Товара');
define('TEXT_SHIPPING_RESTRICTION', 'Ограничение Способа Доставки');
define('TEXT_SHIPPING_RESTRICTION_TIP', 'Этот продукт запрещен транспортировать по некоторыми видами транспорта.');

define ( 'TEXT_PAYMENT_BANK_WESTERN_UNION', 'Наша информация Western Union ' );

define('PROMOTION_DISPLAY_AREA' , 'Продвижение');
define('TEXT_SUBMIT_SUCCESS', 'Представлен успешно!');
define('TEXT_API_LOGIN_CUSTOMER', 'Свяжите Существующую Учетную Запись .');
define('TEXT_API_REGISTE_NEW_ACCOUNT', 'Создайте Свою Учетную Запись doreenbeads и Подключитесь к %s.');
define('TEXT_API_BIND_ACCOUNT', 'Если у вас уже есть учетная запись Doreenbeads, вы можете связать свою учетную запись %s с данными учетной записи.');
define('TEXT_API_REGISTER_ACCOUNT', 'Если у вас нет учетной записи Doreenbeads, вы можете создать новую учетную запись и связать свою учетную запись %s с данными учетной записи.');

define('TEXT_PAID','оплачен');
define('TEXT_SHIPPING_INVOECE_COMMENTS', 'Доставки & Коммендарии');
define('TEXT_SHIPPING_RESTRICTION_IMPORTANT_NOTE', '<b>Важное примечание: </b><br/>Из-за ограничения доставки некоторые товары в вашем заказе могут отправляться отдельно авиапочтой, <a href="'.HTTP_SERVER.'/page.html?id=211" style="color:#008fed;" target="_blank">почему >></a>');

define('TEXT_DISCOUNT_PRODUCTS_MAX_NUMBER_TIPS', 'Эта дисконтированная цена ограничивается только %s пакетами, иначе - всё по первоначальной цене.');

define('TEXT_TWO_REWARD_COUPONS', 'Два купона на вознаграждение только для вас, 12 долларов могут быть сохранены');
define('TEXT_IN_ORDER_TO_THANKS_FOR_YOU', 'Чтобы поблагодарить вас за первый заказ с нами, мы отправили вам 2 купона на ваш счет. <a href="' . zen_href_link(FILENAME_MY_COUPON) . '" target="_blank">Просмотреть Мой Купон >></a>');
define('EMAIL_ORDER_TRACK_REMIND_NEW','Проверите,пожалуйста,есть ли неправильная информация.Если вы хотите исправить адрес доставки,напишите нам,пожалуйста: <a href="mailto:service_ru@doreenbeads.com">service_ru@doreenbeads.com</a>, прежде чем мы отправим вам посылку.');
define('TEXT_HOPE_TO_DO_MORE_KIND_BUSINESS','Надеюсь будушее сотрудличество.Приятного дня~~<br/><br/>
С уважением,<br/><br/>
Полк Doreenbeads.');
define('BOTTOM_VIP_POLICY','Смотреть <a style="color:#0786CB;text-decoration: underline;" href="' . zen_href_link(FILENAME_HELP_CENTER,'&id=65') . '" >Политика скидок</a>');
define('IMAGE_NEW_CATEGORY', 'Новая категория');
define('TEXT_COUPON_CODE','Код Купона');
define('TEXT_COUPON_PAR_VALUE','Наминал Купона');
define('TEXT_COUPON_MIN_ORDER','Минимальная стоимость товаров');
define('TEXT_COUPON_DEADLINE','Крайний Срок (GMT+8)');
define('TEXT_DISPATCH_FROM_WAREHOUSE', 'Отправка из склада');
define('TEXT_ALL', 'Всё');
define ('TEXT_DATE_ADDED', 'Дата Добавления');
define('TEXT_FILTER_BY', 'Выбрать по');
define('TEXT_REGULAR_PACK','нормальная упаковка');
define('TEXT_SMALL_PACK','Малая упаковка');
define('TEXT_VIEW_ONLY_SALE_ITEMS', 'Показать Только Товары Продажи');
define('TEXT_EMAIL_REG_TIP', 'Неправильный адрес электронной почты, пожалуйста, укажите правильный адрес электронной почты.');
define('TEXT_DELETE', 'Удалить');
define('TEXT_NO_UNREAD_MESSAGE', 'Нет непрочитанного сообщения.');
define('TEXT_SETTING', 'Установка');
define('TEXT_SEE_ALL_MESSAGES', 'Просмотр Все Сообщений');
define('TEXT_TITLE', 'Заголовок');
define('TEXT_MESSAGE', 'Сообщений');
define('TEXT_MY_MESSAGE', 'Мои Сообщений');
define('TEXT_MESSAGE_SETTING', 'Установка Сообщений');
define('TEXT_ALL_MARKED_AS_READ', 'Все отмеченные как Чтение');
define('TEXT_DELETE_ALL', 'Удалить все');
define('TEXT_UNREAD_MESSAGE', 'Непрочитанные сообщений');
define('TEXT_MARKED_AS_READ', 'Чтение');
define('TEXT_RECEIVE_ALL_MESSAGES', 'Получить все Сообщений');
define('TEXT_RECEIVE_THE_SPECIFIED', 'Получить указанный тип сообщения');
define('TEXT_REJECT_ALL_MESSAGES', 'Отклонить все сообщений');
define('TEXT_PLEASE_CHOOSE_AT_LEAST_MESSAGE', 'Пожалуйста, выберите хотя бы один тип сообщения.');
define('TEXT_YOU_WILL_NO_LONGER_MESSAGE', 'Вы больше не будете получать все наши сообщения, вы уверены?');
define('TEXT_ON_SALE', 'Продвижение');
define('TEXT_IN_STOCK', 'В наличии');
define('BY_CREATING_AGREEN_TO_TEAMS_AND_CONDITIONS', 'By creating an account, you agree to Doreenbeads.com’s  <a href="https://www.doreenbeads.com/page.html?id=157" target="_blank">Terms and Conditions</a>.');
define('TEXT_SHIPPING_FROM_USA', 'Ship From USA');
define('TEXT_CHECK_URL','Введенный вами контент содержит нелегальные ссылки. Пожалуйста, исправьте это.');
?>