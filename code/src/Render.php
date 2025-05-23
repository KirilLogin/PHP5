<?php

namespace Geekbrains\Application1;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class Render {

    private string $viewFolder = '/src/Views/';
    private FilesystemLoader $loader;
    private Environment $environment;


    public function __construct(){

        $this->loader = new FilesystemLoader(dirname(__DIR__) . $this->viewFolder);
        $this->environment = new Environment($this->loader, [
           // 'cache' => $_SERVER['DOCUMENT_ROOT'].'/cache/',
        ]);
    }

    public function renderPage(string $contentTemplateName = 'page-index.twig', array $templateVariables = []) {
        $template = $this->environment->load('main.twig');
        
        $templateVariables['content_template_name'] = $contentTemplateName;
        $templateVariables['title'] = 'имя страницы';
        $templateVariables['current_time'] = date('H:i:s'); // текущие часы:минуты:секунды

        return $template->render($templateVariables);
    }

    public function renderErrorPage(string $message = 'Страница не найдена') {
    http_response_code(404);
    return $this->environment->render('error.twig', [
        'message' => $message,
        'title' => 'Ошибка 404'
    ]);
}
}
