<?php
chdir("../");
require_once("includes/application_top.php");
require("includes/access_ip_limit.php");
@ini_set('display_errors', '1');
set_time_limit(3600);
ini_set('memory_limit','512M');
?>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>data-process</title>
	<script language="JavaScript" src="jquery-1.9.1.js"></script>
	<script language="JavaScript" src="jquery.form.js"></script>
	<script type="text/javascript" language="JavaScript">
	$(function() {
		$(".cForm").submit(function(){
			var jqForm = $(this);
			jqForm.ajaxSubmit({
				beforeSubmit:function(){jqForm.find("#show_res").html('<img src="loading.gif" />');jqForm.find('#submitbtn').attr('disabled', true)},
				success:function(result){
					jqForm.find("#show_res").html(result);
					jqForm.find('#submitbtn').attr('disabled', false);
				}
			});
			return false;
		});
	});
	</script>
	<style>
		td{padding:8px}
	</style>
</head>

<body>

<center><form class="cForm" name="form1" action="sql_update_stock_lxy.php" enctype="multipart/form-data" method="post" style="background-color:#eee;text-align:center; padding-top:100px;padding-bottom:100px;width:40%">
	<table border="0" width="100%">
		<tr><td align="right">库存类型：</td>
			<td><select name="action">
				<option value="">--选择一项--</option>
				<option value="normal">正常销售商品</option>
				<option value="preorder">库存较少卖完需改成预定商品</option>
				<option value="limit_stock">滞销待报废需绑定库存销售商品</option>
				<option value="invalid">暂停报废需下货商品</option>
			</select></td>
		</tr>
		<tr><td align="right">Csv File: </td><td><input type="file" name="csvFile" /> <a href="template_stock.csv" target="_blank">模板文件</a></td></tr>
		<tr><td colspan="2" align="center"><input type="submit" id="submitbtn" name="subtn" value="Submit" /></td></tr>
		<tr><td colspan="2" align="center"><div id="show_res"></div></td></tr>
	</table>
</form></center>

</body>

</html>

