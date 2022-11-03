<?php
include "../../database/Connection.php";
include "../../database/Authentication.php";
require "../../paths.php";
require "../../components/head.php";

$auth = new Authentication();
$conn = new Connection();
?>

<main class="login-main">
    <div class="login-bg"></div>
    <div class="login-bg-color"></div>
    <div class="login-form-div">
        <h1>Prihlásenie</h1>
        <?php if(isset($_COOKIE['user'])) {echo "Hello, " . $_COOKIE['user'];} ?>
        <form action="#" method="post">
            <input type="hidden" name="signout" value="signout">
            <button type="submit">Odhlas</button>
        </form>
        <form action="log_in.php" method="post" class="login-form">
            <div class="form-input-image-div">
                <label for="username" class="input-image-div">
                    <img src="<?php echo ROOT_PATH;?>/img/user-image.png" alt="">
                </label>
                <input type="text" id="username" name="login" placeholder="Používateľské meno" required>
            </div>
            <div class="form-input-image-div">
                <label for="password" class="input-image-div">
                    <img src="<?php echo ROOT_PATH; ?>/img/password-lock.svg" alt="">
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
