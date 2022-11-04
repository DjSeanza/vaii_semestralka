<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;

/**
 * Class HomeController
 * Example class of a controller
 * @package App\Controllers
 */
class HomeController extends AControllerBase
{

    public function index(): Response
    {
        return $this->html(viewName: "index");
    }
}