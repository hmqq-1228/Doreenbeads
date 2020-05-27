<?php




//							if ($quotes[$i]['id'] == "chinapost"){
//								$quotes[$i]['day'] = 5;
//								$quotes[$i]['days'] = '5-7';
//							}elseif($quotes[$i]['id'] == "airmail"){
//								$quotes[$i]['day'] = 10;
//								$quotes[$i]['days'] = '10-19';
//							}elseif($quotes[$i]['id'] == 'airmaillp'){
//								$quotes[$i]['day'] = 10;
//								$quotes[$i]['days'] = '10-19';
//							}elseif($quotes[$i]['id'] == "dfdhl"){
//								$quotes[$i]['day'] = 5;
//								$quotes[$i]['days'] = '5-7';
//							}elseif($quotes[$i]['id'] == "hmdpd"){
//								$quotes[$i]['day'] = 5;
//								$quotes[$i]['days'] = '5-8';
//							
//							if(isset($_SESSION['sendto']) && $_SESSION['sendto'] != ''){
//								$sql_country_id = $db->Execute("select entry_country_id as country_id
//						   from " . TABLE_ADDRESS_BOOK . "
//						   where address_book_id = " . $_SESSION['sendto']);
//								$country_id = $sql_country_id->fields['country_id'];
//								if ($country_id == 222){
//									$quotes[$i]['day'] = 4;
//									$quotes[$i]['days'] = '4-6';
//								}
//							}
//
//							}elseif($quotes[$i]['id'] == "ukeurline"){
//								$quotes[$i]['day'] = 7;
//								$quotes[$i]['days'] = '7-10';
//							}else

							if($quotes[$i]['id'] == "kddhl"){
								$kddhl_id = $i;
								$kddhl_price = $quotes[$i]['methods'][0]['cost'];
								$quotes[$i]['day'] = 4;
								$quotes[$i]['days'] = '4-8';
							}elseif($quotes[$i]['id'] == "ukline"){
								$quotes[$i]['day'] = 5;
								$quotes[$i]['days'] = '5-7';
							}elseif($quotes[$i]['id'] == 'ywdhl' || $quotes[$i]['id'] == 'ywdhl-dh'){
								$quotes[$i]['day'] = 3;
								$quotes[$i]['days'] = '3-4';
							}elseif($quotes[$i]['id'] == 'kdups'){
								$kdups_id=$i;
								$kdups_price = $quotes[$i]['methods'][0]['cost'];
								$quotes[$i]['day'] = 6;
								$quotes[$i]['days'] = '6-8';
							}elseif($quotes[$i]['id'] == 'zydhl'){
								$zydhl_id = $i;
								$zydhl_price = $quotes[$i]['methods'][0]['cost'];
								$quotes[$i]['day'] = 5;
								$quotes[$i]['days'] = '5-7';
							}elseif($quotes[$i]['id'] == 'zyups'){
								$zyups_id=$i;
								$zyups_price = $quotes[$i]['methods'][0]['cost'];
								$quotes[$i]['day'] = 6;
								$quotes[$i]['days'] = '6-8';
							}elseif($quotes[$i]['id'] == 'zyfedex'){
								$zyfedex_id=$i;
								$zyfedex_price = $quotes[$i]['methods'][0]['cost'];
								$quotes[$i]['day'] = 7;
								$quotes[$i]['days'] = '7-8';
							}elseif($quotes[$i]['id'] == 'ywmail'){
								$quotes[$i]['day'] = 6;
								$quotes[$i]['days'] = '6-8';
							}elseif($quotes[$i]['id'] == 'usexpr'){
								$quotes[$i]['day'] = 8;
								$quotes[$i]['days'] = '8-10';
							}else{
								$quotes[$i]['day'] = $quotes[$i]['day'];
								$quotes[$i]['days'] = $quotes[$i]['days'];
							}

?>


