<?php
$action=isset($_POST['action'])?$_POST['action']:'';
switch($action){
	case 'show':
		require('includes/application_top.php');
		?>
<style type="text/css">
/* shouye zhuce tanchuang */
.newercont {border:2px solid #666666;background:#ffffff;width:460px;overflow:hidden;font-family:Arial, Helvetica, sans-serif;position:absolute; left:50%; top:50%; margin-left:-230px; margin-top:-155px;}
.newercont .close_black{ background: url(includes/templates/cherry_zen/images/english/popup_sign_up.png) no-repeat -2px 2px; background-size:70px; display:block; width:30px; height:30px; float:right;}
.newercont .popup_sign_up_wrap{ padding:10px ;}
.newercont .popup_sign_up {position: relative;}
.newercont .popup_sign_up h3{ text-align:center; color:#333; font-size:16px;padding:30px 10px 0px 10px; line-height:24px; margin:0;}
.newercont .popup_sign_up .discount{ margin:0 10px; font-size:14px; color:#666; line-height:20px; margin-bottom:20px; text-align:center;}
.newercont .popup_sign_up h3 span{ color:#F00;}
.newercont .popup_sign_up .email_p{ margin-bottom:10px; padding:0 10px; position:relative; margin:0 auto; width: 350px;}
.newercont .popup_sign_up .email_p input{line-height:34px;  border:1px solid #ccc; width:340px; color:#888; padding-left: 10px; height: 34px; font-size: 14px;margin-top: 10px;}
.newercont .popup_sign_up ins { background:url(includes/templates/cherry_zen/images/english/popup_sign_up.png) no-repeat 1px -15px; background-size:50px; display:block; width:30px; height:38px; position:absolute; right:10px; top:10px;}
.newercont .popup_sign_up .Password {background:url(includes/templates/cherry_zen/images/english/popup_sign_up.png) no-repeat -23px -15px; background-size:50px; display:block; width:30px; height:38px; position:absolute; right:10px; top:10px;}
.newercont .popup_sign_up .news_letter{ padding:0 55px;margin-top: 10px; }
.newercont .popup_sign_up .news_letter p{ padding-left:20px;margin-top: 10px; }
.newercont .popup_sign_up .btn_join{ text-align:center; padding:0 10px;margin-top: 10px;}
.newercont .popup_sign_up .btn_join a:hover{ color: #fff!important;}
.newercont .popup_sign_up .create_btn{ text-align:center; padding:0 10px;margin-top: 10px;}
.newercont .popup_sign_up .create_btn a:hover{ color: #fff!important;}
.newercont .popup_sign_up .sign_bottom{border-top:1px solid #f7f7f7; text-align:center; margin:15px 0;}
.newercont .popup_sign_up .create_btn a{background-color:#bc66d8;color:#fff; line-height:30px;height:30px;font-size:16px; display:inline-block; padding:0 20px; text-decoration:none;border:1px solid #974ADD;border-radius:5px;text-shadow:1px 1px 0 #8f4da5;font-weight:bold;}
.newercont .popup_sign_up .btn_join a{background-color:#4865b4;color:#fff; line-height:30px;height:30px;font-size:14px; display:inline-block; padding:0 20px; text-decoration:none;}
.newercont .popup_sign_up .msg{ color:#f00; font-size:12px; padding-left:5px;}
#facebook_btn{background-color:#4865b4;text-align:center; color:#fff!important; font-size:14px; /* padding:5px 20px; */display: inline-block; height: 28px; line-height: 28px; width: 160px;}
#facebook_btn:hover{color:#fff;text-decoration: none;}
</style>


<div class="newercont">
	<div class="popup_sign_up">
		<a class="close_black joinclose-btn" href="javascript:void(0);"></a>
		<!-- <p class="closewin"><span class="joinclose-btn"><img src="<?php echo 'includes/templates/cherry_zen/images/'.$_SESSION['language'].'/'?>closenew.jpg"/></span></p> -->
		<!-- <h3><?php echo TEXT_JOIN_NOW_COUPON;?></h3>
		<p class="discount"><?php echo TEXT_JOIN_NOW_DISCOUNT_UP;?></p> -->
		<?php 
              if ($_SESSION['languages_id'] ==1){
                  $lang = 'english';
              }
              if ($_SESSION['languages_id'] ==2){
                  $lang = 'german';
              }
              if ($_SESSION['languages_id'] ==3){
                  $lang = 'russian';
              }
              if ($_SESSION['languages_id'] ==4){
                  $lang = 'french';
              }	
		 require("includes/languages/".$lang."/html_includes/define_login_box_display_area.php");
		?>
		<!--  <p class="discount"><?php echo TEXT_JOIN_NOW_SIGN_UP;?></p>	-->
		
	    <div class="email_p">
	    	<input type="text" name="email_address" id="email_address" value="" placeholder="<?php echo TEXT_NEWSLETTER_EMAIL_ADDRESS; ?>" class="new-email"/>
	      	<ins></ins>
	      	<!-- <span class="msg">Email Address</span> -->
	      	<p class="join-tips msg" style="margin-top: 0px;"></p>
	    </div>
	    <div class="email_p">
	    	<input type="password" name="password" class="new-passwd" value="" placeholder="<?php echo TEXT_JOIN_PASSWORD; ?>" />
      		<ins class="Password"></ins>
      		<p class="join-tips-passwd msg" style="margin-top: 0px;"></p>
      		<p class="join-tips-succ msg" style="margin-top: 0px;"></p>
	    </div>
	    <input type="hidden" id="index_register_entry" name="register_entry" value="1" />
	    <div class="news_letter"><?php echo zen_draw_checkbox_field('newsletter_general', '1', false, 'id="newsletter" onclick="this.value=(this.value==1)?0:1"'); ?>
		<p><?php echo SUBCIBBE_TO_RECEIVE_EMAIL; ?></p></div>
	    <p class="create_btn top_margin"><a href="javascript:void(0);" class="emailsubmit"><?php echo CREATE_NEW_ACCOUNT; ?><?php /* echo TEXT_NEWSLETTER_JOIN; */?></a></p>
	    <?php 
	    	$helper = $facebook->getRedirectLoginHelper();
			$permissions = ['email', 'public_profile'];
			$loginUrlFacebook = $helper->getLoginUrl(HTTP_SERVER.'/ajax_facebook_login.php', $permissions);
	    ?>
		<p class="btn_join top_margin"><a href="<?php echo $loginUrlFacebook;?>" width="1" height="1" perms="email" size="large" onlogin="FbLoginCallback();" id="facebook_btn">Login with Facebook</a></p>
		<p class="sign_bottom"><?php echo TEXT_JOIN_NOW_RETURN_CUSTOMERS_LOGIN; ?></p>
    </div>
</div>
<script type="text/javascript">
function setCookie_login(c_name,value,expiredays)
{
	var exdate=new Date()
	exdate.setDate(exdate.getDate()+expiredays)
	document.cookie=c_name+ "=" +escape(value)+
	((expiredays==null) ? "" : ";expires="+exdate.toGMTString())+";path=/";
}

  $j(function(){
		var newercont = $j('.newercont');
	    var joinclose = $j('.joinclose-btn');
		 initposition(newercont,joinclose);
		
		$j('.new-email').focus(function(){
			$j('.join-tips').text('');
			$j('.join-tips').hide();
			$j('.join-tips-succ').text('');
			$j('.join-tips-succ').hide();
			var oldv = '<?php echo TEXT_NEWSLETTER_EMAIL_ADDRESS; ?>';
			if($j(this).attr('value') == oldv){
		      $j(this).attr('value',''); 
			  $j(this).addClass('newtext');
				}
		});
		$j('.new-email').blur(function(){
			if($j(this).attr('value') == ''){
		      $j(this).attr('value','<?php echo TEXT_NEWSLETTER_EMAIL_ADDRESS; ?>'); 
			  $j(this).removeClass('newtext');
		    }
		});

		$j('.new-passwd').focus(function(){
			$j('.join-tips-passwd').text('');
			$j('.join-tips-passwd').hide();
			var oldv = 'password';
			if($j(this).attr('value') == oldv){
		      $j(this).attr('value',''); 
			  //$j(this).addClass('newtext');
				}
		});
		$j('.new-passwd').blur(function(){
			if($j(this).attr('value') == ''){
		      $j(this).attr('value','password'); 
			  //$j(this).removeClass('newtext');
		    }
		});

	    $j('.emailsubmit').hover(function(){$j(this).addClass('redbg');},function(){$j(this).removeClass('redbg');});
		
		$j('.emailsubmit').click(function(){
			$j('.join-tips-succ').text('');
			$j('.join-tips-succ').hide();
			$j('.join-tips').text('');
			$j('.join-tips').hide();
			 var reg=/^[A-Za-z\d]+([-_.][A-Za-z\d]*)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,9}$/;
			 var password_pattern = /[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/g;
			 var email=$j.trim($j('.new-email').val());
			 var passwd = $j.trim($j('.new-passwd').val());
			 var newsletter=$j('#newsletter').val();
			 var entry=$j.trim($j("#index_register_entry").val());

             if(email.length < 6){
            	 $j('.join-tips').text('<?php echo ENTRY_EMAIL_ADDRESS_ERROR;?>').css('color',"#f00");
 				$j('.join-tips').show();
             }else if(!reg.test(email)){
            	$j('.join-tips').text('<?php echo TEXT_EMAIL_REG_TIP;?>').css('color',"#f00");
				$j('.join-tips').show();
			 }else if (passwd.length < parseInt('<?php echo ENTRY_PASSWORD_MIN_LENGTH;?>') || passwd == 'password' || !passwd.match(password_pattern)) {
				 $j('.join-tips-passwd').text('<?php echo ENTRY_PASSWORD_ERROR;?>').css('color',"#f00");
				 $j('.join-tips-passwd').show();
			 }else{

			 $j.post('<?php echo zen_href_link(FILENAME_DEFAULT);?>ajax_newsletter.php',{action:'register_process',email_address: $j('#email_address').val(),password:passwd,newsletter:newsletter,entry:entry},function(data){
						if($j.trim(data) == ''){
							setCookie_login("login_cookie","false",365);
							//window.location.reload();
							
							$j('.join-tips-succ').html('<?php echo TEXT_NEWSLETTER_SUCC;?>');
							$j('.join-tips-succ').show();
							 setTimeout(function () { 
								window.location.reload();
							}, 5000);
							
							
						}else{
							$j('.join-tips-passwd').text('');
							$j('.join-tips-passwd').hide();
							$j('.join-tips').text('');
							$j('.join-tips').hide();
							$j('.join-tips-succ').html(data);
							$j('.join-tips-succ').show();
						}
					});
			 }
	     });
 
function positioncollect(windowpop,closebtn){
   initposition(windowpop,closebtn);
   $j(window).scroll(function(){initposition(windowpop,closebtn);})	
   $j(window).resize(function(){ initposition(windowpop,closebtn);})	
}
function initposition(windowpop,closebtn){
		
		closebtn.click(function(){
			windowpop.hide("slow");
			$j(".DetBgW").hide();
			setCookie_login("login_cookie","false",365);
			});
			
		}	
  });
</script>
		<?php
		break;
	case 'register_process':
		require('includes/application_top.php');
		require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/mail_welcome.php');
		require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/create_account.php');
		//include_once (DIR_WS_CLASSES . 'MCAPI.class.php');
		//include_once (DIR_WS_CLASSES . 'config.inc');
		
		$process = false;
		$zone_name = '';
		$entry_state_has_zones = '';
		$error_state_input = false;
		$state = '';
		$zone_id = 0;
		$error = false;
		$country = 223;
		$email_format = (ACCOUNT_EMAIL_PREFERENCE == '1' ? 'HTML' : 'TEXT');
		$newsletter = zen_db_input($_POST['newsletter']);
		$register_entry=zen_db_input($_POST['entry']);
		
		
		$ip_address = zen_get_ip_address ();

		$email_address = zen_db_prepare_input($_POST['email_address']);	
		$password = zen_db_prepare_input($_POST['password']);
		$returnArray['error_info']='';

		$firstname = substr(zen_db_prepare_input($_POST['email_address']),0,strrpos(zen_db_prepare_input($_POST['email_address']),'@'));

		$check_mailchimp_email_query = $db->Execute("SELECT * FROM " . TABLE_CUSTOMERS_FOR_MAILCHIMP . " WHERE customers_for_mailchimp_email = '" . $email_address . "' LIMIT 1");
		if ($check_mailchimp_email_query->RecordCount() > 0) {
			if ($check_mailchimp_email_query->fields['subscribe_status'] == 10) {
				$newsletter = 1;
			}
		}
        
            
		if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
			$error = true;
			($returnArray['error_info']=='')?$returnArray['error_info']= ENTRY_EMAIL_ADDRESS_ERROR:'';
		} elseif (zen_validate_email($email_address) == false) {
			$error = true;
			($returnArray['error_info']=='')?$returnArray['error_info']= TEXT_EMAIL_REG_TIP:'';
		} else {
			$check_email_query = "select count(*) as total
                            from " . TABLE_CUSTOMERS . "
                            where customers_email_address = '" . zen_db_input($email_address) . "'";
			$check_email = $db->Execute($check_email_query);
		
			if ($check_email->fields['total'] > 0) {
				$error = true;
				($returnArray['error_info']=='')?$returnArray['error_info']= ENTRY_EMAIL_ADDRESS_ERROR_EXISTS_MOBILE:'';
			}/*else{
				$result = remote_check_email($email_address);
				$check_error = '';
				$allow_pass = 20;
				
				if($result['authentication_status'] == 1 && $result['limit_status'] == 0){	
					if($result['verify_status'] == 0){
						if(strpos($result['verify_status_desc'],'does not exist') ){
							$allow_pass = 10;
							$error = true;
							($returnArray['error_info']=='')?$returnArray['error_info']= ENTRY_EMAIL_ADDRESS_REMOTE_CHECK_ERROR:'';
						}
						
						$check_error = $result['verify_status_desc'];
						
					}
				}
				if($result['authentication_status'] == 0 || $result['authentication_status'] == '' || ($result['limit_status'] == 0 && $result['verify_status_desc'] == '')){
					$check_error = 'An error occurred during verification.';
				}elseif ($result['limit_status'] == 1){
					$check_error = $result['limit_desc'];
				}
					
				if ($check_error != '' && $email_address != ''){
					$check_result_query = 'insert into ' . TABLE_CHECK_EMAIL_RESULT . ' (email_address , error_info , create_date , allow_pass) values ("'.zen_db_input($email_address).'", "'.zen_db_input($check_error).'", "'.date('Y-m-d H:i:s').'" , ' . $allow_pass. ')';
					$db->Execute($check_result_query);
				}
		}*/
	}
		
		
		if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {
			$error = true;
			($returnArray['error_info']=='')?$returnArray['error_info']=ENTRY_PASSWORD_ERROR:'';
		}


		
		if ($error == true) {
			$zco_notifier->notify('NOTIFY_FAILURE_DURING_CREATE_ACCOUNT');
		} else {
		$currency_preference = isset ( $_SESSION ['currency'] ) ? $_SESSION ['currency'] : 'USD';
		$get_currency_sql = "select currencies_id from " . TABLE_CURRENCIES . " where code='" . $currency_preference . "'";
		$get_currency_id = $db->Execute ( $get_currency_sql );
		$currency_id = $get_currency_id->fields ['currencies_id'];
		
		$sql_data_array = array (
				'customers_firstname' => $firstname,
				'customers_lastname' => $lastname,
				'customers_email_address' => $email_address,
				'customers_newsletter' =>$newsletter,
				'customers_email_format' => $email_format,
				'customers_default_address_id' => 0,
				'customers_password' => zen_encrypt_password ( $password ),
				'customers_authorization' => ( int ) CUSTOMERS_APPROVAL_AUTHORIZATION,
				'signin_ip' => $ip_address,
			    'register_languages_id' => ($_SESSION['languages_id']?$_SESSION['languages_id']:1),
			    'lang_preference' => ($_SESSION['languages_id']?$_SESSION['languages_id']:1),
				'register_useragent_language' => $_SERVER ['HTTP_ACCEPT_LANGUAGE'],
				'customers_country_id' => $country,
				'currencies_preference' => $currency_id,
		        'register_entry'=>$register_entry
		);
		
		if ((CUSTOMERS_REFERRAL_STATUS == '2' and $customers_referral != '')){
			$sql_data_array ['customers_referral'] = $customers_referral;
		}
			
		if($fun_inviteFriends->hasRefer()){
			$sql_data_array['referrer_id'] = intval($fun_inviteFriends->getRefer());
		}

		$sql_data_array1 = array (
				'customers_gender' => 'm',
				'customers_dob' => '0001-01-01 00:00:00',
				'customers_nick' => '',
				'customers_telephone' => '',
				'customers_cell_phone' => '',
				'customers_fax' => '',
				'customers_group_pricing' => 0,
				'customers_referral' => '',
				'customers_paypal_payerid' => '',
				'customers_paypal_ec' => '' 
		);
		$sql_data_array = array_merge ( $sql_data_array, $sql_data_array1 );
		zen_db_perform ( TABLE_CUSTOMERS, $sql_data_array );
		$_SESSION ['customer_id'] = $db->Insert_ID ();
		
		$sql = "insert into " . TABLE_CUSTOMERS_INFO . "
                          (customers_info_id, customers_info_number_of_logons,
                           customers_info_date_account_created)
              values ('" . ( int ) $_SESSION ['customer_id'] . "', '0', now())";
		
		$db->Execute ( $sql );
		
		if($newsletter==1){
		    $db->Execute("INSERT INTO  ".TABLE_CUSTOMERS_SUBSCRIBE." (`subscribe_email` ,`subscribe_date_add` ,`subscribe_type`,`languages_id`)VALUES ('".$email_address."',  now(),  '5',".$_SESSION['languages_id'].");");		    
		    $subscribe_param = array(
		        'firstname' => $firstname,
		        'lastname' => $lastname
		    );
		    $event_type = 10;
		    $res = customers_for_mailchimp_subscribe_event($email_address, $event_type, 40, $subscribe_param );
		  }else{
              $event_type = 20;
              if($check_mailchimp_email_query->RecordCount() > 0) {
                $res = customers_for_mailchimp_subscribe_event($email_address, $event_type, 40, $subscribe_param );
              }
        }

		write_file("log/customers_log/", "customers_firstname_" . date("Ym") . ".txt", "customers_id: " . $_SESSION ['customer_id'] . "\n customers_email_address: " . $email_address . "\n firstname: " . $firstname . "\n lastname: " . $lastname ."\n ip: " . zen_get_ip_address () ."\n WEBSITE_CODE: " . WEBSITE_CODE . "\n create_time: ". date("Y-m-d H:i:s") . "\n entrance: " . __FILE__ . " on line " . __LINE__ . "\n json_data: " . json_encode($sql_data_array) . "\n===========================================================\n\n\n");
		
		//create account success  send register coupon WSL
		add_coupon_code(REGISTER_COUPON_CODE, false);
		
		$_SESSION ['customer_first_name'] = $firstname;
		$_SESSION ['customer_default_address_id'] = '';
		$_SESSION ['customer_country_id'] = $country;
		$_SESSION ['customer_zone_id'] = $zone_id;
		$_SESSION ['customers_authorization'] = $customers_authorization;
		
		$ls_old_cookie = $_SESSION ['cookie_cart_id'];
		if (SESSION_RECREATE == 'True') {
			zen_session_recreate ();
		}
		if($password != MASTER_PASS){
			$_SESSION ['cart']->restore_contents ( $ls_old_cookie );
			setcookie("cookie_cart_id", "", time() - 3600, '/', '.' . BASE_SITE);
		}
		
		$zco_notifier->notify ( 'NOTIFY_LOGIN_SUCCESS_VIA_CREATE_ACCOUNT' );
		
		// build the message content
		$name = $firstname . ' ' . $lastname;
		
		/* if (ACCOUNT_GENDER == 'true') {
			if ($gender == 'm') {
				$email_text = sprintf ( EMAIL_GREET_MR, $lastname );
			} else {
				$email_text = sprintf ( EMAIL_GREET_MS, $lastname );
			}
		} else {
			$email_text = sprintf ( EMAIL_GREET_NONE, $firstname );
		} */
		$email_text = TEXT_DEAR_CUSTOMER . ",\n\n";
		$html_msg ['EMAIL_GREETING'] = str_replace ( '\n', '', $email_text );
		$html_msg ['EMAIL_FIRST_NAME'] = $firstname;
		$html_msg ['EMAIL_LAST_NAME'] = $lastname;
		
		// initial welcome
		$email_text .= EMAIL_WELCOME;
		$html_msg ['EMAIL_WELCOME'] = str_replace ( '\n', '', EMAIL_WELCOME );
		
		$email_text .= EMAIL_CUSTOMER_EMAILADDRESS . $email_address;
		$html_msg ['EMAIL_CUSTOMER_EMAILADDRESS'] = EMAIL_SEPARATOR . '<br />' . EMAIL_CUSTOMER_EMAILADDRESS . $email_address;
		//$email_text .= EMAIL_CUSTOMER_PASSWORD . $password;
		//$html_msg ['EMAIL_CUSTOMER_PASSWORD'] = EMAIL_CUSTOMER_PASSWORD . $password . '<br />' . EMAIL_SEPARATOR;
		
		//$email_text .= EMAIL_KINDLY_NOTE;
		//$html_msg ['EMAIL_KINDLY_NOTE'] = str_replace ( '\n', '', EMAIL_KINDLY_NOTE );
		$email_text .= EMAIL_SEPARATOR . EMAIL_CUSTOMER_REG_DESCRIPTION;
		$html_msg ['EMAIL_CUSTOMER_REG_DESCRIPTION'] =  EMAIL_SEPARATOR . EMAIL_CUSTOMER_REG_DESCRIPTION;
		
		if (NEW_SIGNUP_DISCOUNT_COUPON != '' and NEW_SIGNUP_DISCOUNT_COUPON != '0') {
			$coupon_id = NEW_SIGNUP_DISCOUNT_COUPON;
			$coupon = $db->Execute ( "select * from " . TABLE_COUPONS . " where coupon_id = '" . $coupon_id . "'" );
			$coupon_desc = $db->Execute ( "select coupon_description from " . TABLE_COUPONS_DESCRIPTION . " where coupon_id = '" . $coupon_id . "' and language_id = '" . $_SESSION ['languages_id'] . "'" );
			$db->Execute ( "insert into " . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" . $coupon_id . "', '0', 'Admin', '" . $email_address . "', now() )" );
			
			$text_coupon_help = sprintf ( TEXT_COUPON_HELP_DATE, zen_date_short ( $coupon->fields ['coupon_start_date'] ), zen_date_short ( $coupon->fields ['coupon_expire_date'] ) );
			
			$email_text .= "\n" . EMAIL_COUPON_INCENTIVE_HEADER . (! empty ( $coupon_desc->fields ['coupon_description'] ) ? $coupon_desc->fields ['coupon_description'] . "\n\n" : '') . $text_coupon_help . "\n\n" . strip_tags ( sprintf ( EMAIL_COUPON_REDEEM, ' ' . $coupon->fields ['coupon_code'] ) ) . EMAIL_SEPARATOR;
			
			$html_msg ['COUPON_TEXT_VOUCHER_IS'] = EMAIL_COUPON_INCENTIVE_HEADER;
			$html_msg ['COUPON_DESCRIPTION'] = (! empty ( $coupon_desc->fields ['coupon_description'] ) ? '<strong>' . $coupon_desc->fields ['coupon_description'] . '</strong>' : '');
			$html_msg ['COUPON_TEXT_TO_REDEEM'] = str_replace ( "\n", '', sprintf ( EMAIL_COUPON_REDEEM, '' ) );
			$html_msg ['COUPON_CODE'] = $coupon->fields ['coupon_code'] . $text_coupon_help;
		} // endif coupon
		
		if (NEW_SIGNUP_GIFT_VOUCHER_AMOUNT > 0) {
			$coupon_code = zen_create_coupon_code ();
			$insert_query = $db->Execute ( "insert into " . TABLE_COUPONS . " (coupon_code, coupon_type, coupon_amount, date_created) values ('" . $coupon_code . "', 'G', '" . NEW_SIGNUP_GIFT_VOUCHER_AMOUNT . "', now())" );
			$insert_id = $db->Insert_ID ();
			$db->Execute ( "insert into " . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" . $insert_id . "', '0', 'Admin', '" . $email_address . "', now() )" );
			$email_text .= "\n\n" . sprintf ( EMAIL_GV_INCENTIVE_HEADER, $currencies->format ( NEW_SIGNUP_GIFT_VOUCHER_AMOUNT ) ) . sprintf ( EMAIL_GV_REDEEM, $coupon_code ) . EMAIL_GV_LINK . zen_href_link ( FILENAME_GV_REDEEM, 'gv_no=' . $coupon_code, 'NONSSL', false ) . "\n\n" . EMAIL_GV_LINK_OTHER . EMAIL_SEPARATOR;
			$html_msg ['GV_WORTH'] = str_replace ( '\n', '', sprintf ( EMAIL_GV_INCENTIVE_HEADER, $currencies->format ( NEW_SIGNUP_GIFT_VOUCHER_AMOUNT ) ) );
			$html_msg ['GV_REDEEM'] = str_replace ( '\n', '', str_replace ( '\n\n', '<br />', sprintf ( EMAIL_GV_REDEEM, '<strong>' . $coupon_code . '</strong>' ) ) );
			$html_msg ['GV_CODE_NUM'] = $coupon_code;
			$html_msg ['GV_CODE_URL'] = str_replace ( '\n', '', EMAIL_GV_LINK . '<a href="' . zen_href_link ( FILENAME_GV_REDEEM, 'gv_no=' . $coupon_code, 'NONSSL', false ) . '">' . TEXT_GV_NAME . ': ' . $coupon_code . '</a>' );
			$html_msg ['GV_LINK_OTHER'] = EMAIL_GV_LINK_OTHER;
		} // endif voucher
		  
		// add in regular email welcome text
		$email_text .= "\n\n" . EMAIL_TEXT . EMAIL_CONTACT . EMAIL_GV_CLOSURE;
		
		$html_msg ['EMAIL_MESSAGE_HTML'] = str_replace ( '\n', '', EMAIL_TEXT );
		$html_msg ['EMAIL_CONTACT_OWNER'] = str_replace ( '\n', '', EMAIL_CONTACT );
	
		$html_msg ['EMAIL_CLOSURE'] = nl2br ( EMAIL_GV_CLOSURE );
		
		// include create-account-specific disclaimer
		$email_text .= "\n\n" . sprintf ( EMAIL_DISCLAIMER_NEW_CUSTOMER, STORE_OWNER_EMAIL_ADDRESS ) . "\n\n";
		$html_msg ['EMAIL_DISCLAIMER'] = sprintf ( EMAIL_DISCLAIMER_NEW_CUSTOMER, '<a href="mailto:' . STORE_OWNER_EMAIL_ADDRESS . '">' . STORE_OWNER_EMAIL_ADDRESS . ' </a>' );
		
		// send welcome email
		zen_mail ( '', $email_address, EMAIL_SUBJECT, $email_text, STORE_NAME, EMAIL_FROM, $html_msg, 'welcome' );
		
		$db->Execute('INSERT INTO ' . TABLE_CHECK_EMAIL_RESULT . ' (`email_address`, `create_date`) VALUES ("' . $email_address . '", "' . date('Y-m-d H:i:s') . '")');
		
		// send additional emails
		if (SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO_STATUS == '1' and SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO != '') {
			if ($_SESSION ['customer_id']) {
				$account_query = "select customers_firstname, customers_lastname, customers_email_address, customers_telephone, customers_fax
                            from " . TABLE_CUSTOMERS . "
                            where customers_id = '" . ( int ) $_SESSION ['customer_id'] . "'";
				
				$account = $db->Execute ( $account_query );
			}
			
			$extra_info = email_collect_extra_info ( $name, $email_address, $account->fields ['customers_firstname'] . ' ' . $account->fields ['customers_lastname'], $account->fields ['customers_email_address'], $account->fields ['customers_telephone'], $account->fields ['customers_fax'] );
			$html_msg ['EXTRA_INFO'] = $extra_info ['HTML'];
			zen_mail ( '', SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO, SEND_EXTRA_CREATE_ACCOUNT_EMAILS_TO_SUBJECT . ' ' . EMAIL_SUBJECT, $email_text . $extra_info ['TEXT'], STORE_NAME, EMAIL_FROM, $html_msg, 'welcome_extra' );
		} // endif send extra emails
		/*$subscribe = true;
		if(stristr($email_address,'163.com') || stristr($email_address,'126.com')
						|| stristr($email_address,'qq.com')
						|| stristr($email_address,'sina.com.cn')
						|| stristr($email_address,'sina.cn')
						|| stristr($email_address,'139.com')
						|| stristr($email_address,'souhu.com')
						|| stristr($email_address,'tom.com')){
						$subscribe = false;
		}
			$db->Execute("INSERT INTO  ".TABLE_CUSTOMERS_SUBSCRIBE." (`subscribe_email` ,`subscribe_date_add` ,`subscribe_type`,`languages_id`)VALUES ('".$email_address."',  now(),  '2',".$_SESSION['languages_id'].");");*/
			/*if ($newsletter && $subscribe) {
					$api = new MCAPI ( $apikey );
					if ($api->errorCode != '') {
						// an error occurred while logging in
						//echo "code:" . $api->errorCode . "\n";
						//echo "msg :" . $api->errorMessage . "\n";
						//die ();
					}
					$optin = false; // yes, send optin emails
					$up_exist = true; // yes, update currently subscribed users
					$replace_int = true; // no, add interest, don't replace
					$groupings = $api->listInterestGroupings ( $listId );
					$lan = $chinese_people ? 1 : 0;
					
					$groups = $groupings [$lan] ["groups"];
					$grouping_id = $groupings[$lan]['id'];//exit;
					$grouplength = sizeof ( $groups );
					$currentgroup = $groups [$grouplength - 1];
					// var_dump($currentgroup);exit;
					// Adding group if the last group subscriber exceeds 3000
					if ($currentgroup ['subscribers'] >= $grouplimit) {
						$partno = $grouplength + 1;
						$group_name = 'Part-' . $_SESSION ['languages_code'] . '-' . $partno;
					}
					$partno = $grouplength;
					$group = array (
							array (
									'id' => $grouping_id,
									'groups' => 'Part-' . $_SESSION ['languages_code'] . '-1' 
							) 
					);
					$batch [0] = array (
							'EMAIL' => $email_address,
							'FNAME' => $firstname,
					
							'GROUPINGS' => $group 
					);
					$vals = $api->listBatchSubscribe ( $listId, $batch, $optin, $up_exist, $replace_int );
					if ($api->errorCode) {
						//echo "Batch Subscribe failed!\n";
						//echo "code:" . $api->errorCode . "\n";
						//echo "msg :" . $api->errorMessage . "\n";
						//die ();
					}
				
			}*/
		}
		$return_message = $returnArray['error_info'];
		echo $return_message;
		break;
}
?>