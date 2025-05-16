<?php

namespace Geekbrains\Application1;

class Application {

    private const APP_NAMESPACE = 'Geekbrains\Application1\Controllers\\';

    private string $controllerName;
    private string $methodName;


   public function run() : string {
    $routeArray = explode('/', $_SERVER['REQUEST_URI']);

    if (isset($routeArray[1]) && $routeArray[1] !== '') {
        $controllerName = $routeArray[1];
    } else {
        $controllerName = "page";
    }

    $this->controllerName = self::APP_NAMESPACE . ucfirst($controllerName) . "Controller";

    if (class_exists($this->controllerName)) {
        if (isset($routeArray[2]) && $routeArray[2] !== '') {
            $methodName = $routeArray[2];
        } else {
            $methodName = "index";
        }

        $this->methodName = "action" . ucfirst($methodName);

        if (method_exists($this->controllerName, $this->methodName)) {
            $controllerInstance = new $this->controllerName();
            return call_user_func_array([$controllerInstance, $this->methodName], []);
        } else {
            // Метод не существует — рендерим 404
            return $this->render404();
        }
    } else {
        // Класс контроллера не найден — рендерим 404
        return $this->render404();
    }
}

private function render404(): string
{
    http_response_code(404);

    $errorControllerClass = self::APP_NAMESPACE . 'ErrorController';
    if (class_exists($errorControllerClass)) {
        $errorController = new $errorControllerClass();
        if (method_exists($errorController, 'action404')) {
            return $errorController->action404();
        }
    }

    // Если контроллер ошибки не найден — просто вернем текст
    return 'Ошибка 404 — страница не найдена';
}


}