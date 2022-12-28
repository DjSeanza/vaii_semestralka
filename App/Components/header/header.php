<?php
/** @var \App\Core\IAuthenticator $auth */
use \App\Models\User;
?>

<header class="header flex-row p-2">
    <div class="header-left">
        <button class="button">
            <img src="public/images/Icons/hamburger-menu.svg" alt="Hamburger menu">
        </button>
        <div class="logo">
            <a href="?c=home">
                <img src="public/images/Icons/logo.svg" alt="Logo">
            </a>
        </div>
    </div>
    <div class="header-mid">
        <form action="#">
            <div>
                <input type="text" placeholder="Search" class="p-2">
                <button class="button pl-4 pr-4">
                    <img src="public/images/Icons/search-icon.svg" alt="">
                </button>
            </div>
        </form>
    </div>
    <div class="header-right" id="header-right">
        <?php if ($auth->isLogged()) { ?>
            <button class="button logged-in-button" style='background-image: url("<?php echo User::getOne($auth->getLoggedUserId())->getProfilePicture() ?>")' type="button" onclick='openUserMenu(<?php echo $auth->getLoggedUserId() ?>)'></button>
        <?php } else { ?>
            <button class="button login-button" type="button" onclick='location.href="?c=auth"'>SIGN IN</button>
        <?php } ?>
    </div>
</header>