<?php

namespace Geekbrains\Application1\Controllers;

use Geekbrains\Application1\Render;
use Geekbrains\Application1\Models\User;

class UserController {

    public function actionAddUser() {
        return "Тут добавляется юзер";
    }

    public function actionIndex() {
        $users = User::getAllUsersFromStorage();
        
        $render = new Render();

        if(!$users){
            return $render->renderPage(
                'user-empty.twig',
                [
                    'title' => 'Список пользователей в хранилище',
                    'message' => "Список пуст или не найден"
                ]);
        }
        else{
            return $render->renderPage(
                'user-index.twig',
                [
                    'title' => 'Список пользователей в хранилище',
                    'users' => $users
                ]);
        }
    }

    // Новый метод для сохранения пользователя через GET
    public function actionSave() {
        $render = new Render();

        // Получаем параметры из GET
        $name = $_GET['name'] ?? null;
        $birthday = $_GET['birthday'] ?? null;

        if (!$name || !$birthday) {
            return $render->renderPage(
                'user-save-result.twig',
                [
                    'title' => 'Ошибка сохранения',
                    'message' => 'Не передано имя или дата рождения'
                ]
            );
        }

        // Создаем пользователя
        $birthdayTimestamp = strtotime($birthday); // или (new \DateTime($birthday))->getTimestamp()
        $user = new User($name, $birthdayTimestamp);

        // Сохраняем пользователя (предполагаем, что есть метод saveUserToStorage)
        $result = User::saveUserToStorage($user);

        // Формируем сообщение в зависимости от результата
        $message = $result ? "Пользователь успешно сохранён" : "Ошибка при сохранении пользователя";

        return $render->renderPage(
            'user-save-result.twig',
            [
                'title' => 'Сохранение пользователя',
                'message' => $message
            ]
        );
    }
}