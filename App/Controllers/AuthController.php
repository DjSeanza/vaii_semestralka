<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\DB\Connection;
use App\Core\Responses\Response;
use App\Core\Responses\ViewResponse;
use public\errors\Errors;

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

    public function sign_up() {

    }

    public function log_in(): Response {
        $data = $this->app->getRequest()->getPost();

        if(isset($data['submit']) && isset($data['login']) && isset($data['password'])) {
            $login = $data['login'];
            $password = $data['password'];

            $isLogged = $this->app->getAuth()->login($login, $password);

            if($isLogged) {
                return $this->redirect('?c=home');
            }
        }

        return $this->redirect('?c=auth&a=login&e=' . Errors::LOGIN_FAILED->value);
    }

    public function logout(): Response {
        $this->app->getAuth()->logout();

        return $this->redirect("?c=auth");
    }
}