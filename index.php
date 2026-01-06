<?php
define('APP_INSTS', 'Y');    // will be used to avoid the direct access as well
define('DS', DIRECTORY_SEPARATOR);
define('ADMIN', 'N');
define('ROOT', dirname(__FILE__));
define('VERSION', '1.0.0');
$DEV_MODE = 1;
if ($DEV_MODE == 1) {
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    error_reporting(E_ALL ^ E_NOTICE);
} else {
    error_reporting(0);
}
//echo ROOT . DS .'includes' . DS . 'bootstrip.php'; exit;
require_once (ROOT . DS . 'includes' . DS . 'bootstrip.php');

//echo $registry; exit;
$cores = new router($registry);  // create the application entry and run it!
//echo '<pre>'; print_r($cores); exit;
$cores->run();
$response->output();