<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;

class StudioController extends AControllerBase
{

    public function index(): Response
    {
        return $this->redirect("?c=studio&a=listContent");
    }

    public function listContent(): Response {
        return $this->html(viewName: "list.content");
    }
}