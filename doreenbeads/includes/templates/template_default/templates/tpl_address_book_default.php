<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=adress_book.<br />
 * Allows customer to manage entries in their address book
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_address_book_default.php 5369 2006-12-23 10:55:52Z drbyte $
 */
?>
	<?php if ($messageStack->size('addressbook_default') > 0) echo $messageStack->output('addressbook_default'); ?> 

	<div class="mycashaccount" style="width:765px;">
        <p class="ordertit"><strong><?php echo TEXT_ADDRESS_BOOK;?></strong><span class="updateshow"><?php echo SUCCESS_ADDRESS_BOOK_ENTRY_UPDATED;?></span></p>
        <p class="adddressbooktit"><strong><?php echo TEXT_DEFAULT_SHIPPING_ADDRESS;?></strong>
        	<span class="requiredfiled"><label>*</label>Indicates required fields</span>
        </p>  
        <div id="add_new_address" <?php if(count($addressArray) >0){ echo 'style="display:none"';}?>> 
            <?php $divName = "'"."#add_new_address"."'"?>   
        	<?php if (!isset($_GET['delete'])) echo zen_draw_form(FILENAME_ADDRESS_BOOK, zen_href_link(FILENAME_ADDRESS_BOOK, (isset($_GET['edit']) ? 'edit=' . $_GET['edit'] : ''), 'SSL'), 'post', 'class="addresseidtform"'); ?>
			<?php require($template->get_template_dir('tpl_modules_address_book_details.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_address_book_details.php'); ?> 
            <?php if (isset($_GET['edit']) && is_numeric($_GET['edit'])) echo zen_draw_hidden_field('action', 'update') . zen_draw_hidden_field('edit', $_GET['edit']) ;?>
            <?php if (!isset($_GET['delete'])) echo '</form>'; ?>
            <div class="clearfix"></div>
            <p  class="filterbtn"><button class="addresssubmit"  onclick="save_address_book('#add_new_address',0);" ><?php echo TEXT_SAVE;?></button>
            <button class="btncancel" <?php if(count($addressArray) == 0){ echo 'style="display:none"';}?>onclick="cancel_edit('#defalut_addressbook',<?php echo count($addressArray)?>)"><?php echo TEXT_CANCEL;?></button>
            </p>     	
        </div>
        <div class="clearfix"></div>
        <?php 
				if (count($addressArray) > 0){
		 ?>
	      <div id="defalut_addressbook">
	          <ul class="account_addresslist">
	          	  <?php 
	          	 	  if ($_SESSION['customer_default_address_id'] != '') { 						
	          	 		  $address =  zen_address_label1($_SESSION['customer_id'], $_SESSION['customer_default_address_id'], true, ' ', '<br />');
	          	 		  foreach ($address as $key => $value) { ?>
	          	 		  	<li><?php echo $value;?></li>
	          	 		<?php  }
	          	 		  /*if(count($address) == 6){
							  ?>
							  	  <li><strong><?php echo $address[0];?></strong></li>
							  	  <li><?php echo $address[1];?></li>
							  	  <li><p><?php echo $address[2];?></p></li>
							  	  <li><?php echo $address[3];?></li>
							  	  <li><?php echo $address[4];?></li>
							  	  <li><ins></ins><?php echo $address[5];?></strong></li>
							  <?php 
						  }else if(count($address) == 5){
							  ?>
							  	  <li><strong><?php echo $address[0];?></strong></li>
							  	  <li><?php echo $address[1];?></li>
							  	  <li><?php echo $address[2];?></li>
							  	  <li><?php echo $address[3];?></li>
							  	  <li><ins></ins><?php echo $address[4];?></strong></li>
							  <?php 							 
                          }*/
                          ?><li><p class="filterbtn "><button class="defaultedit" onclick="edit_address_book(<?php echo $_SESSION['customer_default_address_id']?>,'#defalut_addressbook');"><?php echo TEXT_EDIT;?></button></p></li><?php
	          	 	   }
	          	  ?>
				  
			   </ul>
			   <div class="clearfix"></div>
		  </div>	 
		  <p class="adddressbooktit titborder"><strong><?php echo SHIPPING_ADDRESS_TITLE; ?>
			  <ins>(<?php echo sprintf(TEXT_MAXIMUM_ENTRIES, MAX_ADDRESS_BOOK_ENTRIES); ?>)</ins></strong>
			  <span class="addbutton" <?php if(count($addressArray) >= MAX_ADDRESS_BOOK_ENTRIES){ echo 'style="display:none"';}?> onclick = "edit_address_book(0,'.addbutton')"><ins></ins><?php echo TEXT_ADD_NEW_ADDRESS;?></span>
			  <span class="requiredfiled neccesary"><label>*</label><?php echo TEXT_REQUIRED_FIELDS;?></span>
		  </p>
		  <div id="edit_address_book" style="display:none;">
		  	   <?php $divName = "'"."#edit_address_book"."'"?>
		  	   <?php if (!isset($_GET['delete'])) echo zen_draw_form(FILENAME_ADDRESS_BOOK, zen_href_link(FILENAME_ADDRESS_BOOK, (isset($_GET['edit']) ? 'edit=' . $_GET['edit'] : ''), 'SSL'), 'post', 'class="addresseidtform"'); ?>
			   <?php require($template->get_template_dir('tpl_modules_address_book_details.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_address_book_details.php'); ?> 
               <?php if (isset($_GET['edit']) && is_numeric($_GET['edit'])) echo zen_draw_hidden_field('action', 'update') . zen_draw_hidden_field('edit', $_GET['edit']) ;?>
               <span id="error_same_address"></span>
               <?php if (!isset($_GET['delete'])) echo '</form>'; ?>

               <div class="clearfix"></div>
               <p class="filterbtn"><button class="addresssubmit" onclick="save_address_book('#edit_address_book','')"><?php echo TEXT_SAVE;?></button><button class="btncancel" onclick="cancel_edit('#addressbooklist',<?php echo count($addressArray)?>)"><?php echo TEXT_CANCEL;?></button></p>          
		  </div>
		  <div id="addressbooklist">   
		  <div class="clearfix"></div>        
          <?php
			  $i=1;
			  foreach ($addressArray as $addresses) {
				  $address = zen_address_format1($addresses['format_id'], $addresses['address'], true, ' ', '<br />');
				  //echo count($address);
				  if ($i % 3== 0 || $i==count($addressArray)) {
				      echo "<ul class='account_addresslist bordernone'>";
				  } else {
					  echo "<ul class='account_addresslist'>";
				  }
				  //if(count($address) == 6){
				  	foreach ($address as $key => $value) { ?>
					  	<li><?php echo $value;?></li>
					  	  <!-- <li><strong><?php echo $address[0];?></strong></li>
					  	  <li><?php echo $address[1];?></li>
					  	  <li><p><?php echo $address[2];?></p></li>
					  	  <li><?php echo $address[3];?></li>
					  	  <li><?php echo $address[4];?></li>
					  	  <li><ins></ins><?php echo $address[5];?></strong></li> -->
					  <?php 
				  //}else if(count($address) == 5){
					 /* ?>
					  	  <li><strong><?php echo $address[0];?></strong></li>
					  	  <li><?php echo $address[1];?></li>
					  	  <li><?php echo $address[2];?></li>
					  	  <li><?php echo $address[3];?></li>
					  	  <li><ins></ins><?php echo $address[4];?></strong></li>
					  <?php 							 */
                  //}
				 } ?>
				    <?php if($_SESSION['customer_default_address_id'] != $addresses['address_book_id'] ) {?>
				  	<li style="color:#26C942;cursor:pointer;" onclick="set_default_address(<?php echo $addresses['address_book_id']?>)"><?php echo SET_AS_DEFAULT_ADDRESS ?></li>
				  	<?php }else{ ?>
					<li>&nbsp;</li>
				  	<?php } ?>
				  	  <li>
				  	  	<p class="filterbtn "><button class="defaultedit" onclick = "edit_address_book(<?php echo $addresses['address_book_id']?>,'#addressbooklist')"><?php echo TEXT_EDIT;?></button>
				  	  	<button class="btncancel" <?php if(count($addressArray) ==1 ){ echo 'style="display:none"';} ?> onclick="<?php if($addresses['address']['address_book_id'] == $_SESSION['customer_default_address_id']) { echo "confirm('The primary address cannot be deleted. Please set another address as the primary address and try again.')";} else { echo "delete_address_book('delete_address',". $addresses['address_book_id'].")";}?> "><?php echo TEXT_DELETE;?></button>
				  	  	</p>
				  	  </li>
				  </ul>
				  <?php 
				  $i++;
			    }
			?>
			</div>	
       <?php 
	    }
       ?>
      <div class="clearfix"></div>
    </div>
