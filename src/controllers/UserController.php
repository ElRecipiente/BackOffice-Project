<?php

namespace src\controllers;

use core\BaseController;
use src\models\User;

class UserController extends BaseController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new User;
    }

    public function users()
    {
        $users = $this->model->getAll();

        $this->render('users.html.twig', ['users' => $users]);
    }

    public function edituser()
    {
        $id = $_GET['userid'];
        $user = $this->model->getOne($id);
        $this->render('edituser.html.twig', ['user' => $user]);
    }

    public function newuser()
    {
        $this->render('newuser.html.twig');
    }
}
