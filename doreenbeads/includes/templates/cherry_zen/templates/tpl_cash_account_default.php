<div class="mycashaccount">
    <p class="ordertit"><strong><?php echo TEXT_CASH_ACOUNT;?></strong></p>
    <div class="credittext">
        <p class="balancetit"><?php echo TEXT_USUALLY_WO_USE;?></p>
        <dl> 
            <dd>&bull;</dd>
            <dt><?php echo TEXT_USUALLY_WO_USE_FIRST;?></dt>
        </dl>
        <dl>
            <dd>&bull;</dd>
            <dt><?php echo TEXT_USUALLY_WO_USE_SECOND;?></dt>
        </dl>          
        <p class="balancetit"><?php echo TEXT_BALANCE_POLICY;?></p>
        <dl>
            <dd>&bull;</dd>
            <dt><?php echo TEXT_YOUR_BALANCE_WILL;?></dt>
        </dl>
        <dl>
            <dd>&bull;</dd>
            <dt><?php echo TEXT_BALANCE_ONLY_BE_USED;?></dt>
        </dl>           
        <p class="balancenote"><?php echo sprintf(TEXT_CREDIT_BALANCE_NOW_IS, $credit_account_code.number_format($credit_account_total, 2))?></p>      
        <table class="credittab" width="100%">
            <tr><th width="18%"><?php echo TEXT_CREDIT_DATE;?></th><th  width="18%"><?php echo TEXT_INCOME_AMOUNT;?></th><th  width="18%"><?php echo TEXT_CONSUMPTION_AMOUNT;?></th><th  width="46%"><?php echo TEXT_MEMO;?></th></tr>
            <?php
				if(count($credit_detial_array) > 0){
					foreach($credit_detial_array as $val){
						if($val['cac_order_create']!='2'){
						  if($val['cac_order_create']=='1' ){
							if($val['cac_amount'] < 0) {
							  	$cIncome='/';
							  	$cConsumption='- '.$val['cac_currency_code'].' '.number_format(-$val['cac_amount'],2);
						  	} else {
								$cIncome = '+ '.$val['cac_currency_code'].' '.number_format($val['cac_amount'],2);
								$cConsumption = '/';
							}
						  }else if($val['cac_order_create']=='2'){
							  	$cIncome='/';
								$cConsumption=$val['cac_currency_code'].' '.number_format($val['cac_amount'],2);							
						  }else{
							if($val['cac_amount']>0) {
							  	$cIncome=$val['cac_amount']>0?('+ '.$val['cac_currency_code'].' '.$val['cac_amount']):('- '.$val['cac_currency_code'].' '.number_format(-$val['cac_amount'],2));
							  	$cConsumption='/';
						  	} else {
								$cIncome='/';
								$cConsumption='- '.$val['cac_currency_code'].' '.number_format(-$val['cac_amount'],2);
							}
						  }
						  $dateTime=date('M d, Y',strtotime($val['cac_create_date']));
						  $showLength='20';
						  $show_all_memo=false;
						  if(strlen($val['cac_memo'])>$showLength){
						  	$show_all_memo=true;
						  	$cMemo=getstrbylength($val['cac_memo'], $showLength).'<span class="credit_memo_img"></span>';
						  }else{
						  	$cMemo=$val['cac_memo'];
						  }						  
						  echo '<tr><td>'.$dateTime.'</td><td style="color:red;">'.$cIncome.'</td><td style="color:green;">'.$cConsumption.'</td><td>'.$cMemo.'</td></tr>';		
						  if($show_all_memo){
						  	echo '<tr class="all_c_memo"><td colspan=4><div>'.$val['cac_memo'].'</div></td></tr>';
						  }				
						}
					}					
				} else {
					echo '<tr><td colspan="4" style="padding:20px 0;">' . TEXT_NO_RECORD . '</td></tr>';
				}
			?>
        </table>
        <div class="propagelist"><?php echo $credit_detial_split->display_links_new(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')) ) ?></div>     
    </div>
<?php ?>
</div>