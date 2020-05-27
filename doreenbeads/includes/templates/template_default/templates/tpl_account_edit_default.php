<script>window.lang_wdate='en';</script>
<script type="text/javascript" src="includes/templates/cherry_zen/jscript/My97DatePicker/WdatePicker.js"></script>
<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=account_edit.<br />
 * View or change Customer Account Information
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_account_edit_default.php 3848 2006-06-25 20:33:42Z drbyte $
 * @copyright Portions Copyright 2003 osCommerce
 */
?>
<?php if ($messageStack->size('account') > 0) echo $messageStack->output('account'); ?>
<div class="mainright">    
    <div class="mycashaccount">
          <p class="ordertit"><strong><?php echo TEXT_ACCOUNT_SET; ?></strong>
          <span class="updatedis">
          	<?php if ($messageStack->size('account_password') > 0) {
          				echo SUCCESS_PASSWORD_UPDATED;
          		  } else if($messageStack->size('account_email') > 0){
						echo SUCCESS_EMAIL_UPDATED;
				  } else if($messageStack->size('account_infor') > 0){
						echo SUCCESS_ACCOUNT_UPDATED;
				  }
          ?>
          </span></p>
          <ul class="accountset">
            <li class="in" <?php echo $if_from_facebook?'style="width:397px"':''; ?>><?php echo TEXT_PROFILE_SET; ?></li>
            <?php if(!$if_from_facebook){ ?><li><?php echo TEXT_CHANGE_PASSWORD; ?></li><?php } ?>
            <li <?php echo $if_from_facebook?'style="width:397px"':''; ?>><?php echo TEXT_CHANGE_EMAIL; ?></li>
          </ul>
          <div class="clearfix"></div>
          <div class="accounttab sh">
          	<?php if($show_birth_tag){ ?>
				<div class="birth_remind">
		            <p><?php echo TEXT_BIRTHDAY_TIPS; ?></p>
		        </div>
	        <?php } ?>
             <p class="tit"><strong><?php echo TEXT_EDIT_UPDATE_PROFILE;?></strong><span><ins>*</ins><?php echo TEXT_REQUIRED_FIELDS;?></span></p>
             <?php echo zen_draw_form('account_edit', zen_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL'), 'post') . zen_draw_hidden_field('action', 'process') . zen_draw_hidden_field('class_now','0'); ?>
             <table>
               <tr>
               	   <td width="140"><label></label><ins><?php echo TEXT_AVARTAR;?></ins></td>
               	   <td><div class="headportrait"><?php echo $account->fields['customers_info_avatar'] !='' ?  zen_image(DIR_WS_USER_AVATAR.$account->fields['customers_info_avatar'],'','60','60') : zen_image(DIR_WS_USER_AVATAR.'8seasons.jpg','','62','62');?></div>
               	   <span class="edit" onclick="modify_user_photo('<?php echo $_SESSION['languages_code']?>')"><ins></ins><?php echo TEXT_EDIT;?></span></td>
               </tr>
               <tr>
	               <td><label>*</label><ins><?php echo ENTRY_GENDER;?></ins></td>
	               <td>	             
		            <?php
				    if ($account->fields['customers_gender'] == 'f') {
				      $genderSelect = 'f';
				    } else {
				      $genderSelect = 'm';
				    }
				    echo zen_draw_pull_down_menu('gender', array(array('id'=>'m', 'text'=>TEXT_MALE), array('id'=>'f', 'text'=>TEXT_FEMALE)), $genderSelect, '');
					?>
	               </td>
	               <td></td>
               </tr>
               <tr>
	               <td><label>*</label><ins> <?php echo ENTRY_FIRST_NAME; ?></ins></td>
	               <td><?php echo zen_draw_input_field('firstname', $account->fields['customers_firstname'], 'id="firstname" class="firstname require"'); ?></td>
	               <td><span></span></td>
               </tr>
               <tr>
	               <td><label>*</label><ins><?php echo ENTRY_LAST_NAME; ?></ins></td>
	               <td><?php echo zen_draw_input_field('lastname', $account->fields['customers_lastname'], 'id="lastname" class="firstname require"'); ?></td>
	               <td><span></span></td>
               </tr>
	           <?php
				  if (ACCOUNT_DOB == 'true') {
			   ?>
               <tr>
                    <td><label></label><ins><?php echo ENTRY_DATE_OF_BIRTH; ?></ins></td>
                    <td class="birthday" id="birthday">
						<select name="sel_year" style="width:33%;" class="sel_year" rel="<?php echo $sel_year; ?>"> </select>
						<select name="sel_month" style="width:30%;" class="sel_month" rel="<?php echo $sel_month; ?>"> </select>
						<select name="sel_day" style="width:32%;" class="sel_day" rel="<?php echo $sel_day; ?>"> </select>
				 	</td>
				 	<td><span></span></td>
			   </tr>
			   <?php
			       }
			   ?>               
               <tr>
	               <td><label></label><ins><?php echo ENTRY_YOUR_BUSINESS_WEB; ?></ins></td>
	               <td><?php echo zen_draw_input_field('customers_business_web', $account->fields['customers_business_web'], 'id="customers_business_web" '); ?></td>
	               <td><span></span></td>
               </tr>
               <tr>
	               <td><label></label><ins><?php echo ENTRY_TELEPHONE_NUMBER; ?></ins></td>
	               <td><?php echo zen_draw_input_field('telephone', $account->fields['customers_telephone'], 'id="telephone" class="telnum require"'); ?></td>
	               <td><span></span></td>
               </tr>
               <tr>
	               <td><label></label><ins><?php echo ENTRY_CELL_PHONE; ?></ins></td>
	               <td><?php echo zen_draw_input_field('customers_cell_phone', $account->fields['customers_cell_phone'], 'id="customers_cell_phone" '); ?></td>
	               <td></td>
               </tr>
               <?php
				   if (CUSTOMERS_REFERRAL_STATUS == 2 and $customers_referral == '') {
			   ?>
               <tr>
	               <td><label>*</label><ins><?php echo ENTRY_CUSTOMERS_REFERRAL; ?></ins></td>
	               <td><?php echo zen_draw_input_field('customers_referral', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_referral', 15), 'id="customers-referral"'); ?></td>
	               <td></td>
               </tr>
               <?php } ?>
               <?php
				  if (CUSTOMERS_REFERRAL_STATUS == 2 and $customers_referral != '') {
			   ?>
			   <tr>
	               <td><label>*</label><ins><?php echo ENTRY_CUSTOMERS_REFERRAL; ?></ins></td>
	               <td><?php echo $customers_referral; zen_draw_hidden_field('customers_referral', $customers_referral,'id="customers-referral-readonly"'); ?></td>
	               <td></td>
               </tr>
               <?php } ?>
               <tr>
	               <td><label>*</label><ins><?php echo ENTRY_YOU_COUNTRY; ?></ins></td>
	               <td>
		               <?php 
					      $country_select_name='customers_country_id';
					      echo zen_get_country_select($country_select_name, $account->fields['customers_country_id']);
				       ?>
				       <script>
						   country_select_choose('<?php echo $country_select_name;?>');
					   </script>
	               </td>
	               <td></td>
               </tr>
               <tr><td></td><td><p class="filterbtn"><button id="infosubmit"><?php echo TEXT_SAVE;?></button></p></td></tr>
             </table>
            </form>
          </div>
		  <?php if(!$if_from_facebook){ ?>
          <div class="accounttab">
              <p class="tit"><strong><?php echo TEXT_EDIT_UPDATE_PROFILE;?></strong><span><ins>*</ins><?php echo TEXT_REQUIRED_FIELDS;?></span></p>
              <?php echo zen_draw_form('account_edit', zen_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL'), 'post', 'onsubmit="return check_form(account_password);"') . zen_draw_hidden_field('action', 'process') . zen_draw_hidden_field('class_now','1'); ?>
              <table>
	              <tr>
		              <td width="140"><label>*</label><ins><?php echo ENTRY_PASSWORD_CURRENT; ?></ins></td>
		              <td><?php echo zen_draw_password_field('password_current','','id="password-current" class="currentpass require" autocomplete="off"'); ?></td>
		              <td><span></span></td>
	              </tr>
	              <tr>
		              <td><label>*</label><ins><?php echo ENTRY_PASSWORD_NEW; ?></ins></td>
		              <td><?php echo zen_draw_password_field('password_new','','id="password-new" class="newpass require" autocomplete="off"'); ?></td>
		              <td><span></span></td>
	              </tr>
	              <tr>
		              <td><label>*</label><ins><?php echo ENTRY_PASSWORD_CONFIRMATION; ?></ins></td>
		              <td><?php echo zen_draw_password_field('password_confirmation','','id="password-confirm" class="confirmpass require" autocomplete="off"'); ?></td>
		              <td><span></span></td>
	              </tr>
	              <tr><td></td><td><p class="filterbtn"><button id="passwordchange"><?php echo TEXT_SAVE;?></button></p></td></tr>
              </table>
              </form>
          </div>
		  <?php } ?>
            <div class="accounttab">
            <!-- 不能修改邮箱 --> 
             <p class="tit"><strong><?php echo TEXT_EDIT_UPDATE_PROFILE;?></strong><span><ins>*</ins><?php echo TEXT_REQUIRED_FIELDS;?></span></p>
             <?php echo zen_draw_form('account_edit', zen_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL'), 'post', 'onsubmit="return check_form(account_edit);"') . zen_draw_hidden_field('action', 'process') . zen_draw_hidden_field('class_now','2'); ?>
             <input type='hidden' class='currentpass'/>
             <table>
                 <tr>
             	                 <td width="140"><label>*</label><ins><?php echo ENTRY_EMAIL_ADDRESS; ?></ins></td>
             	                 <td><?php echo zen_draw_input_field('email_address', $account->fields['customers_email_address'], ' id="email-address" class="require"'); ?><br/><span></span></td>
                 	 <td><span></span></td>
                 </tr>
                 <tr><td></td><td colspan=2> <p><?php echo TEXT_YOU_WILL_NEED;?></p></td></tr>               
                 <tr><td></td><td><p class="filterbtn"><button id="emailsubmit"><?php echo TEXT_SAVE;?></button></p></td></tr>
             </table>
             </form>
             <!-- <div align="center"><p style="height:40px;font-size:14px;padding-top: 40px;"><?php echo TEXT_CHANGE_EMAIL_CONSOLE; ?></p></div> -->
          </div>        
          <p class="accounttab_bot"><ins></ins><span><?php echo TEXT_YOUR_DETAILED_INFORMATION;?></span></p>
     </div>
</div>
<script language="javascript" type="text/javascript">		   	
	function check_dob_year(){
		document.getElementById("dob_day").options.length = 0;
		document.getElementById("m_0").selected = true;
	}

	function padLeft(inString, fieldLen, padChar) {
	
		var paddedString = inString;
		var nPad = fieldLen - inString.length;
		for (var i=1; i <= nPad; i++)
			paddedString = padChar + paddedString;
		return paddedString;
	}
	
	function isLeapYear(intYear) {
		
		if ( (intYear % 4 == 0) && ((intYear % 100 != 0) || (intYear % 400 == 0)) )
			return true;
		else
			return false;
	}
		
	function setDayOptions(intYear, intMonth, theDayMenu) {
		
		var NumberOfDays, objDayMenu, i;
	    var DaysInMonth = new Array(0,31,28,31,30,31,30,31,31,30,31,30,31);
		if ( ! isNaN(intYear)  &&  isLeapYear(intYear) ) DaysInMonth[2]++;
	
		if ( typeof theDayMenu == 'object' ) {
			objDayMenu = theDayMenu;
		} else {
			for (i = 0; i < document.forms.length; i++) {
				objDayMenu = document.forms[i][theDayMenu];
				if (objDayMenu != null) break;
			}
			if ( typeof objDayMenu != 'object' ) return;
		}
	
		if ( isNaN(intMonth) ) intMonth = 0;		
			NumberOfDays = DaysInMonth[intMonth];
	
		objDayMenu.options.length = 0;
		objDayMenu[0] = new Option(String.fromCharCode(160, 160, 160, 160), '', true, true);
	
		for ( i = 1; i <= NumberOfDays; i++ ) {
			objDayMenu[i] = new Option(i, padLeft(i.toString(), 2, '0'), false, false);
		}
		objDayMenu.focus();
	
		return;
	}
</script>


<br><br>