<?php
define ( 'MODULE_PAYMENT_PAYPAL_TEXT_ADMIN_TITLE', 'PayPal IPN' );
define ( 'MODULE_PAYMENT_PAYPAL_TEXT_CATALOG_TITLE', 'PayPal IPN' );
if (IS_ADMIN_FLAG === true) {
	define ( 'MODULE_PAYMENT_PAYPAL_TEXT_DESCRIPTION', '<strong>PayPal IPN</strong> (基本的なペイパルサービス)<br /><a href="https://www.paypal.com/mrb/mrb=R-6C7952342H795591R&pal=9E82WJBKKGPLQ" target="_blank">PayPalアカウントを管理します。</a><br /><br /><font color="green">構成指導：</font><br />1. <a href="http://www.zen-cart.com/partners/paypal" target="_blank">PayPalアカウントにサインアップします - こちらをクリックしてください。</a><br />2.ペイパルアカウントでは、「プロファイル」下に,<ul><li> <strong>即時支払い通知の設定</strong>をします。 URLへ：<br />' . str_replace ( 'index.php?main_page=index', 'ipn_main_handler.php', zen_catalog_href_link ( FILENAME_DEFAULT, '', 'SSL' ) ) . '<br />(別のURLが既に使用されている場合は、それを放っておきます。)<br /><span class="alert">IPNを有効にするチェックボックスにチェックが入っていることを確認してください！</span></li><li><strong> <strong>ウェブサイト決済の設定</strong> にあなたの <strong>自動復帰URL</strong> を次のように設定します。<br />' . zen_catalog_href_link ( FILENAME_CHECKOUT_PROCESS, '', 'SSL', false ) . '</li>' . (defined ( 'MODULE_PAYMENT_PAYPAL_STATUS' ) ? '' : '<li>PayPalのサポートを有効にするために上記の「インストール」をクリックし...それで「編集」"して、Zen CartにあなたのPayPalの設定を通知します。</li>') . '</ul><font color="green"><hr /><strong>要件：</strong></font><br /><hr />*<strong>PayPalアカウント</strong> (<a href="http://www.zen-cart.com/partners/paypal" target="_blank">登録するにはクリック</a>)<br />*<strong>*<strong>ポート80</strong>はゲートウェイとの双方向通信のために使用されているので、あなたのホストのルータ/ファイアウォールで開かなければなりません<br />*<strong>PHP allow_url_fopen()</strong> を有効にする必要があります<br />* 上記のように<strong>設定</strong>をしなければなりません。' );
} else {
	define ( 'MODULE_PAYMENT_PAYPAL_TEXT_DESCRIPTION', '<strong>ペイパル</strong>' );
}
define ( 'MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_IMG', 'https://www.paypal.com/en_US/i/logo/PayPal_mark_37x23.gif' );
define ( 'MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_ALT', 'PayPalでチェックアウト' );
define ( 'MODULE_PAYMENT_PAYPAL_ACCEPTANCE_MARK_TEXT', '時間を節約　安全にチェックアウト <br /><div style="clear:both; padding-bottom:10px; padding-left:10px;">ペイパルのアカウントなしで、ペイパルでクレジットカードで支払うことができます。<a href="http://www.8season-supplies.com/page.html?chapter=0&id=65">詳しくはこちら>></a></div>' );

define ( 'MODULE_PAYMENT_PAYPAL_TEXT_CATALOG_LOGO', '<img src="' . MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_IMG . '" alt="' . MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_ALT . '" title="' . MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_ALT . '" /> &nbsp;' . '<span class="smallText">' . MODULE_PAYMENT_PAYPAL_ACCEPTANCE_MARK_TEXT . '</span>' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_FIRST_NAME', '名前：' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_LAST_NAME', '苗字：' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_BUSINESS_NAME', '事業名：' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_NAME', 'アドレス名：' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STREET', 'ストリートアドレス：' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_CITY', '市住所：' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STATE', 'アドレス状態：' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_ZIP', '住所の郵便番号：' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_COUNTRY', '住所国：' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_EMAIL_ADDRESS', '支払者メールアドレス：' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_EBAY_ID', 'eBayのID：' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_PAYER_ID', '支払者ID：' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_PAYER_STATUS', '支払状況：' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STATUS', 'アドレスステータス：' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_TYPE', 'お支払い方法の種類：' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_STATUS', '支払い状況：' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_PENDING_REASON', '保留中の理由：' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_INVOICE', '請求書：' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_DATE', '支払日：' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_CURRENCY', '通貨：' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_GROSS_AMOUNT', '総額：' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_FEE', '支払い手数料：' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_EXCHANGE_RATE', '為替レート：' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_CART_ITEMS', 'カートのアイテム：' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_TXN_TYPE', 'トランザクションタイプ：' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_TXN_ID', 'トランザクションID' );
define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_PARENT_TXN_ID', '親会社輸送ID：' );

define ( 'MODULE_PAYMENT_PAYPAL_PURCHASE_DECRIPTION_TITLE', STORE_NAME . ' 購入' );
?>