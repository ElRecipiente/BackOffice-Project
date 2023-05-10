<?php

namespace src\controllers;

use core\BaseController;
use src\models\History;

class HistoryController extends BaseController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new History;
    }

    public function history()
    {
        $history = $this->model->getAll();
        $this->render('products/history.html.twig', ['history' => $history, 'username' => $_SESSION['Admin']]);
    }
}
