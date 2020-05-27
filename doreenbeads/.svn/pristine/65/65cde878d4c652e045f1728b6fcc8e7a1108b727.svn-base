<h3>3.上传FTP 生成图片地址</h3>
<form class="formselect" id="cForm" name="cForm" action="index.php?action=putFTP" method="post" enctype="multipart/form-data">
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
			<td align="right">图片目录:</td>
			<td><?php 
				$ftp_str = 'ftp_'.$_SESSION['site'];
				$ftp_arr = $$ftp_str;
				echo $ftp_arr['url'].$langArr[$_SESSION['lang']].'/edm/'.date('Ymd').'/';
			?></td>
		</tr>
		<tr>
			<td align="right">选择要上传的图片ZIP:</td>
			<td>
				<input type="file" name="ulFile" id="ulFile" />
				<span>（仅允许ZIP格式）</span>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<button id="submitbtn">提交</button>
				<label class="nav"><a style="color:#fff;" href="index.php?step=<?php echo $step+1; ?>">跳过</a></label>
			</td>
		</tr>
		<tr>
			<td colspan="2"><ins id="show_res"></ins></td>
		</tr>
	</table>
</form>