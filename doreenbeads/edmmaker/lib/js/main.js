$(function() {
	$(".datepicker").datepicker({dateFormat: 'yymmdd'});

	$("#cForm").submit(function(){
		$(this).ajaxSubmit({
			beforeSubmit:function(){$("#cForm #show_res").html('<img src="lib/images/loading.gif" />');$('#cForm #submitbtn').attr('disabled', true)},
			success:function(result){
				$("#cForm #show_res").html(result);
				$('#cForm #submitbtn').attr('disabled', false);
			}
		});
		return false;
	});
	$("#cForm1").submit(function(){
		$(this).ajaxSubmit({
			beforeSubmit:function(){$("#cForm1 #show_res").html('<img src="lib/images/loading.gif" />');$('#cForm1 #submitbtn').attr('disabled', true)},
			success:function(result){
				$("#cForm1 #show_res").html(result);
				$('#cForm1 #submitbtn').attr('disabled', false);
			}
		});
		return false;
	});
	$("#loginForm").submit(function(){
		var username = $("#username").val();
		var password = $("#password").val();
		var auth = $("#auth").val();
		if(username=='' || password=='' || auth==''){
			$("#loginForm #show_res").html('All are needed!');
			return false;
		}
		$(this).ajaxSubmit({
			beforeSubmit:function(){$("#loginForm #show_res").html('<img src="lib/images/loading.gif" />');$('#loginForm #submitbtn').attr('disabled', true)},
			success:function(result){
				var arr = result.split('|');
				if(arr[0] == '0'){
					$("#loginForm #show_res").html(arr[1]);
					$('#loginForm #submitbtn').attr('disabled', false);
				}else{
					window.location.href = arr[1];
				}
			}
		});
		return false;
	});
});