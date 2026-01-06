<?php

error_reporting(E_ALL);

ini_set('display_errors', 1);

ini_set('session.gc_maxlifetime', 84600);

ini_set('session.gc_probability', 1);

ini_set('session.gc_divisor', 1);

error_reporting(E_ERROR | E_WARNING | E_PARSE);
####################################################
#	SpiralClick Custom Framework Based web App     #
####################################################
// check to avoid the direct access
if (!defined('APP_INSTS'))
    exit('No direct script access allowed');
#General Setting  -  Set maximum memory limit, maximum time limit for script execution
@ini_set('memory_limit', '256M');
@set_time_limit(3600);
/* if (!ini_get('date.timezone')) {
  date_default_timezone_set('UTC');
  } */

date_default_timezone_set('Asia/Dubai');
// date_default_timezone_set('Asia/Dubai');
//General Check
if (version_compare(phpversion(), '5.1.0', '<') == TRUE) { // Check Version
    exit('Application required atleast -----PHP5.1+');
}


$urlpath = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));
if ($urlpath[0] == "") {
    $lng = 'en';
    $directory = "english";
} elseif ($urlpath[0] == "en") {
    $lng = 'en';
    $directory = "english";
} elseif ($urlpath[0] == "ar") {
    $lng = 'ar';
    $directory = "arabic";
} else {
    $lng = 'en';
    $directory = "english";
}

#
# MAIN APPLICATION SETTINGS based in the settings
#
//Define all directories with trailing slash
$http = 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . '/';
$imghttp = 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . '/';
define('BASE_URL', $http);
if (strpos($_SERVER['REQUEST_URI'], 'admin')) {
} else {
    if ($lng != 'en') {
        $http = $http . $lng . '/';
    }
}
define('HTTP_HOST', $http);
define('HTTPS_HOST', $http);
define('SITE_HOST', $http);
define('DIR_INC', ROOT . '/includes/');
define('DIR_DOWNLOAD', ROOT . '/downloads/');
define('DIR_UPLOAD', ROOT . '/uploads/');
define('DIR_FILEMANAGER', ROOT . '/uploads/media/');
define('DIR_IMAGE', DIR_UPLOAD . 'image/'); 
define('DIR_LOGS', ROOT . '/vars/logs/');
define('DIR_BLOCKS', ROOT . '/vars/blocks/'); 
define('DIR_CACHE', ROOT . '/includes/cache/');
define('DIR_YOTI', ROOT . '/yoti/');
define('DIR_SOCIAL', ROOT . '/includes/libs/social/');
define('DIR_ETEMPLATE', ROOT . '/themes/email-templates/');
define('DIR_EMAIL', '/var/www/sdomains/ecoms/betest01.scdwapps.com/public_html/emails/'); 

define('DIR_IMAGE_PATH', HTTPS_HOST.'uploads/image/'); 

//define('DIR_EMAIL_PATH', HTTP_HOST.'themes/emails/'); 
//define('DIR_IMAGE_PATH', HTTP_HOST.'uploads/image/'); 


$url = $_SERVER['REQUEST_URI'];
$url = preg_replace('/\?.*/', '', $url); 
$url=ltrim(rtrim($url,"/"),"/");

if(ADMIN == 'A'){//Back end language
    define('DIR_APP', ROOT . '/admin/');
    define('DIR_LANGUAGE', ROOT . '/vars/lang/be/');
    define('DIR_TEMPLATE', ROOT . '/themes/admin/template/');
}else { //Front end language
    define('DIR_LANGUAGE', ROOT . '/vars/lang/fe/' . $directory);
    define('DIR_TEMPLATE', ROOT . '/themes/');
    define('DIR_APP', ROOT . '/apps/');
    // define('DIR_LANGUAGE', ROOT . '/vars/lang/fe/' . $directory);
}
#
# General setting
#		- Register Globals
#		- Magic Quotes Fix
#		- Windows IIS Compatibility
#
if (ini_get('register_globals')) {
    ini_set('session.use_cookies', 'On');
    ini_set('session.use_trans_sid', 'Off');
    session_set_cookie_params(0, '/');
    session_start();
    $globals = array($_REQUEST, $_SESSION, $_SERVER, $_FILES);
    foreach ($globals as $global) {
        foreach (array_keys($global) as $key) {
            unset(${$key});
        }
    }
}
if (ini_get('magic_quotes_gpc')) {

    function clean($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[clean($key)] = clean($value);
            }
        } else {
            $data = stripslashes($data);
        }
        return $data;
    }

    $_GET = clean($_GET);
    $_POST = clean($_POST);
    $_REQUEST = clean($_REQUEST);
    $_COOKIE = clean($_COOKIE);
}
if (!isset($_SERVER['DOCUMENT_ROOT'])) {
    if (isset($_SERVER['SCRIPT_FILENAME'])) {
        $_SERVER['DOCUMENT_ROOT'] = str_replace('\\', '/', substr($_SERVER['SCRIPT_FILENAME'], 0, 0 - strlen($_SERVER['PHP_SELF'])));
    }
}
if (!isset($_SERVER['DOCUMENT_ROOT'])) {
    if (isset($_SERVER['PATH_TRANSLATED'])) {
        $_SERVER['DOCUMENT_ROOT'] = str_replace('\\', '/', substr(str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']), 0, 0 - strlen($_SERVER['PHP_SELF'])));
    }
}
if (!isset($_SERVER['REQUEST_URI'])) {
    $_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'], 1);
    if (isset($_SERVER['QUERY_STRING'])) {
        $_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
    }
}
if (!isset($_SERVER['HTTP_HOST'])) {
    $_SERVER['HTTP_HOST'] = getenv('HTTP_HOST');
}

#  Main Bootstrap File
require_once (ROOT . DS . 'includes' . DS . 'db_config.php');
//Core Engine
require_once(DIR_INC . 'core/registry.php');
require_once(DIR_INC . 'core/router.php');
require_once(DIR_INC . 'core/controller.php');
require_once(DIR_INC . 'core/model.php');


// Common classes
require_once(DIR_INC . 'classes/config.php');
require_once(DIR_INC . 'classes/language.php');
require_once(DIR_INC . 'classes/db.php');
require_once(DIR_INC . 'classes/log.php');
require_once(DIR_INC . 'classes/document.php');
require_once(DIR_INC . 'classes/response.php');
require_once(DIR_INC . 'classes/request.php');
require_once(DIR_INC . 'classes/mail.php');
//require_once(DIR_INC . 'classes/icvSoap.php');
require_once(DIR_INC . 'classes/session.php');
require_once(DIR_INC . 'classes/cache.php');
require_once(DIR_INC . 'classes/pagination.php');
require_once(DIR_INC . 'classes/template.php');
require_once(DIR_INC . 'classes/sgrid.php');
require_once(DIR_INC . 'classes/api.php');
// require_once(DIR_INC . 'classes/cart.php');




//require_once(DIR_INC . 'classes/url.php'); 
//New Files added from OC
if(ADMIN == 'A'){
    require_once(DIR_INC . 'classes/user.php');
} 
else if(ADMIN == 'AF'){
    require_once(DIR_INC . 'classes/affiliate.php');
} 
else {
    require_once(DIR_INC . 'classes/customer.php');
} 
require_once(DIR_INC . 'helper/utf8.php');
require_once(DIR_INC . 'classes/image.php'); 
require_once(DIR_INC . 'library/PhpXlsxGenerator.php'); 

//Do all loading and creations
$slog_data = array();
$registry = new Registry();  // Registry
$registry->set('pcUrls', $_SERVER['REQUEST_URI']); //save the current url
$registry->set('c_p_index', '1'); //save default page index
//echo DB_USERNAME.'==='.DB_PASSWORD.'=='.DB_DATABASE; exit;
$db = new myDB(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE); // Database
$registry->set('db', $db);
$config = new Config(); // Config
$registry->set('config', $config);

//slog data
$registry->set('slog_data', $slog_data);  // slog information based on it to fetch the data on listing and cms etc 
// Settings
$crws = $db->query("SELECT * FROM " . DB_PREFIX . "setting");
foreach ($crws->rows as $srs) {
    $config->set($srs['key'], $srs['value']);
}


// languages 
$query = $db->query("SELECT * FROM language WHERE `status` = '1' ORDER BY `sort_order`, `name`");
$languages =array();
foreach ($query->rows as $result) {
    $languages[$result['code']] = [
        'language_id' => $result['language_id'],
        'name'        => $result['name'],
        'code'        => $result['code'],
        'locale'      => $result['locale'],
        'image'       => $result['image'],
        'directory'   => $result['directory'],
        'sort_order'  => $result['sort_order'],
        'status'      => $result['status']
    ];
}
$language_codes = array_column($languages, 'language_id', 'code');
$config->set('config_language', $lng);
// echo "<pre>";print_r($config->get('config_language'));exit;

//$registry->set('config', $config);
$log = new Log($config->get('config_error_filename'));
$registry->set('log', $log);
set_error_handler('error_handler');

$request = new Request(); // Request
$registry->set('request', $request);
$response = new Response(); // Response
$response->addHeader('Content-Type: text/html; charset=utf-8');
$response->setCompression($config->get('config_compression'));
$registry->set('response', $response); // Cache
$registry->set('cache', new Cache());
$session = new Session(); // Session
$registry->set('session', $session);
$registry->set('document', new Document()); // Document
// $cart = new Cart($registry);
// $registry->set('cart', $cart);
//$registry->set('url', new Url($config->get('site_url'), $config->get('site_ssl')));

// Language Detection
$detect = '';
if (isset($request->server['HTTP_ACCEPT_LANGUAGE']) && ($request->server['HTTP_ACCEPT_LANGUAGE'])) {
    $browser_languages = explode(',', $request->server['HTTP_ACCEPT_LANGUAGE']);
    foreach ($browser_languages as $browser_language) {
        foreach ($languages as $key => $value) {
            $locale = explode(',', $value['locale']);
            if (in_array($browser_language, $locale)) {
                $detect = $key;
            }
        }
    }
}
if (isset($_GET['language']) && array_key_exists($_GET['language'], $language_codes)) {
    $code = $_GET['language'];
} elseif (isset($session->data['language']) && array_key_exists($session->data['language'], $language_codes)) {
    $code = $session->data['language'];
} elseif (isset($request->cookie['language']) && array_key_exists($request->cookie['language'], $language_codes)) {
    $code = $request->cookie['language'];
} elseif ($detect) {
    $code = $detect;
} else {
    $code = $config->get('config_language');
}
if (!isset($session->data['language']) || $session->data['language'] != $code) {
    $session->data['language'] = $code;
}
if (!isset($request->cookie['language']) || $request->cookie['language'] != $code) {
    setcookie('language', $code, time() + 60 * 60 * 24 * 30, '/', $request->server['HTTP_HOST']);
}

$session->data['lang'] = $lng;

$language = new Language($registry);
$language->load($languages[$lng]['directory']);
$config->set('config_language_id', $language_codes[$lng]);
$registry->set('language', $language);


if(ADMIN == 'A'){
    $registry->set('user', new User($registry));
}else if(ADMIN == 'AF'){
    $registry->set('affiliate', new Affiliate($registry));
} 
else {
    $registry->set('customer', new Customer($registry));
}  
 
if($config->get('config_payment_stripe_status')=='1'){
    if($config->get('config_payment_stripe_environment')=='live'){
        $strip_public_key = $config->get('config_payment_stripe_live_public_key');
        $stripe_secret_key = $config->get('config_payment_stripe_live_secret_key');
    }else{
        $strip_public_key = $config->get('config_payment_stripe_test_public_key');
        $stripe_secret_key = $config->get('config_payment_stripe_test_secret_key');
    }
}else{
    $strip_public_key = '';
    $stripe_secret_key = '';
}

define('STRIPE_API_KEY', $stripe_secret_key); 
define('STRIPE_PUBLISHABLE_KEY', $strip_public_key);


function error_handler($errno, $errstr, $errfile, $errline) {
    global $config, $log;
    switch ($errno) {
        case E_NOTICE:
        case E_USER_NOTICE:
            $error = 'Notice';
            break;
        case E_WARNING:
        case E_USER_WARNING:
            $error = 'Warning';
            break;
        case E_ERROR:
        case E_USER_ERROR:
            $error = 'Fatal Error';
            break;
        default:
            $error = 'Unknown';
            break;
    }
    if ($config->get('config_error_display')) {
        echo '<b>' . $error . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
    }

    if ($config->get('config_error_log')) {
        $log->write('PHP ' . $error . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
    }
    return TRUE;
}

