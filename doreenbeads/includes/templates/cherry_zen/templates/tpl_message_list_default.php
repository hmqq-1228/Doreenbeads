<div class="mycashaccount">
    <p class="ordertit"><strong><?php echo TEXT_MY_MESSAGE;?></strong></p>
    <div class="credittext">
        
        <div class="user_message_top" style="float: left;">
			<div class="user_message_top_left">
				<p class="filterbtn" style="padding-left:0px;">
					<a href="<?php echo zen_href_link(FILENAME_MESSAGE_LIST, zen_get_all_get_params(array('action', 'type', 'auto_id')) . 'action=update&type=is_ignore&auto_id=0');?>"><button class="jq_message_setting_button defaultedit"><?php echo TEXT_ALL_MARKED_AS_READ;?></button></a>&nbsp;&nbsp;&nbsp;
					<a href="<?php echo zen_href_link(FILENAME_MESSAGE_LIST, zen_get_all_get_params(array('action', 'type', 'auto_id')) . 'action=update&type=is_delete&auto_id=0');?>"><button class="defaultedit" onclick="window.location.href='<?php echo zen_href_link(FILENAME_MESSAGE_SETTING, zen_get_all_get_params(array('action')));?>';"><?php echo TEXT_DELETE_ALL;?></button></a>
				</p>
			</div>
			<div class="user_message_top_right">
				<label for="unread_input" onclick="window.location.href='<?php echo zen_href_link(FILENAME_MESSAGE_LIST, zen_get_all_get_params(array('action', 'type', 'auto_id', 'unread', 'page')) . (empty($unread) ? 'unread=1' : ''));?>';"><input id="unread_input" type="checkbox" value="1"<?php if(!empty($unread)) {echo " checked='checked'";}?> /> &nbsp;<?php echo TEXT_UNREAD_MESSAGE;?></label>
			</div>
				
		</div>
		<div class="clearfix"></div>
		
        <div class="user_message_list">
			<table cellpadding=0 cellspacing=0 border=0 style="display: table;">
				<tr>
					<th width="55%"><?php echo TEXT_TITLE;?></th>
					<th width="15%"><?php echo TEXT_TIME;?></th>
					<th width="30%"><?php echo TEXT_ACTION;?></th>
				</tr>
				<?php foreach($message_array as $message_value) {?>
				<tr<?php if(empty($message_value['is_read']) && empty($message_value['is_ignore'])) {?> class="unread jq_unread"<?php }?>>
					<td class="message_title<?php if(empty($message_value['is_read']) && empty($message_value['is_ignore'])) {?> unread_title<?php }?>"><a href="<?php echo zen_href_link(FILENAME_MESSAGE_INFO) . '&auto_id=' . $message_value['auto_id'];?>" target="_blank">[<span class="forange"><?php echo $message_value['title_type'];?></span>] <?php echo $message_value['title_list'];?></a></td>
					<td><?php echo zen_date_long($message_value['date_created']);?></td>
					<td>
						<?php if(empty($message_value['is_read']) && empty($message_value['is_ignore'])) {?>
						<a href="<?php echo zen_href_link(FILENAME_MESSAGE_LIST, zen_get_all_get_params(array('action', 'type', 'auto_id')) . 'action=update&type=is_ignore&auto_id=' . $message_value['auto_id']);?>"><?php echo TEXT_MARKED_AS_READ;?></a>&nbsp;
						<?php }?>
	
						<a href="<?php echo zen_href_link(FILENAME_MESSAGE_LIST, zen_get_all_get_params(array('action', 'type', 'auto_id')) . 'action=update&type=is_delete&auto_id=' . $message_value['auto_id']);?>"><?php echo TEXT_DELETE;?></a></td>
				</tr>
				<?php }?>
			</table>
		</div>
        
        <div class="propagelist"><?php echo TEXT_RESULT_PAGE . ' ' . $message_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page'))); ?> </div>     
    </div>
</div>