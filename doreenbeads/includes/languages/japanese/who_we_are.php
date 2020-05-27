<?php
define ( 'NAVBAR_TITLE', '我々は誰ですか。' );
define ( 'PAGE_TITLE', '我々は誰ですか。' );
define ( 'TEXT_TERMS_AND_CONDITIONS', '取引条件' );
switch ($_GET ['id']) {
	case 1 :
		define ( 'NAVBAR_TITLE_1', BOX_INFORMATION_ABOUT_US );
		break;
	case 2 :
		define ( 'NAVBAR_TITLE_1', TEXT_TERMS_AND_CONDITIONS );
		break;
	case 3 :
		define ( 'NAVBAR_TITLE_1', BOTTOM_PRIVACY_POLICY );
		break;
	case 4 :
		define ( 'NAVBAR_TITLE_1', BOX_INFORMATION_CONTACT );
		break;
	default :
		define ( 'NAVBAR_TITLE_1', BOX_INFORMATION_ABOUT_US );
}
define ( 'HEADING_TITLE', 'ご連絡ください' );
define ( 'TEXT_SUCCESS', 'あなたのメッセージは正常に送信されました。' );
define ( 'EMAIL_SUBJECT', 'からのメッセージ' . STORE_NAME );

define ( 'ENTRY_NAME', 'おなまえ：' );
define ( 'ENTRY_EMAIL', 'メールアドレス：' );
define ( 'ENTRY_ENQUIRY', 'メッセージ：' );

define ( 'SEND_TO_TEXT', '：に電子メールを送信' );
define ( 'ENTRY_EMAIL_NAME_CHECK_ERROR', '申し訳ございませんが、お名前は正しいですか。 我々のシステムは少なくとも ' . ENTRY_FIRST_NAME_MIN_LENGTH . 'キャラクターが必要です。 もう一度お試し下さい。' );
define ( 'ENTRY_EMAIL_CONTENT_CHECK_ERROR', 'メッセージはお忘れになりましたか。ご連絡をお待ちしております。 下のテキストエリアにコメントを入力することができます。' );
// by zjl --begin
define ( 'TEXT_CONTACT_US_BY_TELEPHONE', '<div style="margin-top:10px;">
<h3><span style="color:green">4. 電話でご連絡ください。</span></h3>
&nbsp;&nbsp;&nbsp;&nbsp;電話番号： ' . TEXT_TEL_NUMBER . '
</div>
<div style="padding-top:10px;">
状況が緊急であり、呼び出しが必要な場合は、お気軽にお電話下さい。ご連絡をお待ちしております。<br /><br />
<span style="color:red;">追加情報はご注意ください：</span><br />
時々、電子メール通信が信用できません（メールが途中で消えてしまいますまたはISPフィルタによってブロックされる）。従って、48時間以内に我々の応答を取得しない場合は、下記の応対方法を提案させていただきます：<br />
1)メールの受信トレイに迷惑またはスパムメールフォルダを確認してください（場合によってはISPフィルタによって返信メールが誤ってスパムとみなします） <br />
2) 再度ご連絡しようとすると、「LiveHelp」をクリックしますまたは電話メールをもう一度送信します。<br />
</div>
<div style="padding-top:10px;">
<table width="100%" border="0">
  <tr>
    <td bgcolor="#FFFFEC"><strong><font color="#FF0000">注意してください！</font></strong> お客様各位、我々は常に信頼性と一貫性の優れた顧客サービスを提供することを目指しております。 ただし、我々のサービスにご不満がある場合は、我々と連絡を取って <a href="<?php echo HTTP_SERVER ?>/index.php?main_page=feedback">苦情を出されます </a>。我々はそれを対処していただきます。 </td>
  </tr>
</table>
</div>' );
define ( 'TEXT_CONTACT_US_TIME_INFO', '<span style="font-weight:bold;line-height:150%;">カスタマーサービス時間</span><br />
ご連絡の便宜のため、当社の営業時間をご覧ください。我々は、週6日働き（月曜日ー土曜日）、毎日8:30-18:00中国北京時間 現在の北京時間は：' );
define ( 'TEXT_BEIJING_TIME', '中国時間' );
define ( 'TEXT_SEND_SUCCESS', 'ありがとうございます。<br />
あなたの電子メールは正常に我々に送信されました。<br />
当社の営業日で24時間以内に返信されます。' );

define ( 'TEXT_PLEASE_PROVIDE_VALID_EMAIL_ADDRESS', '有効なメールアドレスを提供してください。' );

define ( 'TEXT_CONTACT_US_TO_CUSTOMER_NOTIOCE', '当社のウェブサイト上に伝言を残しているため、このメールはあなたに送信します。それはあなたのメッセージのコピーです。' );
define ( 'EMAIL_SUBJECT_TO_CUSTOMER', 'メッセージは8seasonsチームに正常に送信されました' );

define ( 'TEXT_OUR_TEAM', '我々のチーム' );
define ( 'TEXT_QUALITY_CONTROL', ' 品質管理' );
define ( 'TEXT_HELP_CENTER', ' ヘルプセンター' );
define ( 'TEXT_CUSTOMER_FEEDBACK', ' 顧客フィードバック' );
define ( 'TEXT_SHIPPING_INFO', ' 配送情報' );
define ( 'TEXT_CUSTOMER_SERVICE', ' 顧客サービス' );
define ( 'TEXT_CONTACT_US', 'お問い合わせ' );
define ( 'TEXT_ABOUT_US', '私達について' );
define ( 'TEXT_TESTIMONIALS', 'お客様の声' );

?>