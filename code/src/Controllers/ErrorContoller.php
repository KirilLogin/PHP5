<?php

use Geekbrains\Application1\Render;

$render = new Render();

if ($controllerNotFound) {
    // Выводим 404 страницу и завершаем скрипт
    echo $render->renderErrorPage();
    exit;
}