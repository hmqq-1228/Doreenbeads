<?php 
/**
 * tpl_footer_googleanalytics.php
 *
 * @package zen-cart analytics
 * @copyright Copyright 2004-2008 Andrew Berezin eCommerce-Service.com
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_footer_googleanalytics.php, v 2.2.1 01.09.2008 01:23 Andrew Berezin $
 */
// http://www.zen-cart.com/forum/showpost.php?p=376521&postcount=254
@define('GOOGLE_ANALYTICS_PRODUCTS_ATTRIBUTES_BRACKETS', '[]');
@define('GOOGLE_ANALYTICS_PRODUCTS_ATTRIBUTES_DELIMITER', '; ');
// @define('GOOGLE_ANALYTICS_USE_PAGENAME', 'false');
// http://www.google.com/support/googleanalytics/bin/answer.py?hl=ru&answer=55503
// http://www.google.com/support/googleanalytics/bin/answer.py?hl=ru&answer=55532
// http://www.google.com/support/googleanalytics/bin/answer.py?hl=ru&answer=55524
@define('GOOGLE_ANALYTICS_DOMAINNAME', '');
@define('GOOGLE_ANALYTICS_ALLOWLINKER', 'false');

@define('GOOGLE_CONVERSION_ACTIVE', 'true');
@define('GOOGLE_CONVERSION_ID', '');
@define('GOOGLE_CONVERSION_LANGUAGE', 'en_EN');
?>

<!-- Google Code for &#20877;&#33829;&#38144;&#20195;&#30721; -->
<!-- Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. For instructions on adding this tag and more information on the above requirements, read the setup guide: google.com/ads/remarketingsetup -->
<script type="text/javascript">

<?php
switch($_GET['main_page']){
	case FILENAME_DEFAULT:
		if($this_is_home_page){
			$google_conversion_content = 'var google_tag_params = {
											ecomm_pagetype:"home"
										};';
		}else{
			$products_id_list = '';
			$products_price_list = 0;
			if(sizeof($product_res) > 0){
				foreach($product_res as $prod){
					$products_id_list.=''.$prod.',';
					$products_price_array = get_products_max_sale_price($prod);
					$products_price = floatval($products_price_array[0]['discount_price']);
					$products_price_list += round($products_price,2);
				}
			}
			if($products_id_list!=''){
				$products_id_list = '['.substr($products_id_list,0,-1).']';
			}else{
				$products_id_list='""';
			}
			
			$google_conversion_content = 'var google_tag_params = {
											ecomm_prodid:'.$products_id_list.',
											ecomm_pagetype:"category",
											ecomm_totalvalue:'.$products_price_list.'
										};';
		}
		break;
	case FILENAME_PRODUCT_INFO:
		$products_id = '';
		$products_price = 0;
		if (isset($_GET['products_id']) && $_GET['products_id'] != ''){
			$products_id = $_GET['products_id'];
			$products_price_array = get_products_max_sale_price($products_id);
			$products_price = floatval($products_price_array[0]['discount_price']);
			$products_price_list += round($products_price,2);
		}
		$google_conversion_content = 'var google_tag_params = {
											ecomm_prodid:['.$products_id.'],
											ecomm_pagetype:"product",
											ecomm_totalvalue:'.round($products_price,2).'
										};';
		break;
	case FILENAME_SHOPPING_CART:
		$cart_id_list = '';
		$cart_price_list = 0;
		foreach($products as $prod){
			$cart_id_list .= ''.$prod['id'].',';
			$cart_price_list += round($prod['price'],2) * $prod['quantity'];
		}
		if($cart_id_list!=''){
			$cart_id_list = '['.substr($cart_id_list,0,-1).']';
		}else{
			$cart_id_list='""';
		}
		$google_conversion_content = 'var google_tag_params = {
											ecomm_prodid:'.$cart_id_list.',
											ecomm_pagetype:"cart",
											ecomm_totalvalue:'.$cart_price_list.'
									};';
		break;	
	case FILENAME_CHECKOUT_SHIPPING:
		$cart_id_list = '';
		$cart_price_list = 0;
		//$products = $_SESSION['cart']->get_products();
		//Tianwen.Wan20160624购物车优化
		$products_array = $_SESSION['cart']->get_isvalid_checkout_products_optimize();
		$products = $products_array['data'];

		if (sizeof($products) > 0){
			foreach($products as $prod){
				$cart_id_list.=''.$prod['id'].',';
				$cart_price_list += round($prod['price'],2) * $prod['quantity'];
			}
		}
		if($cart_id_list!=''){
			$cart_id_list = '['.substr($cart_id_list,0,-1).']';
		}else{
			$cart_id_list='""';
		}
		$google_conversion_content = 'var google_tag_params = {
											ecomm_prodid:'.$cart_id_list.',
											ecomm_pagetype:"purchase",
											ecomm_totalvalue:'.$cart_price_list.'
									};';
		
		break;
	case FILENAME_ADVANCED_SEARCH_RESULT:
			$products_id_list = '';
			$products_price_list = 0;
			if(sizeof($product_res) > 0){
				foreach($product_res as $prod){
					$products_id_list.=''.$prod.',';
					$products_price_array = get_products_max_sale_price($prod);
					$products_price = floatval($products_price_array[0]['discount_price']);
					$products_price_list += round($products_price,2);
				}
			}
			if($products_id_list!=''){
				$products_id_list = '['.substr($products_id_list,0,-1).']';
			}else{
				$products_id_list='""';
			}
		
			$google_conversion_content = 'var google_tag_params = {
											ecomm_prodid:'.$products_id_list.',
											ecomm_pagetype:"search",
											ecomm_totalvalue:'.$products_price_list.'
										};';
			break;
	case FILENAME_PRODUCTS_COMMON_LIST:
		$products_id_list = '';
		$products_price_list = 0;
		if(sizeof($product_res) > 0){
			foreach($product_res as $prod){
				$products_id_list.=''.$prod.',';
				$products_price_array = get_products_max_sale_price($prod);
				$products_price = floatval($products_price_array[0]['discount_price']);
				$products_price_list += round($products_price,2);
			}
		}
		if($products_id_list!=''){
			$products_id_list = '['.substr($products_id_list,0,-1).']';
		}else{
			$products_id_list='""';
		}
			
		$google_conversion_content = 'var google_tag_params = {
									ecomm_prodid:'.$products_id_list.',
									ecomm_pagetype:"products_common_list",
									ecomm_totalvalue:'.$products_price_list.'
								};';
	
		break;
	default:
		$google_conversion_content = 'var google_tag_params = {
											ecomm_pagetype:"other"
										};';
		break;		
}
echo $google_conversion_content . "\n";
?>
</script>

<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = <?php echo ADWORDS_PROMOTION_CODE;?>;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
<?php 
	if(isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0){
		echo 'var google_user_id = ' . $_SESSION['customer_id'];
	}
?>
/* ]]> */
</script>
<script type="text/javascript"  src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/<?php echo ADWORDS_PROMOTION_CODE;?>/?guid=ON&amp;script=0<?php echo ((isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0) ? '&amp;userId=' . $_SESSION['customer_id'] : '')?>"/>
</div>
</noscript>

<?php if($_GET['main_page'] == FILENAME_PRODUCT_INFO){?>
<script src="https://apis.google.com/js/platform.js" async="async"></script>
<?php } ?>

<?php if($_GET['main_page'] == FILENAME_CHECKOUT_SUCCESS){?>
    <script src="https://apis.google.com/js/platform.js?onload=renderOptIn" async defer></script>
    
    <script>
      window.renderOptIn = function() {
        window.gapi.load('surveyoptin', function() {
          window.gapi.surveyoptin.render(
            {
              // REQUIRED FIELDS
              "merchant_id": 9784950,
              "order_id": "<?php echo $zv_orders_id;?>",
              "email": "<?php echo $_SESSION['customer_email'];?>",
              "delivery_country": "<?php echo $order->delivery['country_iso_code_2'];?>",
              "estimated_delivery_date": "<?php echo date('Y-m-d', strtotime("+30 days"))?>",
            });
        });
      }
    </script>
<?php }?>

<?php
$render_language_code = 'en_US';
switch ($_SESSION['languages_id']){
    case 1: $render_language_code = 'en_US';break;
    case 2: $render_language_code = 'de';break;
    case 3: $render_language_code = 'ru';break;
    case 4: $render_language_code = 'fr';break;
    case 5: $render_language_code = 'es';break;
    case 6: $render_language_code = 'ja';break;
    case 7: $render_language_code = 'it';break;
    default:
        $render_language_code = 'en_US';
}
?>

<!-- BEGIN GCR Badge Code -->
<script src="https://apis.google.com/js/platform.js?onload=renderBadge" async defer></script>

<script>
  window.renderBadge = function() {
    var ratingBadgeContainer = document.createElement("div");
      document.body.appendChild(ratingBadgeContainer);
      window.gapi.load('ratingbadge', function() {
        window.gapi.ratingbadge.render(
          ratingBadgeContainer, {
            // REQUIRED
            "merchant_id": 9784950,
            // OPTIONAL
            "position": "BOTTOM_LEFT"
          });           
     });
  }
</script>
<!-- END GCR Badge Code -->

<!-- BEGIN GCR Language Code -->
<script>
  window.___gcfg = {
    lang: '<?php echo $render_language_code;?>'
  };
</script>
<!-- END GCR Language Code -->
