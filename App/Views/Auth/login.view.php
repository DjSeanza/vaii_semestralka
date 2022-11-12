<main class="login-main">
    <div class="login-bg"></div>
    <div class="login-bg-color"></div>
    <div class="login-form-div">
        <h1>Prihlásenie</h1>
        <?php if(isset($_COOKIE['user'])) {echo "Hello, " . $_COOKIE['user'];} ?>
        <form action="?c=auth&a=logout" method="post">
            <input type="hidden" name="signout" value="signout">
            <button type="submit">Odhlas</button>
        </form>
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
