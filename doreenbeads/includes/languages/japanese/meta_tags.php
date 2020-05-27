<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: meta_tags.php 6668 2007-08-16 10:05:09Z drbyte $
 */

// page title
//jessa 2009-08-07 Update the TITLE on index page "zen cart!"
//define('TITLE','zen cart!')
define('TITLE', '無料配送');
//eof jessa

// Site Tagline
//jessa 2009-08-07 Update the SITE_TAGLINE on meta_tags.php page "the Art of E-commeric"
//define('SITE_TAGLINE', 'The Art of E-commerce')
define('SITE_TAGLINE', '卸売パンドラスタイルビーズチャーム');
//eof jessa

// Custom Keywords
//jessa 2009-08-07 Update the CUSTOM_KEYWORDS on on meta_tags.php page "ecommerce, open source, shop, online shopping"
define('CUSTOM_KEYWORDS', '卸売パンドラスタイルビーズ、チャーム、チェーン、用品');
//eof jessa

// Home Page Only:
//jessa 2009-08-09
//update define('HOME_PAGE_META_DESCRIPTION', '')
  define('HOME_PAGE_META_DESCRIPTION', '全てのアイテムについて無料配送をご提供します。主に卸売パンドラスタイルビーズチャーム、スネークチェーンブレスレットとそのほかの用品(安全チェーン、パンドラスタイルランプワークガラスビーズ、パンドラスタイルチャーム、クリップ、スペーサビーズを含む)');
//eof jessa
//update define('HOME_PAGE_META_KEYWORDS','')
  define('HOME_PAGE_META_KEYWORDS', '卸売パンドラスタイルビーズ、卸売パンドラスタイルチャーム、卸売パンドラスタイルチェーン、卸売パンドラスタイル用品');
//eof jessa
  // NOTE: If HOME_PAGE_TITLE is left blank (default) then TITLE and SITE_TAGLINE will be used instead.
  define('HOME_PAGE_TITLE', ''); // usually best left blank


// EZ-Pages meta-tags.  Follow this pattern for all ez-pages for which you desire custom metatags. Replace the # with ezpage id.
// If you wish to use defaults for any of the 3 items for a given page, simply do not define it. 
// (ie: the Title tag is best not set, so that site-wide defaults can be used.)
// repeat pattern as necessary
  define('META_TAG_DESCRIPTION_EZPAGE_#','');
  define('META_TAG_KEYWORDS_EZPAGE_#','');
  define('META_TAG_TITLE_EZPAGE_#', '');

// Per-Page meta-tags. Follow this pattern for individual pages you wish to override. This is useful mainly for additional pages.
// replace "page_name" with the UPPERCASE name of your main_page= value, such as ABOUT_US or SHIPPINGINFO etc.
// repeat pattern as necessary
  define('META_TAG_DESCRIPTION_page_name','');
  define('META_TAG_KEYWORDS_PAGE_page_name','');
  define('META_TAG_TITLE_PAGE_page_name', '');

// Review Page can have a lead in:
  define('META_TAGS_REVIEW', 'レビュー: ');

// separators for meta tag definitions
// Define Primary Section Output
  define('PRIMARY_SECTION', ' : ');

// Define Secondary Section Output
  define('SECONDARY_SECTION', ' - ');

// Define Tertiary Section Output
  define('TERTIARY_SECTION', ', ');

// Define divider ... usually just a space or a comma plus a space
  define('METATAGS_DIVIDER', ' ');

// Define which pages to tell robots/spiders not to index
// This is generally used for account-management pages or typical SSL pages, and usually doesn't need to be touched.
  define('ROBOTS_PAGES_TO_SKIP','login,logoff,create_account,account,account_edit,account_history,account_history_info,account_newsletters,account_notifications,account_password,address_book,advanced_search,advanced_search_result,checkout_success,checkout_process,checkout_shipping,checkout_payment,checkout_confirmation,cookie_usage,create_account_success,contact_us,download,download_timeout,customers_authorization,down_for_maintenance,password_forgotten,time_out,unsubscribe,info_shopping_cart,popup_image,popup_image_additional,product_reviews_write,ssl_check');


// favicon setting
// There is usually NO need to enable this unless you need to specify a path and/or a different filename
//  define('FAVICON','favicon.ico');

?>