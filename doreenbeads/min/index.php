<?php
/**
 * Front controller for default Minify implementation
 *
 * DO NOT EDIT! Configure this utility via config.php and groupsConfig.php
 *
 * @package Minify
 */
define('MINIFY_MIN_DIR', dirname(__FILE__));
// load config
require MINIFY_MIN_DIR . '/config.php';

if ($_SERVER['HTTP_HOST'] == MOBILESITE){
	$is_mobilesite = true;
}else{
	$is_mobilesite = false;
}
//$is_mobilesite = true;
$in_language = substr($_SERVER['REQUEST_URI'],(strpos($_SERVER['REQUEST_URI'], 'min')-5),4)=='lang'?((substr($_SERVER['REQUEST_URI'],(strpos($_SERVER['REQUEST_URI'], 'min')-12),3)=='css'?'css':'').'/'.substr($_SERVER['REQUEST_URI'],(strpos($_SERVER['REQUEST_URI'], 'min')-8),2).'/'):'';
$min_language_code = trim($in_language, '/');
if ($is_mobilesite) {
	define('DEFAULT_CSS','//includes/templates/mobilesite/'.$in_language.'css/');
	define('DEFAULT_JS','//includes/templates/mobilesite/jscript/');
	define('DEFAULT_MOD','//includes/modules/pages/');
}else{
	define('DEFAULT_CSS','//includes/templates/cherry_zen/'.$in_language.'css/');
	define('DEFAULT_JS','//includes/templates/cherry_zen/jscript/');
	define('DEFAULT_MOD','//includes/modules/pages/');
}
// setup include path
set_include_path($min_libPath . PATH_SEPARATOR . get_include_path());

require 'Minify.php';

Minify::$uploaderHoursBehind = $min_uploaderHoursBehind;
Minify::setCache(
    isset($min_cachePath) ? $min_cachePath : ''
    ,$min_cacheFileLocking
);

if ($min_documentRoot) {
    $_SERVER['DOCUMENT_ROOT'] = $min_documentRoot;
    Minify::$isDocRootSet = true;
}

$min_serveOptions['minifierOptions']['text/css']['symlinks'] = $min_symlinks;
// auto-add targets to allowDirs
foreach ($min_symlinks as $uri => $target) {
    $min_serveOptions['minApp']['allowDirs'][] = $target;
}

if ($min_allowDebugFlag) {
    require_once 'Minify/DebugDetector.php';
    $min_serveOptions['debug'] = Minify_DebugDetector::shouldDebugRequest($_COOKIE, $_GET, $_SERVER['REQUEST_URI']);
}

if ($min_errorLogger) {
    require_once 'Minify/Logger.php';
    if (true === $min_errorLogger) {
        require_once 'FirePHP.php';
        $min_errorLogger = FirePHP::getInstance(true);
    }
    Minify_Logger::setLogger($min_errorLogger);
}

// check for URI versioning
if (preg_match('/&\\d/', $_SERVER['QUERY_STRING'])) {
    $min_serveOptions['maxAge'] = 31536000;
}
if (isset($_GET['g'])) {
    // well need groups config
    $min_serveOptions['minApp']['groups'] = (require MINIFY_MIN_DIR . '/groupsConfig.php');
    if ($is_mobilesite) {
    	$min_serveOptions['minApp']['groups'] = (require MINIFY_MIN_DIR . '/groupsConfigMobile.php');
    }
}
if (isset($_GET['f']) || isset($_GET['g'])) {
    // serve!

    if (! isset($min_serveController)) {
        require 'Minify/Controller/MinApp.php';
        $min_serveController = new Minify_Controller_MinApp();
    }
    Minify::serve($min_serveController, $min_serveOptions);

} elseif ($min_enableBuilder) {
    header('Location: builder/');
    exit();
} else {
    header("Location: /");
    exit();
}