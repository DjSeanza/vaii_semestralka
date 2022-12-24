<nav class="navigation">
    <ul>
<!--@TODO opravit prekliky na linky-->
        <li class="button <?php if($router->getControllerName() == "Home") { echo "active"; } ?>" onclick='location.href="?c=home"'>
            <img src="public/images/Icons/home-icon.svg" alt="">
            <span>Domov</span>
        </li>
    </ul>
</nav>