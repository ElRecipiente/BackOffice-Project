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

        $this->render('products.html.twig', ['produits' => $produits]);
    }

    public function editProduct()
    {
        $id = $_GET['productid'];
        $produit = $this->model->getOne($id);
        $this->render('editproduct.html.twig', ['produit' => $produit]);
    }

    public function updateThisProduct()
    {
        if (!empty(trim($_POST['name'])) && !empty(trim($_POST['quantity'])) && !empty(trim($_POST['price']))) {
            $id = $_GET['productid'];
            $this->model->updateProduct($id);
            $produits = $this->model->getAll();
            $this->render('products.html.twig', ['produits' => $produits]);
        } else {
            echo 'Nope';
            $id = $_GET['productid'];
            $produit = $this->model->getOne($id);
            $this->render('editproduct.html.twig', ['produit' => $produit]);
        }
    }
}
