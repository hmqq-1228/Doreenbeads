<?php
$zco_notifier->notify ( 'NOTIFY_HEADER_START_ACCOUNT_HISTORY_INFO' );
$page_account = true;
require (DIR_WS_MODULES . zen_get_module_directory ( 'require_languages.php' ));
if (!isset($_SESSION['customer_id']) || (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] == '')){
    $_SESSION ['navigation']->set_snapshot ();
    zen_redirect(zen_href_link(FILENAME_LOGIN));
}
if (! isset ( $_GET ['order_id'] ) || (isset ( $_GET ['order_id'] ) && ! is_numeric ( $_GET ['order_id'] ))) {
    zen_redirect ( zen_href_link ( FILENAME_ACCOUNT, '', 'SSL' ) );
}
$paypal_payment_message = zen_db_prepare_input($_GET['paypal_payment_message']);
$breadcrumb->add ( NAVBAR_TITLE, zen_href_link ( FILENAME_ACCOUNT, '', 'SSL' ) );

require (DIR_WS_CLASSES . 'order.php');
$order = new order ( $_GET ['order_id'] );

if(zen_not_null($order->info['shippingNum'])){
    $shipping_number_str=$order->info['shippingNum'];
    $shipping_number_arr=explode(',', $shipping_number_str);
    $shipping_ways_website=array(
        'ywdhl'=>'http://www.dhl.com/en.html',
        'ywlbip'=>'http://www.fedex.com/Tracking',
        'kdups'=>'http://www.ups.com',
        'zyups'=>'http://www.ups.com',
        'upssk'=>'http://www.ups.com',
        'upskj'=>'http://www.ups.com',
        'upsdh'=>'http://www.ups.com',
        'chinapost'=>'http://www.ems.com.cn/english.html',
        'kddhl'=>'http://www.kddhl.com/en/',
        'hmdpd'=>'http://www.cne.sh.cn/english/',
        'afexpr'=>'http://www.cne.sh.cn/english/',
        'hmey'=>'http://www.cne.sh.cn/english/',
        'hmmz'=>'http://www.cne.sh.cn/english/',
        'airmail'=>'http://www.17track.net/IndexEn.html',
        'airmaillp'=>'http://www.cnexps.com/english/',
        'sfhyzxb'=>'http://www.sfhpost.com',
        'sfhky'=>'http://www.sfhpost.com',
        'ywfedex'=>'http://www.fedex.com/Tracking',
        'kdfedex'=>'http://www.fedex.com/Tracking',
        'zyfedex'=>'http://www.fedex.com/Tracking'
    );

    $shipping_number_input=array();
    foreach($shipping_number_arr as $val){
        $shipping_way=$order->info['shipping_module_code'];
        if($shipping_ways_website[$shipping_way]!=''){
            $shipping_number_input[]='<a style="color:#008FED" href="'.$shipping_ways_website[$shipping_way].'" target="_blank">'.trim($val).'</a>';
        }else{
            $shipping_number_input[]=trim($val);
        }
    }
    $shipping_number_input_str=implode(', ', $shipping_number_input);
}else{
    $shipping_number_input_str='';
}
$message['shipping_number_input']=$shipping_number_input_str;

$order_query = "select orders_status
                        from " . TABLE_ORDERS . "
                        where orders_id = '" . ( int ) $_GET ['order_id'] . "' and customers_id = " . $_SESSION['customer_id'] . " limit 1";
$orders_status = $db->Execute ( $order_query );
if ($orders_status->RecordCount() == 0) {
    zen_redirect ( zen_href_link ( FILENAME_ACCOUNT, '', 'SSL' ) );
}
$orders ['order_id'] = $_GET ['order_id'];
$orders ['order_status'] = $orders_status->fields ['orders_status'];
$orders ['date_purchased_format'] = date ( 'M j, Y', strtotime ( $order->info ['date_purchased'] ) );

$payment_records = $db->Execute ( "select payment_records_id, payment_type from " . TABLE_PAYMENT_RECORDS . " where orders_id = '" . ( int ) $_GET ['order_id'] . "' order by payment_records_id desc limit 1" );
if ($payment_records->RecordCount () == 1) {
    $payment_type = $payment_records->fields['payment_type'];
}else{
    if ($order->info ['payment_method'] != ''){
        $payment_type = $order->info ['payment_method'];
    }else{
        $payment_type = 'Paypal';
    }
}

if((isset($_SESSION['is_old_customers']) && $_SESSION['is_old_customers'] == 0 ) && in_array($orders_status->fields['orders_status'], explode(',', MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP))){
    $db->Execute('update ' . TABLE_CUSTOMERS . ' set is_old_customers = 1 where customers_id= "' . $_SESSION['customer_id'] . '"' );
}

$make_payment = false;
if (isset ( $_GET ['continued_order'] ) && $_GET ['continued_order'] == 'payment' && $orders ['order_status'] == 1 && $payment_records->RecordCount() == 0) {
    $breadcrumb->add ( NAVBAR_TITLE_2, zen_href_link ( FILENAME_ACCOUNT, '', 'SSL'));
    $breadcrumb->add ( sprintf ( NAVBAR_TITLE_3, $_GET ['order_id'] ), zen_href_link ( FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $_GET ['order_id'], 'SSL') );
    $breadcrumb->add ( NAVBAR_TITLE_4 );
    $make_payment = true;
}else{
    $breadcrumb->add ( NAVBAR_TITLE_2, zen_href_link ( FILENAME_ACCOUNT, '', 'SSL' ));
    $breadcrumb->add ( sprintf ( NAVBAR_TITLE_3, $_GET ['order_id'], '', 'SSL') );
    //zen_redirect(zen_href_link(FILENAME_ACCOUNT));
}

if($orders ['order_status']==2 && $_SESSION['payment_return_account']){
    //	20150422 xiaoyong.lv
    present_promotion_coupon($orders['order_id']);

    //	invite frineds 20150422 xiaoyong.lv
    $fun_inviteFriends->sendCoupon($_GET['order_id']);

    unset($_SESSION['payment_return_account']);
}
$total_original = 0;
for($j = 0, $m = sizeof ( $order->products ); $j < $m; $j ++) {
    $products_tax = $order->products [$j] ['tax'];
    $products_price = $db->Execute ( "select products_id,products_price,products_priced_by_attribute,products_discount_type from " . TABLE_PRODUCTS . " where products_id = " . $order->products [$j] ['id'] . " limit 1" );
    $original_price = $products_price->fields ['products_price'];
    if ($products_price->fields ['products_priced_by_attribute'] == '1' and zen_has_product_attributes ( $products_price->fields ['products_id'], 'false' )) {
    } else {
        if ($products_price->fields ['products_discount_type'] != '0') {
            $original_price = zen_get_products_discount_price_qty ( $products_price->fields ['products_id'], $order->products [$j] ['qty'], 0, false );
        }
    }
    $total_original += $currencies->format_cl ( zen_add_tax ( $original_price, $products_tax ), true, $order->info ['currency'] ) * $order->products [$j] ['qty'];
}

$get_vip_amount_sql = "select value from " . TABLE_ORDERS_TOTAL . " where class='ot_group_pricing' and orders_id = " . $_GET ['order_id'];
$get_vip_amount = $db->Execute ( $get_vip_amount_sql );
if ($get_vip_amount->RecordCount () > 0) {
    $get_sub_total_sql = "select value from " . TABLE_ORDERS_TOTAL . " where class='ot_subtotal' and orders_id = " . $_GET ['order_id'];
    $get_sub_total = $db->Execute ( $get_sub_total_sql );
    $vip_discount = "(" . (round ( $get_vip_amount->fields ['value'] / $get_sub_total->fields ['value'], 2 ) * 100) . "% off)";
} else {
    $vip_discount = "";
}
$discount = 0;
$vip = 0;
$rcd = 0;
$orders_discounts = 0;
$special_discount = 0;
for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++){
    if(in_array($order->totals[$i]['class'], array('ot_group_pricing'))){
        $vip +=$currencies->format_cl($order->totals[$i]['value']);
    }else{
        $vip += 0;
    }
    if(in_array($order->totals[$i]['class'], array('ot_coupon'))){
        $rcd += $currencies->format_cl($order->totals[$i]['value']);
    }else{
        $rcd += 0;
    }
    if(in_array($order->totals[$i]['class'], array('ot_order_discount'))){
        $orders_discounts += $currencies->format_cl($order->totals[$i]['value']);
    }else{
        $orders_discounts += 0;
    }
    if(in_array($order->totals[$i]['class'], array('ot_big_orderd'))){
        $special_discount += $currencies->format_cl($order->totals[$i]['value']);
    }else{
        $special_discount += 0;
    }
}
$vip_rcd = $vip+$rcd;
if($orders_discounts >= $vip_rcd){
    $discount  = $orders_discounts+$special_discount;
}else{
    $discount = $vip_rcd+$special_discount;
}
$a = true;
$str = '<tr><td align="right">' . HEADING_PAYMENT_METHOD . ':<br/><br/></td><td>' . $payment_type . '<br/><br/></td></tr>';
if ($make_payment) $str = '';
for($i = 0, $n = sizeof ( $order->totals ); $i < $n; $i ++) {
    $str .= '<tr>';
    if ($order->totals [$i] ['class'] == 'ot_total') {
        $title = '<td align="right"><b>' . HEADING_TOTAL . ':</b></td>';
        $str .= $title . '<td><ins>' . $currencies->format($order->totals[$i]['value'], true, $order->info['currency'], $order->info['currency_value']) . '</td>' . '</ins></td>';
    } else {
        if ($order->totals [$i] ['class'] == 'ot_subtotal') {
             $promotion_discount = $total_original - $currencies->format_cl ( $order->totals [$i] ['value'], true, $order->info ['currency'] );

        $original_prices = $currencies->format_cl($order->totals [$i] ['value']) + $promotion_discount;
            $order->totals [$i] ['title'] = TEXT_CART_ORIGINAL_PRICES . ':';
            $order->totals [$i] ['text'] = $currencies->format ( $original_prices,false, $order->info ['currency'], $order->info ['currency_value'] );
            
        }
        if ($order->totals [$i] ['class'] == 'ot_shipping') {
            $order->totals [$i] ['title'] = TEXT_SHIPPING_CHARGE;
        }
        if ($order->totals [$i] ['class'] == 'ot_group_pricing') {
            require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/modules/order_total/ot_group_pricing.php');
            $order->totals [$i] ['title'] = MODULE_ORDER_TOTAL_GROUP_PRICING_TITLE . ':';
        }
        if ($order->totals [$i] ['class'] == 'ot_coupon') {
            require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/modules/order_total/ot_coupon.php');
            //if($order->totals [$i] ['title'] < MODULE_ORDER_TOTAL_COUPON_TITLE_FIRST.":") {
            //	$order->totals [$i] ['title'] = MODULE_ORDER_TOTAL_COUPON_TITLE;
            //}
        }
        if($order->totals[$i]['class'] == 'ot_promotion'){
            require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/modules/order_total/ot_promotion.php');
            $order->totals[$i]['title'] = TEXT_PROMOTION_DISCOUNT;
        }
        if ($order->totals [$i] ['class'] == 'ot_cash_account') {
            require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/modules/order_total/ot_cash_account.php');
            $order->totals [$i] ['title'] = MODULE_ORDER_TOTAL_BALANCE_CASH_ACCOUNT_TITLE . ':';
        }
        if ($order->totals [$i] ['class'] == 'ot_extra_amount') {
            require (DIR_WS_LANGUAGES . $_SESSION ['language'] . '/modules/order_total/ot_total.php');
            $order->totals [$i] ['title'] = MODULE_ORDER_EXTRA_TOTAL_TITLE . ':';
        }

        if (substr ( $order->totals [$i] ['text'], 0, 1 ) == '-') {
            if ($order->totals [$i] ['class'] == 'ot_group_pricing') {
                $title = ' <td align="right">' . MODULE_ORDER_TOTAL_GROUP_PRICING_TITLE.':</td>';
                // $str .= $title . ' <td>- ' . $currencies->format($order->totals [$i] ['value'], true, $order->info ['currency'], $order->info ['currency_value']) . '</td>';
            } else if ($order->totals [$i] ['class'] == 'ot_coupon') {

                $title_discoupon = $order->totals [$i] ['title'];
                $first_order = false;
                if(in_array(preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$title_discoupon), array('NewCustomerCoupon:','RabattderersteBestellung:','Скидкадляпервогозаказа:','Discountde1èrecommande:' ))) {
                    $first_order = true;
                    $title = ' <td align="right">' . MODULE_ORDER_TOTAL_COUPON_TITLE_FIRST . ': </td>';
                } else {
                    $title = ' <td align="right">RCD: </td>';
                }
                if(!$first_order) {
                    // $str .= $title . ' <td> ' . substr ( $order->totals [$i] ['text'], 1 ) . ' (3% '.TEXT_DISCOUNT_OFF.')</td>';
                } else {
                    // $str .= $title . ' <td> ' . substr ( $order->totals [$i] ['text'], 1 ) . '</td>';
                }
            } else if($order->totals[$i]['class'] == 'ot_extra_amount') {
                $title =' <td valign="top" width="150px;"  align="right">' . $order->totals[$i]['title'].' </td>' . "\n";
                $orders_discount_sql = 'select orders_discount_value from '.TABLE_ORDERS_DISCOUNT_NOTE.' where orders_id='.(int)$_GET['order_id'].' order by orders_discount_date desc limit 1 ';
                $orders_discount = $db->Execute($orders_discount_sql);
                if(isset($orders_discount->fields['orders_discount_value']) && $orders_discount->fields['orders_discount_value'] != ''){
                    $discount_alt = '&nbsp;&nbsp;<ins title="'.$orders_discount->fields['orders_discount_value'].'" style="display:inline-block;width:18px;height:18px;background:url(./includes/templates/cherry_zen/css/en/images/icon_shopcartbg.png) -82px -78px;position:relative;top:2px;cursor:pointer;"></ins>';
                }
                $str .= $title.' <td>- ' .  substr ( $order->totals [$i] ['text'], 1 ) .$discount_alt. '
						</td>' . "\n";
            }else if($order->totals[$i]['class'] == 'ot_order_discount'){
                $str .= '';
            }else if($order->totals [$i] ['class'] == 'ot_discount_coupon'){
                $title =' <td valign="top" width="150px;"  align="right">' . $order->totals[$i]['title'].' </td>' . "\n";
                $str .= $title . ' <td>- ' . substr ( $order->totals [$i] ['text'], 1 ) . '</td>' . "\n";
            } else {
                $title = ' <td align="right">' . $order->totals [$i] ['title'] . '</td>';
                // $str .= $title . ' <td>- ' . substr ( $order->totals [$i] ['text'], 1 ) . '</td>';
            }
        } else if($order->totals[$i]['class'] == 'ot_extra_amount'){
            $title =' <td valign="top" width="150px;"  align="right">' . $order->totals[$i]['title'].' </td>' . "\n";
            $orders_discount_sql = 'select orders_discount_value from '.TABLE_ORDERS_DISCOUNT_NOTE.' where orders_id='.(int)$_GET['order_id'].' order by orders_discount_date desc limit 1 ';
            $orders_discount = $db->Execute($orders_discount_sql);
            if(isset($orders_discount->fields['orders_discount_value']) && $orders_discount->fields['orders_discount_value'] != ''){
                $discount_alt = '&nbsp;&nbsp;<ins title="'.$orders_discount->fields['orders_discount_value'].'" style="display:inline-block;width:18px;height:18px;background:url(./includes/templates/cherry_zen/css/en/images/icon_shopcartbg.png) -82px -78px;position:relative;top:2px;cursor:pointer;"></ins>';
            }
         
            $str .= $title.' <td>' . $order->totals[$i]['text'] .$discount_alt. '
						</td>' . "\n";

        }else if ($order->totals[$i]['class'] == 'ot_handing_fee'){
            $title =' <td valign="top" width="150px;"  align="right">' . $order->totals[$i]['title'].' </td>' . "\n";
                // $str .= $title . ' <td>- ' . substr ( $order->totals [$i] ['text'], 1 ) . '</td>' . "\n";
        }else {
            $title = ' <td align="right">' . $order->totals [$i] ['title'] . '</td>';
            $str .= $title . ' <td> ' . $order->totals [$i] ['text'] . '</td>';
        }
        if($a){
            if($discount+$promotion_discount > 0){
                $title = ' <tr><td align="right">' . TEXT_CART_DISCOUNT . ':</td>';
                $str .= $title . ' <td>- ' . $currencies->format($discount+$promotion_discount, false, $order->info ['currency'], $order->info ['currency_value']) . '</td></tr>';
            }
            $a = false;
        }
       if ($order->totals[$i]['class'] == 'ot_handing_fee'){
            $title =' <td valign="top" width="150px;"  align="right">' . $order->totals[$i]['title'].' </td>' . "\n";
                $str .= $title . ' <td> ' . $order->totals [$i] ['text']. '</td>' . "\n";
           }
    }
    $str .= '</tr>';
}
$smarty->assign ( 'payment_details_str', $str );

if ($orders ['order_status'] == 1){
    $makepayment_str = '<a href="index.php?main_page=account_history_info&order_id=' . $orders ['order_id'] . '&continued_order=payment" class="makepayment_btn">' . TEXT_MAKE_PAYMENT . '</a>';
}
$payment_check_record = $db->Execute ( "select p.currency,p.amount,p.payment_date,p.create_date,p.payment_type from " . TABLE_PAYMENT_RECORDS . " p where orders_id=" . $orders ['order_id'] . " order by payment_records_id desc limit 1" );
if (in_array($payment_check_record->fields['payment_type'], array('westernunion', 'wire', 'wirebc', 'moneygram')) || $orders ['order_status'] == 42){
    $makepayment_str = '<span style="color:#008fed;margin-left:120px;">' . TEXT_PAYMENT_UNDER_CHECKING . '</font>';
}
if ($orders ['order_status'] == 2 || $orders ['order_status'] == 3 || $orders ['order_status'] == 4 || $orders ['order_status'] == 10){
    $makepayment_str = '<a href="invoice.php?oID=' . $orders ['order_id'] . '" class="view_invoice" target="_blank">' . TEXT_VIEW_INVOICE . '</a><font color="#008fed">' . TEXT_HAVE_MADE_PAYMENT . '</font>';
}
$orders ['makepayment_str'] = $makepayment_str;
$order->delivery['telephone_number'] = $order->customer['telephone'];
$orders ['shipping_address'] = zen_address_format_order($order->delivery['format_id'], $order->delivery , 1, '', ' ');

$order_comments = $db->Execute ( "select orders_id,comments from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id = " . ( int ) $orders ['order_id'] . " order by date_added asc limit 1" );
//$order_comments->fields['comments'] = trim(str_replace(array('#D5#','#BD#'),array('',''), $order_comments->fields['comments']));
if (isset ( $order_comments->fields ['comments'] ) && $order_comments->fields ['comments'] != '') {
    $orders ['order_comments'] = htmlentities ( $order_comments->fields ['comments'], ENT_NOQUOTES, "utf-8" );
    $orders['order_comments'] = str_replace("#D5#",TEXT_REORDER_PACKING_WAY_ONE.'<br/>',$orders['order_comments']);
    $orders['order_comments'] = str_replace("#BD#",TEXT_REORDER_PACKING_WAY_TWO.'<br/>',$orders['order_comments']);
    $orders['order_comments'] = str_replace("#D15#",TEXT_REORDER_PACKING_WAY_THREE.'<br/>',$orders['order_comments']);
    $orders['order_comments'] = str_replace("#D#",TEXT_REORDER_PACKING_WAY_FOUR.'<br/>',$orders['order_comments']);
    $orders['order_comments'] = str_replace("#15FA#",TEXT_REORDER_PACKING_WAY_FIVE.'<br/>',$orders['order_comments']);
} else {
    $orders ['order_comments'] = '/';
}

$orders_array = array ();
$orders_products_query = "select orders_products_id, products_id, products_name,
                                 products_model, products_price, products_tax,
                                 products_quantity, final_price,
                                 onetime_charges,
                                 products_priced_by_attribute, product_is_free, products_discount_type,note,
                                 products_discount_type_from
                                  from " . TABLE_ORDERS_PRODUCTS . "
                                  where orders_id = '" . $orders ['order_id'] . "'
                                  order by products_model";
$order_products_review_split = new splitPageResults($orders_products_query, 100);
$order_products_review_split_str = $order_products_review_split->display_links_for_review(100);
$orders_products = $db->Execute($order_products_review_split->sql_query);
$i = 0;
while (!$orders_products->EOF) {
    $image = $db->Execute ( "select products_id, products_image, products_weight, products_price, products_volume_weight, products_discount_type, products_priced_by_attribute, products_stocking_days from " . TABLE_PRODUCTS . " where products_id = " . $orders_products->fields['products_id'] );
    $productsPriceEach = $currencies->display_price ( $orders_products->fields['final_price'], zen_get_tax_rate ( $orders_products->fields['products_tax'] ), 1 );
    $original_price = $image->fields ['products_price'];
    if ($image->fields ['products_priced_by_attribute'] == '1' and zen_has_product_attributes ( $image->fields ['products_id'], 'false' )) {
    } else {
        if ($image->fields ['products_discount_type'] != '0') {
            $original_price = zen_get_products_discount_price_qty ( $image->fields ['products_id'], $orders_products->fields['products_quantity'], 0, false );
        }
    }

    $productsPriceOriginal = $currencies->display_price ( $original_price, zen_get_tax_rate ( $orders_products->fields['products_tax'] ), 1 );
    $productsShowPrice = $productsPriceEach;
    $product_each_price = $currencies->format_cl ( zen_add_tax ( $orders_products->fields['final_price'], zen_get_tax_rate ( $orders_products->fields['products_tax'] ) ), true, $order->info ['currency'], $order->info ['currency_value'] );

    $products_link = zen_href_link ( FILENAME_PRODUCT_INFO, 'products_id=' . $orders_products->fields['products_id'],'SSL');
    $discount_amount = zen_show_discount_amount ( $orders_products->fields['products_id'] );


    $orders_array [$i] = array (
        'products_name' => '<a href="'.HTTP_SERVER.'/index.php?main_page=order_products_snapshot&oID=' . $orders ['order_id'] . '&pID=' . $orders_products->fields['products_id'] . '" target="_blank">' . (stripos($orders_products->fields['products_name'],TEXT_PREORDER)===false ? $orders_products->fields['products_name']. '</a>' : str_replace(TEXT_PREORDER,'',$orders_products->fields['products_name']).'</a>'/* .'</a><div class="clearfix"></div><div style=" margin:10px 0 0 0; color:#999">'.TEXT_AVAILABLE_IN715.'</div>' */),
        'products_id' => $orders_products->fields['products_id'],
        'products_qty' => $orders_products->fields['products_quantity'],
        'products_link' => $products_link,
        'products_qty_text' => $orders_products->fields['products_quantity'] . ' ' . zen_get_words ( 'text_packet', $orders_products->fields['products_quantity'], $_SESSION ['languages_id'] ),
        'products_img' => '<a class="orderimg" href="index.php?main_page=order_products_snapshot&oID=' . $orders ['order_id'] . '&pID=' . $orders_products->fields['products_id'] . '" target="_blank">' . ($discount_amount > 0 ? draw_discount_img($discount_amount, 'div','discountprice')/* '<div class="discountprice">' . $discount_amount . '%<br>off</div>' */ : '') . '<img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/80.gif" data-size="80" data-lazyload="' . HTTPS_IMG_SERVER . 'bmz_cache/' . get_img_size ( $image->fields ['products_image'], 80, 80 ) . '"/></a>',
        'products_model' => $orders_products->fields['products_model'],
        'products_weight' => $image->fields ['products_weight'],
        'note' => $orders_products->fields['note'],
        'is_preorder'=>stripos($orders_products->fields['products_name'],TEXT_PREORDER)===0?1:0,
        'products_volume_weight' => $image->fields ['products_volume_weight'],
        'products_price_orignal' => $currencies->format ( zen_add_tax ( $orders_products->fields['products_price'], $orders_products->fields['products_tax'] ), true, $order->info ['currency'], $order->info ['currency_value'] ),
        'products_price' => $currencies->format ( zen_add_tax ( $orders_products->fields['final_price'], $orders_products->fields['products_tax'] ), true, $order->info ['currency'], $order->info ['currency_value'] ),
        'products_price_total' => $currencies->format ( zen_add_tax ( $product_each_price, $orders_products->fields['products_tax'] ) * $orders_products->fields['products_quantity'], false, $order->info ['currency'], $order->info ['currency_value'] ),
        'is_gift' => 0,
        'products_stocking_days' => $image->fields ['products_stocking_days']
    );
    $i++;
    $orders_products->MoveNext();
}
$smarty->assign ( 'gift_id', $_SESSION['gift_id']);
$smarty->assign ( 'order_products_review_split_str', $order_products_review_split_str );

//bof v1.7 order commonts
$statuses_query = "SELECT os.orders_status_name, osh.date_added, osh.comments
                   FROM " . TABLE_ORDERS_STATUS . " os, " . TABLE_ORDERS_STATUS_HISTORY . " osh
                   WHERE osh.orders_id = :ordersID
                   AND os.language_id = " . $_SESSION['languages_id'] . "
                   AND        osh.orders_status_id = os.orders_status_id
                   ORDER BY   osh.date_added";

$statuses_query = $db->bindVars($statuses_query, ':ordersID', $_GET['order_id'], 'integer');
$statuses = $db->Execute($statuses_query);
while (!$statuses->EOF) {
    if (strstr($statuses->fields['comments'], '<body>')){
        $statuses->fields['comments'] = substr($statuses->fields['comments'], strpos($statuses->fields['comments'], '<body>'));
        $statuses->fields['comments'] = preg_replace('/\r/', ' ', $statuses->fields['comments']);
        $statuses->fields['comments'] = preg_replace('/\n/', ' ', $statuses->fields['comments']);
        $statuses->fields['comments'] = preg_replace('/<\/td>/', '<br>', $statuses->fields['comments']);
        $statuses->fields['comments'] = strip_tags($statuses->fields['comments'],'<br><p><img>');
    }else{
        $statuses->fields['comments'] = nl2br($statuses->fields['comments']);
    }

    $statuses->fields['comments'] = str_replace("#D5#",TEXT_REORDER_PACKING_WAY_ONE.'<br/>',$statuses->fields['comments']);
    $statuses->fields['comments'] = str_replace("#BD#",TEXT_REORDER_PACKING_WAY_TWO.'<br/>',$statuses->fields['comments']);
    $statuses->fields['comments'] = str_replace("#D15#",TEXT_REORDER_PACKING_WAY_THREE.'<br/>',$statuses->fields['comments']);
    $statuses->fields['comments'] = str_replace("#D#",TEXT_REORDER_PACKING_WAY_FOUR.'<br/>',$statuses->fields['comments']);
    $statuses->fields['comments'] = str_replace("#15FA#",TEXT_REORDER_PACKING_WAY_FIVE.'<br/>',$statuses->fields['comments']);

    $statusArray[] = array('date_added'=>date('M d, Y', strtotime($statuses->fields['date_added'])),
        'orders_status_name'=>$statuses->fields['orders_status_name'],
        'comments'=>(empty($statuses->fields['comments']) ? '&nbsp;' : nl2br($statuses->fields['comments'])));

    $statuses->MoveNext();
}
//eof

$order_totals_arr = array ();
$order_total_show = array ();
if (isset ( $orders ['order_id'] )) {
    $order_total_show = $order;
}
for($i = 0, $n = sizeof ( $order_total_show->totals ); $i < $n; $i ++) {
    $order_totals_arr [$order_total_show->totals [$i] ['class']] = $order_total_show->totals [$i];
}

if ($make_payment) {
    require (DIR_WS_CLASSES . 'payment.php');
    $payment_modules = new payment ();
    global $GLOBALS;
    $payment_selection = array ();
    $confirmation = array ();
    if (! isset ( $GLOBALS ['paypalwpp'] )) {
        for($i = 0, $n = sizeof ( $payment_modules->modules ); $i < $n; $i ++) {
            include (zen_get_file_directory ( DIR_WS_LANGUAGES . $_SESSION ['language'] . '/modules/payment/', $payment_modules->modules [$i], 'false' ));

            include_once (DIR_WS_MODULES . 'payment/' . $payment_modules->modules [$i]);

            $payment_modules->modules [$i] = str_replace ( '.php', '', $payment_modules->modules [$i] );

            $GLOBALS [$payment_modules->modules [$i]] = new $payment_modules->modules [$i] ();

            $confirmation [$payment_modules->modules [$i]] = $GLOBALS [$payment_modules->modules [$i]]->confirmation ();
            if($GLOBALS [$payment_modules->modules [$i]]->enabled){
                $payment_selection [] = $GLOBALS [$payment_modules->modules [$i]]->selection ();
            }

        }
    } else {
        $payment_selection = $payment_modules->selection ();
        $confirmation ['westernunion'] = $GLOBALS ['westernunion']->confirmation ();
        if($order_totals_arr['ot_subtotal']['value'] < 30.1){
            foreach($payment_selection as $payment_selection_k=>$payment_selection_v){
                if($payment_selection_v['id'] == 'wirebc' || $payment_selection_v['id'] == 'wire')
                    unset($payment_selection[$payment_selection_k]);
            }
            sort($payment_selection);
        }else{
            $confirmation['wirebc'] = $GLOBALS['wirebc']->confirmation();
            $confirmation['wire'] = $GLOBALS['wire']->confirmation();
        }
        $confirmation['moneygram'] = $GLOBALS['moneygram']->confirmation();
    }

    $smarty->assign ( 'payment_selection', $payment_selection );
}

$message['payment_order_total'] = $currencies->format($order_totals_arr['ot_total']['value'], true, $order->info['currency'], $order->info['currency_value']);
$message['payment_order_subtotal'] = $currencies->format($order_totals_arr['ot_subtotal']['value'], true, $order->info['currency'], $order->info['currency_value']);

reset ( $currencies->currencies );
$currencies_array = array ();
$default_currency = $currencies->currencies['USD']['symbol_left'];
while ( list ( $key, $value ) = each ( $currencies->currencies ) ) {
    $currencies_array [] = array (
        'id' => $key,
        'symbol_left' => $value ['symbol_left']
    );
    if ($key == $order->info ['currency']){
        $default_currency = $value ['symbol_left'];
    }
}
//print_r($currencies_array);
if ($order_totals_arr ['ot_cash_account'] ['value'] > 0) {
    $order_totals_arr ['ot_cash_account'] ['text'] = str_replace ( '-', '', $order_totals_arr ['ot_cash_account'] ['text'] );
}
if ($order_totals_arr ['ot_cash_account'] ['value'] < 0) {
    $order_totals_arr ['ot_cash_account'] ['text'] = '- ' . $order_totals_arr ['ot_cash_account'] ['text'];
}

$show_gc_payment = true;
$message["show_gc_payment"] = $show_gc_payment;

$message ['default_currency'] = $default_currency;
$message ['header_title'] = ($make_payment ? HEADING_TITLE1 : HEADING_TITLE);
$message ['make_payment'] = $make_payment;
$message ['order_total_no_currency_left'] = $order_totals_arr['ot_total']['value'];
$message ['order_total_wire_min'] = ORDER_TOTAL_WIRE_MIN;
$message ['currency_symbol_left'] = $currencies->currencies [$order_total_show->info ['currency']] ['symbol_left'];
$message ["text_grand_total"] = TEXT_GRAND_TOTAL;
$message ['payment_credit_account_blance'] = TEXT_CREDIT_ACCOUNT_BLANCE;
$message ['account_total'] = $currencies->format ( $order->totals [0] ['value'], true, $order->info ['currency'], $order->info ['currency_value'] );
$message ['account_continued_order'] = $db->prepare_input ( $_GET ['continued_order'] );
$message ['payment_credit_card'] = TEXT_CREDIT_CARD_VISA_PAYPAL;
$message ['http_download_img'] = HTTPS_IMG_SERVER;
$message ['payment_coupon'] = TEXT_COUPON;
$message ['account_pay_now'] = TEXT_PAY_NOW;
$message['account_payment_prompt'] = TEXT_PAYMENT_PROMPT;

$message['heading_order_history'] = HEADING_ORDER_HISTORY;
$message['heading_status_date'] = TABLE_HEADING_STATUS_DATE;
$message['heading_status_order_status'] = TABLE_HEADING_STATUS_ORDER_STATUS;
$message['heading_status_comments'] = TABLE_HEADING_STATUS_COMMENTS;

$filter ['filter_languages_code'] = $_SESSION ['languages_code'];
$order->info ['payment_method'] = str_replace ( '<div style="clear:both; padding-bottom:10px;"><span style="colo', '', $order->info ['payment_method'] );

if ($order->info ['currency'] == 'JPY') {
    $smarty->assign ( 'price', floor ( round ( $order->info ['total'] * $order->info ['currency_value'], 2 ) ) );
} else {
    $smarty->assign ( 'price', round ( $order->info ['total'] * $order->info ['currency_value'], 2 ) );
}
$sqlOrderInfo = "SELECT c.countries_iso_code_2,o.delivery_name,o.delivery_street_address,o.delivery_state,o.delivery_postcode FROM ".
    TABLE_ORDERS ." o JOIN ".TABLE_COUNTRIES." c ON o.delivery_country = c.countries_name WHERE orders_id = ".$_GET['order_id'];
$shippingAddressInfo = $db->Execute($sqlOrderInfo);
while (!$shippingAddressInfo->EOF) {
    $nameFull = explode(" ",$shippingAddressInfo->fields['delivery_name']);
    $order->customer['shippingFirstName'] = $nameFull[1];
    $order->customer['shippingLastName'] = $nameFull[0];
    $order->customer['shippingStreet'] = $shippingAddressInfo->fields['delivery_street_address'];
    $order->customer['shippingState'] = $shippingAddressInfo->fields['delivery_state'];
    $order->customer['shippinCountryCode'] = $shippingAddressInfo->fields['countries_iso_code_2'];
    $order->customer['shippinZip'] = $shippingAddressInfo->fields['delivery_postcode'];
    $shippingAddressInfo->MoveNext();
}

$codeInfo = $db->Execute("SELECT c.customers_firstname, c.customers_lastname, ct.countries_iso_code_2, l.code FROM ".TABLE_CUSTOMERS ." c JOIN ".TABLE_COUNTRIES." ct ON c.customers_country_id = ct.countries_id JOIN ".TABLE_LANGUAGES." l ON c.register_languages_id = l.languages_id WHERE c.customers_email_address = '".$order->customer['email_address']."' LIMIT 1");
$order->customer['lanuageCode'] = 'en';
while (!$codeInfo->EOF) {
    $order->customer['lanuageCode'] = $codeInfo->fields['code'];
    //$order->customer['countryCode'] = $codeInfo->fields['countries_iso_code_2'];
    $order->customer['firstName'] = $codeInfo->fields['customers_firstname'];
    $order->customer['lastName'] = $codeInfo->fields['customers_lastname'];
    $codeInfo->MoveNext();
}
$order->customer['countryCode'] = $order->customer['shippinCountryCode'];

require(DIR_WS_CLASSES . 'shipping.php');
$shipping_modules = new shipping($order->info['shipping_module_code']);
$time_unit = TEXT_DAYS_LAN;
if ($shipping_modules->shipping_method[$order->info['shipping_module_code']]['time_unit'] == 20) {
    $time_unit = TEXT_WORKDAYS;
}
//$message['shipping_days'] = $shipping_modules->shipping_method[$order->info['shipping_module_code']]['days'].'&nbsp;'.$time_unit;
$shipping_days_array = $shipping_modules->get_shipping_day($order->info['shipping_module_code'], $shippingAddressInfo->fields['countries_iso_code_2'], $order->delivery['postcode']);
$message['shipping_days'] = implode('-', $shipping_days_array) . $time_unit;

$smarty->assign ( 'order', $order );
$smarty->assign ( 'currencies_array', $currencies_array );
$smarty->assign ( 'confirmation', $confirmation );
$smarty->assign ( 'order_totals_arr', $order_totals_arr );
$smarty->assign ( 'order_total', $order_total );
$smarty->assign ( 'filter', $filter );
$smarty->assign ( 'message', $message );
$smarty->assign ( 'orders', $orders );
$smarty->assign ( 'order', $order );
$smarty->assign ( 'orders_array', $orders_array );
$smarty->assign ( 'total_products', sizeof($order->products) );
$smarty->assign ( 'statusArray', $statusArray );
$smarty->assign ( 'count_order', sizeof ( $order->products ) );
$smarty->assign ( 'coupon_select', $coupon_select );

$smarty->assign('countryCode', $order->customer['countryCode']);
$smarty->assign('lanuageCode', $order->customer['lanuageCode']);
$smarty->assign('currencyCode', $order->info['currency']);
$smarty->assign('orderId', date("yW"));
$smarty->assign('paymentOrderId', $_GET['order_id']);
$smarty->assign('lastName', $order->customer['lastName']);
$smarty->assign('firstName', substr($order->customer['firstName'],0,15));
$smarty->assign('shippingFirstName', substr($order->customer['shippingFirstName'],0,15));
$smarty->assign('shippingLastName', $order->customer['shippingLastName']);
$smarty->assign('shippingStreet', substr($order->customer['shippingStreet'],0,50));
$smarty->assign('shippinCountryCode', $order->customer['shippinCountryCode']);
$smarty->assign('shippingState', $order->delivery['state']);
$smarty->assign('shippinZip', $order->customer['shippinZip']);
$smarty->assign('merchantRef', $_GET['order_id']);
$smarty->assign('shippingCity', $order->delivery['city']);
$smarty->assign('phoneNumber', $order->customer['telephone']);
$smarty->assign('email', $order->customer['email_address']);
$smarty->assign('city', $order->customer['city']);
$smarty->assign('state', $order->customer['state']);
$smarty->assign('street', substr($order->customer['street_address'],0,50));

$text_countries_list = zen_get_country_select('zone_country_id', 223, $_SESSION['languages_id'], 'id="country"');
$smarty->assign ( 'text_countries_list', $text_countries_list );
$smarty->assign ( 'paypal_payment_message', $paypal_payment_message );
$smarty->assign ( 'type', 'hp' );

$smarty->caching = 0;

$zco_notifier->notify ( 'NOTIFY_HEADER_END_ACCOUNT_HISTORY_INFO' );
?>
