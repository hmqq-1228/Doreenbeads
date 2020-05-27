<?php /* Smarty version Smarty-3.1.13, created on 2020-03-11 18:15:46
         compiled from "includes\templates\checkout\tpl_quick_add_products.html" */ ?>
<?php /*%%SmartyHeaderCode:156805e68ba52dc51c3-17029858%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '432dfbb7e2ddc708bcec53399cbcc6f5671feed9' => 
    array (
      0 => 'includes\\templates\\checkout\\tpl_quick_add_products.html',
      1 => 1575421047,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '156805e68ba52dc51c3-17029858',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page' => 0,
    'loop' => 0,
    'show_upload_auth_code' => 0,
    'smarth' => 0,
    'show_upload_auth_code_str' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5e68ba52ebb989_97255002',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e68ba52ebb989_97255002')) {function content_5e68ba52ebb989_97255002($_smarty_tpl) {?><!-- bof quick add product -->
<div class="smallwindow quickfind" id="quickaddsmallwindow" style="display: none;">
	<div class="smallwindowtit"><strong><?php echo @constant('TEXT_CART_QUICK_ORDER_BY');?>
</strong><a href="javascript:void(0);" class="addressclose">X</a></div>
    <ul class="choose_tab">
      <li class="current" data-target=".jq_cart_normal"><?php echo @constant('TEXT_BY_PART_NO');?>
</li>
      <li data-target=".jq_cart_spreadsheet"><?php echo @constant('TEXT_BY_SPREADSHEET');?>
</li>
      <div class="clearfix"></div>
    </ul>
	<div class="quickaddcont jq_cart_normal">
		<p class="quicktext"><?php echo @constant('TEXT_CART_QUICK_ADD_NOW_TITLE');?>
</p> 
		<form action="index.php?main_page=shopping_cart&page=<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
" method="post" name="quick_add">
			<input type="hidden" name="action" value="addselect">
			<table class="quickadd" width="100%">
				<tr><th><?php echo @constant('TEXT_CART_P_NUMBER');?>
</th><th><?php echo @constant('TEXT_CART_P_QTY');?>
</th></tr>
				<tr><td style="padding-top:15px;"><input type="text" name="product_model[]"/></td><td style="padding-top:15px;"><input type="text" name="product_qty[]" onpaste="return false"/></td></tr>
				<?php $_smarty_tpl->tpl_vars["loop"] = new Smarty_variable("4", null, 0);?>
				<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['loop']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total']);
?>
				<tr>
					<td><input type="text" name="product_model[]" /></td>
					<td><input type="text" name="product_qty[]" onpaste="return false" /></td>
				</tr>
				<?php endfor; endif; ?>
			</table>
		</form>
		<div class="doublebutton">
			<div class="successtips_update quickadd_sub">
				<span class="bot"></span>
				<span class="top"></span>
				<p class="quickadd_sub_note"></p>
			</div>
			<button class="paynow_btn"><?php echo @constant('TEXT_CART_ADD_TO_CART');?>
</button>			
			<button class="greybtn"><?php echo @constant('TEXT_CART_ADD_MORE_ITEMS_CART');?>
</button>
			
		</div>
	</div>
    
	<div class="add_spreadsheet jq_cart_spreadsheet" style="display:none;">
        <!-- <form name="jq_export" method="get">
            <input type="hidden" name="main_page" value="shopping_cart" />
            <input type="hidden" name="action" value="export_cart" />
        </form> -->
        <form action="index.php?main_page=shopping_cart&page=<?php echo $_smarty_tpl->tpl_vars['page']->value;?>
" method="post" id="quick_add_spreadsheet" name="quick_add_spreadsheet" enctype="multipart/form-data" onsubmit="return false;">
            <input type="hidden" name="action" value="add_spreadsheet">
            <p><?php echo @constant('TEXT_BY_SPREADSHEET_TIPS');?>
</p><br/>
            <div>
                <input type="file" id="filePath" name="filePath" onchange="loadFile(this);" />
                <div class="upload_notice">
                    <div class="pop_note_tip">
                        <i class="top"></i><em class="top"></em>
                        <?php echo @constant('TEXT_UPLOAD_EXCEL_ERROR_TIPS');?>

                    </div>
                </div>
            </div> 
            <span class="fred jq_error_tips" style="display:none;"></span>
            <p class="fred jq_tips"></p>
            <?php if ($_smarty_tpl->tpl_vars['show_upload_auth_code']->value){?>
                <p>
                    <?php echo $_smarty_tpl->tpl_vars['smarth']->value['const']['TEXT_VERIFY_NUMBER'];?>

                    <?php echo $_smarty_tpl->tpl_vars['show_upload_auth_code_str']->value;?>

                    <img  id="check_code" src="./check_code.php" style="height: 26px;vertical-align: middle;"  onClick="this.src='./check_code.php?'+Math.random();" />
                </p>
                 <span class="fred jq_error_authsode_tips" style="display:none;"></span>
            <?php }?>
            <br/><button class="paynow_btn"><?php echo @constant('TEXT_CART_ADD_TO_CART');?>
</button>
        </form>
        <!-- <div class="fexample"> <?php echo @constant('TEXT_EXAMPLE');?>
:
          <table width="200" border="0" cellspacing="0" cellpadding="0">
          doublebutton  <tr>
              <th scope="col">Part No.</th>
              <th scope="col">QTY</th>
            </tr>
            <tr>
              <td>B00001</td>
              <td>1</td>
            </tr>
            <tr>
              <td>B00002</td>
              <td>5</td>
            </tr>
          </table>
          <p><?php echo @constant('TEXT_SAMPLE_FROM_YOUR_SPREADSHEET');?>
</p>
        </div> -->
	</div>
      
</div>
<!-- eof quick add product -->

<script>
    function loadFile(file) {
        var filePath = file.value;
        var fileExt = filePath.substring(filePath.lastIndexOf(".")).toLowerCase();

        $j('.jq_error_tips').text('').hide();

        if (!checkFileExt(fileExt)) {
            //alert("Format only Accept: .xlsx,.xls .One file should be no more than 2MB.");
            $j('.jq_error_tips').text($lang.TEXT_UPLOAD_EXCEL_ERROR_TIPS).show();
            file.value = "";
            return;
        }
        if (file.files && file.files[0]) {
            if ( (file.files[0].size / 1024 ) > 2048) {
                $j('.jq_error_tips').text($lang.TEXT_UPLOAD_EXCEL_ERROR_TIPS).show();
                file.value = "";
                return;
            };
        } else {
            file.select();
            var url = document.selection.createRange().text;
            try {
                var fso = new ActiveXObject("Scripting.FileSystemObject");
            } catch (e) {
                //alert('如果你用的是ie8以下 请将安全级别调低！');
            }
             if ( (fso.GetFile(url).size / 1024) > 2048) {
                $j('.jq_error_tips').text($lang.TEXT_UPLOAD_EXCEL_ERROR_TIPS).show();
                file.value = "";
                return;
            };
        }
    } 
    function checkFileExt(ext) {
        if (!ext.match(/.xls|.xlsx/i)) {
            return false;
        }
        return true;
    }
</script>
<?php }} ?>