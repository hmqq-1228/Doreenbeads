<script> window.lang_wdate='<?php echo $_SESSION['languages_code'];?>'; </script>
<script type="text/javascript" src="<?php echo HTTP_SERVER;?>/includes/templates/cherry_zen/jscript/My97DatePicker/WdatePicker.js"></script>

<div class="mainwrap" style="margin-top: 0px;">

 <div class="fleft" style="width:766px;">
     <p class="packtit"><strong><?php echo TEXT_PACKING_SLIP;?></strong><!-- <a class="quickadd_btn" href="javascript:void(0)"> --><?php /* echo PRODUCTS_NO_ALT; */?> <!-- >></a> --></p>
     <div class="packtip">
     	<ul>
     		<li><span><?php echo TEXT_PACKAGE_SLIP_TIP_1;?></span></li>
     		<li><span><?php echo TEXT_PACKAGE_SLIP_TIP_2;?></span></li>
     	</ul>
     </div>
     <div class="clear"></div>
     <div class="filterform">
       <?php echo zen_draw_form('filter_form', zen_href_link(FILENAME_PACKING_SLIP, '', 'SSL') , 'get' )?>
       <?php  echo zen_draw_hidden_field('main_page', $_GET['main_page']);?>
       <?php echo zen_draw_hidden_field('action' , 'pack_filter')?>
           <dl>
             <dd>
               <p><label><?php echo TABLE_HEADING_ORDER_NUMBER;?>:</label><input name="ordernumber"  value="<?php echo $_GET['ordernumber'] ? $_GET['ordernumber'] : '';?>"  type="text"/></p>
                <p><label><?php echo TABLE_HEADING_TACKING_NUMBER;?>:</label><input name="trackingnumber"  value="<?php echo  $_GET['trackingnumber'] ? $_GET['trackingnumber'] : '';?>"  type="text"/></p>
             </dd>
             <dt>
               <p><label><?php echo TEXT_MODEL;?>:</label><input name="pronumber" value="<?php echo $_GET['pronumber'] ? $_GET['pronumber']: ''?>" type="text"/></p>
               <p><label><?php echo TABLE_HEADING_DATE;?>:</label>
			   <input class="Wdate" style="width:82px;" value="<?php echo $filter_date_start ? $filter_date_start : ''?>" type="text" name="datestart" onclick="WdatePicker({lang:'<?php echo $_SESSION['languages_code'];?>',minDate:'2017-05-03'});" > <?php echo TEXT_TO;?> 
			   <input class="Wdate" style="width:82px;" value="<?php echo $filter_date_end ? $filter_date_end : ''?>" type="text" name="dateend" onclick="WdatePicker({lang:'<?php echo $_SESSION['languages_code'];?>',minDate:'2017-05-03'});" >
			   </p> 
             </dt>
           </dl>
           <div class="clearBoth"></div>
           <p class="filterbtn"><button class="btn_yellow"><span><strong><?php echo TEXT_SUBMIT;?></strong></span></button></p>
        <?php echo '</form>';?> 
     </div>
     
     <div class="packdetail">
	 <div style="float:left;" >
	 <?php echo $packing_slip_split->display_count(TEXT_DISPLAY_NUMBER_OF_ORDERS);?>
	 </div>
	 <div style="float:right;" class="propagelist">
	 <?php echo TEXT_RESULT_PAGE . ' ' . $packing_slip_split->display_links(MAX_DISPLAY_PAGE_LINKS, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')));;?>
	 </div>
		 <div class="clear"></div>
	      <table>
	        <tr>
	          <th width="170"><?php echo HEADING_ITEM;?></th>
	          <th width="160"><?php echo TEXT_BOUNGHT_QUANTITY;?></th>
	          <th width="160"><?php echo TEXT_SENT_QUANTITY;?></th>
	          <th width="160"><?php echo TEXT_UNSENT_QUANTITY;?></th>
	          <th width="150" ><?php echo TEXT_ORDER_PRODUCTS_PHOTCONT_ORDER_NUMBER;?></th>
	          <th width="150" ><?php echo TABLE_HEADING_TACKING_NUMBER;?></th>
	        </tr>
	        <?php if(sizeof($package_info_array) != 0){?>
	        <?php
	        	foreach ($package_info_array as $package){
	        		echo '<tr>';
	        		echo '<td><div><div><a href="' . $package['products_link'] . '"><img src="'.HTTPS_IMG_SERVER . 'bmz_cache/' . get_img_size ( $package['products_images'], 80, 80 ).'" alt="" width="50" height="50"/></a></div><div><a href="' . zen_href_link(FILENAME_PACKING_SLIP , 'action=pack_filter&pronumber=' . $package['products_model']) . '">' . $package['products_model'] . '</a></div></div></td>';
	        		echo '<td>' . $package['total_quantity'] . '</td>';
	        		echo '<td>' . $package['sent_quantity'] . '</td>';
	        		echo '<td>' . $package['unsent_quantity'] . '</td>';
	        		echo '<td><span><a href="' . zen_href_link(FILENAME_PACKING_SLIP , 'action=pack_filter&ordernumber=' . $package['orders_id']) . '">' . $package['orders_id'] . '</a></span><br><span>' . date('M , d , Y' , strtotime($package['date_purchased'])) . '</span></td>';
	        		if($package['trance_number'] == '/'){
	        			echo '<td><span>/</span></td>';
	        		}else{
	        			echo '<td>';
	        			foreach ($package['trance_number'] as $transaction){
	        				echo '<span><a href="' . zen_href_link(FILENAME_PACKING_SLIP , 'action=pack_filter&trackingnumber=' . $transaction) . '">' . $transaction . '</a></span><br>';
	        			}
	        			echo '</td>';
	        		}
	        		echo '</tr>';
	        	}
	        ?>
		<?php }
		echo '</table>';
		if(sizeof($package_info_array) == 0){
			echo '<div class="packtip_null"><span>' . TEXT_NO_RESULT_PACKING_SLIP . '</span></div>';
		}
		?>
		<div style="float:right;padding-top:10px"><b><?php echo TEXT_DOWNLOAD_PACKINGLIST_INFO;?></b></div>
     </div>
 </div>
</div>
<div id="quick_add_content">
	<div class="smallwindow quickfind" style="display: none;">
		<div class="smallwindowtit">
			<strong><?php echo TEXT_CART_QUICK_ADD_NOW;?></strong><span></span>
		</div>
		<div class="quickaddcont">
			<p class="quicktext"><?php echo TEXT_CART_QUICK_ADD_NOW_TITLE;?></p>
			<form action="index.php?main_page=shopping_cart&page=1" method="post" name="quick_add">
				<input type="hidden" name="action" value="addselect">
				<table class="quickadd" width="100%">
					<tr>
						<th><?php echo TEXT_CART_P_NUMBER;?></th>
						<th><?php echo TEXT_CART_P_QTY;?></th>
					</tr>
					<tr>
						<td style="padding-top: 15px;"><input type="text" name="product_model[]" /></td>
						<td style="padding-top: 15px;"><input type="text" name="product_qty[]" maxlength="5" onpaste="return false" /></td>
					</tr>
					<?php for($i = 1; $i < 9; $i++){?>
					<tr>
						<td><input type="text" name="product_model[]" /></td>
						<td><input type="text" name="product_qty[]" maxlength="5" onpaste="return false" /></td>
					</tr>
					<?php }?>		
				</table>
			</form>
			<p class="doublebutton">
				<button class="btn_yellow">
					<span><strong><?php ADD_TO_CART;?></strong></span>
				</button>
				<button class="btn_grey">
					<span><strong><?php echo TEXT_CART_ADD_MORE_ITEMS_CART;?></strong></span>
				</button>
			</p>
		</div>
	</div>
</div>
<div class="windowbody" style="display: none;"></div>
