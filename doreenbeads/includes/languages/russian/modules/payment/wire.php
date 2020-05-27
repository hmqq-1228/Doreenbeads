<?php
define ( 'MODULE_PAYMENT_WIRE_TEXT_CONFIG_1_1', 'Включить модуль оплаты банковского перевода' );
define ( 'MODULE_PAYMENT_WIRE_TEXT_CONFIG_1_2', 'Вы хотите принимать оплату банковского перевода?' );
define ( 'MODULE_PAYMENT_WIRE_TEXT_CONFIG_2_1', 'Название Счёта:' );
define ( 'MODULE_PAYMENT_WIRE_TEXT_CONFIG_2_2', 'Название Счёта Получателя' );
define ( 'MODULE_PAYMENT_WIRE_TEXT_CONFIG_3_1', 'Номер Счёта:' );
define ( 'MODULE_PAYMENT_WIRE_TEXT_CONFIG_3_2', 'Номер Счёта Получателя' );
define ( 'MODULE_PAYMENT_WIRE_TEXT_CONFIG_4_1', 'Телефон Получателя:' );
define ( 'MODULE_PAYMENT_WIRE_TEXT_CONFIG_4_2', 'Телефон Получателя' );
define ( 'MODULE_PAYMENT_WIRE_TEXT_CONFIG_5_1', 'Название Банка:' );
define ( 'MODULE_PAYMENT_WIRE_TEXT_CONFIG_5_2', 'Название Банка' );
define ( 'MODULE_PAYMENT_WIRE_TEXT_CONFIG_6_1', 'Филиал Банка:' );
define ( 'MODULE_PAYMENT_WIRE_TEXT_CONFIG_6_2', 'Филиал Банка' );
define ( 'MODULE_PAYMENT_WIRE_TEXT_CONFIG_7_1', 'Swift Код:' );
define ( 'MODULE_PAYMENT_WIRE_TEXT_CONFIG_7_2', 'Swift Код' );
define ( 'MODULE_PAYMENT_WIRE_TEXT_CONFIG_8_1', 'Порядок сортировки дисплея.' );
define ( 'MODULE_PAYMENT_WIRE_TEXT_CONFIG_8_2', 'Порядок сортировки дисплея. Самое низкое отображается первым .' );
define ( 'MODULE_PAYMENT_WIRE_TEXT_CONFIG_9_1', 'Установить статус заказа' );
define ( 'MODULE_PAYMENT_WIRE_TEXT_CONFIG_9_2', 'Установить статус заказов, сделанных с этой платёжным модулем к этому значению' );

define ( 'MODULE_PAYMENT_WIRE_TEXT_TITLE', '<strong>Банковский перевод (Citibank)</strong>' );

define ( 'MODULE_PAYMENT_WIRE_NOTES', 'После того,как вы переводили деньги,пожалуйста,напищите нам по service_ru@doreenbeads.com со следующей информацией:<br/>1) Ваше название входа,<br/>2) заказ#, <br/>3) и общая сумма,которую вы послали<br/>' );
define ( 'MODULE_PAYMENT_WIRE_TEXT_BENEFICIARY_BANK', 'БАНК ПОЛУЧАТЕЛЯ :' );
define ( 'MODULE_PAYMENT_WIRE_TEXT_SWIFT_CODE', 'SWIFT КОД :' );
define ( 'MODULE_PAYMENT_WIRE_TEXT_BANK_ADDRESS', 'АДРЕС БАНКА :' );
define ( 'MODULE_PAYMENT_WIRE_TEXT_BENEFICIARY', 'ПОЛУЧАТЕЛЬ :' );
define ( 'MODULE_PAYMENT_WIRE_TEXT_ACCOUNT_NO', 'НОМЕР СЧЁТА :' );
switch ($_SESSION['currency']){
    case 'USD':
        define('MODULE_PAYMENT_WIRE_ACCOUNT_NO_NEW', '1094167015<font style="color:grey">（If you transfer money from Hong Kong please use this account ：40941760）</font>');
        break;
    case 'EUR':
        define('MODULE_PAYMENT_WIRE_ACCOUNT_NO_NEW', '1094167023');
        break;
    case 'GBP':
        define('MODULE_PAYMENT_WIRE_ACCOUNT_NO_NEW', '1094167031');
        break;
    case 'JPY':
        define('MODULE_PAYMENT_WIRE_ACCOUNT_NO_NEW', '1094167058');
        break;
    case 'CAD':
        define('MODULE_PAYMENT_WIRE_ACCOUNT_NO_NEW', '1094167066');
        break;
    case 'AUD':
        define('MODULE_PAYMENT_WIRE_ACCOUNT_NO_NEW', '1094167074');
        break;
    default:
        define('MODULE_PAYMENT_WIRE_ACCOUNT_NO_NEW', '1094167015<font style="color:grey">（If you transfer money from Hong Kong please use this account ：40941760）</font>');
        break;
}
define ( 'MODULE_PAYMENT_WIRE_TEXT_DESCRIPTION', '<table cellpadding="0" cellspacing="0">
                    	<tr>
                        	<th width="135">Банк получателя:</th>
                            <td>' . MODULE_PAYMENT_WIRE_BENEFICIARY_BANK . '</td>
                        </tr>
                        <tr>
                        	<th>SWIFT Код:</th>
                            <td>' . MODULE_PAYMENT_WIRE_SWIFT_CODE . '</td>
                        </tr>
                        <tr>
                        	<th>Адрес Банка:</th>
                            <td>' . MODULE_PAYMENT_WIRE_BANK_ADDRESS . '</td>
                        </tr>
                    </table>
                    <div class="borderbt"></div>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                        	<th width="135">Номер Счёта:</th>
                            <td>' . MODULE_PAYMENT_WIRE_ACCOUNT_NO_NEW . '</td>
                        </tr>
                        <tr>
                        	<th>Получатель:</th>
                            <td>' . MODULE_PAYMENT_WIRE_BENEFICIARY . '</td>
                        </tr>  
                    </table>' );

define ( 'MODULE_PAYMENT_WIRE_TEXT_EMAIL_FOOTER', MODULE_PAYMENT_WIRE_TEXT_DESCRIPTION );
define ( 'MODULE_PAYMENT_WIRE_TEXT_TITLE_DISCOUNT', '&nbsp;(2% скидки будет предложено, если общая сумма достигает 2000 US$,<br/> комиссия должна быть оплачена плательщиком. )' );

?>
