<?php

include_once('includes/application_top.php');
/*include_once(DIR_WS_CLASSES . 'Mailchimp.php');
include_once(DIR_WS_CLASSES . 'config.inc'); */

$first_name=$_POST['first'];
$last_name=$_POST['last'];
$email_address=zen_db_prepare_input($_POST['email']);

if ($first_name == '') {
	$first_name = substr($email_address,0,strrpos($email_address,'@'));
}
//  判断用户是否已经注册
$check_mailchimp_exist_query = $db->Execute("SELECT * FROM " . TABLE_CUSTOMERS_FOR_MAILCHIMP ." WHERE customers_for_mailchimp_email = '" . $email_address . "' AND subscribe_status = 10 LIMIT 1");
if ($check_mailchimp_exist_query->RecordCount() > 0) {
	$response['error'] = true;
	$response['error_message'] = TEXT_EMAIL_HAS_SUBSCRIBED;
}else{
	$response = customers_for_mailchimp_subscribe_event($email_address, 10, 10, array('firstname'=>$first_name, 'lastname'=>$last_name));
}
echo json_encode($response);

//error_reporting(E_ALL);
/*	$subscribe = true;
	if(stristr($email_address,'163.com') || stristr($email_address,'126.com')
								|| stristr($email_address,'qq.com')
								|| stristr($email_address,'sina.com.cn')
								|| stristr($email_address,'sina.cn')
								|| stristr($email_address,'139.com')
								|| stristr($email_address,'souhu.com')
								|| stristr($email_address,'tom.com')){
								$subscribe = false;
	}*/
	//if($subscribe){
				
			//$db->Execute("INSERT INTO  ".TABLE_CUSTOMERS_SUBSCRIBE." (`subscribe_email` ,`subscribe_date_add` ,`subscribe_type`,`languages_id`)VALUES ('".$email_address."',  now(),  '2',".$_SESSION['languages_id'].");");
			
			/*$api = new Mailchimp( $apikey );
				if ($api->errorCode != '') {
					echo "code:" . $api->errorCode . "\n";
					echo "msg :" . $api->errorMessage . "\n";
					die ();
				}
				$optin = false; //yes, send optin emails
				$up_exist = true; // yes, update currently subscribed users
				$replace_int = false; // no, add interest, don't replace
				
				$members_info = $api->getMembers($listId);//print_r($members_info);*/

				// get list interests
				//$interestGroupings = $api->interestGroupings($listId);//print_r($interestGroupings);
				/*if (empty($members_info) || $members_info['status'] == 404 ) {
					$data_array = array();
					
					$subscribe_info = $api->subscribe($listId, $email_address, array('FNAME'=>'fname', 'LNAME'=>'lname'));
					print_r($subscribe_info);
				}*/	

/*				$user_comes_from=$checkIpAddress->countryCode;
				$shielding_ips=array('CN');
				$chinese_people=in_array($user_comes_from,$shielding_ips)?true:false;				
				
				$lan = $chinese_people ? 1 : 0;
				
				$groups = $groupings [$lan] ["groups"];
				$grouping_id = $groupings[$lan]['id'];//exit;
				$grouplength = sizeof ( $groups );
				$currentgroup = $groups [$grouplength - 1];
				//Adding group if the last group subscriber exceeds 3000
				if ($currentgroup ['subscribers'] >= $grouplimit) {
					$partno = $grouplength + 1;
					if($chinese_people){
						$group_name = 'Normal-'. $partno;
					}else{
						$group_name = 'Part-' .$_SESSION['languages_code'].'-'. $partno;
					}
					
					if ($api->listInterestGroupAdd ( $listId, $group_name, $grouping_id )) {
						$grouplength += 1;
					} else if ($api->errorCode) {
						echo "Batch Subscribe failed!\n";
						echo "code:" . $api->errorCode . "\n";
						echo "msg :" . $api->errorMessage . "\n";
						die ();
					}
					
				}
				$partno = $grouplength;
				if($chinese_people){
					if($partno==1){
						$group = array (array ('id' => $grouping_id, 'groups' => 'Normal') );
					}else{
						$group = array (array ('id' => $grouping_id, 'groups' => 'Normal-'. $partno ) );
					}
				}else{
					    $group = array (array ('id' => $grouping_id, 'groups' => 'Part-' .$_SESSION['languages_code'].'-1') );
				}
				$batch [0] = array ('EMAIL' => $email_address, 'FNAME' => $first_name, 'LNAME' => $last_name, 'GROUPINGS' => $group );
				//$response = $api->subscribe ( '3dc67a44eb', $batch, $optin, $up_exist, $replace_int );
				print_r($response );die;
				if ($api->errorCode) {
					echo "Batch Subscribe failed!\n";
					echo "code:" . $api->errorCode . "\n";
					echo "msg :" . $api->errorMessage . "\n";
					die ();
				}else{
					echo TEXT_SUBSCRIBR_SUCCESS;
				}*/
	//}
			