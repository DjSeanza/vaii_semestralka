<nav class="navigation">
    <ul>
<!--        @TODO zmenit na Router-->
<!--@TODO opravit prekliky na linky-->
        <li class="button <?php if($router->getControllerName() == "Home") { echo "active"; } ?>">
            <img src="public/images/Icons/home-icon.svg" alt="">
            <a href="?c=home">Domov</a>
        </li>
        <li class="button">
            <img src="public/images/Icons/explore-icon.svg" alt="">
            <a href="">Preskúmať</a>
        </li>
        <li class="button <?php if($router->getControllerName() == "Content" && $router->getAction() == "listedContent") { echo "active"; } ?>">
            <img src="public/images/Icons/category-icon.svg" alt="">
            <a href="?c=content&a=listedContent">Kategórie</a>
        </li>
    </ul>
</nav>