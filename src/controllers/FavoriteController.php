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

    public function favorite($id, $userid)
    {
        echo $id;
        echo $userid;
    }
}
