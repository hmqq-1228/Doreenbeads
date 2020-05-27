<h3>1.设置</h3>
<form class="formselect" name="cForm" action="index.php?action=setSLT" method="post">	
	<table class="maintab">
		<tr>
			<td align="right">网站:</td>
			<td>
			<?php
			foreach($siteArr as $v){
				if(strstr($_SERVER['HTTP_HOST'], $v)){
					$_SESSION['site'] = $v;
					continue;
				}
			}
			echo $_SESSION['site'];
			?>
			</td>
		</tr>
		<tr>
			<td align="right">语言:</td>
			<td><select name="lang" id="lang">
			<?php
			foreach($langArr as $k=>$v){
				echo "<option value=\"$k\" ".((isset($_SESSION['lang']) && $_SESSION['lang']==$k) ? 'selected="selected"' : '').">$v</option>";
			}
			?>
			</select></td>
		</tr>
		<tr>
			<td align="right">类型:</td>
			<td><select name="type" id="type">
			<?php
			foreach($typeArr as $k=>$v){
				echo "<option style='display:" . ($k == 'edm2' ? 'none':'block') . "' value=\"$k\" ".((isset($_SESSION['type']) && $_SESSION['type']==$k) ? 'selected="selected"' : '').">$v</option>";
			}
			?>
			</select></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><button id="surebtn">确定</button></td>
		</tr>
	</table>
</form>