<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_shipping_calculator_default.php 3464 2006-04-19 00:07:26Z ajeh $
 */
?>

<script language="javascript" type="text/javascript">
function selectall(shipping_cost_calculator, v){
	for (var i = 0; i < document.shipping_cost_calculator.elements.length; i++){
		var e = document.shipping_cost_calculator.elements[i];
		if (e.type == "checkbox"){
			e.checked = v;
		}
	}
}
//eof jessa 2009-11-20
function fun(values){
	if(values==0){
		document.getElementById("days").value='asc';
	}else{
		document.getElementById("days").value='desc';
	}
	
	document.shipping_cost_calculator.submit();
}
function fun_price(values){
	if(values==0){
		document.getElementById("price").value='asc';
	}else{
		document.getElementById("price").value='desc';
	}
	
	document.shipping_cost_calculator.submit();
}
function check_form() {
	var passed = true;
	var err_msg = "";

	//check select
	var selected_country = document.getElementById("country").value;
	if(selected_country == ""){
		err_msg += "<?php echo TEXT_SHIPPING_ERROR_MESSAGE1;?>"+"\n";
		passed = false;
	}

	var input_weight = document.getElementById("net_weight").value;
	//alert(parseFloat(input_weight));
	if(input_weight == "" || parseFloat(input_weight) <= 0 || isNaN(input_weight)){
		err_msg += "<?php echo TEXT_SHIPPING_ERROR_MESSAGE2;?>"+"\n";
		passed =false;
	}
	
	<?php 
	$str = '';
	echo 'if(';	
	foreach ($show_method as $method => $val){
		$val['name'] = (isset($val['nameall']) ? $val['nameall'] : $val['name']);
		if(!strstr($str, 'document.getElementById("'.$val['name'].'").checked == false && ')){
			$str .= 'document.getElementById("'.$val['name'].'").checked == false && ';
		}		
	}
	$str = substr($str, 0, -4);
	echo $str;
	echo '){
		err_msg += "'.TEXT_SHIPPING_ERROR_MESSAGE3.'"+"\n";
		passed = false;
	}';
	?>
	
	if(passed == false){
		alert(err_msg);
		return false;
	} else 	{
		return true;
	}
}

</script>
<div class="centerColumn" id="aboutus">
<h1 id="aboutusHeading"><?php echo HEADING_TITLE; ?></h1>

<div class="content" align="center">
<?php echo zen_draw_form('shipping_cost_calculator', zen_href_link('shipping_calculator', 'action=calc', 'NONSSL'), 'post','onsubmit="return check_form(shipping_cost_calculator);" id="shipping_calculate"'); ?>
<fieldset>
<legend><?php echo TEXT_SHIPPING_INFORMATION;?></legend>

 <table align="center" border="0" width = '90%' >
 	<tr>
 	  <td width="30%" align="right" style="font-size:14px; font-weight:bold">
 	    <label class="inputLabel"><?php echo TEXT_SHIPPING_TO;?>:</label> 	  </td>
 	  <td colspan="2" align="left">
 	  <?php 
 	  	  $country_select_name='zone_country_id';
		  echo zen_get_country_select($country_select_name, $select_country_id,$priority_country);
		  ?>
		      <script>
		        	country_select_choose('<?php echo $country_select_name;?>','create_account');
		      </script>
	      <?php
 	  ?> 	  
 	  </td>
 	</tr>
 	<tr>
 	  <td align="right" style="font-size:14px; font-weight:bold">
 	    <label class="inputLabel"><?php echo TEXT_WEIGHT_WORDS;?></label> 	  </td>
 	  <td colspan="2" align="left">
 	  <?php echo zen_draw_input_field('net_weight', '', 'size="18" id="net_weight"')." <b>g  (".TEXT_GRAM.")</b>"; ?></td> 
 	</tr>
 	
 	<tr>
 	  <td align="right" style="font-size:14px; font-weight:bold">
 	    <label class="inputLabel"><?php echo TEXT_MASS_CONVERSION;?></label> 	  </td>
 	  <td colspan="2" align="left">
	 	   <p align="left" style="margin-top:10px;margin-bottom:10px;font-color:red" >
				          1 kg = 1000 <?php echo TEXT_GRAMS;?> <br />
				          1 <?php echo TEXT_GRAM;?> = 0.0020 <?php echo TEXT_POUND;?> <br />
				          1 <?php echo TEXT_GRAM;?> = 0.0353 <?php echo TEXT_OUNCE;?><br />
			   <a href = "http://www.lenntech.com/unit-conversion-calculator/mass-weight.htm" target="_blank"><?php echo TEXT_CLICK_FOR_WEIGHT_INFO;?></a>			</p> 	  </td>
 	</tr> 	
 	
 	<tr>
 	<td rowspan="<?php echo sizeof($show_method)+1;?>" align="right" style="font-size:14px; font-weight:bold" width="30%">
 	    <label class="inputLabel"><?php echo TEXT_SHIPPING_METHODS;?>:</label> 	  </td>
 	</tr>
 	
 	<?php 
 		foreach ($show_method as $method => $val){
 			if ($method == 'zyups' || $method == 'zyfedex' || $method == 'zydhl'){
 				echo '<tr></tr>';
 				continue;
 			}
 			$method = (isset($val['nameall']) ? $val['nameall'] : $val['name']);
 		?>
 	<tr>
 	  <td align="left"><?php if(!$day[$method]){echo zen_draw_checkbox_field($method, '1', true, 'id="'.$method.'"');}else{echo zen_draw_checkbox_field($method, '1', true, 'id="'.$method.'"');} ?><span style="font-size:13px ; font-weight:normal; valign:top"><?php echo $val['title'];?></span></td>
 	  <td align="left"><?php echo $val['days'].TEXT_DAYS?></td>
 	</tr> 		
 	<?php }?> 	
 	
 	<tr>
 	  <td align="right" style="font-size:14px; font-weight:bold">&nbsp;</td>
 	  <td align="left" ><input name="all" type="checkbox" id="all" checked="checked"  onclick="selectall(this.form, this.checked)" /><label for="all"><b><?php echo TEXT_SELECT_ALL;?></b></label></td>
 	  <td align="left">&nbsp;</td>
        </tr>
<!--eof jessa 2009-11-20-->
        <tr>
 	  <td align="right" style="font-size:14px; font-weight:bold">&nbsp;</td>
 	  <td align="left" ><?php echo zen_image_submit(BUTTON_IMAGE_SUBMIT, BUTTON_SUBMIT_ALT); ?></td>
 	  <td align="left">&nbsp;</td>
        </tr>
 </table>

<br class="clearBoth" />



</fieldset>
<div id="shipping_calulator_message">
<?php

if (isset($_GET['action']) && ($_GET['action'] == 'calc')) {
	
				
if($price['dhl']!="" && ($price['kddhl'] != "" || $price['zydhl'])){
					if($price['dhl']< $price['zydhl'] && $price['dhl'] < $price['kddhl']){
						unset($price['zydhl']);
						unset($message['zydhl']);
						unset($price['kddhl']);
						unset($message['kddhl']);
					}else{
						unset($price['dhl']);
						unset($message['dhl']);
					}
				}
				if($price['kddhl'] != "" && $price['zydhl'] != ""){
					if($price['kddhl'] > $price['zydhl']){
						unset($price['kddhl']);
						unset($message['kddhl']);
					}else{
						unset($price['zydhl']);
						unset($message['zydhl']);
					}
				}
				
				//print_r($price);echo "<br/>";
				if($price['zyups'] != "" && $price['kdups'] != ""){
					if($price['zyups'] > $price['kdups']){
						unset($price['zyups']);
						unset($message['zyups']);
					}else{
						unset($price['kdups']);
						unset($message['kdups']);
					}
				}
				
				if($price['kdfedex'] != "" && $price['zyfedex'] != ""){
					if($price['kdfedex']>$price['zyfedex']){
						unset($price['kdfedex']);
						unset($message['kdfedex']);
					}else{
						unset($price['zyfedex']);
						unset($message['zyfedex']);
					}
				}
//	print_r($price);
$days_id=0;
if($_POST['days']==null&&$_POST['price']==null){
	$_POST['days']='asc';
}


if($_POST['days']=='asc'){
	natsort($day);
	$id = 0;
	//print_r($day);
	foreach ($day as $key => $value){
			$arrat[$id] = $key;
			$id++;
	}
	//echo $message['dhl'];exit;
	for($i = 0, $n = sizeof($arrat); $i < $n; $i++){
		//echo $arrat[$i];echo "<br/>";
		$message_str.= $message[$arrat[$i]];
	}
	$days_id=1;
	$days_alt = 'days from slow to quick';
}elseif($_POST['days']=='desc'){
	natsort($day);
	$day = array_reverse($day,true);
	//print_r($day);
	$id = 0;
	foreach ($day as $key => $value){
			$arrat[$id] = $key;
			$id++;
	}
	
	for($i = 0, $n = sizeof($arrat); $i < $n; $i++){
		//echo $arrat[$i];echo "<br/>";
		$message_str.= $message[$arrat[$i]];
	}
	$days_id=0;
	$days_alt = 'days from quick to slow';
	
}else{
	$days_alt = 'days from quick to slow';
}

$price_id = 0;
$id = 0;
if($_POST['price']=='asc'){
	natsort($price);
	$id = 0;
//	print_r($price);
	foreach ($price as $key => $value){
			$arrat[$id] = $key;
			$id++;
	}
	//echo $message['dhl'];exit;
	for($i = 0, $n = sizeof($arrat); $i < $n; $i++){
		//echo $arrat[$i];echo "<br/>";
		$message_str.= $message[$arrat[$i]];
	}
	$price_id=1;
	$price_alt = 'price from high to low';
}elseif($_POST['price']=='desc'){
	natsort($price);
	$price = array_reverse($price,true);
//	print_r($price);
	foreach ($price as $key => $value){
			$arrat[$id] = $key;
			$id++;
	}

	for($i = 0, $n = sizeof($day); $i < $n; $i++){
		//echo $arrat[$i];echo "<br/>";
		$message_str.= $message[$arrat[$i]];
	}
	$price_id=0;
	$price_alt='price from low to high';
}else{
	$price_alt='price from low to high';
}

echo "<fieldset id='message'>
  	 				  <legend>Compare Result</legend>
  						<table align = 'center' border = '0' width = '100%' cellspacing='0' cellpadding='0' style='border:1px solid #CCCCCC'>
			  				<tr style = 'background: #bfbfbf; font-size:14px; font-weight:bold' align = center>
			  					<td width = '20%'>".TEXT_SHIPPING_METHOD."</td>
			  					<td width = '13%'><a href='javascript:void(0);' title='".$days_alt."' onclick='shipping_calculator_days($days_id);'><font color='#000'>".TEXT_DAYS."</font><img style='vertical-align: middle;padding-bottom:2px;' src='./images/logos/hui_asc.jpg'/></a><input type='hidden' id='days' name='days'></td>
			  					<td width = '10%'>".TEXT_PACKAGE_NUMBER."</td>
			  					<td width = '13%'>".TEXT_SERVER."</td>
			  					<td width = '18%'><a href='javascript:void(0);' title='".$price_alt."' onclick='shipping_calculator_price($price_id);'><font color='#000'>".TEXT_RESULT_COST."</font><img style='vertical-align: middle;padding-bottom:2px;' src='./images/logos/hui_asc.jpg'/></a><input type='hidden' id='price' name='price'></td>
			  				</tr>";
echo $message_str;

echo '</table></fieldset>
  	
  					<div style="text-align:right;margin-top:20px">
  					  <a target="_blank" href = "'.zen_href_link('contact_us').'" >[?Still have problem, Please contact US]</a>
  					</div>';
}
?>
</div>

</form>
</div>
</div>
<?php
if ($net_weight >= 35)

//jessa 2009-09-01 ���û��Ķ����������ڻ����35KGʱ�����û���ʾ�����޸ı�����checkout��һ����
{
	echo TEXT_WEIGHT_LARGE_INFO;
}
//eof jessa 2009-09-01
?>
