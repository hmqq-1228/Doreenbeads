<?php

/**

 * @package languageDefines

 * @copyright Copyright 2003-2006 Zen Cart Development Team

 * @copyright Portions Copyright 2003 osCommerce

 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0

 * @version $Id: index.php 6531 2007-06-26 00:55:30Z drbyte $

 */
define ( 'TEXT_MAIN', 'この主要な定義文は英語用のページに定義されているテンプレートファイルを存在しない場合は使用できます。 それは次の場所にあります： <strong>/includes/languages/japanese/index.php</strong>' );

// Showcase vs Store

if (STORE_STATUS == '0') {

	define ( 'TEXT_GREETING_GUEST', 'ようこそ <span class="greetUser">ゲスト様</span>  <a href="%s">ログインしませんか？</a>?' );
} else {

	define ( 'TEXT_GREETING_GUEST', 'ようこそ、私たちのオンラインショーケースをお楽しみください。' );
}

define ( 'TEXT_GREETING_PERSONAL', 'こんにちは <span class="greetUser">%s</span>! 宜しければ、我々の <a href="%s">最新の追加商品をご覧下さい</a>。' );

define ( 'TEXT_INFORMATION', 'あなたのメインのインデックスページを定義するには、こちらをクリックします。' );

// moved to english

// define('TABLE_HEADING_FEATURED_PRODUCTS','Featured Products');

// define('TABLE_HEADING_NEW_PRODUCTS', 'New Products For %s');

// define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Upcoming Products');

// define('TABLE_HEADING_DATE_EXPECTED', 'Date Expected');

if (($category_depth == 'products') || (zen_check_url_get_terms ())) {

	// This section deals with product-listing page contents

	define ( 'HEADING_TITLE', '在庫商品' );

	define ( 'TABLE_HEADING_IMAGE', '商品画像' );

	define ( 'TABLE_HEADING_MODEL', 'モデル' );

	define ( 'TABLE_HEADING_PRODUCTS', '商品名' );

	define ( 'TABLE_HEADING_MANUFACTURER', 'メーカー' );

	define ( 'TABLE_HEADING_QUANTITY', '数量' );

	define ( 'TABLE_HEADING_PRICE', '価格' );

	define ( 'TABLE_HEADING_WEIGHT', '重量(グラム)' );

	define ( 'TABLE_HEADING_BUY_NOW', '今すぐ購入します' );

	define ( 'TEXT_NO_PRODUCTS', 'このカテゴリの商品はありません。' );

	define ( 'TEXT_NO_PRODUCTS2', 'このメーカーの商品はありません。' );

	define ( 'TEXT_NUMBER_OF_PRODUCTS', '商品番号 ' );

	define ( 'TEXT_SHOW', '並び替え：' );

	define ( 'TEXT_BUY', '購入する 1 ’' );

	define ( 'TEXT_NOW', '’ 今' );

	define ( 'TEXT_ALL_CATEGORIES', 'すべてのカテゴリ' );

	define ( 'TEXT_ALL_MANUFACTURERS', 'すべてのメーカー' );
} elseif ($category_depth == 'top') {

	// This section deals with the "home" page at the top level with no options/products selected

	/* Replace this text with the headline you would like for your shop. For example: 'Welcome to My SHOP!' */

	define ( 'HEADING_TITLE', 'パンドラ卸売に適したビーズやチャーム' );
} elseif ($category_depth == 'nested') {

	// This section deals with displaying a subcategory

	/* Replace this line with the headline you would like for your shop. For example: 'Welcome to My SHOP!' */
}

?>