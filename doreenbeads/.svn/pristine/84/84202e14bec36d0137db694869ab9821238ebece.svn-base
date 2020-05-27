<h3>4.生成HTML</h3>
<form class="formselect" id="cForm" name="cForm" action="index.php?action=createHTML" method="post" enctype="multipart/form-data">
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
		<tr class="hidethis">
			<td align="right">图片目录:</td>
			<td><?php 
				$ftp_str = 'ftp_'.$_SESSION['site'];
				$ftp_arr = $$ftp_str;
				echo $ftp_arr['url'].$langArr[$_SESSION['lang']].'/edm/'.date('Ymd').'/';
				?>
			</td>
		</tr>
		<tr class="hidethis">
			<td align="right">选择要上传的EXCEL:</td>
			<td>
				<input type="file" name="ulFile" id="ulFile" />
			</td>
		</tr>
		<tr class="hidethis">
			<td colspan="2" align="center"><button id="submitbtn">提交</button></td>
		</tr>
		<tr>
			<td colspan="2"><ins id="show_res"></ins></td>
		</tr>
	</table>
</form>