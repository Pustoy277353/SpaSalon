<?php

function getUsersList(){
    $users = require __DIR__ . '/db_users.php';
    return $users;
};

function existsUser(string $login): bool {

    $users = getUsersList();

    foreach ($users as $user){
        if ($user['login'] === $login) {
            return true;
        }
    }
    return false;
}

function checkPassword($login, $password): bool {
    $users = getUsersList();


    foreach ($users as $user){
        if ($user['login'] === $login && $user['password'] === md5($password)) {
            return true;
        }
    }
    return false;
}

function getCurrentUser(): ?string {
    $loginFromSession = $_SESSION['login'] ?? null;
    $passwordFromSession = $_SESSION['password'] ?? null;
    if (checkPassword($loginFromSession, $passwordFromSession)){
        return $loginFromSession;
    }
    return null;
}