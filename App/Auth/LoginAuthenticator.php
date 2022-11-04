<?php

namespace App\Auth;

use App\Core\DB\Connection;
use Exception;

class LoginAuthenticator extends DummyAuthenticator
{
    function login($login, $password): bool
    {
        $sql = "SELECT login, password FROM users WHERE login = ?";

        $query = Connection::connect()->prepare($sql);
        $query->execute([$login]);

        $fetchedData = $query->fetch();

        if($fetchedData['login'] == $login && password_verify($password, $fetchedData['password'])) {
            setcookie('user', $fetchedData['login'], time() + 7*24*60*60);
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
        // the same as isset($_COOKIE['user']) ? $_COOKIE['user'] : throw new \Exception("User not logged in")
        return $_COOKIE['user'] ?? throw new Exception("User not logged in");
    }

    function isLogged(): bool
    {
        return isset($_COOKIE['user']) && !empty($_COOKIE['user']);
    }


}