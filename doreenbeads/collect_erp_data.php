<?php 
require('includes/application_top.php');

if(!isset($_GET['type']) || $_GET['type']==''){
	die('need action param');
}
$startime = microtime(true);
$startdate = date("Y-m-d H:i:s");
$process_type = $_GET['type'];
switch($process_type){
	case 'collect_order':
		$orders_query = $db->Execute("select orders_id from ".TABLE_ORDERS." 
				where orders_status=2 
				and is_exported=0 and payment_info not like '%:null%'
				and customers_email_address not like '%@panduo.com%'");

		while(!$orders_query->EOF){
			$check_exist = $db->Execute("select id from erp_notice_process where process_type=1 and item_id='".$orders_query->fields['orders_id']."' limit 1");
		
			if($check_exist->RecordCount()==0){
				$erp_data_array = array(
					'process_type'=>1,
					'item_id'=>$orders_query->fields['orders_id'],
					'weight'=>10,
					'is_processed'=>0,
					'date_added'=>'now()'
						
				);
				zen_db_perform('erp_notice_process', $erp_data_array);
				$db->Execute("update ".TABLE_ORDERS." set is_exported=1 where orders_id='".$orders_query->fields['orders_id']."'");
			}elseif($check_exist->RecordCount()>0){
				$db->Execute("update ".TABLE_ORDERS." set is_exported=1 where orders_id='".$orders_query->fields['orders_id']."'");				
			}
			
			$orders_query->MoveNext();
		}
		
		$hour = date("H");
		if(in_array($hour, array('09', '12'))) {
			//Tianwen.Wan20160407->修补自动导单遗漏
			$db->Execute("insert into erp_notice_process (process_type, item_id, weight, is_processed, date_added) select 1, orders_id, 10, 0, NOW() from ".TABLE_ORDERS." where date_purchased>FROM_UNIXTIME(UNIX_TIMESTAMP() - (86400 * 30)) and is_exported=1 and payment_info not like '%:null%' and orders_id not in(select item_id from erp_notice_process)");
		}
		
		break;
	default:
		break;	
		
}
echo 'success';
file_put_contents("log/crond_log/" . str_replace("/", "-", substr($_SERVER['PHP_SELF'], 1) . "_" . date("Ymd")) . ".txt", $startdate . "\t" . date("Y-m-d H:i:s") . "\t" . round((microtime(true) - $startime), 4) . "\t" . json_encode($_GET) . "\r\n", FILE_APPEND);
?>