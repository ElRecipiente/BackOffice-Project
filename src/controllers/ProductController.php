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
        echo "Ici nous aurons la liste des produits";

        // Grâce aux méthodes du modèle, on récupère les données
        // que l'on stocke dans un tableau $produits
        // - - - Comment faire ?

        // $produits[] = $this->model->getAll();
        $pomme = 'une bonne pomme';
        $poire = 'une belle poire';
        $produits[] = $pomme;
        $produits[] = $poire;

        // Et on charge la vue, qui aura accès au tableau "$produits"
        // - - - Utilisez soit require() soit Twig

        $this->render('index.html.twig', ['produits' => $produits]);
    }

    public function connect()
    {
        $this->render('connect.html.twig');
    }

    public function users()
    {
        // $users[] = $this->model->getAll();
        $user1 = 'un utilisateur';
        $user2 = 'une utilisatrice';
        $users[] = $user1;
        $users[] = $user2;

        $this->render('users.html.twig', ['users' => $users]);
    }

    public function error()
    {
        $this->render('error.html.twig');
    }
}
