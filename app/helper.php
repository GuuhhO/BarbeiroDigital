<?php

function view(string $viewName, array $data = []) {
    extract($data); // Torna variáveis acessíveis na view
    $viewFile = VIEW_PATH . '/' . $viewName . '.php';

    if (!file_exists($viewFile)) {
        http_response_code(500);
        echo "View '$viewName' não encontrada.";
        exit;
    }

    // Captura o conteúdo da view
    ob_start();
    require $viewFile;
    $content = ob_get_clean();

    // Carrega o layout padrão e injeta $content
    require VIEW_PATH . '/layout/default.php';
}
