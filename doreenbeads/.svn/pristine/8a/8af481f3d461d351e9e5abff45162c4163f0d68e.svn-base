<?php
/**
 * Module Template
 *
 * Displays address-book details/selection
 *
 * @package templateSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_address_book_details.php 5924 2007-02-28 08:25:15Z drbyte $
 */
?>
			<table>
                 <tr>
                 	 <td width="150"><label>*</label><?php echo ENTRY_GENDER;?></td>
                 	 <td width="280">
                 	 <?php
					  /* 	if (ACCOUNT_GENDER == 'true') {
					    if (isset($gender)) {
					      $male = ($gender == 'm') ? false : true;
					    } else {
					      $male = ($entry->fields['entry_gender'] == 'm') ? true : false;
					    }
					    $female = !$male; */
					 ?>
					 <?php //echo  zen_draw_radio_field('gender', 'm', $male, 'id="gender-male" style="float:none;"').MALE; ?>
					 <?php //echo  zen_draw_radio_field('gender', 'f', $female, 'id="gender-female" style="float:none;"').FEMALE; ; ?>
					 <?php
						 //}
					 ?>
					<?php
				    if ($entry->fields['entry_gender'] == 'f') {
				      $genderSelect = 'f';
				    } else {
				      $genderSelect = 'm';
				    }
				    echo zen_draw_pull_down_menu('gender', array(array('id'=>'m', 'text'=>TEXT_MALE), array('id'=>'f', 'text'=>TEXT_FEMALE)), $genderSelect, '');
					?>
					  </td>
				 </tr>	  
                 <tr>
                 	 <td><label>*</label><?php echo TEXT_FIRST_NAME;?>:</td>
                 	 <td>
                 	 	 <?php echo zen_draw_input_field('firstname', $entry->fields['entry_firstname'], zen_set_field_length(TABLE_CUSTOMERS, 'customers_firstname', '') . ' id="firstname" class="firstname require" tips="your name requires a minimum of 2 characters"'); ?>
                     </td>
                     <td><span id="firstname"></span></td>
                 </tr>
                 <tr>
                 	 <td><label>*</label><?php echo TEXT_LAST_NAME;?>:</td>
                 	 <td>              	 	
			 			 <?php echo zen_draw_input_field('lastname', $entry->fields['entry_lastname'], zen_set_field_length(TABLE_CUSTOMERS, 'customers_lastname', '') . ' id="lastname" class="lastname require" tips="' . TEXT_NAME_REQUIRE_MINIMUM . '"'); ?>                       
                     </td>
                     <td><span id="lastname"></span></td>
                 </tr>
                
                 <tr>
	                 <td><label>*</label><?php echo ENTRY_SUBURB1; ?></td>
                     <td>
                 	 <?php echo zen_draw_input_field('street_address', $entry->fields['entry_street_address'], zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_street_address', '50') . ' id="street_address" style="height:36px;" class="street require"'); ?>
		                 <div class="outsidetips">•  <?php echo TEXT_CHECKOUT_FILL_DETAIL;?></div>
						<div  class="outsidetips">
							<span>•  <?php echo TEXT_CHECKOUT_SUGGEST_ENGLISH;?></span>
							<div class="div_address_tips">
								<ins></ins>
								<div class="tips"><span class="bot"></span>
									<span class="top"></span>
									<?php echo TEXT_CHECKOUT_SUGGEST_ENGLISH_INFO;?>
								</div>
							</div>
						</div>
	                 </td>
	                 <td><span id="street"></span></td>
                 </tr>
                 <tr>
	                 <td><label></label><?php echo ENTRY_SUBURB; ?></td>
                 <td>
                 	 <?php
					     if (ACCOUNT_SUBURB == 'true') {
					 ?>
					 <?php echo zen_draw_input_field('suburb', $entry->fields['entry_suburb'], zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_suburb', '50') . ' id="suburb" class="suburb" style="height:36px"'); ?>
					 <?php
					     }
					 ?>
	                 </td>
	                 <td><span id="sub"></span></td>
                 </tr>
                 <tr>
	                 <td><label>*</label><?php echo ENTRY_CITY; ?></td>
                 	 <td><?php echo zen_draw_input_field('city', $entry->fields['entry_city'], zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_city', '40') . ' id="city" class="city require"'); ?></td>
	                 <td><span id="scity"></span></td>
                 </tr>
                 <tr>
	                 <td><label>*</label><?php echo ENTRY_COUNTRY; ?></td>
	                 <td>
	                 	 <?php 
						      $country_select_name='zone_country_id';
						      echo zen_get_country_select($country_select_name, $select_country_id);
						      
						      if($address_num==0){
						      	?>
						      	 <script>
							      	country_select_choose('<?php echo $country_select_name;?>','address_book');
								  </script>
						      	<?php 
						      }
					     ?>
			
				 	    </td>
				 	    <td><span id="country"></span></td>
					</tr>
					<?php
				  		if (ACCOUNT_STATE == 'true') {
				    		if ($flag_show_pulldown_states == true) {
					?>
					<tr>
						<td><label>*</label><?php echo ENTRY_STATE; ?></td>
						<td>
						<?php 
							echo zen_draw_pull_down_menu('zone_id', zen_prepare_country_zones_pull_down($select_country_id), $zone_id, 'id="stateZone"'); 
							//echo zen_draw_hidden_field('state','');
						?>
						<input type="hidden" name="state" value="" id="state"/>
				 	    </td>
				 	    <td><span id="states"></span></td>
					</tr>			
					<?php
					    }else{
					?>
					<tr>
						<td><label>*</label><?php echo ENTRY_STATE; ?></td>
						<td>
							<?php
							echo zen_draw_input_field('state', zen_get_zone_name($entry->fields['entry_country_id'], $entry->fields['entry_zone_id'], $entry->fields['entry_state']), zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_state', '40') . ' id="state"'); 
							echo zen_draw_pull_down_menu('zone_id', zen_prepare_country_zones_pull_down(223), '', 'id="stateZone" class="hiddenField"');
			   		 		?>
						 </td>
						 <td><span id="states"></span></td>
					</tr>
			
					<?php
						    }
				 	 }
					?>			
	                 	 

                 <tr>
	                 <td><label>*</label><?php echo ENTRY_POST_CODE; ?></td>
	                 <td><?php echo zen_draw_input_field('postcode', $entry->fields['entry_postcode'], zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_postcode', '40') . ' id="postcode" class="require postal"'); ?></td>
	                 <td><span id="postCode"></span></td>
                 </tr>
                 <tr>
	                 <td><label>*</label><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
	                 <td>
	                 	 <?php echo zen_draw_input_field('telephone', $entry->fields['telephone_number'], zen_set_field_length(TABLE_ADDRESS_BOOK, 'telephone_number', '40') . ' id="telephone" class="require tel"'); ?>
		                 <p><?php echo TEXT_CHECKOUT_PHONE_NUMBER_REQUIRED;?></p>
	                 </td>
	                 <td><span id="telnumber"></span></td>
                 </tr>
                  <tr>
	                 <td><label></label><?php echo ENTRY_COMPANY; ?></td>
	                 <td>
	                 	 <?php
						     if (ACCOUNT_COMPANY == 'true') {
						 ?>
						 <?php echo zen_draw_input_field('company', $entry->fields['entry_company'], zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_company', '40') . ' id="company"'); ?>
						 <?php
						     }
						 ?>
	                 </td>
	             </tr>
                 <tr>
	                 <td><?php echo TEXT_CUSTOM_NO; ?></td>
	                 <td>
	                 	 <?php echo zen_draw_input_field('tariff_number', $entry->fields['tariff_number'], zen_set_field_length(TABLE_ADDRESS_BOOK, 'tariff_number', '40') . ' id="tariff_number" class="require tarnum"'); ?>
		                 <p><?php echo ENTRY_TARIFF_REQUIRED_TEXT;?></p>
	                 </td>
	                 <td><span id="tarnumber"></span></td>
                 </tr>
                 <tr>
	                 <td><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
	                 <td>
	                 	 <?php echo zen_draw_input_field('backup_email_address', $entry->fields['backup_email_address'], zen_set_field_length(TABLE_ADDRESS_BOOK, 'backup_email_address', '40') . ' id="backup_email_address" class="require backup"'); ?>
		                 <p><?php echo ENTRY_BACKUP_EMAIL_REQUESTED_TEXT;?></p>
	                 </td>
	                 <td><span id="backupemail"></span></td>
                 </tr>
                 <?php if (count($addressArray) > 0 ) {
					?>
					<!-- <tr>
						<td></td>
						<td id="checkprimary" class="checkprimary"><?php echo zen_draw_checkbox_field('primary', 'on', false, 'id="primary"') . ' <label class="checkboxLabels" for="primary"><span class="address_text">' . SET_AS_RECIPIENT_ADDRESS . '</span></label>'; ?></td>
									 	    <td><span></span></td>
					</tr> -->
				 <?php
				 }
				 ?>
                 <tr>
	                 <td><input type="hidden" value="process" name="action"></td>
	                 <td></td>
	                 <td></td>
                 </tr>
             </table>