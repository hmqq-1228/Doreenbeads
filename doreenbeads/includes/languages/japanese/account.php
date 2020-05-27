<?php
define ( 'NAVBAR_TITLE', '私のアカウント' );
define ( 'HEADING_TITLE', '私のアカウント情報' );

define ( 'OVERVIEW_TITLE', '概要' );
define ( 'OVERVIEW_SHOW_ALL_ORDERS', '(注文をすべて示します)' );
define ( 'OVERVIEW_PREVIOUS_ORDERS', '以前の注文' );
define ( 'TABLE_HEADING_DATE', '日付' );
define ( 'TABLE_HEADING_ORDER_NUMBER', 'No.' );
define ( 'TABLE_HEADING_SHIPPED_TO', 'に進みます' );
define ( 'TABLE_HEADING_STATUS', '注文状況' );
define ( 'TABLE_HEADING_TOTAL', 'トータル' );
define ( 'TABLE_HEADING_VIEW', '閲覧する' );

define ( 'MY_ACCOUNT_TITLE', '私のアカウント' );
define ( 'MY_ACCOUNT_INFORMATION', '私のアカウント情報を閲覧または変更する' );
define ( 'MY_ACCOUNT_ADDRESS_BOOK', '私のアドレス帳のエントリを閲覧または変更する' );
define ( 'MY_ACCOUNT_PASSWORD', '私のアカウントのパスワードを変更します.' );

define ( 'MY_ORDERS_TITLE', '私の注文' );
define ( 'MY_ORDERS_VIEW', '注文を見る' );

define ( 'EMAIL_NOTIFICATIONS_TITLE', '電子メール通知' );
define ( 'EMAIL_NOTIFICATIONS_NEWSLETTERS', 'ニュースレターを購読または購読解除する' );
define ( 'EMAIL_NOTIFICATIONS_PRODUCTS', '私の製品通知リストを閲覧または変更する' );

define('TEXT_INVITED_WRITE_REVIEWS','お客様、<br />レビュー歓迎！ 下記の注文 ' . zen_image_button(BUTTON_IMAGE_VIEW_SMALL, BUTTON_VIEW_SMALL_ALT) . ' ボタンをクリックして、商品レビューを書いてください。当社の製品にご意見を教えて、他のユーザーと意見を共有して、どうもありがとうございました！');
define ( 'PRODUCTS_NO_ALT', '商品番号で素早く注文する' );
define ( 'TEXT_CREDIT_ACCOUNT', '<b><font color="#FF6600">以前ご購入されたことがあるために、お客様のクレジット口座に 今<big>%s%.2f</big> があります。</font></b> 詳しくは <a href="' . zen_href_link ( 'cash_account', '', 'SSL' ) . '">クレジットアカウントを見る</a> をクリックします。</b>' );

define ( 'TEXT_CREDIT_ACCOUNT1', '<b>おめでとうございます！</b> 以前のすべての購入額は：US $%.2f' );
define ( 'TEXT_CREDIT_ACCOUNT2', 'おめでとうございます、 我々の <b>%s</b> VIP お客様にアップグレードされました。 <b>%.2f</b>%% の割引は、お客様の次の注文に適用されます。RCDと組み合わせることで、合計の割引は<b>%.2f</b>%%.<br />' );

define ( 'TEXT_GROUP_ACCOUNT1', ' %.2f US$ を累積することで、 次のレベル <b>%s</b>, <b>%.2f</b>%%割引にアップグレードされます。 弊社の <a target="_blank" href="' . zen_href_link ( FILENAME_HELP_CENTER, 'id=33' ) . '">VIP ポリシー</a>をご覧下さい。<br /><br />' );

define ( 'TEXT_GROUP_ACCOUNT2', '<br/>あなたは私たちのVIP顧客になろうとしています。新しい注文金額は%.2f US$.に達する場合、<a target="_blank" href="' . zen_href_link ( FILENAME_HELP_CENTER, 'id=33' ) . '">VIP 特典</a> をお楽しみ下さい。<br /><br />' );

define ( 'TEXT_FILTER', 'フィルター' );
define ( 'TEXT_ACTION', 'アクション' );
define ( 'TEXT_CART_ADD_MORE_ITEMS_CART', 'より多くのアイテムを加えます' );
define ( 'TEXT_CART_QUICK_ADD_NOW', 'クイック追加します' );
define ( 'TEXT_CART_QUICK_ADD_NOW_TITLE', '下記のフォームを使って、商品の品番（たとえばB06512）と数量を入力してから注文できます:' );
define ( 'TEXT_CART_P_NUMBER', '部品番号' );
define ( 'TEXT_CART_P_QTY', '数量' );
define ( 'TEXT_WORD_UPDATE', 'アップデート' );
define ( 'TEXT_WORD_ALREADY_UPDATE', '保存' );
define ( 'TEXT_CART_JS_WRONG_P_NO', '誤った部品番号。 続けるには、リストからこれを削除する必要があります。' );
define ( 'TEXT_CART_JS_SORRY_NOT_FIND', '申し訳ありませんが、一部のアイテムが見つからなかった、誤った部品番号を削除してください' );
define ( 'TEXT_CART_JS_NO_STOCK', '在庫無し。 続けるには、リストからこのアイテムを削除する必要があります。' );
?>
