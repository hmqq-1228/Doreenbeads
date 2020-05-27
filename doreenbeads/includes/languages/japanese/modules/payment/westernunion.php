<?php
define ( 'MODULE_PAYMENT_WESTERNUNION_TEXT_RECEIVER', '受取人' );
define ( 'MODULE_PAYMENT_WESTERNUNION_TEXT_SENDER', '差出人 ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_ENTRY_MCTN', 'MTCN： ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_ENTRY_AMOUNT', '金額： ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_ENTRY_CURRENCY', '通貨： ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_ENTRY_FIRST_NAME', '名前： ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_ENTRY_LAST_NAME', '苗字： ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_ENTRY_ADDRESS', 'アドレス： ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_ENTRY_ZIP', '郵便番号： ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_ENTRY_CITY', '都市： ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_ENTRY_COUNTRY', '國籍： ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_ENTRY_PHONE', '電話番号： ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_ENTRY_QUESTION', '質問： ' );
define ( 'MODULE_PAYMENT_WESTERNUNION_ENTRY_ANSWER', '回答： ' );

define ( 'MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME', '' );
define ( 'MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME', '' );
define ( 'MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS', '' );
define ( 'MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP', '' );
define ( 'MODULE_PAYMENT_WESTERNUNION_RECEIVER_CITY', '' );
define ( 'MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY', '' );
define ( 'MODULE_PAYMENT_WESTERNUNION_RECEIVER_PHONE', '' );

define ( 'MODULE_PAYMENT_WESTERNUNION_TEXT_HEAD', '<strong>ウエスタンユニオン国際送金</strong>' );
define ( 'MODULE_PAYMENT_WESTERNUNION_TEXT_DISCOUNT', '&nbsp;(合計金額が2000ドルに到達した場合、2%の割引が提供されます。支払人は 手数料 <br />を負担します。 <a href="' . HTTP_SERVER . '/page.html?id=146" target="_blank">詳細はこちら >></a>)' );
// efine('MODULE_PAYMENT_WESTERNUNION_TEXT_END','<br /><div style="clear:both; padding-bottom:10px;"><span style="color:#F47504"><strong>Be sure read this important note before continue checkout.</strong></span> <a href="http://www.dreams-crafts.net/page.html?chapter=0&id=95" target="_blank">Click here>></a></div>');

define ( 'MODULE_PAYMENT_WESTERNUNION_TEXT_DESCRIPTION', '<table cellpadding="0" cellspacing="0">
                    	<tr>
                        	<th width="105"><strong>' . MODULE_PAYMENT_WESTERNUNION_ENTRY_FIRST_NAME . '</strong></th><td>' . MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME . '</td>
                        </tr>
                        <tr>
                        	<th><strong>' . MODULE_PAYMENT_WESTERNUNION_ENTRY_LAST_NAME . '</strong></th> <td>' . MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME . '</td>
                        </tr>
                        <tr>
                        	<th><strong>' . MODULE_PAYMENT_WESTERNUNION_ENTRY_ADDRESS . '</strong></th><td>' . MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS . '</td>
                        </tr>
                        <tr>
                        	<th><strong>' . MODULE_PAYMENT_WESTERNUNION_ENTRY_ZIP . '</strong></th><td>' . MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP . '</td>
                        </tr>
                        <tr>
                        	<th><strong>' . MODULE_PAYMENT_WESTERNUNION_ENTRY_CITY . '</strong></th><td>' . MODULE_PAYMENT_WESTERNUNION_RECEIVER_CITY . '</td>
                        </tr>
                        <tr>
                        	<th><strong>' . MODULE_PAYMENT_WESTERNUNION_ENTRY_COUNTRY . '</strong></th> <td>' . MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY . '</td>
                        </tr>
                        <tr>
                        	<th><strong>' . MODULE_PAYMENT_WESTERNUNION_ENTRY_PHONE . '</strong></th> <td>' . MODULE_PAYMENT_WESTERNUNION_RECEIVER_PHONE . '</td>
                        </tr>
                    </table> ' );

define ( 'MODULE_PAYMENT_WESTERNUNION_TEXT_EMAIL_FOOTER', "送金へ<br />" . MODULE_PAYMENT_WESTERNUNION_ENTRY_FIRST_NAME . MODULE_PAYMENT_WESTERNUNION_RECEIVER_FIRST_NAME . '<br />' . MODULE_PAYMENT_WESTERNUNION_ENTRY_LAST_NAME . MODULE_PAYMENT_WESTERNUNION_RECEIVER_LAST_NAME . '<br />' . MODULE_PAYMENT_WESTERNUNION_ENTRY_ADDRESS . MODULE_PAYMENT_WESTERNUNION_RECEIVER_ADDRESS . '<br />' . MODULE_PAYMENT_WESTERNUNION_ENTRY_ZIP . MODULE_PAYMENT_WESTERNUNION_RECEIVER_ZIP . '<br />' . MODULE_PAYMENT_WESTERNUNION_ENTRY_CITY . MODULE_PAYMENT_WESTERNUNION_RECEIVER_CITY . '<br />' . MODULE_PAYMENT_WESTERNUNION_ENTRY_COUNTRY . MODULE_PAYMENT_WESTERNUNION_RECEIVER_COUNTRY . '<br />' . MODULE_PAYMENT_WESTERNUNION_ENTRY_PHONE . MODULE_PAYMENT_WESTERNUNION_RECEIVER_PHONE . "<br /><br />" . "<b>送金した後、下記の情報と一緒に (<a href='mailto:service_jp@8seasons.com'><font style='color:#0000FF;'>service_jp@8seasons.com</font></a>)にメールしてください。</b><br /><br /><span style=" . "color:#FF0000;font-weight:bold;" . ">1.ご登録のメールアドレス、当社のウェブサイトの注文番号とご注文の合計金額<br /><br />2.10桁のウェスタンユニオンマネー即時振替管理番号。<br /><br />3.送った合計金額（通貨を含む）。<br /><br />4.ご情報： <ul><li>氏名（パスポートと同じ）</li><li>T中継都市。</li><li>完全なアドレス。</li><li>電話番号。</li></ul></span>  <span style='font-size:12px;font-weight:normal;padding-left:20px;'>(この情報は、ウェスタンユニオン送金フォームに記入したものと同じでなければなりません。)</span><br /><br />&nbsp;お支払いを受けたら、我々はご注文を処理し始めて、すぐに出荷します" );
?>
