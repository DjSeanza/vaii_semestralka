<?php
/** @var \App\Core\IAuthenticator $auth */
?>

<aside class="sidebar">
    <div class="sidebar-container">
        <?php require dirname(__DIR__)."../nav/nav.php" ?>
    </div>
    <?php if (!$auth->isLogged()) { ?>
    <div class="sidebar-container sidebar-login-container">
        <span>Ak chcete k videám pridať označenie páči sa mi, komentovať alebo sa prihlásiť na odber, musíte sa prihlásiť.</span>
        <button type="button" class="button">Prihlásiť sa</button>
    </div>
    <?php } ?>
</aside>