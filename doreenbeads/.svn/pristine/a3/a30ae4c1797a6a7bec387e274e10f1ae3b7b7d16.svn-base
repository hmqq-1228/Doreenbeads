<style type="text/css">
input{width:18px;height:18px}.user_message_setting{padding-top:20px;padding-left:50px;font-size:14px;text-align:center;line-height:150%;padding-bottom:20px}
.user_message_setting
table{width:100%}.user_message_setting table tr th, .user_message_setting table tr
td{padding:4px
0px 4px 0px;text-align:left}.user_message_setting
.unread{background:#FFF4E8}.user_message_setting
.unread_title{font-weight:bold}.user_message_setting
.message_title{width:451px;display:block;text-align:left;padding-left:8px}.user_message_setting
.message_type_list{padding-left:30px}.user_message_setting label
input{margin-top:4px;margin-right:4px}
.affiliate-Setting td{vertical-align: top;
}
.affiliate-Setting input[type="text" ]{height: 30px; line-height: 30px; width: 200px; padding: 0 10px;border: 1px solid #ccc;}
.affiliate-Setting span{
	font-size: 13px; color:#BF0101
}
.user_message_setting h5{text-align: left; padding-top: 10px;}
.Setting-bt{
	text-align: left;	
}
.Setting-bt button{padding: 0 30px; line-height: 28px;}
</style>
<div class="mycashaccount">
    <p class="ordertit"><strong><?php echo TEXT_COMMISSION_SET;?></strong></p>
    <div class="credittext">
        <div class="user_message_setting affiliate-Setting">
			<form class="jq_from_message_setting" id="from_message_setting" name="from_message_setting" method="post" action="index.php?main_page=<?php echo FILENAME_COMMISSION_SET;?>&action=edit" onsubmit="return check_submit_form();">
			<table>
				<tr>
				  <td width="20%"><?php echo URL;?></td><td><?php echo HTTP_SERVER .$res->fields['dropper_url'];?></td>
				</tr>
				<tr>
					<td><?php echo CONTACT_WAY;?></td><td><input id="contact_way" class="affiliate-Setting" name="contact_way" type="text"  value="<?php echo $res->fields['contact_way'];?>">
				     <div><span id="error_info1"></span></div>
					</td>
				</tr>
			</table>
			<h5 class=""><?php echo PAY_MENTMETHOD;?></h5>
			<table style="display: table;" cellspacing="0" cellpadding="0" border="0">
				<tbody><tr>
					<td width="20%"><label><input id="banlance" type="radio" class="radio" name="message_receive_type" value="10" onclick="checkboxOnclick(this)">Balance</label></td>
					<td ></td>
				</tr>
				<?php if($res->fields['paypal'] != ''){ ?>
                 <script language="javascript" type="text/javascript">
                    $j(document).ready(function(){
                    	$j('#paypal').attr('checked','checked');

                    });
                 </script>
				<?php }else{ ?>
				<script language="javascript" type="text/javascript">
					$j(document).ready(function(){
                    	$j('#banlance').attr('checked','checked');
                    	$j('#pay').attr('disabled','disabled');
                    });

                 </script>
			    <?php } ?>
				<tr>
					<td><label><input id="paypal" type="radio" class="radio"  name="message_receive_type" value="20" onclick="checkboxOnclick(this)">Paypal</label></td>
					<td ><input class="affiliate-Setting" id="pay" name="paypal" type="text"  value="<?php echo $res->fields['paypal'];?>">
					<div><span id="error_info2"></span></div>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
			</tbody></table>
			
			<p class="filterbtn Setting-bt" style="padding-left:0px;">
				<button type="save" class="jq_message_setting_button defaultedit">Save</button>
			</p>
		    </form>
			<br>
			<div class="jq_message_content" style="color:#cb0000;display:none;"></div>
		</div>

    </div>
</div>