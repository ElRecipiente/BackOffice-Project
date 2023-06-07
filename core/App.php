<?php

namespace core;

use src\controllers\ProductController;
use src\controllers\UserController;
use src\controllers\ProductHistoryController;
use src\controllers\UserHistoryController;
use src\controllers\ErrorController;
use src\controllers\FavoriteController;

class App
{

    public function __construct()
    {
        session_start();
    }

    //UNE SEULE METHOD ICI, LA METHOD RUN
    public function run()
    {
        //ATTENTION, CECI EST UN TEST ET N'EST PAS UNE BONNE PRATIQUE ! CE NE DOIT PAS ETRE LE ROLE DE CETTE CLASSE (MAIS CELUI D'UNE CLASS ROUTER) DE GERER LA VERIFICATION DES ROUTES
        //EN TERME DE CONVENTION, CHAQUE CONTROLLER EST UNE CLASSE  

        $uri = strtok($_SERVER['REQUEST_URI'], '?');

        //API ROUTES   
        //UTILISATION DE CURL DANS LE TERMINAL POUR VERIFIER QUE LA ROUTE RENVOIE BIEN UN JSON     
        if ($uri == '/api/products' && isset($_GET['userid'])) {
            $controller = new ProductController();
            $controller->displayJSON($_GET['userid']);
        } else if ($uri == '/api/users' && isset($_GET['id'])) {
            $controller = new UserController();
            $controller->displayJSON($_GET['id']);
        } else if ($uri == '/api/product/consume' && isset($_GET['id']) && isset($_GET['userid'])) {
            $controller = new ProductController();
            $controller->consume($_GET['id'], $_GET['userid']);
        } else if ($uri == '/api/product/favorite' && isset($_GET['productid']) && isset($_GET['userid'])) {
            $controller = new FavoriteController();
            $controller->isFavorite($_GET['productid'], $_GET['userid']);
        } else if ($uri == '/api/auth') {
            header('Content-Type: application/json');
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Headers: *");
            $request_body = file_get_contents('php://input');
            $data = json_decode($request_body, true);

            $controller = new UserController();
            $controller->tryAuth($data);

            //CONNEXION ADMIN
        } else if (isset($_SESSION['Admin']) && $_SESSION['Admin'] != null) {

            //INDEX = PRODUCT HOME
            if ($uri == '/' || $uri == '/index.php') {
                $controller = new ProductController();
                $controller->index();

                //LOGOUT
            } else if ($uri == '/logout') {
                $controller = new UserController();
                $controller->disconnect();



                //PRODUCT ROUTES
            } else if ($uri == '/editproduct' && isset($_GET['productid'])) {
                $controller = new ProductController();
                $controller->editProduct();
            } else if ($uri == '/product' && isset($_GET['productid'])) {
                $controller = new ProductController();
                $controller->updateThisProduct();
            } else if ($uri == '/newproduct') {
                $controller = new ProductController();
                $controller->newProduct();
            } else if ($uri == '/addproduct') {
                $controller = new ProductController();
                $controller->addProduct();
            } else if ($uri == '/deleteproduct') {
                $controller = new ProductController();
                $controller->deleteProduct();

                //USERS ROUTES
            } else if ($uri == '/users') {
                $controller = new UserController();
                $controller->users();
            } else if ($uri == '/newuser') {
                $controller = new UserController();
                $controller->newUser();
            } else if ($uri == '/adduser') {
                $controller = new UserController();
                $controller->addUser();
            } else if ($uri == '/user' && isset($_GET['userid'])) {
                $controller = new UserController();
                $controller->updateThisUser();
            } else if ($uri == '/edituser' && isset($_GET['userid'])) {
                $controller = new UserController();
                $controller->editUser();

                //HISTORY
            } else if ($uri == '/producthistory') {
                $controller = new ProductHistoryController();
                $controller->productHistory();
            } else if ($uri == '/adminhistory') {
                $controller = new UserHistoryController();
                $controller->userHistory();

                //GESTION ERROR
            } else {
                http_response_code(404); //ON ENVOIT LA BONNE ERREUR AU NAVIGATEUR
                $controller = new ErrorController();
                $controller->error();
            }
        } else if ($uri == '/tryauth') {
            $controller = new UserController();
            $controller->tryConnexion();
        } else {
            //AUTHENTIFICATION
            $controller = new UserController();
            $controller->auth();
        }
    }
}