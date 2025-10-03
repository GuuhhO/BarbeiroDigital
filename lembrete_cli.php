<?php
// Mostrar erros (opcional, útil para cron/log)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclui apenas o necessário
define('BASE_PATH', __DIR__);
define('APP_PATH', BASE_PATH . '/app');

require_once APP_PATH . '/db.php';
require_once APP_PATH . '/helper.php';
require_once APP_PATH . '/session.php';

// Inclua diretamente o controller do lembrete
require_once APP_PATH . '/controllers/LembreteController.php';

// Instancia e chama apenas a função de back-end
$controller = new LembreteController();
$controller->avisarClienteHorario();

echo "Lembretes enviados!\n";
