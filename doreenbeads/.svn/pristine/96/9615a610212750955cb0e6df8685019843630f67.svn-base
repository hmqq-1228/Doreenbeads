<?php
/**
 * 新增文件find_new_proudcts_without_catg.php
 * jessa 2010-04-04
 */
	 require('includes/application_top.php');
	 $all_products_query = "Select p.products_date_added, pd.products_name_without_catg
	 						  From " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd 
	 						 Where p.products_id = pd.products_id
	 						   
	 					  Order By pd.products_name_without_catg, p.products_date_added Desc";
	 $all_products = $db->Execute($all_products_query);
	 $all_products_nums = $all_products->RecordCount();
	 $count = 0;
	 $i = 0;
	 $without_catg_array = array();
	 while($i < $all_products_nums){
	 	if ($i == 0){
		 	$without_catg_array[$count] = array('date' => $all_products->fields['products_date_added'],
		 										'name' => $all_products->fields['products_name_without_catg']);
		 	$count++;
	 	}else{
	 		if ($without_catg_name != $all_products->fields['products_name_without_catg']){
	 			$without_catg_array[$count] = array('date' => $all_products->fields['products_date_added'],
	 												'name' => $all_products->fields['products_name_without_catg']);
	 			$count++;
	 		}
	 	}
	 	$i++;
	 	$without_catg_name = $all_products->fields['products_name_without_catg'];
	 	$all_products->MoveNext();
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
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onLoad="init()">
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>

<?php
	$db->Execute("Delete From t_prod_catg");
	for ($j = 0; $j < sizeof($without_catg_array); $j++){
		$db->Execute("Insert into t_prod_catg (pcg_id, pcg_name, pcg_create_date)
					  Values ('', '" . addslashes($without_catg_array[$j]['name']) . "', '" . $without_catg_array[$j]['date'] . "')");
	}
//	$result_query = $db->Execute("Select p.products_id, p.products_model, p.products_image, p.products_weight,
//										 p.products_price, pd.products_name
//									From t_products p, t_products_description pd, t_prod_catg
//								   Where p.products_id = pd.products_id
//								     And pcg_name = pd.products_name_without_catg
//								Order By pcg_create_date Desc, p.products_date_added Desc");
//	while(!$result_query->EOF){
//		echo $result_query->fields['products_model'] . "---" . $result_query->fields['products_name'] . '<br>';
//		$result_query->MoveNext();
//	}
?>

<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>