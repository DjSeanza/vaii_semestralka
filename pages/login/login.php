<?php
require "../../paths.php";
require "../../components/head.php";
?>

<main class="login-main">
    <div class="login-bg"></div>
    <div class="login-bg-color"></div>
    <div class="login-form-div">
        <h1>Prihlásenie</h1>
        <form action="" class="login-form">
            <div class="form-input-image-div">
                <label for="username" class="input-image-div">
                    <picture>
                        <source srcset="<?php echo ROOT_PATH;?>img/user-image-light.png" media="(max-width: 575px)">
                        <img src="<?php echo ROOT_PATH;?>/img/user-image.png" alt="">
                    </picture>
                </label>
                <input type="text" id="username" name="username" placeholder="Používateľské meno" required>
            </div>
            <div class="form-input-image-div">
                <label for="password" class="input-image-div">
                    <picture>
                        <source srcset="<?php echo ROOT_PATH;?>img/password-lock-light.svg" media="(max-width: 575px)">
                        <img src="<?php echo ROOT_PATH; ?>/img/password-lock.svg" alt="">
                    </picture>

                </label>
                <input type="password" id="password" name="password" placeholder="Heslo">
            </div>
            <button type="submit" class="button">
                Prihlásiť
            </button>
        </form>
        <div class="login-register-question">
            <span>Ešte nemáte účet? <a href="">Zaregistrujte sa</a></span>
        </div>
    </div>
</main>

<?php require "../../components/page-ending.php"; ?>
