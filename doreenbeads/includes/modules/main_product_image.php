<?php
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}
//$pro = $db->Execute("select pd.products_name, p.products_image from " . TABLE_PRODUCTS . " p, ". TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . (int)$_GET['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'");
$pro = new stdClass();
$pro->fields = get_products_info_memcache((int)$_GET['products_id']);
$pro->fields['products_name'] = get_products_description_memcache((int)$_GET['products_id'], $_SESSION['languages_id']);
$products_image = $pro->fields['products_image'];
$products_name = $pro->fields['products_name'];
$products_image_extension = substr($products_image, strrpos($products_image, '.'));
$products_image_base = str_replace($products_image_extension, '', $products_image);
$img_80_text[0] = "<img class=\"lazy-img\" src=\"/includes/templates/cherry_zen/images/loading/80.gif\" data-size=\"80\" data-lazyload='" . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($products_image, 80, 80) . "' width='80' height='80' />";
$img_80_lazy_text[0] = "<img class=\"lazy-img\" src=\"/includes/templates/cherry_zen/images/loading/80.gif\" data-size=\"80\" data-lazyload='" . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($products_image, 80, 80) . "' width='80' height='80' />";
$img_310_text[0] = "<img class=\"lazy-img\" src=\"/includes/templates/cherry_zen/images/loading/310.gif\" data-size=\"310\" data-lazyload='" . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($products_image, 310, 310) . "' width='310' height='310' alt='" . zen_clean_html($products_name) . "' />";
$img_310_lazy_text[0] = "<img class=\"lazy-img\" src=\"/includes/templates/cherry_zen/images/loading/310.gif\" data-size=\"310\" data-lazyload='" . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($products_image, 310, 310) . "' width='310' height='310' alt='" . zen_clean_html($products_name) . "' />";
$img_500_text[0] = "<img class=\"lazy-img\" data-display=\"none\" src=\"/includes/templates/cherry_zen/images/loading/500.gif\" data-size=\"500\" data-lazyload='" . HTTP_IMG_SERVER . 'bmz_cache/images/' . get_img_size($products_image, 500, 500) . "' width='500' height='500'/>";
$img_500_lazy_text[0] = "<img class=\"lazy-img\" data-display=\"none\" src=\"/includes/templates/cherry_zen/images/loading/500.gif\" data-size=\"500\" data-lazyload='" . HTTP_IMG_SERVER . 'bmz_cache/images/' . get_img_size($products_image, 500, 500) . "' width='500' height='500'/>";
$img_500_text_show = "<img class=\"lazy-img\" src=\"/includes/templates/cherry_zen/images/loading/500.gif\" data-size=\"500\" data-lazyload='" . HTTP_IMG_SERVER . 'bmz_cache/images/' . get_img_size($products_image, 500, 500) . "' width='500' height='500'/>";


if ($products_image != '') {
    //database save total_number
    $img_total = get_img_count((int)$_GET['products_id']);
    if ($img_total > 6) $img_total = 6;
    for ($i = 1; $i < $img_total; $i++) {
        $img = $products_image_base . '_0' . $i . $products_image_extension;
        $img_80_text[$i] = '<img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/80.gif" data-size="80" data-lazyload="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($img, 80, 80) . '" width="80" height="80" />';
        $img_310_text[$i] = '<img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/310.gif" data-size="310" data-lazyload="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($img, 310, 310) . '" width="310" height="310" />';
        $img_500_text[$i] = '<img class="lazy-img" data-display="none" src="/includes/templates/cherry_zen/images/loading/500.gif" data-size="500" data-lazyload="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($img, 500, 500) . '" width="500" height="500" />';
        $img_80_lazy_text[$i] = '<img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/80.gif" data-size="80" data-lazyload="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($img, 80, 80) . '" width="80" height="80" />';
        $img_310_lazy_text[$i] = '<img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/310.gif" data-size="310" data-lazyload="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($img, 310, 310) . '" width="310" height="310" />';
        $img_500_lazy_text[$i] = '<img class="lazy-img" data-display="none" src="/includes/templates/cherry_zen/images/loading/500.gif" data-size="500" data-lazyload="' . HTTP_IMG_SERVER . 'bmz_cache/' . get_img_size($img, 500, 500) . '" width="500" height="500" />';
    }
}

//$dailydeal_discount = get_dailydeal_discount_by_products_id($_GET['products_id']); //20160715 去除一口价deals的折扣标签
//if (zen_not_null($dailydeal_discount)) {
//$discount_amount = $dailydeal_discount;
//}else{
$discount_amount = get_products_discount_by_products_id($_GET['products_id']);
//}