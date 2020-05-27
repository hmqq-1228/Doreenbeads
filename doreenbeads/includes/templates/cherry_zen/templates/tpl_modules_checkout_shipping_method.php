<?php
if($address_num > 0){
	foreach ($shipping_result as $method => $quotes){		
		if (!$quotes['error']){
			$has_valid_method = true;			
			echo '<div style="padding:8px 0px; border-bottom:1px dashed #CCCCCC" class="onemethod" cost="'.round($quotes['final_cost'], 2).'" day="'.($quotes['day_low']*10+$quotes['day_high']).'">' . "\n";
			echo '	<table width="100%" border="0" cellspacing="0" cellpadding="0">' . "\n";
			echo '    <tr onclick=changeNoteStatus("'.$method.'"); style="cursor:pointer;" >';		
			
			//进行价格的排序
			if ($method == $cheapest['code']){
				echo '<td width="3%">' . zen_draw_radio_field('shipping', $method . '_' . $method, true, 'id="ship-'.$method . '-' . $method.'"') . '</td>' . "\n";
			}else{
				echo '<td width="3%" >' . zen_draw_radio_field('shipping', $method . '_' . $method, false, 'id="ship-'.$method . '-' . $method.'"') . '</td>' . "\n";
			}
			
			if ($order->delivery['country']['iso_code_2'] == 'CN'){
				$sptca_ask = '<span style="float:right;">'.zen_image(DIR_WS_TEMPLATE_IMAGES.'ask.png', '', '', '', 'class="showDetailsImg details_tr_'.$method.'" onmouseover=showDetails(this)') . '<div class="extra_note" style="margin-left:-40px;"><div class="bgtri"></div><div class="bgnote">'.EXTRA_NOTE_CN. '</div></div></span>';
				$sptca_tr = '<span class="note-tr-display" style="float:right;margin-right:3px;color:black;" onclick=showDetailsTr("'.$method.'")>'.zen_image(DIR_WS_TEMPLATE_IMAGES.'s1.png', '', '', '', 'class="img_appear" id="img_'.$method.'"') . '</span>';
			}else {
				$sptca_ask = '';
				$sptca_tr = '';
			}
			
			echo '<td width="15%" style="text-align:left;font-weight:bold;">' . ($quotes['final_cost'] <= 0 ? TEXT_FREE_SHIPPING .$sptca_ask : ($currencies->format($quotes['final_cost']) . $sptca_ask)) . '</td>';
			if (sizeof($special_discount) > 0){
				echo '<td width="116px;" style="display:table-cell; color:#FF0000;">' . (isset($special_discount[$method]) && $special_discount[$method] > 0 ? '-' . $currencies->format($special_discount[$method]) : '') . '</td>';
			}
			echo '<td width="30%" style="text-align:left;font-weight:bold;"><a href="'.HTTP_SERVER.'/index.php?main_page=shippinginfo" target="_blank">' . $quotes['title'] . '</a>' . $sptca_tr . '</td>';
			echo '<td width="12%" style="text-align:left;">'.$quotes['days'].'&nbsp;' . zen_get_text_days($method) . '</td>';
			echo '<td width="24%">';
							
			if ($method == $cheapest['code']){
				echo '<span class="note-'.$method.' note-status" style="display:block;">';	
			}else{
				echo '<span class="note-'.$method.' note-status" style="display:none;">';
			}
							
			$str_note_title = '<div class="note-tr-display" onclick=showDetailsTr("'.$method.'")>';
			$img_appear = zen_image(DIR_WS_TEMPLATE_IMAGES.'s1.png', '', '', '', 'class="img_appear" id="img_'.$method.'"');
			$title_note = '';
			switch ($method){
				case 'chinapost' : $title_note = NOTE_EMS; break;
				case 'kdfedex' :
				case 'zyfedex' : 
					$title_note = $show_tax_note ? TEXT_NOTE_ABOUT_TAX : '';
					if ($show_watch_note){
						$str_note_title_watch = ($title_note != '' ? $img_appear : '') . '</div><div class="note-tr-display" onclick=showDetailsTr("'.$method.'_watch'.'")>';
						$img_appear = zen_image(DIR_WS_TEMPLATE_IMAGES.'s1.png', '', '', '', 'class="img_appear" id="img_'.$method.'_watch'.'"');
						$title_note .= $str_note_title_watch . NOTE_FEDEX;
					}
					break;
				case 'ywfedex' :
				case 'ywlbip' : 
					$title_note = $show_tax_note ? TEXT_NOTE_ABOUT_TAX : '';
					if ($show_watch_note){
						$str_note_title_watch = ($title_note != '' ? $img_appear : '') . '</div><div class="note-tr-display" onclick=showDetailsTr("'.$method.'_watch'.'")>';
						$img_appear = zen_image(DIR_WS_TEMPLATE_IMAGES.'s1.png', '', '', '', 'class="img_appear" id="img_'.$method.'_watch'.'"');
						$title_note .= $str_note_title_watch . NOTE_FEDEX;
					}
				case 'ywdhl' :
				case 'ywdhl-dh' : $title_note = $show_watch_note ? TEXT_NOTE_ABOUT_WATCH : ''; break;
				case 'ukeurline' :
				case 'hmdpd' : 
				case 'usexpr' : $title_note = NOTE_TARIFF; break;
				case 'sfhyzxb' : 
				case 'bpost' :
				case 'sfhky' : $title_note = TEXT_HOW_DOES_IT_WORKS; break;
				case 'ynkqy' :
				case 'trstma' : $title_note = TEXT_HOW_DOES_IT_WORKS_1; break;
				case 'sptya' : $title_note = TEXT_READ_NOTE;break;
			}
			$str_note_title .= ($title_note != '' ? $title_note . $img_appear : '') . '</div>';
			if ($title_note != '') echo $str_note_title;
			
			if ($method == 'airmail' && $order->delivery['country']['iso_code_2'] == 'RU'){
				echo 'We were informed by post office that airmail parcels to Russia being delayed badly. So in order to let you receive parcel in time, we will change shipping method (normally take about 3-4 weeks for shipping) for you free of additional charge after you checkout.';
			}
			
			if($method == "hmauexpr"){
				$sql_country_id = $db->Execute("select entry_street_address as street
								   from " . TABLE_ADDRESS_BOOK . "
								   where address_book_id = " . $_SESSION['sendto']);
				$street = $sql_country_id->fields['street'];
				if (strstr(strtolower($street), strtolower('PO box'))){
					echo '<span style="color:red;">'.TEXT_POBOX_REMINDER.'</span>';
				}
			}
			
			if($quotes['box'] > 1 && $method != 'airmail'){
				echo '<p>('.TEXT_YOUR_ITEMS_BE_SHIPPED.' <span style="font-weight:bold;">' . $quotes['box'] . '</span> '.TEXT_BOXES.'!)</p>';
			}
			
			if(($select_country_id == 13) && strpos($method, 'dhl')){
				echo '<p><a href="'.HTTP_SERVER.'/page.html?id=147 " target="_blank">'.TEXT_WOOD_PRODUCTS_NOTICE.'>></a></p>';
			}

			//bof 20121022
			if ($order->delivery['country']['iso_code_2'] == 'GR' && (strpos($method, 'dhl') !== false || strpos($method, 'ups') !== false || strpos($method, 'fedex') !== false || $method == 'ywlbip')){
				echo '<DIV>'.NOTE_GREECE.'</DIV>';
			}
			//eof

			if($quotes['remote_note'] <> ''){
				echo  '<p>' . $quotes['remote_note'] . '</p>' ;
			}
			
			if($quotes['volume_note'] <> ''){
				echo  '<p>' . $quotes['volume_note'] . '</p>' ;
			}
							
			echo '</span></td></tr>' . "\n";

			$close_btn = '<img style="float:right;padding-left:5px;cursor:pointer;" class="close_btn" src="includes/templates/cherry_zen/images/box_close.gif">';
			$str_note_tr = '<tr><td colspan="'.(sizeof($special_discount) > 0 ? 6 : 5).'"><div class="details_tr" id="details_tr_'.$method.'">' . $close_btn;
			$note = '';
			switch ($method){
				case 'chinapost' : $note = NOTE_EMS_CONTENT; break;
				case 'kdfedex' :
				case 'zyfedex' : 
					$note = TEXT_NOTE_ABOUT_TAX_CONTENT . '</div>';
					$note .= '<div class="details_tr" id="details_tr_'.$method.'_watch'.'">' . $close_btn . NOTE_FEDEX_CONTENT; break;
				case 'ywfedex' :
				case 'ywlbip' : 
					$note = TEXT_NOTE_ABOUT_TAX_CONTENT . '</div>';
					$note .= '<div class="details_tr" id="details_tr_'.$method.'_watch'.'">' . $close_btn . NOTE_FEDEX_CONTENT . '</div>'; break;
				case 'ywdhl' :
				case 'ywdhl-dh' : $note = TEXT_NOTE_ABOUT_WATCH_CONTENT; break;
				case 'ukeurline' :
				case 'hmdpd' : $note = NOTE_TARIFF_CONTENT; break;
				case 'usexpr' : $note = NOTE_TARIFF_CONTENT_US; break;
				case 'sfhyzxb' : $note = TEXT_DETAILS_SFHYZXB; break;
				case 'sfhky' : $note = TEXT_DETAILS_SFHKY;break;
				case 'trstma' : $note = TEXT_DETAILS_TRSTMA;break;
				case 'ynkqy' : $note = TEXT_DETAILS_YNKQY;break;
				case 'sptya' : $note = TEXT_SPTYA;break;
			}
			$str_note_tr .= $note . '</div></td></tr>' . "\n";
			if ($note != '') echo $str_note_tr;
			
			if ($order->delivery['country']['iso_code_2'] == 'CN'){
				echo '<tr><td colspan="5"><div class="details_tr" id="details_tr_'.$method.'">'.TEXT_DETAILS_SPTCA.'</div></td></tr>' . "\n";
			}

			echo '</table></div>' . "\n";
		}				
	}
	if ($has_valid_method == false){
		echo '<div style="padding:20px 30px;">' . TEXT_NO_AVAILABLE_SHIPPING_METHOD . '</div>';
	}
}