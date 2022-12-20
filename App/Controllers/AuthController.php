<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\DB\Connection;
use App\Core\Responses\Response;
use App\Core\Responses\ViewResponse;
use App\Models\User;
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
            $isUploaded = $this->uploadImage($data['login']);

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

    private function uploadImage($userLogin): Errors|string {
        // TODO ak uploaduje dalsiu fotku, tak predoslu dat do nejakeho ineho suboru
        $fileTargetDirectory = $this->getImageDirectory($userLogin);

        if (file_exists($fileTargetDirectory)) {
            return Errors::UNEXPECTED_ERROR;
        }

        $imageExtension = strtolower(pathinfo($_FILES["profile-picture"]["name"],PATHINFO_EXTENSION));
        if($imageExtension != "jpeg" && $imageExtension != "jpg"
            && $imageExtension != "png" && $imageExtension != "svg" ) {
            return Errors::WRONG_FILE_FORMAT;
        }

        if ($_FILES["profile-picture"]["size"] > 500_000_000) { // 500 000 000B = 5MB
            return Errors::FILE_TOO_LARGE;
        }

        if (move_uploaded_file($_FILES["profile-picture"]["tmp_name"], $fileTargetDirectory)) {
            return $fileTargetDirectory;
        } else {
            return Errors::FILE_NOT_UPLOADED;
        }
    }

    private function getImageDirectory(string $userLogin): string {
        $imageExtension = pathinfo($_FILES["profile-picture"]["name"],PATHINFO_EXTENSION);
        $randomString = substr(
            str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz", 5)
            ), 0, 5);
        $directoryToUpload = "public/uploads/users/" . $userLogin . "/";

        if (!is_dir($directoryToUpload) && !mkdir($directoryToUpload)){
            die("Nepodarilo sa vytvoriť súbor: $directoryToUpload");
        }

        return $directoryToUpload .strtotime("now") . "_" . $randomString . "." . $imageExtension;
    }
}