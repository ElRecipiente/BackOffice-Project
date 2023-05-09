<?php

namespace src\controllers;

use core\BaseController;
use src\models\Product;

class ProductController extends BaseController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Product;
    }

    // L'action index récupère les données du modèle et charge la vue
    public function index()
    {

        // Grâce aux méthodes du modèle, on récupère les données
        // que l'on stocke dans un tableau $produits
        // - - - Comment faire ?

        $produits = $this->model->getAll();

        // Et on charge la vue, qui aura accès au tableau "$produits"
        // - - - Utilisez soit require() soit Twig

        $this->render('products/products.html.twig', ['produits' => $produits]);
    }

    public function editProduct()
    {
        $id = $_GET['productid'];
        $produit = $this->model->getOne($id);
        $this->render('products/editproduct.html.twig', ['produit' => $produit]);
    }

    public function updateThisProduct()
    {
        if (!empty(trim($_POST['name'])) && !empty(trim($_POST['quantity'])) && !empty(trim($_POST['price']))) {

            if ($_POST['quantity'] < 0 || $_POST['quantity'] >= 99) {
                echo "<p class='error'>Champ quantité invalide, le nombre doit être compris entre 0 et 99.</p>";
                $id = $_GET['productid'];
                $produit = $this->model->getOne($id);
                $this->render('products/editproduct.html.twig', ['produit' => $produit]);
            } else if ($_POST['price'] < 0.20 || $_POST['price'] >= 20) {
                echo "<p class='error'>Champ prix invalide, le nombre doit être compris entre 0.20 et 20.</p>";
                $id = $_GET['productid'];
                $produit = $this->model->getOne($id);
                $this->render('products/editproduct.html.twig', ['produit' => $produit]);
            } else {
                $id = $_GET['productid'];
                $this->model->updateProduct($id);
                header('Location: /');
                exit;
            }
        } else {
            echo "<p class='error'>Tous les champs sont obligatoires.</p>";
            $id = $_GET['productid'];
            $produit = $this->model->getOne($id);
            $this->render('products/editproduct.html.twig', ['produit' => $produit]);
        }
    }

    public function newProduct()
    {
        $this->render('products/newproduct.html.twig');
    }

    public function addProduct()
    {
        if (!empty(trim($_POST['name'])) && !empty(trim($_POST['quantity'])) && !empty(trim($_POST['price']))) {
            if ($_POST['quantity'] < 0 || $_POST['quantity'] > 99) {
                echo "<p class='error'>Champ quantité invalide, le nombre doit être compris entre 0 et 99.</p>";

                $this->render('products/newproduct.html.twig');
            } else if ($_POST['price'] < 0 || $_POST['price'] > 99) {
                echo "<p class='error'>Champ prix invalide, le nombre doit être compris entre 0 et 99.</p>";

                $this->render('products/newproduct.html.twig');
            } else {
                $this->model->addNewProduct();
                header('Location: /');
                exit;
            }
        } else {
            echo "<p class='error'>Tous les champs sont obligatoires.</p>";

            $this->render('products/newproduct.html.twig');
        }
    }

    public function deleteProduct()
    {
    }
}
