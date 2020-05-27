<div class="addlistcont"></div>
	<div class="addressbody">
       <p class="addressclosebtn"><strong><?php echo TABLE_HEADING_ADDRESS_DETAILS;?></strong><span id="closetips">X</span></p>
       <div class="clearBoth"></div>
       <form class="addresswindow" action="<?php echo zen_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'return=checkout_shipping' . $edit);?>" method="post">
       <input type="hidden" name="action" value="<?php echo ($update != '' ? $update : 'process');?>">
          <table>
              <tr><td width="160"><span>*</span><?php echo TEXT_TITLE;?>:</td><td><input checked="checked" type="radio" name="gender" value="m" style="float:none;" /><?php echo MALE;?> &nbsp;&nbsp;&nbsp;<input type="radio" value="f" name="gender" style="float:none;" /><?php echo FEMALE;?></td></tr>
              <tr><td><span>*</span><?php echo TEXT_NAME;?>:</td><td><input type="text" class="firstn" name="firstname" value="<?php echo $ad_firstname;?>"><input type="text" class="lastn" name="lastname" value="<?php echo $ad_lastname;?>">
            
              <dl>
              <dd>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>*</span><?php echo TEXT_FIRST_NAME;?> 
              <span class="error" id="errorfirst"></span></dd>
              <dt>
              <span class="last">*</span><?php echo TEXT_LAST_NAME;?>
              <span class="error" id="errorlast"></span></dt>
              </dl>
              </td></tr>
              <tr><td><span>&nbsp;&nbsp;&nbsp;</span><?php echo ENTRY_COMPANY;?></td><td><input type="text" name='company' value="<?php echo $ad_company;?>"></td></tr>
              <tr><td><span>*</span><?php echo TEXT_STREET_ADDRESS;?> 1:</td><td><input type="text" class="street needinput" name='street_address' value="<?php echo $ad_street;?>">
               <p>&bull;<?php echo TEXT_CHECKOUT_FILL_DETAIL;?></p>
               <div>&bull;<?php echo TEXT_CHECKOUT_SUGGEST_ENGLISH;?><ins></ins>
               <div class="tips">
                   <span class="bot"></span>
                   <span class="top"></span>
                   <?php echo TEXT_CHECKOUT_SUGGEST_ENGLISH_INFO;?>
               </div>
               </div>
               <span class="error" id="errorstreet"></span>
              </td></tr>
              <tr><td><span>&nbsp;&nbsp;&nbsp;</span><?php echo TEXT_STREET_ADDRESS;?> 2:</td><td><input type="text" name='suburb' value="<?php echo $ad_street1;?>">
              </td></tr>
              <tr><td><span>*</span><?php echo TEXT_CITY;?>:</td><td><input type="text" class="cityval needinput" name='city' value="<?php echo $ad_city;?>">
              <span class="error"></span>
              </td></tr>
              
              <tr>
              	<td><span>*</span><?php echo ENTRY_COUNTRY;?></td>
              	<td>
              		<input type="hidden" name="zone_country_id" value="<?php $ad_country_id = ($ad_country_id != '' ? $ad_country_id : 223); echo $ad_country_id;?>">
	              	<select id="selectcountry">
	              		<?php 
			                 $countries = zen_get_countries();
			                 $default_country = zen_get_countries(223);
			                 $ad_country_name = ($ad_country_name != '' ? $ad_country_name : $default_country['countries_name']);
			                 for ($i = 0; $i < sizeof($countries); $i++){
			                 	echo '<option ' . ($ad_country_name == $countries[$i]['countries_name'] ? 'selected' : '') . ' cid="' . $countries[$i]['countries_id'] . '">' . $countries[$i]['countries_name'] . '</option>';
			                 }
			                 ?>
	              	</select>
	                <span class="error" id="errorcountry"></span>
                </td>
              </tr>
              
              <tr>
              	<td><span>*</span><?php echo ENTRY_STATE_PROVINCE;?>:</td>
              	<td>
              		<input type="hidden" name="zone_id" value="<?php echo $ad_zone_id;?>">
              		<div class="state_content">              		
              		<?php 
              		if (isset($ad_country_id) && $ad_country_id != ''){
              			$zones = zen_get_country_zones ( $ad_country_id );
              		}
              		if (!zen_not_null($zones)){
              		?>
              		<input type="text" name="state" value="<?php echo $ad_state;?>">
              		<?php }else{ ?>
              		<select name="state" id="selectstate">
	              		<option zid="0"><?php echo PULL_DOWN_ALL;?></option>
	              		<?php 
		                   for($i = 0; $i < sizeof ( $zones ); $i ++) {
						   		echo '<option ' . ($ad_zone_id == $zones[$i]['id'] ? 'selected' : '') . ' zid="' . $zones[$i]['id'] . '">' . $zones[$i]['text'] . '</option>';
		                   }
		                ?>
	              	</select>
	              	<?php } ?>
	              	</div>
                   <p>&bull;<?php echo TEXT_CHECKOUT_BETTER_FULFILL;?></p>
                   <span class="error" id="errorprovince"></span>
                </td>
              </tr>
              
              <tr><td><span>*</span><?php echo TEXT_CHECKOUT_POSTAL_CODE;?>:</td><td><input type="text" class="postcode needinput" name='postcode' value="<?php echo $ad_postcode;?>">
              <span class="error"></span>
              </td></tr>
              <tr><td><span>*</span><?php echo TEXT_CHECKOUT_PHONE_NUMBER;?></td><td><input type="text" class="tellnum needinput" value="<?php echo $ad_telephone;?>" name='telephone'><p>&bull;<?php echo TEXT_CHECKOUT_PHONE_NUMBER_REQUIRED;?></p>
             <span class="error" id="errortell"></span>
              </td></tr>
              <tr><td></td><td><input type="submit" class="submitbtn"  id="addressbtn" value="Save"><input type="button" class="closebtn" value="Cancel"></td></tr>
          </table>       
       </form>
    </div>
<script>
$j(function(){
	$j(".needinput").focus(function(){
		$j(this).next('span.error').text('');    
	})

	$j(".tellnum").focus(function(){
		$j("#errortell").text('');
	})	
    $j(".street").focus(function(){
		$j("#errorstreet").text('');
	})
    $j(".firstn").focus(function(){
		$j("#errorfirst").text('');
	})
    $j(".lastn").focus(function(){
		$j("#errorlast").text('');
	})
	$j('input[name="state"]').live('click', function(){
		$j('#errorprovince').text('');
	})
	$j('.addresswindow table td div ins').mouseover(function(){ 
		$j(this).next('.tips').show();
	}) 
	$j('.addresswindow table td div ins').mouseout(function(){
		$j(this).next('.tips').hide();
	}) 		
})   
</script>