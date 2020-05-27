<?php /* Smarty version Smarty-3.1.13, created on 2019-12-12 14:41:03
         compiled from "includes\templates\mobilesite\tpl\tpl_receive_coupon.html" */ ?>
<?php /*%%SmartyHeaderCode:292255df1d5255bf537-94922147%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '09318a23679a18a919c28920e1959317efa4f68b' => 
    array (
      0 => 'includes\\templates\\mobilesite\\tpl\\tpl_receive_coupon.html',
      1 => 1576132859,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '292255df1d5255bf537-94922147',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5df1d525792b55_12819166',
  'variables' => 
  array (
    'receivable' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5df1d525792b55_12819166')) {function content_5df1d525792b55_12819166($_smarty_tpl) {?>
<script language="javascript" type="text/javascript">
function receive_coupon(){
	$('.Close').click(function(){
		$('.Anniversary-2018_error').hide();
	});
	
	$.ajax({
		type : 'post',
		url : 'index.php?main_page=receive_coupon',
		data : {action : 'receive_coupon'},
		async : false,
		success : function(result){
			var returnInfo = process_json(result);
			var lang = $('input[name=c_lan]').val();

			if(returnInfo.error == true){
    			switch(returnInfo.error_type){
    				case 1:
						window.location.href = returnInfo.redirect_url;
            			break;
    				case 2:
						$('.Anniversary-2018_error p').html(returnInfo.error_info);
						$('.Anniversary-2018_error').show();
            			break;
    				case 3:
    					$('.receive_button').attr('src', '/includes/templates/mobilesite/css/' + lang + '/images/Black_Friday1115_m4_grep.jpg');
    					$j('.receive_button').removeAttr('onclick');
        				break;
    			}
			}else{
				$('.receive_button').attr('src', '/includes/templates/mobilesite/css/' + lang + '/images/Black_Friday1115_m4_grep.jpg');
				$('.Anniversary-2018_error p').html(returnInfo.error_info);
				$('.Anniversary-2018_error').show();
				$j('.receive_button').removeAttr('onclick');
			}
		}
	});

	return false;
}

$(document).ready(function(){
	$('.Close').click(function(){
		$('.Anniversary-2018_error').hide();
	});
});
</script>


<div class="wrap-page"><!--手机站外框div-->
	<input type="hidden" name="c_lan" value="<?php echo $_SESSION['languages_code'];?>
">
	<div class="promotion1111_wrap">
		<img src="/includes/templates/mobilesite/css/<?php echo $_SESSION['languages_code'];?>
/images/hm/banner.jpg" />
		<?php if ($_smarty_tpl->tpl_vars['receivable']->value){?>
			<div class="en_btnBox">
				<div onclick="receive_coupon()" class="receive_button"><?php echo @constant('GET_COUPON_MOB');?>
</div>
			</div>
		<?php }else{ ?>
		    <div class="en_btnBox">
			   <div class="unreceive_button"><?php echo @constant('GET_COUPON_MOB');?>
</div>
			</div>
		<?php }?>
		<div class="HowToUse"><?php echo @constant('TEXT_HOW_TO_USE');?>
</div>
		<img src="/includes/templates/mobilesite/css/<?php echo $_SESSION['languages_code'];?>
/images/hm/coupon_step.jpg" />
		<div class="notice_1111">
			<?php echo @constant('TEXT_RECEIVE_COUPON_WARNING');?>

		</div>
		<div class="Anniversary-2018_error" style="display: none">
			<span class="Close"></span>
			<p style="line-hright:26px;"></p>
		</div>

	</div>
</div><?php }} ?>