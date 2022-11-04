<?php
/** @var string $contentHTML */

use App\Core\Router;

$router = new Router();

include "App/Components/head.php";

if ($router->getControllerName() != "Auth") {
    include "App/Components/header/header.php";
}

?>

<div class="web-content">
    <?= $contentHTML ?>
</div>

</body>
</html>
