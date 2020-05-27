 <style>
		   .Commission-title{
			   border-bottom: 1px solid #ccc;
			    margin-bottom: 20px;
		   }
		 .Commission-title .on	{
			   background-color: #bc66d8;
			   color: #fff;
		   }   
		  
         .Commission-title li{
			   float: left;
			   list-style: none;
			   padding: 0 20px;
			   line-height: 30px;
			   font-size: 14px;
			   font-weight: bold;
			   border: 1px solid #ccc;
			   background-color: #f7f7f7;
			   border-bottom: none;
			   color: #333;
			    cursor:pointer
		   }
 </style>
<div class="mycashaccount">
   <p class="ordertit"><strong><?php echo TEXT_MY_COMMSSION;?></strong><!-- <a href="javascript:void(0)" class="quickadd_btn">Quick Add Products >></a> --></p>
   <div class="orderdetail">

		<ul class="Commission-title">
			<li class="on"><?php echo NAVBAR_TITLE_2;?></li>
			<li><?php echo NAVBAR_TITLE_3;?></li>
			<div class="clearBoth"></div>
		</ul>
<!--引入佣金  开始-->
       <div class="commissiondiv">
        <table class="commissiontable commissiontable-one sh">

			<tr>
				<th width="170"><?php echo TEXT_DATE;?></th>
				<th width="300"> <?php echo IN_ORDER_TOTAL;?></th>
				<th width="200"><?php echo RETURN_COMMISSION;?></th>
				<th width="160"><?php echo ACTION;?></th>
		
			</tr>

			<?php foreach ($commission_method as $method => $val){ ?>
			<tr>
				<td><?php echo $val['time'];?></td>
				<td><?php echo $val['in_orders_total'];?></td>
				<td><?php echo $val['return_commission_total'];?></td>
				<td class="account_action">
				<a target="_blank"  href="index.php?main_page=<?php echo FILENAME_MY_COMMISSION_INFO;?>&pid=<?php echo $val['prometers_commission_info_id'];?>&cid=<?php echo $val['customers_dropper_id']?>"><?php echo VIEW_DETAILS;?></a>
				</td> 
			</tr>
			<?php } ?>
		   </div>
		   
		   
		</table>
		<div class="propagelist">
			<?php  echo $history_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info','x', 'y', 'main_page')));?>	
		</div>
	  </div>

		
	  <div class="commissiondiv" style="display:none">
	  	<table class="commissiontable commissiontable-two" >
	  		<tr>
				<th width="120"><?php echo TEXT_DATE;?></th>
				<th width="160"><?php echo IN_ORDER_TOTAL;?></th>
				<th width="150"><?php echo COMMISSION;?></th>
				<th width="160"><?php echo PAYMENT_DATE;?></th>
				<th width="150"><?php echo PAYMENT_METHOD;?></th>
				<th width="120"><?php echo ACTION;?></th>
			</tr>
			<?php foreach($commission_over_method as $method => $val){?>
			<tr>
				<td><?php echo $val['time']?></td>
				<td><?php echo $val['in_orders_total']?></td>
				<td><?php echo $val['return_commission_total']?></td>
				<td><?php echo $val['return_commission_time']?></td>
				<td><?php echo $val['payment_method']?></td>
				<td class="account_action">
				<a target="_blank"  href="index.php?main_page=<?php echo FILENAME_MY_COMMISSION_OVER_INFO;?>&pid=<?php echo $val['prometers_commission_info_id'];?>&cid=<?php echo $val['customers_dropper_id']?>"><?php echo VIEW_DETAILS;?></a>
				</td> 
			</tr>
		    <?php } ?>
	  	</table>
	  	<div class="propagelist">
			<?php  echo $history_split2->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info','x', 'y', 'main_page')));?>	
		</div>
	  </div>
    </div>
</div>
<script>
$j(document).ready(function(){
	$j('.Commission-title li').each(function(index){
		$j(this).click(function(){
			if(! $j(this).hasClass('on')){
				$j('.Commission-title li.on').removeClass('on');
				$j(this).addClass('on');
				$j('.commissiondiv').hide().eq(index).show();
				$j('.commissiontable.sh').removeClass('sh');
				$j('.commissiontable').eq(index).addClass('sh');
			}
		})
	})

})
</script>