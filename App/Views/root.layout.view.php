<?php
/** @var string $contentHTML */

use App\Core\Router;
use public\errors\ErrorToast;

$router = new Router();

include "App/Components/head.php";

if ($router->getControllerName() != "Auth") {
    include "App/Components/header/header.php";
}

$errorToast = ErrorToast::getInstance($_GET);
$errorToast->setGet($_GET);
if ($errorToast->isSuccess() || $errorToast->isError()) {
    include "App/Components/toast/toast.php";
    echo '<script src="public/js/toast/toast.js"></script>';
}

echo $errorToast->getToast();

?>

<div class="web-content">
    <?php
        if ($router->getControllerName() != "Auth") {
            include "App/Components/sidebar/sidebar.php";
        }
    ?>
    <?= $contentHTML ?>
</div>

</body>
</html>
