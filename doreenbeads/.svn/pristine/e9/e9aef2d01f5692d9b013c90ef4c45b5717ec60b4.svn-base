<?php

/**

 * @package admin

 * @copyright Copyright 2003-2006 Zen Cart Development Team

 * @copyright Portions Copyright 2003 osCommerce

 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0

 * @version $Id: customers.php 4280 2006-08-26 03:32:55Z drbyte $

 */



  require('includes/application_top.php');

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  $cID = zen_db_prepare_input($_GET['cID']);

  $error = false;

  $processed = false;


  if (zen_not_null($action)) {

    switch ($action) {
	  case 'insert':
		     $error_message = '';
			 $high_country= zen_db_prepare_input($_POST['high_country']);
			
			 $high_country_array = explode(',', $high_country);
			 while (list(, $value) = each($high_country_array)) {
				if($value != ''){
					$countries = $db->Execute("select c.countries_name from ".TABLE_COUNTRIES." c where c.countries_name = '".trim($value)."'");
					if($countries->RecordCount() == 0){
						$error_message = '注：您输入的国家名  "'.$value.'"  不存在';
						break;
					}
				}else{
					$error_message = '注：您输入的国家为空,或者仔细查看输入的内容逗号后面有没有国家';
				}
				
			 }

			 if($error_message == ''){
				  $high_country_array = explode(',', $high_country);
				 while (list(, $value) = each($high_country_array)) {
					  $countries = $db->Execute("select high_risk_country from ".TABLE_PAYMENT_HIGH_RISK_COUNTRY."  where high_risk_country = '".trim($value)."'");
					  if($countries->RecordCount() == 0){
						   $sql_data_array = array('high_risk_country' => $value);
						   zen_db_perform(TABLE_PAYMENT_HIGH_RISK_COUNTRY, $sql_data_array);
					  }else{
						   $error_message.= '注："'.$value.'"  已经在高危国家列表里,其他均已经添加成功！<br/>';
					  }
				 }
				 if($error_message == ''){
					 $messageStack->add_session('添加成功', 'success');
					 zen_redirect(zen_href_link('high_risk_country', 'NONSSL'));
				 }
				
			 }
    }

  }
   $high_risk_country = $db->Execute("select high_risk_country from ".TABLE_PAYMENT_HIGH_RISK_COUNTRY."  order by high_risk_country_id desc");
   $high_risk_country_str = '';
   while(!$high_risk_country->EOF){
	    $high_risk_country_str.= $high_risk_country->fields['high_risk_country'].', ';
	   	$high_risk_country->MoveNext();
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



<script language="javascript">



function check_form() {
  var high_country = document.high_country_form.high_country.value;
  if(high_country == ''){
	alert('国家不能为空');
	return false;
  }
  return true;

}
</script>


</head>

<body onLoad="init()">

<!-- header //-->

<?php require(DIR_WS_INCLUDES . 'header.php'); ?>

<table border="0" width="100%" cellspacing="2" cellpadding="2">

  <tr>

    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
		<table border="0" width="100%" cellspacing="0" cellpadding="0">

          <tr>

            <td class="pageHeading">
				<br/>
				<?php echo zen_draw_form('high_country_form', 'high_risk_country', zen_get_all_get_params(array('action')) .  'action=insert', 'post', 'onsubmit="return check_form()"', true)?>
				<?php echo '高危国家'; ?>
				<br/><br/>
				<p style="margin-left: 20px;color: #000000;font-size: 12px;">请在下方输入框中输入国家名，国家之前用逗号隔开。(英文下的逗号",")</p>
				<textarea  id="high_country" name="high_country" wrap="soft" style="margin-left: 20px;height: 100px;width: 300px;"><?php echo $high_country; ?></textarea><br/>
				<?php if($error_message != ''){?>
				<p style="font-variant: normal;margin-left: 20px;color:red;font-size: 13px;"><?php echo $error_message; ?></p>
				<?php }?>
				<br/>
				<input style="margin-left: 20px;height: 30px;width: 80px;" type="submit" value="提交"/>
				</form>

			</td>

           <td>
		   <br/>
		   <?php echo $high_risk_country_str; ?>
		   </td>
          </tr>

        </table>
	  </td>

    </tr>

 </table>
<!-- footer //-->

<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>

<!-- footer_eof //-->

</body>

</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>

