<?php

namespace public\toast;

use public\toast\Errors;
use public\toast\Successes;

class Toast
{
    private array $get;
    private static $errorToast;

    private function __construct(array $get) {
        $this->get = $get;
    }

    public static function getInstance(array $get) {
        if (self::$errorToast == null) {
            self::$errorToast = new Toast($get);
        }
        return self::$errorToast;
    }

    /**
     * @param array $get
     */
    public function setGet(array $get): void
    {
        $this->get = $get;
    }

    public function getToast(): string|null {
        $toast = null;
        if ($this->isError()) {
            switch ($this->get['e']) {
                case Errors::REGISTER_FAILED->value:
                    $toast = '<script>toastError("Neúspešná registrácia", "Údaje neboli zadané alebo boli zadané zle.")</script>';
                    break;
                case Errors::UNEXPECTED_ERROR->value:
                    $toast = '<script>toastError("Neočakávaná chyba", "Ľutujeme, ale stala sa neočakávaná chyba.")</script>';
                    break;
                case Errors::WRONG_FILE_FORMAT->value:
                    $toast = '<script>toastError("Zlý formát", "Nahrávajte prosím súbory len s formátom jpg, jpeg, png, svg alebo webp pre obrázky a mp4 pre videá.")</script>';
                    break;
                case Errors::FILE_NOT_UPLOADED->value:
                    $toast = '<script>toastError("Súbor nenahratý", "Ľutujeme, ale súbor sa nenahral. Prosím skúste to ešte raz.")</script>';
                    break;
                case Errors::FILE_TOO_LARGE->value:
                    $toast = '<script>toastError("Súbor nenahratý", "Váš súbor je príliš veľký. Maximálna veľkosť súboru je 5MB.")</script>';
                    break;
                case Errors::USERNAME_EXISTS->value:
                    $toast = '<script>toastError("Používateľské meno existuje", "Ľutujeme, toto používateľské meno už existuje.")</script>';
                    break;
                case Errors::VIDEO_NOT_FOUND->value:
                    $toast = '<script>toastError("Video nenájdené", "Ľutujeme, ale toto video sa nenašlo.")</script>';
                    break;
                case Errors::COMMENT_NOT_FOUND->value:
                    $toast = '<script>toastError("Komentár nenájdený", "Ľutujeme, ale tento komentár neexistuje.")</script>';
                    break;
                case Errors::UPDATE_USER_DATA_FAILED->value:
                    $toast = '<script>toastError("Nesprávne použivateľské dáta", "Ľutujeme, ale nepodarilo sa nám aktualizovať použivateľské dáta.")</script>';
                    break;
                case Errors::LOGIN_FAILED->value:
                    $toast = '<script>toastError("Prihlásenie zlyhalo", "Ľutujeme, ale nepodarilo sa prihlásiť. Skontrolujte si vaše údaje.")</script>';
                    break;
                case Errors::COMMENT_DETAILS_NOT_FOUND->value:
                    $toast = '<script>toastError("Nenájdené detaily komentára", "Ľutujeme, ale nepodarilo sa nám nájsť detaily komentára.")</script>';
                    break;
                case Errors::USER_NO_CONTENT->value:
                    $toast = '<script>toastError("Nenájdené videá", "Ľutujeme, ale ešte ste nenahrali žiadne videá.")</script>';
                    break;
                case Errors::CATEGORY_NOT_FOUND->value:
                    $toast = '<script>toastError("Kategória nenájdená", "Ľutujeme, ale takúto kategóriu sme u nás nenašli.")</script>';
                    break;
                case Errors::USER_NOT_FOUND->value:
                    $toast = '<script>toastError("Používateľ nenájdený", "Ľutujeme, ale takého používateľa sme u nás nenašli.")</script>';
                    break;
            }
        } else if ($this->isSuccess()){
            switch($this->get['s']) {
                case Successes::REGISTRATION->value:
                    $toast = '<script>toastSuccess("Registrácia úspešná", "Úspešne ste sa zaregistrovali.")</script>';
                    break;
                case Successes::CONTENT_ADDED->value:
                    $toast = '<script>toastSuccess("Video pridané", "Úspešne ste pridali video.")</script>';
                    break;
                case Successes::CONTENT_DELETED->value:
                    $toast = '<script>toastSuccess("Video odstránené", "Úspešne ste odstránili video.")</script>';
                    break;
                case Successes::USER_DELETED->value:
                    $toast = '<script>toastSuccess("Používateľ odstránený", "Úspešne ste odstránili používateľa.")</script>';
                    break;
                case Successes::CATEGORY_ADDED->value:
                    $toast = '<script>toastSuccess("Kategória pridaná", "Úspešne ste pridali kategóriu.")</script>';
                    break;
                case Successes::CATEGORY_DELETED->value:
                    $toast = '<script>toastSuccess("Kategória odstránená", "Úspešne ste odstránili kategóriu.")</script>';
                    break;
            }
        }

        return $toast;
    }

    public function isError(): bool {
        return isset($this->get['e']);
    }

    public function isSuccess(): bool {
        return isset($this->get['s']);
    }
}