<script language="javascript" type="text/javascript">
<!--
function check_form_ship() {
	var passed = true;
	var err_msg = "";
	
	//check select
	var selected_country = document.getElementById("country").value;
	if(selected_country == ""){
		err_msg += "<?php echo TEXT_ERROR_SELECT_COUNTRY; ?>";
		passed = false;
	}
	
	var input_weight = document.getElementById("net_weight").value;
	if(input_weight == "" || parseFloat(input_weight) <= 0 || isNaN(input_weight)){
		err_msg += "<?php echo TEXT_ERROR_POSITIVE_WEIGHT;?>";
		passed =false;
	}
		
	if(passed == false){
		alert(err_msg);
		return false;
	} else {
		return true;
	}
}
$j(function(){
	$j(".shipcalcultor_tab .ship_calculator").click(function(){
		if(!check_form_ship()) return false;
		else{
			var country = $j(".shipcalcultor_tab #country").val();
			var weight = $j(".shipcalcultor_tab #net_weight").val();
			var city = $j(".shipcalcultor_tab #city").val();
			var zip = $j(".shipcalcultor_tab #zip").val();
			$j.post('./ajax_login.php', {action:'shipping_calculator', country:country, weight:weight, city:city, zip:zip}, function(data){
				$j('.table_shipping_info').hide();
				$j("#sh_cal_result").html(data);
			});
			return false;
		}
	})
})
-->
</script>
<?php if($_GET['main_page'] == 'shipping_calculator'){ ?>
<div class="centerColumn" id="aboutus">
<h1 id="aboutusHeading"><?php echo HEADING_TITLE; ?></h1>
<?php } ?>
<!--  
<div class="shipping_calculate_info" style="background:#fefde7;border:1px solid #b0b0b0;padding:2px 10px;color:#808080;margin-top:20px;">
	<?php //echo TEXT_SHIPPING_CALCULATE_TIPS;?>
</div>
-->
<form name="shipping_cost_calculator" action="#" method="post">
	<table class="shipcalcultor_tab">
		<tr>
			<td><label><?php echo TEXT_WORD_SHIPPING_WEIGHT;?>:</label><input type="text" name="net_weight" id="net_weight" value="<?php if(zen_not_null($_SESSION['net_weight'])) echo $_SESSION['net_weight'];?>" /><strong><?php echo TEXT_UNIT_GRAM;?></strong></td>
			<td>
				<label class="shipping_cal_country_title"><?php echo ENTRY_COUNTRY;?></label>
				<div class="shipping_cal_country">
				<?php 
					if (zen_not_null($_SESSION['country'])) {
						$country_id = $_SESSION['country'];
					} else {
						switch ($_SESSION ['languages_id']) {
							case 1 :
								$country_id = 223;
								break;
							case 2 :
								$country_id = 81;
								break;
							case 3 :
								$country_id = 176;
								break;
							case 4 :	
								$country_id = 73;
								break;
							default :
								$country_id = 223;
						}
					}
					if(zen_not_null($_SESSION['country_id'])){
						echo zen_get_country_select('country', $country_id, $_SESSION['languages_id']);
					} else {
						echo zen_get_country_select('country', $country_id, $_SESSION['languages_id']);
					}
				?>
				</div>
			</td>
		</tr>
		<tr>
			<td><label><?php echo TEXT_CITY_TOWN;?>:</label><input type="text" name="city" id="city" value="<?php if(zen_not_null($_SESSION['city'])) echo $_SESSION['city'];?>" /></td>
			<td><label><?php echo ENTRY_POST_CODE;?></label><input type="text" name="zip" id="zip" value="<?php if(zen_not_null($_SESSION['zip'])) echo $_SESSION['zip'];?>" /></td>
		</tr>
		<tr>
			<td><label></label><input type="submit" value="<?php echo TEXT_CALCULATE;?>" class="commonbtn ship_calculator"/></td>
		</tr>
	</table>
</form>
	  
<table class="massconver">
	<tr>
		<td rowspan="4"><strong><?php echo TEXT_MASS_CONVERSION;?></strong></td>
		<td><p>1 <?php echo TEXT_UNIT_KG;?> = 1000 <?php echo TEXT_UNIT_GRAM;?></p><p>1 <?php echo TEXT_UNIT_GRAM;?> = 0.00220 <?php echo TEXT_UNIT_POUND;?></p><p>1 <?php echo TEXT_UNIT_GRAM;?> = 0.0353 <?php echo TEXT_UNIT_OUNCE;?></p><p><a href="http://www.lenntech.com/unit-conversion-calculator/mass-weight.htm" target="_blank"><?php echo TEXT_CLICK_FOR_DETAIL;?></a></p></td>
	</tr>
</table>
	  
<table class="shipping_time table_shipping_info">
	<tr><th width="50%"><?php echo TEXT_SHIPPING_METHODS;?></th><th width="50%"><?php echo TEXT_EST_SHIPPING_TIME;?></th></tr>
<?php foreach ($show_method as $method => $val){ ?>
	<?php $time_unit = TEXT_DAYS_LAN;if ($val['time_unit'] == 20) {	$time_unit = TEXT_WORKDAYS;} ?>
	<tr><td><?php echo $val['title'];?></td><td><?php echo $val['days'] . ' ' . $time_unit;?></td></tr>
<?php }?>
</table>
	 
<table class="shipping_time" id="sh_cal_result"></table>

<?php if($_GET['main_page'] == 'shipping_calculator'){ ?>
</div>
<?php } ?>
