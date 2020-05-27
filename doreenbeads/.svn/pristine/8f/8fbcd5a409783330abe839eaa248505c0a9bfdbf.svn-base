<p><br />
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
	<div style="background-color: rgb(204, 204, 255);" id="congratulation"><strong>おめでとうございます！</strong></div>
	<p class="importnat">ご注文は、当社のバックエンドシステムで生成され、リストされてきました。  また、このページの右上にある &quot;私のアカンウト&quot;へ注文の詳細を確認することができます。    <br />
	また、ご登録のメールアドレスに注文明細を記載したメールを送った。</p>
	<div style="background-color: rgb(204, 204, 255);" id="orderinformation"><strong>ご注文：総額&amp;配送方法 </strong></div>
	<p>注文番号<br />
	この注文の合計金額：<br />
	この注文の配送方法：<br />
	今、ペイパルマニュアルを使って、私たちに送金する必要があります。</p>
	<div style="background-color: rgb(204, 204, 255);" id="payment"><strong>ペイパルマニュアルによるお支払いの説明</strong></div>
	<p class="importnat"><font color="red"><strong>まず</strong></font>、 <a color="" target="_blank" href="http://www.paypal.com"><font color="Green">www.paypal.com</font></a>でPayPalアカウントにログインしてください。 アカウントページにボタン  <img width="77.5" height="18" alt="Send Money" src="/images/offline/send_money.bmp" />  をクリックします。<br />
	<br />
	<img width="387.9" height="172.8" alt="Paypal Main Page" src="/images/offline/send_money_main.bmp" /></p>
	<p>&nbsp;</p>
	<p class="importnat"><font color="red"><strong>第二に</strong></font>、これで、&quot;お金を送る&quot;ページに来ます。  	先の（e-mail）ボックスに <strong>service_jp@8seasons.com</strong> (ご注意：supplies@8season<font color="red">s</font>.com　ではありません) を入れて、お客様の合計金額を記入してください。 	  &quot;お金を送る&quot; フレームに  &quot;グッズ&quot;オプションを選択してください。　　それから、 &quot;続ける&quot;をヒットして、　次のページに進みます。<br />
	<br />
	<img alt="Paypal-Send Money Page" src="/images/offline/send_money_content.jpg" /><br />
	<br />
	<font color="red"><strong>第三に</strong></font>、 この新しいページでは「受信者にメールする」オプションまで画面を下にスクロールしてください。件名ボックスに注文番号及び我々のウェブサイトを入力します (下記のように情報を入力します： 注文番号--の支払い　 8seasons.com )。 最後に &quot;お金を送る&quot; ボタンをクリックして、お支払いを完了します。 <br />
	<br />
	<img alt="Paypal-Email Content" src="/images/offline/send_money_email.jpg" /></p>
	<p>&nbsp;</p>
	<p class="importnat"><font color="red"><strong>最終的に</strong></font>、 首尾よく確認した後、できる限り早く主題情報をタイトルとしたのメールで我々を通知してください。    (メールアドレス： <strong><a href="mailto:service_jp@8seasons.com">service_jp@8seasons.com</a> (ご注意： supplies@8season<font color="red">s</font>.comではありません)</strong>).   そこで、我々の財務担当者が請求書を確認した後、速やかに小包の出荷準備ができます。</p>
	<p class="importnat"><strong>まだいくつかの問題点がございましたら、気兼ねなくservice_jp@8seasons.comでお問い合わせください。  			喜んでお手伝いさせていただきます。 </strong></p>
	<!--
	end
	-->

<?php
}else{
?>
	<p><br />
	ウェスタンユニオンマネー即時振替または直接銀行振込（電信送金）を選んで送金する場合、支払いを送信する指示に従うことを忘れないでください。</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p><strong>再び支払指示に従うにはここをクリックしてください。 </strong><a href="<?php echo HTTP_SERVER;?>/index.php?main_page=help_center&pagename=payment_method" target="_blank" title="8Season Payment Instructions"><font color="#0000cc"><strong>お支払い方法</strong></font></a></p>
	<p>&nbsp;</p>
	<p>ご注意*： お支払い方法として、<font color="#0000ff"><strong>間違った</strong></font>ウエスタンユニオンマネー即時振替または直接銀行振込を選ぶ&nbsp;場合、</p>
	<p>または、当社のウェブサイトでPayPalで支払いをしようとしたとき <font color="#0000ff"><strong>問題があった</strong></font>、</p>
	<p>service_jp@8seasons.comにメールを送ってください。 電子メールでは、私たちにお客様のPayPalメールアドレスと注文番号を伝える必要があります。我々の経理部はお客様がPayPalを通してを支払うのをご援助します。</p>
<?php
}
?>