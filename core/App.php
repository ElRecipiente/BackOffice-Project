<?php

namespace core;

use src\controllers\ProductController;
use src\controllers\UserController;
use src\controllers\AuthController;
use src\controllers\ErrorController;


class App
{
    //UNE SEULE METHOD ICI, LA METHOD RUN
    public function run()
    {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        //ATTENTION, CECI EST UN TEST ET N'EST PAS UNE BONNE PRATIQUE ! CE NE DOIT PAS ETRE LE ROLE DE CETTE CLASSE (MAIS CELUI D'UNE CLASS ROUTER) DE GERER LA VERIFICATION DES ROUTES
        if ($uri == '/' || $uri == '/index.php') {
            //EN TERME DE CONVENTION, CHAQUE CONTROLLER EST UNE CLASSE
            $controller = new ProductController();
            $controller->index();
        } else if ($uri == '/auth') {
            $controller = new AuthController();
            $controller->auth();
        } else if ($uri == '/users') {
            $controller = new UserController();
            $controller->users();
        } else if ($uri == '/editproduct' && isset($_GET['productid'])) {
            $controller = new ProductController();
            $controller->editProduct();
        } else if ($uri == '/product' && isset($_GET['productid'])) {
            $controller = new ProductController();
            $controller->updateThisProduct();
        } else if ($uri == '/newuser') {
            $controller = new UserController();
            $controller->newuser();
        } else if ($uri == '/edituser' && isset($_GET['userid'])) {
            $controller = new UserController();
            $controller->edituser();
        } else {
            http_response_code(404); //ON ENVOIT LA BONNE ERREUR AU NAVIGATEUR
            $controller = new ErrorController();
            $controller->error();
        }
    }
}
