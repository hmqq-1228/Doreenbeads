<?php
require('includes/application_top.php');
define('TEXT_DISPLAY_NUMBER_OF_TRENDS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> display area informations)');

if (isset($_GET['action']) && $_GET['action'] == 'download'){

    require_once(DIR_FS_CATALOG . DIR_WS_CLASSES . 'excel/PHPExcel.php');

    $objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
    
    $objPHPExcel->getActiveSheet()->setCellValue('A1', '客户ID');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', '姓名');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', '国家');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', '语种');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'VIP等级');
    $objPHPExcel->getActiveSheet()->setCellValue('F1', '客户店铺网址');
    $objPHPExcel->getActiveSheet()->setCellValue('G1', '注册时间');

    
    $index=2;

    $customers_business_info_sql="SELECT zc.customers_id,zc.customers_firstname,zc.customers_lastname,zc.customers_country_id,zl.directory,zc.customers_group_pricing,zc.customers_business_web,zci.customers_info_date_account_created ";
	$customers_business_info_sql.="FROM ".TABLE_CUSTOMERS." as zc LEFT JOIN ".TABLE_CUSTOMERS_INFO." as zci on zc.customers_id=zci.customers_info_id LEFT JOIN ".TABLE_LANGUAGES." as zl on zc.lang_preference=zl.languages_id where zc.customers_business_web !='' order by zc.customers_id desc";
    $customers_business_info=$db->Execute($customers_business_info_sql);
    
    while(!$customers_business_info->EOF){
        
        $vip_level="SELECT group_percentage FROM ".TABLE_GROUP_PRICING." WHERE group_id=".$customers_business_info->fields['customers_group_pricing'];
        $vip_level=$db->Execute($vip_level);
        $countries_name_sql="SELECT countries_name FROM ".TABLE_COUNTRIES." WHERE countries_id=".$customers_business_info->fields['customers_country_id'];
        $countries_name=$db->Execute($countries_name_sql);
        
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $index, $customers_business_info->fields['customers_id']);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $index, $customers_business_info->fields['customers_firstname'].' '.$customers_business_info->fields['customers_lastname']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $index, $countries_name->fields['countries_name']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $index, $customers_business_info->fields['directory']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $index, ($vip_level->fields['group_percentage']?$vip_level->fields['group_percentage']."%":"0"));
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $index, $customers_business_info->fields['customers_business_web']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $index, $customers_business_info->fields['customers_info_date_account_created']);

        $index++;
        $customers_business_info->MoveNext();
    }


    $styleArray = array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
        ),
    );
    $objPHPExcel->getActiveSheet()->getStyle("A2:G".($index-1))->applyFromArray($styleArray);
     
    $file_name = '客户店铺信息.xls';
    header("Content-type:application/octet-stream");
    header("Accept-Ranges:bytes");
    header("Content-type:application/vnd.ms-excel");
    header("Content-Disposition:attachment;filename=$file_name");
    header("Pragma: no-cache");
    header("Expires: 0");

    $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
    $objWriter->save('php://output');
    exit;
}
?>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" media="print" href="includes/stylesheet_print.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript" src="includes/javascript/jscript_jquery.js"></script>
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
}// -->
$(function(){
  	$('.dataTableRow').mouseover(function(){
		$(this).addClass('dataTableRowSelected');
		$(this).siblings().removeClass('dataTableRowSelected');
	  	})	  				
  });
</script>
<style>

table a{text-decoration:underline;}
td  {line-height:180%;}
.table_info{font-size:12px; font-family: Arial;width: 80%} 
.table_info tr{text-align: left;vertical-align: top;margin-bottom: 10px;line-height: 20px;}
.table_info tr th{width:180px;}
.table_info tr td br{}
.table_desc{margin-left:30px;font-size: 12px; font-size:14px;}
.table_desc tr{height:50px;}
.table_desc tr th{width:150px;text-align: left;}
.buttondiv{width: 300px;margin-left: 150px;}
.buttondiv button{width:100px;}
.normal_table tr td{text-align: center;}
.country_table span{width:160px; display:inline-block; margin:0px 5px 10px 0; vertical-align: top; font-size: 12px;}
.table_desc .title{width:80px;}
.table_desc .note{width:322px;}

</style>
</head>
<body onLoad="init()">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<table border="0" cellpadding="0" cellspacing="0" width="97%" align="center">
  	<tr>
  		<td class="pageHeading"><?php echo zen_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT);?></td>
  	</tr>
  	<tr>
  		<td class="pageHeading"><div style="float:left;">客户店铺信息</div></td>
  		
	</tr>
    <table border="0" width="100%" cellspacing="2" cellpadding="2">
		<tr height="80px">
		<input style="float:right;margin-right:50px;" type="button" value="导出店铺信息" onclick="window.location.href='customers_business_web_info.php?action=download'" />
		<td>
		 <table border="0" width="100%" cellspacing="0" cellpadding="0">
		<tr>
		<td style="float: right;">
				</td>
			</tr>
		</table>
	  <table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr class="dataTableHeadingRow">
			<td class="dataTableHeadingContent" style="padding:5px 2px; width:10%;text-align:center;">客户ID</td>
			<td class="dataTableHeadingContent" style="padding:5px 2px; width:10%;text-align:center;">姓名</td>
			<td class="dataTableHeadingContent" style="padding:5px 2px; width:10%;text-align:center;">国家</td>
			<td class="dataTableHeadingContent" style="padding:5px 2px; width:10%;text-align:center;">语种</td>
			<td class="dataTableHeadingContent" style="padding:5px 2px; width:10%;text-align:center;">VIP等级</td>
			<td class="dataTableHeadingContent" style="padding:5px 2px; width:10%;text-align:center;">客户店铺网址</td>
			<td class="dataTableHeadingContent" style="padding:5px 2px; width:10%;text-align:center;">注册时间</td>
		</tr>
		<?php 
		$customers_business_info_sql="SELECT zc.customers_id,zc.customers_firstname,zc.customers_lastname,zc.customers_country_id,zl.directory,zc.customers_group_pricing,zc.customers_business_web,zci.customers_info_date_account_created ";
		$customers_business_info_sql.="FROM ".TABLE_CUSTOMERS." as zc LEFT JOIN ".TABLE_CUSTOMERS_INFO." as zci on zc.customers_id=zci.customers_info_id LEFT JOIN ".TABLE_LANGUAGES." as zl on zc.lang_preference=zl.languages_id where zc.customers_business_web !='' order by zc.customers_id desc";
		$show_info_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS_REPORTS , $customers_business_info_sql ,$show_info_numrows);
		$customers_business_info=$db->Execute($customers_business_info_sql);
		while((!$customers_business_info->EOF)){
		    $vip_level="SELECT group_percentage FROM ".TABLE_GROUP_PRICING." WHERE group_id=".$customers_business_info->fields['customers_group_pricing'];
		    $vip_level=$db->Execute($vip_level);
		    $countries_name_sql="SELECT countries_name FROM ".TABLE_COUNTRIES." WHERE countries_id=".$customers_business_info->fields['customers_country_id'];
		    $countries_name=$db->Execute($countries_name_sql);
		?>	   
			<tr class="dataTableRow">
			<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo $customers_business_info->fields['customers_id'];?></td>
			<td class="dataTableContent" style="padding:5px 2px;" align="center">
			<?php if(empty($customers_business_info->fields['customers_firstname']) && empty($customers_business_info->fields['customers_lastname'])){echo "/";}else{echo $customers_business_info->fields['customers_firstname'].'&nbsp'.$customers_business_info->fields['customers_lastname'];}?></td>
			<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo $countries_name->fields['countries_name']?$countries_name->fields['countries_name']:"/"; ?></td>
			<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo $customers_business_info->fields['directory']?$customers_business_info->fields['directory']:"/";?></td>
			<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo $vip_level->fields['group_percentage']?$vip_level->fields['group_percentage']."%":"0";?></td>
			<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo $customers_business_info->fields['customers_business_web']?$customers_business_info->fields['customers_business_web']:"/";?></td>
			<td class="dataTableContent" style="padding:5px 2px;" align="center"><?php echo $customers_business_info->fields['customers_info_date_account_created']?$customers_business_info->fields['customers_info_date_account_created']:"/";?></td>
		</tr>
		<?php
		
		$customers_business_info->MoveNext();}?>
	  </table>
	  <table border="0" width="100%" cellspacing="0" cellpadding="2px">
		<tr>
			<td class="smallText" valign="top" ><?php echo $show_info_split->display_count($show_info_numrows, MAX_DISPLAY_SEARCH_RESULTS_REPORTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_TRENDS,zen_get_all_get_params(array('page','id','action'))); ?></td>
		    <td class="smallText" align="right" ><?php echo $show_info_split->display_links($show_info_numrows, MAX_DISPLAY_SEARCH_RESULTS_REPORTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], zen_get_all_get_params(array('page','id','action')) ); ?></td>
		</tr>
	  </table>

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>