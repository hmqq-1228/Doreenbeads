<?php /* Smarty version Smarty-3.1.13, created on 2019-12-12 14:40:51
         compiled from "includes\templates\mobilesite\tpl\tpl_login.html" */ ?>
<?php /*%%SmartyHeaderCode:174195df1e0f3736c47-36280489%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '39c70eb0029dddae9360e41f9a719fc9f3ae8ae0' => 
    array (
      0 => 'includes\\templates\\mobilesite\\tpl\\tpl_login.html',
      1 => 1575421067,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '174195df1e0f3736c47-36280489',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'error_facebook' => 0,
    'loginUrl' => 0,
    'messageStack' => 0,
    'register_new_account' => 0,
    'error_facebook_register' => 0,
    'show_reg_checkcode' => 0,
    'default_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5df1e0f39180f5_84692494',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5df1e0f39180f5_84692494')) {function content_5df1e0f39180f5_84692494($_smarty_tpl) {?>


<style>
.maincontent .btn_like{background-color:#4865b4;text-align:center; color:#fff; font-size:18px; padding:5px 20px;float:unset;display:inline-block;}
.maincontent .btn_like ins{ background:url(https://img.doreenbeads.com/promotion_photo/en/Facebook/20150714/like_f0801.png) no-repeat; display:inline-block; width:12px; height:28px; padding-right:10px; position:relative; top:8px;vertical-align:baseline;}
</style>

<!-- <div class="maincontent">
    <h3 class="themetit"><?php echo @constant('TEXT_LOGIN');?>
</h3>
    <form class="loginform" name="loginform" action="index.php?main_page=login&action=process" method="POST" onsubmit="return check_login_form(loginform)">
      <input type="hidden" id="permLogin" name="permLogin" value=1 />
      <div><label><?php echo @constant('ENTRY_EMAIL_ADDRESS');?>
</label><input type="text" id="login-email-address" name="login_email_address"/><span id="login_email_error"><?php if ($_smarty_tpl->tpl_vars['error_facebook']->value){?>Please use Login With Facebook<?php }?></span></div>
      <div class="password_tr"><label><?php echo @constant('ENTRY_PASSWORD');?>
</label><input type="password"  id="login-password" name="login_password"/><span id="login_passwd_error"></span></div>
      <div><span class="check select"></span><ins><?php echo @constant('TEXT_REMEMBER_ME');?>
</ins><a href="index.php?main_page=forgetpwd"><?php echo @constant('TEXT_FORGET_PWD');?>
</a></div>
      <div><button class="button-now" type="submit"><?php echo @constant('TEXT_LOGIN');?>
</button></div>
    <div><a style="width:100%;padding:2px 0;text-decoration:none;" class="btn_like" href="<?php echo $_smarty_tpl->tpl_vars['loginUrl']->value;?>
"><ins style="top:0;"></ins><em style="font-size:15px;padding-bottom: 16px;">Login with Facebook</em></a></td></div>
    </form>
     <div style="clear:both; border-bottom: 1px dotted #ccc;height:20px;"><p></p></div>
     <div class="newto">  
      <p><?php echo @constant('TEXT_NEED_DORABEADS');?>
</p>
      <a href="index.php?main_page=register" class="button-change" ><?php echo @constant('TEXT_REGISTER');?>
</a>
     </div>
     <div class="loading hiddenField"></div>
</div> -->
<div class="popup">
    <div class="title_tab">
        <ul>
            <li class="active jq_signin_li"><a href="javascript:void(0);"><?php echo strtoupper(@constant('TEXT_RETURN_CUSTOMER'));?>
</a></li>
            <li class="jq_regiser_li"><a href="javascript:void(0);"><?php echo strtoupper(@constant('TEXT_NEW_CUSTOMER'));?>
</a></li>
        </ul>
        <div class="clearfix"></div>
    </div>
      <!--登入--> 
    <div class="regiser jq_signin_div">
        <form class="loginform" name="loginform" action="index.php?main_page=login&action=process" method="POST" onsubmit="return check_login_form(loginform);">
	        <?php if ($_SESSION['api_login_type']!=''){?>
	    		<p><?php echo @constant('TEXT_API_LOGIN_CUSTOMER');?>
</p>
	    	<?php }?>
            <input type="hidden"  value=1 />
            <input class="signin_input" type="text" placeholder="<?php echo @constant('ENTRY_EMAIL_ADDRESS');?>
" id="login-email-address" name="login_email_address"/>
            <span class="msg" id="login_email_error"><?php if ($_smarty_tpl->tpl_vars['error_facebook']->value){?>Please use Login With Facebook<?php }?></span>
            <input class="signin_input password_tr" type="password" placeholder="<?php echo @constant('ENTRY_PASSWORD');?>
" id="login-password" name="login_password"/>
            <span class="msg" id="login_passwd_error"></span>
            <?php if ($_SESSION['login_error_times']>=3){?>
                <div class="loginCode">
                    <input type="text" class="code_input" id="check_code_input" name="check_code" placeholder="<?php echo @constant('TEXT_CHECK_CODE');?>
"/>
                    <img style="height:40px" src="./check_code.php?code_suffix=login" align="absmiddle" onclick="this.src='./check_code.php?code_suffix=login&'+Math.random()" />
                </div>
                <span class="msg" id="codenotice"></span>
            <?php }?>            
            <?php if ($_smarty_tpl->tpl_vars['messageStack']->value->size('login')>0){?>
                <div class="remove_messageStack_css">
                    <?php echo $_smarty_tpl->tpl_vars['messageStack']->value->output('login');?>

                </div>
            <?php }?>
            <div>
                <span class="prompt float_lt"><a href="index.php?main_page=forgetpwd"><?php echo @constant('TEXT_FORGET_PWD');?>
</a></span>
                <div class="notice_checkbox">
                    <input type="checkbox" id="permLogin" name="permLogin" class="chk_1"/> 
                    <?php echo @constant('TEXT_REMEMBER_ME');?>

                </div>
            </div>            
            <button class="button_join" type="submit"><?php echo strtoupper(@constant('TEXT_SIGN_IN'));?>
</button>
            <?php if ($_SESSION['api_login_type']==''){?>
	            <div style="margin-top: 15px;">
		            <span style="vertical-align:  top;display: inline-block;">Login with:</span>
		       		<a id="btn_like" href="<?php echo $_smarty_tpl->tpl_vars['loginUrl']->value;?>
" style="margin-left:0;padding-right:5px;" ><div id="facebook_img" style="top: 5px;"></div></a>
		       		<span onclick = "login_twitter('twitter')" id="twitter_img" style="top: 5px;" ></span>
		       		<div id='vk_api_transport' style="display: inline"></div>
		       		<span onclick="login_api_vk();" id="vk_img" style="top: 5px;"></span>
	       		</div>
       		<?php }?>
        </form>
    </div>
    <div class="regiser jq_register_div"  style="display:none;">
        <!-- <form class="registerform" name="registerform" method="post" action="index.php?main_page=register&action=process" onsubmit="return check_reg_form(registerform);"> -->
        <form class="registerform" name="registerform">
	        <?php if ($_SESSION['api_login_type']!=''){?>
	    		<p><?php echo $_smarty_tpl->tpl_vars['register_new_account']->value;?>
</p>
	    	<?php }?>
            <p><?php echo @constant('TEXT_CREATE_ACCOUNT_BENEFITS');?>
</p>
            <input type="hidden" name="agree_terms"  value=1 />
            <input type="hidden" name="action"  value='create' />
            <input type="hidden" name="is_return_array"  value=1 />
            <input type="hidden" name="is_return_success_page"  value=1 />
            <input type="text"  class="reg-email-address required signin_input" name="email_address" id="reg_email_address" placeholder="<?php echo @constant('ENTRY_EMAIL_ADDRESS');?>
"/>
            <span class="msg" id="reg_email_error"><?php if ($_smarty_tpl->tpl_vars['error_facebook_register']->value){?>This email is taken. Please use Login With Facebook<?php }?></span>
            <input class="signin_input password_tr password required" type="password" placeholder="<?php echo @constant('ENTRY_PASSWORD');?>
" id="reg_password" name="password"/>
            <span class="msg" id="reg_password_error"></span>
            <input class="signin_input confirmpass required" type="password" placeholder="<?php echo @constant('ENTRY_CONFIRM_PASSWORD');?>
" name="confirmation" id="confirmpass"/>
            <span class="msg" id="reg_confpwd_error"></span>
            <?php if ($_smarty_tpl->tpl_vars['show_reg_checkcode']->value){?>
                <div class="registerCode">
                    <input type="text" class="code_input" id="reg_check_code_input" name="check_code" placeholder="<?php echo @constant('TEXT_CHECK_CODE');?>
"/>
                    <img  src="./check_code.php?code_suffix=login" align="absmiddle" onclick="this.src='./check_code.php?code_suffix=login&'+Math.random()" style="height:40px;" />
                </div>
                <span class="msg" id="reg_checkcode_error">Email Address</span>
            <?php }?>
            <div class="notice_checkbox">
                <input type="checkbox" id="newsletter" name="subscribe" class="chk_1" />
                <?php echo @constant('SUBCIBBE_TO_RECEIVE_EMAIL');?>

            </div>
            <input type="hidden" name="register_entry" value="2" />
            <button class="button_join jq_register_submit" data-url="<?php echo $_smarty_tpl->tpl_vars['default_url']->value;?>
ajax_login.php" type="button"><?php echo strtoupper(@constant('TEXT_JOIN_NOW'));?>
</button>
            <span class="prompt"><?php echo @constant('AGREEN_TO_TERMS_AND_CONDITIONS');?>
</span>
        </form>
    </div>
</div>

<script src="https://adodson.com/hello.js/dist/hello.all.js"></script>
<script>
var log = console.log;
hello.init({'twitter':'<?php echo @constant('TEXT_TWITTER_LOGIN_API_KEY_MOBILESITE');?>
'});
            
function login_twitter(network){  //登录方法，并将twitter 作为参数传入
    // Twitter instance
    var twitter = hello(network);
    // Login
    twitter.login().then( function(r){
        return twitter.api('me');
    }, function(e) {
    	
    } ).then( function(p){
         log("Connected to "+ network+" as " + p.name);
         
         var data = JSON.stringify(p);//因为得不到token，但是这步已经得到用户所有信息，所以将用户信息转成JSON字符串给后台
         
         $.ajax({  
	          type : "post",  
	          url : "./ajax/ajax_api_login.php",  
	          data : {action:"api_login",data:data,network:'Twitter',origin_url:window.location.href},  
	          async : false,  
	          success : function(result){
	        	  var returnInfo = process_json(result);
	        	  self.location = returnInfo.redirct_url;
	  			}
	          });  
    }, log );
 }
</script>
<script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>
<script type="text/javascript">
  VK.init({
    apiId: '<?php echo @constant('TEXT_VK_LOGIN_API_KEY_MOBILESITE');?>
'
  });

   function login_api_vk(){//登录  
	    VK.Auth.login(function(response){  
	        if(response.session){  
	            if(response.status=='connected'){  
	                / *所选用户访问设置，如果他们被请求* / 
	                var data = JSON.stringify(response.session);

	                $.ajax({
                                    type : 'post',
                                    url : './ajax/ajax_api_login.php',
                                    data : {action:'api_login',data:data,network:'VK',origin_url:window.location.href},
                                    async : false,
                                    success : function(result){
                                    var returnInfo = process_json(result);
                                    self.location = returnInfo.redirct_url;
                                    }
		            });
	            }  
	        } else {  
	            / *用户单击授权窗口中的取消按钮* /  
	        }  
	    });  
	}; 
</script>
<?php }} ?>