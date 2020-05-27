<br/>
<?php
////paypal_offline_robbie_wei
if ($ls_payment_module == 'paypalmanually'){
	global $db;
	$total_sql = "Select text from " . TABLE_ORDERS_TOTAL .
				 " Where orders_id = '" . $zv_orders_id . "' and class = 'ot_total'";
	$order_total = $db->Execute($total_sql);

	$ot_total_text = $order_total->fields['text'];

	$ship = "Select shipping_method from " . TABLE_ORDERS .
				 " Where orders_id = '" . $zv_orders_id . "'";
	$ship = $db->Execute($ship);

	$ship_method = $ship->fields['shipping_method'];
?>
<div id="congratulation" style="background-color:#CCCCFF;font:12px"><strong>おめでとうございます！</strong></div>
<p class="importnat">ご注文は当社のバックエンドシステムで生成され、リストされてきました。
 また、このページの右上にある &quot;私のアカウント&quot;へ注文の詳細を確認することができます。
  <br />
 また、ご登録したメールアドレスに注文明細を記載したメールを送りました。<br />
  <br />
</p>
<div id="orderinformation" style="background-color:#CCCCFF;font:12px"><strong>ご注文：総額＆配送方法 </strong></div>
<p>この注文の合計金額：<strong><font color="red"><?php echo $ot_total_text; ?></font></strong><br />
	この注文の出荷方法：<strong><font color="red"><?php echo $ship_method; ?></font></strong><br />
	今、手動でPayPalを使って私たちに支払いを送信する必要があります。 <br /><br />
</p>
<div id="payment" style="background-color:#CCCCFF;font:12px"><strong>ペイパルマニュアルによるお支払いの説明</strong></div>
<p class="importnat">
	<font color="red"><strong>まず</strong></font>、 <a href="http://www.paypal.com" target="_blank" color><font color="Green">www.paypal.com</font></a>でPayPalアカウントにログインします。アカウントページのボタン
	 <img src="/images/offline/send_money.bmp" alt="Send Money" width="77.5" height="18" />
	をクリックします。<br /><br />
	 <img src="/images/offline/send_money_main.bmp" alt="Paypal Main Page"
			width="387.9" height="172.8" /></p>
	 <br /><p class="importnat"> <font color="red"><strong>第二に</strong></font>、今、&quot;お金を送る&quot; ページに来ます。
	先の（e-mail）ボックスに <strong>service_jp@8seasons.com</strong> (ご注意：supplies@8season<font color="red">s</font>.comではありません) を入れて、あなたの合計金額を記入してください。
	&quot;お金を送る&quot;フレームに  &quot;グッズ&quot; オプションを選択してください。 それから &quot;続ける&quot; をヒットして次のページへ。<br /><br />
  <img src="/images/offline/send_money_content.bmp" alt="Paypal-Send Money Page" width="299.7"
  	height="421.2" /><br />
  <br /><font color="red"><strong>第三に</strong></font>、この新しいページでは「受信者にメールする」オプションまで画面を下にスクロールしてください。件名ボックスに注文番号及び我々のウェブサイトを入力します (下記のように情報を入力します： 注文番号--の支払い　 8seasons.com )。 最後に &quot;お金を送る&quot; ボタンをクリックして、お支払いを完了します。 <br /><br />
  <img src="/images/offline/send_money_email.bmp" alt="Paypal-Email Content"
  	width="565.2" height="238.5" />
  </p>
  <br /><p class="importnat"><font color="red"><strong>最終的に</strong></font>、 首尾よく確認した後、できる限り早く主題情報をタイトルとしたのメールで我々を通知してください。
  (メールアドレス： <strong><a href="mailto:service_jp@8seasons.com">service_jp@8seasons.com</a> (ご注意： supplies@8season<font color="red">s</font>.comではありません)</strong>).
  そこで、我々の財務担当者が請求書を確認した後、速やかに小包の出荷準備ができます。
  <br /><p class="importnat">
  		<strong>まだいくつかの問題点がございましたら、気兼ねなくservice_jp@8seasons.comでお問い合わせください。 喜んでお手伝いさせていただきます。  </strong><br /><br />
</p>
<!--
end
-->
<?php
}
else
{
?>
<p><strong>Checkout Success Sample Text?...</strong></p><p>A few words about the approximate shipping time or your processing policy would be put here. </p>
<p>This section of text is from the Define Pages Editor located under Tools in the Admin.</p>
<?php
}
?>