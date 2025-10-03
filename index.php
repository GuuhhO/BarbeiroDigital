<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('BASE_PATH', __DIR__);
define('APP_PATH', BASE_PATH . '/app');
define('VIEW_PATH', APP_PATH . '/views');
define('CONTROLLER_PATH', APP_PATH . '/controllers');

define('BASE_URL', '/BarbeiroDigital/');

require_once APP_PATH . '/db.php';
require_once APP_PATH . '/router.php';
require_once APP_PATH . '/helper.php';
require_once APP_PATH . '/session.php';

$router = new Router();
$router->run();
