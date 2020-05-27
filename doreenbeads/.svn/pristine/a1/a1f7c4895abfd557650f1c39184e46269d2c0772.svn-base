<?php
define ( 'TEXT_MAIN', 'これは、テンプレート定義されたファイルが存在しない場合、英語用のページのための主要な定義文である。 それは <strong>/含み/言語/英語/index.php</strong>に位置します。' );
if (STORE_STATUS == '0') {
	define ( 'TEXT_GREETING_GUEST', ' <span class="greetUser">お客様</span>ようこそいらっしゃいませ！ <a href="%s">ログイン</a>をよろしいでしょうか?' );
} else {
	define ( 'TEXT_GREETING_GUEST', 'ようこそ、我々のオンラインショーケースをお楽しみください。' );
}

define ( 'TEXT_INFORMATION', 'メインのインデックスページ定義するにはこちらをコピーします。' );

if (($category_depth == 'products') || (zen_check_url_get_terms ())) {

	define ( 'HEADING_TITLE', '入手可能な商品' );

	define ( 'TABLE_HEADING_IMAGE', '商品画像' );

	define ( 'TABLE_HEADING_MODEL', 'モデル' );

	define ( 'TABLE_HEADING_PRODUCTS', '商品名' );

	define ( 'TABLE_HEADING_MANUFACTURER', 'メーカー' );

	define ( 'TABLE_HEADING_QUANTITY', '数量' );

	define ( 'TABLE_HEADING_PRICE', '価格' );

	define ( 'TABLE_HEADING_WEIGHT', '重量' );

	define ( 'TABLE_HEADING_BUY_NOW', '今すぐ購入します' );

	define ( 'TEXT_NO_PRODUCTS', 'ご指定のカテゴリに該当する商品はありませんでした。' );

	define ( 'TEXT_NO_PRODUCTS2', 'このメーカーに該当する商品はありませんでした。' );

	define ( 'TEXT_NUMBER_OF_PRODUCTS', '商品番号 ' );

	define ( 'TEXT_SHOW', 'によって検索結果を濾過します：' );

	define ( 'TEXT_BUY', '１買う ’' );

	define ( 'TEXT_NOW', '’ 今' );

	define ( 'TEXT_ALL_CATEGORIES', 'すべてのカテゴリ' );

	define ( 'TEXT_ALL_MANUFACTURERS', 'すべてのメーカー' );
} elseif ($category_depth == 'top') {
	define ( 'HEADING_TITLE', '' );
} elseif ($category_depth == 'nested') {

	define ( 'HEADING_TITLE', 'パンドラビーズやチャーム卸売' );

	define ( 'TEXT_SHOW', 'によって検索結果を濾過します：' );
}

?>