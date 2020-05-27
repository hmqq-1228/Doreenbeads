<div>
	<div id="track_info_title"><?php echo TEXT_PAYMENT_TRACK_INFO;?></div>
	<?php
		foreach ($track_info_array as $shipping_num => $track_info){
			if(sizeof($track_info['track_detail']) > 0){
			    $track_url_sql="SELECT track_url FROM ".TABLE_SHIPPING." WHERE code='".$track_info['shipping_code']."'";
			    $track_url=$db->Execute($track_url_sql);
				echo '<div class="package-status">';
				printf(TEXT_TRACKING_INFO_DETAIL, $track_info['shipping_title'], $shipping_num);
				if(isset($track_url->fields['track_url'])){
				printf(TEXT_TRACKING_INFO_URL, $track_url->fields['track_url']);
				}   
				//echo '</h3>';
				echo '<table cellpadding="0" cellspacing="0" border="0" width="100%">
						<tr>
							<th width="25%">' . TEXT_TIME . '</th>
							<th width="35%">' . DISCRIPTION . '</th>
							<th width="40%">' . TEXT_CREATE_MEMO . '</th>
						</tr>';
				foreach ($track_info['track_detail'] as $num => $track_detail){
					echo '<tr ' . (sizeof($track_info['track_detail']) != 1 ? ($num == 0 ? 'class="latest"' : ($num != sizeof($track_info['track_detail'])-1 ? '' : 'class="last"')) : 'class="only-one"') . '><td class="time" width="20%">' . date('d F,Y H:i:s' , strtotime($track_detail['tracking_get_date'])) . '</td><td class="description" width="55%">' . $track_detail['tracking_description'] . '</td><td class="memo">' . $track_detail['tracking_detail'] . '</td></tr>';
				}
				echo '</table></div>';
			}else{
				echo '<div class="package-status"><h3>';
				printf(TEXT_TRACKING_INFO_NULL_DETAIL, $shipping_num);
				echo '</h3>';
				echo '<div style="height:90px;"><span style="display: inline-block;margin: 30px;">' . TEXT_NULL_TRACKING_INFO . '</span></div></div>';
			}
		}
	?>
</div>