<?php
define ( 'MODULE_PAYMENT_LINKPOINT_API_TEXT_ADMIN_TITLE', '物流管理システム（Linkpoint）/yourspay API' );
define ( 'MODULE_PAYMENT_LINKPOINT_API_TEXT_CATALOG_TITLE', 'クレジットカード' );

if (MODULE_PAYMENT_LINKPOINT_API_STATUS == 'True') {
	define ( 'MODULE_PAYMENT_LINKPOINT_API_TEXT_DESCRIPTION', '<a target="_blank" href="https://secure.linkpt.net/lpcentral/servlet/LPCLogin">物流管理システム（Linkpoint）/yourspayマーチャントログイン </a>' . (MODULE_PAYMENT_LINKPOINT_API_TRANSACTION_MODE_RESPONSE != 'LIVE: Production' ? '<br /><br /><strong>リンクポイント/YoursPay APIテストカード番号：</strong><br /><strong>Visa:</strong> 4111111111111111<br /><strong>マスターカード（MasterCard）:</strong> 5419840000000003<br /><strong>アメリカ株式取引所（Amex）:</strong> 371111111111111<br /><strong>ディスカバーカード（Discover Card）:</strong> 6011111111111111' : '') );
} else {
	define ( 'MODULE_PAYMENT_LINKPOINT_API_TEXT_DESCRIPTION', '<a target="_blank" href="http://www.zen-cart.com/index.php?main_page=infopages&pages_id=30">アカウントにサインアップするには、ここをクリックしてください</a><br /><br /><a target="_blank" href="https://secure.linkpt.net/lpcentral/servlet/LPCLogin">物流管理システム（Linkpoint）/YoursPayのAPIマーチャントエリア</a><br /><br /><strong>要件：</strong><br /><hr />*<strong>物流管理システム（Linkpoint)または YoursPay アカンウト</strong> (登録するには上記のリンクを参照してください。)<br />*<strong>URLは </strong>ホスティング会社によってPHPにコンパイルしなければなりません<br />*<strong>ポート1129は</strong>ゲートウェイとの双方向通信のために使用されているので、あなたのホストのルータ/ファイアウォールを開かなければなりません。<br />*<strong>PEM RSAキーファイル </strong>デジタル証明書：<br />あなたのデジタル証明書を取得してアップロードするには (.PEM) key:<br />- それらのウェブサイト上でLinkPoint/ Yourspayのアカウントにログインします<br />- メインメニューバーの「サポート」をクリックしてください。<br />- サイドメニューボックスでのダウンロードの下に「ダウンロードセンター」の単語をクリックしてください。<br />- ページの右側にある「ストアPEMファイル」セクションの横にある単語「ダウンロード」をクリックしてください。<br />-ダウンロードを開始するために必要な情報は重要です。あなたはマーチャントのアカウントの登録プロセスの間に、実際のSSNや税金のIDを提出する必要があります。<br />- includes/modules/payment/linkpoint_api/XXXXXX.pemにこのファイルをアップロードする  (LinkPointで技術を提供する - xxxxxx は、ストアIDです)' );
}
define ( 'MODULE_PAYMENT_LINKPOINT_API_TEXT_CREDIT_CARD_TYPE', 'クレジットカードの種類：' );
define ( 'MODULE_PAYMENT_LINKPOINT_API_TEXT_CREDIT_CARD_OWNER', 'クレジットカードの所有者：' );
define ( 'MODULE_PAYMENT_LINKPOINT_API_TEXT_CREDIT_CARD_NUMBER', 'クレジットカード番号：' );
define ( 'MODULE_PAYMENT_LINKPOINT_API_TEXT_CVV', 'CVV 番号：' );
define ( 'MODULE_PAYMENT_LINKPOINT_API_TEXT_CREDIT_CARD_EXPIRES', 'クレジットカード有効期限：' );
define ( 'MODULE_PAYMENT_LINKPOINT_API_TEXT_JS_CC_OWNER', '*クレジットカードの所有者の氏名は少なくとも ' . CC_OWNER_MIN_LENGTH . ' キャラクターでなければなりません。\n' );
define ( 'MODULE_PAYMENT_LINKPOINT_API_TEXT_JS_CC_NUMBER', '* Tクレジットカード番号は少なくとも ' . CC_NUMBER_MIN_LENGTH . ' キャラクターでなければなりません。\n' );
define ( 'MODULE_PAYMENT_LINKPOINT_API_TEXT_JS_CC_CVV', '*あなたのクレジットカードの裏面に3または4桁の番号を入力する必要があります。' );
define ( 'MODULE_PAYMENT_LINKPOINT_API_TEXT_ERROR', 'クレジットカードのエラー！' );
define ( 'MODULE_PAYMENT_LINKPOINT_API_TEXT_DECLINED_MESSAGE', 'あなたのカードが拒否されました。  別のカードを試して、カード情報を再入力して、またはヘルプについては店の所有者に連絡してください。' );
define ( 'MODULE_PAYMENT_LINKPOINT_API_TEXT_DECLINED_AVS_MESSAGE', '無効な請求先。 別のカードを試して、カード情報が再入力して、またはヘルプについては店の所有者に連絡してください。' );
define ( 'MODULE_PAYMENT_LINKPOINT_API_TEXT_DECLINED_GENERAL_MESSAGE', 'あなたのカードが拒否されました。 別のカードを試して、カード情報が再入力して、またはヘルプについては店の所有者に連絡してください。' );
define ( 'MODULE_PAYMENT_LINKPOINT_API_TEXT_POPUP_CVV_LINK', 'これはなんですか。' );
define ( 'ALERT_LINKPOINT_API_PREAUTH_TRANS', '***授権だけ --料金は管理者が後で解決します。***' );
define ( 'ALERT_LINKPOINT_API_TEST_FORCED_SUCCESSFUL', 'ご注意事項：これはテストトランザクション... 成功応答を返すことを余儀なくされました。' );
define ( 'ALERT_LINKPOINT_API_TEST_FORCED_DECLINED', 'ご注意事項： これはテストトランザクション...拒否応答を返すことを余儀なくされた。' );
define ( 'MODULE_PAYMENT_LINKPOINT_API_TEXT_NOT_CONFIGURED', '<span class="alert">&nbsp;(ご注意事項：モジュールがまだ設定されていません)</span>' );
define ( 'MODULE_PAYMENT_LINKPOINT_API_TEXT_ERROR_CURL_NOT_FOUND', 'CURL機能は見つかりません- LinkpointのAPI支払いモジュールが必要です' );

define ( 'MODULE_PAYMENT_LINKPOINT_API_TEXT_FAILURE_MESSAGE', 'ご迷惑をおかけして申し訳ございませんが、我々が授権についてはクレジットカード会社に連絡することができません。お支払いの替代品を得るために店の所有者に連絡してください。' );
define ( 'MODULE_PAYMENT_LINKPOINT_API_TEXT_GENERAL_ERROR', '申し訳ございませんが、カードの処理中にシステムエラーが発生しました。 あなたの情報は安全です。 代替支払いオプションを配置するには店舗所有者に通知してください。' );

define ( 'MODULE_PAYMENT_LINKPOINT_API_LINKPOINT_ORDER_ID', 'Linkpoint注文ID：' );
define ( 'MODULE_PAYMENT_LINKPOINT_API_AVS_RESPONSE', 'AVS レスポンス：' );
define ( 'MODULE_PAYMENT_LINKPOINT_API_MESSAGE', '応答メッセージ：' );
define ( 'MODULE_PAYMENT_LINKPOINT_API_APPROVAL_CODE', '承認コード：' );
define ( 'MODULE_PAYMENT_LINKPOINT_API_TRANSACTION_REFERENCE_NUMBER', '参照番号：' );
define ( 'MODULE_PAYMENT_LINKPOINT_API_FRAUD_SCORE', '詐欺スコア：' );
define ( 'MODULE_PAYMENT_LINKPOINT_API_TEXT_TEST_MODE', '<span class="alert">&nbsp;(ご注意事項：モジュールはまだストモード中です)</span>' );

?>