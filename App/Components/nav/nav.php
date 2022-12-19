<nav class="navigation">
    <ul>
<!--@TODO opravit prekliky na linky-->
        <li class="button <?php if($router->getControllerName() == "Home") { echo "active"; } ?>" onclick='location.href="?c=home"'>
            <img src="public/images/Icons/home-icon.svg" alt="">
            <span>Domov</span>
        </li>
        <li class="button">
            <img src="public/images/Icons/explore-icon.svg" alt="">
            <span>Preskúmať</span>
        </li>
        <li class="button <?php if($router->getControllerName() == "Content" && $router->getAction() == "listedContent") { echo "active"; } ?>"
            onclick='location.href="?c=content&a=listedContent"'>
            <img src="public/images/Icons/category-icon.svg" alt="">
            <span>Kategórie</span>
        </li>
    </ul>
</nav>