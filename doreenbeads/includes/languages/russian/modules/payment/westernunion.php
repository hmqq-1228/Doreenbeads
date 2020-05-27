<?php
define ( 'MODULE_PAYMENT_WESTERNUNION_TEXT_RECEIVER', 'Получатель ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_TEXT_SENDER', 'Отправитель ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_ENTRY_MCTN', 'MTCN : ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_ENTRY_AMOUNT', 'Сумма : ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_ENTRY_CURRENCY', 'Валюта : ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_ENTRY_FIRST_NAME', 'Имя : ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_ENTRY_LAST_NAME', 'Фамилия : ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_ENTRY_ADDRESS', 'Адрес : ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_ENTRY_ZIP', 'Почтовый Индекс : ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_ENTRY_CITY', 'Город : ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_ENTRY_COUNTRY', 'Страна : ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_ENTRY_PHONE', 'Телефон : ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_ENTRY_QUESTION', 'Вопрос : ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_ENTRY_ANSWER', 'Ответ : ' );

define ( 'MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME', '' );
define ( 'MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME', '' );
define ( 'MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS', '' );
define ( 'MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP', '' );
define ( 'MODULE_PAYMENT_WESTERNUNION_RECEIVER_CITY', '' );
define ( 'MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY', '' );
define ( 'MODULE_PAYMENT_WESTERNUNION_RECEIVER_PHONE', '862163023611' );
define ( 'MODULE_PAYMENT_WESTERNUNION_TEXT_DISCOUNT', '&nbsp;(2% скидки будет предложено, если общая сумма достигает 2000 US$,<br/> комиссия должна быть оплачена плательщиком. <a href="' . HTTP_SERVER . '/page.html?id=124" target="_blank">Нажмите здесь для подробности >></a>)' );

define ( 'MODULE_PAYMENT_WESTERNUNION_TEXT_TITLE', '<strong>мгновенный денежный перевод Western Union</strong>' );

define ( 'MODULE_PAYMENT_WESTERNUNION_TEXT_DESCRIPTION', '<table cellpadding="0" cellspacing="0">
                    	<tr>
                        	<th width="105">Имя:</th>
                            <td>' . MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME . '</td>
                        </tr>
                        <tr>
                        	<th>Фамилия:</th>
                            <td>' . MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME . '</td>
                        </tr>
                        <tr>
                        	<th>Адрес:</th>
                            <td>' . MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS . '</td>
                        </tr>
                        <tr>
                        	<th>Почтовый Индекс:</th>
                            <td>' . MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP . '</td>
                        </tr>
                        <tr>
                        	<th>Город:</th>
                            <td>' . MODULE_PAYMENT_WESTERNUNION_RECEIVER_CITY . '</td>
                        </tr>
                        <tr>
                        	<th>Страна:</th>
                            <td>' . MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY . '</td>
                        </tr>
                        <tr>
                        	<th>Номер телефона:</th>
                            <td>' . MODULE_PAYMENT_WESTERNUNION_RECEIVER_PHONE . '</td>
                        </tr>
                    </table>' );

define ( 'MODULE_PAYMENT_WESTERNUNION_TEXT_EMAIL_FOOTER', "Сделать Мгновенный денежный перевод Western Union выписывать на имя:\n\n" . MODULE_PAYMENT_WESTERNUNION_ENTRY_FIRST_NAME . MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME . "\n" . MODULE_PAYMENT_WESTERNUNION_ENTRY_LAST_NAME . MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME . "\n" . MODULE_PAYMENT_WESTERNUNION_ENTRY_ADDRESS . MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS . "\n" . MODULE_PAYMENT_WESTERNUNION_ENTRY_ZIP . MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP . "\n" . MODULE_PAYMENT_WESTERNUNION_ENTRY_CITY . MODULE_PAYMENT_WESTERNUNION_RECEIVER_CITY . "\n" . MODULE_PAYMENT_WESTERNUNION_ENTRY_COUNTRY . MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY . "\n" . MODULE_PAYMENT_WESTERNUNION_ENTRY_PHONE . MODULE_PAYMENT_WESTERNUNION_RECEIVER_PHONE . "\n\n" . "<b>После того, как вы посылали деньги, напишите нам (<a href='mailto:service_ru@doreenbeads.com'><font style='color:#0000FF;'>service_ru@doreenbeads.com</font></a>) со следующей информацией:</b><br /><br /><span style=" . "color:#FF0000;font-weight:bold;" . ">1.Ваш зарегистрированный адрес электронной почты, заказ № на нашем сайте и общая сумма вашего заказа.<br /><br />2.10 цифров контрольного номера денежного перевода Western Union<br /><br />3.Общая сумма, которую вы послали нам (включая валюты)<br /><br />4.Ващи данные: <ul><li>Имя и Фамилия (так же, как ваш паспорт).</li><li>Город,из которого вы переводили деньги.</li><li>Полный адрес.</li><li>Номер телефона.</li></ul></span><span style='font-size:12px;font-weight:normal;padding-left:20px;'>(Эта информация должна быть такой же, как то, что вы заполнили на форме денежного перевода Western Union.)</span><br /><br /><strong>Как только мы получаем вашу оплату, мы начнём обрабатывать ваш заказ и отправить его сразу.</strong>" );
?>
