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

    public function userFavorite($userid)
    {
        $favoris = $this->model->checkAllFavorite($userid);
        $data = json_encode([$favoris]);

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");

        echo $data;
    }

    public function isFavorite($productid, $userid)
    {
        $favorite = $this->model->checkFavorite($productid, $userid);

        if ($favorite) {
            $this->model->removeFavorite($productid, $userid);
            $favoris = $this->model->checkAllFavorite($userid);
            $data = json_encode([$favoris]);

            header('Content-Type: application/json');
            header("Access-Control-Allow-Origin: *");

            echo $data;
        } else {
            $this->model->addFavorite($productid, $userid);
            $favoris = $this->model->checkAllFavorite($userid);
            $data = json_encode([$favoris]);

            header('Content-Type: application/json');
            header("Access-Control-Allow-Origin: *");

            echo $data;
        }
    }
}
