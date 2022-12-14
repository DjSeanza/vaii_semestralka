<?php
/** @var array $data */
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
                <input type="text" id="username" name="login" pattern="^[A-Za-z][A-Za-z0-9_]{4,29}$" placeholder="Používateľské meno" required>
            </div>
            <div class="form-input-image-div">
                <label for="password" class="input-image-div">
                    <img src="public/images/Icons/password-lock.svg" alt="">
                </label>
                <input type="password" id="password" minlength="8" maxlength="64" name="password" placeholder="Heslo" required>
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
