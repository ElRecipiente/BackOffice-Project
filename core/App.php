<?php

namespace core;

use src\controllers\ProductController;
use src\controllers\UserController;

class App
{
    //UNE SEULE METHOD ICI, LA METHOD RUN
    public function run()
    {
        //ATTENTION, CECI EST UN TEST ET N'EST PAS UNE BONNE PRATIQUE ! CE NE DOIT PAS ETRE LE ROLE DE CETTE CLASSE (MAIS CELUI D'UNE CLASS ROUTER) DE GERER LA VERIFICATION DES ROUTES
        if ($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php') {
            //EN TERME DE CONVENTION, CHAQUE CONTROLLER EST UNE CLASSE
            $controller = new ProductController();
            $controller->index();
        } else if ($_SERVER['REQUEST_URI'] == '/connect') {
            $controller = new ProductController();
            $controller->connect();
        } else if ($_SERVER['REQUEST_URI'] == '/users') {
            $controller = new UserController();
            $controller->users();
        } else {
            http_response_code(404); //ON ENVOIT LA BONNE ERREUR AU NAVIGATEUR
            $controller = new ProductController();
            $controller->error();
        }
    }
}