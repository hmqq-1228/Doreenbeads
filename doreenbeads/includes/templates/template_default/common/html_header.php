<?php
/**
 * Common Template
 *
 * outputs the html header. i,e, everything that comes before the \</head\> tag <br />
 * 
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: html_header.php 4368 2006-09-03 19:31:00Z drbyte $
 */
/**
 * load the module for generating page meta-tags
 */
require(DIR_WS_MODULES . zen_get_module_directory('meta_tags.php'));
/**
 * output main page HEAD tag and related headers/meta-tags, etc
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo HTML_PARAMS; ?>>
<head>
<title><?php echo META_TAG_TITLE; ?></title>
<meta http-equiv="Content-Type"
	content="text/html; charset=<?php echo CHARSET; ?>" />
<meta name="keywords" content="<?php echo META_TAG_KEYWORDS; ?>" />
<meta name="description" content="<?php echo META_TAG_DESCRIPTION; ?>" />
<?php if($_GET['main_page']==$this_is_home_page){ ?>
<meta content="index,follow" name="robots" />
<meta content="index,follow" name="GOOGLEBOT" />
<meta content="Beads Wholesale" name="Author" />
<?php } ?>
<meta http-equiv="imagetoolbar" content="no" />
<meta name="author" content="http://www.8season-knitting.com" />
<meta name="verify-v1"
	content="er+Vol32KIC1eD3tjyNZojGyvLudSG34JAIVck5UET4=" />
<meta name="generator" content="zend studio" />
<?php if (defined('ROBOTS_PAGES_TO_SKIP') && in_array($current_page_base,explode(",",constant('ROBOTS_PAGES_TO_SKIP'))) || $current_page_base=='down_for_maintenance') { ?>
<meta name="robots" content="noindex, nofollow" />
<?php } ?>
<?php if (defined('FAVICON')) { ?>
<link rel="icon" href="<?php echo FAVICON; ?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo FAVICON; ?>"
	type="image/x-icon" />
<?php } //endif FAVICON ?>

<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER . DIR_WS_HTTPS_CATALOG : HTTP_SERVER . DIR_WS_CATALOG ); ?>" />

<?php
	define ( 'MINIFY_MIN_DIR', 'min' );
	$min_app ['groups'] = (require MINIFY_MIN_DIR . '/groupsConfig.php');
	$getMainPageCss = $current_page_base . '.css';
	$getMainPageJs = $current_page_base . '.js';
	$getMainPageCss = (is_array($min_app['groups'][$getMainPageCss])&&$min_app['groups'][$getMainPageCss]!='')?$getMainPageCss:'webDefault.css';
	$getMainPageJs = (is_array($min_app['groups'][$getMainPageJs])&&$min_app['groups'][$getMainPageJs]!='')?$getMainPageJs:'webDefault.js';
	$chooseCssLang = 'css_'.$_SESSION['languages_code'].'_lang/';
	$chooseJsLang = 'js_'.$_SESSION['languages_code'].'_lang/';
?>
<link href="<?php echo CURRENCY_CSS_JS_VERSION;?>/<?php echo $chooseCssLang;?>min/<?php echo $getMainPageCss;?>" rel="stylesheet" type="text/css">
<script src="<?php echo CURRENCY_CSS_JS_VERSION;?>/<?php echo $chooseJsLang;?>min/<?php echo $getMainPageJs;?>" type="text/javascript"></script>
</head>
<?php 
/**
 * include content from all page-specific jscript_*.php files from includes/modules/pages/PAGENAME, alphabetically.
 */
  $directory_array = $template->get_template_part($page_directory, '/^jscript_/');
  while(list ($key, $value) = each($directory_array)) {
/**
 * include content from all page-specific jscript_*.php files from includes/modules/pages/PAGENAME, alphabetically.
 * These .PHP files can be manipulated by PHP when they're called, and are copied in-full to the browser page
 */
    require($page_directory . '/' . $value); echo "\n";
  }

//DEBUG: echo '<!-- I SEE cat: ' . $current_category_id . ' || vs cpath: ' . $cPath . ' || page: ' . $current_page . ' || template: ' . $current_template . ' || main = ' . ($this_is_home_page ? 'YES' : 'NO') . ' -->';
?>
</head>
<?php // NOTE: Blank line following is intended: ?>

