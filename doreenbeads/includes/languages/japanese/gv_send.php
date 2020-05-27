<?php
define ( 'HEADING_TITLE', '送信 ' . TEXT_GV_NAME );
define ( 'HEADING_TITLE_CONFIRM_SEND', ' ' . TEXT_GV_NAME . ' の確認を送信する' );
define ( 'HEADING_TITLE_COMPLETED', TEXT_GV_NAME . '送信済み' );
define ( 'NAVBAR_TITLE', '送信 ' . TEXT_GV_NAME );
define ( 'EMAIL_SUBJECT', 'メッセージから ' . STORE_NAME );
define ( 'HEADING_TEXT', 'あなたが送信したい ' . TEXT_GV_NAME . ' のお名前、メールアドレスと金額を入力してください。
詳細については、 <a href="' . zen_href_link ( FILENAME_GV_FAQ, '', 'NONSSL' ) . '">' . GV_FAQ . '.</a>をご覧下さい。' );
define ( 'ENTRY_NAME', '受信者のお名前：' );
define ( 'ENTRY_EMAIL', '受信者の電子メール：' );
define ( 'ENTRY_MESSAGE', 'あなたのメッセージ：' );
define ( 'ENTRY_AMOUNT', '送る金額：' );
define ( 'ERROR_ENTRY_TO_NAME_CHECK', '受信者の名前をお受け取りいたしません。下に記入してください。 ' );
define ( 'ERROR_ENTRY_AMOUNT_CHECK', ' ' . TEXT_GV_NAME . ' の金額は正しく表示されません。もう一度お試し下さい。' );
define ( 'ERROR_ENTRY_EMAIL_ADDRESS_CHECK', 'このメールアドレスは正しいですか？もう一度お試し下さい。' );
define ( 'MAIN_MESSAGE', '%s から %sまでに値する' . TEXT_GV_NAME . 'を送信します、, そのアドレスは　%sです。これらの詳細が正しくない場合は<strong>編集</strong> ボタンをクリックして、あなたのメッセージを編集することができます。<br /><br />送信しているメッセージは：<br /><br />' );
define ( 'SECONDARY_MESSAGE', '親愛なる %s,<br /><br />' . '%s から %sまでに値する' . TEXT_GV_NAME . 'を送信してしまいました。' );
define ( 'PERSONAL_MESSAGE', '%s 言う：' );
define ( 'TEXT_SUCCESS', 'おめでとうございます、' . TEXT_GV_NAME . ' は送信してしまいました。' );
define ( 'TEXT_SEND_ANOTHER', '別の ' . TEXT_GV_NAME . 'を送信することがよろしいでしょうか?' );
define ( 'TEXT_AVAILABLE_BALANCE', 'ギフト券アカウント' );

define ( 'EMAIL_GV_TEXT_SUBJECT', '%sからのギフト' );
define ( 'EMAIL_SEPARATOR', '----------------------------------------------------------------------------------------' );
define ( 'EMAIL_GV_TEXT_HEADER', 'おめでとうございます、%sに値するの' . TEXT_GV_NAME . ' を受けてしまいました。' );
define ( 'EMAIL_GV_FROM', 'この' . TEXT_GV_NAME . ' %sによって送られました。' );
define ( 'EMAIL_GV_MESSAGE', 'メッセージには以下のようにあって：  ' );
define ( 'EMAIL_GV_SEND_TO', 'こんにちは、 %s' );
define ( 'EMAIL_GV_REDEEM', ' ' . TEXT_GV_NAME . 'を引き換えるには下のリンクをクリックしてください。 また ' . TEXT_GV_REDEEM . 'を記入してください: %s  念のため、あなたには問題があります。' );
define ( 'EMAIL_GV_LINK', '引き換えるには、こちらをクリックしてください' );
define ( 'EMAIL_GV_VISIT', 'または訪問 ' );
define ( 'EMAIL_GV_ENTER', '  ' . TEXT_GV_REDEEM . ' を入力してください' );
define ( 'EMAIL_GV_FIXED_FOOTER', '上記の自動化されたリンクを使用して ' . TEXT_GV_NAME . ' を引き換える時に問題がある場合は' . "\n" . '当店でのチェックアウトプロセス中に ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM . ' も入力できます。' );
define ( 'EMAIL_GV_SHOP_FOOTER', '' );
?>