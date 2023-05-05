<?php

namespace src\controllers;

use core\BaseController;

class ErrorController extends BaseController
{
    public function error()
    {
        $this->render('error.html.twig');
    }
}
