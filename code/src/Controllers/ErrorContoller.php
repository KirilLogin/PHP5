<?php

use Geekbrains\Application1\Render;

$render = new Render();

if ($controllerNotFound) {
    // Вывод 404 страницу
    echo $render->renderErrorPage();
    exit;
}