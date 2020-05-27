<h3>登陆</h3>
<form class="formselect" name="cForm" id="loginForm" action="index.php?action=login&type=login" method="post">
	<table class="maintab">	
		<tr>
			<td>User Name:</td>
			<td><input id="username" name="username" type="text" /></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input id="password" name="password" type="password" /></td>
		</tr>
		<tr>
			<td>Auth NO.:</td>
			<td><input id="auth" name="auth" type="text" /><img id="code" src="create_code.php" alt="看不清楚，换一张" title="看不清楚，换一张" style="cursor: pointer; vertical-align:middle;" onClick="$(this).attr('src', 'create_code.php?'+Math.random()*10000)"/></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><button id="submitbtn">提交</button></td>
		</tr>
		<tr>
			<td colspan="2"><ins id="show_res"></ins></td>
		</tr>
	</table>
</form>