<?php

namespace src\controllers;

use core\BaseController;

class AuthController extends BaseController
{

    public function auth()
    {
        $this->render('auth.html.twig');
    }
}
