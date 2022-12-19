<?php
/** @var array $data */

use public\errors\Errors;

if (isset($_GET['e'])) {
    if ($_GET['e'] == Errors::LOGIN_FAILED->value) {
        include "App/Components/toast/toast.php";
        echo '<script src="public/js/toast/toast.js"></script>';
        echo '<script>toastError("Neúspešné prihlásenie", "Zadali ste zlé meno alebo heslo.")</script>';
    }
}
?>

<main class="login-main">
    <div class="login-bg"></div>
    <div class="login-bg-color"></div>
    <div class="login-form-div">
        <h1>Prihlásenie</h1>
        <form action="?c=auth&a=log_in" method="post" class="login-form">
            <div class="form-input-image-div">
                <label for="username" class="input-image-div">
                    <img src="public/images/Icons/user-image.png" alt="">
                </label>
                <input type="text" id="username" name="login" maxlength="64" placeholder="Používateľské meno" required>
            </div>
            <div class="form-input-image-div">
                <label for="password" class="input-image-div">
                    <img src="public/images/Icons/password-lock.svg" alt="">
                </label>
                <input type="password" id="password" maxlength="64" name="password" placeholder="Heslo" required>
            </div>
            <button type="submit" class="button" name="submit">
                Prihlásiť
            </button>
        </form>
        <div class="login-register-question">
            <span>Ešte nemáte účet? <a href="?c=auth&a=register">Zaregistrujte sa</a></span>
        </div>
    </div>
</main>
