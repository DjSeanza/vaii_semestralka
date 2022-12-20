<?php
/** @var array $data */

use public\errors\Errors;

if (isset($_GET['e'])) {
    include "App/Components/toast/toast.php";
    echo '<script src="public/js/toast/toast.js"></script>';
    switch ($_GET['e']) {
        case Errors::REGISTER_FAILED->value:
            echo '<script>toastError("Neúspešná registrácia", "Údaje neboli zadané alebo boli zadané zle.")</script>';
            break;
        case Errors::UNEXPECTED_ERROR->value:
            echo '<script>toastError("Neočakávaná chyba", "Ľutujeme, ale stala sa neočakávaná chyba.")</script>';
            break;
        case Errors::WRONG_FILE_FORMAT->value:
            echo '<script>toastError("Zlý formát", "Nahrávajte prosím súbory len s formátom jpg, jpeg, png alebo svg.")</script>';
            break;
        case Errors::FILE_NOT_UPLOADED->value:
            echo '<script>toastError("Súbor nenahratý", "Ľutujeme, ale súbor sa nenahral. Prosím skúste to ešte raz.")</script>';
            break;
        case Errors::FILE_TOO_LARGE->value:
            echo '<script>toastError("Súbor nenahratý", "Váš súbor je príliš veľký. Maximálna veľkosť súboru je 5MB.")</script>';
            break;
        case Errors::USERNAME_EXISTS->value:
            echo '<script>toastError("Používateľské meno existuje", "Ľutujeme, toto používateľské meno už existuje.")</script>';
            break;
    }
}
?>

<main class="register-main">
    <div class="register-bg"></div>
    <div class="register-bg-color"></div>
    <div class="register-form-div">
        <h1>Registrácia</h1>
        <form action="?c=auth&a=storeUser" method="post" class="register-form" enctype="multipart/form-data">
            <div class="form-input-image-div">
                <label for="username" class="input-image-div">
                    <img src="public/images/Icons/user-image.png" alt="">
                </label>
                <input type="text" id="username" name="login" pattern="^[A-Za-z][A-Za-z0-9_]{4,29}$" placeholder="Používateľské meno" required>
            </div>
            <div class="form-input-image-div">
                <label for="password" class="input-image-div">
                    <img src="public/images/Icons/password-lock.svg" alt="">
                </label>
                <input type="password" id="password" minlength="8" maxlength="64" name="password" placeholder="Heslo" required>
            </div>
            <div class="form-input-image-div">
                <label for="email" class="input-image-div">
                    <img src="public/images/Icons/password-lock.svg" alt="">
                </label>
                <input type="email" id="email" maxlength="100" name="email" placeholder="Email" required>
            </div>
            <div class="form-input-image-div">
                <label for="profile-pic" class="input-image-div">
                    <img src="public/images/Icons/password-lock.svg" alt="">
                </label>
                <label for="profile-pic" id="file-label">
                    <span id="file-name">Vyberte profilový obrázok...</span>
                    <input type="file" id="profile-pic" accept="image/jpeg, image/jpg, image/png, image/svg" name="profile-picture" hidden>
                </label>
            </div>
            <button type="submit" class="button" name="submit">
                Zaregistrovať
            </button>
        </form>
        <div class="register-login-question">
            <span>Už máte účet? <a href="?c=auth&a=login">Prihláste sa</a></span>
        </div>
    </div>
</main>

<script>
    let input = document.querySelector("label#file-label input#profile-pic");
    let imageName = document.querySelector("label#file-label span#file-name");

    input.addEventListener("change", ()=>{
        imageName.innerText = input.files[0].name;
        document.querySelector("label#file-label").setAttribute("title", input.files[0].name);
    })
</script>
