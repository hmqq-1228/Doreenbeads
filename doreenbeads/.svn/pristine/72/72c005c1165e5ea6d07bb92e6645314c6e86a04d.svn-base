<?php
/**

 * shopping cart, zale, 2012-06-07

 */

  require('includes/application_top.php');
  require(DIR_WS_CLASSES . 'currencies.php');

  $currencies = new currencies();  
  
  if (isset($_SESSION['admin_id']) && $_SESSION['admin_id'] != ''){
  	 $sql = "select admin_name from " . TABLE_ADMIN . " where admin_id = " . $_SESSION['admin_id'];
  	 $result = $db->Execute($sql);
  	 $admin_name = $result->fields['admin_name'];
  } 
  
  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  $customers_id = zen_db_prepare_input($_GET['cID']);
  
  if (isset($_POST['act']) && $_POST['act'] == 'updateqty' && $customers_id != ''){
  	if (zen_not_null($_POST['product_qty'])){
  		for ($i = 0; $i < sizeof($_POST['product_qty']); $i++){
  			$pid = $_POST['product_id'][$i];
  			$qty = $_POST['product_qty'][$i];  			
  			$db->Execute("update " . TABLE_CUSTOMERS_BASKET . "
                 set customers_basket_quantity = '" . (float)$qty . "'
               where customers_id = " . (int)$customers_id . "
                 and products_id = " . zen_db_input($pid));
  		}  		
  	}
  }
  
  if (isset($customers_id) && $customers_id != '' && $action == 'edit'){
  		//$_SESSION['customer_id'] = $_POST ['customer_id'];
  		$_SESSION['customer_id'] = $customers_id;
  		if (isset($_GET['sort_no']) && $_GET['sort_no'] != ''){
  			$query_sort = ' order by p.products_model ' . $_GET['sort_no'];
  		}else{
  			$query_sort = ' order by cb.customers_basket_id desc';
  		}
  	
  		$currencies_query = $db->Execute('select cu.code from ' . TABLE_CUSTOMERS . ' c, ' . TABLE_CURRENCIES . ' cu where c.customers_id = ' . $customers_id . ' and cu.currencies_id = c.currencies_preference');
  		$currencies_code = $currencies_query->fields['code'] != '' ? $currencies_query->fields['code'] : 'USD';
  		
  		$basket_products_query = "select p.products_id, p.products_status, pd.products_name, 
		      							 p.products_model, p.products_image, p.products_price, p.products_weight, 
		      							 p.products_tax_class_id, p.product_is_free, p.products_discount_type, 
		      							 p.products_priced_by_attribute, p.products_discount_type_from, 
		      							 cb.customers_basket_quantity, cb.customers_basket_date_added
		                             from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_CUSTOMERS_BASKET . " cb
		                             where p.products_id = pd.products_id
		                             and pd.language_id = " . (int)$_SESSION['languages_id'] . "
		                             and cb.customers_id = " . $customers_id . "
		                             and cb.products_id = p.products_id
		                             and p.products_status = 1 " . $query_sort;
  		$basket_products_total = $db->Execute($basket_products_query);
  		$total_weight = '';	
		$total_items = '';
		$total = 0;
		$promotion_total = 0;
		$i = 0;
  		while (!$basket_products_total->EOF) {
  			$qty = $basket_products_total->fields['customers_basket_quantity'];
  			$products_price = $basket_products_total->fields['products_price'];
  			$special_price = zen_get_products_special_price($basket_products_total->fields['products_id']);
  			if ($special_price && $basket_products_total->fields['products_priced_by_attribute'] == 0) {
  				$products_price = $special_price;
  			} else {
  				$special_price = 0;
  			}
  			if ($basket_products_total->fields['products_priced_by_attribute'] == '1' and zen_has_product_attributes($basket_products_total->fields['products_id'], 'false')) {
	        	$products_price = ($special_price ? $special_price : $basket_products_total->fields['products_price']);
	        } elseif ($basket_products_total->fields['products_discount_type'] != '0') {
	            $products_price = zen_get_products_discount_price_qty($basket_products_total->fields['products_id'], $qty);
	        }
	        /*promotion countdown*/
	        if (zen_show_discount_amount($basket_products_total->fields['products_id'])) {	        	
	        	$products_price = $products_price-($products_price*zen_show_discount_amount($basket_products_total->fields['products_id']))/100;
	        }
	        
			$total_quantity += $basket_products_total->fields['customers_basket_quantity'];
			$total_weight += $basket_products_total->fields['products_weight'] * $basket_products_total->fields['customers_basket_quantity'];
			$cal_currencicy_price = $currencies->format_cl(zen_add_tax ($products_price, zen_get_tax_rate ( $basket_products_total->fields['products_tax_class_id'] )), true, $currencies_code);
 			//$total += $cal_currencicy_price * $basket_products_total->fields['customers_basket_quantity'];
			if(!get_with_vip($basket_products_total->fields['products_id'])){
				$promotion_total += $currencies->format_cl(zen_add_tax($products_price, zen_get_tax_rate ( $basket_products_total->fields['products_tax_class_id'] )), true, $currencies_code) * $qty;
			}
			$i++;
			$basket_products_total->MoveNext();		
  		}
		$total_items = $i;
  		$totalsDisplay = TEXT_TOTAL_ITEMS . $total_items . TEXT_TOTAL_WEIGHT . $total_weight . TEXT_TOTAL_AMOUNT . $currencies->format($total, false, $currencies_code);
  		
  		$basket_products_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER, $basket_products_query, $basket_products_query_numrows);
		
    	$basket_products = $db->Execute($basket_products_query);
		$i=0;
	    while (!$basket_products->EOF) {
		    $qty = $basket_products->fields['customers_basket_quantity'];
	 		$prid = $basket_products->fields['products_id'];
		    $products_price = $basket_products->fields['products_price'];
		    
	        $special_price = zen_get_products_special_price($prid);
	        if ($special_price && $basket_products->fields['products_priced_by_attribute'] == 0) {
	          $products_price = $special_price;
	        } else {
	          $special_price = 0;
	        }
	        $original_price=$basket_products->fields['products_price'];
	        if ($basket_products->fields['product_is_free'] == '1') $products_price = 0;
	        if ($basket_products->fields['products_priced_by_attribute'] == '1' and zen_has_product_attributes($basket_products->fields['products_id'], 'false')) {
	        	$products_price = ($special_price ? $special_price : $basket_products->fields['products_price']);
	        } elseif ($basket_products->fields['products_discount_type'] != '0') {
	            $products_price = zen_get_products_discount_price_qty($basket_products->fields['products_id'], $qty);
            	$original_price = zen_get_products_discount_price_qty($basket_products->fields['products_id'], $qty, 0, false);
	        }
	        /*promotion countdown*/
	        if (zen_show_discount_amount($prid)) {
	        	$products_price = $original_price-($original_price*zen_show_discount_amount($prid))/100;	        
	        }
	      
	        
	    	$productArray[$i]['id'] = $prid;
	    	$productArray[$i]['name'] = $basket_products->fields['products_name'];
	    	$productArray[$i]['model'] = $basket_products->fields['products_model'];
	    	$productArray[$i]['qty'] = $qty;
	    	$productArray[$i]['image'] = $basket_products->fields['products_image']; 	    	
	    	$productArray[$i]['link'] = HTTP_SERVER . "/index.php?main_page=product_info&products_id=" . $prid;
	    	$productArray[$i]['price'] = $currencies->format($products_price, true, $currencies_code);
	    	$productArray[$i]['original_price'] = $currencies->format_cl ( zen_add_tax ( $original_price, zen_get_tax_rate ( $basket_products->fields['products_tax_class_id'] ) ), true, $currencies_code);
	    	$productArray[$i]['final_price'] = $currencies->format_cl(zen_add_tax ( $products_price, zen_get_tax_rate ( $basket_products->fields['products_tax_class_id'] ) ), true, $currencies_code);
	    	$product_total_amount = $currencies->format_cl ( $productArray[$i]['final_price'] * $qty, false, $currencies_code);
	    	$productArray[$i]['total'] = $currencies->format_number($product_total_amount, false, $currencies_code);
	    	$total += $productArray[$i]['total'];
	
	    	$productArray[$i]['tax'] = $basket_products->fields['products_tax_class_id'];
	    	$productArray[$i]['weight'] = $basket_products->fields['products_weight'];
	    	$productArray[$i]['date_added'] = $basket_products->fields['customers_basket_date_added'];
	        $i++;
	    	$basket_products->MoveNext();
	    }
	    if (sizeof($productArray) == 1 && $productArray[0]['id'] == 28675){
	    	$is_gift = true;
	    }
  		$vip_message = get_vip_message($customers_id);
    } 	
?>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">

<html <?php echo HTML_PARAMS; ?>>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">

<title><?php echo TITLE; ?></title>

<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">

<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">

<script language="javascript" src="includes/menu.js"></script>

<script language="javascript" src="includes/general.js"></script>

<script language="javascript" src="../includes/templates/cherry_zen/jscript/jscript_jquery.js"></script>

<script type="text/javascript">
  <!--

  function init()

  {

    cssjsmenu('navbar');

    if (document.getElementById)

    {

      var kill = document.getElementById('hoverJS');

      kill.disabled = true;

    }

  }

  // -->
</script>

</head>

<body onLoad="init()">
<!-- bof shipping calculator -->
<?php 
if ($action == 'edit') {
if(isset($_SESSION['cart_country_id']) && $_SESSION['cart_country_id'] != ''){
	$country_id = $_SESSION['cart_country_id'];
}else{
	$customer = $db->Execute ( 'select ab.entry_country_id, c.customers_country_id, ab.entry_postcode, ab.entry_city from ' . TABLE_CUSTOMERS . ' c, ' . TABLE_ADDRESS_BOOK . ' ab where c.customers_id = ' . $customers_id . ' and ab.address_book_id = c.customers_default_address_id' );
	if ($customer->RecordCount () == 1) {
		$country_id = $customer->fields ['entry_country_id'];
		$city = $customer->fields ['entry_city'];
		$post_code = $customer->fields ['entry_postcode'];
	} else {
		$country = $db->Execute ( 'select customers_country_id from ' . TABLE_CUSTOMERS . ' where customers_id = ' . $customers_id );
		$country_id = $country->fields ['customers_country_id'];
		$city = '';
		$post_code = '';
	}
}

$country_id = $country_id != '' ? $country_id : '223';
$country_code_query = $db->Execute ( 'select countries_iso_code_2 from ' . TABLE_COUNTRIES . ' where countries_id = ' . $country_id );
$country_code = $country_code_query->fields ['countries_iso_code_2'];
$text_countries_list = zen_get_country_select('zone_country_id', $country_id, 1, 'id="country"');
$country_info = zen_get_countries_new($country_id);
$text_countries_list .= zen_draw_hidden_field('country_name', $country_info['countries_name']);
$cutomer_basket_info = zen_get_customer_basket_info($customers_id, $currencies_code);
?>
<input type="hidden" class="customer_id" value="<?php echo $customers_id;?>">
<input type="hidden" class="volume_weight" value="<?php echo $cutomer_basket_info['volume_weight'];?>">
<input type="hidden" class="subtotal_us" value="<?php echo $currencies->format_cl($total, true, 'USD');?>">
<div class="windowbody"></div>
<div class="smallwindow windowship" style="display: none;">
	<div class="smallwindowtit">
		<strong>Shipping Information</strong><span></span>
	</div>
	<table class="shiptab">
		<tr>
			<td><ins>Total Weight:</ins><input class="canread total_weight_input" value="<?php echo $cutomer_basket_info['weight'];?>g" disabled /></td>
			<td><ins>Country:</ins><div class="shipping_cal_country"><?php echo $text_countries_list;?></div></td>
		</tr>
		<tr>
			<td><ins>City / Town:</ins><input class="estimate_city" type="text" value="<?php echo $city;?>" /><input class="estimate_ocity" type="hidden"  value="<?php echo $city?>" /></td>
			<td><ins>Zip / Postal code:</ins><input class="estimate_postcode" type="text" value="<?php echo $post_code;?>" /><input class="estimate_opostcode" type="hidden" value="<?php echo $post_code;?>" /></td>
		</tr>
		<tr>
			<td><button class="btn_yellow estimate_btn">
					<span><strong>Calculate</strong></span>
				</button></td>
			<td></td>
		</tr>
	</table>
	<div class="estimate_content"></div>
</div>
<?php } ?>
<!-- eof -->

<!-- header //-->

<?php require(DIR_WS_INCLUDES . 'header.php'); ?>

<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
 <tr>

        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">

          <tr><?php echo zen_draw_form('search', FILENAME_SHOPPING_CART1, '', 'get', '', true); ?>

            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>

            <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>

            <td class="smallText" align="right">

<?php

// show reset search   

    echo HEADING_TITLE_SEARCH_DETAIL . ' ' . zen_draw_input_field('search',((isset($_GET['search']) && zen_not_null($_GET['search']))?zen_db_input(zen_db_prepare_input($_GET['search'])):'')) . zen_hide_session_id();
	echo '<br />';
    echo TEXT_CUSTOMER_ID .zen_draw_input_field('scid',((isset($_GET['scid']) && zen_not_null($_GET['scid']))?zen_db_input(zen_db_prepare_input($_GET['scid'])):''));   
    echo '<br/>';
    echo "<input type='submit' value='".IMAGE_SEARCH."'><br/>";
    if(isset($_GET['search']) && zen_not_null($_GET['search']) || isset($_GET['scid']) && zen_not_null($_GET['scid'])) {
    	echo '<a href="' . zen_href_link(FILENAME_SHOPPING_CART1, '', 'NONSSL') . '">' . zen_image_button('button_reset.gif', IMAGE_RESET) . '</a>';
    }

?>
            </td>

          </form></tr>

        </table></td>

  </tr>
  <tr>

<!-- body_text //-->

    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">

<?php

  if ($action == 'edit') {
?>	
    <tr>
    	<td colspan="8" align="center"><b>
	    	<?php 
	    		if (!empty($totalsDisplay)) {
	    			echo $totalsDisplay; //显示例如:Total Items: 10  Weight: 660 grams  Amount: US$20.50
	     		}
			?>
		</b></td>
     </tr>
 
	<tr>
		<td class="smallText" valign="top" colspan="7"><?php echo $basket_products_split->display_count($basket_products_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></td>
		<td class="smallText" align="right"><?php echo $basket_products_split->display_links($basket_products_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
	</tr>   
                
  	<tr class="tableHeading">
  		<th scope="col"><input type="checkbox" onclick="getAllCheck(this,'productCheckbox[]')" class="customer_checkbox"/></th>
  		<th scope="col"><a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART1,zen_get_all_get_params(array('x','y')) .'sort_no='.($_GET['sort_no'] == '' || $_GET['sort_no'] == 'DESC' ? 'ASC' : 'DESC'))?>"><?php echo TABLE_HEADING_MODEL; ?></a></th>
        <th scope="col"><?php echo TABLE_HEADING_QUANTITY; ?>(<a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART1, zen_get_all_get_params(array('x', 'y', 'act')) . 'act=editqty');?>" class="editqty">Edit</a>)</th>
        <th scope="col"><?php echo TABLE_HEADING_PRODUCTS; ?></th>
        <th scope="col">原价</th>
        <th scope="col">折扣</th>
        <th scope="col">折后价</th>
        <th scope="col"><?php echo TABLE_HEADING_TOTAL; ?></th>
     </tr>
<?php
echo zen_draw_form('shopping_cart', FILENAME_SHOPPING_CART1, zen_get_all_get_params(array('act')), 'post', '', true);
echo zen_draw_hidden_field('act', 'updateqty');
echo zen_draw_hidden_field('qty_err_type', '0', 'class="qty_err_type"');
  for ($i = 0; $i < sizeof($productArray); $i++){
  	$rowClass = ($i%2 == 0 ? "rowEven" : "rowOdd");
  	if($productArray[$i]['final_price'] != $productArray[$i]['original_price']){
  		$product_discount = round(100 - round(($productArray[$i]['final_price'] / $productArray[$i]['original_price'])* 100,2) ).'%';
  		$product_final_price = $currencies->format($productArray[$i]['final_price'], false, $currencies_code);
  	}else{
  		$product_discount = "";
  		$product_final_price = '';
  	}
?>     
     <tr class="<?php echo $rowClass;?>">
	   <td class="cartQuantity" valign="middle" align="center">
	   	<input type="checkbox" name="productCheckbox[]" value="<?php echo $productArray[$i]['id'];?>" />
	   	<?php echo zen_draw_hidden_field('product_id[]', $productArray[$i]['id']);?>
	   </td>
	   <td class="cartQuantity" valign="middle" align="center"><?php echo $productArray[$i]['model']; ?></td>
       <td class="cartQuantity" valign="middle" align="center">
       	<?php echo $_GET['act'] == 'editqty' ? zen_draw_input_field('product_qty[]', $productArray[$i]['qty'], 'size=6') : $productArray[$i]['qty'];?>
       	<?php echo zen_draw_hidden_field('product_model[]', $productArray[$i]['model']);?>       	
       </td>
       <td><a href="<?php echo $productArray[$i]['link']; ?>" target="_blank"><img src="<?php echo HTTP_IMG_SERVER . 'bmz_cache/' . DIR_WS_IMAGES . get_img_size ( $productArray[$i]['image'], 80, 80 );?>"><span style="text-align:center;"><?php echo $productArray[$i]['name']; ?></span></a></td>
       <td class="cartUnitDisplay" valign="middle" align="center"><?php echo $currencies->format($productArray[$i]['original_price'], false, $currencies_code); ?></td>
       <td class="cartUnitDisplay" valign="middle" align="center"><?php echo $product_discount; ?></td>
       <td class="cartUnitDisplay" valign="middle" align="center"><?php echo $product_final_price; ?></td>
       <td class="cartTotalDisplay" valign="middle" align="center"><?php echo $currencies->currencies[$currencies_code]['symbol_left'] . $productArray[$i]['total']; ?></td>
     </tr>
<?php
  } // end foreach ($productArray as $product)
?>
	<tr><?php echo ($_GET['act'] == 'editqty' ? '<td class="cartSubTotal" colspan="3" align="right"><button class="updateqty">确定</button></td>' : '');?><td class="cartSubTotal" colspan="<?php echo ($_GET['act'] == 'editqty' ? 5 : 8);?>" align="right"><?php echo SUB_TITLE_SUB_TOTAL; ?> <span class="subtotal"><?php echo $currencies->format($total, false, $currencies_code); ?></span></td></tr>
<?php
	if ($_GET['cID'] and $vip_message['group_percentage'] <> 0) {

?>
	<tr>
		<td class="cartSubTotal " align="right" colspan="8">
		<?php echo TEXT_VIP_GROUNP_DISCOUNT;?> [<a href="http://www.doreenbeads.com/index.php?main_page=help_center&id=33" target="_blank"> <?php echo round($vip_message['group_percentage']) . '%' ?></a>]: -<span class="viptotal"><?php echo $currencies->format(($total-$promotion_total)*$vip_message['group_percentage']/100, false, $currencies_code); ?></span>
		</td>
	</tr>
<?php } ?>

	<tr style="display:none;">
		<td class="cartSubTotal" align="right" colspan="8">
		<?php 
			if ($is_gift) {
				echo '<span>Shipping Charges: ' . $currencies->format(1.5, true, $currencies_code) . '</span>';
			}else{
				echo '<a href="javascript:void(0);" class="estShippingCost">运费估算</a>: <span class="shipping_content"><img src="../includes/templates/cherry_zen/images/zen_loader.gif"></span>';
			}
		?>		
		</td>
	</tr>
	
	<tr>
		<td class="cartSubTotal" align="right" colspan="8">
		<a href="<?php echo HTTP_SERVER . '/index.php?main_page=shopping_cart&admin_id=' . $_SESSION['admin_id'];?>" onclick="return set_customer_id(<?php echo $customers_id;?>);" target="_blank"><input type="button" value="checkout"></a> <a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART1);?>"><input type="button" value="返回"></a>
		</td>
	</tr>

	 <tr>
		<td class="smallText" valign="top" colspan="7"><?php echo $basket_products_split->display_count($basket_products_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></td>
		<td class="smallText" align="right"><?php echo $basket_products_split->display_links($basket_products_query_numrows, MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
	</tr>      
<?php 
echo '</form>';
  } else {

?><br>	

      <tr>

        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">

          <tr>

<?php

// Sort Listing

          switch ($_GET['list_order']) {
          	  case "customerid":

              $disp_order = "c.customers_id";

              break;
              case "customerid-desc":

              $disp_order = "c.customers_id DESC";

              break;
              
              case "firstname":

              $disp_order = "c.customers_firstname";

              break;

              case "firstname-desc":

              $disp_order = "c.customers_firstname DESC";

              break;

              case "group":

              $disp_order = "c.customers_group_pricing";

              break;

              case "group-desc":

              $disp_order = "c.customers_group_pricing DESC";

              break;

              case "total":

              $disp_order = "sum(cb.customers_basket_quantity * p.products_price)";

              break;

              case "total-desc":

              $disp_order = "sum(cb.customers_basket_quantity * p.products_price) DESC";

              break;

              case "lastname":

              $disp_order = "c.customers_lastname, c.customers_firstname";

              break;

              case "lastname-desc":

              $disp_order = "c.customers_lastname DESC, c.customers_firstname";

              break;
              
              case "emailaddress";
              
              $disp_order = "c.customers_email_address" ;
              
              break;
              
              case "emailaddress-desc":
              	
              $disp_order = "c.customers_email_address DESC";
              
              break;

              default:

              $disp_order = "cb.customers_basket_date_added DESC";

          }
          
?>        	

            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
			<form action="<?php echo zen_href_link(FILENAME_SHOPPING_CART1,'action=send_email');?>" method='post' name="customerForm">
              <tr class="dataTableHeadingRow">     

                <td class="dataTableHeadingContent s_customer_id" align="center" valign="top">
                  <?php echo (($_GET['list_order']=='customerid' or $_GET['list_order']=='customerid-desc') ? '<span class="SortOrderHeader">' . TABLE_HEADING_ID . '</span>' : TABLE_HEADING_ID); ?><br>
                  <a href="<?php echo zen_href_link(basename($PHP_SELF) . '?list_order=customerid', '', 'NONSSL'); ?>"><?php echo ($_GET['list_order']=='customerid' ? '<span class="SortOrderHeader">Asc</span>' : '<span class="SortOrderHeaderLink">Asc</b>'); ?></a>&nbsp;
                  <a href="<?php echo zen_href_link(basename($PHP_SELF) . '?list_order=customerid-desc', '', 'NONSSL'); ?>"><?php echo ($_GET['list_order']=='customerid-desc' ? '<span class="SortOrderHeader">Desc</span>' : '<span class="SortOrderHeaderLink">Desc</b>'); ?></a>
                </td>

                <td class="dataTableHeadingContent s_customer_name" align="left">
                  <?php echo (($_GET['list_order']=='lastname' or $_GET['list_order']=='lastname-desc') ? '<span class="SortOrderHeader">' . TABLE_HEADING_LASTNAME . '</span>' : TABLE_HEADING_LASTNAME); ?><br>
                  <a href="<?php echo zen_href_link(basename($PHP_SELF) . '?list_order=lastname', '', 'NONSSL'); ?>"><?php echo ($_GET['list_order']=='lastname' ? '<span class="SortOrderHeader">Asc</span>' : '<span class="SortOrderHeaderLink">Asc</b>'); ?></a>&nbsp;
                  <a href="<?php echo zen_href_link(basename($PHP_SELF) . '?list_order=lastname-desc', '', 'NONSSL'); ?>"><?php echo ($_GET['list_order']=='lastname-desc' ? '<span class="SortOrderHeader">Desc</span>' : '<span class="SortOrderHeaderLink">Desc</b>'); ?></a>
                </td>

                <td class="dataTableHeadingContent s_customer_name" align="left">
                  <?php echo (($_GET['list_order']=='firstname' or $_GET['list_order']=='firstname-desc') ? '<span class="SortOrderHeader">' . TABLE_HEADING_FIRSTNAME . '</span>' : TABLE_HEADING_FIRSTNAME); ?><br>
                  <a href="<?php echo zen_href_link(basename($PHP_SELF) . '?list_order=firstname', '', 'NONSSL'); ?>"><?php echo ($_GET['list_order']=='firstname' ? '<span class="SortOrderHeader">Asc</span>' : '<span class="SortOrderHeaderLink">Asc</b>'); ?></a>&nbsp;
                  <a href="<?php echo zen_href_link(basename($PHP_SELF) . '?list_order=firstname-desc', '', 'NONSSL'); ?>"><?php echo ($_GET['list_order']=='firstname-desc' ? '<span class="SortOrderHeader">Desc</span>' : '<span class="SortOrderHeaderLink">Desc</span>'); ?></a>
                </td>

                
                <td class="dataTableHeadingContent s_customer_email" align="left">
                  <?php echo (($_GET['list_order']=='emailaddress' or $_GET['list_order']=='emailaddress-desc') ? '<span class="SortOrderHeader">' . TABLE_HEADING_EMAIL_ADDRESS . '</span>' : TABLE_HEADING_EMAIL_ADDRESS); ?><br>
                  <a href="<?php echo zen_href_link(basename($PHP_SELF) . '?list_order=emailaddress', '', 'NONSSL'); ?>"><?php echo ($_GET['list_order']=='emailaddress' ? '<span class="SortOrderHeader">Asc</span>' : '<span class="SortOrderHeaderLink">Asc</b>'); ?></a>&nbsp;
                  <a href="<?php echo zen_href_link(basename($PHP_SELF) . '?list_order=emailaddress-desc', '', 'NONSSL'); ?>"><?php echo ($_GET['list_order']=='emailaddress-desc' ? '<span class="SortOrderHeader">Desc</span>' : '<span class="SortOrderHeaderLink">Desc</b>'); ?></a>
                </td>          

				<td class="dataTableHeadingContent li_width" align="left">
                  <?php echo (($_GET['list_order']=='group' or $_GET['list_order']=='group-desc') ? '<span class="SortOrderHeader">' . TABLE_HEADING_VIP . '</span>' : TABLE_HEADING_VIP); ?><br>
                  <a href="<?php echo zen_href_link(basename($PHP_SELF) . '?list_order=group', '', 'NONSSL'); ?>"><?php echo ($_GET['list_order']=='group' ? '<span class="SortOrderHeader">Asc</span>' : '<span class="SortOrderHeaderLink">Asc</b>'); ?></a>&nbsp;
                  <a href="<?php echo zen_href_link(basename($PHP_SELF) . '?list_order=group-desc', '', 'NONSSL'); ?>"><?php echo ($_GET['list_order']=='group-desc' ? '<span class="SortOrderHeader">Desc</span>' : '<span class="SortOrderHeaderLink">Desc</b>'); ?></a>
                </td>
                
                <td class="dataTableHeadingContent li_width" align="left">
                  <?php echo (($_GET['list_order']=='total' or $_GET['list_order']=='total-desc') ? '<span class="SortOrderHeader">物品总金额</span>' : '物品总金额'); ?><br>
                  <a href="<?php echo zen_href_link(basename($PHP_SELF) . '?list_order=total', '', 'NONSSL'); ?>"><?php echo ($_GET['list_order']=='total' ? '<span class="SortOrderHeader">Asc</span>' : '<span class="SortOrderHeaderLink">Asc</b>'); ?></a>&nbsp;
                  <a href="<?php echo zen_href_link(basename($PHP_SELF) . '?list_order=total-desc', '', 'NONSSL'); ?>"><?php echo ($_GET['list_order']=='total-desc' ? '<span class="SortOrderHeader">Desc</span>' : '<span class="SortOrderHeaderLink">Desc</b>'); ?></a>
                </td>

                <td class="dataTableHeadingContent li_width"><?php echo TABLE_HEADING_VIEW; ?>&nbsp;</td>
              </tr>

<?php
	$time_7_ago = date("Ymd",time()-6*24*3600);
	$search_query = '';

    if (isset($_GET['search']) && zen_not_null($_GET['search'])) {
      $keywords = zen_db_input(zen_db_prepare_input($_GET['search']));
      if(isset($_GET['scid']) && $_GET['scid']!=''){
      	$scid = zen_db_input(zen_db_prepare_input($_GET['scid']));	
        $searchCid=' c.custormers_id = ' . $scid . ' and ';
      }else{
      	$searchCid='';
      }      
      $searchwords = "and " . $searchCid."  (c.customers_lastname like '%" . $keywords . "%' or c.customers_firstname like '%" . $keywords . "%' or c.customers_email_address like '%" . $keywords . "%')";      
    }elseif(isset($_GET['search']) && trim($_GET['search']) == ''){
      if((isset($_GET['scid'])) && $_GET['scid'] != ''){
      	$scid = zen_db_input(zen_db_prepare_input($_GET['scid']));		
        $searchwords = 'and c.customers_id = ' . $scid;
      }
    }
    
    $customers_query_raw = "select c.customers_id, c.customers_lastname, c.customers_firstname, c.customers_email_address
    							   from " . TABLE_CUSTOMERS . " c where c.customers_id in(select customers_id from " . TABLE_CUSTOMERS_BASKET . ")" . $searchwords;
								 
	
    $customers_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER, $customers_query_raw, $customers_query_numrows);
    $customers = $db->Execute($customers_query_raw);
    while (!$customers->EOF) {
		$vip_message = get_vip_message($customers->fields['customers_id']);
		//$status_result = $db->Execute('select en_send_times from '.TABLE_EMAIL_NOTICE.' where en_customers_id = ' . $customers->fields['customers_id']);
		
		$currencies_query = $db->Execute('select cu.code from ' . TABLE_CUSTOMERS . ' c, ' . TABLE_CURRENCIES . ' cu where c.customers_id = ' . $customers->fields['customers_id'] . ' and cu.currencies_id = c.currencies_preference');
		$currencies_code = $currencies_query->fields['code'] != '' ? $currencies_query->fields['code'] : 'USD';
		
		$total_query = $db->Execute('select cb.final_price, cb.customers_basket_quantity, cb.products_id, p.products_priced_by_attribute, p.product_is_free, p.products_discount_type, p.products_tax_class_id from ' . TABLE_CUSTOMERS_BASKET . ' cb, ' . TABLE_PRODUCTS . ' p where cb.customers_id = ' . $customers->fields['customers_id'] . ' and p.products_id = cb.products_id and p.products_status = 1');
		$total = 0;
		while (!$total_query->EOF){
			$products_price = $total_query->fields['final_price'];
			$qty = $total_query->fields['customers_basket_quantity'];
			$prid = $total_query->fields['products_id'];
			
			$special_price = zen_get_products_special_price($prid);
			if ($special_price && $total_query->fields['products_priced_by_attribute'] == 0) {
				$products_price = $special_price;
			}
			if ($total_query->fields['product_is_free'] == '1') $products_price = 0;
			if ($total_query->fields['products_priced_by_attribute'] == '1' and zen_has_product_attributes($prid, 'false')) {
				$products_price = ($special_price ? $special_price : $total_query->fields['products_price']);
			} elseif ($total_query->fields['products_discount_type'] != '0') {
				$products_price = zen_get_products_discount_price_qty($prid, $qty);
			}
			$cal_currencicy_price = $currencies->format_cl(zen_add_tax ($products_price, zen_get_tax_rate ( $total_query->fields['products_tax_class_id'] )), true, $currencies_code);
			$total += $cal_currencicy_price * $qty;
			
			$total_query->MoveNext();
      }
      
  /*     if ($status_result->RecordCount() == 0){
     	 $status = 0;
      }else {
     	 $status = $status_result->fields['en_send_times'];
      } */
      
      if ((!isset($_GET['cID']) || (isset($_GET['cID']) && ($_GET['cID'] == $customers->fields['customers_id']))) && !isset($cInfo)) {
        $cInfo = new objectInfo($customers->fields);
      }      

      if (isset($cInfo) && is_object($cInfo) && ($customers->fields['customers_id'] == $cInfo->customers_id)) {
        echo '          <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . zen_href_link(FILENAME_SHOPPING_CART1, zen_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_id . '&action=edit', 'NONSSL') . '\'">' . "\n";
      } else {
        echo '          <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" ondblclick="document.location.href=\'' . zen_href_link(FILENAME_SHOPPING_CART1, zen_get_all_get_params(array('cID', 'action')) . 'cID=' . $customers->fields['customers_id'] . '&action=edit', 'NONSSL') . '\'" onclick="document.location.href=\'' . zen_href_link(FILENAME_SHOPPING_CART1, zen_get_all_get_params(array('cID', 'action')) . 'cID=' . $customers->fields['customers_id'], 'NONSSL') . '\'">' . "\n";
      }

?>
				<td class="dataTableContent s_customer_id" align="center"><?php echo zen_output_if_null($customers->fields['customers_id']); ?></td>

                <td class="dataTableContent s_customer_name"><?php echo zen_output_if_null($customers->fields['customers_lastname']); ?><input type="hidden" value="<?php echo zen_output_if_null($customers->fields['customers_lastname']); ?>" name="lastname[]"></td>

                <td class="dataTableContent s_customer_name"><?php echo zen_output_if_null($customers->fields['customers_firstname']); ?><input type="hidden" value="<?php echo zen_output_if_null($customers->fields['customers_firstname']); ?>" name="firstname[]"></td>
      			
                <td class="dataTableContent s_customer_email"><?php echo zen_output_if_null($_SESSION['show_customer_email'] ? $customers->fields['customers_email_address'] : strstr($customers->fields['customers_email_address'], '@', true) . '@'); ?><input type="hidden" value="<?php echo zen_output_if_null($customers->fields['customers_email_address']); ?>" name="email[]"></td>
                
				<td class="dataTableContent li_width"><?php echo $vip_message['group_name']; ?></td>
				
				<td class="dataTableContent li_width"><?php echo $currencies->format($total, false, $currencies_code); ?></td>

                <td class="dataTableContent li_width"><?php if (isset($cInfo) && is_object($cInfo) && ($customers->fields['customers_id'] == $cInfo->customers_id)) { echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . zen_href_link(FILENAME_SHOPPING_CART1, zen_get_all_get_params(array('cID','action')) . 'cID=' . $customers->fields['customers_id'] . ($_GET['page'] > 0 ? '&page=' . $_GET['page'] : ''), 'NONSSL') . '">' . zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>

<?php
      $customers->MoveNext();

    }
?>
			</form> 
              <tr>
                <td colspan="8"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top">
                    <?php echo $customers_split->display_count($customers_split->number_of_rows, MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_CUSTOMERS); ?>
                    </td>

                    <td class="smallText" align="right"><?php echo $customers_split->display_links($customers_split->number_of_rows, MAX_DISPLAY_SEARCH_RESULTS_CUSTOMER, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page', 'info', 'x', 'y', 'cID'))); ?>
                    </td>
                  </tr>
<?php

    if (isset($_GET['search']) && zen_not_null($_GET['search']) || isset($_GET['scid']) && zen_not_null($_GET['scid'])) {

?>
                  <tr>
                    <td align="right" colspan="2"><?php echo '<a href="' . zen_href_link(FILENAME_SHOPPING_CART1, '', 'NONSSL') . '">' . zen_image_button('button_reset.gif', IMAGE_RESET) . '</a>'; ?></td>
                  </tr>
<?php
    }
?>
                </table></td>

              </tr>

            </table>
           
            </td>

          </tr>

        </table></td>

      </tr>

<?php

  }

?>

    </table></td>

<!-- body_text_eof //-->

  </tr>

</table>


<!-- body_eof //-->



<!-- footer //-->

<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>

<!-- footer_eof //-->

<br>

</body>

</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>