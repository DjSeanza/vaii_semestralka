<?php
$current_url = basename($_SERVER['PHP_SELF']);
?>

<nav class="navigation">
    <ul>
        <li class="button <?php if($current_url == "index.php") { echo "active"; } ?>">
            <img src="img/home-icon.svg" alt="">
            <a href="">Domov</a>
        </li>
        <li class="button">
            <img src="img/explore-icon.svg" alt="">
            <a href="">Preskúmať</a>
        </li>
        <li class="button">
            <img src="img/category-icon.svg" alt="">
            <a href="">Kategórie</a>
        </li>
    </ul>
</nav>