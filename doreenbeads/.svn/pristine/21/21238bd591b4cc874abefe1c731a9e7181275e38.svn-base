<div class="mycashaccount">
    <p class="ordertit"><strong><?php echo TEXT_MESSAGE_SETTING;?></strong></p>
    <div class="credittext">
        <div class="user_message_setting">
			<form class="jq_from_message_setting" id="from_message_setting" name="from_message_setting" method="post" action="<?php echo zen_href_link(FILENAME_MESSAGE_SETTING, zen_get_all_get_params(array('action')) . 'action=update');?>">
			<table cellpadding=0 cellspacing=0 border=0 style="display: table;">
				<tr>
					<td width="65%"><label><input type="radio" name="message_receive_type" value="30"<?php if($message_setting_result->fields['customers_info_message_receive_type'] == "30") {echo " checked='checked';";}?> /> <?php echo TEXT_RECEIVE_ALL_MESSAGES;?></label></td>
					<td width="35%"></td>
				</tr>
				<tr>
					<td><label><input type="radio" name="message_receive_type" value="20"<?php if($message_setting_result->fields['customers_info_message_receive_type'] == "20") {echo " checked='checked';";}?> /> <?php echo TEXT_RECEIVE_THE_SPECIFIED;?></label></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="2" style="padding-left:30px;">
						<?php foreach($type_array as $type_key => $type_value) {?>
						<label><input type="checkbox" name="message_receive_appoint[]" value="<?php echo $type_value['auto_id'];?>"<?php if(strstr($message_setting_result->fields['customers_info_message_receive_appoint'], "," . $type_value['auto_id'] . ",") != "") {echo "checked='checked';";}?> /><?php echo $type_value['title'];?></label><br/>
						<?php }?>
					</td>
				</tr>
				<tr>
					<td><label><input type="radio" name="message_receive_type" value="10"<?php if($message_setting_result->fields['customers_info_message_receive_type'] == "10") {echo " checked='checked';";}?> /> <?php echo TEXT_REJECT_ALL_MESSAGES;?></label></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
			</table>
			</form>
			<p class="filterbtn" style="padding-left:0px;">
				<button class="jq_message_setting_button defaultedit"><?php echo TEXT_SUBMIT;?></button>
				<a href="<?php echo zen_href_link(FILENAME_MYACCOUNT);?>"><button class="btncancel"><?php echo TEXT_CANCEL;?></button></a>
			</p>
			<br/>
			<div class="jq_message_content" style="color:#cb0000;display:none;"></div>
		</div>

    </div>
<?php ?>
</div>