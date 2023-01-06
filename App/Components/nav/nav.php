<?php
/** @var \App\Core\IAuthenticator $auth */
?>
<nav class="navigation">
    <ul>
<!--@TODO opravit prekliky na linky-->
        <li class="button <?php if($router->getControllerName() == "Home") { echo "active"; } ?>" onclick='location.href="?c=home"'>
            <img src="public/images/Icons/home-icon.svg" alt="">
            <span>Domov</span>
        </li>
        <?php
        try {
            if ($auth->isLogged()) {
                if ($auth->isAdmin()) { ?>
                <li class="button <?php if ($router->getControllerName() == "Category") {echo "active";} ?>" onclick='location.href="?c=category"'>
                    <img src="public/images/Icons/category.png" alt="">
                    <span>Správa kategórií</span>
                </li>
            <?php } }
        } catch (Exception $e) {
            printf($e->getMessage());
        } ?>
    </ul>
</nav>