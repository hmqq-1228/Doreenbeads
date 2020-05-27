<?php
define ( 'NAVBAR_TITLE', 'アカウントを作成する' );

define ( 'HEADING_TITLE', 'アカウント情報' );

define ( 'TEXT_ORIGIN_LOGIN', '<strong class="note">ご注意事項：</strong> すでに我々のアカウントを持っている場合は、 <a href="%s">ログインページ</a>からログインしてください。' );

// greeting salutation
define ( 'EMAIL_SUBJECT', 'ようこそいらっしゃいませ ' . STORE_NAME );
define ( 'EMAIL_GREET_MR', 'Dear Mr. %s,' . "\n\n" );
define ( 'EMAIL_GREET_MS', 'Dear Ms. %s,' . "\n\n" );
define ( 'EMAIL_GREET_NONE', 'Dear %s' . "\n\n" );

// First line of the greeting
define ( 'EMAIL_WELCOME', 'ようこそいらっしゃいませ ' . STORE_NAME . '. 当社のウェブサイト上で、あなたのアカウントが作成されています。<br><b>以下は、あなたのアカウント情報です：</b><br />' );
// define('EMAIL_CUSTOMER_REG_INFO','Your account information is as follows:');
define ( 'EMAIL_CUSTOMER_EMAILADDRESS', '<span style="color:blue;">登録したメールアドレス：</span>' );
define ( 'EMAIL_CUSTOMER_PASSWORD', '<span style="color:blue;">パスワード：</span>' );
define ( 'EMAIL_CUSTOMER_REG_DESCRIPTION', '<span style="color:red;">** ご注意事項：</span>記録のためにこの電子メールを保存しておくことをお薦めします。後でパスワードをお忘れになった場合は、このメールをチェックして参照することができます。<br /><br />' . "\n\n" );
define ( 'EMAIL_SEPARATOR', '--------------------' );
define ( 'EMAIL_COUPON_INCENTIVE_HEADER', 'おめでとうございます！ 弊社オンラインショップの訪問をよりやりがいのある経験をさせるためにリストされたのは、あなたのためにつくられる割り引き券の詳細です。!' . "\n\n" );
// your Discount Coupon Description will be inserted before this next define
define ( 'EMAIL_COUPON_REDEEM', '割引き券を使用するには、チェックアウト時に ' . TEXT_GV_REDEEM . 'コードを入力します <strong>%s</strong>' . "\n\n" );
define ( 'TEXT_COUPON_HELP_DATE', '<p>クーポンは%sと%sの間で有効である</p>' );

define ( 'EMAIL_GV_INCENTIVE_HEADER', '今日に限って、%sのために ' . TEXT_GV_NAME . ' を送ります。' . "\n" );
define ( 'EMAIL_GV_REDEEM', ' ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM . 'は %s です' . "\n\n" . 'ストアで商品の選びを行ったあと、チェックアウト時に ' . TEXT_GV_REDEEM . 'を入力することができます。' );
define ( 'EMAIL_GV_LINK', 'または、 次のリンクで、それを引き換えることができます。 ' . "\n" );
// GV link will automatically be included before this line

define ( 'EMAIL_GV_LINK_OTHER', '一度 ' . TEXT_GV_NAME . ' をアカウントに追加した後, 自分で ' . TEXT_GV_NAME . ' を使用できます, またはこれを友達に送ります。' . "\n\n" );
define ( 'EMAIL_TEXT_BACK_UP', '<table cellpadding=0 cellspacing=0 border=0  width="532" style="border:1px dashed #3A3A3A"><tr><td><div id="accountSuccessDiv"><p><b>今、次のような利点をお楽しみになれます。</b></p>
<p>1. 5.01ドルのクーポンが自動的にあなたのアカウントに追加されました。 <a href="' . zen_href_link ( FILENAME_MY_COUPON ) . '">ご閲覧ください>> </a></p>
<p>2. 最初の注文の割引を受ける：</p>
<table cellpadding=0 cellspacing=0 border=0 class="firstDiscountTb">
		<tr><th width="135">総製品価格</th><th width="80">割引</th><th>どのように割引を取得しますか。</th></tr>
		<tr><td>US $800 - US$ 1000</td><td><b>6%</b></td><td rowspan=3 class="rowspanTd">「注文を確定する」ボタンをクリックする前に「それを使用する」をクリックして、簡単に対応した割引を取得します。</td></tr>
		<tr><td>US $1000 - US$ 3000</td><td><b>8%</b></td></tr>
		<tr><td>US $3000+</td><td><b>10%</b></td></tr>
</table>
<p>3.第二回の注文の割引から <a href="' . zen_href_link ( FILENAME_HELP_CENTER, 'id=33' ) . '">VIPのポリシー</a>に従って適用されます。</p>
<p>4. 注文した後あなたが購入した製品の透かしなしの写真をダウンロードできます。</p>
</div></td></tr></table>' );
define('EMAIL_TEXT', '<table cellpadding=0 cellspacing=0 border=0  width="532" style="border:1px dashed #3A3A3A"><tr><td><div id="accountSuccessDiv"><p><b>今、次のような利点をお楽しみになれます。</b></p>
<p>1. 最初の注文の割引を受ける：</p>
<table cellpadding=0 cellspacing=0 border=0 class="firstDiscountTb">
		<tr><th width="135">総商品価格</th><th width="80">割引</th><th>どのように割引を取得しますか。</th></tr>
		<tr><td>US $800 - US$ 1000</td><td><b>6%</b></td><td rowspan=3 class="rowspanTd">「注文を確定」をクリックする前に「それを使用する」ボタンをクリックして、簡単に対応する割引を取得できます。</td></tr>
		<tr><td>US $1000 - US$ 3000</td><td><b>8%</b></td></tr>
		<tr><td>US $3000+</td><td><b>10%</b></td></tr>
</table>
<p>2. 第二回の注文の割引から <a href="'.zen_href_link(FILENAME_HELP_CENTER,'id=33').'">VIPのポリシー</a>に従って適用されます。</p>
<p>3. 注文した後あなたが購入した製品の透かしなしの写真をダウンロードできます。</p>
<p>4. <a href="'.zen_href_link(FILENAME_ACCOUNT_EDIT).'">プロフィールを更新して</a>、<span>'.TEXT_DOLLAR_501.' のクー</span>ポンを取得できます。</p>
</div></td></tr></table>');
define ( 'EMAIL_CONTACT', '当社のオンラインサービスのいずれかのヘルプについては、ストアーオーナー
にメールしてください： <a href="mailto:' . STORE_OWNER_EMAIL_ADDRESS . '">' . STORE_OWNER_EMAIL_ADDRESS . " </a>\n\n" );

define ( 'EMAIL_GV_CLOSURE', '敬具' . "\n\n" . STORE_OWNER . "\nストアーオーナー\n\n" . '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">' . HTTP_SERVER . DIR_WS_CATALOG . "</a>\n\n" );

// email disclaimer - this disclaimer is separate from all other email disclaimers
define ( 'EMAIL_DISCLAIMER_NEW_CUSTOMER', 'このメールアドレスは、あなたによってまたは他の顧客によって私達に与えられました。 アカウントにサインアップしますまたは誤ってこのメールを受け取った場合は、%sにメールを送ってください。' );
define ( 'TEXT_BIRTHDAY_SPECIAL_INFO', 'はい、誕生日特別な割引き券を受信したいと思います。' );
define ( 'TEXT_SHIPPING_ADDRESS_INFO', '<span style="font-weight:bold;">いくつかの運送会社は（例えば、DHLなど）メールボックスに出荷しないため</span>詳細な郵便の住所を記入してください。' );
define ( 'TEXT_REMEMBER_ME_WORDS', '自動的に次の訪問にログインを希望しますか。 ' );
define ( 'TEXT_EMAIL_RECEIVE_INFO', 'はい、最新の製品、スペシャルオファー、プロモーションニュースとその他のお知らせについての電子メールを受信したいと思います。' );
?>
