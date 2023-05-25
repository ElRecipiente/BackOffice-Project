<?php

namespace src\controllers;

use core\BaseController;
use src\models\Product;
use src\models\ProductHistory;
use src\models\User;

class ProductController extends BaseController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Product;
    }

    // L'action index récupère les données du modèle et charge la vue
    // Grâce aux méthodes du modèle, on récupère les données
    // que l'on stocke dans un tableau $produits
    // - - - Comment faire ?
    // Et on charge la vue, qui aura accès au tableau "$produits"
    // - - - Utilisez soit require() soit Twig


    public function index()
    {
        $produits = $this->model->getAll();

        if (isset($_SESSION['popup'])) {
            $popup = $_SESSION['popup'];
            $this->render('products/products.html.twig', ['produits' => $produits, 'popup' => $popup, 'username' => $_SESSION['Admin']]);
            unset($_SESSION['popup']);
        } else {
            $this->render('products/products.html.twig', ['produits' => $produits, 'username' => $_SESSION['Admin']]);
        }
    }

    public function editProduct()
    {
        $id = $_GET['productid'];
        $produit = $this->model->getOne($id);
        if (isset($_SESSION['popup'])) {
            $popup = $_SESSION['popup'];
            $this->render('products/editproduct.html.twig', ['produit' => $produit, 'popup' => $popup, 'username' => $_SESSION['Admin']]);
            unset($_SESSION['popup']);
        } else {
            $this->render('products/editproduct.html.twig', ['produit' => $produit, 'username' => $_SESSION['Admin']]);
        }
    }

    public function updateThisProduct()
    {
        if (!empty(trim($_POST['name'])) && !empty(trim($_POST['quantity'])) && !empty(trim($_POST['price']))) {

            //Limite la quantité des produits
            if ($_POST['quantity'] < 0 || $_POST['quantity'] > 99 || !preg_match('/^[0-9]+$/', $_POST['quantity'])) {
                $_SESSION['popup'] = "Champ quantité invalide, le nombre doit être compris entre 0 et 99.";
                $id = $_GET['productid'];
                header('Location: /editproduct?productid=' . $id);
                exit;

                //limite le prix des produits
            } else if ($_POST['price'] < 0.20 || $_POST['price'] >= 20) {
                $_SESSION['popup'] = "Champ prix invalide, le nombre doit être compris entre 0.20 et 20.";
                $id = $_GET['productid'];
                header('Location: /editproduct?productid=' . $id);
                exit;
                //regex
            } else if (!preg_match('/^[\wÀ-ÖØ-öø-ÿ ]+$/u', $_POST['name'])) {
                $_SESSION['popup'] = "Le champ nom contient des caratères invalides, caractères alphanumériques uniquement.";
                $id = $_GET['productid'];
                header('Location: /editproduct?productid=' . $id);
                exit;

                //mise à jour de produit dans la DB
            } else {

                $productid = $_GET['productid'];

                $produit = $this->model->getOne($productid);

                //création d'un historique des modifications
                if ($produit->quantity != $_POST['quantity'] || $produit->price != $_POST['price']) {
                    $quantity = $_POST['quantity'] - $produit->quantity;
                    $price = $_POST['price'] - $produit->price;
                    $userid =  $_SESSION['id'];
                    $history = new ProductHistory();
                    $history->insertHistory($userid, $productid, $quantity, $price);
                }

                $this->model->updateProduct($productid);

                $_SESSION['popup'] = "La base de données a été mise à jour.";

                header('Location: /');
                exit;
            }
        } else {
            $_SESSION['popup'] = "Tous les champs sont obligatoires.";
            $id = $_GET['productid'];
            header('Location: /editproduct?productid=' . $id);
            exit;
        }
    }

    public function newProduct()
    {
        if (isset($_SESSION['popup'])) {
            $popup = $_SESSION['popup'];
            $this->render('products/newproduct.html.twig', ['popup' => $popup, 'username' => $_SESSION['Admin']]);
            unset($_SESSION['popup']);
        } else {
            $this->render('products/newproduct.html.twig', ['username' => $_SESSION['Admin']]);
        }
    }

    public function addProduct()
    {
        if (!empty(trim($_POST['name'])) && !empty(trim($_POST['quantity'])) && !empty(trim($_POST['price']))) {
            if ($_POST['quantity'] < 0 || $_POST['quantity'] >= 99 || !preg_match('/^[0-9]+$/', $_POST['quantity'])) {
                $_SESSION['popup'] = "Champ 'Quantité' invalide, le champ doit être nombre compris entre 0 et 99.";
                header('Location: /newproduct');
                exit;
            } else if ($_POST['price'] <= 0.20 || $_POST['price'] >= 20 || !preg_match('/^[0-9]+$/', $_POST['price'])) {
                $_SESSION['popup'] = "Champ 'Prix' invalide, le champ doit être un nombre compris entre 0. et 20.";
                header('Location: /newproduct');
                exit;
            } else if (!preg_match('/^[\wÀ-ÖØ-öø-ÿ ]+$/u', $_POST['name'])) {
                $_SESSION['popup'] = "Le champ 'Nom du produit' contient des caratères invalides, caractères alphanumériques uniquement.";
                header('Location: /newproduct');
                exit;
            } else {
                $this->model->addNewProduct();

                $_SESSION['popup'] = "Le produit a été ajouté à la base de donnée avec succès.";
                header('Location: /');
                exit;
            }
        } else {
            $_SESSION['popup'] = "Tous les champs sont obligatoires.";
            header('Location: /newproduct');
            exit;
        }
    }

    public function deleteProduct()
    {
        $id = $_GET['productid'];

        $produit = $this->model->getOne($id);
        $this->model->deleteThisProduct($id);
        $_SESSION['popup'] = "L'entrée " . $produit->name . " a été supprimée de la base de donnée avec succès.";

        header('Location: /');
        exit;
    }

    public function displayJSON()
    {
        $produits = $this->model->getAll();
        $data = json_encode($produits);

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");

        echo $data;
    }

    public function consume($id, $userid)
    {
        $this->model->consumeThisProduct($id);
        $price = $this->model->getPrice($id);
        $user = new User;
        $user->consumeCredish($userid, $price);

        $produit = $this->model->getOne($id);

        $data = json_encode($produit);

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");

        echo $data;
    }
}
