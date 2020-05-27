<?php
/*	Mailchimp  
 * 	subscribe
 *  unsubscribe
 *  2014-08-27
 */
if (!defined('IS_ADMIN_FLAG')) {
	die('Illegal Access');
}

include_once(DIR_WS_CLASSES . 'MCAPI.class.php');
//include_once(DIR_WS_CLASSES . 'config.inc'); //contains username & password

class newsletter extends base{

	
	/*subscribe the newsletter
	 * @param int $customer_id use the id to get customer infomation
	 * */
	function subscribe($customer_id){
		include(DIR_WS_CLASSES . 'config.inc');
		$subscribe = true;
		global $db;
		if (zen_not_null($customer_id)) {
			$sql = "SELECT * FROM ".TABLE_CUSTOMERS." WHERE customers_id = ".$customer_id;
			$sql_result = $db->Execute($sql);
			if ($sql_result->RecordCount() > 0) {
				$firstname = $sql_result->fields['customers_firstname'];
				$lastname  = $sql_result->fields['customers_lastname'];
				$email_address = $sql_result->fields['customers_email_address'];
			}		
		}			
		if(    stristr($email_address,'163.com') 
			|| stristr($email_address,'126.com')
			|| stristr($email_address,'qq.com')
			|| stristr($email_address,'sina.com.cn')
			|| stristr($email_address,'sina.cn')
			|| stristr($email_address,'139.com')
			|| stristr($email_address,'souhu.com')
			|| stristr($email_address,'tom.com')){
			  $subscribe = false;
		}
		if($subscribe){
			$api = new MCAPI($apikey);
			if ($api->errorCode != '') {   /*be test   be Comments on Formal website*/
				// an error occurred while logging in
				echo "code:".$api->errorCode."\n";
				echo "msg :".$api->errorMessage."\n";
				die();
			}
			$optin = false; //yes, send optin emails
			$up_exist = true; // yes, update currently subscribed users
			$replace_int = false; // no, add interest, don't replace
			$groupings = $api->listInterestGroupings ( $listId );
			$user_comes_from=$checkIpAddress->countryCode; //get $groupings
			$shielding_ips=array('CN');
			$chinese_people=in_array($user_comes_from,$shielding_ips)?true:false;
			$lan = $chinese_people ? 1 : 0;			
			$groups = $groupings [$lan] ["groups"];
			$grouping_id = $groupings[$lan]['id'];//exit;
			$grouplength = sizeof ( $groups );
			$currentgroup = $groups [$grouplength - 1];
			//Adding group if the last group subscriber exceeds 3000
			$register_code = $db->Execute("select code from " . TABLE_LANGUAGES . " where languages_id = " . $lang_MC)->fields['code'];
			if ($currentgroup ['subscribers'] >= $grouplimit) {
				$partno = $grouplength + 1;
				$group_name = 'Part-' .$register_code.'-'. $partno;
				/*
				 if ($api->listInterestGroupAdd ( $listId, $group_name, $grouping_id )) {
				$grouplength += 1;
				} else if ($api->errorCode) {
				echo "Batch Subscribe failed!\n";
				echo "code:" . $api->errorCode . "\n";
				echo "msg :" . $api->errorMessage . "\n";
				die ();
				}
				*/
			}
			$partno = $grouplength;
			if($chinese_people){
				if($partno==1){
					$group = array (array ('id' => $grouping_id, 'groups' => 'Normal') );
				}else{
					$group = array (array ('id' => $grouping_id, 'groups' => 'Normal-'. $partno ) );
				}
			}else{
				$group = array (array ('id' => $grouping_id, 'groups' => 'Part-' .$register_code.'-1') );
			}
			$batch [0] = array ('EMAIL' => $email_address, 'FNAME' => $firstname, 'LNAME' => $lastname, 'GROUPINGS' => $group );
			$vals = $api->listBatchSubscribe ( $listId, $batch, $optin, $up_exist, $replace_int );
			if ($api->errorCode) {
				echo "Batch Subscribe failed!\n";
				echo "code:" . $api->errorCode . "\n";
				echo "msg :" . $api->errorMessage . "\n";
				die ();
			}
			
		}
	}
	
	/*unsubscribe the newsletter
	 * @param string $listId the list id to connect to. Get by calling lists()
	 * @param string $email_address the email address to unsubscribe  OR the email "id" returned from listMemberInfo, Webhooks, and Campaigns
     * @param boolean $delete_member flag to completely delete the member from your list instead of just unsubscribing, default to false
     * @param boolean $send_goodbye flag to send the goodbye email to the email address, defaults to true
     * @param boolean $send_notify flag to send the unsubscribe notification email to the address defined in the list email notification settings, defaults to true
	 * */
	function unsubscribe($email_address){	
		include(DIR_WS_CLASSES . 'config.inc');
		$api = new MCAPI($apikey);
		if ($api->errorCode != '') {
			// an error occurred while logging in
			echo "code:".$api->errorCode."\n";
			echo "msg :".$api->errorMessage."\n";
			die();
		}
		$delete_member = true; //boolean $delete_member flag to completely delete the member from your list instead of just unsubscribing, default to false
		$send_goodbye = false; //boolean $send_goodbye flag to send the goodbye email to the email address, defaults to true
		$send_notify = false; //$send_notify flag to send the unsubscribe notification email to the address defined in the list email notification settings, defaults to true 
		$groupings = $api->listInterestGroupings ( $listId );		
		$api->listUnsubscribe($listId,$email_address, $delete_member,$send_goodbye,  $send_notify);//删除客户  第三个参数true为删除，false为Unsubscribe 状态,第二个状态为是否发邮件
	}
	
	/*update a List Member's information using the MCAPI.php class and do some basic error checking.*/
	/**
	 * Edit the email address, merge fields, and interest groups for a list member. If you are doing a batch update on lots of users,
	 * consider using listBatchSubscribe() with the update_existing and possible replace_interests parameter.
	 *
	 * @section List Related
	 * @example mcapi_listUpdateMember.php
	 *
	 * @param string $id the list id to connect to. Get by calling lists()
	 * @param string $email_address the current email address of the member to update OR the "id" for the member returned from listMemberInfo, Webhooks, and Campaigns
	 * @param array $merge_vars array of new field values to update the member with.  See merge_vars in listSubscribe() for details.
	 * @param string $email_type change the email type preference for the member ("html" or "text").  Leave blank to keep the existing preference (optional)
	 * @param boolean $replace_interests flag to determine whether we replace the interest groups with the updated groups provided, or we add the provided groups to the member's interest groups (optional, defaults to true)
	* @return boolean true on success, false on failure. When using MCAPI.class.php, the value can be tested and error messages pulled from the MCAPI object
	*/	
	function updateMemberinfo($customer_id){
		include(DIR_WS_CLASSES . 'config.inc');
		$api = new MCAPI($apikey);
		global $db;
		if (zen_not_null($customer_id)) {
			$sql = "SELECT customers_firstname,customers_lastname,customers_email_address FROM ".TABLE_CUSTOMERS." WHERE customers_id = ".$customer_id;
			$sql_result = $db->Execute($sql);
			if ($sql_result->RecordCount() > 0) {
				$firstname = $sql_result->fields['customers_firstname'];
				$lastname  = $sql_result->fields['customers_lastname'];
				$email_address = $sql_result->fields['customers_email_address'];
			}
		}
		$merge_vars = array("FNAME"=>$firstname, "LNAME"=>$lastname );
	
		$api->listUpdateMember($listId, $email_address, $merge_vars, 'html', true);
	
		if ($api->errorCode){
			if($api->errorCode == 232) {  /*232该类用户没有订阅过            215该用户语言类别无法确定*/
				$new_newsletter = new newsletter();
				$new_newsletter->subscribe($customer_id);
			}elseif($api->errorCode == 215){
				$new_newsletter = new newsletter();
				$new_newsletter->unsubscribe($email_address);
				$new_newsletter->subscribe($customer_id);
			}else{
				echo "Unable to update member info!\n";
				echo "\tCode=".$api->errorCode."\n";
				echo "\tMsg=".$api->errorMessage."\n";
				die();
			}						
		}
	}	
}









