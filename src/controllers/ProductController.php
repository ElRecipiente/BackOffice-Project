<?php

namespace src\controllers;

use core\BaseController;
use src\models\Product;
use src\models\ProductHistory;

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

        $this->render('products/products.html.twig', ['produits' => $produits, 'username' => $_SESSION['Admin']]);
    }

    public function editProduct()
    {
        $id = $_GET['productid'];
        $produit = $this->model->getOne($id);

        $this->render('products/editproduct.html.twig', ['produit' => $produit, 'username' => $_SESSION['Admin']]);
    }

    public function updateThisProduct()
    {
        if (!empty(trim($_POST['name'])) && !empty(trim($_POST['quantity'])) && !empty(trim($_POST['price']))) {

            //Limite la quantité des produits
            if ($_POST['quantity'] < 0 || $_POST['quantity'] >= 99 || !preg_match('/^[0-9]+$/', $_POST['quantity'])) {
                $popup = "Champ quantité invalide, le nombre doit être compris entre 0 et 99.";
                $id = $_GET['productid'];
                $produit = $this->model->getOne($id);

                $this->render('products/editproduct.html.twig', ['produit' => $produit, 'popup' => $popup, 'username' => $_SESSION['Admin']]);

                //limite le prix des produits
            } else if ($_POST['price'] < 0.20 || $_POST['price'] >= 20) {
                $popup = "Champ prix invalide, le nombre doit être compris entre 0.20 et 20.";
                $id = $_GET['productid'];
                $produit = $this->model->getOne($id);

                $this->render('products/editproduct.html.twig', ['produit' => $produit, 'popup' => $popup, 'username' => $_SESSION['Admin']]);
                //regex
            } else if (!preg_match('/^[\wÀ-ÖØ-öø-ÿ ]+$/u', $_POST['name'])) {
                $popup = "Le champ nom contient des caratères invalides, caractères alphanumériques uniquement.";
                $id = $_GET['productid'];
                $produit = $this->model->getOne($id);

                $this->render('products/editproduct.html.twig', ['produit' => $produit, 'popup' => $popup, 'username' => $_SESSION['Admin']]);

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

                $popup = "La base de données a été mise à jour.";

                $produits = $this->model->getAll();
                $this->render('products/products.html.twig', ['produits' => $produits, 'popup' => $popup, 'username' => $_SESSION['Admin']]);
            }
        } else {
            $popup = "Tous les champs sont obligatoires.";
            $id = $_GET['productid'];
            $produit = $this->model->getOne($id);

            $this->render('products/editproduct.html.twig', ['produit' => $produit, 'popup' => $popup, 'username' => $_SESSION['Admin']]);
        }
    }

    public function newProduct()
    {
        $this->render('products/newproduct.html.twig', ['username' => $_SESSION['Admin']]);
    }

    public function addProduct()
    {
        if (!empty(trim($_POST['name'])) && !empty(trim($_POST['quantity'])) && !empty(trim($_POST['price']))) {
            if ($_POST['quantity'] < 0 || $_POST['quantity'] >= 99 || !preg_match('/^[0-9]+$/', $_POST['price'])) {
                $popup = "Champ quantité invalide, le nombre doit être compris entre 0 et 99.";

                $this->render('products/newproduct.html.twig', ['popup' => $popup]);
            } else if ($_POST['price'] <= 0.20 || $_POST['price'] >= 20) {
                $popup = "Champ prix invalide, le nombre doit être compris entre 0 et 99.";

                $this->render('products/newproduct.html.twig', ['popup' => $popup]);
            } else if (!preg_match('/^[\wÀ-ÖØ-öø-ÿ ]+$/u', $_POST['name'])) {
                $popup = "Le champ nom contient des caratères invalides, caractères alphanumériques uniquement.";

                $this->render('products/newproduct.html.twig', ['popup' => $popup]);
            } else {
                $this->model->addNewProduct();

                $popup = "Le produit a été ajouté à la base de donnée avec succès.";

                $produits = $this->model->getAll();
                $this->render('products/products.html.twig', ['produits' => $produits, 'popup' => $popup, 'username' => $_SESSION['Admin']]);
            }
        } else {
            $popup = "Tous les champs sont obligatoires.";

            $this->render('products/newproduct.html.twig', ['popup' => $popup, 'username' => $_SESSION['Admin']]);
        }
    }

    public function deleteProduct()
    {
        $id = $_GET['productid'];

        $produit = $this->model->getOne($id);
        $this->model->deleteThisProduct($id);
        $popup = "L'entrée " . $produit->name . " a été supprimée de la base de donnée avec succès.";

        $produits = $this->model->getAll();
        $this->render('products/products.html.twig', ['produits' => $produits, 'popup' => $popup, 'username' => $_SESSION['Admin']]);
    }
}
