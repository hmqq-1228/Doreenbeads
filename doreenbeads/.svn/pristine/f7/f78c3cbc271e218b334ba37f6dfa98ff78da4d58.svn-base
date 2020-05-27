<h3>2.获取产品数据</h3>
<br/>
<form class="formselect" id="cForm1" name="cForm1" action="index.php?action=createEXCEL" method="post" enctype="multipart/form-data">
	<input type="hidden" name="type" value="testPic" />
	<fieldset>
	<legend>测试图片</legend>
	<table class="maintab">
		<tr>
			<td align="right">Excel:</td>
			<td>
				<input type="file" name="ulFile" id="ulFile" /><span>(<a href="template/excel/testPic.xlsx">点此</a>下载EXCEL模板.)</span>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><button id="submitbtn">提交</button></td>
		</tr>
		<tr>
			<td colspan="2"><ins id="show_res"></ins></td>
		</tr>
	</table>
	</fieldset>
</form>
<form class="formselect" id="cForm" name="cForm" action="index.php?action=createEXCEL" method="post" enctype="multipart/form-data">
	<fieldset>
	<legend>获取产品数据</legend>
	<table class="maintab">
		<tr>
			<td align="right">网站:</td>
			<td><?php echo $_SESSION['site']; ?></td>
		</tr>
		<tr>
			<td align="right">语言:</td>
			<td><?php echo $langArr[$_SESSION['lang']]; ?></td>
		</tr>
		<tr>
			<td align="right">类型:</td>
			<td><?php echo $typeArr[$_SESSION['type']]; ?></td>
		</tr>
		<tr>
			<td align="right">选择要上传的EXCEL:</td>
			<td>
				<input type="file" name="ulFile" id="ulFile" /><span>(<a href="template/excel/<?php echo $typeArr[$_SESSION['type']].'-1.xlsx'; ?>">点此</a>下载EXCEL模板1.)</span>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><button id="submitbtn">提交</button></td>
		</tr>
		<tr>
			<td colspan="2"><ins id="show_res"></ins></td>
		</tr>
	</table>
	</fieldset>
</form>