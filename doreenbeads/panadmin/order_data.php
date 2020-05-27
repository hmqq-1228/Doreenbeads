<?php
require ('includes/application_top.php');
/*
 统计第一次购买的客户，没有时间限制
 $start_time  订单开始时间
 $end_time    订单结束时间
 $acount_start_time  注册启示时间(为订单开始时间前一个月)
 $lang        下单语种
 */
set_time_limit(0);
function get_customers_first_order($start_time,$end_time,$acount_start_time,$lang, $from_mobile=0){
    global $db_slave;
    if(isset($lang)){
        if(is_numeric($lang)) {
            $lang_str = ' and o.language_id = ' . $lang;
        } else {
            $lang_str = ' and o.language_id in (' . $lang . ')';
        }
    }
    switch ($from_mobile){
        case 10:
            $mobile_str = ' and from_mobile = 0';
            break;
        case 20:
            $mobile_str = ' and from_mobile = 1';
            break;
        default:
            $mobile_str = '';
            break;
    }
    $customers = $db_slave->Execute("SELECT DISTINCT (o.customers_id)
	FROM  ".TABLE_ORDERS." o
	WHERE
	o.date_purchased >= '".$start_time."'
	and o.date_purchased <= '".$end_time."'
	and o.orders_status in ( " . MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP . ")
	".$lang_str."
    " . $mobile_str . "
	AND o.customers_email_address NOT LIKE '%panduo.com.cn%' and o.customers_email_address NOT LIKE '%@163.com%' and o.customers_email_address NOT LIKE '%@qq.com%'");
    
    while (!$customers->EOF) {
        $customers_id = $customers->fields['customers_id'];
        if(isset($customers_id) && (int)$customers_id > 0){
            $orders = $db_slave->Execute("select customers_id from  ".TABLE_ORDERS." o where customers_id = ".$customers_id." and  date_purchased <= '".$start_time."' and orders_status in ( " . MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP . ") " . $mobile_str );
            
            if((int)$orders->fields['customers_id'] > 0){
                
            }else{
                $customers_ids = $customers_ids . $customers_id .',';
            }
        }
        $customers->MoveNext();
    }
    
    $orders_total = 'null';
    if($customers_ids != ''){
        $orders_total = $db_slave->Execute("SELECT
			COUNT(zo.customers_id) count_customer,
			COUNT(zo.orders_id) count_order,
			SUM(order_total) count_order_total,
			avg(order_total) avg_order_total
		FROM ".TABLE_ORDERS." zo INNER JOIN (
			SELECT
				customers_id,
				MIN(orders_id) mino
			FROM
				".TABLE_ORDERS." o
			WHERE
				customers_id IN (
					".substr($customers_ids, 0, -1) ."
				)
			AND orders_status in ( " . MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP . ")
			AND date_purchased >= '".$start_time."'
			AND date_purchased <= '".$end_time."'
			" . $lang_str ."
            " . $mobile_str . "
			GROUP BY
				customers_id
		) t ON t.mino = zo.orders_id");
    }
    
    
    return $orders_total;
}


/*
 统计老客户数据（回头客户）
 */
function get_customers_old_order($start_time,$end_time,$acount_start_time,$lang, $from_mobile=0){
    global $db_slave;
    $lang_str = '';
    if(isset($lang)){
        if(is_numeric($lang)) {
            $lang_str = ' and o.language_id = ' . $lang;
        } else {
            $lang_str = ' and o.language_id in (' . $lang . ')';
        }
    }
    switch ($from_mobile){
        case 10:
            $mobile_str = ' and from_mobile = 0';
            break;
        case 20:
            $mobile_str = ' and from_mobile = 1';
            break;
        default:
            $mobile_str = '';
            break;
    }
    
    $customers = $db_slave->Execute("SELECT DISTINCT (o.customers_id)
	FROM  ".TABLE_ORDERS." o
	WHERE  o.date_purchased >= '".$start_time."'
	and o.date_purchased <= '".$end_time."'
	and o.orders_status in ( " . MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP . ")
	".$lang_str."
    " . $mobile_str . "
	and o.customers_email_address NOT LIKE '%@panduo.com.cn%' and o.customers_email_address NOT LIKE '%@163.com%' and o.customers_email_address NOT LIKE '%@qq.com%'");
    $customers_ids = '';
    $first_customers_ids = '';
    
    while (!$customers->EOF) {
        $customers_id = $customers->fields['customers_id'];
        if(isset($customers_id) && (int)$customers_id > 0){
            $orders = $db_slave->Execute("select customers_id from  ".TABLE_ORDERS." o where customers_id = ".$customers_id." and  date_purchased <= '".$start_time."' and orders_status in(" . MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP . ") " . $mobile_str );
            
            if((int)$orders->fields['customers_id'] > 0){
                $customers_ids = $customers_ids . $customers_id .',';
            }else{
                $first_customers_ids .= $customers_id . ',';
                //$customers_ids = $customers_ids . $customers_id .',';
            }
        }
        $customers->MoveNext();
    }
    $orders_total = 'null';
    if($customers_ids != ''){
        
        $orders_total = $db_slave->Execute("select count(DISTINCT customers_id) count_customer,count(orders_id) count_order,sum(order_total) count_order_total,avg(order_total) avg_order_total from  ".TABLE_ORDERS." o where date_purchased >= '".$start_time."'	and date_purchased <= '".$end_time."' and customers_id IN (".substr($customers_ids, 0, -1) .") and orders_status in(" . MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP . ") ".$lang_str. " " . $mobile_str);
    }
    
    if($first_customers_ids != ''){
        $first_customers_orders_ids = '';
        $first_customers_orders_ids_query = $db_slave->Execute("SELECT
						MIN(orders_id) mino
					FROM
						".TABLE_ORDERS." o
					WHERE
						customers_id IN (
							".substr($first_customers_ids, 0, -1) ."
						)
					AND orders_status IN (" . MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP . ")
					AND date_purchased >= '".$start_time."'
					AND date_purchased <= '".$end_time."'
					" . $lang_str ."
                    " . $mobile_str . "
					GROUP BY
						customers_id");
        
        if($first_customers_orders_ids_query->RecordCount() > 0){
            while(!$first_customers_orders_ids_query->EOF){
                $first_customers_orders_ids .= $first_customers_orders_ids_query->fields['mino'] . ',';
                
                $first_customers_orders_ids_query->MoveNext();
            }
        }
        $first_customers_again_orders_total = $db_slave->Execute("SELECT
				count(DISTINCT customers_id) count_customer,
				count(orders_id) count_order,
				sum(order_total) count_order_total,
				avg(order_total) avg_order_total
			FROM
				".TABLE_ORDERS." o
			WHERE
				" . (substr($first_customers_orders_ids , 0, -1) != '' ?  "orders_id NOT IN (" . substr($first_customers_orders_ids , 0, -1) . ")" : '') . "
			AND customers_id IN (
				".substr($first_customers_ids, 0, -1) ."
			)
			AND orders_status IN (" . MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP . ")
			AND date_purchased >= '".$start_time."'
			AND date_purchased <= '".$end_time."'
			" . $lang_str . $mobile_str) ;
    }
    
    $merge_orders_total = array();
    
    $merge_orders_total['count_customer'] = $orders_total->fields['count_customer'] + $first_customers_again_orders_total->fields['count_customer'];
    $merge_orders_total['count_order'] = $orders_total->fields['count_order'] + $first_customers_again_orders_total->fields['count_order'];
    $merge_orders_total['count_order_total'] = $orders_total->fields['count_order_total'] + $first_customers_again_orders_total->fields['count_order_total'];
    $merge_orders_total['avg_order_total'] = $orders_total->fields['avg_order_total'] + $first_customers_again_orders_total->fields['avg_order_total'];
    
    return $merge_orders_total;
}


// zongdingdanshu
function get_all_orders_query($start_time, $end_time, $lang, $from_mobile=0 , $orders_range = false){
    global $db_slave;
    $lang_str = '';
    if(isset($lang)){
        if(is_numeric($lang)) {
            $lang_str = ' and language_id = ' . $lang;
        } else {
            $lang_str = ' and language_id in (' . $lang . ')';
        }
    }
    switch ($from_mobile){
        case 10:
            $mobile_str = ' and from_mobile = 0';
            break;
        case 20:
            $mobile_str = ' and from_mobile = 1';
            break;
        default:
            $mobile_str = '';
            break;
    }
    if(!$orders_range){
        $orders_range_str = " and orders_status in(" . MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP . ")";
    }else{
        $orders_range_str = " ";
    }
    
    $query_sql = "select count(orders_id) as orders_num, sum(order_total) as total,count(DISTINCT customers_id) as customers_num from ".TABLE_ORDERS."  where date_purchased >= '".$start_time."' and date_purchased <= '".$end_time."'". $lang_str . $mobile_str . $orders_range_str ." and customers_email_address NOT LIKE '%@panduo.com.cn%'  and customers_email_address NOT LIKE '%@163.com%' and customers_email_address NOT LIKE '%@qq.com%'";
    $query_result = $db_slave->Execute($query_sql);
    return $query_result;
}

function get_all_orders_query_group($start_time, $end_time, $lang, $from_mobile = 0){
    global $db_slave;
    $lang_str = '';
    if(isset($lang)){
        if(is_numeric($lang)) {
            $lang_str = ' and language_id = ' . $lang;
        } else {
            $lang_str = ' and language_id in (' . $lang . ')';
        }
    }
    
    switch ($from_mobile){
        case 10:
            $mobile_str = ' and from_mobile = 0';
            break;
        case 20:
            $mobile_str = ' and from_mobile = 1';
            break;
        default:
            $mobile_str = '';
            break;
    }
    
    $query_sql = "select count(orders_id) as orders_num, sum(order_total) as total, count(DISTINCT customers_id) as customers_num, CONCAT(YEAR(date_purchased), '-', LPAD(MONTH(date_purchased), 2, 0), '-', LPAD(day(date_purchased), 2, 0)) as date_purchased_day from ".TABLE_ORDERS."  where date_purchased >= '".$start_time."' and date_purchased < '".$end_time."'". $lang_str . $mobile_str . " and orders_status in(" . MODULE_ORDER_PAID_VALID_DELIVERED_UNDER_CHECKING_STATUS_ID_GROUP . ") and customers_email_address NOT LIKE '%@panduo.com.cn%'  and customers_email_address NOT LIKE '%@163.com%' and customers_email_address NOT LIKE '%@qq.com%' group by date_purchased_day";
    $query_result = $db_slave->Execute($query_sql);
    $array = array();
    while(!$query_result->EOF) {
        $array[] = $query_result->fields;
        $query_result->MoveNext();
    }
    return $array;
}

//查询各类订单的信息
function get_all_status_orders($start_time, $end_time, $lang, $status, $auto_cancel = false, $from_mobile = 0){
    global $db_slave;
    $where = ' ';
    if(isset($lang)){
        if(is_numeric($lang)) {
            $where .= ' and language_id = '.$lang.'';
        } else {
            $where .= ' and language_id in (' . $lang . ')';
        }
    }
    switch ($from_mobile){
        case 10:
            $mobile_str = ' and from_mobile = 0';
            break;
        case 20:
            $mobile_str = ' and from_mobile = 1';
            break;
        default:
            $mobile_str = '';
            break;
    }
    if ( isset($status) && !$auto_cancel ) {
        $where .= ' and orders_status = '.$status;
    }elseif(!isset($status) && !$auto_cancel){
        $where .= '';
    }else{
        $where .= ' and automatically_canceled = 1 ';
    }
    $query_sql = "select count(orders_id) as orders_num, sum(order_total) as total,count(DISTINCT customers_id) as customers_num from ".TABLE_ORDERS."  where date_purchased >= '".$start_time."' and date_purchased <= '".$end_time."'". $where . " and customers_email_address NOT LIKE '%@panduo.com.cn%'  and customers_email_address NOT LIKE '%@163.com%' and customers_email_address NOT LIKE '%@qq.com%'"  . $mobile_str;
    $query_result = $db_slave->Execute($query_sql);
    return $query_result;
    
}

function outputXlsHeader($data,$file_name = 'export')
{
    ob_end_clean();
    header('Content-Type: text/xls');
    header( "Content-type:application/vnd.ms-excel;charset=utf-8" );
    $str = mb_convert_encoding($file_name, 'utf-8', 'utf-8');
    header('Content-Disposition: attachment;filename="' .$str . '.xls"');
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
    header('Expires:0');
    header('Pragma:public');
    $encode = mb_detect_encoding($data, array("ASCII","UTF-8","GB2312","GBK","BIG5"));
    $data = mb_convert_encoding($data, $encode, 'utf-8');
    
    echo $data;
    die();
}
$compare_time_type = zen_db_input($_POST['time']);
$starttime = zen_db_prepare_input($_POST['starttime']);
$stoptime = zen_db_prepare_input($_POST['stoptime']);
$count_type = $_POST['count_type'];
$section_type = zen_db_prepare_input($_POST['section_type']);
$languages_id_all = zen_db_prepare_input($_POST['languages_id_all']);
$languages_id = $_POST['languages_id'];

$device_type = zen_db_prepare_input($_POST['device_type']);
$compare_time = zen_db_prepare_input($_POST['compare_time']);
$languages_id_span_display = " display:none;";
$section_type_title = "站点";
if(!empty($section_type)) {
    $languages_id_span_display = "";
    $section_type_title = "日期";
}

$languages_id_selected = "";


$languages = zen_get_languages ();
if (empty($starttime)) {
    $starttime = date('Y-m-d') .' 00:00:00';
}
if (empty($stoptime)) {
    $stoptime = date('Y-m-d') .' 23:59:59';
}

if(!empty($section_type)) {
    if(strtotime($stoptime) - strtotime($starttime) > 86400 * 31) {
        $messageStack->add_session("结束时间不能大于开始时间31天!", 'error');
        zen_redirect(zen_href_link(FILENAME_ORDER_DATA, zen_get_all_get_params(array())));
    }
    
    if(empty($languages_id_all) && empty($languages_id)) {
        $messageStack->add_session("请选择语种!", 'error');
        zen_redirect(zen_href_link(FILENAME_ORDER_DATA, zen_get_all_get_params(array())));
    }
}
$compare_start_time='';
 $compare_stop_time ='';
 if(!empty($compare_time)){
    if($_POST['time'] == 0){
        $compare_start_time = date('Y-m-d H:i:s',strtotime('-1 month',strtotime($starttime))); 
        $compare_stop_time = date('Y-m-d H:i:s',strtotime('-1 month',strtotime($stoptime)));
        $shuju = '环比数据';
    }else if($_POST['time'] == 1){
       $compare_start_time = date('Y-m-d H:i:s',strtotime('-12 month',strtotime($starttime))); 
        $compare_stop_time = date('Y-m-d H:i:s',strtotime('-12 month',strtotime($stoptime)));
        $shuju = '同比数据';
    }else{
        $compare_start_time = $_POST['starttimes']; 
        $compare_stop_time = $_POST['stoptimes'];;
        $shuju = '自定义数据';
    }
 }
if(isset($_POST['action']) && ($_POST['action'] == 'search_status' || $_POST['action'] == 'get_excel')){
    $languages_id_query = null;
    if($languages_id_all != "20") {
        $languages_id_query = implode(",", $languages_id);
    }
    $languages_id_selected = "," . $languages_id_query . ",";
    
    
    $array_export = array();
    if(!empty($section_type)) {
        $all_orders = get_all_orders_query_group($starttime, $stoptime, $languages_id_query, $device_type);
        $wm_all_orders_origin = get_all_orders_query_group($starttime, $stoptime, $languages_id_query, 0);
        
        foreach($all_orders as $all_orders_key => $all_orders_value) {
            $array_export[$all_orders_key]['data_key'] = $all_orders_value['date_purchased_day'];
            $array_export[$all_orders_key]['data_name'] = $all_orders_value['date_purchased_day'];
            $array_export[$all_orders_key]['orders_num'] = $all_orders_value['orders_num'];
            $array_export[$all_orders_key]['total'] = $all_orders_value['total'];
            $array_export[$all_orders_key]['customers_num'] = $all_orders_value['customers_num'];
        }
    } else {
        for($j = 0, $n = sizeof ( $languages ); $j < $n; $j ++) {
            $array_export[$j]['data_key'] = $languages[$j]['id'];
            $array_export[$j]['data_name'] = $languages[$j]['name'];
        }
    }
    
    if(isset($count_type) && $count_type == 'customers_count'){
        $str = '';
        $str.=$starttime . '-' . $stoptime.'<br/><br/>';
        $str.='<table border="0" class="info_table" valign="top" >
			<tr>
				<th>' . $section_type_title . '</th>
				<th>总订单数</th>
				<th>总下单金额(USD)</th>
				<th>总客户数</th>
				<th>首次购买客户数</th>
				<th>首次购买客户的订单数</th>
				<th>首次客户订单总金额(USD)</th>
				<th>重复购买客户数</th>
				<th>重复购买客户的订单数</th>
				<th>重复客户订单总金额(USD)</th>
                <th>订单数占总占比</th>
				<th>订单金额占总占比</th>
			</tr>';
        
        $all_orders = array();
        // 			$lastyear_all_orders = array();
        $first_orders = array();
        $repeat_orders = array();
        $mobile_orders = array();
        
        $total_all_orders_num = 0;
        $total_all_orders_total = 0;
        $total_all_customers_num = 0;
        // 			$total_lastyear_all_orders_num = 0;
        // 			$total_lastyear_all_orders_total = 0;
        $total_first_orders_count_customer = 0;
        $total_first_orders_count_order_total = 0;
        $total_repeat_orders_count_customer = 0;
        $total_repeat_orders_count_order_total = 0;
        // 			$total_mobile_orders_num = 0;
        // 			$total_mobile_orders_num_percent = 0;
        // 			$total_mobile_orders_total = 0;
        // 			$total_mobile_orders_total_percent = 0;
        $total_device_orders_num_percent = 0;
        $total_device_orders_total_percent = 0;
        
        foreach($array_export as $array_export_key => $array_export_value) {
            $starttime_query = $stoptime_query = "0000-00-00 00:00:00";
            $all_orders = new stdClass();
            $all_orders->fields = array();
            if(!empty($section_type)) {
                $all_orders->fields = $array_export_value;

                foreach ($wm_all_orders_origin  as $wm_key => $wm_info){
                    if($wm_info['date_purchased_day'] == $array_export_value['data_key']){
                        $wm_all_orders->fields = $wm_info;
                    }
                }

//			  	$wm_all_orders->fields = $wm_all_orders_origin[$array_export_key];
                $starttime_query = $array_export_value['data_key'] . " 00:00:00";
                $stoptime_query = $array_export_value['data_key'] . " 23:59:59";
                
            } else {
                $languages_id_query = $array_export_value['data_key'];
                $all_orders = get_all_orders_query($starttime, $stoptime, $languages_id_query, $device_type);
                $wm_all_orders = get_all_orders_query($starttime, $stoptime, $languages_id_query, 0);
                $starttime_query = $starttime;
                $stoptime_query = $stoptime;
            }
            
            if ($all_orders->fields['orders_num'] > 0) {
                $table_display[] = true;
            }
            
            
            
            // 				$lastyear_all_orders = get_all_orders_query(date('Y-m-d H:i:s',strtotime("$starttime_query - 1 year")), date('Y-m-d H:i:s',strtotime("$stoptime_query - 1 year")), $languages_id_query);
            $first_orders = get_customers_first_order($starttime_query, $stoptime_query, '0000-00-00 00:00:00',$languages_id_query, $device_type);
            $repeat_orders = get_customers_old_order($starttime_query, $stoptime_query, '0000-00-00 00:00:00',$languages_id_query, $device_type);
            // 				$mobile_orders = get_all_orders_query($starttime_query, $stoptime_query, $languages_id_query, 1);
            
            $total_all_orders_num += (int)$all_orders->fields['orders_num'];
            $total_all_orders_total += round($all_orders->fields['total'], 2);
            $total_device_orders_num += $wm_all_orders->fields['orders_num'];
            $total_device_orders_total += $wm_all_orders->fields['total'];
            $total_all_customers_num += (int)$all_orders->fields['customers_num'];
            // 				$total_lastyear_all_orders_num += (int)$lastyear_all_orders->fields['orders_num'];
            // 				$total_lastyear_all_orders_total += round($lastyear_all_orders->fields['total'], 2);
            $total_first_orders_count_customer += (int)$first_orders->fields['count_customer'];
            $total_first_orders_count_order += (int)$first_orders->fields['count_order'];
            $total_first_orders_count_order_total += round($first_orders->fields['count_order_total'],2);
            $total_repeat_orders_count_customer += (int)$repeat_orders['count_customer'];
            $total_repeat_orders_count_order += (int)$repeat_orders['count_order'];
            $total_repeat_orders_count_order_total += round($repeat_orders['count_order_total'],2);
            // 				$total_mobile_orders_num += (int)$mobile_orders->fields['orders_num'];
            // 				$total_mobile_orders_num_percent = round(($total_mobile_orders_num / $total_all_orders_num)*100, 2).'%';
            // 				$total_mobile_orders_total += round($mobile_orders->fields['total'],2);
            // 				$total_mobile_orders_total_percent = round(($total_mobile_orders_total / $total_all_orders_total)*100, 2).'%';
            $total_device_orders_num_percent = round(((int)$all_orders->fields['orders_num'] / $wm_all_orders->fields['orders_num'])*100, 2).'%';
            $total_device_orders_total_percent = round(($all_orders->fields['total'] / $wm_all_orders->fields['total'])*100, 2).'%';
            
            $str.='<tr>
						<td>'.$array_export_value['data_name'] .'</td>
						<td>'.(int)$all_orders->fields['orders_num'].'</td>
						<td>'.round($all_orders->fields['total'], 2).'</td>
						<td>'.(int)$all_orders->fields['customers_num'].'</td>
						<td>'.(int)$first_orders->fields['count_customer'].'</td>
						<td>'.(int)$first_orders->fields['count_order'].'</td>
						<td>'.round($first_orders->fields['count_order_total'],2).'</td>
						<td>'.(int)$repeat_orders['count_customer'].'</td>
						<td>'.(int)$repeat_orders['count_order'].'</td>
						<td>'.round($repeat_orders['count_order_total'],2).'</td>
                        <td>'.$total_device_orders_num_percent.'</td>
                        <td>'.$total_device_orders_total_percent.'</td>
					    </tr>';
        }

        if(!empty($section_type)) {
            $total_device_orders_num = 0;
            $total_device_orders_total = 0;
            foreach ($wm_all_orders_origin as $wm_key => $wm_info) {
                $total_device_orders_num += $wm_info['orders_num'];
                $total_device_orders_total += $wm_info['total'];
            }
        }

        $total_device_orders_num_percent_total = round(($total_all_orders_num / $total_device_orders_num)*100, 2);
        $total_device_orders_total_percent_total = round(($total_all_orders_total / $total_device_orders_total)*100, 2);
        
        $str .= '<tr>
						<td>总计</td>
						<td>'.$total_all_orders_num.'</td>
						<td>'.$total_all_orders_total.'</td>
						<td>'.$total_all_customers_num.'</td>
						<td>'.$total_first_orders_count_customer.'</td>
						<td>'.$total_first_orders_count_order.'</td>
						<td>'.$total_first_orders_count_order_total.'</td>
						<td>'.$total_repeat_orders_count_customer.'</td>
						<td>'.$total_repeat_orders_count_order.'</td>
						<td>'.$total_repeat_orders_count_order_total.'</td>
                        <td>'.$total_device_orders_num_percent_total.'%</td>
						<td>'.$total_device_orders_total_percent_total.'%</td>
					    </tr>';
        $str.='</table>';
        
        
        
        if($_POST['action'] == 'get_excel' && empty($compare_time)){
            
            outputXlsHeader($str,"Doreenbeads订单数据(" . $starttime .'--'. $stoptime . ")");
        }
        //print_r($order_date_tongqi);exit;
    }elseif ( isset($count_type) && $count_type == 'pending_count' ) {
        $str = '';
        $str.=$starttime . '-' . $stoptime.'<br/><br/>';
        $str.='<table border="0" class="info_table" valign="top" >
			<tr>
				<th>' . $section_type_title . '</th>
				<th>总订单数</th>
				<th>总下单金额(USD)</th>
				<th>Pending订单数</th>
				<th>Pending订单数量占比</th>
				<th>Pending订单总金额(USD)</th>
				<th>Pending订单金额占比</th>
				<th>自动取消订单</th>
				<th>自动取消数量占比</th>
				<th>自动取消订单总金额(USD)</th>
				<th>自动取消订单总金额占比</th>
			</tr>';
        
        $all_orders = array();
        $pending_array = array();
        $auto_cancel_array = array();
        $pending_orders_num = 0;
        $pending_total = 0;
        $auto_cancel_orders_num = 0;
        $auto_cancel_total = 0;
        
        //for($j = 0, $n = sizeof ( $languages ); $j < $n; $j ++) {
        
        foreach($array_export as $array_export_key => $array_export_value) {
            
            $starttime_query = $stoptime_query = "0000-00-00 00:00:00";
            $all_orders = new stdClass();
            $all_orders->fields = array();
            if(!empty($section_type)) {
                $all_orders->fields = $array_export_value;
                $starttime_query = $array_export_value['data_key'] . " 00:00:00";
                $stoptime_query = $array_export_value['data_key'] . " 23:59:59";
                
            } else {
                $languages_id_query = $array_export_value['data_key'];
                $all_orders = get_all_orders_query($starttime, $stoptime, $languages_id_query, $device_type , true);
                $starttime_query = $starttime;
                $stoptime_query = $stoptime;
            }
            
            if ($all_orders->fields['orders_num'] > 0) {
                $table_display[] = true;
            }
            
            
            $all_orders = get_all_orders_query($starttime_query, $stoptime_query, $languages_id_query, $device_type , true);
            $pending_array = get_all_status_orders($starttime_query, $stoptime_query, $languages_id_query, 1, false, $device_type);
            $auto_cancel_array = get_all_status_orders($starttime_query, $stoptime_query, $languages_id_query, 0, true, $device_type);
            
            $total_all_orders_num += (int)$all_orders->fields['orders_num'];
            $total_all_orders_total += round($all_orders->fields['total'], 2);
            $pending_orders_num += (int)$pending_array->fields['orders_num'];
            $pending_total += round($pending_array->fields['total'], 2);
            $auto_cancel_orders_num += (int)$auto_cancel_array->fields['orders_num'];
            $auto_cancel_total += round($auto_cancel_array->fields['total'], 2);
            
            if ($all_orders->fields['orders_num'] > 0) {
                $table_display[] = true;
            }
            
            $str.='<tr>
				<td>'.$array_export_value['data_name'] .'</td>
				<td>'.(int)$all_orders->fields['orders_num'].'</td>
				<td>'.round($all_orders->fields['total'], 2).'</td>
				<td>'.(int)$pending_array->fields['orders_num'].'</td>
				<td>'.round(($pending_array->fields['orders_num'] / $all_orders->fields['orders_num'])*100, 2).'%</td>
				<td>'.round($pending_array->fields['total'], 2).'</td>
				<td>'.round(($pending_array->fields['total'] / $all_orders->fields['total'])*100, 2).'%</td>
				<td>'.(int)$auto_cancel_array->fields['orders_num'].'</td>
				<td>'.round(($auto_cancel_array->fields['orders_num'] / $all_orders->fields['orders_num'])*100, 2).'%</td>
				<td>'.round($auto_cancel_array->fields['total'], 2).'</td>
				<td>'.round(($auto_cancel_array->fields['total'] / $all_orders->fields['total'])*100, 2).'%</td>
			    </tr>';
        }
        
        $str .= '<tr>
				<td>总计</td>
				<td>'.$total_all_orders_num.'</td>
				<td>'.$total_all_orders_total.'</td>
				<td>'.$pending_orders_num.'</td>
				<td>'.round(($pending_orders_num / $total_all_orders_num)*100, 2).'%</td>
				<td>'.$pending_total.'</td>
				<td>'.round(($pending_total / $total_all_orders_total)*100, 2).'%</td>
				<td>'.$auto_cancel_orders_num.'</td>
				<td>'.round(($auto_cancel_orders_num / $total_all_orders_num)*100, 2).'%</td>
				<td>'.$auto_cancel_total.'</td>
				<td>'.round(($auto_cancel_total / $total_all_orders_total)*100, 2).'%</td>
			    </tr>';
        $str.='</table>';
        
        if($_POST['action'] == 'get_excel' && empty($compare_time)){
            
            outputXlsHeader($str,"Doreenbeads pending订单数据(" . $starttime .'--'. $stoptime . ")");
        }
        
    }
    
}
if(!empty($compare_time) && isset($_POST['action']) && ($_POST['action'] == 'search_status' || $_POST['action'] == 'get_excel')){
    $languages_id_query = null;
    if($languages_id_all != "20") {
        $languages_id_query = implode(",", $languages_id);
    }
    $languages_id_selected = "," . $languages_id_query . ",";
    
    
    $array_export = array();
    if(!empty($section_type)) {
        $all_orders = get_all_orders_query_group($compare_start_time, $compare_stop_time, $languages_id_query, $device_type);
        $wm_all_orders_origin = get_all_orders_query_group($compare_start_time, $compare_stop_time, $languages_id_query, 0);
        
        foreach($all_orders as $all_orders_key => $all_orders_value) {
            $array_export[$all_orders_key]['data_key'] = $all_orders_value['date_purchased_day'];
            $array_export[$all_orders_key]['data_name'] = $all_orders_value['date_purchased_day'];
            $array_export[$all_orders_key]['orders_num'] = $all_orders_value['orders_num'];
            $array_export[$all_orders_key]['total'] = $all_orders_value['total'];
            $array_export[$all_orders_key]['customers_num'] = $all_orders_value['customers_num'];
        }
    } else {
        for($j = 0, $n = sizeof ( $languages ); $j < $n; $j ++) {
            $array_export[$j]['data_key'] = $languages[$j]['id'];
            $array_export[$j]['data_name'] = $languages[$j]['name'];
        }
    }
                
    if(isset($count_type) && $count_type == 'customers_count'){
        $str1 = '';
        $str1.= $shuju.'('.$compare_start_time .'--'. $compare_stop_time.')<br/><br/>';
        $str1.='<table border="0" class="info_table" valign="top" >
            <tr>
                <th>' . $section_type_title . '</th>
                <th>总订单数</th>
                <th>总下单金额(USD)</th>
                <th>总客户数</th>
                <th>首次购买客户数</th>
                <th>首次购买客户的订单数</th>
                <th>首次客户订单总金额(USD)</th>
                <th>重复购买客户数</th>
                <th>重复购买客户的订单数</th>
                <th>重复客户订单总金额(USD)</th>
                <th>订单数占总占比</th>
                <th>订单金额占总占比</th>
            </tr>';

            $all_orders = array();
//          $lastyear_all_orders = array();
            $first_orders = array();
            $repeat_orders = array();
            $mobile_orders = array();

            $total_all_orders_num = 0;
            $total_all_orders_total = 0;
            $total_all_customers_num = 0;
            $total_device_orders_num = 0;
            $total_device_orders_total = 0;
            $total_all_customers_num = 0;
// 			$total_lastyear_all_orders_num = 0;
// 			$total_lastyear_all_orders_total = 0;
            $total_first_orders_count_customer = 0;
            $total_first_orders_count_orders = 0;
            $total_first_orders_count_order_total = 0;
            $total_repeat_orders_count_customer = 0;
            $total_repeat_orders_count_orders = 0;
            $total_repeat_orders_count_order_total = 0;
// 			$total_mobile_orders_num = 0;
// 			$total_mobile_orders_num_percent = 0;
// 			$total_mobile_orders_total = 0;
// 			$total_mobile_orders_total_percent = 0;
            $total_device_orders_num_percent = 0;
            $total_device_orders_total_percent = 0;
            
            foreach($array_export as $array_export_key => $array_export_value) {
                $starttime_query = $stoptime_query = "0000-00-00 00:00:00";
                $all_orders = new stdClass();
                $all_orders->fields = array();
                if(!empty($section_type)) {
                    $all_orders->fields = $array_export_value;
                    $wm_all_orders->fields = $wm_all_orders_origin[$array_export_key];
                    $compare_starttime_query = $array_export_value['data_key'] . " 00:00:00";
                    $compare_stoptime_query = $array_export_value['data_key'] . " 23:59:59";
                
                } else {
                    $languages_id_query = $array_export_value['data_key'];
                    $all_orders = get_all_orders_query($compare_start_time, $compare_stop_time, $languages_id_query, $device_type);
                    $wm_all_orders = get_all_orders_query($compare_start_time, $compare_stop_time, $languages_id_query, 0);
                    $compare_starttime_query = $compare_start_time;
                    $compare_stoptime_query = $compare_stop_time;
                }
                
                if ($all_orders->fields['orders_num'] > 0) {
                    $table_display[] = true;
                    $table1_display[] = true;
                }
                
                
                
//              $lastyear_all_orders = get_all_orders_query(date('Y-m-d H:i:s',strtotime("$starttime_query - 1 year")), date('Y-m-d H:i:s',strtotime("$stoptime_query - 1 year")), $languages_id_query);
                $first_orders = get_customers_first_order($compare_starttime_query, $compare_stoptime_query, '0000-00-00 00:00:00',$languages_id_query, $device_type);
                $repeat_orders = get_customers_old_order($compare_starttime_query, $compare_stoptime_query, '0000-00-00 00:00:00',$languages_id_query, $device_type);
//              $mobile_orders = get_all_orders_query($starttime_query, $stoptime_query, $languages_id_query, 1);
                
                $total_all_orders_num += (int)$all_orders->fields['orders_num'];
                $total_all_orders_total += round($all_orders->fields['total'], 2);
                $total_device_orders_num += $wm_all_orders->fields['orders_num'];
                $total_device_orders_total += $wm_all_orders->fields['total'];
                $total_all_customers_num += (int)$all_orders->fields['customers_num'];
//              $total_lastyear_all_orders_num += (int)$lastyear_all_orders->fields['orders_num'];
//              $total_lastyear_all_orders_total += round($lastyear_all_orders->fields['total'], 2);
                $total_first_orders_count_customer += (int)$first_orders->fields['count_customer'];
                $total_first_orders_count_orders += (int)$first_orders->fields['count_order'];
                $total_first_orders_count_order_total += round($first_orders->fields['count_order_total'],2);
                $total_repeat_orders_count_customer += (int)$repeat_orders['count_customer'];
                $total_repeat_orders_count_orders += (int)$repeat_orders['count_order'];
                $total_repeat_orders_count_order_total += round($repeat_orders['count_order_total'],2);
//              $total_mobile_orders_num += (int)$mobile_orders->fields['orders_num'];
//              $total_mobile_orders_num_percent = round(($total_mobile_orders_num / $total_all_orders_num)*100, 2).'%';
//              $total_mobile_orders_total += round($mobile_orders->fields['total'],2);
//              $total_mobile_orders_total_percent = round(($total_mobile_orders_total / $total_all_orders_total)*100, 2).'%';
                $total_device_orders_num_percent = round(((int)$all_orders->fields['orders_num'] / $wm_all_orders->fields['orders_num'])*100, 2).'%';
                $total_device_orders_total_percent = round(($all_orders->fields['total'] / $wm_all_orders->fields['total'])*100, 2).'%';
                
                  $str1.='<tr>
                        <td>'.$array_export_value['data_name'] .'</td>
                        <td>'.(int)$all_orders->fields['orders_num'].'</td>
                        <td>'.round($all_orders->fields['total'], 2).'</td>
                        <td>'.(int)$all_orders->fields['customers_num'].'</td>
                        <td>'.(int)$first_orders->fields['count_customer'].'</td>
                        <td>'.(int)$first_orders->fields['count_order'].'</td>
                        <td>'.round($first_orders->fields['count_order_total'],2).'</td>
                        <td>'.(int)$repeat_orders['count_customer'].'</td>
                        <td>'.(int)$repeat_orders['count_order'].'</td>
                        <td>'.round($repeat_orders['count_order_total'],2).'</td>
                        <td>'.$total_device_orders_num_percent.'</td>
                        <td>'.$total_device_orders_total_percent.'</td>
                        </tr>';
            }

            if(!empty($section_type)) {
                $total_device_orders_num = 0;
                $total_device_orders_total = 0;
                foreach ($wm_all_orders_origin as $wm_key => $wm_info) {
                    $total_device_orders_num += $wm_info['orders_num'];
                    $total_device_orders_total += $wm_info['total'];
                }
            }

            $total_device_orders_num_percent_total = round(($total_all_orders_num / $total_device_orders_num)*100, 2);
            $total_device_orders_total_percent_total = round(($total_all_orders_total / $total_device_orders_total)*100, 2);

            $str1 .= '<tr>
                        <td>总计</td>
                        <td>'.$total_all_orders_num.'</td>
                        <td>'.$total_all_orders_total.'</td>
                        <td>'.$total_all_customers_num.'</td>
                        <td>'.$total_first_orders_count_customer.'</td>
                        <td>'.$total_first_orders_count_orders.'</td>
                        <td>'.$total_first_orders_count_order_total.'</td>
                        <td>'.$total_repeat_orders_count_customer.'</td>
                        <td>'.$total_repeat_orders_count_orders.'</td>
                        <td>'.$total_repeat_orders_count_order_total.'</td>
                        <td>'.$total_device_orders_num_percent_total.'%</td>
                        <td>'.$total_device_orders_total_percent_total.'%</td>
                        </tr>';
            $str1.='</table>';

            

        if($_POST['action'] == 'get_excel' && !empty($compare_time)){
            
            outputXlsHeader($str.'<br><br>'.$str1,"Doreenbeads订单数据(".$shuju . $starttime . '-' . $stoptime . ")");
        }
        //print_r($order_date_tongqi);exit;
    }elseif ( isset($count_type) && $count_type == 'pending_count' ) {
        $str1 = '';
        $str1.= $shuju.'('.$compare_start_time .'--'. $compare_stop_time.')<br/><br/>';
        $str1.='<table border="0" class="info_table" valign="top" >
            <tr>
                <th>' . $section_type_title . '</th>
                <th>总订单数</th>
                <th>总下单金额(USD)</th>
                <th>Pending订单数</th>
                <th>Pending订单数量占比</th>
                <th>Pending订单总金额(USD)</th>
                <th>Pending订单金额占比</th>
                <th>自动取消订单</th>
                <th>自动取消数量占比</th>
                <th>自动取消订单总金额(USD)</th>
                <th>自动取消订单总金额占比</th>
            </tr>';

        $all_orders = array();
        $pending_array = array();
        $auto_cancel_array = array();
        $pending_orders_num = 0;
        $pending_total = 0;
        $auto_cancel_orders_num = 0;
        $auto_cancel_total = 0;
        $total_all_orders_num = 0;
        $total_all_orders_totals = 0;
        $pending_orders_num = 0;
        $pending_total = 0;
        $auto_cancel_orders_num = 0;
        $auto_cancel_total = 0;

        //for($j = 0, $n = sizeof ( $languages ); $j < $n; $j ++) {
        
        foreach($array_export as $array_export_key => $array_export_value) {
                    
            $compare_starttime_query = $compare_stoptime_query = "0000-00-00 00:00:00";
            $all_orders = new stdClass();
            $all_orders->fields = array();
            if(!empty($section_type)) {
                $all_orders->fields = $array_export_value;
                $compare_starttime_query = $array_export_value['data_key'] . " 00:00:00";
                $compare_stoptime_query = $array_export_value['data_key'] . " 23:59:59";
            
            } else {
                $languages_id_query = $array_export_value['data_key'];
                $all_orders = get_all_orders_query($compare_start_time, $compare_stop_time, $languages_id_query, $device_type , true);
                $compare_starttime_query = $compare_start_time;
                $compare_stoptime_query = $compare_stop_time;
            }
            
            if ($all_orders->fields['orders_num'] > 0) {
                $table_display[] = true;
                $table1_display[] = true;
            }


            $all_orders = get_all_orders_query($compare_starttime_query, $compare_stoptime_query, $languages_id_query, $device_type , true);
            $pending_array = get_all_status_orders($compare_starttime_query, $compare_stoptime_query, $languages_id_query, 1, false, $device_type);
            $auto_cancel_array = get_all_status_orders($compare_starttime_query, $compare_stoptime_query, $languages_id_query, 0, true, $device_type);

            $total_all_orders_num += (int)$all_orders->fields['orders_num'];
            $total_all_orders_totals += round($all_orders->fields['total'], 2);          
            $pending_orders_num += (int)$pending_array->fields['orders_num'];
            $pending_total += round($pending_array->fields['total'], 2);
            $auto_cancel_orders_num += (int)$auto_cancel_array->fields['orders_num'];
            $auto_cancel_total += round($auto_cancel_array->fields['total'], 2);

            if ($all_orders->fields['orders_num'] > 0) {
                $table_display[] = true;
                $table1_display[] = true;
            }

            $str1.='<tr>
                <td>'.$array_export_value['data_name'] .'</td>
                <td>'.(int)$all_orders->fields['orders_num'].'</td>
                <td>'.round($all_orders->fields['total'], 2).'</td>
                <td>'.(int)$pending_array->fields['orders_num'].'</td>
                <td>'.round(($pending_array->fields['orders_num'] / $all_orders->fields['orders_num'])*100, 2).'%</td>
                <td>'.round($pending_array->fields['total'], 2).'</td>  
                <td>'.round(($pending_array->fields['total'] / $all_orders->fields['total'])*100, 2).'%</td>
                <td>'.(int)$auto_cancel_array->fields['orders_num'].'</td>
                <td>'.round(($auto_cancel_array->fields['orders_num'] / $all_orders->fields['orders_num'])*100, 2).'%</td>
                <td>'.round($auto_cancel_array->fields['total'], 2).'</td>  
                <td>'.round(($auto_cancel_array->fields['total'] / $all_orders->fields['total'])*100, 2).'%</td>        
                </tr>';
        }

            $str1 .= '<tr>
                <td>总计</td>
                <td>'.$total_all_orders_num.'</td>
                <td>'.$total_all_orders_totals.'</td>
                <td>'.$pending_orders_num.'</td>
                <td>'.round(($pending_orders_num / $total_all_orders_num)*100, 2).'%</td>
                <td>'.$pending_total.'</td>
                <td>'.round(($pending_total / $total_all_orders_total)*100, 2).'%</td>
                <td>'.$auto_cancel_orders_num.'</td>
                <td>'.round(($auto_cancel_orders_num / $total_all_orders_num)*100, 2).'%</td>
                <td>'.$auto_cancel_total.'</td>
                <td>'.round(($auto_cancel_total / $total_all_orders_total)*100, 2).'%</td>
                </tr>';
            $str1.='</table>';

        if($_POST['action'] == 'get_excel' && !empty($compare_time)){
            
            outputXlsHeader($str.'<br><br>'.$str1,"Doreenbeads pending订单数据(".$shuju . $starttime . '-' . $stoptime . ")");
        }

    }
    
}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">

<html <?php echo HTML_PARAMS; ?>>

<head>

<meta http-equiv="Content-Type"
	content="text/html; charset=<?php echo CHARSET; ?>">

<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css"
	href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript" src="includes/jquery.js"></script>
<?php echo "<script> window.lang_wdate='".$_SESSION['languages_code']."'; </script>";?>
<script type="text/javascript" src="../includes/templates/cherry_zen/jscript/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
	function search_status(){
		document.products_status.action.value = 'search_status';
		document.products_status.submit();
	}
	function get_excel(){
		document.products_status.action.value = 'get_excel';
		document.products_status.submit();
	}
	$(function() {
		$(".jq_section_type").click(function() {
			if($(this).val() == "") {
				$(".jq_languages_id").hide();
			} else {
				$(".jq_languages_id").show();
			}
		});
		
		$(".jq_languages_id_all").click(function() {
			if($(this).attr("checked") == "checked") {
				$(".jq_languages_id").attr("checked", "checked");
			} else {
				$(".jq_languages_id").removeAttr("checked");
			}
		});
		
		$(".jq_languages_id").click(function() {
			var length = $(".jq_languages_id").length - 1;
			var checkedLenth = $(".jq_languages_id:checked").length;
			if(length == checkedLenth) {
				$(".jq_languages_id_all").attr("checked", "checked");
			} else {
				$(".jq_languages_id_all").removeAttr("checked");
			}
		});
        $(".compare_time").click(function(){
            
          if($(this).attr("checked") == "checked" ) {
       
                $(".compare_time").attr("checked", "checked");
            } else {
                $(".compare_time").removeAttr("checked");
            }
        });
	});
</script>
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
<style>
#products_upload_main {
	padding: 10px;
}

#products_upload_main p {
	margin: 0px;
}

.inputdiv {
	margin: 20px 0 30px 20px;
}

.headertitle {
	font-size: 15px;
	padding: 0 0 5px;
}

.inputdiv {
	font-size: 12px;
}

.inputdiv  .filetips {
	color: #FF6600;
	font-size: 12px;
	padding: 5px 0;
}

.inputdiv  .filetips a {
	color: #0000ff;
	text-decoration: underline;
}

.submitdiv {
	margin-top: 8px;
}

.submitdiv input {
	font-size: 16px;
	width: 100px;
}

.info_table{font-size:12px;width:100%;text-align: center;border-spacing: 0px;border: 1px solid #aaa;border-collapse:collapse}
.info_table tr{border: 1px solid #aaa;background-color: #fff;height: 30px;}
.info_table tr td,th{border: 1px solid #aaa;}
</style>
</head>
<body onLoad="init()">
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<div style="padding: 10px;">
		<p class="pageHeading">统计订单情况（不包含panduo.com.cn、163.com、qq.com邮箱结尾的数据）</p>
		<div style="padding-left: 50px;">
			<form  name="products_status" id="products_status" action="<?php echo zen_href_link(FILENAME_ORDER_DATA,zen_get_all_get_params(array()));?>" method="post">
			<input type="hidden" name="action" value=""/>
			设备类型：
			<label><input type="radio" name="device_type" checked value="0" <?php echo ($device_type == '0' || !$device_type) ? 'checked' : ' '; ?> />W&M端</label>
			&nbsp;
			<label><input type="radio" name="device_type"  value="10" <?php echo $device_type == '10' ? 'checked' : ' '; ?>/>W端</label>
			&nbsp;
			<label><input type="radio" name="device_type"  value="20" <?php echo $device_type == '20' ? 'checked' : ' '; ?>/>M端</label>
			<br/><br/>
			数据类型：
			<label><input type="radio" class="jq_section_type" name="section_type" checked value="" <?php echo empty($section_type) ? 'checked' : ' '; ?> />区间汇总</label>
			&nbsp;
			<label><input type="radio" class="jq_section_type" name="section_type"  value="10" <?php echo $section_type == '10' ? 'checked' : ' '; ?>/>区间明细</label>
			<br/><br/>
			<span class="jq_languages_id" style="<?php echo $languages_id_span_display;?>">
			统计站点：
			<label><input class="jq_languages_id_all" name="languages_id_all" value="20" type="checkbox"<?php if($languages_id_all == "20") {echo " checked='checked'";}?> <?php echo $readonly;?>/>所有</label>&nbsp;&nbsp;
			<?php
            	$languages_code_array = array();
				foreach($languages as $value){
					$checked = "";
					if($languages_id_all == "20" || strstr($languages_id_selected, "," . $value['id'] . ",") != "") {
						$checked = " checked='checked'";
					}
					array_push($languages_code_array, $value['code']);
					echo '<label><input class="jq_languages_id" name="languages_id[]" value="' . $value['id'] . '" type="checkbox"' . $checked . $readonly . '>' . $value['name'] . '</label>&nbsp;&nbsp;&nbsp;&nbsp;';
				}
			?>
			<br/><br/>
			</span>
			统计类型：
			<label><input type="radio" name="count_type" checked value="customers_count" <?php echo $count_type == 'customers_count' ? 'checked' : ' '; ?> />客户购买情况统计</label>
			&nbsp;
			<label><input type="radio" name="count_type"  value="pending_count" <?php echo $count_type == 'pending_count' ? 'checked' : ' '; ?>/>Pending和自动取消订单统计</label>
			<br/><br/>
			<!-- 
			请选择客户类型：
			<input type="radio" name="from_customer" id="new_customer"  value="0" <?php if(!$from_customer) echo 'checked';?> /><label for="new_customer">首次购买</label>
			&nbsp;
			<input type="radio" name="from_customer" id="old_customer" <?php if($from_customer) echo 'checked';?> value="1"/><label for="old_customer">重复购买</label>
			<br/><br/> -->
			
			 时间范围:&nbsp;<?php 
			 //echo str_replace("<input","<input class='Wdate' style='width:125px;'",zen_draw_input_field('starttime', (isset($_POST['starttime']))?$_POST['starttime']: date('Y-m-d',strtotime("-1 day")), 'class = "123" onClick="WdatePicker();"  ')) .' 00:00:00'; 
			 echo zen_draw_input_field('starttime', (isset($_POST['starttime']))?$_POST['starttime']: date('Y-m-d',strtotime("-1 day")).' 00:00:00', "class = 'Wdate' style='width:150px;' onClick='WdatePicker({dateFmt:&quot;yyyy-MM-dd HH:mm:ss&quot;});'   ");
			?>
			<?php
			 //echo str_replace("<input","<input class='Wdate' style='width:125px;'",zen_draw_input_field('stoptime', (isset($_POST['stoptime']))?$_POST['stoptime']: date('Y-m-d',strtotime("-1 day")), 'onClick="WdatePicker();"  ')).' 23:59:59'; 
			 echo zen_draw_input_field('stoptime', (isset($_POST['stoptime']))?$_POST['stoptime']: date('Y-m-d',strtotime("-1 day")) .' 23:59:59', "class = 'Wdate' style='width:150px;' onClick='WdatePicker({dateFmt:&quot;yyyy-MM-dd HH:mm:ss&quot;});'   ");
			?>
            <?php
            $time_str_arr = array(array('id' => 0, 'text' => '环比数据'),
                      array('id' => 1, 'text' => '同比数据'),
                      array('id' => 2, 'text' => '自定义数据')
                     );
            ?>
			<br/><br/>
            <label><input class="compare_time" name="compare_time"  type="checkbox" style="margin-left:-40px;" value="checked" <?php echo $compare_time ; ?> >比较时间范围： <?php echo zen_draw_pull_down_menu('time', $time_str_arr , $_POST['time'] ? $_POST['time'] : '' ,  'value="selected " id="shuju_type" style="width: 100px;height: 20px;"')?>
            </label>
            <br><br/>
            <?php
            echo zen_draw_input_field('starttimes', $compare_start_time ? $compare_start_time : '', "class = 'compare_strattime' style='width:150px;margin-left:54px;' onClick='WdatePicker({dateFmt:&quot;yyyy-MM-dd HH:mm:ss&quot;});'    ");
            ?> 一
            <?php
            echo zen_draw_input_field('stoptimes', $compare_stop_time ? $compare_stop_time : '', "class = 'compare_stoptime' style='width:150px;' onClick='WdatePicker({dateFmt:&quot;yyyy-MM-dd HH:mm:ss&quot;});'   ");
            // }
            ?>
            <br/><br/>
			<input type="hidden" name="downlaod_sql" value = "<?php echo $order_date_query_raw;?>"/>
			<input type="button" value="查询" onclick="search_status();"/>
			<input type="button" value="下载" onclick="get_excel();"/>
			</form>
			<br/><br/><br/>
			
			<?php  

			if ($starttime > $stoptime) {
				echo '请选择正确的时间';
			}elseif(!empty($table_display)){
				echo $str .'<br/><br/>';
            }else{?>
				没有记录！！
			<?php }?>
            <?php
            if (!empty($compare_time) && !empty($table_display)){   
             echo $str1;
            }
            ?>
		</div>
		
		
		
</div>
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</body>
</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>