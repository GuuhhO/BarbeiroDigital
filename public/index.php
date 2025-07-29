<?php

// Ativa erros (só em dev)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Definir constantes de caminho — corrigindo para apontar para pasta app corretamente
define('BASE_PATH', dirname(__DIR__)); // assume que public/ está dentro da raiz, então sobe uma pasta
define('APP_PATH', BASE_PATH . '/app');
define('VIEW_PATH', APP_PATH . '/views');
define('CONTROLLER_PATH', APP_PATH . '/controllers');

// Agora sim, inclui o roteador

require_once APP_PATH . '/helper.php';
require_once APP_PATH . '/router.php';


$router = new Router();
$router->run();
