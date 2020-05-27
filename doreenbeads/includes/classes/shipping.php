<?php

class shipping extends base
{
    public $shipping_method;
    public $cal_result;
    public $reduce_result;
    public $virtual_result;
    public $special_result;
    public $country_iso2;
    public $shipping_method_limit;
    public $shipping_method_limit_description;
    private $toatl_shipping_weight;
    //kuaidiyunshufanshi
    private $kd_shipping_array = array('chinapost', 'ywdhl', 'hmauexpr', 'ywfedex', 'ywlbip', 'upssk', 'upskj', 'etk', 'ubi', 'zdzx', 'cneth', 'zdzxqh', 'zdzxzh', 'dsfygzx', 'jstnt', 'jsdhl');

    function __construct($single_method = '', $country_iso2 = '', $weight = '', $postcode = '', $city = '', $feed_flag = false, $product_id = '')
    {
        global $db;
        $extra_sql = $single_method == '' ? '' : ' and code="' . $single_method . '"';
        $shipping = $db->Execute('select * from ' . TABLE_SHIPPING . ' where (status = 1 or `code`="airmail")' . $extra_sql);
        if ($shipping->RecordCount() > 0) {
            while (!$shipping->EOF) {
                $shipping_day = $this->get_shipping_day($shipping->fields['code']);
                $shipping_title = $this->get_shipping_title($shipping->fields['id']);

                $shipping->fields['title'] = $shipping_title;
                $shipping->fields['days'] = $shipping_day['day_low'] . '-' . $shipping_day['day_high'];
                $this->shipping_method[$shipping->fields['code']] = $shipping->fields;
                $shipping->MoveNext();
            }
        }

        $this->quote($country_iso2, $weight, $postcode, $city, $feed_flag, $product_id);
        $this->reduce_airmail_cost();
    }

    function get_shipping_day($shipping_code, $country_iso2 = '', $shipping_postcode = '')
    {
        global $db;
        $shipping_day = array();
        $query = $db->Execute('select day_low, day_high from ' . TABLE_SHIPPING_DAY . ' where code = "' . $shipping_code . '" and country_iso2 = "' . $country_iso2 . '" limit 1');
        if ($query->RecordCount() == 0) {
            if ($shipping_postcode != '') {
                $virtual_shipping_area_query = 'SELECT
                                                    	vsap.shipping_transport_min as day_low,
                                                    	vsap.shipping_transport_max as day_high
                                                    FROM
                                                        ' . TABLE_VIRTUAL_SHIPPING_AREA_POSTCODE . ' vsap
                                                    INNER JOIN ' . TABLE_VIRTUAL_SHIPPING . ' vs ON vsap.shipping_id = vs.shipping_id
                                                    WHERE
                                                        vs.shipping_code = "' . $shipping_code . '"
                                                    AND vsap.shipping_post_code_start <= "' . $shipping_postcode . '"
                                                    AND vsap.shipping_post_code_end >= "' . $shipping_postcode . '"
                                                    AND vs.shipping_status = 10
                                                    AND vs.country_code = "' . $country_iso2 . '"
                                                    limit 1';

                $query = $db->Execute($virtual_shipping_area_query);
            } else {
                $query = $db->Execute('select day_low, day_high from ' . TABLE_SHIPPING_DAY . ' where code = "' . $shipping_code . '" and country_iso2 = "" limit 1');
            }
        }
        if ($query->RecordCount() == 1) {
            if ($country_iso2 == 'RU' && $shipping_code == 'bybpy') {
                $shipping_day['day_low'] = 20;
                $shipping_day['day_high'] = 35;
            } else {
                $shipping_day['day_low'] = $query->fields['day_low'];
                $shipping_day['day_high'] = $query->fields['day_high'];
            }
            return $shipping_day;
        } else {
            return 0;
        }
    }

    function get_shipping_title($id)
    {
        global $db;
        $query = $db->Execute('select title from ' . TABLE_SHIPPING_INFO . ' where id = ' . $id . ' and language_id = ' . $_SESSION['languages_id'] . ' limit 1');
        if ($query->RecordCount() == 1) {
            if ($query->fields['title'] != '') {
                return $query->fields['title'];
            }
        }
        return '';
    }

    function quote($country_iso2 = '', $weight = '', $postcode = '', $city = '', $feed_flag = false, $product_id = '')
    {
        global $order, $db, $currencies;
        $this->country_iso2 = $country_iso2 != '' ? $country_iso2 : $order->delivery['country']['iso_code_2'];
        $shipping_city = $city != '' ? $city : $order->delivery['city'];
        $shipping_postcode = $postcode != '' ? $postcode : $order->delivery['postcode'];
        $shipping_state = $order->delivery['state'];
        $zone_id = $order->delivery['zone_id'];

        if ($this->country_iso2 == 'US' and ($order->delivery['state'] == 'PR' or strstr($order->delivery['state'], 'Puerto Rico'))) {
            $this->country_iso2 = 'PR';
        }

        //Tianwen.Wan20150922(当国家为美国（United States）、州（State/Province）选中的是 “Virgin Islands”时，运费按照国家为“Virgin Islands(U.S.)”时去算)
        if ($this->country_iso2 == 'US' && $order->delivery['zone_id'] == 60) {
            $this->country_iso2 = 'VI';
        }

        if (zen_is_facebook_like_time()) {    //	送产品活动期间，运送地址屏蔽这些国家 lvxiaoyong 20150730
            $black_shipping = explode(',', FACEBOOK_LIKE_BLACK_COUNTRY_SHIPPING);
            if (in_array($this->country_iso2, $black_shipping)) {
                return false;
            }
        }

        $shipping_size = sizeof($this->shipping_method);

        // 运输方式限制新增数据表查询20160309 feiyao
        $shipping_method_restriction_sql = 'select smr.shipping_method, smr.products_id, smr.country_iso_code_2, smr.limit_result, smr.postcode_from, smr.postcode_to, smr.start_time, smr.end_time, smrr.display_status, smr.status from ' . TABLE_SHIPPING_METHOD_RESTRICTION . ' smr, ' . TABLE_SHIPPING_METHOD_RESTRICTION_RESULT . ' smrr where smr.limit_result = smrr.limit_result';
        $shipping_method_restriction = $db->Execute($shipping_method_restriction_sql);
        if ($shipping_method_restriction->RecordCount() > 0) {
            while (!$shipping_method_restriction->EOF) {
                $shipping_method_restriction_array[] = array(
                    'shipping_method' => $shipping_method_restriction->fields['shipping_method'],
                    'products_id' => $shipping_method_restriction->fields['products_id'],
                    'country_iso_code_2' => $shipping_method_restriction->fields['country_iso_code_2'],
                    'limit_result' => $shipping_method_restriction->fields['limit_result'],
                    'start_time' => $shipping_method_restriction->fields['start_time'],
                    'end_time' => $shipping_method_restriction->fields['end_time'],
                    'display_status' => $shipping_method_restriction->fields['display_status'],
                    'status' => $shipping_method_restriction->fields['status'],
                    'postcode_from' => $shipping_method_restriction->fields['postcode_from'],
                    'postcode_to' => $shipping_method_restriction->fields['postcode_to']
                );
                $shipping_method_restriction->MoveNext();
            }
        }
        //print_r($shipping_method_restriction_array);
        $shipping_disable = array();
        $index_limit = 0;
        foreach ($shipping_method_restriction_array as $key => $value) {
            if (isset($value['start_time']) && isset($value['end_time']) && $value['start_time'] > '1900-00-00 00:00:00') {
                if ($value['start_time'] < date('Y-m-d H:i:s') && $value['end_time'] > date('Y-m-d H:i:s')) {
                    $shipping_disable[$value['shipping_method']][$value['limit_result']][$index_limit]['start_time'] = $value['start_time'];
                    $shipping_disable[$value['shipping_method']][$value['limit_result']][$index_limit]['end_time'] = $value['end_time'];
                } else {
                    continue;
                }
            }
            if (!empty($value['country_iso_code_2'])) {
                //array_push($shipping_disable[$value['shipping_method']][$value['limit_result']]['country_iso_code_2'], $value['country_iso_code_2']);
                $shipping_disable[$value['shipping_method']][$value['limit_result']][$index_limit]['country_iso_code_2'] = $value['country_iso_code_2'];
            }
            if (!empty($value['products_id'])) {
                //array_push($shipping_disable[$value['shipping_method']][$value['limit_result']]['products_id'], $value['products_id']);
                $shipping_disable[$value['shipping_method']][$value['limit_result']][$index_limit]['products_id'] = $value['products_id'];
            }
            if (isset($value['postcode_from']) && isset($value['postcode_to']) && $value['postcode_from'] != '') {
                $shipping_disable[$value['shipping_method']][$value['limit_result']][$index_limit]['postcode_from'] = preg_replace('/[\s-]/', '', $value['postcode_from']);
                $shipping_disable[$value['shipping_method']][$value['limit_result']][$index_limit]['postcode_to'] = preg_replace('/[\s-]/', '', $value['postcode_to']);
            }

            if (!empty($value['display_status'])) {
                //array_push($shipping_disable[$value['shipping_method']][$value['limit_result']]['products_id'], $value['products_id']);
                $shipping_disable[$value['shipping_method']][$value['limit_result']][$index_limit]['display_status'] = $value['display_status'];
                $shipping_disable[$value['shipping_method']][$value['limit_result']][$index_limit]['limit_result'] = $value['limit_result'];
            }
            if (!empty($value['display_status'])) {
                //array_push($shipping_disable[$value['shipping_method']][$value['limit_result']]['products_id'], $value['products_id']);
                $shipping_disable[$value['shipping_method']][$value['limit_result']][$index_limit]['display_status'] = $value['display_status'];
                $shipping_disable[$value['shipping_method']][$value['limit_result']][$index_limit]['limit_result'] = $value['limit_result'];
            }

            if (!empty($value['status'])) {
                //array_push($shipping_disable[$value['shipping_method']][$value['limit_result']]['products_id'], $value['products_id']);
                $shipping_disable[$value['shipping_method']][$value['limit_result']][$index_limit]['status'] = $value['status'];
            }
            //$shipping_disable[$value['shipping_method']][$value['limit_result']] = array_values($shipping_disable[$value['shipping_method']][$value['limit_result']]);
            $index_limit++;
        }
        //print_r($shipping_disable);

        $shipping_method_restriction_deccription_sql = 'select smrrd.limit_result, smrrd.language_id, smrrd.comment from ' . TABLE_SHIPPING_METHOD_RESTRICTION_RESULT_DESCRIPTION . ' smrrd, ' . TABLE_SHIPPING_METHOD_RESTRICTION_RESULT . ' smrr where smrrd.limit_result = smrr.limit_result and smrr.display_status = 20 ';
        $shipping_method_restriction_deccription = $db->Execute($shipping_method_restriction_deccription_sql);
        if ($shipping_method_restriction_deccription->RecordCount() > 0) {
            while (!$shipping_method_restriction_deccription->EOF) {
                $shipping_method_restriction_deccription_array[$shipping_method_restriction_deccription->fields ['limit_result']][$shipping_method_restriction_deccription->fields ['language_id']] = $shipping_method_restriction_deccription->fields ['comment'];
                $shipping_method_restriction_deccription->MoveNext();
            }
        }
        $this->shipping_method_limit_description = $shipping_method_restriction_deccription_array;

        if ($shipping_size > 0) {
            $shipping_display_method = get_shipping_display_method($order->delivery['country']['id']);
            if (!$feed_flag) {
                $show_weight = $airmail_weight = $_SESSION['cart']->show_weight();
                $volume_weight = round($_SESSION['cart']->show_volume_weight(), 2);
            } else {
                $show_weight = $airmail_weight = get_products_info_memcache($product_id, 'products_weight');
                $volume_weight = get_products_info_memcache($product_id, 'products_volume_weight');
            }

            if (empty($weight) || $feed_flag) {
                $this->toatl_shipping_weight = $show_weight * 1.1;
            } else {
                $this->toatl_shipping_weight = $weight;
            }

            foreach ($this->shipping_method as $code => $shipping_info) {
                $error = false;
                $shipping_volume_weight = $shipping_package_box_weight_final = $shipping_package_box_weight = $shipping_package_box_weight_volume = 0;
                $shipping_box_note = $shipping_volume_weight_title = $shipping_volume_weight_alt = $remote_note = $volume_note = "";

                $shipping_id = $shipping_info['id'];
                $shipping_code = $shipping_info['code'];
                $fuel_rate = $shipping_info['extra_oil'];
                $discount = $shipping_info['discount'];
                $extra_amt = $shipping_info['extra_amt'];
                $extra_times = $shipping_info['extra_times'];
                if ($shipping_info['status'] == '0') {
                    $error = true;
                }
                if (in_array($shipping_code, array('airmail', 'kddhl', 'ywdhl-dh', 'ywdhl'))) {
                    if ($this->country_iso2 == 'ES') {
                        if ((trim(strtolower($shipping_city)) == 'las palmas' || $zone_id == 157 || ($shipping_postcode >= 38000 && $shipping_postcode <= 38999)) || (trim(strtolower($shipping_city)) == 'santa cruz de tenerife' || $zone_id == 170 || ($shipping_postcode >= 35000 && $shipping_postcode <= 35999))) {
                            $this->country_iso2 = 'IC';
                        }
                    }
                }

                $disable_country = $this->disable($shipping_info['disable_country'], $this->country_iso2);
                $disable_postcode = $this->disable($shipping_info['disable_postcode'], $shipping_postcode);
                $disable_city = $this->disable($shipping_info['disable_city'], $city);
                if ($disable_country || $disable_postcode || $disable_city) {
                    $error = true;
                }

                if (!$feed_flag) {
                    $shipping_package_box_weight = $_SESSION['cart']->show_shipping_package_box_weight(0);
                    $shipping_package_box_weight_volume = $_SESSION['cart']->show_shipping_package_box_weight(1);
                } else {
                    $shipping_package_box_weight = get_solo_product_shipping_package_box_weight(0, $show_weight, $volume_weight);
                    $shipping_package_box_weight_volume = get_solo_product_shipping_package_box_weight(1, $show_weight, $volume_weight);
                }

                if (empty($weight)) {
                    $shipping_total_weight = round($show_weight + $shipping_package_box_weight, 2);
                    $shipping_total_volume_weight = round($volume_weight + $shipping_package_box_weight_volume, 2);

                    $shipping_package_box_weight_final = $shipping_package_box_weight;
                    $shipping_weight = $shipping_total_weight;

                    if ($shipping_total_volume_weight > $shipping_total_weight) {
                        if (!in_array($code, array('cnezx', 'ozswbg')) && ($shipping_info['cal_volume'] || (intval($shipping_info['package_type']) > 0 && $shipping_info['package_weight_kg'] > 0))) {
                            if (!in_array($code, array('airmaillp', 'airmail', 'xxeub', 'bybpy', 'cnegh', 'bpost', 'hmjz', 'hmdpd', 'hmauexpr', 'chinapost', 'etk'))) {
                                $volume_note = TEXT_SHIPPING_FEE . ', ' . TEXT_CLICK_HERE_FOR_MORE_LINK;
                            }
                            if (in_array($code, array('chinapost', 'emsrbzx', 'hmdpd', 'etk')) && !in_array($this->country_iso2, array('ZA', 'IN'))) {
                                if (round($shipping_total_volume_weight * 0.625, 2) > $shipping_total_weight) {
                                    $shipping_volume_weight_title = TEXT_WORD_VOLUME_WEIGHT;
                                    $shipping_volume_weight_alt = TEXT_WORD_VOLUME_WEIGHT_ALT;
                                    $shipping_volume_weight = $volume_weight;
                                    $shipping_weight = $shipping_total_weight = round($shipping_total_volume_weight * 0.625, 2);
                                    $shipping_package_box_weight_final = $shipping_package_box_weight_volume;
                                } else {
                                    $shipping_info['cal_volume'] = 0;
                                    $shipping_weight = $shipping_total_weight;
                                    $shipping_package_box_weight_final = $shipping_package_box_weight;
                                }
                            } else {
                                $shipping_volume_weight_title = TEXT_WORD_VOLUME_WEIGHT;
                                $shipping_volume_weight_alt = "";
                                $shipping_volume_weight = $volume_weight;
                                $shipping_weight = $shipping_total_volume_weight;
                                $shipping_package_box_weight_final = $shipping_package_box_weight_volume;
                            }
                        }

                        if ($code == 'cnezx') {
                            if ($shipping_total_volume_weight >= 12000 && round($shipping_total_volume_weight * 0.625, 2) > $shipping_total_weight && !in_array($this->country_iso2, array('ZA', 'IN'))) {

                                //$shipping_volume_weight_title = TEXT_WORD_VOLUME_WEIGHT_EMS;
                                $shipping_volume_weight_title = TEXT_WORD_VOLUME_WEIGHT;
                                $shipping_volume_weight_alt = TEXT_WORD_VOLUME_WEIGHT_ALT;
                                $shipping_volume_weight = $volume_weight;
                                $shipping_weight = $shipping_total_weight = round($shipping_total_volume_weight * 0.625, 2);
                                $shipping_package_box_weight_final = $shipping_package_box_weight_volume;
                            } else {
                                $shipping_info['cal_volume'] = 0;
                                $shipping_weight = $shipping_total_weight;
                                $shipping_package_box_weight_final = $shipping_package_box_weight;
                            }
                        }

                        if ($code == 'ozswbg') {
                            if ($shipping_total_volume_weight >= 5000) {

                                $shipping_volume_weight_title = TEXT_WORD_VOLUME_WEIGHT;
                                $shipping_volume_weight_alt = TEXT_WORD_VOLUME_WEIGHT_ALT;
                                $shipping_volume_weight = $volume_weight;
                                $shipping_weight = $shipping_total_volume_weight;
                                $shipping_package_box_weight_final = $shipping_package_box_weight_volume;
                            } else {
                                $shipping_info['cal_volume'] = 0;
                                $shipping_weight = $shipping_total_weight;
                                $shipping_package_box_weight_final = $shipping_package_box_weight;
                            }
                        }

                    }
                    $shipping_weight = round($shipping_weight, 2);
                } else {
                    $volume_weight = $weight;
                    $shipping_package_box_weight_final = round(($weight > 50000 ? $weight * 0.06 : $weight * 0.1), 2);
                    $show_weight = $airmail_weight = $weight - $shipping_package_box_weight;
                    $shipping_weight = $shipping_total_weight = round($weight, 2);
                }

                $shipping_weight_for_shipping_amount = $shipping_weight / 1000;
                //eof

                //bof 各种限制条件，zale
                /*if (in_array($shipping_code, array('hmey', 'airmail', 'hmjz', 'xxeub', 'bpost', 'bybpy')) && $_SESSION['cart']->in_cart(55800)) {//model 810013
                    continue;
                }*/
                //if(in_array($code, array('bybpy'))&&$_SESSION['cart']->in_cart('55800')){continue;}
                // 判断限制条件
                if (isset($shipping_postcode) && $shipping_postcode != '') {
                    if (!is_numeric($shipping_postcode)) {
                        $shipping_postcode = preg_replace('/[\s-]/', '', strtoupper($shipping_postcode));
                    }
                }
                if (isset($shipping_disable[$code])) {
                    foreach ($shipping_disable[$code] as $limit_result => $limit_info_array) {
                        foreach ($limit_info_array as $key => $limit_info) {
                            if ($limit_info['status'] == 10) {
                                if (isset($limit_info['postcode_from']) && ($shipping_postcode <= $limit_info['postcode_to'] && $limit_info['postcode_from'] <= $shipping_postcode) && (strlen($shipping_postcode) == strlen($limit_info['postcode_from']))) {
                                    if (isset($limit_info['country_iso_code_2'])) {
                                        if (isset($limit_info['products_id'])) {
                                            if (isset($limit_info['start_time']) && isset($limit_info['end_time'])) {//设置了邮编+国家+产品ID+时间
                                                if (in_array($this->country_iso2, explode(',', $limit_info['country_iso_code_2'])) && in_array($limit_info['products_id'], $_SESSION['cart']->products_products_checked)) {
                                                    if ($code == 'airmail') {
                                                        $error = true;
                                                    } else {
                                                        continue(3);
                                                    }
                                                }
                                            } else {//设置了邮编+国家+产品ID
                                                if (in_array($this->country_iso2, explode(',', $limit_info['country_iso_code_2'])) && in_array($limit_info['products_id'], $_SESSION['cart']->products_products_checked)) {
                                                    if ($code == 'airmail') {
                                                        $error = true;
                                                    } else {
                                                        continue(3);
                                                    }
                                                }
                                            }

                                        } elseif (isset($limit_info['start_time']) && isset($limit_info['end_time'])) {//设置了邮编+国家+时间
                                            if (in_array($this->country_iso2, explode(',', $limit_info['country_iso_code_2']))) {
                                                if ($code == 'airmail') {
                                                    $error = true;
                                                } else {
                                                    continue(3);
                                                }
                                            }
                                        } else {
                                            if (in_array($this->country_iso2, explode(',', $limit_info['country_iso_code_2']))) {//设置了邮编+国家
                                                if ($code == 'airmail') {
                                                    $error = true;
                                                } else {
                                                    continue(3);
                                                }
                                            }
                                        }

                                    } elseif (isset($limit_info['products_id'])) {
                                        if (isset($limit_info['start_time']) && isset($limit_info['end_time'])) {//设置了邮编+商品ID+时间
                                            if (in_array($limit_info['products_id'], $_SESSION['cart']->products_products_checked)) {
                                                if ($code == 'airmail') {
                                                    $error = true;
                                                } else {
                                                    continue(3);
                                                }
                                            }
                                        } else {
                                            if (in_array($limit_info['products_id'], $_SESSION['cart']->products_products_checked)) {//设置了邮编+商品ID
                                                if ($code == 'airmail') {
                                                    $error = true;
                                                } else {
                                                    continue(3);
                                                }
                                            }
                                        }
                                    } elseif (isset($limit_info['start_time']) && isset($limit_info['end_time'])) {//只设置了邮编+时间
                                        if ($code == 'airmail') {
                                            $error = true;
                                        } else {
                                            continue(3);
                                        }
                                    } else {
                                        if ($code == 'airmail') {
                                            $error = true;
                                        } else {
                                            continue(3);
                                        }
                                    }
                                } elseif (isset($limit_info['country_iso_code_2']) && (!isset($limit_info['postcode_from']))) {//
                                    if (isset($limit_info['products_id'])) {
                                        if (isset($limit_info['start_time']) && isset($limit_info['end_time'])) { // 设置了国家+商品id+时间
                                            if (in_array($this->country_iso2, explode(',', $limit_info['country_iso_code_2'])) && in_array($limit_info['products_id'], $_SESSION['cart']->products_products_checked)) {
                                                if ($code == 'airmail') {
                                                    $error = true;
                                                } else {
                                                    continue(3);
                                                }
                                            }
                                        } else { // 设置了国家 + 商品id
                                            if (in_array($this->country_iso2, explode(',', $limit_info['country_iso_code_2'])) && in_array($limit_info['products_id'], $_SESSION['cart']->products_products_checked)) {
                                                if ($code == 'airmail') {
                                                    $error = true;
                                                } else {
                                                    continue(3);
                                                }
                                            }
                                        }
                                    } else {
                                        if (isset($limit_info['start_time']) && isset($limit_info['end_time'])) { // 设置了国家+时间
                                            if (in_array($this->country_iso2, explode(',', $limit_info['country_iso_code_2']))) {
                                                if ($code == 'airmail') {
                                                    $error = true;
                                                } else {
                                                    continue(3);
                                                }
                                            }
                                        } else { // 只设置了国家
                                            if (in_array($this->country_iso2, explode(',', $limit_info['country_iso_code_2']))) {
                                                if ($code == 'airmail') {
                                                    $error = true;
                                                } else {
                                                    continue(3);
                                                }
                                            }
                                        }
                                    }
                                } elseif (isset($limit_info['products_id']) && (!isset($limit_info['country_iso_code_2'])) && (!isset($limit_info['postcode_from']))) {
                                    if (isset($limit_info['start_time']) && isset($limit_info['end_time'])) { // 设置了商品id+时间
                                        if (in_array($limit_info['products_id'], $_SESSION['cart']->products_products_checked)) {
                                            if ($code == 'airmail') {
                                                $error = true;
                                            } else {
                                                continue(3);
                                            }
                                        }
                                    } else { // 只设置了商品id
                                        if (in_array($limit_info['products_id'], $_SESSION['cart']->products_products_checked)) {
                                            if ($code == 'airmail') {
                                                $error = true;
                                            } else {
                                                continue(3);
                                            }
                                        }
                                    }
                                } else {
                                    if (isset($limit_info['start_time']) && isset($limit_info['end_time']) && !(isset($limit_info['products_id'])) && (!isset($limit_info['country_iso_code_2'])) && (!isset($limit_info['postcode_from']))) { // 设置时间
                                        if ($limit_info['display_status'] == 20) {
                                            $this->shipping_method_limit[$code] = $limit_info;
                                        } else {
                                            if ($code == 'airmail') {
                                                $error = true;
                                            } else {
                                                continue(3);
                                            }
                                        }
                                    }
                                    if (!isset($limit_info['start_time']) && !isset($limit_info['end_time']) && !(isset($limit_info['products_id'])) && (!isset($limit_info['country_iso_code_2'])) && (!isset($limit_info['postcode_from']))) {
                                        if ($code == 'airmail') {
                                            $error = true;
                                        } else {
                                            continue(3);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                if ($shipping_weight_for_shipping_amount > 30 && in_array($shipping_code, array('ubi'))) continue;    //ubi 重量不能大于 20
                if (in_array($shipping_code, array('hmdpd')) && $this->country_iso2 == 'IT' && $shipping_postcode == '08025') continue;//hmdpd不走意大利邮编为08025
                if (in_array($shipping_code, array('kdups', 'upssk', 'upskj', 'upsdh')) && $this->country_iso2 == 'RU') continue; //ups,xjpxb不走俄罗斯
                if (in_array($shipping_code, array('hmdpd', 'bybpy', 'bpost', 'hmey', 'hmfrexpr', 'hmmz'))) {
                    if ($this->country_iso2 == 'ES') {
                        if (($shipping_postcode >= 38000 && $shipping_postcode <= 38999) || ($shipping_postcode >= 35000 && $shipping_postcode <= 35999)) {
                            continue;
                        }
                    }
                }

                //disable Northwest Territories
                if ($_SESSION ["sendto"] > 0 && in_array($shipping_code, array('upssk', 'upskj'))) {
                    if ($this->check_disable_address($_SESSION ["sendto"], 'Northwest Territories,yellowknife')) continue;
                }
                //eof
                if ($shipping_info['min_weight_kg'] > 0 && $shipping_weight_for_shipping_amount < $shipping_info['min_weight_kg']) {
                    $error = true;
                }

                //bof 分包
                $max_weight = $db->Execute("Select shipping_weight
												   From " . TABLE_AREA_COUNTRY . ", " . TABLE_AREA_POSTAGE . "
												  Where country_iso_code_2 = '" . $this->country_iso2 . "'
												    And trans_type = '" . $shipping_id . "'
												    And country_area_id = postage_area_id
												    And postage_trans_type = '" . $shipping_id . "'
											   Order By shipping_weight desc limit 0, 1");
                if ($max_weight->RecordCount() == 1) {
                    $perbox_max_weight = $max_weight->fields['shipping_weight'];
                    if ($shipping_info['max_weight_kg'] > 0 && $shipping_info['max_weight_kg'] < $perbox_max_weight) {
                        $perbox_max_weight = $shipping_info['max_weight_kg'];
                    }
                } else {
                    $perbox_max_weight = 0;
                    $error = true;
                }

                if ($perbox_max_weight > 0 && !empty($shipping_weight_for_shipping_amount)) {
                    if ($shipping_info['split_type'] == 1 && ($shipping_weight_for_shipping_amount > $perbox_max_weight || (intval($shipping_info['package_type']) == 1 && $shipping_info['package_weight_kg'] > 0))) {
                        $shipping_num_boxes_volume = $perbox_weight_volume = 0;
                        if (intval($shipping_info['package_type']) == 1 && $shipping_info['package_weight_kg'] > 0 && $shipping_total_volume_weight > $shipping_total_weight) {
                            //Tianwen.Wan20170822->特别注意这里，显示的发包重量重新被赋值
                            $shipping_weight = $shipping_total_weight;
                            $shipping_package_box_weight_final = $shipping_package_box_weight;
                            $shipping_volume_weight = 0;

                            $shipping_num_boxes_volume = ceil($shipping_total_volume_weight / 1000 / $shipping_info['package_weight_kg']);
                            $perbox_weight_volume = $shipping_total_weight / 1000 / $shipping_num_boxes_volume;

                            $shipping_num_boxes = ceil($shipping_total_weight / 1000 / $perbox_max_weight);
                            $perbox_weight = $shipping_total_weight / 1000 / $shipping_num_boxes;

                            if ($shipping_num_boxes_volume > $shipping_num_boxes) {
                                $shipping_num_boxes = $shipping_num_boxes_volume;
                                $perbox_weight = $perbox_weight_volume;
                            }

                        } else {
                            $shipping_num_boxes = ceil($shipping_weight_for_shipping_amount / $perbox_max_weight);
                            $perbox_weight = $shipping_weight_for_shipping_amount / $shipping_num_boxes;
                        }
                        if ($shipping_num_boxes > 1) {
                            $shipping_box_note = '(' . TEXT_TOTAL_BOX_NUMBER . ': ' . $shipping_num_boxes . ')';
                        }
                    } else {
                        $shipping_num_boxes = 1;
                        $perbox_weight = $shipping_weight_for_shipping_amount;
                        //不分包、且当前重量大于最大重量，不显示这个方式
                        if ($shipping_info['split_type'] == 0 && $shipping_info['max_weight_kg'] > 0 && $shipping_info['max_weight_kg'] <= $shipping_weight_for_shipping_amount) {
                            $error = true;
                        }
                    }

                } else {
                    $perbox_weight = 0;
                    $error = true;
                }

                //eof

                $lds_pre_weight = $db->Execute("Select shipping_weight
										  From " . TABLE_AREA_COUNTRY . ", " . TABLE_AREA_POSTAGE . "
										 Where country_iso_code_2 = '" . $this->country_iso2 . "'
									       And trans_type = '" . $shipping_id . "'
									       And country_area_id = postage_area_id
									       And shipping_weight < " . $perbox_weight . "
									       And postage_trans_type = '" . $shipping_id . "'
									     Order By shipping_weight Desc limit 0, 1");
                if ($lds_pre_weight->RecordCount() == 0) {
                    $pre_weight = 0;
                } else {
                    $pre_weight = $lds_pre_weight->fields['shipping_weight'];
                }

                $lds_shipping = $db->Execute("Select shipping_amount, postage_add_type, postage_increment, postage_add_price
										   From " . TABLE_AREA_COUNTRY . ", " . TABLE_AREA_POSTAGE . "
										  Where country_iso_code_2 = '" . $this->country_iso2 . "'
										    And trans_type = '" . $shipping_id . "'
										    And country_area_id = postage_area_id
										    And shipping_weight >= '" . $perbox_weight . "'
										    And postage_trans_type = '" . $shipping_id . "'
									   Order By shipping_weight asc limit 0, 1");
                if ($lds_shipping->RecordCount() == 1) {
                    $shipping_amount = $lds_shipping->fields['shipping_amount'];
                    $add_type = $lds_shipping->fields['postage_add_type'];
                    $increment = $lds_shipping->fields['postage_increment'];
                    $add_price = $lds_shipping->fields['postage_add_price'];

                    if ($add_type == 0) {
                        $original_shipping_cost = $shipping_amount;
                    } elseif ($add_type == 1) {
                        $original_shipping_cost = $shipping_amount + $add_price * ceil(($perbox_weight - $pre_weight) / $increment);
                    } elseif ($add_type == 2) {
                        if ($increment == 0) {
                            $original_shipping_cost = $perbox_weight * $add_price;
                        } else {
                            $original_shipping_cost = ceil($perbox_weight / $increment) * $add_price;
                        }
                    } else {
                        $error = true;
                    }
                } else {
                    $error = true;
                }

                if ($original_shipping_cost <= 0) {
                    $error = true;
                }

                $is_remote = $this->check_remote_area($shipping_code, $this->country_iso2, $shipping_postcode, $shipping_city);
                $remote_fee = 0;
                if ($shipping_info['cal_remote'] && $is_remote) {
                    switch ($shipping_code) {
                        case 'cneth' :
                            $remote_fee = 10;
                            $remote_note .= sprintf(TEXT_SHIPPING_NOTE, 'CNE');
                            $_SESSION['hmdpd'] = true;
                            break;
                        case 'hmjz' :
                        case 'cnezx' :
                        case 'hmdpd' :
                            $remote_fee = 80;
                            $remote_note .= sprintf(TEXT_SHIPPING_NOTE, 'CNE');
                            break;
                        case 'kddhl' :
                        case 'kdups' :
                            $remote_fee = 220;
                            $remote_note .= sprintf(TEXT_SHIPPING_NOTE, 'DHL');
                            break;
                        case 'ywdhl' :
                        case 'ywdhl-dh' :
                        case 'xjpdhl' :
                            $remote_fee = $perbox_weight * 3.5 <= 160 ? 160 : $perbox_weight * 3.5;
                            $remote_note .= sprintf(TEXT_SHIPPING_NOTE, 'DHL');
                            break;
                        case 'kdfedex' :
                        case 'zyfedex' :
                        case 'ywfedex' :
                        case 'ywlbip' :
                        case 'xjplbip' :
                            $remote_fee = $perbox_weight * 3.7 <= 168 ? 168 : $perbox_weight * 3.7;
                            $remote_note .= sprintf(TEXT_SHIPPING_NOTE, 'FEDEX');
                            break;
                        case 'xjpupssk' :
                        case 'upssk' :
                        case 'upskj' :
                            $remote_fee = $perbox_weight * 3.5 <= 167 ? 167 : 3.5 * $perbox_weight;
                            $remote_note .= sprintf(TEXT_SHIPPING_NOTE, 'UPS');
                            break;
                    }

                    $remote_fee = $remote_fee * (1 + $fuel_rate) * $shipping_num_boxes / MODULE_SHIPPING_CHIANPOST_CURRENCY;
                    $remote_note .= '<font style="color:red; font-weight:bold;">' . $currencies->format($remote_fee) . '</font>)';
                }

                $shipping_cost = round($original_shipping_cost * (1 + $fuel_rate) * $discount + $extra_amt, 2);
                if ($shipping_code == 'ukeurline' && $perbox_weight >= 5) {
                    $shipping_cost += 70;
                }

                $shipping_cost = $shipping_cost * $shipping_num_boxes * $extra_times / MODULE_SHIPPING_CHIANPOST_CURRENCY + $remote_fee;
                $shipping_day = $this->get_shipping_day($shipping_info['code'], $this->country_iso2);
                switch ($code) {
                    case 'airmail':
                        $shipping_cost = MODULE_SHIPPING_AIRMAIL_ARGUMENT * $discount / 1000 * $airmail_weight * 1.1 / MODULE_SHIPPING_CHIANPOST_CURRENCY;
                        break;
                }

                //增值税
                /* if ($code == 'ywdhl' || $code == 'ywdhl-dh') {
                    $shipping_cost *= 1.06;
                } */

                $is_display = 1;
                if (!empty($shipping_display_method)) {
                    if (!in_array($shipping_id, $shipping_display_method)) {
                        $is_display = 0;
                    }
                }
                if ($shipping_info['code'] == 'agent' && ($this->country_iso2 == 'CN' || $this->country_iso2 == 'RU')) {
                    $shipping_num_boxes = 1;
                    $error = false;
                }

                $this->cal_result[$code] = array(
                    'id' => $shipping_id,
                    'code' => $shipping_code,
                    'is_remote' => $is_remote,
                    'name' => $shipping_info['name'],
                    'title' => $shipping_info['title'],
                    'box' => $shipping_num_boxes,
                    'day_low' => $shipping_day['day_low'],
                    'day_high' => $shipping_day['day_high'],
                    'days' => $shipping_day['day_low'] . '-' . $shipping_day['day_high'],
                    'cost' => $shipping_cost,
                    'box_note' => $shipping_box_note,
                    'remote_note' => $remote_note,
                    'remote_fee' => $remote_fee,
                    'volume_note' => $volume_note,
                    'track_url' => $shipping_info['track_url'],
                    'error' => $error,
                    'shipping_package_box_weight' => $shipping_package_box_weight_final,
                    'shipping_weight' => $shipping_weight,
                    'shipping_volume_weight_title' => $shipping_volume_weight_title,
                    'shipping_volume_weight_alt' => $shipping_volume_weight_alt,
                    'shipping_volume_weight' => $shipping_volume_weight,
                    'time_unit' => $shipping_info['time_unit'],
                    'is_display' => $is_display
                );
            }

        }

        if ($this->country_iso2 != '' && $shipping_postcode != '') {
            require_once(DIR_WS_CLASSES . 'shipping_virtual.php');
            $shipping_virtual = new shipping_virtual($weight, $this->country_iso2, $shipping_state, $shipping_city, $shipping_postcode);

            $this->virtual_result = $shipping_virtual->get_method();

            $this->cal_result = array_merge($this->cal_result, $this->virtual_result);
        }
    }

    function disable($disable_str, $str)
    {
        if ($disable_str != '' && $str != '') {
            $disable_arr = explode(';', strtoupper($disable_str));
            return in_array(strtoupper($str), $disable_arr);
        } else {
            return false;
        }
    }

    function check_disable_address($address_id, $disable_content)
    {
        global $db;
        //	lvxiaoyong20141111 记录到global，减少重复查询
        if (isset($GLOBALS['g_check_disable_address'][$address_id])) {
            $address_query = $GLOBALS['g_check_disable_address'][$address_id];
        } else {
            $address_query = $db->Execute("select entry_city, entry_state from " . TABLE_ADDRESS_BOOK . " where address_book_id='" . $address_id . "'");
            $GLOBALS['g_check_disable_address'][$address_id] = $address_query;
        }

        $disable_content = str_replace(array(' ', ' '), array('', ''), strtolower($disable_content));
        $address_array = explode(',', $disable_content);
        foreach ($address_array as $val) {
            $address_query->fields['entry_city'] = str_replace(array(' ', ' '), array('', ''), strtolower($address_query->fields['entry_city']));
            $address_query->fields['entry_state'] = str_replace(array(' ', ' '), array('', ''), strtolower($address_query->fields['entry_state']));
            if (stristr($address_query->fields['entry_city'], $val) || stristr($address_query->fields['entry_state'], $val) || $address_query->fields['entry_city'] == $val || $address_query->fields['entry_state'] == $val) {
                return true;
            }
        }
        return false;
    }

    function check_remote_area($shipping_code, $country_iso2, $postcode, $city)
    {
        global $db;
        if (empty($postcode) && empty($city)) {
            return false;
        }
        $sento = isset ($_SESSION ["sendto"]) ? $_SESSION ["sendto"] : 0;
        $is_remote = false;
        $group_sql = "select group_code from " . TABLE_REMOTE_SHIPPING_CODE_GROUP . " where shipping_code=:shipping_code";
        $group_sql = $db->bindVars($group_sql, ':shipping_code', $shipping_code, 'string');
        $group_result = $db->Execute($group_sql);
        if ($group_result->RecordCount() > 0) {
            $is_remote = get_trans_remote($sento, $group_result->fields['group_code'], $country_iso2, $postcode, $city);
        }
        return $is_remote;
    }

    function reduce_airmail_cost()
    {
        global $order;
        $free_shipping_cart_min = 0;
        $this->special_result = $shipping_previous = $shipping_next = $shipping_list = array();
        $airmail_cost = 0;
        $this->cal_result = $this->array_sort($this->cal_result, 'cost');
//去掉以airmail作为基准运费的逻辑 20200330
//        if (isset($this->cal_result['airmail']) && $this->cal_result['airmail']['error'] == false) {
//            $airmail_cost = $this->cal_result['airmail']['cost'];
//            $this->airmail_result = $this->cal_result['airmail'];
//        } elseif (!empty($this->cal_result)) {
            foreach ($this->cal_result as $cal_result_key => $cal_result_value) {
                if (strstr(MODULE_SHIPPING_NOT_BASE_FREESHIPPING_CODE, "," . $cal_result_key . ",") != "") {
                    continue;
                }
                if ( $cal_result_value['error'] == false) {//$cal_result_key == 'airmail' ||
                    array_push($shipping_list, $cal_result_value);
                }
            }
            //换成以最便宜的运输方式为基准运费
            $airmail_cost = $shipping_list[0]['cost'];
            $this->airmail_result = $shipping_list[0];

            //Tianwen.Wan20170508->获取最运费最接近的一个配送方式的运费(先取运费较小的，再取运费较大的)
//            $airmail_position = -1;
//            foreach ($shipping_list as $shipping_list_key => $shipping_list_value) {
//                if ($shipping_list_value['code'] == 'airmail') {
//                    $airmail_position = $shipping_list_key;
//                }
//            }
//            if ($airmail_position > -1) {
//                $airmail_position_a = $airmail_position + 1;
//                $airmail_cost_a = $shipping_list[$airmail_position_a]['cost'];
//                $airmail_result_a = $shipping_list[$airmail_position_a];
//
//                $airmail_position_b = $airmail_position - 1;
//                $airmail_cost_b = $shipping_list[$airmail_position_b]['cost'];
//                $airmail_result_b = $shipping_list[$airmail_position_b];
//
//
//                $airmail_cost = $airmail_cost_b;
//                $this->airmail_result = $airmail_result_b;
//                if ($this->airmail_result == null) {
//                    $airmail_cost = $airmail_cost_a;
//                    $this->airmail_result = $airmail_result_a;
//                }
//            }
//        }

        /*
        if($_SERVER['PHP_SELF']=='/ajax_login.php'){
            $shopping_cart_total = 20;
        }else{
            $shopping_cart_total = $_SESSION['cart']->show_total();
        }
        */
        $shopping_cart_total = $_SESSION['cart']->show_total();

        foreach ($this->cal_result as $key => $val) {
            if ($val['code'] == 'agent') {
                $this->reduce_result[$key] = $val;
                $this->reduce_result[$key]['final_cost'] = 0;
                continue;
            }
            if (!$val['error']) {
                $this->reduce_result[$key] = $val;
                if ($airmail_cost >= $val['cost']) {
                    if ($shopping_cart_total >= $free_shipping_cart_min) {
                        $this->reduce_result[$key]['final_cost'] = 0;
                    } else {
                        $this->reduce_result[$key]['final_cost'] = $val['cost'] < 2.99 ? 2.99 : $val['cost'];
                    }
                    if ($airmail_cost > $val['cost'] && $val['cost'] > 0 && $shopping_cart_total >= $free_shipping_cart_min) {
                        $discount = $airmail_cost - $val['cost'];
                        if ($_SESSION['cart']->promotion_weight() > 0 && !$_POST['weight']) {
                            $discount = $discount * (1 - $_SESSION['cart']->promotion_weight() / $_SESSION['cart']->show_weight());
                        }
                        //bof 由于航空小包运费上涨,返回金额改为原来返回金额的85%; by zale 20130619
                        //change to 0.77, by zale 20131101
                        //change to 0.70, by tianwen.wan 20150918
                        //change to 0.50, by tianwen.wan 20171124(运费返还比例)
                        if ($order->info['subtotal'] > 0) {
                            $this->special_result[$key] = $discount * 0.50;
                        }
                        //eof
                    }
                } else {
                    if ($shopping_cart_total >= $free_shipping_cart_min) {
                        $final = $val['cost'] - $airmail_cost;
                    } else {
                        $final = $val['cost'] < 2.99 ? 2.99 : $val['cost'];
                    }
                    $this->reduce_result[$key]['final_cost'] = $final;
                }
            }
        }

        $this->reduce_result = $this->array_sort($this->reduce_result, 'final_cost');
    }

    function array_sort($sort_array, $sort_by = 'cost', $sort = 'asc', $sort_by_then = 'day_low')
    {
        $keysvalue = $new_array = array();
        foreach ($sort_array as $k => $v) {
            $keysvalue [$k] = round($v [$sort_by], 4) * 10000 + $v [$sort_by_then] * 100;
        }
        if ($sort == 'asc') {
            asort($keysvalue);
        } elseif ($sort == 'desc') {
            arsort($keysvalue);
        }
        reset($keysvalue);
        foreach ($keysvalue as $k => $v) {
            $new_array [$k] = $sort_array [$k];
        }
        return $new_array;
    }

    /**
     * lvxiaoyong 取所有运送方式，不限制状态
     */
    public function get_all_shipping()
    {
        global $db;
        $shipping = $db->Execute('select * from ' . TABLE_SHIPPING);
        if ($shipping->RecordCount() > 0) {
            while (!$shipping->EOF) {
                $shipping_day = $this->get_shipping_day($shipping->fields['code']);
                $shipping_title = $this->get_shipping_title($shipping->fields['id']);

                $shipping->fields['title'] = $shipping_title;
                $shipping->fields['days'] = $shipping_day['day_low'] . '-' . $shipping_day['day_high'];
                $this->all_shipping_method[$shipping->fields['code']] = $shipping->fields;
                $shipping->MoveNext();
            }
        }
    }

    function get_default_shipping_info($customers_info = array('customers_id' => 0, 'countries_iso_code_2' => "", 'address_book_id' => 0, 'weight' => "", 'postcode' => "", 'city' => ""))
    {
        global $db, $currencies, $order;

        $shipping_list = $this->reduce_result;
        $special_discount = $this->special_result;

        $shipping_info_cheapest = $shipping_info_return = $this->cheapest();
        $last_shipping_code = $shipping_code_default = "";

        //xin tui jian gui ze 20181226
        if (!empty ($customers_info) && isset ($customers_info['customers_id']) && $customers_info['customers_id'] > 0) {
            if (isset($_SESSION['is_old_customers']) && $_SESSION['is_old_customers'] == 1) {
                if (isset($_SESSION['customers_default_shipping']) && !empty($_SESSION['customers_default_shipping'])) {
                    $shipping_code_explode = explode("_", $_SESSION['customers_default_shipping']);
                    $customers_default_shipping = $shipping_code_explode[0];

                    if (in_array($customers_default_shipping, $this->kd_shipping_array)) {
                        $last_shipping_code = zen_customer_has_valid_order();
                        if (!empty($last_shipping_code) && $shipping_list[$shipping_code_default]['error'] == false) {
                            $shipping_code_default = $last_shipping_code;
                        }
                    } else {
                        if ($this->toatl_shipping_weight <= 500) {
                            $shipping_code_default = $this->search_virtual_shipping_method();
                        }
                    }
                }
            } else {
                if (isset($_SESSION['customers_default_shipping']) && !empty($_SESSION['customers_default_shipping'])) {
                    $shipping_code_explode = explode("_", $_SESSION['customers_default_shipping']);
                    $customers_default_shipping = $shipping_code_explode[0];
                    $shipping_code_default = $customers_default_shipping;

                    if ($this->toatl_shipping_weight <= 500) {
                        $shipping_code_default = $this->search_virtual_shipping_method();
                    }
                }
            }
        }

        if (!empty($_SESSION['estimate_method'])) {
            $shipping_code_default = $_SESSION['estimate_method'];
        }

        if (isset($shipping_list[$shipping_code_default]) && $shipping_list[$shipping_code_default]['error'] == false) {
            $shipping_info_return = $shipping_list[$shipping_code_default];
        }

        $display_note = ($shipping_info_return['box_note'] != '' && $shipping_info_return['remote_note'] != '' ? $shipping_info_return['box_note'] . '<br>' . $shipping_info_return['remote_note'] : $shipping_info_return['box_note'] . $shipping_info_return['remote_note']);
        $display_note = $shipping_info_return['box_note'] == '' && $shipping_info_return['remote_note'] == '' ? '' : $display_note;
        if ($special_discount[$shipping_info_return['code']]) {
            $cost_show = '-' . $currencies->format($special_discount[$shipping_info_return['code']]);
            $special_cost = '-' . $currencies->format($special_discount[$shipping_info_return['code']]);
        } else {
            $cost_show = ($shipping_info_return['final_cost'] <= 0 ? TEXT_FREE_SHIPPING : $currencies->format($shipping_info_return['final_cost']));
        }

        $time_unit = TEXT_DAYS_LAN;
        if ($shipping_info_return['time_unit'] == 20) {
            $time_unit = TEXT_WORKDAYS;
        }
        $shipping_info_return['days_show'] = $shipping_info_return['days'] . ' ' . $time_unit;
        $shipping_info_return['cost_show'] = $cost_show;
        //$shipping_info_return['final_cost'] = $final_cost;
        $shipping_info_return['show_note'] = $display_note;
        $shipping_info_return['special_cost'] = $special_cost;
        $shipping_info_return['id'] = $shipping_info_return['code'] . "_" . $shipping_info_return['code'];
        $_SESSION['shipping'] = $shipping_info_return;

        $datas = array(
            'shipping_list' => $shipping_list,
            'special_discount' => $special_discount,
            'shipping_info' => $shipping_info_return
        );

        return $datas;
    }

    /*
    * 得到默认配送方式列表和选中配送方式
    * @param array $customers_info
    * @return array
    */

    function cheapest()
    {
        $cheapest = array();
        foreach ($this->reduce_result as $shipping => $value) {
            if (!$value['error'] && $value['code'] != 'agent' || in_array($this->country_iso2, array('CN'))) {
                if (!zen_not_null($cheapest)) {
                    $cheapest = $value;
                } else {
                    /*if ($cheapest['final_cost'] * 1000 + $cheapest['day_low'] > $value['final_cost'] * 1000 + $value['day_low']){
                        $cheapest = $value;
                    }*/
                    if ($cheapest['final_cost'] == $value['final_cost']) {
                        if ($cheapest['day_low'] == $value['day_low']) {
                            if ($cheapest['day_high'] > $value['day_high']) {
                                $cheapest = $value;
                            }
                        } elseif ($cheapest['day_low'] > $value['day_low']) {
                            $cheapest = $value;
                        }
                    } elseif ($cheapest['final_cost'] > $value['final_cost']) {
                        $cheapest = $value;
                    }
                }
            }
        }
        return $cheapest;
    }

    function search_virtual_shipping_method()
    {
        $recommend_virtualcode = '';
        $shipping_list = $this->virtual_result;
        $shipping_list = $this->array_sort($shipping_list, 'final_cost', 'asc', 'days');
        $recommend_virtual = array_pop($shipping_list);
        $recommend_virtualcode = $recommend_virtual['code'];
        return $recommend_virtualcode;
    }

}

?>