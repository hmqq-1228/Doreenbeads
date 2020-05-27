 <style>
		   .Commission-title{
			   border-bottom: 1px solid #ccc;
			    margin-bottom: 20px;
		   }
		 .Commission-title  .on	{
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
		<!-- <ul class="Commission-title">
			<li><?php echo NAVBAR_TITLE_2;?></li>
			<li class="on"><?php echo NAVBAR_TITLE_3; ?></li>
			<div class="clearBoth"></div>
		</ul> -->
<!--引入佣金  开始-->
        <table>

			<tr>
				<th width="170"><?php echo TEXT_NAME;?></th>
				<th width="200"><?php echo IN_ORDER_TOTAL;?> </th>
				<th width="280"><?php echo RETURN_COMMISSION;?></th>
				<th width="280"><?php echo STATUS;?></th>
		
			</tr>
          <?php foreach ($commission_method as $method => $val){ ?>
			<tr>
				<td><?php echo substr($val['name'],0,7).'...';?></td>
				<td><?php echo $val['in_orders_total'];?></td>
				<td><?php echo $val['return_commission_total'];?></td>
				<td class="account_action"><?php echo $val['commission_status'];?></td> 
			</tr>
		   <?php } ?> 
		</table>
	
		 <!-- 分页 -->
        <div class="propagelist">
			<?php  echo $history_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info','x', 'y', 'main_page')));?>	
		</div>
    
    </div>
</div>
<script>
// $j(document).ready(function(){
// 	$j('.Commission-title li').each(function(index){
// 		$j(this).click(function(){
// 			if(! $j(this).hasClass('on')){
// 				$j('.Commission-title li.on').removeClass('on');
// 				$j(this).addClass('on');
// 				$j('.commission-div').hide().eq(index).show();
// 				$j('.commissiontable.sh').removeClass('sh');
// 				$j('.commissiontable').eq(index).addClass('sh');
// 			}
// 		})
// 	})

// })
</script>
