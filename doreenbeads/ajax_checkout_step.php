<?php
$returnArray = array();
$action = $_POST['action'];

if ($action != '') {
    switch ($action) {
        case 'address_info':
            $customer_num_val = $_POST['customer_num_val'];
            $returnArray['error'] = ($customer_num_val == 'n0' || $customer_num_val == 'n') ? true : false;

            if ($returnArray['error']) {
                $returnArray['info'] = '';
                $returnArray['link'] = "index.php?main_page=login";
            } else {
                require('includes/application_top.php');
                require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/checkout.php');

                $returnArray['link'] = '';
                $customer_id = substr($_POST['customer_num_val'], 1);

                $address_listing = $db->Execute("select address_book_id, entry_firstname , entry_lastname ,entry_company, entry_gender , entry_street_address ,  entry_suburb , entry_city , entry_postcode ,
										entry_state , entry_zone_id , entry_country_id ,entry_telephone , tariff_number , backup_email_address
								from	" . TABLE_ADDRESS_BOOK . "
								where customers_id = " . (int)$customer_id . " order by address_book_id");
                $address_num = $address_listing->RecordCount();
                $customers_address_query = $db->Execute("select  customers_default_address_id  from " . TABLE_CUSTOMERS . " where customers_id='" . (int)$customer_id . "'");
                $customers_default_address_id = intval($customers_address_query->fields['customers_default_address_id']);

                if ($address_num > 0) {
                    $add_input_info = '<form class="addresschioce"><table><tbody>';
                    $count_num = 0;
                    while (!$address_listing->EOF) {
                        if (!$customers_default_address_id && $count_num == 0 && (!isset($_POST['customer_sto']) || $_POST['customer_sto'] == 0)) {
                            $customers_default_address_id = $address_listing->fields['address_book_id'];
                            $_POST['customer_sto'] = $address_listing->fields['address_book_id'];
                            $_SESSION['sendto'] = $address_listing->fields['address_book_id'];
                        }
                        $count_num++;
                        if (!zen_not_null($address_listing->fields['entry_telephone'])) {
                            $phone_note = '<div style="display:inline-block;position:relative;"><ins class="question_icon"></ins><div style="display: none;left:-145px;" class="pricetips"><span class="bot"></span><span class="top"></span>' . TEXT_ADD_ADDRESS_PHONE . '</div></div>';
                        } else {
                            $phone_note = '';
                        }
                        if ($address_listing->fields['address_book_id'] == $_POST['customer_sto']) {
                            if ($address_listing->fields['address_book_id'] == $customers_default_address_id) $text_delete = '&nbsp;';
                            else $text_delete = '<span class="spanD" style="display:none">' . TEXT_DELETE . '</span>';
                            $add_input_info .= '<tr class="selected"><td class="selectThisTd"><input type="radio" name="address" id="address_' . $address_listing->fields['address_book_id'] . '" checked="checked" aId="' . $address_listing->fields['address_book_id'] . '"></td><td class="selectThisTd"><label style="position:relative;" for="address_' . $address_listing->fields['address_book_id'] . '"><strong>' . zen_address_format_new($address_listing->fields) . '</strong>' . $phone_note . '</label></td><td><span class="edit addaddress" edit="1">' . TEXT_EDIT . '</span>' . $text_delete . '</td></tr>';
                        } else {
                            if ($address_listing->fields['address_book_id'] == $customers_default_address_id) $text_delete = '&nbsp;';
                            else $text_delete = '<span class="spanD">' . TEXT_DELETE . '</span>';
                            $add_input_info .= '<tr><td class="selectThisTd"><input type="radio" name="address" id="address_' . $address_listing->fields['address_book_id'] . '" aId="' . $address_listing->fields['address_book_id'] . '"></td><td class="selectThisTd"><label style="position:relative;" for="address_' . $address_listing->fields['address_book_id'] . '"><strong>' . zen_address_format_new($address_listing->fields) . '</strong>' . $phone_note . '</label></td><td><span class="edit addaddress" edit="1" style="display:none">' . TEXT_EDIT . '</span>' . $text_delete . '</td></tr>';
                        }
                        $address_listing->MoveNext();
                    }
                    $add_input_info .= '</tbody></table>';
                    if ($address_listing->RecordCount() < MAX_ADDRESS_BOOK_ENTRIES) {
                        $add_input_info .= '<p><a href="javascript:void(0);" class="greybtn addaddress"><span>' . TEXT_ENTER_A_ADDRESS . '</span></a></p>';
                    }
                    $add_input_info .= '</form>';
                    $returnArray['info'] = $add_input_info;
                    $returnArray['show'] = 'list';
                } else {
                    $returnArray['info'] = '';
                    $returnArray['show'] = 'add';
                }
            }
            echo json_encode($returnArray);
            break;

        case 'shipping_method':
            require('includes/application_top.php');
            require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/checkout.php');
            $startime = microtime(true);
            $startdate = date("Y-m-d H:i:s");

            $write_shopping_log = false;
            if (isset($_SESSION['count_cart']) && $_SESSION['count_cart'] >= 50) {
                $write_shopping_log = true;
                $identity_info = $_COOKIE['cookie_cart_id'];
                if (!empty($_SESSION['customer_id'])) {
                    $identity_info = $_SESSION['customer_id'];
                }
                if (empty($identity_info)) {
                    $identity_info = json_encode($_COOKIE) . "separator" . json_encode($_SESSION);
                }
                write_file("log/shopping_cart_log/", "shipping_method_" . date("Ymd") . ".txt", $identity_info . "\t" . $_SESSION['count_cart'] . "\t" . $startdate . "\r\n");
            }
            if (!isset($_SESSION['sendto'])) {
                $_SESSION['sendto'] = $_SESSION['customer_default_address_id'];
            }

            if (isset($_SESSION['sendto']) && $_SESSION['sendto'] != 0) {
                $_SESSION['cartID'] = $_SESSION['cart']->cartID;
                $total_weight = $_SESSION['cart']->show_weight();
                $total_weight_all = ($total_weight > 50000 ? $total_weight * 1.06 : $total_weight * 1.1);
                $volume_shipping_weight = $_SESSION['cart']->show_volume_weight();

                require(DIR_WS_CLASSES . 'order.php');
                require(DIR_WS_CLASSES . 'shipping.php');
                $order = new order;


                //$shipping_modules = new shipping;
                //$shipping_result = $shipping_modules->reduce_result;
                //$special_discount = $shipping_modules->special_result;
                //$shipping_method_limit = $shipping_modules->shipping_method_limit;
                //$shipping_method_limit_description = $shipping_modules->shipping_method_limit_description;

                $countries_iso_code_2 = get_default_country_code(array('customers_id' => $_SESSION['customer_id'], 'address_book_id' => $_SESSION['sendto']));

                $shipping_modules = new shipping ('', $countries_iso_code_2, '', $post_postcode, $post_city);

                $shipping_data = $shipping_modules->get_default_shipping_info(array('customers_id' => $_SESSION['customer_id'], 'countries_iso_code_2' => $countries_iso_code_2, 'address_book_id' => $_SESSION['sendto']));
                $shipping_list = $shipping_data['shipping_list'];
                $shipping_info = $shipping_data['shipping_info'];
                $special_discount = $shipping_data['special_discount'];

                $product_model_list = $_SESSION['cart']->get_product_model_list();
                $products_watch = $db->Execute("select pw_model from " . TABLE_PRODUCTS_WATCH . " where pw_model in(" . $product_model_list . ")");
                $show_watch_note = $products_watch->RecordCount() == 0 ? false : true;

                if (zen_not_null($_SESSION['sendto']) && $_SESSION['sendto']) {

                    $country_id_array = array('BE', 'FR', 'DE', 'IE', 'LU', 'NL', 'GB');
                    $show_tax_note = false;
                    if (in_array($countries_iso_code_2, $country_id_array)) {
                        $show_tax_note = true;
                    }

                    if (!empty($_SESSION['shipping']['shipping_volume_weight'])) {
                        $show_volume_weight = '<tr><td>' . $_SESSION['shipping']['shipping_volume_weight_title'] . '</td><td>' . $_SESSION['shipping']['shipping_volume_weight'] . ' ' . TEXT_SHIPPING_WEIGHT . '</td></tr>';
                    }

                    $input_info_arr['info'] .= '<table class="shipway"><tbody>
						<tr class="isTopTr"><th width="220">' . TEXT_SHIPPING_METHOD . '</th><th width="215"><p>' . TEXT_ESTINATE_TIME . '</p><a href="javascript:void(0);" class="rise dasc"></a><a href="javascript:void(0);" class="down ddes"></a></th><th width="174"><p>' . TEXT_SHIPPING_COST . '</p><a href="javascript:void(0);" class="rise casc"></a><a href="javascript:void(0);" class="down cdes"></a></th>' . (sizeof($special_discount) > 0 ? '<th width="105">' . TEXT_SPECIAL_DISCOUNT . '</th>' : '') . '<th>' . TEXT_SHIPING_NOTE . '</th></tr>';

                    $has_no_display_method = true;
                    foreach ($shipping_list as $method => $quotes) {
                        if ($quotes['error']) continue;

                        $sChecked = $sClass = '';
                        if ($method == $_SESSION['shipping']['code'] && !isset($shipping_method_limit[$quotes['code']])) {
                            $sChecked = 'checked="checked"';
                            $sClass = 'class="selected"';
                        } else {
                            if ($quotes['is_display']) {
                                $sClass = 'class=is_show';
                            } else {
                                $has_no_display_method = false;
                                $sClass = 'class=not_show';
                            }
                        }

                        $extra_style = '';
                        $str_note = $str_detail = '';
                        $note_class = 'open';
                        switch ($method) {
                            case 'chinapost':
                            case 'etk':
                                $str_note = NOTE_EMS;
                                $str_detail = NOTE_EMS_CONTENT;
                                break;
// 							case 'kdfedex':
// 							case 'zyfedex':
// 								if ($show_tax_note) {
// 									$str_note = TEXT_NOTE_ABOUT_TAX;
// 									$str_detail = TEXT_NOTE_ABOUT_TAX_CONTENT;
// 								}
// 								if ($show_watch_note) {
// 									$str_note = ($str_note != '' ? $str_note . '</ins><span class="open"></span><br><ins>' : '') . NOTE_FEDEX;
// 									$str_detail = ($str_detail != '' ? $str_detail . '</p><p>' : '') . NOTE_FEDEX_CONTENT;
// 								}
// 								break;
                            case 'ywfedex':
                            case 'ywlbip':
                                if ($show_tax_note) {
                                    $str_note = TEXT_NOTE_ABOUT_TAX;
                                    $str_detail = TEXT_NOTE_ABOUT_TAX_CONTENT;
                                }
                                if ($show_watch_note) {
                                    $str_note = ($str_note != '' ? $str_note . '</ins><span class="open"></span><br><ins>' : '') . NOTE_FEDEX;
                                    $str_detail = ($str_detail != '' ? $str_detail . '</p><p>' : '') . NOTE_FEDEX_CONTENT;
                                }
                                //$str_note = ($str_note != '' ? $str_note . '</ins><span class="open"></span><br><ins>' : '') . sprintf(NOTE_DECLEAR, 600);
                                //$str_detail = ($str_detail != '' ? $str_detail . '</p><p>' : '') . sprintf(NOTE_DECLEAR_CONTENT, 'FEDEX', 600, 600);
                                if ($select_country_id_return->fields['entry_country_id'] == 107) {
                                    $str_note .= TEXT_NOTE_USE_ENGLISH . $str_note;
                                    $str_detail .= TEXT_NOTE_USE_ENGLISH_DESCRIPTION;
                                }
                                break;
                            case 'ywdhl':
                            case 'ywdhl-dh':
                                if ($show_watch_note) {
                                    $str_note = TEXT_NOTE_ABOUT_WATCH;
                                    $str_detail = TEXT_NOTE_ABOUT_WATCH_CONTENT;
                                }
                                break;
// 							case 'ukeurline':
                            case 'hmdpd':
                            case 'cnezx':
                            case 'hmjz':
                                $str_note = NOTE_TARIFF;
                                $str_detail = NOTE_TARIFF_CONTENT;
                                break;
                            case 'usexpr':
                                $str_note = NOTE_TARIFF;
                                $str_detail = NOTE_TARIFF_CONTENT_US;
                                break;
                            case 'sfhyzxb':
                                if ($_SESSION['languages_id'] == 1 || $_SESSION['languages_id'] == 3) {
                                    $str_note = TEXT_HOW_DOES_IT_WORKS;
                                }
                                $str_detail = TEXT_DETAILS_SFHYZXB;
                                break;
                            case 'sfhky':
                                if ($_SESSION['languages_id'] == 1 || $_SESSION['languages_id'] == 3) {
                                    $str_note = TEXT_HOW_DOES_IT_WORKS;
                                }
                                $str_detail = TEXT_DETAILS_SFHKY;
                                break;
                            case 'ynkqy':
                                if ($_SESSION['languages_id'] == 1 || $_SESSION['languages_id'] == 3) {
                                    $str_note = TEXT_HOW_DOES_IT_WORKS_1;
                                }
                                $str_detail = TEXT_DETAILS_YNKQY;
                                break;
                            case 'trstma':
                                if ($_SESSION['languages_id'] == 1 || $_SESSION['languages_id'] == 3) {
                                    $str_note = TEXT_HOW_DOES_IT_WORKS_1;
                                }
                                $str_detail = TEXT_DETAILS_TRSTMA;
                                break;
                            case 'trstm':
                                if ($_SESSION['languages_id'] == 1 || $_SESSION['languages_id'] == 3) {
                                    $str_note = TEXT_READ_NOTE;
                                    $str_detail = TEXT_TRSTM;;
                                }
                                break;
                            case 'agent':
                                $str_note = TEXT_READ_NOTE;
                                $str_detail = TEXT_SPTYA;
                                $extra_style = ' style="display:block" ';
                                $note_class = 'close';
                                break;
// 							case 'eyoubao':
// 								$str_note = TEXT_READ_NOTE;
// 								$str_detail = TEXT_EYOUBAO;
// 								break;
                            case 'xxeub':
                                $str_note = NOTE_USPS;
                                $str_detail = NOTE_USPS_CONTENT;
                                break;
                            case 'ubi':
                                $str_note = TEXT_UBI_NOTE;
                                $str_detail = TEXT_UBI_NOTE_CONTENT;
                                break;
                            default:
                                $str_note = $str_detail = '';
                        }

                        $str_note = ($str_note != '' ? '<ins>' . $str_note . '</ins><span class="' . $note_class . '"></span>' : '');
                        $str_detail = ($str_detail != '' ? '<p>' . $str_detail . '</p>' : '');


                        if ($str_detail != '') $str_detail = '<div class="notecontent"' . $extra_style . '><dl><dd>' . $str_detail . '</dd><dt><ins></ins></dt></dl></div>';

                        if ($method == "hmauexpr") {
                            $sql_country_id = $db->Execute("select entry_street_address as street from " . TABLE_ADDRESS_BOOK . " where address_book_id = " . $_SESSION['sendto']);
                            $street = $sql_country_id->fields['street'];
                            if (strstr(strtolower($street), strtolower('PO box')))
                                $str_note .= '<span style="color:red;">' . TEXT_SHIPPING_METHOD_HMAUEXPR_NOTE . '</span>';
                        }
                        if ($quotes['box'] > 1 && $method != 'airmail')
                            $str_note .= '<p>(' . sprintf(TEXT_SHIPPED_OUT_BOXES, $quotes['box']) . ')</p>';
                        if ((in_array($countries_iso_code_2, array('AU'))) && strpos($method, 'dhl'))
                            $str_note .= '<p><a href="' . HTTP_SERVER . '/page.html?id=147 " target="_blank">' . TEXT_WOOD_PRODUCT_NOTE . '</a></p>';
                        if ($order->delivery['country']['iso_code_2'] == 'GR' && (strpos($method, 'dhl') !== false || strpos($method, 'ups') !== false || strpos($method, 'fedex') !== false || $method == 'ywlbip'))
                            $str_note .= '<a href="' . HTTP_SERVER . '/page.html?id=215' . '" target="_blank">' . TEXT_BE_SURE_READ . '</a>';
                        if ($quotes ['box_note'] != '') $str_note .= '<p>' . $quotes ['box_note'] . '</p>';
                        if ($quotes['remote_note'] <> '') $str_note .= '<p style="color:black">' . $quotes['remote_note'] . '</p>';
                        if ($quotes['volume_note'] <> '') $str_note .= '<p>' . $quotes['volume_note'] . '</p>';

                        //	CN
                        if ($order->delivery['country']['iso_code_2'] == 'CN') {
                            $sptca_ask = '<a title="' . TEXT_CHARGE_BASED_ON . '"><font size="1" color="#c89469">[?]</font></a>';
                            $sptca_tr = '';
                        } else
                            $sptca_ask = $sptca_tr = '';


                        $shipping_method_limit_td = '';
                        $time_unit = TEXT_DAYS_LAN;
                        if ($quotes['time_unit'] == 20) {
                            $time_unit = TEXT_WORKDAYS;
                        }

                        $hot_logo = '';
                        if ($quotes['is_virtual']) {
                            $hot_logo = '<span style="display:inline-block; position:relative">
                                            <span style="position:absolute; display:inline-block; top:-11px;">
                                                <img src="/includes/templates/cherry_zen/css/' . $_SESSION['languages_code'] . '/images/db-hot.png" border="0">
                                            </span>
                                        </span>';
                        }

                        // 限制运输方式的排序要在最下层
                        if (isset($shipping_method_limit) && !empty($shipping_method_limit[$quotes['code']])) {
                            $shipping_method_limit_td = '<div class="pop_wrap">
										<div class="pop_note_tip">
											<i class="top"></i><em class="top"></em>
											' . $shipping_method_limit_description[$shipping_method_limit[$quotes['code']]['limit_result']][$_SESSION['languages_id']] . '</div> 
							</div>';
                            $limit_method_info_arr['info'] .= '<tr class=shipping_method_limit_class_tr >';
                            $limit_method_info_arr['info'] .= '<td class="selectThisTd">' . $shipping_method_limit_td . '<input disabled="disabled" class="shipping_method_limit" type="radio"  name="shipping" value="' . $method . '_' . $method . '" iday="' . ($quotes['day_low'] * 10 + $quotes['day_high']) . '" icost="' . round($quotes['final_cost'], 2) . '" />' . strip_tags($quotes['title']) . '</td> <td class="selectThisTd"><strong>' . $quotes['days'] . '&nbsp;' . $time_unit . '</strong></td> <td class="selectThisTd"><strong>' . (($quotes['final_cost'] <= 0 && $quotes['code'] != 'agent') ? TEXT_FREE_SHIPPING : $currencies->format($quotes['final_cost'])) . '</strong>' . $sptca_ask . '</td> ' . (sizeof($special_discount) > 0 ? '<td class="selectThisTd">' . (isset($special_discount[$method]) && $special_discount[$method] > 0 ? '-' . $currencies->format($special_discount[$method]) : '') . '</td>' : '') . '<td style="text-align:left;"><div class="shipway_note_div" ' . ($method == $_SESSION['shipping']['code'] || $me ? '' : 'style="display:none"') . '>' . $str_note . $str_detail . '</div></td>';
                            $limit_method_info_arr['info'] .= '</tr>';
                        } else {
                            $input_info_arr['info'] .= '<tr ' . $sClass . '>';
                            $input_info_arr['info'] .= '<td class="selectThisTd"><input type="radio" ' . $sChecked . ' name="shipping" value="' . $method . '_' . $method . '" iday="' . ($quotes['day_low'] * 10 + $quotes['day_high']) . '" icost="' . round($quotes['final_cost'], 2) . '" />' . $quotes['title'] . $hot_logo . '</td> <td class="selectThisTd"><strong>' . $quotes['days'] . '&nbsp;' . $time_unit . '</strong></td> <td class="selectThisTd"><strong>' . (($quotes['final_cost'] <= 0 && $quotes['code'] != 'agent') ? TEXT_FREE_SHIPPING : $currencies->format($quotes['final_cost'])) . '</strong>' . $sptca_ask . '</td> ' . (sizeof($special_discount) > 0 ? '<td class="selectThisTd">' . (isset($special_discount[$method]) && $special_discount[$method] > 0 ? '-' . $currencies->format($special_discount[$method]) : '') . '</td>' : '') . '<td style="text-align:left;"><div class="shipway_note_div" ' . ($method == $_SESSION['shipping']['code'] || $me ? '' : 'style="display:none"') . '>' . $str_note . $str_detail . '</div></td>';
                            $input_info_arr['info'] .= '</tr>';
                        }
                    }
                    $input_info_arr['info'] .= $limit_method_info_arr['info'];
                    $input_info_arr['info'] .= '</tbody></table>';
                    if (!$has_no_display_method) {
                        $input_info_arr['info'] .= '<div class="shipping_method_display_tips">' . TEXT_SHIPPING_METHOD_DISPLAY_TIPS . '</div>';
                    }
                }

                $shipping_info_summary .=
                    '<div style="margin:10px 20px;">
  			 			<div><span>' . TEXT_SHIPPING_WEIGHT_LIST . ' </span><span class="shipping_weight_total">' . $shipping_info['shipping_weight'] . ' g </span><span class="view_weight_detail"> ( ' . TEXT_VIEW_DETAILS . ' )
	  			 			<div class="successtips_weight">
  			 					<span class="bot"></span>
								<span class="top"></span>' . TEXT_SHIPPING_COST_IS_CAL_BY . '
	  			 				<table class="table_shipping_weight" border="0" cellpadding="0" cellspacing="0" width="100%">
									<tr>
								    	<td style="border-right:#d0d1a9 1px solid;" width="50%">' . TEXT_PRODUCT_WEIGHT . '</td>
								        <td>' . $total_weight . ' ' . TEXT_GRAMS . '</td>
								    </tr>'
                    . $show_volume_weight .
                    '<tr>
								    	<td style="border-right:#d0d1a9 1px solid;">' . TEXT_WORD_PACKAGE_BOX_WEIGHT . '</td>
								        <td class="show_package_box_weight_td">' . $shipping_info['shipping_package_box_weight'] . ' ' . TEXT_GRAMS . '</td>
								    </tr>
								    <tr>
								    	<td style="border-right:#d0d1a9 1px solid;">' . TEXT_WORD_SHIPPING_WEIGHT . '</td>
								        <td class="shipping_total_weight_td">' . $shipping_info['shipping_weight'] . ' ' . TEXT_GRAMS . '</td>
								    </tr>
								</table>
	  			 			</div>
  			 			</span></div>
					</div>';
                $input_info_arr['info'] = $shipping_info_summary . $input_info_arr['info'];

                if ($_POST['extra_info'] == 1) {
                    $order->cart();
                    require(DIR_WS_CLASSES . 'order_total.php');
                    $order_total_modules = new order_total;
                    $order_total_array = $order_total_modules->process();
                    if ($_SESSION['cc_id']) $order_total_str = zen_get_order_total_str($order_total_array, 1);
                    else $order_total_str = zen_get_order_total_str($order_total_array);
                    $input_info_arr['extra_total'] = $order_total_str;
                }
            } else {
                $input_info_arr['info'] = '';
            }
            echo json_encode($input_info_arr);
            if ($write_shopping_log) {
                write_file("log/shopping_cart_log/", "shipping_method_" . date("Ymd") . ".txt", $identity_info . "\t" . $_SESSION['count_cart'] . "\t" . $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n");
            }
            break;

        case 'invoice_comment':
            require('includes/application_top.php');
            require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/checkout.php');
            $startime = microtime(true);
            $startdate = date("Y-m-d H:i:s");
            $write_shopping_log = false;
            $return_array = array('error' => 0, 'message' => "");
            if (isset($_SESSION['count_cart']) && $_SESSION['count_cart'] >= 50) {
                $write_shopping_log = true;
                $identity_info = $_COOKIE['cookie_cart_id'];
                if (!empty($_SESSION['customer_id'])) {
                    $identity_info = $_SESSION['customer_id'];
                }
                if (empty($identity_info)) {
                    $identity_info = json_encode($_COOKIE) . "separator" . json_encode($_SESSION);
                }
                write_file("log/shopping_cart_log/", "invoice_comment_" . date("Ymd") . ".txt", $identity_info . "\t" . $_SESSION['count_cart'] . "\t" . $startdate . "\r\n");
            }
            $return_array['body'] = '<div class="invoiceform" style="margin-bottom: 55px;">
				<p>' . TABLE_BODY_COMMENTS . '</p><br/>
				<div><ins>' . TEXT_ORDER_COMMENTS . '</ins><textarea name="orderComments" id="areacomment" style="display:inline-block;"></textarea><p class="colorgrey">(<span class="len">1000</span> ' . TEXT_CHARACTERS_LEFT . ')</p><p>';


            $select_country_id_query = "select entry_country_id, countries_iso_code_2 from " . TABLE_ADDRESS_BOOK . ", " . TABLE_COUNTRIES . " where address_book_id = :addressBookID and entry_country_id = countries_id";
            $select_country_id_query = $db->bindVars($select_country_id_query, ':addressBookID', $_SESSION['sendto'], 'integer');
            $select_country_id_return = $db->Execute($select_country_id_query);

            if ($select_country_id_return->RecordCount() == 1) {
                $select_country_id = $select_country_id_return->fields['entry_country_id'];
                $select_country_code = $select_country_id_return->fields['countries_iso_code_2'];
            }

            $tariff_number_query = "select tariff_number from " . TABLE_ADDRESS_BOOK . ' where address_book_id = :addressBookID ';
            $tariff_number_query = $db->bindVars($tariff_number_query, ':addressBookID', $_SESSION['sendto'], 'integer');
            $tariff_number_result = $db->Execute($tariff_number_query);

            if ($tariff_number_result->RecordCount() > 0) {
                $tariff_value = $tariff_number_result->fields['tariff_number'];
            }
            if ($_SESSION['languages_id'] == 1) {
                if ($select_country_code == 'BR' || $select_country_code == 'CL') {
                    if ($_SESSION['shipping']['code'] == 'airmail' || $_SESSION['shipping']['code'] == 'airmaillp') {
                        if ($tariff_number_result->RecordCount() > 0) {
                            $return_array['body'] .= str_replace('name="tariff"', ' name="tariff" value="' . $tariff_value . '" ', TEXT_TARIFF_TITLE_1);
                        } else {
                            $return_array['body'] .= TEXT_TARIFF_TITLE_1;
                        }
                    } else {
                        if ($tariff_number_result->RecordCount() > 0) {
                            $return_array['body'] .= str_replace('name="tariff"', ' name="tariff" value="' . $tariff_value . '" ', TEXT_TARIFF_TITLE_2);
                        } else {
                            $return_array['body'] .= TEXT_TARIFF_TITLE_2;
                        }
                    }
                } elseif ($select_country_code == 'DE' || $select_country_code == 'ES') {
                    if ($_SESSION['shipping']['code'] == 'kdfedex') {
                        if ($tariff_number_result->RecordCount() > 0) {
                            $return_array['body'] .= str_replace('name="tariff"', ' name="tariff" value="' . $tariff_value . '" ', TEXT_TARIFF_TITLE_3);
                        } else {
                            $return_array['body'] .= TEXT_TARIFF_TITLE_3;
                        }

                    } else {
                        if ($tariff_number_result->RecordCount() > 0) {
                            $return_array['body'] .= str_replace('name="tariff"', ' name="tariff" value="' . $tariff_value . '" ', TEXT_TARIFF_TITLE_4);
                        } else {
                            $return_array['body'] .= TEXT_TARIFF_TITLE_4;
                        }
                    }
                } else {
                    if ($tariff_number_result->RecordCount() > 0) {
                        $return_array['body'] .= str_replace('name="tariff"', ' name="tariff" value="' . $tariff_value . '" ', TEXT_TARIFF_TITLE_5);
                    } else {
                        $return_array['body'] .= TEXT_TARIFF_TITLE_5;
                    }

                }
            } elseif ($_SESSION['languages_id'] == 3 || $_SESSION['languages_id'] == 2 || $_SESSION['languages_id'] == 4) {
                if ($tariff_number_result->RecordCount() > 0) {
                    $return_array['body'] .= str_replace('name="tariff"', ' name="tariff" value="' . $tariff_value . '" ', TEXT_TARIFF_TITLE_1);
                } else {
                    $return_array['body'] .= TEXT_TARIFF_TITLE_1;
                }
            }

            $return_array['body'] .= '</p></div></div>';

            if ($write_shopping_log) {
                write_file("log/shopping_cart_log/", "invoice_comment_" . date("Ymd") . ".txt", $identity_info . "\t" . $_SESSION['count_cart'] . "\t" . $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n");
            }
            die(json_encode($return_array));
            break;

        case 'review_order':
            require('includes/application_top.php');
            require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/checkout.php');

            $coupon_show_id = 1;
            $startime = microtime(true);
            $startdate = date("Y-m-d H:i:s");
            $write_shopping_log = false;
            if (isset($_SESSION['count_cart']) && $_SESSION['count_cart'] >= 50) {
                $write_shopping_log = true;
                $identity_info = $_COOKIE['cookie_cart_id'];
                if (!empty($_SESSION['customer_id'])) {
                    $identity_info = $_SESSION['customer_id'];
                }
                if (empty($identity_info)) {
                    $identity_info = json_encode($_COOKIE) . "separator" . json_encode($_SESSION);
                }
                write_file("log/shopping_cart_log/", "review_order_" . date("Ymd") . ".txt", $identity_info . "\t" . $_SESSION['count_cart'] . "\t" . $startdate . "\r\n");
            }

            $input_info_arr = array();
            if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != 0) {
                //Tianwen.Wan20160624购物车优化
                $products_array = $_SESSION['cart']->get_isvalid_checkout_products_optimize();
                $total_num = $products_array['count'];

                //$_SESSION ['cart']->calculate();
                $_SESSION ['cart']->check_gift();
                $page_size = 100;        //	item num per page
                //$total_num = $_SESSION['cart']->get_products_num();
                //$products = $_SESSION['cart']->get_products(false, $page_size);
                $total_page = ceil($total_num / $page_size);        //	total page
                $_GET['page'] = isset($_POST['page']) ? ($_POST['page'] < 1 ? 1 : ($_POST['page'] > $total_page ? $total_page : $_POST['page'])) : 1;
                $current_page_num = $_GET['page'];        //	current page

                $products = array_slice($products_array['data'], ($current_page_num - 1) * $page_size, $page_size);

                $input_info_arr['info'] = '
					<div class="total_top"><span>' . sprintf(TEXT_TOTAL_ITEM, $total_num) . '</span><a href="' . zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL') . '">' . TEXT_BACK_TO_MODIFY_CART . '</a></div>
						<table width="100%" cellspacing="0" cellpadding="0" border="0" class="shopcart_content cartTab">
							<tbody><tr>
								<th width="105">' . TEXT_IMAGE . '</th>
								<th>' . TEXT_PART_NO . '</th>
								<th width="70">' . TEXT_WEIGHT . '</th>
								<th width="350">' . TEXT_PRODUCT_NAME . '</th>
								<th width="95">' . TEXT_PRICE . '</th>
								<th width="100">' . TEXT_QUANTITY . '</th>
								<th width="135">' . TEXT_SUBTOTAL . '</th>
							</tr>';
                for ($i = 0, $n = sizeof($products); $i < $n; $i++) {
                    $product_link = zen_href_link('product_info', 'products_id=' . $products[$i]['id']);
                    $product_name = htmlspecialchars(zen_clean_html($products [$i] ['name']));
                    $product_image = HTTPS_IMG_SERVER . 'bmz_cache/' . get_img_size($products[$i]['image'], 80, 80);
                    $product_quantity = $products[$i]['quantity'];
                    $discount_amount = zen_show_discount_amount($products [$i] ['id']);
                    $productsPriceEach = $currencies->format_cl(zen_add_tax($products [$i] ['final_price'], zen_get_tax_rate($products [$i] ['tax_class_id'])));
                    $productsPriceOriginal = $currencies->format_cl(zen_add_tax($products [$i] ['original_price'], zen_get_tax_rate($products [$i] ['tax_class_id'])));
                    $symbol_left = $currencies->currencies [$_SESSION ['currency']] ['symbol_left'];
                    $productsPrice = $currencies->format($currencies->format_cl(zen_add_tax($products [$i] ['final_price'], zen_get_tax_rate($products [$i] ['tax_class_id']))) * $product_quantity, false);
                    $productsShowPrice = ($productsPriceEach == $productsPriceOriginal) ? $currencies->format($productsPriceEach, false) : ('<del>' . $symbol_left . $productsPriceOriginal . '</del>' . $currencies->format($productsPriceEach, false));
                    $showTr = $i > 2 ? ' style="display:none" class="hideTheTr" ' : '';        //	only show 3 items
                    $input_info_arr['info'] .= '
					<tr ' . $showTr . '>
						<td align="center">' . ($discount_amount > 0 ? draw_discount_img($discount_amount, 'div', 'discountbg_small')/* '<div class="discountbg_small">'.$discount_amount.'%<br/>off</div>' */ : '') . ($i + 1) . '.<a target="_blank" href="' . $product_link . '" class="proimg"><img class="lazy-img" src="/includes/templates/cherry_zen/images/loading/80.gif" data-size="80" data-lazyload="' . $product_image . '" align="texttop" width="50px" /></a></td>
						<td align="center">' . $products[$i]['model'] . '</td>
						<td align="center" class="volweightwap">' . number_format($products [$i] ['weight'], 1, ".", ",") . TEXT_GRAM_WORD . '</td>
						<td><a target="_blank" href="' . $product_link . '">' ./*($products [$i] ['product_quantity']==0 ? TEXT_PREORDER.' ':'').*/
                        $product_name . '</a>' . ($products [$i] ['product_quantity'] == 0 ? '<div class="clearfix"></div><div style=" margin:10px 0 0 0; color:#999">' . ($products[$i]['products_stocking_days'] > 7 ? TEXT_AVAILABLE_IN715 : TEXT_AVAILABLE_IN57) . '</div>' : '') . '</td>
						<td align="center">' . $productsShowPrice . '</td>
						<td align="center">' . $product_quantity . ' ' . ($product_quantity > 1 ? TEXT_PACKET_2 : TEXT_PACKET) . '</td>
						<td align="center"><span class="font_red">' . $productsPrice . '</span></td>
					</tr>';
                }
                if ($n > 3)
                    $input_info_arr['info'] .= '<tr><td colspan="7" class="more"><a href="javascript:void(0);" class="open"></a></td></tr>';
                $input_info_arr['info'] .= '</tbody></table>';
                $split_page = new splitPageResults('', $page_size, "*", 'page', false, $total_num);
                $split_page_str = $split_page->display_links_for_review(5);
                if (trim($split_page_str) != '' && trim($split_page_str) != '&nbsp;') $input_info_arr['info'] .= '<div class="propagelist">' . $split_page_str . '</div>';

                require(DIR_WS_CLASSES . 'order.php');
                $order = new order(0, $products_array['data']);
                unset($_SESSION['cc_id']);
                unset($_SESSION['show_rcd']);
                $packing_choose = $_SESSION['packing_tips_choose'];
                require(DIR_WS_CLASSES . 'order_total.php');
                $order_total_modules = new order_total;
                $order_total_array = $order_total_modules->process();
                $order_total_str = zen_get_order_total_str($order_total_array);

                //	about coupon
                $coupon_err = false;
                $selection = $order_total_modules->credit_selection();

                //coupon_code always be 80214 WSL
                $is_first_coupon = false;
                $coupon_code = '80214';

                $customers_add_coupon_str = '<div class="add_coupon_guide coupon-other"><span id=><strong>(' . $coupon_show_id . ')</strong>&nbsp;
							<strong>' . TEXT_ADD_COUPON_TITLE . ':</strong><span style="MARGIN-LEFT: 5px;">' . zen_draw_input_field('add_coupon_code', TEXT_ENTER_A_COUPON_CODE, 'style="line-height: 16px;" id="add_coupon_code"') . '</span>
							<button class="add_coupon_describe" onclick="return doAddCoupon();"><span><strong>' . TEXT_ADD_COUPON . '</strong></span></button>
							<p style="color:red;display: inline-block;" id="add_coupon_tip"></p>
							</div>';
                $coupon_show_id++;

                $show_select_coupon = '';
                $order_totals = 0;
                $promotion_discount = 0;
                if (isset($order_total_array)) {
                    for ($i = 0, $n = sizeof($order_total_array); $i < $n; $i++) {
                        if ($order_total_array[$i]['code'] == 'ot_subtotal') {
                            $order_totals = $order_total_array[$i]['value'];
                        } elseif ($order_total_array[$i]['code'] == 'ot_promotion') {
                            $promotion_discount = $order_total_array[$i]['value'];
                        }
                    }
                }
                $coupon_array = get_coupon_select();

                //$hide_str = '';
                if ($_SESSION['channel']) {
                    $coupon_err = true;
                } else {
                    $sql = "select coupon_id, coupon_amount, coupon_minimum_order from " . TABLE_COUPONS . " where coupon_code= :couponCodeEntered and coupon_active='Y' order by coupon_amount desc";
                    $sql = $db->bindVars($sql, ':couponCodeEntered', $coupon_code, 'string');
                    $coupon_result = $db->Execute($sql);
                    if ($order->info['subtotal'] < $coupon_result->fields['coupon_minimum_order']) {
                        if ($coupon_result->fields['coupon_amount'] == '6.01')
                            $coupon_err = true;
                    }
                    if ($order->info['subtotal'] <= $order->info['promotion_total'] /* && !zen_customer_is_new() WSL doreenbeads*/) {
                        $coupon_err = true;
                    }
                    if (sizeof($coupon_array) == 1 && $coupon_array[0]['coupon_usage'] == 'ru_only' && $is_first_coupon) {
                        $coupon_err = true;
                    }
                }

                // unset($_SESSION['cc_id']);
                // unset($_SESSION ['order_discount']);
                $_SESSION['coupon_id'] = 0;
                $_SESSION['use_coupon'] = 'N';
                $_SESSION['use_coupon_amount'] = 0;

                if (sizeof($coupon_array) > 0) {
                    $is_ru_online = false;
                    $coupon_count = 0;
                    $coupon_onlyone = 0;
                    $coupon_select = '<select id="coupon_select" name="coupon" class="coupon-select">';
                    /*满减活动 默认不选择coupon 与coupon不共享*/
                    if (date('Y-m-d H:i:s') > PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_START_TIME && date('Y-m-d H:i:s') < PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_END_TIME && !$_SESSION['channel']) {
                        $coupon_select .= '<option value="0" selected="selected">' . TEXT_DONT_USE_COUPON . '</option>';
                    } else {
                        $coupon_select .= '<option value="0">' . TEXT_DONT_USE_COUPON . '</option>';
                    }

                    for ($i = 0; $i < sizeof($coupon_array); $i++) {
                        if ($coupon_array[$i]['coupon_usage'] == 'ru_online') {
                            if ($_SESSION['languages_id'] != 3) continue;        //	ru_online
                            if ($coupon_array[$i]['coupon_amount'] != '6.01' && $promotion_discount > $coupon_array[$i]['coupon_amount'])
                                continue;
                            $is_ru_online = true;
                        }
                        //WSL  selected coupon_amount bigest default
                        if ($coupon_count == 0) {
                            /*满减活动 默认不选择coupon 与coupon不共享*/
                            if (date('Y-m-d H:i:s') < PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_START_TIME || date('Y-m-d H:i:s') > PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_END_TIME || $_SESSION['channel']) {
                                $select = 'selected="selected"';

                                $_SESSION['coupon_id'] = $coupon_array[0]['coupon_id'];
                                $_SESSION['coupon_to_customer_id'] = $coupon_array[0]['coupon_to_customer_id'];
                                $_SESSION['use_coupon'] = 'Y';
                                $order = new order(0, $products_array['data']);
                                $order_total_modules = new order_total;
                                $order_total_array = $order_total_modules->process();
                                $order_total_str = zen_get_order_total_str($order_total_array);
                            }
                        } else {
                            $select = '';
                        }

                        if ($coupon_array[$i]['coupon_type'] == "P") {
                            $coupon_amount = number_format($coupon_array[$i]['coupon_amount'], 2) . '% ' . TEXT_DISCOUNT_OFF;
                            $coupon_select_str .= '<option ' . $select . ' value="' . $coupon_array[$i]['coupon_to_customer_id'] . '" >' . $coupon_array[$i]['coupon_code'] . '&nbsp;&nbsp;&nbsp;' . $coupon_amount . '</option>';
                        } elseif ($coupon_array[$i]['coupon_type'] == "F" || $coupon_array[$i]['coupon_type'] == "C") {
                            $coupon_amount = $currencies->format($coupon_array[$i]['coupon_amount'], true, $order->info['currency'], $order->info['currency_value']);
                            $coupon_select_str .= '<option ' . $select . ' value="' . $coupon_array[$i]['coupon_to_customer_id'] . '" >' . $coupon_array[$i]['coupon_code'] . '&nbsp;&nbsp;&nbsp;' . $coupon_amount . '</option>';
                        }
                        $coupon_count++;
                        $coupon_onlyone = $coupon_array[$i]['coupon_id'];
                    }
                    if ($coupon_select_str) {
                        /*满减活动 默认不选择coupon 与coupon不共享*/
                        if ($coupon_count == 1 && (date('Y-m-d H:i:s') < PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_START_TIME || date('Y-m-d H:i:s') > PROMOTION_RANK_DISCOUNT_FULL_SET_MINUS_END_TIME || $_SESSION['channel'])) {        // if only one coupon, use it!
                            $coupon_select_str = str_replace('option value="' . $coupon_array[0]['coupon_to_customer_id'] . '"', 'option value="' . $coupon_array[0]['coupon_to_customer_id'] . '" selected="selected"', $coupon_select_str);
                            $coupon_id = intval($coupon_onlyone);
                            $_SESSION['coupon_id'] = 0;
                            $_SESSION['use_coupon'] = 'N';
                            $_SESSION['use_coupon_amount'] = 0;
                            if ($coupon_id > 0) {
                                $coupon_result = $db->Execute("select coupon_id, coupon_amount, coupon_type, coupon_usage from " . TABLE_COUPONS . " where coupon_id = $coupon_id and coupon_active='Y'");
                                if ($coupon_result->RecordCount() > 0) {
                                    if ($coupon_result->fields['coupon_usage'] == 'ru_online') {
                                        if ($_SESSION['languages_id'] == 3) {    //	ru_online
                                            $_SESSION['coupon_id'] = $coupon_id;
                                            $_SESSION['coupon_to_customer_id'] = $coupon_array[0]['coupon_to_customer_id'];
                                            $_SESSION['use_coupon_amount'] = $coupon_result->fields['coupon_amount'] == '6.01' ? 0 : $coupon_result->fields['coupon_amount'];
                                            $_SESSION['use_coupon'] = 'Y';
                                        }
                                    } else {
                                        $_SESSION['coupon_id'] = $coupon_id;
                                        $_SESSION['coupon_to_customer_id'] = $coupon_array[0]['coupon_to_customer_id'];
                                        $_SESSION['use_coupon'] = 'Y';
                                    }
                                }
                            }
                        }

                        $order = new order(0, $products_array['data']);
                        $order_total_modules = new order_total;
                        $order_total_array = $order_total_modules->process();
                        $order_total_str = zen_get_order_total_str($order_total_array, 2);
                        $coupon_select .= $coupon_select_str . '</select>';

                        if ($_SESSION['languages_id'] == 3) {
                            if ($coupon_count == 1) $coupon_count = ' (' . $coupon_count . ' ' . TEXT_COUPON_AVAILABLE_1 . ')';
                            else $coupon_count = ' (' . $coupon_count . ' ' . TEXT_COUPON_AVAILABLE_2 . ')';
                        } else
                            $coupon_count = ' (' . $coupon_count . ' ' . TEXT_COUPON_AVAILABLE . ')';
                        $show_select_coupon = '<div class="coupon-other" id="coupon_select_display"><strong><ins>(' . $coupon_show_id . ') <a target="_blank" href="page.html?id=192" style="text-decoration:none;color:#008FED;">' . TEXT_OTHER_COUPON_TITLE . '</a>' . $coupon_count . '</ins></strong><br/><form><p class="couponcode" id="coupon_select_str">' . $coupon_select . '</p></form></div>';
                    }
                }

                if ((!zen_get_customer_create()) && !$_SESSION ['order_discount'] && !get_with_channel()) {
                    $_SESSION['cc_id'] = 20;//RCD
                    $order = new order(0, $products_array['data']);
                    $order_total_modules = new order_total;
                    $order_total_array = $order_total_modules->process();
                    $order_total_str = zen_get_order_total_str($order_total_array, 1);
                }

                $show_rcd_str = '<div class="caption_shopgray">
						<h3>5.' . TEXT_DISCOUNT_COUPON . '</h3>
					</div>';

                $show_coupon_rcd_str = '<div class="left" >
						' . $customers_add_coupon_str . $cre_str . $show_select_coupon . '
					</div>';
                if ($cre_str == '' && $show_select_coupon == '' && $customers_add_coupon_str == '') {
                    $show_rcd_str = '';
                    $show_coupon_rcd_str = '';
                }
                $packing_choose_tips = '<div class="packtips">
						<p class="packtipstit"><label>*</label> ' . TEXT_REORDER_PACKING_TIPS . '</p>
						<dl>
							<dd>' . TEXT_PACKING . '</dd>
							<dt>
								<p><label><input type="radio" value="1" name="packingway" style="float: none;" />' . TEXT_REORDER_PACKING_WAY_ONE . '</label></p>
								<p><label><input type="radio" value="2" name="packingway" style="float: none;" />' . TEXT_REORDER_PACKING_WAY_TWO . '</label></p>
								<div><span class="pay_remain_shipping_text">( ' . TEXT_EXTRA_TIPS . ')</span><div class="extratips packnotice" style="display: none;"><span class="bot"></span><span class="top"></span>' . TEXT_EXTAR_SHIPPING_FEE . '</div></div>
							</dt>
						</dl>
					</div>';
                switch ($packing_choose) {
                    case 1:
                        $packing_choose_tips = '<div class="packtips">
							<p class="packtipstit"><label>*</label> ' . TEXT_REORDER_PACKING_TIPS . '</p>
							<dl>
								<dd>' . TEXT_PACKING . '</dd>
								<dt>
									<p><label><input type="radio" value="1" name="packingway" style="float: none;" />' . TEXT_REORDER_PACKING_WAY_ONE . '</label></p>
									<p><label><input type="radio" value="2" name="packingway" style="float: none;" />' . TEXT_REORDER_PACKING_WAY_TWO . '</label></p>
									<div><span class="pay_remain_shipping_text">( ' . TEXT_EXTRA_TIPS . ')</span><div class="extratips packnotice" style="display: none;"><span class="bot"></span><span class="top"></span>' . TEXT_EXTAR_SHIPPING_FEE . '</div></div>
								</dt>
							</dl>
						</div>';
                        break;
                    /*取消在部分商品为预定的情况下的 #D15*/
                    /* case 2:
                        $packing_choose_tips = '<div class="packtips">
                            <p class="packtipstit"><label>*</label> ' . TEXT_REORDER_PACKING_TIPS_2 . '</p>
                            <dl>
                                <dd>' . TEXT_PACKING . '</dd>
                                <dt>
                                    <p><label><input type="radio" value="3" name="packingway" style="float: none;" />' . TEXT_REORDER_PACKING_WAY_THREE . '</label></p>
                                    <p><label><input type="radio" value="2" name="packingway" style="float: none;" />' . TEXT_REORDER_PACKING_WAY_TWO . '</label></p>
                                    <div><span>( ' . TEXT_EXTRA_TIPS . '.<ins class="question_icon"></ins>)</span><div class="extratips packnotice" style="display: none;"><span class="bot"></span><span class="top"></span>' . TEXT_EXTAR_SHIPPING_FEE . '</div></div>
                                </dt>
                            </dl>
                        </div>';
                        break; */
                    case 2:
                        $packing_choose_tips = '<div class="packtips">
						<p class="packtipstit"><label>*</label> ' . TEXT_REORDER_PACKING_TIPS . '</p>
						<dl>
							<dd>' . TEXT_PACKING . '</dd>
							<dt>
								<p><label><input type="radio" value="1" name="packingway" style="float: none;" />' . TEXT_REORDER_PACKING_WAY_ONE . '</label></p>
								<p><label><input type="radio" value="2" name="packingway" style="float: none;" />' . TEXT_REORDER_PACKING_WAY_TWO . '</label></p>
								<div><span class="pay_remain_shipping_text">( ' . TEXT_EXTRA_TIPS . ')</span><div class="extratips packnotice" style="display: none;"><span class="bot"></span><span class="top"></span>' . TEXT_EXTAR_SHIPPING_FEE . '</div></div>
							</dt>
						</dl>
					</div>';
                        $packing_choose = 1;
                        break;

                    case 3:
                        $packing_choose_tips = '<div class="packtips">
							<p class="packtipstit"><label>*</label> ' . TEXT_REORDER_PACKING_TIPS_3 . '</p>
							<dl>
								<dd>' . TEXT_PACKING . '</dd>
								<dt>
									<p><label><input type="radio" value="4" name="packingway" style="float: none;" />' . TEXT_REORDER_PACKING_WAY_FOUR . '</label></p>
									<p><label><input type="radio" value="5" name="packingway" style="float: none;" />' . TEXT_REORDER_PACKING_WAY_FIVE . '</label></p>
									<div><div class="extratips packnotice" style="display: none;"><span class="bot"></span><span class="top"></span>' . TEXT_ERROR_PACKING_TIPS . '</div></div>
								</dt>
							</dl>
						</div>';
                        break;

                    default:
                        $packing_choose_tips = '<div class="packtips">
							<p class="packtipstit"><label>*</label> ' . TEXT_REORDER_PACKING_TIPS . '</p>
							<dl>
								<dd>' . TEXT_PACKING . '</dd>
								<dt>
									<p><label><input type="radio" value="1" name="packingway" style="float: none;" />' . TEXT_REORDER_PACKING_WAY_ONE . '</label></p>
									<p><label><input type="radio" value="2" name="packingway" style="float: none;" />' . TEXT_REORDER_PACKING_WAY_TWO . '</label></p>
									<div><span class="pay_remain_shipping_text">( ' . TEXT_EXTRA_TIPS . ')</span><div class="extratips packnotice" style="display: none;"><span class="bot"></span><span class="top"></span>' . TEXT_EXTAR_SHIPPING_FEE . '</div></div>
								</dt>
							</dl>
						</div>';
                }


                $packing_choose_tips .= '<input type="hidden" id="packing_choose" value="' . $packing_choose . '" />';
                $input_info_arr['info_below'] = '
				<div class="total_price" style="padding-top: 20px;">
					' . $show_rcd_str . '
					' . $show_coupon_rcd_str . '
					<div class="details_price">
						 <dl>' . $order_total_str . '</dl>
					</div>
					<div class="clear"></div>
				</div>
				<div class="cartftbtn">
					' . $packing_choose_tips . '
					<div class="clearfix"></div>
					<a href="' . zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL') . '"><< ' . TEXT_BACK_TO_SHOPPING_CART . '</a><a href="javascript:void(0);" class="confirmbtn nextbtnbig_yellow orderbtnbig" style="text-decoration:none">' . TEXT_PLACE_YOUR_ORDER . '</a>
				</div>';
                $input_info_arr['error'] = false;
                $input_info_arr['link'] = '';
            } else {
                $input_info_arr['link'] = zen_href_link(FILENAME_LOGIN, '', 'SSL');
                $input_info_arr['error'] = true;
            }
            echo json_encode($input_info_arr);
            if ($write_shopping_log) {
                write_file("log/shopping_cart_log/", "review_order_" . date("Ymd") . ".txt", $identity_info . "\t" . $_SESSION['count_cart'] . "\t" . $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n");
            }
            break;

        case 'add_coupon':
            require('includes/application_top.php');
            require('includes/languages/' . $_SESSION['language'] . '/checkout.php');

            $result_info_array = array('is_error' => false, 'error_info' => '', 'link' => '', 'coupon_display' => '', 'order_info' => '', 'prom_discount_str' => '', 'success_info' => TEXT_ADD_COUPON_DESCRIPTION);
            $code = zen_db_prepare_input($_POST['code']);
            $coupon_show_id = zen_db_prepare_input($_POST['coupon_show_id']);

            if ($code == '' || $code == TEXT_ENTER_A_COUPON_CODE) {
                $result_info_array['error_info'] = TEXT_ENTER_A_COUPON_CODE;
                $result_info_array['is_error'] = true;
            }

            $error_info_array = add_coupon_code($code);
            $result_info_array['error_info'] = $error_info_array['error_info'];
            $result_info_array['is_error'] = $error_info_array['is_error'];

            if (!$result_info_array['is_error']) {
                if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != 0) {
                    require(DIR_WS_CLASSES . 'order.php');
                    $order = new order();
                    require(DIR_WS_CLASSES . 'order_total.php');
                    $order_total_modules = new order_total;
                    $order_total_array = $order_total_modules->process();
                    $order_total_str = zen_get_order_total_str($order_total_array, 1);


                    $show_select_coupon = '';
                    $order_totals = 0;
                    $promotion_discount = 0;
                    if (isset($order_total_array)) {
                        for ($i = 0, $n = sizeof($order_total_array); $i < $n; $i++) {
                            if ($order_total_array[$i]['code'] == 'ot_subtotal') {
                                $order_totals = $order_total_array[$i]['value'];
                            } elseif ($order_total_array[$i]['code'] == 'ot_promotion') {
                                $promotion_discount = $order_total_array[$i]['value'];
                            }
                        }
                    }
                    $coupon_array = get_coupon_select();
                    if (sizeof($coupon_array) > 0) {
                        $coupon_count = 0;
                        $coupon_onlyone = 0;
                        $coupon_select = '<select id="coupon_select" name="coupon" class="coupon-select">';
                        $coupon_select .= '<option value="0">' . TEXT_DONT_USE_COUPON . '</option>';
                        for ($i = 0; $i < sizeof($coupon_array); $i++) {
                            if ($coupon_array[$i]['coupon_usage'] == 'ru_online') {
                                if ($_SESSION['languages_id'] != 3) continue;        //	ru_online
                                if ($coupon_array[$i]['coupon_amount'] != '6.01' && $promotion_discount > $coupon_array[$i]['coupon_amount'])
                                    continue;
                                $is_ru_online = true;
                            }
                            //WSL  selected coupon_amount bigest default
                            //var_dump($coupon_array[0]['coupon_id']);exit;
                            if ($coupon_count == 0) {
                                $select = 'selected="selected"';

                                $_SESSION['coupon_id'] = $coupon_array[0]['coupon_id'];
                                $_SESSION['coupon_to_customer_id'] = $coupon_array[0]['coupon_to_customer_id'];
                                $_SESSION['use_coupon'] = 'Y';
                                $order = new order(0, $products_array['data']);
                                $order_total_modules = new order_total;
                                $order_total_array = $order_total_modules->process();
                                $order_total_str = zen_get_order_total_str($order_total_array, 1);
                            } else {
                                $select = '';
                            }

                            if ($coupon_array[$i]['coupon_type'] == "P") {
                                $coupon_amount = number_format($coupon_array[$i]['coupon_amount'], 2) . '% ' . TEXT_DISCOUNT_OFF;
                                $coupon_select_str .= '<option ' . $select . ' value="' . $coupon_array[$i]['coupon_to_customer_id'] . '" >' . $coupon_array[$i]['coupon_code'] . '&nbsp;&nbsp;&nbsp;' . $coupon_amount . '</option>';
                            } elseif ($coupon_array[$i]['coupon_type'] == "F" || $coupon_array[$i]['coupon_type'] == "C") {
                                $coupon_amount = $currencies->format($coupon_array[$i]['coupon_amount'], true, $order->info['currency'], $order->info['currency_value']);
                                $coupon_select_str .= '<option ' . $select . ' value="' . $coupon_array[$i]['coupon_to_customer_id'] . '" >' . $coupon_array[$i]['coupon_code'] . '&nbsp;&nbsp;&nbsp;' . $coupon_amount . '</option>';
                            }
                            $coupon_count++;
                            $coupon_onlyone = $coupon_array[$i]['coupon_id'];
                        }
                        if ($coupon_select_str) {
                            if ($coupon_count == 1) {        // if only one coupon, use it!
                                $coupon_select_str = str_replace('option value="' . $coupon_array[0]['coupon_to_customer_id'] . '"', 'option value="' . $coupon_array[0]['coupon_to_customer_id'] . '" selected="selected"', $coupon_select_str);
                                $coupon_id = intval($coupon_onlyone);
                                $_SESSION['coupon_id'] = 0;
                                $_SESSION['use_coupon'] = 'N';
                                $_SESSION['use_coupon_amount'] = 0;
                                if ($coupon_id > 0) {
                                    $coupon_result = $db->Execute("select coupon_id, coupon_amount, coupon_type, coupon_usage
									from " . TABLE_COUPONS . " where coupon_id = $coupon_id and coupon_active='Y'");
                                    if ($coupon_result->RecordCount() > 0) {
                                        if ($coupon_result->fields['coupon_usage'] == 'ru_online') {
                                            if ($_SESSION['languages_id'] == 3) {    //	ru_online
                                                $_SESSION['coupon_id'] = $coupon_id;
                                                $_SESSION['coupon_to_customer_id'] = $coupon_array[0]['coupon_to_customer_id'];
                                                $_SESSION['use_coupon_amount'] = $coupon_result->fields['coupon_amount'] == '6.01' ? 0 : $coupon_result->fields['coupon_amount'];
                                                $_SESSION['use_coupon'] = 'Y';
                                            }
                                        } else {
                                            $_SESSION['coupon_id'] = $coupon_id;
                                            $_SESSION['coupon_to_customer_id'] = $coupon_array[0]['coupon_to_customer_id'];
                                            $_SESSION['use_coupon'] = 'Y';
                                        }
                                    }
                                }
                                $order = new order(0, $products_array['data']);
                                $order_total_modules = new order_total;
                                $order_total_array = $order_total_modules->process();
                                $order_total_str = zen_get_order_total_str($order_total_array, 2);
                            }
                            $coupon_select .= $coupon_select_str . '</select>';

                            if ($_SESSION['languages_id'] == 3) {
                                if ($coupon_count == 1) $coupon_count = ' (' . $coupon_count . ' ' . TEXT_COUPON_AVAILABLE_1 . ')';
                                else $coupon_count = ' (' . $coupon_count . ' ' . TEXT_COUPON_AVAILABLE_2 . ')';
                            } else {
                                $coupon_count = ' (' . $coupon_count . ' ' . TEXT_COUPON_AVAILABLE . ')';
                            }
                            $show_select_coupon = '<div class="coupon-other" id="coupon_select_display"><strong><ins>(' . $coupon_show_id . ') <a target="_blank" href="page.html?id=192" style="text-decoration:none;color:#008FED;">' . TEXT_OTHER_COUPON_TITLE . '</a>' . $coupon_count . '</ins></strong><br/><form><p class="couponcode" id="coupon_select_str">' . $coupon_select . '</p></form></div>';
                        }
                    }
                    $result_info_array['coupon_display'] = $show_select_coupon;
                    $result_info_array['order_info'] = $order_total_str;


                } else {
                    $result_info_array['link'] = zen_href_link(FILENAME_LOGIN, '', 'SSL');
                    $result_info_array['is_error'] = true;
                }
            }

            echo json_encode($result_info_array);
            break;
        case 'discount_coupou':
            require('includes/application_top.php');
            require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/checkout.php');
            $input_info_arr = array();

            if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != 0) {
                require(DIR_WS_CLASSES . 'order.php');
                $order = new order;
                $order_total = array('totalFull' => $order->info['subtotal'], 'total' => $order->info['total'], 'tax' => 0);

                $is_first_coupon = false;
                $_POST['dc_redeem_code'] = '80214';

                if (isset($_POST['dc_redeem_code']) && $_POST['dc_redeem_code'] <> "") {
                    $sql = "select coupon_id, coupon_amount, coupon_type, coupon_minimum_order, uses_per_coupon, uses_per_user,
								restrict_to_products, restrict_to_categories, coupon_zone_restriction, coupon_usage
								from " . TABLE_COUPONS . "
								where coupon_code= :couponCodeEntered
								and coupon_active='Y'";
                    $sql = $db->bindVars($sql, ':couponCodeEntered', $_POST['dc_redeem_code'], 'string');
                    $coupon_result = $db->Execute($sql);

                    if ($coupon_result->fields['coupon_type'] != 'G') {
                        $coupon_valid = true;

                        if ($coupon_result->RecordCount() < 1 || !$coupon_valid) {
                            $input_info_arr['error_info'] = '<br>' . TEXT_INVALID_REDEEM_COUPON;
                        } elseif ($order_total['totalFull'] < $coupon_result->fields['coupon_minimum_order']) {
                            if ($coupon_result->fields['coupon_amount'] == '6.01')
                                $input_info_arr['error_info'] = '<br>' . sprintf(TEXT_INVALID_REDEEM_COUPON_MINIMUM_1, $currencies->format(6.01), $currencies->format($coupon_result->fields['coupon_minimum_order']));
                            else
                                $input_info_arr['error_info'] = '<br>' . sprintf(TEXT_INVALID_REDEEM_COUPON_MINIMUM, $currencies->format($coupon_result->fields['coupon_minimum_order']));
                        } else {
                            $date_query = $db->Execute("select coupon_start_date from " . TABLE_COUPONS . "
											 where coupon_start_date <= now() and
											 coupon_code='" . zen_db_prepare_input($_POST['dc_redeem_code']) . "'");
                            if ($date_query->RecordCount() < 1) {
                                $input_info_arr['error_info'] = '<br>(<b>' . TEXT_INVALID_STARTDATE_COUPON . '</b>)';
                            } else {
                                $date_query = $db->Execute("select coupon_expire_date from " . TABLE_COUPONS . "
											 where coupon_expire_date >= now() and
											 coupon_code='" . zen_db_prepare_input($_POST['dc_redeem_code']) . "'");
                                if ($date_query->RecordCount() < 1) {
                                    $input_info_arr['error_info'] = '<br>(<b>' . TEXT_INVALID_FINISHDATE_COUPON . '</b>)';
                                } else {
                                    $coupon_count = $db->Execute("select coupon_id from " . TABLE_COUPON_REDEEM_TRACK . "
												where coupon_id = '" . (int)$coupon_result->fields['coupon_id'] . "'");
                                    $coupon_count_customer = $db->Execute("select coupon_id from " . TABLE_COUPON_REDEEM_TRACK . "
														  where coupon_id = '" . $coupon_result->fields['coupon_id'] . "' and
														  customer_id = '" . (int)$_SESSION['customer_id'] . "'");
                                    if ($coupon_count->RecordCount() >= $coupon_result->fields['uses_per_coupon'] && $coupon_result->fields['uses_per_coupon'] > 0) {
                                        $input_info_arr['error_info'] = '<br>(<b>' . TEXT_INVALID_USES_COUPON . $coupon_result->fields['uses_per_coupon'] . TIMES . '</b>)';
                                    } elseif ($coupon_count_customer->RecordCount() >= $coupon_result->fields['uses_per_user'] && $coupon_result->fields['uses_per_user'] > 0) {
                                        $input_info_arr['error_info'] = '<br>(<b>' . sprintf(TEXT_INVALID_USES_USER_COUPON, $_POST['dc_redeem_code']) . $coupon_result->fields['uses_per_user'] . ($coupon_result->fields['uses_per_user'] == 1 ? TIME : TIMES) . '</b>)';
                                    } else {
                                        $_SESSION['cc_id'] = $coupon_result->fields['coupon_id'];
                                        require(DIR_WS_CLASSES . 'order_total.php');
                                        $order_total_modules = new order_total;
                                        $order_total_array = $order_total_modules->process();
                                        $order_total_str = zen_get_order_total_str($order_total_array, 1);
                                        $input_info_arr['order_info'] = $order_total_str;
                                        $input_info_arr['success_info'] = '<strong><ins>' . TEXT_DISCOUNT_COUPOU . '</ins></strong>	<br><br>
																			 <p class="greenfont"><strong>' . TEXT_COUPOU_SUCCESS_INFO . '</strong></p>';
                                        if ($is_first_coupon) {
                                            $order_totals = 0;
                                            $promotion_discount = 0;
                                            if (isset($order_total_array)) {
                                                for ($i = 0, $n = sizeof($order_total_array); $i < $n; $i++) {
                                                    if ($order_total_array[$i]['code'] == 'ot_subtotal') {
                                                        $order_totals = $order_total_array[$i]['value'];
                                                    } elseif ($order_total_array[$i]['code'] == 'ot_promotion') {
                                                        $promotion_discount = $order_total_array[$i]['value'];
                                                    }
                                                }
                                            }
                                            $coupon_select_str = '';
                                            $coupon_array = get_coupon_select();
                                            if (sizeof($coupon_array) > 0) {
                                                $coupon_select = '<select id="coupon_select" name="coupon" class="coupon-select">';
                                                $coupon_select .= '<option value="0">' . TEXT_DONT_USE_COUPON . '</option>';
                                                $coupon_count = 0;
                                                for ($i = 0; $i < sizeof($coupon_array); $i++) {
                                                    if ($coupon_array[$i]['coupon_usage'] == 'ru_only') {
                                                        continue;
                                                    }
                                                    if (isset($_SESSION['coupon_id']) && $_SESSION['coupon_id'] == $coupon_array[$i]['coupon_id'] && $_SESSION['coupon_id'] > 0) {
                                                        $select = ' selected="selected"';
                                                    } else {
                                                        $select = '';
                                                    }
                                                    if ($coupon_array[$i]['coupon_type'] == "P") {
                                                        $coupon_amount = number_format($coupon_array[$i]['coupon_amount'], 2) . '% ' . TEXT_DISCOUNT_OFF;

                                                    } elseif ($coupon_array[$i]['coupon_type'] == "F" || $coupon_array[$i]['coupon_type'] == "C") {
                                                        $coupon_amount = $currencies->format($coupon_array[$i]['coupon_amount'], true, $order->info['currency'], $order->info['currency_value']);
                                                    }
                                                    $coupon_select_str .= '<option ' . $select . ' value="' . $coupon_array[$i]['coupon_to_customer_id'] . '" >' . $coupon_array[$i]['coupon_code'] . '&nbsp;&nbsp;&nbsp;' . $coupon_amount . '</option>';
                                                    $coupon_count++;
                                                }
                                                if ($coupon_select_str) {

                                                    $coupon_select .= $coupon_select_str . '</select>';
                                                    if ($_SESSION['languages_id'] == 3) {
                                                        if ($coupon_count == 1) {
                                                            $coupon_count = ' (' . $coupon_count . ' ' . TEXT_COUPON_AVAILABLE_1 . ')';
                                                        } else {
                                                            $coupon_count = ' (' . $coupon_count . ' ' . TEXT_COUPON_AVAILABLE_2 . ')';
                                                        }
                                                    } else {
                                                        $coupon_count = ' (' . $coupon_count . ' ' . TEXT_COUPON_AVAILABLE . ')';
                                                    }
                                                    $show_select_coupon = '<strong><ins>(2) <a target="_blank" href="page.html?id=192" style="text-decoration:none;color:#008FED;">' . TEXT_OTHER_COUPON_TITLE . '</a>' . $coupon_count . '</ins></strong><br/><form><p class="couponcode" id="coupon_select_str">' . $coupon_select . '</p></form>';
                                                    $input_info_arr['show_select_coupon'] = $show_select_coupon;
                                                }
                                                if (sizeof($coupon_array) == 1 && $coupon_array[0]['coupon_usage'] == 'ru_only') {
                                                    $input_info_arr['show_select_coupon'] = ' ';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $input_info_arr['error_info'] = TEXT_ERROR_CODE;
                }
                $input_info_arr['error'] = false;
                $input_info_arr['link'] = '';
            } else {
                $input_info_arr['link'] = zen_href_link(FILENAME_LOGIN, '', 'SSL');
                $input_info_arr['error'] = true;
            }
            echo json_encode($input_info_arr);
            break;

        case 'update_shipping_address' :
            include('includes/application_top.php');
            require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/checkout.php');

            if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != 0) {
                unset($_SESSION['shipping']);
                require(DIR_WS_CLASSES . 'order.php');
                $order = new order;
                $_SESSION['cartID'] = $_SESSION['cart']->cartID;
                require(DIR_WS_CLASSES . 'shipping.php');
                $shipping_modules = new shipping;
                $shipping_result = $shipping_modules->reduce_result;

                $_SESSION['cartID'] = $_SESSION['cart']->cartID;
                $total_weight = $_SESSION['cart']->show_weight();
                $total_weight_all = ($total_weight > 50000 ? $total_weight * 1.06 : $total_weight * 1.1);
                $volume_shipping_weight = $_SESSION['cart']->show_volume_weight();

                $shipping_input = zen_db_prepare_input($_POST['shipping']);

                if ((sizeof($shipping_result) > 0) || ($free_shipping == true)) {
                    if ((strpos($shipping_input, '_'))) {

                        if ($shipping_input != "" && $_SESSION['customer_id'] != 0) {
                            $db->Execute("update " . TABLE_CUSTOMERS . " set customers_default_shipping = '" . zen_db_prepare_input($shipping_input) . "' where customers_id  = " . $_SESSION['customer_id'] . " ");
                        }
                        list($module, $method) = explode('_', $shipping_input);
                        $_SESSION['estimate_method'] = $module;
                        if (isset($shipping_result[$module]) || ($_SESSION['shipping']['id'] == 'free_free')) {
                            if ($_SESSION['shipping']['id'] == 'free_free') {
                                $quote['title'] = FREE_SHIPPING_TITLE;
                                $quote['cost'] = '0';
                            } else {
                                $quote = $shipping_result[$module];
                                $quote['id'] = $quote['code'] . '_' . $quote['code'];
                            }

                            if ($quote['error']) {
                                $_SESSION['shipping'] = null;
                            } else {
                                if ((isset($quote['title'])) && (isset($quote['final_cost']))) {
                                    $_SESSION['shipping'] = $quote;
                                }
                            }
                        } else {
                            $_SESSION['shipping'] = null;
                        }
                    }
                }

                $order->cart();
                require(DIR_WS_CLASSES . 'order_total.php');
                $order_total_modules = new order_total;
                $order_total_array = $order_total_modules->process();

                if ($_SESSION['cc_id']) {
                    $order_total_str = zen_get_order_total_str($order_total_array, 1);
                } else {
                    $order_total_str = zen_get_order_total_str($order_total_array, false, true);
                }

                if ($_SESSION['shipping']) {
                    $select_country_id_query = "select entry_country_id, countries_iso_code_2 from " . TABLE_ADDRESS_BOOK . ", " . TABLE_COUNTRIES . " where address_book_id = :addressBookID and entry_country_id = countries_id";
                    $select_country_id_query = $db->bindVars($select_country_id_query, ':addressBookID', $_SESSION['sendto'], 'integer');
                    $select_country_id_return = $db->Execute($select_country_id_query);
                    if ($select_country_id_return->RecordCount() == 1) {
                        $select_country_id = $select_country_id_return->fields['entry_country_id'];
                        $select_country_code = $select_country_id_return->fields['countries_iso_code_2'];
                    }

                    $input_info_arr['info'] = $order_total_str;

                    $show_volume_weight = '<tr class="show_volume_weight_tr"></tr>';
                    if (!empty($quote['shipping_volume_weight'])) {
                        $show_volume_weight = '<tr class="show_volume_weight_tr"><td style="border-right:#d0d1a9 1px solid;">' . $quote['shipping_volume_weight_title'] . '</td><td><label title="' . $quote['shipping_volume_weight_alt'] . '">' . $quote['shipping_volume_weight'] . ' ' . TEXT_GRAMS . '</label></td></tr>';
                    }

                    $shipping_weight_info .= '
								<tr>
							    	<td style="border-right:#d0d1a9 1px solid;" width="50%">' . TEXT_PRODUCT_WEIGHT . '</td>
							        <td>' . $total_weight . ' ' . TEXT_GRAMS . '</td>
							    </tr>'
                        . $show_volume_weight .
                        '<tr>
							    	<td style="border-right:#d0d1a9 1px solid;">' . TEXT_WORD_PACKAGE_BOX_WEIGHT . '</td>
							        <td class="show_package_box_weight_td">' . $quote['shipping_package_box_weight'] . ' ' . TEXT_GRAMS . '</td>
							    </tr>
							    <tr>
							    	<td style="border-right:#d0d1a9 1px solid;">' . TEXT_WORD_SHIPPING_WEIGHT . '</td>
							        <td class="shipping_total_weight_td">' . $quote['shipping_weight'] . ' ' . TEXT_GRAMS . '</td>
							    </tr>
								';

                    $input_info_arr['weight_info'] = $shipping_weight_info;
                    $input_info_arr['shipping_total_weight'] = $quote['shipping_weight'] . " g";

                    $input_info_arr['error'] = false;
                    $input_info_arr['link'] = '';
                } else {
                    $input_info_arr['link'] = zen_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL');
                    $input_info_arr['error'] = true;
                }
            } else {
                $input_info_arr['link'] = zen_href_link(FILENAME_LOGIN, '', 'SSL');
                $input_info_arr['error'] = true;
            }
            echo json_encode($input_info_arr);
            break;

        case 'set_discount_coupou':
            require('includes/application_top.php');
            require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/checkout.php');
            $input_info_arr = array();

            if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != 0) {
                require(DIR_WS_CLASSES . 'order.php');
                require(DIR_WS_CLASSES . 'order_total.php');
                $order = new order;

                $_SESSION['coupon_to_customer_id'] = intval($_POST['couponId']);
                $coupon_query = $db->Execute("select cc_coupon_id from " . TABLE_COUPON_CUSTOMER . " where cc_id='" . $_POST['couponId'] . "' limit 1");
                $coupon_id = $coupon_query->fields['cc_coupon_id'];

                unset($_SESSION['cc_id']);
                unset($_SESSION ['order_discount']);
                $_SESSION['coupon_id'] = 0;
                $_SESSION['use_coupon'] = 'N';
                $_SESSION['use_coupon_amount'] = 0;
                if ($coupon_id > 0) {
                    $coupon_result = $db->Execute("select coupon_id, coupon_amount, coupon_type, coupon_usage
								from " . TABLE_COUPONS . " where coupon_id = $coupon_id and coupon_active='Y'");
                    if ($coupon_result->RecordCount() > 0) {
                        if ($coupon_result->fields['coupon_usage'] == 'ru_online') {
                            if ($_SESSION['languages_id'] == 3) {    //	ru_online
                                $_SESSION['coupon_id'] = $coupon_id;
                                $_SESSION['use_coupon_amount'] = $coupon_result->fields['coupon_amount'] == '6.01' ? 0 : $coupon_result->fields['coupon_amount'];
                                $_SESSION['use_coupon'] = 'Y';
                            }
                        } else {
                            $is_first_coupon = zen_check_first_coupon();
                            if ($coupon_result->fields['coupon_usage'] == 'ru_only' && $is_first_coupon) {
                                $input_info_arr['hide_first_coupon'] = true;
                            }
                            $_SESSION['coupon_id'] = $coupon_id;
                            $_SESSION['use_coupon'] = 'Y';
                        }
                    }
                }

                $order_total_modules = new order_total;
                $order_total_array = $order_total_modules->process();
                $order_total_str = zen_get_order_total_str($order_total_array, 2);

                if ((!zen_get_customer_create()) && !$_SESSION ['order_discount'] && !get_with_channel()) {
                    $_SESSION['cc_id'] = 20;//RCD
                    $order = new order(0, $products_array['data']);
                    $order_total_modules = new order_total;
                    $order_total_array = $order_total_modules->process();
                    $order_total_str = zen_get_order_total_str($order_total_array, 1);
                }

                $input_info_arr['order_info'] = $order_total_str;
                $input_info_arr['error'] = false;
            } else {
                $input_info_arr['link'] = zen_href_link(FILENAME_LOGIN, '', 'SSL');
                $input_info_arr['error'] = true;
            }
            echo json_encode($input_info_arr);
            break;

        default :
            exit;
    }
} else {
    exit;
}