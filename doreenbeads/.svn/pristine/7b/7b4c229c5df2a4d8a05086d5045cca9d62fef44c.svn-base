<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
//  $Id: featured.php 4533 2006-09-17 17:21:10Z ajeh $
//

  require('includes/application_top.php');
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  if (zen_not_null($action)) {
  		switch($action){
  			case 'delete_product':
  				if(isset($_GET['clearance_id'])&&$_GET['clearance_id']!=''){
  					$delete_sql="delete from ".TABLE_CLEARANCE_SHOW_PRODUCTS." where clearance_id=".$_GET['clearance_id']." ";
  					$db->Execute($delete_sql);
  				}
  				break;
  				case 'set_status':
  				if(isset($_GET['status'])&&$_GET['status']!=''){
  					$upate_sql='update '.TABLE_CONFIGURATION.' set configuration_value="'.$_GET['status'].'" where configuration_key="DISPLAY_SHOW_CLEARANCE_CATEGORIES_STATUS" ';
  					$db->Execute($upate_sql);
  				}
  				//zen_redirect(zen_href_link(FILENAME_CLEARANCE_PRODUCTS));
  				break;
  		}
  		
  }
  $action = (isset($_POST['action']) ? $_POST['action'] : '');
  if (zen_not_null($action)) {
  	switch($action){
  		case 'set_clearance_cate':
  			if(isset($_POST['clearance_id'])&&$_POST['clearance_id']!=''){
  				$clearance_arr=explode(',', $_POST['clearance_id']);
  				$if_insert=true;
  				foreach($clearance_arr as $val){
  					if(is_numeric($val)){
  						$check_cate_sql="select categories_id from ".TABLE_CATEGORIES." where categories_id=".$val." ";
  						$check_cate=$db->Execute($check_cate_sql);
  						if($check_cate->RecordCount()==0){
  							$if_insert=false;
  							$messageStack->add_session('Category id '.$val .' does not exist', 'error');
  						}
  					}else{
  						$if_insert=false;
  						$messageStack->add_session($val .' is not a Number', 'error');
  					}
  				}
  				if($if_insert){
  				$upate_sql='update '.TABLE_CONFIGURATION.' set configuration_value="'.$_POST['clearance_id'].'" where configuration_key="CLEARANCE_CATEGORY_ID" ';	
  				$db->Execute($upate_sql);
  				$messageStack->add_session('Clearance Categoies have been updated successfully. ', 'success');
  				}
  				//$upate_sql='update '.TABLE_CONFIGURATION.' set configuration_value="'.$_POST['clearance_id'].'" where configuration_key="CLEARANCE_CATEGORY_ID" ';
  				//echo $upate_sql;
  				//$db->Execute($upate_sql);
  				zen_redirect(zen_href_link(FILENAME_CLEARANCE_PRODUCTS));
  			}
  			//zen_redirect(zen_href_link(FILENAME_CLEARANCE_PRODUCTS));
  			break;
  			case 'enter_clearance_pro':
  			if(isset($_POST['show_products_model'])&&$_POST['show_products_model']!=''){
  				$clearance_category_id=$_POST['sub_category'];
  				$model_pro=explode(",", $_POST['show_products_model']);
  				//$insert_success=true;
  				foreach($model_pro as $val){
  					$check_model_sql="select products_id from ".TABLE_PRODUCTS." where products_model='".$val."' and products_status=1 ";
  					$check_model=$db->Execute($check_model_sql);
  					if($check_model->RecordCount()==0){
  						//$insert_success=false;
  					    $messageStack->add_session('Product '.$val .' does not exist', 'error');
  					}else{
  					$select_sql="select clearance_id from ".TABLE_CLEARANCE_SHOW_PRODUCTS." where clearance_products_model='".$val."' and clearance_category_id=".$clearance_category_id." ";
  					$res=$db->Execute($select_sql);
  					if($res->RecordCount()>0){
  						//$insert_success=false;
  					    $messageStack->add_session('Product '.$val .' has been selected.', 'error');
  					}else{
  					$enter_sql="insert into ".TABLE_CLEARANCE_SHOW_PRODUCTS."(clearance_products_model,clearance_category_id,date_added) values ('".$val."',".$clearance_category_id.",now())";
  					$db->Execute($enter_sql);	
  					$messageStack->add_session('Products '.$val.' have been selected successfully. ', 'success');
  					}
  					}
  				}
  				
  			}
  			zen_redirect(zen_href_link(FILENAME_CLEARANCE_PRODUCTS));
  			break;
  			case'set_show_style':
  				if(isset($_POST['amount_products'])&&zen_not_null($_POST['amount_products'])){
  					if(is_numeric($_POST['amount_products'])){
  				$upate_sql='update '.TABLE_CONFIGURATION.' set configuration_value="'.$_POST['amount_products'].'" where configuration_key="MAX_DISPLAY_CLEARANCE_PRODUCTS" ';	
  				$db->Execute($upate_sql);
  				$messageStack->add_session('configuration have been updated successfully. ', 'success');	
  					}else{
  					$messageStack->add_session('Entered incorrectly. ', 'error');		
  					}
  				}elseif(isset($_POST['num_per_row'])&&zen_not_null($_POST['num_per_row'])){
  				if(is_numeric($_POST['num_per_row'])){
  				if(is_numeric($_POST['num_per_row'])){
  				$upate_sql='update '.TABLE_CONFIGURATION.' set configuration_value="'.$_POST['num_per_row'].'" where configuration_key="SHOW_PRODUCT_INFO_COLUMNS_CLEARANCE_PRODUCTS" ';	
  				$db->Execute($upate_sql);
  				$messageStack->add_session('configuration have been updated successfully. ', 'success');	
  					}	
  					}else{
  					$messageStack->add_session('Entered incorrectly. ', 'error');	
  					}
  				}
  				zen_redirect(zen_href_link(FILENAME_CLEARANCE_PRODUCTS));
  			break;
  	}
  }
  $clearance_category_string="(".zen_get_configuration_key_value('CLEARANCE_CATEGORY_ID').")";
  
  $clearance_category_info_query="select c.categories_id , categories_image ,categories_name from ".TABLE_CATEGORIES." c ,".TABLE_CATEGORIES_DESCRIPTION." cd where c.categories_id=cd.categories_id and cd.language_id=".$_SESSION['languages_id']." and c.categories_id in ".$clearance_category_string." ";
  
    $clearance_category_info=$db->Execute($clearance_category_info_query); 

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

<script type="text/javascript">
  <!--
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
  }
  // -->
</script>
<style>
#clearance_category{
	text-align:center;
	font-size:20px;
	line-height:40px;
}
.clearance_category_tb{
	width:90%;
	margin:auto;
	border-collapse:collapse;
}
.clearance_category_tb td{
	text-align:center;
	border:1px solid #333333;
	padding:3px;
}
.enter_clearance_cate{
	text-align:center;
	line-height:40px;
}
.clearance_cate_name{
	width:90%;
	margin:auto;
	font-size:14px;
	line-height:20px;
margin-top:10px;
}
.show_clearance_product{
	margin-right:15px;
	float-left:left;
}
.show_clearance_product a{
	color:red;
}
</style>
</head>
<body onload="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<div id="clearance_category">Clearance Categories:</div>
<table class="clearance_category_tb" >
<tr>
<?php 
if($clearance_category_info->RecordCount()>0){
	$td_width=100/($clearance_category_info->RecordCount()).'%';
	while(!$clearance_category_info->EOF){
		//print_r($clearance_category_info);
		?>
		<td width="<?php echo $td_width;?>">
		<br/>
		<?php echo zen_image('../'.DIR_WS_IMAGES.$clearance_category_info->fields['categories_image'],'',100,73 );?><br/>
		<div style="line-height:30px;"><?php echo $clearance_category_info->fields['categories_name']?> ( <?php echo $clearance_category_info->fields['categories_id'];?> )</div>
		</td>
		<?php  
		$clearance_category_info->MoveNext();
	}
}
?>
</tr>
</table>
<div class="enter_clearance_cate">
<form action="<?php echo $_SERVER['PHP_SELF']?>" method='post'>
Enter ids of Clearance Categories : <input type="hidden" name="action" value='set_clearance_cate'> 
<input type="text" name="clearance_id"> ( like: 690,171 ) <input type='submit' value="submit">
</form>
</div>
<div class="enter_clearance_cate">
<form action="<?php echo $_SERVER['PHP_SELF']?>" method='post'>
The Amount of products showed : <input type="hidden" name="action" value='set_show_style'> 
<input type="text" name="amount_products"> <input type='submit' value="submit"> (<?php echo MAX_DISPLAY_CLEARANCE_PRODUCTS;?>)
</form>
</div>
<div class="enter_clearance_cate">
<form action="<?php echo $_SERVER['PHP_SELF']?>" method='post'>
The Number of Products showed per row : <input type="hidden" name="action" value='set_show_style'> 
<input type="text" name="num_per_row"> <input type='submit' value="submit"> (<?php echo SHOW_PRODUCT_INFO_COLUMNS_CLEARANCE_PRODUCTS;?>)
</form>
</div>
<div class="enter_clearance_cate">
Set show clearance category status:
<?php echo (zen_get_configuration_key_value('DISPLAY_SHOW_CLEARANCE_CATEGORIES_STATUS')) ? '<a href="' . zen_href_link(FILENAME_CLEARANCE_PRODUCTS, 'action=set_status&status=0') . '">' . zen_image(DIR_WS_IMAGES . 'icon_green_on.gif') . '</a>' : '<a href="' . zen_href_link(FILENAME_CLEARANCE_PRODUCTS, 'action=set_status&status=1') . '">' . zen_image(DIR_WS_IMAGES . 'icon_red_on.gif') . '</a>'; ?>
</div>
<?php 
if($clearance_category_info->RecordCount()>0){
$clearance_category_info=$db->Execute($clearance_category_info_query);
while(!$clearance_category_info->EOF){
		?>
		<div class="clearance_cate_name"><?php echo $clearance_category_info->fields['categories_name'];?></div>
		<?php 
		$get_subcate_query="select c.categories_id  ,categories_name from ".TABLE_CATEGORIES." c ,".TABLE_CATEGORIES_DESCRIPTION." cd where c.categories_id=cd.categories_id and cd.language_id=".$_SESSION['languages_id']." and parent_id=".$clearance_category_info->fields['categories_id']." ";
		$get_subcate=$db->Execute($get_subcate_query);
		if($get_subcate->RecordCount()>0){
			?><table class="clearance_category_tb">
			<tr><td width="20%">Category</td><td>Products On Display</td><td width="20%">Enter product model on display<br/>(like:B12345,B12721)</td></tr>
			<?php 
		while(!$get_subcate->EOF){
			?><tr><td><?php echo $get_subcate->fields['categories_name'];?></td>
			<td>
			<?php 
			$get_show_products_query="select clearance_id,clearance_products_model,clearance_category_id from ".TABLE_CLEARANCE_SHOW_PRODUCTS." where clearance_category_id='".$get_subcate->fields['categories_id']."' ";
  $get_show_products=$db->Execute($get_show_products_query);
  //echo $get_show_products_query;
  if($get_show_products->RecordCount()>0){
  while(!$get_show_products->EOF){
  	?>
  	<span class="show_clearance_product"><?php echo $get_show_products->fields['clearance_products_model'];?> (<font  title="Delete"> <a href="<?php echo $_SERVER['PHP_SELF']?>?action=delete_product&clearance_id=<?php echo $get_show_products->fields['clearance_id'];?>">X</a> </font>)</span>
  	<?php 
  $get_show_products->MoveNext();
  }	
  }
			?>
			</td>
			<td width="20%">
			<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			<input type="hidden" name="action" value='enter_clearance_pro'>
			<input type="hidden" name="father_category" value="<?php echo $clearance_category_info->fields['categories_id'];?>">
			<input type="hidden" name="sub_category" value="<?php echo $get_subcate->fields['categories_id'];?>">
			<input type="text" name="show_products_model" value="" ><br/>
			<input type="submit" value="submit">
			</form>
			</td></tr><?php 
			$get_subcate->MoveNext();
		}?>
		</table>
		<?php 
		}
		?>
		<?php  
		$clearance_category_info->MoveNext();
	}
}
?>

<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
