<?php

namespace public\errors;

class ErrorToast
{
    private array $get;
    private static $errorToast;

    private function __construct(array $get) {
        $this->get = $get;
    }

    public static function getInstance(array $get) {
        if (self::$errorToast == null) {
            self::$errorToast = new ErrorToast($get);
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
            }
        } else if ($this->isSuccess()){
            $toast = '<script>toastSuccess("Registrácia úspešná", "Úspešne ste sa zaregistrovali.")</script>';
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