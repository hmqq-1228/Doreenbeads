<?php
	require(DIR_WS_CLASSES . "class.des.php");
	require(DIR_WS_MODULES . zen_get_module_directory("require_languages.php"));
	$action = zen_db_prepare_input($_POST['action']);
	$info_of_get = zen_db_prepare_input($_GET['info']);
	$success = zen_db_prepare_input($_GET['success']);
	if(empty($success)) {
		$success = "0";
	}
	if(empty($success) && empty($info_of_get)) {
		die("Error.");
	}
	$des = new DES("panduohz", 0);
	$string_decrypt = $des->decrypt($info_of_get);
	if(empty($success) && (empty($string_decrypt) || strstr($string_decrypt, "|") == "")) {
		die("Error.");
	}
		
	if($action == "unsubscribe") {
		$unsubscribe_reason_code = zen_db_prepare_input($_POST['unsubscribe_reason_code']);
		$unsubscribe_reason_remark = zen_db_prepare_input($_POST['unsubscribe_reason_remark']);
		if(empty($unsubscribe_reason_code)) {
			die("Error.");
		}
		$unsubscribe_reason_array = explode(".|.", $unsubscribe_reason_code);
		if(!is_numeric($unsubscribe_reason_array[0]) || empty($unsubscribe_reason_array[1]) || strlen($unsubscribe_reason_array[1]) > 500) {
			die("Error.");
		}
		
		$string_decrypt_array = explode("|", $string_decrypt);
		$unsubscribe_type = isset($string_decrypt_array[2]) ? $string_decrypt_array[2] : "";
		if(count($string_decrypt_array) < 2) {
			die("Error.");
		}
		
		$customers_id = 0;
		$customer_info_query = "select customers_id from " . TABLE_CUSTOMERS . " where customers_email_address = :customers_email_address";
		$customer_info_query = $db->bindVars($customer_info_query, ':customers_email_address', $string_decrypt_array[0], 'string');
		$customer_info_result = $db->Execute($customer_info_query);
	  	if ($customer_info_result->RecordCount() > 0){
	  		$customers_id = $customer_info_result->fields['customers_id'];
	  	}
		
		$sql_data_array = array(
			'unsubscribe_from' => 10,
			'session_customers_id' => $_SESSION['customer_id'],
			'session_customers_email_address' => $_SESSION['customer_email'],
			'session_languages_id' => $_SESSION['languages_id'],
			'website_code' => WEBSITE_CODE,
			'customers_id' => $customers_id,
			'customers_email_address' => $string_decrypt_array[0],
			'unsubscribe_reason_code' => $unsubscribe_reason_array[0],
			'unsubscribe_reason_string' => $unsubscribe_reason_array[1],
			'unsubscribe_reason_remark' => $unsubscribe_reason_remark,
			'unsubscribe_email_date_created' => $string_decrypt_array[1],
			'unsubscribe_type' => $unsubscribe_type,
			'browser_user_agent' => $_SERVER['HTTP_USER_AGENT'],
			'date_created' => 'now()'
		);
		zen_db_perform(TABLE_CUSTOMERS_UNSUBSCRIBE_LOG, $sql_data_array);
		
		
		$exist_query = "select customers_id from " . TABLE_CUSTOMERS_UNSUBSCRIBE . " where customers_email_address = :customers_email_address and unsubscribe_type = :unsubscribe_type";
		$exist_query = $db->bindVars($exist_query, ':customers_email_address', $string_decrypt_array[0], 'string');
		$exist_query = $db->bindVars($exist_query, ':unsubscribe_type', $unsubscribe_type, 'string');
		$exist_result = $db->Execute($exist_query);
	  	if ($exist_result->RecordCount() > 0){
	  		zen_redirect(zen_href_link(FILENAME_CUSTOMER_UNSUBSCRIBE,zen_get_all_get_params(array('info', 'success')) . "&success=20"));
	  	} else {
			zen_db_perform(TABLE_CUSTOMERS_UNSUBSCRIBE, $sql_data_array);
			
			$business_id = $db->Insert_ID();
			$event_array = array(
				'business_id' => $business_id,
				'event_type' => 10,
				'event_weight' => 10,
				'event_status' => 10,
				'date_create' => 'now()'
			);
			zen_db_perform(TABLE_EVENT_TO_CRM, $event_array);
	  	}
		
		zen_redirect(zen_href_link(FILENAME_CUSTOMER_UNSUBSCRIBE,zen_get_all_get_params(array('info', 'success')) . "&success=10"));
	} else {
		
		
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo TEXT_DO_YOU_CONFIRM_TO_UNSUBSCRIBE_IT;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="imagetoolbar" content="no" />
<meta name="authors" content="The Doreenbeads Team" />
<meta name="generator" content="<?php echo TEXT_DO_YOU_CONFIRM_TO_UNSUBSCRIBE_IT;?> <?php echo HTTP_SERVER;?>" />
<meta name="robots" content="noindex, nofollow" />
<style> 
.btn_yellow{background: none repeat scroll 0 0 transparent;border: medium none;font-family: Tahoma;overflow: visible;cursor:pointer;}
.btn_yellow span{background: url(includes/templates/cherry_zen/css/en/images/btn_bgyellows2.png) no-repeat right -502px;cursor: pointer;display: block;height: 34px;line-height: 34px;
 padding-right: 20px;}
.btn_yellow span strong{ background: url(includes/templates/cherry_zen/css/en/images/btn_bgyellows2.png) no-repeat left -468px;color: #623500;display: block;font-size: 14px;height: 34px;line-height: 34px;padding: 0 0 0 20px;text-shadow: 1px 1px 0 #FFFFFF;white-space: nowrap;width:auto !important; width:80px; min-width:80px; }
p.lf{ display:block; width:190px; height:83px; background:url(/includes/templates/cherry_zen/css/en/images/news_logo.png) top no-repeat; text-indent:-99999px; float:left;}
p.lf a{ display:block; width:190px; height:50px; }
table tr{height:32px;}
td{text-align:left;}
label{ cursor:pointer;}
</style>
<script src="includes/templates/cherry_zen/jscript/jscript_jquery.js" type="text/javascript"></script>
</head>
<body style="margin-top:50px;"> 
	<center>
    	<div style="width: 730px; background-color: #ffffff; margin: auto; padding: 10px; border: 1px solid #cacaca;display:block; min-height:200px;">
            <a style="float:left; margin-bottom:20px;" href="<?php echo zen_href_link(FILENAME_DEFAULT);?>"><img src="includes/templates/cherry_zen/images/logo.jpg" alt="doreenbeads.com" title="doreenbeads.com" border="0" /></a>
            <?php if(empty($success)) {?>
            <form action="<?php echo zen_href_link(FILENAME_CUSTOMER_UNSUBSCRIBE,zen_get_all_get_params(array('info', 'success')) . "&info=" . $info_of_get . ""); ?>" method="post">
            	<input type="hidden" name="action" value="unsubscribe" />
                <input type="hidden" name="info" value="<?php echo $info_of_get;?>" />
                <table style="width:740px;" class="jq_main_table">
                    <tr>
                        <td colspan="2"><b><?php echo TEXT_DO_YOU_CONFIRM_TO_UNSUBSCRIBE_IT;?></b></td>
                    </tr>
                    <tr>
                        <td style="width:10px;"><input type="radio" value="10.|.<?php echo TEXT_I_DONT_WANT_TO_RECEIVE;?>" id="unsubscribe_reason_code_10" name="unsubscribe_reason_code" checked="checked"></td>
                        <td style="width:690px;"><label for="unsubscribe_reason_code_10"><?php echo TEXT_I_DONT_WANT_TO_RECEIVE;?></label></td>
                    </tr>
                    <tr>
                        <td><input type="radio" value="20.|.<?php echo TEXT_I_NEVER_SIGNED_UP;?>" id="unsubscribe_reason_code_20" name="unsubscribe_reason_code"></label></td>
                        <td><label for="unsubscribe_reason_code_20"><?php echo TEXT_I_NEVER_SIGNED_UP;?></label></td>
                    </tr>
                    <tr>
                        <td><input type="radio" value="30.|.<?php echo TEXT_THE_EMAILS_ARE_INAPPROPRIATE;?>" id="unsubscribe_reason_code_30" name="unsubscribe_reason_code"></label></td>
                        <td><label for="unsubscribe_reason_code_30"><?php echo TEXT_THE_EMAILS_ARE_INAPPROPRIATE;?></label></td>
                    </tr>
                    <tr>
                        <td><input type="radio" value="40.|.<?php echo TEXT_THE_EMAILS_ARE_SPAM;?>" id="unsubscribe_reason_code_40" name="unsubscribe_reason_code"></label></td>
                        <td><label for="unsubscribe_reason_code_40"><?php echo TEXT_THE_EMAILS_ARE_SPAM;?></label></td>
                    </tr>
                    <tr>
                        <td><input type="radio" value="50.|.<?php echo TEXT_OTHER_FILL_IN_REASON;?>" id="unsubscribe_reason_code_50" name="unsubscribe_reason_code" class="jq_other_input"></label></td>
                        <td><label for="unsubscribe_reason_code_50"><?php echo TEXT_OTHER_FILL_IN_REASON;?></label></td>
                    </tr>
                    <tr class="jq_other_tr" style="display:none;">
                        <td></td>
                        <td>
                            <textarea rows="8" cols="60" id="unsubscribe_reason_remark" name="unsubscribe_reason_remark"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button id="braintree_button" class="btn_yellow">
                              <span>
                                  <strong><?php echo TEXT_SUBMIT;?></strong>
                              </span>
                            </button>
                        </td>
                    </tr>
                </table>
            </form>
            <?php } elseif($success == "10") {?>
            	<div style="margin:30px; width:730px; text-align:center; float:left; height:100px; display:block;">
            	<span style="font-weight:bold; font-size:30px;"><?php echo TEXT_YOU_HAVE_UNSUBSCRIBED_SUCCESSFULLY;?></span>
            	<br/>
            	<?php echo TEXT_ANY_QUESTIONS_PLEASE_CONTACT;?>
            	</div>
            <?php } elseif($success == "20") {?>
            	<div style="margin:30px; width:730px; text-align:center; float:left; height:100px; display:block;">
            	<span style="font-weight:bold; font-size:30px;"><?php echo TEXT_YOU_HAD_ALREADY_UNSUBSCRIBED_IT;?></span>
            	<br/>
            	<?php echo TEXT_ANY_QUESTIONS_PLEASE_CONTACT;?>
            	</div>
            <?php }?>
        </div>
    </center>
    <script language="javascript">
    	$(function() {
			$(".jq_main_table input").bind("click", function() {
				var className = $(this).attr("class");
				if(className == "jq_other_input") {
					$(".jq_other_tr").show();
				} else {
					$(".jq_other_tr").hide();
				}
			});
		});
    </script>
</body>
</html>
<?php
exit;
?>