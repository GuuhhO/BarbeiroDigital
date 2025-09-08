<?php

class Router
{
    public function run()
    {
        $url = $_GET['url'] ?? 'home/index';
        $url = explode('/', filter_var(rtrim($url, '/'), FILTER_SANITIZE_URL));

        $controllerName = ucfirst($url[0]) . 'Controller';
        $action = $url[1] ?? 'index';

        $controllerFile = CONTROLLER_PATH . "/$controllerName.php";

        if (file_exists($controllerFile)) {
            require_once $controllerFile;

            if (class_exists($controllerName)) {
                $controller = new $controllerName();

                if (method_exists($controller, $action)) {
                    $controller->$action();
                    return;
                }
            }
        }

        http_response_code(404);

        $errorPage = BASE_PATH . "/404.php";
        if (file_exists($errorPage)) {
            require $errorPage;
        } else {
            echo "Página não encontrada.";
        }
    }
}
