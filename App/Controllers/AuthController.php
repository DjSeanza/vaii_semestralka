<?php

namespace App\Controllers;

use App\Auth\DummyAuthenticator;
use App\Core\AControllerBase;
use App\Core\DB\Connection;
use App\Core\Responses\Response;
use App\Core\Responses\ViewResponse;

class AuthController extends AControllerBase
{

    public function index(): Response
    {
        return $this->redirect("?c=auth&a=login");
    }

    public function login(): ViewResponse
    {
        return $this->html();
    }

    public function register(): ViewResponse
    {
        return $this->html();
    }

    public function log_in() {
        $data = $this->app->getRequest()->getPost();

        if(isset($data['submit']) && isset($data['login']) && isset($data['password'])) {
            $login = $data['login'];
            $password = $data['password'];

            $isLogged = $this->app->getAuth()->login($login, $password);

            if($isLogged) {
                return $this->redirect('?c=home');
            }
        }

        // TODO ak sa nepodari prihlasit
        return $this->redirect('?c=auth');
    }

    public function logout(): Response {
        $this->app->getAuth()->logout();

        return $this->redirect("?c=auth");
    }
}