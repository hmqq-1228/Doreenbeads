<?php 
require_once ('includes/application_top.php');

$sort_list = array(
	 array('id'=>'30','text'=>'Best Match'),
	 array('id'=>'6', 'text'=>'Date Added - New to Old'),
	 array('id'=>'7', 'text'=>'Date Added - Old to New'),
	 array('id'=>'3', 'text'=>'Price - low to high'),
	 array('id'=>'4', 'text'=>'Price - high to low'),
	 array('id'=>'5', 'text'=>'Part No.')		
);
$sort_display = array(
		'30' =>'Best Match',
		'6' => 'Date Added - New to Old',
		'7' => 'Date Added - Old to New',
		'3' => 'Price - low to high',
		'4' => 'Price - high to low',
		'5' => 'Part No.',
);
if($_GET['action'] == 'update'){
	global $db;
	$sort_new_arrival = zen_db_prepare_input($_POST['sort_new_arrival']);
	$sort_featured = zen_db_prepare_input($_POST['sort_featured']);
	$sort_clearance = zen_db_prepare_input($_POST['sort_clearance']);
	$sort_mixed = zen_db_prepare_input($_POST['sort_mixed']);
	$sort_best_seller = zen_db_prepare_input($_POST['sort_best_seller']);
	$sort_promotion = zen_db_prepare_input($_POST['sort_promotion']);
	$sort_common_list = zen_db_prepare_input($_POST['sort_common_list']);
	
	if($sort_new_arrival!=SORT_NEW_ARRIVAL && $sort_new_arrival>0){
		$db->Execute("update ".TABLE_CONFIGURATION." set configuration_value='".$sort_new_arrival."' where configuration_key='SORT_NEW_ARRIVAL'");
		$messageStack->add_session ( 'New Arrival默认排序更新为'.$sort_display[$sort_new_arrival], 'success' );
	}
	if($sort_featured!=SORT_FEATURED_PRODUCTS && $sort_featured>0){
		$db->Execute("update ".TABLE_CONFIGURATION." set configuration_value='".$sort_featured."' where configuration_key='SORT_FEATURED_PRODUCTS'");
		$messageStack->add_session ( 'Featured Products默认排序更新为'.$sort_display[$sort_featured], 'success' );
	}
	if($sort_clearance!=SORT_CLEARANCE && $sort_clearance>0){
		$db->Execute("update ".TABLE_CONFIGURATION." set configuration_value='".$sort_clearance."' where configuration_key='SORT_CLEARANCE'");
		$messageStack->add_session ( 'Stock & Clearance默认排序更新为'.$sort_display[$sort_clearance], 'success' );
	}

	if($sort_mixed!=SORT_MIXED_PRODUCTS && $sort_mixed>0){
		$db->Execute("update ".TABLE_CONFIGURATION." set configuration_value='".$sort_mixed."' where configuration_key='SORT_MIXED_PRODUCTS'");
		$messageStack->add_session ( 'Shop By Subject默认排序更新为'.$sort_display[$sort_mixed], 'success' );
	}
	if($sort_best_seller!=SORT_BEST_SELLER && $sort_best_seller>0){
		$db->Execute("update ".TABLE_CONFIGURATION." set configuration_value='".$sort_best_seller."' where configuration_key='SORT_BEST_SELLER'");
		$messageStack->add_session ( 'Best Seller默认排序更新为'.$sort_display[$sort_best_seller], 'success' );
	}
	if($sort_promotion!=SORT_PROMOTION && $sort_promotion>0){
		$db->Execute("update ".TABLE_CONFIGURATION." set configuration_value='".$sort_promotion."' where configuration_key='SORT_PROMOTION'");
		$messageStack->add_session ( '促销区默认排序更新为'.$sort_display[$sort_promotion], 'success' );
	}
	if($sort_common_list!=SORT_COMMON_LIST && $sort_common_list>0){
		$db->Execute("update ".TABLE_CONFIGURATION." set configuration_value='".$sort_common_list."' where configuration_key='SORT_COMMON_LIST'");
		$messageStack->add_session ( '正常商品列表默认排序更新为'.$sort_display[$sort_common_list], 'success' );
	}
		
	zen_redirect ( zen_href_link ( 'product_sort_order' ) );
}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">

<html <?php echo HTML_PARAMS; ?>>

<head>

<meta http-equiv="Content-Type"
	content="text/html; charset=<?php echo CHARSET; ?>">

<title><?php echo TITLE; ?></title>

<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">

<link rel="stylesheet" type="text/css"
	href="includes/cssjsmenuhover.css" media="all" id="hoverJS">

<script language="javascript" src="includes/menu.js"></script>

<script language="javascript" src="includes/general.js"></script>
<script language="javascript" src="includes/jquery.js"></script>
<script type="text/javascript">
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');

      kill.disabled = true;
    }    
  }
 
</script>
<style>
#product_sort {
	padding: 20px;
}

.sort_list{	
	font-size:14px;
	margin-left:20px;
}

.sort_list td{
	padding:10px;
}
.sort_list select{	
	font-size:13px;
	
}
.sort_values{
	text-align:center;
}
.sub_btn{
	background: -moz-linear-gradient(center top , #FFFFFF, #CCCCCC) repeat scroll 0 0 #F2F2F2;
    border: 1px solid #656462;
    border-radius: 3px;
    cursor: pointer;
    padding: 3px 20px;
	font-size:14px;
}
</style>
</head>
<body onLoad="init()">
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<div id="product_sort">
	<p class="pageHeading">列表默认排序原则</p>
	<form action="<?php echo zen_href_link('product_sort_order','action=update')?>" method="post" onsubmit="return confirm('是否确认提交？')">
	<table width="30%" class="sort_list">
		<tr>
		<th width="40%" height="60px">类别/专区</th>
		<th>默认排序原则</th>
		</tr>
		
		<tr>
		<td>New Arrivals</td>
		<td class="sort_values"><?php echo zen_draw_pull_down_menu('sort_new_arrival', $sort_list,SORT_NEW_ARRIVAL);?></td>
		</tr>
		
		<tr>
		<td>Featured Products</td>
		<td class="sort_values"><?php echo zen_draw_pull_down_menu('sort_featured', $sort_list,SORT_FEATURED_PRODUCTS);?></td>
		</tr>
		
		<tr>
		<td>Stock &amp; Clearance</td>
		<td class="sort_values"><?php echo zen_draw_pull_down_menu('sort_clearance', $sort_list,SORT_CLEARANCE);?></td>
		</tr>
		
		
		<tr>
		<td>Mixed Products</td>
		<td class="sort_values"><?php echo zen_draw_pull_down_menu('sort_mixed', $sort_list,SORT_MIXED_PRODUCTS);?></td>
		</tr>
		
		<tr>
		<td>Best Seller</td>
		<td class="sort_values"><?php echo zen_draw_pull_down_menu('sort_best_seller', $sort_list,SORT_BEST_SELLER);?></td>
		</tr>
		
		<tr>
		<td>促销区</td>
		<td class="sort_values"><?php echo zen_draw_pull_down_menu('sort_promotion', $sort_list,SORT_PROMOTION);?></td>
		</tr>
		
		<tr>
		<td>正常商品列表</td>
		<td class="sort_values"><?php echo zen_draw_pull_down_menu('sort_common_list', $sort_list,SORT_COMMON_LIST);?></td>
		</tr>
		
		<tr>
		<td></td>
		<td ><input class="sub_btn" type='submit' name='update_sort' value='提交'></td>
		</tr>
	
	</table>
	</form>
</div>

<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>