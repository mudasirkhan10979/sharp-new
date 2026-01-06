<?php
// Version
define('VERSION', '2.0.2.0');
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('ADMIN','A');
define('HTTP_SERVER', 'http://'.$_SERVER['SERVER_NAME'].'/boffice/');
define('HTTP_CATALOG', 'http://'.$_SERVER['SERVER_NAME'].'/');
define('APP_INSTS', '1');
define('DIR_SYSTEM', '../includes/');

// Startup
require_once(DIR_SYSTEM . 'bootstrip.php');
$cores = new router($registry);

$cores->run();
$response->output(); // Output