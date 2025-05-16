<?php

namespace Geekbrains\Application1\Models;

class User {

    private ?string $userName;
    private ?int $userBirthday;

    private static string $storageAddress = '/storage/birthdays.txt';

    public function __construct(string $name = null, int $birthday = null){
        $this->userName = $name;
        $this->userBirthday = $birthday;
    }

    public function setName(string $userName) : void {
        $this->userName = $userName;
    }

    public function getUserName(): string {
        return $this->userName;
    }

    public function getUserBirthday(): int {
        return $this->userBirthday;
    }

    public function setBirthdayFromString(string $birthdayString) : void {
        $this->userBirthday = strtotime($birthdayString);
    }

   public static function getAllUsersFromStorage(): array|false {
    $address = $_SERVER['DOCUMENT_ROOT'] . User::$storageAddress;
    
    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "r");
        
        $users = [];
    
        while (!feof($file)) {
            $userString = trim(fgets($file)); // убираем пробелы и переносы
            
            if ($userString === '') {
                continue; // пропускаем пустые строки
            }
            
            $userArray = explode(",", $userString);

            if (count($userArray) < 2) {
                continue; // если данных меньше двух — пропускаем строку
            }
        
            $user = new User($userArray[0]);
            $user->setBirthdayFromString($userArray[1]);
            $users[] = $user;
        }
        
        fclose($file);
        return $users;
    }

    return false;
}

    public static function saveUserToStorage(User $user): bool
{
    $address = $_SERVER['DOCUMENT_ROOT'] . self::$storageAddress;

    // Формируем строку для записи: имя и дата рождения в формате d-m-Y
    $line = $user->getUserName() . ',' . date('d-m-Y', $user->getUserBirthday()) . PHP_EOL;

    // Пытаемся открыть файл в режиме дозаписи
    $file = fopen($address, 'a');

    if ($file === false) {
        return false;
    }

    $writeResult = fwrite($file, $line);

    fclose($file);

    return $writeResult !== false;
}
}
