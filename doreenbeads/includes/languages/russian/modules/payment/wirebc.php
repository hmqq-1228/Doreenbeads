<?php
define ( 'MODULE_PAYMENT_WIREBC_TEXT_CONFIG_1_1', 'Включить модуль оплаты банковского перевода(Банк Китая)' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_CONFIG_1_2', 'Вы хотите принимать оплату банковского перевода?(Банк Китая)' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_CONFIG_2_1', 'Название Счёта:' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_CONFIG_2_2', 'Название Счёта Получателя' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_CONFIG_3_1', 'Номер Счёта:' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_CONFIG_3_2', 'Номер Счёта Получателя' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_CONFIG_4_1', 'Телефон Получателя:' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_CONFIG_4_2', 'Телефон Получателя' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_CONFIG_5_1', 'Название Банка:' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_CONFIG_5_2', 'Название Банка' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_CONFIG_6_1', 'Филиал Банка:' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_CONFIG_6_2', 'Филиал Банка' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_CONFIG_7_1', 'Swift Код:' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_CONFIG_7_2', 'Swift Код' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_CONFIG_8_1', 'Порядок сортировки дисплея.' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_CONFIG_8_2', 'Порядок сортировки дисплея. Самое низкое отображается первым.' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_CONFIG_9_1', 'Установить статус заказа' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_CONFIG_9_2', 'Установить статус заказов, сделанных с этой платежным модулем к этому значению' );
define ( 'MODULE_PAYMENT_WIREBC_NOTES', 'После того,как вы переводили деньги,пожалуйста,напищите нам по service_ru@doreenbeads.com со следующей информацией:<br/>1) ваше название входа,<br/>2) order#, <br/>3) и общая сумма,которую вы послали<br/>' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_TITLE_HEAD', '<strong>Банковский перевод (Банк Китая)</strong>' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_TITLE_DISCOUNT', '&nbsp;(2% скидки будет предложено, если общая сумма достигает 2000 US$,<br/> комиссия должна быть оплачена плательщиком.)' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_TITLE_END', '<br /><div style="clear:both; padding-bottom:10px;"><span style="color:#F47504"><strong>Прежде чем вы продолжаете оплатить, Обязательно прочтать эту важное примечание.</strong></span> <a href="' . HTTP_SERVER . '/page.html?chapter=0&id=95" target="_blank">Нажмите здесь>></a></div>' );

define ( 'MODULE_PAYMENT_WIREBC_TEXT_BENEFICIARY_BANK', 'Банк Получателя :' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_SWIFT_CODE', 'SWIFT Код :' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_HOLDER_NAME', 'Имя Владельца Банковского Счёта :' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_ACCOUNT_NUMBER', 'Номер Банковского Счёта :' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_BANK_ADDRESS', 'Адрес Банка :' );
define ( 'MODULE_PAYMENT_WIREBC_TEXT_HOLDER_PHONE', 'Номер Телефона Владельца Банковского Счёта :' );

define ( 'MODULE_PAYMENT_WIREBC_TEXT_DESCRIPTION', '<table cellpadding="0" cellspacing="0">
                    	<tr>
                        	<th width="135">Банк получателя:</th>
                            <td>' . MODULE_PAYMENT_WIREBC_BENEFICIARY_BANK . '</td>
                        </tr>
                        <tr>
                        	<th>SWIFT Код:</th>
                            <td>' . MODULE_PAYMENT_WIREBC_SWIFT_CODE . '</td>
                        </tr>
                        <tr>
                        	<th>Имя Владельца:</th>
                            <td>' . MODULE_PAYMENT_WIREBC_HOLDER_NAME . '</td>
                        </tr>
                    </table>
                    <div class="borderbt"></div>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                        	<th width="135">Номер Банковского Счёта:</th>
                            <td>' . MODULE_PAYMENT_WIREBC_ACCOUNT_NUMBER . '</td>
                        </tr>
                        <tr>
                        	<th>Адрес Банка:</th>
                            <td>' . MODULE_PAYMENT_WIREBC_BANK_ADDRESS . '</td>
                        </tr>
                        <tr>
                        	<th>Номер Телефона Владельца:</th>
                            <td>' . MODULE_PAYMENT_WIREBC_HOLDER_PHONE . '</td>
                        </tr>
                    </table>' );

define ( 'MODULE_PAYMENT_WIREBC_TEXT_EMAIL_FOOTER', MODULE_PAYMENT_WIREBC_TEXT_DESCRIPTION );

?>