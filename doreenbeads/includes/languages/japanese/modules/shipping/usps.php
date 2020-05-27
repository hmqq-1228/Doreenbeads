<?php
define ( 'MODULE_SHIPPING_USPS_TEXT_TITLE', '米国郵政公社' );
define ( 'MODULE_SHIPPING_USPS_TEXT_DESCRIPTION', '米国郵政公社<br /><br />このモジュールを使用するには、 <a href="http://www.usps.com/webtools/" target="_blank">彼のウェブサイトで</a> USPS Webツールのアカウントを登録している必要があります。<br /><br />USPSはあなたが製品に <strong>ポンドを重量単位として</strong> 利用することを期待します。' . ((MODULE_SHIPPING_USPS_USERID == 'NONE' || MODULE_SHIPPING_USPS_USERID == '' || MODULE_SHIPPING_USPS_SERVER == 'test') ? '<br /><br /><strong>USPSリアルタイムの出荷オファーの顧客アカウントを作成する </strong><br />
1. <a href="http://www.usps.com/webtools/rate.htm" target="_blank">USPSと為替レートオファーの情報</a><br />
2. <a href="https://secure.shippingapis.com/registration/" target="_blank">USPS Webツールのアカウントを作成する</a><br />
3.顧客情報を記入して、[送信]をクリックします<br />
4. USPS為替レートオファーWebツールのユーザIDを含むメールにを受信します。<br />
5. Zen Cart USPSの出荷モジュールでWebツールのユーザーIDをインサートします。<br />
6. 電話で（USPS1-800-344-7779）プロダクションサーバにアカウントを移動してもらいます。またはicustomercare@usps.comにメールして、Web ToolユーザIDを引用してもらいます。<br />
7. 彼らは、別の確認メールを送信いたします。アクティベーションを完了するためにプロダクションモード（テストモード代わりに）にZen Cart モジュールを設定します。' : '') );
define ( 'MODULE_SHIPPING_USPS_TEXT_OPT_PP', '小包' );
define ( 'MODULE_SHIPPING_USPS_TEXT_OPT_PM', '優先扱いメール' );
define ( 'MODULE_SHIPPING_USPS_TEXT_OPT_EX', 'エクスプレスメール' );
define ( 'MODULE_SHIPPING_USPS_TEXT_ERROR', '我々はお送り先にUSPS出荷オファーと通常使用する配送方法を適することができません。
<br />USPSを配送方法として、それをしたい場合は当社にお問い合わせください。<br/>（郵便番号が正しく入力されていることを確認してください。)' );
define ( 'MODULE_SHIPPING_USPS_TEXT_SERVER_ERROR', 'エラーがUSPSの出荷相場を入手することで発生した。<br /> USPSを配送方法として、それをしたい場合は当社にお問い合わせください。' );
define ( 'MODULE_SHIPPING_USPS_TEXT_DAY', '日' );
define ( 'MODULE_SHIPPING_USPS_TEXT_DAYS', '日' );
define ( 'MODULE_SHIPPING_USPS_TEXT_WEEKS', '週間' );
define ( 'MODULE_SHIPPING_USPS_TEXT_TEST_MODE_NOTICE', '<br /><span class="alert">お客様のアカウントがテストモードである。USPSのアカウントがプロダクションサーバー（1-800-344-7779）に移動されるまで使用可能な為替レートオファーが見られません。それで、Zen Cart管理にプロダクションモードをモジュールとして設定する必要があります。</span>' );
?>