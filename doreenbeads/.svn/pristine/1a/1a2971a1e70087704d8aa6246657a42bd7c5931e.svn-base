<?php
define ( 'OFFICE_FROM', '<strong>から：</strong>' );
define ( 'OFFICE_EMAIL', '<strong>メール：</strong>' );

define ( 'OFFICE_SENT_TO', '<strong>：に送られました</strong>' );
define ( 'OFFICE_EMAIL_TO', '<strong>メールに：</strong>' );

define ( 'OFFICE_USE', '<strong>オフィスでの使用のみ：</strong>' );
define ( 'OFFICE_LOGIN_NAME', '<strong>ログイン名：</strong>' );
define ( 'OFFICE_LOGIN_EMAIL', '<strong>メールログイン：</strong>' );
define ( 'OFFICE_LOGIN_PHONE', '<strong>電話：</strong>' );
define ( 'OFFICE_IP_ADDRESS', '<strong>IPアドレス：</strong>' );
define ( 'OFFICE_HOST_ADDRESS', '<strong>ホストアドレス：</strong>' );
define ( 'OFFICE_DATE_TIME', '<strong>日時：</strong>' );
// define('OFFICE_IP_TO_HOST_ADDRESS', 'OFF');
$emai_array = explode ( ",", EMAIL_ARRAY );
$send_to_email = $emai_array [( int ) $_SESSION ['languages_id'] - 1];
if ($send_to_email == "") {
	$send_to_email = $emai_array [0];
}
// email disclaimer
define ( 'EMAIL_DISCLAIMER', 'このメールアドレスは、あなたによってまたは他のお客様によって私達に与えられました。誤ってこのメールを受け取ったことを感じた場合は、<a href="mailto:' . $send_to_email . '">' . $send_to_email . '</a>にメールを送ってください。 ' );
define ( 'EMAIL_SPAM_DISCLAIMER', 'このメールは、2004年1月1日の米国CAN-SPAM法に基づき送信されます。このアドレスに除去要求を送信することができます。ご要望は尊重されます。' );
define ( 'EMAIL_FOOTER_COPYRIGHT', 'Copyright (c) ' . date ( 'Y' ) . ' <a href="http://www.zen-cart.com" target="_blank">Zen Cart</a>.  <a href="http://www.zen-cart.com" target="_blank">Zen Cart</a>によって供給されます' );
// email advisory for all emails customer generate - tell-a-friend and GV send
define ( 'EMAIL_ADVISORY', '-----' . "\n" . '<strong>IMPORTANT:</strong> 情報保護または不正な使用を防止するために、本ウェブサイトを経由して送信されるメールは、ログに記録され、内容が記録され、店のオーナーにご利用いただけます。誤ってこのメールを受け取ったことを感じた場合は、' . STORE_OWNER_EMAIL_ADDRESS . "にメールを送ってください\n\n" );

// email advisory included warning for all emails customer generate - tell-a-friend and GV send
define ( 'EMAIL_ADVISORY_INCLUDED_WARNING', '<strong>このメッセージは、このサイトから送信されたすべての電子メールを含まれています：</strong>' );
define('TEXT_EMAIL_NEWSLETTER', '');

// Admin additional email subjects
define ( 'SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO_SUBJECT', '[アカウントを作成する]' );
define ( 'SEND_EXTRA_TELL_A_FRIEND_EMAILS_TO_SUBJECT', '[友達にお薦め]' );
define ( 'SEND_EXTRA_GV_CUSTOMER_EMAILS_TO_SUBJECT', '[GVカスタマーに送ります]' );
define ( 'SEND_EXTRA_NEW_ORDERS_EMAILS_TO_SUBJECT', '[新規注文]' );
define ( 'SEND_EXTRA_CC_EMAILS_TO_SUBJECT', '[余分なCCオーダー情報] #' );

// Low Stock Emails
define ( 'EMAIL_TEXT_SUBJECT_LOWSTOCK', '警告：在庫不足' );
define ( 'SEND_EXTRA_LOW_STOCK_EMAIL_TITLE', '在庫不足のレポート： ' );

// for when gethost is off
define ( 'OFFICE_IP_TO_HOST_ADDRESS', '無効になって' );
// by zjl--begin
define ( 'TEXT_EMAIL_SUBJECT', 'おめでとうございます、あなたのVIPレベルと割引がアップグレードされています！' );
define ( 'TEXT_EMAIL_WORDS', '親愛なる [%名%] [%苗字%],

ご注文誠にありがとうございました。取引関係を持っていることは本当に満足していただきありがとうございます。

これまで、当社のウェブサイト上で、以前の購入のすべてが $[%合計金額%]ドルになりました. おめでとうございます、あなたのVIPレベルは以前の購入に基づき[[%VIPレベル%]] あなたのVIPレベルは以前の購入に基づきと[[%組み合わせ割引%]]VIP割引 にアップグレードされました。当社のウェブサイトを通して最新のビーズとジュエリーメイキング用品[[%Server%]/products_new.html] の[[%組み合わせ割引%]] 割引と 今週のスペシャル[[%Server%]/specials.html] を楽しむことができます。 [%Server%]
(ご注意ください：VIP割引とRCD割引を組み合わせて使用することが許可されています。)

現在のVIPレベルについては当社のウェブサイト上でアカウントにログインして詳細な情報があります。
以下のチャートに次のレベルと割引をチェックしてお気軽にご覧下さい。

ウェブサイト上のVIPポリシーに関する詳細については、このリンクをチェックしてください：
[%VIPページ%]

拝啓
Hong (Lisa) &8season Team' );
define ( 'TEXT_EMAIL_WORDS_1', '親愛なる [%名%] [%苗字%],

ご注文誠にありがとうございました。取引関係を持っていることは本当に満足していただきありがとうございます。

これまで、当社のウェブサイト上で、以前の購入のすべてが $[%合計金額%]ドルになりました. おめでとうございます、あなたのVIPレベルは以前の購入に基づき[[%VIPレベル%]] あなたのVIPレベルは以前の購入に基づきと[[%組み合わせ割引%]]VIP割引 にアップグレードされました。当社のウェブサイトを通して最新のビーズとジュエリーメイキング用品[[%Server%]/products_new.html] の[[%組み合わせ割引%]] 割引と 今週のスペシャル[[%Server%]/specials.html] を楽しむことができます。 [%Server%]

現在のVIPレベルについては当社のウェブサイト上でアカウントにログインして詳細な情報があります。
以下のチャートに次のレベルと割引をチェックしてお気軽にご覧下さい。

ウェブサイト上のVIPポリシーに関する詳細については、このリンクをチェックしてください：
[%VIPページ%]

拝啓
Hong (Lisa) &8season Team' );
define ( 'TEXT_EMAIL_HTML', '<br />Dear [%First Name%] [%Last Name%], <br /><br />
				ご注文誠にありがとうございました。取引関係を持っていることは本当に満足していただきありがとうございます。 <br /><br />

				これまで、当社のウェブサイト上で、以前の購入のすべてが $[%合計金額%]ドルになりました.  おめでとうございます！ あなたのVIPレベルは以前の購入に基づき <b>[%VIPレベル%]</b>VIPと <b>[%組み合わせ割引%]</b> VIP割引 にアップグレードされました。
				<br />当社のウェブサイト<a href="[%Server%]" target="_blank">[%Server%]</a>を通して <a href="[%Server%]/products_new.html" target="_blank">最新のビーズとジュエリーメイキング用品</a>の<b>[%組み合わせ割引%]</b>割引と<a href="[%Server%]/specials.html" target="_blank">今週のスペシャル</a> を楽しむことができます。<br />
				(ご注意ください： VIP割引とRCD割引を組み合わせて使用することが許可されています。)<br /><br />

				現在のVIPレベルについては当社のウェブサイト上でアカウントにログインして詳細な情報があります。 <br /><br />

				<b>以下のチャートに次のレベルと割引をチェックしてお気軽にご覧下さい。</b><br /><br />
				<table bordercolor="#69006E" border="1" width="486">
			            <tr>
			                <td width="187" bordercolor="#999999" bgcolor="#00FFFF">
			       		  <div align="center">Cumulative purchase</div>				</td>
			                <td width="100" bordercolor="#999999" bgcolor="#00FFFF">
			       		  <div align="center">Member Level</div>				</td>
			                <td width="77" bordercolor="#999999" bgcolor="#00FFFF">
			       		  <div align="center">VIP <br />Discount</div>				</td>
			                <td width="94" bordercolor="#999999" bgcolor="#00FFFF">
			           	  <div align="center">Combination Discount</div>				</td>
			            </tr>
			            <tr height="24">
			                <td bordercolor="#999999" align="right">
			              First order</td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;Normal</td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;$5.01               </td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;&nbsp;               </td>
			            </tr>
			      <tr bgcolor="#F0F0F0">
			          <td height="23" bordercolor="#999999" align="right">
			          US $100-US $200
			          <div align="right"></div></td>
			          <td bordercolor="#999999" align="center">&nbsp;Steel </td>
			          <td bordercolor="#999999" align="center">2%</td>
			          <td bordercolor="#999999" align="center">4.94%</td>
			      </tr>
			            <tr>
			                <td height="23" bordercolor="#999999" align="right">
			                US $200-US $500                </td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;Bronze              </td>
			                <td bordercolor="#999999" align="center">
			                3%                </td>
			                <td bordercolor="#999999" align="center">
			                5.91%                </td>
			            </tr>
			            <tr bgcolor="#F0F0F0">
			                <td height="23" bordercolor="#999999" align="right">
			                US $500-US $800                </td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;Silver              </td>
			                <td bordercolor="#999999" align="center">
			                4%                </td>
			                <td bordercolor="#999999" align="center">
			                6.88%                </td>
			            </tr>
			            <tr>
			                <td height="23" bordercolor="#999999" align="right">
			                US $800-US $1000</td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;Gold              </td>
			                <td bordercolor="#999999" align="center">
			                5%                </td>
			                <td bordercolor="#999999" align="center">
			                7.85%                </td>
			            </tr>
			            <tr bgcolor="#F0F0F0">
			                <td height="23" bordercolor="#999999" align="right">
			                US $1000-US $3000                </td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;Platinum              </td>
			                <td bordercolor="#999999" align="center">
			                6%                </td>
			                <td bordercolor="#999999" align="center">
			                8.82%                </td>
			            </tr>
			            <tr>
			                <td height="23" bordercolor="#999999" align="right">
			                US $3000-US $5000                </td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;Diamond              </td>
			                <td bordercolor="#999999" align="center">
			                7%                </td>
			                <td bordercolor="#999999" align="center">
			                9.79%                </td>
			            </tr>
			            <tr>
			                <td height="23" bordercolor="#999999" align="right">
			                US $5000-US $8000                </td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;Advanced 1              </td>
			                <td bordercolor="#999999" align="center">
			                8%                </td>
			                <td bordercolor="#999999" align="center">
			                10.76%                </td>
			            </tr>
			            <tr bgcolor="#F0F0F0">
			                <td height="23" bordercolor="#999999" align="right">
			                US $8000-US $10000                </td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;Advanced 2              </td>
			                <td bordercolor="#999999" align="center">
			                9%                </td>
			                <td bordercolor="#999999" align="center">
			                11.73%                </td>
			            </tr>
			            <tr>
			                <td height="23" bordercolor="#999999" align="right">
			                US $10000-US $15000                </td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;Advanced 3              </td>
			                <td bordercolor="#999999" align="center">
			                10%                </td>
			                <td bordercolor="#999999" align="center">
			                12.70%                </td>
			            </tr>
			            <tr bgcolor="#F0F0F0">
			                <td height="23" bordercolor="#999999" align="right">
			                US $15000-US $20000                </td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;Super 1              </td>
			                <td bordercolor="#999999" align="center">
			                13%                </td>
			                <td bordercolor="#999999" align="center">
			                15.61%                </td>
			            </tr>
			            <tr>
			                <td height="23" bordercolor="#999999" align="right">
			                US $20000-US $50000                </td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;Super 2              </td>
			                <td bordercolor="#999999" align="center">
			                15%                </td>
			                <td bordercolor="#999999" align="center">
			                17.55%                </td>
			            </tr>
			            <tr bgcolor="#F0F0F0">
			                <td height="23" bordercolor="#999999" align="right">
			                US $50000 or above                </td>
			                <td bordercolor="#999999" align="center">
			                &nbsp;Super 3              </td>
			                <td bordercolor="#999999" align="center">
			                20%                </td>
			                <td bordercolor="#999999" align="center">
			                22.40%                </td>
			            </tr>
						<tr>
			                <td bordercolor="#999999" colspan="4" align="left" height="20">
			                <p><font color="#0000ff" face="Arial"><strong>ご注意ください</strong>: 割引は送料を含まれなくて商品だけに使用されますnbsp;<br>
			                <strong>組み合わせ割引</strong>: はVIPの割引の合計割引率とRCDクーポン割引で蓄積されました。(チェックアウト時RCDのクーポンコードを入力してこのスーパーの割引を楽しめます。)</font></p>
			                </td>
			            </tr>
			</table>
				<br />
				ご都合の良い時にウェブサイト上で詳細なVIPの情報をチェックしてください。<br />
				<a href="[%VIP Page%]" target="_blank">[%VIP ページ%]</a><br /><br />
				敬具<br />
				Hong (Lisa) と 8season Team' );


define('VIP_EMAIL_HEADER', '<br/>Dear <b>[%First Name%] [%Last Name%]</b>, <br /><br />
				Thanks for all of your great business with 8seasons.com!<br/>
				Up to now, all of your previous purchases on our website reach to US $[%Total Amount%].<br/>
  				Congratulations! Your VIP level has been upgraded to <b>[%VIP Level%]</b> along with <b>[%Conbined Discount%]</b> VIP discount.
				<br />Please go ahead! You can start to enjoy this <b>[%Conbined Discount%]</b> discount on <a href="[%Server%]/new-jewelry-wholesale/normal.html" target="_blank">New Arrival</a>
  				 and <a href="[%Server%]" target="_blank">every item on 8seasons.com</a>.<br /><br />
				<font color="#BE0A2B">(Kindly note: Your VIP discount is allowed to combine with RCD discount for the Combination Discount)</font><br /><br />
				Regarding to your current VIP level, you could login <a href="[%Server%]/index.php?main_page=myaccount">"My Account"</a> on our website for the detailed information. <br /><br />
				<b>Please feel free to check out the chart below for your next VIP level and discount.</b><br/><br/>
  				<table bordercolor="#69006E" border="1" width="500">
  					<tr>
			                <td width="187" bordercolor="#999999" bgcolor="#00FFFF">
			       		  <div align="center">Cumulative purchase</div>				</td>
			                <td width="100" bordercolor="#999999" bgcolor="#00FFFF">
			       		  <div align="center">Member Level</div>				</td>
			                <td width="77" bordercolor="#999999" bgcolor="#00FFFF">
			       		  <div align="center">VIP <br />Discount</div>				</td>
			                <td width="94" bordercolor="#999999" bgcolor="#00FFFF">
			           	  <div align="center">Combination Discount</div>				</td>
			            </tr>');
define('VIP_EMAIL_HEADER_1', '<br/>Dear <b>[%First Name%] [%Last Name%]</b>, <br /><br />
				Thanks for all of your great business with 8seasons.com!<br/>
				Up to now, all of your previous purchases on our website reach to US $[%Total Amount%].<br/>
  				Congratulations! Your VIP level has been upgraded to <b>[%VIP Level%]</b> along with <b>[%Conbined Discount%]</b> VIP discount.
				<br />Please go ahead! You can start to enjoy this <b>[%Conbined Discount%]</b> discount on <a href="[%Server%]/new-jewelry-wholesale/normal.html" target="_blank">New Arrival</a>
  				 and <a href="[%Server%]" target="_blank">every item on 8seasons.com</a>.<br />
				<br />
				Regarding to your current VIP level, you could login <a href="[%Server%]/index.php?main_page=myaccount">"My Account"</a> on our website for the detailed information. <br /><br />
				<b>Please feel free to check out the chart below for your next VIP level and discount.</b><br/><br/>
  				<table bordercolor="#69006E" border="1" width="500">
  					<tr>
			                <td width="187" bordercolor="#999999" bgcolor="#00FFFF">
			       		  <div align="center">Cumulative purchase</div>				</td>
			                <td width="100" bordercolor="#999999" bgcolor="#00FFFF">
			       		  <div align="center">Member Level</div>				</td>
			                <td width="77" bordercolor="#999999" bgcolor="#00FFFF">
			       		  <div align="center">VIP <br />Discount</div>				</td>
			            </tr>');
define('VIP_EMAIL_FOOTER', '<tr>
			                <td bordercolor="#999999" colspan="4" align="left" height="20">
			                <p><font color="#0000ff" face="Arial"><strong>Kindly Note</strong>: the discount is only for goods value not including postage.<br>
			                <strong>Combination Discount</strong>:  is the total discount rate of our VIP discount with RCD Coupon Discount (simply follow the steps at checkout procedure to enjoy this super discount).</font></p>
			                </td>
			            </tr>
				</table>
				<br />
				You may have a check here for detailed VIP information on our website at your convenience.<br />
				<a href="[%VIP Page%]" target="_blank">[%VIP Page%]</a><br /><br />
				Sincerely yours, <br />
				Hong (Lisa) & 8season Team');
define('VIP_EMAIL_FOOTER_1', '<tr>
			                <td bordercolor="#999999" colspan="4" align="left" height="20">
			                <p><font color="#0000ff" face="Arial"><strong>Kindly Note</strong>: the discount is only for goods value not including postage.</p>
			                </td>
			            </tr>
				</table>
				<br />
				You may have a check here for detailed VIP information on our website at your convenience.<br />
				<a href="[%VIP Page%]" target="_blank">[%VIP Page%]</a><br /><br />
				Sincerely yours, <br />
				Hong (Lisa) & 8season Team');

define('TEXT_CURRENT_LEVEL', '<br/>(Your Level)');
?>