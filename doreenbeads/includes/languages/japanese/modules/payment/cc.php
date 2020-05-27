<?php
define ( 'MODULE_PAYMENT_CC_TEXT_TITLE', 'クレジットカード' );
define ( 'MODULE_PAYMENT_CC_TEXT_DESCRIPTION', 'クレジットカードテスト情報：<br /><br />CC#: 4111111111111111<br />有効期限：いつでも' );
define ( 'MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_TYPE', 'クレジットカードの種類：' );
define ( 'MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_OWNER', 'カード所有者の氏名：' );
define ( 'MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_NUMBER', 'カード番号：' );
define ( 'MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_CVV', 'CVV番号 (<a href="javascript:popupWindow(\'' . zen_href_link ( FILENAME_POPUP_CVV_HELP ) . '\')">' . '詳細情報' . '</a>)' );
define ( 'MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_EXPIRES', '有効期限：' );
define ( 'MODULE_PAYMENT_CC_TEXT_JS_CC_OWNER', '* クレジットカード所有者の氏名は少なくとも ' . CC_OWNER_MIN_LENGTH . ' キャラクターでなければなりません。\n' );
define ( 'MODULE_PAYMENT_CC_TEXT_JS_CC_NUMBER', '* クレジットカード番号は少なくとも ' . CC_NUMBER_MIN_LENGTH . ' キャラクターでなければなりません。\n' );
define ( 'MODULE_PAYMENT_CC_TEXT_ERROR', 'クレジットカードのエラー：' );
define ( 'MODULE_PAYMENT_CC_TEXT_JS_CC_CVV', '* CVV番号が少なくとも' . CC_CVV_MIN_LENGTH . 'キャラクターでなければなりません。 \n' );
define ( 'MODULE_PAYMENT_CC_TEXT_EMAIL_ERROR', '警告 - 配置エラー： ' );
define ( 'MODULE_PAYMENT_CC_TEXT_EMAIL_WARNING', '警告：お客様はCC支払いモジュールを有効にしていましたが、電子メールでCC情報を送信することを設定しません。その結果、ＣＣ番号を使用して、この方法で行われたご注文を処理することができません。[管理] - > [モジュール] - > [お支払い方法]  - > CC->編集、そのような順序に進んで、CC情報を送信の優先な電子メールアドレスを設定します。' . "\n\n\n\n" );
define ( 'MODULE_PAYMENT_CC_TEXT_MIDDLE_DIGITS_MESSAGE', 'オンライン注文と一緒に提出することができるように、経理部門にこのメールを送信してください。それが' . "\n\n" . 'に関してします。注文： %s' . "\n\n" . 'ミドル数字： %s' . "\n\n" );
?>