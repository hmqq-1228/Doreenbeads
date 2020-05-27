<?php
/**
 * @package admin
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: collect_info.php 6131 2007-04-08 06:56:51Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}//jessa 2009-08-24 add 'products_net_price' => '',
//jessa 2009-11-09 add 'products_limit_stock => '',
//jessa 2010-01-22 add 'match_prod_list' => '',

	$categories_level_sql = $db->Execute("Select categories_level,parent_id
											From " . TABLE_CATEGORIES . "
										   Where categories_id ='" . $current_category_id . "'");
	$parent_id = $categories_level_sql->fields['parent_id']; 
	if($parent_id !=0){
	$parent_id_sql = $db->Execute("Select categories_level
											From " . TABLE_CATEGORIES . "
										   Where categories_id ='" . $parent_id . "'");
	$categories_level = $parent_id_sql->fields['categories_level'];  
	}else{
	$categories_level_sql = $db->Execute("Select categories_level
									From " . TABLE_CATEGORIES . "
								   Where categories_id ='" .  $current_category_id. "'");
	$categories_level = $categories_level_sql->fields['categories_level'];	
	}
    $parameters = array('products_name' => '',
                       'products_description' => '',
					   'products_name_without_catg' => '',
                       'products_url' => '',
                       'products_id' => '',
                       'products_quantity' => '50000',
                       'products_model' => '',
                       'products_image' => '',
                       'products_price' => '',
					   'products_net_price' => '',
                       'products_virtual' => DEFAULT_PRODUCT_PRODUCTS_VIRTUAL,
                       'products_weight' => '',
    				   'products_volume_weight' => '',
                       'products_date_added' => '',
                       'products_last_modified' => '',
                       'products_date_available' => '',
                       'products_status' => '',
                       'is_mixed' => 0,
                       'products_tax_class_id' => DEFAULT_PRODUCT_TAX_CLASS_ID,
                       'manufacturers_id' => '',
                       'products_quantity_order_min' => '',
                       'products_quantity_order_units' => '',
                       'products_priced_by_attribute' => '',
					   'products_limit_stock' => '',
                       'product_is_free' => '',
                       'product_is_call' => '',
                       'products_quantity_mixed' => '',
                       'product_is_always_free_shipping' => DEFAULT_PRODUCT_PRODUCTS_IS_ALWAYS_FREE_SHIPPING,
                       'products_qty_box_status' => PRODUCTS_QTY_BOX_STATUS,
                       'products_quantity_order_max' => '0',
                       'products_sort_order' => '1000',
                       'products_discount_type' => '0',
                       'products_discount_type_from' => '0',
                       'products_price_sorter' => '0',
                       'master_categories_id' => '',
                       'match_prod_list' => '',
                       'product_price_times' => '',
					   'products_level' => $categories_level,
						'products_stocking_days' => 0,
                        'is_display' => 1
                       );
//eof jessa 2010-01-22
//eof jessa 2009-11-09
//eof jessa 2009-08-24
    $pInfo = new objectInfo($parameters);

    if (isset($_GET['pID']) && empty($_POST)) {//jessa 2009-08-24 add p.products_net_price
    	//jessa 2010-01-22 add p.match_prod_list
      $product = $db->Execute("select pd.products_name,pd.products_url, pd.products_name_without_catg,
                                      p.products_id, p.products_model,is_display,
                                      p.products_image, p.products_price, p.products_virtual, p.products_weight,p.products_net_price,
                                      p.products_date_added, p.products_last_modified, p.products_volume_weight,
                                      date_format(p.products_date_available, '%Y-%m-%d') as
                                      products_date_available, p.products_status, p.products_tax_class_id,
                                      p.manufacturers_id,
                                      p.products_quantity_order_min, p.products_quantity_order_units, p.products_priced_by_attribute, p.products_limit_stock,
                                      p.product_is_free,p.product_is_call,  p.products_quantity_mixed,
                                      p.product_is_always_free_shipping, p.products_qty_box_status, p.products_quantity_order_max,
                                      p.products_sort_order, p.products_level, 
                                      p.products_discount_type, p.products_discount_type_from,
                                      p.products_price_sorter, p.master_categories_id, p.product_price_times, p.is_mixed , p.products_stocking_days
                              from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
                              where p.products_id = '" . (int)$_GET['pID'] . "'                   
                              and p.products_id = pd.products_id
                              and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'");
      
      $products_quantity = get_products_quantity($product->fields);
      $product->fields['products_quantity'] = $products_quantity;
      
      /* best match WSL */
      $match_products_id_result = $db->Execute("select match_products_id from ".TABLE_PRODUCTS_MATCH_PROD_LIST." where products_id = ".(int)$_GET['pID']);  
      while (!$match_products_id_result->EOF){
      	$products_model_match = $db->Execute("select products_model from ".TABLE_PRODUCTS." where products_id = ".$match_products_id_result->fields['match_products_id'])->fields['products_model'];
      	if($products_model_match){
      		$products_model_list .= $products_model_match.',';
      	}
      	$match_products_id_result->MoveNext();
      }
      $products_model_list = substr($products_model_list,0,-1);
      $product->fields['match_prod_list'] = $products_model_list;
      
//eof jessa 2010-01-22
//eof jessa 2009-08-24
      $pInfo->objectInfo($product->fields);
    } elseif (zen_not_null($_POST)) {
      $pInfo->objectInfo($_POST);
      $products_name = $_POST['products_name'];
      $products_name_without_catg = $_POST ['products_name_without_catg'];
      $products_description = $_POST['products_description'];
      $products_url = $_POST['products_url'];
      //jessa 2010-01-22
	  $prodcuts_match = $_POST['match_products'];
	  //eof jessa 2010-01-22
    }

    $manufacturers_array = array(array('id' => '', 'text' => TEXT_NONE));
    $manufacturers = $db->Execute("select manufacturers_id, manufacturers_name
                                   from " . TABLE_MANUFACTURERS . " order by manufacturers_name");
    while (!$manufacturers->EOF) {
      $manufacturers_array[] = array('id' => $manufacturers->fields['manufacturers_id'],
                                     'text' => $manufacturers->fields['manufacturers_name']);
      $manufacturers->MoveNext();
    }

    $tax_class_array = array(array('id' => '0', 'text' => TEXT_NONE));
    $tax_class = $db->Execute("select tax_class_id, tax_class_title
                                     from " . TABLE_TAX_CLASS . " order by tax_class_title");
    while (!$tax_class->EOF) {
      $tax_class_array[] = array('id' => $tax_class->fields['tax_class_id'],
                                 'text' => $tax_class->fields['tax_class_title']);
      $tax_class->MoveNext();
    }

    $languages = zen_get_languages();

    if (!isset($pInfo->products_status)) $pInfo->products_status = '1';
    $out_status = $in_status = $is_deleted = false;
    if($pInfo->products_status == 0) {
    	$out_status = true;
    } else if($pInfo->products_status == 1) {
    	$in_status = true;
    }
    else if($pInfo->products_status == 10) {
    	$is_deleted = true;
    }

// set to out of stock if categories_status is off and new product or existing products_status is off
    if (zen_get_categories_status($current_category_id) == '0' and $pInfo->products_status != '1') {
      $pInfo->products_status = 0;
      $in_status = false;
      $out_status = true;
    }

// Virtual Products
    if (!isset($pInfo->products_virtual)) $pInfo->products_virtual = PRODUCTS_VIRTUAL_DEFAULT;
    switch ($pInfo->products_virtual) {
      case '0': $is_virtual = false; $not_virtual = true; break;
      case '1': $is_virtual = true; $not_virtual = false; break;
      default: $is_virtual = false; $not_virtual = true;
    }
// Always Free Shipping
    if (!isset($pInfo->product_is_always_free_shipping)) $pInfo->product_is_always_free_shipping = DEFAULT_PRODUCT_PRODUCTS_IS_ALWAYS_FREE_SHIPPING;
    switch ($pInfo->product_is_always_free_shipping) {
      case '0': $is_product_is_always_free_shipping = false; $not_product_is_always_free_shipping = true; $special_product_is_always_free_shipping = false; break;
      case '1': $is_product_is_always_free_shipping = true; $not_product_is_always_free_shipping = false; $special_product_is_always_free_shipping = false; break;
      case '2': $is_product_is_always_free_shipping = false; $not_product_is_always_free_shipping = false; $special_product_is_always_free_shipping = true; break;
      default: $is_product_is_always_free_shipping = false; $not_product_is_always_free_shipping = true; $special_product_is_always_free_shipping = false;
    }
// products_qty_box_status shows
    if (!isset($pInfo->products_qty_box_status)) $pInfo->products_qty_box_status = PRODUCTS_QTY_BOX_STATUS;
    switch ($pInfo->products_qty_box_status) {
      case '0': $is_products_qty_box_status = false; $not_products_qty_box_status = true; break;
      case '1': $is_products_qty_box_status = true; $not_products_qty_box_status = false; break;
      default: $is_products_qty_box_status = true; $not_products_qty_box_status = false;
    }
// Product is Priced by Attributes
    if (!isset($pInfo->products_priced_by_attribute)) $pInfo->products_priced_by_attribute = '0';
    switch ($pInfo->products_priced_by_attribute) {
      case '0': $is_products_priced_by_attribute = false; $not_products_priced_by_attribute = true; break;
      case '1': $is_products_priced_by_attribute = true; $not_products_priced_by_attribute = false; break;
      default: $is_products_priced_by_attribute = false; $not_products_priced_by_attribute = true;
    }
//jessa 2009-11-09 add the following code
// product is limit stock
	if (!isset($pInfo->products_limit_stock)) $pInfo->products_limit_stock = '0';
	switch ($pInfo->products_limit_stock){
	  case '0': $in_product_limit_stock = false; $out_product_limit_stock = true; break;
	  case '1': $in_product_limit_stock = true; $out_product_limit_stock = false; break;
	  default: $in_product_limit_stock = false; $out_product_limit_stock =true; 
	}
//eof jessa 2009-11-09
// Product is Free
    if (!isset($pInfo->product_is_free)) $pInfo->product_is_free = '0';
    switch ($pInfo->product_is_free) {
      case '0': $in_product_is_free = false; $out_product_is_free = true; break;
      case '1': $in_product_is_free = true; $out_product_is_free = false; break;
      default: $in_product_is_free = false; $out_product_is_free = true;
    }
// Product is Call for price
    if (!isset($pInfo->product_is_call)) $pInfo->product_is_call = '0';
    switch ($pInfo->product_is_call) {
      case '0': $in_product_is_call = false; $out_product_is_call = true; break;
      case '1': $in_product_is_call = true; $out_product_is_call = false; break;
      default: $in_product_is_call = false; $out_product_is_call = true;
    }
// Products can be purchased with mixed attributes retail
    if (!isset($pInfo->products_quantity_mixed)) $pInfo->products_quantity_mixed = '0';
    switch ($pInfo->products_quantity_mixed) {
      case '0': $in_products_quantity_mixed = false; $out_products_quantity_mixed = true; break;
      case '1': $in_products_quantity_mixed = true; $out_products_quantity_mixed = false; break;
      default: $in_products_quantity_mixed = true; $out_products_quantity_mixed = false;
    }

// set image overwrite
  $on_overwrite = true;
  $off_overwrite = false;
// set image delete
  $on_image_delete = false;
  $off_image_delete = true;

  
  //bof properties
  $property_sql = 'select ctp.property_group_id, pg.group_code, pg.group_value from ' . TABLE_CATEGORIES_TO_PROPERTY . ' ctp, ' . TABLE_PROPERTY_GROUP . ' pg where ctp.categories_id = ' . $current_category_id . ' AND ctp.property_group_id = pg.property_group_id AND pg.is_basic = 1 order by pg.sort_order';
  $property = $db->Execute($property_sql);
  if ($property->RecordCount() > 0){
  	while (!$property->EOF){
  		$property_group[] = $property->fields;
  		$property->MoveNext();
  	}
  }
  //eof
?>
<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
<script language="javascript"><!--
  var dateAvailable = new ctlSpiffyCalendarBox("dateAvailable", "new_product", "products_date_available","btnDate1","<?php echo $pInfo->products_date_available; ?>",scBTNMODE_CUSTOMBLUE);
//--></script>
<script language="javascript"><!--
var tax_rates = new Array();
<?php
    for ($i=0, $n=sizeof($tax_class_array); $i<$n; $i++) {
      if ($tax_class_array[$i]['id'] > 0) {
        echo 'tax_rates["' . $tax_class_array[$i]['id'] . '"] = ' . zen_get_tax_rate_value($tax_class_array[$i]['id']) . ';' . "\n";
      }
    }
?>

function doRound(x, places) {
  return Math.round(x * Math.pow(10, places)) / Math.pow(10, places);
}

function getTaxRate() {
  var selected_value = document.forms["new_product"].products_tax_class_id.selectedIndex;
  var parameterVal = document.forms["new_product"].products_tax_class_id[selected_value].value;

  if ( (parameterVal > 0) && (tax_rates[parameterVal] > 0) ) {
    return tax_rates[parameterVal];
  } else {
    return 0;
  }
}

function updateGross() {
 // var taxRate = getTaxRate();
 // var grossValue = document.forms["new_product"].products_net_price.value;

  //if (taxRate > 0) {
  //  grossValue = grossValue * ((taxRate / 100) + 1);
  //}

 // document.forms["new_product"].products_price_gross.value = doRound(grossValue, 4);
}

function updateNet() {
  //var taxRate = getTaxRate();
 // var netValue = document.forms["new_product"].products_price_gross.value;

  //if (taxRate > 0) {
 //  netValue = netValue / ((taxRate / 100) + 1);
 // }

 // document.forms["new_product"].products_net_price.value = doRound(netValue, 4);
}
function model_losefocus()
{
   // document.forms["new_product"].products_model.focus()
    document.forms["new_product"].products_image_manual.value = document.forms["new_product"].products_model.value + ".JPG"
    document.forms["new_product"].img_dir.value = get_product_image_name(document.forms["new_product"].products_model.value);
}
function get_product_image_name(model){
	if(model.length >= 3){
		if(model.substr(0, 1) == 'D' ){
			return 'extra/';
		}else if(model.substr(0, 1) == 'K' ){
			return model.substr(0, 3) + '/';
		}else if(model.substr(0, 1) == 'C' ){
			return model.substr(0, 3) + '/';
		}else if(model.substr(0, 1) == 'P' ){
			return model.substr(0, 3) + '/';
		}else if(model.substr(0, 1) == 'Z' ){
			return model.substr(0, 3) + '/';
		}
		else{
			return (Number(model.substr(1, 2)) + 1) + '/';
		}
		
	}else {
		return '';
	}
}
//--></script>

<table width="100%">
<tr>
  <td class="smallText" align="right">
<?php
    echo zen_draw_form('search', FILENAME_CATEGORIES, '', 'get');
// show reset search
    if (isset($_GET['search']) && zen_not_null($_GET['search'])) {
      echo '<a href="' . zen_href_link(FILENAME_CATEGORIES) . '">' . zen_image_button('button_reset.gif', IMAGE_RESET) . '</a>&nbsp;&nbsp;';
    }
    echo HEADING_TITLE_SEARCH_DETAIL . ' ' . zen_draw_input_field('search') . zen_hide_session_id();
    if (isset($_GET['search']) && zen_not_null($_GET['search'])) {
      $keywords = zen_db_input(zen_db_prepare_input($_GET['search']));
      echo '<br/ >' . TEXT_INFO_SEARCH_DETAIL_FILTER . $keywords;
    }else{
    	echo '<br/><font color="red">'.TEXT_SEARCH_FORMAT.'</font>';
    }
    echo '</form>';
?>
  </td>
</tr>
<tr>
<td class="smallText" align="right">
<?php
  if ($_SESSION['display_categories_dropdown'] == 0) {
    echo '<a href="' . zen_href_link(FILENAME_CATEGORIES, 'set_display_categories_dropdown=1&cID=' . $categories->fields['categories_id'] . '&cPath=' . $cPath . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')) . '">' . zen_image(DIR_WS_ICONS . 'cross.gif', IMAGE_ICON_STATUS_OFF) . '</a>&nbsp;&nbsp;';
    echo zen_draw_form('goto', FILENAME_CATEGORIES, '', 'get');
    echo zen_hide_session_id();
    echo HEADING_TITLE_GOTO . ' ' . zen_draw_pull_down_menu('cPath', zen_get_category_tree(), $current_category_id, 'onChange="this.form.submit();"');
    echo '</form>';
  } else {
    echo '<a href="' . zen_href_link(FILENAME_CATEGORIES, 'set_display_categories_dropdown=0&cID=' . $categories->fields['categories_id'] . '&cPath=' . $cPath . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')) . '">' . zen_image(DIR_WS_ICONS . 'tick.gif', IMAGE_ICON_STATUS_ON) . '</a>&nbsp;&nbsp;';
    echo HEADING_TITLE_GOTO;
  }
?>
</td>
</tr>
</table>
    <?php
//  echo $type_admin_handler;
echo zen_draw_form('new_product', $type_admin_handler , 'cPath=' . $cPath . (isset($_GET['product_type']) ? '&product_type=' . $_GET['product_type'] : '') . (isset($_GET['pID']) ? '&pID=' . $_GET['pID'] : '') . '&action=new_product_preview' . (isset($_GET['page']) ? '&page=' . $_GET['page'] : ''), 'post', 'enctype="multipart/form-data"'); ?>

    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo sprintf(TEXT_NEW_PRODUCT, zen_output_generated_category_path($current_category_id)); ?></td>
            <td class="pageHeading" align="right"><?php echo zen_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main" align="right">
        	<?php 
        	if($pInfo->products_status == 10){
				//echo '<a href="' . zen_href_link(FILENAME_PRODUCT, zen_get_all_get_params()) . '&is_sold_out=2">' . zen_image_button('cancel_soldout.png', IMAGE_CANCEL,' style="width: 102px;height:27px;"') . '</a>';
				echo "<input style='font-size:16px; padding:-10px 10px 0px 10px; cursor:pointer;' type='button' value='恢复下架' onclick='javascript:if(confirm(\"是否将该商品恢复为下架状态？\")) {window.location.href=\"" . zen_href_link(FILENAME_PRODUCT, zen_get_all_get_params(array('action'))) . "&action=delete&is_delete=0\";}' />&nbsp;&nbsp;";
			}else{
				//echo '<a href="' . zen_href_link(FILENAME_PRODUCT, zen_get_all_get_params()) . '&is_sold_out=1">' . zen_image_button('button_delete_cn.png', IMAGE_CANCEL,' style="width: 102px;height:27px;"') . '</a>';
				echo "<input style='font-size:16px; padding:-10px 10px 0px 10px; cursor:pointer;' type='button' value='已删除' onclick='javascript:if(confirm(\"是否将该商品的状态更改为“已删除”？\")) {window.location.href=\"" . zen_href_link(FILENAME_PRODUCT, zen_get_all_get_params(array('action'))) . "&action=delete&is_delete=1\";}' />&nbsp;&nbsp;";
			}
			echo "<input style='font-size:16px; padding:-10px 10px 0px 10px; cursor:pointer;' type='submit' value='预览' />&nbsp;&nbsp;";
			echo "<input style='font-size:16px; padding:-10px 10px 0px 10px; cursor:pointer;' type='button' value='取消' onclick='javascript:window.location.href=\"" . zen_href_link(FILENAME_PRODUCT, zen_get_all_get_params(array('action'))) . "\";' />";
        	?>
        	<?php //echo zen_draw_hidden_field('products_date_added', (zen_not_null($pInfo->products_date_added) ? $pInfo->products_date_added : date('Y-m-d'))) . zen_image_submit('button_preview.gif', IMAGE_PREVIEW) . '&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . (isset($_GET['pID']) ? '&pID=' . $_GET['pID'] : '') . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?>
        </td>
      </tr>
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="2">
<?php
// show when product is linked
if (zen_get_product_is_linked($_GET['pID']) == 'true' and $_GET['pID'] > 0) {
?>
          <tr>
            <td class="main"><?php echo TEXT_MASTER_CATEGORIES_ID; ?></td>
            <td class="main">
              <?php
                // echo zen_draw_pull_down_menu('products_tax_class_id', $tax_class_array, $pInfo->products_tax_class_id);
                echo zen_image(DIR_WS_IMAGES . 'icon_yellow_on.gif', IMAGE_ICON_LINKED) . '&nbsp;&nbsp;';
                echo zen_draw_pull_down_menu('master_category', zen_get_master_categories_pulldown($_GET['pID']), $pInfo->master_categories_id); ?>            </td>
          </tr>
<?php } else { ?>
          <tr>
            <td class="main"><?php echo TEXT_MASTER_CATEGORIES_ID; ?></td>
          <td class="main"><?php echo TEXT_INFO_ID . ($_GET['pID'] > 0 ? $pInfo->master_categories_id  . ' ' . zen_get_category_name($pInfo->master_categories_id, $_SESSION['languages_id']) : $current_category_id  . ' ' . zen_get_category_name($current_category_id, $_SESSION['languages_id'])); ?>          </tr>
<?php } ?>
          <tr>
            <td colspan="2" class="main"><?php echo TEXT_INFO_MASTER_CATEGORIES_ID; ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '100%', '2'); ?></td>
          </tr>
<?php
// hidden fields not changeable on products page
echo zen_draw_hidden_field('master_categories_id', $pInfo->master_categories_id);
echo zen_draw_hidden_field('products_discount_type', $pInfo->products_discount_type);
echo zen_draw_hidden_field('products_discount_type_from', $pInfo->products_discount_type_from);
echo zen_draw_hidden_field('products_price_sorter', $pInfo->products_price_sorter);
?>
          <tr>
            <td colspan="2" class="main" align="center"><?php echo (zen_get_categories_status($current_category_id) == '0' ? TEXT_CATEGORIES_STATUS_INFO_OFF : '') . ($out_status == true ? ' ' . TEXT_PRODUCTS_STATUS_INFO_OFF : ''); ?></td>
          </tr>
          <!--
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_STATUS; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_radio_field('products_status', '1', $in_status) . '&nbsp;' . TEXT_PRODUCT_AVAILABLE . '&nbsp;' . zen_draw_radio_field('products_status', '0', $out_status) . '&nbsp;' . TEXT_PRODUCT_NOT_AVAILABLE . '&nbsp;' . zen_draw_radio_field('products_status', '10', $is_deleted) . '&nbsp;已删除' ?>
            	<?php 
            		//jessa 2010-02-01 add the old quantity
            		echo zen_draw_hidden_field('old_quantity', $pInfo->products_quantity);
            		//eof jessa 2010-02-01
            	?>
            </td>
          </tr>
          -->
          <tr> 
			<td class="main">Product is mixed:</td> 
			<td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_radio_field('is_mixed', '1', ($pInfo->is_mixed==1)) . '&nbsp;' . TEXT_YES . '&nbsp;&nbsp;' . zen_draw_radio_field('is_mixed', '0', ($pInfo->is_mixed==0)) . '&nbsp;' . TEXT_NO; ?></td> 
		  </tr> 
          
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_DATE_AVAILABLE; ?><br /><small>(YYYY-MM-DD)</small></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;'; ?><script language="javascript">dateAvailable.writeControl(); dateAvailable.dateFormat="yyyy-MM-dd";</script></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_MANUFACTURER; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_pull_down_menu('manufacturers_id', $manufacturers_array, $pInfo->manufacturers_id); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
<?php
    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
          <tr>
            <td class="main"><?php if ($i == 0) echo TEXT_PRODUCTS_NAME; ?></td>
            <td class="main"><?php echo zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . zen_draw_input_field('products_name[' . $languages[$i]['id'] . ']', (isset($products_name[$languages[$i]['id']]) ? stripslashes($products_name[$languages[$i]['id']]) : zen_get_products_name($pInfo->products_id, $languages[$i]['id'])), zen_set_field_length(TABLE_PRODUCTS_DESCRIPTION, 'products_name')); ?></td>
          </tr>
<?php
    }

    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
<!--jessa 2010-02-01 add the products without Property-->
		 <tr>
		 	<td class="main">Name Without Property:</td>
			<td class="main"><?php echo  zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' .zen_draw_input_field ( 'products_name_without_catg[' . $languages [$i] ['id'] . ']', isset ( $products_name_without_catg [$languages [$i] ['id']] ) ? stripslashes ( $products_name_without_catg [$languages [$i] ['id']] ) : zen_get_products_name_without_catg ( $pInfo->products_id, $languages [$i] ['id'] ), zen_set_field_length ( TABLE_PRODUCTS_DESCRIPTION, 'products_name_without_catg' ) ); ?></td>
		 </tr>
<!--eof jessa 2010-02-01-->
<?php
    }
?>
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          
          <!--jessa 2010-01-22 add the match products input box-->
          <tr>
            <td class="main"><?php echo 'Match Product No.: '; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('match_products', $pInfo->match_prod_list, 'maxlength="512" size="51"'); ?>	</td>
          </tr>
		  <!--eof jessa 2010-01-22-->
		  
<!--jessa 2009-11-09 閿熸枻鎷烽敓鎻紮鎷烽敓绐栤槄鎷风澘顒婃嫹閿熸枻鎷疯瘨閿熺粸璁规嫹娆犻敓鏂ゆ嫹閿熸枻鎷烽敓鏂ゆ嫹-->		  
		  <tr>
            <td class="main"><?php echo LIMIT_STOCK_QUANTITY; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_radio_field('limit_stock', '1', ($in_product_limit_stock==1)) . '&nbsp;' . TEXT_YES . '&nbsp;&nbsp;' . zen_draw_radio_field('limit_stock', '0', ($in_product_limit_stock==0)) . '&nbsp;' . TEXT_NO . ' ' . ($pInfo->products_limit_stock == 1 ? '<span class="errorText">' . TEXT_PRODUCTS_LIMIT_STOCK_EDIT . '</span>' : ''); ?></td>
          </tr>
		  
<!--eof jessa 2009-11-09-->		  

          <tr>
            <td class="main"><?php echo TEXT_PRODUCT_IS_FREE; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_radio_field('product_is_free', '1', ($in_product_is_free==1)) . '&nbsp;' . TEXT_YES . '&nbsp;&nbsp;' . zen_draw_radio_field('product_is_free', '0', ($in_product_is_free==0)) . '&nbsp;' . TEXT_NO . ' ' . ($pInfo->product_is_free == 1 ? '<span class="errorText">' . TEXT_PRODUCTS_IS_FREE_EDIT . '</span>' : ''); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCT_IS_CALL; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_radio_field('product_is_call', '1', ($in_product_is_call==1)) . '&nbsp;' . TEXT_YES . '&nbsp;&nbsp;' . zen_draw_radio_field('product_is_call', '0', ($in_product_is_call==0)) . '&nbsp;' . TEXT_NO . ' ' . ($pInfo->product_is_call == 1 ? '<span class="errorText">' . TEXT_PRODUCTS_IS_CALL_EDIT . '</span>' : ''); ?></td>
          </tr>

          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_PRICED_BY_ATTRIBUTES; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_radio_field('products_priced_by_attribute', '1', $is_products_priced_by_attribute) . '&nbsp;' . TEXT_PRODUCT_IS_PRICED_BY_ATTRIBUTE . '&nbsp;&nbsp;' . zen_draw_radio_field('products_priced_by_attribute', '0', $not_products_priced_by_attribute) . '&nbsp;' . TEXT_PRODUCT_NOT_PRICED_BY_ATTRIBUTE . ' ' . ($pInfo->products_priced_by_attribute == 1 ? '<span class="errorText">' . TEXT_PRODUCTS_PRICED_BY_ATTRIBUTES_EDIT . '</span>' : ''); ?></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr bgcolor="#ebebff">
            <td class="main"><?php echo TEXT_PRODUCTS_TAX_CLASS; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_pull_down_menu('products_tax_class_id', $tax_class_array, $pInfo->products_tax_class_id, 'onchange="updateGross()"'); ?></td>
          </tr>
          <tr bgcolor="#ebebff">
            <td height="22" class="main"><?php echo TEXT_PRODUCTS_PRICE_NET; ?></td>
            <td height="22" class="main">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php 
echo $pInfo->products_price;
			?></td>
          </tr>
          <tr bgcolor="#ebebff">
            <td height="22" class="main"><?php echo TEXT_PRODUCTS_PRICE_GROSS; ?></td>
            <td height="22" class="main">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php 
echo $pInfo->products_price;
			?></td>
          </tr>
          <tr bgcolor="#ebebff">
            <td class="main"><?php echo TEXT_PRODUCTS_NET_PRICE; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('products_net_price', $pInfo->products_net_price) . zen_draw_hidden_field('old_net_price', $pInfo->products_net_price); //jessa 2010-01-29 閿熸枻鎷烽敓鏂ゆ嫹涓�敓鏂ゆ嫹閿熸枻鎷烽敓鏂ゆ嫹閿熸枻鎷烽敓鏂ゆ嫹閿熸枻鎷烽敓鏂ゆ嫹褰曞師閿熸枻鎷烽敓渚ユ棫纰夋嫹net_price; ?></td>
          </tr>

<!--jessa 2010-01-25 add product_price_times-->
		  <tr bgcolor="#ebebff">
            <td class="main"><?php echo 'Product Price modulus:';?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('product_price_times', $pInfo->product_price_times) . zen_draw_hidden_field('old_price_times', $pInfo->product_price_times);//jessa 2010-01-29 閿熸枻鎷烽敓鏂ゆ嫹涓�敓鏂ゆ嫹閿熸枻鎷烽敓鏂ゆ嫹閿熸枻鎷烽敓鏂ゆ嫹閿熸枻鎷烽敓鏂ゆ嫹褰曢敓缂寸鎷穚rice time;?></td>
          </tr>
<!--eof jessa 2010-01-25-->
          
          <tr>
          	<td>上浮比例：</td>
          	<td>
			<input type="checkbox" name="price_manager_check" value="1"> 上调比例 
			<?php
				if ($_GET ['pID'] > 0) {
					$price_manager_products = $db->Execute ( "SELECT price_manager_id FROM  " . TABLE_PRODUCTS . " WHERE products_id = " . ( int ) $_GET ['pID'] );
					if ($price_manager_products->fields ['price_manager_id'] > 0) {
						$price_manager_defaunt_id = $price_manager_products->fields ['price_manager_id'];					
					}
				}
				$price_manager_array [] = array (
						'id' => 0,
						'text' => '请选择' 
				);
				$price_manager = $db->Execute ( "SELECT price_manager_id, price_manager_value FROM  " . TABLE_PRICE_MANAGER . " order by price_manager_id desc " );
				while ( ! $price_manager->EOF ) {
					$price_manager_array [] = array (
							'id' => $price_manager->fields ['price_manager_id'],
							'text' => $price_manager->fields ['price_manager_value'] . '%' 
					);
					$price_manager->MoveNext ();
				}
				if (! isset ( $_GET ['pID'] )) {
					$price_manager_defaunt_id = 33;
				}
				echo zen_draw_pull_down_menu ( 'price_manager', $price_manager_array, $price_manager_defaunt_id );
			?>
			</td>
		  </tr>
          <tr>
			<td>备货周期：</td>
			<td><?php echo zen_draw_input_field('products_stocking_days', $pInfo->products_stocking_days != null ? $pInfo->products_stocking_days : 0)?></td>
		  </tr>
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_VIRTUAL; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_radio_field('products_virtual', '1', $is_virtual) . '&nbsp;' . TEXT_PRODUCT_IS_VIRTUAL . '&nbsp;' . zen_draw_radio_field('products_virtual', '0', $not_virtual) . '&nbsp;' . TEXT_PRODUCT_NOT_VIRTUAL . ' ' . ($pInfo->products_virtual == 1 ? '<br /><span class="errorText">' . TEXT_VIRTUAL_EDIT . '</span>' : ''); ?></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_PRODUCTS_IS_ALWAYS_FREE_SHIPPING; ?></td>
            <td class="main" valign="top"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_radio_field('product_is_always_free_shipping', '1', $is_product_is_always_free_shipping) . '&nbsp;' . TEXT_PRODUCT_IS_ALWAYS_FREE_SHIPPING . '&nbsp;' . zen_draw_radio_field('product_is_always_free_shipping', '0', $not_product_is_always_free_shipping) . '&nbsp;' . TEXT_PRODUCT_NOT_ALWAYS_FREE_SHIPPING  . '<br />' . zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_radio_field('product_is_always_free_shipping', '2', $special_product_is_always_free_shipping) . '&nbsp;' . TEXT_PRODUCT_SPECIAL_ALWAYS_FREE_SHIPPING . ' ' . ($pInfo->product_is_always_free_shipping == 1 ? '<br /><span class="errorText">' . TEXT_FREE_SHIPPING_EDIT . '</span>' : ''); ?></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_QTY_BOX_STATUS; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_radio_field('products_qty_box_status', '1', $is_products_qty_box_status) . '&nbsp;' . TEXT_PRODUCTS_QTY_BOX_STATUS_ON . '&nbsp;' . zen_draw_radio_field('products_qty_box_status', '0', $not_products_qty_box_status) . '&nbsp;' . TEXT_PRODUCTS_QTY_BOX_STATUS_OFF . ' ' . ($pInfo->products_qty_box_status == 0 ? '<br /><span class="errorText">' . TEXT_PRODUCTS_QTY_BOX_STATUS_EDIT . '</span>' : ''); ?></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_QUANTITY_MIN_RETAIL; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('products_quantity_order_min', ($pInfo->products_quantity_order_min == 0 ? 1 : $pInfo->products_quantity_order_min)); ?></td>
          </tr>

          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_QUANTITY_MAX_RETAIL; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('products_quantity_order_max', $pInfo->products_quantity_order_max); ?>&nbsp;&nbsp;<?php echo TEXT_PRODUCTS_QUANTITY_MAX_RETAIL_EDIT; ?></td>
          </tr>

          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_QUANTITY_UNITS_RETAIL; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('products_quantity_order_units', ($pInfo->products_quantity_order_units == 0 ? 1 : $pInfo->products_quantity_order_units)); ?></td>
          </tr>

          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_MIXED; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_radio_field('products_quantity_mixed', '1', $in_products_quantity_mixed) . '&nbsp;' . TEXT_YES . '&nbsp;&nbsp;' . zen_draw_radio_field('products_quantity_mixed', '0', $out_products_quantity_mixed) . '&nbsp;' . TEXT_NO; ?></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

<script language="javascript"><!--
updateGross();
//--></script>
<?php
    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
            <tr>
            <td class="main" valign="top"><?php if ($i == 0) echo TEXT_PRODUCTS_DESCRIPTION; ?></td>
            <td colspan="2"><table border="0" cellspacing="0" cellpadding="0" width="100%">
              <tr>
                <td class="main" width="25" valign="top"><?php echo zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']); ?>&nbsp;</td>
                <td class="main" width="100%">
                  <?php
                $oFCKeditor = new FCKeditor('products_description[' . $languages[$i]['id'] . ']') ;
                $oFCKeditor->Value = (isset($products_description[$languages[$i]['id']])) ? stripslashes($products_description[$languages[$i]['id']]) : zen_get_products_description($pInfo->products_id, $languages[$i]['id']) ;
                  $oFCKeditor->Width = '99%';
                  $oFCKeditor->Height = '350';
                        $oFCKeditor->ToolbarSet = 'ProductDesc' ;
                $output = $oFCKeditor->CreateHtml() ;  echo $output;

          ?>        </td>
              </tr>
            </table></td>
          </tr>
<?php
    }
?>
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_QUANTITY; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('products_quantity', $pInfo->products_quantity); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_MODEL; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('products_model', $pInfo->products_model, zen_set_field_length(TABLE_PRODUCTS, 'products_model') . 'onBlur="model_losefocus()"'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
<?php
  $dir = @dir(DIR_FS_CATALOG_IMAGES);
  $dir_info[] = array('id' => '', 'text' => "Main Directory");
  while ($file = $dir->read()) {
    if (is_dir(DIR_FS_CATALOG_IMAGES . $file) && strtoupper($file) != 'CVS' && $file != "." && $file != "..") {
      $dir_info[] = array('id' => $file . '/', 'text' => $file);
    }
  }
  $dir->close();
  sort($dir_info);

  $default_directory = substr( $pInfo->products_image, 0,strpos( $pInfo->products_image, '/')+1);
?>

          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_black.gif', '100%', '3'); ?></td>
          </tr>

          <tr>
            <td class="main" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="main"><?php echo TEXT_PRODUCTS_IMAGE; ?></td>
                <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_file_field('products_image') . '&nbsp;' . ($pInfo->products_image !='' ? TEXT_IMAGE_CURRENT . $pInfo->products_image : TEXT_IMAGE_CURRENT . '&nbsp;' . NONE) . zen_draw_hidden_field('products_previous_image', $pInfo->products_image); ?></td>
                <?php 
                if ($pInfo->products_model != ''){
                	$products_image_arr = explode('/', $pInfo->products_image);
                	$pInfo->img_dir = $products_image_arr[0] . '/';
                }
                ?>
                <td valign = "center" class="main"><?php echo TEXT_PRODUCTS_IMAGE_DIR; ?>&nbsp;<?php //echo zen_draw_pull_down_menu('img_dir', $dir_info, $default_directory); ?><?php echo zen_draw_input_field('img_dir', $pInfo->img_dir != '' ? $pInfo->img_dir : '', 'readonly size="6"');?></td>
			  </tr>
              <tr>
                <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15'); ?></td>
                <td class="main" valign="top"><?php echo TEXT_IMAGES_DELETE . ' ' . zen_draw_radio_field('image_delete', '0', $off_image_delete) . '&nbsp;' . TABLE_HEADING_NO . ' ' . zen_draw_radio_field('image_delete', '1', $on_image_delete) . '&nbsp;' . TABLE_HEADING_YES; ?></td>
  	    	  </tr>

              <tr>
                <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15'); ?></td>
                <td colspan="3" class="main" valign="top"><?php echo TEXT_IMAGES_OVERWRITE  . ' ' . zen_draw_radio_field('overwrite', '0', $off_overwrite) . '&nbsp;' . TABLE_HEADING_NO . ' ' . zen_draw_radio_field('overwrite', '1', $on_overwrite) . '&nbsp;' . TABLE_HEADING_YES; ?>
                  <?php 
                		
                		$products_image = array_pop($products_image_arr);
                	?>
                  <?php echo '<br />' . TEXT_PRODUCTS_IMAGE_MANUAL . '&nbsp;' . zen_draw_input_field('products_image_manual' , $products_image); ?></td>
              </tr>
            </table></td> 
          </tr>

          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_black.gif', '100%', '3'); ?></td>
          </tr>

<?php
    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
          <tr>
            <td class="main"><?php if ($i == 0) echo TEXT_PRODUCTS_URL . '<br /><small>' . TEXT_PRODUCTS_URL_WITHOUT_HTTP . '</small>'; ?></td>
            <td class="main"><?php echo zen_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . zen_draw_input_field('products_url[' . $languages[$i]['id'] . ']', (isset($products_url[$languages[$i]['id']]) ? $products_url[$languages[$i]['id']] : zen_get_products_url($pInfo->products_id, $languages[$i]['id'])), zen_set_field_length(TABLE_PRODUCTS_DESCRIPTION, 'products_url')); ?></td>
          </tr>
<?php
    }
?>
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_WEIGHT; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('products_weight', $pInfo->products_weight) . zen_draw_hidden_field('old_product_weight', $pInfo->products_weight);//jessa 2010-01-29 閿熸枻鎷烽敓鏂ゆ嫹涓�敓鏂ゆ嫹閿熸枻鎷烽敓鏂ゆ嫹閿熸枻鎷烽敓鏂ゆ嫹閿熸枻鎷烽敓鏂ゆ嫹褰曢敓缂寸鎷烽敓鏂ゆ嫹閿熸枻鎷�; ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
		  	<td class="main"><?php echo 'Products Volume Weight:'?></td>
			<td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('products_volume_weight', $pInfo->products_volume_weight); ?></td>
		  </tr>
          <tr>
            <td colspan="2"><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_SORT_ORDER; ?></td>
            <td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('products_sort_order', $pInfo->products_sort_order); ?></td>
          </tr>
		  <tr>
		  	<td class="main"><?php echo 'Products Level :'?></td>
			<td class="main"><?php echo zen_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . zen_draw_input_field('products_level', $pInfo->products_level); ?></td>
		  </tr>
          <tr>
             <td>是否搜索隐藏:</td>
             <td><?php echo zen_draw_radio_field('is_display', '0', $pInfo->is_display == 0 ? true : false) . ' 是<br />' . zen_draw_radio_field('is_display', '1', $pInfo->is_display == 1 ? true : false) . ' 否'; ?></td>
          </tr>
		  
		   <?php
    	for ($i = 0; $i < sizeof($property_group); $i++){
			$property_name_cn = $property_group[$i]['group_value'];
			$sql = 'select distinct property_id, property_value from ' . TABLE_PROPERTY . ' where  property_group_id = ' . (int)$property_group[$i]['property_group_id'] ;
			$property_value_result = $db->Execute($sql);
			$property_value_array = '';
			if ($property_value_result->RecordCount() > 0){
				$property_value_array[0] = array ('id' => '', 'text' => '请选择');
				while (!$property_value_result->EOF){
					$property_value_array[] = array ('id' => $property_value_result->fields['property_id'], 'text' => $property_value_result->fields['property_value']);
					$property_value_result->MoveNext();
				}
			}
			if ($_POST['property_group_id'][$property_group[$i]['property_group_id']] != ''){
				$property_display_id = $_POST['property_group_id'][$property_group[$i]['property_group_id']];
			}else{
				if ($_GET ['pID'] != ''){
					$property_default_id_query = $db->Execute('select property_id from ' . TABLE_PRODUCTS_TO_PROPERTY . ' where product_id = ' . $_GET ['pID'] . ' and property_group_id = ' . $property_group[$i]['property_group_id']);
					$property_default_id = $property_default_id_query->fields['property_id'];
					$property_display_id = $property_default_id;
					
				}
			}
    ?>
    <tr>
    	<td><?php echo $property_name_cn;?>:</td>
    	<td><?php echo zen_draw_pull_down_menu('property_value[' . $property_group[$i]['property_group_id'] . ']', $property_value_array, $property_display_id, 'style="width:134px"'); ?></td>
    </tr>
    <?php 
    	}
    ?>
    
        </table></td>
      </tr>
      <tr>
        <td><?php echo zen_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main" align="right">
        <?php 
    	if($pInfo->products_status == 10){
			//echo '<a href="' . zen_href_link(FILENAME_PRODUCT, zen_get_all_get_params()) . '&is_sold_out=2">' . zen_image_button('cancel_soldout.png', IMAGE_CANCEL,' style="width: 102px;height:27px;"') . '</a>';
			echo "<input style='font-size:16px; padding:-10px 10px 0px 10px; cursor:pointer;' type='button' value='恢复下架' onclick='javascript:if(confirm(\"是否将该商品恢复为下架状态？\")) {window.location.href=\"" . zen_href_link(FILENAME_PRODUCT, zen_get_all_get_params(array('action'))) . "&action=delete&is_delete=0\";}' />&nbsp;&nbsp;";
		}else{
			//echo '<a href="' . zen_href_link(FILENAME_PRODUCT, zen_get_all_get_params()) . '&is_sold_out=1">' . zen_image_button('button_delete_cn.png', IMAGE_CANCEL,' style="width: 102px;height:27px;"') . '</a>';
			echo "<input style='font-size:16px; padding:-10px 10px 0px 10px; cursor:pointer;' type='button' value='已删除' onclick='javascript:if(confirm(\"是否将该商品的状态更改为“已删除”？\")) {window.location.href=\"" . zen_href_link(FILENAME_PRODUCT, zen_get_all_get_params(array('action'))) . "&action=delete&is_delete=1\";}' />&nbsp;&nbsp;";
		}
		echo "<input style='font-size:16px; padding:-10px 10px 0px 10px; cursor:pointer;' type='submit' value='预览' />&nbsp;&nbsp;";
		echo "<input style='font-size:16px; padding:-10px 10px 0px 10px; cursor:pointer;' type='button' value='取消' onclick='javascript:window.location.href=\"" . zen_href_link(FILENAME_PRODUCT, zen_get_all_get_params(array('action'))) . "\";' />";
    	?>
        <?php //echo zen_draw_hidden_field('products_date_added', (zen_not_null($pInfo->products_date_added) ? $pInfo->products_date_added : date('Y-m-d'))) . zen_image_submit('button_preview.gif', IMAGE_PREVIEW) . '&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . (isset($_GET['pID']) ? '&pID=' . $_GET['pID'] : '') . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')) . '">' . zen_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?>
        </td>
      </tr>
    </table></form>