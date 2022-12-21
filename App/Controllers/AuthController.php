<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Core\Responses\ViewResponse;
use App\Models\User;
use public\errors\Errors;
use public\uploadFiles\FileDirectory;
use public\uploadFiles\FileType;
use public\uploadFiles\FileUpload;

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

    /**
     * @throws \Exception
     */
    public function storeUser() {
        $userId = $this->request()->getValue('uid');
        $data = $this->app->getRequest()->getPost();

        $user = ( $userId ? User::getOne($userId) : new User());

        if (isset($data['login']) && isset($data['password']) && isset($data['email'])) {
            if (User::getNumberOfUsersWithLogin($data['login']) > 0) {
                return $this->redirect('?c=auth&a=register&e=' . Errors::USERNAME_EXISTS->value);
            }

            $user->setAttributes($data['login'], password_hash($data['password'], PASSWORD_DEFAULT), $data['email']);
            $fileUpload = new FileUpload($_FILES['profile-picture'],
                FileDirectory::PROFILE_PICTURE,
                    FileType::PROFILE_PICTURE,
                            $data['login']);

            $isUploaded = $fileUpload->uploadFile();

            if ($isUploaded instanceof Errors) {
                return $this->redirect('?c=auth&a=register&e=' . $isUploaded->value);
            } else {
                $user->setProfilePicture($isUploaded);
            }

        } else {
            // TODO zmenit a=login pri update na nieco ine
            $url = ( $userId ?
                '?c=auth&a=login&e=' . Errors::UPDATE_USER_DATA_FAILED->value :
                '?c=auth&a=register&e=' . Errors::REGISTER_FAILED->value);
            return $this->redirect($url);
        }

        $user->save();
        return $this->redirect('?c=auth&a=login&s=1');
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