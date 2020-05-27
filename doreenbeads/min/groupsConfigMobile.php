<?php
/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

/**
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http://yourdomain/min/builder/
 *
 * See http://code.google.com/p/minify/wiki/CustomSource for other ideas
 **/

return array (
    'webDefault.css' => array (
        DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS . 'common.css',
        /*DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS . 'main.css',
        DEFAULT_CSS . 'form.css',*/
        DEFAULT_CSS . 'shopping_cart.css'
    ),
    'webDefault.js' => array (
        DEFAULT_JS . 'jscript_jquery.js',
        DEFAULT_JS . 'hammer.min.js',
        DEFAULT_JS . 'jquery.hammer.js',
        DEFAULT_JS . 'bootstrap.js',
        DEFAULT_JS . 'swipe.js',
        DEFAULT_JS . 'lang/' . $min_language_code . '.js',
        DEFAULT_JS . 'common.js',
        DEFAULT_JS . 'jscript_product_addto.js',
        DEFAULT_JS . 'lazyload.js',
        DEFAULT_JS . 'jquery.form.js',
        DEFAULT_JS . 'login.js'
    ),
    'index.css' => array (
        DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS . 'main.css',
        DEFAULT_CSS . 'form.css'
    ),
    'advanced_search_result.css'=> array (
        DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS . 'main.css',
        DEFAULT_CSS . 'form.css'
    ),
    'products_common_list.css'=> array (
        DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS . 'main.css',
        DEFAULT_CSS . 'form.css'
    ),
    'promotion.css'=> array(
        DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS . 'main.css',
        DEFAULT_CSS . 'form.css'
    ),
    'non_accessories.css'=> array(
        DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS . 'main.css',
        DEFAULT_CSS . 'form.css'
    ),
    'promotion_deals.css'=> array(
        DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS . 'main.css',
        DEFAULT_CSS . 'form.css'
    ),
    'promotion_price.css'=> array(
        DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS . 'main.css',
        DEFAULT_CSS . 'form.css'
    ),
    'invite_friends.css'=> array (
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'invite_friends.css'
    ),
    'product_info.css' => array (
        DEFAULT_CSS . 'bootstrap.css',
        DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS . 'main.css',
        DEFAULT_CSS . 'form.css'
    ),
    'learning_center.css' => array(
        DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS . 'main.css',
        DEFAULT_CSS . 'form.css'
    ),
    'learning_center.js' => array (
        DEFAULT_JS . 'jscript_jquery.js',
        DEFAULT_JS . 'hammer.min.js',
        DEFAULT_JS . 'jquery.hammer.js',
        DEFAULT_JS . 'bootstrap.js',
        DEFAULT_JS . 'swipe.js',
        DEFAULT_JS . 'lang/' . $min_language_code . '.js',
        DEFAULT_JS . 'common.js',
        DEFAULT_JS . 'jscript_product_addto.js',
        DEFAULT_JS . 'lazyload.js',
        DEFAULT_JS . 'learning_center.js'
    ),
    'product_info.js' => array (
        DEFAULT_JS . 'jscript_jquery.js',
        DEFAULT_JS . 'hammer.min.js',
        DEFAULT_JS . 'jquery.hammer.js',
        DEFAULT_JS . 'bootstrap.js',
        DEFAULT_JS . 'lang/' . $min_language_code . '.js',
        DEFAULT_JS . 'common.js',
        DEFAULT_JS . 'product_info.js',
        DEFAULT_JS . 'jquery.lazyload.js',
        DEFAULT_JS . 'lazyload.js',
    ),
    'facebook_like.css'=> array (
        DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS . 'main.css',
        DEFAULT_CSS . 'form.css'
    ),
    'spin_to_win.css'=> array (
        DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS . 'main.css',
        DEFAULT_CSS . 'form.css'
    ),
    'shopping_cart.css' => array (
        DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'shopping_cart.css'
    ),
    'shopping_cart.js' => array (
        DEFAULT_JS . 'jscript_jquery.js',
        DEFAULT_JS . 'hammer.min.js',
        DEFAULT_JS . 'jquery.hammer.js',
        DEFAULT_JS . 'bootstrap.js',
        DEFAULT_JS . 'swipe.js',
        DEFAULT_JS . 'lang/' . $min_language_code . '.js',
        DEFAULT_JS . 'common.js',
        DEFAULT_JS . 'shopping_cart.js',
        DEFAULT_JS . 'lazyload.js',
    ),
    'checkout.css' => array (
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'checkout.css'
    ),
    'checkout.js' => array (
        DEFAULT_JS . 'jscript_jquery.js',
        DEFAULT_JS . 'hammer.min.js',
        DEFAULT_JS . 'jquery.hammer.js',
        DEFAULT_JS . 'bootstrap.js',
        DEFAULT_JS . 'swipe.js',
        DEFAULT_JS . 'lang/' . $min_language_code . '.js',
        DEFAULT_JS . 'common.js',
        DEFAULT_JS . 'checkout.js',
        DEFAULT_JS . 'lazyload.js',
    ),
    'site_map.css' => array(
        DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'site_map.css'
    ),
    'checkout_payment.css' => array (
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'checkout_payment.css'
    ),
    'checkout_payment.js' => array (
        DEFAULT_JS . 'jscript_jquery.js',
        DEFAULT_JS . 'hammer.min.js',
        DEFAULT_JS . 'jquery.hammer.js',
        DEFAULT_JS . 'bootstrap.js',
        DEFAULT_JS . 'swipe.js',
        DEFAULT_JS . 'lang/' . $min_language_code . '.js',
        DEFAULT_JS . 'common.js',
        DEFAULT_JS . 'checkout_payment.js'
    ),
    'checkout_success.css' => array (
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'checkout_success.css'
    ),
    'account_history_info.css' => array(
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'account_history_info.css'
    ),
    'account_history_info.js' => array (
        DEFAULT_JS . 'jscript_jquery.js',
        DEFAULT_JS . 'hammer.min.js',
        DEFAULT_JS . 'jquery.hammer.js',
        DEFAULT_JS . 'bootstrap.js',
        DEFAULT_JS . 'swipe.js',
        DEFAULT_JS . 'lang/' . $min_language_code . '.js',
        DEFAULT_JS . 'common.js',
        DEFAULT_JS . 'account_history_info.js',
        DEFAULT_JS . 'lazyload.js',
    ),
    'order_products_snapshot.css' => array(
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'account_history_info.css'
    ),
    'myaccount.css' => array(
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'myaccount.css',
    ),
    'myaccount.js' => array(
        DEFAULT_JS . 'jscript_jquery.js',
        DEFAULT_JS . 'hammer.min.js',
        DEFAULT_JS . 'jquery.hammer.js',
        DEFAULT_JS . 'bootstrap.js',
        DEFAULT_JS . 'swipe.js',
        DEFAULT_JS . 'lang/' . $min_language_code . '.js',
        DEFAULT_JS . 'common.js',
        DEFAULT_JS . 'myaccount.js'
    ),
    'account.css' => array (
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'myaccount.css',
        DEFAULT_CSS . 'lCalendar.css'
    ),
    'account.js' => array (
        DEFAULT_JS . 'jscript_jquery.js',
        DEFAULT_JS . 'hammer.min.js',
        DEFAULT_JS . 'jquery.hammer.js',
        DEFAULT_JS . 'bootstrap.js',
        DEFAULT_JS . 'swipe.js',
        DEFAULT_JS . 'lang/' . $min_language_code . '.js',
        DEFAULT_JS . 'common.js',
        DEFAULT_JS . 'jquery.form.js',
        DEFAULT_JS . 'lCalendar.min.js',
        DEFAULT_JS . 'account.js'
    ),
    'wishlist.css' => array (
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'myaccount.css'
    ),
    'wishlist.js' => array (
        DEFAULT_JS . 'jscript_jquery.js',
        DEFAULT_JS . 'hammer.min.js',
        DEFAULT_JS . 'jquery.hammer.js',
        DEFAULT_JS . 'bootstrap.js',
        DEFAULT_JS . 'swipe.js',
        DEFAULT_JS . 'lang/' . $min_language_code . '.js',
        DEFAULT_JS . 'common.js',
        DEFAULT_JS . 'jquery.form.js',
        DEFAULT_JS . 'account.js',
        DEFAULT_JS . 'lazyload.js',
    ),
    'cash_account.css' => array (
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'myaccount.css'
    ),
    'packing_slip.css' => array (
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'myaccount.css',
        DEFAULT_CSS . 'lCalendar.css'
    ),
    'packing_slip.js' => array (
        DEFAULT_JS . 'jscript_jquery.js',
        DEFAULT_JS . 'hammer.min.js',
        DEFAULT_JS . 'jquery.hammer.js',
        DEFAULT_JS . 'bootstrap.js',
        DEFAULT_JS . 'swipe.js',
        DEFAULT_JS . 'lang/' . $min_language_code . '.js',
        DEFAULT_JS . 'common.js',
        DEFAULT_JS . 'jquery.form.js',
        DEFAULT_JS . 'lCalendar.min.js',
        DEFAULT_JS . 'account.js'
    ),
    'login.css' => array(
        DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'login.css'
    ),
    'login.js' => array(
        DEFAULT_JS . 'jscript_jquery.js',
        DEFAULT_JS . 'hammer.min.js',
        DEFAULT_JS . 'jquery.hammer.js',
        DEFAULT_JS . 'bootstrap.js',
        DEFAULT_JS . 'swipe.js',
        DEFAULT_JS . 'lang/' . $min_language_code . '.js',
        DEFAULT_JS . 'common.js',
        DEFAULT_JS . 'login.js',
        DEFAULT_JS . 'jquery.form.js'
    ),
    'register.css' => array(
        DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'shopping_cart.css',
        //DEFAULT_CSS . 'register.css'
    ),
    'register.js' => array(
        DEFAULT_JS . 'jscript_jquery.js',
        DEFAULT_JS . 'hammer.min.js',
        DEFAULT_JS . 'jquery.hammer.js',
        DEFAULT_JS . 'bootstrap.js',
        DEFAULT_JS . 'swipe.js',
        DEFAULT_JS . 'lang/' . $min_language_code . '.js',
        DEFAULT_JS . 'common.js',
        DEFAULT_JS . 'register.js'
    ),
    'forgetpwd.js' => array(
        DEFAULT_JS . 'jscript_jquery.js',
        DEFAULT_JS . 'hammer.min.js',
        DEFAULT_JS . 'jquery.hammer.js',
        DEFAULT_JS . 'bootstrap.js',
        DEFAULT_JS . 'swipe.js',
        DEFAULT_JS . 'lang/' . $min_language_code . '.js',
        DEFAULT_JS . 'common.js',
        DEFAULT_JS . 'forgetpwd.js'
    ),
    'password_reset.js' => array(
        DEFAULT_JS . 'jscript_jquery.js',
        DEFAULT_JS . 'hammer.min.js',
        DEFAULT_JS . 'jquery.hammer.js',
        DEFAULT_JS . 'bootstrap.js',
        DEFAULT_JS . 'swipe.js',
        DEFAULT_JS . 'lang/' . $min_language_code . '.js',
        DEFAULT_JS . 'common.js',
        DEFAULT_JS . 'password_reset.js'
    ),
    'product_reviews.js' => array (
        DEFAULT_JS . 'jscript_jquery.js',
        DEFAULT_JS . 'hammer.min.js',
        DEFAULT_JS . 'jquery.hammer.js',
        DEFAULT_JS . 'bootstrap.js',
        DEFAULT_JS . 'swipe.js',
        DEFAULT_JS . 'lang/' . $min_language_code . '.js',
        DEFAULT_JS . 'common.js',
        DEFAULT_JS . 'product_reviews.js'
    ),
    'product_question.js' => array (
        DEFAULT_JS . 'jscript_jquery.js',
        DEFAULT_JS . 'hammer.min.js',
        DEFAULT_JS . 'jquery.hammer.js',
        DEFAULT_JS . 'bootstrap.js',
        DEFAULT_JS . 'swipe.js',
        DEFAULT_JS . 'lang/' . $min_language_code . '.js',
        DEFAULT_JS . 'common.js',
        DEFAULT_JS . 'product_question.js'
    ),
    'address_book.css' => array (
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'address_book.css'
    ),
    'address_book.js' => array(
        DEFAULT_JS . 'jscript_jquery.js',
        DEFAULT_JS . 'hammer.min.js',
        DEFAULT_JS . 'jquery.hammer.js',
        DEFAULT_JS . 'bootstrap.js',
        DEFAULT_JS . 'swipe.js',
        DEFAULT_JS . 'lang/' . $min_language_code . '.js',
        DEFAULT_JS . 'common.js',
        DEFAULT_JS . 'address_book.js'
    ),
    'account_newsletters.css' => array (
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'address_book.css'
    ),
    'account_newsletters.js' => array(
        DEFAULT_JS . 'jscript_jquery.js',
        DEFAULT_JS . 'hammer.min.js',
        DEFAULT_JS . 'jquery.hammer.js',
        DEFAULT_JS . 'bootstrap.js',
        DEFAULT_JS . 'swipe.js',
        DEFAULT_JS . 'lang/' . $min_language_code . '.js',
        DEFAULT_JS . 'common.js',
        DEFAULT_JS . 'account_newsletters.js'
    ),
    'account_notifications.js' => array(
        DEFAULT_JS . 'jscript_jquery.js',
        DEFAULT_JS . 'hammer.min.js',
        DEFAULT_JS . 'jquery.hammer.js',
        DEFAULT_JS . 'bootstrap.js',
        DEFAULT_JS . 'swipe.js',
        DEFAULT_JS . 'lang/' . $min_language_code . '.js',
        DEFAULT_JS . 'common.js',
        DEFAULT_JS . 'account_notifications.js'
    ),
    'account_edit.css' => array (
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'address_book.css'
    ),
    'account_edit.js' => array(
        DEFAULT_JS . 'jscript_jquery.js',
        DEFAULT_JS . 'hammer.min.js',
        DEFAULT_JS . 'jquery.hammer.js',
        DEFAULT_JS . 'bootstrap.js',
        DEFAULT_JS . 'swipe.js',
        DEFAULT_JS . 'lang/' . $min_language_code . '.js',
        DEFAULT_JS . 'common.js',
        DEFAULT_JS . 'account_edit.js'
    ),
    'my_coupon.css' => array (
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'myaccount.css'
    ),
    'my_coupon.js' => array(
        DEFAULT_JS . 'jscript_jquery.js',
        DEFAULT_JS . 'hammer.min.js',
        DEFAULT_JS . 'jquery.hammer.js',
        DEFAULT_JS . 'bootstrap.js',
        DEFAULT_JS . 'swipe.js',
        DEFAULT_JS . 'lang/' . $min_language_code . '.js',
        DEFAULT_JS . 'common.js',
        DEFAULT_JS . 'account.js'
    ),
    'testimonial.js' => array(
        DEFAULT_JS . 'jscript_jquery.js',
        DEFAULT_JS . 'hammer.min.js',
        DEFAULT_JS . 'jquery.hammer.js',
        DEFAULT_JS . 'bootstrap.js',
        DEFAULT_JS . 'swipe.js',
        DEFAULT_JS . 'lang/' . $min_language_code . '.js',
        DEFAULT_JS . 'common.js',
        DEFAULT_JS . 'testimonial.js'
    ),
    'contact_us.js' => array(
        DEFAULT_JS . 'jscript_jquery.js',
        DEFAULT_JS . 'hammer.min.js',
        DEFAULT_JS . 'jquery.hammer.js',
        DEFAULT_JS . 'bootstrap.js',
        DEFAULT_JS . 'swipe.js',
        DEFAULT_JS . 'lang/' . $min_language_code . '.js',
        DEFAULT_JS . 'common.js',
        DEFAULT_JS . 'contact_us.js'
    ),
    'get_coupon.css'=> array (
        DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS . 'main.css',
        DEFAULT_CSS . 'form.css'
    ),
    'page_not_found.css'=> array (
        DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS . 'main.css',
        DEFAULT_CSS . 'form.css'
    ),
    'promotion_display_area.css'=> array (
        DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS . 'main.css',
        DEFAULT_CSS . 'form.css',
        DEFAULT_CSS . 'promotion_display_area.css'
    ),
    'track_info.css'=> array (
        DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'track_info.css'
    ),
    'no_watermark_picture.css'=> array (
        DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'no_watermark_picture.css'
    ),
    'message_list.css' => array (
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'message_list.css'
    ),
    'message_setting.css' => array (
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'address_book.css',
        DEFAULT_CSS . 'message_setting.css'
    ),
    'new_customers_receive_coupon.css' => array(
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS.'new_customers_receive_coupon.css',
    ),
    'receive_coupon.css' => array(
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS.'receive_coupon.css',
    ),
    'all_customers_receive_coupon.css' => array(
        DEFAULT_CSS . 'common.css',
        DEFAULT_CSS . 'layout.css',
        DEFAULT_CSS.'all_customers_receive_coupon.css',
    )

);