<?php
define ( 'NAVBAR_TITLE', '我々は誰ですか' );
define ( 'PAGE_TITLE', '我々は誰ですか' );
define ( 'TEXT_WRITE_TESTIMONIAL', '表彰状をシェアしたいですか。' );
if (isset ( $_SESSION ['customer_id'] ) && $_SESSION ['customer_id'] != '') {
	define ( 'TEXT_TESTIMONIAL_DESCRIPTION', '我々のお客様からフィードバックとシェアすることをお誇りします。そのお客様のおかげでここで彼らのショッピング体験がシェアできます。そのすべての大切な表彰状はビジネスに沿って我々の努力と奉仕の見返りに最高のご褒美です。シェアしたい表彰状をお持ちになっていれば、次のフォームで書くことができます。お時間をありがとうございます。' );
} else {
	define ( 'TEXT_TESTIMONIAL_DESCRIPTION', '我々のお客様からフィードバックとシェアすることをお誇りします。 そのお客様のおかげでここで彼らのショッピング体験がシェアできます。そのすべての大切な表彰状はビジネスに沿って我々の努力と奉仕の見返りに最高のご褒美です。<br />表彰状を書くのは<a href="' . zen_href_link ( FILENAME_LOGIN ) . '">ログイン</a> または <a href="' . zen_href_link ( FILENAME_CREATE_ACCOUNT ) . '">新規登録</a>してください。' );
}




define ( 'TEXT_NO_PUBLISH', '( 公開されません)' );
define ( 'TEXT_TESTIMONIAL_REQUIRED', '<span style="color:red">*</span> ' );
define ( 'TEXT_CUSTOMER_NAME', 'お名前： ' );
define ( 'TEXT_CUSTOMER_EMAIL', 'メールアドレス： ' );
define ( 'TEXT_TESTIMONIAL_COMMENT', 'コメント： ' );
define ( 'TEXT_ERROR_CUSTOMER_NAME', 'あなたの名前を入力してください。' );
define ( 'TEXT_ERROR_CUSTOMER_EMAIL', '効なメールアドレスを入力してください（それは公開されません）' );
define ( 'TEXT_ERROR_COMMENT_REQUIRED', 'コメントを入力してください。' );
define ( 'TEXT_SUCCESS_WRITE_TESTIMONIAL', 'あなたのコメントは正常に追加されました。当社のウェブサイトへのご支援、ご清聴どうもありがとうございました。' );
define ( 'TEXT_TESTIMONIAL_REQUIRED_INFO', '<span style="color:red">* 必須</span>' );
define ( 'EMAIL_TESTIMONIAL_PENDING_SUBJECT', '表彰状を受信しました。' );
define ( 'EMAIL_TESTIMONIAL_CONTENT_DETAILS', '表彰状の詳細： %s' );
define ( 'EMAIL_TESTIMONIAL_CUSTOMER_NAME', 'お客様の名前： %s' );
define ( 'EMAIL_TESTIMONIAL_CUSTOMER_EMAIL', 'お客様の電子メール： %s' );
define ( 'EMAIL_TESTIMONIAL_COMMENT', 'コメント： %s' );
define ( 'TEXT_TESTIMONIAL_DESCRIPTIONS', '我々のお客様からフィードバックとシェアすることをお誇りします。それでここでご経験をシェアするお客様に感謝しております。 すべての大切な表彰状が8seasonsで高く評価されています。 ご注目をさせて頂きま、ありがとうございます。' );
define ( 'TEXT_TESTIMONIAL_INPUT_TITLE', '表彰状をアップロード — 我々にコメントを送る' );
define ( 'TEXT_TESTIMONIAL_WELCOME_SUBMIT', '以下の部分であなたの表彰状を提出します' );
define ( 'TEXT_TESTIMONIAL_NEED_TO_LOGIN', '*表彰状を提出する前に <a style="color:#0179C3" href="' . zen_href_link ( FILENAME_LOGIN, '', 'SSL' ) . '">ログイン</a> または <a style="color:#0179C3" href="' . zen_href_link ( FILENAME_CREATE_ACCOUNT ) . '">新規登録</a> してください。' );
define ( 'TEXT_WRITE_YOUR_COMMENTS', 'コメントをお書きください：' );
define ( 'TEXT_CUSTOMER_TESTIMONIAL', 'お客様の声' );
define ( 'TEXT_SEE_MORE', 'もっと見る' );
define ( 'TEXT_REPLY', '応答：' );
define ( 'TEXT_TERMS_AND_CONDITIONS', '取引条件' );
define ( 'WRITE_A_TESTIMONIAL', '表彰状を書く' );
?>