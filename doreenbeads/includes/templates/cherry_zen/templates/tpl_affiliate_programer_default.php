<?php
/**
 * Page Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_login_default.php 5926 2007-02-28 18:15:39Z drbyte $
 */
?>

<style>
    div, p{ margin: 0; padding: 0;
        
    }
    .program-login{
        width: 340px;
        margin: 0 auto;
        border:1px solid #d6a7cd;
        box-shadow:2px 5px 2px #eaeaea;
        padding: 40px 130px;
        margin-top:50px;
    }
    .program-login .account{
     margin-bottom: 20px;
    }
    .program-login .account p{
        color: #BF0101;
        font-size: 13px;
        
    }
    .program-login .account input {
        width: 340px;
        border: 1px solid #ccc;
        line-height: 30px;
        display: block;
    }
    .program-login .copy{
        display: block;
        background-color:#bc66d8;
        border: 1px solid #974add;
        width: 340px;
        line-height: 30px;
        color:#fff;
        font-size: 14px;
        font-weight: bold;
        margin-top: 10px;
        cursor: pointer;
    }
</style>

<div class="program-login">
    
    <div class="account"><input id="input"  value="<?php echo $url;?>" readonly>
    </div>
    
    <button class="copy" onclick="copyUrl()" id="copy" ><?php echo TEXT_COPY; ?> </button>
    <br/>
    <p><?php echo TEXT_WORD ;?></p>
</div>
