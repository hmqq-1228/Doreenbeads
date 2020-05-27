<div class="accountfirst">
     <h3 class="calltit"><?php echo sprintf(TEXT_SAY_HI,$_SESSION['customer_first_name']);?></h3>

<?php if($show_ru_get_coupon){ ?>
	<div class="coupontips" id="ru_get_coupon">
		Дорогой клиент! Чтобы отмечать открытие русского сайта, каждый новый клиент может получить купоны --- общая стоимость: $36.03! <a href="<?php echo zen_href_link('get_coupon'); ?>">Получите купоны прямо сейчас!</a> <span onclick="hide_ru_get_coupon()">&times;</span>
	</div>
	<script type="text/javascript">
	function hide_ru_get_coupon(){
		document.getElementById('ru_get_coupon').style.display = 'none';
		setCookie("hide_ru_get_coupon","true",<?php echo $show_ru_cookie_day; ?>);
	}
	</script>
<?php } ?>
<?php if($show_ru_use_coupon){ ?>
	<div class="coupontips" id="ru_use_coupon">
		Дорогой клиент, у Вас ещё есть купоны: общая стоимость: $ <?php echo $show_ru_use_amount; ?>. Мы заметили, что вы ещё не используется. Осталось только <?php echo $show_ru_day_type; ?> дней! Используйте сейчас!))) <span onclick="hide_ru_use_coupon()">&times;</span>
	</div>
	<script type="text/javascript">
	function hide_ru_use_coupon(){
		document.getElementById('ru_use_coupon').style.display = 'none';
		setCookie("hide_ru_use_coupon","true",<?php echo $show_ru_ucookie_day; ?>);
	}
	</script>
<?php } ?>

     <!-- <p class="quickadd_btn"><a href="javascript:void(0)"> --><?php /* echo TEXT_CART_QUICK_ORDER_BY; */?><!-- &gt;&gt;</a></p> -->
     <br>
     <?php if($customer_new&&false){
     	?>
     	<div class="consumption">
        <p><strong><?php echo TEXT_TOTAL_CONSUMPTION;?> <ins><?php echo $display_orders_total;?></ins></strong></p>
        <p><strong><?php echo TEXT_WHAT_YOU_CAN_ENJOY;?></strong></p>
		
         <?php echo (($_SESSION['register_languages_id']==4||$_SESSION['register_languages_id']==2)?TEXT_DISCOUNT_TABLE_INFO_2:TEXT_DISCOUNT_TABLE_INFO);?>
		 <?php echo $text_value;?>
     	</div>
     	<?php
     }else{
     	?>
     	<div class="caption_shopgray">
		<div class="level">
        <ul>
			<?php if($history_amount<5000 && $cVipInfo['group_percentage'] < 15){
				?>
				<li class="next_level"><span><strong><?php echo $cNextVipInfo['customer_group'];?></strong>(<?php echo $cNextVipInfo['group_percentage'];?>% <?php echo TEXT_CART_OFF;?>)</span></li>           	
            	<li class="<?php echo $history_amount==0?'schedule_null':'schedule';?>"><span style="width:<?php echo $width_vip_li;?>%;"><ins><?php echo floor($history_amount).' / '.$cNextVipInfo['max_amt'];?> (US $)</ins></span></li>
				<?php
			}?>
            <li class="current">
            	<span><?php if(!$_SESSION['channel']){?><strong><?php echo $cVipInfo['customer_group'];?></strong>(<?php }?><?php echo $cVipInfo['group_percentage'];?>% <?php echo TEXT_CART_OFF;?><?php if(!$_SESSION['channel']){?>)<?php }?></span>
            </li>
            <li><?php echo TEXT_CART_MY_VIP;?>:</li>
        </ul>
   		</div>
		</div>
		<div class="consumption_vip">
      	<p><strong><?php echo TEXT_CREDIT_BALANCE;?> <ins><?php echo $credit_account_total_display;?></ins></strong></p>
      	<p><strong><?php echo TEXT_TOTAL_CONSUMPTION;?> <ins><?php echo $display_orders_total;?></ins></strong>
			<?php if(isset($order_total_integral)  && $order_total_integral->fields['total'] != ''){?>
		   (<?php echo TEXT_ACTUAL_CONSUMPTION;?>: <ins><strong><?php echo $currencies->format($old_customers_orders_total);?></strong></ins>&nbsp;&nbsp;&nbsp;
			<?php echo TEXT_PROMOTION_CUNSUMPTION;?>: <ins><strong><?php echo $currencies->format($order_total_integral->fields['total']);?></strong></ins>)
		   <?php }?>
		   </p>   
     	</div>
     	<?php
     }?>    
     <div class="scan">
       <?php echo TEXT_NOW_YOU_CAN;?>     
     </div>
	<?php if(sizeof($matching_products_content)){
		?>	
		<div class="best_seller">
		<div class="detailcont">
			<p class="detailconttit"><strong><?php echo BEST_SELLER;?></strong></p>
		</div>
        <div class="detailcont">
			<?php echo $title;?>
			<ul class="detailitem product_list">
			<?php for ($i = 0; $i < 10; $i++) {?>
			<li>
				<?php 
					echo $matching_products_content[$i]['discount'];
					echo $matching_products_content[$i]['img'];
					echo $matching_products_content[$i]['name'];
					echo $matching_products_content[$i]['price'];
					echo $matching_products_content[$i]['button'];			
				?>		
			</li>
			<?php } ?>      
			<div class="clearfix"></div>
			</ul>
		</div>    
     </div>
		<?php
	}?>
     
</div>
<div id="quick_add_content">
	<div class="smallwindow quickfind" style="display: none;">
		<div class="smallwindowtit">
			<strong><?php echo TEXT_CART_QUICK_ADD_NOW;?></strong><span></span>
		</div>
		<div class="quickaddcont">
			<p class="quicktext"><?php echo TEXT_CART_QUICK_ADD_NOW_TITLE;?></p>
			<form action="index.php?main_page=shopping_cart&page=<?php echo $page;?>" method="post" name="quick_add">
				<input type="hidden" name="action" value="addselect">
				<table class="quickadd" width="100%">
					<tr>
						<th><?php echo TEXT_CART_P_NUMBER;?></th>
						<th><?php echo TEXT_CART_P_QTY;?></th>
					</tr>
					<tr>
						<td style="padding-top: 15px;"><input type="text" name="product_model[]" /></td>
						<td style="padding-top: 15px;"><input type="text" name="product_qty[]" onpaste="return false" /></td>
					</tr>
					<?php for($ii=0;$ii<=8;$ii++){
					?>
					<tr>
						<td><input type="text" name="product_model[]" /></td>
						<td><input type="text" name="product_qty[]" onpaste="return false" /></td>
					</tr>
					<?php
					}?>
				</table>
			</form>
			<p class="doublebutton">
				<button class="btn_yellow">
					<span><strong><?php echo ADD_TO_CART;?></strong></span>
				</button>
				<button class="btn_grey">
					<span><strong><?php echo TEXT_CART_ADD_MORE_ITEMS_CART;?></strong></span>
				</button>
			</p>
		</div>
	</div>
</div>
<div class="windowbody" style="display: none;"></div>