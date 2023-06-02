<?php

namespace src\controllers;

use core\BaseController;
use src\models\Favorite;

class FavoriteController extends BaseController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Favorite;
    }

    // method qui verifie si un produit est un favori pour un user donné
    public function isFavorite($productid, $userid)
    {
        $favorite = $this->model->checkFavorite($productid, $userid);

        // si le favori existe, alors on le retire
        if ($favorite) {
            $this->model->removeFavorite($productid, $userid);
            $favoris = ["favori" => false];
            $data = json_encode($favoris);

            echo $data;

            // si le favori n'existe pas, on l'ajoute
        } else {
            $this->model->addFavorite($productid, $userid);
            $favoris = ["favori" => true];
            $data = json_encode($favoris);

            echo $data;
        }

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
    }
}
