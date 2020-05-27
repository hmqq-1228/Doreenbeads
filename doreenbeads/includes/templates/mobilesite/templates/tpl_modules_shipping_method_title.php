<?php 

							if ($quotes[$i]['id'] == "chinapost"){
								echo TEXT_SHIPPING_CHINAPOST;
							}elseif($quotes[$i]['id'] == "dfdhl"){
								echo TEXT_SHIPPING_NORMAL_DHL1;
							}elseif($quotes[$i]['id'] == "kddhl"){
								echo TEXT_SHIPPING_NORMAL_DHL2;
							}elseif($quotes[$i]['id'] == "ukline"){
								echo $quotes[$i]['module'];
							}elseif($quotes[$i]['id'] == "ukeurline"){
								echo TEXT_SHIPPING_UKEURLINE_TITLE;
							}elseif($quotes[$i]['id'] == 'ywdhl' || $quotes[$i]['id'] == 'ywdhl-dh'){
								echo TEXT_SHIPPING_DHL;
							}elseif($quotes[$i]['id'] == 'airmaillp'){
								echo $quotes[$i]['module'] . TEXT_SHIPPING_AIRMAILLIP;
							}elseif($quotes[$i]['id'] == 'kdups'){
								echo TEXT_SHIPPING_KDUPS;
							}elseif($quotes[$i]['id'] == 'zydhl'){
								echo TEXT_SHIPPING_NORMAL_DHL2;
							}elseif($quotes[$i]['id'] == 'zyups'){
								echo TEXT_SHIPPING_KDUPS;
							}elseif($quotes[$i]['id'] == 'zyfedex'){
								echo TEXT_SHIPPING_KDFEDEX;
							}elseif($quotes[$i]['id'] == 'hmmz'){
								echo TEXT_SHIPPING_HMMZ_TITLE;
							}elseif($quotes[$i]['id'] == 'ywfedex'){
								echo TEXT_SHIPPING_YWFEDEX;
							}else{
								echo $quotes[$i]['module'];
							}


?>