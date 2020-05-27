<?php
define ( 'NAVBAR_TITLE', 'ログインがタイムアウトしました。' );
define ( 'HEADING_TITLE', 'セッションが期限切れになっています。' );
define ( 'HEADING_TITLE_LOGGED_IN', '大変申し訳ございませんが、要求されたアクションを実行することはできません。 ' );
define ( 'TEXT_INFORMATION', '<p>ご注文をしている場合はログインしてください。それからショッピングカートが復元されます。その後、戻ってチェックアウトして最終的な購入を完了させます。</p><p>ご注文を完了したら、それを確認したい場合は' . (DOWNLOAD_ENABLED == 'true' ? ', またはダウンロードがあって、それを取得したい場合は' : '') . ',  <a href="' . zen_href_link ( FILENAME_ACCOUNT, '', 'SSL' ) . '">私のアカウント</a> ページにチェックしてください。</p>' );

define ( 'TEXT_INFORMATION_LOGGED_IN', 'アカウントにまだログアウトしていません。ショッピングを続けることができます。メニューから目的地を選択してください。' );

define ( 'HEADING_RETURNING_CUSTOMER', 'ログイン' );
define ( 'TEXT_PASSWORD_FORGOTTEN', 'パスワードを忘れましたか。' );
?>