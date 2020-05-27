<?php
define('NAVBAR_TITLE_1', 'Мой Счёт');
define('NAVBAR_TITLE_2', 'Пошлина За Обработку');
define('TEXT_PACKING_SLIP' , 'Пошлина За Обработку');
define('PRODUCTS_NO_ALT','Быстро добавлять товары');
define('TABLE_HEADING_ORDER_NUMBER', '№');
define('TABLE_HEADING_TACKING_NUMBER', 'Трек номер');
define('TABLE_HEADING_DATE', 'Дата');
define('HEADING_ITEM', 'товар');
define('TEXT_BOUNGHT_QUANTITY', 'Количество Купленных');
define('TEXT_SENT_QUANTITY', 'Количество Отправляемых');
define('TEXT_UNSENT_QUANTITY', 'Количество Не Отправляемых');
define('TEXT_NO_RESULT_PACKING_SLIP', 'Нет результатов!Измените, Пожалуйста,свою информацию. ');

define('TEXT_DOWNLOAD_PACKINGLIST_INFO', '<span style="font-family:verdana;font-size:12px;">Скачать <a href="' . HTTP_SERVER . $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'] . '&export=true' . '" style="text-decoration:underline">Лист для Упаковки</a> (.xlsx) здесь.</span>');
define('TEXT_PACKAGE_SLIP_TIP_1', 'Вы можете выполнить поиск упаковочного листа.Заполните пожалуйста,необходимую информацию и нажмите кнопку «представлять».<br/>(Примечание:Из-за системной функции можно искать только упаковочный лист после 3-ого мая 2017 г.)');
define('TEXT_PACKAGE_SLIP_TIP_2', 'Если вам нужны детали неоплаченных товаров, <a class="link_text" href="' . zen_href_link(FILENAME_ACCOUNT) . '">нажмите здесь,</a> пожалуйста,чтобы найти нужный заказ в списке заказов и просмотреть на странице подробностей заказа.');
?>