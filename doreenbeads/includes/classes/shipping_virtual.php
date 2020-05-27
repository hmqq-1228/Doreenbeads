<?php 
class shipping_virtual extends base {
    private $virtual_cal_result = array();
    private $country_iso2 = '';
    private $shipping_postcode  = '';
    private $shipping_city  = '';
    private $shipping_state  = '';
    public $shipping_method_limit;
    public $shipping_method_limit_description;
    private $all_virtual_shipping_method = array();
    
    function __construct( $weight = '', $country_iso2 = '', $state = '', $city = '', $postcode = ''){
        global $db;
        
        $this->quote($weight, $country_iso2, $state, $city, $postcode);
    }
    
    function get_method(){
        return $this->virtual_cal_result;
    }
    private function quote( $weight = '', $country_iso2 = '', $state = '', $city = '', $postcode = ''){
        global $order, $db, $currencies;
        
        $this->country_iso2 = ($country_iso2 != '' ? $country_iso2 : $order->delivery['country']['iso_code_2']);
        $this->shipping_postcode = ($postcode != '' ? $postcode : $order->delivery['postcode']);
        $this->shipping_city = ($city != '' ? $city : $order->delivery['city']);
        $this->shipping_state = ($state != '' ? $state : $order->delivery['state']);
        
        $virtual_shipping_group_query = 'select vsg.shipping_group_id, group_description, shipping_erp_id_group from '
                                        . TABLE_VIRTUAL_SHIPPING_GROUP . ' vsg inner join ' . TABLE_VIRTUAL_SHIPPING_GROUP_DESCRIPTION . ' vsgd
                                         on vsg.shipping_group_id = vsgd.shipping_group_id
                                         where group_status = 10 and vsgd.language_id = ' . $_SESSION['languages_id'] . ' and vsg.country_code ="' . $this->country_iso2 . '"';
        $virtual_shipping_group = $db->Execute($virtual_shipping_group_query);
        
        if($virtual_shipping_group->RecordCount() > 0){
            while (!$virtual_shipping_group->EOF){
                $shipping_group_id = $virtual_shipping_group->fields['shipping_group_id'];
                $group_name = $virtual_shipping_group->fields['group_description'];
                $shipping_erp_id_group = $virtual_shipping_group->fields['shipping_erp_id_group'];
                $shipping_erp_id_group_array = explode(',', $shipping_erp_id_group);
                $shipping_method_array = array();
                
                $erp_str_array = array();
                foreach ($shipping_erp_id_group_array as $values){
                    $erp_str_array[] = '"' . $values . '"';
                }
                $erp_str = implode(',', $erp_str_array);
                
                if($erp_str != '' && $this->shipping_postcode != ''){
                    $virtual_shipping_area_query = 'SELECT
                                                        vs.shipping_id,
                                                    	vs.shipping_code,
                                                    	vs.shipping_erp_id,
                                                    	vs.shipping_fuel_surcharge,
                                                        vs.shipping_vat,
                                                    	vs.shipping_discount,
                                                    	vs.cal_remote,
                                                    	vs.cal_weight_type,
                                                    	vs.remote_guideline,
                                                        vs.remote_cal_type,
                                                    	vs.remote_fee,
                                                        vs.remote_min_fee,
                                                    	vs.limit_split,
                                                    	vs.track_url,
                                                    	vsap.shipping_area_code,
                                                    	vsap.shipping_singlepiece_limit,
                                                    	vsap.shipping_singleticket_limit,
                                                    	vsap.shipping_transport_min,
                                                    	vsap.shipping_transport_max
                                                    FROM
                                                        ' . TABLE_VIRTUAL_SHIPPING_AREA_POSTCODE . ' vsap
                                                    INNER JOIN ' . TABLE_VIRTUAL_SHIPPING . ' vs ON vsap.shipping_id = vs.shipping_id
                                                    WHERE
                                                        vs.shipping_erp_id in (' . $erp_str . ')
                                                    AND vsap.shipping_post_code_start <= "' . $this->shipping_postcode . '"
                                                    AND vsap.shipping_post_code_end >= "' . $this->shipping_postcode . '"
                                                    AND vs.shipping_status = 10
                                                    AND vs.country_code = "' . $this->country_iso2 . '"
                                                    ORDER BY shipping_area_code asc';
                    
                    $virtual_shipping_area = $db->Execute($virtual_shipping_area_query);
                    
                    $virtual_shipping_array = array();
                    while(!$virtual_shipping_area->EOF){
                        $shipping_code = $virtual_shipping_area->fields['shipping_code'];
                        $virtual_shipping_array[$shipping_code] = $virtual_shipping_area->fields;
                        
                        $virtual_shipping_area->MoveNext();
                    }
                }
                if(sizeof($virtual_shipping_array) > 0){
                    foreach ($virtual_shipping_array as $code => $shipping_info){
                        $error = false;
                        $shipping_volume_weight = $shipping_package_box_weight_final = $shipping_package_box_weight = $shipping_package_box_weight_volume = 0;
                        $shipping_box_note = $shipping_volume_weight_title = $shipping_volume_weight_alt = $remote_note = $volume_note = "";
                        
                        $shipping_id = $shipping_info['shipping_id'];
                        $shipping_code = $shipping_info['shipping_code'];
                        $shipping_erp_id = $shipping_info['shipping_erp_id'];
                        $shipping_area_code = $shipping_info['shipping_area_code'];
                        $fuel_rate = $shipping_info['shipping_fuel_surcharge'];
                        $shipping_vat = $shipping_info['shipping_vat'];
                        $shipping_discount = $shipping_info['shipping_discount'];
                        $cal_remote = $shipping_info['cal_remote'];
                        $cal_weight_type = $shipping_info['cal_weight_type'];
                        $remote_guideline = $shipping_info['remote_guideline'];
                        $remote_cal_type = $shipping_info['remote_cal_type'];
                        $remote_fee_unit = $shipping_info['remote_fee'];
                        $remote_min_fee = $shipping_info['remote_min_fee'];
                        $limit_split = $shipping_info['limit_split'];
                        $track_url = $shipping_info['track_url'];
                        //单票限重
                        $shipping_singlepiece_limit = $shipping_info['shipping_singlepiece_limit'];
                        //单件限重
                        $shipping_singleticket_limit = $shipping_info['shipping_singleticket_limit'];
                        $shipping_transport_min = $shipping_info['shipping_transport_min'];
                        $shipping_transport_max = $shipping_info['shipping_transport_max'];
                        
                        if(empty($weight)){
                            $show_weight = $_SESSION['cart']->show_weight();
                            $volume_weight = round($_SESSION['cart']->show_volume_weight(), 2);
                            $package_box_weight = $_SESSION['cart']->show_shipping_package_box_weight_virtual($cal_weight_type);
                        }else{
                            $show_weight = $volume_weight = $weight;
                            $package_box_weight = $weight * 0.1;
                        }
                        
                        switch ($cal_weight_type){
                            case 10:
                                $shipping_weight = $show_weight;
                                $volume_weight = 0;
                                break;
                            case 20:
                                $shipping_weight = $volume_weight;
                                break;
                            case 30:
                                $shipping_weight = max($show_weight, $volume_weight);
                                break;
                            default:
                                $error = true;
                                continue;
                        }
                        
                        $shipping_weight += $package_box_weight;
                        $shipping_weight_kg = $shipping_weight / 1000;
                        $first_part_shipping_fee = ($shipping_weight_kg  * VIRTUAL_SHIPPING_PRE_FEE) / MODULE_SHIPPING_CHIANPOST_CURRENCY;
                        
                        $perbox_max_weight_sql = 'SELECT
                                                        MAX(shipping_incremental_weight) max_weight
                                                    FROM
                                                        ' . TABLE_VIRTUAL_SHIPPING_AREA_POSTAGE . '
                                                    WHERE
                                                        shipping_code = "' . $shipping_code . '"';
                        $perbox_max_weight_query = $db->Execute($perbox_max_weight_sql);
                        
                        if($perbox_max_weight_query->RecordCount() > 0){
                            $perbox_max_weight = $perbox_max_weight_query->fields['max_weight'];
                            
                            if($shipping_singleticket_limit > 0 && $perbox_max_weight > 0 && $perbox_max_weight > $shipping_singleticket_limit){
                                $perbox_max_weight = $shipping_singleticket_limit;
                            }
                        }else{
                            $error = true;
                            continue;
                        }
                        
                        if($shipping_weight_kg > 0 && $perbox_max_weight > 0){
                            if(!($limit_split == 20 && $shipping_weight_kg > $perbox_max_weight)){
                                if($shipping_weight_kg > $perbox_max_weight){
                                    $shipping_num_boxes = ceil($shipping_weight_kg / $perbox_max_weight);
                                    $perbox_max_weight = $shipping_weight_kg / $shipping_num_boxes;
                                }else{
                                    $shipping_num_boxes = 1;
                                    $perbox_max_weight = $shipping_weight_kg;
                                }
                                
                                if($shipping_num_boxes > 1) {
                                    $shipping_box_note = '(' . TEXT_TOTAL_BOX_NUMBER . ': ' . $shipping_num_boxes . ')';
                                }
                            }else{
                                $error = true;
                                continue;
                            }
                        }else{
                            $error = true;
                            continue;
                        }
                        
                        //前一个梯度重量
                        $pre_weight_sql = 'SELECT
                                               shipping_incremental_weight
                                           FROM
                                           ' . TABLE_VIRTUAL_SHIPPING_AREA_POSTAGE . '
                                           WHERE
                                            shipping_incremental_weight < ' . $perbox_max_weight . '
                                           AND shipping_code = "' . $shipping_code . '"
                                           AND shipping_area_code = "' . $shipping_area_code . '"
                                           ORDER BY shipping_incremental_weight desc
                                           limit 1';
                        $pre_weight_query = $db->Execute($pre_weight_sql);
                        
                        if($pre_weight_query->RecordCount() == 0){
                            $pre_weight = 0;
                        }else{
                            $pre_weight = $pre_weight_query->fields['shipping_incremental_weight'];
                        }
                        
                        $shipping_postage_query = 'SELECT
                                                       shipping_amount,
                                                       shipping_incremental_price,
                                                       shipping_incremental_type,
                                                       shipping_incremental_unit,
                                                       shipping_incremental_weight
                                                   FROM
                                                       t_virtual_shipping_area_postage
                                                   WHERE
                                                       shipping_code = "' . $shipping_code . '"
                                                   AND shipping_area_code = "' . $shipping_area_code . '"
                                                   AND shipping_incremental_weight >= ' . $perbox_max_weight . '
                                                   ORDER BY shipping_incremental_weight asc
                                                   limit 1';
                        $shipping_postage = $db->Execute($shipping_postage_query);
                        
                        if($shipping_postage->RecordCount() > 0){
                            $shipping_amount = $shipping_postage->fields['shipping_amount'];
                            $shipping_incremental_price = $shipping_postage->fields['shipping_incremental_price'];
                            $shipping_incremental_type = $shipping_postage->fields['shipping_incremental_type'];
                            $shipping_incremental_unit = $shipping_postage->fields['shipping_incremental_unit'];
                            
                            if ($shipping_incremental_type == 0){
                                $original_shipping_cost = $shipping_amount;
                            }elseif ($shipping_incremental_type == 1){
                                $original_shipping_cost = $shipping_amount + $shipping_incremental_price * ceil(($perbox_max_weight - $pre_weight) / $shipping_incremental_unit);
                            }elseif($shipping_incremental_type == 2){
                                if ($shipping_incremental_unit == 0) {
                                    $original_shipping_cost = $perbox_max_weight * $shipping_incremental_price;
                                }else{
                                    $original_shipping_cost = ceil($perbox_max_weight / $shipping_incremental_unit) * $shipping_incremental_price;
                                }
                            }else{
                                continue;
                                $error = true;
                            }
                        }else{
                            $error = true;
                            continue;
                        }
                        
                        if ($original_shipping_cost <= 0) {
                            $error = true;
                            continue;
                        }
                        
                        $remote_fee = 0;
                        $remote_fee_usd = 0;
                        $is_remote = false;
                        if($cal_remote == 10){
                            $is_remote = $this->check_virtual_remote_area($shipping_erp_id, $remote_guideline, $this->country_iso2, $this->shipping_state, $this->shipping_city, $this->shipping_postcode);
                            
                            if($is_remote){
                                if($remote_guideline == 10){
                                    switch ($remote_cal_type){
                                        case '20':
                                            $remote_fee_head = ($shipping_weight_kg + 1) * $remote_fee_unit;
                                            
                                            $remote_fee_head = max($remote_fee_head, $remote_min_fee);
                                            break;
                                        case '30':
                                            $remote_fee_head = $remote_min_fee;
                                            break;
                                        default:
                                            $remote_fee_head = 0;
                                            break;
                                    }
                                    
                                    $remote_fee = ($remote_fee_head * (1 + ($fuel_rate / 100) )) * (1 +  ($shipping_vat / 100));
                                }else{
                                    $remote_fee = $remote_min_fee * (1 +  ($shipping_vat / 100));
                                }

                                if($remote_fee > 0){
                                    $remote_fee = $remote_fee * $shipping_num_boxes;
                                    $remote_fee_usd = $remote_fee / MODULE_SHIPPING_CHIANPOST_CURRENCY;
                                    $remote_note = sprintf(TEXT_SHIPPING_NOTE, $group_name);
                                    $remote_note .= '<span style="color:red; font-weight:bold;">' . $currencies->format($remote_fee_usd) . '</span>)';
                                }
                            }
                        }

//                        $remote_note .= TEXT_SHIPPING_VIRTUAL_COUPON_ACTIVITY;

                        $fuel_fee = ($original_shipping_cost + $remote_fee) * ($fuel_rate / 100);
                        $last_part_shipping_fee = ((($original_shipping_cost + $fuel_fee) * ($shipping_discount / 100)) * $shipping_num_boxes  + $remote_fee) / MODULE_SHIPPING_CHIANPOST_CURRENCY;
                        
                        $shipping_fee = $first_part_shipping_fee + $last_part_shipping_fee;

                        // 运输方式限制新增数据表查询20160309 feiyao
                        $shipping_method_restriction_sql = 'select smr.shipping_method, smr.products_id, smr.country_iso_code_2, smr.limit_result, smr.postcode_from, smr.postcode_to, smr.start_time, smr.end_time, smrr.display_status, smr.status from ' . TABLE_SHIPPING_METHOD_RESTRICTION .' smr, '.TABLE_SHIPPING_METHOD_RESTRICTION_RESULT.' smrr where smr.limit_result = smrr.limit_result';
                        $shipping_method_restriction = $db->Execute ( $shipping_method_restriction_sql );
                        if ($shipping_method_restriction->RecordCount() > 0) {
                            while ( ! $shipping_method_restriction->EOF ) {
                                $shipping_method_restriction_array[] = array (
                                    'shipping_method' => $shipping_method_restriction->fields['shipping_method'],
                                    'products_id' => $shipping_method_restriction->fields['products_id'],
                                    'country_iso_code_2' => $shipping_method_restriction->fields['country_iso_code_2'],
                                    'limit_result' =>$shipping_method_restriction->fields['limit_result'],
                                    'start_time' => $shipping_method_restriction->fields['start_time'],
                                    'end_time' => $shipping_method_restriction->fields['end_time'],
                                    'display_status' => $shipping_method_restriction->fields['display_status'],
                                    'status'=>$shipping_method_restriction->fields['status'],
                                    'postcode_from'=>$shipping_method_restriction->fields['postcode_from'],
                                    'postcode_to'=>$shipping_method_restriction->fields['postcode_to']
                                );
                                $shipping_method_restriction->MoveNext();
                            }
                        }

                        $shipping_disable = array();
                        $index_limit = 0;

                        foreach($shipping_method_restriction_array as $key => $value) {
                            if(isset($value['start_time']) && isset($value['end_time']) && $value['start_time'] > '1900-00-00 00:00:00') {
                                if ($value['start_time'] < date('Y-m-d H:i:s') && $value['end_time'] > date('Y-m-d H:i:s')) {
                                    $shipping_disable[$value['shipping_method']][$value['limit_result']][$index_limit]['start_time'] = $value['start_time'];
                                    $shipping_disable[$value['shipping_method']][$value['limit_result']][$index_limit]['end_time'] = $value['end_time'];
                                }else{
                                    continue;
                                }
                            }
                            if(!empty($value['country_iso_code_2'])) {
                                $shipping_disable[$value['shipping_method']][$value['limit_result']][$index_limit]['country_iso_code_2'] = $value['country_iso_code_2'];
                            }
                            if(!empty($value['products_id'])) {
                                $shipping_disable[$value['shipping_method']][$value['limit_result']][$index_limit]['products_id'] = $value['products_id'];
                            }
                            if(isset($value['postcode_from']) && isset($value['postcode_to']) && $value['postcode_from']!=''){
                                $shipping_disable[$value['shipping_method']][$value['limit_result']][$index_limit]['postcode_from'] = preg_replace('/[\s-]/','',$value['postcode_from']);
                                $shipping_disable[$value['shipping_method']][$value['limit_result']][$index_limit]['postcode_to'] = preg_replace('/[\s-]/','',$value['postcode_to']);
                            }

                            if(!empty($value['display_status'])) {
                                $shipping_disable[$value['shipping_method']][$value['limit_result']][$index_limit]['display_status'] = $value['display_status'];
                                $shipping_disable[$value['shipping_method']][$value['limit_result']][$index_limit]['limit_result'] = $value['limit_result'];
                            }
                            if(!empty($value['display_status'])) {
                                $shipping_disable[$value['shipping_method']][$value['limit_result']][$index_limit]['display_status'] = $value['display_status'];
                                $shipping_disable[$value['shipping_method']][$value['limit_result']][$index_limit]['limit_result'] = $value['limit_result'];
                            }

                            if(!empty($value['status'])) {
                                $shipping_disable[$value['shipping_method']][$value['limit_result']][$index_limit]['status'] = $value['status'];
                            }
                            $index_limit++;
                        }

                        $shipping_method_restriction_deccription_sql = 'select smrrd.limit_result, smrrd.language_id, smrrd.comment from '. TABLE_SHIPPING_METHOD_RESTRICTION_RESULT_DESCRIPTION .' smrrd, '. TABLE_SHIPPING_METHOD_RESTRICTION_RESULT .' smrr where smrrd.limit_result = smrr.limit_result and smrr.display_status = 20 ' ;
                        $shipping_method_restriction_deccription = $db->Execute ( $shipping_method_restriction_deccription_sql );
                        if ($shipping_method_restriction_deccription->RecordCount() > 0) {
                            while ( ! $shipping_method_restriction_deccription->EOF ) {
                                $shipping_method_restriction_deccription_array[$shipping_method_restriction_deccription->fields['limit_result']][$shipping_method_restriction_deccription->fields['language_id']] = $shipping_method_restriction_deccription->fields['comment'];
                                $shipping_method_restriction_deccription->MoveNext();
                            }
                        }
                        $this->shipping_method_limit_description = $shipping_method_restriction_deccription_array;

                        if (isset($shipping_disable[$code])) {
                            foreach ($shipping_disable[$code]as $limit_result => $limit_info_array) {
                                foreach ($limit_info_array as $key => $limit_info) {
                                    if($limit_info['status']==10){
                                        if(isset($limit_info['postcode_from'])&&($this->shipping_postcode<=$limit_info['postcode_to']&&$limit_info['postcode_from']<=$this->shipping_postcode)&&(strlen($this->shipping_postcode)==strlen($limit_info['postcode_from']))){
                                            if(isset($limit_info['country_iso_code_2'])){
                                                if(isset($limit_info['products_id'])){
                                                    if(isset($limit_info['start_time']) && isset($limit_info['end_time'])){//设置了邮编+国家+产品ID+时间

                                                        if (in_array($this->country_iso2,explode(',',$limit_info['country_iso_code_2'])) && in_array($limit_info['products_id'], $_SESSION['cart']->products_products_checked)){
                                                            continue(3);
                                                        }
                                                    }else{//设置了邮编+国家+产品ID
                                                        if (in_array($this->country_iso2,explode(',',$limit_info['country_iso_code_2'])) && in_array($limit_info['products_id'], $_SESSION['cart']->products_products_checked)){
                                                            continue(3);
                                                        }
                                                    }

                                                }elseif(isset($limit_info['start_time']) && isset($limit_info['end_time'])){//设置了邮编+国家+时间
                                                    if (in_array($this->country_iso2,explode(',',$limit_info['country_iso_code_2']))){
                                                        continue(3);
                                                    }
                                                }else{
                                                    if (in_array($this->country_iso2,explode(',',$limit_info['country_iso_code_2']))){//设置了邮编+国家
                                                        continue(3);
                                                    }
                                                }

                                            }elseif(isset($limit_info['products_id'])){
                                                if(isset($limit_info['start_time']) && isset($limit_info['end_time'])){//设置了邮编+商品ID+时间
                                                    if (in_array($limit_info['products_id'], $_SESSION['cart']->products_products_checked)) {
                                                        continue(3);
                                                    }
                                                }else{
                                                    if (in_array($limit_info['products_id'], $_SESSION['cart']->products_products_checked)) {//设置了邮编+商品ID
                                                        continue(3);
                                                    }
                                                }
                                            }elseif(isset($limit_info['start_time']) && isset($limit_info['end_time'])){
                                                continue(3);
                                            }else{
                                                continue(3);
                                            }
                                        }elseif(isset($limit_info['country_iso_code_2'])&&(!isset($limit_info['postcode_from']))) {
                                            if(isset($limit_info['products_id'])) {
                                                if ( isset($limit_info['start_time']) && isset($limit_info['end_time'])) { // 设置了国家+商品id+时间
                                                    if (in_array($this->country_iso2,explode(',',$limit_info['country_iso_code_2'])) && in_array($limit_info['products_id'], $_SESSION['cart']->products_products_checked)) {
                                                        continue(3);
                                                    }
                                                }else{ // 设置了国家 + 商品id
                                                    if (in_array($this->country_iso2,explode(',',$limit_info['country_iso_code_2'])) && in_array($limit_info['products_id'], $_SESSION['cart']->products_products_checked)) {
                                                        continue(3);
                                                    }
                                                }
                                            }else{
                                                if ( isset($limit_info['start_time']) && isset($limit_info['end_time'])) { // 设置了国家+时间
                                                    if (in_array($this->country_iso2,explode(',',$limit_info['country_iso_code_2']))) {
                                                        continue(3);
                                                    }
                                                }else{ // 只设置了国家
                                                    if (in_array($this->country_iso2,explode(',',$limit_info['country_iso_code_2']))) {
                                                        continue(3);
                                                    }
                                                }
                                            }
                                        }elseif (isset($limit_info['products_id'])&&(!isset($limit_info['country_iso_code_2']))&&(!isset($limit_info['postcode_from']))) {
                                            if ( isset($limit_info['start_time']) && isset($limit_info['end_time'])) { // 设置了商品id+时间
                                                if (in_array($limit_info['products_id'], $_SESSION['cart']->products_products_checked)) {
                                                    continue(3);
                                                }
                                            }else{ // 只设置了商品id
                                                if (in_array($limit_info['products_id'], $_SESSION['cart']->products_products_checked)) {
                                                    continue(3);
                                                }
                                            }
                                        }else{
                                            if ( isset($limit_info['start_time']) && isset($limit_info['end_time'])&&!(isset($limit_info['products_id']))&&(!isset($limit_info['country_iso_code_2']))&&(!isset($limit_info['postcode_from']))) { // 设置时间
                                                continue(3);
                                            }
                                            if (!isset($limit_info['start_time'])&&!isset($limit_info['end_time'])&&!(isset($limit_info['products_id']))&&(!isset($limit_info['country_iso_code_2']))&&(!isset($limit_info['postcode_from']))){
                                                continue(3);
                                            }
                                        }
                                    }
                                }
                            }
                        }


                        $virtual_shipping_display_method = get_virtual_shipping_display_method($order->delivery['country']['id']);
                        $is_display = 1;
                        if (!empty($virtual_shipping_display_method)) {
                            if (!in_array($shipping_id, $virtual_shipping_display_method)) {
                                $is_display = 0;
                            }
                        }

                        if(!$error){
                            $shipping_method_array[] = array(
                                'id' => $shipping_group_id,
                                'code' => 'VVV' . $shipping_group_id . 'VVV',
                                'virtual_id' => $shipping_id,
                                'virtual_code' => $shipping_code,
                                'area_code' => $shipping_area_code,
                                'is_remote' => $is_remote,
                                'name' => $group_name,
                                'title' => $group_name,
                                'box' => $shipping_num_boxes,
                                'day_low' => $shipping_transport_min,
                                'day_high' => $shipping_transport_max,
                                'days' => $shipping_transport_min . '-' . $shipping_transport_max,
                                'cost' => $shipping_fee,
                                'box_note' => $shipping_box_note,
                                'remote_note' => $remote_note,
                                'remote_fee' => $remote_fee_usd,
                                'volume_note' => '',
                                'track_url' => $track_url,
                                'error' => $error,
                                'shipping_package_box_weight' => $package_box_weight,
                                'shipping_weight' => $shipping_weight,
                                'shipping_volume_weight_title' => TEXT_WORD_VOLUME_WEIGHT,
                                'shipping_volume_weight_alt' => TEXT_WORD_VOLUME_WEIGHT,
                                'shipping_volume_weight' => $volume_weight,
                                'time_unit' => TEXT_DAYS_LAN,
                                'is_display' => $is_display,
                                'is_virtual' => true
                            );
                        }
                    }
                
                }
                
                $min_shipping_method = array();
                if(sizeof($shipping_method_array) > 0){
                    $shipping_method_array = $this->array_sort($shipping_method_array, 'area_code', 'asc', 'cost');
                    
                    $i = 0;
                    foreach ($shipping_method_array as $key => $shipping_detail){
                        $area_code = $shipping_detail['area_code'];
                        
                        if($i == 0){
                            $min_area_code = $area_code;
                            $min_shipping_fee = $shipping_detail['cost'];
                            $min_trans_day = $shipping_detail['days'];
                            $min_shipping_id = $shipping_detail['id'];
                            $min_shipping_method = $shipping_detail;
                        }else{
                            if($min_area_code == $area_code){
                                if($shipping_detail['cost'] < $min_shipping_fee){
                                    $min_area_code = $area_code;
                                    $min_shipping_fee = $shipping_detail['cost'];
                                    $min_trans_day = $shipping_detail['days'];
                                    $min_shipping_id = $shipping_detail['id'];
                                    $min_shipping_method = $shipping_detail;
                                }elseif($shipping_detail['cost'] == $min_shipping_fee){
                                    if($min_trans_day > $shipping_detail['cost']){
                                        $min_area_code = $area_code;
                                        $min_shipping_fee = $shipping_detail['cost'];
                                        $min_trans_day = $shipping_detail['days'];
                                        $min_shipping_id = $shipping_detail['id'];
                                        $min_shipping_method = $shipping_detail;
                                    }elseif($min_trans_day == $shipping_detail['cost']){
                                        if($min_shipping_id > $shipping_detail['id']){
                                            $min_area_code = $area_code;
                                            $min_shipping_fee = $shipping_detail['cost'];
                                            $min_trans_day = $shipping_detail['days'];
                                            $min_shipping_id = $shipping_detail['id'];
                                            $min_shipping_method = $shipping_detail;
                                        }else{
                                            continue;
                                        }
                                    }else{
                                        continue;
                                    }
                                }else{
                                    continue;
                                }
                            }elseif($min_area_code > $area_code){
                                $min_area_code = $area_code;
                                $min_shipping_fee = $shipping_detail['cost'];
                                $min_trans_day = $shipping_detail['days'];
                                $min_shipping_id = $shipping_detail['id'];
                                $min_shipping_method = $shipping_detail;
                            }else{
                                continue;
                            }
                        }
                        $i++;
                    }
                }
                
                if(sizeof($min_shipping_method) > 0){
                    $this->virtual_cal_result[ $min_shipping_method['code']] = $min_shipping_method;
                }
                
                $virtual_shipping_group->MoveNext();
            }
            
        }
    }
    
    private function array_sort($sort_array, $sort_by = 'cost', $sort = 'asc', $sort_by_then = 'day_low'){
        $keysvalue = $new_array = array ();
        foreach ( $sort_array as $k => $v ) {
            $keysvalue [$k] = round($v [$sort_by], 4) * 10000 + $v [$sort_by_then] * 100;
        }
        if ($sort == 'asc') {
            asort ( $keysvalue );
        } elseif ($sort == 'desc') {
            arsort ( $keysvalue );
        }
        reset ( $keysvalue );
        foreach ( $keysvalue as $k => $v ) {
            $new_array [$k] = $sort_array [$k];
        }
        return $new_array;
    }

    private function check_virtual_remote_area($shipping_erp_id, $remote_guideline, $country_iso2, $state, $city, $postcode){
        global $db;
        $is_remote = false;

        if(empty($postcode) && empty($city)) {
            return $is_remote;
        }

        if($remote_guideline == 10){
            $check_virtual_remote_area_sql = 'SELECT
                                                remote_id,
                                                remote_state,
                                                remote_city
                                              FROM
                                                ' . TABLE_VIRTUAL_SHIPPING_REMOTE_AREA . '
                                              WHERE
                                              ( 
                                                shipping_code like "%,' . $shipping_erp_id . ',%"
                                                  AND
                                                ((remote_country_code = :country
                                                  AND
                                                    remote_start_postcode <= :postcode
                                                  AND
                                                    remote_end_postcode >= :postcode
                                                )
                                              OR
                                                (
                                                    remote_start_postcode = "<>"
                                                AND
                                                    remote_end_postcode = "<>"
                                                AND
                                                    remote_city = :city
                                                ))
                                              )
                                              AND
                                                remote_status = 10';

            $check_virtual_remote_area_sql = $db->bindVars($check_virtual_remote_area_sql,':country',$country_iso2,'string');
            $check_virtual_remote_area_sql = $db->bindVars($check_virtual_remote_area_sql,':postcode',$postcode,'string');
            $check_virtual_remote_area_sql = $db->bindVars($check_virtual_remote_area_sql,':city',$city,'string');

            $check_virtual_remote_area_query = $db->Execute($check_virtual_remote_area_sql);

            if($check_virtual_remote_area_query->RecordCount() > 0){
                if($check_virtual_remote_area_query->fields['remote_state'] != '' || $check_virtual_remote_area_query->fields['remote_city'] != ''){
                    if($check_virtual_remote_area_query->fields['remote_state'] == $state){
                        $is_remote = true;
                    }elseif($check_virtual_remote_area_query->fields['remote_city'] == $city){
                        $is_remote = true;
                    }else{
                        $is_remote = false;
                    }
                }else{
                    $is_remote = true;
                }
            }
        }elseif($remote_guideline == 20){
            $check_virtual_remote_area_sql = 'SELECT
                                                remote_id
                                              FROM
                                                ' . TABLE_VIRTUAL_SHIPPING_REMOTE_AREA . '
                                              WHERE
                                                    shipping_code like "%,' . $shipping_erp_id . ',%"
                                                  AND
                                                    remote_start_postcode <= :postcode
                                                  AND
                                                    remote_end_postcode >= :postcode
                                                    AND
                                                remote_status = 10';

            $check_virtual_remote_area_sql = $db->bindVars($check_virtual_remote_area_sql,':postcode',$postcode,'string');

            $check_virtual_remote_area_query = $db->Execute($check_virtual_remote_area_sql);

            if($check_virtual_remote_area_query->RecordCount() > 0){
                $is_remote = true;
            }
        }

        return $is_remote;
    }

    /**
     * 取所有虚拟运送方式，不限制状态
     */
    public function all_virtual_shipping(){
        global $db;
        $virtual_shipping = $db->Execute ( 'select shipping_erp_id, shipping_code, shipping_name, track_url from ' . TABLE_VIRTUAL_SHIPPING );
        if ($virtual_shipping->RecordCount() > 0) {
            while ( ! $virtual_shipping->EOF ) {
//                $shipping_day = $this->get_shipping_day($shipping->fields['code']);
//                $shipping_title = $this->get_shipping_title($shipping->fields['id']);
//                $shipping->fields['title'] = $shipping_title;
//                $shipping->fields['days'] = $shipping_day['day_low'] . '-' . $shipping_day['day_high'];
                $this->all_virtual_shipping_method [$virtual_shipping->fields['shipping_code']] = $virtual_shipping->fields;

                $virtual_shipping->MoveNext();
            }
        }
    }

    public function get_all_virtual_shipping(){
        return $this->all_virtual_shipping_method;
    }
}
?>