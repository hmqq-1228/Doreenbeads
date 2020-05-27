<?php
require('includes/application_top.php');
$action = (isset($_POST['action']) ? $_POST['action'] : '');
$hrc_type = (isset($_POST['hrc_type']) ? $_POST['hrc_type'] : '');

if(zen_not_null($action) && zen_not_null($hrc_type)){
	switch ($action) {
		case 'update':
			$hrc_type = zen_db_prepare_input($_POST['hrc_type']);
			$hrc_value = zen_db_prepare_input($_POST['hrc_value']);

			$err = $hrc_type.'_error';
			$$err = '';

			if(chk_hrc_invalid($hrc_value, $$err, $hrc_type)){
				$chk_exitsts = $db->Execute("select count(*) as cnt from " . TABLE_HIGH_RISK_CUSTOMER . " where hrc_type='".$hrc_type."'");

				if($chk_exitsts->fields['cnt'] == 0){
					$db->Execute("insert into " . TABLE_HIGH_RISK_CUSTOMER . " (hrc_type, hrc_value) values ('".$hrc_type."', '".$hrc_value."')");
				}else{
					$db->Execute("update " . TABLE_HIGH_RISK_CUSTOMER . " set hrc_value='".$hrc_value."' where hrc_type='".$hrc_type."'");
				}
			}
			break;
	}
}
function chk_hrc_invalid(&$value, &$err, $type){
	$flag = true;

	$value = trim($value);
	if($value == '') return $flag;

	$split = $type=='address' ? "\r\n" : ',';
	$value_bak = $type=='address' || $type=='city' ? strtolower($value) : $value;
	$value_arr = explode($split, $value_bak);
	foreach($value_arr as $k=>$v)
		$value_arr[$k] = trim($v);
	$value_count = array_count_values($value_arr);
	foreach($value_count as $k=>$v){
		if($v > 1){
			$err .= $k.'重复;';
			$flag = false;
		}
		switch($type){
			case 'email':
				if(! filter_var($k, FILTER_VALIDATE_EMAIL)){
					$err .= $k.'格式错误;';
					$flag = false;
				}
				break;
			default:
				break;
		}
	}

	if($flag) $value = serialize($value_arr);
	return $flag;
}
//	get all
$hrc = $db->Execute("select * from " . TABLE_HIGH_RISK_CUSTOMER . "");
while(!$hrc->EOF){
	$field = $hrc->fields['hrc_type'].'_str';
	$split = $hrc->fields['hrc_type']=='address' ? "\r\n" : ',';
	$$field = implode($split, unserialize($hrc->fields['hrc_value']));
	$hrc->MoveNext();
}
?>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script type="text/javascript"><!--
	function init(){
		cssjsmenu('navbar');
		if (document.getElementById){
			var kill = document.getElementById('hoverJS');
			kill.disabled = true;
		}
	}
// --></script>
<style>
.simple_button{
	background: -moz-linear-gradient(center top , #FFFFFF, #CCCCCC) repeat scroll 0 0 #F2F2F2;
	border: 1px solid #656462;
	border-radius: 3px 3px 3px 3px;
	cursor: pointer;
	padding: 3px 20px;
	font-size:12px;
	margin-left:20px;
	margin-top:10px;
}
</style>
</head>

<body onload="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->

<table border="0" width="100%" cellspacing="2" cellpadding="2">
	<tr><td class="pageHeading"><br/>高危客户</td></tr>
	<tr>
		<td style="padding-left:20px;font-size:13px;">
			<a name="email"></a>
			<?php echo zen_draw_form('hrc_form1', 'high_risk_customer')?>
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="hrc_type" value="email" />
			<p><b>邮箱</b></p>
			<p style="color:#000000;">请在下方输入框中输入邮箱，邮箱之间用<span style="color:red">逗号(英文下的",")</span>隔开。</p>
			<textarea id="hrc_value" name="hrc_value" wrap="soft" style="height:120px;width: 500px;"><?php if(isset($email_str) && $email_str != '') echo $email_str; ?></textarea><br/>
			<?php if(isset($email_error) && $email_error != ''){?>
			<p style="font-variant:normal;color:red;"><?php echo $email_error; ?></p>
			<?php }?>
			<input class="simple_button" type="submit" value="提交"/>
			</form>
		</td>
	</tr>
	<tr>
		<td style="padding-left:20px;font-size:13px;">
			<a name="name"></a>
			<?php echo zen_draw_form('hrc_form1', 'high_risk_customer')?>
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="hrc_type" value="name" />
			<p><b>姓名</b></p>
			<p style="color:#000000;">请在下方输入框中输入姓名，姓名之间用<span style="color:red">逗号(英文下的",")</span>隔开。</p>
			<textarea id="hrc_value" name="hrc_value" wrap="soft" style="height:120px;width: 500px;"><?php if(isset($name_str) && $name_str != '') echo $name_str; ?></textarea><br/>
			<?php if(isset($name_error) && $name_error != ''){?>
			<p style="font-variant:normal;color:red;"><?php echo $name_error; ?></p>
			<?php }?>
			<input class="simple_button" type="submit" value="提交"/>
			</form>
		</td>
	</tr>
	<tr>
		<td style="padding-left:20px;font-size:13px;">
			<a name="city"></a>
			<?php echo zen_draw_form('hrc_form1', 'high_risk_customer')?>
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="hrc_type" value="city" />
			<p><b>城市</b></p>
			<p style="color:#000000;">请在下方输入框中输入城市名，城市名之间用<span style="color:red">逗号(英文下的",")</span>隔开。</p>
			<textarea id="hrc_value" name="hrc_value" wrap="soft" style="height:120px;width: 500px;"><?php if(isset($city_str) && $city_str != '') echo $city_str; ?></textarea><br/>
			<?php if(isset($city_error) && $city_error != ''){?>
			<p style="font-variant:normal;color:red;"><?php echo $city_error; ?></p>
			<?php }?>
			<input class="simple_button" type="submit" value="提交"/>
			</form>
		</td>
	</tr>
	<tr>
		<td style="padding-left:20px;font-size:13px;">
			<a name="postcode"></a>
			<?php echo zen_draw_form('hrc_form1', 'high_risk_customer')?>
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="hrc_type" value="postcode" />
			<p><b>邮编</b></p>
			<p style="color:#000000;">请在下方输入框中输入邮编，邮编之间用<span style="color:red">逗号(英文下的",")</span>隔开。</p>
			<textarea id="hrc_value" name="hrc_value" wrap="soft" style="height:120px;width: 500px;"><?php if(isset($postcode_str) && $postcode_str != '') echo $postcode_str; ?></textarea><br/>
			<?php if(isset($postcode_error) && $postcode_error != ''){?>
			<p style="font-variant:normal;color:red;"><?php echo $postcode_error; ?></p>
			<?php }?>
			<input class="simple_button" type="submit" value="提交"/>
			</form>
		</td>
	</tr>
	<tr>
		<td style="padding-left:20px;font-size:13px;">
			<a name="address"></a>
			<?php echo zen_draw_form('hrc_form1', 'high_risk_customer')?>
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="hrc_type" value="address" />
			<p><b>街道地址</b></p>
			<p style="color:#000000;">请在下方输入框中输入街道地址，每个地址之间<span style="color:red">换行</span>。</p>
			<textarea id="hrc_value" name="hrc_value" wrap="soft" style="height:120px;width: 70%;"><?php if(isset($address_str) && $address_str != '') echo $address_str; ?></textarea><br/>
			<?php if(isset($address_error) && $address_error != ''){?>
			<p style="font-variant:normal;color:red;"><?php echo $address_error; ?></p>
			<?php }?>
			<input class="simple_button" type="submit" value="提交"/>
			</form>
		</td>
	</tr>
	<tr>
		<td style="padding-left:20px;font-size:13px;">
			<a name="telephone"></a>
			<?php echo zen_draw_form('hrc_form1', 'high_risk_customer')?>
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="hrc_type" value="telephone" />
			<p><b>电话</b></p>
			<p style="color:#000000;">请在下方输入框中输入电话，电话之间用<span style="color:red">逗号(英文下的",")</span>隔开。</p>
			<textarea id="hrc_value" name="hrc_value" wrap="soft" style="height:120px;width: 500px;"><?php if(isset($telephone_str) && $telephone_str != '') echo $telephone_str; ?></textarea><br/>
			<?php if(isset($telephone_error) && $telephone_error != ''){?>
			<p style="font-variant:normal;color:red;"><?php echo $telephone_error; ?></p>
			<?php }?>
			<input class="simple_button" type="submit" value="提交"/>
			</form>
		</td>
	</tr>
</table>
<!-- body_eof //-->

<script type="text/javascript"><!--
	<?php if(zen_not_null($hrc_type)){
	echo "window.location.hash = '#".$hrc_type."';\n";
	}?>
// --></script>

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>