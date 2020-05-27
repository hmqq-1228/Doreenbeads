<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
//  Original contrib by Vijay Immanuel for osCommerce, converted to zen by dave@open-operations.com - http://www.open-operations.com
//  $Id: links_manager.php 2006-12-22 Clyde Jones
//
define('NAVBAR_SUB_TITLE', 'ジュエリー相互リンク-サイトを提出する');
define('NAVBAR_TITLE_1', 'リンク');
define('NAVBAR_TITLE_2', 'リンクを提出する');
define('HEADING_TITLE', '<h1>リンクの提出</h1>');
define('SUBMIT_RULE', '<p>あなたのリンクの最も適切なカテゴリを選択してください。必要に応じて、<strong>' . STORE_NAME . '</strong>はカテゴリを変更したり、説明を編集する権利を有します。</p>');
define('LINKS_SUCCESS','ご提出されたサイトは7営業日以内に審査されます。サイトが正常にリストされたら、あなたに電子メールをご送信します。もし何かご質問やご提案がある場合、気兼ねなく <a href="' . zen_href_link(FILENAME_CONTACT_US) . '">ご連絡ください</a>いつでも御用を勤めます。</p>');
define('TEXT_MAIN', 'ウェブサイトを提出するには、以下のフォームにご記入ください。');
define('EMAIL_SUBJECT', '' . STORE_NAME . '相互リンクへようこそ');
define('EMAIL_GREET_NONE', '%s' . "\n\n");
define('EMAIL_WELCOME', '<b>' . STORE_NAME . '</b>相互リンクプログラムへようこそ' . "\n\n");
define('EMAIL_TEXT', 'リンクが成功的に' . STORE_NAME . 'に提出されました。我々がそれを確認の上、すぐリストに追加します。' ."\n". '我々は提出のステータスに関する電子メールを送信します。48時間以内にそれを受け取っていない場合は、我々に連絡してください。そして、もう一度リンクをご提供お願いします。' . "\n\n");
define('EMAIL_CONTACT', '我々の相互リンクプログラムにお困りのことがございましたら、店舗の所有者にメールしてください: ' . STORE_OWNER_EMAIL_ADDRESS . "\n\n");
define('EMAIL_WARNING', '<b>ご注意:</b>このメールアドレスはリンク提出の際に、我々に与えられました。何か質問がございましたら、' . STORE_OWNER_EMAIL_ADDRESS . "にお問い合わせください\n\n");
define('EMAIL_OWNER_SUBJECT', STORE_NAME.'にリンクを提出');
define('EMAIL_OWNER_TEXT', '新しいリンクは' . STORE_NAME . 'に提出されました。それはまだ承認されていません。このリンクを検証して、アクティブにします。' . "\n\n");
define('TEXT_LINKS_HELP_LINK', '&nbsp;ヘルプ&nbsp;[?]');
define('HEADING_LINKS_HELP', 'リンクヘルプ');
define('TEXT_LINKS_HELP', '<b>サイトタイトル:</b>ウェブサイトについて説明的なタイトル<br><br><b>URL:</b>あなたのウェブサイトの絶対アドレスは \'http://\'を含みます。<br><br><b>カテゴリ:</b> ウェブサイトに属する最も適切なカテゴリ<br><br><b>説明:</b>ウェブサイトの簡単な説明<br><br><b>画像URL:</b>提出されたいの画像の絶対URLは \'http://\'を含みます。この画像はウェブサイトのリンクとともに表示されます。<br>例: http://your-domain.com/path/to/your/image.gif <br><br><b>お名前:</b> あなたのフルネーム<br><br><b>メール:</b>あなたのメールアドレス。電子メールで通知されますから、有効なメールアドレスを入力してください。<br><br><b>互恵的なページ:</b> リンクページの絶対URLは当社のウェブサイトへのリンクがリスト/表示されます。<br>例: http://your-domain.com/path/to/your/links_page.php');
define('TEXT_CLOSE_WINDOW', '<u>ウインドウ[x]を閉じる</u>');
define('TEXT_DONOT_REPEAT_SUBMIT','警告:我々は相互リンクの要求を受けました。繰り返してそれを提出しないでください');
define('LINKS_TITLE_TIPS',''.ENTRY_LINKS_TITLE_MIN_LENGTH."-".ENTRY_LINKS_TITLE_MAX_LENGTH."の文字をご入力ください");
define('LINKS_URL_TIPS','サイトの完全かつ正確なURLを入力します。"http://"を含む');
define('LINKS_DESCRIPTION_TIPS','1. テキストの内容のみ<br/>&nbsp;&nbsp;2. '.ENTRY_LINKS_DESCRIPTION_MIN_LENGTH."-".ENTRY_LINKS_DESCRIPTION_MAX_LENGTH.'の文字をご入力ください');
define('LINKS_EMAIL_TIPS','サイトが成功的にリストされたら、あなたに電子メールを送信します。');
define('LINKS_NAME_TIPS','少なくとも'. ENTRY_LINKS_CONTACT_NAME_MIN_LENGTH.'の文字が必要');
define('LINKS_RECIPROCAL_TIPS', '我々のリンクが含まれているサイトページのURL');
define('LINKS_NAME_WRONG_LEAST1','ご入力ください ');
define('LINKS_NAME_WRONG_LEAST2',' 最小の文字数');
define('LINKS_NAME_WRONG_MORE1','最大の文字数  ');
define('LINKS_NAME_WRONG_MORE2',' 文字');
define('LINKS_WRONG_EMAILS','間違った電子メール形式！');
define('LINKS_WRONG_URLS','間違った URLフォーマット！');
?>