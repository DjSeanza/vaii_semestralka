<?php

namespace App\Auth;

use App\Core\DB\Connection;
use App\Models\User;
use Exception;

class LoginAuthenticator extends DummyAuthenticator
{
    function login($login, $password): bool
    {
        $sql = "SELECT login, password, id FROM users WHERE login = ?";

        $query = Connection::connect()->prepare($sql);
        $query->execute([$login]);

        $fetchedData = $query->fetch();

        if($fetchedData['login'] == $login && password_verify($password, $fetchedData['password'])) {
            setcookie('user', $fetchedData['id'], time() + 7*24*60*60);
            return true;
        }

        return false;
    }

    function logout(): void
    {
        if(self::isLogged()) {
            unset($_COOKIE['user']);
            setcookie('user', '', time() - 3600);
        }
    }

    /**
     * @throws Exception
     */
    function getLoggedUserName(): string
    {
        $user = User::getOne($_COOKIE['user']);

        if (!$user) {
            throw new Exception("User not logged in");
        }

        return $user->getLogin();
    }

    function getLoggedUserId(): int {
        return $_COOKIE['user'];
    }

    function isLogged(): bool
    {
        return isset($_COOKIE['user']) && !empty($_COOKIE['user']);
    }


}