<div class="searchpart">
	<div class="searchpart_l"><h2><?php echo TEXT_HELP_CENTER; ?></h2></div>
	<div class="searchpart_r">
		<form class="searchform" name="faq_search_form" action="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'action=search'); ?>" method="post" onsubmit="return chk_faq_search_form();">
			<input type="text" name="faq_search" value="<?php echo TEXT_ENTER_THE_KEYWORD; ?>" id="searchwords"/>
			<input type="submit" class="searchsubmit" value="&nbsp;"/>
		</form>
	</div>
	<div class="clearfix"></div>
</div>
<div class="resultcont">
	<ul class="helpcenter">
		<li class="helpc_l"><h3><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER);?>"><?php echo TEXT_CUSTOMER_CARE; ?></a></h3></li>
		<li class="helpc_r"><h3><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=180');?>"><?php echo TEXT_FAQ; ?></a></h3></li>
		<li class="helpc_l"><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'pagename=shipping_calculator');?>"><ins class="shipcal_icon"></ins><?php echo TEXT_SHIPPING_CALCULATOR; ?></a></li>
		<li class="helpc_r"><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=182');?>"><ins class="aboutcom_icon"></ins><?php echo TEXT_ACOUT_DORABEADS; ?></a></li>
		<li class="helpc_l"><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=181');?>"><ins class="shipmethod_icon"></ins><?php echo TEXT_SHIPPING_METHODS; ?></a></li>
		<li class="helpc_r"><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=227');?>"><ins class="shipusa_icon"></ins><?php echo TEXT_SHIPPING_FROM_USA;?></a></li>
		<li class="helpc_l"><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=15');?>"><ins class="payment_icon"></ins><?php echo TEXT_PAYMENT_METHODS; ?></a></li>
		<li class="helpc_r"><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=183');?>"><ins class="order_icon"></ins><?php echo TEXT_ORDERING_INFO; ?></a></li>
		<li class="helpc_l"><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=46');?>"><ins class="track_icon"></ins><?php echo TEXT_TRACKING_PARCELS; ?></a></li>
		<li class="helpc_r"><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=184');?>"><ins class="myaccount_icon"></ins><?php echo TEXT_MYACCOUNT_INFO; ?></a></li>
		<li class="helpc_l"><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=65');?>"><ins class="vippolicy_icon"></ins><?php echo TEXT_DISCOUNT_VIP; ?></a></li>
		<li class="helpc_r"><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=185');?>"><ins class="customer_icon"></ins><?php echo TEXT_CUSTOMER_SERVICE; ?></a></li>
		<li class="helpc_l"><a href="<?php echo zen_href_link(FILENAME_OEM_SOURCING, '');?>"><ins class="customize_icon"></ins></ins><?php echo TEXT_CUSTOMIZE_SERVICE; ?></a></li>
		<li class="helpc_r"><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=186');?>"><ins class="cusduty_icon"></ins><?php echo TEXT_CUSTOM_DUTY; ?></a></li>
		<!-- <li class="helpc_l"><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=18');?>"><ins class="learning_icon"></ins><?php echo TEXT_LEARNING_CENTER; ?></a></li> -->
		<li class="helpc_l"><!-- <a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=64');?>"><ins class="newlastest_icon"></ins><?php echo TEXT_LASTEST_NEWS; ?></a> --></li>
		<li class="helpc_r"><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=187');?>"><ins class="item_icon"></ins><?php echo TEXT_ITEM_PRICE; ?></a></li>
		<li class="helpc_l"></li>
		<li class="helpc_r"><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=188');?>"><ins class="product_icon"></ins><?php echo TEXT_PRODUCT_QUESTIONS; ?></a></li>
		<li class="helpc_l"></li>
		<li class="helpc_r"><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=189');?>"><ins class="website_icon"></ins><?php echo TEXT_WEBSITE_QUESTIONS; ?></a></li>
		<!--Tianwen.Wan20170523
		<li class="helpc_l"></li>
		<li class="helpc_r"><a href="<?php echo zen_href_link(FILENAME_HELP_CENTER, 'id=180');?>"><ins class="cusques_icon"></ins><?php echo TEXT_CUSTOMER_QUESTIONS; ?></a></li>
		-->
	</ul>
	<div class="clearfix"></div>
<?php if (isset($_SESSION['customer_id']) && $_SESSION['customer_id'] != ''){
	$customer_info = zen_get_customer_info($_SESSION['customer_id']);
?>
	<p class="helpcenter_askbtn"><a href="javascript:void(0);" class="commonbtn ask_new_qst"><?php echo TEXT_ASK_QUESTION; ?></a></p>
	<div class="askquestioncont">
		<p class="askquestioncont_tit"><strong><?php echo TEXT_ASK_QUESTION; ?></strong><span class="closeaskbtn">X</span></p>
		<div class="askquestioninner">
			<form name="faq_customer_question" id="askquestform" action="#" method="post">
				<p><?php echo TEXT_YOUR_NAME; ?>: <?php echo $customer_info['name'];?></p>
				<p><?php echo TEXT_YOUR_EMAIL; ?>: <?php echo $customer_info['email'];?></p>
				<p><span><?php echo TEXT_QUESTIONS; ?>: </span><textarea id="askquestion_area" name="customer_question"></textarea><div id="question_tip" style="color: red;margin-left: 80px;"></div></p>
				<p>
				<?php if ($_SESSION['auto_auth_code_display']['FAQ'] >=3 ){?>
		        	<span style="width:50px;position: relative;top:1px;display:inline-block;line-height: 18px;" class="auth_code_span"><?php echo TEXT_VERIFY_NUMBER;?>:</span> <?php echo zen_draw_input_field('check_code', '', 'size="25" id="check_code_input" class="auth_code_span" style="WIDTH: 50PX;line-height: 20px;position: relative;top: -8px; margin-left:10px;"'); ?><img  id="check_code" src="./check_code.php" style="margin-left: 15px;height:24px;" onClick="this.src='./check_code.php?'+Math.random();" />
		        <?php }?>
		        <span   style="position: relative;top:1px;float: right;" id="char_num_tips">(<label id="textnum">150</label> <?php echo TEXT_CHAR_REMAINING; ?>)</span></p>
				<p><input type="submit" class="commonbtn askquestion_submit" value="Submit"/><span class="alert" id="login_checkcode_error" style=" display: inline-block; margin-left: 10px;line-height: 20px; margin-top: 10px;position: relative;top:1px;display:inline-block;line-height: 18px;"></span></p>
				<p class="quesemail"><?php echo TEXT_HAVE_DIFF_QUESTIONS; ?></p>
			</form>
			<dl class="askquest_success">
				<dd></dd>
				<dt><?php echo TEXT_SUBMIT_SUCCESS_NEW; ?></dt>
			</dl>
		</div>
	</div>
<?php }?>
</div>
<script type="text/javascript">

function chk_faq_search_form(){
	var v = $j('#searchwords').val();
//	var reg = /^[0-9a-zA-Z]*$/g;
	var reg = /^([0-9A-Za-z]+\s*)*[0-9A-Za-z]*$/g;
	if(! reg.test(v)){
		alert("<?php echo TEXT_KEYWORD_ERROR; ?>");
		return false;
	}else
		return true;
}
$j(function(){
	$j('#searchwords').focus(function(){
		var v = $j(this).val();
		if(v == '<?php echo TEXT_ENTER_THE_KEYWORD; ?>')
			$j(this).val('');
	}).blur(function(){
		var v = $j(this).val();
		if(v == '')
			$j(this).val('<?php echo TEXT_ENTER_THE_KEYWORD; ?>');
	});

	$j(".helpcenter_askbtn .ask_new_qst").click(function(){
		ask_reinput();
		showbox('askquestioncont','windowbody','closeaskbtn');
		var h = $j(document).height();
		$j(".windowbody").css("height",h);
	})

	var showbox = function(aid,bgid,imgid){
		var sheight = $j(window).scrollTop();
		var rheight = $j(window).height();
		var rwidth	= $j(window).width();
		var wwidth	= $j('.'+aid).width();
		var wheight = $j('.'+aid).height();
		$j('.'+aid).css("top",(sheight+(rheight-wheight)/2)+"px");
		$j('.'+bgid).fadeTo(1000,0.3);
		$j('.'+aid).show();
		$j('.'+bgid).click(function(){
			$j('.'+bgid).fadeOut();
			$j('.'+aid).hide();
		})
		$j('.'+imgid).click(function(){
			$j('.'+bgid).fadeOut();
			$j('.'+aid).hide();
		})
	}
	var askques_tips="<?php echo TEXT_ATLEAST_CHAR; ?>";	
	var ask_reinput = function(){
		$j("#askquestion_area").val(askques_tips).css('color','#959595');
		$j('#askquestform').show();
		$j('.askquest_success').hide();
		$j('#textnum').text(150);
	}

	$j("#askquestion_area").val(askques_tips).css('color','#959595');	
	$j("#askquestion_area").focus(function(){
		if($j(this).val() == askques_tips){
			$j(this).val('');
			$j("#askquestion_area").css("background","#fff");
			$j("#askquestion_area").css("color","#959595");
		}
	}).blur(function(){
		if($j(this).val() == '')
			$j(this).val(askques_tips);
	}).keyup(function(){
		if($j(this).val() == askques_tips){
			$j(this).val('');
			$j("#askquestion_area").css("background","#fff");
			$j("#askquestion_area").css("color","#959595");
		}else{
			if($j(this).val().length>150)
				$j(this).val($j(this).val().substr(0,150))
			$j('#textnum').text(150-($j(this).val().length));
		}
	})		
			
	var askchecking = function(){
		var question_text = $j.trim($j("#askquestion_area").val());
		var langs = $j("#c_lan").val();
		var error = false;
		var error_info;
		
		$j("#login_checkcode_error").text('');
		
		switch(langs){
			case 'english': 
				error_info = 'Please input right validate code!';
				break;
			case 'german': 
				error_info = 'Ungleicher Sicherheitscode!';
				break;
			case 'russian': 
				error_info = 'Пожалуйста, введите правильный код!';
				break;
			case 'french': 
				error_info = 'Saisissez le code correct et valide!';
				break;
			case 'spanish': 
				error_info = 'Por favor ingrese correctamente el código de validación!';
				break;
			case 'japanese': 
				error_info = '正しい検証コードを入力してください。';
				break;
			case 'italian':
				error_info = 'Si prega di inserire il codice esatto !';
				break;
			default :
				error_info = 'Please input right validate code!';
		}
		
		if(question_text == '' || question_text == askques_tips){
			$j("#askquestion_area").css("background","#fffdea").css("color","#c70006");  
			error = true;
		}else{
		    if(checkTextUrl(question_text)){
                $j("#question_tip").html($lang.TEXT_CHECK_URL);
                error = true;
            }else{
                $j("#askquestion_area").css("color","#333");
                error = false;
            }
		}

		if($j('#check_code_input').length > 0){
			var form_code = $j('#check_code_input').val().toLowerCase();
			
			if(form_code.length == 0){
				error = true;
				$j("#login_checkcode_error").text(error_info);
			}else{
				$j.ajax({
					url: './checkCode.php',
					type: 'POST',
					async: false,
					data: {form_code: form_code},
					success: function(data){
						if(data.length > 0){
							$j("#login_checkcode_error").text(error_info);
							error = true;
						}
					}
				});
			}
		}
		
		return !error;
	}
	$j('.askquestion_submit').click(function(){
		if(!askchecking()){
			return false;
		}else{
			$j.post('./ajax_login.php', {action:'customer_question', customer_question:$j.trim($j("#askquestion_area").val())}, function(data){
				returnInfo = process_json(data);

				if(returnInfo.is_error == true){
					alert(returnInfo.error_info);
				}else{
					$j('#askquestform').hide();
					$j('.askquest_success').show();
					setTimeout(function(){$j('.windowbody').fadeOut();$j('.askquestioncont').hide();},5000);
				}

				$j(".auth_code_span").remove();
				if(returnInfo.add_auth_code == true){
					$j("#char_num_tips").before(returnInfo.add_content);
				}
			});
			return false;
		}
	})		
})

</script>
