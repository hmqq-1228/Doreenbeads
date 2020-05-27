<?php

 /**
  * @parm int $address_id地址薄ID
  * @pram string $trans 配送方式编码
  * @pram string $country_iso2 城市二级编码
  * @pram string $postcode 邮编
  * @pram string $city 城市名称
  * @pram string $state 省份
  * @return boolean 是否是偏远 
  */
function get_trans_remote($address_id = 1, $trans = 'dhl', $country_iso2 = '', $postcode = '', $city = '', $state) {
	global $db, $order;
	if ($address_id == 0) {
		return false;
	}
	$sql = "select ra_address_book_id from ". TABLE_REMOTE_AREA ." where ra_address_book_id=:ra_address_book_id and ra_trans_type=:trans_type";
	$sql = $db->bindVars($sql,':ra_address_book_id',$address_id,'integer');
	$sql = $db->bindVars($sql,':trans_type',$trans,'string');
	$record = $db->Execute($sql);
	if ($record->RecordCount () == 0) {
		$dest_zone_id = !empty($country_iso2) ? $country_iso2 : $order->delivery['country']['iso_code_2'];
		$shipping_city = !empty($city) ? $city : $order->delivery['city'];
		$shipping_city = addslashes(strtoupper(preg_replace('/[\s-]/', '', $shipping_city)));
		$shipping_state = !empty($state) ? $state : $order->delivery['state'];
		$shipping_state = addslashes(strtoupper(preg_replace('/[\s-]/', '', $shipping_state)));
		$shipping_post_code = isset($cal_postcode) && $cal_postcode != '' ? $cal_postcode : $order->delivery['postcode'];
		$shipping_post_code = addslashes($shipping_post_code);
		
		if (in_array(strtoupper($shipping_post_code), array('IV9', 'IV10', 'IV11', 'IV12')) && $dest_zone_id == 'GB' && $trans == 'ups'){
			return true;
		}
		$shipping_city_sql = $shipping_state_sql = "1=1";
		$shipping_city_sql_must = $shipping_state_sql_must = "1=2";
		if(!empty($shipping_city)) {
			$shipping_city_sql = $shipping_city_sql_must = "city='" . $shipping_city . "'";
		}
		if(!empty($shipping_state)) {
			$shipping_state_sql = $shipping_state_sql_must = "state='" . $shipping_state . "'";
		}
		$postageString = "";
		if(is_numeric($shipping_post_code)) {
			$postageStringPart = "postage!='' AND postcode_high!='' AND
									postage <= :postcode
									AND postcode_high >= :postcode
									AND " . strlen($shipping_post_code) . " <= length( postcode_high )
									AND " . strlen($shipping_post_code) . " >= length( postage )";
									
		} else {
			$postageStringPart = "postage!='' AND postcode_high!='' AND
									postage <= SUBSTRING('" . $shipping_post_code . "', 1, LENGTH(postage))
                                    AND postcode_high >= SUBSTRING('" . $shipping_post_code . "', 1, LENGTH(postage))
									) OR (
									postage!='' AND postcode_high!='' AND
									replace(postage, ' ', '') <= SUBSTRING('" . preg_replace('/[\s-]/', '', $shipping_post_code) . "', 1, LENGTH(replace(postage, ' ', '')))
                                    AND replace(postcode_high, ' ', '') >= SUBSTRING('" . preg_replace('/[\s-]/', '', $shipping_post_code) . "', 1, LENGTH(replace(postage, ' ', '')))";
		}
		$postageString = " OR (
									" . $postageStringPart . "
									)";
		$remote_address_sql = "SELECT id,postage,postcode_high FROM ". TABLE_REMOTE_ADDRESSES . "
										WHERE countries_iso_code_2 = :countries_iso_code_2 AND trans_type = :trans_type AND (
										case when state!='' and city!='' and postage!='' then " . $shipping_state_sql_must . " and " . $shipping_city_sql_must . " and (" . $postageStringPart . ") 
										when state!='' and postage!='' then " . $shipping_state_sql_must . " and (" . $postageStringPart . ")
										when city!='' and postage!='' then " . $shipping_city_sql_must . " and (" . $postageStringPart . ") 
										else
										(
										if(state!='' and city!='', " . $shipping_state_sql . " and " . $shipping_city_sql . ", if(state!='', " . $shipping_state_sql . ", if(city!='', " . $shipping_city_sql . ", 1=2)))
										)
										" . $postageString . "
										end
										)
										LIMIT 1";
	
		$remote_address_sql = $db->bindVars($remote_address_sql, ':countries_iso_code_2', $dest_zone_id, 'string');
		$remote_address_sql = $db->bindVars($remote_address_sql, ':trans_type', $trans, 'string');
		$remote_address_sql = $db->bindVars($remote_address_sql, ':postcode', strtolower(trim($shipping_post_code)), 'string');
		//$remote_address_sql = $db->bindVars($remote_address_sql, ':city', strtoupper(preg_replace('/[\s-]/', '', $shipping_city)), 'string');
		$remote_address_record = $db->Execute($remote_address_sql);
		if($remote_address_record->RecordCount() != 0){
			$postage_low = $remote_address_record->fields['postage'];
			$postage_high = $remote_address_record->fields['postcode_high'];
			if ((strlen($postage_high) > strlen($postage_low)) && is_numeric($postage_high)){
				if (is_numeric($shipping_post_code)){
					return true;
				}else {
					return false;
				}
			}
			return true;
		}else{
			return false;
		}
	} else {
		return true;
	}
}

/**
 * 下单页面显示的虚拟海外仓运输方式
 * @param $country_id int
 * @return array or false
 */
function get_virtual_shipping_display_method($country_id){
    global $db;
    if (!$country_id) {
        return false;
    }
    $display_virtual_shipping = array();

    $selected_country_query = $db->Execute('SELECT virtual_shipping_ids FROM ' . TABLE_SHIPPING_DISPLAY . ' WHERE country_ids LIKE "%,'.$country_id.',%" ORDER BY id DESC LIMIT 1');
    if ($selected_country_query->RecordCount() > 0) {
        while (!$selected_country_query->EOF){
            $display_virtual_shipping = explode(',', trim($selected_country_query->fields['virtual_shipping_ids'], ','));
            $selected_country_query->MoveNext();
        }
    }
    return $display_virtual_shipping;
}


function set_trans_remote($address_id = 1, $trans = 'dhl',$status=1) {
	global $db;
	$sql = "select ra_address_book_id from ". TABLE_REMOTE_AREA ." where ra_address_book_id=:ra_address_book_id and ra_trans_type=:trans_type";
	$sql = $db->bindVars($sql,':ra_address_book_id',$address_id,'integer');
	$sql = $db->bindVars($sql,':trans_type',$trans,'string');
	$record = $db->Execute($sql);
	if($status&&$record->RecordCount()==0){
		$sql = "insert into  " . TABLE_REMOTE_AREA . "(ra_address_book_id, ra_trans_type, ra_remote, ra_system_remark, create_time, modify_operator)  values(:ra_address_book_id,:trans_type,1,0, now(), '')";
		$sql = $db->bindVars($sql,':ra_address_book_id',$address_id,'integer');
		$sql = $db->bindVars($sql,':trans_type',$trans,'string');
		$db->Execute($sql);
		return 1;
	}
	if(!$status&&$record->RecordCount()>0&&!$record->fields['ra_system_remark']){
		$sql = "delete from   ". TABLE_REMOTE_AREA ."  where ra_address_book_id =:ra_address_book_id and ra_trans_type=:trans_type";
		$sql = $db->bindVars($sql,':ra_address_book_id',$address_id,'integer');
		$sql = $db->bindVars($sql,':trans_type',$trans,'string');
		$db->Execute($sql);
		return 1;
	}
	return 0;
}

/*
* author zale
* date 20130402 
*/
function check_remote_area_dhl($ctry, $post_code, $city){	
	$check_city = false;
	$check_post_code = false;

	$ch = curl_init();
	$url = 'http://remoteareas.dhl.com/jsp/SearchServlet?fromFilter=true&DPEECTR=N&cntry_cd=VN&isoCountryCode=EN';
	$ctry = urlencode($ctry);
	$post_code = urlencode($post_code);
	$city = urlencode($city);

	$post_city_data = 'selectedCtry=' . $ctry . '&inputCity=' . $city;
	$post_pstcd_data = 'selectedCtry=' . $ctry . '&inputPostalCode=' . $post_code;

	//bof use city check
	if ($city == ''){
		$city_result = '';
	}else{
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_city_data);
		$city_result = curl_exec($ch);
	}
	//eof use city check

	//bof use post code check
	if ($post_code == ''){
		$post_code_result = '';
	}else{
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_pstcd_data);
		$post_code_result = curl_exec($ch);
	}
	//eof use post code check
	
	curl_close($ch);
	
	$city = urldecode(strtoupper($city));
	$post_code = preg_replace('/[-\s]/', '', urldecode($post_code));
	if ($post_code <> '' && preg_match('/'.$post_code.'/i', $post_code_result) && preg_match('/Total Records/i', $post_code_result)){
		return true;
	}
	if ($city <> '' and preg_match('/'.$city.'/i', $city_result) && preg_match('/Total Records/i', $city_result)) {
		if($post_code == ''){
			return true;
		}else{
			if (preg_match('/ALLCODES|'.$post_code.'/i', $city_result) && preg_match('/Total Records/i', $city_result)) {
				return true;
			}
		}
	}
	return false;
}

function check_remote_area_dpd($postcode, $sento = '') {	
	$postcode = strtoupper(trim($postcode));
	if (substr ( $postcode, 0, 1 ) == 'G' && intval ( substr ( $postcode, 1, 2 ) ) == 83) {
		return true;
	}
	switch (substr ( $postcode, 0, 2 )) {
		case 'AB' :
			$subseq = intval ( substr ( $postcode, 2, 2 ) );
			if (($subseq >= 30 && $subseq <= 38) || ($subseq >= 44 && $subseq <= 56))
				$remote = true;
			break;
		case 'FK' :
			$subseq = intval ( substr ( $postcode, 2, 2 ) );
			if ($subseq >= 17 && $subseq <= 21)
				$remote = true;
			break;
		case 'GY' :
			$subseq = intval ( substr ( $postcode, 2, 1 ) );
			if ($subseq == 9) {
				$remote = true;
			}
			break;
		case 'HS' :
			$subseq = intval ( substr ( $postcode, 2, 1 ) );
			if ($subseq >= 1 && $subseq <= 9) {
				$remote = true;
			}
			break;
		case 'KA' :
			$subseq = intval ( substr ( $postcode, 2, 2 ) );
			if ($subseq >= 27 && $subseq <= 28)
				$remote = true;
			break;
		case 'KW' :
			$subseq = intval ( substr ( $postcode, 2, 1 ) );
			$subseq1 = intval ( substr ( $postcode, 2, 2 ) );
			if (($subseq >= 0 && $subseq <= 9) || ($subseq1 >= 10 && $subseq1 <= 99))
				$remote = true;
			break;
		case 'PA' :
			$subseq = intval ( substr ( $postcode, 2, 2 ) );
			if ($subseq >= 20 && $subseq <= 99)
				$remote = true;
			break;
		case 'PH' :
			$subseq = intval ( substr ( $postcode, 2, 2 ) );
			if (($subseq >= 17 && $subseq <= 32) || ($subseq >= 34 && $subseq <= 48))
				$remote = true;
			break;
		case 'TR' :
			$subseq = intval ( substr ( $postcode, 2, 2 ) );
			if ($subseq >= 22 && $subseq <= 25)
				$remote = true;
			break;
		case 'BT' :
		case 'ZE' :
		case 'JE' :
		case 'IM' :
		case 'IV' :
			$remote = true;
			break;
		default :
			$remote = false;
			break;
	}
	if ($remote && $sento != ''){
		set_trans_remote($sento, 'dpd',1);
	}
	return $remote;
}

function check_remote_area_byID($address_id = 1) {
	global $db;
	$address_query = "select entry_city as city, entry_postcode as postcode,

                             entry_state as state,  countries_iso_code_2

                      from " . TABLE_ADDRESS_BOOK . " As ab left join " . TABLE_COUNTRIES . " c on (ab.entry_country_id = c.countries_id)

                      where customers_id = '" . ( int ) $_SESSION ["customer_id"] . "'

                      and address_book_id = '" . ( int ) $address_id . "'";
	$address_query = $db->Execute ( $address_query );
	if ($address_query->RecordCount () == 0){
		return 0;
	}
	$ctry = $address_query->fields ['countries_iso_code_2'];
	$city = $address_query->fields ['city'];
	$post_code = $address_query->fields ['postcode'];
	
	// �����������ʡ�ݲ�����Puerto Rico
	if ($ctry == 'US' and ($address_query->fields ['state'] == 'PR' or strstr ( $address_query->fields ['state'], 'Puerto Rico' ))) {
		$ctry = 'PR';
	}
	if (check_remote_area_dhl($ctry, $post_code, $city)){
		set_trans_remote ( $address_id, 'dhl', 1 );
	}else{
		set_trans_remote ( $address_id, 'dhl', 0 );
	}
	if (check_remote_area_dpd($post_code, $address_id)){
		set_trans_remote ( $address_id, 'dpd', 1 );
	}else{
		set_trans_remote ( $address_id, 'dpd', 0 );
	}
	if (get_trans_remote('', 'fedex', $ctry, $post_code, $city)){
		set_trans_remote ( $address_id, 'fedex', 1 );
	}else{
		set_trans_remote ( $address_id, 'fedex', 0 );
	}
	if (get_trans_remote('', 'ups', $ctry, $post_code, $city)){
		set_trans_remote ( $address_id, 'ups', 1 );
	}else{
		set_trans_remote ( $address_id, 'ups', 0 );
	}
}
function get_shipping_day($shipping_code, $country_iso2 = ''){
	global $db;
	$shipping_day = array();
	$query = $db->Execute('select day_low, day_high from ' . TABLE_SHIPPING_DAY . ' where code = "' . $shipping_code . '" and country_iso2 = "' . $country_iso2 . '" limit 1');
	if ($query->RecordCount() == 0){
		$query = $db->Execute('select day_low, day_high from ' . TABLE_SHIPPING_DAY . ' where code = "' . $shipping_code . '" and country_iso2 = "" limit 1');
	}
	if ($query->RecordCount() == 1){
		$shipping_day['day_low'] = $query->fields['day_low'];
		$shipping_day['day_high'] = $query->fields['day_high'];
		return $shipping_day;
	}else{
		return 0;
	}
}
function get_all_shipping_day($shipping_code){
	global $db;
	$shipping_day = array();
	$query = $db->Execute('select day_low, day_high, country_iso2 from ' . TABLE_SHIPPING_DAY . ' where code = "' . $shipping_code . '" order by country_iso2');
	while (!$query->EOF){
		$country = ($query->fields['country_iso2'] == '' ? 'default' : $query->fields['country_iso2']);
		$shipping_day[$country] = array('day_low' => $query->fields['day_low'], 'day_high' => $query->fields['day_high']);
		$query->MoveNext();
	}
	return $shipping_day;
}
function get_shipping_title($id){
	global $db;
	$shipping_title = '';
	if ($id != ''){
		$query = $db->Execute('select title, language_id from ' . TABLE_SHIPPING_INFO . ' where id = ' . $id);
		while (!$query->EOF){
			$shipping_title [$query->fields['language_id']] = $query->fields['title'];
			$query->MoveNext();
		}
	}
	return $shipping_title;
}


 /**
   * 下单页面显示的运输方式
   * @param $country_id int
   * @return array or false
   */
function get_shipping_display_method($country_id){
	global $db;
	if (!$country_id) {
		return false;
	}
	$selected_country_array = array();

	$selected_country_query = $db->Execute('SELECT * FROM ' . TABLE_SHIPPING_DISPLAY . ' WHERE country_ids LIKE "%,'.$country_id.',%" ORDER BY id DESC LIMIT 1');
	if ($selected_country_query->RecordCount() > 0) {
		while (!$selected_country_query->EOF){
			$display_shipping = explode(',', trim($selected_country_query->fields['shipping_ids'], ','));
			$selected_country_query->MoveNext();
		}
	}
	return $display_shipping;
}
?>