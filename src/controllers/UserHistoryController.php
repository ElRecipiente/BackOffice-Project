<?php

namespace src\controllers;

use core\BaseController;
use src\models\UserHistory;

class UserHistoryController extends BaseController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new UserHistory;
    }

    public function userHistory()
    {
        $history = $this->model->getAll();
        $this->render('users/userhistory.html.twig', ['history' => $history, 'username' => $_SESSION['Admin']]);
    }
}
