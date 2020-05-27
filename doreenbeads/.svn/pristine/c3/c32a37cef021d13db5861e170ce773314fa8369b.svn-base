<?php

/**

 * @package languageDefines

 * @copyright Copyright 2003-2007 Zen Cart Development Team

 * @copyright Portions Copyright 2003 osCommerce

 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0

 * @version $Id: paypalwpp.php 6528 2007-06-25 23:25:27Z drbyte $

 */
define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_TITLE_EC', 'ペイパルエクスプレスチェックアウト' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_TITLE_WPP', 'ペイパルウェブペイメントプロ' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_TITLE_PRO20', 'ペイパルウェブペイメントプロ Payflow版（英国）' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_TITLE_PF_EC', 'ペイパル Payflow Pro - ゲートウェイ' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_TITLE_PF_GATEWAY', 'ペイパル Payflow Pro + エクスプレスチェックアウト' );

if (IS_ADMIN_FLAG === true) {

	define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_ADMIN_DESCRIPTION', '<strong>ペイパルエクスプレスチェックアウト</strong>%s<br />' . (substr ( MODULE_PAYMENT_PAYPALWPP_MODULE_MODE, 0, 7 ) == 'Payflow' ? '<a href="https://manager.paypal.com/loginPage.do?partner=ZenCart" target="_blank">ペイパルアカウントを管理します。</a>' : '<a href="http://www.zen-cart.com/partners/paypal" target="_blank">ペイパルアカウントを管理します。</a>') . '<br /><br /><font color="green">設定手順：</font><br /><span class="alert">1. </span><a href="http://www.zen-cart.com/partners/paypal" target="_blank">ペイパルアカウントにサインアップします - こちらをクリックしてください。</a><br />' .

	(defined ( 'MODULE_PAYMENT_PAYPALWPP_STATUS' ) ? '' : '。。。とペイパルエクスプレスチェックアウトのサポートを有効にするために、上記の「インストール」をクリックします</br>') .

	(MODULE_PAYMENT_PAYPALWPP_MODULE_MODE == 'ペイパル' && (! defined ( 'MODULE_PAYMENT_PAYPALWPP_APISIGNATURE' ) || MODULE_PAYMENT_PAYPALWPP_APISIGNATURE == '') ? '<span class="alert">2. </span><strong>API資格情報</strong>あなたのPayPalプロファイル設定領域内のAPI資格情報オプションから。このモジュールは <strong>API署名</strong> オプションを使用しています -- 下記のフィールドにユーザ名、パスワード、署名を入力する必要があります。' : (substr ( MODULE_PAYMENT_PAYPALWPP_MODULE_MODE, 0, 7 ) == 'Payflow' && (! defined ( 'MODULE_PAYMENT_PAYPALWPP_PFUSER' ) || MODULE_PAYMENT_PAYPALWPP_PFUSER == '') ? '<span class="alert">2. </span><strong>PAYFLOW 資格情報</strong> このモジュールはあなたの<strong>Payflowパートナー、ベンダー、ユーザーとパスワード設定</ strong>を下記の4つのフィールドに入力する必要があります。 これらはPayflowシステムと通信して、アカウントにトランザクションを授権するために使用されます。' : '<span class="alert">2. </span>ユーザー名/パスワードなどの適切なセキュリティデータを確認してください。次のように')) .

	(MODULE_PAYMENT_PAYPALWPP_MODULE_MODE == 'ペイパル' ? '<br /><span class="alert">3. </span>ペイパルアカウントでは <strong>即時支払い通知</strong>を有効にします:<br /> 「プロファイル」の下で<em>即時支払い通知設定</em>を選んでください<ul style="margin-top: 0.5;"><li>IPNを有効にするためにチェックボックスをクリックします</li><li>指定されたURLはいない場合、URLを<br />' . str_replace ( 'index.php?main_page=index', 'ipn_main_handler.php', zen_catalog_href_link ( FILENAME_DEFAULT, '', 'SSL' ) ) . '</li></ul>' : 'に設定します。') .

	'<font color="green"><hr /><strong>要件：</strong></font><br /><hr />*<strong>CURL</strong> はゲートウェイとの双方向通信のため使用されているので、あなたのホストサーバーを活性化する必要があります（あなたはCURLプロキシを使用する必要がある場合は、[管理] - > [設定] - >私の店の下でCURLプロキシ設定を設定してください。）<br /><hr />' );
}

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_DESCRIPTION', '<strong>ペイパル</strong>' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_TITLE', 'クレジットカード' );

define ( 'MODULE_PAYMENT_PAYPALWPP_EC_TEXT_TITLE', 'ペイパル' );

define ( 'MODULE_PAYMENT_PAYPALWPP_EC_TEXT_TYPE', 'ペイパルエクスプレスチェックアウト' );

define ( 'MODULE_PAYMENT_PAYPALWPP_DP_TEXT_TYPE', 'ペイパル直接支払い' );

define ( 'MODULE_PAYMENT_PAYPALWPP_PF_TEXT_TYPE', 'クレジットカード' ); // (used for payflow transactions)

define ( 'MODULE_PAYMENT_PAYPALWPP_ERROR_HEADING', '申し訳ございませんが、あなたのクレジットカードを処理することができませんでした。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_CARD_ERROR', '入力されたクレジットカード情報に誤りがあります。それを確認してからもう一度お試しください。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_FIRSTNAME', 'クレジットカード名：' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_LASTNAME', 'クレジットカード苗字：' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_OWNER', 'カード所有者名：' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_TYPE', 'クレジットカードの種類：' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_NUMBER', 'クレジットカードの番号：' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_EXPIRES', 'クレジットカード有効期限：' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_ISSUE', 'クレジットカードの発行日：' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_CHECKNUMBER', 'CVV番号：' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_CREDIT_CARD_CHECKNUMBER_LOCATION', '（クレジットカードの裏面に）' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_DECLINED', 'あなたのクレジットカードが拒否されました。別のカードを試すか、詳細については、お使いの銀行にお問い合わせください。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_INVALID_RESPONSE', '私たちはあなたの注文を処理することができませんでした。もう一度やり直して別の支払い方法を選んで、または支援のために店の所有者に連絡してください。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_INVALID_RESPONSE_ADDRESS', "ペイパルの判断によると、このトランザクションを処理することができません。出荷国は購入者の国で許可されていません。心配しないで、支払いを処理するために<a href='mailto:service_jp@8seasons.com'> service_jp@8seasons.com</ A>にご連絡ください。 我々は24時間以内に返信されます。ありがとうございます。 " );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_GEN_ERROR', '我々は支払プロセッサに連絡しようとしたときにエラーが発生しました。 もう一度やり直して別の支払い方法を選んで、またはヘルプについては店の所有者に連絡してください。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_EMAIL_ERROR_MESSAGE', '親愛なる店主；' . "\n" . 'ペイパルエクスプレスチェックアウト取引を開始しようとしたときにエラーが発生しました。礼儀として、エラー「番号」のみお客様に示します。エラーの詳細を以下に示します。' . "\n\n" );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_EMAIL_ERROR_SUBJECT', '警告： ペイパルエクスプレスチェックアウトエラー' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_ADDR_ERROR', '入力したアドレス情報が有効ではないか、または一致できません。別のアドレスを選んでまたは追加してもう一度試してください。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_ADDR_ERROR_FOR_SHIPPING_ADDRESS', '10736配送先住所が無効な市州
郵便番号ー 配送先住所市、州、および郵便番号は一致していません。 <br/>もう一度配送先住所を確認して、それを<a href="javascript:void(0);" style="color:#008FED;"><span class="edit shippingAddressAction">編集する</span></a>(正しい）　または迅速な解決策を得るために<a href="mailto:service_jp@8seasons.com" style="color:#008FED;"> service_jp@8seasons.com</ A>までお問い合わせください。 ' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_CONFIRMEDADDR_ERROR', 'ペイパルで選んだアドレスは確認された住所ではありません。ペイパルに戻り、確認されたアドレスを選択または追加して、もう一度お試しください。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_INSUFFICIENT_FUNDS_ERROR', 'ペイパルはこのトランザクションに資金を供給することができませんでした。 先に進む前に、ペイパルアカウントで別の支払いオプションを選ぶ或いは資金調達のオプションを調べます。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_ERROR', 'あなたのクレジットカードを処理しようとしたときにエラーが発生しました。別の支払い方法を選んでもう一度試して、またはヘルプについては店の所有者に連絡してください。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_BAD_CARD', 'ご迷惑をお掛けして申し訳ございません。入力したクレジットカードはお受け入れできません。別のクレジットカードをご利用下さい。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_BAD_LOGIN', 'アカウントの検証問題が有ります。もう一度試してください。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_JS_CC_OWNER', '* カード所有者の氏名は少なくとも ' . CC_OWNER_MIN_LENGTH . ' キャラクターでなければなりません。\n' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_JS_CC_NUMBER', '* クレジットカード番号は少なくとも' . CC_NUMBER_MIN_LENGTH . ' キャラクターでなければなりません。\n' );

define ( 'MODULE_PAYMENT_PAYPALWPP_ERROR_AVS_FAILURE_TEXT', '警告：アドレスの検証は失敗しました。 ' );

define ( 'MODULE_PAYMENT_PAYPALWPP_ERROR_CVV_FAILURE_TEXT', '警告： カードのCVVコードの検証は失敗しました。 ' );

define ( 'MODULE_PAYMENT_PAYPALWPP_ERROR_AVSCVV_PROBLEM_TEXT', 'ご注文は店舗所有者で審査保留中になっています。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_EC_HEADER', 'ペイパルで、高速で安全なチェックアウト：' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_BUTTON_TEXT', '時間を節約。安全にチェックアウト。 財務情報を共有せずに支払今すぐ。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_BUTTON_ALTTEXT', 'ペイパルエクスプレスチェックアウトで支払うにはここをクリックします。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_STATE_ERROR', '自分のアカウントに割り当てられている状態が有効ではありません。アカウント設定に移動し、それを変更してください。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_NOT_WPP_ACCOUNT_ERROR', 'ご迷惑をお掛けして申し訳ございません。 ストアの所有者による設定されたペイパルアカウントはペイパルウェブペイメントプロのアカウントではありません、またはペイパルゲートウェイサービスまだ購入されていないから、お支払いを開始することができませんでした。ご注文のお支払いの代替方法を選んでください。.' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_SANDBOX_VS_LIVE_ERROR', 'ご迷惑をお掛けして申し訳ございません。 今、混合サンドボックスやライブ設定を使うために、このストアのペイパルアカウントは正しく設定されていません。我々は取引を完了することはできません。この問題を解決することができるように店の所有者に通知してください。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_WPP_BAD_COUNTRY_ERROR', '申し訳ございません。 -- 店舗管理者が設定したペイパルアカウントは、現在の時点でプロウェブペイメントをサポートしない国に拠点を置いています。ご注文を完了するために、別のお支払い方法をお選び下さい。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_NOT_CONFIGURED', '<span class="alert">&nbsp;(注意事項：モジュールがまだ設定されていません)</span>' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_GETDETAILS_ERROR', '取引の詳細を取得する時、問題がありました。 ' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_TRANSSEARCH_ERROR', '指定した取引を検索する時、問題がありました。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_VOID_ERROR', '取引を無效させる時、問題がありました。 ' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_REFUND_ERROR', '指定された取引金額を払い戻す時、問題がありました。 ' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_AUTH_ERROR', '取引を認可する時、問題がありました。 ' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_CAPT_ERROR', '取引をキャプチャする時、問題がありました。 ' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_REFUNDFULL_ERROR', '払い戻しの要求はペイパルで拒否されました。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_INVALID_REFUND_AMOUNT', '一部の払い戻しを要求しましたが、金額を指定しませんでした。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_REFUND_FULL_CONFIRM_ERROR', '全額返金を要求しましたが、確認ボックスをチェックしなければ、ご要望を確認できません。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_INVALID_AUTH_AMOUNT', '認可を要求しましたが、金額を指定しませんでした。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_INVALID_CAPTURE_AMOUNT', 'キャプチャを要求しましたが、金額を指定しませんでした。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_VOID_CONFIRM_CHECK', '確認する' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_VOID_CONFIRM_ERROR', '取引を無効にするように要求しましたが、確認ボックスをチェックしなければ、ご要望を確認できません。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_AUTH_FULL_CONFIRM_CHECK', '確認する' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_AUTH_CONFIRM_ERROR', '認可を要求しましたが、確認ボックスをチェックしなければ、ご要望を確認ができません。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_CAPTURE_FULL_CONFIRM_ERROR', '資金キャプチャを要求しましたが、確認ボックスをチェックしなければ、ご要望を確認できません。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_REFUND_INITIATED', '%sのPayPal払い戻しをスタート。取引 ID: %s. 注文状況の歴史/コメント欄に更新された確認の詳細を閲覧するには、画面をリフレッシュします。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_AUTH_INITIATED', '%sのPayPal認証 をスタート。注文状況の歴史/コメント欄に更新された確認の詳細を閲覧するには、画面をリフレッシュします。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_CAPT_INITIATED', '%sのPayPalャプチャ をスタート。 レシートID： %s. 注文状況の歴史/コメント欄に更新された確認の詳細を閲覧するには、画面をリフレッシュします。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_VOID_INITIATED', 'PayPalボイドリクエストをスタート。 取引ID： %s. 注文状況の歴史/コメント欄に更新された確認の詳細を閲覧するには、画面をリフレッシュします。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_GEN_API_ERROR', 'トランザクションをしようとした時エラーが発生しました。詳しくはAPIリファレンスガイド或いはトランザクションログを参照してください。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_INVALID_ZONE_ERROR', 'ご迷惑をおかけして申し訳ございませんが、現在のところ、我々はPayPalでお客様のPayPalのアドレスとしてのご選択された地域に注文を処理できません。  通常のチェックアウトを使用して、ご注文を完了するために利用可能なお支払い方法からお選びください。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_ORDER_ALREADY_PLACED_ERROR', 'ご注文が二度提出されたことがあります。実際の注文の詳細を見るには「私のアカウント」エリアをご確認ください。 すでにPayPalアカウントから支払われていますが、ご注文はここに表示されない場合、お問い合わせフォームをご利用ください。それで、我々は我々のレコードをチェックしてこれを調整することができます。' );

// EC buttons -- Do not change these values:

define ( 'MODULE_PAYMENT_PAYPALWPP_EC_BUTTON_IMG', 'includes/templates/cherry_zen/buttons/english/btn_xpressCheckout.gif' );

define ( 'MODULE_PAYMENT_PAYPALWPP_EC_BUTTON_SM_IMG', DIR_WS_CATALOG . DIR_WS_IMAGES . 'payment/btn_xpressCheckoutsm.gif' );

define ( 'MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_IMG', DIR_WS_CATALOG . DIR_WS_IMAGES . 'payment/PayPal_mark_37x23.gif' );

define ( 'MODULE_PAYMENT_PAYPALWPP_MARK_BUTTON_TXT', '<strong>PayPalでチェックアウト <br /></strong>' );

// //////////////////////////////////////

// Styling of the PayPal Payment Page. Uncomment to customize. Otherwise, simply create a Custom Page Style at PayPal and mark it as Primary or name it in your Zen Cart PayPal WPP settings.

// define('MODULE_PAYMENT_PAYPALWPP_HEADER_IMAGE', ''); // this should be an HTTPS URL to the image file

// define('MODULE_PAYMENT_PAYPALWPP_PAGECOLOR', ''); // 6-digit hex value

// define('MODULE_PAYMENT_PAYPALWPP_HEADER_BORDER_COLOR', ''); // 6-digit hex value

// define('MODULE_PAYMENT_PAYPALWPP_HEADER_BACK_COLOR', ''); // 6-digit hex value

// //////////////////////////////////////

// These are used for displaying raw transaction details in the Admin area:

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

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_ADDRESS_STATUS', 'アドレス状態：' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_TYPE', 'お支払い方法の種類：' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_STATUS', '支払い状況：' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_PENDING_REASON', '保留中の理由：' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_INVOICE', '請求書：' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_DATE', '支払日：' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_CURRENCY', '通貨：' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_GROSS_AMOUNT', '総額：' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_PAYMENT_FEE', 'お支払い手数料：' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_EXCHANGE_RATE', '為替レート：' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_CART_ITEMS', 'カートアイテム：' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_TXN_TYPE', 'トランザクションタイプ：' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_TXN_ID', 'トランザクションID：' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_PARENT_TXN_ID', 'ペイパルトランザクションID：' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_TITLE', '<strong>注文払い戻し</strong>' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_FULL', 'この注文のすべてを払い戻すなら、こちらをクリックします：' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_BUTTON_TEXT_FULL', '全額返金を行う' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_BUTTON_TEXT_PARTIAL', '一部払い戻しを行う' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_TEXT_FULL_OR', '<br />... または部分を入力します。 ' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_PAYFLOW_TEXT', '入力する ' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_PARTIAL_TEXT', 'ここに金額を返金し、一部返金をクリックします' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_SUFFIX', '*一部払い戻しが適用された後、全額返金が払い戻されない場合があります。<br />*複数の部分の払い戻しは残りの未返還残高を超えられない。' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_TEXT_COMMENTS', '<strong>お客様への注意事項：</strong>' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_DEFAULT_MESSAGE', '店舗管理者によって返金されます。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_REFUND_FULL_CONFIRM_CHECK', '確認：' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_AUTH_TITLE', '<strong>オーダー認可</strong>' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_AUTH_PARTIAL_TEXT', 'この注文の一部を認可したい場合は、ここに金額を入力します:' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_AUTH_BUTTON_TEXT_PARTIAL', '認証を行う' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_AUTH_SUFFIX', '' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_TEXT_COMMENTS', '<strong>お客様への注意事項：</strong>' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_REFUND_DEFAULT_MESSAGE', '店舗管理者によって返金されます。' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_TITLE', '<strong>権限を得る</strong>' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_FULL', 'この注文の未返済残高のすべての金額または一部の金額をキャプチャーしたい場合、キャプチャ金額を入力し、これがこの注文の最終的なャプチャ金額であるかどうかを選択します。キャプチャー•リクエストを提出する前に確認ボックスをチェックしてください。<br />' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_BUTTON_TEXT_FULL', 'キャプチャを行う' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_AMOUNT_TEXT', 'キャプチャ金額：' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_FINAL_TEXT', 'これは最終的なキャプチャですか？' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_SUFFIX', '' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_TEXT_COMMENTS', '<strong>お客様への注意事項：</strong>' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_CAPTURE_DEFAULT_MESSAGE', 'ご注文ありがとうございます。' );

define ( 'MODULE_PAYMENT_PAYPALWPP_TEXT_CAPTURE_FULL_CONFIRM_CHECK', '確認： ' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_VOID_TITLE', '<strong>オーダー認可を無効させる</strong>' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_VOID', '認可を無効にしたい場合は、ここで認可IDを入力して、確認します。' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_VOID_TEXT_COMMENTS', '<strong>>お客様への注意事項：</strong>' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_VOID_DEFAULT_MESSAGE', 'ご愛顧いただき、誠にありがとうございます。ようこそもう一度いらっしゃいませ。' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_VOID_BUTTON_TEXT_FULL', '無効させる' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_VOID_SUFFIX', '' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_TRANSSTATE', 'トランザクションの状態：' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_AUTHCODE', '認証コード：' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_AVSADDR', 'AVSアドレス一致：' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_AVSZIP', 'AVS郵便マッチ：' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_CVV2MATCH', 'CVV2マッチ：' );

define ( 'MODULE_PAYMENT_PAYPAL_ENTRY_DAYSTOSETTLE', '決済日：' );

// this text is used to announce the username/password when the module creates the customer account and emails data to them:

define ( 'EMAIL_EC_ACCOUNT_INFORMATION', 'アカウントのログインの詳細を使って、ご注文をチェックできます。詳しくは次のとおりです。' );

?>