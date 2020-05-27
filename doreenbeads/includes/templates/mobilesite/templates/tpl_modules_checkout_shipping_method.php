<script type="text/javascript">
$(document).ready(function(){
	$('.note-tr-display, .details_tr').click(function(e){
		e.stopPropagation();
	})
})
</script>
<?php
$radio_buttons = 0;
//				natsort($quotes);
//				print_r($quotes);exit;
				//print_r($_SESSION);exit;.
				$quotes_s = $quotes;
				for ($i = 0, $n = sizeof($quotes); $i < $n; $i++){
					require($template->get_template_dir('tpl_modules_shipping_method_days.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_shipping_method_days.php');
					$array_day[$i] = $quotes[$i]['day'];
				}					
				if($_GET['price']=='asc'){
					$array;
					$arrats;
					for ($i = 0, $n = sizeof($quotes); $i < $n; $i++){
						$array[$i]= intval($quotes[$i]['methods'][0]['cost']);
					}
					natsort($array);
					$id =0;
					foreach ($array as $key => $value){
						$arrats[$id] = $key;
						$id++;
					}
					$price = 'desc';
					$price_alt = 'price from high to low';
				}
				else if($_GET['price']=='desc'){
					$array;
					$arrats;
					for ($i = 0, $n = sizeof($quotes); $i < $n; $i++){
						$array[$i]= intval($quotes[$i]['methods'][0]['cost']);
						
					}
					natsort($array);
					$array = array_reverse($array,true);
//					print_r($array);exit;
					$id =0;
					foreach ($array as $key => $value){
						$arrats[$id] = $key;
						$id++;
					}
//					print_r($arrats);
					$price = 'asc';
					$price_alt='price from low to high';
				}
				else{
					$price = 'asc';
					$price_alt='price from low to high';
				}
				
				if($_GET['price']=="" && $_GET['days']==""){
					natsort($array_day);
					$id_day=0;
					foreach ($array_day as $key => $value){
						$arrat_days[$id_day] = $key;
						$id_day++;
					}
					$days = 'desc';
					$days_alt = 'days from slow to quick';
				}else if($_GET['days'] == "asc"){
					natsort($array_day);
//					print_r($array_day);exit;
					$id_day=0;
					foreach ($array_day as $key => $value){
						$arrat_days[$id_day] = $key;
						$id_day++;
					}
					$days_alt = 'days from slow to quick';
					$days = 'desc';
				}
				else if($_GET['days'] == "desc"){
					
					natsort($array_day);
					$array_day = array_reverse($array_day,true);
					$id_day=0;
					foreach ($array_day as $key => $value){
						$arrat_days[$id_day] = $key;
						$id_day++;
					}
					$days_alt = 'days from quick to slow';
					$days = 'asc';
				}else{
					$days = 'asc';
					$days_alt = 'days from quick to slow';
				}
				
			    if($kddhl_price != "" && $zydhl_price != ""){
					if($kddhl_price> $zydhl_price){
						unset($quotes[$kddhl_id]);
					}else{
						unset($quotes[$zydhl_id]);
					}
				}
				
				if($zyups_price != "" && $kdups_price != ""){
					if($zyups_price > $kdups_price){
						unset($quotes[$zyups_id]);
					}else{
						unset($quotes[$kdups_id]);
					}
				}
				
				if($kdfedex_price != "" && $zyfedex_price != ""){
					if($kdfedex_price>$zyfedex_price){
						unset($quotes[$kdfedex_id]);
					}else{
						unset($quotes[$zyfedex_id]);
					}
				}
				echo '<div style="padding:8px 0px; border-bottom:1px dashed #CCCCCC">' . "\n";
				echo '	<table width="100%" border="0" cellspacing="0" cellpadding="0">' . "\n";
				echo '    <tr>';
				if (sizeof($quotes) == 1 && $quotes[0]['methods'][0]['cost'] == 0){
					echo "<th width='3%'></th><th width='12%'>".TEXT_PRICE."</th><th width='30%'>".TEXT_SHIPPING_METHOD."</th><th width='18%'>".TEXT_DAYS."</th><th>".TEXT_NOTE."</th>";
				}else{
					echo "<th width='3%'></th><th width='12%'><a onclick='checkout_shipping_price(\"".$price."\");' title='".$price_alt."' href='javascript:void(0);'>".TEXT_PRICE."&nbsp;<img style='vertical-align: middle;' src='".DIR_WS_TEMPLATE_IMAGES."asc.png'/></a></th><th width='30%'>".TEXT_SHIPPING_METHOD."</th><th width='18%'><a   onclick='checkout_shipping_days(\"".$days."\");' title='".$days_alt."'  href='javascript:void(0);'>".TEXT_DAYS."&nbsp;<img style='vertical-align: middle;' src='".DIR_WS_TEMPLATE_IMAGES."asc.png'/></a></th><th>".TEXT_NOTE."</th>";
				}
				echo '    </tr>';
				echo '</table></div>' . "\n";
				if($address_num == 0){
					//echo '<div style="padding:20px 30px;color:red;">' . TEXT_ADD_SHIPPING_ADDRESS . '</div>';
				}else{
				for ($i = 0, $n = sizeof($quotes_s); $i < $n; $i++){					
					$s = $i;
					if(isset($_GET['price'])){//按照价格升序
						$i = $arrats[$s];
					}
					if(isset($_GET['days'])){
						$i = $arrat_days[$s];
					}
					if($_GET['price']=="" && $_GET['days']==""){
						$i = $arrat_days[$s];
					}
					if (isset($quotes[$i]['error'])){
						//do nothing
					}else{
						$has_valid_method = true;
						for ($j=0, $n2=sizeof($quotes[$i]['methods']); $j<$n2; $j++){				
							$str_ru_method = '';
							if ($quotes[$i]['id'] == 'sptya' || $quotes[$i]['id'] == 'trstv' || $quotes[$i]['id'] == 'trstm' || $quotes[$i]['id'] == 'trstma'){
								$str_ru_method .= '<div style="float:center;padding:8px 0px; border-bottom:1px dashed #CCCCCC;">' . "\n";
								$str_ru_method .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">' . "\n";
								$str_ru_method .= '<tr>';
								if ($quotes[$i]['id'] == $ls_min_id){
									$str_ru_method .= '			<td width="3%">' . zen_draw_radio_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'], true, 'onclick=changeNoteStatus("'.$quotes[$i]['id'].'"); id="ship-'.$quotes[$i]['id'] . '-' . $quotes[$i]['methods'][$j]['id'].'"') . '</td>' . "\n";
								}else{
									$str_ru_method .= '			<td width="3%" >' . zen_draw_radio_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'], false, 'onclick=changeNoteStatus("'.$quotes[$i]['id'].'"); id="ship-'.$quotes[$i]['id'] . '-' . $quotes[$i]['methods'][$j]['id'].'"') . '</td>' . "\n";
								}
								if (($n > 1) || ($n2 > 1)){
									$str_ru_method .= '<td width="12%" style="text-align:left;font-weight:bold;">' . $currencies->format(zen_add_tax($quotes[$i]['methods'][$j]['cost'], (isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0))) . '</td>' . "\n";
								}else{
									$str_ru_method .= '<td width="12%" style="text-align:left;font-weight:bold;">' . $currencies->format(zen_add_tax($quotes[$i]['methods'][$j]['cost'], $quotes[$i]['tax'])) . zen_draw_hidden_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id']) . '</td>' . "\n";
								}
									
								$str_ru_method .= '<td width="20%" class="note-tr-display" style="text-align:left;font-weight:bold;color:white;" onclick=showDetailsTr("'.$quotes[$i]['id'].'")>'.$quotes[$i]['title'] . '</span>' .'&nbsp;<span style="float:right;cursor:pointer;margin-right:3px;">'.zen_image(DIR_WS_TEMPLATE_IMAGES.'s1.png', '', '', '', 'class="img_appear" id="img_'.$quotes[$i]['id'].'"') . '</span>&nbsp;</td>';
								$str_ru_method .= '<td width="10%" style="text-align:left;">'.$quotes[$i]['days'].'&nbsp;'.TEXT_DAYS_LAN;
								if ($quotes[$i]['id'] == 'sptya'){
//									$str_ru_method .= '<span style="float:right;margin-right:5px;">'.zen_image(DIR_WS_TEMPLATE_IMAGES.'ask.png', '', '', '', 'class="showDetailsImg details_tr_'.$quotes[$i]['id'].'" onmouseover=showDetails(this)') . '</span><div class="extra_note"><div class="bgtri"></div><div class="bgnote">'.EXTRA_NOTE. '</div></div>';
								}
								$str_ru_method .= '</td>';
								$str_ru_method .= '<td style="text-align:left; width:28%;">';
								$str_ru_method .= '<span class="note-'.$quotes[$i]['id'].' note-status" style="display:'.($quotes[$i]['id'] == $ls_min_id ? 'block' : 'none').';">';
								if($quotes[$i]['id'] == 'sptya'){
									$str_ru_method .= TEXT_NOTE_SPTYA;
								}elseif($quotes[$i]['id'] == 'trstma' && isset($_SESSION['russia_discount'])){
									$str_ru_method .= TEXT_NOTE_TRSTMA;
								}
								$str_ru_method .= '</span></td>';
								$str_ru_method .= '</tr>' . "\n";								
								
								switch ($quotes[$i]['id']){
									case 'sptya' : echo $str_ru_method . '<tr><td colspan="5"><div class="details_tr" id="details_tr_'.$quotes[$i]['id'].'">'.TEXT_DETAILS_SPTYA.'</div></td></tr></table></div>' . "\n";break;
									case 'trstv' : echo  $str_ru_method . '<tr><td colspan="5"><div class="details_tr" id="details_tr_'.$quotes[$i]['id'].'">'.TEXT_DETAILS_TRSTV.'</div></td></tr></table></div>' . "\n";break;
									case 'trstm' : echo  $str_ru_method . '<tr><td colspan="5"><div class="details_tr" id="details_tr_'.$quotes[$i]['id'].'">'.TEXT_DETAILS_TRSTM.'</div></td></tr></table></div>' . "\n";break;
									case 'trstma' : echo $str_ru_method . '<tr><td colspan="5"><div class="details_tr" id="details_tr_'.$quotes[$i]['id'].'">'.(isset($_SESSION['russia_discount'])?TEXT_RUSSIA_DISCOUNT_IF_NOT_MOSCOW:TEXT_DETAILS_TRSTMA).'</div></td></tr></table></div>' . "\n";break;
								}
								continue;							
							}
							
							$checked = (($quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'] == $_SESSION['shipping']['id']) ? true : false);
							echo '<div style="float:center;padding:8px 0px; border-bottom:1px dashed #CCCCCC">' . "\n";
							echo '	<table width="100%" border="0" cellspacing="0" cellpadding="0">' . "\n";
							echo '    <tr>';		
							
							//进行价格的排序
							if ($quotes[$i]['id'] == $ls_min_id){
								echo '			<td width="3%">' . zen_draw_radio_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'], true, 'onclick=changeNoteStatus("'.$quotes[$i]['id'].'"); id="ship-'.$quotes[$i]['id'] . '-' . $quotes[$i]['methods'][$j]['id'].'"') . '</td>' . "\n";
							}else{
								echo '			<td width="3%" >' . zen_draw_radio_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'], false, 'onclick=changeNoteStatus("'.$quotes[$i]['id'].'"); id="ship-'.$quotes[$i]['id'] . '-' . $quotes[$i]['methods'][$j]['id'].'"') . '</td>' . "\n";
							}
							
							if ($order->delivery['country']['iso_code_2'] == 'CN'){
								$sptca_ask = '<span style="float:right;margin-right:20px;">'.zen_image(DIR_WS_TEMPLATE_IMAGES.'ask.png', '', '', '', 'class="showDetailsImg details_tr_'.$quotes[$i]['id'].'" onmouseover=showDetails(this)') . '<div class="extra_note" style="margin-left:-40px;"><div class="bgtri"></div><div class="bgnote">'.EXTRA_NOTE_CN. '</div></div></span>';
								$sptca_tr = '<span class="note-tr-display" style="float:right;margin-right:3px;color:white;" onclick=showDetailsTr("'.$quotes[$i]['id'].'")>'.zen_image(DIR_WS_TEMPLATE_IMAGES.'s1.png', '', '', '', 'class="img_appear" id="img_'.$quotes[$i]['id'].'"') . '</span>';
							}else {
								$sptca_ask = '';
								$sptca_tr = '';
							}
							
							if (($n > 1) || ($n2 > 1)){
								echo '			<td width="12%" style="text-align:left;font-weight:bold;">' . $currencies->format(zen_add_tax($quotes[$i]['methods'][$j]['cost'], (isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0))) . $sptca_ask . '</td>' . "\n";
							}else{
								echo '			<td width="12%" style="text-align:left;font-weight:bold;">' . $currencies->format(zen_add_tax($quotes[$i]['methods'][$j]['cost'], $quotes[$i]['tax'])) . zen_draw_hidden_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id']) . $sptca_ask . '</td>' . "\n";
							}							
							echo '			<td width="20%" style="text-align:left; font-weight:bold;"><a href="'.HTTP_SERVER.(($_SESSION['languages_id']==1)?'':'/'.$_SESSION['languages_code']).'/'.'index.php?main_page=shippinginfo" target="_blank">';
							
							require($template->get_template_dir('tpl_modules_shipping_method_title.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_shipping_method_title.php');
							
							echo '</a>' . $sptca_tr . '</td>' . "\n";
						
							if(strstr($quotes[$i]['days'],TEXT_DAYS_LAN)){
								echo '<td width="10%" style="text-align:left;">'.$quotes[$i]['days'].'&nbsp;</td>';
							}else{
								echo '<td width="10%" style="text-align:left;">'.$quotes[$i]['days'].'&nbsp;'.TEXT_DAYS_LAN.'</td>';
							}
//							print_r($quotes);exit;
							echo '<td style="text-align:left; width:28%;">';
							
						if ($quotes[$i]['id'] == $ls_min_id){
							echo '<span class="note-'.$quotes[$i]['id'].' note-status" style="display:block;">';	
						}else{
							echo '<span class="note-'.$quotes[$i]['id'].' note-status" style="display:none;">';
						}
						if ($special_customer_total > 150 && $_SESSION['cart']->show_total() > 150){
							$open_live_chat_url='onclick="window.open(\'' . HTTP_LIVECHAT_URL . '/request.php?langs='.$_SESSION['language'].'&amp;uname='.$_SESSION['customer_first_name'].'&amp;uemail='.$url_email.'&amp;l=HongShengXie&amp;x=1&amp;deptid=1&amp;pagex=http%3A//'.$_SERVER['REQUEST_URI'].'\',\'unique\',\'scrollbars=no,menubar=no,resizable=0,location=no,screenX=50,screenY=100,width=500,height=400\')"';
							echo sprintf(TEXT_SPECIAL_CUSTOMER_NOTE_CHECKOUT, $open_live_chat_url);
						}else{
							$str_note_title = '<div class="note-tr-display" onclick=showDetailsTr("'.$quotes[$i]['id'].'")>';
							$img_appear = zen_image(DIR_WS_TEMPLATE_IMAGES.'s1.png', '', '', '', 'class="img_appear" id="img_'.$quotes[$i]['id'].'"');
							$title_note = '';
							switch ($quotes[$i]['id']){
								case 'chinapost' : $title_note = NOTE_EMS; break;
								case 'kdfedex' :
								case 'zyfedex' : $title_note = $show_tax_note ? TEXT_NOTE_ABOUT_TAX : '';
													if ($show_watch_note){
														$str_note_title_watch = ($title_note != '' ? $img_appear : '') . '</div><div class="note-tr-display" onclick=showDetailsTr("'.$quotes[$i]['id'].'_watch'.'")>';
														$img_appear = zen_image(DIR_WS_TEMPLATE_IMAGES.'s1.png', '', '', '', 'class="img_appear" id="img_'.$quotes[$i]['id'].'_watch'.'"');
														$title_note .= $str_note_title_watch . NOTE_FEDEX;
													}
													break;												
								case 'ywfedex' :
								case 'ywlbip' : $title_note = $show_tax_note ? TEXT_NOTE_ABOUT_TAX : '';
													if ($show_watch_note){
														$str_note_title_watch = ($title_note != '' ? $img_appear : '') . '</div><div class="note-tr-display" onclick=showDetailsTr("'.$quotes[$i]['id'].'_watch'.'")>';
														$img_appear = zen_image(DIR_WS_TEMPLATE_IMAGES.'s1.png', '', '', '', 'class="img_appear" id="img_'.$quotes[$i]['id'].'_watch'.'"');
														$title_note .= $str_note_title_watch . NOTE_FEDEX;
													}
								case 'ywdhl' :
								case 'ywdhl-dh' : $title_note = $show_watch_note ? TEXT_NOTE_ABOUT_WATCH : ''; break;
								case 'ukeurline' :
								case 'hmdpd' : 
								case 'cnezx' : 
								case 'usexpr' : $title_note = NOTE_TARIFF; break;
								case 'sfhyzxb' : 
								case 'bpost' :break;
								case 'eyoubao' :
								case 'xxeub' : $title_note = 'If your order contains electronic products like watches, electronic scale etc. , please do not choose USA airline. Why?';break;
								case 'hmjz' :
								case 'sfhky' : $title_note = TEXT_HOW_DOES_IT_WORKS; break;
							}
							$str_note_title .= ($title_note != '' ? $title_note . $img_appear : '') . '</div>';
							if ($title_note != '') echo $str_note_title;
							
							if($quotes[$i]['id'] == "hmauexpr"){
								$sql_country_id = $db->Execute("select entry_street_address as street
												   from " . TABLE_ADDRESS_BOOK . "
												   where address_book_id = " . $_SESSION['sendto']);
								$street = $sql_country_id->fields['street'];
								if (strstr(strtolower($street), strtolower('PO box'))){
									echo '<span style="color:red;">'.TEXT_POBOX_REMINDER.'</span>';
								}
							}
							
							if(isset($quotes[$i]['num_box']) && (int)($quotes[$i]['num_box']) > 1){
								echo '<p>('.TEXT_YOUR_ITEMS_BE_SHIPPED.' <span style="font-weight:bold;">' . $quotes[$i]['num_box'] . '</span> '.TEXT_BOXES.'!)</p>';
							}
							
							if(($select_country_id == 13) && strpos($quotes[$i]['id'], 'dhl')){
								echo '<p><a href="'.HTTP_SERVER.(($_SESSION['languages_id']==1)?'':'/'.$_SESSION['languages_code']).'/page.html?id=147 " target="_blank">'.TEXT_WOOD_PRODUCTS_NOTICE.'>></a></p>';
							}

							//bof 20121022							
							if ($order->delivery['country']['iso_code_2'] == 'GR' && (strpos($quotes[$i]['id'], 'dhl') !== false || strpos($quotes[$i]['id'], 'ups') !== false || strpos($quotes[$i]['id'], 'fedex') !== false || $quotes[$i]['id'] == 'ywlbip')){
								echo '<DIV>'.NOTE_GREECE.'</DIV>';
							}
							//eof

							if($quotes[$i]['methods'][$j]['title_note'] <> ''){
								echo  '<p>'.$quotes[$i]['methods'][$j]['title_note'].'</p>' ;
							}
						}
							echo '</span></td></tr>' . "\n";
							
							$str_note_tr = '<tr><td colspan="5"><div class="details_tr" id="details_tr_'.$quotes[$i]['id'].'">';
							$note = '';
							switch ($quotes[$i]['id']){
								case 'chinapost' : $note = NOTE_EMS_CONTENT; break;
								case 'kdfedex' :
								case 'zyfedex' : $note = TEXT_NOTE_ABOUT_TAX_CONTENT . '</div>';
                                             $note .= '<div class="details_tr" id="details_tr_'.$quotes[$i]['id'].'_watch'.'">' . NOTE_FEDEX_CONTENT; break;
								case 'ywfedex' :
								case 'ywlbip' : $note = TEXT_NOTE_ABOUT_TAX_CONTENT . '</div>';
												  $note .= '<div class="details_tr" id="details_tr_'.$quotes[$i]['id'].'_watch'.'">' . NOTE_FEDEX_CONTENT . '</div>';
								case 'ywdhl' :
								case 'ywdhl-dh' : $note = TEXT_NOTE_ABOUT_WATCH_CONTENT; break;
								case 'ukeurline' :
								case 'cnezx' : 
								case 'hmdpd' : $note = NOTE_TARIFF_CONTENT; break;
								case 'usexpr' : $note = NOTE_TARIFF_CONTENT_US; break;
								case 'sfhyzxb' : $note = TEXT_DETAILS_SFHYZXB; break;
								case 'sfhky' : $note = TEXT_DETAILS_SFHKY;break;
								case 'eyoubao' : $note = TEXT_EYOUBAO;break;
								case 'xxeub' : if($_SESSION['languages_id'] == 1){$note = TEXT_XXEUB;}else{$note = '';}break;
								case 'hmjz' : $note = TEXT_HMJZ;break;
							}
							$str_note_tr .= $note . '</div></td></tr>' . "\n";
							if ($note != '' && $special_customer_total <= 150) echo $str_note_tr;
							
							if ($order->delivery['country']['iso_code_2'] == 'CN'){
								echo '<tr><td colspan="5"><div class="details_tr" id="details_tr_'.$quotes[$i]['id'].'">'.TEXT_DETAILS_SPTCA.'</div></td></tr>' . "\n";
							}

							//bof 20121022
//							switch ($quotes[$i]['id']){
//								case 'sfhyzxb': echo get_shipping_method_note($quotes[$i]['id'], '', TEXT_DETAILS_SFHYZXB);break;		
//								case 'sfhky': echo get_shipping_method_note($quotes[$i]['id'], '', TEXT_DETAILS_SFHKY);break;								
//							}
							//eof

							echo '</table></div>' . "\n";
							$radio_buttons++;
						}
					}
					$i = $s;					
				}
					if ($has_valid_method == false){
						echo '<div style="padding:20px 30px;">' . TEXT_NO_AVAILABLE_SHIPPING_METHOD . '</div>';
					}
				}