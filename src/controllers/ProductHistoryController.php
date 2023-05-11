<?php

namespace src\controllers;

use core\BaseController;
use src\models\ProductHistory;

class ProductHistoryController extends BaseController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new ProductHistory;
    }

    public function productHistory()
    {
        $history = $this->model->getAll();
        $this->render('products/producthistory.html.twig', ['history' => $history, 'username' => $_SESSION['Admin']]);
    }
}
